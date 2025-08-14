<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LuasAreaProduksi extends Model
{
    use HasFactory;

    protected $table = 'luas_area_produksi';
    protected $fillable = [
        'nama_komoditi',
        'tipe_area',
        'luas_tanam',
        'luas_panen',
        'produksi',
        'tahun',
        'user_id',
        'image',
    ];
    protected $casts = [ // Otomatis ubah tipe data ke float
        'luas_tanam' => 'float',
        'luas_panen' => 'float',
        'produksi' => 'float',
    ];

    // Accessor untuk luas_tanam (akan dipanggil saat mengakses $model->luas_tanam_formatted)
    public function getLuasTanamFormattedAttribute()
    {
        $value = $this->luas_tanam;
        // Jika desimalnya .00, tampilkan sebagai integer
        return (float)$value == (int)$value ? number_format($value, 0, ',', '.') : number_format($value, 2, ',', '.');
    }

    // Accessor untuk luas_panen
    public function getLuasPanenFormattedAttribute()
    {
        $value = $this->luas_panen;
        return (float)$value == (int)$value ? number_format($value, 0, ',', '.') : number_format($value, 2, ',', '.');
    }

    // Accessor untuk produksi
    public function getProduksiFormattedAttribute()
    {
        $value = $this->produksi;
        return (float)$value == (int)$value ? number_format($value, 0, ',', '.') : number_format($value, 2, ',', '.');
    }


    public function user() { return $this->belongsTo(User::class); }
}