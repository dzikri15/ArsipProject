@extends('layouts.app')

@section('title', 'Edit Foto')
@section('page-title', 'Edit Foto')

@section('content')
<div class="page-header">
  <div>
    <div class="page-heading">🖼️ Edit Foto</div>
    <div class="page-sub">{{ $foto['judul'] ?? 'Edit Foto' }}</div>
  </div>
</div>

<div class="panel">
  <div class="panel-body">
    <form action="{{ route('foto.update', $foto['id']) }}" method="POST" enctype="multipart/form-data">
      @csrf
      @method('PUT')

      <div class="form-group">
        <label class="form-label">Judul Foto</label>
        <input type="text" name="judul" value="{{ $foto['judul'] }}" class="form-input" required>
      </div>

      <div class="form-group">
        <label class="form-label">Deskripsi (Opsional)</label>
        <textarea name="deskripsi" class="form-input" placeholder="Deskripsi singkat..." style="min-height: 100px; resize: vertical;">{{ $foto['deskripsi'] }}</textarea>
      </div>

      <div class="form-group">
        <label class="form-label">File Foto (Opsional)</label>
        <input type="file" name="file" class="form-input" accept=".jpg,.jpeg,.png,.webp">
        <div style="font-size: 12px; color: var(--text3); margin-top: 6px;">JPG, PNG, WEBP — Maks. 10MB</div>
      </div>

      <div style="display: flex; gap: 12px; margin-top: 24px;">
        <button type="submit" class="btn btn-danger">Simpan Perubahan</button>
        <a href="{{ route('foto') }}" class="btn btn-outline">Batal</a>
      </div>
    </form>
  </div>
</div>
@endsection
