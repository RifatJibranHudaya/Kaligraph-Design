@extends('layouts.guest')

@section('title', 'Verifikasi Kode OTP - Kaligraph Design')

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
    max-width: 460px;
    background: var(--bg-card);
    border: 1px solid var(--border-color);
    border-radius: 24px;
    padding: 40px 36px;
    box-shadow: 0 20px 40px -10px rgba(0, 0, 0, 0.08);
    position: relative;
    overflow: hidden;
    text-align: center;
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

  .auth-logo {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #2563eb, #7c3aed);
    border-radius: 16px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 30px;
    margin-bottom: 16px;
    box-shadow: 0 10px 20px -3px rgba(37, 99, 235, 0.35);
  }

  .auth-title {
    font-size: 24px;
    font-weight: 800;
    color: var(--text-main);
    letter-spacing: -0.5px;
    margin-bottom: 8px;
  }

  .auth-subtitle {
    font-size: 14px;
    color: var(--text-muted);
    line-height: 1.5;
    margin-bottom: 24px;
  }

  .email-highlight {
    color: var(--primary);
    font-weight: 700;
  }

  /* 6-Digit OTP Inputs */
  .otp-inputs-wrapper {
    display: flex;
    justify-content: center;
    gap: 10px;
    margin-bottom: 24px;
  }

  .otp-digit {
    width: 48px;
    height: 58px;
    border-radius: 12px;
    border: 2px solid var(--border-color);
    background: var(--bg-main);
    color: var(--text-main);
    font-size: 24px;
    font-weight: 800;
    text-align: center;
    outline: none;
    transition: all 0.2s;
  }

  .otp-digit:focus {
    border-color: #2563eb;
    box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.15);
    background: #ffffff;
  }

  .timer-box {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: #f1f5f9;
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 13px;
    color: #64748b;
    font-weight: 600;
    margin-bottom: 24px;
  }

  .timer-box.warning {
    background: #fee2e2;
    color: #991b1b;
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
  }

  .btn-submit:hover {
    transform: translateY(-1px);
    box-shadow: 0 8px 20px rgba(37, 99, 235, 0.4);
  }

  .resend-box {
    margin-top: 24px;
    font-size: 13px;
    color: var(--text-muted);
  }

  .btn-resend {
    background: none;
    border: none;
    color: var(--primary);
    font-weight: 700;
    cursor: pointer;
    font-size: 13px;
    padding: 0;
    text-decoration: underline;
  }

  .btn-resend:disabled {
    color: var(--text-muted);
    cursor: not-allowed;
    text-decoration: none;
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
    color: var(--primary);
    font-weight: 600;
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
    text-align: left;
  }

  .alert-success {
    background: #d1fae5;
    color: #065f46;
    border: 1px solid #a7f3d0;
    padding: 12px 16px;
    border-radius: 10px;
    font-size: 13px;
    margin-bottom: 20px;
    text-align: left;
  }
</style>
@endsection

@section('content')
<div class="auth-container">
  <div class="auth-card">
    <div class="auth-logo">📬</div>
    <h1 class="auth-title">Verifikasi Kode OTP</h1>
    <p class="auth-subtitle">
      Masukkan 6 digit kode OTP yang telah dikirimkan ke:<br>
      <span class="email-highlight">{{ $email }}</span>
    </p>

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

    <form method="POST" action="{{ route('password.otp.verify.post') }}" id="otpForm">
      @csrf
      <!-- Hidden full OTP input -->
      <input type="hidden" name="otp_code" id="fullOtpInput">

      <div class="otp-inputs-wrapper">
        <input type="text" maxlength="1" class="otp-digit" pattern="[0-9]" inputmode="numeric" autofocus data-index="0">
        <input type="text" maxlength="1" class="otp-digit" pattern="[0-9]" inputmode="numeric" data-index="1">
        <input type="text" maxlength="1" class="otp-digit" pattern="[0-9]" inputmode="numeric" data-index="2">
        <input type="text" maxlength="1" class="otp-digit" pattern="[0-9]" inputmode="numeric" data-index="3">
        <input type="text" maxlength="1" class="otp-digit" pattern="[0-9]" inputmode="numeric" data-index="4">
        <input type="text" maxlength="1" class="otp-digit" pattern="[0-9]" inputmode="numeric" data-index="5">
      </div>

      <div class="timer-box" id="timerBox">
        <span>⏳</span> Kode berlaku: <strong id="countdownTimer">10:00</strong>
      </div>

      <button type="submit" class="btn-submit">Verifikasi & Lanjutkan ➔</button>
    </form>

    <div class="resend-box">
      Tidak menerima kode? 
      <form method="POST" action="{{ route('password.otp.resend') }}" style="display: inline;">
        @csrf
        <button type="submit" class="btn-resend" id="btnResend">Kirim Ulang OTP</button>
      </form>
    </div>

    <div class="auth-footer">
      Salah email? <a href="{{ route('password.request') }}">Ubah Email</a>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
  // Handle 6-Digit input auto-advance and paste
  const digits = document.querySelectorAll('.otp-digit');
  const fullOtpInput = document.getElementById('fullOtpInput');
  const otpForm = document.getElementById('otpForm');

  digits.forEach((input, index) => {
    input.addEventListener('input', (e) => {
      const val = e.target.value;
      if (val.length === 1 && index < digits.length - 1) {
        digits[index + 1].focus();
      }
      updateFullOtp();
    });

    input.addEventListener('keydown', (e) => {
      if (e.key === 'Backspace' && !input.value && index > 0) {
        digits[index - 1].focus();
      }
    });

    input.addEventListener('paste', (e) => {
      e.preventDefault();
      const pasteData = e.clipboardData.getData('text').trim().replace(/[^0-9]/g, '');
      if (pasteData) {
        for (let i = 0; i < digits.length; i++) {
          digits[i].value = pasteData[i] || '';
        }
        const nextFocus = Math.min(pasteData.length, digits.length - 1);
        digits[nextFocus].focus();
        updateFullOtp();
      }
    });
  });

  function updateFullOtp() {
    let combined = '';
    digits.forEach(d => combined += d.value);
    fullOtpInput.value = combined;
  }

  otpForm.addEventListener('submit', (e) => {
    updateFullOtp();
    if (fullOtpInput.value.length !== 6) {
      e.preventDefault();
      alert('Silakan masukkan 6 digit kode OTP secara lengkap.');
    }
  });

  // Countdown Timer
  const expiryTimestamp = {{ $expiresAt }} * 1000;
  const timerDisplay = document.getElementById('countdownTimer');
  const timerBox = document.getElementById('timerBox');

  function updateCountdown() {
    const now = new Date().getTime();
    const distance = expiryTimestamp - now;

    if (distance <= 0) {
      timerDisplay.textContent = "00:00 (Kadaluarsa)";
      timerBox.classList.add('warning');
      return;
    }

    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    const seconds = Math.floor((distance % (1000 * 60)) / 1000);

    timerDisplay.textContent = 
      (minutes < 10 ? '0' : '') + minutes + ':' + 
      (seconds < 10 ? '0' : '') + seconds;

    if (distance < 60000) {
      timerBox.classList.add('warning');
    }
  }

  setInterval(updateCountdown, 1000);
  updateCountdown();
</script>
@endsection
