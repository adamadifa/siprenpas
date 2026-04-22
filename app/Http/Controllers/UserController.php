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
        $users = $query->paginate(20);
        $users->appends($request->all());
        return view('settings.users.index', compact('users'));
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


        $request->validate([
            'name' => 'required',
            'username' => 'required',
            'email' => 'required|email',
            'kode_unit' => 'required',
            'kode_dept' => 'required',
            'role' => 'required',
            'kode_jabatan' => 'required'
        ]);

        try {

            if (isset($request->password)) {
                User::where('id', $id)->update([
                    'name' => $request->name,
                    'username' => $request->username,
                    'email' => $request->email,
                    'password' => bcrypt($request->password),
                    'kode_unit' => $request->kode_unit,
                    'kode_dept' => $request->kode_dept,
                    'kode_jabatan' => $request->kode_jabatan
                ]);
            } else {
                User::where('id', $id)->update([
                    'name' => $request->name,
                    'username' => $request->username,
                    'email' => $request->email,
                    'kode_unit' => $request->kode_unit,
                    'kode_dept' => $request->kode_dept,
                    'kode_jabatan' => $request->kode_jabatan
                ]);
            }

            if (isset($request->role)) {
                $user->syncRoles([]);
                $user->assignRole($request->role);
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
