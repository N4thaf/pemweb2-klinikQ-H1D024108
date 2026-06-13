# KlinikQ — Sistem Antrian & Kunjungan Klinik
Link Youtube: https://youtu.be/6nl7PQ_NO4Y

Aplikasi web untuk pengelolaan antrian pasien dan pencatatan kunjungan klinik secara digital. Dibangun sebagai tugas besar mata kuliah Pemrograman Web 2, Program Studi Informatika, Universitas Jenderal Soedirman.

---

## Informasi Proyek

- Mata Kuliah : Pemrograman Web 2
- Paket Soal  : Paket 8 — Sistem Antrian & Kunjungan Klinik
- Stack Utama : Laravel 13, Livewire 4, Tailwind CSS, MySQL

---

## Fitur Utama

- Autentikasi pengguna dengan dua peran: Admin dan Petugas
- CRUD data poli, dokter, dan pasien
- Pendaftaran antrian pasien per poli dengan nomor antrian otomatis (auto-increment harian)
- Pemanggilan antrian dan perubahan status secara real-time
- Papan antrian digital yang diperbarui otomatis tanpa reload halaman
- Pencatatan kunjungan pasien (keluhan, diagnosis, dokter)
- Upload foto profil dokter
- Dashboard statistik dan grafik kunjungan
- Estimasi waktu tunggu antrian

---

## Kebutuhan Sistem

Sebelum memulai instalasi, pastikan perangkat sudah memiliki:

- PHP 8.3 atau 8.4
- Composer 2.x
- Node.js 18 atau lebih baru dan npm
- MySQL 8 atau MariaDB 10.6+
- Git

---

## Langkah Instalasi

### 1. Clone Repository

```bash
git clone https://github.com/[username]/klinikq.git
cd klinikq
```

Ganti `[username]` dengan username GitHub yang sesuai.

### 2. Install Dependensi PHP

```bash
composer install
```

### 3. Salin File Konfigurasi

```bash
cp .env.example .env
```

### 4. Generate Application Key

```bash
php artisan key:generate
```

### 5. Konfigurasi Database

Buka file `.env` menggunakan teks editor, lalu sesuaikan bagian berikut:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=klinikq
DB_USERNAME=root
DB_PASSWORD=
```

Ganti `DB_USERNAME` dan `DB_PASSWORD` sesuai dengan konfigurasi MySQL di perangkat masing-masing.

### 6. Buat Database

Masuk ke MySQL dan buat database baru:

```sql
CREATE DATABASE klinikq CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

Atau buat melalui phpMyAdmin dengan nama `klinikq`.

### 7. Jalankan Migrasi dan Seeder

```bash
php artisan migrate --seed
```

Perintah ini akan membuat semua tabel dan mengisi data awal secara otomatis, termasuk akun demo, data poli, dokter, dan pasien contoh.

### 8. Buat Symbolic Link Storage

```bash
php artisan storage:link
```

Langkah ini diperlukan agar foto profil dokter dapat ditampilkan di browser.

### 9. Install Dependensi Node dan Build Aset

```bash
npm install
npm run build
```

---

## Menjalankan Aplikasi

```bash
php artisan serve
```

Setelah perintah di atas berjalan, buka browser dan akses:

```
http://localhost:8000
```

---

## Akun Demo

Setelah migrasi dan seeder berhasil, tersedia dua akun untuk pengujian:

| Peran   | Email                    | Password |
|---------|--------------------------|----------|
| Admin   | admin@klinikq.test       | password |
| Petugas | petugas@klinikq.test     | password |

---

## Struktur Direktori Penting

```
app/
  Livewire/          - Komponen Livewire (logika CRUD, antrian, dsb.)
  Models/            - Model Eloquent beserta relasi
database/
  migrations/        - Definisi skema tabel
  seeders/           - Data awal untuk pengujian
resources/
  views/livewire/    - Tampilan Blade tiap komponen
  css/app.css        - Stylesheet utama
routes/
  web.php            - Definisi semua route
```

---

## Catatan Tambahan

- Halaman `/papan-antrian` dapat diakses tanpa login. Halaman ini dirancang untuk ditampilkan di layar monitor ruang tunggu klinik.
- Jika menggunakan XAMPP atau Laragon, pastikan service MySQL sudah aktif sebelum menjalankan `php artisan serve`.
- Jika terjadi error permission pada folder `storage` atau `bootstrap/cache`, jalankan:

```bash
chmod -R 775 storage bootstrap/cache
```

