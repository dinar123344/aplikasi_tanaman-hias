# 🌿 Sistem Informasi Penjualan Tanaman Hias

Aplikasi web penjualan tanaman hias berbasis **Laravel 13** dengan fitur manajemen produk, pemesanan, pembayaran, dan laporan penjualan.

---

## 📋 Persyaratan Sistem

| Software | Versi Minimum |
|----------|--------------|
| PHP | >= 8.4.1 |
| Composer | >= 2.x |
| MySQL | >= 8.0 |
| Node.js | >= 20.19 |
| NPM | >= 9.x |

> **⚠️ PENTING - Laragon PATH Setup:**
> Terminal PowerShell/CMD Laragon mungkin menggunakan PHP & Node.js versi lama.
> Pastikan switch ke versi yang benar sebelum menjalankan command apapun:

**Cara 1: Switch via Laragon GUI (Recommended)**
1. Klik kanan icon Laragon di system tray
2. **PHP** → Pilih `php-8.5.4-Win32-vs17-x64`
3. **Node.js** → Pilih `node-v24.14.1-win-x64`
4. **Restart Laragon** agar PATH terminal terupdate

**Cara 2: Set PATH Manual di Terminal (per session)**
```powershell
$env:Path = "C:\laragon\bin\php\php-8.5.4-Win32-vs17-x64;C:\laragon\bin\nodejs\node-v24.14.1-win-x64;$env:Path"
```

Verifikasi versi:
```powershell
php -v    # Harus >= 8.4.1
node -v   # Harus >= 20.19
```

---

## 🚀 Cara Menjalankan Project

### 1. Clone Repository

```bash
git clone <repository-url>
cd aplikasi_tanaman
```

### 2. Install Dependencies

```bash
composer install
npm install
```

### 3. Konfigurasi Environment

Salin file `.env.example` menjadi `.env`:

```bash
cp .env.example .env
```

Edit file `.env` dan sesuaikan konfigurasi database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tanaman_hias
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Generate Application Key

```bash
php artisan key:generate
```

### 5. Buat Database

Buat database MySQL bernama `tanaman_hias`:

```bash
mysql -u root -e "CREATE DATABASE IF NOT EXISTS tanaman_hias CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
```

Atau buat manual melalui **phpMyAdmin** / **HeidiSQL** di Laragon.

### 6. Jalankan Migration & Seeder

```bash
php artisan migrate
php artisan db:seed
```

Ini akan membuat **7 tabel** dan mengisi data awal (admin, customer, kategori).

### 7. Jalankan Aplikasi

```bash
# Cara 1: Jalankan semua service sekaligus
composer dev

# Cara 2: Jalankan manual satu per satu
php artisan serve        # Backend di http://localhost:8000
npm run dev              # Frontend (Vite)
```

Buka browser dan akses: **http://localhost:8000**

---

## 🔐 Akun Default

| Role | Email | Password |
|------|-------|----------|
| **Admin** | `admin@tanaman.com` | `password` |
| **Customer** | `customer@tanaman.com` | `password` |

---

## 🗄️ Struktur Database

Aplikasi menggunakan **7 tabel** utama:

```
users            → Data login (admin/customer)
customers        → Profil pelanggan (1:1 → users)
categories       → Kategori tanaman
products         → Produk tanaman hias (N:1 → categories)
orders           → Pesanan (N:1 → customers)
order_items      → Detail item pesanan (N:1 → orders, N:1 → products)
payments         → Pembayaran (1:1 → orders)
```

### ERD (Entity Relationship Diagram)

```
┌──────────┐ 1    1 ┌────────────┐ 1    N ┌──────────┐
│  users   │────────│ customers  │────────│  orders  │
└──────────┘        └────────────┘        └────┬─────┘
                                               │ 1
                    ┌────────────┐         ┌───┴──────┐
                    │ categories │         │order_items│
                    └─────┬──────┘         └───┬──────┘
                        1 │                  N │
                        N │                  N │
                    ┌─────┴──────┐             │
                    │  products  │─────────────┘
                    └────────────┘
                                          ┌──────────┐
                    orders 1 ──────── 1   │ payments │
                                          └──────────┘
```

---

## 📁 Struktur Project

```
aplikasi_tanaman/
├── app/
│   ├── Models/
│   │   ├── User.php
│   │   ├── Customer.php
│   │   ├── Category.php
│   │   ├── Product.php
│   │   ├── Order.php
│   │   ├── OrderItem.php
│   │   └── Payment.php
│   └── Http/
│       └── Controllers/
├── database/
│   ├── migrations/          # File migration semua tabel
│   └── seeders/
│       └── DatabaseSeeder.php
├── resources/
│   └── views/               # Blade templates
├── routes/
│   └── web.php              # Routing aplikasi
├── public/                  # Assets publik
└── .env                     # Konfigurasi environment
```

---

## 🛠️ Perintah Artisan Berguna

```bash
# Reset database (hapus semua tabel, migrate ulang, seed ulang)
php artisan migrate:fresh --seed

# Buat controller baru
php artisan make:controller NamaController --resource

# Buat model baru dengan migration
php artisan make:model NamaModel -m

# Cek status migration
php artisan migrate:status

# Bersihkan cache
php artisan optimize:clear

# Jalankan testing
php artisan test
```

---

## 📝 Teknologi yang Digunakan

- **Backend:** Laravel 13 (PHP 8.3+)
- **Frontend:** Blade Template, Bootstrap, CSS
- **Database:** MySQL 8.0
- **Build Tool:** Vite
- **DBMS Tool:** Laragon

---

## 📄 Lisensi

Project ini dibuat untuk keperluan tugas/proyek Sistem Informasi Penjualan Tanaman Hias.
