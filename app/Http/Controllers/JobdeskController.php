<?php

namespace App\Http\Controllers;

use App\Models\Departemen;
use App\Models\Jabatan;
use App\Models\Jobdesk;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redirect;
use Jenssegers\Agent\Agent;

class JobdeskController extends Controller
{
    public function index(Request $request, $kode_unit = null, $kode_dept = null, $kode_jabatan = null)
    {
        $user = User::where('id', auth()->user()->id)->first();
        $query = Jobdesk::query();
        $query->select('jobdesk.*', 'jobdesk_group.kode_dept', 'jobdesk_group.kode_jabatan', 'jobdesk_group.kode_unit', 'nama_dept', 'nama_jabatan', 'nama_unit');
        $query->join('jobdesk_group', 'jobdesk.kode_jobdesk_group', '=', 'jobdesk_group.kode_jobdesk_group');
        $query->join('departemen', 'jobdesk_group.kode_dept', '=', 'departemen.kode_dept');
        $query->join('jabatan', 'jobdesk_group.kode_jabatan', '=', 'jabatan.kode_jabatan');
        $query->leftJoin('unit', 'jobdesk_group.kode_unit', '=', 'unit.kode_unit');
        $query->orderBy('kode_jobdesk');
        if ($user->hasRole('karyawan')) {
            $userkaryawan = \App\Models\Userkaryawan::where('id_user', $user->id)->first();
            $karyawan = \App\Models\Karyawan::where('karyawan.npp', $userkaryawan->npp)
                ->join('jabatan', 'karyawan.kode_jabatan', '=', 'jabatan.kode_jabatan')
                ->join('unit', 'karyawan.kode_unit', '=', 'unit.kode_unit')
                ->first();
            
            $dept = \App\Models\Departemen::where('kode_dept', $user->kode_dept)->first();
            if ($karyawan && $dept) {
                $karyawan->nama_dept = $dept->nama_dept;
            }
            
            $query->where('jobdesk_group.kode_jabatan', $user->kode_jabatan);
            $query->where('jobdesk_group.kode_dept', $user->kode_dept);
            if (!empty($user->kode_unit)) {
                $query->where('jobdesk_group.kode_unit', $user->kode_unit);
            }
            $data['jobdesk'] = $query->get();
            $data['karyawan'] = $karyawan;
            
            return view('datamaster.jobdesk.index_karyawan', $data);
        }

        if ($user->hasRole(['super admin', 'pimpinan pesantren', 'sekretaris'])) {
            if (!empty($kode_jabatan)) {
                $query->where('jobdesk_group.kode_jabatan', $kode_jabatan);
            } elseif (!empty($request->kode_jabatan)) {
                $query->where('jobdesk_group.kode_jabatan', $request->kode_jabatan);
            }
            
            if (!empty($kode_dept)) {
                $query->where('jobdesk_group.kode_dept', $kode_dept);
            } elseif (!empty($request->kode_dept)) {
                $query->where('jobdesk_group.kode_dept', $request->kode_dept);
            }

            if (!empty($kode_unit)) {
                $query->where('jobdesk_group.kode_unit', $kode_unit);
            } elseif (!empty($request->kode_unit)) {
                $query->where('jobdesk_group.kode_unit', $request->kode_unit);
            }
        } else {
            $query->where('jobdesk_group.kode_jabatan', $user->kode_jabatan);
            $query->where('jobdesk_group.kode_dept', $user->kode_dept);
            if (!empty($user->kode_unit)) {
                $query->where('jobdesk_group.kode_unit', $user->kode_unit);
            }
        }

        if (!empty($request->jobdesk_search)) {
            $query->where('jobdesk.jobdesk', 'like', '%' . $request->jobdesk_search . '%');
        }

        $data['jobdesk'] = $query->get();

        $data['jabatan'] = Jabatan::orderBy('kode_jabatan')->where('kode_jabatan', '!=', 'J00')->get();
        $data['departemen'] = Departemen::orderBy('kode_dept')->get();
        $data['unit'] = \App\Models\Unit::where('kode_unit', '!=', 'U00')->orderBy('kode_unit')->get();

        $data['selected_unit'] = $kode_unit ? \App\Models\Unit::where('kode_unit', $kode_unit)->first() : null;
        $data['selected_dept'] = $kode_dept ? Departemen::where('kode_dept', $kode_dept)->first() : null;
        $data['selected_jabatan'] = $kode_jabatan ? Jabatan::where('kode_jabatan', $kode_jabatan)->first() : null;

        $agent = new Agent();
        if ($agent->isMobile()) {
            return view('datamaster.jobdesk.index_mobile', $data);
        }
        return view('datamaster.jobdesk.index', $data);
    }


