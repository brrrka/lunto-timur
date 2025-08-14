<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('populasi_tanaman', function (Blueprint $table) {
            $table->id();
            $table->string('nama_komoditi');
            $table->enum('tipe_tanaman', ['Buah-buahan', 'Perkebunan']);
            $table->integer('jumlah_panen')->default(0);
            $table->year('tahun')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('populasi_tanaman');
    }
};