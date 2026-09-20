@extends('layouts.guest')

@section('title', 'Kafa Advertising - Jasa Neon Box & Signage Custom Terbaik')

@section('styles')
<style>
  /* ─── Promo Banner ─── */
  .promo-banner {
    background-color: var(--ink-deep);
    color: #ffffff;
    font-size: 13px;
    font-weight: 700;
    padding: 10px 24px;
    text-align: center;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 12px;
  }
  .promo-banner-badge {
    background-color: var(--warning);
    color: var(--ink-deep);
    font-size: 11px;
    font-weight: 800;
    padding: 3px 10px;
    border-radius: var(--radius-full);
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }
  .promo-banner-link {
    color: #ffffff;
    text-decoration: underline;
    font-weight: 700;
    margin-left: 6px;
  }

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

  /* Center category pills */
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
  .nav-pill-btn.active {
    background: var(--ink-deep);
    color: #ffffff;
    border-color: var(--ink-deep);
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
    transition: all 0.2s ease;
  }

  .menu-toggle-btn:hover {
    background: #444950;
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
    transition: all 0.3s;
  }
  .menu-burger-icon .line-1 { width: 100%; }
  .menu-burger-icon .line-2 { width: 70%; margin-left: auto; }
  .menu-burger-icon .line-3 { width: 100%; }

  /* ─── Side Drawer ─── */
  .side-drawer-backdrop {
    position: fixed;
    inset: 0;
    background: rgba(10, 19, 23, 0.6);
    backdrop-filter: blur(6px);
    z-index: 99998;
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.35s ease, visibility 0.35s ease;
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
    width: 400px;
    max-width: 90vw;
    background: #0a1317;
    color: #fff;
    z-index: 99999;
    box-shadow: -10px 0 35px rgba(0,0,0,0.5);
    transform: translateX(100%);
    transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    display: flex;
    flex-direction: column;
    overflow-y: auto;
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
    width: 34px;
    height: 34px;
    background: var(--primary);
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    font-weight: 800;
  }

  .drawer-brand-title {
    font-size: 16px;
    font-weight: 700;
    color: #fff;
  }

  .drawer-close-btn {
    width: 36px;
    height: 36px;
    border-radius: var(--radius-full);
    background: rgba(255,255,255,0.08);
    border: 1px solid rgba(255,255,255,0.12);
    color: #fff;
    font-size: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s;
  }

  .drawer-close-btn:hover {
    background: var(--danger);
    border-color: var(--danger);
  }

  .drawer-body {
    padding: 28px 24px;
    flex: 1;
    display: flex;
    flex-direction: column;
  }

  .drawer-nav-label {
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    color: var(--text-stone);
    margin-bottom: 16px;
    padding-left: 12px;
  }

  .drawer-menu-list {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    flex-direction: column;
    gap: 6px;
  }

  .drawer-link {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 12px 18px;
    border-radius: var(--radius-full);
    color: #f1f5f9;
    text-decoration: none;
    font-size: 15px;
    font-weight: 600;
    transition: all 0.2s ease;
  }

  .drawer-link:hover {
    background: rgba(255, 255, 255, 0.08);
    color: #ffffff;
    transform: translateX(4px);
  }

  .drawer-footer {
    padding: 24px 28px;
    border-top: 1px solid rgba(255,255,255,0.08);
    background: rgba(0,0,0,0.3);
  }

  .drawer-footer-info {
    font-size: 12px;
    color: var(--text-stone);
    line-height: 1.6;
    margin-bottom: 16px;
  }

  .drawer-wa-cta {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 12px 20px;
    background: var(--success);
    color: #fff;
    border-radius: var(--radius-full);
    font-size: 13.5px;
    font-weight: 700;
    text-decoration: none;
    transition: all 0.2s;
  }
  .drawer-wa-cta:hover {
    opacity: 0.9;
  }

  /* ─── Hero Section (Meta Hero Display) ─── */
  .hero-wrapper {
    padding: 24px 8% 0;
    background: var(--bg-main);
  }

  .hero-band {
    position: relative;
    border-radius: var(--radius-xxxl);
    overflow: hidden;
    min-height: 75vh;
    display: flex;
    align-items: center;
    background: #0a1317;
  }

  .hero-bg {
    position: absolute;
    inset: 0;
    background-image: url('/images/neon_box_hero.jpg');
    background-size: cover;
    background-position: center;
    filter: brightness(0.4);
  }

  .hero-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(180deg, rgba(10,19,23,0.3) 0%, rgba(10,19,23,0.85) 100%);
  }

  .hero-content {
    position: relative;
    z-index: 2;
    padding: 60px 48px;
    max-width: 760px;
  }

  .hero-badge-pill {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 6px 16px;
    background: rgba(255, 255, 255, 0.15);
    border: 1px solid rgba(255, 255, 255, 0.25);
    color: #ffffff;
    border-radius: var(--radius-full);
    font-size: 12px;
    font-weight: 700;
    margin-bottom: 20px;
    backdrop-filter: blur(8px);
  }

  .hero-title {
    font-size: 52px;
    font-weight: 500;
    line-height: 1.15;
    color: #ffffff;
    margin-bottom: 18px;
    letter-spacing: -0.5px;
  }

  .hero-subtitle {
    font-size: 18px;
    font-weight: 300;
    color: rgba(255, 255, 255, 0.85);
    line-height: 1.55;
    margin-bottom: 32px;
  }

  .hero-btns {
    display: flex;
    gap: 14px;
    flex-wrap: wrap;
    align-items: center;
  }

  .hero-stats-strip {
    margin-top: 24px;
    background: var(--surface-soft);
    border-radius: var(--radius-xxl);
    border: 1px solid var(--hairline-soft);
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    padding: 24px 32px;
    gap: 20px;
  }

  .stat-tile {
    text-align: center;
  }
  .stat-tile .num {
    font-size: 26px;
    font-weight: 700;
    color: var(--ink-deep);
    letter-spacing: -0.5px;
  }
  .stat-tile .lbl {
    font-size: 12px;
    color: var(--text-muted);
    font-weight: 600;
    margin-top: 2px;
  }

  /* ─── Section Shared Styles ─── */
  .section {
    padding: 80px 8%;
  }

  .section-badge {
    display: inline-block;
    padding: 4px 12px;
    background: var(--surface-soft);
    color: var(--text-muted);
    border: 1px solid var(--hairline-soft);
    border-radius: var(--radius-full);
    font-size: 12px;
    font-weight: 700;
    margin-bottom: 12px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }

  .section-title {
    font-size: 36px;
    font-weight: 500;
    color: var(--ink-deep);
    margin-bottom: 10px;
    letter-spacing: -0.5px;
  }

  .section-subtitle {
    font-size: 16px;
    color: var(--text-muted);
    margin-bottom: 44px;
    max-width: 600px;
    line-height: 1.5;
  }

  /* ─── Category Cards (32px Rounding) ─── */
  .categories-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 24px;
  }

  .category-card {
    background: var(--bg-card);
    border: 1px solid var(--hairline-soft);
    border-radius: var(--radius-xxxl);
    padding: 24px;
    text-decoration: none;
    display: flex;
    flex-direction: column;
    transition: all 0.25s ease;
  }

  .category-card:hover {
    border-color: var(--hairline);
    box-shadow: var(--shadow-md);
    transform: translateY(-4px);
  }

  .category-img {
    width: 100%;
    height: 190px;
    object-fit: cover;
    border-radius: var(--radius-xxl);
    margin-bottom: 18px;
    background: var(--surface-soft);
  }

  .category-title {
    font-size: 18px;
    font-weight: 700;
    color: var(--ink-deep);
    margin-bottom: 6px;
  }

  .category-count {
    font-size: 12px;
    font-weight: 700;
    color: var(--primary);
    margin-bottom: 8px;
  }

  .category-desc {
    font-size: 13.5px;
    color: var(--text-muted);
    line-height: 1.5;
    flex: 1;
  }

  .category-cta-row {
    margin-top: 16px;
    padding-top: 14px;
    border-top: 1px solid var(--hairline-soft);
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: 13px;
    font-weight: 700;
    color: var(--ink-deep);
  }

  /* ─── Reassurance Tiles (Why Buy - 4-up) ─── */
  .why-buy-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
    gap: 20px;
  }

  .why-buy-tile {
    background: var(--bg-card);
    border: 1px solid var(--hairline-soft);
    border-radius: var(--radius-xl);
    padding: 28px 24px;
    transition: all 0.2s ease;
  }

  .why-buy-tile:hover {
    border-color: var(--hairline);
    box-shadow: var(--shadow-sm);
  }

  .why-buy-icon-wrap {
    width: 44px;
    height: 44px;
    border-radius: var(--radius-full);
    background: var(--surface-soft);
    color: var(--primary);
    font-size: 15px;
    font-weight: 800;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 16px;
  }

  .why-buy-title {
    font-size: 16px;
    font-weight: 700;
    color: var(--ink-deep);
    margin-bottom: 8px;
  }

  .why-buy-desc {
    font-size: 13.5px;
    color: var(--text-muted);
    line-height: 1.5;
  }

  /* ─── Promo Strip Card (32px Rounding) ─── */
  .promo-strip-section {
    padding: 0 8% 80px;
  }

  .card-promo-strip {
    background: var(--ink-deep);
    color: #ffffff;
    border-radius: var(--radius-xxxl);
    padding: 60px 48px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 32px;
    flex-wrap: wrap;
  }

  .promo-strip-content h2 {
    font-size: 36px;
    font-weight: 500;
    margin-bottom: 12px;
    letter-spacing: -0.5px;
  }

  .promo-strip-content p {
    font-size: 16px;
    font-weight: 300;
    color: rgba(255, 255, 255, 0.8);
    max-width: 540px;
    line-height: 1.5;
  }

  /* ─── Branches / Showrooms ─── */
  .branches-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 24px;
  }

  .branch-card {
    background: var(--bg-card);
    border: 1px solid var(--hairline-soft);
    border-radius: var(--radius-xxl);
    padding: 24px;
    display: flex;
    flex-direction: column;
    gap: 12px;
  }

  .branch-card .branch-name {
    font-size: 17px;
    font-weight: 700;
    color: var(--ink-deep);
  }

  .branch-card .branch-addr {
    font-size: 13.5px;
    color: var(--text-muted);
    line-height: 1.5;
  }

  /* ─── Footer Region ─── */
  .footer-region {
    background: #ffffff;
    border-top: 1px solid var(--hairline-soft);
    padding: 64px 8% 36px;
  }

  .footer-columns {
    display: grid;
    grid-template-columns: 2fr repeat(3, 1fr);
    gap: 40px;
    margin-bottom: 48px;
  }

  .footer-col h4 {
    font-size: 14px;
    font-weight: 700;
    color: var(--ink-deep);
    margin-bottom: 16px;
    letter-spacing: -0.14px;
  }

  .footer-col ul {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    flex-direction: column;
    gap: 10px;
  }

  .footer-col a {
    color: var(--text-muted);
    text-decoration: none;
    font-size: 13.5px;
    transition: color 0.2s;
  }
  .footer-col a:hover {
    color: var(--primary);
  }

  .footer-bottom {
    padding-top: 24px;
    border-top: 1px solid var(--hairline-soft);
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: 12px;
    color: var(--text-stone);
    flex-wrap: wrap;
    gap: 16px;
  }

  /* ─── WhatsApp Float ─── */
  .wa-float {
    position: fixed;
    bottom: 24px;
    right: 20px;
    z-index: 999;
    padding: 10px 18px;
    background: var(--success);
    color: #ffffff;
    border-radius: var(--radius-full);
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 13px;
    font-weight: 700;
    text-decoration: none;
    box-shadow: var(--shadow-md);
    transition: all 0.2s ease;
  }
  .wa-float:hover {
    transform: translateY(-2px);
    opacity: 0.95;
  }

  /* ─── Mobile Responsiveness Enhancements ─── */
  @media (max-width: 768px) {
    .navbar {
      padding: 10px 14px;
    }
    .nav-brand {
      font-size: 16px;
      gap: 8px;
    }
    .nav-brand .brand-logo {
      width: 30px;
      height: 30px;
      font-size: 15px;
      border-radius: 8px;
    }
    .menu-toggle-btn {
      padding: 7px 14px;
      font-size: 12px;
      gap: 6px;
    }
    .hero-wrapper {
      padding: 8px 10px 0;
    }
    .hero-band {
      min-height: auto;
      border-radius: var(--radius-xl);
    }
    .hero-content {
      padding: 28px 14px;
      max-width: 100%;
    }
    .hero-badge-pill {
      font-size: 11px;
      padding: 4px 12px;
      margin-bottom: 12px;
    }
    .hero-title {
      font-size: 24px;
      line-height: 1.25;
      margin-bottom: 10px;
      word-break: break-word;
    }
    .hero-subtitle {
      font-size: 13.5px;
      margin-bottom: 18px;
      line-height: 1.45;
    }
    .hero-btns {
      flex-direction: column;
      width: 100%;
      gap: 8px;
    }
    .hero-btns .btn-pill {
      width: 100%;
      text-align: center;
      justify-content: center;
      padding: 11px 16px;
      font-size: 13.5px;
    }
    .hero-stats-strip {
      grid-template-columns: repeat(2, 1fr);
      padding: 12px 8px;
      gap: 8px;
      margin-top: 10px;
      border-radius: var(--radius-lg);
    }
    .stat-tile {
      padding: 6px 4px;
    }
    .stat-tile .num {
      font-size: 18px;
      margin-bottom: 2px;
    }
    .stat-tile .lbl {
      font-size: 10.5px;
      line-height: 1.2;
    }
    .section {
      padding: 32px 14px;
    }
    .section-badge {
      font-size: 10.5px;
      padding: 3px 10px;
      margin-bottom: 8px;
    }
    .section-title {
      font-size: 20px;
      margin-bottom: 6px;
    }
    .section-subtitle {
      font-size: 13px;
      margin-bottom: 18px;
      line-height: 1.4;
    }
    .categories-grid {
      grid-template-columns: 1fr;
      gap: 12px;
    }
    .category-card {
      padding: 14px;
      border-radius: var(--radius-xl);
    }
    .category-img {
      height: 140px;
      border-radius: var(--radius-lg);
      margin-bottom: 10px;
    }
    .category-title {
      font-size: 17px;
    }
    .category-count {
      font-size: 11px;
      margin-bottom: 6px;
    }
    .category-desc {
      font-size: 12.5px;
      margin-bottom: 12px;
      line-height: 1.4;
    }
    .category-cta-row {
      font-size: 12.5px;
      padding-top: 8px;
    }
    .why-buy-grid {
      grid-template-columns: 1fr;
      gap: 10px;
    }
    .why-buy-tile {
      padding: 14px 12px;
      border-radius: var(--radius-md);
    }
    .why-buy-title {
      font-size: 15px;
    }
    .why-buy-desc {
      font-size: 12.5px;
      line-height: 1.4;
    }
    .promo-strip-section {
      padding: 0 10px 32px;
      margin-top: 24px !important;
    }
    .card-promo-strip {
      padding: 22px 14px;
      gap: 14px;
      border-radius: var(--radius-xl);
      flex-direction: column;
      text-align: center;
    }
    .promo-strip-content h2 {
      font-size: 19px;
      margin-bottom: 6px;
    }
    .promo-strip-content p {
      font-size: 12.5px;
      line-height: 1.4;
    }
    .card-promo-strip .btn-meta-buy {
      width: 100%;
      text-align: center;
      justify-content: center;
      padding: 11px 18px;
      font-size: 13.5px;
    }
    .branches-grid {
      grid-template-columns: 1fr;
      gap: 12px;
    }
    .branch-card {
      padding: 14px 12px;
      border-radius: var(--radius-lg);
    }
    .branch-name {
      font-size: 16px;
    }
    .branch-addr {
      font-size: 12.5px;
    }
    .footer-region {
      padding: 30px 14px 20px;
    }
    .footer-columns {
      grid-template-columns: 1fr;
      gap: 20px;
      margin-bottom: 24px;
    }
    .footer-bottom {
      flex-direction: column;
      text-align: center;
      gap: 6px;
      font-size: 11.5px;
    }
  }
