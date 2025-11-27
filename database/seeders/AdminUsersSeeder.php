<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class AdminUsersSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            'Admin Panitia' => [
                'name' => 'Admin Panitia',
                'email' => 'admin@spmb.baknus666.com',
                'password' => 'admin123'
            ],
            'Kepala Sekolah' => [
                'name' => 'Kepala Sekolah',
                'email' => 'kepsek@spmb.baknus666.com',
                'password' => 'kepsek123'
            ],
            'Keuangan' => [
                'name' => 'Staff Keuangan',
                'email' => 'keuangan@spmb.baknus666.com',
                'password' => 'keuangan123'
            ],
            'Verifikator Administrasi' => [
                'name' => 'Verifikator Administrasi',
                'email' => 'verifikator@spmb.baknus666.com',
                'password' => 'verifikator123'
            ]
        ];

        foreach ($roles as $roleName => $userData) {
            $role = Role::where('name', $roleName)->first();
            
            if ($role) {
                User::updateOrCreate(
                    ['email' => $userData['email']],
                    [
                        'name' => $userData['name'],
                        'email' => $userData['email'],
                        'password' => Hash::make($userData['password']),
                        'role_id' => $role->id,
                        'email_verified_at' => now(),
                        'aktif' => true
                    ]
                );
            }
        }
    }
}