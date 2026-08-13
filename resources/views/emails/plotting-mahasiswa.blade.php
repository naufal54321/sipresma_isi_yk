@component('mail::message')
# Halo, {{ $dosen->name }}!

Kami informasikan bahwa **mahasiswa baru telah ditetapkan sebagai mahasiswa bimbingan Anda** melalui sistem PRATAMA.

### Detail Mahasiswa

@component('mail::table')
| Keterangan | Detail |
| --- | --- |
| **Nama Mahasiswa** | {{ $mahasiswa->name ?? '-' }} |
| **NIM** | {{ $mahasiswa->nim ?? '-' }} |
| **Program Studi** | {{ $mahasiswa->prodi ?? '-' }} |
| **Angkatan** | {{ $mahasiswa->angkatan ?? '-' }} |
@endcomponent

Mohon untuk dapat memantau dan memberikan tindak lanjut terhadap **pengajuan RPK dan SPK** dari mahasiswa tersebut melalui sistem PRATAMA.

@component('mail::button', ['url' => route('dosen.mahasiswa.index')])
Lihat Daftar Mahasiswa Bimbingan →
@endcomponent

Terima kasih atas perhatian dan kerja sama Anda.

**PRATAMA**<br>
Sistem Informasi Prestasi dan Talenta Mahasiswa<br>
UPA TIK – Institut Seni Indonesia Yogyakarta
@endcomponent