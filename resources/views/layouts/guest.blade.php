<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Kafa Advertising')</title>
  
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

  <style>
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
  </style>
  @yield('styles')
</head>
<body>
  @yield('content')
  @yield('scripts')
</body>
</html>
