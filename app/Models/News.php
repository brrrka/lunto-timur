<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'thumbnail',
        'published_at',
        'user_id',
    ];

    // Relasi dengan User (Penulis/Admin)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}