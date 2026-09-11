@extends('layouts.guest')

@section('title', 'Kaligraph Design - Jasa Neon Box & Signage Custom Terbaik')

@section('styles')
<style>
  /* ─── Navbar ─── */
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
<a href="{{ \App\Helpers\FormatHelper::whatsappUrl('Halo Kaligraph Design, saya ingin memesan neon box') }}" target="_blank" class="wa-float" title="Chat WhatsApp">
  💬
</a>

<!-- ─── Navbar ─── -->
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
        <a href="#home" class="drawer-link" onclick="closeSideNav()">
          <div class="drawer-link-left">
            <span class="drawer-link-num">01</span>
            <span>🏠 Beranda</span>
          </div>
          <span class="drawer-link-arrow">➔</span>
        </a>
      </li>
      <li class="drawer-menu-item">
        <a href="#kategori" class="drawer-link" onclick="closeSideNav()">
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
        <a href="#keunggulan" class="drawer-link" onclick="closeSideNav()">
          <div class="drawer-link-left">
            <span class="drawer-link-num">05</span>
            <span>⭐ Keunggulan Layanan</span>
          </div>
          <span class="drawer-link-arrow">➔</span>
        </a>
      </li>
      <li class="drawer-menu-item">
        <a href="#cabang" class="drawer-link" onclick="closeSideNav()">
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

<!-- ─── Hero Section ─── -->
<section class="hero-section" id="home">
  <div class="hero-bg"></div>
  <div class="hero-overlay"></div>

  <div style="flex:1; display:flex; flex-direction:column; justify-content:space-between; min-height:90vh;">
    <div class="hero-content" style="padding-top: 80px; padding-bottom: 60px; flex: 1; display: flex; flex-direction: column; justify-content: center;">
      @php $heroData = $homeContents->get('hero'); $hero = $heroData && count($heroData) > 0 ? $heroData[0] : null; @endphp
      <div class="hero-badge">
        ⚡ {{ $hero->subtitle ?? 'Spesialis Neon Box & Signage Custom' }}
      </div>
      <h1 class="hero-title">
        {{ $hero->title ?? 'Solusi' }} <span class="highlight">Neon Box & Reklame</span><br>
        Terbaik di Indonesia
      </h1>
      <p class="hero-subtitle">
        {{ $hero->content ?? 'Kaligraph Design menghadirkan neon box akrilik, flexy, LED, huruf timbul, pylon sign, dan jasa bengkel las konstruksi berkualitas premium bergaransi.' }}
      </p>
      <div class="hero-btns">
        <a href="{{ route('katalog') }}" class="btn-hero-primary">📂 Lihat Kategori & Katalog</a>
        <a href="{{ \App\Helpers\FormatHelper::whatsappUrl('Halo, saya mau konsultasi pesanan') }}" target="_blank" class="btn-hero-wa">💬 Konsultasi via WhatsApp</a>
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
        <div class="num">08:00-21:00</div>
        <div class="lbl">Layanan Pelanggan</div>
      </div>
    </div>
  </div>
</section>

<!-- ─── Categories Section ─── -->
<section class="section" id="kategori">
  <div style="display:flex; justify-content:space-between; align-items:flex-end; margin-bottom:30px; flex-wrap:wrap; gap:16px;">
    <div>
      <div class="section-badge">Kategori Produk</div>
      <h2 class="section-title" style="margin-bottom:8px;">Pilihan Kategori Layanan Kami</h2>
      <p class="section-subtitle" style="margin-bottom:0;">Pilih kategori untuk melihat katalog produk lengkap, spesifikasi, dan estimasi harga.</p>
    </div>
    <a href="{{ route('katalog') }}" class="btn btn-secondary" style="font-weight:700; border-radius:10px; padding:10px 20px;">
      Semua Kategori ({{ $categories->count() }}) ➔
    </a>
  </div>

  <div class="products-grid">
    @forelse($categories as $cat)
      <a href="{{ route('katalog.kategori', $cat->slug) }}" class="product-card" style="text-decoration:none; display:flex; flex-direction:column;">
        @if($cat->foto_url)
          <img src="{{ $cat->foto_url }}" alt="{{ $cat->nama }}" style="width:100%; height:180px; object-fit:cover; border-radius:14px; margin-bottom:16px; border:1px solid var(--border-color);">
        @else
          <div class="product-icon-wrap" style="margin-bottom:16px;">
            {{ $cat->emoji ?: '📂' }}
          </div>
        @endif
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px;">
          <div class="product-name" style="margin-bottom:0;">{{ $cat->nama }}</div>
        </div>
        <div style="display:inline-block; font-size:12px; font-weight:700; color:var(--primary); margin-bottom:10px;">
          📦 {{ $cat->products_count }} Pilihan Produk
        </div>
        <p class="product-desc" style="flex:1;">{{ $cat->deskripsi ?: 'Koleksi signage & advertising berkualitas untuk kategori ini.' }}</p>
        <div style="margin-top:16px; padding-top:12px; border-top:1px solid var(--border-color); display:flex; align-items:center; justify-content:space-between; color:var(--primary); font-weight:700; font-size:13px;">
          <span>Buka Katalog Kategori</span>
          <span>➔</span>
        </div>
      </a>
    @empty
      <div style="grid-column:1/-1; text-align:center; padding:60px 0; color:var(--text-muted);">
        <div style="font-size:48px; margin-bottom:16px;">📂</div>
        <p>Kategori produk sedang diperbarui.</p>
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
  <a href="{{ \App\Helpers\FormatHelper::whatsappUrl('Halo Kaligraph Design, saya ingin konsultasi neon box') }}" target="_blank" class="btn-hero-wa" style="margin: 0 auto; font-size:18px; padding:18px 40px;">
    💬 Chat WhatsApp Sekarang
  </a>
</section>

<!-- ─── Footer ─── -->
<footer class="footer">
  <div class="footer-brand">💡 Kaligraph Design</div>
  <p>© {{ date('Y') }} <strong>Kaligraph Design</strong>. Spesialis Neon Box & Signage Custom Indonesia.</p>
  <div style="display: flex; gap: 16px; font-size: 13px;">
    <a href="https://www.instagram.com/kafaxgraf?utm_source=ig_web_button_share_sheet&stkn=ZDNlZDc0MzIxNw==" style="color:#60a5fa; text-decoration:none;">Instagram</a>
    <a href="https://www.facebook.com/people/Kafa-X-Graf-Adv/61555941644272/" style="color:#94a3b8; text-decoration:none;">Facebook</a>
    <a href="" style="color:#94a3b8; text-decoration:none;">Email</a>
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

// Close on Escape key
document.addEventListener('keydown', function(e) {
  if (e.key === 'Escape') {
    closeSideNav();
  }
});
</script>
@endsection
