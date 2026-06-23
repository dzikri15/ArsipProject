@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('topbar-action')

@endsection

@section('content')
<div class="page-header">
  <div>
    <div class="page-heading">Dashboard</div>
    <div class="page-sub">Selamat datang, {{ session('user.name') }} {{ session('user.role') === 'admin' ? '(Admin)' : '' }}</div>
  </div>
</div>

<!-- Stats -->
<div class="stats-grid">
  <a href="{{ route('dokumen') }}" class="stat-card stat-dokumen" style="text-decoration: none; cursor: pointer; transition: all 0.2s;">
    <div class="card-icon">📄</div>
    <div class="card-num">{{ $stats['dokumen'] }}</div>
    <div class="card-label">Dokumen</div>
    <div class="card-trend">↑ 3 baru minggu ini</div>
  </a>
  <a href="{{ route('foto') }}" class="stat-card stat-foto" style="text-decoration: none; cursor: pointer; transition: all 0.2s;">
    <div class="card-icon">🖼️</div>
    <div class="card-num">{{ $stats['foto'] }}</div>
    <div class="card-label">Foto</div>
    <div class="card-trend">↑ 12 baru minggu ini</div>
  </a>
  <a href="{{ route('video') }}" class="stat-card stat-video" style="text-decoration: none; cursor: pointer; transition: all 0.2s;">
    <div class="card-icon">🎬</div>
    <div class="card-num">{{ $stats['video'] }}</div>
    <div class="card-label">Video</div>
    <div class="card-trend">↑ 1 baru minggu ini</div>
  </a>
  <a href="{{ route('link') }}" class="stat-card stat-link" style="text-decoration: none; cursor: pointer; transition: all 0.2s;">
    <div class="card-icon">🔗</div>
    <div class="card-num">{{ $stats['link'] }}</div>
    <div class="card-label">Link</div>
    <div class="card-trend">↑ 5 baru minggu ini</div>
  </a>
</div>

<!-- Bottom panels -->
<div style="display:grid;grid-template-columns:2fr 1fr;gap:22px;">
  <!-- Arsip Terbaru -->
  <div class="panel">
    <div class="panel-header"><span class="panel-title">📋 Arsip Terbaru</span></div>
    <div class="panel-body">
      <div class="table-wrap">
        <table>
          <thead>
            <tr>
              <th>Judul</th>
              <th>Kategori</th>
              @if($isAdmin) <th>Pemilik</th> @endif
              <th>Tanggal</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach($arsipTerbaru as $item)
            <tr>
              <td>{{ $item['judul'] }}</td>
              <td><span class="badge {{ $item['badge'] }}">{{ $item['kategori'] }}</span></td>
              @if($isAdmin) <td>{{ $item['pemilik'] }}</td> @endif
              <td>{{ $item['tanggal'] }}</td>
              <td>
                <div class="td-actions">
                  <button class="btn btn-sm btn-outline" onclick="viewItem({{ $item['id'] }}, '{{ $item['type'] }}')" title="Lihat Detail">👁</button>
                  <button class="btn btn-sm btn-warn" onclick="editItem({{ $item['id'] }}, '{{ $item['type'] }}')" title="Edit">✏️</button>
                  <button class="btn btn-sm btn-danger" onclick="deleteItem({{ $item['id'] }}, '{{ $item['type'] }}', '{{ $item['judul'] }}')" title="Hapus">🗑</button>
                </div>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Log Aktivitas -->
  <div class="panel">
    <div class="panel-header"><span class="panel-title">📜 Log Aktivitas</span></div>
    <div class="panel-body">
      @foreach($logAktivitas as $log)
      <div class="log-item">
        <div class="log-avatar">{{ $log['initial'] }}</div>
        <div class="log-info">
          <div class="action">{{ $log['action'] }}</div>
          <div class="meta">{{ $log['user'] }} · {{ $log['waktu'] }}</div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</div>
@endsection

@section('modal-body')
<div style="padding: 20px; text-align: center; color: var(--text3);">
  <p>⚠️ Silakan navigasi ke halaman Dokumen, Foto, Video, atau Link untuk upload.</p>
</div>
@endsection
