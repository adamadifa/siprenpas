<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Ensure all default roles exist
        $roles = [
            'super admin',
            'admin',
            'admin unit',
            'admin tu',
            'pimpinan pesantren',
            'sekretaris',
            'guru',
            'karyawan',
            'ketua koperasi',
            'peserta',
            'orang tua',
            'pendaftar',
        ];

        foreach ($roles as $roleName) {
            \Spatie\Permission\Models\Role::firstOrCreate([
                'name' => $roleName,
                'guard_name' => 'web'
            ]);
        }

        $seeders = [
            Agendakegiatanpermissionseeder::class,
            AkademikSiswapermissionseeder::class,
            AlAminGotTalentPermissionSeeder::class,
            Anggotapermissionseeder::class,
            Asalsekolahpermissionseeder::class,
            Biayapermissionseeder::class,
            Defaultsettingpermissionseeder::class,
            Departemenpermissionseeder::class,
            Gurupermissionseeder::class,
            Izinabsenpermissionseeder::class,
            Izinsakitpermissionseeder::class,
            JabatanAkademikpermissionseeder::class,
            Jabatanpermissionseeder::class,
            JadwalPelajaranPermissionSeeder::class,
            Jamkerjapermissionseeder::class,
            Jenibiayapermissionseeder::class,
            Jenispembiayaanpermissionseeder::class,
            Jenissimpananpermissionseeder::class,
            Jenistabunganpermissionseeder::class,
            Jobdeskpermissionseeder::class,
            Karyawanpermissionseeder::class,
            Kategoriibadahpermissionseeder::class,
            Kategoripemasukanpermissionseeder::class,
            Kategoripengeluaranpermissionseeder::class,
            Kegiatanibadahpermissionseeder::class,
            Kelaspermissionseeder::class,
            KuisionerPermissionSeeder::class,
            Laporankeuanganpermissionseeder::class,
            Ledgerpermissionseeder::class,
            MataPelajaranPermissionSeeder::class,
            MesinFingerprintPermissionSeeder::class,
            MigrasiSiswaPermissionSeeder::class,
            Pembayaranpendidikanpermissionseeder::class,
            Pembiayaanpermissionseeder::class,
            Pendaftaranonlinepermissionseeder::class,
            Pendaftaranpermissionseeder::class,
            Pengaturanumumpermissionseeder::class,
            Pengumumanpermissionseeder::class,
            PilarPendidikanPermissionSeeder::class,
            PresensiSiswaPermissionSeeder::class,
            Presensipermissionseeder::class,
            PrestasiSiswaPermissionSeeder::class,
            ProgramUnggulanPermissionSeeder::class,
            ProgramUnggulanSeeder::class,
            PesertaRoleSeeder::class,
            Programkerjapermissionseeder::class,
            Realisasikegiatanpermissionseeder::class,
            Saldoawalpermissiosneeder::class,
            Simpananpermissionseeder::class,
            Siswapermissionseeder::class,
            Sumberdanapermissionseeder::class,
            Tabunganpermissionseeder::class,
            Tahunajaranpermissionseeder::class,
            Tahunajaranppdbpermissionseeder::class,
            TestimonialPermissionSeeder::class,
            Transaksiledgerpermissionseeder::class,
            Unitpermissionseeder::class,
            Webpermissionseeder::class,
            WebsiteUpdatePermissionSeeder::class,
        ];

        foreach ($seeders as $seeder) {
            try {
                $this->call($seeder);
            } catch (\Throwable $e) {
                if ($this->isDuplicateException($e)) {
                    if (isset($this->command)) {
                        $this->command->warn("Seeder " . class_basename($seeder) . " skipped: permissions/records already exist.");
                    }
                } else {
                    throw $e;
                }
            }
        }
    }

    private function isDuplicateException(\Throwable $e): bool
    {
        $message = strtolower($e->getMessage());
        return str_contains($message, 'duplicate') ||
               str_contains($message, 'already exists') ||
               $e->getCode() === '23000' ||
               $e->getCode() === 23000;
    }
}
