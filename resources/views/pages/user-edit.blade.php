@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6 flex items-center justify-between">
        <h1 class="text-3xl font-bold">Edit User</h1>
        <a href="{{ route('users') }}" class="px-4 py-2 bg-gray-500 text-white rounded">Kembali</a>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <form action="{{ route('users.update', $user['id']) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Nama</label>
                <input type="text" name="nama" value="{{ $user['nama'] }}" class="w-full px-4 py-2 border rounded" required>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                <input type="email" name="email" value="{{ $user['email'] }}" class="w-full px-4 py-2 border rounded" required>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-2">NIM</label>
                <input type="text" name="nim" value="{{ $user['nim'] }}" class="w-full px-4 py-2 border rounded" required>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Role</label>
                <select name="role" class="w-full px-4 py-2 border rounded" required>
                    <option value="admin" {{ $user['role'] === 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="user" {{ $user['role'] === 'user' ? 'selected' : '' }}>User</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Status</label>
                <select name="status" class="w-full px-4 py-2 border rounded" required>
                    <option value="aktif" {{ $user['status'] === 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="nonaktif" {{ $user['status'] === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Password (Kosongkan jika tidak ingin mengubah)</label>
                <input type="password" name="password" class="w-full px-4 py-2 border rounded">
            </div>

            <div class="flex gap-2">
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">Simpan</button>
                <a href="{{ route('users') }}" class="px-4 py-2 bg-gray-500 text-white rounded">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
