@extends('layouts.guest')

@section('title', 'Login Staff & Admin - Kaligraph Design')

@section('styles')
<style>
  .auth-container {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 30px 20px;
    background: radial-gradient(circle at top right, rgba(124, 58, 237, 0.12), transparent 50%),
                radial-gradient(circle at bottom left, rgba(37, 99, 235, 0.1), transparent 50%),
                var(--bg-main);
  }

  .auth-card {
    width: 100%;
    max-width: 440px;
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
    background: linear-gradient(90deg, #7c3aed, #2563eb);
  }

  .auth-header {
    text-align: center;
    margin-bottom: 30px;
  }

  .auth-logo {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #7c3aed, #2563eb);
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 30px;
    margin: 0 auto 16px;
    box-shadow: 0 10px 20px -3px rgba(124, 58, 237, 0.35);
  }

  .auth-badge {
    display: inline-block;
    padding: 4px 12px;
    background: #f3e8ff;
    color: #6b21a8;
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
    margin-bottom: 20px;
  }

  .form-label {
    display: block;
    font-size: 13px;
    font-weight: 600;
    margin-bottom: 8px;
    color: var(--text-main);
  }

  .form-control {
    width: 100%;
    padding: 12px 16px;
    border-radius: 12px;
    border: 1px solid var(--border-color);
    background: var(--bg-main);
    color: var(--text-main);
    font-size: 14px;
    outline: none;
    transition: all 0.2s;
  }

  .form-control:focus {
    border-color: #7c3aed;
    box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.15);
  }

  .btn-submit {
    width: 100%;
    padding: 13px;
    border-radius: 12px;
    background: linear-gradient(135deg, #7c3aed, #6d28d9);
    color: #fff;
    font-size: 15px;
    font-weight: 700;
    border: none;
    cursor: pointer;
    margin-top: 10px;
    box-shadow: 0 6px 15px rgba(124, 58, 237, 0.3);
    transition: all 0.2s;
  }

  .btn-submit:hover {
    transform: translateY(-1px);
    box-shadow: 0 8px 20px rgba(124, 58, 237, 0.4);
  }

  .auth-links-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    font-size: 13px;
  }

  .auth-links-row a {
    color: #7c3aed;
    text-decoration: none;
    font-weight: 600;
  }

  .auth-links-row a:hover {
    text-decoration: underline;
  }

  .auth-footer {
    text-align: center;
    margin-top: 28px;
    padding-top: 20px;
    border-top: 1px solid var(--border-color);
    font-size: 13px;
    color: var(--text-muted);
  }

  .auth-footer a {
    color: var(--primary);
    font-weight: 600;
    text-decoration: none;
  }

  .alert {
    padding: 12px 16px;
    border-radius: 10px;
    font-size: 13px;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 8px;
  }

  .alert-error {
    background: #fee2e2;
    color: #991b1b;
    border: 1px solid #fecaca;
  }

  .alert-success {
    background: #d1fae5;
    color: #065f46;
    border: 1px solid #a7f3d0;
  }
</style>
@endsection

@section('content')
<div class="auth-container">
  <div class="auth-card">
    <div class="auth-header">
      <div class="auth-logo">🛡️</div>
      <span class="auth-badge">Staff & Manajemen</span>
      <h1 class="auth-title">Login Admin</h1>
      <p class="auth-subtitle">Sistem Manajemen POS & Operasional Neon Box</p>
    </div>

    @if(session('success'))
      <div class="alert alert-success">
        <span>✅</span> {{ session('success') }}
      </div>
    @endif

    @if($errors->any())
      <div class="alert alert-error">
        <span>⚠️</span> {{ $errors->first() }}
      </div>
    @endif

    <form method="POST" action="{{ route('login.admin.post') }}">
      @csrf
      <div class="form-group">
        <label class="form-label">Username atau Email Admin</label>
        <input type="text" name="username" class="form-control" placeholder="Masukkan username / email" value="{{ old('username') }}" required autofocus>
      </div>

      <div class="form-group">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
      </div>

      <div class="auth-links-row">
        <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; color: var(--text-main);">
          <input type="checkbox" name="remember"> Ingat Saya
        </label>
        <a href="{{ route('password.request') }}">Lupa Password?</a>
      </div>

      <button type="submit" class="btn-submit">Masuk ke Sistem Admin ➔</button>
    </form>

    <div class="auth-footer">
      Bukan staff/admin? <a href="{{ route('login.customer') }}">Masuk Portal Pelanggan</a><br>
      <a href="{{ route('login') }}" style="display: inline-block; margin-top: 8px; color: var(--text-muted); font-weight: normal;">← Kembali ke Pilihan Login</a>
    </div>
  </div>
</div>
@endsection
