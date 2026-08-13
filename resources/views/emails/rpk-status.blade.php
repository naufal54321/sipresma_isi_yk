@component('mail::message')
# Halo, {{ $rpk->user->name ?? 'Mahasiswa' }}!

@if($status === 'disetujui')
Selamat! Rencana Kegiatan Anda telah **disetujui**.
@else
Rencana Kegiatan Anda **ditolak**. Silakan perbaiki dan ajukan kembali melalui sistem.
@endif

@if($rpk->verifiedBy)
@php
    $penyetuju = $rpk->verifiedBy->hasRole('Admin') ? 'Admin ' . $rpk->verifiedBy->name : 'Dosen ' . $rpk->verifiedBy->name;
    $waktu = $rpk->verified_at ? $rpk->verified_at->format('d/m/Y H:i') : '-';
@endphp
**{{ ucfirst($status) }} oleh {{ $penyetuju }}** — {{ $waktu }}
@endif

@component('mail::table')
| Detail | Keterangan |
| --- | --- |
| **Status** | {{ ucfirst($status) }} |
| **Tahun / Semester** | {{ $rpk->tahun ?? '-' }} / {{ $rpk->semester ?? '-' }} |
@endcomponent

@if($rpk->catatan_dosen)
@php
    $catatanLabel = $rpk->verifiedBy
        ? ($rpk->verifiedBy->hasRole('Admin') ? 'Admin' : 'Dosen') . ' (' . $rpk->verifiedBy->name . ')'
        : '';
@endphp
@component('mail::panel')
**Catatan{{ $catatanLabel ? ' ' . $catatanLabel : '' }}:**<br>
{{ $rpk->catatan_dosen }}
@endcomponent
@endif

@if($status === 'disetujui')
Anda dapat menambahkan Sertifikat Prestasi Kegiatan (SPK) berdasarkan RPK ini.
@endif

@component('mail::button', ['url' => route('rpks.show', $rpk->id)])
Lihat Detail RPK
@endcomponent

Terima kasih,<br>
{{ config('app.name') }}
@endcomponent