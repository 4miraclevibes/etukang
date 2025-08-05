<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Register new user
     */
    public function register(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'User berhasil didaftarkan',
            'data' => [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                ],
                'token' => $token,
                'token_type' => 'Bearer',
            ]
        ], 201);
    }

    /**
     * Login user
     */
    public function login(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Email atau password salah'
            ], 401);
        }

        $user = User::where('email', $request->email)->firstOrFail();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login berhasil',
            'data' => [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                ],
                'token' => $token,
                'token_type' => 'Bearer',
            ]
        ]);
    }

    /**
     * Logout user (revoke token)
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logout berhasil'
        ]);
    }

    /**
     * Get user profile
     */
    public function profile(Request $request): JsonResponse
    {
        $user = $request->user();

        return response()->json([
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'email_verified_at' => $user->email_verified_at,
                'created_at' => $user->created_at->format('d/m/Y H:i'),
                'updated_at' => $user->updated_at->format('d/m/Y H:i'),
            ]
        ]);
    }

    /**
     * Update user profile
     */
    public function updateProfile(Request $request): JsonResponse
    {
        // Cek dulu apakah user sudah login
        if (!Auth::check()) {
            return response()->json([
                'message' => 'Akses ditolak: Anda belum login atau token tidak valid.',
                'error' => 'UNAUTHENTICATED',
                'hint' => 'Pastikan sudah login dan mengirimkan Authorization: Bearer <token>'
            ], 401);
        }

        // Definisikan rules validasi
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . Auth::id(),
        ];

        // Custom pesan error per field
        $messages = [
            'name.required' => 'Nama wajib diisi.',
            'name.string' => 'Nama harus berupa teks.',
            'name.max' => 'Nama maksimal 255 karakter.',
            'email.required' => 'Email wajib diisi.',
            'email.string' => 'Email harus berupa teks.',
            'email.email' => 'Format email tidak valid.',
            'email.max' => 'Email maksimal 255 karakter.',
            'email.unique' => 'Email sudah digunakan.',
        ];

        // Jalankan validasi manual
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            // Ambil semua error
            $errors = $validator->errors()->toArray();

            // Custom format response error
            return response()->json([
                'message' => 'Validasi gagal',
                'errors' => $errors,
                'hint' => 'Periksa kembali data yang dikirim'
            ], 422);
        }

        try {
            $user = Auth::user();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Profile berhasil diperbarui',
                'data' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memperbarui profile',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Change password
     */
    public function changePassword(Request $request): JsonResponse
    {
        // Cek dulu apakah user sudah login
        if (!Auth::check()) {
            return response()->json([
                'message' => 'Akses ditolak: Anda belum login atau token tidak valid.',
                'error' => 'UNAUTHENTICATED',
                'hint' => 'Pastikan sudah login dan mengirimkan Authorization: Bearer <token>'
            ], 401);
        }

        // Definisikan rules validasi
        $rules = [
            'old_password' => 'required|string',
            'new_password' => 'required|string|min:8',
        ];

        // Custom pesan error per field
        $messages = [
            'old_password.required' => 'Password lama wajib diisi.',
            'old_password.string' => 'Password lama harus berupa teks.',
            'new_password.required' => 'Password baru wajib diisi.',
            'new_password.string' => 'Password baru harus berupa teks.',
            'new_password.min' => 'Password baru minimal 8 karakter.',
        ];

        // Jalankan validasi manual
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()->toArray(),
                'hint' => 'Periksa kembali data yang dikirim'
            ], 422);
        }

        try {
            $user = Auth::user();

            if (!Hash::check($request->old_password, $user->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Password lama tidak sesuai',
                    'error' => 'INVALID_OLD_PASSWORD'
                ], 400);
            }

            $user->password = Hash::make($request->new_password);
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Password berhasil diubah'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengubah password',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Refresh token
     */
    public function refreshToken(Request $request): JsonResponse
    {
        $user = $request->user();

        // Revoke current token
        $request->user()->currentAccessToken()->delete();

        // Create new token
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Token berhasil diperbarui',
            'data' => [
                'token' => $token,
                'token_type' => 'Bearer',
            ]
        ]);
    }
}
