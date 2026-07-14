<x-app-layout>

<style>
    .hide-scrollbar::-webkit-scrollbar { display: none; }
    .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
</style>

<div class="max-w-8xl mx-auto py-6">

    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
        <h1 class="text-3xl font-bold text-gray-900">
            Detail Kegiatan RPK
        </h1>

        <div class="flex items-center gap-3">
            <a href="{{ route('dosen.rpk.index') }}"
               class="inline-flex items-center gap-2 bg-white border border-gray-300 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm font-semibold shadow-sm transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali
            </a>

            @if($rpk->status == 'draft')
                <button onclick="approveKegiatan({{ $rpk->id }})"
                        class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-500 text-white px-4 py-2 rounded-lg text-sm font-semibold shadow-sm transition cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                    RPK Disetujui
                </button>

                <button onclick="rejectKegiatan({{ $rpk->id }})"
                        class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-500 text-white px-4 py-2 rounded-lg text-sm font-semibold shadow-sm transition cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    RPK Ditolak
                </button>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

        {{-- SIDEBAR --}}
        <div class="lg:col-span-4">
            <div class="bg-gray-50 border border-gray-200 shadow-sm rounded-xl overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-200 bg-white">
                    <h2 class="text-lg font-bold text-gray-900">Detail & Periode</h2>
                </div>
                
                <div class="p-6 bg-white space-y-4">
                    <div class="grid grid-cols-3 gap-2">
                        <span class="col-span-1 text-sm font-bold text-gray-600">Nama</span>
                        <span class="col-span-2 text-sm text-gray-800 font-medium">{{ $rpk->user->name }}</span>
                    </div>
                    
                    <div class="grid grid-cols-3 gap-2 pb-4">
                        <span class="col-span-1 text-sm font-bold text-gray-600">NIM</span>
                        <span class="col-span-2 text-sm text-gray-800 font-medium">{{ $rpk->user->nim ?? '-' }}</span>
                    </div>

                    <div class="grid grid-cols-3 gap-2">
                        <span class="col-span-1 text-sm font-bold text-gray-600">Prodi</span>
                        <span class="col-span-2 text-sm text-gray-800 font-medium">{{ $rpk->user->prodi ?? '-' }}</span>
                    </div>

                    {{-- ⚡ FAKULTAS (AMBIL DARI TABEL PROGRAM_STUDIS) --}}
                    <div class="grid grid-cols-3 gap-2 pb-4 border-b border-gray-200">
                        <span class="text-sm font-bold text-gray-600">Fakultas</span>
                        <span class="col-span-2 text-sm text-gray-800 font-medium">
                            @php
                                $prodi = \App\Models\ProgramStudi::where('nama_prodi', $rpk->user->prodi)->first();
                            @endphp
                            {{ $prodi->fakultas ?? '-' }}
                        </span>
                    </div>

                    <div class="grid grid-cols-3 gap-2 pb-4">
                        <span class="col-span-1 text-sm font-bold text-slate-500">Angkatan</span>
                        <span class="col-span-2 text-sm text-slate-800 font-bold">{{ $rpk->user->angkatan ?? '-' }}</span>
                    </div>

                     <div class="grid grid-cols-3 gap-2 pb-4 border-b border-slate-100">
                        <span class="col-span-1 text-sm font-bold text-slate-500">Semester</span>
                        <span class="col-span-2 text-sm text-slate-800 font-bold">{{ $rpk->user->semester ?? '-' }}</span>
                    </div>

                    <div class="grid grid-cols-3 gap-2 pt-2">
                        <span class="col-span-1 text-sm font-bold text-gray-600">Tahun RPK</span>
                        <span class="col-span-2 text-sm text-gray-800 font-medium">{{ $rpk->tahun }}</span>
                    </div>

                    <div class="grid grid-cols-3 gap-2 pb-4 border-b border-gray-200">
                        <span class="col-span-1 text-sm font-bold text-gray-600">Semester</span>
                        <span class="col-span-2 text-sm text-gray-800 font-medium">{{ $rpk->semester }}</span>
                    </div>

                    <div class="grid grid-cols-3 gap-2 pb-4">
                        <span class="col-span-1 text-sm font-bold text-gray-600">Jumlah Kegiatan</span>
                        <span class="col-span-2 text-sm text-gray-800 font-medium">{{ $rpk->kegiatans->count() }}</span>
                    </div>

                    <div class="col-span-2 md:col-span-4 mt-2 pt-3 border-t border-gray-200">
                        <span class="text-sm font-bold text-gray-600">Status Saat Ini</span>
                        @if($rpk->status == 'draft')
                            <span class="bg-orange-500 text-white px-3 py-1 rounded-full text-xs font-semibold">Draft</span>
                        @elseif($rpk->status == 'disetujui')
                            <span class="bg-green-500 text-white px-3 py-1 rounded-full text-xs font-semibold">Disetujui</span>
                        @else
                            <span class="bg-red-500 text-white px-3 py-1 rounded-full text-xs font-semibold">Ditolak</span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="mt-6 bg-white border border-gray-200 rounded-2xl p-5 shadow-sm">
    {{-- Header --}}
    <div class="flex items-center gap-3 mb-4">
        <div class="w-8 h-8 bg-amber-100 rounded-lg flex items-center justify-center">
            <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z"/>
            </svg>
        </div>
        <h3 class="text-sm font-bold text-gray-800">Catatan Penting</h3>
    </div>

    {{-- Content --}}
    <div class="space-y-3 text-sm text-gray-600 leading-relaxed">
        <p>
            Dosen Pembimbing dimohon untuk meninjau dan memastikan kesesuaian data yang diajukan dengan ketentuan kegiatan sebelum melakukan proses <span class="font-semibold text-gray-800">VALIDASI</span>.
        </p>
        <p>
            Apabila ditemukan ketidaksesuaian, Dosen Pembimbing berwenang untuk meminta <span class="font-semibold text-gray-800">REVISI</span> dengan menyertakan catatan perbaikan kepada mahasiswa yang bersangkutan.
        </p>
    </div>

    {{-- Divider --}}
    <div class="border-t border-gray-100 my-4"></div>

    {{-- Warning --}}
    <p class="text-sm text-red-500 leading-relaxed">
        Kekeliruan prosedural maupun ketidakcermatan dalam pemeriksaan data dapat menghambat kelancaran dan memperpanjang estimasi waktu penyelesaian proses administrasi.
    </p>
