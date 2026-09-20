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

  /* ─── Footer Region (DESIGN2.md Spec) ─── */
  .footer-region {
    background: var(--bg-main, #ffffff);
    border-top: 1px solid var(--hairline-soft);
    padding: 64px 8% 36px;
    font-size: 14px;
    line-height: 1.43;
    letter-spacing: -0.14px;
  }

  .footer-top-brand {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 20px;
    padding-bottom: 32px;
    margin-bottom: 40px;
    border-bottom: 1px solid var(--hairline-soft);
  }

  .footer-brand-left {
    display: flex;
    align-items: center;
    gap: 12px;
    text-decoration: none;
  }

  .footer-brand-logo {
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

  .footer-brand-info h3 {
    font-size: 18px;
    font-weight: 800;
    color: var(--ink-deep);
    margin: 0;
    letter-spacing: -0.4px;
  }

  .footer-brand-info p {
    font-size: 13px;
    color: var(--text-muted);
    margin: 2px 0 0;
  }

  .footer-brand-right {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    gap: 12px;
  }

  .footer-brand-badges {
    display: flex;
    align-items: center;
    gap: 8px;
    flex-wrap: wrap;
  }

  .footer-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 14px;
    background: var(--surface-soft);
    border: 1px solid var(--hairline-soft);
    border-radius: var(--radius-full);
    font-size: 12px;
    font-weight: 700;
    color: var(--text-body);
  }

  /* ─── Social Media Icon Buttons ─── */
  .footer-social-strip {
    display: flex;
    align-items: center;
    gap: 10px;
  }

  .social-icon-btn {
    width: 38px;
    height: 38px;
    border-radius: var(--radius-full);
    background: var(--surface-soft);
    border: 1px solid var(--hairline-soft);
    color: var(--text-muted);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
  }

  .social-icon-btn svg {
    width: 18px;
    height: 18px;
    transition: transform 0.2s ease;
  }

  .social-icon-btn:hover svg {
    transform: scale(1.12);
  }

  .social-icon-btn.btn-wa:hover {
    background: #25D366;
    border-color: #25D366;
    color: #ffffff;
    box-shadow: 0 4px 12px rgba(37, 211, 102, 0.35);
  }

  .social-icon-btn.btn-ig:hover {
    background: linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%);
    border-color: transparent;
    color: #ffffff;
    box-shadow: 0 4px 12px rgba(220, 39, 67, 0.35);
  }

  .social-icon-btn.btn-fb:hover {
    background: #1877F2;
    border-color: #1877F2;
    color: #ffffff;
    box-shadow: 0 4px 12px rgba(24, 119, 242, 0.35);
  }

  .social-icon-btn.btn-tiktok:hover {
    background: #010101;
    border-color: #010101;
    color: #ffffff;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.35);
  }

  .social-icon-btn.btn-mail:hover {
    background: #EA4335;
    border-color: #EA4335;
    color: #ffffff;
    box-shadow: 0 4px 12px rgba(234, 67, 53, 0.35);
  }

  /* Footer Link with brand icon */
  .footer-link-icon {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    color: var(--text-muted);
    text-decoration: none;
    font-size: 13.5px;
    transition: all 0.2s ease;
  }

  .footer-link-icon .link-icon-glyph {
    width: 18px;
    height: 18px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    transition: transform 0.2s ease;
  }

  .footer-link-icon:hover {
    color: var(--ink-deep);
    transform: translateX(2px);
  }

  .footer-link-icon:hover .link-icon-glyph {
    transform: scale(1.1);
  }

  .footer-link-icon.wa-link .link-icon-glyph { color: #25D366; }
  .footer-link-icon.ig-link .link-icon-glyph { color: #E4405F; }
  .footer-link-icon.fb-link .link-icon-glyph { color: #1877F2; }
  .footer-link-icon.tiktok-link .link-icon-glyph { color: var(--ink-deep); }
  .footer-link-icon.mail-link .link-icon-glyph { color: #EA4335; }

  .footer-columns {
    display: grid;
    grid-template-columns: repeat(6, 1fr);
    gap: 36px 20px;
    margin-bottom: 48px;
  }

  .footer-col h4 {
    font-size: 14px;
    font-weight: 700;
    color: var(--ink-deep);
    margin-bottom: 16px;
    letter-spacing: -0.14px;
    line-height: 1.43;
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
    font-size: 14px;
    font-weight: 400;
    line-height: 1.43;
    letter-spacing: -0.14px;
    transition: color 0.15s ease;
  }
  .footer-col a:hover {
    color: var(--ink-deep);
  }

  .footer-bottom {
    padding-top: 24px;
    border-top: 1px solid var(--hairline-soft);
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: 12px;
    line-height: 1.33;
    color: var(--text-stone);
    flex-wrap: wrap;
    gap: 16px;
  }

  .footer-legal-links {
    display: flex;
    align-items: center;
    gap: 20px;
    flex-wrap: wrap;
  }

  .footer-legal-links a {
    color: var(--text-stone);
    text-decoration: none;
    transition: color 0.15s ease;
  }

  .footer-legal-links a:hover {
    color: var(--ink-deep);
  }

  .footer-locale-indicator {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    color: var(--text-muted);
    font-weight: 600;
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
    gap: 8px;
    font-size: 13px;
    font-weight: 700;
    text-decoration: none;
    box-shadow: 0 8px 24px rgba(37, 211, 102, 0.4);
    transition: all 0.2s ease;
  }
  .wa-float:hover {
    transform: translateY(-2px);
    opacity: 0.95;
    box-shadow: 0 10px 28px rgba(37, 211, 102, 0.55);
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
  @media (max-width: 1100px) {
    .footer-columns {
      grid-template-columns: repeat(3, 1fr);
    }
  }

  @media (max-width: 768px) {
    .hero-title { font-size: 36px; }
    .hero-stats-strip { grid-template-columns: repeat(2, 1fr); }
    .section-title { font-size: 28px; }
    .footer-columns { grid-template-columns: repeat(2, 1fr); gap: 28px 16px; }
    .footer-bottom { flex-direction: column; align-items: flex-start; }
    .footer-top-brand { flex-direction: column; align-items: flex-start; }
    .footer-brand-right { align-items: flex-start; }
  }

  @media (max-width: 480px) {
    .hero-btns { flex-direction: column; }
    .footer-columns { grid-template-columns: 1fr; }
  }
</style>
@endsection

@section('content')

<!-- Floating WhatsApp CTA Pill -->
<a href="{{ \App\Helpers\FormatHelper::whatsappUrl('Halo Kafa Advertising, saya ingin memesan neon box custom') }}" target="_blank" class="wa-float" title="Konsultasi WhatsApp">
  <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor">
    <path d="M17.472 14.382c-.301-.15-1.78-.878-2.056-.978-.275-.1-.476-.15-.677.15-.2.3-.776.978-.952 1.179-.175.2-.351.225-.652.075-.301-.15-1.27-.468-2.42-1.493-.895-.798-1.5-1.784-1.676-2.085-.175-.3-.019-.463.132-.612.136-.134.301-.35.451-.525.15-.176.2-.301.301-.502.101-.2.05-.376-.025-.526-.075-.15-.677-1.631-.928-2.235-.245-.588-.493-.508-.677-.517-.175-.009-.376-.009-.577-.009-.2 0-.526.075-.802.376-.275.301-1.053 1.028-1.053 2.508 0 1.48 1.078 2.909 1.228 3.11.15.2 2.122 3.24 5.141 4.544.718.31 1.279.495 1.716.634.722.23 1.379.197 1.9.12.58-.087 1.78-.727 2.03-1.429.251-.702.251-1.304.176-1.43-.075-.125-.276-.2-.577-.35zM12.04 2C6.5 2 2 6.5 2 12.04c0 1.78.47 3.52 1.36 5.06L2 22l5.06-1.33c1.5 0.84 3.19 1.29 4.98 1.29 5.54 0 10.04-4.5 10.04-10.04S17.58 2 12.04 2zm0 18.36c-1.57 0-3.1-.42-4.44-1.21l-.32-.19-3.3.87.88-3.21-.21-.33a8.31 8.31 0 0 1-1.27-4.45c0-4.6 3.74-8.34 8.34-8.34 4.6 0 8.34 3.74 8.34 8.34 0 4.6-3.74 8.34-8.34 8.34z"/>
  </svg>
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
      <svg viewBox="0 0 24 24" width="18" height="18" fill="currentColor">
        <path d="M17.472 14.382c-.301-.15-1.78-.878-2.056-.978-.275-.1-.476-.15-.677.15-.2.3-.776.978-.952 1.179-.175.2-.351.225-.652.075-.301-.15-1.27-.468-2.42-1.493-.895-.798-1.5-1.784-1.676-2.085-.175-.3-.019-.463.132-.612.136-.134.301-.35.451-.525.15-.176.2-.301.301-.502.101-.2.05-.376-.025-.526-.075-.15-.677-1.631-.928-2.235-.245-.588-.493-.508-.677-.517-.175-.009-.376-.009-.577-.009-.2 0-.526.075-.802.376-.275.301-1.053 1.028-1.053 2.508 0 1.48 1.078 2.909 1.228 3.11.15.2 2.122 3.24 5.141 4.544.718.31 1.279.495 1.716.634.722.23 1.379.197 1.9.12.58-.087 1.78-.727 2.03-1.429.251-.702.251-1.304.176-1.43-.075-.125-.276-.2-.577-.35zM12.04 2C6.5 2 2 6.5 2 12.04c0 1.78.47 3.52 1.36 5.06L2 22l5.06-1.33c1.5 0.84 3.19 1.29 4.98 1.29 5.54 0 10.04-4.5 10.04-10.04S17.58 2 12.04 2zm0 18.36c-1.57 0-3.1-.42-4.44-1.21l-.32-.19-3.3.87.88-3.21-.21-.33a8.31 8.31 0 0 1-1.27-4.45c0-4.6 3.74-8.34 8.34-8.34 4.6 0 8.34 3.74 8.34 8.34 0 4.6-3.74 8.34-8.34 8.34z"/>
      </svg>
      <span>Chat WhatsApp Sekarang</span>
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

<!-- ─── Footer Region (DESIGN2.md Spec) ─── -->
<footer class="footer-region">
  <div class="footer-top-brand">
    <a href="{{ route('home') }}" class="footer-brand-left">
      <div class="footer-brand-logo">K</div>
      <div class="footer-brand-info">
        <h3>Kafa Advertising</h3>
        <p>Spesialis Neon Box, Signage LED & Reklame Komersial</p>
      </div>
    </a>
    <div class="footer-brand-right">
      <div class="footer-brand-badges">
        <div class="footer-badge">✓ Garansi Resmi 12 Bulan</div>
        <div class="footer-badge">✓ Pengiriman Seluruh Indonesia</div>
        <div class="footer-badge">✓ Workshop Mandiri</div>
      </div>
      <!-- Social Media Buttons -->
      <div class="footer-social-strip">
        <!-- WhatsApp -->
        <a href="{{ \App\Helpers\FormatHelper::whatsappUrl('Halo Kafa Advertising, saya ingin konsultasi produk') }}" target="_blank" class="social-icon-btn btn-wa" title="WhatsApp" aria-label="WhatsApp">
          <img src="https://cdn.jsdelivr.net/npm/simple-icons@v9.13.0/icons/whatsapp.svg" alt="WhatsApp" class="w-6 h-6" />
        </a>
        <!-- Instagram -->
        <a href="https://www.instagram.com/kafaxgraf?utm_source=ig_web_button_share_sheet&stkn=ZDNlZDc0MzIxNw==" target="_blank" class="social-icon-btn btn-ig" title="Instagram" aria-label="Instagram">
          <img src="https://cdn.jsdelivr.net/npm/simple-icons@v9.13.0/icons/instagram.svg" alt="Instagram" class="w-6 h-6" />
        </a>
        <!-- Facebook -->
        <a href="https://www.facebook.com/people/Kafa-X-Graf-Adv/61555941644272/" target="_blank" class="social-icon-btn btn-fb" title="Facebook" aria-label="Facebook">
          <img src="https://cdn.jsdelivr.net/npm/simple-icons@v9.13.0/icons/facebook.svg" alt="Facebook" class="w-6 h-6" />
        </a>
        <!-- TikTok -->
        <a href="https://www.tiktok.com/@kafaxgraf" target="_blank" class="social-icon-btn btn-tiktok" title="TikTok" aria-label="TikTok">
          <img src="https://cdn.jsdelivr.net/npm/simple-icons@v9.13.0/icons/tiktok.svg" alt="TikTok" class="w-6 h-6" />
        </a>
        <!-- Email -->
        <a href="mailto:info@kafa-adv.com" class="social-icon-btn btn-mail" title="Email" aria-label="Email">
          <img src="https://cdn.jsdelivr.net/npm/simple-icons@v9.13.0/icons/gmail.svg" alt="Email" class="w-6 h-6" />
        </a>
      </div>
    </div>
  </div>

  <div class="footer-columns">
    <!-- Col 1: Produk Unggulan -->
    <div class="footer-col">
      <h4>Produk Signage</h4>
      <ul>
        <li><a href="{{ route('katalog') }}">Neon Box Akrilik</a></li>
        <li><a href="{{ route('katalog') }}">Neon Box LED Bulat</a></li>
        <li><a href="{{ route('katalog') }}">Huruf Timbul 3D</a></li>
        <li><a href="{{ route('katalog') }}">Pylon & Totem Sign</a></li>
        <li><a href="{{ route('katalog') }}">Signage Komersial</a></li>
      </ul>
    </div>

    <!-- Col 2: Kategori Katalog -->
    <div class="footer-col">
      <h4>Kategori Produk</h4>
      <ul>
        @forelse($categories->take(5) as $cat)
          <li><a href="{{ route('katalog.kategori', $cat->slug) }}">{{ $cat->nama }}</a></li>
        @empty
          <li><a href="{{ route('katalog') }}">Semua Kategori</a></li>
        @endforelse
      </ul>
    </div>

    <!-- Col 3: Navigasi Utama -->
    <div class="footer-col">
      <h4>Eksplorasi</h4>
      <ul>
        <li><a href="{{ route('home') }}">Beranda</a></li>
        <li><a href="{{ route('katalog') }}">Katalog & Harga</a></li>
        <li><a href="{{ route('portofolio') }}">Portofolio Proyek</a></li>
        <li><a href="#keunggulan">Keunggulan Mutu</a></li>
        <li><a href="#cabang">Cabang Showroom</a></li>
      </ul>
    </div>

    <!-- Col 4: Layanan & Garansi -->
    <div class="footer-col">
      <h4>Layanan Kami</h4>
      <ul>
        <li><a href="{{ \App\Helpers\FormatHelper::whatsappUrl('Halo Kafa Advertising, saya ingin konsultasi desain neon box') }}" target="_blank">Konsultasi Desain</a></li>
        <li><a href="#keunggulan">Garansi 12 Bulan</a></li>
        <li><a href="#keunggulan">Instalasi & Pasang</a></li>
        <li><a href="#keunggulan">Pengiriman Nasional</a></li>
        <li><a href="{{ route('login.customer') }}">Status Pesanan</a></li>
      </ul>
    </div>

    <!-- Col 5: Lokasi & Workshop -->
    <div class="footer-col">
      <h4>Workshop & Cabang</h4>
      <ul>
        @forelse($branches->take(4) as $branch)
          <li><a href="#cabang">{{ $branch->nama_cabang }}</a></li>
        @empty
          <li><a href="#cabang">Showroom Demak (Pusat)</a></li>
          <li><a href="#cabang">Workshop Semarang</a></li>
          <li><a href="#cabang">Cabang Surabaya</a></li>
        @endforelse
      </ul>
    </div>

    <!-- Col 6: Hubungi Kami -->
    <div class="footer-col">
      <h4>Hubungi Kami</h4>
      <ul>
        <li>
          <a href="{{ \App\Helpers\FormatHelper::whatsappUrl('Halo Kafa Advertising, saya ingin bertanya produk') }}" target="_blank" class="footer-link-icon wa-link">
            <span class="link-icon-glyph">
              <svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor"><path d="M17.472 14.382c-.301-.15-1.78-.878-2.056-.978-.275-.1-.476-.15-.677.15-.2.3-.776.978-.952 1.179-.175.2-.351.225-.652.075-.301-.15-1.27-.468-2.42-1.493-.895-.798-1.5-1.784-1.676-2.085-.175-.3-.019-.463.132-.612.136-.134.301-.35.451-.525.15-.176.2-.301.301-.502.101-.2.05-.376-.025-.526-.075-.15-.677-1.631-.928-2.235-.245-.588-.493-.508-.677-.517-.175-.009-.376-.009-.577-.009-.2 0-.526.075-.802.376-.275.301-1.053 1.028-1.053 2.508 0 1.48 1.078 2.909 1.228 3.11.15.2 2.122 3.24 5.141 4.544.718.31 1.279.495 1.716.634.722.23 1.379.197 1.9.12.58-.087 1.78-.727 2.03-1.429.251-.702.251-1.304.176-1.43-.075-.125-.276-.2-.577-.35zM12.04 2C6.5 2 2 6.5 2 12.04c0 1.78.47 3.52 1.36 5.06L2 22l5.06-1.33c1.5 0.84 3.19 1.29 4.98 1.29 5.54 0 10.04-4.5 10.04-10.04S17.58 2 12.04 2zm0 18.36c-1.57 0-3.1-.42-4.44-1.21l-.32-.19-3.3.87.88-3.21-.21-.33a8.31 8.31 0 0 1-1.27-4.45c0-4.6 3.74-8.34 8.34-8.34 4.6 0 8.34 3.74 8.34 8.34 0 4.6-3.74 8.34-8.34 8.34z"/></svg>
            </span>
            <span>WhatsApp Chat</span>
          </a>
        </li>
        <li>
          <a href="https://www.instagram.com/kafaxgraf?utm_source=ig_web_button_share_sheet&stkn=ZDNlZDc0MzIxNw==" target="_blank" class="footer-link-icon ig-link">
            <span class="link-icon-glyph">
              <svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
            </span>
            <span>Instagram</span>
          </a>
        </li>
        <li>
          <a href="https://www.facebook.com/people/Kafa-X-Graf-Adv/61555941644272/" target="_blank" class="footer-link-icon fb-link">
            <span class="link-icon-glyph">
              <svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
            </span>
            <span>Facebook Page</span>
          </a>
        </li>
        <li>
          <a href="https://www.tiktok.com/@kafaxgraf" target="_blank" class="footer-link-icon tiktok-link">
            <span class="link-icon-glyph">
              <svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor"><path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.24 1.07-.14 1.61.24 1.64 1.82 2.88 3.48 2.71 1.26-.06 2.4-1.01 2.6-2.27.09-.43.1-.87.09-1.31V.02h.01z"/></svg>
            </span>
            <span>TikTok Official</span>
          </a>
        </li>
        <li>
          <a href="mailto:info@kafa-adv.com" class="footer-link-icon mail-link">
            <span class="link-icon-glyph">
              <svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor"><path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4-8 5-8-5V6l8 5 8-5v2z"/></svg>
            </span>
            <span>Email Konsultasi</span>
          </a>
        </li>
      </ul>
    </div>
  </div>

  <div class="footer-bottom">
    <div>
      © {{ date('Y') }} <strong>Kafa Advertising</strong>. Seluruh hak cipta dilindungi.
    </div>

    <div class="footer-legal-links">
      <span class="footer-locale-indicator">🇮🇩 Indonesia (ID)</span>
      <a href="#">Syarat & Ketentuan</a>
      <a href="#">Kebijakan Privasi</a>
      <a href="#">Jaminan Mutu</a>
    </div>
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

