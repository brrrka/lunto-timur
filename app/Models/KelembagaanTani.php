<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KelembagaanTani extends Model
{
    use HasFactory;

    protected $table = 'kelembagaan_tani'; // Nama tabel
    protected $fillable = [
        'nama_poktan',
        'kelas_kemampuan',
        'id_poktan',
        'jumlah_anggota',
        'nama_ketua',
        'no_hp',
        'alamat_sekretariat',
        'user_id',
    ];

    public function user() { return $this->belongsTo(User::class); }
}