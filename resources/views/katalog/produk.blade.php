@extends('layouts.guest')

@section('title', $category->nama . ' - Kaligraph Design')

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

  /* ─── Hero Global Style Side Drawer (Menurun ke Bawah) ─── */
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

  /* Drawer Menu List (Menurun ke Bawah) */
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

  /* Staggered delay for descending animation */
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

  /* Drawer Footer */
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
/*page*/
  .page-header {
    background: linear-gradient(135deg, #0d1b3e 0%, #1e1b4b 100%);
    padding: 50px 8%;
    color: #fff;
    position: relative;
  }
  .page-header h1 {
    font-size: 34px;
    font-weight: 800;
    margin-bottom: 10px;
  }
  .page-header p {
    font-size: 15px;
    color: rgba(255,255,255,0.75);
    max-width: 700px;
    line-height: 1.6;
  }

  .catalog-container {
    padding: 40px 8%;
    max-width: 1280px;
    margin: 0 auto;
  }

  .breadcrumb {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 13px;
    color: var(--text-muted);
    margin-bottom: 24px;
  }
  .breadcrumb a {
    color: var(--primary);
    text-decoration: none;
  }

  /* Category pills */
  .category-pills {
    display: flex;
    gap: 10px;
    overflow-x: auto;
    padding-bottom: 16px;
    margin-bottom: 30px;
    scrollbar-width: thin;
  }
  .cat-pill {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 18px;
    border-radius: 30px;
    background: var(--bg-card);
    border: 1px solid var(--border-color);
    color: var(--text-main);
    text-decoration: none;
    font-size: 13px;
    font-weight: 600;
    white-space: nowrap;
    transition: all 0.2s;
  }
  .cat-pill:hover, .cat-pill.active {
    background: var(--primary);
    color: #fff;
    border-color: var(--primary);
    box-shadow: 0 4px 12px rgba(37,99,235,0.25);
  }

  .products-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 26px;
  }

  .product-card {
    background: var(--bg-card);
    border: 1px solid var(--border-color);
    border-radius: 18px;
    overflow: hidden;
    transition: transform 0.3s, box-shadow 0.3s;
    display: flex;
    flex-direction: column;
    text-decoration: none;
    color: inherit;
  }
  .product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 16px 32px rgba(37,99,235,0.12);
  }

  .product-img {
    height: 190px;
    background: linear-gradient(135deg, var(--primary-light), #ede9fe);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 48px;
    overflow: hidden;
  }
  .product-img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  .product-body {
    padding: 20px;
    flex: 1;
    display: flex;
    flex-direction: column;
  }
  .product-name {
    font-size: 17px;
    font-weight: 800;
    color: var(--text-main);
    margin-bottom: 6px;
  }
  .product-price {
    font-size: 18px;
    font-weight: 800;
    color: var(--primary);
    margin-bottom: 10px;
  }
  .product-desc {
    font-size: 13px;
    color: var(--text-muted);
    line-height: 1.6;
    margin-bottom: 16px;
    flex: 1;
  }
  .btn-detail {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    padding: 10px 16px;
    background: var(--primary-light);
    color: var(--primary);
    border-radius: 10px;
    font-weight: 700;
    font-size: 13px;
    transition: all 0.2s;
  }
  .product-card:hover .btn-detail {
    background: var(--primary);
    color: #fff;
  }

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
    margin-top: 60px;
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

<!-- ─── Side Drawer Backdrop ─── -->
<div class="side-drawer-backdrop" id="sideDrawerBackdrop" onclick="closeSideNav()"></div>

<!-- ─── Hero Global Style Side Drawer (Menurun ke Bawah) ─── -->
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
  <div style="display:inline-block; padding:5px 12px; background:rgba(255,255,255,0.1); border-radius:20px; font-size:12px; font-weight:700; color:#60a5fa; margin-bottom:10px;">
    {{ $category->emoji ?: '📂' }} KATEGORI PRODUK
  </div>
  <h1>{{ $category->nama }}</h1>
  <p>{{ $category->deskripsi ?: 'Pilihan produk custom dengan bahan berkualitas, pengerjaan presisi, dan garansi resmi.' }}</p>
</div>

<div class="catalog-container">
  <div class="breadcrumb">
    <a href="{{ route('home') }}">Beranda</a>
    <span>/</span>
    <a href="{{ route('katalog') }}">Katalog Kategori</a>
    <span>/</span>
    <span>{{ $category->nama }}</span>
  </div>

  <!-- Category Filter Pills -->
  <div class="category-pills">
    <a href="{{ route('katalog') }}" class="cat-pill">Semua Kategori</a>
    @foreach($categories as $cat)
      <a href="{{ route('katalog.kategori', $cat->slug) }}" class="cat-pill {{ $cat->id === $category->id ? 'active' : '' }}">
        <span>{{ $cat->emoji ?: '📂' }}</span>
        <span>{{ $cat->nama }}</span>
      </a>
    @endforeach
  </div>

  <!-- Products Grid -->
  <div class="products-grid">
    @forelse($products as $prod)
      <a href="{{ route('katalog.detail', [$category->slug, $prod->id]) }}" class="product-card">
        <div class="product-img">
          @if($prod->foto_url)
            <img src="{{ $prod->foto_url }}" alt="{{ $prod->nama }}">
          @else
            <span>💡</span>
          @endif
        </div>
        <div class="product-body">
          <div class="product-name">{{ $prod->nama }}</div>
          <div class="product-price">{{ $prod->harga_display }}</div>
          <p class="product-desc">{{ Str::limit($prod->deskripsi ?: 'Kualitas terjamin, siap survey lokasi dan melayani pengiriman.', 100) }}</p>
          <div class="btn-detail">
            <span>Detail & Estimasi Harga</span>
            <span>➔</span>
          </div>
        </div>
      </a>
    @empty
      <div style="grid-column:1/-1; text-align:center; padding:70px 20px; color:var(--text-muted);">
        <div style="font-size:48px; margin-bottom:16px;">🔍</div>
        <h3>Belum ada produk dalam kategori ini</h3>
        <p style="margin-top:8px;">Silakan hubungi kami via WhatsApp untuk konsultasi produk custom sesuai kebutuhan Anda.</p>
        <a href="https://wa.me/6281234567890?text=Halo%20Kaligraph%20Design%2C%20saya%20ingin%20tanya%20produk%20kategori%20{{ urlencode($category->nama) }}" target="_blank" class="btn btn-primary" style="margin-top:16px; display:inline-flex;">
          💬 Konsultasi Produk Ini
        </a>
      </div>
    @endforelse
  </div>
</div>

<!-- Footer -->
<footer class="footer">
  <div>💡 <strong>Kaligraph Design</strong> — Spesialis Neon Box & Signage Custom</div>
  <p>© {{ date('Y') }} All rights reserved.</p>
</footer>

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
</script>



@endsection
