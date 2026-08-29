<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Kaligraph Design')</title>
  
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

  <style>
    :root {
      --bg-main: #f0f4ff;
      --bg-card: #ffffff;
      --text-main: #0d1b3e;
      --text-muted: #5a6a8a;
      --border-color: #dde4f0;
      --primary: #2563eb;
      --primary-hover: #1d4ed8;
      --primary-light: #dbeafe;
      --accent: #eab308;
      --accent-light: #fef9c3;
      --radius: 16px;
    }

    [data-theme="dark"] {
      --bg-main: #060d1f;
      --bg-card: #111827;
      --text-main: #e2e8f0;
      --text-muted: #6b7280;
      --border-color: #1e2d4a;
      --primary-light: #1e3a8a;
      --accent-light: #713f12;
    }

    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      font-family: 'Plus Jakarta Sans', sans-serif;
    }

    body {
      background-color: var(--bg-main);
      color: var(--text-main);
      min-height: 100vh;
    }
  </style>
  @yield('styles')
</head>
<body>
  @yield('content')
  @yield('scripts')
</body>
</html>
