<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;

    protected $fillable = [
        'photo',
        'activity_date',
        'user_id',
    ];

    protected $casts = [
        'activity_date' => 'date', // Mengubah ke objek Carbon secara otomatis
    ];

    // Relasi dengan User (Admin yang mengunggah)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}