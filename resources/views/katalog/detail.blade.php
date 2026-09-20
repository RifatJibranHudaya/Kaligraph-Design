@extends('layouts.guest')

@section('title', $product->nama . ' - Kafa Advertising')

@section('styles')
<style>
  /* ─── Navbar ─── */
  .navbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 14px 8%;
    background: #ffffff;
    border-bottom: 1px solid var(--hairline-soft);
    position: sticky;
    top: 0;
    z-index: 1000;
    box-shadow: 0 1px 3px rgba(10, 19, 23, 0.04);
  }

  .nav-brand {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 19px;
    font-weight: 800;
    color: var(--ink-deep);
    text-decoration: none;
    letter-spacing: -0.4px;
  }

  .nav-brand .brand-logo {
    width: 36px;
    height: 36px;
    background: var(--primary);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    font-weight: 800;
    color: #ffffff;
  }

  .nav-pills-center {
    display: none;
    gap: 8px;
    align-items: center;
  }
  @media(min-width: 900px) {
    .nav-pills-center {
      display: flex;
    }
  }

  .nav-pill-btn {
    padding: 8px 18px;
    border-radius: var(--radius-full);
    font-size: 13.5px;
    font-weight: 700;
    letter-spacing: -0.14px;
    text-decoration: none;
    color: var(--text-body);
    background: var(--bg-card);
    border: 1px solid var(--hairline);
    transition: all 0.2s ease;
  }
  .nav-pill-btn:hover {
    background: var(--surface-soft);
    border-color: var(--text-muted);
  }

  .nav-right-wrap {
    display: flex;
    align-items: center;
    gap: 12px;
  }

  .menu-toggle-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 9px 20px;
    background: var(--ink-deep);
    color: #fff;
    border: none;
    border-radius: var(--radius-full);
    font-size: 13px;
    font-weight: 700;
    letter-spacing: 0.5px;
    cursor: pointer;
  }

  .menu-burger-icon {
    width: 16px;
    height: 12px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
  }
  .menu-burger-icon span {
    display: block;
    height: 2px;
    background: #fff;
    border-radius: 2px;
  }
  .menu-burger-icon .line-1 { width: 100%; }
  .menu-burger-icon .line-2 { width: 70%; margin-left: auto; }
  .menu-burger-icon .line-3 { width: 100%; }

  /* ─── Breadcrumbs ─── */
  .breadcrumb-nav {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 13px;
    color: var(--text-muted);
    padding: 24px 8% 12px;
    background: var(--bg-main);
  }
  .breadcrumb-nav a {
    color: var(--text-muted);
    text-decoration: none;
  }
  .breadcrumb-nav a:hover {
    color: var(--primary);
  }
  .breadcrumb-nav .active {
    color: var(--ink-deep);
    font-weight: 700;
  }

  /* ─── PDP 2-Column Split Layout ─── */
  .pdp-container {
    padding: 12px 8% 80px;
    max-width: 1320px;
    margin: 0 auto;
  }

  .pdp-grid {
    display: grid;
    grid-template-columns: 1.15fr 0.85fr;
    gap: 48px;
    align-items: flex-start;
  }

  /* Gallery Hero */
  .pdp-gallery-card {
    background: var(--surface-soft);
    border: 1px solid var(--hairline-soft);
    border-radius: var(--radius-xxxl);
    overflow: hidden;
    height: 520px;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .pdp-gallery-card img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  /* Sticky Right Rail (card-checkout-summary) */
  .pdp-summary-rail {
    position: sticky;
    top: 90px;
    background: var(--bg-card);
    border: 1px solid var(--hairline-soft);
    border-radius: var(--radius-xl);
    padding: 36px;
    box-shadow: var(--shadow-sticky);
  }

  .pdp-badge-pill {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 4px 12px;
    background: var(--surface-soft);
    color: var(--primary);
    border: 1px solid var(--hairline-soft);
    border-radius: var(--radius-full);
    font-size: 12px;
    font-weight: 700;
    margin-bottom: 14px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }

  .pdp-title {
    font-size: 32px;
    font-weight: 500;
    color: var(--ink-deep);
    line-height: 1.2;
    margin-bottom: 14px;
    letter-spacing: -0.5px;
  }

  .pdp-price-row {
    margin-bottom: 24px;
    padding-bottom: 20px;
    border-bottom: 1px solid var(--hairline-soft);
  }

  .pdp-price-label {
    font-size: 12px;
    font-weight: 600;
    color: var(--text-muted);
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }

  .pdp-price-value {
    font-size: 30px;
    font-weight: 700;
    color: var(--ink-deep);
    margin-top: 4px;
    letter-spacing: -0.5px;
  }

  .pdp-desc {
    font-size: 14.5px;
    color: var(--text-body);
    line-height: 1.6;
    margin-bottom: 28px;
  }

  /* Tech Specs Table (2-column minimal key/value) */
  .tech-specs-box {
    margin-bottom: 28px;
    border: 1px solid var(--hairline-soft);
    border-radius: var(--radius-lg);
    background: var(--surface-soft);
    padding: 18px 20px;
  }

  .tech-specs-title {
    font-size: 13px;
    font-weight: 700;
    color: var(--ink-deep);
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 12px;
  }

  .spec-row {
    display: flex;
    justify-content: space-between;
    padding: 8px 0;
    font-size: 13px;
    border-bottom: 1px solid var(--hairline-soft);
  }
  .spec-row:last-child {
    border-bottom: none;
  }
  .spec-label {
    color: var(--text-muted);
    font-weight: 500;
  }
  .spec-val {
    color: var(--ink-deep);
    font-weight: 700;
  }

  /* Cobalt Buy CTA Button */
  .btn-buy-rail {
    width: 100%;
    padding: 16px 28px;
    background: var(--primary);
    color: #ffffff;
    border-radius: var(--radius-full);
    font-size: 15px;
    font-weight: 700;
    letter-spacing: -0.14px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    text-decoration: none;
    transition: all 0.2s ease;
    border: none;
    cursor: pointer;
  }
  .btn-buy-rail:hover {
    background: var(--primary-deep);
  }

  /* Feature reassurance cards (4-up) */
  .pdp-reassurance-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 12px;
    margin-top: 24px;
  }

  .reassurance-chip {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px 14px;
    background: var(--surface-soft);
    border-radius: var(--radius-lg);
    font-size: 12px;
    font-weight: 600;
    color: var(--text-body);
  }

  /* Related Products */
  .related-section {
    margin-top: 80px;
    padding-top: 48px;
    border-top: 1px solid var(--hairline-soft);
  }

  .related-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
    gap: 24px;
  }

  .related-card {
    background: var(--bg-card);
    border: 1px solid var(--hairline-soft);
    border-radius: var(--radius-xxl);
    padding: 20px;
    text-decoration: none;
    display: flex;
    flex-direction: column;
    transition: all 0.2s ease;
  }
  .related-card:hover {
    border-color: var(--hairline);
    box-shadow: var(--shadow-sm);
    transform: translateY(-4px);
  }

  .related-img {
    width: 100%;
    height: 160px;
    object-fit: cover;
    border-radius: var(--radius-xl);
    margin-bottom: 14px;
    background: var(--surface-soft);
  }

  .related-title {
    font-size: 16px;
    font-weight: 700;
    color: var(--ink-deep);
    margin-bottom: 4px;
  }

  .related-price {
    font-size: 14px;
    font-weight: 700;
    color: var(--primary);
  }

  /* ─── Footer ─── */
  .footer-region {
    background: #ffffff;
    border-top: 1px solid var(--hairline-soft);
    padding: 48px 8% 32px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 16px;
    font-size: 13px;
    color: var(--text-stone);
  }

  @media (max-width: 960px) {
    .pdp-grid { grid-template-columns: 1fr; gap: 20px; }
    .pdp-gallery-card { height: 280px; border-radius: var(--radius-xl); }
    .pdp-summary-rail { position: static; padding: 20px 14px; border-radius: var(--radius-xl); }
    .pdp-container { padding: 12px 14px 40px; }
    .breadcrumb-nav { padding: 14px 14px 8px; font-size: 12px; }
    .navbar { padding: 10px 14px; }
    .pdp-title { font-size: 22px; }
    .pdp-price-value { font-size: 24px; }
    .pdp-desc { font-size: 13px; margin-bottom: 18px; }
    .btn-buy-rail { padding: 12px 18px; font-size: 14px; }
    .footer-region { padding: 24px 14px; flex-direction: column; text-align: center; gap: 8px; font-size: 12px; }
  }
