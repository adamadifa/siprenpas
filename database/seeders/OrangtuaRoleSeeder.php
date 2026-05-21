<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class OrangtuaRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Cek jika role sudah ada
        if (!Role::where('name', 'orang tua')->exists()) {
            Role::firstOrCreate(['name' => 'orang tua']);
        }
    }
}
