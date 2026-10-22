@extends('layouts.guest')

@section('title', 'Portofolio Proyek - Kafa Advertising')

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
  /* ─── Page Header ─── */
  .page-header {
    background: #0a1317;
    padding: 64px 8%;
    color: #ffffff;
    text-align: center;
    position: relative;
    overflow: hidden;
  }
  .page-header h1 {
    font-size: 40px;
    font-weight: 500;
    margin-bottom: 12px;
    letter-spacing: -0.5px;
  }
  .page-header p {
    font-size: 16px;
    font-weight: 300;
    color: rgba(255,255,255,0.8);
    max-width: 600px;
    margin: 0 auto;
    line-height: 1.6;
  }

  /* ─── Portfolio Grid ─── */
  .portfolio-container {
    padding: 40px 8% 80px;
    max-width: 1320px;
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
    color: var(--text-muted);
    text-decoration: none;
  }
  .breadcrumb a:hover {
    color: var(--primary);
  }

  /* ─── Filter Select Dropdowns (Style like Image 3) ─── */
  .filter-select-row {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 30px;
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

  .portfolio-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 28px;
  }

  .port-card {
    background: var(--bg-card);
    border: 1px solid var(--hairline-soft);
    border-radius: var(--radius-xxxl);
    overflow: hidden;
    transition: all 0.25s ease;
    display: flex;
    flex-direction: column;
  }
  .port-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--shadow-md);
    border-color: var(--hairline);
  }

  .port-card-img {
    height: 240px;
    background: var(--surface-soft);
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
    transform: scale(1.04);
  }

  .port-card-overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    padding: 14px 18px;
    background: linear-gradient(transparent, rgba(10,19,23,0.8));
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
  }

  .port-card-tag {
    display: inline-block;
    padding: 4px 12px;
    border-radius: var(--radius-full);
    background: rgba(255,255,255,0.2);
    backdrop-filter: blur(6px);
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
    .portfolio-container {
      padding: 20px 14px 40px;
    }
    .filter-select-row {
      gap: 8px;
      margin-bottom: 20px;
    }
    .filter-select-col {
      flex: 1 1 calc(50% - 8px);
      min-width: 140px;
    }
    .filter-select {
      width: 100%;
      min-width: unset;
      padding: 7px 28px 7px 10px;
      font-size: 12.5px;
    }
    .portfolio-grid {
      grid-template-columns: 1fr;
      gap: 14px;
    }
    .port-card {
      border-radius: var(--radius-xl);
    }
    .port-card-img {
      height: 180px;
    }
    .port-card-body {
      padding: 14px;
    }
    .port-card-title {
      font-size: 16px;
    }
    .port-card-desc {
      font-size: 12.5px;
    }
    .port-card-footer {
      padding: 10px 14px;
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

<!-- Page Header -->
<div class="page-header">
  <div style="display:inline-flex; align-items:center; gap:6px; padding:6px 14px; border-radius:20px; font-size:12px; font-weight:700; margin-bottom:12px; background:rgba(255,255,255,0.1); color:#60a5fa;">
    <i class="bi bi-images"></i> PORTOFOLIO PROYEK
  </div>
  <h1>Hasil Karya & Proyek Kami</h1>
  <p>Lihat koleksi proyek neon box, signage, dan advertising yang telah kami kerjakan untuk berbagai klien di seluruh Indonesia.</p>
</div>

<div class="portfolio-container">
  <div class="breadcrumb" style="display:flex; align-items:center; gap:8px;">
    <a href="{{ route('home') }}" style="display:inline-flex; align-items:center; gap:4px;"><i class="bi bi-house-door"></i> Beranda</a>
    <i class="bi bi-chevron-right" style="font-size:11px; opacity:0.6;"></i>
    <span>Portofolio</span>
  </div>

  <!-- Category & Year Filter Selects (Image 3 Style) -->
  <div class="filter-select-row">
    <div class="filter-select-col">
      <select class="filter-select" id="portfolioCategorySelect" onchange="filterPortfolio()">
        <option value="all">-Semua Kategori-</option>
        @foreach($categories as $cat)
          <option value="cat-{{ $cat->id }}">{{ $cat->nama }}</option>
        @endforeach
      </select>
    </div>

    @php
      $years = $portfolios->pluck('tahun')->filter()->unique()->sortDesc();
    @endphp
    @if($years->count() > 0)
    <div class="filter-select-col">
      <select class="filter-select" id="portfolioYearSelect" onchange="filterPortfolio()">
        <option value="all">-Semua Tahun-</option>
        @foreach($years as $yr)
          <option value="{{ $yr }}">{{ $yr }}</option>
        @endforeach
      </select>
    </div>
    @endif
  </div>

  <div class="portfolio-grid" id="portfolioGrid">
    @forelse($portfolios as $p)
      <div class="port-card" data-category="cat-{{ $p->category_id }}" data-year="{{ $p->tahun }}">
        <div class="port-card-img" style="display:flex; align-items:center; justify-content:center; background:#1e293b;">
          @if($p->foto_url)
            <img src="{{ $p->foto_url }}" alt="{{ $p->nama }}">
          @else
            <i class="bi bi-image" style="font-size:40px; color:#64748b;"></i>
          @endif
          <div class="port-card-overlay">
            @if($p->category)
              <span class="port-card-tag"><i class="bi bi-tag-fill" style="margin-right:3px;"></i> {{ $p->category ? $p->category->nama : '' }}</span>
            @endif
            @if($p->tahun)
              <span class="port-card-tag"><i class="bi bi-calendar3" style="margin-right:3px;"></i> {{ $p->tahun }}</span>
            @endif
          </div>
        </div>
        <div class="port-card-body">
          <div class="port-card-title">{{ $p->nama }}</div>
          <div class="port-card-meta">
            @if($p->client)
              <span><i class="bi bi-building"></i> {{ $p->client }}</span>
            @endif
            @if($p->lokasi)
              <span><i class="bi bi-geo-alt"></i> {{ $p->lokasi }}</span>
            @endif
          </div>
          <p class="port-card-desc">{{ Str::limit($p->deskripsi ?: 'Proyek custom signage & advertising berkualitas premium.', 120) }}</p>
        </div>
        @if($p->category || $p->tahun)
        <div class="port-card-footer">
          @if($p->category)
            <span class="port-card-category"><i class="bi bi-tag"></i> {{ $p->category ? $p->category->nama : '' }}</span>
          @else
            <span></span>
          @endif
          @if($p->tahun)
            <span class="port-card-year"><i class="bi bi-calendar-event"></i> {{ $p->tahun }}</span>
          @endif
        </div>
        @endif
      </div>
    @empty
      <div style="grid-column:1/-1; text-align:center; padding:80px 20px; color:var(--text-muted);">
        <i class="bi bi-folder2-open" style="font-size:48px; color:var(--text-muted); display:block; margin-bottom:12px;"></i>
        <p style="font-size:16px; font-weight:600;">Portofolio sedang diperbarui.</p>
        <p style="font-size:14px; margin-top:8px;">Hubungi kami via WhatsApp untuk melihat contoh proyek yang telah kami kerjakan.</p>
      </div>
    @endforelse
  </div>
</div>

<!-- Footer -->
<footer class="footer">
  <div><strong><i class="bi bi-award"></i> Kafa Advertising</strong> — Spesialis Neon Box & Signage Custom</div>
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

// Portfolio Filter (Multi-Criteria: Category & Year)
function filterPortfolio() {
  const catSelect = document.getElementById('portfolioCategorySelect');
  const yrSelect = document.getElementById('portfolioYearSelect');

  const selectedCat = catSelect ? catSelect.value : 'all';
  const selectedYr = yrSelect ? yrSelect.value : 'all';

  const cards = document.querySelectorAll('.port-card');
  let visibleCount = 0;

  cards.forEach(card => {
    const cardCat = card.getAttribute('data-category');
    const cardYr = card.getAttribute('data-year');

    const matchCat = (selectedCat === 'all' || cardCat === selectedCat);
    const matchYr = (selectedYr === 'all' || cardYr === selectedYr);

    if (matchCat && matchYr) {
      card.style.display = '';
      visibleCount++;
    } else {
      card.style.display = 'none';
    }
  });

  let emptyMsg = document.getElementById('portfolioEmptyFilter');
  if (visibleCount === 0) {
    if (!emptyMsg) {
      emptyMsg = document.createElement('div');
      emptyMsg.id = 'portfolioEmptyFilter';
      emptyMsg.style.cssText = 'grid-column: 1 / -1; text-align: center; padding: 60px 20px; color: var(--text-muted);';
      emptyMsg.innerHTML = '<i class="bi bi-search" style="font-size: 32px; display: block; margin-bottom: 12px; opacity: 0.5;"></i><p>Tidak ada proyek yang sesuai dengan filter yang dipilih.</p>';
      document.getElementById('portfolioGrid').appendChild(emptyMsg);
    }
    emptyMsg.style.display = '';
  } else if (emptyMsg) {
    emptyMsg.style.display = 'none';
  }
}
</script>
@endsection