</style>
@endsection

@section('content')

<!-- Navbar -->
<nav class="navbar">
  <a href="{{ route('home') }}" class="nav-brand">
    <div class="brand-logo">K</div>
    <span>Kafa Advertising</span>
  </a>

  <div class="nav-pills-center">
    <a href="{{ route('home') }}" class="nav-pill-btn">Beranda</a>
    <a href="{{ route('katalog') }}" class="nav-pill-btn">Katalog Produk</a>
    <a href="{{ route('portofolio') }}" class="nav-pill-btn">Portofolio</a>
  </div>

  <div class="nav-right-wrap">
    <a href="{{ route('login.customer') }}" class="nav-pill-btn" style="border-color: var(--primary); color: var(--primary); font-weight: 700;">
      Portal Pelanggan
    </a>
  </div>
</nav>

<!-- Breadcrumb -->
<div class="breadcrumb-nav">
  <a href="{{ route('home') }}">Beranda</a>
  <span>›</span>
  <a href="{{ route('katalog') }}">Katalog</a>
  <span>›</span>
  <a href="{{ route('katalog.kategori', $product->category->slug ?? 'kategori') }}">{{ $product->category->nama ?? 'Kategori' }}</a>
  <span>›</span>
  <span class="active">{{ $product->nama }}</span>
