@extends('layouts.guest')

@section('title', 'Keranjang Belanja - Kafa Advertising')

@section('styles')
<style>
  .customer-navbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px 6%;
    background: rgba(255, 255, 255, 0.96);
    backdrop-filter: blur(14px);
    border-bottom: 1px solid var(--border-color);
    position: sticky;
    top: 0;
    z-index: 1000;
    box-shadow: 0 4px 20px rgba(15, 23, 42, 0.04);
  }
  .nav-brand {
    display: flex; align-items: center; gap: 12px;
    font-size: 19px; font-weight: 800; color: var(--primary);
    text-decoration: none;
  }
  .brand-icon {
    width: 38px; height: 38px; background: var(--primary);
    border-radius: 10px; display: flex; align-items: center;
    justify-content: center; font-size: 18px; color: #fff;
    box-shadow: 0 4px 12px rgba(0, 100, 224, 0.25);
  }

  .cart-container { max-width: 900px; margin: 2rem auto; padding: 0 20px; }
  .cart-title { font-size: 1.6rem; font-weight: 700; margin-bottom: 1.5rem; color: #1e293b; }
  
  .cart-item {
    display: flex; align-items: center; gap: 16px;
    padding: 16px; background: #fff; border-radius: 12px;
    border: 1px solid #e2e8f0; margin-bottom: 12px;
    transition: box-shadow 0.2s;
  }
  .cart-item:hover { box-shadow: 0 4px 12px rgba(0,0,0,0.06); }
  
  .cart-item-img {
    width: 80px; height: 80px; border-radius: 10px;
    object-fit: cover; background: #f1f5f9; flex-shrink: 0;
  }
  .cart-item-img-placeholder {
    width: 80px; height: 80px; border-radius: 10px;
    background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e1 100%);
    display: flex; align-items: center; justify-content: center;
    font-size: 28px; flex-shrink: 0;
  }
  
  .cart-item-info { flex: 1; min-width: 0; }
  .cart-item-name { font-weight: 600; font-size: 1rem; color: #1e293b; margin-bottom: 4px; }
  .cart-item-price { color: #0064E0; font-weight: 700; font-size: 0.95rem; }
  
  .cart-item-actions { display: flex; align-items: center; gap: 8px; flex-shrink: 0; }
  .qty-input {
    width: 60px; text-align: center; padding: 6px 8px;
    border: 1px solid #e2e8f0; border-radius: 8px;
    font-size: 0.9rem; font-weight: 600;
  }
  .qty-input:focus { outline: none; border-color: #0064E0; box-shadow: 0 0 0 3px rgba(0,100,224,0.1); }

  .btn-remove {
    background: #fee2e2; color: #dc2626; border: none;
    padding: 8px 12px; border-radius: 8px; cursor: pointer;
    font-size: 0.85rem; font-weight: 600; transition: all 0.2s;
  }
  .btn-remove:hover { background: #fecaca; }
  
  .cart-summary {
    background: #fff; border-radius: 14px; border: 1px solid #e2e8f0;
    padding: 24px; margin-top: 24px;
  }
  .cart-total {
    display: flex; justify-content: space-between; align-items: center;
    font-size: 1.2rem; font-weight: 700; color: #1e293b;
    padding-bottom: 16px; border-bottom: 2px solid #f1f5f9; margin-bottom: 16px;
  }
  .cart-total-value { color: #0064E0; font-size: 1.4rem; }

  .btn-checkout {
    display: block; width: 100%; padding: 14px;
    background: linear-gradient(135deg, #0064E0 0%, #0052b8 100%);
    color: #fff; border: none; border-radius: 12px;
    font-size: 1rem; font-weight: 700; cursor: pointer;
    transition: all 0.3s; text-align: center;
  }
  .btn-checkout:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(0,100,224,0.35); }
  .btn-checkout:disabled { background: #94a3b8; cursor: not-allowed; transform: none; box-shadow: none; }
  
  .btn-back {
    display: inline-flex; align-items: center; gap: 6px;
    color: #64748b; text-decoration: none; font-weight: 600;
    font-size: 0.9rem; margin-bottom: 1rem; transition: color 0.2s;
  }
  .btn-back:hover { color: #0064E0; }
  
  .empty-cart {
    text-align: center; padding: 60px 20px;
    color: #94a3b8;
  }
  .empty-cart i { font-size: 48px; margin-bottom: 16px; display: block; }
  .empty-cart p { font-size: 1.1rem; margin-bottom: 20px; }
  .btn-shop {
    display: inline-block; padding: 12px 28px;
    background: var(--primary); color: #fff;
    border-radius: 10px; text-decoration: none;
    font-weight: 600; transition: all 0.3s;
  }
  .btn-shop:hover { transform: translateY(-2px); box-shadow: 0 4px 16px rgba(0,100,224,0.3); color: #fff; }
  
  .checkout-form { margin-top: 16px; }
  .checkout-form label { display: block; font-weight: 600; margin-bottom: 6px; color: #475569; font-size: 0.9rem; }
  .checkout-form textarea {
    width: 100%; padding: 10px 14px; border: 1px solid #e2e8f0;
    border-radius: 10px; font-size: 0.9rem; resize: vertical; min-height: 70px;
    margin-bottom: 16px;
  }
  .checkout-form textarea:focus { outline: none; border-color: #0064E0; box-shadow: 0 0 0 3px rgba(0,100,224,0.1); }
</style>
@endsection

@section('content')
<!-- Navbar -->
<nav class="customer-navbar">
  <a href="{{ route('customer.dashboard') }}" class="nav-brand">
    <div class="brand-icon">K</div>
    Kafa Advertising
  </a>
  <a href="{{ route('customer.dashboard') }}" class="btn-back">
    <i class="bi bi-arrow-left"></i> Kembali
  </a>
</nav>

<div class="cart-container">
  <h1 class="cart-title">🛒 Keranjang Belanja</h1>
  
  @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius:10px;">
      {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif
  
  @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-radius:10px;">
      {{ session('error') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif

  @if($cart->items->count() > 0)
    @foreach($cart->items as $item)
      <div class="cart-item">
        @if($item->product && $item->product->foto_url)
          <img src="{{ $item->product->foto_url }}" alt="{{ $item->product->nama }}" class="cart-item-img">
        @else
          <div class="cart-item-img-placeholder">📦</div>
        @endif
        
        <div class="cart-item-info">
          <div class="cart-item-name">{{ $item->product->nama ?? 'Produk dihapus' }}</div>
          <div class="cart-item-price">
            Rp {{ number_format($item->unit_price, 0, ',', '.') }} × {{ $item->quantity }}
            = <strong>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</strong>
          </div>
          @if($item->product && $item->product->stock < $item->quantity)
            <small style="color: #dc2626;">⚠️ Stok tersisa: {{ $item->product->stock }}</small>
          @endif
        </div>
        
        <div class="cart-item-actions">
          <form action="{{ route('cart.update', $item->id) }}" method="POST" style="display:inline;">
            @csrf @method('PUT')
            <input type="number" name="quantity" value="{{ $item->quantity }}" min="0" max="{{ $item->product->stock ?? 999 }}" class="qty-input" onchange="this.form.submit()">
          </form>
          
          <form action="{{ route('cart.remove', $item->id) }}" method="POST" style="display:inline;">
            @csrf @method('DELETE')
            <button type="submit" class="btn-remove" title="Hapus">🗑️</button>
          </form>
        </div>
      </div>
    @endforeach

    <div class="cart-summary">
      <div class="cart-total">
        <span>Total Belanja</span>
        <span class="cart-total-value">Rp {{ number_format($cart->total, 0, ',', '.') }}</span>
      </div>
      
      <form action="{{ route('cart.checkout') }}" method="POST" class="checkout-form">
        @csrf
        <label for="alamat">📍 Alamat Pengiriman (Opsional)</label>
        <textarea name="alamat" id="alamat" placeholder="Masukkan alamat pengiriman...">{{ old('alamat') }}</textarea>
        
        <label for="keterangan">📝 Catatan Pesanan (Opsional)</label>
        <textarea name="keterangan" id="keterangan" placeholder="Catatan tambahan untuk pesanan Anda..." style="min-height:50px;">{{ old('keterangan') }}</textarea>
        
        <button type="submit" class="btn-checkout" id="checkoutBtn">
          🛍️ Checkout — Rp {{ number_format($cart->total, 0, ',', '.') }}
        </button>
      </form>
    </div>
  @else
    <div class="empty-cart">
      <i class="bi bi-cart-x"></i>
      <p>Keranjang belanja Anda masih kosong</p>
      <a href="{{ route('katalog') }}" class="btn-shop">🛍️ Mulai Belanja</a>
    </div>
  @endif
</div>
@endsection
