<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VoucherUsage extends Model
{
    use HasFactory;
    protected $table = 'voucher_usage';
    protected $fillable = [
        'email',
        'otp',
    ];

    protected $timestamp = true;
}
