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
        Schema::create('content_pages', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Judul konten (e.g., "Sejarah", "Visi Nagari", "Kontak Hukum")
            $table->string('slug')->unique()->nullable(); // Opsional untuk URL yang bersih
            $table->text('body')->nullable(); // Isi konten teks panjang (e.g., sejarah, deskripsi kontak)
            $table->string('type')->index(); // Tipe konten (e.g., 'sejarah', 'visi', 'misi', 'legal_contact', 'struktur_bagan')
            $table->string('image')->nullable(); // Path gambar (untuk bagan struktur, atau gambar terkait lainnya)

            // Kolom-kolom kontak jika tidak disimpan di JSON atau body
            $table->string('contact_polsek_phone')->nullable();
            $table->string('contact_polsek_name')->nullable();
            $table->string('contact_babinsa_phone')->nullable();
            $table->string('contact_babinsa_name')->nullable();

            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null'); // Admin yang membuat/mengedit
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('content_pages');
    }
};