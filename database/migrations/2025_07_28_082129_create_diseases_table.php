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
        Schema::create('diseases', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // Nama penyakit (wajib unik)
            $table->integer('case_count'); // Jumlah kasus
            $table->year('year')->nullable(); // Tahun data (opsional, jika data per tahun)
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null'); // Admin yang membuat/mengedit
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diseases');
    }
};