<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class PesertaRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Cek jika role sudah ada
        if (!Role::where('name', 'peserta')->exists()) {
            Role::create(['name' => 'peserta']);
        }
    }
}

