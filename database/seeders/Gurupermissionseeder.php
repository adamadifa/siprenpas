<?php

namespace Database\Seeders;

use App\Models\Permission_group;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class Gurupermissionseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissiongroup = Permission_group::create([
            'name' => 'Guru'
        ]);

        Permission::create([
            'name' => 'guru.index',
            'id_permission_group' => $permissiongroup->id
        ]);

        Permission::create([
            'name' => 'guru.create',
            'id_permission_group' => $permissiongroup->id
        ]);

        Permission::create([
            'name' => 'guru.store',
            'id_permission_group' => $permissiongroup->id
        ]);

        Permission::create([
            'name' => 'guru.edit',
            'id_permission_group' => $permissiongroup->id
        ]);

        Permission::create([
            'name' => 'guru.update',
            'id_permission_group' => $permissiongroup->id
        ]);

        Permission::create([
            'name' => 'guru.delete',
            'id_permission_group' => $permissiongroup->id
        ]);

        $permissions = Permission::where('id_permission_group', $permissiongroup->id)->get();
        $roleID = 1;
        $role = Role::findById($roleID);
        $role->givePermissionTo($permissions);
    }
}
