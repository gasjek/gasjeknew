<?php

namespace App\Http\Controllers\Api;

use App\Helpers\GlobalHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\PenggunaResource;
use App\Models\Setting;
use App\Models\User;
use App\Models\UserVerify;
use App\Models\Voucher;
use App\Models\VoucherUsage;
use Carbon\Carbon;
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
        $id = $request->input('id_user');

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
            return new PenggunaResource(404, 'Email sudah digunakan pengguna lain.');
        }

        // Cek jika nomor WhatsApp sudah terdaftar
        $existingUserByPhone = User::where('no_whatsapp', $validatedData['nomor_pengguna'])->first();
        if ($existingUserByPhone) {
            if ($existingUserByPhone->is_verify == 1) {
                $message = 'Nomor HP sudah digunakan pengguna lain.';
            } else {
                $message = 'Nomor HP telah ada silahkan Login';
            }
            return new PenggunaResource(401, $message);
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
            'status' => 201,
            'id_user' => $pengguna->id,
            'tokens' => $token,
            'message' => 'Data berhasil dibuat.',
            'is_verify' => 0
        ], 201);
    }

    public function login(Request $request)
    {
        // Validasi input
        $validateData = $request->validate([
            'email_pengguna' => 'required|email|string',
            // 'role' => 'required',
            'password_pengguna' => 'required',
        ]);

        // Cek apakah pengguna ada berdasarkan email
        $pengguna = User::where('email', $validateData['email_pengguna'])->where('role', 'pengguna')->first();

        if (!$pengguna) {
            // Jika pengguna tidak ditemukan
            return new PenggunaResource(404, 'Email atau password salah');
        }

        // Cek apakah password salah
        if (!Hash::check($request->password_pengguna, $pengguna->password)) {
            // Jika password salah
            return new PenggunaResource(400, 'Password Anda Salah');
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
            ]);
        }

        // Jika pengguna sudah diverifikasi, perbarui fcm_token jika disediakan
        if ($request->fcm_token) {
            $pengguna->update(['fcm_token' => $request->fcm_token]);
        }

        // Buat token menggunakan Sanctum
        $token = $pengguna->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status' => 200,
            'id_user' => $token,
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

        $pengguna = $request->user();

        // Periksa apakah kata sandi saat ini benar
        if (!Hash::check($request->old_password, $pengguna->password)) {
            return new PenggunaResource(400, 'Kata sandi saat ini salah');
        }

        // Update kata sandi baru
        $pengguna->password = Hash::make($request->new_password);
        $pengguna->save();

        return new PenggunaResource(200, 'Kata sandi berhasil diperbarui');
    }

    // Update informasi pengguna
    public function updateUser(Request $request)
    {
        $request->validate([
            'nama_pengguna' => 'sometimes|string|max:255',
            'email_pengguna' => 'sometimes|string|email|max:255|unique:users,email,' . $request->user()->id,
            'nomor_pengguna' => 'sometimes|string|max:15',
            'photo_profile' => 'required'
        ]);

        $user = $request->user();
        $user->update($request->only('name', 'email', 'no_whatsapp', 'photo_profile'));

        return new PenggunaResource(200, 'Informasi pengguna berhasil diperbarui');
    }

    public function verify(Request $request)
    {
        $validatedData = $request->validate([
            'user_email' => 'required|email',
            'id_user' => 'required',
        ]);

        $email = $validatedData['user_email'];
        $token = $validatedData['id_user'];

        // Cari pengguna berdasarkan email
        $pengguna = User::where('email', $email)->first();

        if (!$pengguna) {
            return new PenggunaResource(404, 'Akun tidak ditemukan');
        }

        // Cari verifikasi pengguna berdasarkan email dan token
        $penggunaVerify = UserVerify::where('email', $email)
            ->where('otp', $token)
            ->first();

        if (!$penggunaVerify) {
            return new PenggunaResource(401, 'Kode OTP tidak valid');
        }

        // Hapus data verifikasi setelah digunakan
        $penggunaVerify->delete();

        // Update status verifikasi pengguna
        $pengguna->update(['is_verify' => 1]);

        // Kirimkan notifikasi ke pengguna
        GlobalHelper::sendWhatsApp($pengguna->no_whatsapp, 'Selamat akun anda telah active. Sekarang anda bisa melanjutkan transaksi');

        return new PenggunaResource(200, 'Akun Anda telah diverifikasi');
    }

    public function otpRequest(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|email',
        ]);

        $email = $validatedData['email'];

        // Cari pengguna berdasarkan email
        $pengguna = User::where('email', $email)->firstOrFail();

        // Generate OTP baru
        $otp_code = rand(100000, 999999);

        // JIka ada update OTP sebelumnya
        UserVerify::updateOrCreate(
            ['email' => $pengguna->email],
            ['otp' => $otp_code]
        );

        // Kirim OTP ke nomor WhatsApp pengguna
        GlobalHelper::sendOTP($otp_code, 'verify', $pengguna->no_whatsapp);

        return response()->json([
            'status' => 200,
            'message' => 'OTP terkirim',
        ], 200);
    }

    public function updateFCMToken(Request $request)
    {
        $validatedData = $request->validate([
            'id_user' => 'required|integer',
            'fcm_token' => 'required',
        ]);

        $idPengguna = $validatedData['id_user'];

        // Cari pengguna berdasarkan ID, jika tidak ditemukan, akan otomatis return 404
        $pengguna = User::findOrFail($idPengguna);

        // Update FCM token pengguna
        $pengguna->update([
            'fcm_token' => $validatedData['fcm_token']
        ]);

        return new PenggunaResource(200, 'Token FCM berhasil diperbarui');
    }

    public function updateSaldo(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'id_user' => 'required|integer',
            'balance' => 'required|numeric',
        ]);

        $token = $validatedData['id_user'];
        $balance = $validatedData['balance'];

        // Update saldo pengguna
        $pengguna = User::where('id', $token)->first();

        // Cek apakah pengguna ditemukan
        if ($pengguna) {
            $pengguna->update(['saldo' => $balance]);

            return new PenggunaResource(200, 'Saldo pengguna berhasil diperbarui.');
        } else {
            return new PenggunaResource(404, 'Pengguna tidak ditemukan');
        }
    }

    public function checkSaldo(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'id_user' => 'required|integer',
            'harga' => 'required|numeric',
        ]);

        $token = $validatedData['id_user'];
        $harga = $validatedData['harga'];

        // Cari pengguna berdasarkan token (ID)
        $user = User::where('id', $token)->first();

        if ($user) {
            if ($user->saldo >= $harga) {
                return new PenggunaResource(200, 'Saldo mencukupi.');
            } else {
                return new PenggunaResource(404, 'Saldo tidak mencukupi.');
            }
        } else {
            return new PenggunaResource(404, 'Pengguna tidak ditemukan');
        }
    }

    public function lupaPassword(Request $request)
    {
        // Validasi input nomor pengguna
        $validatedData = $request->validate([
            'user_number' => 'required|string',
        ]);

        $nohp = $validatedData['user_number'];

        // Cari pengguna berdasarkan nomor HP
        $user = User::where('no_whatsapp', $nohp)->first();

        if (!$user) {
            return new PenggunaResource(404, 'Pengguna tidak ditemukan');
        } else {
            // Generate kode OTP
            $codeOTP = rand(100000, 999999);

            // Simpan OTP ke dalam tabel verifikasi
            UserVerify::create([
                'email' => $user->email,
                'id_user' => $codeOTP,
            ]);

            // Kirim OTP ke nomor HP pengguna
            GlobalHelper::sendOTP($codeOTP, 'forgot', $user->no_whatsapp);

            return new PenggunaResource(200, 'OTP terkirim');
        }
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'user_number' => 'required',
            'otp' => 'required',
            'new_password' => 'required|min:6',
        ]);

        $nohp = $request->user_number;
        $otp = $request->otp;
        $new_password = $request->new_password;

        $user = User::where('no_whatsapp', $nohp)->first();

        if (!$user) {
            return new PenggunaResource(404, 'Pengguna tidak ditemukan');
        }

        $verification = UserVerify::where('email', $user->email)
            ->where('otp', $otp)
            ->first();

        if (!$verification) {
            return new PenggunaResource(404, 'OTP tidak ditemukan');
        }

        // Update password user
        $user->password = bcrypt($new_password);
        $user->save();

        // Hapus verifikasi token
        $verification->delete();

        return new PenggunaResource(200, 'Password berhasil diperbarui');
    }

    public function checkVoucher(Request $request)
    {
        $validatedData = $request->validate([
            'voucher_code' => 'required|string',
            'id_user' => 'required|integer',
        ]);

        $voucherCode = $validatedData['voucher_code'];
        $userId = $validatedData['id_user'];
        $currentDate = now()->format('Y-m-d');

        try {
            // Cari voucher berdasarkan kode
            $voucher = Voucher::where('voucher_code', $voucherCode)
                ->where('is_active', 1)
                ->first();

            if (!$voucher) {
                return new PenggunaResource(404, 'Voucher tidak ditemukan');
            }

            // Cek apakah jatah penggunaan masih tersedia
            if ($voucher->used >= $voucher->quota) {
                return new PenggunaResource(400, 'Jatah penggunaan sudah habis');
            }

            // Cek apakah voucher sudah kedaluwarsa
            if ($voucher->expiry_date < $currentDate) {
                return new PenggunaResource(400, 'Voucher sudah kedaluwarsa');
            }

            // Cek apakah user sudah pernah menggunakan voucher ini
            $voucherUsage = VoucherUsage::where('user_id', $userId)
                ->where('voucher_id', $voucher->id)
                ->first();

            if ($voucherUsage) {
                return new PenggunaResource(400, 'Anda sudah menggunakan voucher ini');
            }

            // Kurangi jatah penggunaan voucher
            $voucher->decrement($voucher->id);

            // Update saldo pengguna
            User::where('id', $userId)->increment('saldo', $voucher->discount);

            // Catat penggunaan voucher oleh user
            VoucherUsage::create([
                'user_id' => $userId,
                'voucher_id' => $voucher->id,
            ]);

            // Jika valid, balas dengan detail voucher
            return response()->json([
                'status' => 200,
                'message' => 'Voucher valid.',
                'voucher' => $voucher,
            ], 200);
        } catch (\Exception $e) {
            return new PenggunaResource(500, $e->getMessage());
        }
    }

    public function operatingHours()
    {
        $settings = Setting::whereIn('key', ['closer_hours', 'open_hours'])->get()->keyBy('key');
        $now = now();
        $closeTime = Carbon::parse($settings->get('closer_hours'));
        $openTime = Carbon::parse($settings->get('open_hours'));

        // Jika status_develop adalah true, berikan respons dengan status 202
        if ($settings->get('status_dev') == 'true') {
            return new PenggunaResource(202, 'Aplikasi sedang dalam pengembangan.');
        }

        if ($closeTime->isToday() && $now->gt($closeTime) && $now->lt($openTime->subDay())) {
            return new PenggunaResource(200, 'Udah tutup nih dari jam 22:00. Kembali buka 05:00.');
        }
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
