<?php

namespace Database\Seeders;

use App\Models\Permission_group;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class TestimonialPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissiongroup = Permission_group::firstOrCreate([
            'name' => 'Testimoni'
        ]);

        Permission::firstOrCreate([
            'name' => 'testimonials.index',
            'id_permission_group' => $permissiongroup->id
        ]);

        Permission::firstOrCreate([
            'name' => 'testimonials.create',
            'id_permission_group' => $permissiongroup->id
        ]);

        Permission::firstOrCreate([
            'name' => 'testimonials.edit',
            'id_permission_group' => $permissiongroup->id
        ]);

        Permission::firstOrCreate([
            'name' => 'testimonials.delete',
            'id_permission_group' => $permissiongroup->id
        ]);

        // Berikan permission ke role super admin
        $permissions = Permission::where('id_permission_group', $permissiongroup->id)->get();
        $roleID = 1;
        $role = Role::findById($roleID);
        $role->givePermissionTo($permissions);
    }
}
