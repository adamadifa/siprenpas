<?php

namespace Database\Seeders;

use App\Models\Permission_group;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class WebsiteUpdatePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = Role::findById(1); // Super Admin

        // 1. Testimoni
        $groupTestimoni = Permission_group::firstOrCreate(['name' => 'Testimoni']);
        $permissionsTestimoni = [
            'testimonials.index',
            'testimonials.create',
            'testimonials.edit',
            'testimonials.delete',
        ];
        foreach ($permissionsTestimoni as $p) {
            Permission::firstOrCreate(['name' => $p, 'id_permission_group' => $groupTestimoni->id]);
            $role->givePermissionTo($p);
        }

        // 2. Pilar Pendidikan
        $groupPilar = Permission_group::firstOrCreate(['name' => 'Pilar Pendidikan']);
        $permissionsPilar = [
            'pilarpendidikan.index',
            'pilarpendidikan.create',
            'pilarpendidikan.edit',
            'pilarpendidikan.delete',
        ];
        foreach ($permissionsPilar as $p) {
            Permission::firstOrCreate(['name' => $p, 'id_permission_group' => $groupPilar->id]);
            $role->givePermissionTo($p);
        }

        // 3. Sebaran Alumni
        $groupAlumni = Permission_group::firstOrCreate(['name' => 'Sebaran Alumni']);
        $permissionsAlumni = [
            'sebaran-alumni.index',
            'sebaran-alumni.create',
            'sebaran-alumni.edit',
            'sebaran-alumni.delete',
        ];
        foreach ($permissionsAlumni as $p) {
            Permission::firstOrCreate(['name' => $p, 'id_permission_group' => $groupAlumni->id]);
            $role->givePermissionTo($p);
        }

        // 4. Gallery
        $groupGallery = Permission_group::firstOrCreate(['name' => 'Gallery']);
        $permissionsGallery = [
            'gallery.index',
            'gallery.create',
            'gallery.edit',
            'gallery.delete',
        ];
        foreach ($permissionsGallery as $p) {
            Permission::firstOrCreate(['name' => $p, 'id_permission_group' => $groupGallery->id]);
            $role->givePermissionTo($p);
        }

        // 5. Visi & Misi
        $groupVisiMisi = Permission_group::firstOrCreate(['name' => 'Visi & Misi']);
        $permissionsVisiMisi = [
            'visimisi.index',
            'visimisi.store',
            'visimisi.update',
            'visimisi.delete',
        ];
        foreach ($permissionsVisiMisi as $p) {
            Permission::firstOrCreate(['name' => $p, 'id_permission_group' => $groupVisiMisi->id]);
            $role->givePermissionTo($p);
        }
    }
}
