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

    public function edit($id)
    {
        $id = Crypt::decrypt($id);
        $post = Post::findOrFail($id);
        $categories = Category::all();
        return view('website.post.edit', compact('post', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $id = Crypt::decrypt($id);
        $post = Post::findOrFail($id);

        $request->validate([
            'title' => 'required|unique:posts,title,' . $id,
            'category_id' => 'required',
            'content' => 'required',
            'image' => 'nullable|image|mimes:jpeg,jpg,png|max:2000'
        ]);

        $data = [
            'title' => $request->title,
            'slug' => Str::slug($request->title, '-'),
            'category_id' => $request->category_id,
            'content' => $request->content
        ];

        // Upload image jika ada file baru
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            // Ambil nama file asli dari database (tanpa accessor URL)
            $oldImageName = $post->getAttributes()['image'] ?? null;
            if ($oldImageName && file_exists(storage_path('app/public/posts/' . $oldImageName))) {
                unlink(storage_path('app/public/posts/' . $oldImageName));
            }

            // Upload gambar baru
            $image = $request->file('image');
            $image->storeAs('public/posts', $image->hashName());
            $data['image'] = $image->hashName();
        }

        $post->update($data);

        return Redirect::back()->with(messageSuccess('Data Post Berhasil Diupdate'));
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
