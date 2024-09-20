<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trips extends Model
{
    use HasFactory;
    protected $table = 'trips';

    protected $fillable = [
        'driver_id',
        'trip_date',
        'rating',
        'earnings',
    ];

    // Relasi Many-to-One dengan tabel drivers
    public function driver()
    {
        return $this->belongsTo(Driver::class, 'driver_id', 'id');
    }
}
