<?php

namespace App\Http\Controllers;

use App\Exports\TemplateMigrasiExport;
use App\Imports\MigrasiSiswaImport;
use App\Models\MigrasiLog;
use App\Models\MigrasiLogDetail;
use App\Models\Pendaftaran;
use App\Models\Siswa;
use App\Models\Tahunajaran;
use App\Models\Biayasiswa;
use App\Models\Kelassiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Facades\Excel;

class MigrasiSiswaController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:migrasi-siswa.index', ['only' => ['index']]);
        $this->middleware('permission:migrasi-siswa.upload', ['only' => ['upload']]);
        $this->middleware('permission:migrasi-siswa.preview', ['only' => ['preview']]);
        $this->middleware('permission:migrasi-siswa.proses', ['only' => ['proses']]);
        $this->middleware('permission:migrasi-siswa.riwayat', ['only' => ['riwayat']]);
        $this->middleware('permission:migrasi-siswa.rollback', ['only' => ['rollback']]);
    }

    public function index()
    {
        $ta_aktif = Tahunajaran::where('status', 1)->first();
        $tahunajaran = Tahunajaran::orderBy('kode_ta', 'desc')->get();
        return view('migrasi.index', compact('ta_aktif', 'tahunajaran'));
    }

    public function downloadTemplate()
    {
        return Excel::download(new TemplateMigrasiExport(), 'template_migrasi_siswa.xlsx');
    }

    public function downloadTemplateHorizontal()
    {
        return Excel::download(new \App\Exports\TemplateMigrasiHorizontalExport(), 'template_migrasi_horizontal.xlsx');
    }

    public function uploadHorizontal(Request $request)
    {
        $request->validate([
            'file_excel' => 'required|mimes:xlsx,xls',
        ]);

        $file = $request->file('file_excel');
        $fileName = time() . '_' . $file->getClientOriginalName();

        $ta_aktif = Tahunajaran::where('status', 1)->first();

        $log = MigrasiLog::create([
            'nama_file' => $fileName,
            'kode_ta' => $ta_aktif->kode_ta ?? null,
            'status' => 'processing',
            'id_user' => Auth::id()
        ]);

        try {
            Excel::import(new \App\Imports\MigrasiHorizontalImport($log->id), $file);

            return Redirect::route('migrasi-siswa.preview', $log->id)
                ->with('success', 'File horizontal berhasil diupload dan diproses.');
        } catch (\Exception $e) {
            $log->update(['status' => 'error']);
            return Redirect::back()->with('error', 'Terjadi kesalahan saat mengupload: ' . $e->getMessage());
        }
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file_excel' => 'required|mimes:xlsx,xls',
        ]);

        $file = $request->file('file_excel');
        $fileName = time() . '_' . $file->getClientOriginalName();

        // Get active TA for log reference
        $ta_aktif = Tahunajaran::where('status', 1)->first();

        // Create initial log
        $log = MigrasiLog::create([
            'nama_file' => $fileName,
            'kode_ta' => $ta_aktif->kode_ta ?? null,
            'status' => 'processing',
            'id_user' => Auth::id()
        ]);

        try {
            // Import the file - kode_ta is now per-row in Excel
            Excel::import(new MigrasiSiswaImport($log->id), $file);
            
            return Redirect::route('migrasi-siswa.preview', $log->id)
                ->with('success', 'File berhasil diupload dan diproses.');
        } catch (\Exception $e) {
            $log->update(['status' => 'error']);
            return Redirect::back()->with('error', 'Terjadi kesalahan saat mengupload: ' . $e->getMessage());
        }
    }

    public function preview($id)
    {
        $log = MigrasiLog::with(['details'])->findOrFail($id);
        $valid_data = MigrasiLogDetail::where('migrasi_log_id', $id)->where('status', 'success')->get();
        $error_data = MigrasiLogDetail::where('migrasi_log_id', $id)->where('status', 'failed')->get();

        return view('migrasi.preview', compact('log', 'valid_data', 'error_data'));
    }

    public function proses($id)
    {
        $log = MigrasiLog::findOrFail($id);
        $log->update(['status' => 'done']);

        return Redirect::route('migrasi-siswa.riwayat')
            ->with('success', 'Migrasi data selesai.');
    }

    public function riwayat()
    {
        $riwayat = MigrasiLog::with(['user', 'tahunAjaran'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('migrasi.riwayat', compact('riwayat'));
    }

    public function rollback($id)
    {
        $log = MigrasiLog::with('details')->findOrFail($id);

        if ($log->status == 'rolled_back') {
            return Redirect::back()->with('error', 'Data ini sudah di-rollback sebelumnya.');
        }

        DB::beginTransaction();
        try {
            foreach ($log->details as $detail) {
                if ($detail->status == 'success') {
                    // 1. Delete Biaya
                    Biayasiswa::where('no_pendaftaran', $detail->no_pendaftaran)->delete();
                    
                    // 2. Delete Mutation payments
                    DB::table('pembayaran_pendidikan_mutasi')->where('no_pendaftaran', $detail->no_pendaftaran)->delete();
                    
                    // 3. Delete Kelas Siswa
                    Kelassiswa::where('id_siswa', $detail->id_siswa)->delete();
                    
                    // 4. Delete Pendaftaran
                    Pendaftaran::where('no_pendaftaran', $detail->no_pendaftaran)->delete();
                    
                    // 5. Delete Siswa only if it was new
                    if ($detail->is_new_siswa) {
                        Siswa::where('id_siswa', $detail->id_siswa)->delete();
                    }
                }
            }

            $log->update(['status' => 'rolled_back']);
            $log->details()->update(['status' => 'rolled_back']);

            DB::commit();
            return Redirect::back()->with('success', 'Rollback berhasil. Data pendaftaran telah dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return Redirect::back()->with('error', 'Gagal melakukan rollback: ' . $e->getMessage());
        }
    }
}
