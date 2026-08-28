@component('mail::message')
# Halo, {{ $dosen->name ?? 'Dosen' }}!

Mahasiswa bimbingan Anda mengajukan Sertifikat Prestasi Kegiatan (SPK) baru:

@component('mail::table')
| Detail | Keterangan |
| --- | --- |
| **Nama Mahasiswa** | {{ $spk->user->name ?? '-' }} |
| **NIM** | {{ $spk->user->nim ?? '-' }} |
| **Program Studi** | {{ $spk->user->prodi ?? '-' }} |
| **Judul Karya** | {{ $spk->judul_karya ?? '-' }} |
| **Kegiatan** | {{ $spk->kegiatan?->judul_kegiatan ?? $spk->kegiatan?->kegiatan ?? '-' }} |
| **Kategori** | {{ $spk->kategori ?? '-' }} |
| **Poin KKM** | {{ $spk->poin ?? 0 }} |
@endcomponent

Silakan tinjau SPK tersebut dan lakukan persetujuan atau penolakan melalui sistem.

@component('mail::button', ['url' => route('spks.show', $spk->id)])
Lihat Detail SPK
@endcomponent

Terima kasih,<br>
{{ config('app.name') }}
@endcomponent