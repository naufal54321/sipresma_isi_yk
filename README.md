<p align="center">
  <h1 align="center">SIPRESMA</h1>
  <p align="center">Sistem Informasi Prestasi Mahasiswa - Institut Seni Indonesia Yogyakarta</p>
</p>

<p align="center">
  <a href=""><img src="https://img.shields.io/badge/Framework-Laravel-FF2D20?style=for-the-badge&logo=laravel" alt="Laravel"></a>
  <a href=""><img src="https://img.shields.io/badge/Frontend-Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css" alt="Tailwind CSS"></a>
  <a href=""><img src="https://img.shields.io/badge/Database-MySQL-4479A1?style=for-the-badge&logo=mysql" alt="MySQL"></a>
</p>

## 📌 Tentang SIPRESMA

**SIPRESMA** (Sistem Informasi Prestasi Mahasiswa) adalah aplikasi berbasis web yang dikembangkan untuk memfasilitasi pencatatan, pengelolaan, dan validasi data prestasi akademik maupun non-akademik mahasiswa di lingkungan **Institut Seni Indonesia (ISI) Yogyakarta**. 

Aplikasi ini dirancang untuk mempermudah alur birokrasi pengajuan prestasi (seperti RPK/SPK) dari mahasiswa hingga divalidasi oleh Dosen dan dikelola oleh Admin Institusi, secara digital dan terpusat.

## ✨ Fitur Utama

- **Multi-Role Access**: Sistem otentikasi dengan hak akses yang berbeda untuk **Mahasiswa**, **Dosen**, dan **Admin**.
- **Pengelolaan Data Prestasi**: Pengajuan, validasi, dan pengarsipan sertifikat atau bukti prestasi.
- **Sistem Keamanan Akun**: Terintegrasi dengan fitur Verifikasi Email wajib dan Reset Password berbasis SMTP (Gmail).
- **Notifikasi Cerdas**: Menggunakan notifikasi email otomatis dan *Toast* interaktif (SweetAlert2) untuk setiap tindakan (perubahan profil, update password, dll).
- **Manajemen Profil**: Halaman khusus bagi pengguna untuk memperbarui data diri, program studi, dan keamanan kata sandi.

## 🛠️ Teknologi yang Digunakan

- **Backend**: Laravel Framework (PHP)
- **Frontend**: Blade Templating, Tailwind CSS, Alpine.js
- **Database**: MySQL
- **Dependencies**: SweetAlert2 (Notifikasi UI), FontAwesome (Ikon)

## 🚀 Panduan Instalasi (Development)

Ikuti langkah-langkah di bawah ini untuk menjalankan project SIPRESMA di *local environment* Anda.

### Prasyarat
Pastikan komputer Anda sudah terinstal:
- PHP >= 8.2
- Composer
- Node.js & NPM
- MySQL / MariaDB

### Langkah Instalasi

1. **Clone Repository**
   ```bash
   git clone [https://github.com/username-anda/nama-repo-anda.git](https://github.com/username-anda/nama-repo-anda.git)
   cd nama-repo-anda

```

2. **Install Dependencies PHP & Node**
```bash
composer install
npm install

```


3. **Konfigurasi Environment**
Duplikat file `.env.example` menjadi `.env`:
```bash
cp .env.example .env

```


Buka file `.env` dan sesuaikan koneksi database serta konfigurasi SMTP Email Anda:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sipresma_db
DB_USERNAME=root
DB_PASSWORD=

# Konfigurasi SMTP (Wajib untuk fitur Verifikasi & Reset Password)
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=email_anda@gmail.com
MAIL_PASSWORD=app_password_gmail_anda
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=email_anda@gmail.com
MAIL_FROM_NAME="${APP_NAME}"

```


4. **Generate Application Key**
```bash
php artisan key:generate

```


5. **Migrasi Database & Seeder** (Menyiapkan tabel dan data *default* seperti Roles)
```bash
php artisan migrate --seed

```


6. **Jalankan Server Lokal**
Buka dua tab terminal. Di terminal pertama, jalankan *asset bundler*:
```bash
npm run dev

```


Di terminal kedua, jalankan server Laravel:
```bash
php artisan serve

```


Aplikasi kini dapat diakses melalui `http://127.0.0.1:8000`.

## 🔒 Keamanan (Security Vulnerabilities)

Jika Anda menemukan celah keamanan dalam sistem ini, mohon untuk tidak membukanya ke publik. Silakan laporkan langsung melalui kontak **UPA TIK ISI Yogyakarta**.

## 📄 Hak Cipta & Lisensi

Dikembangkan oleh **UPA TIK Institut Seni Indonesia Yogyakarta**.
Hak Cipta Dilindungi © 2026.

```

```
