<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VillageOfficial extends Model
{
    use HasFactory;

    protected $table = 'village_officials'; // Menyesuaikan nama tabel

    protected $fillable = [
        'name',
        'position',
        'photo',
        'order',
        'user_id',
    ];

    /**
     * Get the user who last updated the official.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}