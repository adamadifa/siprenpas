<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\GalleryAlbum;

class GalleryController extends Controller
{
    /**
     * @OA\Get(
     *     path="/public/gallery/albums",
     *     tags={"Gallery"},
     *     summary="Ambil daftar album galeri beserta jumlah foto",
     *     @OA\Response(
     *         response=200,
     *         description="Daftar album",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="title", type="string", example="Kegiatan Pramuka"),
     *                 @OA\Property(property="description", type="string", example="Dokumentasi pramuka 2025"),
     *                 @OA\Property(property="cover_url", type="string", example="https://domain.com/storage/gallery/covers/cover.jpg"),
     *                 @OA\Property(property="photos_count", type="integer", example=12)
     *             )
     *         )
     *     )
     * )
     */
    public function getAlbums()
    {
        $albums = GalleryAlbum::withCount('photos')
            ->latest()
            ->get()
            ->map(function ($album) {
                return [
                    'id' => $album->id,
                    'title' => $album->title,
                    'description' => $album->description,
                    'cover_url' => $album->cover ? asset('storage/' . $album->cover) : null,
                    'photos_count' => $album->photos_count ?? 0,
                ];
            });

        return response()->json($albums);
    }

    /**
     * @OA\Get(
     *     path="/public/gallery/albums/{id}",
     *     tags={"Gallery"},
     *     summary="Ambil detail album beserta daftar foto",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID album",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detail album",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="title", type="string", example="Kegiatan Pramuka"),
     *             @OA\Property(property="description", type="string", example="Dokumentasi pramuka 2025"),
     *             @OA\Property(property="cover_url", type="string", example="https://domain.com/storage/gallery/covers/cover.jpg"),
     *             @OA\Property(
     *                 property="photos",
     *                 type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="id", type="integer", example=10),
     *                     @OA\Property(property="title", type="string", nullable=true, example="Upacara pembukaan"),
     *                     @OA\Property(property="url", type="string", example="https://domain.com/storage/gallery/photos/photo.jpg")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(response=404, description="Album tidak ditemukan")
     * )
     */
    public function getAlbumDetail($id)
    {
        $album = GalleryAlbum::with('photos')->find($id);

        if (!$album) {
            return response()->json(['message' => 'Album tidak ditemukan'], 404);
        }

        $data = [
            'id' => $album->id,
            'title' => $album->title,
            'description' => $album->description,
            'cover_url' => $album->cover ? asset('storage/' . $album->cover) : null,
            'photos' => $album->photos->map(function ($photo) {
                return [
                    'id' => $photo->id,
                    'title' => $photo->title,
                    'url' => $photo->path ? asset('storage/' . $photo->path) : null,
                ];
            })
        ];

        return response()->json($data);
    }
}


