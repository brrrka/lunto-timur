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
        Schema::create('umkms', function (Blueprint $table) {
            $table->id();
            $table->string('nama_usaha'); // Nama Usaha
            $table->string('slug')->unique(); // Slug untuk URL yang rapi
            $table->string('nama_pemilik'); // Nama Pemilik UMKM
            $table->text('alamat_usaha')->nullable(); // Alamat Usaha
            $table->string('no_hp_usaha')->nullable(); // Nomor HP Usaha
            $table->string('photo')->nullable(); // Path foto UMKM (opsional)
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null'); // Admin yang membuat/mengedit
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('umkms');
    }
};