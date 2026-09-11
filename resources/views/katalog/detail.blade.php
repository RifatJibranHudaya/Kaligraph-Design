@extends('layouts.guest')

@section('title', $product->nama . ' - Kaligraph Design')

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

  .detail-container {
    padding: 40px 8%;
    max-width: 1200px;
    margin: 0 auto;
  }

  .breadcrumb {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 13px;
    color: var(--text-muted);
    margin-bottom: 24px;
    flex-wrap: wrap;
  }
  .breadcrumb a {
    color: var(--primary);
    text-decoration: none;
  }

  .product-detail-grid {
    display: grid;
    grid-template-columns: 1fr 1.2fr;
    gap: 40px;
    margin-bottom: 60px;
  }

  .product-gallery {
    background: var(--bg-card);
    border: 1px solid var(--border-color);
    border-radius: 20px;
    overflow: hidden;
    height: 420px;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 10px 25px rgba(0,0,0,0.05);
  }
  .product-gallery img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }
  .product-gallery .placeholder-icon {
    font-size: 84px;
  }

  .product-info {
    display: flex;
    flex-direction: column;
  }

  .cat-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 14px;
    background: var(--primary-light);
    color: var(--primary);
    border-radius: 20px;
    font-size: 13px;
    font-weight: 700;
    margin-bottom: 12px;
    align-self: flex-start;
  }

  .product-title {
    font-size: 32px;
    font-weight: 800;
    color: var(--text-main);
    line-height: 1.2;
    margin-bottom: 16px;
  }

  .price-box {
    background: linear-gradient(135deg, rgba(37,99,235,0.06), rgba(124,58,237,0.06));
    border: 1px solid rgba(37,99,235,0.15);
    border-radius: 14px;
    padding: 16px 20px;
    margin-bottom: 24px;
  }
  .price-label {
    font-size: 12px;
    font-weight: 600;
    color: var(--text-muted);
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }
  .price-value {
    font-size: 28px;
    font-weight: 800;
    color: var(--primary);
    margin-top: 4px;
  }

  .product-description {
    font-size: 15px;
    color: var(--text-main);
    line-height: 1.8;
    margin-bottom: 28px;
  }

  .features-pills {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 12px;
    margin-bottom: 30px;
  }
  .feat-pill {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 12px 16px;
    background: var(--bg-card);
    border: 1px solid var(--border-color);
    border-radius: 12px;
    font-size: 13px;
    font-weight: 600;
    color: var(--text-main);
  }

  .order-btn-wa {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    padding: 16px 28px;
    background: #25d366;
    color: #fff;
    border-radius: 12px;
    font-size: 16px;
    font-weight: 700;
    text-decoration: none;
    box-shadow: 0 8px 24px rgba(37,211,102,0.4);
    transition: transform 0.2s, box-shadow 0.2s;
  }
  .order-btn-wa:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 30px rgba(37,211,102,0.5);
  }

  .related-section {
    border-top: 1px solid var(--border-color);
    padding-top: 40px;
  }
  .related-title {
    font-size: 22px;
    font-weight: 800;
    margin-bottom: 24px;
    color: var(--text-main);
  }
  .related-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
    gap: 20px;
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

  @media (max-width: 868px) {
    .product-detail-grid { grid-template-columns: 1fr; }
    .product-gallery { height: 320px; }
    .features-pills { grid-template-columns: 1fr; }
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
    <a href="{{ \App\Helpers\FormatHelper::whatsappUrl('Halo Kaligraph Design, saya ingin konsultasi pesanan') }}" target="_blank" class="drawer-wa-cta">
      <span>💬</span>
      <span>Chat WhatsApp Sekarang</span>
    </a>
  </div>
</aside>

<div class="detail-container">
  <!-- Breadcrumb -->
  <div class="breadcrumb">
    <a href="{{ route('home') }}">Beranda</a>
    <span>/</span>
    <a href="{{ route('katalog') }}">Katalog</a>
    @if($product->category)
      <span>/</span>
      <a href="{{ route('katalog.kategori', $product->category->slug) }}">{{ $product->category->nama }}</a>
    @endif
    <span>/</span>
    <span>{{ $product->nama }}</span>
  </div>

  <!-- Detail Main Grid -->
  <div class="product-detail-grid">
    <!-- Image -->
    <div class="product-gallery">
      @if($product->foto_url)
        <img src="{{ $product->foto_url }}" alt="{{ $product->nama }}">
      @else
        <div class="placeholder-icon">💡</div>
      @endif
    </div>

    <!-- Info -->
    <div class="product-info">
      @if($product->category)
        <a href="{{ route('katalog.kategori', $product->category->slug) }}" class="cat-badge">
          <span>{{ $product->category->emoji ?: '📂' }}</span>
          <span>{{ $product->category->nama }}</span>
        </a>
      @endif

      <h1 class="product-title">{{ $product->nama }}</h1>

      <div class="price-box">
        <div class="price-label">Estimasi Biaya / Harga</div>
        <div class="price-value">{{ $product->harga_display }}</div>
      </div>

      <div class="product-description">
        {!! nl2br(e($product->deskripsi ?: 'Produk custom dengan material bermutu tinggi, siap diukur ke lokasi dan melayani pengiriman langsung ke alamat Anda.')) !!}
      </div>

      <!-- Value Props -->
      <div class="features-pills">
        <div class="feat-pill">
          <span style="font-size:20px;">📐</span>
          <span>Survey & Pengukuran Lokasi</span>
        </div>
        <div class="feat-pill">
          <span style="font-size:20px;">📦</span>
          <span>Bisa Dikirim ke Seluruh Wilayah</span>
        </div>
        <div class="feat-pill">
          <span style="font-size:20px;">🛡️</span>
          <span>Garansi Material & Modul LED</span>
        </div>
        <div class="feat-pill">
          <span style="font-size:20px;">⚡</span>
          <span>Pengerjaan Cepat & Presisi</span>
        </div>
      </div>

      <!-- WhatsApp CTA -->
      @php
        $waMsg = "Halo Kaligraph Design, saya tertarik untuk memesan / konsultasi produk: *" . $product->nama . "* (" . $product->harga_display . "). Mohon info estimasi dan proses pemesanannya.";
        $waUrl = \App\Helpers\FormatHelper::whatsappUrl($waMsg);
      @endphp
      <a href="{{ $waUrl }}" target="_blank" class="order-btn-wa">
        <span style="font-size:22px;">💬</span>
        <span>Konsultasi & Pesan via WhatsApp</span>
      </a>
    </div>
  </div>

  <!-- Related Products -->
  @if($relatedProducts->count() > 0)
    <div class="related-section">
      <h3 class="related-title">Produk Lainnya dalam Kategori Ini</h3>
      <div class="related-grid">
        @foreach($relatedProducts as $rel)
          <a href="{{ route('katalog.detail', [$rel->category ? $rel->category->slug : 'katalog', $rel->id]) }}" class="card" style="text-decoration:none; color:inherit; padding:16px; border-radius:14px; transition:transform 0.2s;">
            <div style="height:140px; border-radius:10px; overflow:hidden; background:linear-gradient(135deg, var(--primary-light), #ede9fe); display:flex; align-items:center; justify-content:center; margin-bottom:12px;">
              @if($rel->foto_url)
                <img src="{{ $rel->foto_url }}" alt="{{ $rel->nama }}" style="width:100%; height:100%; object-fit:cover;">
              @else
                <span style="font-size:36px;">💡</span>
              @endif
            </div>
            <div style="font-weight:700; font-size:14px; color:var(--text-main); margin-bottom:4px;">{{ $rel->nama }}</div>
            <div style="font-weight:800; font-size:13px; color:var(--primary);">{{ $rel->harga_display }}</div>
          </a>
        @endforeach
      </div>
    </div>
  @endif
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

document.addEventListener('keydown', function(e) {
  if (e.key === 'Escape') {
    closeSideNav();
  }
});
</script>
@endsection
