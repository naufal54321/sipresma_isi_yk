# 📘 PANDUAN PENGGUNA WEBSITE PRATAMA

**PRESTASI DAN TALENTA MAHASISWA**
**Institut Seni Indonesia Yogyakarta**

Versi: 1.0 | Terakhir diperbarui: Juli 2026

---

## DAFTAR ISI

1. [Pendahuluan](#1-pendahuluan)
2. [Memulai](#2-memulai)
3. [Registrasi & Login](#3-registrasi--login)
4. [Beranda (Welcome Page)](#4-beranda-welcome-page)
5. [Dashboard](#5-dashboard)
6. [Role: Mahasiswa](#6-role-mahasiswa)
   - 6.1 RPK (Rencana Prestasi Kemahasiswaan)
   - 6.2 SPK (Sertifikat Prestasi Kegiatan)
   - 6.3 Status & Alur Validasi
7. [Role: Dosen](#7-role-dosen)
   - 7.1 Dashboard Dosen
   - 7.2 Mahasiswa Bimbingan
   - 7.3 Verifikasi RPK
   - 7.4 Verifikasi SPK
   - 7.5 Laporan
8. [Role: Admin](#8-role-admin)
   - 8.1 Dashboard Admin
   - 8.2 Manajemen User
   - 8.3 Persetujuan Akun
   - 8.4 Dosen Pembimbing
   - 8.5 Master Data
   - 8.6 RPK Mahasiswa
   - 8.7 SPK Mahasiswa
   - 8.8 Kelola Poin
   - 8.9 Laporan & Export
9. [Status & Alur Validasi](#9-status--alur-validasi)
10. [FAQ & Troubleshooting](#10-faq--troubleshooting)

---

## 1. PENDAHULUAN

### 1.1 Tentang PRATAMA

PRATAMA (Prestasi dan Talenta Mahasiswa) adalah sistem informasi berbasis web untuk mengelola pencatatan prestasi mahasiswa di Institut Seni Indonesia Yogyakarta. Sistem ini memungkinkan mahasiswa mencatat rencana kegiatan dan prestasi mereka, dosen memverifikasi, dan admin mengelola seluruh data.

### 1.2 Fitur Utama

| Fitur | Mahasiswa | Dosen | Admin |
|---|---|---|---|
| Dashboard Statistik | ✅ | ✅ | ✅ |
| RPK (Rencana Prestasi) | ✅ | ✅ (verifikasi) | ✅ (override) |
| SPK (Sertifikat Prestasi) | ✅ | ✅ (verifikasi) | ✅ (override) |
| Upload File (PDF, JPG, PNG) | ✅ | ✅ | ✅ |
| Tambah Anggota Kelompok | ✅ | ❌ | ❌ |
| Master Data | ❌ | ❌ | ✅ |
| Kelola Poin | ❌ | ❌ | ✅ |
| Laporan Export | ❌ | ✅ | ✅ |
| Persetujuan Akun | ❌ | ❌ | ✅ |

### 1.3 Aktor Pengguna

| Role | Deskripsi |
|---|---|
| **Mahasiswa** | Mencatat rencana kegiatan (RPK) dan mengajukan sertifikat prestasi (SPK) |
| **Dosen** | Memverifikasi RPK dan SPK mahasiswa bimbingan |
| **Admin** | Mengelola master data, user, dan memiliki kewenangan override validasi |

---

## 2. MEMULAI

### 2.1 Akses Website

Buka browser (Chrome, Edge, Firefox) dan akses alamat website PRATAMA.

### 2.2 Browser yang Didukung

| Browser | Versi Minimal |
|---|---|
| Google Chrome | 90+ |
| Microsoft Edge | 90+ |
| Mozilla Firefox | 88+ |
| Safari (macOS) | 14+ |

### 2.3 Resolusi Layar

- **Desktop:** 1366×768 atau lebih besar (optimal)
- **Tablet:** 768×1024 (responsif)
- **Mobile:** 360×640 (responsif, beberapa fitur terbatas)

---

## 3. REGISTRASI & LOGIN

### 3.1 Registrasi Akun Baru

1. Buka halaman utama website
2. Klik **"Daftar"** atau masuk ke halaman register
3. Isi formulir pendaftaran:

| Field | Keterangan |
|---|---|
| Nama Lengkap | Nama sesuai dokumen resmi |
| NIM | Nomor Induk Mahasiswa |
| Program Studi | Pilih dari dropdown prodi aktif |
| Angkatan | Tahun masuk kuliah |
| Semester | Semester saat ini |
| Email | Email aktif (untuk verifikasi & notifikasi) |
| Password | Minimal 6 karakter |
| Konfirmasi Password | Ketik ulang password |

4. Klik **"Daftar"**
5. Tunggu persetujuan dari Admin (notifikasi email akan dikirim jika admin mengirim email)

### 3.2 Login

1. Masukkan **Email** dan **Password**
2. Klik **"Masuk"** (tombol akan menampilkan loading spinner)
3. Jika email belum diverifikasi, sistem akan mengarahkan ke halaman verifikasi
4. Cek email untuk link verifikasi, klik link tersebut
5. Setelah email terverifikasi, login kembali

### 3.3 Lupa Password

1. Di halaman login, klik **"Lupa Password?"**
2. Masukkan email terdaftar
3. Cek email untuk link reset password
4. Buat password baru
5. Login dengan password baru

### 3.4 Logout

Klik ikon profil di pojok kanan atas → **"Keluar"**

---

## 4. BERANDA (WELCOME PAGE)

Halaman beranda menampilkan statistik publik yang bisa diakses tanpa login:

- **Statistik Cards:** Total Mahasiswa, SPK Draft/Disetujui, Mahasiswa Berprestasi
- **Chart Statistik Prodi:** Bar chart jumlah prestasi per program studi
- **Rekap Prestasi Terbaru:** 10 prestasi terakhir yang disetujui
- **Chart Prestasi Berdasarkan Tingkat:** Universias, Regional, Nasional, Internasional
- **Chart Distribusi Jenis Kegiatan:** Doughnut chart jenis kegiatan
- **Chart Tren Bulanan:** Line chart tren prestasi 12 bulan terakhir
- **Chart Top Penyelenggara:** Bar chart 5 penyelenggara terbanyak

---

## 5. DASHBOARD

Setiap role memiliki dashboard yang berbeda:

| Role | Komponen Dashboard |
|---|---|
| **Admin** | Statistik user, chart status RPK/SPK, top 5 mahasiswa, log aktivitas |
| **Dosen** | Statistik bimbingan, chart komposisi draft, progress bar validasi |
| **Mahasiswa** | Info dosen pembimbing, statistik poin, chart aktivitas bulanan |

Dashboard dapat diakses setelah login dengan mengklik **"Beranda"** di sidebar.

---

## 6. ROLE: MAHASISWA

### 6.1 RPK (Rencana Prestasi Kemahasiswaan)

RPK adalah dokumen rencana kegiatan yang akan diikuti mahasiswa dalam satu semester.

#### 6.1.1 Membuat RPK Baru

1. Di sidebar, klik **"RPK"**
2. Klik **"Tambah RPK"**
3. Isi:
   - **Tahun:** Tahun akademik (contoh: 2026)
   - **Semester:** Ganjil atau Genap
4. Klik **"Simpan"**
5. RPK akan muncul dengan status **Draft**

#### 6.1.2 Menambah Kegiatan ke dalam RPK

1. Klik pada RPK yang sudah dibuat
2. Klik **"Tambah Kegiatan"**
3. Isi formulir kegiatan:

| Field | Keterangan |
|---|---|
| Nama Kegiatan | Pilih dari master kegiatan yang sudah disediakan |
| Judul Kegiatan | Judul spesifik kegiatan Anda |
| Tanggal Mulai | Klik untuk memilih tanggal (datepicker) |
| Tanggal Selesai | Klik untuk memilih tanggal selesai |
| Kategori | Pilih **Individu** atau **Kelompok** |

4. Jika kategori **Kelompok**:
   - Pilih **Peran**: Ketua atau Anggota
   - Jika **Ketua**: tentukan **Jumlah Anggota**
5. Klik **"Simpan"**
6. Kegiatan akan muncul di daftar kegiatan

#### 6.1.3 Edit / Hapus Kegiatan

- **Edit:** Klik tombol edit pada kegiatan (hanya bisa jika status RPK masih **Draft** atau **Ditolak**)
- **Hapus:** Klik tombol hapus pada kegiatan (hanya bisa jika status RPK masih **Draft** atau **Ditolak**)

#### 6.1.4 Status RPK

| Status | Arti | Bisa Diedit? |
|---|---|---|
| **Draft** | Masih dikerjakan, belum divalidasi | ✅ Ya |
| **Disetujui** | Sudah divalidasi dosen/admin | ❌ Tidak |
| **Ditolak** | Ditolak, perlu revisi | ✅ Ya |

### 6.2 SPK (Sertifikat Prestasi Kegiatan)

SPK adalah dokumen sertifikat/bukti prestasi yang sudah diikuti.

#### 6.2.1 Prasyarat Membuat SPK

- RPK dengan status **Disetujui** harus sudah ada
- Kegiatan dalam RPK harus sudah terisi

#### 6.2.2 Membuat SPK Baru

1. Di sidebar, klik **"SPK"**
2. Klik **"Tambah SPK"**
3. Isi form lengkap:

**Data Dasar:**
| Field | Keterangan |
|---|---|
| Tahun | Tahun kegiatan |
| RPK | Pilih RPK yang sudah disetujui |
| Kegiatan | Pilih kegiatan dari RPK |
| Penyelenggara | Nama penyelenggara kegiatan |
| Kategori | Individu / Kelompok |
| Prestasi | Pilih prestasi yang diraih |

**Upload File (Wajib):**
| File | Format | Maks |
|---|---|---|
| Surat Tugas | PDF | 5 MB |
| Sertifikat / Foto Piala | PDF, JPG, JPEG, PNG | 5 MB |
| Foto Penyerahan Piagam | JPG, JPEG, PNG | 5 MB |
| Laporan | PDF | 5 MB |

**Informasi Tambahan:**
| Field | Wajib? |
|---|---|
| URL Kegiatan | ✅ Wajib (URL valid) |
| Link Google Drive | ✅ Wajib (URL valid) |
| Judul Karya/Inovasi/Riset | ✅ Wajib |
| Biografi/Latar Belakang | Optional |
| Rincian Inovasi/Riset | Optional |
| Kebaruan/Keunggulan | Optional |

4. Klik **"Simpan"**
5. SPK akan muncul dengan status **Draft**

#### 6.2.3 Edit SPK

1. Klik tombol edit pada SPK
2. Ubah data yang diperlukan
3. Upload ulang file jika ada perubahan
4. Klik **"Simpan"**

> ⚠️ Hanya bisa diedit jika status **Draft** atau **Ditolak**

#### 6.2.4 Hapus SPK

- Klik tombol hapus pada SPK
- Konfirmasi penghapusan
- File upload ikut terhapus

> ⚠️ Hanya bisa dihapus jika status **Draft** atau **Ditolak**

### 6.3 Status & Alur Validasi Mahasiswa

```
Buat RPK/Draft
      │
      ▼
Tambah Kegiatan
      │
      ▼  (Otomatis dikirim ke dosen pembimbing)
Dosen / Admin Review
      │
      ├── Disetujui → Bisa buat SPK
      │                   │
      │                   ▼
      │              Upload File → Draft → Dosen/Admin Review
      │                              │
      │                              ├── Disetujui → Admin entry poin
      │                              │
      │                              └── Ditolak → Revisi
      │
      └── Ditolak → Perbaiki sesuai catatan
```

---

## 7. ROLE: DOSEN

### 7.1 Dashboard Dosen

Setelah login, dosen akan melihat dashboard dengan:
- Jumlah mahasiswa bimbingan
- Jumlah draft RPK dan SPK yang menunggu verifikasi
- Progress bar validasi
- Chart komposisi draft

### 7.2 Mahasiswa Bimbingan

1. Di sidebar, klik **"Mahasiswa Bimbingan"**
2. Lihat daftar mahasiswa bimbingan dengan total RPK dan SPK masing-masing
3. Filter: Cari berdasarkan nama/NIM, filter angkatan

### 7.3 Verifikasi RPK

1. Di sidebar, klik **"Validasi → RPK"**
2. Lihat daftar RPK mahasiswa bimbingan
3. Filter: Cari, tahun, semester, status
4. Klik pada RPK untuk melihat detail kegiatan
5. Klik **"Setujui"** atau **"Tolak"**

**Menyetujui RPK:**
- Masukkan catatan (opsional)
- Klik **"Setujui"**
- Status berubah menjadi **Disetujui**
- SweetAlert konfirmasi muncul

**Menolak RPK:**
- Masukkan alasan penolakan (wajib)
- Klik **"Tolak"**
- Status berubah menjadi **Ditolak**
- Mahasiswa bisa melihat catatan dan merevisi

### 7.4 Verifikasi SPK

1. Di sidebar, klik **"Validasi → SPK"**
2. Lihat daftar SPK mahasiswa bimbingan
3. Filter: Cari, tahun, status
4. Klik pada SPK untuk melihat detail + file upload
5. Klik **"Setujui"** atau **"Tolak"**

### 7.5 Laporan

1. Di sidebar, klik **"Laporan"**
2. Filter laporan: Cari, tahun, fakultas, prodi, tingkat
3. Export:
   - **CSV:** Data mentah dalam format csv
   - **Excel:** Multi-sheet per fakultas dengan warna berbeda
   - **PDF:** Format landscape siap cetak

---

## 8. ROLE: ADMIN

### 8.1 Dashboard Admin

Setelah login, admin akan melihat dashboard dengan:
- Statistik total mahasiswa, dosen, RPK, SPK
- Chart status RPK dan SPK
- Perbandingan data sistem
- Prestasi berdasarkan tingkat
- Top 5 mahasiswa berprestasi
- Log aktivitas sistem terbaru

### 8.2 Manajemen User

1. Di sidebar, klik **"Daftar Pengguna"**
2. **Tambah User:** Klik **"Tambah"**, isi form, pilih role
3. **Edit User:** Klik ikon edit pada user
4. **Ubah Role:** Klik ikon role pada user
5. **Hapus User:** Klik ikon hapus (konfirmasi)

### 8.3 Persetujuan Akun

1. Di sidebar, klik **"Persetujuan Akun"** (menu khusus admin)
2. Lihat daftar akun yang menunggu persetujuan
3. **Setujui:** Klik **"Setujui"** → akun aktif
4. **Tolak:** Klik **"Tolak"** → akun dihapus
5. Opsi kirim email notifikasi ke user

### 8.4 Dosen Pembimbing

1. Di sidebar, klik **"Dosen Pembimbing"**
2. Lihat daftar mahasiswa tanpa dosen pembimbing
3. Klik **"Atur Pembimbing"** pada mahasiswa
4. Pilih dosen dari dropdown
5. Klik **"Simpan"**

### 8.5 Master Data

#### 8.5.1 Master Kegiatan

1. Di sidebar, klik **"Master Kegiatan"**
2. **Tambah:** Nama kegiatan + status (aktif/tidak aktif)
3. **Edit/Ubah Status:** Klik aksi pada kegiatan
4. **Hapus:** Dengan konfirmasi

#### 8.5.2 Master Prestasi

1. Di sidebar, klik **"Master Prestasi"**
2. **Tambah:** Juara + tingkat + status aktif
3. **Edit:** Ubah data prestasi
4. **Hapus:** Nonaktifkan (tidak benar-benar hapus)

#### 8.5.3 Program Studi

1. Di sidebar, klik **"Master Prodi"**
2. **Tambah:** Nama prodi + fakultas + status
3. **Toggle Status:** Aktif/Tidak Aktif
4. **Edit/Hapus:** Sesuai kebutuhan

### 8.6 RPK Mahasiswa

1. Di sidebar, klik **"RPK"**
2. Lihat semua RPK seluruh mahasiswa
3. Filter: Search, status, dosen pembimbing
4. Klik detail untuk melihat kegiatan
5. **Override Validasi:** Setujui / Tolak / Kembalikan ke Draft

### 8.7 SPK Mahasiswa

1. Di sidebar, klik **"SPK"**
2. Lihat semua SPK seluruh mahasiswa
3. Filter: Tahun, status, search
4. Klik detail untuk melihat file upload
5. **Approve / Tolak:** Sama seperti dosen

### 8.8 Kelola Poin

1. Di sidebar, klik **"SPK → Kelola Poin"**
2. Lihat daftar SPK yang sudah disetujui
3. **Tambah Poin:** Klik **"Tambah Poin"** pada SPK yang belum punya poin
4. **Edit Poin:** Klik **"Edit Poin"** pada SPK yang sudah punya poin
5. Poin otomatis tercatat ke mahasiswa

### 8.9 Laporan & Export

1. Di sidebar, klik **"Laporan"**
2. Filter: Search, tahun, prodi, tingkat
3. Pilih format export:

| Format | File | Kegunaan |
|---|---|---|
| CSV | `.csv` | Data mentah untuk diolah di Excel/Spreadsheet |
| Excel | `.xlsx` | Multi-sheet per fakultas dengan warna header berbeda |
| PDF | `.pdf` | Format landscape siap cetak |

---

## 9. STATUS & ALUR VALIDASI

### 9.1 Diagram Status

```
┌──────────┐      Dibuat/disimpan      ┌──────────┐
│          │◄───────────────────────────│          │
│  DRAFT   │      Revisi setelah tolak  │ DITOLAK  │
│          │───────────────────────────►│          │
└────┬─────┘                            └──────────┘
     │
     │  Dosen/Admin menyetujui
     ▼
┌──────────┐
│DISETUJUI │
│          │
└──────────┘
     │
     ▼
  Admin entry poin
```

### 9.2 Tabel Status

| Status | Background | Arti | Aksi Mahasiswa | Aksi Dosen/Admin |
|---|---|---|---|---|
| **Draft** | 🟠 Orange | Belum divalidasi | Bisa edit/hapus | Bisa setujui/tolak |
| **Disetujui** | 🟢 Hijau | Sudah divalidasi | Lihat saja | Tidak bisa diubah |
| **Ditolak** | 🔴 Merah | Perlu revisi | Bisa edit ulang | Bisa setujui/tolak |

---

## 10. FAQ & TROUBLESHOOTING

### 10.1 Saya lupa password. Bagaimana cara reset?

Di halaman login, klik **"Lupa Password?"**, masukkan email terdaftar, dan ikuti instruksi di email.

### 10.2 Kenapa saya tidak bisa login setelah registrasi?

Akun baru harus disetujui oleh Admin terlebih dahulu. Silakan hubungi Admin atau tunggu email notifikasi persetujuan.

### 10.3 File upload SPK gagal. Kenapa?

Periksa:
- Format file sesuai ketentuan (PDF/JPG/PNG)
- Ukuran file maksimal 5 MB per file
- Koneksi internet stabil
- Nama file tidak mengandung karakter khusus

### 10.4 Kenapa chart di dashboard tidak muncul?

Chart akan muncul setelah ada data yang disetujui. Jika chart tetap tidak muncul, coba refresh halaman (F5).

### 10.5 Saya tidak bisa edit RPK/SPK. Kenapa?

RPK/SPK dengan status **Disetujui** tidak bisa diedit. Hanya status **Draft** atau **Ditolak** yang bisa diedit.

### 10.6 Bagaimana cara melihat catatan dosen?

Buka detail RPK atau SPK, catatan dosen akan ditampilkan di halaman detail.

### 10.7 Kenapa saya tidak bisa memilih kegiatan tertentu?

Pastikan:
- Kegiatan aktif di master data Admin
- RPK yang dipilih sudah disetujui
- Kegiatan sesuai dengan RPK yang dipilih

### 10.8 Apakah data aman?

Ya. Sistem menggunakan:
- CSRF protection untuk semua form
- Authentication untuk akses data
- Role-based access control
- Password di-hash menggunakan bcrypt

---

> **PRATAMA v1.0** — Prestasi dan Talenta Mahasiswa
> Institut Seni Indonesia Yogyakarta
> UPA TIK ISI Yogyakarta
