<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Update Status Pesanan</title>
</head>
<body style="margin:0;padding:0;background-color:#0f172a;font-family:'Segoe UI',Roboto,Helvetica,Arial,sans-serif;">

  @php
    $statusConfig = [
      'order'       => ['label' => 'Order Baru', 'icon' => '📋', 'color' => '#6366f1', 'bg' => '#eef2ff'],
      'on_progress' => ['label' => 'Sedang Dikerjakan', 'icon' => '🔧', 'color' => '#f59e0b', 'bg' => '#fffbeb'],
      'selesai'     => ['label' => 'Selesai', 'icon' => '✅', 'color' => '#10b981', 'bg' => '#ecfdf5'],
      'cancelled'   => ['label' => 'Dibatalkan', 'icon' => '❌', 'color' => '#ef4444', 'bg' => '#fef2f2'],
    ];
    $newCfg = $statusConfig[$newStatus] ?? ['label' => ucfirst($newStatus), 'icon' => '📌', 'color' => '#6366f1', 'bg' => '#eef2ff'];
    $oldCfg = $statusConfig[$oldStatus] ?? ['label' => ucfirst($oldStatus), 'icon' => '📌', 'color' => '#94a3b8', 'bg' => '#f8fafc'];
  @endphp

  <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background-color:#0f172a;padding:30px 15px;">
    <tr>
      <td align="center">
        <table role="presentation" width="580" cellspacing="0" cellpadding="0" style="background-color:#ffffff;border-radius:16px;overflow:hidden;box-shadow:0 20px 40px rgba(0,0,0,0.3);">

          {{-- Gradient Top Bar --}}
          <tr>
            <td style="height:5px;background:linear-gradient(90deg,#6366f1,#ec4899,#f59e0b);">&nbsp;</td>
          </tr>

          {{-- Header --}}
          <tr>
            <td style="padding:30px 32px 20px;text-align:center;border-bottom:2px dashed #e2e8f0;">
              <div style="font-size:22px;font-weight:800;color:#0f172a;letter-spacing:-0.5px;">KALIGRAPH DESIGN</div>
              <div style="font-size:10px;text-transform:uppercase;letter-spacing:1.5px;color:#6366f1;font-weight:700;margin-top:2px;">Advertising &bull; Signage &bull; Neon Box</div>
            </td>
          </tr>

          {{-- Status Update Icon --}}
          <tr>
            <td style="padding:28px 32px 8px;text-align:center;">
              <div style="font-size:48px;margin-bottom:8px;">{{ $newCfg['icon'] }}</div>
              <div style="font-size:20px;font-weight:800;color:#0f172a;">Status Pesanan Diperbarui</div>
              <div style="font-size:14px;color:#64748b;margin-top:4px;">
                Pesanan <strong>#ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</strong>
              </div>
            </td>
          </tr>

          {{-- Status Transition --}}
          <tr>
            <td style="padding:20px 32px;">
              <table role="presentation" width="100%" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="42%" style="padding:14px;background:{{ $oldCfg['bg'] }};border-radius:12px;text-align:center;">
                    <div style="font-size:10px;text-transform:uppercase;letter-spacing:0.5px;color:#94a3b8;font-weight:700;">Sebelumnya</div>
                    <div style="font-size:14px;font-weight:700;color:{{ $oldCfg['color'] }};margin-top:4px;">{{ $oldCfg['icon'] }} {{ $oldCfg['label'] }}</div>
                  </td>
                  <td width="16%" style="text-align:center;font-size:24px;color:#94a3b8;">→</td>
                  <td width="42%" style="padding:14px;background:{{ $newCfg['bg'] }};border-radius:12px;text-align:center;border:2px solid {{ $newCfg['color'] }};">
                    <div style="font-size:10px;text-transform:uppercase;letter-spacing:0.5px;color:#94a3b8;font-weight:700;">Sekarang</div>
                    <div style="font-size:14px;font-weight:700;color:{{ $newCfg['color'] }};margin-top:4px;">{{ $newCfg['icon'] }} {{ $newCfg['label'] }}</div>
                  </td>
                </tr>
              </table>
            </td>
          </tr>

          {{-- Order Summary --}}
          <tr>
            <td style="padding:0 32px 20px;">
              <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:12px;">
                <tr>
                  <td style="padding:14px 18px;border-bottom:1px solid #e2e8f0;" width="50%">
                    <div style="font-size:10px;text-transform:uppercase;letter-spacing:0.5px;color:#94a3b8;font-weight:700;">Pelanggan</div>
                    <div style="font-size:14px;font-weight:600;color:#0f172a;margin-top:2px;">{{ $order->nama_pelanggan }}</div>
                  </td>
                  <td style="padding:14px 18px;border-bottom:1px solid #e2e8f0;text-align:right;" width="50%">
                    <div style="font-size:10px;text-transform:uppercase;letter-spacing:0.5px;color:#94a3b8;font-weight:700;">Total Pesanan</div>
                    <div style="font-size:16px;font-weight:800;color:#6366f1;font-family:'Courier New',monospace;margin-top:2px;">Rp {{ number_format($order->total, 0, ',', '.') }}</div>
                  </td>
                </tr>
                <tr>
                  <td style="padding:14px 18px;" colspan="2">
                    <div style="font-size:10px;text-transform:uppercase;letter-spacing:0.5px;color:#94a3b8;font-weight:700;">Status Pembayaran</div>
                    <div style="font-size:13px;font-weight:600;color:#0f172a;margin-top:2px;">
                      Terbayar: Rp {{ number_format($order->total_dibayar, 0, ',', '.') }} &bull;
                      Sisa: Rp {{ number_format($order->sisa_tagihan, 0, ',', '.') }}
                    </div>
                  </td>
                </tr>
              </table>
            </td>
          </tr>

          {{-- Info Note --}}
          @if($newStatus === 'selesai')
          <tr>
            <td style="padding:0 32px 28px;">
              <div style="background:#ecfdf5;border:1px solid #a7f3d0;border-radius:12px;padding:16px 18px;">
                <div style="font-size:13px;font-weight:700;color:#065f46;margin-bottom:4px;">🎉 Pesanan Selesai!</div>
                <div style="font-size:12px;color:#065f46;line-height:1.6;">
                  Pesanan Anda telah selesai dikerjakan. Silakan hubungi kami untuk pengambilan atau pengiriman.
                </div>
              </div>
            </td>
          </tr>
          @elseif($newStatus === 'on_progress')
          <tr>
            <td style="padding:0 32px 28px;">
              <div style="background:#fffbeb;border:1px solid #fde68a;border-radius:12px;padding:16px 18px;">
                <div style="font-size:13px;font-weight:700;color:#92400e;margin-bottom:4px;">🔧 Sedang Dikerjakan</div>
                <div style="font-size:12px;color:#92400e;line-height:1.6;">
                  Tim kami sudah mulai mengerjakan pesanan Anda. Kami akan menginformasikan jika pesanan sudah selesai.
                </div>
              </div>
            </td>
          </tr>
          @elseif($newStatus === 'cancelled')
          <tr>
            <td style="padding:0 32px 28px;">
              <div style="background:#fef2f2;border:1px solid #fecaca;border-radius:12px;padding:16px 18px;">
                <div style="font-size:13px;font-weight:700;color:#991b1b;margin-bottom:4px;">❌ Pesanan Dibatalkan</div>
                <div style="font-size:12px;color:#991b1b;line-height:1.6;">
                  Pesanan Anda telah dibatalkan. Jika Anda merasa ini adalah kesalahan, silakan hubungi tim kami segera.
                </div>
              </div>
            </td>
          </tr>
          @endif

          {{-- Footer --}}
          <tr>
            <td style="padding:20px 32px;background:#f8fafc;border-top:1px solid #e2e8f0;text-align:center;">
              <div style="font-size:11px;color:#94a3b8;line-height:1.5;">
                Terima kasih telah mempercayakan kebutuhan advertising Anda kepada Kaligraph Design.<br>
                Email ini dikirim otomatis, mohon jangan membalas email ini.
              </div>
            </td>
          </tr>

        </table>
      </td>
    </tr>
  </table>

</body>
</html>
