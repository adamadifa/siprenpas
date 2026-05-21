<?php

namespace Database\Seeders;

use App\Models\Permission_group;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class Unitpermissionseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissiongroup = Permission_group::firstOrCreate([
            'name' => 'Unit'
        ]);

        Permission::firstOrCreate([
            'name' => 'unit.index',
            'id_permission_group' => $permissiongroup->id
        ]);

        Permission::firstOrCreate([
            'name' => 'unit.create',
            'id_permission_group' => $permissiongroup->id
        ]);

        Permission::firstOrCreate([
            'name' => 'unit.edit',
            'id_permission_group' => $permissiongroup->id
        ]);

        Permission::firstOrCreate([
            'name' => 'unit.store',
            'id_permission_group' => $permissiongroup->id
        ]);

        Permission::firstOrCreate([
            'name' => 'unit.update',
            'id_permission_group' => $permissiongroup->id
        ]);


        Permission::firstOrCreate([
            'name' => 'unit.delete',
            'id_permission_group' => $permissiongroup->id
        ]);

        $permissions = Permission::where('id_permission_group', $permissiongroup->id)->get();
        $roleID = 1;
        $role = Role::findById($roleID);
        $role->givePermissionTo($permissions);
    }
}
