@extends('layouts.guest')

@section('title', 'Register - DapurKu POS')

@section('styles')
<style>
  .auth-container {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
    background: radial-gradient(circle at top left, rgba(249, 115, 22, 0.1), transparent 50%),
                radial-gradient(circle at bottom right, rgba(59, 130, 246, 0.08), transparent 50%);
  }

  .auth-card {
    width: 100%;
    max-width: 440px;
    background: var(--bg-card);
    border: 1px solid var(--border-color);
    border-radius: var(--radius);
    padding: 36px;
    box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1);
  }

  .auth-header {
    text-align: center;
    margin-bottom: 24px;
  }

  .auth-logo {
    width: 56px;
    height: 56px;
    background: linear-gradient(135deg, #f97316, #ef4444);
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 28px;
    margin: 0 auto 16px;
  }

  .auth-title {
    font-size: 22px;
    font-weight: 800;
  }

  .auth-subtitle {
    font-size: 13px;
    color: var(--text-muted);
    margin-top: 4px;
  }

  .form-group {
    margin-bottom: 16px;
  }

  .form-label {
    display: block;
    font-size: 13px;
    font-weight: 600;
    margin-bottom: 6px;
  }

  .form-control {
    width: 100%;
    padding: 10px 14px;
    border-radius: 8px;
    border: 1px solid var(--border-color);
    background: var(--bg-main);
    color: var(--text-main);
    font-size: 14px;
    outline: none;
  }

  .btn-submit {
    width: 100%;
    padding: 12px;
    border-radius: 10px;
    background: var(--primary);
    color: #fff;
    font-size: 15px;
    font-weight: 700;
    border: none;
    cursor: pointer;
    margin-top: 10px;
  }

  .auth-footer {
    text-align: center;
    margin-top: 20px;
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
    border-radius: 8px;
    background: #fee2e2;
    color: #991b1b;
    font-size: 13px;
    margin-bottom: 18px;
  }
</style>
@endsection

@section('content')
<div class="auth-container">
  <div class="auth-card">
    <div class="auth-header">
      <div class="auth-logo">🍳</div>
      <h1 class="auth-title">Daftar Akun DapurKu</h1>
      <p class="auth-subtitle">Buat akun staf kasir baru untuk sistem POS</p>
    </div>

    @if($errors->any())
      <div class="alert">
        {{ $errors->first() }}
      </div>
    @endif

    <form method="POST" action="{{ route('register') }}">
      @csrf
      <div class="form-group">
        <label class="form-label">Username *</label>
        <input type="text" name="username" class="form-control" value="{{ old('username') }}" required autofocus>
      </div>

      <div class="form-group">
        <label class="form-label">Email (Opsional)</label>
        <input type="email" name="email" class="form-control" value="{{ old('email') }}">
      </div>

      <div class="form-group">
        <label class="form-label">No. HP (Opsional)</label>
        <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
      </div>

      <div class="form-group">
        <label class="form-label">Password *</label>
        <input type="password" name="password" class="form-control" required minlength="6">
      </div>

      <div class="form-group">
        <label class="form-label">Konfirmasi Password *</label>
        <input type="password" name="password_confirmation" class="form-control" required minlength="6">
      </div>

      <button type="submit" class="btn-submit">Daftar Akun ➔</button>
    </form>

    <div class="auth-footer">
      Sudah memiliki akun? <a href="{{ route('login') }}">Masuk di sini</a>
    </div>
  </div>
</div>
@endsection
