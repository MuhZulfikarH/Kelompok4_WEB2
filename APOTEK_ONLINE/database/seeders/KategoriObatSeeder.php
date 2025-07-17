<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KategoriObat;

class KategoriObatSeeder extends Seeder
{
    public function run(): void
    {
        $kategori = [
            'Tablet',
            'Kapsul',
            'Sirup',
            'Obat Tetes',
            'Salep',
            'Injeksi'
        ];

        foreach ($kategori as $nama) {
            KategoriObat::create(['nama' => $nama]);
        }
    }
}
