<?php

namespace Database\Seeders;

use App\Models\Permission_group;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class JadwalPelajaranPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'jadwalpelajaran.index',
            'jadwalpelajaran.create',
            'jadwalpelajaran.store',
            'jadwalpelajaran.edit',
            'jadwalpelajaran.update',
            'jadwalpelajaran.delete',
        ];

        $permissionGroup = Permission_group::firstOrCreate(['name' => 'akademik']);

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'id_permission_group' => $permissionGroup->id
            ]);
        }

        $role = Role::find(1); // Super Admin
        if ($role) {
            $role->givePermissionTo($permissions);
        }
    }
}
