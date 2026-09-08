@extends('layouts.guest')

@section('title', 'Portofolio Proyek - Kaligraph Design')

@section('styles')
<style>
  /* ─── Navbar & Menu Trigger ─── */
  .navbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px 8%;
    background: rgba(255,255,255,0.95);
    backdrop-filter: blur(14px);
    border-bottom: 1px solid var(--border-color);
    position: sticky;
    top: 0;
    z-index: 1000;
    box-shadow: 0 4px 20px rgba(15,23,42,0.05);
  }

  .nav-brand {
    display: flex;
    align-items: center;
    gap: 12px;
    font-size: 20px;
    font-weight: 800;
    color: var(--primary);
    text-decoration: none;
    letter-spacing: -0.5px;
  }

  .nav-brand .brand-logo {
    width: 42px;
    height: 42px;
    background: linear-gradient(135deg, #2563eb, #7c3aed);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    box-shadow: 0 4px 12px rgba(37,99,235,0.3);
  }

  .nav-right-wrap {
    display: flex;
    align-items: center;
    gap: 14px;
  }

  .nav-quick-btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 8px 16px;
    background: var(--primary-light);
    color: var(--primary);
    border-radius: 20px;
    font-size: 13px;
    font-weight: 700;
    text-decoration: none;
    transition: all 0.2s;
  }
  .nav-quick-btn:hover {
    background: var(--primary);
    color: #fff;
  }

  /* Hero Global Style Menu Button */
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

  /* ─── Side Drawer ─── */
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
  .side-drawer-nav.active .drawer-menu-item:nth-child(8) { transition-delay: 0.41s; }

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

  /* ─── Page Header ─── */
  .page-header {
    background: linear-gradient(135deg, #0d1b3e 0%, #1e1b4b 100%);
    padding: 60px 8%;
    color: #fff;
    text-align: center;
    position: relative;
    overflow: hidden;
  }
  .page-header::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -10%;
    width: 500px;
    height: 500px;
    background: radial-gradient(circle, rgba(124,58,237,0.15) 0%, transparent 70%);
    pointer-events: none;
  }
  .page-header h1 {
    font-size: 38px;
    font-weight: 800;
    margin-bottom: 12px;
  }
  .page-header p {
    font-size: 16px;
    color: rgba(255,255,255,0.7);
    max-width: 600px;
    margin: 0 auto;
    line-height: 1.7;
  }

  /* ─── Portfolio Grid ─── */
  .portfolio-container {
    padding: 50px 8%;
    max-width: 1280px;
    margin: 0 auto;
  }

  .breadcrumb {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 13px;
    color: var(--text-muted);
    margin-bottom: 30px;
  }
  .breadcrumb a {
    color: var(--primary);
    text-decoration: none;
  }

  /* Filter Tabs */
  .filter-tabs {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
    margin-bottom: 30px;
  }
  .filter-tab {
    padding: 8px 18px;
    border-radius: 30px;
    border: 1px solid var(--border-color);
    background: var(--bg-card);
    color: var(--text-muted);
    font-size: 13px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.2s;
    text-decoration: none;
  }
  .filter-tab:hover, .filter-tab.active {
    background: var(--primary);
    color: #fff;
    border-color: var(--primary);
  }

  .portfolio-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 28px;
  }

  .port-card {
    background: var(--bg-card);
    border: 1px solid var(--border-color);
    border-radius: 20px;
    overflow: hidden;
    transition: transform 0.3s, box-shadow 0.3s, border-color 0.3s;
    display: flex;
    flex-direction: column;
  }
  .port-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 20px 40px rgba(37,99,235,0.12);
    border-color: rgba(37,99,235,0.3);
  }

  .port-card-img {
    height: 220px;
    background: linear-gradient(135deg, var(--primary-light), #ede9fe);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 54px;
    overflow: hidden;
    position: relative;
  }
  .port-card-img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.4s;
  }
  .port-card:hover .port-card-img img {
    transform: scale(1.05);
  }

  .port-card-overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    padding: 12px 16px;
    background: linear-gradient(transparent, rgba(0,0,0,0.7));
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
  }

  .port-card-tag {
    display: inline-block;
    padding: 4px 10px;
    border-radius: 20px;
    background: rgba(255,255,255,0.2);
    backdrop-filter: blur(4px);
    color: #fff;
    font-size: 11px;
    font-weight: 700;
  }

  .port-card-body {
    padding: 24px;
    flex: 1;
    display: flex;
    flex-direction: column;
  }
  .port-card-title {
    font-size: 18px;
    font-weight: 800;
    color: var(--text-main);
    margin-bottom: 8px;
  }
  .port-card-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
    font-size: 13px;
    color: var(--text-muted);
    margin-bottom: 12px;
  }
  .port-card-meta span {
    display: inline-flex;
    align-items: center;
    gap: 4px;
  }
  .port-card-desc {
    font-size: 14px;
    color: var(--text-muted);
    line-height: 1.6;
    flex: 1;
  }

  .port-card-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 14px 24px;
    border-top: 1px solid var(--border-color);
    background: var(--bg-main);
  }
  .port-card-category {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    font-size: 12px;
    font-weight: 700;
    color: var(--primary);
    background: var(--primary-light);
    padding: 4px 10px;
    border-radius: 20px;
  }
  .port-card-year {
    font-size: 12px;
    font-weight: 700;
    color: var(--text-muted);
  }

  /* ─── Footer ─── */
  .footer {
    background: #060d1f;
    color: #6b7280;
    padding: 36px 8%;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 16px;
    font-size: 14px;
  }

  /* ─── Responsive ─── */
  @media (max-width: 768px) {
    .page-header h1 { font-size: 28px; }
    .portfolio-grid { grid-template-columns: 1fr; }
  }
