<!-- ─── Navbar: Desktop (Gambar 1) & Mobile (Gambar 2) ─── -->
<style>
  /* ─── Self-Contained Navbar Styles ─── */
  .navbar {
    display: flex !important;
    align-items: center !important;
    justify-content: space-between !important;
    padding: 16px 8% !important;
    background: rgba(255, 255, 255, 0.96) !important;
    backdrop-filter: blur(14px) !important;
    -webkit-backdrop-filter: blur(14px) !important;
    border-bottom: 1px solid var(--border-color, #dee3e9) !important;
    position: sticky !important;
    top: 0 !important;
    z-index: 1000 !important;
    box-shadow: 0 4px 20px rgba(15, 23, 42, 0.04) !important;
  }

  .nav-brand {
    display: flex !important;
    align-items: center !important;
    gap: 12px !important;
    font-size: 19px !important;
    font-weight: 800 !important;
    color: var(--primary, #0064e0) !important;
    text-decoration: none !important;
    letter-spacing: -0.5px !important;
    flex-shrink: 0 !important;
  }

  .nav-brand .brand-logo {
    width: 38px !important;
    height: 38px !important;
    background: var(--primary, #0064e0) !important;
    border-radius: 10px !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    font-size: 18px !important;
    font-weight: 800 !important;
    color: #ffffff !important;
    box-shadow: 0 4px 12px rgba(0, 100, 224, 0.25) !important;
  }

  /* Desktop Menu (Sesuai Gambar 1: Horizontal links di sebelah kanan) */
  .nav-desktop-menu {
    display: flex !important;
    align-items: center !important;
    gap: 28px !important;
    list-style: none !important;
    margin: 0 !important;
    padding: 0 !important;
  }

  .nav-desktop-item {
    margin: 0 !important;
    padding: 0 !important;
    list-style: none !important;
  }

  .nav-desktop-link {
    display: inline-block !important;
    font-size: 14.5px !important;
    font-weight: 600 !important;
    color: #0f172a !important;
    text-decoration: none !important;
    padding: 6px 0 !important;
    position: relative !important;
    transition: color 0.2s ease !important;
  }

  .nav-desktop-link:hover,
  .nav-desktop-link.active {
    color: var(--primary, #0064e0) !important;
  }

  .nav-desktop-link::after {
    content: '';
    position: absolute;
    bottom: -2px;
    left: 0;
    width: 0;
    height: 2px;
    background: var(--primary, #0064e0);
    transition: width 0.25s ease;
    border-radius: 2px;
  }

  .nav-desktop-link:hover::after,
  .nav-desktop-link.active::after {
    width: 100%;
  }

  .nav-desktop-portal {
    display: inline-flex !important;
    align-items: center !important;
    gap: 6px !important;
    padding: 7px 16px !important;
    border-radius: 20px !important;
    font-size: 13px !important;
    font-weight: 700 !important;
    color: var(--primary, #0064e0) !important;
    background: #e7f1fe !important;
    border: 1px solid rgba(0, 100, 224, 0.2) !important;
    text-decoration: none !important;
    transition: all 0.2s ease !important;
    margin-left: 6px !important;
  }

  .nav-desktop-portal:hover {
    background: var(--primary, #0064e0) !important;
    color: #ffffff !important;
    box-shadow: 0 4px 12px rgba(0, 100, 224, 0.25) !important;
  }

  /* Mobile Toggle Wrap (Sesuai Gambar 2) */
  .nav-right-mobile {
    display: none !important;
  }

  .menu-toggle-btn {
    display: inline-flex !important;
    align-items: center !important;
    gap: 8px !important;
    padding: 8px 18px !important;
    background: #0f172a !important;
    color: #ffffff !important;
    border: 1px solid rgba(255, 255, 255, 0.1) !important;
    border-radius: 30px !important;
    font-size: 13px !important;
    font-weight: 800 !important;
    letter-spacing: 1px !important;
    cursor: pointer !important;
    box-shadow: 0 4px 14px rgba(15, 23, 42, 0.18) !important;
    transition: all 0.25s ease !important;
  }

  .menu-toggle-btn:hover {
    background: var(--primary, #0064e0) !important;
    border-color: var(--primary, #0064e0) !important;
    transform: translateY(-1px) !important;
    box-shadow: 0 6px 18px rgba(0, 100, 224, 0.3) !important;
  }

  .menu-burger-icon {
    width: 18px !important;
    height: 13px !important;
    display: flex !important;
    flex-direction: column !important;
    justify-content: space-between !important;
  }

  .menu-burger-icon span {
    display: block !important;
    height: 2px !important;
    background: #ffffff !important;
    border-radius: 2px !important;
    transition: all 0.3s ease !important;
  }

  .menu-burger-icon .line-1 { width: 100% !important; }
  .menu-burger-icon .line-2 { width: 75% !important; margin-left: auto !important; }
  .menu-burger-icon .line-3 { width: 100% !important; }

  .menu-toggle-btn:hover .menu-burger-icon .line-2 {
    width: 100% !important;
  }

  /* ─── Responsive Switch (Gambar 1 Desktop vs Gambar 2 Mobile) ─── */
  @media (min-width: 901px) {
    .nav-desktop-menu {
      display: flex !important;
    }
    .nav-right-mobile,
    .menu-toggle-btn {
      display: none !important;
    }
  }

  @media (max-width: 900px) {
    .navbar {
      padding: 14px 5% !important;
    }
    .nav-desktop-menu {
      display: none !important;
    }
    .nav-right-mobile {
      display: flex !important;
      align-items: center !important;
    }
    .menu-toggle-btn {
      display: inline-flex !important;
    }
  }
</style>

<nav class="navbar">
  <a href="{{ route('home') }}" class="nav-brand">
    <div class="brand-logo">K</div>
    <span>Kafa Advertising</span>
  </a>

  <!-- Desktop Navigation Menu (Sesuai Gambar 1) -->
  <ul class="nav-desktop-menu">
    <li class="nav-desktop-item">
      <a href="{{ route('home') }}" class="nav-desktop-link {{ request()->routeIs('home') ? 'active' : '' }}">Beranda</a>
    </li>
    <li class="nav-desktop-item">
      <a href="{{ route('home') }}#keunggulan" class="nav-desktop-link">Tentang Kami</a>
    </li>
    <li class="nav-desktop-item">
      <a href="{{ route('katalog') }}" class="nav-desktop-link {{ request()->routeIs('katalog*') ? 'active' : '' }}">Layanan</a>
    </li>
    <li class="nav-desktop-item">
      <a href="{{ route('portofolio') }}" class="nav-desktop-link {{ request()->routeIs('portofolio') ? 'active' : '' }}">Portofolio</a>
    </li>
    <li class="nav-desktop-item">
      <a href="{{ route('home') }}#keunggulan" class="nav-desktop-link">Artikel</a>
    </li>
    <li class="nav-desktop-item">
      <a href="{{ route('home') }}#cabang" class="nav-desktop-link">Cabang</a>
    </li>
    <li class="nav-desktop-item">
      <a href="{{ \App\Helpers\FormatHelper::whatsappUrl('Halo Kafa Advertising, saya ingin konsultasi produk') }}" target="_blank" class="nav-desktop-link">Kontak</a>
    </li>
    <li class="nav-desktop-item">
      <a href="{{ route('login.customer') }}" class="nav-desktop-portal">
        <i class="bi bi-person-circle"></i> Portal
      </a>
    </li>
  </ul>

  <!-- Mobile Menu Button (Sesuai Gambar 2) -->
  <div class="nav-right-mobile">
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

<!-- ─── Mobile Side Drawer Backdrop ─── -->
<div class="side-drawer-backdrop" id="sideDrawerBackdrop" onclick="closeSideNav()"></div>

<!-- ─── Mobile Side Drawer Nav ─── -->
<aside class="side-drawer-nav" id="sideDrawerNav" aria-label="Menu Navigasi Samping">
  <div class="drawer-header">
    <div class="drawer-brand">
      <div class="drawer-brand-logo">K</div>
      <div>
        <div class="drawer-brand-title">Kafa Advertising</div>
        <div class="drawer-brand-sub">Advertising & Reklame</div>
      </div>
    </div>
    <button type="button" class="drawer-close-btn" onclick="closeSideNav()" aria-label="Tutup Menu">
      <i class="bi bi-x-lg"></i>
    </button>
  </div>

  <div class="drawer-body">
    <div class="drawer-nav-label">Navigasi Menu</div>
    <ul class="drawer-menu-list">
      <li>
        <a href="{{ route('home') }}" class="drawer-link" onclick="closeSideNav()">
          <span><i class="bi bi-house-fill" style="margin-right:8px; color:var(--primary);"></i> Beranda</span>
          <i class="bi bi-chevron-right" style="font-size:12px; opacity:0.5;"></i>
        </a>
      </li>
      <li>
        <a href="{{ route('home') }}#keunggulan" class="drawer-link" onclick="closeSideNav()">
          <span><i class="bi bi-info-circle-fill" style="margin-right:8px; color:#38bdf8;"></i> Tentang Kami</span>
          <i class="bi bi-chevron-right" style="font-size:12px; opacity:0.5;"></i>
        </a>
      </li>
      <li>
        <a href="{{ route('katalog') }}" class="drawer-link" onclick="closeSideNav()">
          <span><i class="bi bi-grid-fill" style="margin-right:8px; color:#a855f7;"></i> Layanan & Katalog</span>
          <i class="bi bi-chevron-right" style="font-size:12px; opacity:0.5;"></i>
        </a>
      </li>
      <li>
        <a href="{{ route('portofolio') }}" class="drawer-link" onclick="closeSideNav()">
          <span><i class="bi bi-images" style="margin-right:8px; color:#f59e0b;"></i> Portofolio Proyek</span>
          <i class="bi bi-chevron-right" style="font-size:12px; opacity:0.5;"></i>
        </a>
      </li>
      <li>
        <a href="{{ route('home') }}#keunggulan" class="drawer-link" onclick="closeSideNav()">
          <span><i class="bi bi-journal-text" style="margin-right:8px; color:#ec4899;"></i> Artikel & Panduan</span>
          <i class="bi bi-chevron-right" style="font-size:12px; opacity:0.5;"></i>
        </a>
      </li>
      <li>
        <a href="{{ route('home') }}#cabang" class="drawer-link" onclick="closeSideNav()">
          <span><i class="bi bi-geo-alt-fill" style="margin-right:8px; color:#10b981;"></i> Lokasi Cabang</span>
          <i class="bi bi-chevron-right" style="font-size:12px; opacity:0.5;"></i>
        </a>
      </li>
      <li>
        <a href="{{ \App\Helpers\FormatHelper::whatsappUrl('Halo Kafa Advertising, saya ingin tanya info pemesanan') }}" target="_blank" class="drawer-link">
          <span><i class="bi bi-whatsapp" style="margin-right:8px; color:#25d366;"></i> Kontak WhatsApp</span>
          <i class="bi bi-chevron-right" style="font-size:12px; opacity:0.5;"></i>
        </a>
      </li>
      <li>
        <a href="{{ route('login.customer') }}" class="drawer-link" style="color: #60a5fa;" onclick="closeSideNav()">
          <span><i class="bi bi-person-circle" style="margin-right:8px;"></i> Portal Pelanggan</span>
          <i class="bi bi-box-arrow-in-right" style="font-size:12px; opacity:0.7;"></i>
        </a>
      </li>
      <li>
        <a href="{{ route('login.admin') }}" class="drawer-link" style="color: var(--text-stone);" onclick="closeSideNav()">
          <span><i class="bi bi-shield-lock" style="margin-right:8px;"></i> Login Staf / Admin</span>
          <i class="bi bi-box-arrow-in-right" style="font-size:12px; opacity:0.7;"></i>
        </a>
      </li>
    </ul>
  </div>

  <div class="drawer-footer">
    <div class="drawer-footer-info">
      <div><strong>Kafa Advertising</strong></div>
      <div>Spesialis Neon Box, Signage LED & Huruf Timbul Custom.</div>
    </div>
    <a href="{{ \App\Helpers\FormatHelper::whatsappUrl('Halo Kafa Advertising, saya ingin konsultasi pesanan') }}" target="_blank" class="drawer-wa-cta">
      <i class="bi bi-whatsapp" style="font-size:16px;"></i>
      <span>Chat WhatsApp Sekarang</span>
    </a>
  </div>
</aside>

<script>
  function openSideNav() {
    const backdrop = document.getElementById('sideDrawerBackdrop');
    const drawer = document.getElementById('sideDrawerNav');
    if (backdrop && drawer) {
      backdrop.classList.add('active');
      drawer.classList.add('active');
      document.body.style.overflow = 'hidden';
    }
  }

  function closeSideNav() {
    const backdrop = document.getElementById('sideDrawerBackdrop');
    const drawer = document.getElementById('sideDrawerNav');
    if (backdrop && drawer) {
      backdrop.classList.remove('active');
      drawer.classList.remove('active');
      document.body.style.overflow = '';
    }
  }

  function toggleSideNav() {
    const drawer = document.getElementById('sideDrawerNav');
    if (drawer && drawer.classList.contains('active')) {
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
