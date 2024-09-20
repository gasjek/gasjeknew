<?php

namespace App\Http\Controllers;

use App\Helpers\GlobalHelper;
use App\Http\Requests\PostDriverRequest;
use App\Http\Resources\DriverResource;
use App\Models\Driver;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class MitraDriverController extends Controller
{
    public function driverPage()
    {
        return view('auth.mitra.driverRegister');
    }

    public function registerDriver(PostDriverRequest $request)
    {
        try {
            // Validasi input
            $validator = $request->validated();

            // Cek jika email sudah terdaftar
            $existingUserByEmail = Driver::where('email', $validator['email'])->first();
            if ($existingUserByEmail) {
                return response()->json([
                    'status' => 400,
                    'message' => 'Email sudah digunakan driver lain.'
                ], 400);
            }

            // Cek jika nomor WhatsApp sudah terdaftar
            $existingUserByPhone = Driver::where('no_whatsapp', $validator['no_whatsapp'])->first();
            if ($existingUserByPhone) {
                if ($existingUserByPhone->is_verify == 1) {
                    $message = 'Nomor HP sudah digunakan driver lain.';
                } else {
                    $message = 'Nomor HP telah ada silahkan Login';
                }
                return response()->json([
                    'status' => 401,
                    'message' => $message,
                ], 401);
            }

            // Simpan file SIM dan KTP jika di-upload
            $simFileName = 'default.jpg';
            $ktpFileName = 'default.jpg';

            // Periksa apakah ada file SIM yang di-upload
            if ($request->hasFile('sim')) {
                $simFile = $request->file('sim'); // Ambil file dari request
                $simFileName = time() . '_sim.' . $simFile->getClientOriginalExtension(); // Buat nama file unik
                // Simpan file ke public/storage/img/berkas
                $simFile->storeAs('public/img/berkas/sim', $simFileName); // Simpan file
            }

            // Periksa apakah ada file KTP yang di-upload
            if ($request->hasFile('ektp')) {
                $ktpFile = $request->file('ektp'); // Ambil file dari request
                $ktpFileName = time() . '_ektp.' . $ktpFile->getClientOriginalExtension(); // Buat nama file unik
                // Simpan file ke public/storage/img/berkas
                $ktpFile->storeAs('public/img/berkas/ktp', $ktpFileName); // Simpan file
            }

            // Buat record driver
            Driver::create([
                'name' => $validator['full_name'],
                'email' => $validator['email'],
                'password' => Hash::make($validator['password']),
                'role' => 'driver',
                'type_vehicle' => $validator['vehicle_type'],
                'vehicle_name' => $validator['vehicle_name'],
                'location' => $validator['location'],
                'no_whatsapp' => $validator['no_whatsapp'],
                'plat_number' => $validator['plat_number'],
                'photo_profile' => 'default.jpg',
                'sim' => $simFileName,
                'ktp' => $ktpFileName,
            ]);

            GlobalHelper::sendWhatsApp($validator['no_whatsapp'], 'Selamat akun Anda berhasil dibuat, silahkan datang ke kantor.');
            return response()->json(['success' => 'Registrasi berhasil!'], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
