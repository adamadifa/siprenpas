<?php

namespace App\Exports\Sheets;

use App\Models\Kelas;
use App\Models\Tahunajaran;
use App\Models\Unit;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class MigrasiHorizontalReferensiSheet implements WithTitle, WithEvents
{
    public function title(): string
    {
        return 'Referensi';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Headers
                $sheet->setCellValue('A1', 'TIPE');
                $sheet->setCellValue('B1', 'KODE');
                $sheet->setCellValue('C1', 'KETERANGAN');

                $sheet->getColumnDimension('A')->setWidth(20);
                $sheet->getColumnDimension('B')->setWidth(15);
                $sheet->getColumnDimension('C')->setWidth(45);

                // Style header
                $sheet->getStyle('A1:C1')->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF'], 'size' => 10],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'FF1B2A4A'],
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => 'FF4A5568'],
                        ],
                    ],
                ]);

                $row = 2;

                // Tahun Ajaran
                $tahunAjaran = Tahunajaran::orderBy('kode_ta', 'desc')->get();
                foreach ($tahunAjaran as $ta) {
                    $sheet->setCellValue('A' . $row, 'TAHUN AJARAN');
                    $sheet->setCellValue('B' . $row, $ta->kode_ta);
                    $sheet->setCellValue('C' . $row, $ta->tahun_ajaran . ($ta->status == 1 ? ' (AKTIF)' : ''));
                    $this->styleRow($sheet, $row, 'FFEBF5FB');
                    $row++;
                }

                // Units
                $units = Unit::all();
                foreach ($units as $unit) {
                    $sheet->setCellValue('A' . $row, 'UNIT');
                    $sheet->setCellValue('B' . $row, $unit->kode_unit);
                    $sheet->setCellValue('C' . $row, $unit->nama_unit);
                    $this->styleRow($sheet, $row, 'FFE8F8F5');
                    $row++;
                }

                // Jenis Kelamin
                $sheet->setCellValue('A' . $row, 'JENIS KELAMIN');
                $sheet->setCellValue('B' . $row, 'L');
                $sheet->setCellValue('C' . $row, 'Laki-laki');
                $this->styleRow($sheet, $row, 'FFFEF9E7');
                $row++;
                $sheet->setCellValue('A' . $row, 'JENIS KELAMIN');
                $sheet->setCellValue('B' . $row, 'P');
                $sheet->setCellValue('C' . $row, 'Perempuan');
                $this->styleRow($sheet, $row, 'FFFEF9E7');
                $row++;

                // Jenis Biaya
                $jenisBiaya = \App\Models\Jenisbiaya::orderBy('kode_jenis_biaya', 'asc')->get();
                foreach ($jenisBiaya as $jb) {
                    $sheet->setCellValue('A' . $row, 'JENIS BIAYA');
                    $sheet->setCellValue('B' . $row, $jb->kode_jenis_biaya);
                    $sheet->setCellValue('C' . $row, $jb->jenis_biaya);
                    $this->styleRow($sheet, $row, 'FFFCE4EC');
                    $row++;
                }

                // Kelas
                $allTa = Tahunajaran::orderBy('kode_ta', 'desc')->get();
                foreach ($allTa as $ta) {
                    $kelas = Kelas::with('unit')
                        ->where('kode_ta', $ta->kode_ta)
                        ->get();

                    foreach ($kelas as $k) {
                        $sheet->setCellValue('A' . $row, 'KELAS (' . $ta->tahun_ajaran . ')');
                        $sheet->setCellValue('B' . $row, $k->kode_kelas);
                        $sheet->setCellValue('C' . $row, $k->nama_kelas . ' (' . ($k->unit->nama_unit ?? 'N/A') . ' - Tingkat ' . $k->tingkat . ')');
                        $this->styleRow($sheet, $row, 'FFF5EEF8');
                        $row++;
                    }
                }
            },
        ];
    }

    private function styleRow($sheet, $row, $bgColor)
    {
        $sheet->getStyle('A' . $row . ':C' . $row)->applyFromArray([
            'font' => ['size' => 9],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => $bgColor],
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FFE2E8F0'],
                ],
            ],
            'alignment' => [
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);
    }
}
