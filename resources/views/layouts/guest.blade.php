<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Kafa Advertising')</title>
  
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

  <style>
    /* ─── Bootstrap Icon Global Style ─── */
    .bi {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      vertical-align: middle;
      line-height: 1;
    }
    :root {
      --bg-main: #ffffff;
      --bg-card: #ffffff;
      --surface-soft: #f1f4f7;
      --text-main: #0a1317;
      --text-body: #1c1e21;
      --text-muted: #5d6c7b;
      --text-stone: #8595a4;
      --border-color: #dee3e9;
      --hairline: #ced0d4;
      --hairline-soft: #dee3e9;
      --primary: #0064e0;
      --primary-deep: #0457cb;
      --primary-soft: #0091ff;
      --primary-light: #e7f1fe;
      --ink-button: #000000;
      --ink-deep: #0a1317;
      --accent: #1876f2;
      --success: #31a24c;
      --warning: #f7b928;
      --warning-bg: #ffe200;
      --attention: #f2a918;
      --danger: #e41e3f;
      --radius-sm: 4px;
      --radius-md: 6px;
      --radius-lg: 8px;
      --radius-xl: 16px;
      --radius-xxl: 24px;
      --radius-xxxl: 32px;
      --radius-full: 100px;
      --shadow-sm: 0 1px 3px rgba(10, 19, 23, 0.06);
      --shadow-md: rgba(20, 22, 26, 0.08) 0px 4px 16px;
      --shadow-sticky: rgba(20, 22, 26, 0.3) 0px 1px 4px 0px;
    }

    [data-theme="dark"] {
      --bg-main: #0a1317;
      --bg-card: #141f26;
      --surface-soft: #1a2730;
      --text-main: #f1f4f7;
      --text-body: #dee3e9;
      --text-muted: #8595a4;
      --text-stone: #5d6c7b;
      --border-color: #243542;
      --hairline: #314656;
      --hairline-soft: #243542;
      --primary-light: #0a2540;
    }

    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
    }

    html, body {
      max-width: 100%;
      overflow-x: hidden;
      background-color: var(--bg-main);
      color: var(--text-body);
      min-height: 100vh;
      -webkit-font-smoothing: antialiased;
      letter-spacing: -0.16px;
    }

    /* Common Button & Element Base Tokens */
    .btn-pill {
      border-radius: var(--radius-full);
      font-weight: 700;
      letter-spacing: -0.14px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      text-decoration: none;
      transition: all 0.2s ease;
      cursor: pointer;
    }

    .btn-meta-primary {
      background: var(--ink-button);
      color: #ffffff;
      padding: 14px 30px;
      border: none;
    }
    .btn-meta-primary:hover {
      background: #444950;
      color: #ffffff;
    }

    .btn-meta-buy {
      background: var(--primary);
      color: #ffffff;
      padding: 14px 30px;
      border: none;
    }
    .btn-meta-buy:hover {
      background: var(--primary-deep);
      color: #ffffff;
    }

    .btn-meta-ghost {
      background: transparent;
      color: var(--text-main);
      padding: 12px 28px;
      border: 2px solid var(--text-main);
    }
    .btn-meta-ghost:hover {
      background: rgba(10, 19, 23, 0.05);
    }

    /* ─── Table Responsive & Horizontal Scroll ─── */
    .table-responsive {
      width: 100%;
      overflow-x: auto;
      -webkit-overflow-scrolling: touch;
      scrollbar-width: thin;
      scrollbar-color: var(--hairline) transparent;
      margin-bottom: 16px;
    }
    .table-responsive::-webkit-scrollbar {
      height: 6px;
      width: 6px;
    }
    .table-responsive::-webkit-scrollbar-track {
      background: var(--surface-soft);
      border-radius: 10px;
    }
    .table-responsive::-webkit-scrollbar-thumb {
      background: var(--hairline);
      border-radius: 10px;
    }
    @media (max-width: 768px) {
      .table-responsive .table {
        min-width: 650px !important;
      }
      .table th, .table td {
        white-space: nowrap;
      }
    }

    /* ─── Navbar: Desktop (Gambar 1) & Mobile (Gambar 2) ─── */
    .navbar {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 16px 8%;
      background: rgba(255, 255, 255, 0.96);
      backdrop-filter: blur(14px);
      -webkit-backdrop-filter: blur(14px);
      border-bottom: 1px solid var(--border-color);
      position: sticky;
      top: 0;
      z-index: 1000;
      box-shadow: 0 4px 20px rgba(15, 23, 42, 0.04);
    }

    .nav-brand {
      display: flex;
      align-items: center;
      gap: 12px;
      font-size: 19px;
      font-weight: 800;
      color: var(--primary);
      text-decoration: none;
      letter-spacing: -0.5px;
      flex-shrink: 0;
    }

    .nav-brand .brand-logo {
      width: 38px;
      height: 38px;
      background: var(--primary);
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 18px;
      font-weight: 800;
      color: #ffffff;
      box-shadow: 0 4px 12px rgba(0, 100, 224, 0.25);
    }

    /* Desktop Menu (Gambar 1) */
    .nav-desktop-menu {
      display: flex;
      align-items: center;
      gap: 28px;
      list-style: none;
      margin: 0;
      padding: 0;
    }

    .nav-desktop-item {
      margin: 0;
      padding: 0;
    }

    .nav-desktop-link {
      display: inline-block;
      font-size: 14.5px;
      font-weight: 600;
      color: #0f172a;
      text-decoration: none;
      padding: 6px 0;
      position: relative;
      transition: color 0.2s ease;
    }

    .nav-desktop-link:hover,
    .nav-desktop-link.active {
      color: var(--primary);
    }

    .nav-desktop-link::after {
      content: '';
      position: absolute;
      bottom: -2px;
      left: 0;
      width: 0;
      height: 2px;
      background: var(--primary);
      transition: width 0.25s ease;
      border-radius: 2px;
    }

    .nav-desktop-link:hover::after,
    .nav-desktop-link.active::after {
      width: 100%;
    }

    .nav-desktop-portal {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      padding: 7px 16px;
      border-radius: 20px;
      font-size: 13px;
      font-weight: 700;
      color: var(--primary);
      background: var(--primary-light);
      border: 1px solid rgba(0, 100, 224, 0.2);
      text-decoration: none;
      transition: all 0.2s ease;
      margin-left: 6px;
    }

    .nav-desktop-portal:hover {
      background: var(--primary);
      color: #ffffff;
      box-shadow: 0 4px 12px rgba(0, 100, 224, 0.25);
    }

    /* Mobile Toggle Wrap (Gambar 2) */
    .nav-right-mobile {
      display: none;
    }

    .menu-toggle-btn {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      padding: 8px 18px;
      background: #0f172a;
      color: #ffffff;
      border: 1px solid rgba(255, 255, 255, 0.1);
      border-radius: 30px;
      font-size: 13px;
      font-weight: 800;
      letter-spacing: 1px;
      cursor: pointer;
      box-shadow: 0 4px 14px rgba(15, 23, 42, 0.18);
      transition: all 0.25s ease;
    }

    .menu-toggle-btn:hover {
      background: var(--primary);
      border-color: var(--primary);
      transform: translateY(-1px);
      box-shadow: 0 6px 18px rgba(0, 100, 224, 0.3);
    }

    .menu-burger-icon {
      width: 18px;
      height: 13px;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
    }

    .menu-burger-icon span {
      display: block;
      height: 2px;
      background: #ffffff;
      border-radius: 2px;
      transition: all 0.3s ease;
    }

    .menu-burger-icon .line-1 { width: 100%; }
    .menu-burger-icon .line-2 { width: 75%; margin-left: auto; }
    .menu-burger-icon .line-3 { width: 100%; }

    .menu-toggle-btn:hover .menu-burger-icon .line-2 {
      width: 100%;
    }

    /* ─── Drawer Styles (Used when Mobile MENU is clicked) ─── */
    .side-drawer-backdrop {
      position: fixed;
      inset: 0;
      background: rgba(15, 23, 42, 0.65);
      backdrop-filter: blur(8px);
      -webkit-backdrop-filter: blur(8px);
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
      width: 360px;
      max-width: 88vw;
      background: linear-gradient(180deg, #090e1a 0%, #0f172a 100%);
      color: #ffffff;
      z-index: 99999;
      box-shadow: -12px 0 40px rgba(0,0,0,0.5);
      transform: translateX(100%);
      transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1);
      display: flex;
      flex-direction: column;
      overflow-y: auto;
      border-left: 1px solid rgba(255,255,255,0.08);
    }
    .side-drawer-nav.active {
      transform: translateX(0);
    }

    .drawer-header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 20px 24px;
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
      color: #ffffff;
    }
    .drawer-brand-title {
      font-size: 15px;
      font-weight: 800;
      color: #ffffff;
    }
    .drawer-brand-sub {
      font-size: 11px;
      color: #94a3b8;
    }
    .drawer-close-btn {
      width: 34px;
      height: 34px;
      border-radius: 50%;
      background: rgba(255,255,255,0.08);
      border: 1px solid rgba(255,255,255,0.12);
      color: #ffffff;
      font-size: 16px;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      transition: all 0.2s ease;
    }
    .drawer-close-btn:hover {
      background: #ef4444;
      border-color: #ef4444;
    }
    .drawer-body {
      padding: 24px 20px;
      flex: 1;
    }
    .drawer-nav-label {
      font-size: 11px;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 1.5px;
      color: #64748b;
      margin-bottom: 14px;
      padding-left: 8px;
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
      padding: 12px 16px;
      border-radius: 10px;
      color: #f1f5f9;
      text-decoration: none;
      font-size: 13.5px;
      font-weight: 600;
      transition: all 0.2s ease;
      background: rgba(255,255,255,0.03);
      border: 1px solid rgba(255,255,255,0.05);
    }
    .drawer-link:hover {
      background: rgba(37, 99, 235, 0.15);
      border-color: rgba(37, 99, 235, 0.3);
      color: #60a5fa;
      transform: translateX(3px);
    }
    .drawer-footer {
      padding: 20px 24px;
      border-top: 1px solid rgba(255,255,255,0.08);
      background: rgba(0,0,0,0.2);
    }
    .drawer-footer-info {
      font-size: 11.5px;
      color: #94a3b8;
      margin-bottom: 12px;
      line-height: 1.4;
    }
    .drawer-wa-cta {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      padding: 11px 18px;
      background: #25d366;
      color: #ffffff;
      border-radius: 30px;
      font-size: 13px;
      font-weight: 700;
      text-decoration: none;
      box-shadow: 0 4px 14px rgba(37, 211, 102, 0.3);
      transition: all 0.2s ease;
    }
    .drawer-wa-cta:hover {
      background: #20bd5a;
      transform: translateY(-1px);
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
        padding: 14px 5%;
      }
      .nav-desktop-menu {
        display: none !important;
      }
      .nav-right-mobile {
        display: flex !important;
        align-items: center;
      }
      .menu-toggle-btn {
        display: inline-flex !important;
      }
    }
  </style>
  @yield('styles')
</head>
<body>
  @yield('content')
  @yield('scripts')
</body>
</html>
