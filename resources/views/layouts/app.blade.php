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
  
  <!-- DataTables CSS -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
  
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

    /* Submenu Dropdown */
    .menu-group {
      display: flex;
      flex-direction: column;
    }

    .menu-group-header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 10px 14px;
      color: #94a3b8;
      border-radius: 8px;
      font-size: 14px;
      font-weight: 600;
      cursor: pointer;
      user-select: none;
      transition: all 0.2s;
    }

    .menu-group-header:hover, .menu-group.open .menu-group-header {
      background-color: rgba(255, 255, 255, 0.05);
      color: #f1f5f9;
    }

    .menu-group.active .menu-group-header {
      color: #60a5fa;
    }

    .menu-group-left {
      display: flex;
      align-items: center;
      gap: 12px;
    }

    .menu-group-arrow {
      font-size: 10px;
      transition: transform 0.25s ease;
      color: #64748b;
    }

    .menu-group.open .menu-group-arrow {
      transform: rotate(180deg);
      color: #60a5fa;
    }

    .submenu-list {
      list-style: none;
      padding: 4px 0 6px 36px;
      margin: 0;
      display: none;
      flex-direction: column;
      gap: 3px;
      border-left: 2px solid rgba(255, 255, 255, 0.08);
      margin-left: 24px;
    }

    .menu-group.open .submenu-list {
      display: flex;
    }

    .submenu-item {
      margin: 0;
      padding: 0;
    }

    .submenu-link {
      display: flex;
      align-items: center;
      gap: 8px;
      padding: 7px 12px;
      color: #94a3b8;
      text-decoration: none;
      border-radius: 6px;
      font-size: 13px;
      font-weight: 500;
      transition: all 0.2s;
    }

    .submenu-link:hover, .submenu-link.active {
      background-color: rgba(37, 99, 235, 0.18);
      color: #60a5fa;
      font-weight: 600;
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
    .badge-customer { background: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd; }
    .badge-superadmin { background: #fee2e2; color: #991b1b; font-weight: 700; }
    .badge-owner { background: #f3e8ff; color: #6b21a8; font-weight: 700; }
    .badge-admin { background: #dbeafe; color: #1e40af; font-weight: 700; }
    .badge-kasir { background: #d1fae5; color: #065f46; font-weight: 700; }
    .badge-cadangan { background: #e0e7ff; color: #3730a3; font-weight: 700; }

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

    /* ─── DataTables Custom Styling ─── */
    .dataTables_wrapper {
      width: 100%;
      position: relative;
      clear: both;
      padding: 4px 0;
    }

    .dataTables_wrapper .dataTables_length {
      float: left;
      font-size: 13px;
      font-weight: 600;
      color: var(--text-muted);
      margin-bottom: 16px;
    }

    .dataTables_wrapper .dataTables_length label {
      display: inline-flex;
      align-items: center;
      gap: 8px;
    }

    .dataTables_wrapper .dataTables_length select {
      padding: 6px 12px;
      border-radius: 8px;
      border: 1px solid var(--border-color);
      background-color: var(--bg-main);
      color: var(--text-main);
      font-weight: 700;
      font-size: 13px;
      outline: none;
      cursor: pointer;
    }

    .dataTables_wrapper .dataTables_filter {
      float: right;
      font-size: 13px;
      font-weight: 600;
      color: var(--text-muted);
      margin-bottom: 16px;
    }

    .dataTables_wrapper .dataTables_filter label {
      display: inline-flex;
      align-items: center;
      gap: 8px;
    }

    .dataTables_wrapper .dataTables_filter input {
      padding: 7px 14px;
      border-radius: 8px;
      border: 1px solid var(--border-color);
      background-color: var(--bg-main);
      color: var(--text-main);
      font-size: 13px;
      outline: none;
      transition: border-color 0.2s, box-shadow 0.2s;
      min-width: 220px;
    }

    .dataTables_wrapper .dataTables_filter input:focus {
      border-color: var(--primary);
      box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
    }

    .dataTables_wrapper .dataTables_info {
      float: left;
      padding-top: 16px;
      font-size: 13px;
      color: var(--text-muted);
      font-weight: 500;
    }

    .dataTables_wrapper .dataTables_paginate {
      float: right;
      padding-top: 14px;
      display: flex;
      gap: 4px;
      align-items: center;
      flex-wrap: wrap;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button {
      padding: 6px 12px;
      border-radius: 8px;
      border: 1px solid var(--border-color) !important;
      background: var(--bg-main) !important;
      color: var(--text-main) !important;
      font-size: 13px;
      font-weight: 600;
      cursor: pointer;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      min-width: 34px;
      transition: all 0.2s;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
      background: var(--border-color) !important;
      color: var(--text-main) !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current,
    .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
      background: var(--primary) !important;
      color: #fff !important;
      border-color: var(--primary) !important;
      box-shadow: 0 2px 6px rgba(37, 99, 235, 0.3);
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.disabled,
    .dataTables_wrapper .dataTables_paginate .paginate_button.disabled:hover {
      opacity: 0.4;
      cursor: not-allowed;
      background: var(--bg-main) !important;
    }

    table.dataTable thead th {
      border-bottom: 2px solid var(--border-color) !important;
    }

    table.dataTable.no-footer {
      border-bottom: 1px solid var(--border-color) !important;
    }

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

      .dataTables_wrapper .dataTables_length,
      .dataTables_wrapper .dataTables_filter,
      .dataTables_wrapper .dataTables_info,
      .dataTables_wrapper .dataTables_paginate {
        float: none !important;
        width: 100% !important;
        justify-content: center;
        text-align: center;
        margin-left: 0;
        margin-right: 0;
      }
      .dataTables_wrapper .dataTables_filter input {
        width: 100%;
        min-width: auto;
      }
      .dataTables_wrapper .dataTables_paginate {
        justify-content: center;
      }
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

      <div class="menu-header">Produk & Katalog</div>

      @if(auth()->user()->hasPermission('produk'))
      <a href="{{ route('produk.index') }}" class="menu-item {{ request()->routeIs('produk.*') ? 'active' : '' }}">
        <span class="icon">💡</span> Kelola Produk
      </a>
      @endif

      @if(auth()->user()->hasPermission('kategori'))
      <a href="{{ route('kategori.index') }}" class="menu-item {{ request()->routeIs('kategori.*') ? 'active' : '' }}">
        <span class="icon">📂</span> Kelola Kategori
      </a>
      @endif

      @if(auth()->user()->hasPermission('portfolio'))
      <a href="{{ route('portfolio.index') }}" class="menu-item {{ request()->routeIs('portfolio.*') ? 'active' : '' }}">
        <span class="icon">🖼️</span> Kelola Portofolio
      </a>
      @endif

      <div class="menu-header">Manajemen Order</div>

      @if(auth()->user()->hasPermission('status_order'))
      <a href="{{ route('status_order.index') }}" class="menu-item {{ request()->routeIs('status_order.*') ? 'active' : '' }}">
        <span class="icon">📋</span> Status Pengerjaan
      </a>
      @endif

      @if(auth()->user()->hasPermission('pembayaran'))
      <a href="{{ route('pembayaran.index') }}" class="menu-item {{ request()->routeIs('pembayaran.*') ? 'active' : '' }}">
        <span class="icon">💳</span> Data Pembayaran
      </a>
      @endif

      <div class="menu-header">Pengaturan & Admin</div>

      @if(auth()->user()->hasPermission('users'))
      <!-- Sub-Modul Manajemen User -->
      <div class="menu-group {{ request()->routeIs('users.*', 'pelanggan.*') ? 'active open' : '' }}">
        <div class="menu-group-header" onclick="toggleSubmenu(this)">
          <div class="menu-group-left">
            <span class="icon">👥</span>
            <span>Manajemen User</span>
          </div>
          <span class="menu-group-arrow">▼</span>
        </div>
        <ul class="submenu-list">
          <li class="submenu-item">
            <a href="{{ route('users.index') }}" class="submenu-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
              <span>🛡️</span> Admin & Staf
            </a>
          </li>
          <li class="submenu-item">
            <a href="{{ route('pelanggan.index') }}" class="submenu-link {{ request()->routeIs('pelanggan.*') ? 'active' : '' }}">
              <span>🛍️</span> Pelanggan
            </a>
          </li>
        </ul>
      </div>
      @endif

      @if(auth()->user()->hasPermission('akses'))
      <!-- Sub-Modul Kelola Akses -->
      <div class="menu-group {{ request()->routeIs('akses.*') ? 'active open' : '' }}">
        <div class="menu-group-header" onclick="toggleSubmenu(this)">
          <div class="menu-group-left">
            <span class="icon">🔐</span>
            <span>Kelola Akses</span>
          </div>
          <span class="menu-group-arrow">▼</span>
        </div>
        <ul class="submenu-list">
          <li class="submenu-item">
            <a href="{{ route('akses.index') }}" class="submenu-link {{ request()->routeIs('akses.index') && !request()->routeIs('akses.pelanggan*') ? 'active' : '' }}">
              <span>🛡️</span> Admin & Staf
            </a>
          </li>
          <li class="submenu-item">
            <a href="{{ route('akses.pelanggan') }}" class="submenu-link {{ request()->routeIs('akses.pelanggan*') ? 'active' : '' }}">
              <span>🛍️</span> Pelanggan
            </a>
          </li>
        </ul>
      </div>
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

      @if(auth()->user()->isAdmin())
      <a href="{{ route('settings.whatsapp') }}" class="menu-item {{ request()->routeIs('settings.whatsapp*') ? 'active' : '' }}">
        <span class="icon">💬</span> Pengaturan Kontak WA
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

  <!-- jQuery & DataTables JS -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
  <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

  <script>
    function toggleSidebar() {
      document.getElementById('sidebar').classList.toggle('open');
    }

    function toggleSubmenu(header) {
      const group = header.closest('.menu-group');
      if (group) {
        group.classList.toggle('open');
      }
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

    // Global default DataTables config
    if (typeof $.fn.dataTable !== 'undefined') {
      $.extend(true, $.fn.dataTable.defaults, {
        responsive: true,
        pageLength: 25,
        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Semua"]],
        language: {
          search: "Cari:",
          searchPlaceholder: "Ketik untuk mencari...",
          lengthMenu: "Tampilkan _MENU_ data",
          info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
          infoEmpty: "Menampilkan 0 data",
          infoFiltered: "(difilter dari _MAX_ total data)",
          zeroRecords: "Tidak ada data yang cocok ditemukan",
          emptyTable: "Belum ada data tersedia",
          paginate: {
            first: "«",
            previous: "‹",
            next: "›",
            last: "»"
          }
        }
      });
    }
  </script>

  @yield('scripts')
</body>
</html>
