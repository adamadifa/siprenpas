<?php

namespace Database\Seeders;

use App\Models\Permission_group;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class MigrasiSiswaPermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissiongroup = Permission_group::updateOrCreate(
            ['name' => 'Migrasi Siswa'],
            ['name' => 'Migrasi Siswa']
        );

        $permissions = [
            'migrasi-siswa.index',
            'migrasi-siswa.upload',
            'migrasi-siswa.preview',
            'migrasi-siswa.proses',
            'migrasi-siswa.riwayat',
            'migrasi-siswa.rollback',
        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(
                ['name' => $permission],
                ['id_permission_group' => $permissiongroup->id]
            );
        }

        // Assign to Super Admin (Role ID 1)
        $role = Role::find(1);
        if ($role) {
            $role->givePermissionTo($permissions);
        }
    }
}
