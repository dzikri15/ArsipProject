<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Log as LogModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $user = session('user');
        $isAdmin = $user['role'] === 'admin';
        $users = User::latest()->paginate(15);
        return view('pages.users', compact('users', 'user', 'isAdmin'));
    }

    public function create()
    {
        $user = session('user');
        $isAdmin = $user['role'] === 'admin';
        return view('pages.users-create', compact('user', 'isAdmin'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'nim' => 'required|unique:users',
            'password' => 'required|min:6',
            'role' => 'required|in:admin,user',
        ]);

        try {
            $user = session('user');

            $newUser = User::create([
                'nama' => $validated['nama'],
                'email' => $validated['email'],
                'nim' => $validated['nim'],
                'password' => Hash::make($validated['password']),
                'role' => $validated['role'],
                'status' => true,
            ]);

            LogModel::create([
                'user_id' => $user['id'],
                'aksi' => 'create_user',
                'model' => 'User',
                'model_id' => $newUser->id,
                'keterangan' => 'Tambah user: ' . $newUser->nama,
                'ip_address' => request()->ip(),
            ]);

            return redirect()->route('user')->with('success', 'User berhasil ditambahkan');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal menambahkan user']);
        }
    }

    public function edit($id)
    {
        $user = session('user');
        $isAdmin = $user['role'] === 'admin';
        $editUser = User::findOrFail($id);
        return view('pages.users-edit', compact('editUser', 'user', 'isAdmin'));
    }

    public function update(Request $request, $id)
    {
        $user = session('user');
        $editUser = User::findOrFail($id);

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required|in:admin,user',
        ]);

        try {
            $editUser->update($validated);

            LogModel::create([
                'user_id' => $user['id'],
                'aksi' => 'update_user',
                'model' => 'User',
                'model_id' => $editUser->id,
                'keterangan' => 'Update user: ' . $editUser->nama,
                'ip_address' => request()->ip(),
            ]);

            return redirect()->route('user')->with('success', 'User berhasil diperbarui');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal memperbarui user']);
        }
    }

    public function destroy($id)
    {
        $user = session('user');
        $deleteUser = User::findOrFail($id);

        try {
            LogModel::create([
                'user_id' => $user['id'],
                'aksi' => 'delete_user',
                'model' => 'User',
                'model_id' => $deleteUser->id,
                'keterangan' => 'Hapus user: ' . $deleteUser->nama,
                'ip_address' => request()->ip(),
            ]);

            $deleteUser->delete();
            return redirect()->route('user')->with('success', 'User berhasil dihapus');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal menghapus user']);
        }
    }

    public function toggleStatus($id)
    {
        $user = session('user');
        $toggleUser = User::findOrFail($id);

        try {
            $toggleUser->update(['status' => !$toggleUser->status]);

            LogModel::create([
                'user_id' => $user['id'],
                'aksi' => $toggleUser->status ? 'activate_user' : 'deactivate_user',
                'model' => 'User',
                'model_id' => $toggleUser->id,
                'keterangan' => ($toggleUser->status ? 'Aktifkan' : 'Nonaktifkan') . ' user: ' . $toggleUser->nama,
                'ip_address' => request()->ip(),
            ]);

            return redirect()->route('user')->with('success', 'Status user berhasil diubah');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal mengubah status user']);
        }
    }
}