</style>
@endsection

@section('content')

<!-- Floating WhatsApp CTA Pill -->
<a href="{{ \App\Helpers\FormatHelper::whatsappUrl('Halo Kafa Advertising, saya ingin memesan neon box custom') }}" target="_blank" class="wa-float" title="Konsultasi WhatsApp">
  <span>WhatsApp</span>
</a>

<!-- ─── Navbar ─── -->
<nav class="navbar">
  <a href="{{ route('home') }}" class="nav-brand">
    <div class="brand-logo">K</div>
    <span>Kafa Advertising</span>
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
  </div>
</nav>

<!-- ─── Side Drawer Backdrop ─── -->
<div class="side-drawer-backdrop" id="sideDrawerBackdrop" onclick="closeSideNav()"></div>

<!-- ─── Side Drawer Nav ─── -->
<aside class="side-drawer-nav" id="sideDrawerNav" aria-label="Menu Navigasi Samping">
  <div class="drawer-header">
    <div class="drawer-brand">
      <div class="drawer-brand-logo">K</div>
      <div>
        <div class="drawer-brand-title">Kafa Advertising</div>
      </div>
    </div>
    <button type="button" class="drawer-close-btn" onclick="closeSideNav()" aria-label="Tutup Menu">✕</button>
  </div>

  <div class="drawer-body">
    <div class="drawer-nav-label">Navigasi Utama</div>
    <ul class="drawer-menu-list">
      <li><a href="{{ route('home') }}" class="drawer-link" onclick="closeSideNav()">01. Beranda</a></li>
      <li><a href="{{ route('katalog') }}" class="drawer-link" onclick="closeSideNav()">02. Katalog & Harga</a></li>
      <li><a href="{{ route('portofolio') }}" class="drawer-link" onclick="closeSideNav()">03. Portofolio Proyek</a></li>
      <li><a href="#keunggulan" class="drawer-link" onclick="closeSideNav()">04. Keunggulan</a></li>
      <li><a href="#cabang" class="drawer-link" onclick="closeSideNav()">05. Cabang Showroom</a></li>
      <li><a href="{{ route('login.customer') }}" class="drawer-link" style="color: #60a5fa;" onclick="closeSideNav()">06. Portal Pelanggan</a></li>
      <li><a href="{{ route('login.admin') }}" class="drawer-link" style="color: var(--text-stone);" onclick="closeSideNav()">07. Login Staf / Admin</a></li>
    </ul>
  </div>

  <div class="drawer-footer">
    <div class="drawer-footer-info">
      <div><strong>Workshop & Showroom</strong></div>
      <div>Melayani Demak, Semarang, Surabaya & seluruh Indonesia.</div>
    </div>
    <a href="{{ \App\Helpers\FormatHelper::whatsappUrl('Halo Kafa Advertising, saya ingin konsultasi pesanan') }}" target="_blank" class="drawer-wa-cta">
      Chat WhatsApp Sekarang
    </a>
  </div>
