# 🎨 Kaligraph Design — Architecture & UI/UX Design System Specification

---

## 1. Filosofi & Konsep Desain

**Kaligraph Design** mengusung tema **"Electric Neon & Modern Signage Aesthetics"** dipadukan dengan **"Hero Global Style Navigation"**. 

Sistem desain ini dirancang untuk mencerminkan karakteristik industri pembuatan *neon box, huruf timbul, portofolio karya, dan signage reklame*:
* **Luminous & Vibrant**: Efek pencahayaan LED neon terang, gradasi biru elektrik (*electric blue*) ke ungu ultraviolet (*indigo/violet*), serta aksen kuning neon (*amber glow*).
* **Hero Global Style Side Drawer**: Navigasi samping offcanvas menurun ke bawah bergaya premium dengan backdrop blur, penomoran urut (01-08), hover translate halus, dan interaktivitas responsif di desktop maupun mobile.
* **Atmospheric Contrast**: Kontras tinggi antara latar belakang gelap elegan dengan elemen cahaya menyala untuk menghadirkan visual papan nama neon di malam hari.
* **Clarity & Performance**: Integrasi **jQuery DataTables** untuk pengurutan, pencarian instan, dan penomoran halaman yang ringan tanpa membebani performa browser.

---

## 2. Color Palette & Design Tokens

### Primary & Accent Colors

| Token Name | Hex Code | Preview | Penggunaan Utama |
| :--- | :--- | :---: | :--- |
| `--primary` | `#2563EB` | 🟦 | Tombol utama, link aktif, highlight teks, CTA |
| `--primary-hover` | `#1D4ED8` | 🟦 | State hover pada tombol primer |
| `--primary-light` | `#DBEAFE` | 🩵 | Background badge, icon container ringan |
| `--accent-violet` | `#7C3AED` | 🟪 | Gradient hero, icon header, portal admin |
| `--accent-neon-amber` | `#EAB308` | 🟨 | Badge "Terlaris", alert peringatan, neon glow |
| `--success-green` | `#10B981` | 🟩 | Status selesai, badge pelanggan, WhatsApp CTA |
| `--danger-red` | `#EF4444` | 🟥 | Tombol hapus, status cancelled/error |

### Neutral & Theme Palettes

```css
:root {
  /* Light Mode */
  --bg-main: #f0f4ff;
  --bg-card: #ffffff;
  --bg-sidebar: #0f172a;
  --text-main: #0d1b3e;
  --text-muted: #5a6a8a;
  --border-color: #dde4f0;
  --radius-sm: 8px;
  --radius-md: 12px;
  --radius-lg: 20px;
  --radius-xl: 24px;
}

[data-theme="dark"] {
  /* Dark Neon Mode */
  --bg-main: #060d1f;
  --bg-card: #111827;
  --bg-sidebar: #020617;
  --text-main: #f8fafc;
  --text-muted: #94a3b8;
  --border-color: #1e2d4a;
}
```

---

## 3. Sistem Tipografi

* **Primary Font Family**: `'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif`
* **Karakteristik**: Geometris, modern, keterbacaan tinggi di berbagai ukuran layar.

### Skala Tipografi (Type Scale)

| Level | Size | Weight | Line Height | Contoh Penggunaan |
| :--- | :--- | :--- | :--- | :--- |
| **Hero Display** | `58px` | `800 (Extra Bold)` | `1.1` | Headline Utama Landing Page |
| **Section Title** | `36px` | `800 (Extra Bold)` | `1.2` | Judul Bagian Katalog & Portofolio |
| **Card Heading** | `20px` - `24px` | `800 (Bold)` | `1.3` | Judul Kartu Produk, Proyek & Modal |
| **Body Regular** | `14px` - `15px` | `400 / 500` | `1.6` | Paragraf penjelasan & deskripsi produk |
| **Caption & Badges** | `11px` - `12px` | `700 (Bold)` | `1.4` | Badge status, kategori, nomor urut nav |

---

## 4. Arsitektur Komponen UI & Navigasi

### A. Hero Global Style Side Drawer (Navigasi Samping)
Navigasi offcanvas samping menurun ke bawah dengan interaksi micro-animation:

