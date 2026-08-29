<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'Kaligraph Design') - Sistem Manajemen Neon Box & Signage</title>
  
  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  
  <style>
    :root {
      --bg-main: #f8fafc;
      --bg-card: #ffffff;
      --bg-sidebar: #0f172a;
      --text-main: #0f172a;
      --text-muted: #64748b;
      --border-color: #e2e8f0;
      --primary: #2563eb;
      --primary-hover: #1d4ed8;
      --primary-light: #dbeafe;
      --accent: #3b82f6;
      --success: #10b981;
      --warning: #f59e0b;
      --danger: #ef4444;
      --purple: #8b5cf6;
      --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
      --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
      --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
      --radius: 12px;
    }

    [data-theme="dark"] {
      --bg-main: #0b0f19;
      --bg-card: #1e293b;
      --bg-sidebar: #020617;
      --text-main: #f8fafc;
      --text-muted: #94a3b8;
      --border-color: #334155;
      --primary-light: #1e3a8a;
      --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.5);
      --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.3);
      --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.4);
    }

    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      font-family: 'Plus Jakarta Sans', sans-serif;
    }

    body {
      background-color: var(--bg-main);
      color: var(--text-main);
      display: flex;
      min-height: 100vh;
      transition: background-color 0.3s, color 0.3s;
    }

    /* Sidebar */
    .sidebar {
      width: 260px;
      background-color: var(--bg-sidebar);
      color: #fff;
      display: flex;
      flex-direction: column;
      position: fixed;
      top: 0;
      bottom: 0;
      left: 0;
      z-index: 100;
      transition: transform 0.3s ease;
    }

    .sidebar-brand {
      padding: 24px 20px;
      display: flex;
      align-items: center;
      gap: 12px;
      border-bottom: 1px solid rgba(255,255,255,0.08);
    }

    .sidebar-brand .logo-icon {
      width: 40px;
      height: 40px;
      background: linear-gradient(135deg, #2563eb, #7c3aed);
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 22px;
    }

    .sidebar-brand .brand-title {
      font-size: 18px;
      font-weight: 800;
      letter-spacing: -0.5px;
      color: #fff;
    }

    .sidebar-brand .brand-sub {
      font-size: 11px;
      color: #94a3b8;
      text-transform: uppercase;
      letter-spacing: 1px;
    }

    .sidebar-menu {
      flex: 1;
      padding: 16px 12px;
      overflow-y: auto;
      display: flex;
      flex-direction: column;
      gap: 4px;
    }

    .menu-header {
      font-size: 11px;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 1px;
      color: #64748b;
      margin: 16px 12px 6px;
    }

    .menu-item {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 10px 14px;
      color: #94a3b8;
      text-decoration: none;
      border-radius: 8px;
      font-size: 14px;
      font-weight: 500;
      transition: all 0.2s;
    }

    .menu-item:hover, .menu-item.active {
      background-color: rgba(37, 99, 235, 0.15);
      color: #60a5fa;
    }

    .menu-item .icon {
      font-size: 18px;
      width: 24px;
      text-align: center;
    }

    .sidebar-user {
      padding: 16px;
      border-top: 1px solid rgba(255,255,255,0.08);
      background-color: rgba(0,0,0,0.2);
    }

    .user-card {
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .user-avatar {
      width: 38px;
      height: 38px;
      border-radius: 50%;
      background-color: var(--primary);
      color: #fff;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: 700;
      font-size: 16px;
    }

    .user-info {
      flex: 1;
      overflow: hidden;
    }

    .user-name {
      font-weight: 600;
      font-size: 13px;
      color: #f8fafc;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }

    .user-role {
      font-size: 11px;
      color: #94a3b8;
      text-transform: capitalize;
    }

    /* Main Container */
    .main-wrapper {
      margin-left: 260px;
      flex: 1;
      display: flex;
      flex-direction: column;
      min-width: 0;
    }

    /* Topbar */
    .topbar {
      height: 70px;
      background-color: var(--bg-card);
      border-bottom: 1px solid var(--border-color);
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0 28px;
      position: sticky;
      top: 0;
      z-index: 90;
      box-shadow: var(--shadow-sm);
    }

    .topbar-left {
      display: flex;
      align-items: center;
      gap: 16px;
    }

    .toggle-sidebar-btn {
      display: none;
      background: none;
      border: none;
      font-size: 22px;
      cursor: pointer;
      color: var(--text-main);
    }

    .page-title {
      font-size: 20px;
      font-weight: 700;
      color: var(--text-main);
    }

    .topbar-right {
      display: flex;
      align-items: center;
      gap: 14px;
    }

    .branch-selector {
      display: flex;
      align-items: center;
      gap: 8px;
      background: var(--bg-main);
      border: 1px solid var(--border-color);
      border-radius: 8px;
      padding: 6px 12px;
      font-size: 13px;
    }

    .theme-toggle-btn {
      background: var(--bg-main);
      border: 1px solid var(--border-color);
      width: 38px;
      height: 38px;
      border-radius: 8px;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 18px;
      color: var(--text-main);
      transition: all 0.2s;
    }

    .theme-toggle-btn:hover {
      background: var(--border-color);
    }

    /* Content Area */
    .content-area {
      padding: 28px;
      flex: 1;
    }

    /* UI Components */
    .card {
      background-color: var(--bg-card);
      border: 1px solid var(--border-color);
      border-radius: var(--radius);
      padding: 24px;
      box-shadow: var(--shadow-sm);
      margin-bottom: 24px;
    }

    .card-header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 20px;
    }

    .card-title {
      font-size: 16px;
      font-weight: 700;
      color: var(--text-main);
    }

    /* Buttons */
    .btn {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      padding: 9px 16px;
      border-radius: 8px;
      font-size: 14px;
      font-weight: 600;
      cursor: pointer;
      border: none;
      transition: all 0.2s;
      text-decoration: none;
    }

    .btn-primary {
      background-color: var(--primary);
      color: #fff;
    }
    .btn-primary:hover {
      background-color: var(--primary-hover);
    }

    .btn-secondary {
      background-color: var(--bg-main);
      color: var(--text-main);
      border: 1px solid var(--border-color);
    }
    .btn-secondary:hover {
      background-color: var(--border-color);
    }

    .btn-danger {
      background-color: var(--danger);
      color: #fff;
    }
    .btn-danger:hover {
      opacity: 0.9;
    }

    .btn-sm {
      padding: 5px 10px;
      font-size: 12px;
      border-radius: 6px;
    }

    /* Form Elements */
    .form-group {
      margin-bottom: 16px;
    }

    .form-label {
      display: block;
      font-size: 13px;
      font-weight: 600;
      margin-bottom: 6px;
      color: var(--text-main);
    }

    .form-control {
      width: 100%;
      padding: 10px 14px;
      border-radius: 8px;
      border: 1px solid var(--border-color);
      background-color: var(--bg-main);
      color: var(--text-main);
      font-size: 14px;
      outline: none;
      transition: border-color 0.2s;
    }

    .form-control:focus {
      border-color: var(--primary);
    }

    /* Tables */
    .table-responsive {
      overflow-x: auto;
    }

    .table {
      width: 100%;
      border-collapse: collapse;
      font-size: 14px;
    }

    .table th {
      background-color: var(--bg-main);
      color: var(--text-muted);
      font-weight: 600;
      text-align: left;
      padding: 12px 16px;
      border-bottom: 1px solid var(--border-color);
    }

    .table td {
      padding: 14px 16px;
      border-bottom: 1px solid var(--border-color);
      color: var(--text-main);
    }

    .table tr:hover {
      background-color: rgba(37, 99, 235, 0.03);
    }

    /* Badges */
    .badge {
      display: inline-block;
      padding: 4px 10px;
      border-radius: 20px;
      font-size: 12px;
      font-weight: 600;
    }

    .badge-primary { background: #dbeafe; color: #1e40af; }
    .badge-success { background: #d1fae5; color: #065f46; }
    .badge-warning { background: #fef3c7; color: #92400e; }
    .badge-danger  { background: #fee2e2; color: #991b1b; }
    .badge-purple  { background: #f3e8ff; color: #6b21a8; }

    /* Alert / Flash */
    .alert {
      padding: 14px 18px;
      border-radius: 8px;
      margin-bottom: 20px;
      font-size: 14px;
      font-weight: 500;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .alert-success { background: #d1fae5; color: #065f46; border: 1px solid #a7f3d0; }
    .alert-error { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }

    /* Grid layout */
    .grid {
      display: grid;
      gap: 20px;
    }
    .grid-2 { grid-template-columns: repeat(2, 1fr); }
    .grid-3 { grid-template-columns: repeat(3, 1fr); }
    .grid-4 { grid-template-columns: repeat(4, 1fr); }

    /* Responsive */
    @media (max-width: 1024px) {
      .grid-4 { grid-template-columns: repeat(2, 1fr); }
      .grid-3 { grid-template-columns: 1fr; }
    }

    @media (max-width: 768px) {
      .sidebar { transform: translateX(-100%); }
      .sidebar.open { transform: translateX(0); }
      .main-wrapper { margin-left: 0; }
      .toggle-sidebar-btn { display: block; }
      .grid-2, .grid-4 { grid-template-columns: 1fr; }
    }
  </style>
  @yield('styles')
</head>
<body>

  <!-- Sidebar -->
  <aside class="sidebar" id="sidebar">
    <div class="sidebar-brand">
      <div class="logo-icon">💡</div>
      <div>
        <div class="brand-title">Kaligraph Design</div>
        <div class="brand-sub">Neon Box & Signage</div>
      </div>
    </div>

    <nav class="sidebar-menu">
      <div class="menu-header">Utama</div>
      <a href="{{ route('dashboard') }}" class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <span class="icon">📊</span> Dashboard
      </a>

      @if(auth()->user()->hasPermission('kasir'))
      <a href="{{ route('kasir.index') }}" class="menu-item {{ request()->routeIs('kasir.*') ? 'active' : '' }}">
        <span class="icon">🧾</span> Kasir / Order
      </a>
      @endif

      <div class="menu-header">Operasional</div>

      @if(auth()->user()->hasPermission('produk'))
      <a href="{{ route('produk.index') }}" class="menu-item {{ request()->routeIs('produk.*') ? 'active' : '' }}">
        <span class="icon">💡</span> Kelola Produk
      </a>
      @endif

      @if(auth()->user()->hasPermission('stok'))
      <a href="{{ route('stok.index') }}" class="menu-item {{ request()->routeIs('stok.*') ? 'active' : '' }}">
        <span class="icon">📦</span> Kelola Stok
      </a>
      @endif

      @if(auth()->user()->hasPermission('produksi'))
      <a href="{{ route('produksi.index') }}" class="menu-item {{ request()->routeIs('produksi.*') ? 'active' : '' }}">
        <span class="icon">🏭</span> Produksi
      </a>
      @endif

      @if(auth()->user()->hasPermission('operasional'))
      <a href="{{ route('operasional.index') }}" class="menu-item {{ request()->routeIs('operasional.*') ? 'active' : '' }}">
        <span class="icon">🛠️</span> Operasional
      </a>
      @endif

      <div class="menu-header">Pengaturan & Admin</div>

      @if(auth()->user()->hasPermission('users'))
      <a href="{{ route('users.index') }}" class="menu-item {{ request()->routeIs('users.*') ? 'active' : '' }}">
        <span class="icon">👥</span> Users
      </a>
      @endif

      @if(auth()->user()->hasPermission('akses'))
      <a href="{{ route('akses.index') }}" class="menu-item {{ request()->routeIs('akses.*') ? 'active' : '' }}">
        <span class="icon">🔐</span> Kelola Akses
      </a>
      @endif

      @if(auth()->user()->isOwner())
      <a href="{{ route('branches.index') }}" class="menu-item {{ request()->routeIs('branches.*') ? 'active' : '' }}">
        <span class="icon">🏪</span> Cabang & Showroom
      </a>
      @endif

      @if(auth()->user()->hasPermission('home_manager'))
      <a href="{{ route('home_manager.index') }}" class="menu-item {{ request()->routeIs('home_manager.*') ? 'active' : '' }}">
        <span class="icon">🌐</span> Landing Page Manager
      </a>
      @endif

      @if(auth()->user()->hasPermission('activity_log'))
      <a href="{{ route('activity_log.index') }}" class="menu-item {{ request()->routeIs('activity_log.*') ? 'active' : '' }}">
        <span class="icon">📜</span> Log Aktivitas
      </a>
      @endif

      <a href="{{ route('home') }}" target="_blank" class="menu-item">
        <span class="icon">🌐</span> Lihat Website
      </a>
    </nav>

    <div class="sidebar-user">
      <div class="user-card">
        <div class="user-avatar">
          {{ strtoupper(substr(auth()->user()->username, 0, 1)) }}
        </div>
        <div class="user-info">
          <div class="user-name">{{ auth()->user()->username }}</div>
          <div class="user-role">{{ auth()->user()->level }}</div>
        </div>
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit" class="btn btn-sm btn-secondary" title="Keluar">⏻</button>
        </form>
      </div>
    </div>
  </aside>

  <!-- Main Wrapper -->
  <div class="main-wrapper">
    <!-- Topbar -->
    <header class="topbar">
      <div class="topbar-left">
        <button class="toggle-sidebar-btn" onclick="toggleSidebar()">☰</button>
        <h1 class="page-title">@yield('title', 'Dashboard')</h1>
      </div>

      <div class="topbar-right">
        @if(auth()->user()->isOwner())
        <form method="POST" action="{{ route('switch-branch') }}" class="branch-selector">
          @csrf
          <span>🏢</span>
          <select name="branch_id" onchange="this.form.submit()" style="border:none; background:transparent; font-size:13px; font-weight:600; color:var(--text-main); cursor:pointer;">
            <option value="" {{ !session('active_branch_id') ? 'selected' : '' }}>Semua Cabang</option>
            @foreach(\App\Models\Branch::all() as $b)
              <option value="{{ $b->id }}" {{ session('active_branch_id') == $b->id ? 'selected' : '' }}>
                {{ $b->nama_cabang }}
              </option>
            @endforeach
          </select>
        </form>
        @endif

        <button class="theme-toggle-btn" onclick="toggleTheme()" id="themeBtn" title="Toggle Mode Dark/Light">
          🌙
        </button>
      </div>
    </header>

    <!-- Content Area -->
    <main class="content-area">
      @if(session('success'))
        <div class="alert alert-success">
          <span>✅</span> {{ session('success') }}
        </div>
      @endif

      @if(session('error'))
        <div class="alert alert-error">
          <span>⚠️</span> {{ session('error') }}
        </div>
      @endif

      @if($errors->any())
        <div class="alert alert-error">
          <span>⚠️</span>
          <ul style="margin-left: 20px;">
            @foreach($errors->all() as $err)
              <li>{{ $err }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      @yield('content')
    </main>
  </div>

  <script>
    function toggleSidebar() {
      document.getElementById('sidebar').classList.toggle('open');
    }

    function toggleTheme() {
      const html = document.documentElement;
      const current = html.getAttribute('data-theme');
      const next = current === 'dark' ? 'light' : 'dark';
      html.setAttribute('data-theme', next);
      document.getElementById('themeBtn').textContent = next === 'dark' ? '☀️' : '🌙';
      localStorage.setItem('theme', next);
    }

    // Load saved theme
    const savedTheme = localStorage.getItem('theme') || 'light';
    document.documentElement.setAttribute('data-theme', savedTheme);
    document.getElementById('themeBtn').textContent = savedTheme === 'dark' ? '☀️' : '🌙';
  </script>

  @yield('scripts')
</body>
</html>
