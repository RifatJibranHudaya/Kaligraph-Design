@extends('layouts.guest')

@section('title', 'Portal Pelanggan - Kaligraph Design')

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
    display: flex;
    align-items: center;
    gap: 16px;
  }

  .user-info-pill {
    display: flex;
    align-items: center;
    gap: 10px;
    background: var(--bg-main);
    padding: 6px 14px;
    border-radius: 30px;
    border: 1px solid var(--border-color);
    font-size: 13px;
    font-weight: 600;
  }

  .user-avatar-circle {
    width: 26px;
    height: 26px;
    background: #2563eb;
    color: #fff;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    font-weight: 800;
  }

  .btn-nav-logout {
    background: #fee2e2;
    color: #991b1b;
    border: none;
    padding: 7px 14px;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 700;
    cursor: pointer;
    transition: background 0.2s;
  }

  .btn-nav-logout:hover {
    background: #fecaca;
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
    padding: 32px;
    width: 100%;
    max-width: 480px;
    border: 1px solid var(--border-color);
    box-shadow: 0 20px 60px rgba(0,0,0,0.3);
  }

  .profile-edit-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 24px;
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

  .btn-edit-profile {
    background: var(--bg-main);
    color: var(--text-main);
    border: 1px solid var(--border-color);
    padding: 8px 16px;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.2s;
  }

  .btn-edit-profile:hover {
    background: var(--primary);
    color: #fff;
    border-color: var(--primary);
  }
</style>
@endsection

@section('content')
<!-- Navigation Bar -->
<nav class="customer-navbar">
  <a href="{{ route('home') }}" class="nav-brand">
    <div class="brand-icon">💡</div>
    <span>Kaligraph Design</span>
  </a>

  <div class="nav-right-wrap">
    <button type="button" class="menu-toggle-btn" id="menuToggleBtn" onclick="toggleSideNav()" aria-label="Buka Menu Navigasi">
      <span>MENU</span>
      <div class="menu-burger-icon">
        <span class="line-1"></span>
        <span class="line-2"></span>
        <span class="line-3"></span>
      </div>
    </button>

    <div class="user-nav-actions">
      <button type="button" class="btn-edit-profile" onclick="openProfileModal()">✏️ Edit Profil</button>

      <div class="user-info-pill">
        <div class="user-avatar-circle">
          {{ strtoupper(substr($user->username, 0, 1)) }}
        </div>
        <span>{{ $user->username }}</span>
      </div>

      <form method="POST" action="{{ route('customer.logout') }}">
        @csrf
        <button type="submit" class="btn-nav-logout" title="Keluar">⏻ Keluar</button>
      </form>
    </div>
  </div>
</nav>

<!-- Side Drawer Backdrop -->
<div class="side-drawer-backdrop" id="sideDrawerBackdrop" onclick="closeSideNav()"></div>

<!-- Side Drawer Navigation -->
<aside class="side-drawer-nav" id="sideDrawerNav" aria-label="Menu Navigasi Samping">
  <div class="drawer-header">
    <div class="drawer-brand">
      <div class="drawer-brand-logo">💡</div>
      <div>
        <div class="drawer-brand-title">Kaligraph Design</div>
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
            <span>🏠 Beranda</span>
          </div>
          <span class="drawer-link-arrow">➔</span>
        </a>
      </li>
      <li class="drawer-menu-item">
        <a href="{{ route('home') }}#kategori" class="drawer-link" onclick="closeSideNav()">
          <div class="drawer-link-left">
            <span class="drawer-link-num">02</span>
            <span>📂 Kategori Layanan</span>
          </div>
          <span class="drawer-link-arrow">➔</span>
        </a>
      </li>
      <li class="drawer-menu-item">
        <a href="{{ route('katalog') }}" class="drawer-link" onclick="closeSideNav()">
          <div class="drawer-link-left">
            <span class="drawer-link-num">03</span>
            <span>💡 Katalog & Harga Produk</span>
          </div>
          <span class="drawer-link-arrow">➔</span>
        </a>
      </li>
      <li class="drawer-menu-item">
        <a href="{{ route('portofolio') }}" class="drawer-link" onclick="closeSideNav()">
          <div class="drawer-link-left">
            <span class="drawer-link-num">04</span>
            <span>🖼️ Portofolio Proyek</span>
          </div>
          <span class="drawer-link-arrow">➔</span>
        </a>
      </li>
      <li class="drawer-menu-item">
        <a href="{{ route('home') }}#keunggulan" class="drawer-link" onclick="closeSideNav()">
          <div class="drawer-link-left">
            <span class="drawer-link-num">05</span>
            <span>⭐ Keunggulan Layanan</span>
          </div>
          <span class="drawer-link-arrow">➔</span>
        </a>
      </li>
      <li class="drawer-menu-item">
        <a href="{{ route('home') }}#cabang" class="drawer-link" onclick="closeSideNav()">
          <div class="drawer-link-left">
            <span class="drawer-link-num">06</span>
            <span>📍 Lokasi Showroom & Maps</span>
          </div>
          <span class="drawer-link-arrow">➔</span>
        </a>
      </li>
      <li class="drawer-menu-item">
        <a href="{{ route('login.admin') }}" class="drawer-link highlight-admin" onclick="closeSideNav()">
          <div class="drawer-link-left">
            <span class="drawer-link-num">07</span>
            <span>🛡️ Login Admin & Staff</span>
          </div>
          <span class="drawer-link-arrow">➔</span>
        </a>
      </li>
    </ul>
  </div>

  <div class="drawer-footer">
    <div class="drawer-footer-info">
      Butuh bantuan? Hubungi kami untuk konsultasi gratis.
    </div>
    <a href="{{ \App\Helpers\FormatHelper::whatsappUrl('Halo Kaligraph Design, saya butuh bantuan') }}" target="_blank" class="drawer-wa-cta">
      💬 Hubungi via WhatsApp
    </a>
  </div>
