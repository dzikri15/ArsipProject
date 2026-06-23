@extends('layouts.app')

@section('title', 'Arsip Link')
@section('page-title', 'Arsip Link')

@section('topbar-action')
  <button class="btn btn-outline btn-sm" onclick="openModal('🔗 Tambah Link', 'link', '/link')">
    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
      <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
    </svg>
    Tambah
  </button>
@endsection

@section('content')
<div class="page-header">
  <div>
    <div class="page-heading">🔗 Arsip Link</div>
    <div class="page-sub">Kelola koleksi tautan</div>
  </div>
</div>

<div class="panel">
  <div class="panel-body">
    <div class="table-wrap">
      <table>
        <thead>
          <tr>
            <th>Judul</th>
            <th>URL</th>
            @if($isAdmin) <th>Pemilik</th> @endif
            <th>Deskripsi</th>
            <th>Tanggal</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($link as $l)
          <tr>
            @php
              $linkUrl = preg_match('/^https?:\/\//i', $l->url) ? $l->url : 'https://' . $l->url;
            @endphp
            <td>{{ $l->judul }}</td>
            <td><a href="{{ $linkUrl }}" target="_blank" style="color:var(--accent);font-size:12px;">{{ $l->url }}</a></td>
            @if($isAdmin) <td>{{ $l->user->nama ?? 'N/A' }}</td> @endif
            <td>{{ $l->deskripsi ?? '-' }}</td>
            <td>{{ $l->created_at->format('d M Y H:i') }}</td>
            <td>
              <div class="td-actions">
                <button class="btn btn-sm btn-outline" onclick="window.open('{{ $linkUrl }}', '_blank')" title="Buka Link">🔗</button>
                <button class="btn btn-sm btn-warn" onclick="editItem({{ $l->id }}, 'link')" title="Edit">✏️</button>
                <button class="btn btn-sm btn-danger" onclick="deleteItem({{ $l->id }}, 'link', '{{ $l->judul }}')" title="Hapus">🗑</button>
              </div>
            </td>
          </tr>
          @empty
          <tr><td colspan="6" style="text-align:center;color:var(--text3);padding:32px;">Belum ada tautan.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection

@section('modal-body')
<div class="form-group">
  <label class="form-label">Judul</label>
  <input type="text" name="judul" class="form-input" placeholder="Judul tautan..." required>
</div>
<div class="form-group">
  <label class="form-label">URL</label>
  <input type="url" name="url" class="form-input" placeholder="https://example.com" required>
</div>
<div class="form-group">
  <label class="form-label">Deskripsi (Opsional)</label>
  <textarea name="deskripsi" class="form-input" placeholder="Deskripsi singkat..." style="min-height: 80px; resize: vertical;"></textarea>
</div>
@endsection
