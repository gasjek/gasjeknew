<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bonus extends Model
{
    use HasFactory;
    protected $table = 'bonuses';

    protected $fillable = [
        'driver_id',
        'bonus_points',
        'bonus_date',
    ];
    // Relasi Many-to-One dengan tabel drivers
    public function driver()
    {
        return $this->belongsTo(Driver::class, 'driver_id', 'id');
    }
}
