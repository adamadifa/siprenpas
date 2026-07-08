<?php

namespace App\Http\Controllers;

use App\Models\Departemen;
use App\Models\Jabatan;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();
        $query->with('roles');
        $query->leftjoin('unit', 'users.kode_unit', '=', 'unit.kode_unit');
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
            'kode_jabatan' => $isOrangTua ? 'nullable' : 'required'
        ]);

        try {
            $data = [
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
            ];

            if ($request->filled('password')) {
                $data['password'] = bcrypt($request->password);
            }

            if (!$isOrangTua) {
                $data['kode_unit'] = $request->kode_unit;
                $data['kode_dept'] = $request->kode_dept;
                $data['kode_jabatan'] = $request->kode_jabatan;
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
        try {
            User::where('id', $id)->delete();
            return Redirect::back()->with(['success' => 'Data Berhasil Dihapus']);
        } catch (\Exception $e) {
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
}
