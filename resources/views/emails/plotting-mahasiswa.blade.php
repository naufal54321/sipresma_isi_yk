@component('mail::message')
# Halo, {{ $dosen->name }}!

Kami informasikan bahwa Anda telah ditetapkan sebagai **dosen pembimbing** untuk Rencana Prestasi Kemahasiswaan (RPK) berikut melalui sistem PRATAMA.

### Detail RPK

@component('mail::table')
| Keterangan | Detail |
| --- | --- |
| **Nama Mahasiswa** | {{ $rpk->user->name ?? '-' }} |
| **NIM** | {{ $rpk->user->nim ?? '-' }} |
| **Program Studi** | {{ $rpk->user->prodi ?? '-' }} |
| **Tahun / Semester** | {{ $rpk->tahun ?? '-' }} / {{ $rpk->semester ?? '-' }} |
@endcomponent

Mohon untuk dapat memantau dan memberikan tindak lanjut terhadap **pengajuan RPK dan SPK** dari mahasiswa tersebut melalui sistem PRATAMA.

@component('mail::button', ['url' => route('admin.rpk.show', $rpk->id)])
Lihat Detail RPK
@endcomponent

Terima kasih atas perhatian dan kerja sama Anda.

**PRATAMA**<br>
Sistem Informasi Prestasi dan Talenta Mahasiswa<br>
UPA TIK – Institut Seni Indonesia Yogyakarta
@endcomponent