<?php

namespace App\Http\Controllers;

use App\Models\KonfirmasiPembayaranGotTalent;
use App\Models\PendaftaranGotTalent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redirect;

class KonfirmasiPembayaranGotTalentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = KonfirmasiPembayaranGotTalent::with(['pendaftaran.jenjangPendidikan', 'verifikator']);

        // Filter by status
        if (!empty($request->status)) {
            $query->where('status', $request->status);
        }

        // Search
        if (!empty($request->search)) {
            $search = $request->search;
            $query->whereHas('pendaftaran', function($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('nomor_register', 'like', "%{$search}%");
            });
        }

        $konfirmasi = $query->latest()->paginate(25);
        $konfirmasi->appends($request->all());

        return view('konfirmasi-pembayaran-got-talent.index', compact('konfirmasi'));
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $id = Crypt::decrypt($id);
        $konfirmasi = KonfirmasiPembayaranGotTalent::with(['pendaftaran.jenjangPendidikan', 'verifikator'])
            ->findOrFail($id);

        return view('konfirmasi-pembayaran-got-talent.show', compact('konfirmasi'));
    }

    /**
     * Update status konfirmasi pembayaran
     */
    public function updateStatus(Request $request, $id)
    {
        $id = Crypt::decrypt($id);
        
        $request->validate([
            'status' => 'required|in:diverifikasi,ditolak',
            'catatan_admin' => 'nullable|string|max:500',
        ]);

        try {
            $konfirmasi = KonfirmasiPembayaranGotTalent::findOrFail($id);
            
            $konfirmasi->update([
                'status' => $request->status,
                'catatan_admin' => $request->catatan_admin,
                'diverifikasi_oleh' => Auth::id(),
                'diverifikasi_pada' => now(),
            ]);

            return Redirect::back()->with(messageSuccess('Status konfirmasi pembayaran berhasil diupdate'));

        } catch (\Exception $e) {
            return Redirect::back()->with(messageError($e->getMessage()));
        }
    }
}

