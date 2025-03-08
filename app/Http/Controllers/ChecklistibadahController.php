<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChecklistibadahController extends Controller
{
    public function create()
    {
        return view('checklistibadah.create');
    }
}