    public function create(Request $request)
    {
        $data['jabatan'] = Jabatan::orderBy('kode_jabatan')->where('kode_jabatan', '!=', 'J00')->get();
        $data['departemen'] = Departemen::orderBy('kode_dept')->get();
        $data['unit'] = \App\Models\Unit::where('kode_unit', '!=', 'U00')->orderBy('kode_unit')->get();
        $data['pre_selected_dept'] = $request->query('kode_dept');
        $data['pre_selected_jabatan'] = $request->query('kode_jabatan');
        $data['pre_selected_unit'] = $request->query('kode_unit');
        $agent = new Agent();
        if ($agent->isMobile()) {
            return view('datamaster.jobdesk.create_mobile', $data);
        }
        return view('datamaster.jobdesk.create', $data);
    }

    public function store(Request $request)
    {
        $user = User::where('id', auth()->user()->id)->first();
        if ($user->hasRole('super admin')) {
            $request->validate([
                'kode_jabatan' => 'required',
                'kode_dept' => 'required',
                'jobdesk' => 'required',
                'kode_unit' => 'nullable',
            ]);
            $kode_dept = $request->kode_dept;
            $kode_jabatan = $request->kode_jabatan;
            $kode_unit = $request->kode_unit;
        } else {
            $request->validate([
                'jobdesk' => 'required',
            ]);
            $kode_dept = $user->kode_dept;
            $kode_jabatan = $user->kode_jabatan;
            $kode_unit = $user->kode_unit;
        }


        try {
            $unitPart = $kode_unit ?? 'U00';
            $groupId = substr($kode_jabatan . $kode_dept . $unitPart, 0, 10);

            $group = \App\Models\JobdeskGroup::find($groupId);
            if (!$group) {
                $group = \App\Models\JobdeskGroup::create([
                    'kode_jobdesk_group' => $groupId,
                    'kode_unit' => $kode_unit,
                    'kode_dept' => $kode_dept,
                    'kode_jabatan' => $kode_jabatan
                ]);
            }

            $lastjobdesk = Jobdesk::orderBy('kode_jobdesk', 'desc')
                 ->where('kode_jobdesk', 'like', $kode_jabatan . $kode_dept . '%')
                 ->first();
            $last_kode_jobdesk = $lastjobdesk != null ? $lastjobdesk->kode_jobdesk : '';
            $kode_jobdesk = buatkode($last_kode_jobdesk, $kode_jabatan . $kode_dept, 4);
            Jobdesk::create([
                'kode_jobdesk' => $kode_jobdesk,
                'jobdesk' => $request->jobdesk,
                'kode_jobdesk_group' => $groupId
            ]);

            $agent = new Agent();

            if ($agent->isMobile()) {
                return redirect(route('jobdesk.index'))->with(messageSuccess('Data Berhasil Disimpan'));
            }
            return Redirect::back()->with(messageSuccess('Data Berhasil Disimpan'));
        } catch (\Exception $e) {
            return Redirect::back()->with(messageError($e->getMessage()));
        }
    }

