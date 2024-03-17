<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Carbon;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function registrasi(Request $request) {
        if(!$request->filled(['name', 'email', 'password'])) {
            return response()->json(['message' => 'semua field harus diisi'], 422);
        }

        // Validasi input
        $validator = Validator::make($request->all(),[
            'name' => 'required|string',
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/',
            'phone' => ['nullable', 'string', 'max:255'],
        ], [
            'name.required' => 'Nama harus diisi.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Password harus diisi.',
            'password.regex' => 'Password harus minimal 8 karakter, mengandung huruf besar, huruf kecil, angka, dan karakter spesial.',
        ]);

        // Cek hasil validasi
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // Buat pengguna baru
        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $user = User::where('email', $request->email)->first();

        $tokenResult = $user->createToken('authToken')->plainTextToken;


        return response()->json([
            'data' => $user,
            'token' => $tokenResult,
            'token_type' => 'Bearer',
            'message' => 'registrasi berhasil !'
        ], 201);
    }

    public function login (Request $request) {
        // Validate input
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:8'
        ], [
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password harus diisi.',
            'password.min' => 'Password minimal 8 karakter.'
        ]);

        // Check validation result
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // Attempt to find user by email
        $user = User::where('email', $request->email)->first();

        // Check if user exists
        if (!$user) {
            return response()->json(['message' => 'Email atau password salah'], 401);
        }

        // Verify password
        if (!Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Email atau password salah'], 401);
        }

        // Generate token (consider using a dedicated library for token management)
        $tokenResult = $user->createToken('authToken')->plainTextToken;

        return response()->json([
            'data' => $user,
            'token' => $tokenResult,
            'token_type' => 'Bearer',
            'message' => 'login berhasil !'
        ], 200);
    }

    public function verifikasiEmail(Request $request) {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        // Check validation result
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // Find user by email
        $user = User::where('email', $request->email)->first();

        // Check if user exists
        if (!$user) {
            return response()->json(['message' => 'Email tidak ditemukan'], 401);
        }

        // Check if email is already verified
        if ($user->email_verified_at) {
            return response()->json(['message' => 'Email sudah terverifikasi'], 401);
        }

        // Mark user as verified
        $user->email_verified_at = time(); // Set timestamp saat ini
        $user->save();

        // Success response
        return response()->json(['message' => 'Email berhasil diverifikasi'], 200);
    }

    public function currentUser() {
        $user = auth()->user();

        if ($user) {
            return response()->json([
                'data' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                ],
                'message' => 'Informasi pengguna saat ini',
            ], 200);
        } else {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    }

    public function updateProfile(Request $request) {
        $user = Auth::user();

        // Gunakan data default
        $data = $request->only('name', 'email');
        if (!isset($data['phone'])) {
            $data['phone'] = $user->phone;
        }

        // Hitung jumlah field yang diubah
        $updatedFields = count(array_filter($data, function ($value) {
            return $value !== null;
        }));

        // Cek apakah ada field yang diubah
        if ($updatedFields === 0) {
            return response()->json([
                'message' => 'Anda belum memperbarui informasi profil'
            ], 422);
        }

        // Perbarui informasi user
        $user->update($data);

        return response()->json([
            'data' => $user,
            'message' => 'Informasi profil berhasil diperbarui'
        ], 200);
    }

}
