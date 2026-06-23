@extends('layouts.app')

@section('title', 'Edit User')
@section('page-title', 'Edit User')

@section('content')
<div class="page-header">
  <div>
    <div class="page-heading">👤 Edit User</div>
    <div class="page-sub">Perbarui data pengguna sistem</div>
  </div>
</div>

<div class="panel">
  <div class="panel-body">
    <form action="{{ route('users.update', $editUser->id) }}" method="POST" class="form-vertical">
      @csrf
      @method('PUT')

      <div class="form-group">
        <label for="nama">Nama Lengkap *</label>
        <input type="text" id="nama" name="nama" value="{{ $editUser->nama }}" class="form-control" placeholder="Nama lengkap pengguna" required>
        @error('nama') <span class="text-danger">{{ $message }}</span> @enderror
      </div>

      <div class="form-group">
        <label for="email">Email *</label>
        <input type="email" id="email" name="email" value="{{ $editUser->email }}" class="form-control" placeholder="email@example.com" required>
        @error('email') <span class="text-danger">{{ $message }}</span> @enderror
      </div>

      <div class="form-group">
        <label for="nim">NIM/NPK</label>
        <input type="text" id="nim" name="nim" value="{{ $editUser->nim }}" class="form-control" placeholder="Nomor Induk Mahasiswa" readonly>
      </div>

      <div class="form-group">
        <label for="role">Role *</label>
        <select id="role" name="role" class="form-control" required>
          <option value="admin" {{ $editUser->role === 'admin' ? 'selected' : '' }}>Admin</option>
          <option value="user" {{ $editUser->role === 'user' ? 'selected' : '' }}>User</option>
        </select>
        @error('role') <span class="text-danger">{{ $message }}</span> @enderror
      </div>

      <div class="form-actions">
        <a href="{{ route('users') }}" class="btn btn-outline">Batal</a>
        <button type="submit" class="btn btn-danger">Simpan Perubahan</button>
      </div>
    </form>
  </div>
</div>

@endsection
