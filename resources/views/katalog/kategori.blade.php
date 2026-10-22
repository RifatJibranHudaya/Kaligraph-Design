@extends('layouts.guest')

@section('title', 'Katalog Kategori Produk & Layanan - Kafa Advertising')

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
    padding: 60px 8%;
    color: #fff;
    text-align: center;
    position: relative;
    overflow: hidden;
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
  }

  .catalog-container {
    padding: 50px 8%;
    max-width: 1280px;
    margin: 0 auto;
  }

  /* ─── Filter Select Dropdowns (Style like Image 3) ─── */
  .filter-select-row {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 28px;
    flex-wrap: wrap;
  }
  .filter-select-col {
    position: relative;
    display: inline-block;
  }
  .filter-select {
    display: block;
    width: auto;
    min-width: 170px;
    padding: 7px 34px 7px 12px;
    font-size: 13.5px;
    font-weight: 500;
    line-height: 1.5;
    color: #1f2937;
    background-color: #ffffff;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%23374151' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 10px center;
    background-size: 11px 11px;
    border: 1px solid #d1d5db;
    border-radius: 6px;
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
    cursor: pointer;
    box-shadow: 0 1px 2px rgba(0,0,0,0.04);
    transition: border-color 0.15s ease, box-shadow 0.15s ease;
    font-family: inherit;
  }
  .filter-select:hover {
    border-color: #9ca3af;
  }
  .filter-select:focus {
    outline: none;
    border-color: #2563eb;
    box-shadow: 0 0 0 3px rgba(37,99,235,0.15);
  }

  .category-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 28px;
  }

  .cat-card {
    background: var(--bg-card);
    border: 1px solid var(--border-color);
    border-radius: 20px;
    overflow: hidden;
    transition: transform 0.3s, box-shadow 0.3s, border-color 0.3s;
    text-decoration: none;
    color: inherit;
    display: flex;
    flex-direction: column;
  }
  .cat-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 20px 40px rgba(37,99,235,0.12);
    border-color: rgba(37,99,235,0.3);
  }

  .cat-card-img {
    height: 180px;
    background: linear-gradient(135deg, var(--primary-light), #ede9fe);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 54px;
    overflow: hidden;
  }
  .cat-card-img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  .cat-card-body {
    padding: 24px;
    flex: 1;
    display: flex;
    flex-direction: column;
  }
  .cat-card-title {
    font-size: 20px;
    font-weight: 800;
    color: var(--text-main);
    margin-bottom: 8px;
  }
  .cat-card-count {
    display: inline-block;
    font-size: 12px;
    font-weight: 700;
    color: var(--primary);
    background: var(--primary-light);
    padding: 4px 10px;
    border-radius: 20px;
    margin-bottom: 12px;
    align-self: flex-start;
  }
  .cat-card-desc {
    font-size: 14px;
    color: var(--text-muted);
    line-height: 1.6;
    margin-bottom: 20px;
    flex: 1;
  }
  .cat-card-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding-top: 14px;
    border-top: 1px solid var(--border-color);
    font-weight: 700;
    color: var(--primary);
    font-size: 14px;
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

  @media (max-width: 768px) {
    .navbar {
      padding: 10px 14px;
    }
    .page-header {
      padding: 32px 14px;
    }
    .page-header h1 {
      font-size: 22px;
      line-height: 1.3;
    }
    .page-header p {
      font-size: 13px;
    }
    .catalog-container {
      padding: 20px 14px;
    }
    .filter-select-row {
      gap: 8px;
      margin-bottom: 20px;
    }
    .filter-select-col {
      flex: 1 1 100%;
      min-width: 140px;
    }
    .filter-select {
      width: 100%;
      min-width: unset;
      padding: 7px 28px 7px 10px;
      font-size: 12.5px;
    }
    .category-grid {
      grid-template-columns: 1fr;
      gap: 14px;
    }
    .cat-card-body {
      padding: 16px 14px;
    }
    .cat-card-title {
      font-size: 17px;
    }
    .cat-card-desc {
      font-size: 12.5px;
      margin-bottom: 14px;
    }
    .cat-card-footer {
      font-size: 13px;
      padding-top: 10px;
    }
    .footer {
      padding: 24px 14px;
      flex-direction: column;
      text-align: center;
      gap: 8px;
      font-size: 12px;
    }
  }
</style>
@endsection

@section('content')

<!-- ─── Navbar: Desktop (Gambar 1) & Mobile (Gambar 2) ─── -->
@include('partials.guest-navbar')
<!-- Header -->
<div class="page-header">
  <div class="section-badge" style="background:rgba(255,255,255,0.1); color:#60a5fa; display:inline-block; padding:6px 14px; border-radius:20px; font-size:12px; font-weight:700; margin-bottom:12px;">
    KATALOG PRODUK & LAYANAN
  </div>
  <h1>Pilihan Kategori Advertising & Reklame</h1>
  <p>Pilih kategori yang Anda cari untuk meninjau produk detail, foto pengerjaan, estimasi biaya, dan spesifikasi material.</p>
</div>

<div class="catalog-container">
  <div class="breadcrumb">
    <a href="{{ route('home') }}">Beranda</a>
    <span>/</span>
    <span>Kategori Produk</span>
  </div>

  <!-- Filter Select Dropdown (Image 3 Style) -->
  <div class="filter-select-row">
    <div class="filter-select-col">
      <select class="filter-select" onchange="if(this.value) window.location.href=this.value;">
        <option value="{{ route('katalog.kategori', 'semua') }}" selected>-Semua Kategori-</option>
        @foreach($categories as $category)
          <option value="{{ route('katalog.kategori', $category->slug) }}">{{ $category->nama }}</option>
        @endforeach
      </select>
    </div>
  </div>

  <div class="category-grid">
    @forelse($categories as $category)
      <a href="{{ route('katalog.kategori', $category->slug) }}" class="cat-card">
        <div class="cat-card-img">
          @if($category->foto_url)
            <img src="{{ $category->foto_url }}" alt="{{ $category->nama }}">
          @else
            
          @endif
        </div>
        <div class="cat-card-body">
          <div class="cat-card-title">{{ $category->nama }}</div>
          <div class="cat-card-count">
            {{ $category->products_count }} Produk
          </div>
          <p class="cat-card-desc">
            {{ $category->deskripsi ?: 'Koleksi produk berkualitas dengan spesifikasi custom dan garansi resmi.' }}
          </p>
          <div class="cat-card-footer">
            <span>Lihat Produk →</span>
          </div>
        </div>
      </a>
    @empty
      <div style="grid-column:1/-1; text-align:center; padding:80px 20px; color:var(--text-muted);">
        
        <p>Belum ada kategori yang tersedia.</p>
      </div>
    @endforelse
  </div>
</div>

<!-- Footer -->
<footer class="footer">
  <div><strong>Kafa Advertising</strong> — Spesialis Neon Box & Signage Custom</div>
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

