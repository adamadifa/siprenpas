<?php

namespace Database\Seeders;

use App\Models\Permission_group;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class Webpermissionseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissiongroup = Permission_group::firstOrCreate([
            'name' => 'Kategori'
        ]);

        Permission::firstOrCreate([
            'name' => 'kategori.index',
            'id_permission_group' => $permissiongroup->id
        ]);

        Permission::firstOrCreate([
            'name' => 'kategori.create',
            'id_permission_group' => $permissiongroup->id
        ]);

        Permission::firstOrCreate([
            'name' => 'kategori.edit',
            'id_permission_group' => $permissiongroup->id
        ]);




        Permission::firstOrCreate([
            'name' => 'kategori.delete',
            'id_permission_group' => $permissiongroup->id
        ]);


        $permissiongroup = Permission_group::firstOrCreate([
            'name' => 'Post'
        ]);

        Permission::firstOrCreate([
            'name' => 'post.index',
            'id_permission_group' => $permissiongroup->id
        ]);

        Permission::firstOrCreate([
            'name' => 'post.create',
            'id_permission_group' => $permissiongroup->id
        ]);

        Permission::firstOrCreate([
            'name' => 'post.edit',
            'id_permission_group' => $permissiongroup->id
        ]);




        Permission::firstOrCreate([
            'name' => 'post.delete',
            'id_permission_group' => $permissiongroup->id
        ]);


        $permissiongroup = Permission_group::firstOrCreate([
            'name' => 'Pages'
        ]);

        Permission::firstOrCreate([
            'name' => 'pages.index',
            'id_permission_group' => $permissiongroup->id
        ]);

        Permission::firstOrCreate([
            'name' => 'pages.create',
            'id_permission_group' => $permissiongroup->id
        ]);

        Permission::firstOrCreate([
            'name' => 'pages.edit',
            'id_permission_group' => $permissiongroup->id
        ]);



        Permission::firstOrCreate([
            'name' => 'pages.delete',
            'id_permission_group' => $permissiongroup->id
        ]);

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

        $permissions = Permission::where('id_permission_group', $permissiongroup->id)->get();
        $roleID = 1;
        $role = Role::findById($roleID);
        $role->givePermissionTo($permissions);
    }
}
