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
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade'); // Siapa pelakunya
            $table->string('action'); // create, update, delete, login, dll
            $table->text('description')->nullable(); // Detail aktivitas
            $table->nullableMorphs('subject'); // Menyimpan subject_id dan subject_type (Model target)
            $table->json('properties')->nullable(); // Opsional: simpan data lama/baru
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
