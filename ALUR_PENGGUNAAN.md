# ALUR PENGGUNAAN WEBSITE PRATAMA

## 1. Alur Publik (Welcome Page)

```
User ╶→ Buka Website (/)
         ↓
    ┌─ Welcome Page ──────────────────────────────────────────────────────┐
    │  • Statistik umum (Total Mahasiswa, SPK Draft/Disetujui)           │
    │  • Chart Prestasi per Prodi                                        │
    │  • Rekap 10 Prestasi Terbaru                                       │
    │  • Chart Tingkat (Universitas/Regional/Nasional/Internasional)     │
    │  • Chart Distribusi Jenis Kegiatan                                 │
    │  • Tren Prestasi Bulanan                                           │
    │  • Top 5 Penyelenggara Kegiatan                                    │
    │  ────────────────────────────────────────────────────────          │
    │  Tombol: [Login] [Dashboard (jika sudah login)]                    │
    └────────────────────────────────────────────────────────────────────┘
         ↓
     [Login] atau [Daftar]
```

---

## 2. Alur Registrasi & Login

```
┌─ REGISTER ─────────────────────────────────────────────────────────────┐
│  Form Registrasi:                                                      │
│  • Nama Lengkap                                                        │
│  • NIM                                                                 │
│  • Program Studi (dropdown)                                            │
│  • Angkatan (dropdown)                                                 │
│  • Semester (dropdown)                                                 │
│  • Email                                                               │
│  • Password + Konfirmasi Password (dengan toggle mata)                 │
│  ﹖ Submit ﹖                                                          │
│  → Sukses: Langsung login + cek email untuk verifikasi                 │
│  → Klik link verifikasi di email → Dashboard terbuka                   │
└────────────────────────────────────────────────────────────────────────┘
         ↓
┌─ LOGIN ────────────────────────────────────────────────────────────────┐
│  Email + Password (dengan toggle mata)                                 │
│  ﹖ Submit ﹖                                                          │
│  → Cek email terverifikasi?                                            │
│     ├─ Belum → Halaman verifikasi (kirim ulang email)                 │
│     └─ Sudah → Masuk ke Dashboard sesuai role                         │
└────────────────────────────────────────────────────────────────────────┘
```

---

## 3. Alur Per Role

### 3A. ADMIN

```
╔══════════════════════════════════════════════════════════════════════╗
║                      DASHBOARD ADMIN                                 ║
║  • Statistik: Total Mahasiswa, Dosen, RPK, SPK                      ║
║  • Chart: Status RPK, Status SPK, Perbandingan Sistem               ║
║  • Chart: Prestasi per Tingkat, Distribusi Jenis Kegiatan           ║
║  • Top 5 Mahasiswa Berprestasi                                       ║
║  • Log Aktivitas Sistem Terbaru                                      ║
╚══════════════════════════════════════════════════════════════════════╝
         │
         ├── MANAJEMEN USER ──────────────────────────────────────────┐
         │  ├─ Daftar Pengguna                                        │
         │  │    → CRUD (Create, Read, Update, Delete)                │
         │  │    → Filter by Role + Search (Nama/NIM/Email/Prodi)     │
         │  │    → Edit data user                                     │
         │  │    → Ubah Role user                                     │
         │  │    → Hapus user                                         │
         │  │                                                         │
         │  ├─ Persetujuan Akun                                       │
         │  │    → List akun baru menunggu approve                    │
         │  │    → Search + Filter Role                               │
         │  │    → Approve (aktifkan akun + kirim email notif)        │
         │  │    → Reject (hapus akun + kirim email notif)            │
         │  │                                                         │
         │  └─ Dosen Pembimbing                                       │
         │       → List mahasiswa                                     │
         │       → Pilih / Ganti / Hapus dosen pembimbing per mhs     │
         └─────────────────────────────────────────────────────────────┘
         │
         ├── MASTER DATA ─────────────────────────────────────────────┐
         │  ├─ Master Kegiatan                                        │
         │  │    → Daftar jenis kegiatan yang tersedia                │
         │  │    → CRUD + Filter (Status Aktif/Tidak Aktif)           │
         │  │                                                         │
         │  ├─ Master Prestasi                                        │
         │  │    → Daftar prestasi (Juara 1, 2, 3, Harapan, dll)     │
         │  │    → CRUD + Is Active (Aktif/Nonaktif)                  │
         │  │    → Tingkat (Universitas, Regional, Nasional, Intern.) │
         │  │                                                         │
         │  └─ Program Studi                                          │
         │       → Daftar prodi                                       │
         │       → CRUD + Toggle Status (Aktif/Tidak Aktif)           │
         │       → Filter by Fakultas & Status                        │
         └─────────────────────────────────────────────────────────────┘
         │
         ├── RPK MAHASISWA (View Only + Override) ───────────────────┐
         │  ├─ List semua RPK mahasiswa                              │
         │  │    → Filter: Search, Status, Dosen Pembimbing          │
         │  │                                                         │
         │  └─ Detail RPK → Approve / Tolak / Kembalikan Draft       │
         │       (Override keputusan dosen pembimbing)                │
         └─────────────────────────────────────────────────────────────┘
         │
         ├── SPK MAHASISWA ──────────────────────────────────────────┐
         │  ├─ List semua SPK                                        │
         │  │    → Filter: Tahun, Status, Search                     │
         │  │                                                         │
         │  ├─ Detail SPK → Approve / Tolak                          │
         │  │                                                         │
         │  └─ Kelola Poin                                            │
         │       → List SPK disetujui tanpa poin / dengan poin       │
         │       → Tambah Poin (input angka poin)                    │
         │       → Edit Poin (ubah poin yang sudah ada)              │
         └─────────────────────────────────────────────────────────────┘
         │
         └── LAPORAN ─────────────────────────────────────────────────┐
            → List SPK yang sudah disetujui + Filter                 │
              • Search (Nama, NIM, Judul, Penyelenggara)             │
              • Tahun, Prodi, Tingkat                                 │
            → Export:                                                 │
              • CSV (.csv)                                            │
              • Excel Multi-Sheet per Fakultas (.xlsx)               │
              • PDF (.pdf)                                            │
            └─────────────────────────────────────────────────────────┘
```