    public function destroy($kode_jobdesk)
    {

        $kode_jobdesk = Crypt::decrypt($kode_jobdesk);

        try {
            Jobdesk::where('kode_jobdesk', $kode_jobdesk)->delete();
            return Redirect::back()->with(messageSuccess('Data Berhasil Dihapus'));
        } catch (\Exception $e) {
            return Redirect::back()->with(messageError($e->getMessage()));
        }
    }

    public function edit($kode_jobdesk)
    {
        $kode_jobdesk = Crypt::decrypt($kode_jobdesk);
        $data['jobdesk'] = Jobdesk::select('jobdesk.*', 'jobdesk_group.kode_dept', 'jobdesk_group.kode_jabatan', 'jobdesk_group.kode_unit')
            ->join('jobdesk_group', 'jobdesk.kode_jobdesk_group', '=', 'jobdesk_group.kode_jobdesk_group')
            ->where('kode_jobdesk', $kode_jobdesk)
            ->first();
        $data['jabatan'] = Jabatan::orderBy('kode_jabatan')->where('kode_jabatan', '!=', 'J00')->get();
        $data['departemen'] = Departemen::orderBy('kode_dept')->get();
        $data['unit'] = \App\Models\Unit::where('kode_unit', '!=', 'U00')->orderBy('kode_unit')->get();
        $agent = new Agent();
        if ($agent->isMobile()) {
            return view('datamaster.jobdesk.edit_mobile', $data);
        }
        return view('datamaster.jobdesk.edit', $data);
    }

    public function update(Request $request, $kode_jobdesk)
    {
        $user = User::where('id', auth()->user()->id)->first();
        if ($user->hasRole('super admin')) {
            $request->validate([
                'kode_jabatan' => 'required',
                'kode_dept' => 'required',
                'jobdesk' => 'required',
                'kode_unit' => 'nullable',
            ]);
            $kode_dept = $request->kode_dept;
            $kode_jabatan = $request->kode_jabatan;
            $kode_unit = $request->kode_unit;
        } else {
            $request->validate([
                'jobdesk' => 'required',
            ]);
            $kode_dept = $user->kode_dept;
            $kode_jabatan = $user->kode_jabatan;
            $kode_unit = $user->kode_unit;
        }

        $kode_jobdesk = Crypt::decrypt($kode_jobdesk);
        try {
            $unitPart = $kode_unit ?? 'U00';
            $groupId = substr($kode_jabatan . $kode_dept . $unitPart, 0, 10);

            $group = \App\Models\JobdeskGroup::find($groupId);
            if (!$group) {
                $group = \App\Models\JobdeskGroup::create([
                    'kode_jobdesk_group' => $groupId,
                    'kode_unit' => $kode_unit,
                    'kode_dept' => $kode_dept,
                    'kode_jabatan' => $kode_jabatan
                ]);
            }

            Jobdesk::where('kode_jobdesk', $kode_jobdesk)->update([
                'kode_jobdesk_group' => $groupId,
                'jobdesk' => $request->jobdesk
            ]);
            $agent = new Agent();

            if ($agent->isMobile()) {
                return redirect(route('jobdesk.index'))->with(messageSuccess('Data Berhasil Diubah'));
            }
            return Redirect::back()->with(messageSuccess('Data Berhasil Diubah'));
        } catch (\Exception $e) {
            return Redirect::back()->with(messageError($e->getMessage()));
        }
    }


    public function getjobdesk(Request $request)
    {
        $user = User::where('id', auth()->user()->id)->first();
        $kode_jabatan = $user->hasRole('super admin') ? $request->kode_jabatan : auth()->user()->kode_jabatan;
        $kode_dept = $user->hasRole('super admin') ? $request->kode_dept : auth()->user()->kode_dept;

        $jobdesk = Jobdesk::join('jobdesk_group', 'jobdesk.kode_jobdesk_group', '=', 'jobdesk_group.kode_jobdesk_group')
            ->where('jobdesk_group.kode_jabatan', $kode_jabatan)
            ->where('jobdesk_group.kode_dept', $kode_dept)
            ->get();
        return response()->json($jobdesk);
    }


