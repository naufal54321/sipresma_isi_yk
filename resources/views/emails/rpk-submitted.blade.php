@component('mail::message')
# Halo, {{ $penerima === 'Dosen' && $dosen ? $dosen->name : $penerima }}!

Ada Rencana Kegiatan (RPK) baru yang diajukan oleh mahasiswa berikut:

@component('mail::table')
| Detail | Keterangan |
| --- | --- |
| **Nama Mahasiswa** | {{ $rpk->user->name ?? '-' }} |
| **NIM** | {{ $rpk->user->nim ?? '-' }} |
| **Program Studi** | {{ $rpk->user->prodi ?? '-' }} |
| **Tahun / Semester** | {{ $rpk->tahun ?? '-' }} / {{ $rpk->semester ?? '-' }} |
| **Jumlah Kegiatan** | {{ $rpk->kegiatans_count ?? $rpk->kegiatans->count() ?? 0 }} kegiatan |
@endcomponent

@if($penerima === 'Dosen')
Silakan tinjau RPK tersebut dan lakukan persetujuan atau penolakan melalui sistem.
@endif

@component('mail::button', ['url' => route('rpks.show', $rpk->id)])
Lihat Detail RPK
@endcomponent

Terima kasih,<br>
{{ config('app.name') }}
@endcomponent