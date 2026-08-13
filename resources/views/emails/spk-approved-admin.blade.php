@component('mail::message')
# Halo, Admin!

SPK berikut telah **disetujui**. Silakan tambahkan poin bagi mahasiswa melalui sistem:

@component('mail::table')
| Detail | Keterangan |
| --- | --- |
| **Nama Mahasiswa** | {{ $spk->user->name ?? '-' }} |
| **NIM** | {{ $spk->user->nim ?? '-' }} |
| **Judul Karya** | {{ $spk->judul_karya ?? '-' }} |
| **Kategori** | {{ $spk->kategori ?? '-' }} |
| **Tahun** | {{ $spk->tahun ?? '-' }} |
@endcomponent

@component('mail::button', ['url' => route('admin.spk.show', $spk->id)])
Tambah Poin
@endcomponent

Terima kasih,<br>
{{ config('app.name') }}
@endcomponent