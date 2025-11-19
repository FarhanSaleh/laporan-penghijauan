<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('status_laporan', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('laporan', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->text('deskripsi');
            $table->string('alamat');
            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 11, 8);
            $table->string('foto_laporan');
            $table->date('tanggal_laporan');
            $table->timestamps();
            $table->foreignId('user_id')->constrained('users')->onDelete('restrict');
            $table->foreignId('status_id')->constrained('status_laporan')->onDelete('restrict');
        });

        Schema::create('tindak_lanjut', function (Blueprint $table) {
            $table->id();
            $table->text('catatan');
            $table->string('foto_bukti');
            $table->date('tanggal_laporan');
            $table->timestamps();
            $table->foreignId('user_id')->constrained('users')->onDelete('restrict');
            $table->foreignId('laporan_id')->constrained('laporan')->onDelete('restrict');
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('status_laporan');
        Schema::dropIfExists('laporan');
        Schema::dropIfExists('tindak_lanjut');
    }
};