</div>
        </div>

        {{-- TABEL KEGIATAN --}}
        <div class="lg:col-span-8">
            <div class="bg-white border border-gray-200 shadow-sm rounded-xl overflow-hidden flex flex-col h-full">
                
                <div class="flex border-b border-gray-200 bg-gray-50 px-2 pt-2 overflow-x-auto hide-scrollbar" id="tab-headers">
                    <button onclick="geserTab(0)" class="tab-btn bg-white border-t border-l border-r border-gray-200 rounded-t-xl px-6 py-3 -mb-[1px] relative z-10 font-bold text-gray-800 whitespace-nowrap transition cursor-pointer">
                        Rencana Kegiatan
                    </button>
                    <button onclick="geserTab(1)" class="tab-btn px-6 py-3 text-gray-500 font-bold hover:text-gray-700 whitespace-nowrap border-b border-transparent transition cursor-pointer">
                        Riwayat RPK
                    </button>
                </div>

                <div class="flex overflow-x-auto snap-x snap-mandatory hide-scrollbar scroll-smooth flex-grow" id="tab-content-container">
                    
                    {{-- TAB 1: RENCANA KEGIATAN --}}
            <div class="w-full flex-shrink-0 snap-start p-6">
                <h3 class="text-gray-600 font-medium mb-4">Daftar Rencana Kegiatan</h3>
                
                <div class="border border-gray-200 rounded-lg overflow-hidden mb-6">
                    <table class="w-full text-sm text-left text-gray-600">
                        <thead class="bg-gray-50 text-gray-700 uppercase text-xs tracking-wider border-b border-gray-200">
                            <tr>
                                <th class="px-4 py-3 font-semibold text-center w-12">No</th>
                                <th class="px-4 py-3 font-semibold">Judul Kegiatan</th>
                                <th class="px-4 py-3 font-semibold">Nama Kegiatan</th>
                                <th class="px-4 py-3 font-semibold text-center">Kategori</th>
                                <th class="px-4 py-3 font-semibold">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($rpk->kegiatans as $kegiatan)
                            <tr class="bg-white hover:bg-gray-50">
                                <td class="px-4 py-3 border-r border-slate-200 text-center font-semibold">{{ $loop->iteration }}</td>
                                <td class="px-4 py-3 border-r border-slate-200 font-bold text-slate-800">{{ $kegiatan->judul_kegiatan ?? '-' }}</td>
                                <td class="px-4 py-3 border-r border-slate-200">{{ $kegiatan->kegiatan }}</td>
                                <td class="px-4 py-3 border-r border-slate-200 text-center">
                                    @if($kegiatan->kategori == 'Kelompok')
                                        <span class="text-purple-700 text-xs font-semibold">
                                            <i class="fas fa-users mr-1"></i>Kelompok
                                        </span>
                                    @else
                                        <span class="text-gray-600 text-xs font-semibold">
                                            <i class="fas fa-user mr-1"></i>Individu
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-4">
                                    @if($kegiatan->tanggal_mulai && $kegiatan->tanggal_selesai)
                                        {{ \Carbon\Carbon::parse($kegiatan->tanggal_mulai)->translatedFormat('d F Y') }} - {{ \Carbon\Carbon::parse($kegiatan->tanggal_selesai)->translatedFormat('d F Y') }}
                                    @elseif($kegiatan->tanggal_mulai)
                                        {{ \Carbon\Carbon::parse($kegiatan->tanggal_mulai)->translatedFormat('d F Y') }}
                                    @elseif($kegiatan->tanggal)
                                        {{ \Carbon\Carbon::parse($kegiatan->tanggal)->translatedFormat('d F Y') }}
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-6 text-gray-500">
                                    Belum ada kegiatan pada RPK ini
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                        {{-- 🔧 DAFTAR ANGGOTA KELOMPOK --}}
                        @php
                            $kegiatanKelompok = $rpk->kegiatans->where('kategori', 'Kelompok');
                        @endphp
                        @if($kegiatanKelompok->count() > 0)
                        <div class="mt-6">
                            <h3 class="text-gray-700 font-semibold mb-3 text-sm">
                                <i class="fas fa-users text-blue-500 mr-2"></i>Daftar Anggota Kelompok
                            </h3>
                            <div class="space-y-4">
                                @foreach($kegiatanKelompok as $kegiatan)
                                    <div class="border border-gray-200 rounded-xl overflow-hidden">
                                        <div class="px-4 py-3 bg-gray-50 border-b border-gray-200">
                                            <h4 class="text-sm font-bold text-gray-800">📋 {{ $kegiatan->judul_kegiatan }}</h4>
                                            <div class="flex items-center gap-2 mt-1 text-xs text-gray-500">
                                                <span class="bg-purple-100 text-purple-700 px-2 py-0.5 rounded-full text-xs font-semibold">Kelompok</span>
                                                <span>{{ $kegiatan->anggota->count() }} anggota</span>
                                            </div>
                                        </div>
                                        <table class="w-full text-sm">
                                            <thead class="bg-gray-100 text-xs uppercase text-gray-500">
                                                <tr>
                                                    <th class="px-4 py-2 text-center w-12">No</th>
                                                    <th class="px-4 py-2 text-left">Nama</th>
                                                    <th class="px-4 py-2 text-left">NIM</th>
                                                    <th class="px-4 py-2 text-left">Prodi</th>
                                                    <th class="px-4 py-2 text-center w-24">Peran</th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-gray-100">
                                                <tr class="bg-blue-50">
                                                    <td class="px-4 py-2 text-center text-gray-500">1</td>
                                                    <td class="px-4 py-2 font-medium text-gray-800">{{ $rpk->user->name }}</td>
                                                    <td class="px-4 py-2 text-gray-500">{{ $rpk->user->nim ?? '-' }}</td>
                                                    <td class="px-4 py-2 text-gray-500">{{ $rpk->user->prodi ?? '-' }}</td>
                                                    <td class="px-4 py-2 text-center">
                                                        <span class="bg-blue-100 text-blue-700 px-2 py-0.5 rounded-full text-xs font-semibold">Ketua</span>
                                                    </td>
                                                </tr>
                                                @foreach($kegiatan->anggota as $index => $anggota)
                                                    <tr class="hover:bg-gray-50">
                                                        <td class="px-4 py-2 text-center text-gray-500">{{ $index + 2 }}</td>
                                                        <td class="px-4 py-2 font-medium text-gray-800">{{ $anggota->name }}</td>
                                                        <td class="px-4 py-2 text-gray-500">{{ $anggota->nim ?? '-' }}</td>
                                                        <td class="px-4 py-2 text-gray-500">{{ $anggota->prodi ?? '-' }}</td>
                                                        <td class="px-4 py-2 text-center">
                                                            <span class="bg-green-100 text-green-700 px-2 py-0.5 rounded-full text-xs font-semibold">Anggota</span>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                @if($kegiatan->anggota->count() == 0)
                                                    <tr>
                                                        <td colspan="5" class="px-4 py-4 text-center text-gray-400 text-xs">Belum ada anggota</td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>

                    {{-- TAB 2: RIWAYAT --}}
                    <div class="w-full flex-shrink-0 snap-start p-6">
                        <h3 class="text-gray-600 font-medium mb-6">Timeline Riwayat Pengajuan</h3>
                        
                        <div class="relative border-l-2 border-blue-200 ml-3 space-y-8">
                            <div class="relative pl-6">
                                <div class="absolute w-4 h-4 bg-blue-500 rounded-full -left-[9px] top-1 border-2 border-white shadow"></div>
                                <p class="text-xs font-semibold text-blue-600 mb-1">Terbaru</p>
                                <h4 class="font-bold text-gray-800">Status Diperbarui: {{ ucfirst($rpk->status) }}</h4>
                                <p class="text-sm text-gray-600 mt-1 bg-gray-50 p-3 rounded-lg border border-gray-100">
                                    Catatan: {{ $rpk->catatan_dosen ?? 'Tidak ada catatan yang dilampirkan.' }}
                                </p>
                            </div>

                            <div class="relative pl-6">
                                <div class="absolute w-4 h-4 bg-gray-300 rounded-full -left-[9px] top-1 border-2 border-white shadow"></div>
                                <p class="text-xs font-semibold text-gray-500 mb-1">{{ $rpk->created_at ? $rpk->created_at->format('d M Y - H:i') : 'Tanggal tidak tersedia' }}</p>
                                <h4 class="font-bold text-gray-800">Kegiatan Diajukan</h4>
                                <p class="text-sm text-gray-600 mt-1">
                                    Mahasiswa membuat draf rencana kegiatan dan mengajukannya ke sistem.
                                </p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
