<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisiMisi extends Model
{
    use HasFactory;

    protected $table = 'visi_misi'; // Menyesuaikan nama tabel jika tidak plural dari nama model

    protected $fillable = [
        'type',
        'content',
        'order', // Pastikan 'order' ada di sini
        'user_id',
    ];

    /**
     * Get the user that owns the VisiMisi entry.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
