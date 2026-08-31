# 🌐 Dokumentasi API — PRATAMA

> **Prestasi dan Talenta Mahasiswa** — Institut Seni Indonesia Yogyakarta
>
> Versi: 1.0 | Terakhir diperbarui: Agustus 2026

---

## 📋 Daftar Isi

1. [Pendahuluan](#1-pendahuluan)
2. [Autentikasi & Middleware](#2-autentikasi--middleware)
3. [Role & Akses](#3-role--akses)
4. [Public Routes](#4-public-routes)
5. [Auth Routes](#5-auth-routes)
6. [Dashboard Routes](#6-dashboard-routes)
7. [Admin Routes](#7-admin-routes)
8. [Dosen Routes](#8-dosen-routes)
9. [Mahasiswa Routes](#9-mahasiswa-routes)
10. [Response Pattern](#10-response-pattern)
11. [Error Handling](#11-error-handling)

---

## 1. Pendahuluan

Aplikasi PRATAMA adalah aplikasi web berbasis Laravel 12 yang menggunakan **AJAX/Fetch** untuk operasi CRUD tanpa reload halaman. API ini tidak berupa RESTful API tradisional, melainkan **web routes** yang mengembalikan **JSON response** untuk request AJAX dan **view/HTML** untuk request biasa.

### Karakteristik API
- **Base URL**: `http://localhost:8000` (development)
- **Content-Type**: `application/json` (untuk AJAX), `multipart/form-data` (untuk upload file)
- **Auth**: Session-based authentication (bukan token)
- **CSRF**: Laravel CSRF token wajib untuk POST/PUT/DELETE
- **Response**: JSON untuk AJAX request, View/HTML untuk request biasa

### Header yang Diperlukan
```
X-Requested-With: XMLHttpRequest
X-CSRF-TOKEN: {csrf_token}
Accept: application/json
```

---

## 2. Autentikasi & Middleware

### Middleware yang Digunakan

| Middleware | Deskripsi |
|-----------|-----------|
| `auth` | Memastikan pengguna sudah login |
| `verified` | Memastikan email sudah diverifikasi |
| `role:Admin` | Memastikan pengguna memiliki role Admin |
| `role:Dosen` | Memastikan pengguna memiliki role Dosen |
| `role:Mahasiswa` | Memastikan pengguna memiliki role Mahasiswa |

### CSRF Token
Semua request POST, PUT, PATCH, DELETE wajib menyertakan CSRF token:
```html
<meta name="csrf-token" content="{{ csrf_token() }}">
```

```javascript
// JavaScript
fetch(url, {
    method: 'POST',
    headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        'Content-Type': 'application/json',
    },
    body: JSON.stringify(data)
});
```

---

## 3. Role & Akses

| Role | Prefix URL | Akses |
|------|-----------|-------|
| **Admin** | `/admin` | Manajemen penuh sistem |
| **Dosen** | `/dosen` | Verifikasi mahasiswa bimbingan |
| **Mahasiswa** | `/dashboard`, `/rpks`, `/spks` | Pengajuan RPK & SPK |
| **Public** | `/`, `/statistik`, `/kontak` | Akses tanpa login |

---

## 4. Public Routes

### 4.1 Beranda (Welcome Page)

```
GET /
```

**Deskripsi:** Halaman beranda publik dengan statistik umum, chart, dan rekap prestasi terbaru.

**Response:** HTML View (`welcome.blade.php`)

**Data yang dikirim ke view:**
| Variable | Deskripsi |
|----------|-----------|
| `totalMahasiswa` | Jumlah total mahasiswa |
| `spkDraft` | Jumlah SPK dengan status draft |
| `spkDisetujui` | Jumlah SPK dengan status disetujui |
| `mahasiswaBerprestasi` | Jumlah mahasiswa yang memiliki SPK disetujui |
| `rekapPrestasi` | 10 SPK terbaru yang disetujui (dengan relasi user, kegiatan, prestasi) |

---

### 4.2 Statistik Publik

```
GET /statistik
```

**Deskripsi:** Halaman statistik publik dengan berbagai chart.

**Response:** HTML View (`statistik.blade.php`)

**Data yang dikirim ke view:**
| Variable | Deskripsi |
|----------|-----------|
| `totalMahasiswa` | Jumlah total mahasiswa |
| `spkDraft` | Jumlah SPK draft |
| `spkDisetujui` | Jumlah SPK disetujui |
| `rekapPrestasi` | 10 SPK terbaru yang disetujui |
| `chartLabels` | Label chart prestasi per prodi |
| `chartData` | Data chart prestasi per prodi |
| `tingkatLabels` | Label chart tingkat prestasi |
| `tingkatData` | Data chart tingkat prestasi |
| `jenisLabels` | Label chart jenis kegiatan |
| `jenisData` | Data chart jenis kegiatan |
| `trenBulanLabels` | Label bulan (Jan-Des) |
| `trenBulanData` | Data tren bulanan |
| `penyelenggaraLabels` | Label top 5 penyelenggara |
| `penyelenggaraData` | Data top 5 penyelenggara |

---

### 4.3 Halaman Kontak

```
GET /kontak
```

**Deskripsi:** Halaman kontak dengan informasi alamat, email, telepon, dan link terkait ISI Yogyakarta.

**Response:** HTML View (`kontak.blade.php`)

---

### 4.4 Sitemap XML

```
GET /sitemap.xml
```

**Deskripsi:** Mengembalikan sitemap XML untuk SEO.

**Response:** XML

**Daftar URL yang disertakan:**
| URL | Priority |
|-----|----------|
| `/` | 1.0 |
| `/statistik` | 0.8 |
| `/login` | 0.5 |
| `/register` | 0.5 |

---

## 5. Auth Routes

### 5.1 Registrasi

#### Tampilkan Form Registrasi
```
GET /register
```
**Middleware:** `guest`
**Response:** HTML View

#### Proses Registrasi
```
POST /register
```
**Middleware:** `guest`, `throttle:3,60`
**Rate Limit:** 3 request per 60 detik

**Request Body (multipart/form-data):**
| Field | Type | Required | Validasi |
|-------|------|----------|----------|
| `name` | string | ✅ | required |
| `nim` | string | ✅ | required, unique:users,nim |
| `prodi` | string | ✅ | required (untuk Mahasiswa) |
| `angkatan` | string | ✅ | required, max:4 (untuk Mahasiswa) |
| `semester` | string | ✅ | required, max:2 (untuk Mahasiswa) |
| `email` | string | ✅ | required, email, unique:users,email |
| `password` | string | ✅ | required, min:6 |
| `password_confirmation` | string | ✅ | required, same:password |

**Response (Success):** Redirect ke dashboard
**Response (Error):** Redirect back dengan error

---

### 5.2 Login

#### Tampilkan Form Login
```
GET /login
```
**Middleware:** `guest`
**Response:** HTML View

#### Proses Login
```
POST /login
```
**Middleware:** `guest`

**Request Body:**
| Field | Type | Required |
|-------|------|----------|
| `email` | string | ✅ |
| `password` | string | ✅ |
| `remember` | boolean | ❌ |

**Response (Success):** Redirect ke dashboard
**Response (Error):** Redirect back dengan error

---

### 5.3 Email Verification

#### Tampilkan Halaman Verifikasi
```
GET /email/verify
```
**Middleware:** `auth`
**Response:** HTML View

#### Verifikasi Email
```
GET /email/verify/{id}/{hash}
```
**Middleware:** `auth`, `signed`, `throttle:6,1`
**Rate Limit:** 6 request per 1 menit

**Response:** Redirect ke dashboard

#### Kirim Ulang Email Verifikasi
```
POST /email/verification-notification
```
**Middleware:** `auth`, `throttle:6,1`
**Rate Limit:** 6 request per 1 menit

**Response:** Redirect back dengan notifikasi

---

### 5.4 Reset Password

#### Tampilkan Form Lupa Password
```
GET /forgot-password
```
**Middleware:** `guest`
**Response:** HTML View

#### Kirim Link Reset Password
```
POST /forgot-password
```
**Middleware:** `guest`, `throttle:3,60`
**Rate Limit:** 3 request per 60 detik

**Request Body:**
| Field | Type | Required |
|-------|------|----------|
| `email` | string | ✅ |

**Response:** Redirect dengan notifikasi

#### Tampilkan Form Reset Password
```
GET /reset-password/{token}
```
**Middleware:** `guest`
**Response:** HTML View

#### Proses Reset Password
```
POST /reset-password
```
**Middleware:** `guest`

**Request Body:**
| Field | Type | Required | Validasi |
|-------|------|----------|----------|
| `token` | string | ✅ | hidden |
| `email` | string | ✅ | required, email |
| `password` | string | ✅ | required, min:6, confirmed |
| `password_confirmation` | string | ✅ | required |

**Response:** Redirect ke login

---

### 5.5 Konfirmasi Password

#### Tampilkan Form Konfirmasi
```
GET /confirm-password
```
**Middleware:** `auth`
**Response:** HTML View

#### Proses Konfirmasi
```
POST /confirm-password
```
**Middleware:** `auth`

**Request Body:**
| Field | Type | Required |
|-------|------|----------|
| `password` | string | ✅ |

**Response:** Redirect ke dashboard

---

### 5.6 Ganti Password

```
PUT /password
```
**Middleware:** `auth`

**Request Body:**
| Field | Type | Required | Validasi |
|-------|------|----------|----------|
| `current_password` | string | ✅ | required, current_password |
| `password` | string | ✅ | required, min:6, confirmed |
| `password_confirmation` | string | ✅ | required |

**Response:** Redirect back dengan notifikasi

---

### 5.7 Logout

```
POST /logout
```
**Middleware:** `auth`

**Response:** Redirect ke halaman login

---

## 6. Dashboard Routes

### 6.1 Dashboard (HTML)

```
GET /dashboard
```
**Middleware:** `auth`, `verified`

**Deskripsi:** Menampilkan dashboard sesuai role pengguna.

**Response:** HTML View (berbeda per role)
- Admin: `dashboard.admin`
- Dosen: `dashboard.dosen`
- Mahasiswa: `dashboard.mahasiswa`

**Data yang dikirim:**
- **Admin:** stats, tingkat chart, kategori chart, topMahasiswa, aktivitasTerbaru, rasio
- **Dosen:** stats (totalMahasiswa, rpkDraft, rpkDisetujui, rpkDitolak, spkDraft, spkDisetujui, spkDitolak)
- **Mahasiswa:** dosenPembimbing, kegiatanTerbaru, stats, tingkat chart, kategori chart, bulanan chart

---

### 6.2 Dashboard Realtime (JSON)

```
GET /dashboard/realtime
```
**Middleware:** `auth`, `verified`

**Deskripsi:** Mengembalikan data dashboard dalam format JSON untuk AJAX polling.

**Response (JSON):**
```json
{
    "role": "Admin|Dosen|Mahasiswa",
    "stats": { ... },
    "tingkat": { ... },
    "kategori": { ... },
    "bulanan": { ... },
    "aktivitasTerbaru": [ ... ]
}
```

---

## 7. Admin Routes

**Prefix:** `/admin` | **Middleware:** `auth`, `role:Admin` | **Name Prefix:** `admin.`

### 7.1 Dashboard Admin

```
GET /admin
```
**Name:** `admin.dashboard`
**Response:** Redirect ke `admin.users.index`

---

### 7.2 Manajemen User

#### Daftar Pengguna
```
GET /admin/users
```
**Name:** `admin.users.index`
**Middleware:** `auth`, `role:Admin`

**Query Parameters:**
| Parameter | Type | Deskripsi |
|-----------|------|-----------|
| `search` | string | Cari berdasarkan nama, NIM, email, prodi |
| `role` | string | Filter berdasarkan role |

**Response:** HTML View (`admin.daftar_pengguna.index`)

---

#### Tambah User
```
POST /admin/users
```
**Name:** `admin.users.store`
**Middleware:** `auth`, `role:Admin`

**Request Body:**
| Field | Type | Required | Validasi |
|-------|------|----------|----------|
| `name` | string | ✅ | required |
| `nim` | string | ✅ | required, unique:users,nim |
| `prodi` | string | ✅ | required (untuk Mahasiswa) |
| `angkatan` | string | ✅ | required, max:4 (untuk Mahasiswa) |
| `semester` | string | ✅ | required, max:2 (untuk Mahasiswa) |
| `email` | string | ✅ | required, email, unique:users,email |
| `password` | string | ✅ | required, min:6 |
| `role` | string | ✅ | required |

**Response (AJAX):**
```json
{
    "message": "success",
    "user": { ... }
}
```

---

#### Detail User
```
GET /admin/users/{user}
```
**Name:** `admin.users.show`
**Middleware:** `auth`, `role:Admin`

**Response (JSON):**
```json
{
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com",
    "nim": "12345678",
    "prodi": "Desain Interior",
    "angkatan": "2023",
    "semester": "3",
    "status": "aktif",
    "is_approved": true,
    "roles": [
        { "id": 2, "name": "Mahasiswa", "guard_name": "web" }
    ]
}
```

---

#### Update User
```
PUT/PATCH /admin/users/{user}
```
**Name:** `admin.users.update`
**Middleware:** `auth`, `role:Admin`

**Request Body:**
| Field | Type | Required | Validasi |
|-------|------|----------|----------|
| `name` | string | ✅ | required |
| `nim` | string | ✅ | required, unique:users,nim,{id} |
| `prodi` | string | ✅ | required (untuk Mahasiswa) |
| `angkatan` | string | ✅ | required, max:4 (untuk Mahasiswa) |
| `semester` | string | ✅ | required, max:2 (untuk Mahasiswa) |
| `email` | string | ✅ | required, email, unique:users,email,{id} |
| `role` | string | ✅ | required |

**Response (AJAX):**
```json
{
    "message": "updated",
    "user": { ... }
}
```

---

#### Hapus User
```
DELETE /admin/users/{user}
```
**Name:** `admin.users.destroy`
**Middleware:** `auth`, `role:Admin`

**Response (AJAX):**
```json
{
    "message": "deleted"
}
```

---

#### Update Role User
```
POST /admin/users/{user}/role
```
**Name:** `admin.users.role.update`
**Middleware:** `auth`, `role:Admin`

**Request Body:**
| Field | Type | Required |
|-------|------|----------|
| `role` | string | ✅ |

**Response (AJAX):**
```json
{
    "message": "success",
    "user": { ... }
}
```

---

#### Get Users Data (API)
```
GET /users-data
```
**Middleware:** `auth`, `role:Admin`

**Deskripsi:** Mengembalikan semua user dengan status aktif dalam format JSON.

**Response (JSON):**
```json
[
    {
        "id": 1,
        "name": "John Doe",
        "email": "john@example.com",
        "nim": "12345678",
        "prodi": "Desain Interior",
        "status": "aktif",
        ...
    }
]
```

---

### 7.3 Dosen Pembimbing

#### Daftar Mahasiswa Tanpa Dosen
```
GET /admin/pembimbing
```
**Name:** `admin.pembimbing.index`
**Middleware:** `auth`, `role:Admin`

**Query Parameters:**
| Parameter | Type | Deskripsi |
|-----------|------|-----------|
| `search` | string | Cari berdasarkan nama, NIM |

**Response:** HTML View (`admin.pembimbing.index`)

---

#### Atur Dosen Pembimbing
```
POST /admin/pembimbing/set
```
**Name:** `admin.pembimbing.set`
**Middleware:** `auth`, `role:Admin`

**Request Body:**
| Field | Type | Required | Validasi |
|-------|------|----------|----------|
| `mahasiswa_id` | integer | ✅ | required, exists:users,id |
| `dosen_id` | integer | ❌ | nullable |

**Response (AJAX):**
```json
{
    "success": true,
    "message": "Dosen pembimbing berhasil diatur.",
    "dosen_name": "Dr. John Doe"
}
```

---

### 7.4 Master Kegiatan

#### Daftar Master Kegiatan
```
GET /admin/kegiatan
```
**Name:** `admin.kegiatan.index`
**Middleware:** `auth`, `role:Admin`

**Response:** HTML View

---

#### Tambah Master Kegiatan
```
POST /admin/kegiatan
```
**Name:** `admin.kegiatan.store`
**Middleware:** `auth`, `role:Admin`

**Request Body:**
| Field | Type | Required | Validasi |
|-------|------|----------|----------|
| `nama_kegiatan` | string | ✅ | required |
| `status` | enum | ❌ | aktif/tidak aktif |

**Response (AJAX):**
```json
{
    "message": "success",
    "data": { ... }
}
```

---

#### Update Master Kegiatan
```
PUT/PATCH /admin/kegiatan/{kegiatan}
```
**Name:** `admin.kegiatan.update`
**Middleware:** `auth`, `role:Admin`

**Request Body:**
| Field | Type | Required |
|-------|------|----------|
| `nama_kegiatan` | string | ✅ |
| `status` | enum | ❌ |

**Response (AJAX):**
```json
{
    "message": "updated",
    "data": { ... }
}
```

---

#### Hapus Master Kegiatan
```
DELETE /admin/kegiatan/{kegiatan}
```
**Name:** `admin.kegiatan.destroy`
**Middleware:** `auth`, `role:Admin`

**Response (AJAX):**
```json
{
    "message": "deleted"
}
```

---

### 7.5 Program Studi

#### Daftar Program Studi
```
GET /admin/prodi
```
**Name:** `admin.prodi.index`
**Middleware:** `auth`, `role:Admin`

**Response:** HTML View

---

#### Tambah Program Studi
```
POST /admin/prodi
```
**Name:** `admin.prodi.store`
**Middleware:** `auth`, `role:Admin`

**Request Body:**
| Field | Type | Required | Validasi |
|-------|------|----------|----------|
| `nama_prodi` | string | ✅ | required |
| `fakultas` | string | ❌ | nullable |
| `status` | enum | ❌ | aktif/tidak aktif |

**Response (AJAX):**
```json
{
    "message": "success",
    "data": { ... }
}
```

---

#### Update Program Studi
```
PUT/PATCH /admin/prodi/{prodi}
```
**Name:** `admin.prodi.update`
**Middleware:** `auth`, `role:Admin`

**Request Body:**
| Field | Type | Required |
|-------|------|----------|
| `nama_prodi` | string | ✅ |
| `fakultas` | string | ❌ |
| `status` | enum | ❌ |

**Response (AJAX):**
```json
{
    "message": "updated",
    "data": { ... }
}
```

---

#### Hapus Program Studi
```
DELETE /admin/prodi/{prodi}
```
**Name:** `admin.prodi.destroy`
**Middleware:** `auth`, `role:Admin`

**Response (AJAX):**
```json
{
    "message": "deleted"
}
```

---

#### Toggle Status Program Studi
```
PATCH /admin/prodi/{prodi}/toggle-status
```
**Name:** `admin.prodi.toggle-status`
**Middleware:** `auth`, `role:Admin`

**Response (AJAX):**
```json
{
    "message": "updated",
    "data": { ... }
}
```

---

### 7.7 RPK Mahasiswa (Admin)

#### Daftar RPK
```
GET /admin/rpk
```
**Name:** `admin.rpk.index`
**Middleware:** `auth`, `role:Admin`

**Query Parameters:**
| Parameter | Type | Deskripsi |
|-----------|------|-----------|
| `search` | string | Cari berdasarkan nama/NIM mahasiswa atau nama kegiatan |
| `status` | string | Filter berdasarkan status (draft/disetujui/ditolak) |
| `dosen_id` | string | Filter berdasarkan dosen pembimbing (atau `tanpa_dosen`) |

**Response:** HTML View (`admin.rpk.index`)

---

#### Detail RPK
```
GET /admin/rpk/{rpk}
```
**Name:** `admin.rpk.show`
**Middleware:** `auth`, `role:Admin`

**Response:** HTML View (`admin.rpk.show`)

---

#### Update Status RPK
```
PATCH /admin/rpk/{rpk}/status
```
**Name:** `admin.rpk.update-status`
**Middleware:** `auth`, `role:Admin`

**Request Body:**
| Field | Type | Required | Validasi |
|-------|------|----------|----------|
| `status` | enum | ✅ | in:draft,disetujui,ditolak |
| `catatan` | string | ❌ | nullable, max:500 |

**Response (AJAX):**
```json
{
    "success": true,
    "message": "Status RPK berhasil diubah menjadi DISETUJUI"
}
```

---

### 7.8 SPK Mahasiswa (Admin)

#### Daftar SPK
```
GET /admin/spk
```
**Name:** `admin.spk.index`
**Middleware:** `auth`, `role:Admin`

**Query Parameters:**
| Parameter | Type | Deskripsi |
|-----------|------|-----------|
| `tahun` | string | Filter berdasarkan tahun |
| `status` | string | Filter berdasarkan status |
| `search` | string | Cari berdasarkan nama/NIM mahasiswa atau nama kegiatan |

**Response:** HTML View (`admin.spk.index`)

---

#### Detail SPK
```
GET /admin/spk/{spk}
```
**Name:** `admin.spk.show`
**Middleware:** `auth`, `role:Admin`

**Response:** HTML View (`admin.spk.show`)

---

#### Setujui SPK
```
POST /admin/spk/{spk}/approve
```
**Name:** `admin.spk.approve`
**Middleware:** `auth`, `role:Admin`

**Request Body:**
| Field | Type | Required | Validasi |
|-------|------|----------|----------|
| `catatan` | string | ❌ | nullable, max:500 |

**Response (AJAX):**
```json
{
    "success": true,
    "message": "SPK berhasil disetujui"
}
```

---

#### Tolak SPK
```
POST /admin/spk/{spk}/reject
```
**Name:** `admin.spk.reject`
**Middleware:** `auth`, `role:Admin`

**Request Body:**
| Field | Type | Required | Validasi |
|-------|------|----------|----------|
| `catatan` | string | ✅ | required, max:500 |

**Response (AJAX):**
```json
{
    "success": true,
    "message": "SPK berhasil ditolak"
}
```

---

#### Hapus SPK
```
DELETE /admin/spk/{spk}
```
**Name:** `admin.spk.destroy`
**Middleware:** `auth`, `role:Admin`

**Response:** Redirect dengan notifikasi

---

#### Tambah Poin SPK
```
POST /admin/spk/{spk}/tambah-poin
```
**Name:** `admin.spk.tambah-poin`
**Middleware:** `auth`, `role:Admin`

**Request Body:**
| Field | Type | Required | Validasi |
|-------|------|----------|----------|
| `poin` | integer | ✅ | required, min:1, max:100 |

**Response (AJAX):**
```json
{
    "success": true,
    "message": "Poin sebesar 10 berhasil ditambahkan!"
}
```

---

#### Edit Poin SPK
```
POST /admin/spk/{spk}/edit-poin
```
**Name:** `admin.spk.edit-poin`
**Middleware:** `auth`, `role:Admin`

**Request Body:**
| Field | Type | Required | Validasi |
|-------|------|----------|----------|
| `poin` | integer | ✅ | required, min:1, max:100 |

**Response (AJAX):**
```json
{
    "success": true,
    "message": "Poin berhasil diupdate menjadi 15!"
}
```

---

### 7.9 Laporan (Admin)

#### Daftar Laporan
```
GET /admin/laporan
```
**Name:** `admin.laporan.index`
**Middleware:** `auth`, `role:Admin`

**Query Parameters:**
| Parameter | Type | Deskripsi |
|-----------|------|-----------|
| `search` | string | Cari berdasarkan nama, NIM, judul, penyelenggara |
| `tahun` | string | Filter berdasarkan tahun |
| `prodi` | string | Filter berdasarkan program studi |
| `tingkat` | string | Filter berdasarkan tingkat |

**Response:** HTML View (`admin.laporan.index`)

---

#### Export CSV
```
GET /admin/laporan/export
```
**Name:** `admin.laporan.export`
**Middleware:** `auth`, `role:Admin`

**Response:** File download (CSV)

---

#### Export PDF
```
GET /admin/laporan/export-pdf
```
**Name:** `admin.laporan.export-pdf`
**Middleware:** `auth`, `role:Admin`

**Response:** File download (PDF, landscape A4)

---

#### Export Excel
```
GET /admin/laporan/export-excel
```
**Name:** `admin.laporan.export-excel`
**Middleware:** `auth`, `role:Admin`

**Response:** File download (XLSX, multi-sheet per fakultas)

---

## 8. Dosen Routes

**Prefix:** `/dosen` | **Middleware:** `auth`, `role:Dosen` | **Name Prefix:** `dosen.`

### 8.1 RPK (Dosen)

#### Daftar RPK Mahasiswa Bimbingan
```
GET /dosen/rpk
```
**Name:** `dosen.rpk.index`
**Middleware:** `auth`, `role:Dosen`

**Query Parameters:**
| Parameter | Type | Deskripsi |
|-----------|------|-----------|
| `search` | string | Cari berdasarkan status, tahun, semester, nama/NIM mahasiswa, nama kegiatan |
| `tahun` | string | Filter tahun |
| `semester` | string | Filter semester |
| `status` | string | Filter status |

**Response:** HTML View (`dosen.rpk.index`)

---

#### Detail RPK
```
GET /dosen/rpk/{rpk}
```
**Name:** `dosen.rpk.show`
**Middleware:** `auth`, `role:Dosen`

**Response:** HTML View (`dosen.rpk.show`)

---

#### Setujui RPK
```
PUT /dosen/rpk/{rpk}/approve
```
**Name:** `dosen.rpk.approve`
**Middleware:** `auth`, `role:Dosen`

**Request Body:**
| Field | Type | Required | Validasi |
|-------|------|----------|----------|
| `catatan_dosen` | string | ❌ | nullable |

**Response (AJAX):**
```json
{
    "success": true,
    "message": "RPK berhasil disetujui"
}
```

---

#### Tolak RPK
```
PUT /dosen/rpk/{rpk}/reject
```
**Name:** `dosen.rpk.reject`
**Middleware:** `auth`, `role:Dosen`

**Request Body:**
| Field | Type | Required | Validasi |
|-------|------|----------|----------|
| `catatan_dosen` | string | ✅ | required |

**Response (AJAX):**
```json
{
    "success": true,
    "message": "RPK berhasil ditolak"
}
```

---

### 8.2 SPK (Dosen)

#### Daftar SPK Mahasiswa Bimbingan
```
GET /dosen/spk
```
**Name:** `dosen.spk.index`
**Middleware:** `auth`, `role:Dosen`

**Query Parameters:**
| Parameter | Type | Deskripsi |
|-----------|------|-----------|
| `search` | string | Cari berdasarkan status, nama/NIM mahasiswa, nama kegiatan, tahun, semester |
| `tahun` | string | Filter tahun |
| `status` | string | Filter status |

**Response:** HTML View (`dosen.spk.index`)

---

#### Detail SPK
```
GET /dosen/spk/{spk}
```
**Name:** `dosen.spk.show`
**Middleware:** `auth`, `role:Dosen`

**Response:** HTML View (`dosen.spk.show`)

---

#### Setujui SPK
```
PUT /dosen/spk/{spk}/approve
```
**Name:** `dosen.spk.approve`
**Middleware:** `auth`, `role:Dosen`

**Request Body:**
| Field | Type | Required | Validasi |
|-------|------|----------|----------|
| `catatan_dosen` | string | ❌ | nullable |

**Response (AJAX):**
```json
{
    "success": true,
    "message": "SPK berhasil disetujui"
}
```

---

#### Tolak SPK
```
PUT /dosen/spk/{spk}/reject
```
**Name:** `dosen.spk.reject`
**Middleware:** `auth`, `role:Dosen`

**Request Body:**
| Field | Type | Required | Validasi |
|-------|------|----------|----------|
| `catatan_dosen` | string | ✅ | required |

**Response (AJAX):**
```json
{
    "success": true,
    "message": "SPK berhasil ditolak"
}
```

---

### 8.3 Mahasiswa Bimbingan

#### Daftar Mahasiswa Bimbingan
```
GET /dosen/mahasiswa
```
**Name:** `dosen.mahasiswa.index`
**Middleware:** `auth`, `role:Dosen`

**Response:** HTML View (`dosen.mahasiswa.index`)

---

### 8.4 Laporan (Dosen)

#### Daftar Laporan
```
GET /dosen/laporan
```
**Name:** `dosen.laporan.index`
**Middleware:** `auth`, `role:Dosen`

**Query Parameters:**
| Parameter | Type | Deskripsi |
|-----------|------|-----------|
| `search` | string | Cari berdasarkan nama, NIM, judul, penyelenggara |
| `tahun` | string | Filter tahun |
| `fakultas` | string | Filter fakultas |
| `prodi` | string | Filter program studi |
| `tingkat` | string | Filter tingkat |

**Response:** HTML View (`dosen.laporan.index`)

---

#### Export CSV
```
GET /dosen/laporan/export
```
**Name:** `dosen.laporan.export`
**Middleware:** `auth`, `role:Dosen`

**Response:** File download (CSV)

---

#### Export Excel
```
GET /dosen/laporan/export-excel
```
**Name:** `dosen.laporan.export-excel`
**Middleware:** `auth`, `role:Dosen`

**Response:** File download (XLSX, multi-sheet per fakultas)

---

#### Export PDF
```
GET /dosen/laporan/export-pdf
```
**Name:** `dosen.laporan.export-pdf`
**Middleware:** `auth`, `role:Dosen`

**Response:** File download (PDF, landscape A4)

---

## 6. Dashboard Routes

### 6.1 Dashboard Index

```
GET /dashboard
```

**Middleware:** `auth`, `verified`
**Name:** `dashboard`

**Deskripsi:** Dashboard utama per role (Admin/Dosen/Mahasiswa). Redirect otomatis ke view yang sesuai.

**Response:** HTML View (`dashboard.admin` / `dashboard.dosen` / `dashboard.mahasiswa`)

**Data yang dikirim ke view (Mahasiswa):**

| Variable | Type | Deskripsi |
|----------|------|-----------|
| `dosenPembimbing` | User|null | Dosen pembimbing dari RPK terbaru |
| `dosenKegiatan` | Collection | Kegiatan grouped by dosen pembimbing |
| `rpkDraft` | int | Jumlah RPK draft |
| `rpkDisetujui` | int | Jumlah RPK disetujui |
| `spkDraft` | int | Jumlah SPK draft |
| `spkDisetujui` | int | Jumlah SPK disetujui |
| `totalPoin` | int | Total poin (owner + anggota) |
| `poinProfesional` | int | Poin Bidang Profesional |
| `poinKepribadian` | int | Poin Bidang Kepribadian & Sosial |
| `syaratTerpenuhi` | bool | Apakah syarat minimal terpenuhi |
| `predikat` | string | Predikat (Unggul/Sangat Baik/Baik/Cukup/Belum Memenuhi Syarat) |
| `predikatColor` | string | Warna Tailwind (emerald/blue/amber/orange/red) |
| `totalKegiatan` | int | Total RPK+SPK disetujui |
| `persentase` | int | Persentase disetujui |
| `jumlahDitolak` | int | Jumlah ditolak |
| `kegiatanTerbaru` | Collection | 5 kegiatan terbaru |
| `tingkat` | Collection | Chart tingkat prestasi |
| `kategoriLabels` | array | Label chart kategori |
| `kategoriData` | array | Data chart kategori |
| `bulanLabels` | array | Label chart bulanan |
| `bulanData` | array | Data chart bulanan |

**Struktur `dosenKegiatan`:**
```json
[
    {
        "dosen": { "id": 1, "name": "Dr. John Doe", ... },
        "kegiatans": [
            {
                "id": 1,
                "judul_kegiatan": "Kompetisi Desain",
                "kegiatan": "Kompetisi Desain Interior",
                "status": "disetujui",
                "kkmRule": {
                    "bidang": "Bidang Orientasi Kompetensi Profesional",
                    "jenis_kegiatan": "Kompetisi sesuai dengan bidang keilmuan"
                }
            }
        ]
    }
]
```

### 6.2 Dashboard Realtime

```
GET /dashboard/realtime
```

**Middleware:** `auth`, `verified`
**Name:** `dashboard.realtime`

**Deskripsi:** Endpoint AJAX untuk realtime polling dashboard (30 detik interval). Mengembalikan JSON stats terbaru.

**Response (Mahasiswa):**
```json
{
    "role": "Mahasiswa",
    "stats": {
        "rpkDraft": 2,
        "rpkDisetujui": 5,
        "spkDraft": 1,
        "spkDisetujui": 3,
        "totalPoin": 85,
        "poinProfesional": 45,
        "poinKepribadian": 40,
        "syaratTerpenuhi": true,
        "predikat": "Baik",
        "predikatColor": "amber",
        "totalKegiatan": 8,
        "persentase": 80,
        "jumlahDitolak": 2,
        "draft": 3,
        "disetujui": 8,
        "ditolak": 2
    },
    "tingkat": { "Universitas": 5, "Regional": 3 },
    "kategori": { "kategoriLabels": [...], "kategoriData": [...] },
    "bulanan": { "bulanLabels": [...], "bulanData": [...] }
}
```

**Response (Admin):**
```json
{
    "role": "Admin",
    "stats": { ... },
    "tingkat": { ... },
    "kategori": { ... },
    "aktivitasTerbaru": [ ... ]
}
```

**Response (Dosen):**
```json
{
    "role": "Dosen",
    "stats": { ... }
}
```

---

## 6.3 Dashboard Service Endpoints (Internal)

### 6.3.1 Get Mahasiswa Dosen Kegiatan

```
GET /dashboard/dosen-kegiatan (Internal Service Method)
```

**Method:** `DashboardService::getMahasiswaDosenKegiatan($userId)`

**Deskripsi:** Mengambil semua kegiatan mahasiswa grouped by dosen pembimbing.

**Return:** `Collection<['dosen' => User, 'kegiatans' => Collection]>`

**Query:**
```php
Kegiatan::whereHas('rpk', fn($q) => $q->where('user_id', $userId))
    ->with(['rpk.dosenPembimbing', 'kkmRule'])
    ->latest()
    ->get()
    ->groupBy(fn($k) => $k->rpk?->dosenPembimbing?->id ?? 'tanpa-dosen')
    ->map(fn($k, $id) => ['dosen' => $k->first()?->rpk?->dosenPembimbing, 'kegiatans' => $k])
    ->filter(fn($v) => $v['dosen'] !== null)
    ->values();
```

---

## 9. Mahasiswa Routes

### 9.1 RPK (Mahasiswa)

#### Daftar RPK
```
GET /rpks
```
**Name:** `rpks.index`
**Middleware:** `auth`, `verified`, `role:Mahasiswa`

**Query Parameters:**
| Parameter | Type | Deskripsi |
|-----------|------|-----------|
| `tahun` | string | Filter tahun |
| `semester` | string | Filter semester |
| `status` | string | Filter status |

**Response:** HTML View (`mahasiswa.rpks.index`)

---

#### Buat RPK
```
POST /rpks
```
**Name:** `rpks.store`
**Middleware:** `auth`, `verified`, `role:Mahasiswa`

**Request Body:**
| Field | Type | Required | Validasi |
|-------|------|----------|----------|
| `tahun` | string | ✅ | required |
| `semester` | string | ✅ | required |

**Response (AJAX):**
```json
{
    "success": true,
    "message": "RPK berhasil dibuat",
    "data": { ... }
}
```

---

#### Detail RPK
```
GET /rpks/{rpk}
```
**Name:** `rpks.show`
**Middleware:** `auth`, `verified`, `role:Mahasiswa`

**Response:** HTML View (`mahasiswa.rpks.show`)

---

#### Edit RPK
```
GET /rpks/{rpk}/edit
```
**Name:** `rpks.edit`
**Middleware:** `auth`, `verified`, `role:Mahasiswa`

**Response:** Redirect ke `rpks.show` dengan pesan error

---

#### Update RPK
```
PUT/PATCH /rpks/{rpk}
```
**Name:** `rpks.update`
**Middleware:** `auth`, `verified`, `role:Mahasiswa`

**Request Body:**
| Field | Type | Required | Validasi |
|-------|------|----------|----------|
| `tahun` | string | ✅ | required |
| `semester` | string | ✅ | required |

**Response:** Redirect ke `rpks.index`

---

#### Hapus RPK
```
DELETE /rpks/{rpk}
```
**Name:** `rpks.destroy`
**Middleware:** `auth`, `verified`, `role:Mahasiswa`

**Response (AJAX):**
```json
{
    "success": true,
    "message": "RPK berhasil dihapus"
}
```

---

### 9.2 Kegiatan (Mahasiswa)

#### Tambah Kegiatan
```
GET /rpks/{rpk}/kegiatans/create
```
**Name:** `kegiatans.create`
**Middleware:** `auth`, `verified`, `role:Mahasiswa`

**Response:** Redirect ke `rpks.show` dengan pesan error

---

#### Simpan Kegiatan
```
POST /rpks/{rpk}/kegiatans
```
**Name:** `kegiatans.store`
**Middleware:** `auth`, `verified`, `role:Mahasiswa`

**Request Body:**
| Field | Type | Required | Validasi |
|-------|------|----------|----------|
| `judul_kegiatan` | string | ✅ | required, max:255 |
| `tanggal_mulai` | date | ✅ | required, date |
| `tanggal_selesai` | date | ✅ | required, date, after_or_equal:tanggal_mulai |
| `kategori` | enum | ✅ | in:Individu,Kelompok |
| `peran` | string | ❌ | nullable, max:255 |
| `jumlah_anggota` | integer | ❌ | nullable, min:1 |
| `anggota_ids` | string | ❌ | nullable (comma-separated user IDs) |

**Response (AJAX):**
```json
{
    "success": true,
    "message": "Kegiatan berhasil ditambahkan",
    "data": { ... }
}
```

---

#### Edit Kegiatan
```
GET /kegiatan/{kegiatan}/edit
```
**Name:** `kegiatans.edit`
**Middleware:** `auth`, `verified`, `role:Mahasiswa`

**Response (JSON):**
```json
{
    "success": true,
    "data": { ... }
}
```

---

#### Update Kegiatan
```
PUT /kegiatan/{kegiatan}
```
**Name:** `kegiatans.update`
**Middleware:** `auth`, `verified`, `role:Mahasiswa`

**Request Body:** (sama seperti store)

**Response (AJAX):**
```json
{
    "success": true,
    "message": "Kegiatan berhasil diperbarui",
    "data": { ... }
}
```

---

#### Hapus Kegiatan
```
DELETE /kegiatans/{kegiatan}
```
**Name:** `kegiatans.destroy`
**Middleware:** `auth`, `verified`, `role:Mahasiswa`

**Response (AJAX):**
```json
{
    "success": true,
    "message": "Kegiatan berhasil dihapus"
}
```

---

### 9.3 SPK (Mahasiswa)

#### Daftar SPK
```
GET /spks
```
**Name:** `spks.index`
**Middleware:** `auth`, `verified`, `role:Mahasiswa`

**Query Parameters:**
| Parameter | Type | Deskripsi |
|-----------|------|-----------|
| `tahun` | string | Filter tahun |
| `status` | string | Filter status |

**Response:** HTML View (`mahasiswa.spks.index`)

---

#### Buat SPK
```
GET /spks/create
```
**Name:** `spks.create`
**Middleware:** `auth`, `verified`, `role:Mahasiswa`

**Response:** Redirect ke `spks.index` dengan pesan error

---

#### Simpan SPK
```
POST /spks
```
**Name:** `spks.store`
**Middleware:** `auth`, `verified`, `role:Mahasiswa`

**Request Body (multipart/form-data):**
| Field | Type | Required | Validasi |
|-------|------|----------|----------|
| `tahun` | string | ✅ | required |
| `rpk_id` | integer | ✅ | required |
| `kegiatan_id` | integer | ✅ | required |
| `penyelenggara` | string | ✅ | required |
| `kategori` | enum | ✅ | in:Individu,Kelompok |

| `judul_karya` | string | ✅ | required, max:255 |
| `biografi` | string | ❌ | nullable, max:2000 |
| `rincian` | string | ❌ | nullable, max:3000 |
| `kebaruan` | string | ❌ | nullable, max:2000 |
| `url_kegiatan` | string | ✅ | required, url, max:500 |
| `link_drive` | string | ✅ | required, url, max:500 |
| `surat_tugas` | file | ✅ | required, mimes:pdf, max:5120 |
| `sertifikat` | file | ✅ | required, mimes:pdf,jpg,jpeg,png, max:5120 |
| `foto_penyerahan` | file | ✅ | required, mimes:jpg,jpeg,png, max:5120 |
| `laporan` | file | ✅ | required, mimes:pdf, max:5120 |

**Response (AJAX Success):**
```json
{
    "success": true,
    "message": "SPK berhasil ditambahkan"
}
```

**Response (AJAX Error - Duplikasi):**
```json
{
    "success": false,
    "message": "Anda sudah menginput maksimal 4 kegiatan dengan jenis yang sama (Kompetisi sesuai dengan bidang keilmuan) di bidang ini."
}
```

**Response (AJAX Error - File Wajib):**
```json
{
    "message": "The given data was invalid.",
    "errors": {
        "surat_tugas": ["File Makalah wajib diupload untuk peran/sifat ini."]
    }
}
```

---

#### Detail SPK
```
GET /spks/{spk}
```
**Name:** `spks.show`
**Middleware:** `auth`, `verified`, `role:Mahasiswa`

**Response:** HTML View (`mahasiswa.spks.show`)

---

#### Edit SPK
```
GET /spks/{spk}/edit
```
**Name:** `spks.edit`
**Middleware:** `auth`, `verified`, `role:Mahasiswa`

**Response:** Redirect ke `spks.index` dengan pesan error

---

#### Update SPK
```
PUT/PATCH /spks/{spk}
```
**Name:** `spks.update`
**Middleware:** `auth`, `verified`, `role:Mahasiswa`

**Request Body (multipart/form-data):**
| Field | Type | Required | Validasi |
|-------|------|----------|----------|
| `tahun` | string | ✅ | required |
| `rpk_id` | integer | ✅ | required |
| `kegiatan_id` | integer | ✅ | required |
| `penyelenggara` | string | ✅ | required |
| `kategori` | enum | ✅ | in:Individu,Kelompok |

| `judul_karya` | string | ✅ | required, max:255 |
| `biografi` | string | ❌ | nullable, max:2000 |
| `rincian` | string | ❌ | nullable, max:3000 |
| `kebaruan` | string | ❌ | nullable, max:2000 |
| `url_kegiatan` | string | ✅ | required, url, max:500 |
| `link_drive` | string | ✅ | required, url, max:500 |
| `surat_tugas` | file | ❌ | nullable, mimes:pdf, max:5120 |
| `sertifikat` | file | ❌ | nullable, mimes:pdf,jpg,jpeg,png, max:5120 |
| `foto_penyerahan` | file | ❌ | nullable, mimes:jpg,jpeg,png, max:5120 |
| `laporan` | file | ❌ | nullable, mimes:pdf, max:5120 |

**Response (AJAX):**
```json
{
    "success": true,
    "message": "SPK berhasil diperbaiki dan diajukan ulang"
}
```

---

#### Hapus SPK
```
DELETE /spks/{spk}
```
**Name:** `spks.destroy`
**Middleware:** `auth`, `verified`, `role:Mahasiswa`

**Response (AJAX):**
```json
{
    "success": true,
    "message": "SPK berhasil dihapus"
}
```

---

## 10. Response Pattern

### 10.1 AJAX Success Response

Semua endpoint AJAX yang berhasil mengembalikan response dengan pola berikut:

```json
{
    "success": true,
    "message": "Deskripsi keberhasilan",
    "data": { ... }  // opsional
}
```

### 10.2 AJAX Error Response

```json
{
    "success": false,
    "message": "Deskripsi error"
}
```

### 10.3 Validation Error Response

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "field_name": ["Error message 1", "Error message 2"]
    }
}
```

### 10.4 HTTP Status Codes

| Code | Deskripsi |
|------|-----------|
| 200 | OK — Request berhasil |
| 201 | Created — Resource berhasil dibuat |
| 302 | Redirect — Redirect setelah operasi berhasil |
| 401 | Unauthorized — Belum login |
| 403 | Forbidden — Tidak memiliki akses |
| 404 | Not Found — Resource tidak ditemukan |
| 422 | Unprocessable Entity — Validasi gagal |
| 429 | Too Many Requests — Rate limit terlampaui |
| 500 | Internal Server Error — Error server |

---

## 11. Error Handling

### 11.1 Authorization Errors

- **403 Forbidden** dikembalikan ketika:
  - Mahasiswa mencoba mengakses RPK/SPK milik pengguna lain
  - Dosen mencoba memverifikasi RPK/SPK yang bukan bimbingannya
  - Pengguna tanpa role yang sesuai mencoba mengakses endpoint khusus role

### 11.2 Validation Errors

- **422 Unprocessable Entity** dikembalikan ketika:
  - Field wajib tidak diisi
  - Format file tidak sesuai (harus PDF/JPG/PNG)
  - Ukuran file melebihi 5MB
  - URL tidak valid
  - Data tidak ditemukan di database (foreign key)
  - **Duplikasi kegiatan**: Melebihi maksimal 4 kegiatan sama (same `jenis_kegiatan` + `bidang`) per mahasiswa
  - **File wajib hilang**: File yang diperlukan berdasarkan `bidang` + `jenis_kegiatan` + `peran` tidak diupload

### 11.3 Rate Limiting

- Register: 3 request per 60 detik
- Email verification: 6 request per 1 menit
- Forgot password: 3 request per 60 detik

---

## 📌 Catatan Penting

1. **CSRF Protection**: Semua form POST/PUT/DELETE wajib menggunakan CSRF token
2. **Email Verification**: Pengguna harus memverifikasi email sebelum mengakses dashboard
3. **File Upload**: Maksimal 5MB per file, format PDF/JPG/JPEG/PNG
4. **AJAX Pattern**: Aplikasi menggunakan pola AJAX untuk operasi CRUD — response selalu JSON
5. **Role-based Access**: Middleware `role:` digunakan untuk membatasi akses berdasarkan role
6. **Caching**: Dashboard admin menggunakan cache (5 menit) yang di-clear saat ada perubahan data
7. **Email Notifications**: Sistem mengirim email otomatis untuk verifikasi, notifikasi status, dan plotting dosen
