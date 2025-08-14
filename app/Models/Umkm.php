<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Umkm extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_usaha',
        'slug',
        'nama_pemilik',
        'nik_pemilik',
        'alamat_usaha',
        'no_hp_usaha',
        'photo',
        'user_id',
    ];

    /**
     * Mendapatkan kunci rute untuk model (digunakan untuk Route Model Binding dengan slug).
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Relasi dengan user (admin yang membuat/mengedit UMKM).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}