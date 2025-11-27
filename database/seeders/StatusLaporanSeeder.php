<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\StatusLaporan;

class StatusLaporanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat status laporan
        StatusLaporan::create([
            "name" => "Pending",
        ]);

        StatusLaporan::create([
            "name" => "Diproses",
        ]);

        StatusLaporan::create([
            "name" => "Selesai",
        ]);

        StatusLaporan::create([
            "name" => "Ditolak",
        ]);
    }
}
