<?php

namespace Database\Seeders;

use App\Models\Permission_group;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PresensiSiswaPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Membuat permission group untuk presensi siswa
        $permissiongroup = Permission_group::firstOrCreate([
            'name' => 'Presensi Siswa'
        ]);

        // Membuat permissions untuk presensi siswa
        $permissions = [
            'presensisiswa.index',
            'presensisiswa.create',
            'presensisiswa.store',
            'presensisiswa.show',
            'presensisiswa.edit',
            'presensisiswa.update',
            'presensisiswa.delete',
            'presensisiswa.destroy',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'id_permission_group' => $permissiongroup->id
            ]);
        }

        // Memberikan permissions ke role super admin
        $superAdminRole = Role::where('name', 'super admin')->first();
        if ($superAdminRole) {
            $superAdminRole->givePermissionTo($permissions);
        }

        // Memberikan permissions ke role admin
        $adminRole = Role::where('name', 'admin')->first();
        if ($adminRole) {
            $adminRole->givePermissionTo($permissions);
        }

        // Memberikan permissions ke role guru (hanya index, create, store, edit, update)
        $guruRole = Role::where('name', 'guru')->first();
        if ($guruRole) {
            $guruPermissions = [
                'presensisiswa.index',
                'presensisiswa.create',
                'presensisiswa.store',
                'presensisiswa.edit',
                'presensisiswa.update',
            ];
            $guruRole->givePermissionTo($guruPermissions);
        }

        $this->command->info('Presensi Siswa permissions created successfully!');
    }
}
