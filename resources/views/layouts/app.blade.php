<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'Kafa Advertising') - Sistem Manajemen Neon Box & Signage</title>
  
  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  
  <!-- DataTables CSS -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
  
  <style>
    :root {
      --bg-main: #f1f4f7;
      --bg-card: #ffffff;
      --surface-soft: #f1f4f7;
      --bg-sidebar: #0a1317;
      --text-main: #0a1317;
      --text-body: #1c1e21;
      --text-muted: #5d6c7b;
      --text-stone: #8595a4;
      --border-color: #dee3e9;
      --hairline: #ced0d4;
      --hairline-soft: #dee3e9;
      --primary: #0064e0;
      --primary-hover: #0457cb;
      --primary-light: #e7f1fe;
      --ink-button: #000000;
      --ink-deep: #0a1317;
      --accent: #1876f2;
      --success: #31a24c;
      --warning: #f7b928;
      --danger: #e41e3f;
      --purple: #a121ce;
      --shadow-sm: 0 1px 3px rgba(10, 19, 23, 0.05);
      --shadow-md: rgba(20, 22, 26, 0.08) 0px 4px 16px;
      --shadow-sticky: rgba(20, 22, 26, 0.3) 0px 1px 4px 0px;
      --radius: 16px;
      --radius-lg: 24px;
      --radius-full: 100px;
    }

    [data-theme="dark"] {
      --bg-main: #0a1317;
      --bg-card: #141f26;
      --surface-soft: #1a2730;
      --bg-sidebar: #060b0d;
      --text-main: #f1f4f7;
      --text-body: #dee3e9;
      --text-muted: #8595a4;
      --text-stone: #5d6c7b;
      --border-color: #243542;
      --hairline: #314656;
      --hairline-soft: #243542;
      --primary-light: #0a2540;
      --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.4);
      --shadow-md: 0 4px 12px rgba(0, 0, 0, 0.3);
    }

    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
    }

    body {
      background-color: var(--bg-main);
      color: var(--text-body);
      display: flex;
      min-height: 100vh;
      transition: background-color 0.3s, color 0.3s;
      letter-spacing: -0.16px;
      -webkit-font-smoothing: antialiased;
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
      border-right: 1px solid rgba(255,255,255,0.06);
    }

    .sidebar-brand {
      padding: 22px 20px;
      display: flex;
      align-items: center;
      gap: 12px;
      border-bottom: 1px solid rgba(255,255,255,0.08);
    }

    .sidebar-brand .logo-icon {
      width: 38px;
      height: 38px;
      background: var(--primary);
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 20px;
      font-weight: 800;
      color: #ffffff;
    }

    .sidebar-brand .brand-title {
      font-size: 16px;
      font-weight: 700;
      letter-spacing: -0.3px;
      color: #fff;
    }

    .sidebar-brand .brand-sub {
      font-size: 11px;
      color: var(--text-stone);
      text-transform: uppercase;
      letter-spacing: 0.8px;
    }

    .sidebar-menu {
      flex: 1;
      padding: 16px 12px;
      overflow-y: auto;
      display: flex;
      flex-direction: column;
      gap: 3px;
    }

    .menu-header {
      font-size: 11px;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.8px;
      color: var(--text-stone);
      margin: 14px 12px 6px;
    }

    .menu-item {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 9px 16px;
      color: #94a3b8;
      text-decoration: none;
      border-radius: var(--radius-full);
      font-size: 13.5px;
      font-weight: 600;
      transition: all 0.2s ease;
    }

    .menu-item:hover {
      background-color: rgba(255, 255, 255, 0.08);
      color: #ffffff;
    }

    .menu-item.active {
      background-color: var(--primary);
      color: #ffffff;
      font-weight: 700;
    }

    .menu-item .icon {
      font-size: 16px;
      width: 20px;
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
      padding: 9px 16px;
      color: #94a3b8;
      border-radius: var(--radius-full);
      font-size: 13.5px;
      font-weight: 600;
      cursor: pointer;
      user-select: none;
      transition: all 0.2s ease;
    }

    .menu-group-header:hover, .menu-group.open .menu-group-header {
      background-color: rgba(255, 255, 255, 0.06);
      color: #ffffff;
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
      color: var(--text-stone);
    }

    .menu-group.open .menu-group-arrow {
      transform: rotate(180deg);
      color: #ffffff;
    }

    .submenu-list {
      list-style: none;
      padding: 4px 0 6px 14px;
      margin: 0;
      display: none;
      flex-direction: column;
      gap: 2px;
      border-left: 2px solid rgba(255, 255, 255, 0.1);
      margin-left: 20px;
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
      padding: 7px 14px;
      color: #94a3b8;
      text-decoration: none;
      border-radius: var(--radius-full);
      font-size: 13px;
      font-weight: 500;
      transition: all 0.2s ease;
    }

    .submenu-link:hover {
      background-color: rgba(255, 255, 255, 0.08);
      color: #ffffff;
    }

    .submenu-link.active {
      background-color: rgba(0, 100, 224, 0.35);
      color: #93c5fd;
      font-weight: 700;
    }

    .sidebar-user {
      padding: 16px;
      border-top: 1px solid rgba(255,255,255,0.08);
      background-color: rgba(0,0,0,0.3);
    }

    .user-card {
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .user-avatar {
      width: 36px;
      height: 36px;
      border-radius: 50%;
      background-color: var(--primary);
      color: #fff;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: 700;
      font-size: 15px;
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
      color: var(--text-stone);
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
      height: 64px;
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
      font-size: 20px;
      cursor: pointer;
      color: var(--text-main);
    }

    .page-title {
      font-size: 18px;
      font-weight: 700;
      color: var(--text-main);
      letter-spacing: -0.3px;
    }

    .topbar-right {
      display: flex;
      align-items: center;
      gap: 12px;
    }

    .branch-selector {
      display: flex;
      align-items: center;
      gap: 8px;
      background: var(--surface-soft);
      border: 1px solid var(--border-color);
      border-radius: var(--radius-full);
      padding: 6px 14px;
      font-size: 13px;
    }

    .theme-toggle-btn {
      background: var(--surface-soft);
      border: 1px solid var(--border-color);
      padding: 6px 14px;
      height: 36px;
      border-radius: var(--radius-full);
      cursor: pointer;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      font-size: 12px;
      font-weight: 700;
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

    /* UI Components - Cards */
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
      letter-spacing: -0.2px;
    }

    /* Buttons - Meta Pill Standard */
    .btn {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      padding: 10px 22px;
      border-radius: var(--radius-full);
      font-size: 13.5px;
      font-weight: 700;
      letter-spacing: -0.14px;
      cursor: pointer;
      border: none;
      transition: all 0.2s ease;
      text-decoration: none;
    }

    .btn-primary {
      background-color: var(--ink-button);
      color: #ffffff;
    }
    .btn-primary:hover {
      background-color: #333333;
      color: #ffffff;
    }

    .btn-cobalt {
      background-color: var(--primary);
      color: #ffffff;
    }
    .btn-cobalt:hover {
      background-color: var(--primary-hover);
      color: #ffffff;
    }

    .btn-secondary {
      background-color: var(--bg-card);
      color: var(--text-main);
      border: 1px solid var(--hairline);
    }
    .btn-secondary:hover {
      background-color: var(--surface-soft);
      border-color: var(--text-muted);
    }

    .btn-danger {
      background-color: var(--danger);
      color: #ffffff;
    }
    .btn-danger:hover {
      background-color: #cc1836;
    }

    .btn-sm {
      padding: 6px 14px;
      font-size: 12px;
      border-radius: var(--radius-full);
    }

    /* Form Elements */
    .form-group {
      margin-bottom: 16px;
    }

    .form-label {
      display: block;
      font-size: 13px;
      font-weight: 700;
      margin-bottom: 6px;
      color: var(--text-main);
    }

    .form-control {
      width: 100%;
      height: 44px;
      padding: 0 14px;
      border-radius: 8px;
      border: 1px solid var(--hairline);
      background-color: var(--bg-card);
      color: var(--text-main);
      font-size: 14px;
      outline: none;
      transition: border-color 0.2s, box-shadow 0.2s;
    }

    textarea.form-control {
      height: auto;
      padding: 10px 14px;
    }

    .form-control:focus {
      border-color: var(--accent);
      box-shadow: 0 0 0 3px rgba(24, 118, 242, 0.15);
    }

    /* ─── Scrollable Form Containers (Vertical & Horizontal) ─── */
    .form-scroll-y {
      max-height: 65vh;
      overflow-y: auto;
      overflow-x: hidden;
      padding-right: 6px;
      scrollbar-width: thin;
      scrollbar-color: var(--hairline) transparent;
    }

    .form-scroll-x,
    .table-scroll-x {
      overflow-x: auto;
      max-width: 100%;
      -webkit-overflow-scrolling: touch;
      scrollbar-width: thin;
      scrollbar-color: var(--hairline) transparent;
    }

    .modal-scroll-container {
      max-height: 85vh;
      display: flex;
      flex-direction: column;
      overflow: hidden;
    }

    .modal-scroll-body {
      overflow-y: auto;
      overflow-x: hidden;
      max-height: calc(85vh - 130px);
      padding-right: 4px;
      scrollbar-width: thin;
      scrollbar-color: var(--hairline) transparent;
    }

    /* Sleek Webkit Scrollbars for forms and tables */
    .form-scroll-y::-webkit-scrollbar,
    .form-scroll-x::-webkit-scrollbar,
    .table-scroll-x::-webkit-scrollbar,
    .table-responsive::-webkit-scrollbar,
    .modal-scroll-body::-webkit-scrollbar,
    .ticket-modal-body::-webkit-scrollbar {
      width: 6px;
      height: 6px;
    }

    .form-scroll-y::-webkit-scrollbar-thumb,
    .form-scroll-x::-webkit-scrollbar-thumb,
    .table-scroll-x::-webkit-scrollbar-thumb,
    .table-responsive::-webkit-scrollbar-thumb,
    .modal-scroll-body::-webkit-scrollbar-thumb,
    .ticket-modal-body::-webkit-scrollbar-thumb {
      background: var(--hairline);
      border-radius: 6px;
    }

    .form-scroll-y::-webkit-scrollbar-track,
    .form-scroll-x::-webkit-scrollbar-track,
    .table-scroll-x::-webkit-scrollbar-track,
    .table-responsive::-webkit-scrollbar-track,
    .modal-scroll-body::-webkit-scrollbar-track,
    .ticket-modal-body::-webkit-scrollbar-track {
      background: transparent;
    }

    /* Tables */
    .table-responsive {
      overflow-x: auto;
      -webkit-overflow-scrolling: touch;
      scrollbar-width: thin;
      scrollbar-color: var(--hairline) transparent;
    }

    .table {
      width: 100%;
      border-collapse: collapse;
      font-size: 14px;
    }

    .table th {
      background-color: var(--surface-soft);
      color: var(--text-muted);
      font-weight: 700;
      font-size: 12.5px;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      text-align: left;
      padding: 12px 16px;
      border-bottom: 1px solid var(--border-color);
    }

    .table td {
      padding: 14px 16px;
      border-bottom: 1px solid var(--border-color);
      color: var(--text-body);
    }

    .table tr:hover {
      background-color: var(--surface-soft);
    }

    /* Badges - Meta Pill Style */
    .badge {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      padding: 4px 12px;
      border-radius: var(--radius-full);
      font-size: 12px;
      font-weight: 700;
      letter-spacing: -0.1px;
    }

    .badge-primary { background: #e7f1fe; color: #0064e0; }
    .badge-success { background: #dcfce7; color: #15803d; }
    .badge-warning { background: #fef9c3; color: #a16207; }
    .badge-danger  { background: #fee2e2; color: #b91c1c; }
    .badge-purple  { background: #f3e8ff; color: #7e22ce; }
    .badge-customer { background: #e7f1fe; color: #0064e0; border: 1px solid #bfdbfe; }
    .badge-superadmin { background: #fee2e2; color: #991b1b; }
    .badge-owner { background: #f3e8ff; color: #6b21a8; }
    .badge-admin { background: #e7f1fe; color: #0064e0; }
    .badge-kasir { background: #dcfce7; color: #15803d; }
    .badge-cadangan { background: #ede9fe; color: #4338ca; }

    /* Alert / Flash */
    .alert {
      padding: 14px 18px;
      border-radius: var(--radius);
      margin-bottom: 20px;
      font-size: 14px;
      font-weight: 600;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .alert-success { background: #dcfce7; color: #15803d; border: 1px solid #bbf7d0; }
    .alert-error { background: #fee2e2; color: #b91c1c; border: 1px solid #fecaca; }

    /* Grid layout */
    .grid {
      display: grid;
      gap: 20px;
    }
    .grid-2 { grid-template-columns: repeat(2, 1fr); }
    .grid-3 { grid-template-columns: repeat(3, 1fr); }
    .grid-4 { grid-template-columns: repeat(4, 1fr); }

    /* ─── DataTables Meta Custom Styling ─── */
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
      padding: 6px 14px;
      border-radius: var(--radius-full);
      border: 1px solid var(--hairline);
      background-color: var(--bg-card);
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
      height: 40px;
      padding: 0 16px;
      border-radius: var(--radius-full);
      border: 1px solid var(--hairline);
      background-color: var(--surface-soft);
      color: var(--text-main);
      font-size: 13px;
      outline: none;
      transition: all 0.2s ease;
      min-width: 220px;
    }

    .dataTables_wrapper .dataTables_filter input:focus {
      background-color: var(--bg-card);
      border-color: var(--accent);
      box-shadow: 0 0 0 3px rgba(24, 118, 242, 0.15);
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
      gap: 6px;
      align-items: center;
      flex-wrap: wrap;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button {
      padding: 6px 14px;
      border-radius: var(--radius-full);
      border: 1px solid var(--hairline) !important;
      background: var(--bg-card) !important;
      color: var(--text-main) !important;
      font-size: 13px;
      font-weight: 700;
      cursor: pointer;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      min-width: 36px;
      transition: all 0.2s;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
      background: var(--surface-soft) !important;
      border-color: var(--text-muted) !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current,
    .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
      background: var(--ink-deep) !important;
      color: #ffffff !important;
      border-color: var(--ink-deep) !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.disabled,
    .dataTables_wrapper .dataTables_paginate .paginate_button.disabled:hover {
      opacity: 0.35;
      cursor: not-allowed;
      background: var(--surface-soft) !important;
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
      .topbar { padding: 12px 14px; }
      .content-area { padding: 14px 12px; }
      .card { padding: 16px 14px; margin-bottom: 16px; }
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
      <div class="logo-icon">K</div>
      <div>
        <div class="brand-title">Kafa Advertising</div>
        <div class="brand-sub">Neon Box & Signage</div>
      </div>
    </div>

    <nav class="sidebar-menu">
      <div class="menu-header">Utama</div>
      <a href="{{ route('dashboard') }}" class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
        Dashboard
      </a>

      <div class="menu-header">Produk & Katalog</div>

      @if(auth()->user()->hasPermission('produk'))
      <a href="{{ route('produk.index') }}" class="menu-item {{ request()->routeIs('produk.*') ? 'active' : '' }}">
        Kelola Produk
      </a>
      @endif

      @if(auth()->user()->hasPermission('kategori'))
      <a href="{{ route('kategori.index') }}" class="menu-item {{ request()->routeIs('kategori.*') ? 'active' : '' }}">
        Kelola Kategori
      </a>
      @endif

      @if(auth()->user()->hasPermission('portfolio'))
      <a href="{{ route('portfolio.index') }}" class="menu-item {{ request()->routeIs('portfolio.*') ? 'active' : '' }}">
        Kelola Portofolio
      </a>
      @endif

      <div class="menu-header">Manajemen Order</div>

      @if(auth()->user()->hasPermission('status_order'))
      <a href="{{ route('status_order.index') }}" class="menu-item {{ request()->routeIs('status_order.*', 'pembayaran.*') ? 'active' : '' }}">
        Status Pengerjaan
      </a>
      @endif

      <div class="menu-header">Pengaturan & Admin</div>

      @if(auth()->user()->hasPermission('users'))
      <!-- Sub-Modul Manajemen User -->
      <div class="menu-group {{ request()->routeIs('users.*', 'pelanggan.*') ? 'active open' : '' }}">
        <div class="menu-group-header" onclick="toggleSubmenu(this)">
          <div class="menu-group-left">
            <span>Manajemen User</span>
          </div>
          <span class="menu-group-arrow">▼</span>
        </div>
        <ul class="submenu-list">
          <li class="submenu-item">
            <a href="{{ route('users.index') }}" class="submenu-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
              Admin & Staf
            </a>
          </li>
          <li class="submenu-item">
            <a href="{{ route('pelanggan.index') }}" class="submenu-link {{ request()->routeIs('pelanggan.*') ? 'active' : '' }}">
              Pelanggan
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
            <span>Kelola Akses</span>
          </div>
          <span class="menu-group-arrow">▼</span>
        </div>
        <ul class="submenu-list">
          <li class="submenu-item">
            <a href="{{ route('akses.index') }}" class="submenu-link {{ request()->routeIs('akses.index') && !request()->routeIs('akses.pelanggan*') ? 'active' : '' }}">
              Admin & Staf
            </a>
          </li>
          <li class="submenu-item">
            <a href="{{ route('akses.pelanggan') }}" class="submenu-link {{ request()->routeIs('akses.pelanggan*') ? 'active' : '' }}">
              Pelanggan
            </a>
          </li>
        </ul>
      </div>
      @endif

      @if(auth()->user()->isOwner())
      <a href="{{ route('branches.index') }}" class="menu-item {{ request()->routeIs('branches.*') ? 'active' : '' }}">
        Cabang & Showroom
      </a>
      @endif

      @if(auth()->user()->hasPermission('home_manager'))
      <a href="{{ route('home_manager.index') }}" class="menu-item {{ request()->routeIs('home_manager.*') ? 'active' : '' }}">
        Landing Page Manager
      </a>
      @endif

      @if(auth()->user()->hasPermission('activity_log'))
      <a href="{{ route('activity_log.index') }}" class="menu-item {{ request()->routeIs('activity_log.*') ? 'active' : '' }}">
        Log Aktivitas
      </a>
      @endif

      @if(auth()->user()->isAdmin())
      <a href="{{ route('settings.whatsapp') }}" class="menu-item {{ request()->routeIs('settings.whatsapp*') ? 'active' : '' }}">
        Pengaturan Kontak WA
      </a>
      @endif

      <a href="{{ route('home') }}" target="_blank" class="menu-item">
        Lihat Website
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
          <button type="submit" class="btn btn-sm btn-secondary" title="Keluar">Keluar</button>
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
        <button class="theme-toggle-btn" onclick="toggleTheme()" id="themeBtn" title="Toggle Mode Dark/Light">
          Mode
        </button>
      </div>
    </header>

    <!-- Content Area -->
    <main class="content-area">
      @if(session('success'))
        <div class="alert alert-success">
          {{ session('success') }}
        </div>
      @endif

      @if(session('error'))
        <div class="alert alert-error">
          {{ session('error') }}
        </div>
      @endif

      @if($errors->any())
        <div class="alert alert-error">
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

    function updateThemeBtn(theme) {
      const btn = document.getElementById('themeBtn');
      if (btn) {
        btn.textContent = theme === 'dark' ? 'Terang' : 'Gelap';
      }
    }

    function toggleTheme() {
      const html = document.documentElement;
      const current = html.getAttribute('data-theme');
      const next = current === 'dark' ? 'light' : 'dark';
      html.setAttribute('data-theme', next);
      updateThemeBtn(next);
      localStorage.setItem('theme', next);
    }

    // Load saved theme
    const savedTheme = localStorage.getItem('theme') || 'light';
    document.documentElement.setAttribute('data-theme', savedTheme);
    updateThemeBtn(savedTheme);

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
