<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;
    protected $table = 'voucher';
    protected $fillable = ['voucher_name', 'voucher_code', 'discount', 'expiry_date', 'is_active', 'quota', 'used'];

    public function decrementQuota($voucherId)
    {
        // Temukan voucher berdasarkan ID
        $voucher = self::find($voucherId);

        if (!$voucher) {
            throw new \Exception('Voucher not found.');
        }

        // Update jatah penggunaan voucher
        $updated = self::where('id_voucher', $voucherId)
            ->increment('used');

        if (!$updated) {
            throw new \Exception('Update failed.');
        }

        return true;
    }

    protected $timestamp = true;
}
