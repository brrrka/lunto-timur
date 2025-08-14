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
        Schema::create('residents', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->enum('gender', ['Pria', 'Wanita']);
            $table->date('birth_date');
            $table->string('birth_place', 100);
            $table->text('address');
            $table->string('religion', 50)->nullable();
            $table->enum('marital_status', ['Belum Menikah', 'Menikah', 'Cerai', 'Janda/Duda']);
            $table->string('occupation', 100)->nullable();
            $table->enum('status', ['Aktif', 'Pindah', 'Meninggal'])->default('Aktif');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('residents');
    }
};