</aside>

<!-- ─── Hero Section ─── -->
<div class="hero-wrapper" id="home">
  <section class="hero-band">
    <div class="hero-bg"></div>
    <div class="hero-overlay"></div>

    <div class="hero-content">
      @php $heroData = $homeContents->get('hero'); $hero = $heroData && count($heroData) > 0 ? $heroData[0] : null; @endphp
      <div class="hero-badge-pill">
        {{ $hero->subtitle ?? 'Spesialis Neon Box & Signage Custom' }}
      </div>
      <h1 class="hero-title">
        {{ $hero->title ?? 'Solusi Neon Box & Signage Custom Berkualitas' }}
      </h1>
      <p class="hero-subtitle">
        {{ $hero->content ?? 'Pembuatan neon box akrilik, LED modern, huruf timbul & pylon sign bergaransi resmi dan bermutu tinggi.' }}
      </p>
      <div class="hero-btns">
        <a href="{{ route('katalog') }}" class="btn-pill btn-meta-primary">
          Katalog Produk
        </a>
        <a href="{{ \App\Helpers\FormatHelper::whatsappUrl('Halo, saya ingin konsultasi kebutuhan neon box') }}" target="_blank" class="btn-pill btn-meta-ghost" style="border-color: rgba(255,255,255,0.7); color:#fff;">
          Konsultasi WA
        </a>
      </div>
    </div>
  </section>

  <!-- Reassurance Metric Strip (Ringkas & Responsif) -->
  <div class="hero-stats-strip">
    <div class="stat-tile">
      <div class="num">500+</div>
      <div class="lbl">Proyek</div>
    </div>
    <div class="stat-tile">
      <div class="num">8+ Th</div>
      <div class="lbl">Pengalaman</div>
    </div>
    <div class="stat-tile">
      <div class="num">12 Bln</div>
      <div class="lbl">Garansi</div>
    </div>
    <div class="stat-tile">
      <div class="num">Nasional</div>
      <div class="lbl">Pengiriman</div>
    </div>
  </div>
