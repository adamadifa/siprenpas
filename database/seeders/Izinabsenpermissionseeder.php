<?php

namespace Database\Seeders;

use App\Models\Izinabsen;
use App\Models\Permission_group;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Crypt;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class Izinabsenpermissionseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissiongroup = Permission_group::firstOrCreate(
            ['name' => 'Izin Absen']
        );

        Permission::firstOrCreate(
            ['name' => 'izinabsen.index'],
            ['id_permission_group' => $permissiongroup->id]
        );

        Permission::firstOrCreate(
            ['name' => 'izinabsen.create'],
            ['id_permission_group' => $permissiongroup->id]
        );

        Permission::firstOrCreate(
            ['name' => 'izinabsen.edit'],
            ['id_permission_group' => $permissiongroup->id]
        );

        Permission::firstOrCreate(
            ['name' => 'izinabsen.delete'],
            ['id_permission_group' => $permissiongroup->id]
        );

        Permission::firstOrCreate(
            ['name' => 'izinabsen.approve'],
            ['id_permission_group' => $permissiongroup->id]
        );


        $permissions = Permission::where('id_permission_group', $permissiongroup->id)->get();
        $roleID = 1;
        $role = Role::findById($roleID);
        $role->givePermissionTo($permissions);
    }
}
