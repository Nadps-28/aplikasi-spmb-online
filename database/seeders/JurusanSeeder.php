<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Jurusan;

class JurusanSeeder extends Seeder
{
    public function run()
    {
        $jurusans = [
            ['nama' => 'PPLG', 'biaya_daftar' => 5500000],
            ['nama' => 'Akuntansi', 'biaya_daftar' => 5500000],
            ['nama' => 'Animasi', 'biaya_daftar' => 5500000],
            ['nama' => 'DKV', 'biaya_daftar' => 5500000],
            ['nama' => 'BDP', 'biaya_daftar' => 5500000],
        ];

        foreach ($jurusans as $jurusan) {
            Jurusan::firstOrCreate(['nama' => $jurusan['nama']], $jurusan);
        }
    }
}