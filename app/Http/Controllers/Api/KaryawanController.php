<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Karyawan",
 *     description="Manajemen Karyawan"
 * )
 */
class KaryawanController extends Controller
{
    /**
     * @OA\Get(
     *     path="/karyawan/aktif",
     *     tags={"Karyawan"},
     *     summary="Ambil daftar karyawan aktif",
     *     @OA\Parameter(
     *         name="nama",
     *         in="query",
     *         description="Filter berdasarkan nama karyawan (partial match)",
     *         required=false,
     *         @OA\Schema(type="string", example="John")
     *     ),
     *     @OA\Parameter(
     *         name="unit",
     *         in="query",
     *         description="Filter berdasarkan kode unit",
     *         required=false,
     *         @OA\Schema(type="string", example="U01")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil ambil daftar karyawan aktif",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="success",
     *                 type="boolean",
     *                 example=true
     *             ),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
                     *                     @OA\Property(property="npp", type="string", example="K001"),
                     *                     @OA\Property(property="nama", type="string", example="John Doe"),
                     *                     @OA\Property(property="jabatan", type="string", example="Guru"),
                     *                     @OA\Property(property="nama_unit", type="string", example="SMP"),
                     *                     @OA\Property(property="foto", type="string", example="http://example.com/storage/photos/karyawan/photo.jpg")
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function getAktif(Request $request)
    {
        try {
            $query = Karyawan::select(
                'karyawan.npp',
                'karyawan.nama_lengkap as nama',
                'jabatan.nama_jabatan as jabatan',
                'unit.nama_unit',
                'karyawan.kode_unit',
                'karyawan.foto'
            )
                ->join('jabatan', 'karyawan.kode_jabatan', '=', 'jabatan.kode_jabatan')
                ->join('unit', 'karyawan.kode_unit', '=', 'unit.kode_unit')
                ->where('karyawan.status', 1);

            // Filter berdasarkan nama (partial match)
            if ($request->has('nama') && !empty($request->nama)) {
                $query->where('karyawan.nama_lengkap', 'like', '%' . $request->nama . '%');
            }

            // Filter berdasarkan unit
            if ($request->has('unit') && !empty($request->unit)) {
                $query->where('karyawan.kode_unit', $request->unit);
            }

            $karyawan = $query->orderBy('karyawan.nama_lengkap', 'asc')
                ->get()
                ->map(function ($item) {
                    // Gunakan helper function untuk mendapatkan URL foto atau default image
                    $fotoUrl = null;
                    if (!empty($item->foto)) {
                        $fotoUrl = url('/storage/photos/karyawan/' . $item->foto);
                    } else {
                        $fotoUrl = asset('assets/img/avatars/No_Image_Available.jpg');
                    }

                    return [
                        'npp' => $item->npp,
                        'nama' => $item->nama,
                        'jabatan' => $item->jabatan,
                        'nama_unit' => $item->nama_unit,
                        'foto' => $fotoUrl
                    ];
                });

            return response()->json([
                'success' => true,
                'data' => $karyawan
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil data karyawan.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}

