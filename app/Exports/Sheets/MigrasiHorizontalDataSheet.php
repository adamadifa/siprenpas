<?php

namespace App\Exports\Sheets;

use App\Models\Jenisbiaya;
use App\Models\Tahunajaran;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;

class MigrasiHorizontalDataSheet implements WithTitle, WithEvents
{
    protected $kodeUnit;

    public function __construct($kodeUnit = null)
    {
        $this->kodeUnit = $kodeUnit;
    }

    public function title(): string
    {
        return 'Data Migrasi';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // ==============================
                // CONFIGURATION
                // ==============================
                $taAktif = Tahunajaran::where('status', 1)->first();
                if ($taAktif) {
                    $tahunAjaran = Tahunajaran::where('kode_ta', '<=', $taAktif->kode_ta)
                        ->orderBy('kode_ta', 'desc')
                        ->take(4) // Aktif + 3 ke belakang
                        ->get()
                        ->reverse(); // Urutkan dari yang terlama
                } else {
                    $tahunAjaran = Tahunajaran::orderBy('kode_ta', 'desc')->take(4)->get()->reverse();
                }
                
                $jenisBiaya = Jenisbiaya::orderBy('kode_jenis_biaya', 'asc')->get();

                // Fixed columns for student data (A-G)
                $fixedHeaders = [
                    'A' => ['label' => 'NISN', 'width' => 16],
                    'B' => ['label' => 'Nama Siswa', 'width' => 30],
                    'C' => ['label' => 'Jenis Kelamin', 'width' => 14],
                    'D' => ['label' => 'Tempat Lahir', 'width' => 18],
                    'E' => ['label' => 'Tanggal Lahir', 'width' => 16],
                    'F' => ['label' => 'Kode Unit', 'width' => 12],
                    'G' => ['label' => 'Tingkat Masuk', 'width' => 14],
                ];

                $dataStartCol = 7; // 0-based index for col H

                // Each jenis biaya = 2 sub-columns (Tagihan, Bayar)
                $subColsPerJB = 2;
                $colsPerTa = $jenisBiaya->count() * $subColsPerJB;

                // ==============================
                // HEADER ROW 1-4
                // ==============================
                // Row 1: "Tahun Ajaran" label spanning all TA columns
                // Row 2: TA name (merged per TA block)
                // Row 3: kode_jenis_biaya labels (merged per 2 sub-cols: Tagihan+Bayar)
                // Row 4: Sub-headers: Tagihan | Bayar per jenis biaya

                // Fixed student columns span rows 1-4 (merged vertically)
                foreach ($fixedHeaders as $col => $info) {
                    $sheet->setCellValue($col . '1', $info['label']);
                    $sheet->mergeCells($col . '1:' . $col . '4');
                    $sheet->getColumnDimension($col)->setWidth($info['width']);
                }

                $colIndex = $dataStartCol;

                // Build TA column mapping for import reference
                // Store structure: [ ['kode_ta' => ..., 'jenis_biaya' => [ ['kode' => 'B01', 'tagihan_idx' => X, 'bayar_idx' => Y], ... ] ] ]

                foreach ($tahunAjaran as $ta) {
                    $taStartIdx = $colIndex;
                    $taEndIdx = $colIndex + $colsPerTa - 1;
                    $taStartCol = $this->getColLetter($taStartIdx);
                    $taEndCol = $this->getColLetter($taEndIdx);

                    // Row 1: "Tahun Ajaran" — only write once (first TA)
                    // We'll merge a super-header across ALL TAs instead
                    // Row 2: TA name (merged across all jenis biaya columns)
                    $sheet->setCellValue($taStartCol . '2', $ta->tahun_ajaran);
                    if ($colsPerTa > 1) {
                        $sheet->mergeCells($taStartCol . '2:' . $taEndCol . '2');
                    }

                    // Row 3 & 4: Per jenis biaya
                    foreach ($jenisBiaya as $jb) {
                        $jbStartCol = $this->getColLetter($colIndex);
                        $jbEndCol = $this->getColLetter($colIndex + $subColsPerJB - 1);

                        // Row 3: Jenis biaya label (merged across Tagihan+Bayar)
                        $sheet->setCellValue($jbStartCol . '3', $jb->kode_jenis_biaya);
                        if ($subColsPerJB > 1) {
                            $sheet->mergeCells($jbStartCol . '3:' . $jbEndCol . '3');
                        }

                        // Row 4: Sub-column headers
                        $sheet->setCellValue($this->getColLetter($colIndex) . '4', 'Tagihan');
                        $sheet->setCellValue($this->getColLetter($colIndex + 1) . '4', 'Bayar');

                        // Set widths
                        $sheet->getColumnDimension($this->getColLetter($colIndex))->setWidth(13);
                        $sheet->getColumnDimension($this->getColLetter($colIndex + 1))->setWidth(13);

                        $colIndex += $subColsPerJB;
                    }
                }

                $lastDataCol = $this->getColLetter($colIndex - 1);
                $taStartColLetter = $this->getColLetter($dataStartCol);

                // Row 1: "Tahun Ajaran" super-header spanning all TA columns
                if ($tahunAjaran->count() > 0 && $jenisBiaya->count() > 0) {
                    $sheet->setCellValue($taStartColLetter . '1', 'Tahun Ajaran');
                    $sheet->mergeCells($taStartColLetter . '1:' . $lastDataCol . '1');
                }

                // ==============================
                // STYLING
                // ==============================
                $darkBlue = 'FF1B2A4A';
                $mediumBlue = 'FF2C3E6B';
                $lightBlue = 'FF3A5199';
                $lighterBlue = 'FF4A6BC4';
                $headerFont = 'FFFFFFFF';
                $borderColor = 'FF4A5568';

                // Style for fixed student headers (A1:G4) — Dark blue
                $sheet->getStyle('A1:G4')->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['argb' => $headerFont], 'size' => 10],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => $darkBlue]],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER, 'wrapText' => true],
                    'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => $borderColor]]],
                ]);

                // Style for Row 1 (Tahun Ajaran super-header) — Dark blue
                $sheet->getStyle($taStartColLetter . '1:' . $lastDataCol . '1')->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['argb' => $headerFont], 'size' => 11],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => $darkBlue]],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
                    'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => $borderColor]]],
                ]);

                // Style for Row 2 (TA names) — Medium blue
                $sheet->getStyle($taStartColLetter . '2:' . $lastDataCol . '2')->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['argb' => $headerFont], 'size' => 10],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => $mediumBlue]],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
                    'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => $borderColor]]],
                ]);

                // Style for Row 3 (kode jenis biaya) — Light blue
                $sheet->getStyle($taStartColLetter . '3:' . $lastDataCol . '3')->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['argb' => $headerFont], 'size' => 9],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => $lightBlue]],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
                    'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => $borderColor]]],
                ]);

                // Style for Row 4 (Tagihan/Bayar) — Lighter blue
                $sheet->getStyle($taStartColLetter . '4:' . $lastDataCol . '4')->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['argb' => $headerFont], 'size' => 9],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => $lighterBlue]],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
                    'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => $borderColor]]],
                ]);

                // Set row heights
                $sheet->getRowDimension(1)->setRowHeight(26);
                $sheet->getRowDimension(2)->setRowHeight(24);
                $sheet->getRowDimension(3)->setRowHeight(22);
                $sheet->getRowDimension(4)->setRowHeight(22);

                // Freeze panes
                $sheet->freezePane($taStartColLetter . '5');

                // ==============================
                // SAMPLE DATA ROWS (15 Rows starting Row 5)
                // ==============================
                $samples = [
                    ['0012345671', 'Ahmad Fadhil', 'L', 'Bandung', '2010-05-15', 'U01', '1'],
                    ['0012345672', 'Siti Aminah', 'P', 'Jakarta', '2010-06-20', 'U01', '1'],
                    ['0012345673', 'Budi Santoso', 'L', 'Surabaya', '2009-12-10', 'U01', '2'],
                    ['0012345674', 'Dewi Lestari', 'P', 'Yogyakarta', '2011-01-05', 'U02', '1'],
                    ['0012345675', 'Fauzan Azima', 'L', 'Medan', '2010-03-22', 'U01', '1'],
                    ['0012345676', 'Indah Permata', 'P', 'Semarang', '2010-08-14', 'U02', '1'],
                    ['0012345677', 'Rizky Ramadhan', 'L', 'Makassar', '2009-09-30', 'U01', '3'],
                    ['0012345678', 'Lutfi Hakim', 'L', 'Palembang', '2010-11-11', 'U01', '1'],
                    ['0012345679', 'Nadia Safira', 'P', 'Bali', '2011-02-28', 'U02', '1'],
                    ['0012345680', 'Yusuf Mansur', 'L', 'Aceh', '2010-04-10', 'U01', '2'],
                    ['0012345681', 'Zahra Aulia', 'P', 'Banjarmasin', '2010-07-07', 'U01', '1'],
                    ['0012345682', 'Farhan Ali', 'L', 'Malang', '2009-10-25', 'U02', '2'],
                    ['0012345683', 'Putri Salma', 'P', 'Bogor', '2011-05-01', 'U01', '1'],
                    ['0012345684', 'Haikal Razak', 'L', 'Tangerang', '2010-01-19', 'U01', '1'],
                    ['0012345685', 'Annisa Fitri', 'P', 'Bekasi', '2010-12-12', 'U01', '1'],
                ];

                $currentRow = 5;
                foreach ($samples as $data) {
                    $sheet->setCellValue('A' . $currentRow, $data[0]);
                    $sheet->setCellValue('B' . $currentRow, $data[1]);
                    $sheet->setCellValue('C' . $currentRow, $data[2]);
                    $sheet->setCellValue('D' . $currentRow, $data[3]);
                    $sheet->setCellValue('E' . $currentRow, $data[4]);
                    $sheet->setCellValue('F' . $currentRow, $this->kodeUnit ?? $data[5]);
                    $sheet->setCellValue('G' . $currentRow, $data[6]);

                    // Fill sample payment data for each TA (only for first few rows to show variation)
                    if ($currentRow <= 10) {
                        $sampleColIdx = $dataStartCol;
                        foreach ($tahunAjaran as $ta) {
                            foreach ($jenisBiaya as $jb) {
                                if ($jb->kode_jenis_biaya == 'B01') { // Pendaftaran
                                    $sheet->setCellValue($this->getColLetter($sampleColIdx) . $currentRow, 250000);
                                    $sheet->setCellValue($this->getColLetter($sampleColIdx + 1) . $currentRow, 250000);
                                }
                                $sampleColIdx += $subColsPerJB;
                            }
                        }
                    }

                    // Style the row
                    $sheet->getStyle('A' . $currentRow . ':' . $lastDataCol . $currentRow)->applyFromArray([
                        'font' => ['size' => 10, 'italic' => true, 'color' => ['argb' => 'FF64748B']],
                        'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFF1F5F9']],
                        'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FFCBD5E1']]],
                        'alignment' => ['vertical' => Alignment::VERTICAL_CENTER],
                    ]);

                    $currentRow++;
                }

                // Format number columns for all payment area
                $numFormat = '#,##0';
                for ($row = 5; $row <= 200; $row++) {
                    $idx = $dataStartCol;
                    foreach ($tahunAjaran as $ta) {
                        foreach ($jenisBiaya as $jb) {
                            $sheet->getStyle($this->getColLetter($idx) . $row)->getNumberFormat()->setFormatCode($numFormat);
                            $sheet->getStyle($this->getColLetter($idx + 1) . $row)->getNumberFormat()->setFormatCode($numFormat);
                            $idx += $subColsPerJB;
                        }
                    }
                }

                // Data validation for Jenis Kelamin (C column)
                $validation = $sheet->getCell('C5')->getDataValidation();
                $validation->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST);
                $validation->setErrorStyle(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_STOP);
                $validation->setAllowBlank(true);
                $validation->setShowDropDown(true);
                $validation->setFormula1('"L,P"');
                for ($row = 6; $row <= 200; $row++) {
                    $sheet->getCell('C' . $row)->setDataValidation(clone $validation);
                }
            },
        ];
    }

    /**
     * Convert 0-based column index to Excel letter (0=A, 1=B, 26=AA, etc.)
     */
    private function getColLetter(int $index): string
    {
        $letter = '';
        while ($index >= 0) {
            $letter = chr(65 + ($index % 26)) . $letter;
            $index = intval($index / 26) - 1;
        }
        return $letter;
    }
}
