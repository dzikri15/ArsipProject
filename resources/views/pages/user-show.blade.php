@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6 flex items-center justify-between">
        <h1 class="text-3xl font-bold">Detail User</h1>
        <a href="{{ route('users') }}" class="px-4 py-2 bg-gray-500 text-white rounded">Kembali</a>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-semibold text-gray-600">Nama</label>
                <p class="text-lg">{{ $user['nama'] }}</p>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-600">Email</label>
                <p class="text-lg">{{ $user['email'] }}</p>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-600">NIM</label>
                <p class="text-lg">{{ $user['nim'] }}</p>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-600">Role</label>
                <p class="text-lg"><span class="badge badge-admin">{{ $user['role'] }}</span></p>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-600">Status</label>
                <p class="text-lg">{{ ucfirst($user['status']) }}</p>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-600">Dibuat</label>
                <p class="text-lg">{{ $user['dibuat'] }}</p>
            </div>
        </div>

        <div class="mt-6 flex gap-2">
            <a href="{{ route('users.edit', $user['id']) }}" class="px-4 py-2 bg-blue-500 text-white rounded">Edit</a>
            <a href="{{ route('users') }}" class="px-4 py-2 bg-gray-500 text-white rounded">Kembali</a>
        </div>
    </div>
</div>
@endsection