    public function getjobdesklist(Request $request)
    {
        $user = User::where('id', auth()->user()->id)->first();
        $kode_jabatan = $user->hasRole('super admin') ? $request->kode_jabatan : auth()->user()->kode_jabatan;
        $kode_dept = $user->hasRole('super admin') ? $request->kode_dept : auth()->user()->kode_dept;

        $qjobdesk = Jobdesk::query();
        $qjobdesk->join('jobdesk_group', 'jobdesk.kode_jobdesk_group', '=', 'jobdesk_group.kode_jobdesk_group');
        $qjobdesk->where('jobdesk_group.kode_jabatan', $kode_jabatan);
        $qjobdesk->where('jobdesk_group.kode_dept', $kode_dept);
        if (!empty($request->jobdesk_search)) {
            $qjobdesk->where('jobdesk.jobdesk', 'like', '%' . $request->jobdesk_search . '%');
        }
        $jobdesk  = $qjobdesk->get();
        return view('datamaster.jobdesk.getjobdesklist', compact('jobdesk'));
    }

    public function reset()
    {
        $user = User::where('id', auth()->user()->id)->first();
        if (!$user->hasRole('super admin')) {
            abort(403, 'Unauthorized action.');
        }

        try {
            \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            Jobdesk::query()->delete();
            \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            return Redirect::back()->with(messageSuccess('Semua data jobdesk berhasil direset'));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            return Redirect::back()->with(messageError($e->getMessage()));
        }
    }

    public function downloadFormat()
    {
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        
        $headerStyle = [
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => '064E3B'],
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
        ];

