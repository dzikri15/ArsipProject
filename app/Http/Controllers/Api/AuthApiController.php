<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class AuthApiController extends Controller
{
    public function login(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        $user = User::where('email', $validated['email'])->first();

        if (!$user || !Hash::check($validated['password'], $user->password)) {
            return response()->json(['error' => 'Email atau password salah'], 401);
        }

        if (!$user->status) {
            return response()->json(['error' => 'User tidak aktif'], 403);
        }

        $token = $user->createToken('auth-token')->plainTextToken;

        return response()->json([
            'data' => [
                'user' => $user,
                'token' => $token,
            ],
            'message' => 'Login berhasil',
        ], 200);
    }

    public function register(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'nim' => 'nullable|string|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        try {
            $user = User::create([
                'nama' => $validated['nama'],
                'email' => $validated['email'],
                'nim' => $validated['nim'] ?? null,
                'password' => Hash::make($validated['password']),
                'role' => 'user',
                'status' => true,
            ]);

            $token = $user->createToken('auth-token')->plainTextToken;

            return response()->json([
                'data' => [
                    'user' => $user,
                    'token' => $token,
                ],
                'message' => 'Registrasi berhasil',
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal registrasi'], 500);
        }
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logout berhasil'], 200);
    }

    public function me(Request $request): JsonResponse
    {
        return response()->json(['data' => $request->user()], 200);
    }

    public function updateProfile(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $request->user()->id,
            'nim' => 'nullable|string|unique:users,nim,' . $request->user()->id,
        ]);

        try {
            $request->user()->update($validated);
            return response()->json(['data' => $request->user(), 'message' => 'Profil berhasil diperbarui'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal memperbarui profil'], 500);
        }
    }

    public function changePassword(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = $request->user();

        if (!Hash::check($validated['current_password'], $user->password)) {
            return response()->json(['error' => 'Password saat ini salah'], 401);
        }

        try {
            $user->update(['password' => Hash::make($validated['password'])]);
            return response()->json(['message' => 'Password berhasil diubah'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal mengubah password'], 500);
        }
    }

    public function forgotPassword(Request $request): JsonResponse
    {
        $validated = $request->validate(['email' => 'required|email']);

        $user = User::where('email', $validated['email'])->first();

        if (!$user) {
            return response()->json(['error' => 'User tidak ditemukan'], 404);
        }

        // TODO: Implement password reset logic with token
        return response()->json(['message' => 'Instruksi reset password telah dikirim ke email Anda'], 200);
    }
}