</div>

<!-- ─── Categories Section ─── -->
<section class="section" id="kategori">
  <div style="display:flex; justify-content:space-between; align-items:flex-end; margin-bottom:24px; flex-wrap:wrap; gap:12px;">
    <div>
      <div class="section-badge">Katalog Kategori</div>
      <h2 class="section-title">Pilihan Layanan Signage</h2>
      <p class="section-subtitle" style="margin-bottom:0;">Pilih kategori untuk melihat spesifikasi dan varian produk.</p>
    </div>
    <a href="{{ route('katalog') }}" class="btn-pill btn-meta-ghost" style="font-size: 13px; padding: 8px 18px;">
      Semua ({{ $categories->count() }})
    </a>
  </div>

  <div class="categories-grid">
    @forelse($categories as $cat)
      <a href="{{ route('katalog.kategori', $cat->slug) }}" class="category-card">
        @if($cat->foto_url)
          <img src="{{ $cat->foto_url }}" alt="{{ $cat->nama }}" class="category-img">
        @else
          <div class="category-img" style="display:flex; align-items:center; justify-content:center; font-size:32px; color:var(--text-muted);">
            K
          </div>
        @endif
        <div class="category-title">{{ $cat->nama }}</div>
        <div class="category-count">{{ $cat->products_count }} Varian Produk</div>
        <p class="category-desc">{{ $cat->deskripsi ?: 'Signage & advertising bermutu tinggi untuk identitas visual usaha Anda.' }}</p>
        <div class="category-cta-row">
          <span>Buka Katalog</span>
          <span>→</span>
        </div>
      </a>
    @empty
      <div style="grid-column:1/-1; text-align:center; padding:50px 0; color:var(--text-muted);">
        Kategori produk sedang diperbarui.
      </div>
    @endforelse
  </div>
