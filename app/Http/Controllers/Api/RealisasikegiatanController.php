<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Realisasikegiatan;
use App\Models\Jobdesk;
use App\Models\Programkerja;
use App\Models\Tahunajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Drivers\Gd\Encoders\JpegEncoder;

class RealisasikegiatanController extends Controller
{
    public function index(Request $request)
    {
        try {
            $user = $request->user();
            $query = Realisasikegiatan::query()
                ->select('realisasi_kegiatan.*', 'users.name as user_name', 'jobdesk.jobdesk', 'program_kerja.program_kerja')
                ->join('departemen', 'realisasi_kegiatan.kode_dept', '=', 'departemen.kode_dept')
                ->join('jabatan', 'realisasi_kegiatan.kode_jabatan', '=', 'jabatan.kode_jabatan')
                ->leftJoin('jobdesk', 'realisasi_kegiatan.kode_jobdesk', '=', 'jobdesk.kode_jobdesk')
                ->leftJoin('program_kerja', 'realisasi_kegiatan.kode_program_kerja', '=', 'program_kerja.kode_program_kerja')
                ->join('users', 'realisasi_kegiatan.id_user', '=', 'users.id')
                ->where('realisasi_kegiatan.id_user', $user->id);

            if (!empty($request->start_date) && !empty($request->end_date)) {
                $query->whereBetween('tanggal', [$request->start_date, $request->end_date]);
            }

            $realisasi = $query->orderBy('tanggal', 'desc')->get();

            $formatted = $realisasi->map(function ($item) {
                $foto_url = null;
                if ($item->foto) {
                    $foto_url = asset('storage/realisasikegiatan/' . $item->kode_dept . '/' . $item->foto);
                }
                return [
                    'id' => $item->id,
                    'tanggal' => $item->tanggal,
                    'nama_kegiatan' => $item->nama_kegiatan,
                    'kode_dept' => $item->kode_dept,
                    'kode_jabatan' => $item->kode_jabatan,
                    'kode_jobdesk' => $item->kode_jobdesk,
                    'jobdesk' => $item->jobdesk,
                    'kode_program_kerja' => $item->kode_program_kerja,
                    'program_kerja' => $item->program_kerja,
                    'uraian_kegiatan' => $item->uraian_kegiatan,
                    'foto' => $item->foto,
                    'foto_url' => $foto_url,
                ];
            });

            return response()->json([
                'success' => true,
                'data' => $formatted
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function getFormOptions(Request $request)
    {
        try {
            $user = $request->user();

            $jobdesks = Jobdesk::whereHas('group', function($q) use ($user) {
                $q->where('kode_jabatan', $user->kode_jabatan)
                  ->where('kode_dept', $user->kode_dept);
                if (!empty($user->kode_unit)) {
                    $q->where('kode_unit', $user->kode_unit);
                }
            })
            ->orderBy('jobdesk')
            ->get(['kode_jobdesk', 'jobdesk']);

            $ta_aktif = Tahunajaran::where('status', 1)->first();
            $queryProgram = Programkerja::whereHas('group', function($q) use ($user, $ta_aktif) {
                $q->where('kode_dept', $user->kode_dept);
                if ($ta_aktif) {
                    $q->where('kode_ta', $ta_aktif->kode_ta);
                }
                if (!empty($user->kode_unit)) {
                    $q->where('kode_unit', $user->kode_unit);
                }
            });
            $programs = $queryProgram->orderBy('program_kerja')->get(['kode_program_kerja', 'program_kerja']);

            return response()->json([
                'success' => true,
                'data' => [
                    'jobdesks' => $jobdesks,
                    'programs' => $programs,
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $user = $request->user();

            $request->validate([
                'tanggal' => 'required|date',
                'nama_kegiatan' => 'required|string|max:255',
                'uraian_kegiatan' => 'required|string',
                'kode_jobdesk' => 'nullable|string',
                'kode_program_kerja' => 'nullable|string',
                'foto' => 'nullable|string', // base64 string
            ]);

            $kode_jabatan = $user->kode_jabatan;
            $kode_dept = $user->kode_dept;
            $file = null;

            if ($request->foto) {
                // Decode base64
                if (preg_match('/^data:image\/(\w+);base64,/', $request->foto, $type)) {
                    $data = substr($request->foto, strpos($request->foto, ',') + 1);
                    $type = strtolower($type[1]); // jpg, jpeg, png

                    if (!in_array($type, ['jpg', 'jpeg', 'png'])) {
                        return response()->json(['success' => false, 'message' => 'Format gambar tidak valid. Hanya diperbolehkan jpg, jpeg, png.'], 400);
                    }

                    $decodedData = base64_decode($data);
                    if ($decodedData === false) {
                        return response()->json(['success' => false, 'message' => 'Gagal mendekode file foto.'], 400);
                    }

                    // Process and compress image using GD driver
                    $imageManager = new ImageManager(new Driver());
                    $img = $imageManager->read($decodedData);
                    $compressed = $img->resize(800, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })->encode(new JpegEncoder(quality: 70));

                    $file_name = time() . '_' . uniqid() . '.jpg';
                    $destination_foto_path = "/public/realisasikegiatan/" . $kode_dept . "/";

                    Storage::put($destination_foto_path . $file_name, (string) $compressed);
                    $file = $file_name;
                }
            } elseif ($request->file('foto_file')) {
                // Support normal file uploads if any
                $image = $request->file('foto_file');
                $imageManager = new ImageManager(new Driver());
                $img = $imageManager->read($image->getRealPath());
                $compressed = $img->resize(800, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->encode(new JpegEncoder(quality: 70));

                $file_name = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $destination_foto_path = "/public/realisasikegiatan/" . $kode_dept . "/";

                Storage::put($destination_foto_path . $file_name, (string) $compressed);
                $file = $file_name;
            }

            $realisasi = Realisasikegiatan::create([
                'tanggal' => $request->tanggal,
                'nama_kegiatan' => $request->nama_kegiatan,
                'kode_jabatan' => $kode_jabatan,
                'kode_dept' => $kode_dept,
                'kode_jobdesk' => $request->kode_jobdesk,
                'kode_program_kerja' => $request->kode_program_kerja,
                'uraian_kegiatan' => $request->uraian_kegiatan,
                'id_user' => $user->id,
                'foto' => $file
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Kegiatan berhasil disimpan',
                'data' => $realisasi
            ], 201);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $user = $request->user();
            $realisasi = Realisasikegiatan::where('id', $id)
                ->where('id_user', $user->id)
                ->first();

            if (!$realisasi) {
                return response()->json(['success' => false, 'message' => 'Data tidak ditemukan atau Anda tidak memiliki akses.'], 404);
            }

            if ($realisasi->foto) {
                $destination_foto_path = "/public/realisasikegiatan/" . $realisasi->kode_dept . "/" . $realisasi->foto;
                Storage::delete($destination_foto_path);
            }

            $realisasi->delete();

            return response()->json([
                'success' => true,
                'message' => 'Kegiatan berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
