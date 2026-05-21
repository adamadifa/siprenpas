<?php

namespace Database\Seeders;

use App\Models\Permission_group;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class Pengumumanpermissionseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissiongroup = Permission_group::firstOrCreate([
            'name' => 'Pengumuman'
        ]);

        $permissions = [
            'pengumuman.index',
            'pengumuman.create',
            'pengumuman.store',
            'pengumuman.show',
            'pengumuman.edit',
            'pengumuman.update',
            'pengumuman.delete',
            'pengumuman.destroy',
            'kategori-pengumuman.index',
            'kategori-pengumuman.create',
            'kategori-pengumuman.store',
            'kategori-pengumuman.show',
            'kategori-pengumuman.edit',
            'kategori-pengumuman.update',
            'kategori-pengumuman.delete',
            'kategori-pengumuman.destroy',
            'push-subscriptions.index',
            'push-subscriptions.destroy',
        ];

        foreach ($permissions as $permissionName) {
            Permission::firstOrCreate([
                'name' => $permissionName,
                'id_permission_group' => $permissiongroup->id
            ]);
        }

        // Ambil semua permission yang baru dibuat
        $allPermissions = Permission::where('id_permission_group', $permissiongroup->id)->get();

        // Cari role yang akan diberikan hak akses manajemen pengumuman
        $targetRoles = ['super admin', 'admin', 'admin unit', 'admin tu', 'pimpinan pesantren', 'sekretaris'];
        foreach ($targetRoles as $roleName) {
            $role = Role::where('name', $roleName)->first();
            if ($role) {
                $role->givePermissionTo($allPermissions);
            }
        }
    }
}
