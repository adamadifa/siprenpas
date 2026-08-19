<?php

namespace Database\Seeders;

use App\Models\Permission_group;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class Agendakegiatanpermissionseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissiongroup = Permission_group::firstOrCreate([
            'name' => 'Agenda Kegiatan'
        ]);

        Permission::updateOrCreate([
            'name' => 'agendakegiatan.index'
        ], [
            'id_permission_group' => $permissiongroup->id
        ]);

        Permission::updateOrCreate([
            'name' => 'agendakegiatan.create'
        ], [
            'id_permission_group' => $permissiongroup->id
        ]);

        Permission::updateOrCreate([
            'name' => 'agendakegiatan.edit'
        ], [
            'id_permission_group' => $permissiongroup->id
        ]);

        Permission::updateOrCreate([
            'name' => 'agendakegiatan.store'
        ], [
            'id_permission_group' => $permissiongroup->id
        ]);

        Permission::updateOrCreate([
            'name' => 'agendakegiatan.update'
        ], [
            'id_permission_group' => $permissiongroup->id
        ]);

        Permission::updateOrCreate([
            'name' => 'agendakegiatan.delete'
        ], [
            'id_permission_group' => $permissiongroup->id
        ]);

        $permissions = Permission::where('id_permission_group', $permissiongroup->id)->get();
        $roleID = 1;
        $role = Role::findById($roleID);
        $role->givePermissionTo($permissions);
    }
}
