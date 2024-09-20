<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\GlobalResource;
use App\Models\Bonus;
use App\Models\Trips;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    public function trxOrder(Request $request)
    {
        // input transaksi order
    }

    public function updateOrder(Request $request)
    {
        // ketika ada perubahan pada order
    }

    // Fungsi untuk menyelesaikan orderan
    private function completeOrder(Request $request)
    {
        $driverId = $request('driver_id');
        $earnings = $request('earnings');

        // Buat record baru di tabel trips
        $trip = Trips::create([
            'driver_id' => $driverId,
            'trip_date' => now(),
            'rating' => 0, // Default rating 0
            'earnings' => $earnings
        ]);

        return new GlobalResource(201, 'Order completed, waiting for user rating');
    }

    // Fungsi untuk menerima rating dari user dan menghitung bonus
    private function submitRating(Request $request)
    {
        $tripId = $request->input('trip_id');
        $rating = $request->input('rating');

        // Temukan trip berdasarkan ID
        $trip = Trips::find($tripId);

        if (!$trip) {
            return new GlobalResource(404, 'Trip not found');
        }

        // Update rating trip
        $trip->rating = $rating;
        $trip->save();

        // Hitung bonus setelah rating diberikan
        $this->calculateBonus($trip->driver_id);

        return new GlobalResource(201, 'Rating submitted and bonus calculated');
    }

    // Fungsi untuk menghitung bonus berdasarkan data trip
    private function calculateBonus($driverId)
    {
        $trips = Trips::where('driver_id', $driverId)->get();

        $totalTrips = $trips->count();
        $totalRating = $trips->sum('rating');
        $totalEarnings = $trips->sum('earnings');
        $averageRating = $totalTrips > 0 ? $totalRating / $totalTrips : 0.0;

        $bonusPoints = 0;

        // Aturan perhitungan bonus
        if ($totalTrips >= 10) {
            $bonusPoints += 50;
        }

        if ($averageRating >= 4.5) {
            $bonusPoints += 100;
        }

        if ($totalEarnings >= 50000) {
            $bonusPoints += 150;
        }

        // Simpan bonus ke database
        if ($bonusPoints > 0) {
            Bonus::create([
                'driver_id' => $driverId,
                'bonus_points' => $bonusPoints,
                'bonus_date' => now(),
            ]);
        }
    }
}
