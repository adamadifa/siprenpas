<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    public function index()
    {
        $units = \App\Models\Unit::whereNotIn('kode_unit', ['U00', 'U06'])
            ->orderBy('kode_unit')
            ->get();
        return response()->json($units);
    }
}
