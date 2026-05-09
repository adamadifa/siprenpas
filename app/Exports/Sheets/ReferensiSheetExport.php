<?php

namespace App\Exports\Sheets;

use App\Models\Unit;
use App\Models\Jenisbiaya;
use App\Models\Kelas;
use App\Models\Tahunajaran;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ReferensiSheetExport implements FromCollection, WithHeadings, WithTitle, ShouldAutoSize
{
    public function title(): string
    {
        return 'Referensi';
    }

    public function headings(): array
    {
        return [
            'TYPE',
            'KODE',
            'NAMA / KETERANGAN'
        ];
    }

    public function collection()
    {
        $data = collect();

        // Tahun Ajaran
        $tahunAjaran = Tahunajaran::orderBy('kode_ta', 'desc')->get();
        foreach ($tahunAjaran as $ta) {
            $data->push([
                'TAHUN AJARAN',
                $ta->kode_ta,
                $ta->tahun_ajaran . ($ta->status == 1 ? ' (AKTIF)' : '')
            ]);
        }

        // Units
        $units = Unit::all();
        foreach ($units as $unit) {
            $data->push([
                'UNIT',
                $unit->kode_unit,
                $unit->nama_unit
            ]);
        }

        // Jenis Biaya
        $jenisBiaya = Jenisbiaya::all();
        foreach ($jenisBiaya as $jb) {
            $data->push([
                'JENIS BIAYA',
                $jb->kode_jenis_biaya,
                $jb->jenis_biaya
            ]);
        }

        // Kelas for all TAs (so user can reference any TA)
        $allTa = Tahunajaran::orderBy('kode_ta', 'desc')->get();
        foreach ($allTa as $ta) {
            $kelas = Kelas::with('unit')
                ->where('kode_ta', $ta->kode_ta)
                ->get();

            foreach ($kelas as $k) {
                $data->push([
                    'KELAS (' . $ta->tahun_ajaran . ')',
                    $k->kode_kelas,
                    $k->nama_kelas . ' (' . ($k->unit->nama_unit ?? 'N/A') . ' - Tingkat ' . $k->tingkat . ')'
                ]);
            }
        }

        return $data;
    }
}
