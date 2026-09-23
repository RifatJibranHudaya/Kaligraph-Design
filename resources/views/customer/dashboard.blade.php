@extends('layouts.guest')

@section('title', 'Portal Pelanggan - Kafa Advertising')

@section('styles')
<style>
  /* Customer Navbar with Menu Button */
  .customer-navbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px 6%;
    background: var(--bg-card);
    border-bottom: 1px solid var(--border-color);
    position: sticky;
    top: 0;
    z-index: 100;
    box-shadow: 0 2px 10px rgba(0,0,0,0.03);
  }

  .nav-brand {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 18px;
    font-weight: 800;
    color: var(--primary);
    text-decoration: none;
  }

  .brand-icon {
    width: 36px;
    height: 36px;
    background: linear-gradient(135deg, #2563eb, #7c3aed);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
  }

  .nav-right-wrap {
    display: flex;
    align-items: center;
    gap: 14px;
  }

  /* Menu Toggle Button - Same as Home Page */
  .menu-toggle-btn {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 10px 20px;
    background: #0f172a;
    color: #fff;
    border: 1px solid rgba(255,255,255,0.1);
    border-radius: 30px;
    font-size: 13px;
    font-weight: 800;
    letter-spacing: 1.5px;
    cursor: pointer;
    box-shadow: 0 4px 16px rgba(15,23,42,0.18);
    transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
  }

  .menu-toggle-btn:hover {
    background: var(--primary);
    border-color: var(--primary);
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(37,99,235,0.35);
  }

  .menu-burger-icon {
    width: 20px;
    height: 14px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
  }

  .menu-burger-icon span {
    display: block;
    height: 2px;
    background: #fff;
    border-radius: 2px;
    transition: all 0.3s;
  }

  .menu-burger-icon .line-1 { width: 100%; }
  .menu-burger-icon .line-2 { width: 65%; margin-left: auto; }
  .menu-burger-icon .line-3 { width: 100%; }

  .menu-toggle-btn:hover .menu-burger-icon .line-2 {
    width: 100%;
  }

  /* Side Drawer Backdrop */
  .side-drawer-backdrop {
    position: fixed;
    inset: 0;
    background: rgba(15, 23, 42, 0.65);
    backdrop-filter: blur(8px);
    z-index: 99998;
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.4s ease, visibility 0.4s ease;
  }

  .side-drawer-backdrop.active {
    opacity: 1;
    visibility: visible;
  }

  /* Side Drawer Navigation */
  .side-drawer-nav {
    position: fixed;
    top: 0;
    right: 0;
    bottom: 0;
    width: 420px;
    max-width: 90vw;
    background: linear-gradient(180deg, #090e1a 0%, #0f172a 100%);
    color: #fff;
    z-index: 99999;
    box-shadow: -12px 0 40px rgba(0,0,0,0.5);
    transform: translateX(100%);
    transition: transform 0.45s cubic-bezier(0.16, 1, 0.3, 1);
    display: flex;
    flex-direction: column;
    overflow-y: auto;
    border-left: 1px solid rgba(255,255,255,0.08);
  }

  .side-drawer-nav.active {
    transform: translateX(0);
  }

  .drawer-header {
    padding: 24px 28px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    border-bottom: 1px solid rgba(255,255,255,0.08);
  }

  .drawer-brand {
    display: flex;
    align-items: center;
    gap: 10px;
  }

  .drawer-brand-logo {
    width: 36px;
    height: 36px;
    background: linear-gradient(135deg, #2563eb, #7c3aed);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
  }

  .drawer-brand-title {
    font-size: 16px;
    font-weight: 800;
    color: #fff;
    letter-spacing: -0.3px;
  }

  .drawer-brand-sub {
    font-size: 10px;
    color: #94a3b8;
    text-transform: uppercase;
    letter-spacing: 1px;
  }

  .drawer-close-btn {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    background: rgba(255,255,255,0.08);
    border: 1px solid rgba(255,255,255,0.12);
    color: #fff;
    font-size: 18px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s;
  }

  .drawer-close-btn:hover {
    background: #ef4444;
    border-color: #ef4444;
    transform: rotate(90deg);
  }

  .drawer-body {
    padding: 30px 24px;
    flex: 1;
    display: flex;
    flex-direction: column;
  }

  .drawer-nav-label {
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 2px;
    color: #64748b;
    margin-bottom: 16px;
    padding-left: 12px;
  }

  .drawer-menu-list {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    flex-direction: column;
    gap: 8px;
  }

  .drawer-menu-item {
    opacity: 0;
    transform: translateY(16px);
    transition: opacity 0.35s ease, transform 0.35s ease;
  }

  .side-drawer-nav.active .drawer-menu-item {
    opacity: 1;
    transform: translateY(0);
  }

  .side-drawer-nav.active .drawer-menu-item:nth-child(1) { transition-delay: 0.06s; }
  .side-drawer-nav.active .drawer-menu-item:nth-child(2) { transition-delay: 0.11s; }
  .side-drawer-nav.active .drawer-menu-item:nth-child(3) { transition-delay: 0.16s; }
  .side-drawer-nav.active .drawer-menu-item:nth-child(4) { transition-delay: 0.21s; }
  .side-drawer-nav.active .drawer-menu-item:nth-child(5) { transition-delay: 0.26s; }
  .side-drawer-nav.active .drawer-menu-item:nth-child(6) { transition-delay: 0.31s; }
  .side-drawer-nav.active .drawer-menu-item:nth-child(7) { transition-delay: 0.36s; }

  .drawer-link {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 13px 18px;
    border-radius: 12px;
    color: #f1f5f9;
    text-decoration: none;
    font-size: 16px;
    font-weight: 700;
    letter-spacing: -0.2px;
    background: transparent;
    transition: all 0.25s ease;
    border: 1px solid transparent;
  }

  .drawer-link-left {
    display: flex;
    align-items: center;
    gap: 12px;
  }

  .drawer-link-num {
    font-size: 11px;
    font-weight: 700;
    color: #64748b;
    font-family: monospace;
    transition: color 0.25s;
    min-width: 20px;
  }

  .drawer-link-arrow {
    font-size: 14px;
    color: #64748b;
    transform: translateX(-4px);
    opacity: 0;
    transition: all 0.25s;
  }

  .drawer-link:hover {
    background: rgba(37, 99, 235, 0.15);
    border-color: rgba(37, 99, 235, 0.3);
    color: #60a5fa;
    transform: translateX(6px);
  }

  .drawer-link:hover .drawer-link-num {
    color: #60a5fa;
  }

  .drawer-link:hover .drawer-link-arrow {
    opacity: 1;
    transform: translateX(0);
    color: #60a5fa;
  }

  .drawer-link.highlight-customer {
    background: rgba(16, 185, 129, 0.1);
    border-color: rgba(16, 185, 129, 0.2);
    color: #34d399;
  }
  .drawer-link.highlight-customer:hover {
    background: rgba(16, 185, 129, 0.2);
    border-color: rgba(16, 185, 129, 0.4);
    color: #6ee7b7;
  }

  .drawer-link.highlight-admin {
    background: rgba(139, 92, 246, 0.1);
    border-color: rgba(139, 92, 246, 0.2);
    color: #a78bfa;
  }
  .drawer-link.highlight-admin:hover {
    background: rgba(139, 92, 246, 0.2);
    border-color: rgba(139, 92, 246, 0.4);
    color: #c4b5fd;
  }

  .drawer-footer {
    padding: 24px 28px;
    border-top: 1px solid rgba(255,255,255,0.08);
    background: rgba(0,0,0,0.25);
  }

  .drawer-footer-info {
    font-size: 12px;
    color: #94a3b8;
    line-height: 1.6;
    margin-bottom: 16px;
  }

  .drawer-wa-cta {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 12px 20px;
    background: #25d366;
    color: #fff;
    border-radius: 12px;
    font-size: 14px;
    font-weight: 700;
    text-decoration: none;
    box-shadow: 0 4px 16px rgba(37,211,102,0.3);
    transition: all 0.2s;
  }

  .drawer-wa-cta:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(37,211,102,0.45);
  }

  .user-nav-actions {
    display: none;
  }

  .user-info-pill {
    display: none;
  }

  .btn-nav-logout {
    display: none;
  }

  .btn-edit-profile {
    display: none;
  }

  /* Portal Content */
  .portal-content {
    max-width: 1200px;
    margin: 0 auto;
    padding: 40px 24px;
  }

  .welcome-banner {
    background: linear-gradient(135deg, #0d1b3e 0%, #1e1b4b 100%);
    border-radius: 24px;
    padding: 36px 40px;
    color: #ffffff;
    margin-bottom: 32px;
    position: relative;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(13, 27, 62, 0.15);
  }

  .welcome-banner::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -10%;
    width: 400px;
    height: 400px;
    background: radial-gradient(circle, rgba(37, 99, 235, 0.3) 0%, transparent 70%);
    pointer-events: none;
  }

  .welcome-badge {
    display: inline-block;
    padding: 4px 12px;
    background: rgba(255,255,255,0.1);
    color: #60a5fa;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 700;
    margin-bottom: 12px;
  }

  .welcome-title {
    font-size: 28px;
    font-weight: 800;
    margin-bottom: 8px;
    letter-spacing: -0.5px;
  }

  .welcome-subtitle {
    font-size: 14px;
    color: rgba(255,255,255,0.7);
    max-width: 540px;
    line-height: 1.6;
    margin-bottom: 20px;
  }

  .btn-cta-wa {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 11px 22px;
    background: #25d366;
    color: #fff;
    border-radius: 10px;
    font-size: 14px;
    font-weight: 700;
    text-decoration: none;
    box-shadow: 0 4px 15px rgba(37, 211, 102, 0.4);
    transition: transform 0.2s;
  }

  .btn-cta-wa:hover {
    transform: translateY(-2px);
  }

  /* Grid Layouts */
  .section-card {
    background: var(--bg-card);
    border: 1px solid var(--border-color);
    border-radius: 20px;
    padding: 28px;
    margin-bottom: 32px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.02);
  }

  .section-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 20px;
  }

  .section-title {
    font-size: 18px;
    font-weight: 800;
    color: var(--text-main);
    display: flex;
    align-items: center;
    gap: 8px;
  }

  /* Table styling */
  .table-responsive {
    overflow-x: auto;
  }

  .table {
    width: 100%;
    border-collapse: collapse;
    font-size: 14px;
  }

  .table th {
    background: var(--bg-main);
    color: var(--text-muted);
    font-weight: 700;
    text-align: left;
    padding: 12px 16px;
    border-bottom: 1px solid var(--border-color);
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }

  .table td {
    padding: 16px;
    border-bottom: 1px solid var(--border-color);
    color: var(--text-main);
  }

  .table tr:hover {
    background: rgba(37, 99, 235, 0.02);
  }

  .order-id-badge {
    font-weight: 700;
    color: var(--primary);
  }

  .badge-status {
    display: inline-block;
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 700;
  }

  .badge-selesai { background: #d1fae5; color: #065f46; }
  .badge-proses  { background: #dbeafe; color: #1e40af; }
  .badge-pending { background: #fef3c7; color: #92400e; }

  /* Product Catalog mini */
  .products-mini-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
    gap: 20px;
  }

  .product-mini-card {
    background: var(--bg-main);
    border: 1px solid var(--border-color);
    border-radius: 16px;
    padding: 20px;
    display: flex;
    flex-direction: column;
    transition: transform 0.2s, box-shadow 0.2s;
  }

  .product-mini-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 20px rgba(37, 99, 235, 0.08);
  }

  .product-mini-icon {
    font-size: 32px;
    margin-bottom: 12px;
  }

  .product-mini-name {
    font-size: 16px;
    font-weight: 700;
    margin-bottom: 4px;
    color: var(--text-main);
  }

  .product-mini-price {
    font-size: 16px;
    font-weight: 800;
    color: var(--primary);
    margin-bottom: 8px;
  }

  .product-mini-desc {
    font-size: 12px;
    color: var(--text-muted);
    line-height: 1.5;
    margin-bottom: 16px;
    flex-grow: 1;
  }

  .btn-order-wa {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    width: 100%;
    padding: 8px;
    background: var(--primary);
    color: #fff;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 700;
    text-decoration: none;
    transition: background 0.2s;
  }

  .btn-order-wa:hover {
    background: var(--primary-hover);
  }

  .empty-state {
    text-align: center;
    padding: 40px 20px;
    color: var(--text-muted);
  }

  .empty-icon {
    font-size: 48px;
    margin-bottom: 12px;
  }

  /* Profile Edit Modal */
  .profile-edit-modal {
    position: fixed;
    inset: 0;
    background: rgba(15, 23, 42, 0.7);
    backdrop-filter: blur(6px);
    z-index: 100000;
    display: none;
    align-items: center;
    justify-content: center;
    padding: 20px;
  }

  .profile-edit-modal.active {
    display: flex;
  }

  .profile-edit-card {
    background: var(--bg-card);
    border-radius: 20px;
    padding: 24px;
    width: 100%;
    max-width: 480px;
    max-height: 85vh;
    display: flex;
    flex-direction: column;
    overflow-y: auto;
    border: 1px solid var(--border-color);
    box-shadow: 0 20px 60px rgba(0,0,0,0.3);
  }

  .profile-edit-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 20px;
  }

  .profile-edit-title {
    font-size: 20px;
    font-weight: 800;
    color: var(--text-main);
  }

  .profile-edit-close {
    width: 34px;
    height: 34px;
    border-radius: 50%;
    background: var(--bg-main);
    border: 1px solid var(--border-color);
    color: var(--text-main);
    font-size: 18px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s;
  }

  .profile-edit-close:hover {
    background: #ef4444;
    color: #fff;
    border-color: #ef4444;
  }

  .form-group {
    margin-bottom: 20px;
  }

  .form-label {
    display: block;
    font-size: 13px;
    font-weight: 700;
    color: var(--text-main);
    margin-bottom: 8px;
  }

  .form-input {
    width: 100%;
    padding: 11px 14px;
    border-radius: 10px;
    border: 1px solid var(--border-color);
    background: var(--bg-main);
    color: var(--text-main);
    font-size: 14px;
    transition: border-color 0.2s, box-shadow 0.2s;
  }

  .form-input:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
  }

  .btn-save-profile {
    width: 100%;
    padding: 12px 20px;
    background: var(--primary);
    color: #fff;
    border: none;
    border-radius: 10px;
    font-size: 14px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.2s;
  }

  .btn-save-profile:hover {
    background: var(--primary-hover);
    transform: translateY(-1px);
  }

  /* Ikon SVG (Bootstrap Icons - icons.getbootstrap.com) */
  .bs-icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
  }

  .bs-icon svg {
    width: 20px;
    height: 20px;
  }
