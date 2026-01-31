<?php

namespace Database\Seeders;

use App\Models\Permission_group;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class MataPelajaranPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissiongroup = Permission_group::create([
            'name' => 'Mata Pelajaran'
        ]);

        Permission::create([
            'name' => 'matapelajaran.index',
            'id_permission_group' => $permissiongroup->id
        ]);

        Permission::create([
            'name' => 'matapelajaran.create',
            'id_permission_group' => $permissiongroup->id
        ]);

        Permission::create([
            'name' => 'matapelajaran.store',
            'id_permission_group' => $permissiongroup->id
        ]);

        Permission::create([
            'name' => 'matapelajaran.edit',
            'id_permission_group' => $permissiongroup->id
        ]);

        Permission::create([
            'name' => 'matapelajaran.update',
            'id_permission_group' => $permissiongroup->id
        ]);

        Permission::create([
            'name' => 'matapelajaran.delete',
            'id_permission_group' => $permissiongroup->id
        ]);

        $permissions = Permission::where('id_permission_group', $permissiongroup->id)->get();
        $roleID = 1; // Super Admin
        $role = Role::findById($roleID);
        $role->givePermissionTo($permissions);
    }
}
