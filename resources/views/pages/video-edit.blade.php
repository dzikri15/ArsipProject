@extends('layouts.app')

@section('title', 'Edit Video')
@section('page-title', 'Edit Video')

@section('content')
<div class="page-header">
  <div>
    <div class="page-heading">🎬 Edit Video</div>
    <div class="page-sub">{{ $video['judul'] ?? 'Edit Video' }}</div>
  </div>
</div>

<div class="panel">
  <div class="panel-body">
    <form action="{{ route('video.update', $video['id']) }}" method="POST" enctype="multipart/form-data">
      @csrf
      @method('PUT')

      <div class="form-group">
        <label class="form-label">Judul Video</label>
        <input type="text" name="judul" value="{{ $video['judul'] }}" class="form-input" required>
      </div>

      <div class="form-group">
        <label class="form-label">Deskripsi (Opsional)</label>
        <textarea name="deskripsi" class="form-input" placeholder="Deskripsi singkat..." style="min-height: 100px; resize: vertical;">{{ $video['deskripsi'] }}</textarea>
      </div>

      <div class="form-group">
        <label class="form-label">File Video (Opsional)</label>
        <input type="file" name="file" class="form-input" accept=".mp4,.mov,.avi,.mkv">
        <div style="font-size: 12px; color: var(--text3); margin-top: 6px;">MP4, MOV, AVI, MKV — Maks. 2GB</div>
      </div>

      <div style="display: flex; gap: 12px; margin-top: 24px;">
        <button type="submit" class="btn btn-danger">Simpan Perubahan</button>
        <a href="{{ route('video') }}" class="btn btn-outline">Batal</a>
      </div>
    </form>
  </div>
</div>
@endsection