</style>
@endsection

@section('content')

<!-- Navbar -->
<nav class="navbar">
  <a href="{{ route('home') }}" class="nav-brand">
    <div class="brand-logo">💡</div>
    <span>Kaligraph Design</span>
  </a>

  <div class="nav-right-wrap">
    <a href="{{ route('katalog') }}" class="nav-quick-btn" style="display:none; @media(min-width:768px){display:inline-flex;}">
      <span>📂</span>
      <span>Katalog Produk</span>
    </a>
    <button type="button" class="menu-toggle-btn" id="menuToggleBtn" onclick="toggleSideNav()" aria-label="Buka Menu Navigasi">
      <span>MENU</span>
      <div class="menu-burger-icon">
        <span class="line-1"></span>
        <span class="line-2"></span>
        <span class="line-3"></span>
      </div>
    </button>
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
        <a href="{{ route('portofolio') }}" class="drawer-link" onclick="closeSideNav()" style="background:rgba(37,99,235,0.15); border-color:rgba(37,99,235,0.3); color:#60a5fa;">
          <div class="drawer-link-left">
            <span class="drawer-link-num" style="color:#60a5fa;">04</span>
            <span>🖼️ Portofolio Proyek</span>
          </div>
          <span class="drawer-link-arrow" style="opacity:1; transform:translateX(0); color:#60a5fa;">➔</span>
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
        <a href="{{ route('login.customer') }}" class="drawer-link highlight-customer" onclick="closeSideNav()">
          <div class="drawer-link-left">
            <span class="drawer-link-num">07</span>
            <span>🛍️ Portal Pelanggan</span>
          </div>
          <span class="drawer-link-arrow">➔</span>
        </a>
      </li>
      <li class="drawer-menu-item">
        <a href="{{ route('login.admin') }}" class="drawer-link highlight-admin" onclick="closeSideNav()">
          <div class="drawer-link-left">
            <span class="drawer-link-num">08</span>
            <span>🛡️ Login Admin & Staff</span>
          </div>
          <span class="drawer-link-arrow">➔</span>
        </a>
      </li>
    </ul>
  </div>

  <div class="drawer-footer">
    <div class="drawer-footer-info">
      <div>📍 <strong>Workshop & Showroom</strong></div>
      <div>Melayani Demak, Semarang, Surabaya & sekitarnya. Pengiriman ke seluruh Indonesia.</div>
    </div>
    <a href="https://wa.me/6281234567890?text=Halo%20Kaligraph%20Design%2C%20saya%20ingin%20konsultasi%20pesanan" target="_blank" class="drawer-wa-cta">
      <span>💬</span>
      <span>Chat WhatsApp Sekarang</span>
    </a>
  </div>
</aside>

<!-- Page Header -->
<div class="page-header">
  <div style="display:inline-block; padding:6px 14px; border-radius:20px; font-size:12px; font-weight:700; margin-bottom:12px; background:rgba(255,255,255,0.1); color:#60a5fa;">
    🖼️ PORTOFOLIO PROYEK
  </div>
  <h1>Hasil Karya & Proyek Kami</h1>
  <p>Lihat koleksi proyek neon box, signage, dan advertising yang telah kami kerjakan untuk berbagai klien di seluruh Indonesia.</p>
