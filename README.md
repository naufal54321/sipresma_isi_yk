
# PRATAMA - Prestasi dan Talenta Mahasiswa

<div align="center">


**Institut Seni Indonesia Yogyakarta**

[![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=flat&logo=laravel)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=flat&logo=php)](https://php.net)
[![TailwindCSS](https://img.shields.io/badge/TailwindCSS-3.x-06B6D4?style=flat&logo=tailwindcss)](https://tailwindcss.com)
[![Alpine.js](https://img.shields.io/badge/Alpine.js-3.x-8BC0D0?style=flat&logo=alpine.js)](https://alpinejs.dev)
[![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=flat&logo=mysql)](https://mysql.com)

</div>

---

## 📖 Tentang

**PRATAMA** (Prestasi dan Talenta Mahasiswa) adalah platform digital yang dikembangkan untuk **Institut Seni Indonesia Yogyakarta** guna mengelola dan memonitor prestasi mahasiswa secara terintegrasi. Sistem ini memfasilitasi mahasiswa dalam mengajukan Rencana Prestasi Kegiatan (RPK) dan Sertifikat Prestasi Kegiatan (SPK), serta memudahkan Dosen Pembimbing dan Admin dalam melakukan verifikasi, validasi, dan monitoring.

---

## ✨ Fitur Utama

### 👨‍🎓 Mahasiswa
| Fitur | Deskripsi |
|-------|-----------|
| **Registrasi** | Pendaftaran dengan NIM, Prodi, Angkatan, Semester |
| **RPK** | Membuat dan mengelola Rencana Prestasi Kegiatan |
| **SPK** | Membuat dan mengelola Sertifikat Prestasi Kegiatan |
| **Upload** | Upload dokumen pendukung (Surat Tugas, Sertifikat, Foto, Laporan) |
| **Dashboard** | Statistik pribadi dengan grafik interaktif |

### 👨‍🏫 Dosen Pembimbing
| Fitur | Deskripsi |
|-------|-----------|
| **Dashboard** | Statistik mahasiswa bimbingan dengan grafik |
| **Verifikasi RPK** | Menyetujui/menolak RPK mahasiswa bimbingan |
| **Verifikasi SPK** | Menyetujui/menolak SPK mahasiswa bimbingan |
| **Monitoring** | Melihat data dan progres mahasiswa bimbingan |

### 👑 Admin
| Fitur | Deskripsi |
|-------|-----------|
| **Manajemen User** | CRUD pengguna dengan role Admin, Dosen, Mahasiswa |
| **Ploting Dosen** | Mengatur dosen pembimbing untuk mahasiswa |
| **Master Data** | Kelola Kegiatan, Prestasi, Program Studi |
| **Verifikasi** | Persetujuan RPK dan SPK |
| **Poin** | Menambahkan poin pada SPK yang disetujui |
| **Laporan** | Export data dalam format PDF/Excel |

---

## 🛠️ Teknologi

| Teknologi | Versi | Keterangan |
|-----------|-------|------------|
| **Laravel** | 12.x | Backend Framework |
| **PHP** | 8.2+ | Bahasa Pemrograman |
| **TailwindCSS** | 3.x | Utility-first CSS Framework |
| **Alpine.js** | 3.x | Minimal JavaScript Framework |
| **MySQL** | 8.0 | Database |
| **Spatie Permission** | 6.x | Role & Permission Management |
| **SweetAlert2** | 11.x | Interactive Alert Dialogs |
| **Chart.js** | 4.x | Chart & Graph Visualization |
| **Flatpickr** | 4.x | Date Picker |
| **Font Awesome** | 6.x | Icon Library |

---

## 📋 Persyaratan Sistem

- **PHP** 8.2 atau lebih tinggi
- **Composer** 2.x
- **MySQL** 8.0+ / MariaDB 10.3+
- **Node.js** 18+ & NPM (untuk asset building)

---

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
DB_DATABASE=sipresma
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

Akses di browser: **http://localhost:8000**

---

## 👥 Role & Akses

| Role | URL | Akses |
|------|-----|-------|
| **Admin** | `/admin` | Manajemen penuh sistem |
| **Dosen** | `/dosen` | Verifikasi mahasiswa bimbingan |
| **Mahasiswa** | `/dashboard` | Pengajuan RPK & SPK |

---

## 📊 Alur Kerja

```
Mahasiswa membuat RPK → Dosen/Admin verifikasi RPK
                              ↓
Mahasiswa membuat SPK → Dosen/Admin verifikasi SPK
                              ↓
                         Admin tambah Poin
```

---

## 🧪 Testing

```bash
php artisan test
```

---

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
│   ├── images/
│   └── storage/
├── resources/
│   └── views/
│       ├── admin/
│       ├── dashboard/
│       ├── dosen/
│       ├── mahasiswa/
│       │   ├── rpks/
│       │   ├── spks/
│       │   └── kegiatans/
│       └── layouts/
├── routes/
│   └── web.php
├── tests/
│   ├── Feature/
│   └── Unit/
└── storage/
    └── app/public/
```

---

## 🔧 Perintah Berguna

```bash
# Clear cache
php artisan optimize:clear

# Refresh database
php artisan migrate:fresh --seed

# Run tests
php artisan test

# Check routes
php artisan route:list

# Check Laravel version
php artisan --version

# Storage link
php artisan storage:link
```

---

## 📝 Catatan Penting

- **Email Verification**: Mahasiswa harus verifikasi email sebelum akses dashboard
- **Dosen Bimbingan**: Dosen hanya melihat data mahasiswa bimbingannya
- **Poin SPK**: Admin menambahkan poin pada SPK yang sudah disetujui
- **File Upload**: Maksimal 5MB (PDF, JPG, PNG)
- **Status**: Draft → Disetujui/Ditolak

---

## 🎨 Fitur UI/UX

- **Full AJAX**: Operasi CRUD tanpa reload halaman
- **SweetAlert2**: Notifikasi dan konfirmasi interaktif
- **Chart.js**: Grafik statistik di dashboard
- **Flatpickr**: Date picker untuk rentang tanggal
- **Responsive Design**: Optimal di desktop dan mobile
- **Glassmorphism**: Efek glass modern di welcome page
- **Animasi**: Fade, slide, scale, float di seluruh halaman
- **Motif Batik**: Ornamen tradisional Indonesia di hero section

---

## 📄 Lisensi

Proyek ini dikembangkan untuk **UPA TIK Institut Seni Indonesia Yogyakarta**.

---

<div align="center">
Made with ❤️ for ISI Yogyakarta
</div>
```
