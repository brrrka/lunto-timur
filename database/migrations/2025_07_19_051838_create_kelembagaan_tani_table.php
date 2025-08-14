<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kelembagaan_tani', function (Blueprint $table) {
            $table->id();
            $table->string('nama_poktan')->unique();
            $table->enum('kelas_kemampuan', ['Pemula', 'Lanjutan']);
            $table->string('id_poktan')->nullable()->unique();
            $table->integer('jumlah_anggota');
            $table->string('nama_ketua');
            $table->text('alamat_sekretariat')->nullable();
            
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kelembagaan_tani');
    }
};