@extends('layouts.app')

@section('title', 'Detail Foto')
@section('page-title', 'Detail Foto')

@section('content')
<div class="page-header">
  <div>
    <div class="page-heading">🖼️ Detail Foto</div>
    <div class="page-sub">{{ $foto->judul }}</div>
  </div>
</div>

<div class="panel">
  <div class="panel-body">
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
      <div>
        <img src="{{ Illuminate\Support\Facades\Storage::url($foto->file_path) }}" alt="{{ $foto->judul }}" style="width: 100%; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
      </div>
      <div>
        <div class="form-group">
          <label>Judul</label>
          <div style="font-size: 16px; font-weight: 500;">{{ $foto->judul }}</div>
        </div>
        <div class="form-group">
          <label>Pemilik</label>
          <div style="font-size: 14px;">{{ $foto->user->nama ?? 'N/A' }}</div>
        </div>
        <div class="form-group">
          <label>Ukuran</label>
          <div style="font-size: 14px;">{{ $foto->ukuran }}</div>
        </div>
        <div class="form-group">
          <label>Tanggal Upload</label>
          <div style="font-size: 14px;">{{ $foto->created_at->format('d M Y H:i') }}</div>
        </div>
        <div class="form-group">
          <label>Deskripsi</label>
          <div style="font-size: 14px; color: var(--text2);">{{ $foto->deskripsi ?? '-' }}</div>
        </div>
        <div style="display: flex; gap: 8px; margin-top: 20px;">
          <a href="{{ route('foto.edit', $foto->id) }}" class="btn btn-danger">Edit</a>
          <a href="{{ route('foto') }}" class="btn btn-outline">Kembali</a>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
