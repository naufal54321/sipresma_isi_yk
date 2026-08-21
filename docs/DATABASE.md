# 📚 Dokumentasi Database — PRATAMA

> **Prestasi dan Talenta Mahasiswa** — Institut Seni Indonesia Yogyakarta
>
> Versi: 1.0 | Terakhir diperbarui: Agustus 2026

---

## 📋 Daftar Isi

1. [Gambaran Umum](#1-gambaran-umum)
2. [Skema Database](#2-skema-database)
3. [Relasi Antar Tabel](#3-relasi-antar-tabel)
4. [ER Diagram](#4-er-diagram)
5. [Seeders](#5-seeders)
6. [Migrasi & Evolusi Skema](#6-migrasi--evolusi-skema)

---

## 1. Gambaran Umum

Aplikasi PRATAMA menggunakan **MySQL 8.0+** sebagai database. Skema database dikelola melalui Laravel Migration dan terdiri dari **7 tabel utama** plus **1 tabel pivot** dan **5 tabel dari Spatie Permission**.

### Tabel Utama

| No | Nama Tabel | Deskripsi |
|----|-----------|-----------|
| 1 | `users` | Data pengguna (Admin, Dosen, Mahasiswa) |
| 2 | `rpks` | Rencana Prestasi Kemahasiswaan |
| 3 | `kegiatans` | Kegiatan dalam RPK |
| 4 | `spks` | Sertifikat Prestasi Kegiatan |
| 5 | `master_kegiatans` | Master jenis kegiatan |
| 6 | `master_prestasis` | Master tingkat prestasi (Juara 1, 2, 3, dll) |
| 7 | `program_studis` | Master program studi |
| 8 | `kegiatan_user` | Pivot — anggota kelompok kegiatan |

### Tabel Spatie Permission

| No | Nama Tabel | Deskripsi |
|----|-----------|-----------|
| 1 | `permissions` | Daftar permission |
| 2 | `roles` | Daftar role (Admin, Dosen, Mahasiswa) |
| 3 | `model_has_permissions` | Relasi model ke permission |
| 4 | `model_has_roles` | Relasi model ke role |
| 5 | `role_has_permissions` | Relasi role ke permission |

---

## 2. Skema Database

### 2.1 Tabel `users`

| Kolom | Tipe Data | Atribut | Deskripsi |
|-------|-----------|---------|-----------|
| `id` | bigint (auto) | PK | Primary key |
| `name` | varchar(255) | required | Nama lengkap pengguna |
| `email` | varchar(255) | unique, required | Email (untuk login & verifikasi) |
| `email_verified_at` | timestamp | nullable | Waktu verifikasi email |
| `password` | varchar(255) | required | Password (hashed dengan bcrypt) |
| `remember_token` | varchar(100) | nullable | Token "ingat saya" |
| `nim` | varchar(255) | nullable | Nomor Induk Mahasiswa |
| `prodi` | varchar(255) | nullable | Program Studi (untuk Mahasiswa) |
| `angkatan` | varchar(255) | nullable | Tahun angkatan (misal: 2023) |
| `semester` | varchar(255) | nullable | Semester (misal: 1, 2, 3, ...) |
| `dosen_pembimbing_id` | bigint | nullable, FK → users.id | Dosen pembimbing (untuk Mahasiswa) |
| `status` | enum | default: `pending` | Status akun: `pending`, `aktif`, `ditolak` |
| `is_approved` | boolean | default: false | Apakah akun disetujui oleh Admin |
| `created_at` | timestamp | | Waktu pembuatan |
| `updated_at` | timestamp | | Waktu pembaruan terakhir |

### 2.2 Tabel `rpks`

| Kolom | Tipe Data | Atribut | Deskripsi |
|-------|-----------|---------|-----------|
| `id` | bigint (auto) | PK | Primary key |
| `user_id` | bigint | FK → users.id (cascade delete) | Pemilik RPK (Mahasiswa) |
| `master_kegiatan_id` | bigint | nullable, FK → master_kegiatans.id | Master kegiatan (opsional) |
| `tahun` | varchar(255) | required | Tahun akademik (misal: 2026) |
| `semester` | enum | required | `Ganjil` atau `Genap` |
| `status` | enum | default: `draft` | `draft`, `disetujui`, `ditolak` |
| `catatan_dosen` | text | nullable | Catatan dari dosen/admin |
| `verified_by` | bigint | nullable, FK → users.id | User yang memverifikasi |
| `verified_at` | timestamp | nullable | Waktu verifikasi |
| `created_at` | timestamp | | Waktu pembuatan |
| `updated_at` | timestamp | | Waktu pembaruan terakhir |

### 2.3 Tabel `kegiatans`

| Kolom | Tipe Data | Atribut | Deskripsi |
|-------|-----------|---------|-----------|
| `id` | bigint (auto) | PK | Primary key |
| `rpk_id` | bigint | FK → rpks.id (cascade delete) | RPK tempat kegiatan ini |
| `master_kegiatan_id` | bigint | nullable, FK → master_kegiatans.id | Master kegiatan |
| `kegiatan` | varchar(255) | required | Nama kegiatan (dari master) |
| `judul_kegiatan` | varchar(255) | required | Judul spesifik kegiatan |
| `tanggal_mulai` | date | required | Tanggal mulai kegiatan |
| `tanggal_selesai` | date | required | Tanggal selesai kegiatan |
| `kategori` | enum | required | `Individu` atau `Kelompok` |
| `peran` | varchar(255) | nullable | Peran: `Ketua`, `Anggota`, `Individu` |
| `jumlah_anggota` | integer | nullable | Jumlah anggota (untuk kelompok) |
| `created_at` | timestamp | | Waktu pembuatan |
| `updated_at` | timestamp | | Waktu pembaruan terakhir |

### 2.4 Tabel `spks`

| Kolom | Tipe Data | Atribut | Deskripsi |
|-------|-----------|---------|-----------|
| `id` | bigint (auto) | PK | Primary key |
| `user_id` | bigint | FK → users.id (cascade delete) | Pemilik SPK (Mahasiswa) |
| `rpk_id` | bigint | FK → rpks.id (cascade delete) | RPK terkait |
| `kegiatan_id` | bigint | FK → kegiatans.id (cascade delete) | Kegiatan terkait |
| `tahun` | year | required | Tahun kegiatan |
| `tanggal_kegiatan` | varchar(255) | nullable | Rentang tanggal (format string, misal: "15 Januari 2025 - 17 Januari 2025") |
| `penyelenggara` | varchar(255) | required | Nama penyelenggara |
| `kategori` | enum | required | `Individu` atau `Kelompok` |
| `prestasi_id` | bigint | nullable, FK → master_prestasis.id | Master prestasi |
| `hasil` | varchar(255) | nullable | Hasil prestasi (dari master_prestasis.juara) |
| `judul_kegiatan` | varchar(255) | nullable | Judul kegiatan |
| `poin` | integer | default: 0 | Poin prestasi (diisi oleh Admin) |
| `tingkat` | varchar(255) | nullable | Tingkat: `Universitas`, `Regional`, `Nasional`, `Internasional` |
| `url_kegiatan` | varchar(500) | required | URL kegiatan |
| `link_drive` | varchar(500) | nullable | Link Google Drive |
| `surat_tugas` | varchar(255) | nullable | Path file surat tugas (PDF, max 5MB) |
| `sertifikat` | varchar(255) | nullable | Path file sertifikat/foto piala (PDF/JPG/PNG, max 5MB) |
| `foto_penyerahan` | varchar(255) | nullable | Path foto penyerahan piagam (JPG/PNG, max 5MB) |
| `laporan` | varchar(255) | nullable | Path file laporan (PDF, max 5MB) |
| `judul_karya` | varchar(255) | required | Judul karya/inovasi/riset |
| `biografi` | text | nullable | Biografi/latar belakang |
| `rincian` | text | nullable | Rincian inovasi/riset |
| `kebaruan` | text | nullable | Kebaruan/keunggulan |
| `status` | enum | default: `draft` | `draft`, `disetujui`, `ditolak` |
| `catatan_dosen` | text | nullable | Catatan dari dosen/admin |
| `verified_by` | bigint | nullable, FK → users.id | User yang memverifikasi |
| `verified_at` | timestamp | nullable | Waktu verifikasi |
| `poin_added_at` | timestamp | nullable | Waktu poin ditambahkan |
| `poin_added_by` | bigint | nullable, FK → users.id (set null on delete) | Admin yang menambahkan poin |
| `created_at` | timestamp | | Waktu pembuatan |
| `updated_at` | timestamp | | Waktu pembaruan terakhir |

### 2.5 Tabel `master_kegiatans`

| Kolom | Tipe Data | Atribut | Deskripsi |
|-------|-----------|---------|-----------|
| `id` | bigint (auto) | PK | Primary key |
| `nama_kegiatan` | varchar(255) | required | Nama kegiatan (misal: "Lomba", "Workshop", "Seminar") |
| `status` | enum | default: `aktif` | `aktif` atau `tidak aktif` |
| `created_at` | timestamp | | Waktu pembuatan |
| `updated_at` | timestamp | | Waktu pembaruan terakhir |

### 2.6 Tabel `master_prestasis`

| Kolom | Tipe Data | Atribut | Deskripsi |
|-------|-----------|---------|-----------|
| `id` | bigint (auto) | PK | Primary key |
| `juara` | varchar(255) | required | Nama prestasi (misal: "Juara 1", "Harapan 2", "Peserta") |
| `tingkat` | varchar(255) | nullable | Tingkat: `Universitas`, `Regional`, `Nasional`, `Internasional` |
| `is_active` | boolean | default: true | Status aktif/tidak aktif |
| `created_at` | timestamp | | Waktu pembuatan |
| `updated_at` | timestamp | | Waktu pembaruan terakhir |

### 2.7 Tabel `program_studis`

| Kolom | Tipe Data | Atribut | Deskripsi |
|-------|-----------|---------|-----------|
| `id` | bigint (auto) | PK | Primary key |
| `nama_prodi` | varchar(255) | required | Nama program studi |
| `fakultas` | varchar(255) | nullable | Nama fakultas |
| `status` | enum | default: `aktif` | `aktif` atau `tidak aktif` |
| `created_at` | timestamp | | Waktu pembuatan |
| `updated_at` | timestamp | | Waktu pembaruan terakhir |

### 2.8 Tabel `kegiatan_user` (Pivot)

| Kolom | Tipe Data | Atribut | Deskripsi |
|-------|-----------|---------|-----------|
| `id` | bigint (auto) | PK | Primary key |
| `kegiatan_id` | bigint | FK → kegiatans.id (cascade delete) | Kegiatan |
| `user_id` | bigint | FK → users.id (cascade delete) | Anggota kelompok |
| `peran` | varchar(255) | nullable | Peran: `Ketua`, `Anggota` |
| `created_at` | timestamp | | Waktu pembuatan |
| `updated_at` | timestamp | | Waktu pembaruan terakhir |
| **unique** | | `[kegiatan_id, user_id]` | Mencegah duplikat anggota |

---

## 3. Relasi Antar Tabel

### Eloquent Relationships

| Model | Relasi | Model Terkait | Tipe |
|-------|--------|---------------|------|
| `User` | `rpks()` | `Rpk` | HasMany |
| `User` | `spks()` | `Spk` | HasMany |
| `User` | `mahasiswaBimbingan()` | `User` | HasMany (dosen → mahasiswa) |
| `User` | `dosenPembimbing()` | `User` | BelongsTo (mahasiswa → dosen) |
| `User` | `kegiatanAnggota()` | `Kegiatan` | BelongsToMany (via `kegiatan_user`) |
| `User` | `programStudi()` | `ProgramStudi` | BelongsTo (via `prodi` → `nama_prodi`) |
| `Rpk` | `user()` | `User` | BelongsTo |
| `Rpk` | `kegiatans()` | `Kegiatan` | HasMany |
| `Rpk` | `spks()` | `Spk` | HasMany |
| `Rpk` | `masterKegiatan()` | `MasterKegiatan` | BelongsTo |
| `Rpk` | `verifiedBy()` | `User` | BelongsTo |
| `Kegiatan` | `rpk()` | `Rpk` | BelongsTo |
| `Kegiatan` | `user()` | `User` | BelongsTo |
| `Kegiatan` | `spks()` | `Spk` | HasMany |
| `Kegiatan` | `masterKegiatan()` | `MasterKegiatan` | BelongsTo |
| `Kegiatan` | `anggota()` | `User` | BelongsToMany (via `kegiatan_user`) |
| `Spk` | `user()` | `User` | BelongsTo |
| `Spk` | `rpk()` | `Rpk` | BelongsTo |
| `Spk` | `kegiatan()` | `Kegiatan` | BelongsTo |
| `Spk` | `prestasi()` | `MasterPrestasi` | BelongsTo |
| `Spk` | `poinAddedBy()` | `User` | BelongsTo |
| `Spk` | `verifiedBy()` | `User` | BelongsTo |
| `MasterKegiatan` | `rpks()` | `Rpk` | HasMany |
| `MasterKegiatan` | `kegiatans()` | `Kegiatan` | HasMany |
| `MasterPrestasi` | (tidak ada relasi langsung) | — | — |
| `ProgramStudi` | (relasi dikomentar) | — | — |

### Foreign Key Summary

| Tabel | Kolom FK | Referensi | On Delete |
|-------|----------|-----------|-----------|
| `rpks` | `user_id` | `users.id` | CASCADE |
| `rpks` | `master_kegiatan_id` | `master_kegiatans.id` | — |
| `rpks` | `verified_by` | `users.id` | — |
| `kegiatans` | `rpk_id` | `rpks.id` | CASCADE |
| `kegiatans` | `master_kegiatan_id` | `master_kegiatans.id` | — |
| `spks` | `user_id` | `users.id` | CASCADE |
| `spks` | `rpk_id` | `rpks.id` | CASCADE |
| `spks` | `kegiatan_id` | `kegiatans.id` | CASCADE |
| `spks` | `prestasi_id` | `master_prestasis.id` | — |
| `spks` | `verified_by` | `users.id` | — |
| `spks` | `poin_added_by` | `users.id` | SET NULL |
| `kegiatan_user` | `kegiatan_id` | `kegiatans.id` | CASCADE |
| `kegiatan_user` | `user_id` | `users.id` | CASCADE |
| `users` | `dosen_pembimbing_id` | `users.id` | — |

---

## 4. ER Diagram

```
┌─────────────────────────────────────────────────────────────────────────┐
│                              USERS                                     │
├─────────────────────────────────────────────────────────────────────────┤
│ id (PK)                                                                │
│ name                                                                   │
│ email (unique)                                                         │
│ email_verified_at                                                      │
│ password                                                               │
│ remember_token                                                         │
│ nim                                                                    │
│ prodi                                                                  │
│ angkatan                                                               │
│ semester                                                               │
│ dosen_pembimbing_id (FK → users.id)                                    │
│ status (pending/aktif/ditolak)                                         │
│ is_approved                                                            │
│ created_at, updated_at                                                 │
└─────────────────────────────────────────────────────────────────────────┘
         │
         │ 1
         │
         │ N
┌─────────────────────────────────────────────────────────────────────────┐
│                              RPKS                                       │
├─────────────────────────────────────────────────────────────────────────┤
│ id (PK)                                                                │
│ user_id (FK → users.id)                                                │
│ master_kegiatan_id (FK → master_kegiatans.id)                          │
│ tahun                                                                  │
│ semester (Ganjil/Genap)                                                │
│ status (draft/disetujui/ditolak)                                       │
│ catatan_dosen                                                          │
│ verified_by (FK → users.id)                                            │
│ verified_at                                                            │
│ created_at, updated_at                                                 │
└─────────────────────────────────────────────────────────────────────────┘
         │
         │ 1
         │
         │ N
┌─────────────────────────────────────────────────────────────────────────┐
│                           KEGIATANS                                     │
├─────────────────────────────────────────────────────────────────────────┤
│ id (PK)                                                                │
│ rpk_id (FK → rpks.id)                                                  │
│ master_kegiatan_id (FK → master_kegiatans.id)                          │
│ kegiatan                                                               │
│ judul_kegiatan                                                         │
│ tanggal_mulai                                                          │
│ tanggal_selesai                                                        │
│ kategori (Individu/Kelompok)                                           │
│ peran                                                                  │
│ jumlah_anggota                                                         │
│ created_at, updated_at                                                 │
└─────────────────────────────────────────────────────────────────────────┘
         │
         │ 1
         │
         │ N
┌─────────────────────────────────────────────────────────────────────────┐
│                              SPKS                                       │
├─────────────────────────────────────────────────────────────────────────┤
│ id (PK)                                                                │
│ user_id (FK → users.id)                                                │
│ rpk_id (FK → rpks.id)                                                  │
│ kegiatan_id (FK → kegiatans.id)                                        │
│ tahun                                                                  │
│ tanggal_kegiatan (string)                                              │
│ penyelenggara                                                          │
│ kategori (Individu/Kelompok)                                           │
│ prestasi_id (FK → master_prestasis.id)                                 │
│ hasil                                                                  │
│ judul_kegiatan                                                         │
│ poin                                                                   │
│ tingkat                                                                │
│ url_kegiatan, link_drive                                               │
│ surat_tugas, sertifikat, foto_penyerahan, laporan                      │
│ judul_karya, biografi, rincian, kebaruan                               │
│ status (draft/disetujui/ditolak)                                       │
│ catatan_dosen                                                          │
│ verified_by (FK → users.id)                                            │
│ verified_at                                                            │
│ poin_added_at, poin_added_by (FK → users.id)                           │
│ created_at, updated_at                                                 │
└─────────────────────────────────────────────────────────────────────────┘

┌──────────────────────┐     ┌──────────────────────┐     ┌──────────────────────┐
│  MASTER_KEGIATANS    │     │  MASTER_PRESTASIS    │     │  PROGRAM_STUDIS      │
├──────────────────────┤     ├──────────────────────┤     ├──────────────────────┤
│ id (PK)              │     │ id (PK)              │     │ id (PK)              │
│ nama_kegiatan        │     │ juare                │     │ nama_prodi           │
│ status               │     │ tingkat              │     │ fakultas             │
│ created_at,updated_at│     │ is_active            │     │ status               │
└──────────────────────┘     │ created_at,updated_at│     │ created_at,updated_at│
                             └──────────────────────┘     └──────────────────────┘

┌─────────────────────────────────────────────────────────────────────────┐
│                          KEGIATAN_USER (Pivot)                         │
├─────────────────────────────────────────────────────────────────────────┤
│ id (PK)                                                                │
│ kegiatan_id (FK → kegiatans.id)                                        │
│ user_id (FK → users.id)                                                │
│ peran                                                                  │
│ created_at, updated_at                                                 │
│ UNIQUE(kegiatan_id, user_id)                                           │
└─────────────────────────────────────────────────────────────────────────┘
```

---

## 5. Seeders

### 5.1 `DatabaseSeeder`

Seed utama yang dijalankan dengan `php artisan db:seed`.

```php
// database/seeders/DatabaseSeeder.php
public function run(): void
{
    User::factory()->create([
        'name' => 'Test User',
        'email' => 'test@example.com',
    ]);
}
```

> **Catatan:** Seeder ini hanya membuat 1 user test. Role dan permission tidak otomatis di-seed di sini.

### 5.2 `RoleSeeder`

Membuat 3 role dasar menggunakan Spatie Permission:

```php
// database/seeders/RoleSeeder.php
public function run(): void
{
    Role::create(['name' => 'Admin']);
    Role::create(['name' => 'Mahasiswa']);
    Role::create(['name' => 'Dosen']);
}
```

> **Catatan:** RoleSeeder belum dipanggil di DatabaseSeeder. Perlu ditambahkan manual jika diperlukan:
> ```php
> $this->call([RoleSeeder::class]);
> ```

---

## 6. Migrasi & Evolusi Skema

Berikut adalah urutan migrasi yang mengelola evolusi skema database:

### Migrasi Awal (Laravel Default)
| File | Deskripsi |
|------|-----------|
| `0001_01_01_000000_create_users_table.php` | Membuat tabel `users`, `password_reset_tokens`, `sessions` |
| `0001_01_01_000001_create_cache_table.php` | Membuat tabel `cache` |
| `0001_01_01_000002_create_jobs_table.php` | Membuat tabel `jobs`, `job_batches` |

### Migrasi Spatie Permission
| File | Deskripsi |
|------|-----------|
| `2026_05_26_013317_create_permission_tables.php` | Membuat tabel permission, roles, model_has_permissions, model_has_roles, role_has_permissions |

### Migrasi Pengguna
| File | Deskripsi |
|------|-----------|
| `2026_05_25_030939_add_nim_prodi_to_users_table.php` | Menambah kolom `nim`, `prodi` ke tabel `users` |
| `2026_06_03_062819_add_dosen_pembimbing_id_to_users_table.php` | Menambah kolom `dosen_pembimbing_id` ke tabel `users` |
| `2026_06_12_101611_add_status_to_users_table.php` | Menambah kolom `status` (enum: pending/aktif/ditolak) ke tabel `users` |
| `2026_06_26_142611_add_is_approved_to_users_table.php` | Menambah kolom `is_approved` (boolean) ke tabel `users` |
| `2026_07_06_103048_add_angkatan_and_semester_to_users_table.php` | Menambah kolom `angkatan`, `semester` ke tabel `users` |

### Migrasi RPK
| File | Deskripsi |
|------|-----------|
| `2026_05_29_071401_create_rpks_table.php` | Membuat tabel `rpks` (id, user_id, tahun, semester, kategori) |
| `2026_06_08_021252_add_master_kegiatan_id_to_rpks_table.php` | Menambah kolom `master_kegiatan_id` ke tabel `rpks` |
| `2026_06_12_092049_add_status_to_rpks_table.php` | Menambah kolom `status` ke tabel `rpks` |
| `2026_07_07_104445_remove_kategori_from_rpks_table.php` | Menghapus kolom `kategori` dari tabel `rpks` |
| `2026_07_29_153332_add_verified_by_to_rpks_and_spks_tables.php` | Menambah kolom `verified_by`, `verified_at` ke tabel `rpks` dan `spks` |
| `2026_08_06_000000_add_verified_at_to_rpks_and_spks_table.php` | Menambah kolom `verified_at` ke tabel `rpks` dan `spks` |

### Migrasi Kegiatan
| File | Deskripsi |
|------|-----------|
| `2026_05_29_071545_create_kegiatans_table.php` | Membuat tabel `kegiatans` (id, rpk_id, kegiatan, jenis, tingkat, hasil, tanggal, peran, jumlah_anggota, status, catatan_dosen) |
| `2026_06_03_062819_add_user_id_to_kegiatans_table.php` | Menambah kolom `user_id` ke tabel `kegiatans` |
| `2026_06_08_022014_add_master_kegiatan_id_to_kegiatans_table.php` | Menambah kolom `master_kegiatan_id` ke tabel `kegiatans` |
| `2026_06_08_024305_add_master_kegiatan_id_to_kegiatans_table.php` | Perbaikan penambahan `master_kegiatan_id` |
| `2026_06_08_074731_change_peran_nullable_on_kegiatans_table.php` | Mengubah kolom `peran` menjadi nullable |
| `2026_06_25_084457_add_judul_kegiatan_to_kegiatans_table.php` | Menambah kolom `judul_kegiatan` ke tabel `kegiatans` |
| `2026_06_25_101059_remove_status_from_kegiatans_table.php` | Menghapus kolom `status` dari tabel `kegiatans` |
| `2026_06_29_113555_remove_jenis_from_master_kegiatans_table.php` | Menghapus kolom `jenis` dari tabel `master_kegiatans` |
| `2026_06_30_082906_remove_jenis_from_kegiatans_table.php` | Menghapus kolom `jenis` dari tabel `kegiatans` |
| `2026_07_27_133922_add_tanggal_mulai_selesai_to_kegiatans_table.php` | Menambah kolom `tanggal_mulai`, `tanggal_selesai` ke tabel `kegiatans` |
| `2026_06_25_094953_create_kegiatan_user_table.php` | Membuat tabel pivot `kegiatan_user` |
| `2026_06_25_101807_add_peran_to_kegiatan_user_table.php` | Menambah kolom `peran` ke tabel `kegiatan_user` |

### Migrasi SPK
| File | Deskripsi |
|------|-----------|
| `2026_06_03_014144_create_spks_table.php` | Membuat tabel `spks` (id, user_id, rpk_id, kegiatan_id, tahun, tanggal_kegiatan, penyelenggara, kategori, url_kegiatan, bukti, keterangan, status, catatan_dosen) |
| `2026_06_25_130255_add_prestasi_to_spks_table.php` | Menambah kolom `prestasi_id` ke tabel `spks` |
| `2026_06_26_084720_remove_tingkat_from_master_kegiatans_table.php` | Menghapus kolom `tingkat` dari tabel `master_kegiatans` |
| `2026_06_26_084750_add_tingkat_to_master_prestasis_table.php` | Menambah kolom `tingkat` ke tabel `master_prestasis` |
| `2026_06_26_091414_add_tingkat_to_spks_table.php` | Menambah kolom `tingkat` ke tabel `spks` |
| `2026_06_26_095509_add_judul_kegiatan_to_spks_table.php` | Menambah kolom `judul_kegiatan` ke tabel `spks` |
| `2026_06_26_104403_remove_tingkat_from_kegiatans_table.php` | Menghapus kolom `tingkat` dari tabel `kegiatans` |
| `2026_07_03_143846_remove_poin_from_master_kegiatans_table.php` | Menghapus kolom `poin` dari tabel `master_kegiatans` |
| `2026_07_03_150456_add_dokumen_columns_to_spks_table.php` | Menambah kolom `link_drive`, `surat_tugas`, `sertifikat`, `foto_penyerahan`, `laporan` ke tabel `spks` |
| `2026_07_06_082331_remove_bukti_from_spks_table.php` | Menghapus kolom `bukti` dari tabel `spks` |
| `2026_07_06_092546_add_poin_tracking_to_spks_table.php` | Menambah kolom `poin_added_at`, `poin_added_by` ke tabel `spks` |
| `2026_07_10_081542_add_detail_columns_to_spks_table.php` | Menambah kolom `judul_karya`, `biografi`, `rincian`, `kebaruan` ke tabel `spks` |
| `2026_07_10_081935_remove_keterangan_from_spks_table.php` | Menghapus kolom `keterangan` dari tabel `spks` |
| `2026_07_13_084104_change_tanggal_kegiatan_to_string_in_spks_table.php` | Mengubah tipe `tanggal_kegiatan` dari date ke string |

### Migrasi Master Data
| File | Deskripsi |
|------|-----------|
| `2026_06_08_015456_create_master_kegiatans_table.php` | Membuat tabel `master_kegiatans` (id, nama_kegiatan, jenis, tingkat, hasil, poin, status) |
| `2026_06_10_082436_create_program_studis_table.php` | Membuat tabel `program_studis` (id, nama_prodi, status) |
| `2026_06_24_101541_create_master_prestasis_table.php` | Membuat tabel `master_prestasis` (id, juare, poin, is_active) |
| `2026_07_13_090522_add_fakultas_to_program_studis_table.php` | Menambah kolom `fakultas` ke tabel `program_studis` |

### Migrasi Lainnya
| File | Deskripsi |
|------|-----------|
| `2026_07_27_114841_add_indexes_to_tables.php` | Menambahkan indeks ke tabel-tabel untuk performa |

---

## 🔧 Perintah Berguna Database

```bash
# Jalankan migrasi
php artisan migrate

# Reset & migrate ulang (hapus semua data)
php artisan migrate:fresh

# Reset & migrate ulang + seed
php artisan migrate:fresh --seed

# Rollback migrasi terakhir
php artisan migrate:rollback

# Rollback semua migrasi
php artisan migrate:reset

# Cek status migrasi
php artisan migrate:status

# Seed database
php artisan db:seed

# Seed dengan class tertentu
php artisan db:seed --class=RoleSeeder
```
