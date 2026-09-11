@extends('layouts.app')

@section('title', 'Pengaturan Nomor WhatsApp')

@section('styles')
<style>
  .settings-grid {
    display: grid;
    grid-template-columns: 1.2fr 1fr;
    gap: 24px;
    align-items: start;
  }

  .preview-wa-card {
    background: linear-gradient(135deg, #059669, #10b981);
    color: #ffffff;
    border-radius: 16px;
    padding: 24px;
    box-shadow: 0 10px 25px rgba(16, 185, 129, 0.25);
    position: sticky;
    top: 90px;
  }

  .preview-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(8px);
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 700;
    margin-bottom: 16px;
  }

  .preview-number {
    font-size: 26px;
    font-weight: 800;
    letter-spacing: -0.5px;
    margin-bottom: 12px;
  }

  .preview-chat-box {
    background: #ffffff;
    color: #0f172a;
    border-radius: 12px;
    padding: 16px;
    margin-top: 16px;
    font-size: 13px;
    line-height: 1.5;
    position: relative;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
  }

  .preview-chat-box::before {
    content: '';
    position: absolute;
    top: -8px;
    left: 20px;
    border-width: 0 8px 8px 8px;
    border-style: solid;
    border-color: transparent transparent #ffffff transparent;
  }

  .btn-test-wa {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    width: 100%;
    margin-top: 20px;
    padding: 12px;
    background: #ffffff;
    color: #047857;
    font-weight: 700;
    font-size: 14px;
    border-radius: 10px;
    text-decoration: none;
    transition: all 0.2s;
  }

  .btn-test-wa:hover {
    background: #f0fdf4;
    transform: translateY(-2px);
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
  }

  .module-list {
    margin-top: 20px;
    border-top: 1px solid rgba(255, 255, 255, 0.2);
    padding-top: 16px;
    font-size: 12px;
  }

  .module-list li {
    margin-bottom: 6px;
    list-style: none;
    display: flex;
    align-items: center;
    gap: 8px;
  }

  @media (max-width: 900px) {
    .settings-grid {
      grid-template-columns: 1fr;
    }
  }
</style>
@endsection

@section('content')
<div class="settings-grid">
  <!-- Form Pengaturan -->
  <div class="card">
    <div class="card-header">
      <div>
        <h3 class="card-title">Pengaturan Kontak WhatsApp Terpusat</h3>
        <p style="font-size:13px; color:var(--text-muted); margin-top:4px;">
          Nomor WhatsApp yang Anda atur di sini akan langsung berlaku untuk seluruh tombol WhatsApp di semua halaman web & portal.
        </p>
      </div>
    </div>

    <form method="POST" action="{{ route('settings.whatsapp.update') }}" id="waForm">
      @csrf

      <div class="form-group">
        <label class="form-label" for="whatsapp_number">Nomor WhatsApp Admin / CS *</label>
        <input 
          type="text" 
          id="whatsapp_number" 
          name="whatsapp_number" 
          class="form-control" 
          value="{{ old('whatsapp_number', $waNumber) }}" 
          placeholder="Contoh: 081234567890 atau 6281234567890" 
          required
          oninput="updatePreview()"
        >
        <small style="color:var(--text-muted); font-size:12px; display:block; margin-top:4px;">
          Format bisa diawali dengan <code>08...</code>, <code>628...</code>, atau <code>+62...</code>. Sistem otomatis memformat ke format internasional.
        </small>
      </div>

      <div class="form-group">
        <label class="form-label" for="whatsapp_default_message">Pesan Pembuka Default (Greeting)</label>
        <textarea 
          id="whatsapp_default_message" 
          name="whatsapp_default_message" 
          class="form-control" 
          rows="4" 
          placeholder="Tulis pesan default saat pelanggan pertama kali menekan tombol WhatsApp..."
          oninput="updatePreview()"
        >{{ old('whatsapp_default_message', $waDefaultMsg) }}</textarea>
        <small style="color:var(--text-muted); font-size:12px; display:block; margin-top:4px;">
          Pesan ini akan otomatis terisi di chat WhatsApp pelanggan saat menekan tombol konsultasi umum.
        </small>
      </div>

      <div style="margin-top: 24px;">
        <button type="submit" class="btn btn-primary" style="padding: 12px 24px; font-size: 15px;">
          Simpan Pengaturan WhatsApp
        </button>
      </div>
    </form>
  </div>

  <!-- Preview Card -->
  <div class="preview-wa-card">
    <div class="preview-badge">
      <span></span> Live Preview Terhubung
    </div>
    <div style="font-size:13px; opacity:0.9;">Nomor Kontak Aktif:</div>
    <div class="preview-number" id="previewNumberDisplay">+{{ $formattedWa }}</div>

    <div style="font-size:12px; opacity:0.9; margin-top:10px;">Template Pesan:</div>
    <div class="preview-chat-box" id="previewMsgDisplay">
      {{ $waDefaultMsg }}
    </div>

    <a href="{{ \App\Helpers\FormatHelper::whatsappUrl() }}" target="_blank" class="btn-test-wa" id="testWaBtn">
      <span>💬</span> Uji Chat WhatsApp Sekarang
    </a>

    <div class="module-list">
      <div style="font-weight:700; margin-bottom:8px;">Modul yang Terhubung Otomatis:</div>
      <ul>
        <li>Tombol Hero CTA Landing Page</li>
        <li>Tombol Melayang (Floating Button) WhatsApp</li>
        <li>Tombol Hubungi CS di Detail & List Katalog</li>
        <li>Tombol Konsultasi di Portofolio</li>
        <li>Tombol Order / Chat CS di Portal Pelanggan</li>
        <li>Menu Mobile Drawer Navigation</li>
      </ul>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
  function formatCleanNumber(num) {
    let clean = num.replace(/[^0-9]/g, '');
    if (clean.startsWith('0')) {
      clean = '62' + clean.substring(1);
    } else if (clean.startsWith('8')) {
      clean = '62' + clean;
    }
    return clean || '6281234567890';
  }

  function updatePreview() {
    const rawNum = document.getElementById('whatsapp_number').value;
    const cleanNum = formatCleanNumber(rawNum);
    const msg = document.getElementById('whatsapp_default_message').value || 'Halo Kaligraph Design, saya ingin konsultasi pesanan neon box & signage.';

    document.getElementById('previewNumberDisplay').textContent = '+' + cleanNum;
    document.getElementById('previewMsgDisplay').textContent = msg;

    const testUrl = 'https://wa.me/' + cleanNum + '?text=' + encodeURIComponent(msg);
    document.getElementById('testWaBtn').href = testUrl;
  }
</script>
@endsection
