<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pembayaran Diterima</title>
</head>
<body style="margin:0;padding:0;background-color:#0f172a;font-family:'Segoe UI',Roboto,Helvetica,Arial,sans-serif;">

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

          {{-- Success Icon --}}
          <tr>
            <td style="padding:28px 32px 8px;text-align:center;">
              <div style="font-size:48px;margin-bottom:8px;">💰</div>
              <div style="font-size:20px;font-weight:800;color:#0f172a;">Pembayaran Berhasil Dicatat</div>
              <div style="font-size:14px;color:#64748b;margin-top:4px;">
                Pesanan <strong>#ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</strong>
              </div>
            </td>
          </tr>

          {{-- Payment Details --}}
          <tr>
            <td style="padding:20px 32px;">
              <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background:#ecfdf5;border:2px solid #a7f3d0;border-radius:14px;overflow:hidden;">
                <tr>
                  <td style="padding:18px;text-align:center;">
                    <div style="font-size:10px;text-transform:uppercase;letter-spacing:0.5px;color:#065f46;font-weight:700;">Jumlah Pembayaran</div>
                    <div style="font-size:28px;font-weight:800;color:#10b981;font-family:'Courier New',monospace;margin-top:6px;">
                      Rp {{ number_format($payment->jumlah, 0, ',', '.') }}
                    </div>
                    <div style="font-size:12px;color:#065f46;margin-top:6px;font-weight:600;">
                      {{ $payment->metode === 'dp' ? 'Uang Muka / DP' : ($payment->metode === 'transfer' ? 'Transfer Bank / QRIS' : 'Tunai / Cash') }}
                      &bull;
                      {{ $payment->tanggal_bayar ? $payment->tanggal_bayar->format('d M Y') : now()->format('d M Y') }}
                    </div>
                  </td>
                </tr>
              </table>
            </td>
          </tr>

          {{-- Financial Summary --}}
          <tr>
            <td style="padding:0 32px 20px;">
              @php
                $totalPaid = (int) $order->payments->sum('jumlah');
                $sisa = max(0, $order->total - $totalPaid);
                $isLunas = $sisa <= 0;
              @endphp
              <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="border:1px solid #e2e8f0;border-radius:12px;overflow:hidden;">
                <tr>
                  <td style="padding:10px 16px;background:#1e293b;font-size:11px;font-weight:700;color:#fff;text-transform:uppercase;letter-spacing:0.5px;">Keterangan</td>
                  <td style="padding:10px 16px;background:#1e293b;font-size:11px;font-weight:700;color:#fff;text-transform:uppercase;letter-spacing:0.5px;text-align:right;">Nominal</td>
                </tr>
                <tr>
                  <td style="padding:10px 16px;font-size:13px;color:#475569;border-bottom:1px solid #f1f5f9;">Total Tagihan</td>
                  <td style="padding:10px 16px;font-size:13px;color:#0f172a;font-weight:600;font-family:'Courier New',monospace;text-align:right;border-bottom:1px solid #f1f5f9;">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                </tr>
                <tr>
                  <td style="padding:10px 16px;font-size:13px;color:#475569;border-bottom:1px solid #f1f5f9;">Total Terbayar (Kumulatif)</td>
                  <td style="padding:10px 16px;font-size:13px;color:#10b981;font-weight:700;font-family:'Courier New',monospace;text-align:right;border-bottom:1px solid #f1f5f9;">Rp {{ number_format($totalPaid, 0, ',', '.') }}</td>
                </tr>
                <tr>
                  <td style="padding:12px 16px;font-size:14px;font-weight:800;color:#0f172a;">Sisa Tagihan</td>
                  <td style="padding:12px 16px;font-size:16px;font-weight:800;color:{{ $isLunas ? '#10b981' : '#f59e0b' }};font-family:'Courier New',monospace;text-align:right;">
                    Rp {{ number_format($sisa, 0, ',', '.') }}
                    @if($isLunas) ✅ @endif
                  </td>
                </tr>
              </table>
            </td>
          </tr>

          {{-- Lunas Badge --}}
          @if($isLunas)
          <tr>
            <td style="padding:0 32px 28px;">
              <div style="background:#ecfdf5;border:1px solid #a7f3d0;border-radius:12px;padding:16px 18px;text-align:center;">
                <div style="font-size:16px;font-weight:800;color:#065f46;">🎉 PEMBAYARAN LUNAS</div>
                <div style="font-size:12px;color:#065f46;margin-top:4px;">Seluruh tagihan pesanan ini sudah terbayarkan.</div>
              </div>
            </td>
          </tr>
          @else
          <tr>
            <td style="padding:0 32px 28px;">
              <div style="background:#fffbeb;border:1px solid #fde68a;border-radius:12px;padding:16px 18px;">
                <div style="font-size:13px;font-weight:700;color:#92400e;margin-bottom:4px;">⏳ Masih Ada Sisa Tagihan</div>
                <div style="font-size:12px;color:#92400e;line-height:1.6;">
                  Silakan lakukan pelunasan sisa tagihan sebesar <strong>Rp {{ number_format($sisa, 0, ',', '.') }}</strong> melalui dashboard pelanggan Anda.
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
