@extends('layouts.app')

@section('title', 'Arsip Dokumen')
@section('page-title', 'Arsip Dokumen')

@section('topbar-action')
  <button class="btn btn-outline btn-sm" onclick="openModal('📄 Upload Dokumen', 'dokumen', '/dokumen')">
    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
      <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
    </svg>
    Tambah
  </button>
@endsection

@section('content')
<div class="page-header">
  <div>
    <div class="page-heading">📄 Arsip Dokumen</div>
    <div class="page-sub">Kelola dokumen digital</div>
  </div>
</div>

<div class="panel">
  <div class="panel-body">
    <div class="table-wrap">
      <table>
        <thead>
          <tr>
            <th>Judul</th>
            @if($isAdmin) <th>Pemilik</th> @endif
            <th>Ukuran</th>
            <th>Tanggal Upload</th>
            <th>Tipe</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($dokumen as $dok)
          <tr>
            <td>{{ $dok->judul }}</td>
            @if($isAdmin) <td>{{ $dok->user->nama ?? 'N/A' }}</td> @endif
            <td>{{ $dok->ukuran }}</td>
            <td>{{ $dok->created_at->format('d M Y H:i') }}</td>
            <td><span class="badge" style="background-color: #e3f2fd; color: #1976d2;">{{ $dok->tipe }}</span></td>
            <td>
              <div class="td-actions">
                <button class="btn btn-sm btn-outline" onclick="viewItem({{ $dok->id }}, 'dokumen')" title="Lihat">👁</button>
                <button class="btn btn-sm btn-warn" onclick="editItem({{ $dok->id }}, 'dokumen')" title="Edit">✏️</button>
                <button class="btn btn-sm btn-danger" onclick="deleteItem({{ $dok->id }}, 'dokumen', '{{ $dok->judul }}')" title="Hapus">🗑</button>
              </div>
            </td>
          </tr>
          @empty
          <tr><td colspan="6" style="text-align:center;color:var(--text3);padding:32px;">Belum ada dokumen.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection

@section('modal-body')
<div class="form-group">
  <label class="form-label">Judul Dokumen</label>
  <input type="text" name="judul" class="form-input" placeholder="Masukkan judul dokumen..." required>
</div>
<div class="form-group">
  <label class="form-label">File Dokumen</label>
  <div class="file-drop" style="border: 2px dashed var(--border); border-radius: 8px; padding: 24px; text-align: center; cursor: pointer; transition: all 0.2s;">
    <div class="icon" style="font-size: 32px; margin-bottom: 8px;">📄</div>
    <p style="margin: 0; font-weight: 500;">Klik atau seret file ke sini</p>
    <p style="font-size: 12px; color: var(--text3); margin: 6px 0 0 0;">PDF, DOCX, XLSX — Maks. 50MB</p>
  </div>
  <input type="file" name="file" style="display: none;" accept=".pdf,.doc,.docx,.xls,.xlsx" required>
</div>
<div class="form-group">
  <label class="form-label">Deskripsi (Opsional)</label>
  <textarea name="deskripsi" class="form-input" placeholder="Deskripsi singkat..." style="min-height: 80px; resize: vertical;"></textarea>
</div>
@endsection
