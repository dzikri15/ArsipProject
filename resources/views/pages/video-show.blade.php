@extends('layouts.app')

@section('title', 'Detail Video')
@section('page-title', 'Detail Video')

@section('content')
<div class="page-header">
  <div>
    <div class="page-heading">🎬 Detail Video</div>
    <div class="page-sub">{{ $video->judul }}</div>
  </div>
</div>

<div class="panel">
  <div class="panel-body">
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
      <div>
        @php
          $videoUrl = Illuminate\Support\Facades\Storage::url($video->file_path);
          $videoExt = strtolower(pathinfo($video->file_path, PATHINFO_EXTENSION));
          $videoType = match($videoExt) {
            'webm' => 'video/webm',
            'ogg' => 'video/ogg',
            'mov' => 'video/quicktime',
            'avi' => 'video/x-msvideo',
            default => 'video/mp4',
          };
        @endphp
        <video width="100%" height="auto" style="border-radius: 8px; background: #000; box-shadow: 0 2px 8px rgba(0,0,0,0.1);" controls>
          <source src="{{ $videoUrl }}" type="{{ $videoType }}">
          Your browser does not support the video tag.
        </video>
        <p style="margin-top: 12px; font-size: 13px; color: var(--text3);">
          <a href="{{ $videoUrl }}" target="_blank" style="color: var(--accent);">Buka atau download file video</a>
        </p>
      </div>
      <div>
        <div class="form-group">
          <label>Judul</label>
          <div style="font-size: 16px; font-weight: 500;">{{ $video->judul }}</div>
        </div>
        <div class="form-group">
          <label>Pemilik</label>
          <div style="font-size: 14px;">{{ $video->user->nama ?? 'N/A' }}</div>
        </div>
        <div class="form-group">
          <label>Durasi</label>
          <div style="font-size: 14px;">{{ $video->durasi ?? '-' }}</div>
        </div>
        <div class="form-group">
          <label>Ukuran</label>
          <div style="font-size: 14px;">{{ $video->ukuran }}</div>
        </div>
        <div class="form-group">
          <label>Tanggal Upload</label>
          <div style="font-size: 14px;">{{ $video->created_at->format('d M Y H:i') }}</div>
        </div>
        <div class="form-group">
          <label>Deskripsi</label>
          <div style="font-size: 14px; color: var(--text2);">{{ $video->deskripsi ?? '-' }}</div>
        </div>
        <div style="display: flex; gap: 8px; margin-top: 20px;">
          <a href="{{ route('video.edit', $video->id) }}" class="btn btn-danger">Edit</a>
          <a href="{{ route('video') }}" class="btn btn-outline">Kembali</a>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
