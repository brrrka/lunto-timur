<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'phone_number',
        'email',
        'password',
        'status',
        'role_id',
        'otp_attempts',
        'two_factor_code',
        'two_factor_expires_at'
    ];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function resident()
    {
        return $this->hasOne(Resident::class);
    }

    public function visiMisi()
    {
        return $this->hasMany(VisiMisi::class);
    }

    public function villageOfficials()
    {
        return $this->hasMany(VillageOfficial::class);
    }
    public function generateTwoFactorCode()
    {
        $this->timestamps = false; // biar updated_at gak berubah
        $this->two_factor_code = rand(100000, 999999); // 6 digit OTP
        $this->two_factor_expires_at = now()->addMinutes(5); // expired 5 menit
        $this->save();
    }
    public function resetTwoFactorCode()
    {
        $this->timestamps = false;
        $this->two_factor_code = null;
        $this->two_factor_expires_at = null;
        $this->save();
    }
}
