<?php

namespace Database\Seeders;

use App\Models\Permission_group;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class MesinFingerprintPermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissiongroup = Permission_group::updateOrCreate(
            ['name' => 'Mesin Fingerprint'],
            ['name' => 'Mesin Fingerprint']
        );

        $permissions = [
            'mesinfingerprint.index',
            'mesinfingerprint.create',
            'mesinfingerprint.store',
            'mesinfingerprint.edit',
            'mesinfingerprint.update',
            'mesinfingerprint.delete',
            'mesinfingerprint.logmesin',
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
