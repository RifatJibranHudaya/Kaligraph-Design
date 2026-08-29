<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kode OTP Reset Password</title>
  <style>
    body {
      font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
      background-color: #f1f5f9;
      margin: 0;
      padding: 30px 15px;
      color: #1e293b;
    }
    .email-container {
      max-width: 520px;
      margin: 0 auto;
      background: #ffffff;
      border-radius: 16px;
      overflow: hidden;
      box-shadow: 0 10px 25px rgba(0,0,0,0.05);
      border: 1px solid #e2e8f0;
    }
    .email-header {
      background: linear-gradient(135deg, #2563eb, #7c3aed);
      padding: 32px 24px;
      text-align: center;
      color: #ffffff;
    }
    .email-header .logo-icon {
      font-size: 36px;
      margin-bottom: 8px;
    }
    .email-header h1 {
      margin: 0;
      font-size: 22px;
      font-weight: 800;
      letter-spacing: -0.5px;
    }
    .email-header p {
      margin: 6px 0 0;
      font-size: 13px;
      color: rgba(255,255,255,0.85);
    }
    .email-body {
      padding: 32px 28px;
      text-align: center;
    }
    .email-body h2 {
      font-size: 18px;
      color: #0f172a;
      margin-top: 0;
      margin-bottom: 12px;
    }
    .email-body p {
      font-size: 14px;
      color: #64748b;
      line-height: 1.6;
      margin-bottom: 24px;
    }
    .otp-box {
      display: inline-block;
      padding: 16px 36px;
      background: #eff6ff;
      border: 2px dashed #3b82f6;
      border-radius: 12px;
      font-size: 32px;
      font-weight: 800;
      color: #1d4ed8;
      letter-spacing: 8px;
      margin-bottom: 24px;
    }
    .otp-warning {
      font-size: 12px;
      color: #94a3b8;
      background: #f8fafc;
      padding: 12px 16px;
      border-radius: 8px;
      margin-bottom: 20px;
    }
    .email-footer {
      background: #f8fafc;
      padding: 20px 24px;
      text-align: center;
      font-size: 12px;
      color: #94a3b8;
      border-top: 1px solid #e2e8f0;
    }
  </style>
</head>
<body>
  <div class="email-container">
    <div class="email-header">
      <div class="logo-icon">💡</div>
      <h1>Kaligraph Design</h1>
      <p>Spesialis Neon Box & Signage Custom</p>
    </div>
    <div class="email-body">
      <h2>Permintaan Reset Password</h2>
      <p>Kami menerima permintaan untuk mereset kata sandi akun Anda (<strong>{{ $email }}</strong>). Gunakan kode OTP di bawah ini untuk melanjutkan:</p>
      
      <div class="otp-box">
        {{ $otpCode }}
      </div>

      <div class="otp-warning">
        ⏳ Kode OTP ini hanya berlaku selama <strong>10 menit</strong>.<br>
        Jangan berikan kode ini kepada siapapun termasuk pihak Kaligraph Design.
      </div>

      <p style="margin-bottom: 0; font-size: 13px;">Jika Anda tidak meminta perubahan kata sandi, abaikan email ini.</p>
    </div>
    <div class="email-footer">
      © {{ date('Y') }} Kaligraph Design. Hak cipta dilindungi undang-undang.
    </div>
  </div>
</body>
</html>