### 3B. DOSEN

```
╔══════════════════════════════════════════════════════════════════════╗
║                     DASHBOARD DOSEN                                  ║
║  • Statistik: Mahasiswa Bimbingan, Draft RPK, Draft SPK             ║
║  • Chart: Komposisi Draft, Perbandingan Data                        ║
║  • Akses Cepat: Verifikasi RPK, SPK, Data Mahasiswa                ║
║  • Progress Bar Validasi                                             ║
╚══════════════════════════════════════════════════════════════════════╝
         │
         ├── MAHASISWA BIMBINGAN ────────────────────────────────────┐
         │  → List mahasiswa bimbingan                               │
         │  → Filter: Search (Nama/NIM/Prodi), Angkatan              │
         │  → Lihat total RPK & SPK per mahasiswa                   │
         └─────────────────────────────────────────────────────────────┘
         │
         ├── RPK ─────────────────────────────────────────────────────┐
         │  ├─ List RPK mahasiswa bimbingan                          │
         │  │    → Filter: Search (Nama/NIM/Status/Tahun/Semester)   │
         │  │                                                         │
         │  └─ Detail RPK                                             │
         │       → Lihat daftar kegiatan + anggota kelompok           │
         │       → Setujui (dengan catatan)                          │
         │       → Tolak (dengan catatan wajib)                      │
         └─────────────────────────────────────────────────────────────┘
         │
         ├── SPK ─────────────────────────────────────────────────────┐
         │  ├─ List SPK mahasiswa bimbingan                          │
         │  │    → Filter: Search, Tahun, Status                     │
         │  │                                                         │
         │  └─ Detail SPK                                             │
         │       → Lihat file upload (Surat Tugas, Sertifikat, dll)  │
         │       → Setujui (dengan catatan)                          │
         │       → Tolak (dengan catatan wajib)                      │
         └─────────────────────────────────────────────────────────────┘
         │
         └── LAPORAN ─────────────────────────────────────────────────┐
            → List SPK disetujui milik bimbingan + Filter            │
              • Search, Tahun, Fakultas, Prodi, Tingkat               │
            → Export: CSV / Excel Multi-Sheet / PDF                   │
            └─────────────────────────────────────────────────────────┘
```

### 3C. MAHASISWA

