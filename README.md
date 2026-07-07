
# SIPRESMA - Sistem Informasi Prestasi Mahasiswa

<div align="center">

![SIPRESMA](public/images/logo_isi_dashboard.png)

**Institut Seni Indonesia Yogyakarta**

[![Laravel](https://img.shields.io/badge/Laravel-11.x-FF2D20?style=flat&logo=laravel)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2-777BB4?style=flat&logo=php)](https://php.net)
[![TailwindCSS](https://img.shields.io/badge/TailwindCSS-3.x-06B6D4?style=flat&logo=tailwindcss)](https://tailwindcss.com)
[![Tests](https://img.shields.io/badge/Tests-9%20Passed-brightgreen?style=flat)](https://github.com/your-repo)

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

- **Backend**: Laravel 11.x
- **Frontend**: TailwindCSS, Alpine.js
- **Database**: MySQL / SQLite
- **Authentication**: Laravel Breeze
- **Authorization**: Spatie Laravel Permission
- **Icons**: Font Awesome
- **Alerts**: SweetAlert2
- **Charts**: Chart.js
- **Date Picker**: Flatpickr
- **Testing**: Pest PHP

## 📋 Persyaratan

- PHP 8.2 atau lebih tinggi
- Composer
- MySQL 5.7+ atau SQLite
- Node.js & NPM (opsional)

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
| Admin | admin@example.com | password |
| Dosen | dosen@example.com | password |
| Mahasiswa | mahasiswa@example.com | password |

## 📊 Status RPK & SPK

| Status | Keterangan |
|--------|------------|
| `draft` | Masih dalam proses pengisian |
| `disetujui` | Telah diverifikasi |
| `ditolak` | Ditolak dengan catatan |

## 🧪 Testing

```bash
php artisan test
```

Hasil test terbaru:
```
Tests:    9 passed (13 assertions)
Duration: 1.07s
```

## 📁 Struktur Folder

```
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
├── resources/
│   └── views/
│       ├── admin/
│       ├── dashboard/
│       ├── dosen/
│       ├── spks/
│       └── rpks/
├── routes/
│   └── web.php
└── tests/
    ├── Feature/
    └── Unit/
```

## 🔧 Perintah Berguna

```bash
# Clear cache
php artisan optimize:clear

# Refresh database
php artisan migrate:fresh --seed

# Run tests
php artisan test

# Run specific test
php artisan test --filter=RpkTest

# Check routes
php artisan route:list
```

## 📝 Catatan

- Mahasiswa harus verifikasi email sebelum mengakses dashboard
- Dosen hanya dapat melihat data mahasiswa bimbingannya
- Admin dapat menambahkan poin pada SPK yang sudah disetujui
- File upload maksimal 5MB
- Format file yang didukung: PDF, JPG, PNG

## 📄 Lisensi

Proyek ini dikembangkan untuk **Institut Seni Indonesia Yogyakarta**.

---

<div align="center">
Made with ❤️ for ISI Yogyakarta
</div>
```

README.md sudah siap! 🎉
