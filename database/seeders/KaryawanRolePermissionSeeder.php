<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class KaryawanRolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = Role::where('name', 'karyawan')->first();
        if (!$role) {
            $role = Role::create(['name' => 'karyawan', 'guard_name' => 'web']);
        }

        // Assign permissions for Kegiatan, Program Kerja, Jobdesk, Realisasi Kegiatan, and Agenda Kegiatan
        $permissions = [
            // Jobdesk
            'jobdesk.index',
            'jobdesk.create',
            'jobdesk.edit',
            'jobdesk.store',
            'jobdesk.update',
            'jobdesk.delete',
            
            // Program Kerja
            'programkerja.index',
            'programkerja.create',
            'programkerja.edit',
            'programkerja.delete',
            
            // Realisasi Kegiatan
            'realkegiatan.index',
            'realkegiatan.create',
            'realkegiatan.edit',
            'realkegiatan.store',
            'realkegiatan.update',
            'realkegiatan.delete',
            
            // Agenda Kegiatan
            'agendakegiatan.index',
            'agendakegiatan.create',
            'agendakegiatan.edit',
            'agendakegiatan.store',
            'agendakegiatan.update',
            'agendakegiatan.delete',
        ];

        // Revoke first to make it a clean sync
        $role->syncPermissions([]);

        // Give permissions to role
        foreach ($permissions as $permissionName) {
            $permission = Permission::where('name', $permissionName)->first();
            if ($permission) {
                $role->givePermissionTo($permission);
            }
        }
    }
}