</section>

<!-- ─── Why Buy / Feature Icons ─── -->
<section class="section" id="keunggulan" style="background: var(--surface-soft);">
  <div class="section-badge">Keunggulan</div>
  <h2 class="section-title">Mengapa Bermitra Dengan Kami?</h2>
  <p class="section-subtitle">Komitmen kami untuk memberikan mutu terbaik pada setiap pengerjaan reklame.</p>

  <div class="why-buy-grid">
    <div class="why-buy-tile">
      <div class="why-buy-icon-wrap">01</div>
      <div class="why-buy-title">Bahan Premium</div>
      <p class="why-buy-desc">Material akrilik dan modul LED pilihan tahan terhadap cuaca outdoor.</p>
    </div>
    <div class="why-buy-tile">
      <div class="why-buy-icon-wrap">02</div>
      <div class="why-buy-title">Pengerjaan Cepat</div>
      <p class="why-buy-desc">Proses presisi, estimasi pengerjaan rapi 3–7 hari kerja.</p>
    </div>
    <div class="why-buy-tile">
      <div class="why-buy-icon-wrap">03</div>
      <div class="why-buy-title">Garansi Resmi</div>
      <p class="why-buy-desc">Jaminan mutu material & instalasi hingga 12 bulan.</p>
    </div>
    <div class="why-buy-tile">
      <div class="why-buy-icon-wrap">04</div>
      <div class="why-buy-title">Desain Custom</div>
      <p class="why-buy-desc">Gratis konsultasi & rancang konsep visual sesuai kebutuhan brand Anda.</p>
    </div>
  </div>
