<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * @OA\Get(
     *     path="/public/posts/getposthomepage",
     *     tags={"Post"},
     *     summary="List data post homepage",
     *     @OA\Response(
     *         response=200,
     *         description="List data post homepage",
     *         @OA\JsonContent(type="array", @OA\Items(type="object"))
     *     )
     * )
     */
    public function getposthomepage()
    {
        $posts = Post::with('user', 'category')->latest()->take(6)->get();

        //return with Api Resource
        return new PostResource(true, 'List Data Post HomePage', $posts);
    }



    /**
     * @OA\Get(
     *     path="/public/posts/getlastposthomepage",
     *     tags={"Post"},
     *     summary="Post terakhir homepage",
     *     @OA\Response(
     *         response=200,
     *         description="Post terakhir homepage",
     *         @OA\JsonContent(type="object")
     *     )
     * )
     */
    public function getlastposthomepage()
    {
        $posts = Post::with('user', 'category')->latest()->orderBy('id', 'desc')->first();

        //return with Api Resource
        return new PostResource(true, 'List Data Post HomePage', $posts);
    }

    /**
     * @OA\Get(
     *     path="/public/posts/{slug}",
     *     tags={"Post"},
     *     summary="Detail post by slug",
     *     @OA\Parameter(
     *         name="slug",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string"),
     *         description="Slug post"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detail data post",
     *         @OA\JsonContent(type="object")
     *     ),
     *     @OA\Response(response=404, description="Detail Data Post Tidak Ditemukan!")
     * )
     */
    public function show($slug)
    {
        $post = Post::with('user', 'category')->where('slug', $slug)->first();

        if ($post) {
            //return with Api Resource
            return new PostResource(true, 'Detail Data Post', $post);
        }

        //return with Api Resource
        return new PostResource(false, 'Detail Data Post Tidak Ditemukan!', null);
    }

    public function getrandompost()
    {
        $posts = Post::with('user', 'category')->inRandomOrder()->take(6)->get();

        //return with Api Resource
        return new PostResource(true, 'List Data Post HomePage', $posts);
    }

    /**
     * @OA\Get(
     *     path="/public/posts",
     *     tags={"Post"},
     *     summary="List semua post dengan pagination",
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         required=false,
     *         @OA\Schema(type="integer", default=1),
     *         description="Nomor halaman"
     *     ),
     *     @OA\Parameter(
     *         name="per_page",
     *         in="query",
     *         required=false,
     *         @OA\Schema(type="integer", default=10),
     *         description="Jumlah data per halaman"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List data post dengan pagination",
     *         @OA\JsonContent(type="object")
     *     )
     * )
     */
    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 10);

        $posts = Post::with('user', 'category')->latest()->paginate($perPage);

        return new PostResource(true, 'List Data Post', $posts);
    }
}
