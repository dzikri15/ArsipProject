@extends('layouts.app')

@section('title', 'Tambah User')
@section('page-title', 'Tambah User Baru')

@section('content')
<div class="page-header">
  <div>
    <div class="page-heading">👤 Tambah User Baru</div>
    <div class="page-sub">Tambahkan pengguna ke sistem</div>
  </div>
</div>

<div class="panel">
  <div class="panel-body">
    <form action="{{ route('users.store') }}" method="POST" class="form-vertical">
      @csrf

      <div class="form-group">
        <label for="nama">Nama Lengkap *</label>
        <input type="text" id="nama" name="nama" class="form-control" placeholder="Nama lengkap pengguna" required>
        @error('nama') <span class="text-danger">{{ $message }}</span> @enderror
      </div>

      <div class="form-group">
        <label for="email">Email *</label>
        <input type="email" id="email" name="email" class="form-control" placeholder="email@example.com" required>
        @error('email') <span class="text-danger">{{ $message }}</span> @enderror
      </div>

      <div class="form-group">
        <label for="nim">NIM/NPK *</label>
        <input type="text" id="nim" name="nim" class="form-control" placeholder="Nomor Induk Mahasiswa" required>
        @error('nim') <span class="text-danger">{{ $message }}</span> @enderror
      </div>

      <div class="form-group">
        <label for="password">Password *</label>
        <input type="password" id="password" name="password" class="form-control" placeholder="Minimal 6 karakter" required>
        @error('password') <span class="text-danger">{{ $message }}</span> @enderror
      </div>

      <div class="form-group">
        <label for="role">Role *</label>
        <select id="role" name="role" class="form-control" required>
          <option value="">-- Pilih Role --</option>
          <option value="admin">Admin</option>
          <option value="user">User</option>
        </select>
        @error('role') <span class="text-danger">{{ $message }}</span> @enderror
      </div>

      <div class="form-actions">
        <a href="{{ route('users') }}" class="btn btn-outline">Batal</a>
        <button type="submit" class="btn btn-danger">Simpan User</button>
      </div>
    </form>
  </div>
</div>

@endsection