window.geserTab = function(index) {
    var container = document.getElementById('tab-content-container');
    if (!container) return;
    container.scrollTo({ left: container.clientWidth * index, behavior: 'smooth' });
    window.updateGayaTab(index);
};

window.updateGayaTab = function(index) {
    var buttons = document.querySelectorAll('.tab-btn');
    buttons.forEach((btn, i) => {
        if (i === index) {
            btn.className = "tab-btn bg-white border-t border-l border-r border-gray-200 rounded-t-xl px-6 py-3 -mb-[1px] relative z-10 font-bold text-gray-800 whitespace-nowrap transition cursor-pointer";
        } else {
            btn.className = "tab-btn px-6 py-3 text-gray-500 font-bold hover:text-gray-700 whitespace-nowrap border-b border-transparent transition cursor-pointer";
        }
    });
};

(function() {
    var container = document.getElementById('tab-content-container');
    if (container) {
        container.onscroll = function() {
            var indexAktif = Math.round(container.scrollLeft / container.clientWidth);
            window.updateGayaTab(indexAktif);
        };
    }
})();

window.approveKegiatan = function(id) {
    Swal.fire({
        title: 'Setujui RPK',
        input: 'textarea',
        inputLabel: 'Catatan Dosen (opsional)',
        inputPlaceholder: 'Catatan untuk mahasiswa...',
        showCancelButton: true,
        confirmButtonText: 'Setujui',
        confirmButtonColor: '#16a34a',
    }).then((result) => {
        if (!result.isConfirmed) return;

        fetch('/dosen/rpk/' + id + '/approve', {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
            },
            body: JSON.stringify({ catatan_dosen: result.value || '' })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                Swal.fire({ icon: 'success', title: 'Berhasil', text: data.message, timer: 2000, showConfirmButton: false });
                setTimeout(() => location.reload(), 2200);
            } else {
                Swal.fire({ icon: 'error', title: 'Gagal', text: data.message });
            }
        })
        .catch(() => {
            Swal.fire({ icon: 'error', title: 'Error', text: 'Terjadi kesalahan server' });
        });
    });
};

window.rejectKegiatan = function(id) {
    Swal.fire({
        title: 'Tolak RPK',
        input: 'textarea',
        inputLabel: 'Catatan Dosen',
        inputPlaceholder: 'Alasan RPK ditolak...',
        showCancelButton: true,
        confirmButtonText: 'Tolak',
        confirmButtonColor: '#dc2626',
        inputValidator: (value) => {
            if (!value) return 'Alasan wajib diisi';
        }
    }).then((result) => {
        if (!result.isConfirmed) return;

        fetch('/dosen/rpk/' + id + '/reject', {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
            },
            body: JSON.stringify({ catatan_dosen: result.value })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                Swal.fire({ icon: 'success', title: 'Berhasil', text: data.message, timer: 2000, showConfirmButton: false });
                setTimeout(() => location.reload(), 2200);
            } else {
                Swal.fire({ icon: 'error', title: 'Gagal', text: data.message });
            }
        })
        .catch(() => {
            Swal.fire({ icon: 'error', title: 'Error', text: 'Terjadi kesalahan server' });
        });
    });
};
</script>

</x-app-layout>