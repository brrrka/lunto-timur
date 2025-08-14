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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Judul dokumen (contoh: Surat Keputusan No. 1)
            $table->string('slug')->unique(); // Untuk URL detail atau download yang rapi
            $table->text('description')->nullable(); // Deskripsi dokumen
            $table->string('file_path'); // Path file dokumen (PDF, DOCX, dll.)
            $table->string('file_type')->nullable(); // Tipe file (PDF, DOCX, XLS)
            $table->string('file_size')->nullable(); // Ukuran file (contoh: 1.2MB)
            $table->date('published_date')->nullable(); // Tanggal dokumen dipublikasikan
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null'); // Admin yang mengunggah
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};