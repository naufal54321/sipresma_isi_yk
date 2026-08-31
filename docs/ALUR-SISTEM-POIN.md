# Alur Sistem Poin Mahasiswa

## 1. Overview
Sistem penentuan predikat dan validasi poin untuk mahasiswa program **Strata 1** dan **Diploma**. Predikat hanya diberikan jika mahasiswa memenuhi syarat minimum poin dari kedua bidang kompetensi.

## 2. Ketentuan Poin

### 2.1 Syarat Minimal
- **Total poin minimum**: 50 poin
- **Bidang Kompetensi Profesional**: minimum 25 poin
- **Bidang Kompetensi Kepribadian dan Sosial**: minimum 25 poin

Jika syarat minimal **tidak** terpenuhi, status mahasiswa akan menampilkan **"Belum Memenuhi Syarat"** tanpa predikat kualitatif.

### 2.2 Penentuan Predikat (Jika Syarat Terpenuhi)
| Predikat | Perolehan Poin |
|----------|---------------|
| Unggul | > 150 poin |
| Sangat Baik | 100 – 149 poin |
| Baik | 75 – 99 poin |
| Cukup | 50 – 74 poin |

### 2.3 Warnasing Waja
- **Orientasi Kompetensi Profesional**: Warna biru (`text-blue-600`) saat >= 25 poin
- **Kompetensi Kepribadian dan Sosial**: Warna ungu (`text-purple-600`) untuk **semua** nilai (terlepas dari >= 25 atau < 25)

### 2.4 Icon Status
- **Syarat Terpenuhi**: `fa-award` (medali) dengan gradient warna sesuai predikat
- **Belum Memenuhi Syarat**: `fa-exclamation-triangle` (peringatan) warna merah

## 3. Validasi Input Kegiatan

### 3.1 Pencegah Duplikasi
- Sistem membatasi **maksimal 4 kegiatan yang sama** yang boleh diinput pada **kedua bidang kompetensi**
- Jika melebihati, tolak dengan pesan error: *"Anda sudah menginput maksimal 4 kegiatan dengan jenis yang sama {jenis_kegiatan} di bidang {bidang}."*

### 3.2 Sumber Poin
- **Poin Diri (Sendiri)**: Poin dari SPK yang dimiliki mahasiswa sendiri (owner SPK)
- **Poin Anggota**: Poin dari SPK di mana mahasiswa adalah anggota (kegiatan bersama) namun bukan owner

**Total Poin = Poin Diri + Poin Anggota**

## 4. Alur Kerja

### 4.1 Pembuatan SPK (Mahasiswa)
1. Mahasiswa memilih RPK yang sudah disetujui
2. Sistem mengotomatis mengisi `kegiatan_id`, `bidang`, dan `jenis_kegiatan` dari RPK
3. Mahasiswa mengisi data SPK (tahun, penyelenggara, kategori, peran_sifat, judul_karya, biografi, rincian, kebaruan, url_kegiatan, link_drive)
4. **Validasi Duplikasi**: Sistem menghitung jumlah SPK dengan `jenis_kegiatan` + `bidang` yang sama
   - Jika >= 4: **Ditolak** dengan pesan error
   - Jika < 4: Lanjutkan proses
5. **Validasi File**: Sistem memeriksa file wajib berdasarkan `bidang`, `jenis_kegiatan`, dan `peran_sifat`
6. SPK disimpan dengan status `draft` dan `poin = 0`
7. Email notifikasi dikirim ke dosen pembimbing

### 4.2 Verifikasi SPK (Admin/Dosen)
1. Admin/Dosen memverifikasi SPK
2. Sistem mengambil `kkm_rule` berdasarkan `peran_sifat`
3. Poin `diambil` dari `kkm_rule.poin`
4. SPK diupdate: `status = disetujui`, `poin = {nilai dari kkm_rule}`
5. `poin_added_at`, `poin_added_by`, `verified_by`, `verified_at` tercatat
6. Email notifikasi dikirim ke mahasiswa

### 4.3 Penentuan Predikat di Dashboard Mahasiswa
1. DashboardService menghitung poin per bidang dengan join: `spks → kegiatans → kkm_rules`
2. **Cek syarat**:
   - `poinProfesional >= 25` AND `poinKepribadian >= 25` AND `totalPoin >= 50`
3. **Jika Lolos Syarat**: Hitung predikat berdasarkan `totalPoin`
   - > 150 → **Unggul** (emerald)
   - 100 – 149 → **Sangat Baik** (blue)
   - 75 – 99 → **Baik** (amber)
   - 50 – 74 → **Cukup** (orange)
4. **Jika Tidak Lolos Syarat**: Predikat = **"Belum Memenuhi Syarat"** (ungu, fa-exclamation-triangle)

### 4.4 Tampilan di Dashboard Mahasiswa
- **Icon Predikat**: bergeser otomatis antara `fa-award` (saudaraTerpenuhi) dan `fa-exclamation-triangle` (belum terpenuhi)
- **Warna Font Breakdown**:
  - Orientasi Kompetensi Profesional: >=25 → biru, <25 → merah
  - Kompetensi Kepribadian dan Sosial: **selalu ungu** (terlepas nilai)
- **Info Bar**: *"Mahasiswa pada program Strata 1 dan Diploma wajib memenuhi minimal 50 poin kredit keaktifan mahasiswa dari kedua bidang kompetensi."*
- **Kriteria Predikat**: Tabel 4 kolom menjelaskan predikat & perolehan poin

## 5. Contoh Perhitungan

| Kasus | Poin Profesional | Poin Kepribadian | Total | Syarat | Predikat |
|-------|------------------|------------------|-------|--------|----------|
| A | 30 | 20 | 50 | **TIDAK** (prof < 25) | Belum Memenuhi Syarat |
| B | 30 | 25 | 55 | **YA** | Cukup (50-74) |
| C | 80 | 70 | 150 | **YA** | Sangat Baik (100-149) |
| D | 90 | 80 | 170 | **YA** | Unggul (>150) |

## 6. Catatan Penting
- Predikat **hanya** ditampilkan jika syarat minimal (25 per bidang + 50 total) terpenuhi
- Warnasing waja bersifat **konsisten**: Kompetensi Kepribadian dan Sosial selalu menampilkan warna ungu, terlepas nilai po-nya
- Sistem menghitung poin dari **dua sumber**: poirSendiri + poinAnggota
- Setiap verifikasi SPK akan merecalculate total poin mahasiswa di dashboard