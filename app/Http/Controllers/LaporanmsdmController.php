<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;

class LaporanmsdmController extends Controller
{
    public function index(){
        $data['unit'] = Unit::where('kode_unit','!=','U00')->get();
        $data['list_bulan'] = config('global.list_bulan');
        $data['start_year'] = config('global.start_year');
        return view('msdm.laporan.index', $data);
    }
}
