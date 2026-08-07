<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\Permission_group;

class AdminUnitAkademikPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Temukan atau buat role 'admin unit'
        $role = Role::firstOrCreate(['name' => 'admin unit', 'guard_name' => 'web']);

        // Nama-nama grup permission akademik
        $academicGroupNames = [
            'Guru',
            'Akademik Siswa',
            'Jabatan Akademik',
            'Presensi Siswa',
            'Mata Pelajaran',
            'Kelas',
            'akademik' // untuk jadwal pelajaran
        ];

        // Ambil ID dari grup-grup tersebut
        $groupIds = Permission_group::whereIn('name', $academicGroupNames)
            ->pluck('id')
            ->toArray();

        if (!empty($groupIds)) {
            // Ambil semua permission yang berasosiasi dengan grup-grup tersebut
            $permissions = Permission::whereIn('id_permission_group', $groupIds)->get();

            if ($permissions->isNotEmpty()) {
                $role->givePermissionTo($permissions);
                $this->command->info('Berhasil memberikan ' . $permissions->count() . ' hak akses akademik ke role "admin unit".');
            } else {
                $this->command->warn('Tidak ada permission yang ditemukan untuk grup akademik tersebut.');
            }
        } else {
            $this->command->warn('Grup permission akademik tidak ditemukan.');
        }
    }
}
