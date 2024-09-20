<?php

namespace App\Http\Controllers\Api;

use App\Helpers\GlobalHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\DriverResource;
use App\Models\Driver;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DriverController extends Controller
{
    protected $driverModel;

    public function __construct(Driver $driver)
    {
        $this->driverModel = $driver;
    }

    public function index(Request $request)
    {
        // Mengambil parameter dari request
        $token = $request->query('id_driver');
        $platNumber = $request->query('police_number');
        $emailDriver = $request->query('email_driver');
        $is_active = $request->query('is_status');
        $is_limited = $request->query('is_limited');

        // Inisialisasi variabel
        $drivers = [];

        // Mengambil data berdasarkan parameter yang diberikan
        if ($token != null) {
            $drivers = $this->driverModel->getDriver($token);
        } elseif ($emailDriver != null) {
            $drivers = $this->driverModel->getDriverEmail($emailDriver);
        } elseif ($platNumber && $platNumber != "All") {
            $drivers = $this->driverModel->getPoliceNumber($platNumber);
        } elseif ($is_active !== null) {
            $drivers = $this->driverModel->getActiveDriver($is_active);
        } elseif ($is_limited !== null) {
            $drivers = $this->driverModel->checkLimited($is_limited);
        } else {
            $drivers = $this->driverModel->getDriver();
        }

        // Menyiapkan respons
        return response()->json([
            'status' => 1,
            'message' => 'success',
            'dataDrivers' => $drivers,
        ]);
    }

    public function login(Request $request)
    {
        // Validasi input
        $validateData = $request->validate([
            'driver_email' => 'required|email|string',
            'driver_password' => 'required',
        ]);

        // Cek apakah driver ada berdasarkan email
        $driver = Driver::where('email', $validateData['driver_email'])->where('role', 'driver')->first();

        if (!$driver) {
            // Jika driver tidak ditemukan
            return new DriverResource(404, 'Email atau password salah');
        }

        // Cek apakah password salah
        if (!Hash::check($validateData['driver_password'], $driver->password)) {
            // Jika password salah
            return new DriverResource(400, 'Password Anda Salah');
        }

        // Jika driver sudah diverifikasi, perbarui fcm_token jika disediakan
        if ($request->fcm_token) {
            $driver->update(['fcm_token' => $request->fcm_token]);
        }

        // Buat token menggunakan Sanctum
        $token = $driver->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status' => 1,
            'id_driver' => $driver->id,
            'tokens' => $token,
            'message' => "Login berhasil",
            'is_status' => $driver->is_status
        ]);
    }

    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'type_vehicle' => 'required|string',
            'police_number' => 'required|string',
            'vehicle_name' => 'required|string',
            'location' => 'required|string',
            'image_rider' => 'required',
            'username_rider' => 'required|string',
            'email_rider' => 'required|email',
            'phone_rider' => 'required',
            'password_rider' => 'required|string',
            'police_number' => 'required|string',
        ]);

        // Cek jika email sudah terdaftar
        $existingUserByEmail = Driver::where('email', $validatedData['email_rider'])->first();
        if ($existingUserByEmail) {
            return new DriverResource(404, 'Email sudah terdaftar driver lain.');
        }

        // Cek jika nomor WhatsApp sudah terdaftar
        $existingUserByPhone = Driver::where('no_whatsapp', $validatedData['phone_rider'])->first();
        if ($existingUserByPhone) {
            if ($existingUserByPhone->is_verify == 1) {
                $message = 'Nomor HP sudah digunakan driver lain.';
            } else {
                $message = 'Nomor HP telah ada silahkan Login';
            }
            return new DriverResource(401, $message);
        }

        $driver = Driver::create([
            'name' => $validatedData['username_rider'],
            'email' => $validatedData['email_rider'],
            'no_whatsapp' => $validatedData['phone_rider'],
            'password' => Hash::make($validatedData['password_rider']),
            'photo_profile' => $validatedData['phone_rider'],
            'fcm_token' => $request->fcm_token,
            'location' => $validatedData['location'],
            'vehicle_name' => $validatedData['vehicle_name'],
            'police_number' => $validatedData['police_number'],
            'type_vehicle' => $validatedData['type_vehicle'],
            'plat_number' => $validatedData['police_number'],
        ]);

        $token = $driver->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status' => 200,
            'id_driver' => $driver->id,
            'tokens' => $token,
            'message' => 'Data berhasil dibuat.',
        ]);
    }

    public function updateVehicle(Request $request)
    {
        $validateData = $request->validate([
            'id_user' => 'required',
            'police_number' => 'required',
            'vehicle_name' => 'required',
        ]);

        try {
            $idDriver = $validateData['id_user'];
            $platNumber = $validateData['police_number'];
            $vehicle_name = $validateData['vehicle_name'];

            // Validasi input
            if (empty($platNumber) || empty($vehicle_name)) {
                return new DriverResource(400, 'Police Number dan Vehicle Name harus diisi');
            }

            // Cari driver berdasarkan ID
            $currentDriver = Driver::find($idDriver);
            if (!$currentDriver) {
                return new DriverResource(404, 'Driver tidak ditemukan');
            }

            // Data untuk diupdate
            $driverData = [
                'plat_number' => $platNumber,
                'vehicle_name' => $vehicle_name,
            ];

            // Update informasi driver
            $update = $currentDriver->update($driverData);
            if ($update) {
                return new DriverResource(200, 'Informasi Kendaraan Berhasil Diubah', $currentDriver);
            } else {
                return new DriverResource(400, 'Terjadi kesalahan saat mengupdate informasi kendaraan');
            }
        } catch (Exception $e) {
            return new DriverResource(500, 'Terjadi Kesalahan Server');
        }
    }

    public function updateFCMToken(Request $request)
    {
        $validateData = $request->validate([
            'id_driver' => 'required',
            'fcm_token' => 'required',
        ]);

        try {
            $idDriver = $validateData['id_driver'];
            $fcmToken = $validateData['fcm_token'];

            $driver = Driver::find($idDriver);
            if (!$driver) {
                return new DriverResource(404, 'Driver tidak ditemukan');
            }

            $update = $driver->update(['fcm_token' => $fcmToken]);

            if ($update) {
                return new DriverResource(200, 'FCM Token Driver Berhasil Diubah');
            } else {
                return new DriverResource(400, 'FCM Token Driver Gagal Diubah');
            }
        } catch (Exception $e) {
            return new DriverResource(500, 'Terjadi Kesalah Server');
        }
    }
}
