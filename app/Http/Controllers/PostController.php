<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $posts = Post::with('user', 'category')->latest()->paginate(10);
        return view('website.post.index', compact('posts'));
    }

    public function create()
    {
        $data['categories'] = Category::all();
        return view('website.post.create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'image'         => 'required|image|mimes:jpeg,jpg,png|max:2000',
            'title'         => 'required|unique:posts',
            'category_id'   => 'required',
            'content'       => 'required'
        ]);



        //upload image
        $image = $request->file('image');
        $image->storeAs('public/posts', $image->hashName());

        $post = Post::create([
            'image'       => $image->hashName(),
            'title'       => $request->title,
            'slug'        => Str::slug($request->title, '-'),
            'category_id' => $request->category_id,
            'user_id'     => auth()->user()->id,
            'content'     => $request->content
        ]);


        if ($post) {
            //return success with Api Resource
            return Redirect::back()->with(messageSuccess('Data Post Berhasil Disimpan'));
        }

        //return failed with Api Resource
        return Redirect::back()->with(messageError('Gagal Menambahkan Data Post'));
    }

    public function destroy($id)
    {
        $id = Crypt::decrypt($id);
        try {
            Post::where('id', $id)->delete();
            return Redirect::back()->with(messageSuccess('Data Berhasil Dihapus'));
        } catch (\Exception $e) {
            return Redirect::back()->with(messageError($e->getMessage()));
        }
    }
}
