<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Jalankan seeder untuk roles, status laporan, dan users
        $this->call([
            RoleSeeder::class,
            StatusLaporanSeeder::class,
            UserSeeder::class,
        ]);
    }
}
