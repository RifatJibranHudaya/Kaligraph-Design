@extends('layouts.guest')

@section('title', 'Atur Ulang Kata Sandi - Kaligraph Design')

@section('styles')
<style>
  .auth-container {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 30px 20px;
    background: radial-gradient(circle at top right, rgba(37, 99, 235, 0.15), transparent 50%),
                radial-gradient(circle at bottom left, rgba(124, 58, 237, 0.12), transparent 50%),
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
    background: linear-gradient(90deg, #2563eb, #7c3aed);
  }

  .auth-header {
    text-align: center;
    margin-bottom: 28px;
  }

  .auth-logo {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #2563eb, #7c3aed);
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 30px;
    margin: 0 auto 16px;
    box-shadow: 0 10px 20px -3px rgba(37, 99, 235, 0.35);
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
    margin-top: 6px;
    line-height: 1.5;
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
    border-color: #2563eb;
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
  }

  .btn-submit {
    width: 100%;
    padding: 13px;
    border-radius: 12px;
    background: linear-gradient(135deg, #2563eb, #7c3aed);
    color: #fff;
    font-size: 15px;
    font-weight: 700;
    border: none;
    cursor: pointer;
    box-shadow: 0 6px 15px rgba(37, 99, 235, 0.3);
    transition: all 0.2s;
    margin-top: 8px;
  }

  .btn-submit:hover {
    transform: translateY(-1px);
    box-shadow: 0 8px 20px rgba(37, 99, 235, 0.4);
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

  .alert-success {
    background: #d1fae5;
    color: #065f46;
    border: 1px solid #a7f3d0;
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
      <div class="auth-logo">🔑</div>
      <h1 class="auth-title">Kata Sandi Baru</h1>
      <p class="auth-subtitle">Buat kata sandi baru yang kuat untuk akun <strong>{{ $email }}</strong></p>
    </div>

    @if(session('success'))
      <div class="alert-success">
        <span>✅</span> {{ session('success') }}
      </div>
    @endif

    @if($errors->any())
      <div class="alert-error">
        <span>⚠️</span> {{ $errors->first() }}
      </div>
    @endif

    <form method="POST" action="{{ route('password.reset.update') }}">
      @csrf
      <div class="form-group">
        <label class="form-label">Kata Sandi Baru (Min. 6 Karakter)</label>
        <input type="password" name="password" class="form-control" placeholder="Masukkan kata sandi baru" required autofocus>
      </div>

      <div class="form-group">
        <label class="form-label">Konfirmasi Kata Sandi Baru</label>
        <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi kata sandi baru" required>
      </div>

      <button type="submit" class="btn-submit">Simpan Kata Sandi Baru ➔</button>
    </form>
  </div>
</div>
@endsection