</aside>

<!-- Profile Edit Modal -->
<div class="profile-edit-modal" id="profileEditModal">
  <div class="profile-edit-card">
    <div class="profile-edit-header">
      <h3 class="profile-edit-title">✏️ Edit Profil Pelanggan</h3>
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

      <button type="submit" class="btn-save-profile">💾 Simpan Perubahan</button>
    </form>
  </div>
</div>

<!-- Portal Content -->
<div class="portal-content">
  @if(session('success'))
    <div style="padding: 14px 18px; border-radius: 12px; background: #d1fae5; color: #065f46; font-size: 14px; font-weight: 600; margin-bottom: 24px;">
      ✅ {{ session('success') }}
    </div>
  @endif

  <!-- Welcome Banner -->
  <div class="welcome-banner">
    <div class="welcome-badge">Portal Pelanggan Kaligraph Design</div>
    <h1 class="welcome-title">Halo, {{ $user->username }}! 👋</h1>
    <p class="welcome-subtitle">
      Selamat datang di pusat layanan pelanggan Kaligraph Design. Anda dapat melihat riwayat pengerjaan pesanan neon box Anda atau melakukan konsultasi proyek baru.
    </p>
    <a href="{{ \App\Helpers\FormatHelper::whatsappUrl('Halo Kaligraph Design, saya pelanggan (' . $user->username . ') ingin konsultasi pesanan neon box') }}" target="_blank" class="btn-cta-wa">
      💬 Konsultasi & Pesan Custom via WhatsApp
    </a>
  </div>

  <!-- Orders Section -->
  <div class="section-card">
    <div class="section-header">
      <h2 class="section-title">📦 Riwayat & Status Pesanan Anda</h2>
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
                  'order' => '📋 Order Baru',
                  'on_progress' => '🔧 Sedang Dikerjakan',
                  'selesai' => '✅ Selesai',
                  'cancelled' => '❌ Dibatalkan',
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
                    <span class="badge-status badge-selesai">✅ Lunas</span>
                  @elseif($dibayar > 0)
                    <span class="badge-status badge-proses">⏳ DP</span>
                    <div style="font-size:10px; color:var(--text-muted); margin-top:2px;">
                      Sisa: Rp {{ number_format($sisa, 0, ',', '.') }}
                    </div>
                  @else
                    <span class="badge-status badge-pending">⚠️ Belum Bayar</span>
                  @endif
                </td>
                <td>
                  <a href="{{ route('customer.order.detail', $order->id) }}" class="btn-order-wa" style="padding:6px 10px; font-size:11px;">
                    💳 Detail & Bayar
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
        <div class="empty-icon">💡</div>
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
      <h2 class="section-title">✨ Katalog Pilihan Neon Box</h2>
      <a href="{{ route('home') }}#produk" style="font-size: 13px; color: var(--primary); font-weight: 700; text-decoration: none;">
        Lihat Semua Produk ➔
      </a>
    </div>

    <div class="products-mini-grid">
      @foreach($products as $prod)
        <div class="product-mini-card">
          @if($prod->foto_url)
            <img src="{{ $prod->foto_url }}" alt="{{ $prod->nama }}" style="width:100%; height:140px; object-fit:cover; border-radius:10px; margin-bottom:12px; border:1px solid var(--border-color);">
          @else
            <div class="product-mini-icon">💡</div>
          @endif
          <div class="product-mini-name">{{ $prod->nama }}</div>
          <div class="product-mini-price">{{ $prod->harga_display }}</div>
          <div class="product-mini-desc">{{ $prod->deskripsi ?: 'Produk neon box berkualitas tinggi' }}</div>
          <a href="{{ \App\Helpers\FormatHelper::whatsappUrl('Halo Kaligraph Design, saya tertarik dengan produk *' . $prod->nama . '*') }}" target="_blank" class="btn-order-wa">
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
