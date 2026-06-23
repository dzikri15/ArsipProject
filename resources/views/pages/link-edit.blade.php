@extends('layouts.app')

@section('title', 'Edit Link')
@section('page-title', 'Edit Link')

@section('content')
<div class="page-header">
  <div>
    <div class="page-heading">🔗 Edit Link</div>
    <div class="page-sub">{{ $link['judul'] ?? 'Edit Link' }}</div>
  </div>
</div>

<div class="panel">
  <div class="panel-body">
    <form action="{{ route('link.update', $link['id']) }}" method="POST">
      @csrf
      @method('PUT')

      <div class="form-group">
        <label class="form-label">Judul Link</label>
        <input type="text" name="judul" value="{{ $link['judul'] }}" class="form-input" placeholder="Judul tautan..." required>
      </div>

      <div class="form-group">
        <label class="form-label">URL</label>
        <input type="url" name="url" value="{{ $link['url'] }}" class="form-input" placeholder="https://example.com" required>
      </div>

      <div class="form-group">
        <label class="form-label">Deskripsi (Opsional)</label>
        <textarea name="deskripsi" class="form-input" placeholder="Deskripsi singkat..." style="min-height: 100px; resize: vertical;">{{ $link['deskripsi'] }}</textarea>
      </div>

      <div style="display: flex; gap: 12px; margin-top: 24px;">
        <button type="submit" class="btn btn-danger">Simpan Perubahan</button>
        <a href="{{ route('link') }}" class="btn btn-outline">Batal</a>
      </div>
    </form>
  </div>
</div>
@endsection