</style>
@endsection

@section('content')
<!-- Navigation Bar -->
<nav class="customer-navbar">
  <a href="{{ route('home') }}" class="nav-brand">
    <div class="brand-icon">K</div>
    <span>Kafa Advertising</span>
  </a>

  <div class="nav-right-wrap">
    <button type="button" class="menu-toggle-btn" id="menuToggleBtn" onclick="toggleSideNav()" aria-label="Buka Menu Navigasi">
      <span>MENU</span>
      <!-- Ikon: list (Bootstrap Icons) -->
      <span class="bs-icon">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
          <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5"/>
        </svg>
      </span>
    </button>
  </div>
</nav>

<!-- Side Drawer Backdrop -->
<div class="side-drawer-backdrop" id="sideDrawerBackdrop" onclick="closeSideNav()"></div>

<!-- Side Drawer Navigation -->
<aside class="side-drawer-nav" id="sideDrawerNav" aria-label="Menu Navigasi Samping">
  <div class="drawer-header">
    <div class="drawer-brand">
      <div class="drawer-brand-logo">K</div>
      <div>
        <div class="drawer-brand-title">Kafa Advertising</div>
        <div class="drawer-brand-sub">Advertising & Reklame</div>
      </div>
    </div>
    <button type="button" class="drawer-close-btn" onclick="closeSideNav()" aria-label="Tutup Menu">✕</button>
  </div>

  <div class="drawer-body">
    <div class="drawer-nav-label">Menu Navigasi</div>
    <ul class="drawer-menu-list">
      <li class="drawer-menu-item">
        <a href="{{ route('home') }}" class="drawer-link" onclick="closeSideNav()">
          <div class="drawer-link-left">
            <span class="drawer-link-num">01</span>
            <span class="bs-icon"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-house-door" viewBox="0 0 16 16"><path d="M8.354 1.088a.5.5 0 0 0-.708 0L1.923 6.517A1.5 1.5 0 0 0 1.5 7.612V15.5a.5.5 0 0 0 .5.5H7v-5a1.5 1.5 0 0 1 3 0v5h5a.5.5 0 0 0 .5-.5V7.612a1.5 1.5 0 0 0-.423-1.095zM1 15.5V7.612c0-.418.105-.83.304-1.197l5.75-5.326a1.5 1.5 0 0 1 2.115 0l5.728 5.325c.2.368.303.78.303 1.198V15.5a1.5 1.5 0 0 1-1.5 1.5H9.807l.038-5h.07l.342 5h5.243a.5.5 0 0 0 .5-.5V16H8.5a.5.5 0 0 1 0-1h7v-.5H7.5V15H1.5v-1H7v-.5H1.5z"/></svg></span>
            <span>Beranda</span>
          </div>
          
        </a>
      </li>
      <li class="drawer-menu-item">
        <a href="{{ route('home') }}#kategori" class="drawer-link" onclick="closeSideNav()">
          <div class="drawer-link-left">
            <span class="drawer-link-num">02</span>
            <span class="bs-icon"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-grid-3x3-gap-fill" viewBox="0 0 16 16"><path d="M1 2a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1zm5 0a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1zm5 0a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1zM1 7a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1zm5 0a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1zm5 0a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1zM1 12a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1zm5 0a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1zm5 0a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1z"/></svg></span>
            <span>Kategori Layanan</span>
          </div>
          
        </a>
      </li>
      <li class="drawer-menu-item">
        <a href="{{ route('katalog') }}" class="drawer-link" onclick="closeSideNav()">
          <div class="drawer-link-left">
            <span class="drawer-link-num">03</span>
            <span class="bs-icon"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bag-fill" viewBox="0 0 16 16"><path d="M3 2.5a2.5 2.5 0 0 1 5 0v.64c.554.002 1.07.068 1.54.186V2.5a2.5 2.5 0 0 1 5 0v.64c.554.002 1.07.068 1.54.186V2.5a2.5 2.5 0 0 1 5 0v1h1a1 1 0 0 1 1 1v6a3.5 3.5 0 0 1-3.5 3.5h-10A3.5 3.5 0 0 1 2 10.5v-6a1 1 0 0 1 1-1zm3 0v.64c.554.002 1.07.068 1.54.186q.071.018.139.04.043-.033.094-.068A2.5 2.5 0 0 1 8 3.069V2.5zm-1 8.93a2 2 0 0 0 2 2h3a2 2 0 1 0 0-4v.03c-.457-.061-.97.093-1.338.36-.183.134-.48.163-.663 0C7.6 9.4 7.03 9.1 6.5 9.1zm8.5 2a2 2 0 0 0 2-2v-.03c-.457.061-.97-.093-1.338-.36-.183-.134-.48-.163-.663 0-.397.29-.966.59-1.497.59z"/></svg></span>
            <span>Katalog & Harga Produk</span>
          </div>
          
        </a>
      </li>
      <li class="drawer-menu-item">
        <a href="{{ route('portofolio') }}" class="drawer-link" onclick="closeSideNav()">
          <div class="drawer-link-left">
            <span class="drawer-link-num">04</span>
            <span class="bs-icon"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-collection-fill" viewBox="0 0 16 16"><path d="M1 2.5A1.5 1.5 0 0 1 2.5 1h3A1.5 1.5 0 0 1 7 2.5v3A1.5 1.5 0 0 1 5.5 7h-3A1.5 1.5 0 0 1 1 5.5zM6.735 8.565a2 2 0 0 0-1.183 1.51c-.228 1.047.267 2.04 1.015 2.713C7.322 13.36 8 14.092 8 15c0 .25.202.5.5.5s.5-.25.5-.5c0-.908.678-1.64 1.433-2.212.748-.673 1.243-1.666 1.015-2.713a2 2 0 0 0-1.183-1.51c-.692-.272-1.382-.565-1.382-.565h-1.066s-.69.293-1.382.565zM.5 9h3a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-4a.5.5 0 0 1 .5-.5m12 0h3a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-4a.5.5 0 0 1 .5-.5m-6 0h3a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-4a.5.5 0 0 1 .5-.5"/></svg></span>
            <span>Portofolio Proyek</span>
          </div>
          
        </a>
      </li>
      <li class="drawer-menu-item">
        <a href="{{ route('home') }}#keunggulan" class="drawer-link" onclick="closeSideNav()">
          <div class="drawer-link-left">
            <span class="drawer-link-num">05</span>
            <span class="bs-icon"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-patch-check-fill" viewBox="0 0 16 16"><path d="M9.05.93c-.37-.28-.87-.28-1.24 0l-.67.51-.73-.57a.66.66 0 0 0-.92.06L5.13 1.5l-.72-.13a.66.66 0 0 0-.79.47l-.23.75-.74.03a.66.66 0 0 0-.61.69l.04.77-.64.38a.66.66 0 0 0-.21.88l.4.66-.53.56a.66.66 0 0 0 0 .93l.53.56-.4.66a.66.66 0 0 0 .21.88l.64.38-.04.77a.66.66 0 0 0 .61.69l.74.03.23.75a.66.66 0 0 0 .79.47l.72-.13.36.57a.66.66 0 0 0 .92.06l.73-.57.67.51c.37.28.87.28 1.24 0l.67-.51.73.57a.66.66 0 0 0 .92-.06l.36-.57.72.13a.66.66 0 0 0 .79-.47l.23-.75.74-.03a.66.66 0 0 0 .61-.69l-.04-.77.64-.38a.66.66 0 0 0 .21-.88l-.4-.66.53-.56a.66.66 0 0 0 0-.93l-.53-.56.4-.66a.66.66 0 0 0-.21-.88l-.64-.38.04-.77a.66.66 0 0 0-.61-.69l-.74-.03-.23-.75a.66.66 0 0 0-.79-.47l-.72.13-.36-.57a.66.66 0 0 0-.92-.06l-.73.57zM8.27 11.03a.5.5 0 0 1-.72.03l-2.5-2.25a.5.5 0 1 1 .67-.74l2.13 1.92 3.93-4.56a.5.5 0 1 1 .76.65z"/></svg></span>
            <span>Keunggulan Layanan</span>
          </div>
          
        </a>
      </li>
      <li class="drawer-menu-item">
        <a href="{{ route('home') }}#cabang" class="drawer-link" onclick="closeSideNav()">
          <div class="drawer-link-left">
            <span class="drawer-link-num">06</span>
            <span class="bs-icon"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-geo-alt-fill" viewBox="0 0 16 16"><path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10m0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6"/></svg></span>
            <span>Lokasi Showroom & Maps</span>
          </div>
          
        </a>
      </li>
      <li class="drawer-menu-item">
        <a href="{{ route('login.admin') }}" class="drawer-link highlight-admin" onclick="closeSideNav()">
          <div class="drawer-link-left">
            <span class="drawer-link-num">07</span>
            <span class="bs-icon"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-shield-lock-fill" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M8 0c-.535 0-1.18.193-1.918.596A15.8 15.8 0 0 0 2.212 2.62C1.656 3.022 1.2 3.43.874 3.838.547 4.247.329 4.678.329 5.161c0 .662.3 1.468.722 2.315a19 19 0 0 0 1.44 2.331c.687.95 1.408 1.781 1.967 2.433.278.324.513.589.683.783.17.194.275.31.333.372a.53.53 0 0 0 .705 0c.058-.062.163-.178.333-.372.17-.194.405-.459.683-.783.559-.652 1.28-1.483 1.967-2.433a19 19 0 0 0 1.44-2.331C14.37 6.629 14.67 5.823 14.67 5.16c0-.483-.218-.914-.545-1.322C13.8 3.43 13.344 3.022 12.788 2.62a15.8 15.8 0 0 0-3.87-2.024C9.18.193 8.535 0 8 0m0 5.5a2.5 2.5 0 0 0-1 4.8V12a1 1 0 1 0 2 0V10.3a2.5 2.5 0 0 0-1-4.8"/></svg></span>
            <span>Login Admin & Staff</span>
          </div>
          
        </a>
      </li>
    </ul>

    <!-- User Profile Section in Drawer -->
    <div style="margin-top: 24px; padding-top: 24px; border-top: 1px solid rgba(255,255,255,0.08);">
      <div class="drawer-nav-label">Akun Saya</div>
      <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 16px; padding: 12px; background: rgba(255,255,255,0.05); border-radius: 12px;">
        <div style="width: 40px; height: 40px; background: #2563eb; color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 16px; font-weight: 800;">
          {{ strtoupper(substr($user->username, 0, 1)) }}
        </div>
        <div style="flex: 1; min-width: 0;">
          <div style="font-size: 14px; font-weight: 700; color: #fff; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $user->username }}</div>
          <div style="font-size: 11px; color: #94a3b8;">Pelanggan</div>
        </div>
      </div>
      <ul class="drawer-menu-list">
        <li class="drawer-menu-item">
          <button type="button" class="drawer-link" onclick="openProfileModal(); closeSideNav();" style="width: 100%; text-align: left; cursor: pointer;">
            <div class="drawer-link-left">
              <span class="drawer-link-num">08</span>
            <span class="bs-icon"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16"><path d="M15 12a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h9a1 1 0 0 1 1 1zm-6 3a1 1 0 0 1-1-1v-1H3a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h1v3a2 2 0 0 0 2 2h3v3a2 2 0 0 1-2 2zm1-9a1 1 0 0 0-1 1v1h3a1 1 0 0 1 1 1v3h1a1 1 0 0 0 1-1V7a2 2 0 0 0-2-2z"/></svg></span>
            <span>Edit Profil</span>
            </div>
            
          </button>
        </li>
        <li class="drawer-menu-item">
          <form method="POST" action="{{ route('customer.logout') }}" style="display: contents;">
            @csrf
            <button type="submit" class="drawer-link" style="width: 100%; text-align: left; cursor: pointer; background: rgba(239, 68, 68, 0.1); border-color: rgba(239, 68, 68, 0.2); color: #f87171;">
              <div class="drawer-link-left">
                <span class="drawer-link-num">09</span>
            <span class="bs-icon"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-right" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0z"/></svg></span>
            <span>Keluar</span>
              </div>
              
            </button>
          </form>
        </li>
      </ul>
    </div>
  </div>

  <div class="drawer-footer">
    <div class="drawer-footer-info">
      Butuh bantuan? Hubungi kami untuk konsultasi gratis.
    </div>
    <a href="{{ \App\Helpers\FormatHelper::whatsappUrl('Halo Kafa Advertising, saya butuh bantuan') }}" target="_blank" class="drawer-wa-cta">
      💬 Hubungi via WhatsApp
    </a>
  </div>
