@extends('layouts.guest')

@section('title', 'Portal Pelanggan - Kaligraph Design')

@section('styles')
<style>
  .customer-navbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px 6%;
    background: var(--bg-card);
    border-bottom: 1px solid var(--border-color);
    position: sticky;
    top: 0;
    z-index: 100;
    box-shadow: 0 2px 10px rgba(0,0,0,0.03);
  }

  .nav-brand {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 18px;
    font-weight: 800;
    color: var(--primary);
    text-decoration: none;
  }

  .brand-icon {
    width: 36px;
    height: 36px;
    background: linear-gradient(135deg, #2563eb, #7c3aed);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
  }

  .user-nav-actions {
    display: flex;
    align-items: center;
    gap: 16px;
  }

  .user-info-pill {
    display: flex;
    align-items: center;
    gap: 10px;
    background: var(--bg-main);
    padding: 6px 14px;
    border-radius: 30px;
    border: 1px solid var(--border-color);
    font-size: 13px;
    font-weight: 600;
  }

  .user-avatar-circle {
    width: 26px;
    height: 26px;
    background: #2563eb;
    color: #fff;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    font-weight: 800;
  }

  .btn-nav-logout {
    background: #fee2e2;
    color: #991b1b;
    border: none;
    padding: 7px 14px;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 700;
    cursor: pointer;
    transition: background 0.2s;
  }

  .btn-nav-logout:hover {
    background: #fecaca;
  }

  /* Portal Content */
  .portal-content {
    max-width: 1200px;
    margin: 0 auto;
    padding: 40px 24px;
  }

  .welcome-banner {
    background: linear-gradient(135deg, #0d1b3e 0%, #1e1b4b 100%);
    border-radius: 24px;
    padding: 36px 40px;
    color: #ffffff;
    margin-bottom: 32px;
    position: relative;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(13, 27, 62, 0.15);
  }

  .welcome-banner::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -10%;
    width: 400px;
    height: 400px;
    background: radial-gradient(circle, rgba(37, 99, 235, 0.3) 0%, transparent 70%);
    pointer-events: none;
  }

  .welcome-badge {
    display: inline-block;
    padding: 4px 12px;
    background: rgba(255,255,255,0.1);
    color: #60a5fa;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 700;
    margin-bottom: 12px;
  }

  .welcome-title {
    font-size: 28px;
    font-weight: 800;
    margin-bottom: 8px;
    letter-spacing: -0.5px;
  }

  .welcome-subtitle {
    font-size: 14px;
    color: rgba(255,255,255,0.7);
    max-width: 540px;
    line-height: 1.6;
    margin-bottom: 20px;
  }

  .btn-cta-wa {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 11px 22px;
    background: #25d366;
    color: #fff;
    border-radius: 10px;
    font-size: 14px;
    font-weight: 700;
    text-decoration: none;
    box-shadow: 0 4px 15px rgba(37, 211, 102, 0.4);
    transition: transform 0.2s;
  }

  .btn-cta-wa:hover {
    transform: translateY(-2px);
  }

  /* Grid Layouts */
  .section-card {
    background: var(--bg-card);
    border: 1px solid var(--border-color);
    border-radius: 20px;
    padding: 28px;
    margin-bottom: 32px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.02);
  }

  .section-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 20px;
  }

  .section-title {
    font-size: 18px;
    font-weight: 800;
    color: var(--text-main);
    display: flex;
    align-items: center;
    gap: 8px;
  }

  /* Table styling */
  .table-responsive {
    overflow-x: auto;
  }

  .table {
    width: 100%;
    border-collapse: collapse;
    font-size: 14px;
  }

  .table th {
    background: var(--bg-main);
    color: var(--text-muted);
    font-weight: 700;
    text-align: left;
    padding: 12px 16px;
    border-bottom: 1px solid var(--border-color);
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }

  .table td {
    padding: 16px;
    border-bottom: 1px solid var(--border-color);
    color: var(--text-main);
  }

  .table tr:hover {
    background: rgba(37, 99, 235, 0.02);
  }

  .order-id-badge {
    font-weight: 700;
    color: var(--primary);
  }

  .badge-status {
    display: inline-block;
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 700;
  }

  .badge-selesai { background: #d1fae5; color: #065f46; }
  .badge-proses  { background: #dbeafe; color: #1e40af; }
  .badge-pending { background: #fef3c7; color: #92400e; }

  /* Product Catalog mini */
  .products-mini-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
    gap: 20px;
  }

  .product-mini-card {
    background: var(--bg-main);
    border: 1px solid var(--border-color);
    border-radius: 16px;
    padding: 20px;
    display: flex;
    flex-direction: column;
    transition: transform 0.2s, box-shadow 0.2s;
  }

  .product-mini-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 20px rgba(37, 99, 235, 0.08);
  }

  .product-mini-icon {
    font-size: 32px;
    margin-bottom: 12px;
  }

  .product-mini-name {
    font-size: 16px;
    font-weight: 700;
    margin-bottom: 4px;
    color: var(--text-main);
  }

  .product-mini-price {
    font-size: 16px;
    font-weight: 800;
    color: var(--primary);
    margin-bottom: 8px;
  }

  .product-mini-desc {
    font-size: 12px;
    color: var(--text-muted);
    line-height: 1.5;
    margin-bottom: 16px;
    flex-grow: 1;
  }

  .btn-order-wa {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    width: 100%;
    padding: 8px;
    background: var(--primary);
    color: #fff;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 700;
    text-decoration: none;
    transition: background 0.2s;
  }

  .btn-order-wa:hover {
    background: var(--primary-hover);
  }

  .empty-state {
    text-align: center;
    padding: 40px 20px;
    color: var(--text-muted);
  }

  .empty-icon {
    font-size: 48px;
    margin-bottom: 12px;
  }
</style>
@endsection

@section('content')
<!-- Navigation Bar -->
<nav class="customer-navbar">
  <a href="{{ route('home') }}" class="nav-brand">
    <div class="brand-icon">💡</div>
    <span>Kaligraph Design</span>
  </a>

  <div class="user-nav-actions">
    <a href="{{ route('home') }}" style="font-size: 13px; font-weight: 600; color: var(--text-main); text-decoration: none;">
      🌐 Lihat Website
    </a>

    <div class="user-info-pill">
      <div class="user-avatar-circle">
        {{ strtoupper(substr($user->username, 0, 1)) }}
      </div>
      <span>{{ $user->username }}</span>
    </div>

    <form method="POST" action="{{ route('logout') }}">
      @csrf
      <button type="submit" class="btn-nav-logout" title="Keluar">⏻ Keluar</button>
    </form>
  </div>
</nav>

<!-- Portal Content -->
<div class="portal-content">
  @if(session('success'))
    <div style="padding: 14px 18px; border-radius: 12px; background: #d1fae5; color: #065f46; font-size: 14px; font-weight: 600; margin-bottom: 24px;">
      ✅ {{ session('success') }}
    </div>
  @endif

  <!-- Welcome Banner -->
  <div class="welcome-banner">
    <div class="welcome-badge">Portal Pelanggan Kaligraph Design</div>
    <h1 class="welcome-title">Halo, {{ $user->username }}! 👋</h1>
    <p class="welcome-subtitle">
      Selamat datang di pusat layanan pelanggan Kaligraph Design. Anda dapat melihat riwayat pengerjaan pesanan neon box Anda atau melakukan konsultasi proyek baru.
    </p>
    <a href="https://wa.me/6281234567890?text=Halo%20Kaligraph%20Design%2C%20saya%20pelanggan%20({{ $user->username }})%20ingin%20konsultasi%20pesanan%20neon%20box" target="_blank" class="btn-cta-wa">
      💬 Konsultasi & Pesan Custom via WhatsApp
    </a>
  </div>

  <!-- Orders Section -->
  <div class="section-card">
    <div class="section-header">
      <h2 class="section-title">📦 Riwayat & Status Pesanan Anda</h2>
    </div>

    @if($orders->count() > 0)
      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th>No. Order</th>
              <th>Tanggal</th>
              <th>Cabang / Showroom</th>
              <th>Items Pesanan</th>
              <th>Total Biaya</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            @foreach($orders as $order)
              <tr>
                <td><span class="order-id-badge">#ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</span></td>
                <td>{{ $order->created_at->format('d M Y, H:i') }}</td>
                <td>{{ $order->branch ? $order->branch->nama_cabang : 'Pusat' }}</td>
                <td>
                  @if($order->items->count() > 0)
                    {{ $order->items->pluck('product.nama')->filter()->join(', ') ?: 'Pesanan Custom' }}
                  @else
                    Pesanan Signage
                  @endif
                </td>
                <td style="font-weight: 800; color: var(--primary);">
                  Rp {{ number_format($order->total, 0, ',', '.') }}
                </td>
                <td>
                  <span class="badge-status badge-selesai">✅ Selesai</span>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <div style="margin-top: 16px;">
        {{ $orders->links() }}
      </div>
    @else
      <div class="empty-state">
        <div class="empty-icon">💡</div>
        <h3 style="font-size: 16px; font-weight: 700; margin-bottom: 6px; color: var(--text-main);">Belum Ada Pesanan Terdaftar</h3>
        <p style="font-size: 13px; max-width: 400px; margin: 0 auto 16px;">
          Anda belum memiliki riwayat pesanan neon box. Silakan pilih produk di bawah atau hubungi tim kami untuk membuat pesanan custom.
        </p>
      </div>
    @endif
  </div>

  <!-- Catalog Section -->
  <div class="section-card">
    <div class="section-header">
      <h2 class="section-title">✨ Katalog Pilihan Neon Box</h2>
      <a href="{{ route('home') }}#produk" style="font-size: 13px; color: var(--primary); font-weight: 700; text-decoration: none;">
        Lihat Semua Produk ➔
      </a>
    </div>

    <div class="products-mini-grid">
      @foreach($products as $prod)
        <div class="product-mini-card">
          @if($prod->foto_url)
            <img src="{{ $prod->foto_url }}" alt="{{ $prod->nama }}" style="width:100%; height:140px; object-fit:cover; border-radius:10px; margin-bottom:12px; border:1px solid var(--border-color);">
          @else
            <div class="product-mini-icon">💡</div>
          @endif
          <div class="product-mini-name">{{ $prod->nama }}</div>
          <div class="product-mini-price">{{ $prod->harga_display }}</div>
          <div class="product-mini-desc">{{ $prod->deskripsi ?: 'Produk neon box berkualitas tinggi' }}</div>
          <a href="https://wa.me/6281234567890?text=Halo%20Kaligraph%20Design%2C%20saya%20tertarik%20dengan%20produk%20*{{ urlencode($prod->nama) }}*" target="_blank" class="btn-order-wa">
            💬 Pesan Sekarang
          </a>
        </div>
      @endforeach
    </div>
  </div>
</div>
@endsection
