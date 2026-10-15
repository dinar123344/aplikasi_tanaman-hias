RANCANGAN ARSITEKTUR DAN USER APLIKASI SISTEM INFORMASI PENJUALAN TANAMAN HIAS BERBASIS WEB LARAVEL
1. Gambaran Umum
Sistem terdiri dari:
a. Penjualan tanaman hias secara online
b. Manajemen stok tanaman dan perlengkapan tanaman
c. Data pelanggan
d. Transaksi penjualan
e. Cetak invoice / nota
f. Laporan penjualan
g. Manajemen supplier
h. Multi user dengan hak akses berbeda
________________________________________
2. Rancangan Arsitektur Sistem
1. Frontend
(Bagian yang digunakan pengguna dalam berinteraksi dengan sistem)
Teknologi:
•	HTML 
•	CSS 
•	Bootstrap 
•	Blade Template Laravel 
Fitur:
•	Login 
•	Dashboard 
•	Katalog Tanaman 
•	Keranjang Belanja 
•	Form Transaksi 
•	Laporan 
•	Data Pelanggan 
________________________________________
2. Application Layer (Backend Laravel)
Komponen:
•	Controller 
•	Service 
•	Validation 
•	Authentication 
Fungsi:
•	Mengelola transaksi penjualan 
•	Mengatur stok tanaman 
•	Mengelola data produk 
•	Mengelola user dan role 
•	Mengelola laporan penjualan 
________________________________________
3. Data Layer (Database)
Penyimpanan seluruh data sistem.
DBMS: MySQL
Tabel Utama:
•	Users 
•	Pelanggan 
•	Produk Tanaman 
•	Kategori Tanaman 
•	Transaksi 
•	Detail Transaksi 
•	Supplier 
•	Pembayaran 
________________________________________
3. Arsitektur MVC Laravel
a. Model
Mengelola database.
Contoh:
•	Product 
•	Transaction 
•	Customer 
•	Category 
b. View
Tampilan antarmuka pengguna.
Contoh:
•	Halaman Dashboard 
•	Halaman Katalog Tanaman 
•	Halaman Transaksi 
•	Halaman Laporan Penjualan 
c. Controller
Menghubungkan Model dan View.
Contoh:
•	ProductController 
•	TransactionController 
•	ReportController 
•	CustomerController 
________________________________________
4. Rancangan User / Hak Akses Pengguna
a. Admin
Hak Akses
•	Mengelola user 
•	Mengelola produk tanaman 
•	Mengelola supplier 
•	Melihat laporan 
•	Mengatur sistem 
•	Backup data 
Menu
•	Dashboard 
•	Master Data 
•	Produk 
•	Transaksi 
•	Laporan 
•	Pengaturan 
________________________________________
b. Customer
Hak Akses
•	Registrasi dan login akun 
•	Melihat katalog tanaman 
•	Melihat detail produk 
•	Menambahkan produk ke keranjang 
•	Melakukan pemesanan 
•	Melakukan pembayaran 
•	Melihat status pesanan 
•	Mencetak atau mengunduh invoice 
•	Mengelola profil akun 
Menu
•	Beranda 
•	Katalog Tanaman 
•	Keranjang Belanja 
•	Checkout 
•	Riwayat Pesanan 
•	Invoice 
•	Profil Akun

