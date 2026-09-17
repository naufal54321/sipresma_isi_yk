# Diagram Alir (Flowchart) — Sistem PRATAMA

## 1. Pendahuluan

Flowchart digunakan untuk memvisualisasikan alur kerja operasional (workflow) secara sistematis dan berurutan. Pada sistem PRATAMA, bagan alir ini secara spesifik memodelkan urutan logis dari siklus awal pengajuan Rencana Prestasi Kemahasiswaan (RPK) oleh mahasiswa, tahapan evaluasi dan persetujuan oleh dosen pembimbing, hingga transisi menuju pelaporan Satuan Prestasi Kemahasiswaan (SPK). Flowchart juga memetakan alur logika di belakang layar (backend), termasuk proses eksekusi algoritma validasi pencegahan duplikasi masukan dan proses akhir berupa penetapan predikat kelulusan melalui kalkulasi otomatis poin KKM.

### File Diagram PlantUML

| File | Deskripsi |
|------|-----------|
| [`01-auth-dashboard.puml`](01-auth-dashboard.puml) | Alur registrasi, login, email verifikasi, dan dashboard (3 role) |
| [`02-rpk-flow.puml`](02-rpk-flow.puml) | Alur RPK: pembuatan, penambahan kegiatan, assign dosen, review |
| [`03-spk-flow.puml`](03-spk-flow.puml) | Alur SPK: pembuatan, upload dokumen, review, penetapan poin |
| [`04-admin-laporan-log.puml`](04-admin-laporan-log.puml) | Alur admin CRUD, laporan/export, dan activity log |
| [`05-overview.puml`](05-overview.puml) | Ringkasan end-to-end seluruh siklus sistem |

---

## 2. Alur Operasional Utama

Alur operasional utama sistem PRATAMA mengikuti siklus tiga tahap: **Pengajuan RPK → Evaluasi Dosen → Transisi ke SPK**. Setiap tahap memiliki kondisi prerequisite yang harus terpenuhi sebelum transisi ke tahap berikutnya.

### Tahap 1: Pengajuan RPK oleh Mahasiswa

```
MAHASISWA
    │
    ├── 1.1 Buat RPK (tahun, semester)
    │       → Status awal: DRAFT
    │
    ├── 1.2 Tambah Kegiatan ke RPK
    │       ├── Pilih Aturan Poin (PointRule)
    │       ├── Isi data kegiatan (judul, tanggal, kategori)
    │       ├── Pilih anggota (jika kelompok)
    │       └── [VALIDASI] Cek batas maksimal per jenis aktivitas
    │
    └── 1.3 Submit RPK
            → Email notifikasi ke Admin dan Dosen Pembimbing
```

### Tahap 2: Evaluasi oleh Dosen Pembimbing

```
DOSEN PEMBIMBING
    │
    ├── 2.1 Review RPK
    │       ├── Lihat daftar kegiatan
    │       ├── Verifikasi kesesuaian dengan kurikulum
    │       └── Cek kelengkapan dokumen pendukung
    │
    ├── 2.2 Keputusan
    │       ├── SETUJUI → Status: DISETUJUI
    │       │              → Email notifikasi ke Mahasiswa
    │       │              → Mahasiswa dapat membuat SPK
    │       │
    │       └── TOLAK → Status: DITOLAK
    │                    → Wajib isi catatan penolakan
    │                    → Email notifikasi ke Mahasiswa
    │                    → Mahasiswa revisi & resubmit (kembali ke DRAFT)
    │
    └── 2.3 Admin dapat override status
            → Mengubah status RPK secara manual
```

### Tahap 3: Transisi ke SPK

```
MAHASISWA (RPK harus DISETUJUI)
    │
    ├── 3.1 Buat SPK
    │       ├── Pilih RPK → Pilih Kegiatan
    │       ├── Isi data SPK (penyelenggara, peran/sifat, judul karya)
    │       ├── Upload dokumen wajib
    │       │   ├── Surat Tugas (PDF)
    │       │   ├── Sertifikat (PDF/JPG/PNG)
    │       │   ├── Foto Penyerahan (PDF/JPG/PNG)
    │       │   └── Laporan (PDF)
    │       └── [VALIDASI] Cek file requirements dari PointRule
    │
    ├── 3.2 Review SPK oleh Dosen/Admin
    │       ├── SETUJUI
    │       │   → Status: DISETUJUI
    │       │   → Poin ditetapkan dari PointRule.points
    │       │   → Poin muncul di dashboard Mahasiswa
    │       │   → Email notifikasi ke Mahasiswa
    │       │
    │       └── TOLAK
    │           → Status: DITOLAK
    │           → Mahasiswa revisi & upload ulang
    │           → Email notifikasi ke Mahasiswa
    │
    └── 3.3 Poin terakumulasi di Dashboard
            → Digunakan untuk kalkulasi predikat kelulusan
```

