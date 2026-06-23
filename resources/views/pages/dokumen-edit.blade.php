@extends('layouts.app')

@section('title', 'Edit Dokumen')
@section('page-title', 'Edit Dokumen')

@section('content')
<div class="page-header">
  <div>
    <div class="page-heading">📄 Edit Dokumen</div>
    <div class="page-sub">{{ $dokumen['judul'] ?? 'Edit Dokumen' }}</div>
  </div>
</div>

<div class="panel">
  <div class="panel-body">
    <form action="{{ route('dokumen.update', $dokumen['id']) }}" method="POST" enctype="multipart/form-data">
      @csrf
      @method('PUT')

      <div class="form-group">
        <label class="form-label">Judul Dokumen</label>
        <input type="text" name="judul" value="{{ $dokumen['judul'] }}" class="form-input" required>
      </div>

      <div class="form-group">
        <label class="form-label">Deskripsi (Opsional)</label>
        <textarea name="deskripsi" class="form-input" placeholder="Deskripsi singkat..." style="min-height: 100px; resize: vertical;">{{ $dokumen['deskripsi'] }}</textarea>
      </div>

      <div class="form-group">
        <label class="form-label">File Dokumen (Opsional)</label>
        <input type="file" name="file" class="form-input" accept=".pdf,.doc,.docx,.xls,.xlsx">
        <div style="font-size: 12px; color: var(--text3); margin-top: 6px;">PDF, DOCX, XLSX — Maks. 50MB</div>
      </div>

      <div style="display: flex; gap: 12px; margin-top: 24px;">
        <button type="submit" class="btn btn-danger">Simpan Perubahan</button>
        <a href="{{ route('dokumen') }}" class="btn btn-outline">Batal</a>
      </div>
    </form>
  </div>
</div>
@endsection
