<?php

namespace App\Http\Controllers;

use App\Models\Departemen;
use App\Models\Jabatan;
use App\Models\Permission_group;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redirect;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();
        $query->select('users.*', 'unit.nama_unit', 'departemen.nama_dept');
        $query->with(['roles', 'assignedUnits', 'assignedDepartemens']);
        $query->leftjoin('unit', 'users.kode_unit', '=', 'unit.kode_unit');
        $query->leftjoin('departemen', 'users.kode_dept', '=', 'departemen.kode_dept');
        if (!empty($request->name)) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if (!empty($request->role)) {
            if ($request->role === 'lainnya') {
                $query->whereDoesntHave('roles', function($q) {
                    $q->where('name', 'karyawan');
                });
            } else {
                $query->role($request->role);
            }
        }

        if ($request->filled('status')) {
            $statusVal = $request->status === 'aktif' ? 1 : 0;
            $query->where('users.status', $statusVal);
        }

        $users = $query->paginate(20);
        $users->appends($request->all());

        $roles = Role::orderBy('name')->get();

        return view('settings.users.index', compact('users', 'roles'));
    }

    public function create()
    {
        $roles = Role::orderBy('name')->get();
        $unit = Unit::orderBy('kode_unit')->get();
        $jabatan = Jabatan::orderBy('kode_jabatan')->where('kode_jabatan', '!=', 'J00')->get();
        $dept = Departemen::orderBy('kode_dept')->get();
        return view('settings.users.create', compact('roles', 'unit', 'dept', 'jabatan'));
    }

    public function edit($id)
    {
        $id = Crypt::decrypt($id);
        $user = User::with('roles')->where('id', $id)->first();
        $roles = Role::orderBy('name')->get();
        $jabatan = Jabatan::orderBy('kode_jabatan')->where('kode_jabatan', '!=', 'J00')->get();
        $dept = Departemen::orderBy('kode_dept')->get();
        $unit = Unit::orderBy('kode_unit')->get();
        return view('settings.users.edit', compact('user', 'roles', 'unit', 'jabatan', 'dept'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'username' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'role' => 'required',
            'kode_unit' => 'required',
            'kode_dept' => 'required',
            'kode_jabatan' => 'required'
        ]);

        try {
            $user = User::create([
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'password' => $request->password,
                'kode_unit' => $request->kode_unit,
                'kode_dept' => $request->kode_dept,
                'kode_jabatan' => $request->kode_jabatan
            ]);

            $user->assignRole($request->role);
            return Redirect::back()->with(messageSuccess('Data Berhasil Disimpan'));
        } catch (\Exception $e) {
            return Redirect::back()->with(messageError($e->getMessage()));
        }
    }


    public function update($id, Request $request)
    {
        $id = Crypt::decrypt($id);
        $user = User::findorFail($id);


        $isOrangTua = $request->role === 'orang tua';

        $request->validate([
            'name' => 'required',
            'username' => 'required|unique:users,username,' . $id,
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required',
            'kode_unit' => $isOrangTua ? 'nullable' : 'required',
            'kode_dept' => $isOrangTua ? 'nullable' : 'required',
            'kode_jabatan' => $isOrangTua ? 'nullable' : 'required',
            'status' => 'nullable|in:0,1'
        ]);

        try {
            $data = [
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
            ];

            if ($request->has('status')) {
                $data['status'] = $request->status;
            }

            if ($request->filled('password')) {
                $data['password'] = bcrypt($request->password);
            }

            if (!$isOrangTua) {
                $data['kode_unit'] = $request->kode_unit;
                $data['kode_dept'] = $request->kode_dept;
                $data['kode_jabatan'] = $request->kode_jabatan;

                // Sync with karyawan table if exists
                $karyawan = \App\Models\Karyawan::where('npp', $user->npp)->first();
                if ($karyawan) {
                    $karyawan->update([
                        'kode_unit' => $request->kode_unit,
                        'kode_dept' => $request->kode_dept,
                        'kode_jabatan' => $request->kode_jabatan
                    ]);
                }
            }

            $user->update($data);

            if (isset($request->role)) {
                $user->syncRoles([$request->role]);
            }

            return Redirect::back()->with(['success' => 'Data Berhasil Disimpan']);
        } catch (\Exception $e) {
            return Redirect::back()->with(['error' => $e->getMessage()]);
        }
    }


    public function destroy($id)
    {
        $id = Crypt::decrypt($id);
        \Illuminate\Support\Facades\DB::beginTransaction();
        try {
            User::where('id', $id)->delete();
            \App\Models\Userkaryawan::where('id_user', $id)->delete();
            \Illuminate\Support\Facades\DB::commit();
            return Redirect::back()->with(['success' => 'Data Berhasil Dihapus']);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            return Redirect::back()->with(['error' => $e->getMessage()]);
        }
    }


    public function editpassword($id)
    {
        $id = Crypt::decrypt($id);
        $user = User::where('id', $id)->first();
        return view('settings.users.editpassword', compact('user'));
    }

    public function updatepassword(Request $request, $id)
    {
        $id = Crypt::decrypt($id);
        $request->validate([
            'passwordbaru' => 'required',
            'konfirmasipassword' => 'required|same:passwordbaru'
        ]);
        try {
            User::where('id', $id)->update([
                'password' => Hash::make($request->passwordbaru)
            ]);
            return Redirect::back()->with(['success' => 'Password Berhasil Diubah']);
        } catch (\Exception $e) {
            return Redirect::back()->with(['error' => $e->getMessage()]);
        }
    }

    public function updatestatus($id)
    {
        $id = Crypt::decrypt($id);
        $user = User::findOrFail($id);
        if ($user->status == 1) {
            $user->status = 0;
        } else {
            $user->status = 1;
        }
        $user->save();
        return Redirect::back()->with(messageSuccess('Status Berhasil Diubah'));
    }

    public function impersonate($id)
    {
        $id = Crypt::decrypt($id);
        
        if (!auth()->user()->hasRole('super admin')) {
            abort(403, 'Unauthorized action.');
        }

        if (auth()->id() == $id) {
            return Redirect::back()->with(['error' => 'Tidak bisa melakukan View As ke diri sendiri.']);
        }

        session(['impersonator_id' => auth()->id()]);
        \Illuminate\Support\Facades\Auth::loginUsingId($id);

        return redirect()->route('dashboard.index')->with(['success' => 'Anda sekarang masuk sebagai ' . auth()->user()->name]);
    }

    public function stopImpersonate()
    {
        if (!session()->has('impersonator_id')) {
            return redirect()->route('dashboard.index');
        }

        $adminId = session()->pull('impersonator_id');
        \Illuminate\Support\Facades\Auth::loginUsingId($adminId);

        return redirect()->route('users.index')->with(['success' => 'Kembali ke Admin Utama']);
    }

    public function createuserpermission($id)
    {
        $id = Crypt::decrypt($id);
        $user = User::with(['roles.permissions', 'permissions'])->findOrFail($id);

        $permissions = Permission_group::with(['permissions' => function ($q) {
            $q->orderBy('name');
        }])->has('permissions')->orderBy('id')->get();

        // Permissions inherited from roles (read-only/locked)
        $rolePermissions = $user->getPermissionsViaRoles()->pluck('name')->unique()->toArray();

        // Direct permissions assigned specifically to this user
        $directPermissions = $user->getDirectPermissions()->pluck('name')->toArray();

        return view('settings.users.create_user_permission', compact(
            'user',
            'permissions',
            'rolePermissions',
            'directPermissions'
        ));
    }

    public function storeuserpermission($id, Request $request)
    {
        $id = Crypt::decrypt($id);
        $user = User::findOrFail($id);

        try {
            $inputPermissions = $request->input('permission', []);

            // Role permissions already granted via roles
            $rolePermissions = $user->getPermissionsViaRoles()->pluck('name')->unique()->toArray();

            // We only save permissions that are NOT already in the role
            $directPermissionsToSync = array_values(array_diff($inputPermissions, $rolePermissions));
            $user->syncPermissions($directPermissionsToSync);

            return Redirect::back()->with(messageSuccess('Hak Akses Khusus User Berhasil Disimpan'));
        } catch (\Exception $e) {
            return Redirect::back()->with(messageError($e->getMessage()));
        }
    }

    public function createuserunitdept($id)
    {
        $id = Crypt::decrypt($id);
        $user = User::with(['assignedUnits', 'assignedDepartemens'])->findOrFail($id);

        // All active units except undefined
        $allUnits = Unit::where('kode_unit', '!=', 'U00')->orderBy('kode_unit')->get();
        $defaultUnit = $user->kode_unit;
        $assignedUnitCodes = $user->assignedUnits->pluck('kode_unit')->toArray();

        // All active departments
        $allDepts = Departemen::orderBy('kode_dept')->get();
        $defaultDept = $user->kode_dept;
        $assignedDeptCodes = $user->assignedDepartemens->pluck('kode_dept')->toArray();

        return view('settings.users.create_user_unit_dept', compact(
            'user',
            'allUnits',
            'defaultUnit',
            'assignedUnitCodes',
            'allDepts',
            'defaultDept',
            'assignedDeptCodes'
        ));
    }

    public function storeuserunitdept($id, Request $request)
    {
        $id = Crypt::decrypt($id);
        $user = User::findOrFail($id);

        try {
            // 1. Sync Assigned Units (Extra Units beyond default unit)
            $inputUnits = $request->input('unit_access', []);
            $defaultUnit = $user->kode_unit;
            $extraUnitsToSync = array_values(array_filter($inputUnits, function ($code) use ($defaultUnit) {
                return $code !== $defaultUnit && !empty($code);
            }));
            $user->assignedUnits()->sync($extraUnitsToSync);

            // 2. Sync Assigned Departemens (Extra Departemens beyond default dept)
            $inputDepts = $request->input('dept_access', []);
            $defaultDept = $user->kode_dept;
            $extraDeptsToSync = array_values(array_filter($inputDepts, function ($code) use ($defaultDept) {
                return $code !== $defaultDept && !empty($code);
            }));
            $user->assignedDepartemens()->sync($extraDeptsToSync);

            return Redirect::back()->with(messageSuccess('Hak Akses Data Unit & Departemen Berhasil Disimpan'));
        } catch (\Exception $e) {
            return Redirect::back()->with(messageError($e->getMessage()));
        }
    }
}
