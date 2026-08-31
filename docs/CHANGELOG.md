# Changelog - PRATAMA SIPRESMA ISI Yogyakarta

Semua perubahan signifikan pada project ini akan didokumentasikan di file ini.

Format berdasarkan [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
dan project ini menggunakan [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

---

## [1.0.0] - 2026-08-31

### Added - Fitur Baru (Release Pertama)

#### Sistem Poin & Predikat Mahasiswa
- **Sistem Poin Terstruktur:** Penghitungan poin otomatis berdasarkan KKM Rules
- **Poin per Bidang:** Perhitungan terpisah untuk Bidang Profesional (min 25) dan Bidang Kepribadian & Sosial (min 25)
- **Predikat Otomatis:** Unggul (>150), Sangat Baik (100-149), Baik (75-99), Cukup (50-74)
- **Status Belum Memenuhi Syarat:** Jika total < 50 ATAU salah satu bidang < 25
- **Breakdown Poin per Bidang:** Tampilan detail poin per bidang di dashboard

#### Validasi Duplikasi Kegiatan
- Max 4 kegiatan dengan `jenis_kegiatan` yang sama per `bidang` per mahasiswa
- Validasi di `Mahasiswa\SpkController::store()` sebelum create SPK

#### Dashboard Mahasiswa - Predikat & Dosen Pembimbing
- **Predikat Section:** Icon dinamis (medali/peringatan), badge poin, breakdown poin per bidang
- **Kriteria Predikat Table:** 4 kolom (Unggul, Sangat Baik, Baik, Cukup) dengan range poin
- **Dosen Pembimbing per Kegiatan:** Group by dosen → list kegiatan singkat (judul, bidang, jenis, status)
- **Info Bar:** Ketentuan S1/Diploma min 50 poin dari 2 bidang
- **Kriteria Predikat Table:** 4 kolom (Unggul, Sangat Baik, Baik, Cukup) + range poin

#### Dosen Pembimbing per Kegiatan
- Group by dosen pembimbing (via RPK)
- List kegiatan singkat: judul, bidang, jenis kegiatan, status badge
- Setiap dosen punya card terpisah dengan list kegiatannya

#### Realtime Dashboard Updates
- Polling 30 detik untuk update stats, predikat, charts, breakdown poin
- Update realtime tanpa reload halaman

#### FileRequirementService Enhancement
- Structured array dengan label per peran: `[['col' => 'surat_tugas', 'label' => 'Makalah'], ...]`
- Dynamic file requirements by Bidang → Jenis Kegiatan → Peran
- Support PDF/JPG/PNG, max 5MB per file

#### Email Notifications (6 Mailable)
- SpkSubmitted, SpkApproved, SpkRejected, RpkApproved, RpkRejected, AccountApproval

#### Bug Fixes
- Fix Error 500 di Dashboard Mahasiswa (groupBy return integer ID bukan User object)
- Fix dosen pembimbing display: sekarang group by dosen dengan list kegiatan
- Fix predikat icon: medali (syarat terpenuhi) vs peringatan (belum memenuhi)
- Fix poin breakdown color: biru (profesional), ungu (kepribadian), merah (<25)
- Fix SweetAlert2 re-init after AJAX content swap
- Fix Chart.js instance leak (destroy sebelum create baru)

### Changed - Perubahan pada Fitur Existing

#### Dashboard Mahasiswa
- **Alur Kerja:** Update flowchart di README.md menambahkan "Penentuan Predikat berdasarkan poin kompetensi"
- **Dosen Pembimbing Section:** Dari 1 dosen statis → group by dosen dengan list kegiatan singkat
- **Predikat Section:** Tambah breakdown poin, kriteria table, info bar S1/Diploma
- **Stats Cards:** Update label "Total Poin" dengan icon star

#### Master Data Cleanup
- **Removed:** MasterKegiatan & MasterPrestasi (models, controllers, migrations, views)
- **KKM Rules:** Bidang enum renamed ke "Bidang Orientasi Kompetensi Profesional" & "Bidang Kompetensi Kepribadian dan Sosial"
- **Database:** Drop tables `master_kegiatans`, `master_prestasis`
- **Migration:** Drop columns `master_kegiatan_id`, `master_prestasi_id` dari tabel terkait

#### Documentation
- **README.md:** Tambah section "Sistem Poin Mahasiswa" & update "Alur Kerja"
- **USER_GUIDE.md:** Tambah section "9.4 Sistem Poin Mahasiswa" dengan contoh perhitungan
- **ALUR-SISTEM-POIN.md:** Dokumentasi baru lengkap alur sistem poin
- **HANDOVER.md:** Dokumentasi handover komprehensif untuk client
- **TECHNICAL.md:** Update arsitektur, service layer, debugging guide
- **API.md:** Update endpoint terbaru, request/response examples
- **USER_GUIDE.md:** Tambah section 9.4 Sistem Poin Mahasiswa

### Fixed - Bug Fixes

#### Dashboard Mahasiswa
- **Error 500:** Fix `getMahasiswaDosenKegiatan` return integer ID bukan User object
- **Dosen Pembimbing Display:** Sekarang group by dosen dengan list kegiatan per dosen
- **Predikat Icon:** Medali (syarat terpenuhi) vs Peringatan (belum memenuhi syarat)
- **Poin Breakdown Colors:** Biru (Profesional >=25), Ungu (Kepribadian selalu), Merah (<25)
- **SweetAlert2:** Re-init after AJAX content swap
- **Chart.js:** Destroy instance sebelum create baru (prevent memory leak)

#### SPK Controller
- **Duplikasi Validation:** Max 4 kegiatan sama (same jenis_kegiatan + bidang) per mahasiswa
- **File Validation:** Dynamic by bidang/jenis/peran via FileRequirementService
- **Poin Assignment:** Auto-assign dari KKM Rule saat approve SPK

#### Database Cleanup
- Drop tables `master_kegiatans`, `master_prestasis`
- Drop columns `master_kegiatan_id`, `master_prestasi_id` dari tabel terkait
- Drop models `MasterKegiatan`, `MasterPrestasi`
- Drop controllers `MasterKegiatanController`, `MasterPrestasiController`

### Removed - Dihapus

#### Models
- `app/Models/MasterKegiatan.php`
- `app/Models/MasterPrestasi.php`

#### Controllers
- `app/Http/Controllers/Admin/MasterKegiatanController.php`
- `app/Http/Controllers/Admin/MasterPrestasiController.php`

#### Migrations
- `2026_08_28_095248_drop_master_kegiatan_and_prestasi_tables.php`

#### Views
- `resources/views/admin/master-kegiatan/*`
- `resources/views/admin/master-prestasi/*`

#### Routes
- `admin.master-kegiatan.*` & `admin.master-prestasi.*`

### Documentation Updates

#### New Files
- `docs/HANDOVER.md` - Dokumentasi handover komprehensif untuk client
- `docs/ALUR-SISTEM-POIN.md` - Dokumentasi alur sistem poin lengkap
- `docs/CHANGELOG.md` - File ini

#### Updated
- `README.md` - Tambah section Sistem Poin & update Alur Kerja
- `docs/USER_GUIDE.md` - Section 9.4 Sistem Poin Mahasiswa
- `docs/ALUR-SISTEM-POIN.md` - Dokumentasi alur lengkap
- `docs/TECHNICAL.md` - Arsitektur, Service Layer, Debugging
- `docs/API.md` - Endpoint terbaru, request/response examples
- `docs/USER_GUIDE.md` - Section 9.4 Sistem Poin Mahasiswa

---

## [Unreleased] - Upcoming

### Planned
- [ ] Unit & Feature Tests (PHPUnit)
- [ ] API Resource classes untuk response konsisten
- [ ] Queue implementation untuk email async
- [ ] Scheduler untuk auto-cleanup file lama
- [ ] Audit Trail / Activity Log (Spatie Activitylog)
- [ ] Two-Factor Authentication (2FA) untuk Admin
- [ ] Dark Mode Support (Tailwind dark mode)
- [ ] PWA Support (Service Worker + Manifest)

### Under Consideration
- [ ] Mobile App (Flutter/React Native) consume API
- [ ] Real-time Notifications (Pusher/Laravel Echo)
- [ ] Advanced Reporting (PDF templates, charts)
- [ ] Multi-tenancy (jika diperlukan untuk kampus lain)

---

## Migration Guide

### Upgrade ke v1.0.0 dari versi sebelumnya

#### Breaking Changes
1. **MasterKegiatan & MasterPrestasi dihapus** - Data migrasi ke KKM Rules
2. **Poin Calculation Logic** - Sekarang per bidang (min 25 per bidang)
2. **Predikat Logic** - Baru: "Belum Memenuhi Syarat" jika <25 per bidang
3. **Dosen Pembimbing Display** - Sekarang group by dosen dengan list kegiatan

#### Migration Steps
```bash
# 1. Pull latest changes
git pull origin main

# 2. Install dependencies
composer install
npm install && npm run build

# 3. Run migrations
php artisan migrate

# 4. Clear cache
php artisan optimize:clear

# 5. Storage link
php artisan storage:link

# 6. Seed master data (jika perlu)
php artisan db:seed --class=KkmRuleSeeder
```

#### Post-Migration Verification
- [ ] Dashboard mahasiswa load tanpa error 500
- [ ] Dosen pembimbing menampilkan list kegiatan per dosen
- [ ] Predikat muncul dengan benar (breakdown poin, kriteria table)
- [ ] SPK create dengan validasi duplikasi max 4
- [ ] Poin auto-assign saat approve SPK
- [ ] Email notifications terkirim

---

## Versioning Policy

| Version Type | Kapan | Contoh |
|--------------|-------|--------|
| **Major** (X.0.0) | Breaking changes, arsitektur berubah | 1.0.0 → 2.0.0 |
| **Minor** (X.Y.0) | Fitur baru, backward compatible | 1.0.0 → 1.1.0 |
| **Patch** (X.Y.Z) | Bug fixes, no new features | 1.0.0 → 1.0.1 |

---

## Support

- **Repository:** https://github.com/naufal54321/sipresma_isi_yk
- **Issues:** GitHub Issues
- **Branch Utama:** `main`
- **Branch Development:** `develop` (jika ada)

---

*Changelog ini di-maintain manual. Setiap release baru harus update file ini.*