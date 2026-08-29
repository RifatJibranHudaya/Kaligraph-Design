@extends('layouts.guest')

@section('title', 'Pilih Jalur Masuk - Kaligraph Design')

@section('styles')
<style>
  .auth-portal-container {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 40px 20px;
    background: radial-gradient(circle at top right, rgba(37, 99, 235, 0.15), transparent 50%),
                radial-gradient(circle at bottom left, rgba(124, 58, 237, 0.12), transparent 50%),
                var(--bg-main);
    position: relative;
    overflow: hidden;
  }

  .portal-wrapper {
    width: 100%;
    max-width: 820px;
    z-index: 2;
  }

  .portal-header {
    text-align: center;
    margin-bottom: 40px;
  }

  .brand-logo-badge {
    width: 64px;
    height: 64px;
    background: linear-gradient(135deg, #2563eb, #7c3aed);
    border-radius: 18px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 32px;
    margin-bottom: 16px;
    box-shadow: 0 10px 25px rgba(37, 99, 235, 0.35);
    animation: float 4s ease-in-out infinite;
  }

  .portal-title {
    font-size: 28px;
    font-weight: 800;
    color: var(--text-main);
    letter-spacing: -0.5px;
    margin-bottom: 8px;
  }

  .portal-subtitle {
    font-size: 15px;
    color: var(--text-muted);
    max-width: 480px;
    margin: 0 auto;
  }

  .portal-cards-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
    gap: 24px;
  }

  .portal-card {
    background: var(--bg-card);
    border: 1px solid var(--border-color);
    border-radius: 24px;
    padding: 36px 30px;
    text-align: center;
    text-decoration: none;
    display: flex;
    flex-direction: column;
    align-items: center;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
  }

  .portal-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: transparent;
    transition: background 0.3s;
  }

  .portal-card.customer::before {
    background: linear-gradient(90deg, #2563eb, #38bdf8);
  }

  .portal-card.admin::before {
    background: linear-gradient(90deg, #7c3aed, #ec4899);
  }

  .portal-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 35px -5px rgba(37, 99, 235, 0.15);
    border-color: rgba(37, 99, 235, 0.3);
  }

  .portal-icon {
    width: 80px;
    height: 80px;
    border-radius: 22px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 38px;
    margin-bottom: 24px;
    transition: transform 0.3s;
  }

  .portal-card:hover .portal-icon {
    transform: scale(1.1) rotate(5deg);
  }

  .portal-icon.customer {
    background: linear-gradient(135deg, rgba(37, 99, 235, 0.1), rgba(56, 189, 248, 0.15));
    border: 1px solid rgba(37, 99, 235, 0.2);
  }

  .portal-icon.admin {
    background: linear-gradient(135deg, rgba(124, 58, 237, 0.1), rgba(236, 72, 153, 0.15));
    border: 1px solid rgba(124, 58, 237, 0.2);
  }

  .card-role-badge {
    display: inline-block;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 12px;
  }

  .badge-customer {
    background: #dbeafe;
    color: #1d4ed8;
  }

  .badge-admin {
    background: #f3e8ff;
    color: #6b21a8;
  }

  .card-heading {
    font-size: 22px;
    font-weight: 800;
    color: var(--text-main);
    margin-bottom: 10px;
  }

  .card-description {
    font-size: 14px;
    color: var(--text-muted);
    line-height: 1.6;
    margin-bottom: 28px;
    flex-grow: 1;
  }

  .card-btn {
    width: 100%;
    padding: 14px;
    border-radius: 12px;
    font-size: 15px;
    font-weight: 700;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    transition: all 0.2s;
  }

  .btn-customer {
    background: linear-gradient(135deg, #2563eb, #1d4ed8);
    color: #ffffff;
    box-shadow: 0 6px 15px rgba(37, 99, 235, 0.3);
  }

  .btn-customer:hover {
    box-shadow: 0 8px 25px rgba(37, 99, 235, 0.4);
  }

  .btn-admin {
    background: linear-gradient(135deg, #7c3aed, #6d28d9);
    color: #ffffff;
    box-shadow: 0 6px 15px rgba(124, 58, 237, 0.3);
  }

  .btn-admin:hover {
    box-shadow: 0 8px 25px rgba(124, 58, 237, 0.4);
  }

  .portal-footer {
    text-align: center;
    margin-top: 36px;
    font-size: 14px;
    color: var(--text-muted);
  }

  .portal-footer a {
    color: var(--primary);
    text-decoration: none;
    font-weight: 600;
  }

  .portal-footer a:hover {
    text-decoration: underline;
  }

  @keyframes float {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-6px); }
  }
</style>
@endsection

@section('content')
<div class="auth-portal-container">
  <div class="portal-wrapper">
    <div class="portal-header">
      <div class="brand-logo-badge">💡</div>
      <h1 class="portal-title">Selamat Datang di Kaligraph Design</h1>
      <p class="portal-subtitle">Silakan pilih jenis akun Anda untuk melanjutkan ke layanan kami</p>
    </div>

    @if(session('success'))
      <div style="max-width: 500px; margin: 0 auto 24px; padding: 14px 18px; border-radius: 12px; background: #d1fae5; color: #065f46; font-size: 14px; font-weight: 600; text-align: center;">
        ✅ {{ session('success') }}
      </div>
    @endif

    <div class="portal-cards-grid">
      <!-- Customer Card -->
      <a href="{{ route('login.customer') }}" class="portal-card customer">
        <div class="portal-icon customer">🛍️</div>
        <span class="card-role-badge badge-customer">Portal Pelanggan</span>
        <h2 class="card-heading">Saya Pelanggan</h2>
        <p class="card-description">
          Masuk untuk memantau status pengerjaan pesanan neon box, melihat riwayat transaksi, dan katalog produk signage Anda.
        </p>
        <div class="card-btn btn-customer">
          Masuk sebagai Pelanggan ➔
        </div>
      </a>

      <!-- Staff / Admin Card -->
      <a href="{{ route('login.admin') }}" class="portal-card admin">
        <div class="portal-icon admin">🛡️</div>
        <span class="card-role-badge badge-admin">Internal Management</span>
        <h2 class="card-heading">Saya Staff / Admin</h2>
        <p class="card-description">
          Masuk ke sistem manajemen internal Kaligraph Design untuk operasional kasir, produksi, stok, dan administrasi cabang.
        </p>
        <div class="card-btn btn-admin">
          Masuk sebagai Admin / Staff ➔
        </div>
      </a>
    </div>

    <div class="portal-footer">
      <p>← <a href="{{ route('home') }}">Kembali ke Beranda Website</a></p>
    </div>
  </div>
</div>
@endsection
