# ⚙️ Dokumentasi Teknis — PRATAMA

> **Prestasi dan Talenta Mahasiswa** — Institut Seni Indonesia Yogyakarta
>
> Versi: 1.0 | Terakhir diperbarui: Agustus 2026

---

## 📋 Daftar Isi

1. [Arsitektur Aplikasi](#1-arsitektur-aplikasi)
2. [Tech Stack](#2-tech-stack)
3. [Struktur Folder](#3-struktur-folder)
4. [Models & Relationships](#4-models--relationships)
5. [Services](#5-services)
6. [Controllers](#6-controllers)
7. [Middleware & Role-based Access Control](#7-middleware--role-based-access-control)
8. [Caching Strategy](#8-caching-strategy)
9. [File Upload Handling](#9-file-upload-handling)
10. [Email Notifications](#10-email-notifications)
11. [Export System](#11-export-system)
12. [AJAX Response Pattern](#12-ajax-response-pattern)
13. [Frontend Architecture](#13-frontend-architecture)
14. [Setup & Deployment](#14-setup--deployment)
15. [Testing](#15-testing)

---

## 1. Arsitektur Aplikasi

Aplikasi PRATAMA mengikuti pola **MVC (Model-View-Controller)** dengan tambahan **Service Pattern** untuk logika bisnis yang kompleks.

```
Request
    │
    ▼
┌─────────────────┐
│   Middleware    │ ← Auth, Verified, Role
└─────────────────┘
    │
    ▼
┌─────────────────┐
│  Controller     │ ← Menangani request, validasi, otorisasi
└─────────────────┘
    │
    ├──► Service   │ ← Logika bisnis (DashboardService, LaporanService)
    │
    ├──► Model     │ ← Eloquent ORM (User, Rpk, Spk, Kegiatan, dll)
    │
    └──► View      │ ← Blade Template (resources/views/)
    │
    ▼
Response (HTML / JSON / File Download)
```

### Design Patterns yang Digunakan

| Pattern | Implementasi |
|---------|-------------|
| **MVC** | Laravel default (Model, View, Controller) |
| **Service** | `DashboardService`, `LaporanService` — memisahkan logika bisnis dari controller |
| **Repository (implisit)** | Query langsung di controller/service menggunakan Eloquent |
| **Factory** | `UserFactory` untuk testing |
| **Middleware** | Auth, Verified, Role-based access control |
| **Observer (implisit)** | Model events (created, updated, deleted) di `ProgramStudi` |

---

## 2. Tech Stack

### Backend

| Teknologi | Versi | Keterangan |
|-----------|-------|------------|
| **Laravel** | 12.x | Backend Framework |
| **PHP** | 8.2+ | Bahasa Pemrograman |
| **MySQL** | 8.0+ | Database |
| **Spatie Permission** | 7.4 | Role & Permission Management |
| **PhpSpreadsheet** | 5.8 | Excel export |
| **barryvdh/laravel-dompdf** | 3.1 | PDF export |
| **Laravel Breeze** | 2.4 | Auth scaffolding |

### Frontend

| Teknologi | Versi | Keterangan |
|-----------|-------|------------|
| **TailwindCSS** | 3.x | Utility-first CSS Framework |
| **Alpine.js** | 3.x | Minimal JavaScript Framework |
| **Vite** | 5.x | Asset bundler |
| **Chart.js** | 4.x | Chart & Graph Visualization |
| **Flatpickr** | 4.x | Date Picker |
| **SweetAlert2** | 11.x | Interactive Alert Dialogs |
| **Font Awesome** | 6.x | Icon Library |
| **Material Symbols** | — | Google Material Icons |

### Development Tools

| Tool | Versi | Keterangan |
|------|-------|------------|
| **Laravel Pint** | 1.24 | Code formatter (PSR-12) |
| **Laravel Pail** | 1.2.2 | Log viewer |
| **Laravel IDE Helper** | 3.7 | IDE autocomplete |
| **PHPUnit/Pest** | 3.8 | Testing framework |
| **Mockery** | 1.6 | Mocking library |

---

## 3. Struktur Folder

```
pratama/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Controller.php          # Base controller
│   │   │   ├── DashboardController.php # Dashboard (role-based)
│   │   │   ├── ProfileController.php   # Profile management
│   │   │   ├── Admin/                  # Admin controllers
│   │   │   │   ├── UserController.php
│   │   │   │   ├── UserRoleController.php
│   │   │   │   ├── ProgramStudiController.php
│   │   │   │   ├── RpkController.php
│   │   │   │   ├── SpkController.php
│   │   │   │   └── LaporanController.php
│   │   │   ├── Dosen/                  # Dosen controllers
│   │   │   │   ├── RpkController.php
│   │   │   │   ├── SpkController.php
│   │   │   │   ├── MahasiswaController.php
│   │   │   │   └── LaporanController.php
│   │   │   ├── Mahasiswa/              # Mahasiswa controllers
│   │   │   │   ├── RpkController.php
│   │   │   │   ├── KegiatanController.php
│   │   │   │   └── SpkController.php
│   │   │   └── Auth/                   # Auth controllers (Breeze)
│   │   ├── Middleware/
│   │   └── Requests/
│   ├── Mail/
│   │   ├── RpkSubmitted.php
│   │   ├── RpkStatusNotification.php
│   │   ├── SpkSubmitted.php
│   │   ├── SpkStatusNotification.php
│   │   ├── SpkApprovedAdmin.php
│   │   └── PlottingMahasiswa.php
│   ├── Models/
│   │   ├── User.php
│   │   ├── Rpk.php
│   │   ├── Spk.php
│   │   ├── Kegiatan.php
│   │   └── ProgramStudi.php
│   ├── Services/
│   │   ├── DashboardService.php
│   │   └── LaporanService.php
│   ├── Providers/
│   └── View/
├── bootstrap/
├── config/
├── database/
│   ├── migrations/
│   ├── seeders/
│   └── factories/
├── frontend-html/
├── lang/
├── public/
│   ├── build/          # Vite built assets
│   └── images/         # Static images
├── resources/
│   ├── css/
│   ├── js/
│   ├── views/
│   │   ├── admin/
│   │   ├── dosen/
│   │   ├── mahasiswa/
│   │   ├── dashboard/
│   │   ├── emails/
│   │   ├── auth/
│   │   ├── welcome.blade.php
│   │   ├── statistik.blade.php
│   │   ├── kontak.blade.php
│   │   └── sitemap.blade.php
│   └── lang/
├── routes/
│   ├── web.php
│   └── auth.php
├── storage/
├── tests/
├── docs/               # 📚 Dokumentasi (file ini)
├── composer.json
├── package.json
├── vite.config.js
├── tailwind.config.js
├── .env.example
└── README.md
```

---

## 4. Models & Relationships

### 4.1 User Model

**File:** `app/Models/User.php`

**Deskripsi:** Model pengguna dengan role-based access control menggunakan Spatie Permission.

**Fillable:**
```php
protected $fillable = [
    'name', 'email', 'password', 'nim', 'prodi',
    'angkatan', 'semester', 'dosen_pembimbing_id',
    'status', 'is_approved', 'email_verified_at',
];
```

**Casts:**
```php
protected function casts(): array
{
    return [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_approved' => 'boolean',
    ];
}
```

**Scopes:**
| Scope | Deskripsi |
|-------|-----------|
| `scopeAngkatan($query, $angkatan)` | Filter berdasarkan angkatan |
| `scopeSemester($query, $semester)` | Filter berdasarkan semester |
| `scopeMahasiswa($query)` | Filter hanya mahasiswa |
| `scopeMahasiswaBimbingan($query, $dosenId)` | Filter mahasiswa bimbingan |

**Relationships:**
| Method | Tipe | Model | Keterangan |
|--------|------|-------|------------|
| `rpks()` | HasMany | Rpk | RPK milik pengguna |
| `spks()` | HasMany | Spk | SPK milik pengguna |
| `mahasiswaBimbingan()` | HasMany | User | Mahasiswa yang dibimbing (self-referential) |
| `dosenPembimbing()` | BelongsTo | User | Dosen pembimbing (self-referential) |
| `kegiatanAnggota()` | BelongsToMany | Kegiatan | Kegiatan sebagai anggota (via `kegiatan_user`) |
| `programStudi()` | BelongsTo | ProgramStudi | Relasi ke program studi (via `prodi` → `nama_prodi`) |

**Traits:**
- `HasFactory` — Factory untuk testing
- `Notifiable` — Notifikasi email
- `HasRoles` — Spatie Permission role management

---

### 4.2 Rpk Model

**File:** `app/Models/Rpk.php`

**Deskripsi:** Model Rencana Prestasi Kemahasiswaan.

**Fillable:**
```php
protected $fillable = [
    'user_id', 'tahun', 'semester',
    'status', 'catatan_dosen', 'verified_by', 'verified_at',
];
```

**Relationships:**
| Method | Tipe | Model | Keterangan |
|--------|------|-------|------------|
| `user()` | BelongsTo | User | Pemilik RPK |
| `kegiatans()` | HasMany | Kegiatan | Kegiatan dalam RPK |
| `spks()` | HasMany | Spk | SPK dari RPK |
| `verifiedBy()` | BelongsTo | User | User yang memverifikasi |

---

### 4.3 Spk Model

**File:** `app/Models/Spk.php`

**Deskripsi:** Model Sertifikat Prestasi Kegiatan.

**Fillable:**
```php
protected $fillable = [
    'user_id', 'rpk_id', 'kegiatan_id', 'tahun', 'tanggal_kegiatan',
    'penyelenggara', 'kategori', 'judul_kegiatan',
    'poin', 'url_kegiatan', 'link_drive',
    'surat_tugas', 'sertifikat', 'foto_penyerahan', 'laporan',
    'judul_karya', 'biografi', 'rincian', 'kebaruan',
    'status', 'catatan_dosen', 'verified_by', 'verified_at',
    'poin_added_at', 'poin_added_by',
];
```

**Scopes:**
| Scope | Deskripsi |
|-------|-----------|
| `scopeDisetujui($query)` | Filter SPK dengan status disetujui |
| `scopeDenganPoin($query)` | Filter SPK dengan poin > 0 |
| `scopeTanpaPoin($query)` | Filter SPK tanpa poin |

**Methods:**
| Method | Deskripsi |
|--------|-----------|
| `hasPoin()` | Cek apakah SPK sudah memiliki poin |

**Relationships:**
| Method | Tipe | Model | Keterangan |
|--------|------|-------|------------|
| `user()` | BelongsTo | User | Pemilik SPK |
| `rpk()` | BelongsTo | Rpk | RPK terkait |
| `kegiatan()` | BelongsTo | Kegiatan | Kegiatan terkait |
| `poinAddedBy()` | BelongsTo | User | Admin yang menambahkan poin |
| `verifiedBy()` | BelongsTo | User | User yang memverifikasi |

---

### 4.4 Kegiatan Model

**File:** `app/Models/Kegiatan.php`

**Deskripsi:** Model kegiatan dalam RPK.

**Fillable:**
```php
protected $fillable = [
    'rpk_id', 'kkm_rule_id', 'kegiatan', 'judul_kegiatan',
    'tanggal_mulai', 'tanggal_selesai', 'kategori', 'peran', 'jumlah_anggota',
];
```

**Casts:**
```php
protected $casts = [
    'tanggal_mulai' => 'date',
    'tanggal_selesai' => 'date',
];
```

**Accessors:**
| Accessor | Deskripsi |
|----------|-----------|
| `getTanggalRangeAttribute()` | Format rentang tanggal (misal: "15 Jan 2025 - 17 Jan 2025") |
| `getDurasiHariAttribute()` | Durasi kegiatan dalam hari |

**Relationships:**
| Method | Tipe | Model | Keterangan |
|--------|------|-------|------------|
| `rpk()` | BelongsTo | Rpk | RPK tempat kegiatan ini |
| `user()` | BelongsTo | User | User yang membuat |
| `spks()` | HasMany | Spk | SPK dari kegiatan |
| `kkmRule()` | BelongsTo | KkmRule | Aturan KKM terkait |
| `anggota()` | BelongsToMany | User | Anggota kelompok (via `kegiatan_user`, with pivot `peran`) |

---

### 4.5 ProgramStudi Model

**File:** `app/Models/ProgramStudi.php`

**Deskripsi:** Master program studi dengan fakultas.

**Fillable:**
```php
protected $fillable = ['nama_prodi', 'fakultas', 'status'];
```

**Appends:**
```php
protected $appends = ['is_active', 'status_badge'];
```

**Accessors:**
| Accessor | Deskripsi |
|----------|-----------|
| `getIsActiveAttribute()` | Cek apakah prodi aktif |
| `getStatusBadgeAttribute()` | HTML badge status |

**Mutators:**
| Mutator | Deskripsi |
|---------|-----------|
| `setNamaProdiAttribute($value)` | Auto-capitalize nama prodi |

**Scopes:**
| Scope | Deskripsi |
|-------|-----------|
| `scopeActive($query)` | Filter prodi aktif |
| `scopeInactive($query)` | Filter prodi tidak aktif |
| `scopeSearch($query, $search)` | Cari berdasarkan nama |
| `scopeFilterByStatus($query, $status)` | Filter berdasarkan status |

**Methods:**
| Method | Deskripsi |
|--------|-----------|
| `isActive()` | Cek apakah prodi aktif |
| `canBeDeleted()` | Cek apakah prodi bisa dihapus |
| `toggleStatus()` | Toggle status aktif/tidak aktif |
| `getMahasiswaCount()` | Hitung jumlah mahasiswa (return 0, belum diimplementasi) |

---

## 5. Services

### 5.1 DashboardService

**File:** `app/Services/DashboardService.php`

**Deskripsi:** Service untuk mengelola logika bisnis dashboard per role.

**Methods:**

| Method | Role | Deskripsi |
|--------|------|-----------|
| `clearAdminCache()` | Static | Clear semua cache admin (stats, tingkat, kategori) |
| `getAdminStats()` | Admin | Statistik: total mahasiswa, dosen, RPK, SPK (draft/disetujui/ditolak) |
| `getAdminTingkatChart()` | Admin | Chart tingkat prestasi (Universitas/Regional/Nasional/Internasional) |
| `getAdminKategoriChart()` | Admin | Chart kategori kegiatan |
| `getTopMahasiswa()` | Admin | Top 5 mahasiswa berprestasi (berdasarkan poin) |
| `getAktivitasTerbaru()` | Admin | 10 aktivitas terbaru (RPK/SPK/poin) |
| `getAdminRasioBimbingan()` | Admin | Rasio bimbingan dosen, distribusi, top dosen |
| `getDosenStats($dosenId)` | Dosen | Statistik mahasiswa bimbingan (RPK/SPK draft/disetujui/ditolak) |
| `getMahasiswaStats($userId)` | Mahasiswa | Statistik pribadi (RPK/SPK, poin, persentase) |
| `getMahasiswaTingkatChart($userId)` | Mahasiswa | Chart tingkat prestasi pribadi |
| `getMahasiswaKategoriChart($userId)` | Mahasiswa | Chart kategori kegiatan pribadi |
| `getMahasiswaBulananChart($userId)` | Mahasiswa | Chart aktivitas bulanan (12 bulan) |
| `getMahasiswaKegiatanTerbaru($userId)` | Mahasiswa | 5 kegiatan terbaru |

**Caching:**
- `admin.stats` — 300 detik (5 menit)
- `admin.tingkat` — 300 detik (5 menit)
- `admin.kategori` — 300 detik (5 menit)

Cache di-clear otomatis saat ada perubahan data (create, update, delete, approve, reject, tambah poin).

---

### 5.2 LaporanService

**File:** `app/Services/LaporanService.php`

**Deskripsi:** Service untuk mengelola logika bisnis laporan dan export.

**Methods:**

| Method | Deskripsi |
|--------|-----------|
| `applyFilters($query, $request)` | Menerapkan filter (search, tahun, prodi, tingkat) ke query SPK |
| `getTanggalSelesai($item)` | Format tanggal selesai kegiatan (dari kegiatan) |
| `getFakultasFromProdi($prodiName)` | Mapping nama prodi ke fakultas (dengan cache statis) |
| `getHeaderColor($fakultasName)` | Warna header berdasarkan fakultas |
| `getHeaderFontColor($fakultasName)` | Warna font header berdasarkan fakultas |
| `getHeaderFontColorDosen($fakultasName)` | Warna font header untuk laporan dosen |
| `createSheet($spreadsheet, $sheetName, $data, $fakultasName, $dosenName)` | Membuat sheet Excel dengan format tertentu |
| `generateExcel($laporan)` | Generate Excel multi-sheet per fakultas (untuk Admin) |
| `generateExcelDosen($laporan, $dosenName)` | Generate Excel multi-sheet per fakultas (untuk Dosen) |
| `generatePdf($laporan, $viewName, $extraData)` | Generate PDF landscape A4 |
| `generateCsv($laporan, $headers, $mapper)` | Generate CSV dengan BOM UTF-8 |

**Warna Fakultas:**
| Fakultas | Warna Header | Warna Font |
|----------|-------------|------------|
| Seni Rupa dan Desain | `2471A3` (hijau) | `000000` (hitam) |
| Seni Pertunjukan (tanpa Desain) | `F4A460` (oranye) | `000000` (hitam) |
| Media Rekam | `FFFF00` (kuning) | `000000` (hitam) |
| Lainnya | `1a5276` (biru dongker) | `FFFFFF` (putih) |

---

## 6. Controllers

### 6.1 Controller Structure

Semua controller mewarisi dari `App\Http\Controllers\Controller` (base controller).

### 6.2 Admin Controllers

| Controller | File | Deskripsi |
|-----------|------|-----------|
| `UserController` | `Admin/UserController.php` | Manajemen user, dosen pembimbing, API data |
| `UserRoleController` | `Admin/UserRoleController.php` | Update role user |
| `ProgramStudiController` | `Admin/ProgramStudiController.php` | CRUD program studi, toggle status |
| `RpkController` | `Admin/RpkController.php` | View RPK, update status (override) |
| `SpkController` | `Admin/SpkController.php` | CRUD SPK, approve/reject, kelola poin |
| `LaporanController` | `Admin/LaporanController.php` | Laporan, export CSV/Excel/PDF |

### 6.3 Dosen Controllers

| Controller | File | Deskripsi |
|-----------|------|-----------|
| `RpkController` | `Dosen/RpkController.php` | Daftar, detail, approve/reject RPK bimbingan |
| `SpkController` | `Dosen/SpkController.php` | Daftar, detail, approve/reject SPK bimbingan |
| `MahasiswaController` | `Dosen/MahasiswaController.php` | Daftar mahasiswa bimbingan |
| `LaporanController` | `Dosen/LaporanController.php` | Laporan, export CSV/Excel/PDF |

### 6.4 Mahasiswa Controllers

| Controller | File | Deskripsi |
|-----------|------|-----------|
| `RpkController` | `Mahasiswa/RpkController.php` | CRUD RPK, lihat detail |
| `KegiatanController` | `Mahasiswa/KegiatanController.php` | CRUD kegiatan dalam RPK |
| `SpkController` | `Mahasiswa/SpkController.php` | CRUD SPK, upload file |

### 6.5 Shared Controllers

| Controller | File | Deskripsi |
|-----------|------|-----------|
| `DashboardController` | `DashboardController.php` | Dashboard per role (Admin/Dosen/Mahasiswa) |
| `ProfileController` | `ProfileController.php` | Edit profile, update profile |

---

## 7. Middleware & Role-based Access Control

### 7.1 Middleware yang Digunakan

| Middleware | File | Deskripsi |
|-----------|------|-----------|
| `auth` | Laravel default | Memastikan pengguna sudah login |
| `verified` | Laravel default | Memastikan email sudah diverifikasi |
| `role:Admin` | Spatie Permission | Memastikan pengguna memiliki role Admin |
| `role:Dosen` | Spatie Permission | Memastikan pengguna memiliki role Dosen |
| `role:Mahasiswa` | Spatie Permission | Memastikan pengguna memiliki role Mahasiswa |

### 7.2 Role Definitions

Role didefinisikan di `database/seeders/RoleSeeder.php`:

| Role | Nama | Deskripsi |
|------|------|-----------|
| Admin | `Admin` | Akses penuh ke seluruh fitur sistem |
| Dosen | `Dosen` | Verifikasi RPK/SPK mahasiswa bimbingan |
| Mahasiswa | `Mahasiswa` | Pengajuan RPK/SPK, upload dokumen |

### 7.3 Authorization Logic

#### Admin
- Akses ke semua endpoint di `/admin/*`
- Bisa melakukan override verifikasi RPK/SPK
- Bisa menambah/edit poin SPK
- Bisa mengelola master data (kegiatan, prestasi, prodi)
- Bisa mengelola user (CRUD, role, dosen pembimbing)

#### Dosen
- Akses ke semua endpoint di `/dosen/*`
- Hanya bisa memverifikasi RPK/SPK mahasiswa yang menjadi bimbingannya
- Hanya bisa melihat data mahasiswa bimbingan
- Bisa export laporan hanya untuk mahasiswa bimbingan

#### Mahasiswa
- Akses ke endpoint di `/rpks`, `/spks`, `/kegiatans`
- Hanya bisa mengelola RPK/SPK milik sendiri
- Hanya bisa menambah kegiatan ke RPK milik sendiri
- Hanya bisa mengedit/hapus RPK/SPK dengan status `draft` atau `ditolak`

---

## 8. Caching Strategy

### 8.1 Cache Keys

| Key | Duration | Content | Cleared By |
|-----|----------|---------|------------|
| `admin.stats` | 300s (5 min) | Total mahasiswa, dosen, RPK, SPK + status breakdown | `DashboardService::clearAdminCache()` |
| `admin.tingkat` | 300s (5 min) | Chart tingkat prestasi | `DashboardService::clearAdminCache()` |
| `admin.kategori` | 300s (5 min) | Chart kategori kegiatan | `DashboardService::clearAdminCache()` |

### 8.2 Cache Invalidation

Cache admin di-clear otomatis saat:
- Membuat RPK baru (`RpkController::store`)
- Mengupdate RPK (`RpkController::update`)
- Menghapus RPK (`RpkController::destroy`)
- Membuat SPK baru (`SpkController::store`)
- Mengupdate SPK (`SpkController::update`)
- Menghapus SPK (`SpkController::destroy`)
- Menyetujui/menolak RPK (`AdminRpkController::updateStatus`, `DosenRpkController::approve/reject`)
- Menyetujui/menolak SPK (`AdminSpkController::approve/reject`, `DosenSpkController::approve/reject`)
- Menambah/edit poin SPK (`AdminSpkController::tambahPoin/editPoin`)

### 8.3 Cache Implementation

Menggunakan Laravel Cache dengan driver default (file/database).

```php
// Contoh penggunaan cache
return Cache::remember('admin.stats', 300, function () {
    // Query database
    return [...];
});
```

---

## 9. File Upload Handling

### 9.1 Storage Disk

File diupload menggunakan Laravel Storage dengan disk `public` (terhubung ke `storage/app/public`).

```bash
# Buat symbolic link
php artisan storage:link
```

### 9.2 Direktori Penyimpanan

| Field | Direktori | Format | Max Size |
|-------|-----------|--------|----------|
| `surat_tugas` | `storage/app/public/surat-tugas/` | PDF | 5 MB |
| `sertifikat` | `storage/app/public/sertifikat/` | PDF, JPG, JPEG, PNG | 5 MB |
| `foto_penyerahan` | `storage/app/public/foto-penyerahan/` | JPG, JPEG, PNG | 5 MB |
| `laporan` | `storage/app/public/laporan/` | PDF | 5 MB |

### 9.3 Upload Process

```php
// Contoh upload di SpkController
$suratTugas = $request->file('surat_tugas')->store('surat-tugas', 'public');
$sertifikat = $request->file('sertifikat')->store('sertifikat', 'public');
$fotoPenyerahan = $request->file('foto_penyerahan')->store('foto-penyerahan', 'public');
$laporan = $request->file('laporan')->store('laporan', 'public');
```

### 9.4 File Deletion

File dihapus otomatis saat SPK dihapus:

```php
$files = ['surat_tugas', 'sertifikat', 'foto_penyerahan', 'laporan'];
foreach ($files as $field) {
    if ($spk->$field && Storage::disk('public')->exists($spk->$field)) {
        Storage::disk('public')->delete($spk->$field);
    }
}
```

---

## 10. Email Notifications

### 10.1 Mail Classes

| Class | File | Trigger | Penerima |
|-------|------|---------|----------|
| `RpkSubmitted` | `app/Mail/RpkSubmitted.php` | Mahasiswa membuat RPK pertama | Admin / Dosen |
| `RpkStatusNotification` | `app/Mail/RpkStatusNotification.php` | Dosen/Admin menyetujui/menolak RPK | Mahasiswa |
| `SpkSubmitted` | `app/Mail/SpkSubmitted.php` | Mahasiswa mengajukan SPK | Dosen pembimbing |
| `SpkStatusNotification` | `app/Mail/SpkStatusNotification.php` | Dosen/Admin menyetujui/menolak SPK | Mahasiswa |
| `SpkApprovedAdmin` | `app/Mail/SpkApprovedAdmin.php` | Dosen menyetujui SPK | Admin lain |
| `PlottingMahasiswa` | `app/Mail/PlottingMahasiswa.php` | Admin mengatur dosen pembimbing | Dosen pembimbing |

### 10.2 Email Templates

Email menggunakan Markdown template di `resources/views/emails/`:

| Template | File | Deskripsi |
|----------|------|-----------|
| `rpk-submitted` | `emails/rpk-submitted.blade.php` | Notifikasi RPK baru |
| `rpk-status` | `emails/rpk-status.blade.php` | Notifikasi status RPK |
| `spk-submitted` | `emails/spk-submitted.blade.php` | Notifikasi SPK baru |
| `spk-status` | `emails/spk-status.blade.php` | Notifikasi status SPK |
| `spk-approved-admin` | `emails/spk-approved-admin.blade.php` | Notifikasi SPK disetujui ke admin |
| `plotting-mahasiswa` | `emails/plotting-mahasiswa.blade.php` | Notifikasi plotting dosen |

### 10.3 Error Handling

Email dikirim dengan try-catch untuk mencegah aplikasi crash:

```php
try {
    Mail::to($user)->send(new SpkStatusNotification($spk->fresh(), 'disetujui'));
} catch (\Throwable $e) {
    Log::warning('Gagal kirim email status SPK disetujui: ' . $e->getMessage());
}
```

---

## 11. Export System

### 11.1 Format yang Didukung

| Format | Library | Controller |
|--------|---------|------------|
| CSV | PHP native (`fputcsv`) | `LaporanService::generateCsv()` |
| Excel (XLSX) | PhpSpreadsheet | `LaporanService::generateExcel()` |
| PDF | barryvdh/laravel-dompdf | `LaporanService::generatePdf()` |

### 11.2 CSV Export

- Menggunakan PHP native `fputcsv`
- BOM UTF-8 untuk kompatibilitas karakter Indonesia
- Delimiter: `;` (semicolon)
- Headers: Nama, NIM, Prodi, Judul Kegiatan, Nama Kegiatan, Penyelenggara, Tingkat, Hasil, Poin, Tanggal Kegiatan

### 11.3 Excel Export

- Multi-sheet per fakultas
- Header berwarna berdasarkan fakultas
- Font color disesuaikan dengan background
- Freeze pane di baris ke-5
- Auto-size kolom

### 11.4 PDF Export

- Format landscape A4
- Menggunakan view Blade khusus (`admin.laporan.pdf` / `dosen.laporan.pdf`)
- Siap untuk pencetakan

---

## 12. AJAX Response Pattern

### 12.1 Pola Response

Aplikasi menggunakan pola AJAX untuk operasi CRUD. Response selalu dalam format JSON:

**Success:**
```json
{
    "success": true,
    "message": "Deskripsi keberhasilan",
    "data": { ... }  // opsional
}
```

**Error:**
```json
{
    "success": false,
    "message": "Deskripsi error"
}
```

### 12.2 AJAX Detection

Controller mendeteksi request AJAX menggunakan:

```php
if ($request->ajax() || $request->wantsJson()) {
    return response()->json([...]);
}
```

### 12.3 Frontend AJAX Pattern

Frontend menggunakan `fetch` API dengan pola berikut:

```javascript
// Contoh AJAX request
fetch(url, {
    method: 'POST',
    headers: {
        'X-CSRF-TOKEN': csrfToken,
        'Content-Type': 'application/json',
        'Accept': 'application/json',
    },
    body: JSON.stringify(data)
})
.then(response => response.json())
.then(data => {
    if (data.success) {
        // Tampilkan SweetAlert success
        Swal.fire('Berhasil!', data.message, 'success');
    } else {
        // Tampilkan SweetAlert error
        Swal.fire('Gagal!', data.message, 'error');
    }
});
```

---

## 13. Frontend Architecture

### 13.1 CSS Framework

- **TailwindCSS 3.x** — Utility-first CSS framework
- **Custom CSS variables** — Warna biru navy dan aksen biru
- **Glassmorphism** — Efek glass modern di welcome page
- **Responsive Design** — Optimal di desktop dan mobile

### 13.2 JavaScript Framework

- **Alpine.js 3.x** — Minimal JavaScript framework untuk interaktivitas
- **Chart.js 4.x** — Visualisasi chart di dashboard
- **Flatpickr 4.x** — Date picker
- **SweetAlert2 11.x** — Dialog interaktif

### 13.3 Build Tools

- **Vite 5.x** — Asset bundler (menggantikan Laravel Mix)
- **PostCSS** — CSS processing

### 13.4 View Structure

```
resources/views/
├── admin/
│   ├── daftar_pengguna/
│   ├── pembimbing/
│   ├── rpk/
│   ├── spk/
│   ├── laporan/
│   ├── kegiatan/
│   └── prodi/
├── dosen/
│   ├── rpk/
│   ├── spk/
│   ├── mahasiswa/
│   └── laporan/
├── mahasiswa/
│   ├── rpks/
│   └── spks/
├── dashboard/
│   ├── admin.blade.php
│   ├── dosen.blade.php
│   └── mahasiswa.blade.php
├── emails/
│   ├── rpk-submitted.blade.php
│   ├── rpk-status.blade.php
│   ├── spk-submitted.blade.php
│   ├── spk-status.blade.php
│   ├── spk-approved-admin.blade.php
│   └── plotting-mahasiswa.blade.php
├── auth/
│   ├── login.blade.php
│   ├── register.blade.php
│   ├── forgot-password.blade.php
│   ├── reset-password.blade.php
│   └── verify-email.blade.php
├── welcome.blade.php
├── statistik.blade.php
├── kontak.blade.php
├── sitemap.blade.php
└── profile/
    ├── edit.blade.php
    └── update.blade.php
```

---

## 14. Setup & Deployment

### 14.1 Persyaratan Sistem

| Komponen | Versi | Keterangan |
|----------|-------|------------|
| PHP | 8.2+ | Dengan ekstensi: mbstring, openssl, pdo, tokenizer, xml, ctype, json, curl |
| Composer | 2.x | Dependency manager |
| MySQL | 8.0+ | Database |
| Node.js | 18+ | Untuk asset building |
| NPM | 9+ | Package manager |

### 14.2 Instalasi

```bash
# 1. Clone repository
git clone https://github.com/your-username/sipresma_isi_yk.git
cd sipresma_isi_yk

# 2. Install dependencies
composer install
npm install && npm run build

# 3. Konfigurasi environment
cp .env.example .env
php artisan key:generate

# 4. Konfigurasi database
# Edit file .env:
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=pratama
# DB_USERNAME=root
# DB_PASSWORD=

# 5. Migration & Seeder
php artisan migrate
php artisan db:seed --class=RoleSeeder

# 6. Storage link
php artisan storage:link

# 7. Jalankan aplikasi
php artisan serve
```

### 14.3 Konfigurasi Email

Edit file `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME=PRATAMA
```

### 14.4 Perintah Berguna

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

# Queue worker (untuk email)
php artisan queue:work

# Log viewer
php artisan pail
```

### 14.5 Deployment

```bash
# Deploy script
./deploy.sh
```

---

## 15. Testing

### 15.1 Testing Framework

- **Pest PHP 3.8** — Testing framework (wrapper di atas PHPUnit)
- **Mockery 1.6** — Mocking library

### 15.2 Struktur Test

```
tests/
├── Feature/
│   ├── Auth/
│   ├── Admin/
│   ├── Dosen/
│   └── Mahasiswa/
├── Unit/
│   ├── Models/
│   └── Services/
└── TestCase.php
```

### 15.3 Menjalankan Test

```bash
# Jalankan semua test
php artisan test

# Jalankan test tertentu
php artisan test --filter=NamaTest

# Jalankan dengan verbose output
php artisan test --verbose
```

---

## 📌 Catatan Pengembangan

1. **AJAX Pattern**: Aplikasi menggunakan pola AJAX untuk operasi CRUD — response selalu JSON
2. **CSRF Protection**: Semua form POST/PUT/DELETE wajib menggunakan CSRF token
3. **Email Verification**: Pengguna harus memverifikasi email sebelum mengakses dashboard
4. **Role-based Access**: Middleware `role:` digunakan untuk membatasi akses berdasarkan role
5. **Caching**: Dashboard admin menggunakan cache (5 menit) yang di-clear saat ada perubahan data
6. **File Upload**: Maksimal 5MB per file, format PDF/JPG/JPEG/PNG
7. **Error Handling**: Email dikirim dengan try-catch untuk mencegah crash
8. **Status Flow**: Draft → Disetujui/Ditolak → (Admin) Tambah Poin
9. **Soft Delete**: Tidak digunakan — data dihapus secara permanen
10. **Timestamps**: Semua tabel memiliki `created_at` dan `updated_at`
