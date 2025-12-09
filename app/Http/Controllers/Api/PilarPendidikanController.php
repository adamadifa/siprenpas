<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PilarPendidikanResource;
use App\Models\PilarPendidikan;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

/**
 * @OA\Tag(
 *     name="Pilar Pendidikan",
 *     description="API endpoints untuk mengelola Pilar Pendidikan"
 * )
 *
 * @OA\Schema(
 *     schema="PilarPendidikan",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="nama_pilar", type="string", example="Akhlak Mulia"),
 *     @OA\Property(property="deskripsi", type="string", example="Fokus pada pembentukan karakter santri"),
 *     @OA\Property(property="urutan", type="integer", example=1),
 *     @OA\Property(property="created_at", type="string", format="datetime", example="2024-01-01 00:00:00"),
 *     @OA\Property(property="updated_at", type="string", format="datetime", example="2024-01-01 00:00:00")
 * )
 */
class PilarPendidikanController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/pilar-pendidikan",
     *     summary="Daftar Pilar Pendidikan",
     *     description="Mengambil semua pilar pendidikan terurut",
     *     tags={"Pilar Pendidikan"},
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil mengambil data",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Data pilar pendidikan berhasil diambil"),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/PilarPendidikan")
     *             )
     *         )
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        try {
            $data = PilarPendidikan::orderBy('urutan', 'asc')->get();

            return response()->json([
                'success' => true,
                'message' => 'Data pilar pendidikan berhasil diambil',
                'data' => PilarPendidikanResource::collection($data),
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil data pilar pendidikan',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/pilar-pendidikan/{id}",
     *     summary="Detail Pilar Pendidikan",
     *     description="Mengambil detail pilar pendidikan berdasarkan ID",
     *     tags={"Pilar Pendidikan"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil diambil",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Detail pilar pendidikan berhasil diambil"),
     *             @OA\Property(property="data", ref="#/components/schemas/PilarPendidikan")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Tidak ditemukan",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Pilar pendidikan tidak ditemukan")
     *         )
     *     )
     * )
     */
    public function show(string $id): JsonResponse
    {
        try {
            $pilar = PilarPendidikan::findOrFail($id);

            return response()->json([
                'success' => true,
                'message' => 'Detail pilar pendidikan berhasil diambil',
                'data' => new PilarPendidikanResource($pilar),
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Pilar pendidikan tidak ditemukan',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil detail pilar pendidikan',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

}

