# Project Handover - PRATAMA SIPRESMA ISI Yogyakarta

## 1. Project Overview
- **Nama Project:** PRATAMA - Prestasi dan Talenta Mahasiswa
- **Institusi:** Institut Seni Indonesia Yogyakarta
- **Tech Stack:** Laravel 11, PHP 8.2+, MySQL 8.0, TailwindCSS 3.x, Alpine.js 3.x, Spatie Laravel-Permission 6.x
- **Repository:** https://github.com/naufal54321/sipresma_isi_yk (branch: main)
- **Status:** ✅ Deployed & Hosted
- **Versi Terakhir:** v1.0 (lihat CHANGELOG.md)

## 2. Arsitektur Sistem

### 2.1 Pattern & Structure
- **Pattern:** MVC + Service Layer (DashboardService, FileRequirementService)
- **Navigation:** SPA AJAX (page transitions via #content-wrapper innerHTML swap + script re-execution)
- **Authentication:** Laravel Breeze + Spatie Laravel-Permission (Role: Admin, Dosen, Mahasiswa)
- **Database:** MySQL 8.0, 25+ migrations (track schema evolution)

### 2.2 Service Layer Pattern
- **DashboardService:** Stats, Charts, Poin Calculation, Predikat Logic, Kegiatan per Dosen
- **FileRequirementService:** Dynamic file requirements by Bidang/Jenis Kegiatan/Peran
- **Mail Notifications:** 6 Mailable classes (SpkSubmitted, SpkApproved, SpkRejected, RpkApproved, RpkRejected, AccountApproval)

## 3. Fitur Utama per Role

### 3.1 Mahasiswa
- **RPK:** CRUD (AJAX), draft/disetujui/ditolak, tambah kegiatan per RPK
- **SPK:** CRUD (AJAX), upload dokumen (PDF/JPG/PNG max 5MB), prasyarat RPK disetujui
- **Dashboard:** 
  - Statistik cards (8 cards: RPK/SPK draft/disetujui, total poin, total kegiatan, ditolak, persentase)
  - Charts: Pie (status), Bar (ruang lingkup), Donut (kategori), Line (bulanan)
  - **Predikat Prestasi:** Auto-calculate berdasarkan poin per bidang
  - **Dosen Pembimbing per Kegiatan:** Group by dosen, list kegiatan singkat
  - Info bar ketentuan S1/Diploma (min 50 poin dari 2 bidang)

### 3.2 Dosen Pembimbing
- Verifikasi RPK/SPK mahasiswa bimbingan (setujui/tolak + catatan)
- Dashboard statistik bimbingan + progress bar validasi
- Laporan export (CSV/Excel/PDF) dengan filter

### 3.3 Admin
- **User Management:** CRUD + Role assignment (Spatie Permission)
- **Ploting Dosen:** Assign dosen pembimbing ke mahasiswa
- **Master Data:** KKM Rules (Bidang, Jenis Kegiatan, Ruang Lingkup, Peran, Poin), Program Studi, Kegiatan, Prestasi
- **Verifikasi Override:** Setujui/tolak/kembalikan ke draft RPK/SPK semua user
- **Kelola Poin:** Entry/edit poin SPK yang sudah disetujui (override auto-assign)
- **Laporan & Export:** CSV/Excel (multi-sheet per fakultas)/PDF landscape

## 4. Sistem Poin & Predikat (Business Logic Critical)

### 4.1 Ketentuan Poin Minimal
| Kriteria | Nilai Minimum |
|----------|---------------|
| Total Poin | 50 |
| Bidang Orientasi Kompetensi Profesional | 25 |
| Bidang Kompetensi Kepribadian dan Sosial | 25 |

### 4.2 Penentuan Predikat (Jika Syarat Terpenuhi)
| Predikat | Rentang Poin | Warna |
|----------|--------------|-------|
| Unggul | > 150 | Emerald |
| Sangat Baik | 100 – 149 | Blue |
| Baik | 75 – 99 | Amber |
| Cukup | 50 – 74 | Orange |

### 4.3 Status "Belum Memenuhi Syarat"
- Jika total < 50 ATAU salah satu bidang < 25
- Tampil: "Belum Memenuhi Syarat" + icon ⚠️ (fa-exclamation-triangle) warna merah
- **Tidak ada predikat kualitatif** meski total poin > 50

### 4.4 Sumber Poin
- **Poin Diri (Owner):** SPK yang dimiliki mahasiswa (user_id = mahasiswa)
- **Poin Anggota:** SPK di mana mahasiswa adalah anggota (via pivot `kegiatan_user`) tapi bukan owner
- **Total Poin = Poin Diri + Poin Anggota**

### 4.5 Penetapan Poin Otomatis
- Saat Admin/Dosen **approve SPK (status draft → disetujui)**:
  - Lookup `KkmRule` by `peran_sifat` (string match)
  - Assign `poin = kkmRule->poin` (default 0 jika tidak ketemu)
  - Record `poin_added_at`, `poin_added_by`, `verified_by`, `verified_at`

## 5. Database Schema Key Tables

| Tabel | Deskripsi | Kolom Kunci |
|-------|-----------|-------------|
| `users` | User + role (Spatie) | id, name, email, nip/nim, prodi_id |
| `rpks` | Rencana Prestasi Kemahasiswaan | user_id, dosen_pembimbing_id, tahun, semester, status |
| `kegiatans` | Kegiatan dalam RPK | rpk_id, kkm_rule_id, judul_kegiatan, bidang (via kkmRule), status |
| `spks` | Sertifikat Prestasi Kegiatan | user_id, rpk_id, kegiatan_id, poin, status, poin_added_by |
| `kkm_rules` | Master aturan poin | bidang, jenis_kegiatan, ruang_lingkup, peran, poin, is_active |
| `kegiatan_user` | Pivot anggota kegiatan | kegiatan_id, user_id, peran |
| `kkm_rules.bidang` (enum) | **2 nilai:** "Bidang Orientasi Kompetensi Profesional", "Bidang Kompetensi Kepribadian dan Sosial" | |

## 6. Key Services & Files

| File | Fungsi Utama |
|------|--------------|
| `app/Services/DashboardService.php` | Stats, Charts, Poin Calculation, Predikat Logic, Dosen-Kegiatan grouping |
| `app/Services/FileRequirementService.php` | Dynamic file requirements by Bidang/Jenis/Peran (structured array with labels) |
| `app/Http/Controllers/DashboardController.php` | Route dispatch per role, realtime polling endpoint |
| `app/Http/Controllers/Mahasiswa/SpkController.php` | SPK CRUD + validasi duplikasi (max 4 same jenis/bidang) |
| `app/Http/Controllers/Admin/SpkController.php` | Approve SPK + auto-assign poin from KKM Rule |
| `app/Http/Controllers/Dosen/SpkController.php` | Approve SPK (dosen hanya bimbingan sendiri) |

## 6. Validasi & Business Rules

### 7.1 SPK Creation Validation (Mahasiswa\SpkController)
- Max **4 kegiatan sama** (same `jenis_kegiatan` + same `bidang`) per mahasiswa
- File upload wajib sesuai `FileRequirementService` (by bidang/jenis/peran)
- RPK harus status `disetujui` dan milik mahasiswa

### 7.2 File Upload Requirements (FileRequirementService)
- Dynamic by: `bidang` → `jenis_kegiatan` → `peran_sifat`
- Structured array: `[['col' => 'surat_tugas', 'label' => 'Makalah'], ...]`
- Mime types: PDF/JPG/PNG, max 5MB per file

### 7.3 Poin Assignment (Admin/Dosen Approve)
- Lookup `KkmRule` by exact `peran` string match (case sensitive)
- Fallback: 0 poin jika rule tidak ketemu

## 8. Dashboard Mahasiswa - Komponen Utama

| Komponen | Deskripsi |
|----------|-----------|
| **Hero Section** | Welcome + NIM + Prodi + Logo ISI |
| **Dosen Pembimbing** | Group by dosen → list kegiatan (judul, bidang, jenis, status badge) |
| **Stats Cards (8)** | RPK/SPK Draft/Disetujui, Total Poin, Total Kegiatan, Ditolak, % Disetujui |
| **Predikat Section** | Icon + Predikat + Badge Poin + Breakdown per bidang (warna biru/ungu/merah) |
| **Kriteria Predikat Table** | 4 kolom: Unggul/Sangat Baik/Baik/Cukup + range poin |
| **Info Bar** | Ketentuan S1/Diploma min 50 poin 2 bidang |
| **Charts (4)** | Pie (status), Bar (ruang lingkup), Donut (kategori), Line (bulanan) |
| **Realtime Polling** | 30 detik interval, update stats + predikat + charts + breakdown |

## 9. Email Notifications (6 Mailable)

| Mailable | Trigger | Recipient |
|----------|---------|-----------|
| `SpkSubmitted` | Mahasiswa submit SPK | Dosen Pembimbing |
| `SpkApproved` | Admin/Dosen approve SPK | Mahasiswa |
| `SpkRejected` | Admin/Dosen tolak SPK | Mahasiswa |
| `RpkApproved` | Dosen/Admin approve RPK | Mahasiswa |
| `RpkRejected` | Dosen/Admin tolak RPK | Mahasiswa |
| `AccountApproval` | Admin approve/registrasi user | User baru |

## 10. Debugging & Common Issues

| Issue | Solusi |
|-------|--------|
| **Error 500** | Cek `storage/logs/laravel.log` |
| **AJAX 500** | Network tab → XHR → Response body (biasanya validation error) |
| **Chart.js blank** | Check CSP, re-init after AJAX load (`window.dispatchEvent(new Event('chart-reinit'))`) |
| **SweetAlert2 tidak muncul** | Re-init setelah AJAX content swap: `Swal.bindClickHandler()` |
| **File upload gagal** | Check `storage/app/public` permissions (775), `php.ini` upload_max_filesize |
| **Chart.js tidak update realtime** | Pastikan `Chart.getChart(canvasId)` return instance, call `.update()` |
| **SPA script tidak jalan** | Script harus idempotent, gunakan `document.addEventListener('content-loaded', fn)` pattern |
| **SweetAlert2 double bind** | Destroy instance sebelum re-bind: `Swal.close()` |

## 11. Maintenance & Operations

### 11.1 Cache Management
```php
DashboardService::clearAdminCache(); // Call after SPK/RPK create/update/delete
```

### 11.2 Scheduled Tasks (jika pakai Scheduler)
```bash
php artisan schedule:run # Setiap menit via cron
```

### 11.3 Queue Worker (untuk email async)
```bash
php artisan queue:work --tries=3 --timeout=60
```

### 11.4 Backup Database
```bash
mysqldump -u user -p pratama > backup_$(date +%F).sql
```

## 11. Extension Points (Untuk Pengembangan Lanjutan)

| Kebutuhan | Cara Extend |
|-----------|-------------|
| **Tambah Bidang Baru** | Migration `kkm_rules.bidang` enum + `FileRequirementService` + Views |
| **Tambah Role Baru** | Spatie Permission seeder + Middleware + Views + Routes |
| **Tambah Chart Baru** | Method di `DashboardService` + Canvas di Blade + Chart.js config |
| **Tambah Notifikasi** | Buat Mailable baru + trigger di Controller + Queue |
| **Tambah Export Format** | Method di `LaporanController` + Package `maatwebsite/excel` |
| **Custom Bidang/Jenis** | Edit `kkm_rules` via Admin UI + sync `FileRequirementService` |

## 12. Known Limitations

| Limitation | Workaround |
|------------|------------|
| SPA navigation: Scripts must be idempotent | Gunakan `if (window.xxxInitialized) return` pattern |
| SweetAlert2 re-init needed after AJAX | Call `Swal.bindClickHandler()` setelah content swap |
| File upload max 5MB | Edit `php.ini` upload_max_filesize & post_max_size |
| Chart.js instance leak | `Chart.getChart(canvasId)?.destroy()` sebelum create baru |
| SweetAlert2 double bind | `Swal.close()` sebelum `Swal.fire()` |

## 12. Testing Checklist (Untuk QA)

- [ ] Mahasiswa: Create RPK → add kegiatan → submit → verifikasi dosen
- [ ] Mahasiswa: Create SPK → upload file → submit → verifikasi dosen/admin
- [ ] Mahasiswa: Duplikasi >4 kegiatan sama/bidang → reject
- [ ] Mahasiswa: Poin <25 per bidang → predikat "Belum Memenuhi Syarat"
- [ ] Dosen: Approve/Tolak RPK/SPK → email terkirim
- [ ] Admin: Override verifikasi → poin manual entry
- [ ] Admin: Master KKM Rules CRUD → validasi duplikasi combo
- [ ] Export Laporan: CSV/Excel/PDF → data lengkap & format benar
- [ ] Realtime polling: 30 detik update stats + predikat + charts
- [ ] File upload: PDF/JPG/PNG max 5MB, format validasi

## 13. Changelog Reference
Lihat `CHANGELOG.md` untuk history perubahan detail.

## 14. Support & Contacts

| Role | Contact |
|------|---------|
| **Lead Developer** | [Nama] - [Email/WA] |
| **Repository** | https://github.com/naufal54321/sipresma_isi_yk |
| **Branch Utama** | `main` |
| **Issue Tracker** | GitHub Issues |

---

**Dokumen ini dibuat:** 2026-08-31
**Versi Dokumentasi:** 1.0
**Status:** Final Handover