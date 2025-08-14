<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PopulasiTanaman extends Model
{
    use HasFactory;

    protected $table = 'populasi_tanaman';
    protected $fillable = [
        'nama_komoditi',
        'tipe_tanaman',
        'jumlah_panen',
        'tahun',
        'image',
        'user_id',
    ];

    public function user() { return $this->belongsTo(User::class); }
}