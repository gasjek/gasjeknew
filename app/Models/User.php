<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'saldo',
        'role',
        'photo_profile',
        'no_whatsapp',
        'fcm_token',
        'is_verify',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
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

    public static function getUser($id = null)
    {
        // Jika ID disediakan, cari pengguna dengan ID tersebut
        if ($id) {
            return self::select('name', 'email', 'no_whatsapp', 'fcm_token', 'is_verify', 'id')
                ->where('role', 'pengguna')
                ->findOrFail($id);
        }
        // Jika ID tidak disediakan, ambil semua pengguna dengan role 'pengguna'
        else {
            return self::select('name', 'email', 'no_whatsapp', 'fcm_token', 'is_verify', 'id')
                ->where('role', 'pengguna')
                ->get();
        }
    }
}
