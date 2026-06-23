@extends('layouts.app')

@section('title', 'Log Aktivitas')
@section('page-title', 'Log Aktivitas')

@section('content')
<div class="page-header">
  <div>
    <div class="page-heading">📋 Log Aktivitas</div>
    <div class="page-sub">Riwayat seluruh aktivitas pengguna</div>
  </div>
  <div style="display:flex; gap:8px;">
    <button class="btn btn-outline btn-sm" onclick="exportData('csv')" style="display:flex; gap:6px; align-items:center;">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/>
      </svg>
      Export CSV
    </button>
    <button class="btn btn-outline btn-sm" onclick="exportData('pdf')" style="display:flex; gap:6px; align-items:center;">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/>
      </svg>
      Export PDF
    </button>
  </div>
</div>

<div class="panel">
  <div class="panel-body">
    @forelse($logs as $log)
      <div class="log-item">
        <div class="log-avatar">{{ strtoupper(substr($log->user->nama ?? 'U', 0, 1)) }}</div>
        <div class="log-info">
          <div class="action">
            <span class="badge badge-blue">{{ str_replace('_', ' ', $log->aksi) }}</span>
            {{ $log->keterangan ?? 'Tidak ada keterangan tambahan' }}
          </div>
          <div class="meta">
            {{ $log->user->nama ?? 'Pengguna tidak dikenal' }} · {{ $log->model ?? 'Sistem' }} · {{ $log->created_at->diffForHumans() }}
          </div>
          <div class="meta">
            ID: {{ $log->model_id ?? '-' }} · IP: {{ $log->ip_address ?? '-' }}
          </div>
        </div>
      </div>
    @empty
      <div class="empty-state">Belum ada aktivitas yang dicatat.</div>
    @endforelse

    @if(method_exists($logs, 'links'))
      <div style="margin-top:24px;">
        {{ $logs->links() }}
      </div>
    @endif
  </div>
</div>
@endsection
