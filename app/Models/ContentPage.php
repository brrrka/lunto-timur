<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContentPage extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'body',
        'type',
        'image',
        'contact_polsek_phone',
        'contact_polsek_name',
        'contact_babinsa_phone',
        'contact_babinsa_name',
        'user_id',
    ];

    // Jika Anda akan menggunakan slug untuk Route Model Binding di masa depan
    public function getRouteKeyName()
    {
        return 'slug';
    }

    // Relasi dengan user (admin yang membuat/mengedit)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}