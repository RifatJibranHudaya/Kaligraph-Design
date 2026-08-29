# 💡 Kaligraph Design — Sistem Manajemen & POS Neon Box / Signage

<p align="center">
  <img src="public/images/neon_box_hero.jpg" alt="Kaligraph Design Banner" width="100%" style="border-radius: 16px; max-height: 400px; object-fit: cover;">
</p>

<p align="center">
  <strong>Solusi Digital Manajemen Bisnis Neon Box, Huruf Timbul & Signage Custom Terintegrasi</strong><br>
  Dibangun dengan framework <strong>Laravel 10</strong>, <strong>MySQL</strong>, dan arsitektur UI bertema <em>Electric Neon Modern</em>.
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-10.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel 10">
  <img src="https://img.shields.io/badge/PHP-8.1+-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP 8.1+">
  <img src="https://img.shields.io/badge/MySQL-8.0+-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL">
  <img src="https://img.shields.io/badge/License-MIT-green?style=for-the-badge" alt="MIT License">
</p>

---

## 📖 Tentang Kaligraph Design

**Kaligraph Design** adalah aplikasi web komprehensif yang dirancang khusus untuk operasional bisnis manufaktur dan penjualan **Neon Box, Huruf Timbul, LED Signage, dan Reklame Visual**.

Aplikasi ini menggabungkan dua ekosistem dalam satu platform:
1. **Frontend Publik & Portal Pelanggan**: Showcase produk berfoto, rentang harga, lokasi showroom dengan peta interaktif Google Maps (Embed Iframe), dan portal khusus pelanggan untuk memantau status pengerjaan pesanan.
2. **Backend Admin & Sistem POS**: Manajemen pesanan kasir, antrean produksi workshop, pencatatan stok material akrilik/LED, operasional harian, manajemen multi-cabang/showroom, dan kontrol hak akses berbasis matriks izin (Permission Matrix).

---

## ✨ Fitur-Fitur Utama

### 1. 🌐 Landing Page Modern (Showcase Neon Box)
- **Hero Section Dinamis**: Menampilkan identitas visual neon box beresolusi tinggi dengan tipografi modern dan CTA order WhatsApp.
- **Katalog Produk Real-Time**: Menampilkan foto produk asli, deskripsi spesifikasi material, dan **rentang harga** (*contoh: Rp 350.000 - Rp 750.000*).
- **Lokasi & Showroom dengan Iframe Maps**: Setiap cabang dilengkapi peta interaktif Google Maps yang di-embed langsung via kode `<iframe>`.
- **Floating WhatsApp Button**: Tombol chat WhatsApp mengambang dengan efek *pulse animation* untuk konsultasi instan.

### 2. 👥 Pemisahan Jalur Login (Dual Login System)
- **Portal Pilihan (`/login`)**: Halaman pemilih visual (*Saya Pelanggan* vs *Saya Staff/Admin*).
- **Portal Pelanggan (`/login/customer` & `/register/customer`)**:
  - Registrasi & login mandiri untuk pelanggan.
  - Akses ke **Dashboard Pelanggan (`/customer/dashboard`)** untuk melihat riwayat order, status pengerjaan, dan katalog.
- **Login Staff / Admin (`/login/admin`)**:
  - Login khusus internal (Superadmin, Owner, Admin, Kasir).
  - Terhubung langsung ke dashboard manajemen POS & workshop.

### 3. 🔐 Forgot Password via OTP Email
- **Request OTP (`/forgot-password`)**: Masukkan email terdaftar untuk meminta kode OTP 6 digit.
- **Template Email HTML Elegan (`OtpMail`)**: Email otomatis dengan desain branding resmi Kaligraph Design.
- **Verifikasi OTP Interaktif (`/forgot-password/verify`)**:
  - 6 kotak digit otomatis berpindah (*auto-advance*) dan mendukung *copy-paste*.
  - **Countdown Timer 10 Menit**.
  - Tombol kirim ulang OTP (*Resend OTP*).
- **Reset Password (`/forgot-password/reset`)**: Form pembaruan kata sandi baru yang aman.

### 4. 📦 Modul Kelola Produk Signage (`/produk`)
- **Upload Foto Produk**: Upload gambar produk (JPG, PNG, WEBP, SVG) dengan *Live Preview*.
- **Rentang Harga (Price Range)**: Pengaturan *Harga Minimum* dan *Harga Maksimum*.
- **Manajemen Status**: Toggle aktif/non-aktifkan produk dari katalog dan kasir.
- **Modal Edit Produk**: Pengeditan instan tanpa refresh halaman.

### 5. 📍 Modul Cabang & Lokasi Showroom (`/branches`)
- **Embed Iframe Google Maps**: Input kode `<iframe>` resmi dari Google Maps atau link embed.
- **Preview Peta Admin**: Menampilkan pratinjau peta langsung di panel admin cabang.
- **Integrasi Landing Page**: Peta otomatis tampil responsif di halaman publik.

### 6. 🛒 Kasir POS (Point of Sale) (`/kasir`)
- Antarmuka kasir cepat berbasis kartu produk dengan thumbnail foto.
- Keranjang belanja interaktif (tambah qty, hapus item, hitung total otomatis).
- Pilihan kategori pesanan (*Dine-in*, *Takeaway*, *Online Order* / *Custom Project*).
- Cetak struk / nota pesanan instan.

