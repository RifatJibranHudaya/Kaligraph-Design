@extends('layouts.guest')

@section('title', 'Kaligraph Design - Jasa Neon Box & Signage Custom Terbaik')

@section('styles')
<style>
  /* ─── Navbar ─── */
  .navbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 18px 8%;
    background: rgba(255,255,255,0.92);
    backdrop-filter: blur(12px);
    border-bottom: 1px solid var(--border-color);
    position: sticky;
    top: 0;
    z-index: 100;
    box-shadow: 0 2px 20px rgba(37,99,235,0.08);
  }

  .nav-brand {
    display: flex;
    align-items: center;
    gap: 10px;
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
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
  }

  .nav-links {
    display: flex;
    align-items: center;
    gap: 28px;
    list-style: none;
  }

  .nav-links a {
    color: var(--text-main);
    text-decoration: none;
    font-weight: 600;
    font-size: 14px;
    transition: color 0.2s;
  }

  .nav-links a:hover { color: var(--primary); }

  .btn-login {
    padding: 9px 20px;
    background: linear-gradient(135deg, #2563eb, #7c3aed) !important;
    color: #fff !important;
    border-radius: 8px;
    font-weight: 700 !important;
    box-shadow: 0 4px 12px rgba(37,99,235,0.3);
    transition: transform 0.2s, box-shadow 0.2s !important;
  }
  .btn-login:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 20px rgba(37,99,235,0.4) !important;
  }

  /* ─── Hero Section ─── */
  .hero-section {
    position: relative;
    min-height: 90vh;
    display: flex;
    align-items: center;
    overflow: hidden;
  }

  .hero-bg {
    position: absolute;
    inset: 0;
    background-image: url('/images/neon_box_hero.jpg');
    background-size: cover;
    background-position: center;
    filter: brightness(0.35);
  }

  .hero-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, rgba(37,99,235,0.6) 0%, rgba(124,58,237,0.4) 50%, rgba(0,0,0,0.2) 100%);
  }

  .hero-content {
    position: relative;
    z-index: 2;
    padding: 0 8%;
    max-width: 800px;
  }

  .hero-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 16px;
    background: rgba(234,179,8,0.2);
    border: 1px solid rgba(234,179,8,0.5);
    color: #fbbf24;
    border-radius: 30px;
    font-size: 13px;
    font-weight: 700;
    margin-bottom: 24px;
    backdrop-filter: blur(8px);
    animation: fadeInDown 0.6s ease;
  }

  .hero-title {
    font-size: 58px;
    font-weight: 800;
    line-height: 1.1;
    color: #fff;
    margin-bottom: 20px;
    animation: fadeInUp 0.7s ease;
  }

  .hero-title .highlight {
    background: linear-gradient(135deg, #60a5fa, #a78bfa);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
  }

  .hero-subtitle {
    font-size: 18px;
    color: rgba(255,255,255,0.8);
    line-height: 1.7;
    margin-bottom: 36px;
    animation: fadeInUp 0.8s ease;
  }

  .hero-btns {
    display: flex;
    gap: 16px;
    flex-wrap: wrap;
    animation: fadeInUp 0.9s ease;
  }

  .btn-hero-primary {
    padding: 15px 32px;
    background: linear-gradient(135deg, #2563eb, #7c3aed);
    color: #fff;
    border-radius: 12px;
    font-size: 16px;
    font-weight: 700;
    text-decoration: none;
    box-shadow: 0 8px 30px rgba(37,99,235,0.5);
    transition: transform 0.3s, box-shadow 0.3s;
    display: inline-flex;
    align-items: center;
    gap: 8px;
  }

  .btn-hero-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 40px rgba(37,99,235,0.6);
  }

  .btn-hero-wa {
    padding: 15px 32px;
    background: #25d366;
    color: #fff;
    border-radius: 12px;
    font-size: 16px;
    font-weight: 700;
    text-decoration: none;
    box-shadow: 0 8px 30px rgba(37,211,102,0.4);
    transition: transform 0.3s, box-shadow 0.3s;
    display: inline-flex;
    align-items: center;
    gap: 8px;
  }

  .btn-hero-wa:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 40px rgba(37,211,102,0.5);
  }

  .hero-stats {
    position: relative;
    z-index: 2;
    display: flex;
    gap: 40px;
    padding: 28px 8%;
    background: rgba(255,255,255,0.05);
    backdrop-filter: blur(12px);
    border-top: 1px solid rgba(255,255,255,0.1);
  }

  .hero-stat {
    text-align: center;
    color: #fff;
  }

  .hero-stat .num {
    font-size: 28px;
    font-weight: 800;
    color: #60a5fa;
  }

  .hero-stat .lbl {
    font-size: 12px;
    color: rgba(255,255,255,0.6);
    margin-top: 2px;
  }

  /* ─── Section ─── */
  .section {
    padding: 90px 8%;
  }

  .section-badge {
    display: inline-block;
    padding: 6px 14px;
    background: var(--primary-light);
    color: var(--primary);
    border-radius: 20px;
    font-size: 12px;
    font-weight: 700;
    margin-bottom: 12px;
    letter-spacing: 0.5px;
    text-transform: uppercase;
  }

  .section-title {
    font-size: 36px;
    font-weight: 800;
    color: var(--text-main);
    margin-bottom: 12px;
    letter-spacing: -0.5px;
  }

  .section-subtitle {
    font-size: 16px;
    color: var(--text-muted);
    margin-bottom: 50px;
    max-width: 560px;
    line-height: 1.7;
  }

  /* ─── Products Grid ─── */
  .products-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(290px, 1fr));
    gap: 28px;
  }

  .product-card {
    background: var(--bg-card);
    border: 1px solid var(--border-color);
    border-radius: 20px;
    padding: 28px;
    transition: transform 0.3s, box-shadow 0.3s, border-color 0.3s;
    cursor: pointer;
    position: relative;
    overflow: hidden;
  }

  .product-card::before {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, rgba(37,99,235,0.04), rgba(124,58,237,0.04));
    opacity: 0;
    transition: opacity 0.3s;
  }

  .product-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 20px 40px rgba(37,99,235,0.12);
    border-color: rgba(37,99,235,0.3);
  }

  .product-card:hover::before { opacity: 1; }

  .product-icon-wrap {
    width: 72px;
    height: 72px;
    border-radius: 18px;
    background: linear-gradient(135deg, var(--primary-light), #ede9fe);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 36px;
    margin-bottom: 20px;
    position: relative;
    z-index: 1;
  }

  .product-name {
    font-size: 18px;
    font-weight: 800;
    color: var(--text-main);
    margin-bottom: 8px;
    position: relative;
    z-index: 1;
  }

  .product-price {
    font-size: 20px;
    font-weight: 800;
    background: linear-gradient(135deg, #2563eb, #7c3aed);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: 10px;
    position: relative;
    z-index: 1;
  }

  .product-desc {
    font-size: 13px;
    color: var(--text-muted);
    line-height: 1.6;
    position: relative;
    z-index: 1;
  }

  .product-badge {
    position: absolute;
    top: 20px;
    right: 20px;
    padding: 4px 10px;
    background: linear-gradient(135deg, #eab308, #f97316);
    color: #fff;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 700;
  }

  /* ─── Features Section ─── */
  .features-section {
    background: linear-gradient(135deg, #0d1b3e 0%, #1e1b4b 100%);
    padding: 90px 8%;
    position: relative;
    overflow: hidden;
  }

  .features-section::before {
    content: '';
    position: absolute;
    top: -50%;
    left: -10%;
    width: 600px;
    height: 600px;
    background: radial-gradient(circle, rgba(37,99,235,0.15) 0%, transparent 70%);
    pointer-events: none;
  }

  .features-section .section-title { color: #fff; }
  .features-section .section-subtitle { color: rgba(255,255,255,0.6); }
  .features-section .section-badge { background: rgba(255,255,255,0.1); color: #60a5fa; }

  .features-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
    gap: 24px;
  }

  .feature-card {
    background: rgba(255,255,255,0.05);
    border: 1px solid rgba(255,255,255,0.1);
    border-radius: 20px;
    padding: 28px;
    backdrop-filter: blur(8px);
    transition: transform 0.3s, background 0.3s;
  }

  .feature-card:hover {
    transform: translateY(-4px);
    background: rgba(255,255,255,0.08);
  }

  .feature-icon {
    width: 56px;
    height: 56px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 28px;
    margin-bottom: 18px;
  }

  .feature-card h3 {
    font-size: 16px;
    font-weight: 700;
    color: #fff;
    margin-bottom: 8px;
  }

  .feature-card p {
    font-size: 13px;
    color: rgba(255,255,255,0.55);
    line-height: 1.7;
  }

  /* ─── Branches ─── */
  .branches-section {
    padding: 90px 8%;
    background: var(--bg-main);
  }

  .branches-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 24px;
  }

  .branch-card {
    background: var(--bg-card);
    border: 1px solid var(--border-color);
    border-radius: 20px;
    padding: 28px;
    transition: transform 0.3s, box-shadow 0.3s;
    display: flex;
    flex-direction: column;
    gap: 12px;
  }

  .branch-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 16px 30px rgba(37,99,235,0.1);
  }

  .branch-icon-circle {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    background: var(--primary-light);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
  }

  .branch-name {
    font-size: 17px;
    font-weight: 800;
    color: var(--text-main);
  }

  .branch-addr {
    font-size: 13px;
    color: var(--text-muted);
    line-height: 1.6;
  }

  .branch-map-btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    color: var(--primary);
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
    margin-top: 4px;
  }

  .branch-map-btn:hover { text-decoration: underline; }

  /* ─── CTA Section ─── */
  .cta-section {
    padding: 80px 8%;
    background: linear-gradient(135deg, #2563eb 0%, #7c3aed 100%);
    text-align: center;
  }

  .cta-section h2 {
    font-size: 40px;
    font-weight: 800;
    color: #fff;
    margin-bottom: 16px;
  }

  .cta-section p {
    font-size: 17px;
    color: rgba(255,255,255,0.8);
    margin-bottom: 36px;
    max-width: 540px;
    margin-left: auto;
    margin-right: auto;
    line-height: 1.7;
  }

  /* ─── WhatsApp Float ─── */
  .wa-float {
    position: fixed;
    bottom: 28px;
    right: 28px;
    z-index: 999;
    width: 56px;
    height: 56px;
    background: #25d366;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 8px 24px rgba(37,211,102,0.5);
    text-decoration: none;
    font-size: 28px;
    transition: transform 0.3s, box-shadow 0.3s;
    animation: pulse-wa 2s infinite;
  }

  .wa-float:hover {
    transform: scale(1.1);
    box-shadow: 0 12px 32px rgba(37,211,102,0.6);
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

  .footer-brand {
    font-weight: 800;
    color: #60a5fa;
    font-size: 16px;
  }

  /* ─── Animations ─── */
  @keyframes fadeInDown {
    from { opacity: 0; transform: translateY(-20px); }
    to { opacity: 1; transform: translateY(0); }
  }

  @keyframes fadeInUp {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
  }

  @keyframes pulse-wa {
    0%, 100% { box-shadow: 0 8px 24px rgba(37,211,102,0.5); }
    50% { box-shadow: 0 8px 32px rgba(37,211,102,0.8), 0 0 0 12px rgba(37,211,102,0.12); }
  }

  /* ─── Responsive ─── */
  @media (max-width: 768px) {
    .hero-title { font-size: 36px; }
    .hero-stats { gap: 20px; flex-wrap: wrap; }
    .nav-links { gap: 16px; }
    .section-title { font-size: 28px; }
    .cta-section h2 { font-size: 28px; }
    .footer { flex-direction: column; text-align: center; }
  }

  @media (max-width: 480px) {
    .nav-links { display: none; }
    .hero-btns { flex-direction: column; }
  }
</style>
@endsection

@section('content')

<!-- WhatsApp Float Button -->
<a href="https://wa.me/6281234567890?text=Halo%20Kaligraph%20Design%2C%20saya%20ingin%20memesan%20neon%20box" target="_blank" class="wa-float" title="Chat WhatsApp">
  💬
</a>

<!-- ─── Navbar ─── -->
<nav class="navbar">
  <a href="#" class="nav-brand">
    <div class="brand-logo">💡</div>
    <span>Kaligraph Design</span>
  </a>
  <ul class="nav-links">
    <li><a href="#home">Beranda</a></li>
    <li><a href="#produk">Produk</a></li>
    <li><a href="#keunggulan">Keunggulan</a></li>
    <li><a href="#cabang">Lokasi</a></li>
    <li><a href="{{ route('login.customer') }}" style="color:var(--primary); font-weight:700;">🛍️ Portal Pelanggan</a></li>
    <li><a href="{{ route('login.admin') }}" class="btn-login">Masuk Staff / Admin ➔</a></li>
  </ul>
</nav>

<!-- ─── Hero Section ─── -->
<section class="hero-section" id="home">
  <div class="hero-bg"></div>
  <div class="hero-overlay"></div>

  <div style="flex:1; display:flex; flex-direction:column; justify-content:space-between; min-height:90vh;">
    <div class="hero-content" style="padding-top: 80px; padding-bottom: 60px; flex: 1; display: flex; flex-direction: column; justify-content: center;">
      @php $hero = $homeContents['hero']->first() ?? null; @endphp
      <div class="hero-badge">
        ⚡ {{ $hero->subtitle ?? 'Spesialis Neon Box & Signage Custom' }}
      </div>
      <h1 class="hero-title">
        {{ $hero->title ?? 'Solusi' }} <span class="highlight">Neon Box</span><br>
        Terbaik di Indonesia
      </h1>
      <p class="hero-subtitle">
        {{ $hero->content ?? 'Kaligraph Design menghadirkan neon box akrilik, flexy, LED, huruf timbul, dan signage custom berkualitas premium. Garansi terpasang, harga bersaing.' }}
      </p>
      <div class="hero-btns">
        <a href="#produk" class="btn-hero-primary">🔦 Lihat Katalog Produk</a>
        <a href="https://wa.me/6281234567890?text=Halo%2C%20saya%20mau%20pesan%20neon%20box" target="_blank" class="btn-hero-wa">💬 Pesan via WhatsApp</a>
      </div>
    </div>

    <div class="hero-stats">
      <div class="hero-stat">
        <div class="num">500+</div>
        <div class="lbl">Proyek Selesai</div>
      </div>
      <div class="hero-stat">
        <div class="num">8+</div>
        <div class="lbl">Tahun Pengalaman</div>
      </div>
      <div class="hero-stat">
        <div class="num">100%</div>
        <div class="lbl">Bergaransi</div>
      </div>
      <div class="hero-stat">
        <div class="num">24/7</div>
        <div class="lbl">Layanan Pelanggan</div>
      </div>
    </div>
  </div>
</section>

<!-- ─── Products Section ─── -->
<section class="section" id="produk">
  <div class="section-badge">Katalog Produk</div>
  <h2 class="section-title">Produk Neon Box Kami</h2>
  <p class="section-subtitle">Berbagai pilihan neon box dan signage custom untuk kebutuhan bisnis Anda — mulai toko kecil hingga properti komersial besar.</p>

  <div class="products-grid">
    @forelse($products as $prod)
      <div class="product-card">
        @if($loop->first)
          <div class="product-badge">⭐ Terlaris</div>
        @endif
        @if($prod->foto_url)
          <img src="{{ $prod->foto_url }}" alt="{{ $prod->nama }}" style="width:100%; height:180px; object-fit:cover; border-radius:14px; margin-bottom:16px; border:1px solid var(--border-color);">
        @else
          <div class="product-icon-wrap">💡</div>
        @endif
        <div class="product-name">{{ $prod->nama }}</div>
        <div class="product-price">{{ $prod->harga_display }}</div>
        <p class="product-desc">{{ $prod->deskripsi ?: 'Custom sesuai kebutuhan bisnis Anda. Garansi pemasangan & material.' }}</p>
      </div>
    @empty
      <div style="grid-column:1/-1; text-align:center; padding:60px 0; color:var(--text-muted);">
        <div style="font-size:48px; margin-bottom:16px;">💡</div>
        <p>Produk sedang diperbarui. Hubungi kami langsung!</p>
      </div>
    @endforelse
  </div>
</section>

<!-- ─── Features Section ─── -->
<section class="features-section" id="keunggulan">
  <div class="section-badge">Keunggulan Kami</div>
  <h2 class="section-title">Mengapa Pilih Kaligraph Design?</h2>
  <p class="section-subtitle">Kami bukan sekadar produsen — kami adalah mitra branding visual bisnis Anda.</p>

  <div class="features-grid">
    <div class="feature-card">
      <div class="feature-icon" style="background:rgba(37,99,235,0.15);">🏆</div>
      <h3>Kualitas Premium</h3>
      <p>Menggunakan material LED & akrilik berkualitas tinggi dengan ketahanan hingga 5–10 tahun di luar ruangan.</p>
    </div>
    <div class="feature-card">
      <div class="feature-icon" style="background:rgba(234,179,8,0.15);">⚡</div>
      <h3>Pengerjaan Cepat</h3>
      <p>Proses produksi efisien, estimasi pengerjaan 3–7 hari kerja tergantung ukuran & kompleksitas desain.</p>
    </div>
    <div class="feature-card">
      <div class="feature-icon" style="background:rgba(16,185,129,0.15);">🛡️</div>
      <h3>Garansi Resmi</h3>
      <p>Garansi material dan pemasangan hingga 12 bulan. Teknisi kami siap turun tangan jika ada masalah.</p>
    </div>
    <div class="feature-card">
      <div class="feature-icon" style="background:rgba(124,58,237,0.15);">🎨</div>
      <h3>Custom Desain</h3>
      <p>Tim desainer kami siap membantu mewujudkan konsep branding visual bisnis Anda dari nol.</p>
    </div>
    <div class="feature-card">
      <div class="feature-icon" style="background:rgba(239,68,68,0.15);">📦</div>
      <h3>Pengiriman & Pasang</h3>
      <p>Layanan antar dan pemasangan langsung oleh teknisi berpengalaman di seluruh Indonesia.</p>
    </div>
    <div class="feature-card">
      <div class="feature-icon" style="background:rgba(249,115,22,0.15);">💬</div>
      <h3>Konsultasi Gratis</h3>
      <p>Konsultasi desain, ukuran, dan anggaran tanpa biaya. Hubungi kami kapan saja via WhatsApp.</p>
    </div>
  </div>
</section>

<!-- ─── Branches Section ─── -->
<section class="branches-section" id="cabang">
  <div class="section-badge">Lokasi & Showroom</div>
  <h2 class="section-title">Cabang & Showroom Kami</h2>
  <p class="section-subtitle">Kunjungi showroom terdekat untuk melihat langsung contoh produk neon box yang kami kerjakan.</p>

  <div class="branches-grid">
    @forelse($branches as $b)
      <div class="branch-card">
        <div class="branch-icon-circle">🏪</div>
        <div class="branch-name">{{ $b->nama_cabang }}</div>
        <p class="branch-addr">{{ $b->alamat ?: 'Showroom & Workshop Kaligraph Design' }}</p>
        
        @if($b->clean_iframe)
          <div style="border-radius:12px; overflow:hidden; margin-top:8px; box-shadow:0 4px 10px rgba(0,0,0,0.05);">
            {!! $b->clean_iframe !!}
          </div>
        @endif

        @if($b->map_url && !$b->clean_iframe)
          <a href="{{ $b->map_url }}" target="_blank" class="branch-map-btn">📍 Lihat di Google Maps ➔</a>
        @endif
      </div>
    @empty
      <div style="grid-column:1/-1; text-align:center; padding:40px 0; color:var(--text-muted);">
        Informasi lokasi segera hadir.
      </div>
    @endforelse
  </div>
</section>

<!-- ─── CTA Section ─── -->
<section class="cta-section">
  <h2>Siap Memesan Neon Box Custom?</h2>
  <p>Hubungi tim kami sekarang dan dapatkan konsultasi gratis + estimasi harga terbaik untuk kebutuhan bisnis Anda.</p>
  <a href="https://wa.me/6281234567890?text=Halo%20Kaligraph%20Design%2C%20saya%20ingin%20konsultasi%20neon%20box" target="_blank" class="btn-hero-wa" style="margin: 0 auto; font-size:18px; padding:18px 40px;">
    💬 Chat WhatsApp Sekarang
  </a>
</section>

<!-- ─── Footer ─── -->
<footer class="footer">
  <div class="footer-brand">💡 Kaligraph Design</div>
  <p>© {{ date('Y') }} <strong>Kaligraph Design</strong>. Spesialis Neon Box & Signage Custom Indonesia.</p>
  <div style="display: flex; gap: 16px; font-size: 13px;">
    <a href="{{ route('login.customer') }}" style="color:#60a5fa; text-decoration:none;">Portal Pelanggan</a>
    <a href="{{ route('login.admin') }}" style="color:#94a3b8; text-decoration:none;">Login Staff / Admin</a>
    <a href="{{ route('password.request') }}" style="color:#94a3b8; text-decoration:none;">Lupa Password?</a>
  </div>
</footer>

@endsection
