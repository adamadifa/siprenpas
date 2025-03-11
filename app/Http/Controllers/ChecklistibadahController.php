<?php

namespace App\Http\Controllers;

use App\Models\Kegiatanibadah;
use Illuminate\Http\Request;

class ChecklistibadahController extends Controller
{
    public function create()
    {
        return view('checklistibadah.create');
    }

    public function getchecklistibadah(Request $request)
    {
        $kegiatan_ibadah = Kegiatanibadah::join('kategori_ibadah', 'kegiatan_ibadah.id_kategori_ibadah', '=', 'kategori_ibadah.id')
            ->orderBy('kegiatan_ibadah.id_kategori_ibadah')
            ->orderBy('kegiatan_ibadah.id', 'asc')
            ->get();
        $data['kegiatan_ibadah'] = $kegiatan_ibadah;
        return view('checklistibadah.getchecklistibadah', $data);
    }
}