</div>

<!-- Main PDP Content -->
<div class="pdp-container">
  <div class="pdp-grid">
    
    <!-- Gallery Column Left -->
    <div>
      <div class="pdp-gallery-card">
        @if($product->foto_url)
          <img src="{{ $product->foto_url }}" alt="{{ $product->nama }}">
        @else
          <div style="font-size: 64px; color: var(--text-muted); font-weight: 800;">
            K
          </div>
        @endif
      </div>

      <!-- Feature reassurance row below hero photo -->
      <div class="pdp-reassurance-grid">
        <div class="reassurance-chip">
          <span>✓</span>
          <span>Garansi 12 Bln</span>
        </div>
        <div class="reassurance-chip">
          <span>✓</span>
          <span>Custom Desain</span>
        </div>
        <div class="reassurance-chip">
          <span>✓</span>
          <span>Kirim Nasional</span>
        </div>
        <div class="reassurance-chip">
          <span>✓</span>
          <span>Teknisi Pasang</span>
        </div>
      </div>
    </div>

    <!-- Sticky Purchase Rail Column Right (card-checkout-summary) -->
    <div class="pdp-summary-rail">
      <div class="pdp-badge-pill">
        {{ $product->category->nama ?? 'Advertising & Signage' }}
      </div>
      <h1 class="pdp-title">{{ $product->nama }}</h1>

      <div class="pdp-price-row">
        <div class="pdp-price-label">Estimasi Biaya Mulai</div>
        <div class="pdp-price-value">
          Rp {{ number_format($product->harga, 0, ',', '.') }}
        </div>
      </div>

      <p class="pdp-desc">
        {{ $product->deskripsi ?: 'Produk signage neon box berkualitas premium dengan material akrilik terbaik dan modul pencahayaan LED berdaya tahan tinggi.' }}
      </p>

      <!-- Tech Specs Box -->
      <div class="tech-specs-box">
        <div class="tech-specs-title">Spesifikasi Material</div>
        <div class="spec-row">
          <span class="spec-label">Kategori</span>
          <span class="spec-val">{{ $product->category->nama ?? '-' }}</span>
        </div>
        <div class="spec-row">
          <span class="spec-label">Ketahanan</span>
          <span class="spec-val">Outdoor & Indoor (Weatherproof)</span>
        </div>
        <div class="spec-row">
          <span class="spec-label">Penerangan</span>
          <span class="spec-val">Modul LED High-Brightness</span>
        </div>
        <div class="spec-row">
          <span class="spec-label">Waktu Pengerjaan</span>
          <span class="spec-val">3 – 7 Hari Kerja</span>
        </div>
      </div>

      <!-- Buy CTA Button -->
      <a href="{{ \App\Helpers\FormatHelper::whatsappUrl('Halo Kafa Advertising, saya berminat memesan produk ' . $product->nama . ' (Rp ' . number_format($product->harga, 0, ',', '.') . ')') }}" target="_blank" class="btn-buy-rail">
        Pesan via WhatsApp
      </a>
    </div>

  </div>

  <!-- Related Products Section -->
  @if(isset($relatedProducts) && $relatedProducts->count() > 0)
    <div class="related-section">
      <h2 style="font-size: 24px; font-weight: 500; color: var(--ink-deep); margin-bottom: 24px; letter-spacing: -0.4px;">
        Pilihan Produk Terkait
      </h2>
      <div class="related-grid">
        @foreach($relatedProducts as $rel)
          <a href="{{ route('katalog.detail', [$rel->category->slug, $rel->id]) }}" class="related-card">
            @if($rel->foto_url)
              <img src="{{ $rel->foto_url }}" alt="{{ $rel->nama }}" class="related-img">
            @else
              <div class="related-img" style="display:flex; align-items:center; justify-content:center; font-size:24px; color:var(--text-muted);">K</div>
            @endif
            <div class="related-title">{{ $rel->nama }}</div>
            <div class="related-price">Rp {{ number_format($rel->harga, 0, ',', '.') }}</div>
          </a>
        @endforeach
      </div>
    </div>
  @endif
</div>

<!-- Footer -->
<footer class="footer-region">
  <div><strong>Kafa Advertising</strong> — Spesialis Reklame & Signage Modern</div>
  <div>© {{ date('Y') }} Hak Cipta Dilindungi.</div>
</footer>

@endsection

@section('scripts')
<script>
document.addEventListener('keydown', function(e) {
  if (e.key === 'Escape') {
    // Handle escape if needed
  }
});
</script>
@endsection
