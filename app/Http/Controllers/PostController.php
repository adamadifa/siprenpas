<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\WebpEncoder;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $accessibleUnits = $user->getAccessibleUnitCodes();

        $query = Post::with(['user', 'category', 'unit'])->latest();

        // Scope to accessible units
        if (!empty($accessibleUnits)) {
            $query->whereIn('kode_unit', $accessibleUnits);
        }

        // Filter by title
        if ($request->filled('title')) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }

        // Filter by unit
        if ($request->filled('kode_unit')) {
            if ($user->canAccessUnit($request->kode_unit)) {
                $query->where('kode_unit', $request->kode_unit);
            }
        }

        $posts = $query->paginate(10);
        $units = Unit::whereIn('kode_unit', $accessibleUnits)->get();

        return view('website.post.index', compact('posts', 'units'));
    }

    public function create()
    {
        $user = auth()->user();
        $accessibleUnits = $user->getAccessibleUnitCodes();

        $data['categories'] = Category::all();
        $data['units'] = Unit::whereIn('kode_unit', $accessibleUnits)->get();
        $data['default_unit'] = $user->kode_unit ?? ($accessibleUnits[0] ?? 'U06');

        return view('website.post.create', $data);
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        $accessibleUnits = $user->getAccessibleUnitCodes();

        $request->validate([
            'image'         => 'required|image|mimes:jpeg,jpg,png,webp|max:4096',
            'title'         => 'required|unique:posts',
            'category_id'   => 'required',
            'kode_unit'     => 'required|in:' . implode(',', $accessibleUnits),
            'content'       => 'required'
        ]);

        // Fallback unit if not provided
        $kodeUnit = $request->kode_unit ?? $user->kode_unit ?? 'U06';

        // Check unit access
        if (!$user->canAccessUnit($kodeUnit)) {
            return Redirect::back()->with(messageError('Anda tidak memiliki akses ke unit tersebut.'));
        }

        //upload image
        $image = $request->file('image');
        $imageName = time() . '_' . uniqid() . '.webp';
        $this->storeAsWebp($image, 'posts', $imageName);

        $post = Post::create([
            'image'       => $imageName,
            'title'       => $request->title,
            'slug'        => Str::slug($request->title, '-'),
            'category_id' => $request->category_id,
            'kode_unit'   => $kodeUnit,
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
        $user = auth()->user();

        // Check if user has access to this post's unit
        if ($post->kode_unit && !$user->canAccessUnit($post->kode_unit)) {
            return response()->json(['message' => 'Anda tidak memiliki hak akses ke post unit ini.'], 403);
        }

        $accessibleUnits = $user->getAccessibleUnitCodes();
        $categories = Category::all();
        $units = Unit::whereIn('kode_unit', $accessibleUnits)->get();

        return view('website.post.edit', compact('post', 'categories', 'units'));
    }

    public function update(Request $request, $id)
    {
        $id = Crypt::decrypt($id);
        $post = Post::findOrFail($id);
        $user = auth()->user();

        // Check if user has access to current post unit
        if ($post->kode_unit && !$user->canAccessUnit($post->kode_unit)) {
            return Redirect::back()->with(messageError('Anda tidak memiliki hak akses ke post unit ini.'));
        }

        $accessibleUnits = $user->getAccessibleUnitCodes();

        $request->validate([
            'title'       => 'required|unique:posts,title,' . $id,
            'category_id' => 'required',
            'kode_unit'   => 'required|in:' . implode(',', $accessibleUnits),
            'content'     => 'required',
            'image'       => 'nullable|image|mimes:jpeg,jpg,png,webp|max:4096'
        ]);

        $data = [
            'title'       => $request->title,
            'slug'        => Str::slug($request->title, '-'),
            'category_id' => $request->category_id,
            'kode_unit'   => $request->kode_unit,
            'content'     => $request->content
        ];

        // Upload image jika ada file baru
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            // Ambil nama file asli dari database (tanpa accessor URL)
            $oldImageName = $post->getAttributes()['image'] ?? null;
            if ($oldImageName && Storage::exists('public/posts/' . $oldImageName)) {
                Storage::delete('public/posts/' . $oldImageName);
            }

            // Upload gambar baru
            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.webp';
            $this->storeAsWebp($image, 'posts', $imageName);
            $data['image'] = $imageName;
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

    /**
     * Convert and compress an uploaded image to WebP, then store it.
     */
    private function storeAsWebp($file, $folder, $filename)
    {
        $imageManager = new ImageManager(new Driver());
        $img = $imageManager->read($file->getRealPath());
        $encoded = $img->encode(new WebpEncoder(quality: 80));

        $path = $folder . '/' . $filename;
        Storage::put('public/' . $path, (string) $encoded);

        return $filename;
    }
}
