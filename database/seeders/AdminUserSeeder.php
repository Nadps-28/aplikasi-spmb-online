<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        $roles = [
            'Admin Panitia' => [
                'name' => 'Admin Panitia',
                'email' => 'admin@spmb.edu',
                'phone' => '081234567890',
                'nisn' => '1234567890',
                'nik' => '1234567890123456',
                'password' => 'admin123'
            ],
            'Kepala Sekolah' => [
                'name' => 'Dr. Budi Santoso, M.Pd',
                'email' => 'kepsek@spmb.edu', 
                'phone' => '081234567891',
                'nisn' => '1234567891',
                'nik' => '1234567890123457',
                'password' => 'kepsek123'
            ],
            'Keuangan' => [
                'name' => 'Siti Nurhaliza, S.E',
                'email' => 'keuangan@spmb.edu',
                'phone' => '081234567892',
                'nisn' => '1234567892',
                'nik' => '1234567890123458',
                'password' => 'keuangan123'
            ],
            'Verifikator Administrasi' => [
                'name' => 'Ahmad Wijaya, S.Kom',
                'email' => 'verifikator@spmb.edu',
                'phone' => '081234567893',
                'nisn' => '1234567893',
                'nik' => '1234567890123459',
                'password' => 'verifikator123'
            ]
        ];

        foreach ($roles as $roleName => $userData) {
            $role = Role::where('name', $roleName)->first();
            
            if ($role) {
                User::create([
                    'name' => $userData['name'],
                    'email' => $userData['email'],
                    'phone' => $userData['phone'],
                    'nisn' => $userData['nisn'],
                    'nik' => $userData['nik'],
                    'password' => Hash::make($userData['password']),
                    'role_id' => $role->id,
                    'email_verified_at' => now(),
                    'aktif' => true
                ]);
            }
        }
    }
}