<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Jobdesk;
use Illuminate\Http\Request;

class JobdeskController extends Controller
{
    public function index(Request $request)
    {
        try {
            $user = $request->user();
            
            $query = Jobdesk::query();
            $query->select(
                'jobdesk.kode_jobdesk',
                'jobdesk.jobdesk',
                'jobdesk_group.kode_dept',
                'jobdesk_group.kode_jabatan',
                'jobdesk_group.kode_unit',
                'departemen.nama_dept',
                'jabatan.nama_jabatan',
                'unit.nama_unit'
            );
            $query->join('jobdesk_group', 'jobdesk.kode_jobdesk_group', '=', 'jobdesk_group.kode_jobdesk_group');
            $query->join('departemen', 'jobdesk_group.kode_dept', '=', 'departemen.kode_dept');
            $query->join('jabatan', 'jobdesk_group.kode_jabatan', '=', 'jabatan.kode_jabatan');
            $query->leftJoin('unit', 'jobdesk_group.kode_unit', '=', 'unit.kode_unit');

            // Filter by user's active configuration
            $query->where('jobdesk_group.kode_jabatan', $user->kode_jabatan);
            $query->where('jobdesk_group.kode_dept', $user->kode_dept);
            if (!empty($user->kode_unit)) {
                $query->where('jobdesk_group.kode_unit', $user->kode_unit);
            }

            if (!empty($request->search)) {
                $query->where('jobdesk.jobdesk', 'like', '%' . $request->search . '%');
            }

            $jobdesks = $query->orderBy('jobdesk.kode_jobdesk', 'asc')->get();

            return response()->json([
                'success' => true,
                'data' => $jobdesks
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
