# 💡 Kaligraph Design — Sistem Manajemen & Katalog Reklame / Neon Box

<p align="center">
  <img src="public/images/neon_box_hero.jpg" alt="Kaligraph Design Banner" width="100%" style="border-radius: 16px; max-height: 400px; object-fit: cover;">
</p>

<p align="center">
  <strong>Solusi Digital Manajemen Bisnis Advertising, Neon Box, Huruf Timbul, Portofolio & Bengkel Las Konstruksi Terintegrasi</strong><br>
  Dibangun dengan framework <strong>Laravel 10</strong>, <strong>MySQL</strong>, <strong>DataTables</strong>, dan antarmuka UI bertema <em>Electric Neon Modern & Hero Global Style Navigation</em>.
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-10.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel 10">
  <img src="https://img.shields.io/badge/PHP-8.1+-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP 8.1+">
  <img src="https://img.shields.io/badge/MySQL-8.0+-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL">
  <img src="https://img.shields.io/badge/DataTables-1.13.7-0075FF?style=for-the-badge&logo=jquery&logoColor=white" alt="DataTables">
  <img src="https://img.shields.io/badge/License-MIT-green?style=for-the-badge" alt="MIT License">
</p>

---

## 📖 Tentang Kaligraph Design

**Kaligraph Design** adalah aplikasi web komprehensif yang dirancang khusus untuk operasional bisnis jasa advertising visual, reklame, neon box, huruf timbul (*channel letter*), pylon sign, serta produk bengkel las konstruksi (kanopi, pagar minimalis, rak custom, dsb).

Aplikasi ini mengintegrasikan fungsi inti yang lengkap:
1. **Frontend Publik & Katalog Interaktif**:
   - Beranda modern dengan navigasi *Hero Global Style Side Drawer* menurun ke bawah.
   - Katalog publik berbasis kategori layanan advertising dan detail spesifikasi produk.
   - Galeri portofolio hasil karya dan proyek terpasang dengan filter kategori interaktif.
   - Portal mandiri khusus pelanggan untuk pemesanan online, upload bukti bayar, dan pelacakan status pengerjaan.
2. **Backend Admin & Order Tracking System**:
   - Manajemen master produk, kategori, dan portofolio proyek lengkap dengan live upload foto.
   - Pelacakan alur status pengerjaan pesanan (*Order Baru* ➔ *On Progress* ➔ *Selesai* ➔ *Cancelled*).
   - Pencatatan pembayaran uang muka (DP) dan pelunasan dengan verifikasi bukti transfer/nota.
   - Sub-modul **Manajemen User** terpisah: *Admin & Staf* dan *Data Pelanggan*.
   - Sub-modul **Kelola Hak Akses**: *Matriks Akses Staf* dan *Hak Akses Terpusat Level Pelanggan* (*Role-Based Permissions*).
   - Manajemen multi-cabang/showroom dengan Google Maps iframe interaktif dan Audit Log Aktivitas.

---

## ✨ Fitur-Fitur Utama

### 1. 🌐 Beranda Publik & Navigasi Side Drawer (`/`)
- **Hero Banner Dinamis**: Visual neon box resolusi tinggi dengan tipografi modern dan tombol CTA WhatsApp konsultasi instan.
- **Hero Global Style Side Drawer (Navigasi Samping Menurun)**: Navigasi offcanvas samping dengan backdrop blur, penomoran urut dinamis (01-08), dan penataan rute yang konsisten di semua halaman.
- **Showcase Kategori Layanan**: Kartu kategori interaktif lengkap dengan foto cover dan jumlah produk tersedia.
- **Showroom & Lokasi Interaktif**: Integrasi embed Google Maps responsif pada masing-masing cabang.
- **Floating WhatsApp CTA**: Tombol mengambang dengan efek *pulse glow animation*.