</div>

<div class="portfolio-container">
  <div class="breadcrumb">
    <a href="{{ route('home') }}">Beranda</a>
    <span>/</span>
    <span>Portofolio</span>
  </div>

  <!-- Category Filter -->
  @if($categories->count() > 0)
  <div class="filter-tabs">
    <span class="filter-tab active" onclick="filterPortfolio('all')">Semua</span>
    @foreach($categories as $cat)
      <span class="filter-tab" onclick="filterPortfolio('cat-{{ $cat->id }}')" data-cat="{{ $cat->id }}">
        {{ $cat->emoji ?: '📂' }} {{ $cat->nama }}
      </span>
    @endforeach
  </div>
  @endif

  <div class="portfolio-grid" id="portfolioGrid">
    @forelse($portfolios as $p)
      <div class="port-card" data-category="cat-{{ $p->category_id }}">
        <div class="port-card-img">
          @if($p->foto_url)
            <img src="{{ $p->foto_url }}" alt="{{ $p->nama }}">
          @else
            <span>🖼️</span>
          @endif
          <div class="port-card-overlay">
            @if($p->category)
              <span class="port-card-tag">{{ $p->category->emoji ?: '📂' }} {{ $p->category->nama }}</span>
            @endif
            @if($p->tahun)
              <span class="port-card-tag">📅 {{ $p->tahun }}</span>
            @endif
          </div>
        </div>
        <div class="port-card-body">
          <div class="port-card-title">{{ $p->nama }}</div>
          <div class="port-card-meta">
            @if($p->client)
              <span>🏢 {{ $p->client }}</span>
            @endif
            @if($p->lokasi)
              <span>📍 {{ $p->lokasi }}</span>
            @endif
          </div>
          <p class="port-card-desc">{{ Str::limit($p->deskripsi ?: 'Proyek custom signage & advertising berkualitas premium.', 120) }}</p>
        </div>
        @if($p->category || $p->tahun)
        <div class="port-card-footer">
          @if($p->category)
            <span class="port-card-category">{{ $p->category->emoji ?: '📂' }} {{ $p->category->nama }}</span>
          @else
            <span></span>
          @endif
          @if($p->tahun)
            <span class="port-card-year">{{ $p->tahun }}</span>
          @endif
        </div>
        @endif
      </div>
    @empty
      <div style="grid-column:1/-1; text-align:center; padding:80px 20px; color:var(--text-muted);">
        <div style="font-size:48px; margin-bottom:16px;">🖼️</div>
        <p style="font-size:16px; font-weight:600;">Portofolio sedang diperbarui.</p>
        <p style="font-size:14px; margin-top:8px;">Hubungi kami via WhatsApp untuk melihat contoh proyek yang telah kami kerjakan.</p>
      </div>
    @endforelse
  </div>
</div>

<!-- Footer -->
<footer class="footer">
  <div>💡 <strong>Kaligraph Design</strong> — Spesialis Neon Box & Signage Custom</div>
  <p>© {{ date('Y') }} All rights reserved.</p>
</footer>

@endsection

@section('scripts')
<script>
function openSideNav() {
  document.getElementById('sideDrawerBackdrop').classList.add('active');
  document.getElementById('sideDrawerNav').classList.add('active');
  document.body.style.overflow = 'hidden';
}

function closeSideNav() {
  document.getElementById('sideDrawerBackdrop').classList.remove('active');
  document.getElementById('sideDrawerNav').classList.remove('active');
  document.body.style.overflow = '';
}

function toggleSideNav() {
  const nav = document.getElementById('sideDrawerNav');
  if (nav && nav.classList.contains('active')) {
    closeSideNav();
  } else {
    openSideNav();
  }
}

// Close on Escape key
document.addEventListener('keydown', function(e) {
  if (e.key === 'Escape') {
    closeSideNav();
  }
});

// Portfolio Category Filter
function filterPortfolio(category) {
  const cards = document.querySelectorAll('.port-card');
  const tabs = document.querySelectorAll('.filter-tab');

  // Update active tab
  tabs.forEach(tab => tab.classList.remove('active'));
  event.target.classList.add('active');

  // Filter cards
  cards.forEach(card => {
    if (category === 'all' || card.getAttribute('data-category') === category) {
      card.style.display = '';
    } else {
      card.style.display = 'none';
    }
  });
}
</script>
@endsection
