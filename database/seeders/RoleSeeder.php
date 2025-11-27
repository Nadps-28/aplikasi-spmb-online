<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run()
    {
        $roles = [
            'Calon Siswa',
            'Admin Panitia',
            'Verifikator Administrasi',
            'Keuangan',
            'Kepala Sekolah'
        ];

        foreach ($roles as $role) {
            Role::create(['name' => $role]);
        }
    }
}