### 2. 📂 Katalog & Detail Produk
- **Katalog Semua Kategori (`/katalog`)**: Menampilkan seluruh kategori advertising & bengkel las yang aktif.
- **Katalog per Kategori (`/katalog/{slug}`)**: Menampilkan daftar produk spesifik dalam kategori terpilih.
- **Detail Produk & Konsultasi (`/katalog/{slug}/{product}`)**:
  - Foto resolusi tinggi, rentang estimasi harga (*Rp Min - Rp Max*), dan spesifikasi bahan.
  - Nilai tambah (Survey lokasi gratis, Garansi resmi modul LED, Pengiriman kurir/kargo).
  - Tombol CTA WhatsApp dengan pesan pemesanan otomatis terformat.
  - Rekomendasi produk terkait dalam kategori yang sama.

### 3. 🖼️ Galeri Portofolio Proyek (`/portofolio` & `/portfolio`)
- **Halaman Publik Portofolio (`/portofolio`)**:
  - Galeri hasil karya proyek neon box, signage, huruf timbul, dan konstruksi reklame.
  - Filter tab kategori proyek interaktif tanpa reload halaman.
  - Informasi nama proyek, nama klien, lokasi pengerjaan, dan tahun pembuatan.
- **Kelola Portofolio Admin (`/portfolio`)**:
  - CRUD portofolio proyek lengkap dengan upload gambar (JPG, PNG, WEBP max 3MB).
  - Integrasi DataTables, modal edit responsif, dan toggle status tampil di website.

### 4. 📋 Modul Status Pengerjaan Order (`/status-order`)
- **Alur Status Workflow Terpadu**:
  - `📥 Order`: Pesanan baru masuk / menunggu konfirmasi spesifikasi & DP.
  - `⚙️ On Progress`: Sedang dalam proses desain, cutting rangka, las, atau perakitan LED.
  - `✅ Selesai`: Pekerjaan telah selesai diproduksi, terpasang di lokasi, atau siap kirim.
  - `❌ Cancelled`: Pesanan dibatalkan.
- **Form Order Baru & AJAX Autocomplete**: Pencarian instan data pelanggan terdaftar & riwayat pesanan terdahulu secara real-time dengan auto-fill nama, nomor telepon/WhatsApp, dan alamat pengiriman.
- **Filter Tab Cepat & Pencarian**: Filter pesanan per status dengan indikator status pembayaran (*Lunas*, *DP*, *Belum Bayar*).

### 5. 💳 Modul Data Pembayaran & DP (`/pembayaran`)
- Pencatatan transaksi pembayaran per ID order (*Transfer Bank / QRIS*, *Tunai / Cash*, *Uang Muka / DP*).
- **Cetak Nota & Bukti Pembayaran (`/pembayaran/{payment}/nota`)**: Cetak faktur / struk tanda terima pembayaran resmi dengan header cabang, rincian pesanan, status pelunasan, dan format cetak thermal/kertas siap print.
- Upload bukti transfer / nota pembayaran dengan preview modal cepat.
- Filter riwayat pembayaran berdasarkan nomor pesanan dan metode pembayaran.

### 6. 👥 Sub-Modul Manajemen User & Data Pelanggan
- **Admin & Staf (`/users`)**: Kelola akun pengguna internal (Superadmin, Owner, Admin, Kasir) dengan cabang penugasan.
- **Data Pelanggan (`/pelanggan`)**:
  - Manajemen khusus akun pelanggan terdaftar (otomatis dipisahkan dari staf).
  - Ringkasan total pesanan dan total nilai transaksi per pelanggan.
  - Tombol pintas chat WhatsApp langsung (`wa.me`) ke nomor kontak pelanggan.
  - Form pendaftaran pelanggan baru dan modal edit data akun.

### 7. 🔐 Sub-Modul Kelola Hak Akses Terpadu
- **Hak Akses Admin & Staf (`/akses`)**: Matriks izin CRUD (Read, Create, Update, Delete) per modul untuk setiap staf/karyawan.
- **Hak Akses Level Pelanggan (`/akses/pelanggan`)**:
  - Pengaturan izin fitur portal pelanggan terpusat per **Level / Role Pelanggan** (berlaku untuk semua pelanggan secara global tanpa perlu mencentang satu per satu).
  - Kontrol fitur portal: *Buat Pesanan Online*, *Tracking Progres Pengerjaan*, *Upload Bukti Pembayaran*, *Lihat Katalog & Estimasi*, *Riwayat Pesanan*, dan *Cetak Faktur/Nota*.
  - Tombol preset cepat: `✅ Izinkan Semua`, `⚡ Standar Portal`, dan `👁️ Hanya Lihat`.

