@extends('layouts.app')

@section('title', 'Arsip Foto')
@section('page-title', 'Arsip Foto')

@section('topbar-action')
  <button class="btn btn-outline btn-sm" onclick="openModal('🖼️ Upload Foto', 'foto', '/foto')">
    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
      <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
    </svg>
    Tambah
  </button>
@endsection

@section('content')
<div class="page-header">
  <div>
    <div class="page-heading">🖼️ Arsip Foto</div>
    <div class="page-sub">Kelola koleksi foto</div>
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
            <th>Tanggal</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @if($foto->count() > 0)
            @foreach($foto as $f)
            <tr>
              <td>{{ $f->judul }}</td>
              @if($isAdmin) <td>{{ $f->user->nama ?? 'N/A' }}</td> @endif
              <td>{{ $f->ukuran }}</td>
              <td>{{ $f->created_at->format('d M Y H:i') }}</td>
              <td>
                <div class="td-actions">
                  <button class="btn btn-sm btn-outline" onclick="viewItem({{ $f->id }}, 'foto')" title="Lihat">👁</button>
                  <button class="btn btn-sm btn-warn" onclick="editItem({{ $f->id }}, 'foto')" title="Edit">✏️</button>
                  <button class="btn btn-sm btn-danger" onclick="deleteItem({{ $f->id }}, 'foto', '{{ $f->judul }}')" title="Hapus">🗑</button>
                </div>
              </td>
            </tr>
            @endforeach
          @else
            <tr>
              <td colspan="5" style="text-align: center; padding: 40px; color: var(--text2);">
                <div style="font-size: 36px; margin-bottom: 8px;">🖼️</div>
                <p style="margin: 0;">Belum ada foto</p>
              </td>
            </tr>
          @endif
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection

@section('modal-body')
<div class="form-group">
  <label class="form-label">Judul Foto</label>
  <input type="text" name="judul" class="form-input" placeholder="Masukkan judul foto..." required>
</div>
<div class="form-group">
  <label class="form-label">File Foto</label>
  <div class="file-drop" style="border: 2px dashed var(--border); border-radius: 8px; padding: 24px; text-align: center; cursor: pointer; transition: all 0.2s;">
    <div class="icon" style="font-size: 32px; margin-bottom: 8px;">🖼️</div>
    <p style="margin: 0; font-weight: 500;">Klik atau seret foto ke sini</p>
    <p style="font-size: 12px; color: var(--text3); margin: 6px 0 0 0;">JPG, PNG, WEBP — Maks. 10MB</p>
  </div>
  <input type="file" name="file" style="display: none;" accept=".jpg,.jpeg,.png,.webp" required>
</div>
<div class="form-group">
  <label class="form-label">Deskripsi (Opsional)</label>
  <textarea name="deskripsi" class="form-input" placeholder="Deskripsi singkat..." style="min-height: 80px; resize: vertical;"></textarea>
</div>
@endsection
