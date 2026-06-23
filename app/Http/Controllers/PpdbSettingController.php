<?php

namespace App\Http\Controllers;

use App\Models\PengaturanUmum;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PpdbSettingController extends Controller
{
    public function index()
    {
        $pengaturan = PengaturanUmum::first();
        $units = Unit::all();
        return view('website.ppdb.index', compact('pengaturan', 'units'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'brosur_utama' => 'nullable|file|mimes:pdf,jpeg,png,jpg|max:5120',
            'brosur_unit' => 'nullable|array',
            'brosur_unit.*' => 'nullable|file|mimes:pdf,jpeg,png,jpg|max:5120',
            'rincian_biaya_fullday' => 'nullable|array',
            'rincian_biaya_fullday.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            'rincian_biaya_boarding' => 'nullable|array',
            'rincian_biaya_boarding.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
        ]);

        $pengaturan = PengaturanUmum::first();
        if (!$pengaturan) {
            $pengaturan = new PengaturanUmum();
        }

        // Handle Brosur Utama upload
        if ($request->hasFile('brosur_utama')) {
            if ($pengaturan->brosur_utama && Storage::exists('public/' . $pengaturan->brosur_utama)) {
                Storage::delete('public/' . $pengaturan->brosur_utama);
            }

            $file = $request->file('brosur_utama');
            $fileName = 'brosur_utama_' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/ppdb', $fileName);
            $pengaturan->brosur_utama = 'ppdb/' . $fileName;
        }

        $pengaturan->save();

        // Handle Unit uploads
        $units = Unit::all();
        foreach ($units as $unit) {
            $kode = $unit->kode_unit;
            
            // Handle Brosur Unit
            if ($request->hasFile("brosur_unit.$kode")) {
                if ($unit->brosur_unit && Storage::exists('public/' . $unit->brosur_unit)) {
                    Storage::delete('public/' . $unit->brosur_unit);
                }

                $file = $request->file("brosur_unit.$kode");
                $fileName = 'brosur_unit_' . $kode . '_' . time() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('public/ppdb', $fileName);
                $unit->brosur_unit = 'ppdb/' . $fileName;
            }

            // Handle Rincian Biaya Full Day
            if ($request->hasFile("rincian_biaya_fullday.$kode")) {
                if ($unit->rincian_biaya_fullday && Storage::exists('public/' . $unit->rincian_biaya_fullday)) {
                    Storage::delete('public/' . $unit->rincian_biaya_fullday);
                }

                $file = $request->file("rincian_biaya_fullday.$kode");
                $fileName = 'rincian_biaya_fullday_' . $kode . '_' . time() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('public/ppdb', $fileName);
                $unit->rincian_biaya_fullday = 'ppdb/' . $fileName;
            }

            // Handle Rincian Biaya Boarding
            if ($request->hasFile("rincian_biaya_boarding.$kode")) {
                if ($unit->rincian_biaya_boarding && Storage::exists('public/' . $unit->rincian_biaya_boarding)) {
                    Storage::delete('public/' . $unit->rincian_biaya_boarding);
                }

                $file = $request->file("rincian_biaya_boarding.$kode");
                $fileName = 'rincian_biaya_boarding_' . $kode . '_' . time() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('public/ppdb', $fileName);
                $unit->rincian_biaya_boarding = 'ppdb/' . $fileName;
            }

            $unit->save();
        }

        return redirect()->route('ppdb-setting.index')
            ->with('success', 'Pengaturan PPDB berhasil disimpan!');
    }
}
