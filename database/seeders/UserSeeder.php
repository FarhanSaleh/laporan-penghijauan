<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil role dari database
        $adminRole = Role::where('name', 'admin')->first();
        $petugasRole = Role::where('name', 'petugas')->first();
        $userRole = Role::where('name', 'user')->first();
        $komunitasRole = Role::where('name', 'komunitas')->first();

        // Buat user admin
        User::create([
            'nama' => 'Admin Sistem',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role_id' => $adminRole->id,
            'email_verified_at' => now(),
        ]);

        // Buat user petugas
        User::create([
            'nama' => 'Petugas Lapangan',
            'email' => 'petugas@example.com',
            'password' => Hash::make('password'),
            'role_id' => $petugasRole->id,
            'email_verified_at' => now(),
        ]);

        User::create([
            'nama' => 'Petugas 2',
            'email' => 'petugas2@example.com',
            'password' => Hash::make('password'),
            'role_id' => $petugasRole->id,
            'email_verified_at' => now(),
        ]);

        // Buat user biasa
        User::create([
            'nama' => 'User Biasa',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
            'role_id' => $userRole->id,
            'email_verified_at' => now(),
        ]);

        User::create([
            'nama' => 'John Doe',
            'email' => 'john@example.com',
            'password' => Hash::make('password'),
            'role_id' => $userRole->id,
            'email_verified_at' => now(),
        ]);
    }
}
