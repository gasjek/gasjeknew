<?php

namespace App\Http\Controllers\Api;

use App\Helpers\GlobalHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\PenggunaResource;
use App\Models\User;
use App\Models\UserVerify;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function index(Request $request): JsonResponse
    {
        $id = $request->input('token');

        try {
            $model = $id ? User::getUser($id) : User::getUser();

            return response()->json([
                'status' => 200,
                'message' => 'Berhasil',
                'dataUsers' => $model
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 404,
                'message' => "Pengguna Tidak Ditemukan"
            ], 404);
        }
    }

    public function register(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'name_pengguna' => 'required|string|max:255',
            'email_pengguna' => 'required|string|email|max:255',
            'nomor_pengguna' => 'required|string|max:20',
            'password_pengguna' => 'required|string|min:8',
            'image_pengguna' => 'required|string|max:255',
        ]);

        // Cek jika email sudah terdaftar
        $existingUserByEmail = User::where('email', $validatedData['email_pengguna'])->first();
        if ($existingUserByEmail) {
            return response()->json([
                'status' => 400,
                'message' => 'Email sudah digunakan pengguna lain.'
            ], 400);
        }

        // Cek jika nomor WhatsApp sudah terdaftar
        $existingUserByPhone = User::where('no_whatsapp', $validatedData['nomor_pengguna'])->first();
        if ($existingUserByPhone) {
            if ($existingUserByPhone->is_verify == 1) {
                $message = 'Nomor HP sudah digunakan pengguna lain.';
            } else {
                $message = 'Nomor HP telah ada silahkan Login';
            }
            return response()->json([
                'status' => 401,
                'message' => $message,
            ], 401);
        }

        $pengguna = User::create([
            'name' => $validatedData['name_pengguna'],
            'email' => $validatedData['email_pengguna'],
            'no_whatsapp' => $validatedData['nomor_pengguna'],
            'password' => Hash::make($validatedData['password_pengguna']),
            'photo_profile' => $validatedData['image_pengguna'],
            'fcm_token' => $request->fcm_token,
            'role' => 'pengguna',
            'saldo' => 0,
            'is_verify' => 0,
        ]);

        $nowa = (substr($validatedData['nomor_pengguna'], 0, 2) == '62' || substr($validatedData['nomor_pengguna'], 0, 3) == '+62' || substr($validatedData['nomor_pengguna'], 0, 2) == '08') ? $validatedData['nomor_pengguna'] : '62' . substr($validatedData['nomor_pengguna'], strpos($validatedData['nomor_pengguna'], ' '));
        $otp_code = rand(100000, 999999);
        UserVerify::updateOrCreate(
            ['email' => $pengguna->email],
            ['otp' => $otp_code]
        );

        GlobalHelper::sendOTP($otp_code, 'verify', $nowa);

        $token = $pengguna->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status' => 200,
            'token' => $pengguna->id,
            'tokens' => $token,
            'message' => 'Data berhasil dibuat.',
            'is_verify' => 0
        ], 201);
    }

    public function login(Request $request): JsonResponse
    {
        // Validasi input
        $request->validate([
            'email_pengguna' => 'required|email|string',
            'password_pengguna' => 'required',
        ]);

        // Cek apakah pengguna ada berdasarkan email
        $pengguna = User::where('email', $request->email_pengguna)->where('role', 'pengguna')->first();
        if (!$pengguna || !Hash::check($request->password_pengguna, $pengguna->password)) {
            // Jika pengguna tidak ditemukan atau password salah
            return response()->json([
                'status' => 401,
                'message' =>  'Email atau password salah',
            ], 401);
        }

        // Cek apakah pengguna sudah diverifikasi
        if ($pengguna->is_verify == 0) {
            // Jika belum diverifikasi, buat OTP dan kirimkan
            $otp_code = rand(100000, 999999);
            UserVerify::updateOrCreate(
                ['email' => $pengguna->email],
                ['otp' => $otp_code]
            );

            GlobalHelper::sendOTP($otp_code, 'verify', $pengguna->no_whatsapp);

            return response()->json([
                'status' => 401,
                'message' => 'Akun anda belum terverifikasi. Kode OTP telah dikirimkan.',
            ], 401);
        }

        // Jika pengguna sudah diverifikasi, perbarui fcm_token jika disediakan
        if ($request->fcm_token) {
            $pengguna->update(['fcm_token' => $request->fcm_token]);
        }

        // Buat token dan respon berhasil
        $token = $pengguna->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status' => 200,
            'token' => $token,
            'message' => 'Login berhasil',
            'user_verify' => $pengguna->is_verify,
        ]);
    }

    // Update password pengguna
    public function updatePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = $request->user();

        // Periksa apakah kata sandi saat ini benar
        if (!Hash::check($request->old_password, $user->password)) {
            return response()->json([
                'status' => 400,
                'message' => 'Kata sandi saat ini salah',
            ], 400);
        }

        // Update kata sandi baru
        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json([
            'status' => 200,
            'message' => 'Kata sandi berhasil diperbarui',
        ], 200);
    }

    // Update informasi pengguna
    public function updateUser(Request $request)
    {
        $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|string|email|max:255|unique:users,email,' . $request->user()->id,
            'no_whatsapp' => 'sometimes|string|max:15',
            'photo_profile' => 'required'
        ]);

        $user = $request->user();
        $user->update($request->only('name', 'email', 'no_whatsapp', 'photo_profile'));

        return new PenggunaResource(200, 'Informasi pengguna berhasil diperbarui');
    }

    public function logout(Request $request)
    {
        // Cek apakah pengguna sedang login
        if ($pengguna = $request->user()) {
            // Menghapus semua token pengguna saat ini
            $pengguna->tokens()->delete();

            // Mengembalikan respons berhasil logout menggunakan PenggunaResource
            return new PenggunaResource(200, 'Logout berhasil');
        }

        // Jika tidak ada pengguna yang login
        return response()->json([
            'status' => 401,
            'message' => 'Tidak ada pengguna yang sedang login',
        ], 401);
    }
}
