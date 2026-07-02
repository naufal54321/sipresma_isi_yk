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
