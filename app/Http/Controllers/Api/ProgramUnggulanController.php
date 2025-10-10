<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProgramUnggulanResource;
use App\Models\ProgramUnggulan;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

/**
 * @OA\Tag(
 *     name="Program Unggulan",
 *     description="API endpoints untuk mengelola Program Unggulan"
 * )
 * 
 * @OA\Schema(
 *     schema="ProgramUnggulan",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="nama_program", type="string", example="Pembentukan Karakter"),
 *     @OA\Property(property="deskripsi", type="string", example="Program ini fokus pada pembentukan akhlak mulia..."),
 *     @OA\Property(property="urutan", type="integer", example=1),
 *     @OA\Property(property="created_at", type="string", format="datetime", example="2024-01-01 00:00:00"),
 *     @OA\Property(property="updated_at", type="string", format="datetime", example="2024-01-01 00:00:00")
 * )
 */
class ProgramUnggulanController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/program-unggulan",
     *     summary="Mendapatkan daftar Program Unggulan",
     *     description="Mengambil semua data program unggulan yang tersedia",
     *     tags={"Program Unggulan"},
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil mengambil data program unggulan",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Data program unggulan berhasil diambil"),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="nama_program", type="string", example="Pembentukan Karakter"),
     *                     @OA\Property(property="deskripsi", type="string", example="Program ini fokus pada pembentukan akhlak mulia..."),
     *                     @OA\Property(property="urutan", type="integer", example=1),
     *                     @OA\Property(property="created_at", type="string", format="datetime", example="2024-01-01 00:00:00"),
     *                     @OA\Property(property="updated_at", type="string", format="datetime", example="2024-01-01 00:00:00")
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        try {
            $programUnggulan = ProgramUnggulan::orderBy('urutan', 'asc')->get();

            return response()->json([
                'success' => true,
                'message' => 'Data program unggulan berhasil diambil',
                'data' => ProgramUnggulanResource::collection($programUnggulan)
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil data program unggulan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/program-unggulan",
     *     summary="Membuat Program Unggulan baru",
     *     description="Membuat program unggulan baru dengan data yang diberikan",
     *     tags={"Program Unggulan"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nama_program", "urutan"},
     *             @OA\Property(property="nama_program", type="string", example="Program Baru"),
     *             @OA\Property(property="deskripsi", type="string", example="Deskripsi program baru"),
     *             @OA\Property(property="urutan", type="integer", example=5)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Program unggulan berhasil dibuat",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Program unggulan berhasil dibuat"),
     *             @OA\Property(property="data", ref="#/components/schemas/ProgramUnggulan")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validasi gagal",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Validasi gagal"),
     *             @OA\Property(property="errors", type="object")
     *         )
     *     )
     * )
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'nama_program' => 'required|string|max:255',
                'deskripsi' => 'nullable|string',
                'urutan' => 'required|integer|min:0'
            ]);

            $programUnggulan = ProgramUnggulan::create($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Program unggulan berhasil dibuat',
                'data' => new ProgramUnggulanResource($programUnggulan)
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat membuat program unggulan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/program-unggulan/{id}",
     *     summary="Mendapatkan detail Program Unggulan",
     *     description="Mengambil detail program unggulan berdasarkan ID",
     *     tags={"Program Unggulan"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID Program Unggulan",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil mengambil detail program unggulan",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Detail program unggulan berhasil diambil"),
     *             @OA\Property(property="data", ref="#/components/schemas/ProgramUnggulan")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Program unggulan tidak ditemukan",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Program unggulan tidak ditemukan")
     *         )
     *     )
     * )
     */
    public function show(string $id): JsonResponse
    {
        try {
            $programUnggulan = ProgramUnggulan::findOrFail($id);

            return response()->json([
                'success' => true,
                'message' => 'Detail program unggulan berhasil diambil',
                'data' => new ProgramUnggulanResource($programUnggulan)
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Program unggulan tidak ditemukan'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil detail program unggulan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/program-unggulan/{id}",
     *     summary="Mengupdate Program Unggulan",
     *     description="Mengupdate data program unggulan berdasarkan ID",
     *     tags={"Program Unggulan"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID Program Unggulan",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nama_program", "urutan"},
     *             @OA\Property(property="nama_program", type="string", example="Program Terupdate"),
     *             @OA\Property(property="deskripsi", type="string", example="Deskripsi program terupdate"),
     *             @OA\Property(property="urutan", type="integer", example=3)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Program unggulan berhasil diupdate",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Program unggulan berhasil diupdate"),
     *             @OA\Property(property="data", ref="#/components/schemas/ProgramUnggulan")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Program unggulan tidak ditemukan",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Program unggulan tidak ditemukan")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validasi gagal",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Validasi gagal"),
     *             @OA\Property(property="errors", type="object")
     *         )
     *     )
     * )
     */
    public function update(Request $request, string $id): JsonResponse
    {
        try {
            $programUnggulan = ProgramUnggulan::findOrFail($id);

            $request->validate([
                'nama_program' => 'required|string|max:255',
                'deskripsi' => 'nullable|string',
                'urutan' => 'required|integer|min:0'
            ]);

            $programUnggulan->update($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Program unggulan berhasil diupdate',
                'data' => new ProgramUnggulanResource($programUnggulan)
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Program unggulan tidak ditemukan'
            ], 404);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengupdate program unggulan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/program-unggulan/{id}",
     *     summary="Menghapus Program Unggulan",
     *     description="Menghapus program unggulan berdasarkan ID",
     *     tags={"Program Unggulan"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID Program Unggulan",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Program unggulan berhasil dihapus",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Program unggulan berhasil dihapus")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Program unggulan tidak ditemukan",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Program unggulan tidak ditemukan")
     *         )
     *     )
     * )
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            $programUnggulan = ProgramUnggulan::findOrFail($id);
            $programUnggulan->delete();

            return response()->json([
                'success' => true,
                'message' => 'Program unggulan berhasil dihapus'
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Program unggulan tidak ditemukan'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus program unggulan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/public/program-unggulan/random/{limit}",
     *     summary="Mendapatkan Program Unggulan secara acak",
     *     description="Mengambil program unggulan secara acak dengan batasan jumlah",
     *     tags={"Program Unggulan"},
     *     @OA\Parameter(
     *         name="limit",
     *         in="path",
     *         required=false,
     *         description="Jumlah program unggulan yang diambil (default: 3)",
     *         @OA\Schema(type="integer", default=3)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil mengambil program unggulan secara acak",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Data program unggulan acak berhasil diambil"),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/ProgramUnggulan")
     *             )
     *         )
     *     )
     * )
     */
    public function random($limit = 3): JsonResponse
    {
        try {
            $programUnggulan = ProgramUnggulan::inRandomOrder()->limit($limit)->get();

            return response()->json([
                'success' => true,
                'message' => 'Data program unggulan acak berhasil diambil',
                'data' => ProgramUnggulanResource::collection($programUnggulan)
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil data program unggulan acak',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