---

## 3. Validasi Pencegahan Duplikasi Masukan

Sistem PRATAMA menerapkan algoritma validasi pencegahan duplikasi masukan pada dua level: **level kegiatan** dan **level SPK**. Tujuannya adalah memastikan setiap mahasiswa tidak mengajukan kegiatan atau SPK dengan jenis yang sama secara berlebihan.

### Level 1: Validasi Jumlah Kegiatan per Jenis Aktivitas

Ketika mahasiswa menambahkan kegiatan baru ke RPK, sistem melakukan pengecekan terhadap jumlah kegiatan yang sudah ada dengan jenis aktivitas yang sama.

```
INPUT: user_id, activity_type_id (dari PointRule)
│
├── Hitung jumlah kegiatan milik user dengan activity_type_id yang sama
│   query: Kegiatan::where('user_id', $userId)
│          ->whereHas('pointRule.activityType', fn($q) => $q->where('id', $activityTypeId))
│          ->count()
│
├── Jika count >= 4
│   → TOLAK: "Batas maksimal 4 kegiatan untuk jenis ini sudah tercapai"
│
└── Jika count < 4
    → LANJUT: Kegiatan dapat ditambahkan
```

**Batas maksimal**: 4 kegiatan per jenis aktivitas per mahasiswa.

### Level 2: Validasi Jumlah SPK per Kombinasi Bidang dan Jenis

Ketika mahasiswa membuat SPK baru, sistem melakukan pengecekan terhadap jumlah SPK yang sudah ada dengan kombinasi bidang kompetensi dan jenis aktivitas yang sama.

```
INPUT: user_id, competency_field_id, activity_type_id
│
├── Hitung jumlah SPK milik user dengan competency_field_id + activity_type_id yang sama
│   query: Spk::where('user_id', $userId)
│          ->whereHas('pointRule', fn($q) => $q->where('competency_field_id', $cfId)
│                                              ->where('activity_type_id', $atId))
│          ->count()
│
├── Jika count >= 4
│   → TOLAK: "Maksimal 4 kegiatan dengan jenis yang sama"
│
└── Jika count < 4
    → LANJUT: SPK dapat dibuat
```

**Batas maksimal**: 4 SPK per kombinasi (bidang kompetensi + jenis aktivitas) per mahasiswa.

### Validasi File Requirements

Setiap Aturan Poin (PointRule) memiliki daftar file wajib (FileRequirement) yang harus diunggah oleh mahasiswa. Sistem memvalidasi keberadaan dan format file sebelum SPK dapat disimpan.

```
INPUT: point_rule_id, uploaded files
│
├── Ambil daftar FileRequirement dari PointRule
│   query: PointRule::with('fileRequirements')->find($pointRuleId)
│
├── Untuk setiap FileRequirement:
│   ├── Cek apakah file diunggah
│   │   └── Jika tidak → VALIDASI GAGAL: "{nama_file} wajib diunggah"
│   │
│   └── Cek format file (MIME type)
│       └── Jika tidak sesuai → VALIDASI GAGAL: format tidak valid
│
└── Semua file valid → LANJUT: Simpan SPK
```

---

## 4. Kalkulasi Predikat Kelulusan

Predikat kelulusan ditentukan berdasarkan akumulasi poin prestasi kemahasiswaan yang diperoleh mahasiswa dari SPK yang telah disetujui. Kalkulasi ini dilakukan secara otomatis oleh backend dan ditampilkan di dashboard mahasiswa.

### Sumber Poin

Poin diperoleh dari dua sumber:

1. **Poin Sendiri**: SPK yang dibuat oleh mahasiswa itu sendiri
2. **Poin Anggota**: SPK kelompok di mana mahasiswa terdaftar sebagai anggota

```
totalPoin = poinSendiri + poinAnggota
```

Kedua poin hanya dihitung dari SPK dengan status **DISETUJUI**.

### Kalkulasi per Bidang Kompetensi

Sistem menghitung poin terpisah untuk dua bidang kompetensi:

| Bidang Kompetensi | Nama di Database |
|---|---|
| Orientasi Kompetensi Profesional | Bidang Orientasi Kompetensi Profesional |
| Kompetensi Kepribadian dan Sosial | Bidang Kompetensi Kepribadian dan Sosial |

```
poinProfesional = SUM(spks.poin)
    WHERE competency_fields.name = 'Bidang Orientasi Kompetensi Profesional'
    AND spks.status = 'disetujui'
    AND (spks.user_id = $userId OR kegiatan sebagai anggota)

poinKepribadian = SUM(spks.poin)
    WHERE competency_fields.name = 'Bidang Kompetensi Kepribadian dan Sosial'
    AND spks.status = 'disetujui'
    AND (spks.user_id = $userId OR kegiatan sebagai anggota)
```

