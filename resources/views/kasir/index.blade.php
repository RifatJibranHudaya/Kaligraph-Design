@extends('layouts.app')

@section('title', 'Kasir POS')

@section('styles')
<style>
  .pos-wrapper {
    display: grid;
    grid-template-columns: 1fr 380px;
    gap: 24px;
    align-items: start;
  }

  .products-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
    gap: 16px;
  }

  .pos-card {
    background: var(--bg-card);
    border: 1px solid var(--border-color);
    border-radius: 12px;
    padding: 16px;
    text-align: center;
    cursor: pointer;
    transition: all 0.2s;
    user-select: none;
  }

  .pos-card:hover {
    border-color: var(--primary);
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
  }

  .pos-emoji {
    font-size: 40px;
    margin-bottom: 8px;
  }

  .pos-title {
    font-size: 14px;
    font-weight: 700;
    margin-bottom: 4px;
  }

  .pos-price {
    font-size: 13px;
    font-weight: 800;
    color: var(--primary);
  }

  /* Cart Box */
  .cart-box {
    background: var(--bg-card);
    border: 1px solid var(--border-color);
    border-radius: var(--radius);
    padding: 20px;
    position: sticky;
    top: 90px;
  }

  .cart-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-bottom: 14px;
    border-bottom: 1px solid var(--border-color);
    margin-bottom: 16px;
  }

  .cart-items {
    max-height: 320px;
    overflow-y: auto;
    margin-bottom: 16px;
    display: flex;
    flex-direction: column;
    gap: 10px;
  }

  .cart-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 8px 0;
    border-bottom: 1px dashed var(--border-color);
  }

  .qty-btn {
    width: 26px;
    height: 26px;
    border-radius: 6px;
    border: 1px solid var(--border-color);
    background: var(--bg-main);
    cursor: pointer;
    font-weight: 700;
  }

  @media (max-width: 900px) {
    .pos-wrapper { grid-template-columns: 1fr; }
    .cart-box { position: static; }
  }
</style>
@endsection

@section('content')
<div class="pos-wrapper">
  <!-- Products Section -->
  <div>
    <div class="card" style="margin-bottom: 16px;">
      <div style="display:flex; justify-content:space-between; align-items:center;">
        <input type="text" id="searchProduct" class="form-control" placeholder="🔍 Cari menu produk..." onkeyup="filterProducts()">
        <a href="{{ route('kasir.history') }}" class="btn btn-secondary" style="margin-left:12px; white-space:nowrap;">📜 Riwayat</a>
      </div>
    </div>

    <div class="products-grid" id="productsGrid">
      @forelse($products as $prod)
        <div class="pos-card product-item" data-nama="{{ strtolower($prod->nama) }}" onclick="addToCart('{{ $prod->nama }}', {{ $prod->harga_default }})">
          @if($prod->foto_url)
            <img src="{{ $prod->foto_url }}" alt="{{ $prod->nama }}" style="width:50px; height:50px; object-fit:cover; border-radius:10px; margin-bottom:8px;">
          @else
            <div class="pos-emoji">💡</div>
          @endif
          <div class="pos-title">{{ $prod->nama }}</div>
          <div class="pos-price">Rp {{ number_format($prod->harga_default, 0, ',', '.') }}</div>
        </div>
      @empty
        <div style="grid-column: 1/-1; text-align:center; padding:40px; color:var(--text-muted);">
          Belum ada produk aktif di menu. <a href="{{ route('produk.index') }}">Tambah Produk</a>
        </div>
      @endforelse
    </div>
  </div>

  <!-- Cart Section -->
  <div class="cart-box">
    <div class="cart-header">
      <h3 style="font-size:16px; font-weight:700;">🛒 Pesanan Aktif</h3>
      <button class="btn btn-sm btn-secondary" onclick="clearCart()">Kosongkan</button>
    </div>

    <form id="orderForm" action="{{ route('kasir.store') }}" method="POST">
      @csrf
      <div class="form-group">
        <label class="form-label">Kategori Pesanan</label>
        <select name="kategori" class="form-control" required>
          <option value="Dine-in">Dine-in (Makan di Tempat)</option>
          <option value="Takeaway">Takeaway (Bawa Pulang)</option>
          <option value="Online">Online Order (Gofood/Grabfood)</option>
        </select>
      </div>

      <div class="cart-items" id="cartItems">
        <div id="emptyCartMsg" style="text-align:center; color:var(--text-muted); padding:30px 0; font-size:13px;">
          Klik produk di sebelah kiri untuk menambah ke pesanan
        </div>
      </div>

      <div class="form-group">
        <label class="form-label">Catatan Tambahan (Opsional)</label>
        <input type="text" name="keterangan" class="form-control" placeholder="cth. Tanpa pedas, meja #3">
      </div>

      <div style="border-top: 1px solid var(--border-color); padding-top: 14px; margin-top: 14px;">
        <div style="display:flex; justify-content:space-between; font-size:16px; font-weight:800; margin-bottom:16px;">
          <span>Total Bayar</span>
          <span id="cartTotal" style="color:var(--primary);">Rp 0</span>
        </div>

        <button type="submit" class="btn btn-primary" style="width:100%; padding:14px; font-size:15px;" id="btnCheckout" disabled>
          Proses Transaksi & Cetak ➔
        </button>
      </div>
    </form>
  </div>