### 8. ⚡ DataTables & Pagination Responsif
- Integrasi **jQuery DataTables** + **Bootstrap 5** di seluruh tabel modul admin (Produk, Kategori, Portofolio, Pelanggan, Activity Log).
- Pencarian instan, sorting multi-kolom, dropdown jumlah entri (10, 25, 50, 100, Semua), dan penomoran halaman ringan.

### 9. 🛡️ Dual Login Portal & OTP Password Recovery
- **Portal Pemilihan Login (`/login`)**: Pilihan masuk sebagai Pelanggan atau Staff/Admin.
- **Portal Pelanggan (`/login/customer` & `/register/customer`)**: Registrasi mandiri pelanggan (otomatis berstatus `level = 'customer'`).
- **Login Staff Internal (`/login/admin`)**: Login multi-role untuk Superadmin, Owner, Admin, dan Kasir.
- **Lupa Password via OTP Email (`/forgot-password`)**: Alur reset kata sandi dengan 6-digit kode OTP email (kedaluwarsa 10 menit).

---

## 🛠️ Kebutuhan Sistem

- **PHP**: Versi 8.1 atau lebih tinggi (ekstensi `pdo_mysql`, `mbstring`, `fileinfo`, `openssl`)
- **Database**: MySQL 8.0+ / MariaDB 10.4+
- **Web Server**: Apache / Nginx (atau Laragon / XAMPP)
- **Composer**: Versi 2.x
- **Mail Catcher (Pengujian Lokal)**: Mailpit / Mailtrap (port SMTP 1025 / Web UI 8025)

---

## 🚀 Panduan Instalasi & Setup

### 1. Clone Repositori
```bash
git clone https://github.com/RifatJibranHudaya/Kaligraph-Design.git
cd KaligraphAdvertasing-app-laravel
```

### 2. Install Dependensi PHP
```bash
composer install
```

### 3. Konfigurasi Environment (`.env`)
Salin file `.env.example` menjadi `.env`:
```bash
cp .env.example .env
```
Sesuaikan konfigurasi database dan mail pada file `.env`:
```env
APP_NAME="Kaligraph Design"
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=kaligraph_advertising
DB_USERNAME=root
DB_PASSWORD=

MAIL_MAILER=smtp
MAIL_HOST=127.0.0.1
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_FROM_ADDRESS="noreply@kaligraphdesign.com"
MAIL_FROM_NAME="Kaligraph Design"
```

### 4. Generate Application Key & Link Storage
```bash
php artisan key:generate
```

### 5. Jalankan Migrasi & Database Seeder
Perintah berikut akan membuat seluruh skema tabel, akun default, kategori, produk reklame, portofolio, dan izin role:
```bash
php artisan migrate --seed
```

### 6. Jalankan Server Aplikasi
```bash
php artisan serve
```
Akses aplikasi melalui browser di: `http://localhost:8000`

---

## 🔑 Kredensial Akun Default

| Peran (Role) | Username | Email | Password | Hak Akses Utama |
| :--- | :--- | :--- | :--- | :--- |
| **Superadmin** | `admin` | `admin@kaligraphdesign.com` | `admin` | Akses penuh seluruh modul dan konfigurasi sistem |
| **Owner** | `owner` | `owner@kaligraphdesign.com` | `owner` | Manajemen cabang, laporan analitik, order, pembayaran |
| **Kasir** | `kasir` | `kasir@kaligraphdesign.com` | `kasir` | Kasir POS, pencatatan transaksi kasir |
| **Pelanggan** | *Daftar mandiri* | *(Email pelanggan)* | *(Password terdaftar)* | Dashboard pelanggan, order online, tracking progres |

