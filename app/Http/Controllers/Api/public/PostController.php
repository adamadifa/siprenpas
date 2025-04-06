<?php

namespace App\Http\Controllers\Api\public;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function getposthomepage()
    {
        $posts = Post::with('user', 'category')->latest()->take(6)->get();

        //return with Api Resource
        return new PostResource(true, 'List Data Post HomePage', $posts);
    }

    public function getlastposthomepage()
    {
        $posts = Post::with('user', 'category')->latest()->orderBy('id', 'desc')->first();

        //return with Api Resource
        return new PostResource(true, 'List Data Post HomePage', $posts);
    }

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
}