        $borderStyle = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => 'D0D0D0'],
                ],
            ],
        ];

        // Sheet 1: Paket 1 (Grup & Detail tugas)
        $sheet1 = $spreadsheet->getActiveSheet();
        $sheet1->setTitle('Paket 1');
        
        // 1. Header Grup
        $sheet1->setCellValue('A1', 'GRUP JOBDESK (HEADER)');
        $sheet1->mergeCells('A1:C1');
        $sheet1->getStyle('A1:C1')->applyFromArray($headerStyle);
        
        $sheet1->setCellValue('A2', 'kode_unit');
        $sheet1->setCellValue('B2', 'kode_dept');
        $sheet1->setCellValue('C2', 'kode_jabatan');
        $sheet1->getStyle('A2:C2')->getFont()->setBold(true);
        $sheet1->getStyle('A2:C2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        
        // Sample Grup Data
        $sheet1->setCellValue('A3', 'U06');
        $sheet1->setCellValue('B3', 'SKR');
        $sheet1->setCellValue('C3', 'J22');
        
        $sheet1->getStyle('A1:C3')->applyFromArray($borderStyle);
        
        // 2. Header Detail
        $sheet1->setCellValue('A5', 'RINCIAN JOBDESK (DETAIL)');
        $sheet1->mergeCells('A5:B5');
        $sheet1->getStyle('A5:B5')->applyFromArray($headerStyle);
        
        $sheet1->setCellValue('A6', 'no');
        $sheet1->setCellValue('B6', 'rincian_jobdesk');
        $sheet1->getStyle('A6:B6')->getFont()->setBold(true);
        $sheet1->getStyle('A6')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        
        // Sample Detail Data
        $sheet1->setCellValue('A7', '1');
        $sheet1->setCellValue('B7', 'Memelihara jaringan internet dan server lokal Pesantren.');
        $sheet1->setCellValue('A8', '2');
        $sheet1->setCellValue('B8', 'Melakukan troubleshooting perangkat keras di lingkungan Pesantren.');
        
        $sheet1->getStyle('A5:B8')->applyFromArray($borderStyle);
        
        foreach (range('A', 'C') as $col) {
            $sheet1->getColumnDimension($col)->setAutoSize(true);
        }
        
        // Sheet 2: Reference Codes
        $refSheet = $spreadsheet->createSheet();
        $refSheet->setTitle('Referensi Kode');
        
        // Style Reference Headers
        $refHeaderStyle = [
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => '0284C7'], // Blue header for reference
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
        ];

        // Units
        $refSheet->setCellValue('A1', 'REFERENSI KODE UNIT');
        $refSheet->mergeCells('A1:B1');
        $refSheet->getStyle('A1:B1')->applyFromArray($refHeaderStyle);
        $refSheet->setCellValue('A2', 'KODE');
        $refSheet->setCellValue('B2', 'NAMA UNIT');
        $refSheet->getStyle('A2:B2')->getFont()->setBold(true);
        $units = \App\Models\Unit::where('kode_unit', '!=', 'U00')->orderBy('kode_unit')->get();
        $row = 3;
        foreach ($units as $u) {
            $refSheet->setCellValue('A' . $row, $u->kode_unit);
            $refSheet->setCellValue('B' . $row, $u->nama_unit);
            $row++;
        }
        $maxRowUnit = $row - 1;
        $refSheet->getStyle('A2:B' . $maxRowUnit)->applyFromArray($borderStyle);
        
        // Departments
        $refSheet->setCellValue('D1', 'REFERENSI KODE DEPARTEMEN');
        $refSheet->mergeCells('D1:E1');
        $refSheet->getStyle('D1:E1')->applyFromArray($refHeaderStyle);
        $refSheet->setCellValue('D2', 'KODE');
        $refSheet->setCellValue('E2', 'NAMA DEPARTEMEN');
        $refSheet->getStyle('D2:E2')->getFont()->setBold(true);
        $depts = \App\Models\Departemen::orderBy('kode_dept')->get();
        $row = 3;
        foreach ($depts as $d) {
            $refSheet->setCellValue('D' . $row, $d->kode_dept);
            $refSheet->setCellValue('E' . $row, $d->nama_dept);
            $row++;
        }
        $maxRowDept = $row - 1;
        $refSheet->getStyle('D2:E' . $maxRowDept)->applyFromArray($borderStyle);
        
        // Jabatans
        $refSheet->setCellValue('G1', 'REFERENSI KODE JABATAN');
        $refSheet->mergeCells('G1:H1');
        $refSheet->getStyle('G1:H1')->applyFromArray($refHeaderStyle);
        $refSheet->setCellValue('G2', 'KODE');
        $refSheet->setCellValue('H2', 'NAMA JABATAN');
        $refSheet->getStyle('G2:H2')->getFont()->setBold(true);
        $jabs = \App\Models\Jabatan::orderBy('kode_jabatan')->where('kode_jabatan', '!=', 'J00')->get();
        $row = 3;
        foreach ($jabs as $j) {
            $refSheet->setCellValue('G' . $row, $j->kode_jabatan);
            $refSheet->setCellValue('H' . $row, $j->nama_jabatan);
            $row++;
        }
        $maxRowJab = $row - 1;
        $refSheet->getStyle('G2:H' . $maxRowJab)->applyFromArray($borderStyle);
        
        foreach (range('A', 'H') as $col) {
            $refSheet->getColumnDimension($col)->setAutoSize(true);
        }
        
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="format_import_jobdesk.xlsx"');
        header('Cache-Control: max-age=0');
        
        $writer->save('php://output');
        exit;
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        try {
            $file = $request->file('file');
            $import = new \App\Imports\JobdeskImport();
            \Maatwebsite\Excel\Facades\Excel::import($import, $file);

            return redirect()->back()->with(messageSuccess('Berhasil mengimpor ' . $import->successCount . ' data jobdesk.'));
        } catch (\Exception $e) {
            if (isset($import) && !empty($import->errors)) {
                return redirect()->back()->with(messageError('Gagal mengimpor. Masalah validasi:<br>' . implode('<br>', $import->errors)));
            }
            return redirect()->back()->with(messageError('Gagal mengimpor file: ' . $e->getMessage()));
        }
    }
}