> 💡 **Pengujian Email OTP Reset Password:**  
> Jika menggunakan Laragon, email OTP verifikasi dapat dilihat secara real-time melalui Mailpit di browser: [`http://localhost:8025`](http://localhost:8025).

---

## 🧭 Daftar Rute Utama (Route Sitemap)

### Publik & Katalog
| Method | URI | Deskripsi |
| :--- | :--- | :--- |
| `GET` | `/` | Landing page beranda & showcase kategori |
| `GET` | `/katalog` | Daftar seluruh kategori produk reklame |
| `GET` | `/katalog/{slug}` | Daftar produk berdasarkan kategori |
| `GET` | `/katalog/{slug}/{product}` | Detail produk, spesifikasi & order WhatsApp |
| `GET` | `/portofolio` | Galeri portofolio hasil karya dan filter proyek |
| `GET` | `/login` | Pilihan portal login (Pelanggan / Staff) |
| `GET` | `/login/customer` | Login portal pelanggan |
| `GET` | `/login/admin` | Login staff & admin |
| `GET` | `/register/customer` | Registrasi akun pelanggan baru |
| `GET` | `/forgot-password` | Formulir request OTP reset password |

### Portal Pelanggan (`auth` & role `customer`)
| Method | URI | Deskripsi |
| :--- | :--- | :--- |
| `GET` | `/customer/dashboard` | Dashboard riwayat order & tracking pelanggan |

### Admin & Staff Internal (`auth` & permission guards)
| Method | URI | Deskripsi |
| :--- | :--- | :--- |
| `GET` | `/dashboard` | Dashboard analitik pesanan, omset, dan ringkasan |
| `GET` | `/produk` | Master data produk, rentang harga & foto |
| `GET` | `/kategori` | Master data kategori produk & cover |
| `GET` | `/portfolio` | CRUD data portofolio hasil karya proyek |
| `GET` | `/status-order` | Tracking & alur status pengerjaan pesanan |
| `POST` | `/status-order` | Simpan pesanan / order baru |
| `GET` | `/status-order/search-pelanggan` | API AJAX autocomplete pencarian pelanggan |
| `PUT` | `/status-order/{order}/status` | Update status pengerjaan order |
| `GET` | `/pembayaran` | Manajemen pembayaran, DP & bukti transfer |
| `POST` | `/pembayaran` | Simpan pencatatan pembayaran baru |
| `GET` | `/pembayaran/{payment}/nota` | Cetak nota / bukti pembayaran transaksi |
| `GET` | `/users` | Sub-modul manajemen akun Admin & Staf |
| `GET` | `/pelanggan` | Sub-modul manajemen akun Data Pelanggan |
| `GET` | `/akses` | Sub-modul matriks hak akses Admin & Staf |
| `GET` | `/akses/pelanggan` | Sub-modul hak akses Level Pelanggan (Global) |
| `PUT` | `/akses/pelanggan` | Update izin fitur Level Pelanggan |
| `GET` | `/branches` | Manajemen cabang showroom & Google Maps |
| `GET` | `/activity-log` | Audit trail riwayat aktivitas sistem |
| `GET` | `/home-manager` | Kelola konten teks & banner landing page |

---

## 🧪 Pengujian Otomatis (Automated Testing)

Aplikasi dilengkapi test suite komprehensif yang memvalidasi seluruh rute publik, katalog, portofolio, autentikasi pelanggan/staf, CRUD admin, pembaruan status order, cetak nota pembayaran, dan sistem hak akses role:

```bash
php artisan test
```

Hasil pengujian otomatis: **21 passed (58 assertions)** tanpa kendala.

---

## 📂 Struktur Direktori

```
├── app/
│   ├── Helpers/
│   │   └── FormatHelper.php                  # Helper format Rupiah, tanggal Indo, badge
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AuthController.php            # Login dual portal & register customer
│   │   │   ├── BranchController.php          # Manajemen showroom & Google Maps iframe
│   │   │   ├── CategoryController.php        # Admin CRUD Kategori produk
│   │   │   ├── CustomerController.php        # Dashboard portal pelanggan
│   │   │   ├── DashboardController.php       # Dashboard analitik & ringkasan status
│   │   │   ├── ForgotPasswordController.php  # OTP verification & password reset
│   │   │   ├── HomeManagerController.php     # Kelola konten landing page
│   │   │   ├── LandingController.php         # Landing page publik, katalog & portofolio
│   │   │   ├── PaymentController.php         # Manajemen pembayaran & DP
│   │   │   ├── PelangganController.php       # Sub-modul manajemen data pelanggan
│   │   │   ├── PermissionController.php      # Matriks hak akses staf & level pelanggan
│   │   │   ├── PortfolioController.php       # Admin CRUD data portofolio proyek
│   │   │   ├── ProdukController.php          # CRUD produk, upload gambar & rentang harga
│   │   │   ├── StatusOrderController.php     # Tracking alur status pengerjaan pesanan
│   │   │   └── UserController.php            # Manajemen akun staf & admin internal
│   │   └── Middleware/                       # CheckRole & CheckPermission guards
│   ├── Models/
│   │   ├── ActivityLog.php                   # Model pencatatan log audit
│   │   ├── Branch.php                        # Model showroom cabang & maps iframe
│   │   ├── Category.php                      # Model kategori produk & slug
│   │   ├── Order.php                         # Model pesanan & status constants/badges
│   │   ├── Payment.php                       # Model pembayaran & bukti transfer
│   │   ├── Portfolio.php                     # Model portofolio proyek & foto
│   │   ├── Product.php                       # Model produk & rentang harga
│   │   ├── RolePermission.php                # Model izin berbasis role / level pelanggan
│   │   ├── User.php                          # Model user & helper hak akses
│   │   └── UserPermission.php                # Model izin hak akses per akun staf
│   └── Services/
│       └── ActivityLogService.php            # Service audit logging aktivitas
├── database/
│   ├── migrations/                           # Skema migrasi tabel database
│   └── seeders/
│       ├── DatabaseSeeder.php                # Master database seeder
│       ├── CategoryAndProductSeeder.php      # Seeder kategori & master produk reklame
│       └── PortfolioSeeder.php               # Seeder data awal portofolio proyek
├── public/
│   ├── images/                               # Aset hero & banner visual
│   └── uploads/                              # Direktori upload berkas dinamis
│       ├── categories/                       # Upload cover kategori
│       ├── payments/                         # Upload bukti transfer pembayaran
│       ├── portfolios/                       # Upload foto hasil karya portofolio
│       └── products/                         # Upload foto produk
├── resources/
│   └── views/
│       ├── activity_log/                     # View audit trail log aktivitas
│       ├── akses/                            # View hak akses staf & level pelanggan
│       ├── auth/                             # View login portal, register, OTP
│       ├── branches/                         # View manajemen showroom & maps
│       ├── customer/                         # View dashboard portal pelanggan
│       ├── dashboard.blade.php               # View dashboard analitik admin
│       ├── katalog/                          # View katalog publik (kategori, produk, detail)
│       ├── kategori/                         # View admin kelola kategori
│       ├── layouts/                          # Master layout app & guest
│       ├── pelanggan/                        # View admin sub-modul data pelanggan
│       ├── pembayaran/                       # View admin data pembayaran
│       ├── portfolio/                        # View admin kelola portofolio
│       ├── portofolio.blade.php              # View galeri portofolio publik
│       ├── produk/                           # View admin kelola produk
│       ├── status-order/                     # View admin tracking status order
│       ├── users/                            # View admin manajemen staf & admin
│       └── landing.blade.php                 # Landing page beranda
├── routes/
│   └── web.php                               # Definisi seluruh endpoint & rute aplikasi
└── tests/
    └── Feature/
        └── CatalogAndAdminTest.php           # Test suite katalog, portofolio & admin
```

---

## 📄 Lisensi

Proyek ini dilisensikan di bawah [MIT License](LICENSE).  
© 2026 **Kaligraph Design**. Hak Cipta Dilindungi Undang-Undang.
