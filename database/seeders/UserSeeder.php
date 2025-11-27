<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        $roles = Role::all()->keyBy('name');
        
        $users = [
            [
                'name' => 'Admin Panitia',
                'email' => 'admin@smkbaktinusantara666.sch.id',
                'password' => Hash::make('admin123'),
                'phone' => '081234567890',
                'nisn' => '1234567890',
                'nik' => '1234567890123456',
                'role_id' => $roles['Admin Panitia']->id,
            ],
            [
                'name' => 'Verifikator Administrasi',
                'email' => 'verifikator@smkbaktinusantara666.sch.id',
                'password' => Hash::make('verifikator123'),
                'phone' => '081234567891',
                'nisn' => '1234567891',
                'nik' => '1234567890123457',
                'role_id' => $roles['Verifikator Administrasi']->id,
            ],
            [
                'name' => 'Staff Keuangan',
                'email' => 'keuangan@smkbaktinusantara666.sch.id',
                'password' => Hash::make('keuangan123'),
                'phone' => '081234567892',
                'nisn' => '1234567892',
                'nik' => '1234567890123458',
                'role_id' => $roles['Keuangan']->id,
            ],
            [
                'name' => 'Kepala Sekolah',
                'email' => 'kepsek@smkbaktinusantara666.sch.id',
                'password' => Hash::make('kepsek123'),
                'phone' => '081234567893',
                'nisn' => '1234567893',
                'nik' => '1234567890123459',
                'role_id' => $roles['Kepala Sekolah']->id,
            ],
        ];

        foreach ($users as $userData) {
            User::create($userData);
        }
    }
}