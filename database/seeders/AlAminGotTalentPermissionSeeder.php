<?php

namespace Database\Seeders;

use App\Models\Permission_group;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AlAminGotTalentPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Permission Group untuk Perlombaan
        $permissiongroupPerlombaan = Permission_group::firstOrCreate([
            'name' => 'Perlombaan'
        ]);

        Permission::firstOrCreate([
            'name' => 'perlombaan.index',
            'id_permission_group' => $permissiongroupPerlombaan->id
        ]);

        Permission::firstOrCreate([
            'name' => 'perlombaan.create',
            'id_permission_group' => $permissiongroupPerlombaan->id
        ]);

        Permission::firstOrCreate([
            'name' => 'perlombaan.edit',
            'id_permission_group' => $permissiongroupPerlombaan->id
        ]);

        Permission::firstOrCreate([
            'name' => 'perlombaan.store',
            'id_permission_group' => $permissiongroupPerlombaan->id
        ]);

        Permission::firstOrCreate([
            'name' => 'perlombaan.update',
            'id_permission_group' => $permissiongroupPerlombaan->id
        ]);

        Permission::firstOrCreate([
            'name' => 'perlombaan.delete',
            'id_permission_group' => $permissiongroupPerlombaan->id
        ]);

        // Permission Group untuk Pendaftaran (Al Amin Got Talent)
        $permissiongroupPendaftaran = Permission_group::firstOrCreate([
            'name' => 'Pendaftaran Got Talent'
        ]);

        Permission::firstOrCreate([
            'name' => 'pendaftarangottalent.index',
            'id_permission_group' => $permissiongroupPendaftaran->id
        ]);

        Permission::firstOrCreate([
            'name' => 'pendaftarangottalent.create',
            'id_permission_group' => $permissiongroupPendaftaran->id
        ]);

        Permission::firstOrCreate([
            'name' => 'pendaftarangottalent.edit',
            'id_permission_group' => $permissiongroupPendaftaran->id
        ]);

        Permission::firstOrCreate([
            'name' => 'pendaftarangottalent.store',
            'id_permission_group' => $permissiongroupPendaftaran->id
        ]);

        Permission::firstOrCreate([
            'name' => 'pendaftarangottalent.update',
            'id_permission_group' => $permissiongroupPendaftaran->id
        ]);

        Permission::firstOrCreate([
            'name' => 'pendaftarangottalent.delete',
            'id_permission_group' => $permissiongroupPendaftaran->id
        ]);

        // Permission Group untuk Jenjang Pendidikan
        $permissiongroupJenjangPendidikan = Permission_group::firstOrCreate([
            'name' => 'Jenjang Pendidikan'
        ]);

        Permission::firstOrCreate([
            'name' => 'jenjangpendidikan.index',
            'id_permission_group' => $permissiongroupJenjangPendidikan->id
        ]);

        Permission::firstOrCreate([
            'name' => 'jenjangpendidikan.create',
            'id_permission_group' => $permissiongroupJenjangPendidikan->id
        ]);

        Permission::firstOrCreate([
            'name' => 'jenjangpendidikan.edit',
            'id_permission_group' => $permissiongroupJenjangPendidikan->id
        ]);

        Permission::firstOrCreate([
            'name' => 'jenjangpendidikan.store',
            'id_permission_group' => $permissiongroupJenjangPendidikan->id
        ]);

        Permission::firstOrCreate([
            'name' => 'jenjangpendidikan.update',
            'id_permission_group' => $permissiongroupJenjangPendidikan->id
        ]);

        Permission::firstOrCreate([
            'name' => 'jenjangpendidikan.delete',
            'id_permission_group' => $permissiongroupJenjangPendidikan->id
        ]);

        // Memberikan semua permission ke role dengan ID 1 (super admin)
        $permissionsPerlombaan = Permission::where('id_permission_group', $permissiongroupPerlombaan->id)->get();
        $permissionsPendaftaran = Permission::where('id_permission_group', $permissiongroupPendaftaran->id)->get();
        $permissionsJenjangPendidikan = Permission::where('id_permission_group', $permissiongroupJenjangPendidikan->id)->get();

        $roleID = 1;
        $role = Role::findById($roleID);
        $role->givePermissionTo($permissionsPerlombaan);
        $role->givePermissionTo($permissionsPendaftaran);
        $role->givePermissionTo($permissionsJenjangPendidikan);
    }
}
