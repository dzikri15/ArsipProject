@extends('layouts.app')

@section('title', 'Manajemen User')
@section('page-title', 'Manajemen User')

@section('topbar-action')
  <button class="btn btn-outline btn-sm" onclick="openModal('👤 Tambah User', 'users', '/users')">
    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
      <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
    </svg>
    Tambah
  </button>
@endsection

@section('content')
<div class="page-header">
  <div>
    <div class="page-heading">👥 Manajemen User</div>
    <div class="page-sub">Kelola akun pengguna sistem</div>
  </div>
</div>

<div class="panel">
  <div class="panel-body">
    <div class="table-wrap">
      <table>
        <thead>
          <tr><th>Nama</th><th>Email</th><th>Role</th><th>NIM</th><th>Status</th><th>Dibuat</th><th>Aksi</th></tr>
        </thead>
        <tbody>
          @foreach($users as $u)
          <tr>
            <td><b>{{ $u->nama }}</b></td>
            <td>{{ $u->email }}</td>
            <td><span class="badge {{ $u->role === 'admin' ? 'badge-info' : 'badge-default' }}">{{ $u->role }}</span></td>
            <td>{{ $u->nim }}</td>
            <td><span class="badge {{ $u->status ? 'badge-success' : 'badge-warning' }}">{{ $u->status ? 'Aktif' : 'Nonaktif' }}</span></td>
            <td>{{ $u->created_at->format('d M Y H:i') }}</td>
            <td>
              <div class="td-actions">
                <button class="btn btn-sm btn-warn" onclick="editItem({{ $u->id }}, 'users')" title="Edit">✏️</button>
                @if($u->role !== 'admin')
                  <button class="btn btn-sm btn-danger" onclick="deleteItem({{ $u->id }}, 'users', '{{ $u->nama }}')" title="Hapus">🗑</button>
                @endif
              </div>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection

@section('modal-body')
<div class="form-row">
  <div class="form-group">
    <label class="form-label">Nama Lengkap</label>
    <input type="text" name="nama" class="form-input" placeholder="Nama lengkap..." required>
  </div>
  <div class="form-group">
    <label class="form-label">NIM</label>
    <input type="text" name="nim" class="form-input" placeholder="20241234567" required>
  </div>
</div>
<div class="form-group">
  <label class="form-label">Email</label>
  <input type="email" name="email" class="form-input" placeholder="email@ukri.ac.id" required>
</div>
<div class="form-row">
  <div class="form-group">
    <label class="form-label">Password</label>
    <input type="password" name="password" class="form-input" placeholder="Minimal 8 karakter" required>
  </div>
  <div class="form-group">
    <label class="form-label">Konfirmasi Password</label>
    <input type="password" name="password_confirmation" class="form-input" placeholder="Ulangi password" required>
  </div>
</div>
<div class="form-group">
  <label class="form-label">Role</label>
  <select name="role" class="form-select" required>
    <option value="user">User</option>
    <option value="admin">Admin</option>
  </select>
</div>
@endsection
