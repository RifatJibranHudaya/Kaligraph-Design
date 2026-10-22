<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Konfirmasi Pesanan</title>
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

          {{-- Success Icon & Title --}}
          <tr>
            <td style="padding:28px 32px 8px;text-align:center;">
              <div style="font-size:48px;margin-bottom:8px;">✅</div>
              <div style="font-size:20px;font-weight:800;color:#0f172a;">Pesanan Berhasil Dibuat!</div>
              <div style="font-size:14px;color:#64748b;margin-top:4px;">Terima kasih atas pesanan Anda.</div>
            </td>
          </tr>

          {{-- Order Info Card --}}
          <tr>
            <td style="padding:20px 32px;">
              <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:12px;overflow:hidden;">
                <tr>
                  <td style="padding:14px 18px;border-bottom:1px solid #e2e8f0;">
                    <div style="font-size:10px;text-transform:uppercase;letter-spacing:0.5px;color:#94a3b8;font-weight:700;">Nomor Pesanan</div>
                    <div style="font-size:18px;font-weight:800;color:#6366f1;font-family:'Courier New',monospace;margin-top:2px;">#ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</div>
                  </td>
                  <td style="padding:14px 18px;border-bottom:1px solid #e2e8f0;text-align:right;">
                    <div style="font-size:10px;text-transform:uppercase;letter-spacing:0.5px;color:#94a3b8;font-weight:700;">Tanggal</div>
                    <div style="font-size:14px;font-weight:600;color:#0f172a;margin-top:2px;">{{ $order->created_at->format('d M Y, H:i') }}</div>
                  </td>
                </tr>
                <tr>
                  <td style="padding:14px 18px;" colspan="2">
                    <div style="font-size:10px;text-transform:uppercase;letter-spacing:0.5px;color:#94a3b8;font-weight:700;">Pelanggan</div>
                    <div style="font-size:14px;font-weight:600;color:#0f172a;margin-top:2px;">{{ $order->nama_pelanggan }}</div>
                    @if($order->no_hp)
                      <div style="font-size:12px;color:#64748b;margin-top:1px;">{{ $order->no_hp }}</div>
                    @endif
                    @if($order->alamat)
                      <div style="font-size:12px;color:#94a3b8;margin-top:1px;">{{ $order->alamat }}</div>
                    @endif
                  </td>
                </tr>
              </table>
            </td>
          </tr>

          {{-- Order Items --}}
          @if($order->items->count() > 0)
          <tr>
            <td style="padding:0 32px 20px;">
              <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="border:1px solid #e2e8f0;border-radius:12px;overflow:hidden;">
                <tr>
                  <td style="padding:10px 16px;background:#1e293b;font-size:11px;font-weight:700;color:#fff;text-transform:uppercase;letter-spacing:0.5px;">Produk</td>
                  <td style="padding:10px 16px;background:#1e293b;font-size:11px;font-weight:700;color:#fff;text-transform:uppercase;letter-spacing:0.5px;text-align:center;">Qty</td>
                  <td style="padding:10px 16px;background:#1e293b;font-size:11px;font-weight:700;color:#fff;text-transform:uppercase;letter-spacing:0.5px;text-align:right;">Subtotal</td>
                </tr>
                @foreach($order->items as $item)
                <tr>
                  <td style="padding:10px 16px;font-size:13px;color:#334155;border-bottom:1px solid #f1f5f9;font-weight:500;">{{ $item->produk }}</td>
                  <td style="padding:10px 16px;font-size:13px;color:#64748b;border-bottom:1px solid #f1f5f9;text-align:center;">{{ $item->quantity }}</td>
                  <td style="padding:10px 16px;font-size:13px;color:#334155;border-bottom:1px solid #f1f5f9;text-align:right;font-weight:600;font-family:'Courier New',monospace;">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                </tr>
                @endforeach
                <tr>
                  <td colspan="2" style="padding:12px 16px;font-size:14px;font-weight:800;color:#0f172a;">Total</td>
                  <td style="padding:12px 16px;font-size:16px;font-weight:800;color:#6366f1;text-align:right;font-family:'Courier New',monospace;">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                </tr>
              </table>
            </td>
          </tr>
          @else
          <tr>
            <td style="padding:0 32px 20px;">
              <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:12px;">
                <tr>
                  <td style="padding:14px 18px;">
                    <div style="font-size:10px;text-transform:uppercase;letter-spacing:0.5px;color:#94a3b8;font-weight:700;">Total Tagihan</div>
                    <div style="font-size:22px;font-weight:800;color:#6366f1;font-family:'Courier New',monospace;margin-top:4px;">Rp {{ number_format($order->total, 0, ',', '.') }}</div>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
          @endif

          {{-- Next Steps --}}
          <tr>
            <td style="padding:0 32px 28px;">
              <div style="background:#eff6ff;border:1px solid #bfdbfe;border-radius:12px;padding:16px 18px;">
                <div style="font-size:13px;font-weight:700;color:#1e40af;margin-bottom:6px;">📌 Langkah Selanjutnya:</div>
                <div style="font-size:12px;color:#1e40af;line-height:1.6;">
                  1. Lakukan pembayaran sesuai total tagihan<br>
                  2. Upload bukti pembayaran melalui dashboard pelanggan<br>
                  3. Tim kami akan memverifikasi dan memproses pesanan Anda
                </div>
              </div>
            </td>
          </tr>

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
