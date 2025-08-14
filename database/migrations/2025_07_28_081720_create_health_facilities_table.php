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
        Schema::create('health_facilities', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama fasilitas (contoh: Puskesmas, Posyandu)
            $table->string('slug')->unique(); // Untuk URL yang rapi
            $table->string('photo')->nullable(); // Path foto fasilitas (opsional)
            $table->text('address'); // Alamat fasilitas
            $table->string('phone_number')->nullable(); // Nomor telepon fasilitas (opsional)
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null'); // Admin yang membuat/mengedit
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('health_facilities');
    }
};