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
        Schema::create('tourism_spots', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama tempat wisata
            $table->string('slug')->unique(); // Untuk URL yang rapi
            $table->string('thumbnail')->nullable(); // Foto utama (path)
            $table->string('video_url')->nullable(); // Link video (opsional)
            $table->text('address')->nullable(); // Alamat
            $table->string('latitude')->nullable(); // Koordinat Latitude (opsional)
            $table->string('longitude')->nullable(); // Koordinat Longitude (opsional)
            $table->longText('description'); // Deskripsi tempat wisata
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tourism_spots');
    }
};