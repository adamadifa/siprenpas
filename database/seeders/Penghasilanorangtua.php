<?php

namespace Database\Seeders;

use App\Models\Penghasilanortu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Penghasilanorangtua extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Penghasilanortu::firstOrCreate([
            'kode_penghasilan_ortu' => 'PO01',
            'penghasilan' => '<= 500.000'
        ]);

        Penghasilanortu::firstOrCreate([
            'kode_penghasilan_ortu' => 'PO02',
            'penghasilan' => '500.000 - 1.000.000'
        ]);

        Penghasilanortu::firstOrCreate([
            'kode_penghasilan_ortu' => 'PO03',
            'penghasilan' => '1.000.000 - 2.000.000'
        ]);

        Penghasilanortu::firstOrCreate([
            'kode_penghasilan_ortu' => 'PO04',
            'penghasilan' => '<= 2.000.0000 - 3.000.000'
        ]);

        Penghasilanortu::firstOrCreate([
            'kode_penghasilan_ortu' => 'P05',
            'penghasilan' => '3.000.000 - 5.000.000'
        ]);

        Penghasilanortu::firstOrCreate([
            'kode_penghasilan_ortu' => 'PO06',
            'penghasilan' => '<= 5000.000'
        ]);
    }
}