</section>

<!-- ─── Promo Strip CTA Card ─── -->
<div class="promo-strip-section" style="margin-top: 60px;">
  <div class="card-promo-strip">
    <div class="promo-strip-content">
      <h2>Pesan Neon Box Impian Anda</h2>
      <p>Konsultasikan ukuran, bahan & anggaran bersama tim kami. Dapatkan penawaran terbaik dan rancangan visual gratis.</p>
    </div>
    <div>
      <a href="{{ \App\Helpers\FormatHelper::whatsappUrl('Halo Kafa Advertising, saya ingin konsultasi pesanan custom') }}" target="_blank" class="btn-pill btn-meta-buy" style="font-size: 14.5px; padding: 14px 30px;">
        Konsultasi Sekarang
      </a>
    </div>
  </div>
</div>

<!-- ─── Branches & Showrooms ─── -->
<section class="section" id="cabang" style="padding-top: 10px;">
  <div class="section-badge">Lokasi Showroom</div>
  <h2 class="section-title">Cabang & Workshop Kami</h2>
  <p class="section-subtitle">Kunjungi showroom untuk melihat langsung sampel bahan dan pencahayaan LED.</p>

  <div class="branches-grid">
    @forelse($branches as $b)
      <div class="branch-card">
        <div class="branch-name">{{ $b->nama_cabang }}</div>
        <p class="branch-addr">{{ $b->alamat ?: 'Showroom & Workshop Kafa Advertising' }}</p>
        
        @if($b->clean_iframe)
          <div style="border-radius: var(--radius-xl); overflow:hidden; margin-top:8px;">
            {!! $b->clean_iframe !!}
          </div>
        @endif

        @if($b->map_url && !$b->clean_iframe)
          <a href="{{ $b->map_url }}" target="_blank" class="btn-pill btn-meta-ghost" style="margin-top: 8px; font-size: 12px; padding: 6px 16px;">
            Buka di Google Maps
          </a>
        @endif
      </div>
    @empty
      <div style="grid-column:1/-1; text-align:center; padding:40px 0; color:var(--text-muted);">
        Informasi lokasi showroom segera hadir.
      </div>
    @endforelse
  </div>
