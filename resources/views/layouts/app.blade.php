<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'Sistem Arsip Digital') — UKRI</title>
  <link
    href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap"
    rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body>

  <div class="app-layout">

    <!-- SIDEBAR -->
    <aside class="sidebar">
      <div class="sidebar-header">
        <div class="sidebar-logo">
          <div class="logo-icon">
            @php $sidebarLogoPath = public_path('images/ukri.jpg'); @endphp
            @if(file_exists($sidebarLogoPath))
              <img src="{{ asset('images/ukri.jpg') }}" alt="UKRI Logo">
            @else
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width=".5">
                <path d="M5 3h14a2 2 0 012 2v14a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2z" />
                <path d="M8 7h8M8 11h8M8 15h5" />
              </svg>
            @endif
          </div>
          <div class="logo-text">
            <div>Arsip Digital</div>
            <div class="logo-sub">UKRI 2026</div>
          </div>
        </div>
      </div>

      @php $user = session('user');
      $isAdmin = $user['role'] === 'admin'; @endphp

      <div class="sidebar-role {{ $isAdmin ? 'admin' : 'user' }}">
        {{ $isAdmin ? '👑 ADMIN' : '👤 USER' }}
      </div>

      <nav class="sidebar-nav">
        <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
          <span>📊</span><span>Dashboard</span>
        </a>
        <a href="{{ route('dokumen') }}" class="nav-item {{ request()->routeIs('dokumen') ? 'active' : '' }}">
          <span>📄</span><span>Dokumen</span>
        </a>
        <a href="{{ route('foto') }}" class="nav-item {{ request()->routeIs('foto') ? 'active' : '' }}">
          <span>🖼️</span><span>Foto</span>
        </a>
        <a href="{{ route('video') }}" class="nav-item {{ request()->routeIs('video') ? 'active' : '' }}">
          <span>🎬</span><span>Video</span>
        </a>
        <a href="{{ route('link') }}" class="nav-item {{ request()->routeIs('link') ? 'active' : '' }}">
          <span>🔗</span><span>Link</span>
        </a>
        <a href="{{ route('pencarian') }}" class="nav-item {{ request()->routeIs('pencarian') ? 'active' : '' }}">
          <span>🔍</span><span>Pencarian</span>
        </a>

        @if($isAdmin)
          <div class="nav-section">Admin</div>
          <a href="{{ route('users') }}" class="nav-item {{ request()->routeIs('users') ? 'active' : '' }}">
            <span>👥</span><span>Manajemen User</span>
          </a>
          <a href="{{ route('log') }}" class="nav-item {{ request()->routeIs('log') ? 'active' : '' }}">
            <span>📋</span><span>Log Aktivitas</span>
          </a>
        @endif
      </nav>

      <div class="sidebar-footer">
        <div class="sidebar-user">
          <div class="avatar">{{ $user['initial'] }}</div>
          <div class="info">
            <div class="name">{{ $user['name'] }}</div>
            <div class="email">{{ $user['email'] }}</div>
          </div>
          <form method="POST" action="{{ route('logout') }}" style="margin-left:auto;">
            @csrf
            <button type="submit" class="logout" title="Logout"
              style="background:none;border:none;cursor:pointer;padding:4px;">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4M16 17l5-5-5-5M21 12H9" />
              </svg>
            </button>
          </form>
        </div>
      </div>
    </aside>

    <!-- MAIN -->
    <main class="main">
      <div class="topbar">
        <div class="topbar-title">@yield('page-title', 'Dashboard')</div>
        <div class="topbar-right">
          <div class="topbar-notif" id="notifBell" onclick="toggleNotification()" style="cursor:pointer;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9M13.73 21a2 2 0 01-3.46 0" />
            </svg>
            <span class="dot" id="notifDot"></span>
          </div>
          @yield('topbar-action')
        </div>
      </div>

      <!-- Notifikasi Dropdown -->
      <div id="notifDropdown" class="notif-dropdown"
        style="display:none; position:absolute; top:60px; right:20px; width:320px; background:white; border-radius:8px; box-shadow:0 4px 12px rgba(0,0,0,0.15); z-index:1000; max-height:400px; overflow-y:auto;">
        <div style="padding:16px; border-bottom:1px solid var(--border);">
          <div style="font-weight:600; font-size:14px;">Notifikasi</div>
        </div>
        <div id="notifContent" style="max-height:300px; overflow-y:auto;">
          <div style="padding:20px; text-align:center; color:var(--text3); font-size:13px;">Tidak ada notifikasi baru
          </div>
        </div>
      </div>

      <div class="content">
        @if(session('error'))
          <div class="alert-error">{{ session('error') }}</div>
        @endif
        @yield('content')
      </div>
    </main>
  </div>

  <!-- MODAL -->
  <div class="modal-overlay" id="modalOverlay" onclick="if(event.target===this)closeModal()">
    <div class="modal">
      <div class="modal-title" id="modalTitle">📤 Tambah Baru</div>
      <form id="modalForm" method="POST" enctype="multipart/form-data">
        @csrf
        <div id="modalBody">@yield('modal-body')</div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline" onclick="closeModal()">Batal</button>
          <button type="submit" class="btn btn-danger" style="width:auto;">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
              <polyline points="20 6 9 17 4 12" />
            </svg>
            Simpan
          </button>
        </div>
      </form>
    </div>
  </div>

  <script src="{{ asset('js/app.js') }}"></script>
  @yield('scripts')
</body>

</html>