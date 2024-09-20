<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Driver extends Authenticatable
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
        'fcm_token',
        'password',
        'date_register',
        'saldo',
        'role',
        'type_vehicle',
        'vehicle_name',
        'location',
        'is_limited',
        'is_status',
        'is_active',
        'no_whatsapp',
        'plat_number',
        'latitude',
        'longitude',
        'photo_profile',
        'sim',
        'ktp',
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
            'password' => 'hashed',
        ];
    }

    // Relasi One-to-Many dengan tabel trips
    public function trips()
    {
        return $this->hasMany(Trips::class, 'driver_id', 'id');
    }

    // Relasi One-to-Many dengan tabel bonuses
    public function bonuses()
    {
        return $this->hasMany(Bonus::class, 'driver_id', 'id');
    }

    // Fungsi untuk mendapatkan semua driver atau driver berdasarkan idDriver
    public function getDriver($idDriver = null)
    {
        if ($idDriver == false) {
            return self::select('id', 'name', 'email', 'no_whatsapp', 'photo_profile', 'location', 'vehicle_name', 'plat_number', 'type_vehicle', 'plat_number', 'fcm_token')->get();
        }
        return self::where('id', $idDriver)->select('id', 'name', 'email', 'no_whatsapp', 'photo_profile', 'location', 'vehicle_name', 'plat_number', 'type_vehicle', 'plat_number', 'fcm_token')->first();
    }

    // Fungsi untuk mendapatkan semua atau driver berdasarkan nomor polisi
    public function getPoliceNumber($platNumber = null)
    {
        if ($platNumber == false) {
            return self::select('id', 'name', 'email', 'no_whatsapp', 'photo_profile', 'location', 'vehicle_name', 'plat_number', 'type_vehicle', 'plat_number', 'fcm_token')->get();
        }
        return self::where('plat_number', $platNumber)->select('id', 'name', 'email', 'no_whatsapp', 'photo_profile', 'location', 'vehicle_name', 'plat_number', 'type_vehicle', 'plat_number', 'fcm_token')->first();
    }

    // Fungsi untuk mendapatkan semua driver atau driver berdasarkan status
    public function getActiveDriver($is_active = null)
    {
        if ($is_active == false) {
            return self::select('id', 'name', 'email', 'no_whatsapp', 'photo_profile', 'location', 'vehicle_name', 'plat_number', 'type_vehicle', 'plat_number', 'fcm_token')->get();
        }
        return self::where('is_active', $is_active)->select('id', 'name', 'email', 'no_whatsapp', 'photo_profile', 'location', 'vehicle_name', 'plat_number', 'type_vehicle', 'plat_number', 'fcm_token')->first();
    }

    // Fungsi untuk mendapatkan driver berdasarkan email
    public function getDriverEmail($emailDriver = null)
    {
        if ($emailDriver == false) {
            return self::select('id', 'name', 'email', 'no_whatsapp', 'photo_profile', 'location', 'vehicle_name', 'plat_number', 'type_vehicle', 'plat_number', 'fcm_token')->get();
        }
        return self::where('email', $emailDriver)->select('id', 'name', 'email', 'no_whatsapp', 'photo_profile', 'location', 'vehicle_name', 'plat_number', 'type_vehicle', 'plat_number', 'fcm_token')->first();
    }

    // Fungsi untuk mengupdate lokasi driver berdasarkan id
    public function updateLocation($idDriver, $latitude, $longitude)
    {
        return self::where('id', $idDriver)
            ->update(['latitude' => $latitude, 'longitude' => $longitude]);
    }

    // Fungsi untuk mendapatkan driver berdasarkan nomor polisi
    public function getDriverByPoliceNumber($platNumber)
    {
        return self::where('plat_number', $platNumber)->first();
    }

    // Fungsi untuk mengecek driver dengan kondisi `is_limited`
    public function checkLimited($is_limited)
    {
        return self::where('is_limited', $is_limited)->first();
    }
}
