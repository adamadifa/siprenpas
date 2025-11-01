<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Page",
 *     description="Manajemen Halaman"
 * )
 */
class PageController extends Controller
{
    /**
     * @OA\Get(
     *     path="/public/pages/{slug}",
     *     tags={"Page"},
     *     summary="Ambil data halaman berdasarkan slug",
     *     @OA\Parameter(
     *         name="slug",
     *         in="path",
     *         required=true,
     *         description="Slug halaman (contoh: tentang-pesantren)",
     *         @OA\Schema(type="string", example="tentang-pesantren")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil mengambil data halaman",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="success",
     *                 type="boolean",
     *                 example=true
     *             ),
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Data halaman berhasil diambil"
     *             ),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="title", type="string", example="Tentang Pesantren"),
     *                 @OA\Property(property="slug", type="string", example="tentang-pesantren"),
     *                 @OA\Property(property="content", type="string", example="<p>Konten halaman...</p>"),
     *                 @OA\Property(property="created_at", type="string", example="2024-01-01T00:00:00.000000Z"),
     *                 @OA\Property(property="updated_at", type="string", example="2024-01-01T00:00:00.000000Z")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Halaman tidak ditemukan",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Halaman tidak ditemukan")
     *         )
     *     )
     * )
     */
    public function show($slug)
    {
        try {
            $page = Page::where('slug', $slug)->first();

            if ($page) {
                return response()->json([
                    'success' => true,
                    'message' => 'Data halaman berhasil diambil',
                    'data' => [
                        'id' => $page->id,
                        'title' => $page->title,
                        'slug' => $page->slug,
                        'content' => $page->content,
                        'created_at' => $page->created_at,
                        'updated_at' => $page->updated_at
                    ]
                ], 200);
            }

            return response()->json([
                'success' => false,
                'message' => 'Halaman tidak ditemukan'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil data halaman.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}