### Syarat Predikat

Untuk mendapatkan predikat kelulusan, mahasiswa harus memenuhi **ketiga syarat** berikut:

```
Syarat 1: poinProfesional >= 25
Syarat 2: poinKepribadian >= 25
Syarat 3: totalPoin >= 50
```

Jika salah satu syarat tidak terpenuhi, predikat = **"Belum Memenuhi Syarat"**.

### Tabel Predikat

| Kondisi | Predikat | Keterangan |
|---------|----------|------------|
| poinProfesional >= 25 AND poinKepribadian >= 25 AND totalPoin > 150 | **Unggul** | Prestasi luar biasa |
| poinProfesional >= 25 AND poinKepribadian >= 25 AND totalPoin >= 100 | **Sangat Baik** | Prestasi sangat baik |
| poinProfesional >= 25 AND poinKepribadian >= 25 AND totalPoin >= 75 | **Baik** | Prestasi baik |
| poinProfesional >= 25 AND poinKepribadian >= 25 AND totalPoin >= 50 | **Cukup** | Memenuhi syarat minimum |
| Syarat tidak terpenuhi | **Belum Memenuhi Syarat** | Perlu menambah poin |

### Algoritma Kalkulasi

```
FUNCTION hitungPredikat(poinProfesional, poinKepribadian, totalPoin):

    IF poinProfesional >= 25
       AND poinKepribadian >= 25
       AND totalPoin >= 50:

        IF totalPoin > 150:
            RETURN 'Unggul'

        ELSE IF totalPoin >= 100:
            RETURN 'Sangat Baik'

        ELSE IF totalPoin >= 75:
            RETURN 'Baik'

        ELSE:
            RETURN 'Cukup'

    ELSE:
        RETURN 'Belum Memenuhi Syarat'
```

---

## 5. Status State Machine

Baik RPK maupun SPK menggunakan mesin status tiga keadaan yang sama:

```
States: DRAFT, DISETUJUI, DITOLAK

DRAFT ──────→ DISETUJUI    (Dosen/Admin approve)
DRAFT ──────→ DITOLAK      (Dosen/Admin reject)
DITOLAK ────→ DRAFT        (Mahasiswa revisi/resubmit)
DISETUJUI ──→ DRAFT        (Admin override saja)
DISETUJUI ──→ DITOLAK      (Admin override saja)
```

Khusus untuk SPK, transisi DISETUJUI juga menetapkan poin secara final.

---

## 6. Notifikasi Email

| Kejadian | Mail Class | Penerima | Subjek |
|----------|-----------|----------|--------|
| RPK dibuat | RpkSubmitted | Semua Admin | RPK Baru Diajukan — {nama} |
| Kegiatan ditambahkan | RpkSubmitted | Dosen Pembimbing | RPK Baru Diajukan — {nama} |
| Dosen diassign | PlottingMahasiswa | Dosen | Plotting Dosen Pembimbing — RPK {nama} |
| RPK disetujui | RpkStatusNotification | Mahasiswa | Status: disetujui |
| RPK ditolak | RpkStatusNotification | Mahasiswa | Status: ditolak |
| SPK dibuat | SpkSubmitted | Dosen Pembimbing | SPK Baru Diajukan — {nama} |
| SPK disetujui | SpkStatusNotification | Mahasiswa | Status: disetujui |
| SPK ditolak | SpkStatusNotification | Mahasiswa | Status: ditolak |

---

## 7. Referensi Kode

| Komponen | File Utama |
|----------|-----------|
| Controller RPK (Mahasiswa) | `app/Http/Controllers/Mahasiswa/RpkController.php` |
| Controller RPK (Dosen) | `app/Http/Controllers/Dosen/RpkController.php` |
| Controller RPK (Admin) | `app/Http/Controllers/Admin/RpkController.php` |
| Controller SPK (Mahasiswa) | `app/Http/Controllers/Mahasiswa/SpkController.php` |
| Controller SPK (Dosen) | `app/Http/Controllers/Dosen/SpkController.php` |
| Controller SPK (Admin) | `app/Http/Controllers/Admin/SpkController.php` |
| Dashboard Service | `app/Services/DashboardService.php` |
| Laporan Service | `app/Services/LaporanService.php` |
| Activity Log Listener | `app/Listeners/LogAuthActivity.php` |
| Validasi Duplikasi | `app/Http/Controllers/Mahasiswa/SpkController.php` (method store/update) |
| Kalkulasi Predikat | `app/Services/DashboardService.php` (method getMahasiswaStats) |