</div>
@endsection

@section('scripts')
<script>
  let cart = [];

  function addToCart(nama, harga) {
    const existing = cart.find(item => item.nama === nama);
    if (existing) {
      existing.qty++;
    } else {
      cart.push({ nama, harga, qty: 1 });
    }
    renderCart();
  }

  function updateQty(index, delta) {
    cart[index].qty += delta;
    if (cart[index].qty <= 0) {
      cart.splice(index, 1);
    }
    renderCart();
  }

  function clearCart() {
    cart = [];
    renderCart();
  }

  function renderCart() {
    const container = document.getElementById('cartItems');
    const totalEl = document.getElementById('cartTotal');
    const btnCheckout = document.getElementById('btnCheckout');

    if (cart.length === 0) {
      container.innerHTML = `<div id="emptyCartMsg" style="text-align:center; color:var(--text-muted); padding:30px 0; font-size:13px;">Klik produk di sebelah kiri untuk menambah ke pesanan</div>`;
      totalEl.textContent = 'Rp 0';
      btnCheckout.disabled = true;
      return;
    }

    let html = '';
    let total = 0;

    cart.forEach((item, index) => {
      const subtotal = item.harga * item.qty;
      total += subtotal;
      html += `
        <div class="cart-item">
          <div style="flex:1;">
            <div style="font-size:13px; font-weight:600;">${item.nama}</div>
            <div style="font-size:11px; color:var(--text-muted);">Rp ${item.harga.toLocaleString('id-ID')}</div>
            <input type="hidden" name="items[${index}][nama]" value="${item.nama}">
            <input type="hidden" name="items[${index}][harga]" value="${item.harga}">
            <input type="hidden" name="items[${index}][qty]" value="${item.qty}">
          </div>
          <div style="display:flex; align-items:center; gap:6px;">
            <button type="button" class="qty-btn" onclick="updateQty(${index}, -1)">-</button>
            <span style="font-weight:700; font-size:13px; min-width:18px; text-align:center;">${item.qty}</span>
            <button type="button" class="qty-btn" onclick="updateQty(${index}, 1)">+</button>
          </div>
        </div>
      `;
    });

    container.innerHTML = html;
    totalEl.textContent = 'Rp ' + total.toLocaleString('id-ID');
    btnCheckout.disabled = false;
  }

  function filterProducts() {
    const query = document.getElementById('searchProduct').value.toLowerCase();
    const items = document.querySelectorAll('.product-item');
    items.forEach(item => {
      const name = item.getAttribute('data-nama');
      item.style.display = name.includes(query) ? 'block' : 'none';
    });
  }
</script>
@endsection
