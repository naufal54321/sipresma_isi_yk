
# SIPRESMA - Sistem Informasi Prestasi Mahasiswa

<div align="center">


**Institut Seni Indonesia Yogyakarta**

[![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=flat&logo=laravel)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=flat&logo=php)](https://php.net)
[![TailwindCSS](https://img.shields.io/badge/TailwindCSS-3.x-06B6D4?style=flat&logo=tailwindcss)](https://tailwindcss.com)
[![Tests](https://img.shields.io/badge/Tests-9%20Passed-brightgreen?style=flat)]()

</div>

---

## 📖 Tentang

SIPRESMA adalah sistem informasi yang digunakan untuk mengelola prestasi mahasiswa di Institut Seni Indonesia Yogyakarta. Sistem ini memfasilitasi mahasiswa dalam mengajukan Rencana Prestasi Kegiatan (RPK) dan Sertifikat Prestasi Kegiatan (SPK), serta memudahkan Dosen Pembimbing dalam melakukan verifikasi dan validasi.

## ✨ Fitur Utama

### 👨‍🎓 Mahasiswa
- Registrasi dengan data lengkap (NIM, Prodi, Angkatan, Semester)
- Membuat dan mengelola RPK (Rencana Prestasi Kegiatan)
- Membuat dan mengelola SPK (Sertifikat Prestasi Kegiatan)
- Upload dokumen pendukung (Surat Tugas, Sertifikat, Foto, Laporan)
- Melihat status verifikasi RPK dan SPK
- Dashboard dengan statistik pribadi

### 👨‍🏫 Dosen Pembimbing
- Dashboard dengan statistik mahasiswa bimbingan
- Verifikasi dan validasi RPK mahasiswa
- Verifikasi dan validasi SPK mahasiswa
- Melihat data mahasiswa bimbingan
- Grafik dan chart untuk monitoring

### 👑 Admin
- Manajemen pengguna (CRUD)
- Ploting dosen pembimbing
- Master data (Kegiatan, Prestasi, Program Studi)
- Persetujuan RPK dan SPK
- Penambahan poin prestasi
- Laporan dan statistik

## 🛠️ Teknologi

| Teknologi | Versi |
|-----------|-------|
| **Laravel** | 12.x |
| **PHP** | 8.2+ |
| **TailwindCSS** | 3.x |
| **Alpine.js** | 3.x |
| **MySQL** | 5.7+ |
| **Spatie Permission** | 6.x |
| **SweetAlert2** | 11.x |
| **Chart.js** | 4.x |
| **Flatpickr** | 4.x |
| **Pest PHP** | 3.x |

## 📋 Persyaratan

- PHP 8.2 atau lebih tinggi
- Composer 2.x
- MySQL 5.7+ / SQLite 3.x
- Node.js & NPM (untuk asset building)

## 🚀 Instalasi

### 1. Clone Repository

```bash
git clone https://github.com/your-username/sipresma.git
cd sipresma
```

### 2. Install Dependencies

```bash
composer install
npm install && npm run build
```

### 3. Konfigurasi Environment

```bash
cp .env.example .env
php artisan key:generate
```

### 4. Konfigurasi Database

Edit file `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=latihan_sipresma
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Migration & Seeder

```bash
php artisan migrate
php artisan db:seed
```

### 6. Storage Link

```bash
php artisan storage:link
```

### 7. Jalankan Aplikasi

```bash
php artisan serve
```

Akses di browser: `http://localhost:8000`

## 👥 Role & Akses

| Role | Dashboard | Akses |
|------|-----------|-------|
| **Admin** | `/admin` | Manajemen penuh sistem |
| **Dosen** | `/dosen` | Verifikasi mahasiswa bimbingan |
| **Mahasiswa** | `/dashboard` | Pengajuan RPK & SPK |

### Akun Default (Seeder)

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@isi.ac.id | password |
| Dosen | dosen@isi.ac.id | password |
| Mahasiswa | mahasiswa@isi.ac.id | password |

## 📊 Status RPK & SPK

| Status | Keterangan |
|--------|------------|
| `draft` | Menunggu Validasi |
| `disetujui` | Telah diverifikasi dan disetujui |
| `ditolak` | Ditolak dengan catatan perbaikan |

## 🧪 Testing

```bash
php artisan test
```

Hasil test terbaru:
```
Tests:    9 passed (13 assertions)
Duration: 1.07s
```

### Daftar Test:

| # | Test | Status |
|---|------|--------|
| 1 | `Unit\ExampleTest` | ✅ |
| 2 | `Feature\ExampleTest` | ✅ |
| 3 | `Feature\Auth\LoginTest` | ✅ |
| 4 | `Feature\ProdiTest` - create | ✅ |
| 5 | `Feature\ProdiTest` - view | ✅ |
| 6 | `Feature\RpkTest` - create | ✅ |
| 7 | `Feature\RpkTest` - dashboard | ✅ |
| 8 | `Feature\UserTest` - create | ✅ |
| 9 | `Feature\UserTest` - assign role | ✅ |

## 📁 Struktur Folder

```
sipresma/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── Admin/
│   │       ├── Auth/
│   │       └── ...
│   └── Models/
├── database/
│   ├── migrations/
│   └── seeders/
├── public/
│   └── images/
├── resources/
│   └── views/
│       ├── admin/
│       │   ├── spk/
│       │   ├── rpk/
│       │   └── daftar_pengguna/
│       ├── dashboard/
│       ├── dosen/
│       ├── spks/
│       └── rpks/
├── routes/
│   └── web.php
├── tests/
│   ├── Feature/
│   └── Unit/
└── storage/
    └── app/public/
```

## 🔧 Perintah Berguna

```bash
# Clear all cache
php artisan optimize:clear

# Refresh database dengan seed
php artisan migrate:fresh --seed

# Run all tests
php artisan test

# Run specific test
php artisan test --filter=RpkTest

# Check all routes
php artisan route:list

# Check Laravel version
php artisan --version

# Run Laravel Pint (code formatter)
./vendor/bin/pint
```

## 📝 Catatan Penting

- **Email Verification**: Mahasiswa harus verifikasi email sebelum mengakses dashboard
- **Dosen Bimbingan**: Dosen hanya dapat melihat data mahasiswa bimbingannya
- **Poin SPK**: Admin dapat menambahkan poin pada SPK yang sudah disetujui
- **File Upload**: Maksimal 5MB per file
- **Format File**: PDF, JPG, PNG
- **AJAX**: Semua operasi CRUD menggunakan AJAX tanpa reload halaman

## 🎨 Fitur Tambahan

- **Full AJAX**: Tambah, edit, hapus tanpa reload halaman
- **SweetAlert2**: Notifikasi dan konfirmasi interaktif
- **Chart.js**: Grafik statistik di dashboard
- **Flatpickr**: Date picker untuk rentang tanggal
- **Responsive Design**: Tampilan optimal di desktop dan mobile
- **Motif Batik**: Tema tradisional Indonesia di hero section

## 📄 Lisensi

Proyek ini dikembangkan untuk **Institut Seni Indonesia Yogyakarta**.

---

<div align="center">
Made with for ISI Yogyakarta
</div>
```
