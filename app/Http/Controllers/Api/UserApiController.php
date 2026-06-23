<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Log as LogModel;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class UserApiController extends Controller
{
    public function index(): JsonResponse
    {
        $users = User::latest()->paginate(15);
        return response()->json(['data' => $users], 200);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'nim' => 'nullable|string|unique:users',
            'password' => 'required|string|min:6',
            'role' => 'required|in:admin,user',
        ]);

        try {
            $user = User::create([
                'nama' => $validated['nama'],
                'email' => $validated['email'],
                'nim' => $validated['nim'] ?? null,
                'password' => Hash::make($validated['password']),
                'role' => $validated['role'],
                'status' => true,
            ]);

            LogModel::create([
                'user_id' => auth()->user()->id,
                'aksi' => 'create_user',
                'model' => 'User',
                'model_id' => $user->id,
                'keterangan' => 'Buat akun user: ' . $user->nama,
                'ip_address' => request()->ip(),
            ]);

            return response()->json(['data' => $user, 'message' => 'User berhasil dibuat'], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal membuat user'], 500);
        }
    }

    public function show(User $user): JsonResponse
    {
        return response()->json(['data' => $user], 200);
    }

    public function update(Request $request, User $user): JsonResponse
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'nim' => 'nullable|string|unique:users,nim,' . $user->id,
            'role' => 'required|in:admin,user',
        ]);

        try {
            $user->update($validated);

            LogModel::create([
                'user_id' => auth()->user()->id,
                'aksi' => 'update_user',
                'model' => 'User',
                'model_id' => $user->id,
                'keterangan' => 'Update user: ' . $user->nama,
                'ip_address' => request()->ip(),
            ]);

            return response()->json(['data' => $user, 'message' => 'User berhasil diperbarui'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal memperbarui user'], 500);
        }
    }

    public function destroy(User $user): JsonResponse
    {
        try {
            LogModel::create([
                'user_id' => auth()->user()->id,
                'aksi' => 'delete_user',
                'model' => 'User',
                'model_id' => $user->id,
                'keterangan' => 'Hapus user: ' . $user->nama,
                'ip_address' => request()->ip(),
            ]);

            $user->delete();
            return response()->json(['message' => 'User berhasil dihapus'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal menghapus user'], 500);
        }
    }

    public function toggleStatus(User $user): JsonResponse
    {
        try {
            $user->status = !$user->status;
            $user->save();

            LogModel::create([
                'user_id' => auth()->user()->id,
                'aksi' => 'toggle_user_status',
                'model' => 'User',
                'model_id' => $user->id,
                'keterangan' => 'Toggle status user: ' . $user->nama,
                'ip_address' => request()->ip(),
            ]);

            return response()->json(['data' => $user, 'message' => 'Status user berhasil diubah'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal mengubah status user'], 500);
        }
    }

    public function getActivity(User $user): JsonResponse
    {
        $logs = LogModel::where('user_id', $user->id)->latest()->paginate(20);
        return response()->json(['data' => $logs], 200);
    }
}