</aside>

<!-- Profile Edit Modal -->
<div class="profile-edit-modal" id="profileEditModal">
  <div class="profile-edit-card">
    <div class="profile-edit-header">
      <h3 class="profile-edit-title">Edit Profil Pelanggan</h3>
      <button type="button" class="profile-edit-close" onclick="closeProfileModal()">✕</button>
    </div>

    <form method="POST" action="{{ route('customer.profile.update') }}">
      @csrf

      <div class="form-group">
        <label class="form-label" for="edit-username">Username</label>
        <input type="text" class="form-input" id="edit-username" name="username" value="{{ $user->username }}" required>
      </div>

      <div class="form-group">
        <label class="form-label" for="edit-email">Email</label>
        <input type="email" class="form-input" id="edit-email" name="email" value="{{ $user->email }}" required>
      </div>

      <div class="form-group">
        <label class="form-label" for="edit-phone">Nomor Telepon / WhatsApp</label>
        <input type="text" class="form-input" id="edit-phone" name="phone" value="{{ $user->phone ?? '' }}" placeholder="+62...">
      </div>

      <button type="submit" class="btn-save-profile">Simpan Perubahan</button>
    </form>
  </div>
</div>

<!-- Portal Content -->
<div class="portal-content">
  @if(session('success'))
    <div style="padding: 14px 18px; border-radius: 12px; background: #d1fae5; color: #065f46; font-size: 14px; font-weight: 600; margin-bottom: 24px;">
      {{ session('success') }}
    </div>
  @endif

  <!-- Welcome Banner -->
  <div class="welcome-banner">
    <div class="welcome-badge">Portal Pelanggan Kafa Advertising</div>
    <h1 class="welcome-title">Halo, {{ $user->username }}!</h1>
    <p class="welcome-subtitle">
      Selamat datang di pusat layanan pelanggan Kafa Advertising. Anda dapat melihat riwayat pengerjaan pesanan neon box Anda atau melakukan konsultasi proyek baru.
    </p>
    <a href="{{ \App\Helpers\FormatHelper::whatsappUrl('Halo Kafa Advertising, saya pelanggan (' . $user->username . ') ingin konsultasi pesanan neon box') }}" target="_blank" class="btn-cta-wa">
      💬 Konsultasi & Pesan Custom via WhatsApp
    </a>
  </div>

  <!-- Orders Section -->
  <div class="section-card">
    <div class="section-header">
      <h2 class="section-title">Riwayat & Status Pesanan Anda</h2>
    </div>

    @if($orders->count() > 0)
      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th>No. Order</th>
              <th>Tanggal</th>
              <th>Cabang / Showroom</th>
              <th>Items Pesanan</th>
              <th>Total Biaya</th>
              <th>Status Pengerjaan</th>
              <th>Status Pembayaran</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach($orders as $order)
              @php
                $dibayar = $order->total_dibayar ?? 0;
                $total = $order->total ?? 0;
                $sisa = max(0, $total - $dibayar);
                $isLunas = $dibayar >= $total && $total > 0;
                $statusLabels = [
                  'order' => 'Order Baru',
                  'on_progress' => 'Sedang Dikerjakan',
                  'selesai' => 'Selesai',
                  'cancelled' => 'Dibatalkan',
                ];
                $statusLabel = isset($statusLabels[$order->status]) ? $statusLabels[$order->status] : $order->status;
              @endphp
              <tr>
                <td><span class="order-id-badge">#ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</span></td>
                <td>{{ $order->created_at->format('d M Y, H:i') }}</td>
                <td>{{ $order->branch ? $order->branch->nama_cabang : 'Pusat' }}</td>
                <td>
                  @if($order->items->count() > 0)
                    {{ $order->items->pluck('product.nama')->filter()->join(', ') ?: 'Pesanan Custom' }}
                  @else
                    Pesanan Signage
                  @endif
                </td>
                <td style="font-weight: 800; color: var(--primary);">
                  Rp {{ number_format($order->total, 0, ',', '.') }}
                </td>
                <td>
                  <span class="badge-status {{ $order->status === 'selesai' ? 'badge-selesai' : ($order->status === 'on_progress' ? 'badge-proses' : 'badge-pending') }}">
                    {{ $statusLabel }}
                  </span>
                </td>
                <td>
                  @if($isLunas)
                    <span class="badge-status badge-selesai">Lunas</span>
                  @elseif($dibayar > 0)
                    <span class="badge-status badge-proses">DP</span>
                    <div style="font-size:10px; color:var(--text-muted); margin-top:2px;">
                      Sisa: Rp {{ number_format($sisa, 0, ',', '.') }}
                    </div>
                  @else
                    <span class="badge-status badge-pending">Belum Bayar</span>
                  @endif
                </td>
                <td>
                  <a href="{{ route('customer.order.detail', $order->id) }}" class="btn-order-wa" style="padding:6px 10px; font-size:11px;">
                    Detail & Bayar
                  </a>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <div style="margin-top: 16px;">
        {{ $orders->links() }}
      </div>
    @else
      <div class="empty-state">
        
        <h3 style="font-size: 16px; font-weight: 700; margin-bottom: 6px; color: var(--text-main);">Belum Ada Pesanan Terdaftar</h3>
        <p style="font-size: 13px; max-width: 400px; margin: 0 auto 16px;">
          Anda belum memiliki riwayat pesanan neon box. Silakan pilih produk di bawah atau hubungi tim kami untuk membuat pesanan custom.
        </p>
      </div>
    @endif
  </div>

  <!-- Catalog Section -->
  <div class="section-card">
    <div class="section-header">
      <h2 class="section-title">Katalog Pilihan Neon Box</h2>
      <a href="{{ route('home') }}#produk" style="font-size: 13px; color: var(--primary); font-weight: 700; text-decoration: none;">
        Lihat Semua Produk
      </a>
    </div>

    <div class="products-mini-grid">
      @foreach($products as $prod)
        <div class="product-mini-card">
          @if($prod->foto_url)
            <img src="{{ $prod->foto_url }}" alt="{{ $prod->nama }}" style="width:100%; height:140px; object-fit:cover; border-radius:10px; margin-bottom:12px; border:1px solid var(--border-color);">
          @else
            
          @endif
          <div class="product-mini-name">{{ $prod->nama }}</div>
          <div class="product-mini-price">{{ $prod->harga_display }}</div>
          <div class="product-mini-desc">{{ $prod->deskripsi ?: 'Produk neon box berkualitas tinggi' }}</div>
          <a href="{{ \App\Helpers\FormatHelper::whatsappUrl('Halo Kafa Advertising, saya tertarik dengan produk *' . $prod->nama . '*') }}" target="_blank" class="btn-order-wa">
            💬 Pesan Sekarang
          </a>
        </div>
      @endforeach
    </div>
  </div>
</div>

<script>
  // Side Drawer Navigation Functions
  function toggleSideNav() {
    const backdrop = document.getElementById('sideDrawerBackdrop');
    const drawer = document.getElementById('sideDrawerNav');
    backdrop.classList.add('active');
    drawer.classList.add('active');
    document.body.style.overflow = 'hidden';
  }

  function closeSideNav() {
    const backdrop = document.getElementById('sideDrawerBackdrop');
    const drawer = document.getElementById('sideDrawerNav');
    backdrop.classList.remove('active');
    drawer.classList.remove('active');
    document.body.style.overflow = '';
  }

  // Profile Modal Functions
  function openProfileModal() {
    const modal = document.getElementById('profileEditModal');
    modal.classList.add('active');
  }

  function closeProfileModal() {
    const modal = document.getElementById('profileEditModal');
    modal.classList.remove('active');
  }

  // Close modal when clicking outside
  document.addEventListener('click', function(event) {
    const modal = document.getElementById('profileEditModal');
    if (event.target === modal) {
      closeProfileModal();
    }
  });

  // Close modal on Escape key
  document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
      closeProfileModal();
      closeSideNav();
    }
  });
</script>
@endsection
