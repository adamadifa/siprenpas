<?php

namespace Database\Seeders;

use App\Models\Permission_group;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PilarPendidikanPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissionGroup = Permission_group::firstOrCreate([
            'name' => 'Pilar Pendidikan',
        ]);

        $permissions = collect([
            'pilarpendidikan.index',
            'pilarpendidikan.create',
            'pilarpendidikan.edit',
            'pilarpendidikan.delete',
        ])->map(function ($name) use ($permissionGroup) {
            return Permission::firstOrCreate([
                'name' => $name,
                'id_permission_group' => $permissionGroup->id,
            ]);
        });

        $role = Role::findById(1);
        $role->givePermissionTo($permissions);
    }
}