### 7. 🏭 Manajemen Produksi & Stok (`/produksi` & `/stok`)
- Pelacakan alur pengerjaan pesanan signage (*Menunggu*, *Proses Desain*, *Cutting & Rangka*, *Perakitan LED*, *Selesai*).
- Pencatatan stok bahan baku (plat akrilik, trafo LED, kabel, pipa galvanis, stiker vinyl).

### 8. 🛡️ Pengguna, Hak Akses Matriks & Log Aktivitas
- **Manajemen Pengguna (`/users`)**: Kelola akun staff, level role, dan penempatan cabang.
- **Matriks Akses (`/akses`)**: Konfigurasi izin CRUD per fitur untuk setiap role secara fleksibel.
- **Log Aktivitas (`/activity-log`)**: Pencatatan audit trail semua tindakan login, CRUD produk, order, dan cabang.

---

## 🛠️ Kebutuhan Sistem

- **PHP**: Versi 8.1 atau lebih tinggi
- **Database**: MySQL 8.0+ / MariaDB 10.4+
- **Web Server**: Apache / Nginx (atau Laragon / XAMPP)
- **Composer**: Versi 2.x
- **Mail Catcher (Lokal)**: Mailpit (tersedia otomatis di Laragon pada port 1025 / UI 8025)

---

## 🚀 Panduan Instalasi & Menjalankan Proyek

### 1. Clone Repositori
```bash
git clone https://github.com/RifatJibranHudaya/Kaligraph-Design.git
cd food-app-laravel
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
Sesuaikan konfigurasi database dan mail di `.env`:
```env
APP_NAME="Kaligraph Design"
APP_URL=http://localhost/food-app-laravel/public

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=food_sales_laravel
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

### 4. Generate Application Key
```bash
php artisan key:generate
```

### 5. Jalankan Migrasi & Seeder Database
```bash
php artisan migrate --seed
```

### 6. Jalankan Server Aplikasi
Jika menggunakan Laragon, aplikasi dapat langsung diakses melalui:
```
http://localhost/food-app-laravel/public/
```
Atau menggunakan artisan serve bawaan:
```bash
php artisan serve
```

---

## 🔑 Kredensial Akun Default

| Role / Level | Username | Email | Password | Hak Akses Utama |
| :--- | :--- | :--- | :--- | :--- |
| **Superadmin** | `admin` | `admin@kaligraphdesign.com` | `admin` | Seluruh Modul & Manajemen Sistem |
| **Owner** | `owner` | `owner@kaligraphdesign.com` | `owner` | Laporan, Multi-Cabang, POS, Produksi |
| **Kasir / Staff** | `kasir` | `kasir@kaligraphdesign.com` | `kasir` | Kasir POS, Riwayat Transaksi |
| **Pelanggan** | *Daftar baru* | *(Email pelanggan)* | *(Password dibuat user)* | Portal Pelanggan & Pelacakan Order |

> **Catatan Pengujian Email OTP:**  
> Untuk melihat email OTP reset password yang dikirimkan secara lokal, buka **Mailpit** bawaan Laragon di browser: [`http://localhost:8025`](http://localhost:8025).

---

## 📂 Struktur Direktori Utama

```
food-app-laravel/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AuthController.php            # Login dual portal & customer register
│   │   │   ├── BranchController.php          # Modul cabang & Google Maps iframe
│   │   │   ├── CustomerController.php        # Portal dashboard pelanggan
│   │   │   ├── DashboardController.php       # Dashboard analitik admin
│   │   │   ├── ForgotPasswordController.php  # Request, verify OTP, & reset password
│   │   │   ├── KasirController.php           # Kasir POS & struk transaksi
│   │   │   ├── LandingController.php         # Landing page publik
│   │   │   ├── ProdukController.php          # CRUD produk, upload foto & rentang harga
│   │   │   └── UserController.php            # Manajemen staf & pengguna
│   │   └── Middleware/                       # Auth & Permission matrix guards
│   ├── Mail/
│   │   └── OtpMail.php                       # Mailable OTP reset password
│   ├── Models/
│   │   ├── Branch.php                        # Model cabang & accessor iframe
│   │   ├── Order.php                         # Model transaksi pesanan
│   │   ├── Product.php                       # Model produk, rentang harga, & foto
│   │   └── User.php                          # Model user, role & customer helper
│   └── Services/
│       └── ActivityLogService.php            # Pencatatan audit trail aktivitas
├── database/
│   ├── migrations/                           # Skema database & tabel OTP
│   └── seeders/
│       ├── DatabaseSeeder.php                # Master seeder
│       └── NeonBoxProductSeeder.php          # Seeder produk neon box & rentang harga
├── public/
│   ├── images/                               # Aset visual hero neon box
│   └── uploads/products/                     # Direktori upload foto produk asli
├── resources/
│   └── views/
│       ├── auth/                             # View portal login, register, OTP
│       ├── branches/                         # View cabang & iframe peta
│       ├── customer/                         # View portal dashboard pelanggan
│       ├── emails/                           # Template HTML email OTP
│       ├── kasir/                            # View kasir POS
│       ├── layouts/                          # Master layout (app & guest)
│       ├── produk/                           # View kelola produk & upload foto
│       └── landing.blade.php                 # Landing page resmi Kaligraph Design
└── routes/
    └── web.php                               # Definisi seluruh endpoint & route
```

---

## 📄 Lisensi

Proyek ini dilisensikan di bawah [MIT License](LICENSE).  
© 2026 **Kaligraph Design**. Hak Cipta Dilindungi Undang-Undang.