```
╔══════════════════════════════════════════════════════════════════════╗
║                   DASHBOARD MAHASISWA                                ║
║  • Info Dosen Pembimbing                                            ║
║  • Statistik: RPK/SPK Draft, Disetujui, Total Poin, % Disetujui    ║
║  • Chart: Status Kegiatan, Prestasi per Tingkat                    ║
║  • Chart: Distribusi Jenis Kegiatan, Aktivitas Per Bulan            ║
║  • Kegiatan Terbaru (5 terakhir)                                   ║
╚══════════════════════════════════════════════════════════════════════╝
         │
         ├── RPK (Rencana Prestasi Kemahasiswaan) ────────────────────┐
         │  │                                                         │
         │  ├─ 1. BUAT RPK                                           │
         │  │     → Isi: Tahun + Semester                             │
         │  │     → Submit → Status: DRAFT                            │
         │  │                                                         │
         │  ├─ 2. TAMBAH KEGIATAN (Di dalam RPK)                    │
         │  │     → Pilih Master Kegiatan                             │
         │  │     → Judul Kegiatan                                    │
         │  │     → Tanggal Mulai - Tanggal Selesai (datepicker)      │
         │  │     → Kategori:                                         │
         │  │       ├─ Individu → Langsung simpan                    │
         │  │       └─ Kelompok → Pilih Peran (Ketua/Anggota)        │
         │  │                   → Tambah Jumlah Anggota               │
         │  │     → Submit → Status: DRAFT                             │
         │  │                                                         │
         │  ├─ 3. EDIT / HAPUS KEGIATAN                              │
         │  │     → Hanya bisa jika status RPK masih DRAFT/DITOLAK    │
         │  │                                                         │
         │  └─ 4. LIHAT STATUS                                       │
         │       → Draft: Menunggu validasi dosen                     │
         │       → Disetujui: Sudah divalidasi, bisa buat SPK         │
         │       → Ditolak: Perlu revisi sesuai catatan dosen         │
         │                                                           │
         ├── SPK (Sertifikat Prestasi Kegiatan) ─────────────────────┐
         │  │                                                         │
         │  ├─ 1. BUAT SPK                                           │
         │  │     → Pilih RPK (status harus DISETUJUI)                │
         │  │     → Pilih Kegiatan                                   │
         │  │     → Penyelenggara Kegiatan                            │
         │  │     → Kategori (Individu/Kelompok)                     │
         │  │     → Prestasi yang diraih (dari Master Prestasi)      │
         │  │     → Upload File (WAJIB):                              │
         │  │       • Surat Tugas (PDF, max 5MB)                     │
         │  │       • Sertifikat / Foto Piala (PDF/JPG/PNG, max 5MB) │
         │  │       • Foto Penyerahan Piagam (JPG/PNG, max 5MB)      │
         │  │       • Laporan (PDF, max 5MB)                         │
         │  │     → Judul Karya/Inovasi/Riset/Prestasi               │
         │  │     → Biografi/Latar Belakang                          │
         │  │     → Rincian Inovasi                                  │
         │  │     → Kebaruan/Keunggulan                              │
         │  │     → URL Kegiatan + Link Google Drive                 │
         │  │     → Submit → Status: DRAFT                            │
         │  │                                                         │
         │  ├─ 2. EDIT SPK                                           │
         │  │     → Hanya jika status DRAFT/DITOLAK                   │
         │  │     → Upload ulang file jika perlu                     │
         │  │                                                         │
         │  ├─ 3. HAPUS SPK                                          │
         │  │     → Hanya jika status DRAFT/DITOLAK                   │
         │  │     → File upload ikut terhapus                        │
         │  │                                                         │
         │  └─ 4. LIHAT STATUS                                        │
         │       → Draft: Menunggu validasi dosen                     │
         │       → Disetujui: Sudah divalidasi, poin bisa di-entry    │
         │       → Ditolak: Perlu revisi sesuai catatan dosen         │
         └─────────────────────────────────────────────────────────────┘
```

---

## 4. Alur Validasi (End-to-End)