</section>

<!-- ─── Footer Region ─── -->
<footer class="footer-region">
  <div class="footer-columns">
    <div>
      <div class="nav-brand" style="margin-bottom: 12px;">
        <div class="brand-logo">K</div>
        <span>Kafa Advertising</span>
      </div>
      <p style="font-size: 13.5px; color: var(--text-muted); line-height: 1.5; max-width: 320px;">
        Spesialis neon box, huruf timbul, pylon sign & konstruksi reklame bergaransi kualitas premium.
      </p>
    </div>

    <div class="footer-col">
      <h4>Katalog</h4>
      <ul>
        <li><a href="{{ route('katalog') }}">Semua Kategori</a></li>
        <li><a href="{{ route('portofolio') }}">Portofolio Proyek</a></li>
      </ul>
    </div>

    <div class="footer-col">
      <h4>Akses Portal</h4>
      <ul>
        <li><a href="{{ route('login.customer') }}">Portal Pelanggan</a></li>
        <li><a href="{{ route('login.admin') }}">Admin & Staf</a></li>
      </ul>
    </div>

    <div class="footer-col">
      <h4>Media Sosial</h4>
      <ul>
        <li><a href="https://www.instagram.com/kafaxgraf" target="_blank">Instagram</a></li>
        <li><a href="https://www.facebook.com" target="_blank">Facebook</a></li>
      </ul>
    </div>
  </div>

  <div class="footer-bottom">
    <div>© {{ date('Y') }} <strong>Kafa Advertising</strong>. Hak Cipta Dilindungi.</div>
    <div>Sistem Manajemen Reklame & Signage Modern</div>
  </div>
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

