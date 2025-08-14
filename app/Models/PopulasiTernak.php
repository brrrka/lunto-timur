<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PopulasiTernak extends Model
{
    use HasFactory;

    protected $table = 'populasi_ternak';
    protected $fillable = [
        'nama_peternak',
        'jenis_ternak',
        'jumlah_ternak',
        'tahun',
        'user_id',
        'image',
    ];
    public function user() { return $this->belongsTo(User::class); }
}