<?php

namespace Database\Seeders;

use App\Models\Permission_group;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class Asalsekolahpermissionseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissiongroup = Permission_group::firstOrCreate([
            'name' => 'Asal Sekolah'
        ]);

        Permission::firstOrCreate([
            'name' => 'asalsekolah.index',
            'id_permission_group' => $permissiongroup->id
        ]);

        Permission::firstOrCreate([
            'name' => 'asalsekolah.create',
            'id_permission_group' => $permissiongroup->id
        ]);

        Permission::firstOrCreate([
            'name' => 'asalsekolah.edit',
            'id_permission_group' => $permissiongroup->id
        ]);

        Permission::firstOrCreate([
            'name' => 'asalsekolah.store',
            'id_permission_group' => $permissiongroup->id
        ]);

        Permission::firstOrCreate([
            'name' => 'asalsekolah.update',
            'id_permission_group' => $permissiongroup->id
        ]);


        Permission::firstOrCreate([
            'name' => 'asalsekolah.delete',
            'id_permission_group' => $permissiongroup->id
        ]);

        $permissions = Permission::where('id_permission_group', $permissiongroup->id)->get();
        $roleID = 1;
        $role = Role::findById($roleID);
        $role->givePermissionTo($permissions);
    }
}