```
╔══════════════════════════════════════════════════════════════════════════════════╗
║                            FLOW VALIDASI                                        ║
╠══════════════════════╦══════════════════╦═══════════════════════════════════════╣
║     MAHASISWA       ║      DOSEN       ║              ADMIN                    ║
╠══════════════════════╬══════════════════╬═══════════════════════════════════════╣
║                      ║                  ║                                       ║
║  Buat RPK            ║                  ║                                       ║
║  (Draft)             ║                  ║                                       ║
║       │              ║                  ║                                       ║
║       └─────────────►║                  ║                                       ║
║                      ║  Review RPK      ║                                       ║
║                      ║  Setujui/Tolak   ║                                       ║
║                      ║       │          ║                                       ║
║  ◄───────────────────║───────┘          ║                                       ║
║                      ║                  ║                                       ║
║  RPK Disetujui       ║                  ║                                       ║
║       │              ║                  ║                                       ║
║       ▼              ║                  ║                                       ║
║  Buat SPK            ║                  ║                                       ║
║  (Upload File)       ║                  ║                                       ║
║  (Draft)             ║                  ║                                       ║
║       │              ║                  ║                                       ║
║       └─────────────►║                  ║                                       ║
║                      ║  Review SPK      ║                                       ║
║                      ║  Setujui/Tolak   ║                                       ║
║                      ║       │          ║                                       ║
║  ◄───────────────────║───────┘          ║                                       ║
║                      ║                  ║                                       ║
║  SPK Disetujui       ║                  ║                                       ║
║                      ║                  ║                                       ║
║                      ║                  ║  Kelola Poin                          ║
║                      ║                  ║  Tambah/Edit Poin                     ║
║                      ║                  ║  (setelah SPK disetujui)              ║
╚══════════════════════╩══════════════════╩═══════════════════════════════════════╝
```

---

## 5. Status & Transisi

```
┌──────────┐      Mahasiswa Tambah      ┌──────────┐
│          │      Kegiatan / Buat SPK   │          │
│  DRAFT   │◄───────────────────────────│  DITOLAK │
│          │                           │          │
└────┬─────┘                           └────┬─────┘
     │                                      ▲
     │  Dosen/Admin Approve                  │  Dosen/Admin Tolak
     ▼                                      │
┌──────────┐                                │
│          │────────────────────────────────┘
│DISETUJUI│
│          │
└──────────┘
     │
     ▼
  (Admin Tambah/Edit Poin)
```

---

## 6. Fitur Per Role

| Fitur | Admin | Dosen | Mahasiswa |
|---|---|---|---|
| Dashboard | ✅ | ✅ | ✅ |
| Edit Profile | ✅ | ✅ | ✅ |
| Ganti Password | ✅ | ✅ | ✅ |
| Hapus Akun | ✅ | ✅ | ✅ |
| Manajemen User (CRUD) | ✅ | ❌ | ❌ |
| Persetujuan Akun Baru | ✅ | ❌ | ❌ |
| Atur Dosen Pembimbing | ✅ | ❌ | ❌ |
| Master Kegiatan (CRUD) | ✅ | ❌ | ❌ |
| Master Prestasi (CRUD) | ✅ | ❌ | ❌ |
| Program Studi (CRUD) | ✅ | ❌ | ❌ |
| RPK Mahasiswa (Override) | ✅ | ✅ (bimbingan) | ✅ (punya sendiri) |
| SPK Mahasiswa (Override) | ✅ | ✅ (bimbingan) | ✅ (punya sendiri) |
| Kelola Poin | ✅ | ❌ | ❌ |
| Mahasiswa Bimbingan | ❌ | ✅ | ❌ |
| Tambah Kegiatan | ❌ | ❌ | ✅ |
| Upload File SPK | ❌ | ❌ | ✅ |
| Tambah Anggota Kelompok | ❌ | ❌ | ✅ |
| Laporan Export CSV/Excel/PDF | ✅ | ✅ (bimbingan) | ❌ |
| Notifikasi Email Approve | ✅ | ❌ | ❌ |

---

## 7. Teknologi

| Komponen | Teknologi |
|---|---|
| Framework | Laravel 12 |
| Database | MySQL |
| CSS | Tailwind CSS + Vite |
| Frontend JS | Alpine.js + Fetch SPA |
| Charts | Chart.js + Flatpickr |
| Export | PhpSpreadsheet, DomPDF, OpenSpout |
| Auth | Spatie Laravel Permission |
| Notifikasi | Laravel Mail + SweetAlert2 |
