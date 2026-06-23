@extends('layouts.app')

@section('title', 'Pencarian')
@section('page-title', 'Pencarian')

@section('content')
<div class="page-header">
  <div>
    <div class="page-heading">🔍 Pencarian</div>
    <div class="page-sub">Cari arsip berdasarkan kata kunci</div>
  </div>
</div>

<form method="GET" action="{{ route('pencarian') }}">
  <div class="search-bar-wrap">
    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
      <circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/>
    </svg>
    <input class="search-input" type="text" name="q" value="{{ $keyword }}"
      placeholder="Ketik kata kunci pencarian... (contoh: KKN, Wisuda, 2026)">
  </div>

  <div class="category-tabs">
    @foreach(['semua' => 'Semua', 'dokumen' => '📄 Dokumen', 'foto' => '🖼️ Foto', 'video' => '🎬 Video', 'link' => '🔗 Link'] as $val => $label)
      <button type="submit" name="kategori" value="{{ $val }}"
        class="tab {{ $kategori === $val ? 'active' : '' }}">{{ $label }}</button>
    @endforeach
  </div>
</form>

<div class="panel">
  <div class="panel-header">
    <span class="panel-title">Hasil Pencarian
      @if($keyword)
        <small style="font-size:12px;font-weight:400;color:var(--text3);">— "{{ $keyword }}" ({{ count($hasil) }} hasil)</small>
      @endif
    </span>
  </div>
  <div class="panel-body">
    <div class="table-wrap">
      <table>
        <thead>
          <tr><th>Judul</th><th>Kategori</th><th>Pemilik</th><th>Tanggal</th><th>Aksi</th></tr>
        </thead>
        <tbody>
          @forelse($hasil as $item)
          <tr>
            <td>{{ $item['judul'] }}</td>
            <td><span class="badge {{ $item['badge'] }}">{{ $item['kategori'] }}</span></td>
            <td>{{ $item['pemilik'] }}</td>
            <td>{{ $item['tanggal'] }}</td>
            <td><button class="btn btn-sm btn-outline" onclick="viewItem({{ $item['id'] }}, '{{ strtolower($item['kategori']) }}')" title="Lihat Detail">👁 Lihat</button></td>
          </tr>
          @empty
          <tr>
            <td colspan="5">
              <div class="empty-state">
                <div class="icon">🔍</div>
                <p>{{ $keyword ? 'Tidak ada hasil untuk "' . $keyword . '"' : 'Masukkan kata kunci untuk mencari arsip.' }}</p>
              </div>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
