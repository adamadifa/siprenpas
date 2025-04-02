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
        $permissiongroup = Permission_group::create([
            'name' => 'Kategori'
        ]);

        Permission::create([
            'name' => 'kategori.index',
            'id_permission_group' => $permissiongroup->id
        ]);

        Permission::create([
            'name' => 'kategori.create',
            'id_permission_group' => $permissiongroup->id
        ]);

        Permission::create([
            'name' => 'kategori.edit',
            'id_permission_group' => $permissiongroup->id
        ]);




        Permission::create([
            'name' => 'kategori.delete',
            'id_permission_group' => $permissiongroup->id
        ]);


        $permissiongroup = Permission_group::create([
            'name' => 'Post'
        ]);

        Permission::create([
            'name' => 'post.index',
            'id_permission_group' => $permissiongroup->id
        ]);

        Permission::create([
            'name' => 'post.create',
            'id_permission_group' => $permissiongroup->id
        ]);

        Permission::create([
            'name' => 'post.edit',
            'id_permission_group' => $permissiongroup->id
        ]);




        Permission::create([
            'name' => 'post.delete',
            'id_permission_group' => $permissiongroup->id
        ]);


        $permissiongroup = Permission_group::create([
            'name' => 'Pages'
        ]);

        Permission::create([
            'name' => 'pages.index',
            'id_permission_group' => $permissiongroup->id
        ]);

        Permission::create([
            'name' => 'pages.create',
            'id_permission_group' => $permissiongroup->id
        ]);

        Permission::create([
            'name' => 'pages.edit',
            'id_permission_group' => $permissiongroup->id
        ]);



        Permission::create([
            'name' => 'pages.delete',
            'id_permission_group' => $permissiongroup->id
        ]);






        $permissions = Permission::where('id_permission_group', $permissiongroup->id)->get();
        $roleID = 1;
        $role = Role::findById($roleID);
        $role->givePermissionTo($permissions);
    }
}
