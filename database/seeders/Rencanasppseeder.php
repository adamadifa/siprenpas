<?php

namespace Database\Seeders;

use App\Models\Permission_group;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class Rencanasppseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $permissiongroup = Permission_group::firstOrCreate([
            'name' => 'Rencana SPP'
        ]);

        Permission::firstOrCreate([
            'name' => 'rencanaspp.index',
            'id_permission_group' => $permissiongroup->id
        ]);

        Permission::firstOrCreate([
            'name' => 'rencanaspp.create',
            'id_permission_group' => $permissiongroup->id
        ]);

        Permission::firstOrCreate([
            'name' => 'rencanaspp.edit',
            'id_permission_group' => $permissiongroup->id
        ]);

        Permission::firstOrCreate([
            'name' => 'rencanaspp.store',
            'id_permission_group' => $permissiongroup->id
        ]);

        Permission::firstOrCreate([
            'name' => 'rencanaspp.update',
            'id_permission_group' => $permissiongroup->id
        ]);


        Permission::firstOrCreate([
            'name' => 'rencanaspp.delete',
            'id_permission_group' => $permissiongroup->id
        ]);

        $permissions = Permission::where('id_permission_group', $permissiongroup->id)->get();
        $roleID = 1;
        $role = Role::findById($roleID);
        $role->givePermissionTo($permissions);
    }
}