```mermaid
graph TD
    A[Tombol MENU Burger / Navbar] -->|Klik| B[Buka Side Drawer Offcanvas]
    B --> C[01 🏠 Beranda]
    B --> D[02 📂 Kategori Layanan]
    B --> E[03 💡 Katalog & Harga Produk]
    B --> F[04 🖼️ Portofolio Proyek]
    B --> G[05 ⭐ Keunggulan Layanan]
    B --> H[06 📍 Lokasi Showroom & Maps]
    B --> I[07 🛍️ Portal Pelanggan]
    B --> J[08 🛡️ Login Admin & Staff]
    B --> K[Tombol WhatsApp Cepat & Info Workshop]
```

- **Backdrop Blur**: `rgba(15, 23, 42, 0.65)` dengan `backdrop-filter: blur(8px)`.
- **Staggered Animation**: Item menu muncul menurun dengan transisi bertahap (`transition-delay: 0.06s` hingga `0.41s`).
- **Escape Key & Outside Click**: Menutup drawer secara instan saat tombol `Esc` ditekan atau area luar diklik.

---

### B. Arsitektur Sub-Modul Admin Sidebar

Menu navigasi admin diorganisir dalam hierarki sub-menu pohon (`<ul>` dan `<li>`) yang dapat dilipat (*collapsible accordion*):

```mermaid
graph TD
    A[Sidebar Admin Kaligraph Design] --> B[📊 Dashboard]
    A --> D[💡 Produk & Katalog]
    D --> D1[Kelola Produk]
    D --> D2[Kelola Kategori]
    D --> D3[Kelola Portofolio]
    A --> E[📋 Manajemen Order]
    E --> E1[Status Pengerjaan]
    E --> E2[Data Pembayaran & DP]
    A --> F[⚙️ Pengaturan & Admin]
    F --> F1[👥 Manajemen User]
    F1 --> F1a[🛡️ Admin & Staf]
    F1 --> F1b[🛍️ Pelanggan]
    F --> F2[🔐 Kelola Akses]
    F2 --> F2a[🛡️ Admin & Staf]
    F2 --> F2b[🛍️ Level Pelanggan]
    F --> F3[🏪 Cabang & Showroom]
    F --> F4[🌐 Landing Page Manager]
    F --> F5[📜 Log Aktivitas Sistem]
```

---

### C. Arsitektur Hak Akses Terpusat (Role-Based Customer Permissions)

Pengaturan hak akses pelanggan tidak memerlukan pencentangan satu per satu per pengguna, melainkan dikonfigurasi pada level **Role / Level Pelanggan** yang secara otomatis mengontrol seluruh akun pelanggan di portal:

```mermaid
graph LR
    Admin[Superadmin / Admin] -->|Kelola Izin| RP[Tabel role_permissions: role=customer]
    RP -->|cust_create_order| Portal1[Buat & Checkout Pesanan Online]
    RP -->|cust_order_tracking| Portal2[Tracking Status Real-time]
    RP -->|cust_payment_confirm| Portal3[Upload Bukti Transfer Bank]
    RP -->|cust_catalog_view| Portal4[Lihat Katalog & Estimasi Biaya]
    RP -->|cust_order_history| Portal5[Riwayat & Detail Transaksi]
    RP -->|cust_download_invoice| Portal6[Cetak Nota / Unduh Faktur]
    
    CustA[Pelanggan A] -->|Login| Check{Cek Izin Role}
    CustB[Pelanggan B] -->|Login| Check
    CustNew[Pelanggan Baru] -->|Daftar| Check
    Check --> RP
```

---

### D. Dual Login Portal & Alur Autentikasi

```mermaid
graph TD
    A[Pengunjung Web] --> B{Halaman Pilihan /login}
    B -->|Pilih Pelanggan| C[Login Pelanggan /login/customer]
    B -->|Pilih Admin/Staff| D[Login Staff & Admin /login/admin]
    C -->|Belum Punya Akun| E[Daftar Pelanggan /register/customer]
    E -->|Otomatis Level: customer| F[Dashboard Pelanggan /customer/dashboard]
    C -->|Login Sukses| F
    D -->|Login Sukses| G[Dashboard Manajemen POS & Workshop /dashboard]
    C -->|Lupa Password| H[Forgot Password via OTP /forgot-password]
    D -->|Lupa Password| H
```

