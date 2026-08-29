@extends('layouts.guest')

@section('title', 'Daftar Akun Pelanggan - Kaligraph Design')

@section('styles')
<style>
  .auth-container {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 30px 20px;
    background: radial-gradient(circle at top right, rgba(37, 99, 235, 0.15), transparent 50%),
                radial-gradient(circle at bottom left, rgba(56, 189, 248, 0.12), transparent 50%),
                var(--bg-main);
  }

  .auth-card {
    width: 100%;
    max-width: 480px;
    background: var(--bg-card);
    border: 1px solid var(--border-color);
    border-radius: 24px;
    padding: 40px 36px;
    box-shadow: 0 20px 40px -10px rgba(0, 0, 0, 0.08);
    position: relative;
    overflow: hidden;
  }

  .auth-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 5px;
    background: linear-gradient(90deg, #2563eb, #38bdf8);
  }

  .auth-header {
    text-align: center;
    margin-bottom: 28px;
  }

  .auth-logo {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #2563eb, #38bdf8);
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 30px;
    margin: 0 auto 16px;
    box-shadow: 0 10px 20px -3px rgba(37, 99, 235, 0.35);
  }

  .auth-badge {
    display: inline-block;
    padding: 4px 12px;
    background: #dbeafe;
    color: #1d4ed8;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 8px;
  }

  .auth-title {
    font-size: 24px;
    font-weight: 800;
    color: var(--text-main);
    letter-spacing: -0.5px;
  }

  .auth-subtitle {
    font-size: 13px;
    color: var(--text-muted);
    margin-top: 4px;
  }

  .form-group {
    margin-bottom: 18px;
  }

  .form-label {
    display: block;
    font-size: 13px;
    font-weight: 600;
    margin-bottom: 6px;
    color: var(--text-main);
  }

  .input-wrapper {
    position: relative;
  }

  .input-icon {
    position: absolute;
    left: 16px;
    top: 50%;
    transform: translateY(-50%);
    font-size: 16px;
    color: var(--text-muted);
  }

  .form-control {
    width: 100%;
    padding: 11px 16px 11px 44px;
    border-radius: 12px;
    border: 1px solid var(--border-color);
    background: var(--bg-main);
    color: var(--text-main);
    font-size: 14px;
    outline: none;
    transition: all 0.2s;
  }

  .form-control:focus {
    border-color: #2563eb;
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
  }

  .btn-submit {
    width: 100%;
    padding: 13px;
    border-radius: 12px;
    background: linear-gradient(135deg, #2563eb, #1d4ed8);
    color: #fff;
    font-size: 15px;
    font-weight: 700;
    border: none;
    cursor: pointer;
    margin-top: 12px;
    box-shadow: 0 6px 15px rgba(37, 99, 235, 0.3);
    transition: all 0.2s;
  }

  .btn-submit:hover {
    transform: translateY(-1px);
    box-shadow: 0 8px 20px rgba(37, 99, 235, 0.4);
  }

  .auth-footer {
    text-align: center;
    margin-top: 24px;
    padding-top: 20px;
    border-top: 1px solid var(--border-color);
    font-size: 13px;
    color: var(--text-muted);
  }

  .auth-footer a {
    color: #2563eb;
    font-weight: 700;
    text-decoration: none;
  }

  .alert-error {
    background: #fee2e2;
    color: #991b1b;
    border: 1px solid #fecaca;
    padding: 12px 16px;
    border-radius: 10px;
    font-size: 13px;
    margin-bottom: 20px;
  }
</style>
@endsection

@section('content')
<div class="auth-container">
  <div class="auth-card">
    <div class="auth-header">
      <div class="auth-logo">💡</div>
      <span class="auth-badge">Registrasi Akun</span>
      <h1 class="auth-title">Daftar Pelanggan</h1>
      <p class="auth-subtitle">Buat akun untuk memesan & memantau neon box Anda</p>
    </div>

    @if($errors->any())
      <div class="alert-error">
        <span>⚠️</span> {{ $errors->first() }}
      </div>
    @endif

    <form method="POST" action="{{ route('register.customer.post') }}">
      @csrf
      <div class="form-group">
        <label class="form-label">Nama Lengkap / Perusahaan</label>
        <div class="input-wrapper">
          <span class="input-icon">👤</span>
          <input type="text" name="name" class="form-control" placeholder="contoh: Rahmat Hidayat / PT ABC" value="{{ old('name') }}" required autofocus>
        </div>
      </div>

      <div class="form-group">
        <label class="form-label">Alamat Email</label>
        <div class="input-wrapper">
          <span class="input-icon">✉️</span>
          <input type="email" name="email" class="form-control" placeholder="contoh: nama@email.com" value="{{ old('email') }}" required>
        </div>
      </div>

      <div class="form-group">
        <label class="form-label">Nomor WhatsApp / HP</label>
        <div class="input-wrapper">
          <span class="input-icon">📱</span>
          <input type="text" name="phone" class="form-control" placeholder="contoh: 081234567890" value="{{ old('phone') }}" required>
        </div>
      </div>

      <div class="form-group">
        <label class="form-label">Kata Sandi (Min. 6 Karakter)</label>
        <div class="input-wrapper">
          <span class="input-icon">🔒</span>
          <input type="password" name="password" class="form-control" placeholder="Buat kata sandi baru" required>
        </div>
      </div>

      <div class="form-group">
        <label class="form-label">Konfirmasi Kata Sandi</label>
        <div class="input-wrapper">
          <span class="input-icon">🔑</span>
          <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi kata sandi" required>
        </div>
      </div>

      <button type="submit" class="btn-submit">Daftar Sekarang ➔</button>
    </form>

    <div class="auth-footer">
      Sudah memiliki akun? <a href="{{ route('login.customer') }}">Masuk di Sini</a>
    </div>
  </div>
</div>
@endsection
