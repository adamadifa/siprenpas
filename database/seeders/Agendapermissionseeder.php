<?php

namespace Database\Seeders;

use App\Models\Permission_group;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class Agendapermissionseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissiongroup = Permission_group::firstOrCreate([
            'name' => 'Agenda'
        ]);

        $permissions = [
            'agenda.index',
            'agenda.create',
            'agenda.edit',
            'agenda.store',
            'agenda.update',
            'agenda.delete',
        ];

        foreach ($permissions as $p) {
            Permission::updateOrCreate([
                'name' => $p
            ], [
                'id_permission_group' => $permissiongroup->id
            ]);
        }

        // Assign to Super Admin
        $roleSuperAdmin = Role::where('name', 'super admin')->first();
        if ($roleSuperAdmin) {
            $roleSuperAdmin->givePermissionTo($permissions);
        }

        // Assign to Karyawan
        $roleKaryawan = Role::where('name', 'karyawan')->first();
        if ($roleKaryawan) {
            $roleKaryawan->givePermissionTo(['agenda.index']);
        }
    }
}