---

## 5. Skema Relasi Database Terkini (ERD)

```mermaid
erDiagram
    BRANCHES ||--o{ USERS : "memiliki staf"
    BRANCHES ||--o{ ORDERS : "lokasi showroom"
    CATEGORIES ||--o{ PRODUCTS : "mengelompokkan"
    CATEGORIES ||--o{ PORTFOLIOS : "kategori karya"
    USERS ||--o{ ORDERS : "membuat/memproses"
    USERS ||--o{ USER_PERMISSIONS : "izin khusus staf"
    USERS ||--o{ ACTIVITY_LOGS : "mencatat tindakan"
    ORDERS ||--|{ ORDER_ITEMS : "memuat item"
    ORDERS ||--o{ PAYMENTS : "memiliki riwayat bayar"
    PRODUCTS ||--o{ ORDER_ITEMS : "dipesan"

    BRANCHES {
        bigint id PK
        string nama_cabang
        text alamat
        string map_url
        longtext map_iframe
        timestamps created_at
    }

    CATEGORIES {
        bigint id PK
        string nama
        string slug UK
        string foto
        string emoji
        text deskripsi
        boolean is_active
        integer urutan
        timestamps created_at
    }

    PORTFOLIOS {
        bigint id PK
        bigint category_id FK
        string nama
        string foto
        text deskripsi
        string client
        string lokasi
        string tahun
        boolean is_active
        integer urutan
        timestamps created_at
    }

    USERS {
        bigint id PK
        string username UK
        string email UK
        string phone
        string password
        string level "superadmin | owner | admin | kasir | customer"
        enum user_type "admin | customer"
        bigint branch_id FK
        timestamps created_at
    }

    ROLE_PERMISSIONS {
        bigint id PK
        string role "customer | staff"
        string feature
        boolean can_read
        boolean can_create
        boolean can_update
        boolean can_delete
        timestamps created_at
    }

    USER_PERMISSIONS {
        bigint id PK
        bigint user_id FK
        string feature
        boolean can_read
        boolean can_create
        boolean can_update
        boolean can_delete
    }

    PRODUCTS {
        bigint id PK
        bigint category_id FK
        string nama
        string foto
        decimal harga_min
        decimal harga_max
        decimal harga_default
        text deskripsi
        boolean is_active
        integer urutan
        timestamps created_at
    }

    ORDERS {
        bigint id PK
        bigint user_id FK
        bigint branch_id FK
        string nama_pelanggan
        string no_hp
        text alamat
        string kategori
        enum status "order | on_progress | selesai | cancelled"
        integer total
        text keterangan
        timestamps created_at
    }

    PAYMENTS {
        bigint id PK
        bigint order_id FK
        decimal nominal
        date tanggal_bayar
        string metode "transfer | cash | qris | dp"
        string bukti_transfer
        text catatan
        timestamps created_at
    }

    ORDER_ITEMS {
        bigint id PK
        bigint order_id FK
        bigint product_id FK
        integer qty
        integer harga_satuan
        integer subtotal
    }

    ACTIVITY_LOGS {
        bigint id PK
        bigint user_id FK
        string action
        string module
        text description
        string ip_address
        timestamps created_at
    }
```

---

## 6. Prinsip Responsivitas & DataTables

* **DataTables Responsif**:
  - Konfigurasi default otomatis: pencarian cepat (*instant filtering*), pilihan jumlah entri (*lengthMenu: 10, 25, 50, 100, Semua*), bahasa Indonesia ramah pengguna, dan rendering pagination berbasis tombol navigasi modern.
* **Mobile-First Breakpoints**:
  - Desktop Besar (`> 1024px`): Sidebar terbuka tetap, grid 2-3 kolom.
  - Tablet (`768px - 1024px`): Grid 1-2 kolom, sidebar overlay dengan toggle.
  - Smartphone (`< 768px`): Side drawer offcanvas penuh, kartu tabel responsif horizontal scroll, touch target minimum `44px`.
* **Micro-Interactions**: Transisi halus `0.2s - 0.45s cubic-bezier(0.16, 1, 0.3, 1)` untuk semua animasi pembukaan drawer, modal, dan hover kartu.
