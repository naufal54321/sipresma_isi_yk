@component('mail::message')
# Halo, {{ $spk->user->name ?? 'Mahasiswa' }}!

@if($status === 'disetujui')
Selamat! Sertifikat Prestasi Kegiatan Anda telah **disetujui**.
@else
Sertifikat Prestasi Kegiatan Anda **ditolak**. Silakan perbaiki dan ajukan kembali melalui sistem.
@endif

@if($spk->verifiedBy)
@php
    $penyetuju = $spk->verifiedBy->hasRole('Admin') ? 'Admin ' . $spk->verifiedBy->name : 'Dosen ' . $spk->verifiedBy->name;
    $waktu = $spk->verified_at ? $spk->verified_at->format('d/m/Y H:i') : '-';
@endphp
**{{ ucfirst($status) }} oleh {{ $penyetuju }}** — {{ $waktu }}
@endif

@component('mail::table')
| Detail | Keterangan |
| --- | --- |
| **Status** | {{ ucfirst($status) }} |
| **Judul Karya** | {{ $spk->judul_karya ?? $spk->kegiatan?->judul_kegiatan ?? $spk->kegiatan?->kegiatan ?? '-' }} |
| **Kategori** | {{ $spk->kategori ?? '-' }} |
@endcomponent

@if($spk->catatan_dosen)
@php
    $catatanLabel = $spk->verifiedBy
        ? ($spk->verifiedBy->hasRole('Admin') ? 'Admin' : 'Dosen') . ' (' . $spk->verifiedBy->name . ')'
        : '';
@endphp
@component('mail::panel')
**Catatan{{ $catatanLabel ? ' ' . $catatanLabel : '' }}:**<br>
{{ $spk->catatan_dosen }}
@endcomponent
@endif

@component('mail::button', ['url' => route('spks.show', $spk->id)])
Lihat Detail SPK
@endcomponent

Terima kasih,<br>
{{ config('app.name') }}
@endcomponent