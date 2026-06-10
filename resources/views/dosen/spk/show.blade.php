<x-app-layout>

<style>
    /* Menyembunyikan scrollbar tapi tetap bisa di-scroll (untuk fitur tab) */
    .hide-scrollbar::-webkit-scrollbar {
        display: none;
    }
    .hide-scrollbar {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
</style>

<div class="max-w-8xl mx-auto py-6">

    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
        <h1 class="text-3xl font-bold text-gray-900">
            Detail SPK
        </h1>

        <div class="flex items-center gap-3">
            <a href="{{ route('dosen.spk.index') }}"
               class="inline-flex items-center gap-2 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 px-4 py-2 rounded-lg text-sm font-semibold shadow-sm transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali
            </a>

            @if($spk->status == 'draft')
                <button onclick="approveSpk({{ $spk->id }})"
                        class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-500 text-white px-4 py-2 rounded-lg text-sm font-semibold shadow-sm transition cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                    SPK Disetujui
                </button>

                <button onclick="rejectSpk({{ $spk->id }})"
                        class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-500 text-white px-4 py-2 rounded-lg text-sm font-semibold shadow-sm transition cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    SPK Ditolak
                </button>
            @else
                <span class="inline-flex items-center gap-2 bg-gray-100 border border-gray-200 text-gray-600 px-4 py-2 rounded-lg text-sm font-semibold">
                    Status: Selesai
                </span>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

        <div class="lg:col-span-4">
            <div class="bg-gray-50 border border-gray-200 shadow-sm rounded-xl overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-200 bg-white">
                    <h2 class="text-lg font-bold text-gray-900">Detail & Periode</h2>
                </div>
                
                <div class="p-6 bg-white space-y-4">
                    <div class="grid grid-cols-3 gap-2">
                        <span class="col-span-1 text-sm font-bold text-gray-600">Nama</span>
                        <span class="col-span-2 text-sm text-gray-800 font-medium uppercase">{{ $spk->user->name }}</span>
                    </div>
                    
                    <div class="grid grid-cols-3 gap-2">
                        <span class="col-span-1 text-sm font-bold text-gray-600">NIM</span>
                        <span class="col-span-2 text-sm text-gray-800 font-medium">{{ $spk->user->nim }}</span>
                    </div>

                    <div class="grid grid-cols-3 gap-2 pb-4 border-b border-gray-200">
                        <span class="col-span-1 text-sm font-bold text-gray-600">Prodi</span>
                        <span class="col-span-2 text-sm text-gray-800 font-medium uppercase">{{ $spk->user->prodi }}</span>
                    </div>

                    <div class="grid grid-cols-3 gap-2 pt-2">
                        <span class="col-span-1 text-sm font-bold text-gray-600">Tahun</span>
                        <span class="col-span-2 text-sm text-gray-800 font-medium">{{ $spk->tahun }}</span>
                    </div>

                    <div class="grid grid-cols-3 gap-2">
                        <span class="col-span-1 text-sm font-bold text-gray-600">Kegiatan</span>
                        <span class="col-span-2 text-sm text-gray-800 font-medium">{{ $spk->kegiatan->kegiatan }}</span>
                    </div>

                    <div class="grid grid-cols-3 gap-2">
                        <span class="col-span-1 text-sm font-bold text-gray-600">Tanggal</span>
                        <span class="col-span-2 text-sm text-gray-800 font-medium">{{ \Carbon\Carbon::parse($spk->tanggal_kegiatan)->format('d-m-Y') }}</span>
                    </div>

                    <div class="grid grid-cols-3 gap-2">
                        <span class="col-span-1 text-sm font-bold text-gray-600">Penyelenggara</span>
                        <span class="col-span-2 text-sm text-gray-800 font-medium">{{ $spk->penyelenggara }}</span>
                    </div>

                    <div class="grid grid-cols-3 gap-2">
                        <span class="col-span-1 text-sm font-bold text-gray-600">Kategori</span>
                        <span class="col-span-2 text-sm text-gray-800 font-medium">{{ $spk->kategori }}</span>
                    </div>

                    <div class="grid grid-cols-3 gap-2">
                        <span class="col-span-1 text-sm font-bold text-gray-600">URL Kegiatan</span>
                        <span class="col-span-2 text-sm text-blue-600 font-medium break-words">
                            @if($spk->url_kegiatan)
                                <a href="{{ $spk->url_kegiatan }}" target="_blank" class="hover:underline">Buka Tautan</a>
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </span>
                    </div>

                    <div class="grid grid-cols-3 gap-2">
                        <span class="col-span-1 text-sm font-bold text-gray-600">Keterangan</span>
                        <span class="col-span-2 text-sm text-gray-800 font-medium">{{ $spk->keterangan }}</span>
                    </div>

                    <div class="grid grid-cols-3 gap-2 pb-2">
                        <span class="col-span-1 text-sm font-bold text-gray-600 flex items-center">Status</span>
                        <span class="col-span-2">
                            @if($spk->status == 'draft')
                                <span class="bg-orange-500 text-white px-3 py-1 rounded-md text-xs font-bold shadow-sm">Draft</span>
                            @elseif($spk->status == 'disetujui')
                                <span class="bg-green-500 text-white px-3 py-1 rounded-md text-xs font-bold shadow-sm">Disetujui</span>
                            @else
                                <span class="bg-red-500 text-white px-3 py-1 rounded-md text-xs font-bold shadow-sm">Ditolak</span>
                            @endif
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="lg:col-span-8">
            <div class="bg-white border border-gray-200 shadow-sm rounded-xl overflow-hidden flex flex-col h-full">
                
                <div class="flex border-b border-gray-200 bg-gray-50 px-2 pt-2 overflow-x-auto hide-scrollbar" id="tab-headers">
                    <button onclick="geserTab(0)" class="tab-btn bg-white border-t border-l border-r border-gray-200 rounded-t-lg px-6 py-3 -mb-[1px] relative z-10 font-bold text-gray-800 whitespace-nowrap transition cursor-pointer">
                        Deskripsi Kegiatan
                    </button>
                    <button onclick="geserTab(1)" class="tab-btn px-6 py-3 text-gray-500 font-bold hover:text-gray-700 whitespace-nowrap border-b border-transparent transition cursor-pointer">
                        Bukti Kegiatan
                    </button>
                    <button onclick="geserTab(2)" class="tab-btn px-6 py-3 text-gray-500 font-bold hover:text-gray-700 whitespace-nowrap border-b border-transparent transition cursor-pointer">
                        Riwayat Kegiatan
                    </button>
                </div>

                <div class="flex overflow-x-auto snap-x snap-mandatory hide-scrollbar scroll-smooth flex-grow" id="tab-content-container">
                    
                    <div class="w-full flex-shrink-0 snap-start p-6">
                        <div class="border border-gray-200 rounded-lg overflow-hidden">
                            <table class="w-full text-sm text-left text-gray-600">
                                <tbody>
                                    <tr class="border-b border-gray-200 hover:bg-gray-50 transition">
                                        <td class="px-6 py-4 font-bold text-gray-700 w-1/3 bg-gray-50/50">Nama Kegiatan</td>
                                        <td class="px-6 py-4 font-medium text-gray-800">{{ $spk->kegiatan->kegiatan }}</td>
                                    </tr>
                                    <tr class="border-b border-gray-200 hover:bg-gray-50 transition">
                                        <td class="px-6 py-4 font-bold text-gray-700 w-1/3 bg-gray-50/50">Jenis Kegiatan</td>
                                        <td class="px-6 py-4 font-medium text-gray-800">{{ $spk->kegiatan->jenis }}</td>
                                    </tr>
                                    <tr class="border-b border-gray-200 hover:bg-gray-50 transition">
                                        <td class="px-6 py-4 font-bold text-gray-700 w-1/3 bg-gray-50/50">Tingkat Kegiatan</td>
                                        <td class="px-6 py-4 font-medium text-gray-800">{{ $spk->kegiatan->tingkat }}</td>
                                    </tr>
                                    <tr class="border-b border-gray-200 hover:bg-gray-50 transition">
                                        <td class="px-6 py-4 font-bold text-gray-700 w-1/3 bg-gray-50/50">Hasil Kegiatan</td>
                                        <td class="px-6 py-4 font-medium text-gray-800">{{ $spk->kegiatan->hasil }}</td>
                                    </tr>
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-4 font-bold text-gray-700 w-1/3 bg-gray-50/50">Dokumen Bukti</td>
                                        <td class="px-6 py-4 font-medium text-gray-800">
                                            @if($spk->bukti)
                                                File PDF (Tersedia di tab Bukti Kegiatan)
                                            @else
                                                <span class="text-red-500">Tidak ada file lampiran</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr class="border-b border-gray-200 hover:bg-gray-50 transition">
                                        <td class="px-6 py-4 font-bold text-gray-700 w-1/3 bg-gray-50/50">Poin</td>
                                        <td class="px-6 py-4 font-medium text-gray-800">{{ $spk->kegiatan->masterKegiatan->poin ?? '-' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="w-full flex-shrink-0 snap-start p-6 flex flex-col">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-gray-700 font-bold">Preview Dokumen Bukti</h3>
                            <a href="{{ asset('storage/' . $spk->bukti) }}" target="_blank" class="text-sm text-blue-600 font-semibold hover:underline flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                </svg>
                                Lihat Dokumen
                            </a>
                        </div>
                        
                        <div class="flex-grow w-full rounded-lg overflow-hidden border border-gray-200 bg-gray-100 relative min-h-[500px]">
                            @if($spk->bukti)
                                <iframe src="{{ asset('storage/' . $spk->bukti) }}" class="absolute inset-0 w-full h-full border-0"></iframe>
                            @else
                                <div class="flex flex-col items-center justify-center h-full text-gray-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mb-3 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <p>File bukti tidak dilampirkan.</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="w-full flex-shrink-0 snap-start p-6">
                        <h3 class="text-gray-600 font-medium mb-6">Timeline Riwayat Pengajuan</h3>
                        
                        <div class="relative border-l-2 border-blue-200 ml-3 space-y-8">
                            
                            <div class="relative pl-6">
                                <div class="absolute w-4 h-4 bg-blue-500 rounded-full -left-[9px] top-1 border-2 border-white shadow"></div>
                                <p class="text-xs font-semibold text-blue-600 mb-1">Terbaru</p>
                                <h4 class="font-bold text-gray-800">Status SPK: {{ ucfirst($spk->status) }}</h4>
                                <p class="text-sm text-gray-600 mt-1 bg-gray-50 p-3 rounded-lg border border-gray-100">
                                    <span class="font-semibold block mb-1">Catatan Dosen:</span>
                                    {{ $spk->catatan_dosen ?? 'Tidak ada catatan yang dilampirkan oleh dosen.' }}
                                </p>
                            </div>

                            <div class="relative pl-6">
                                <div class="absolute w-4 h-4 bg-gray-300 rounded-full -left-[9px] top-1 border-2 border-white shadow"></div>
                                <p class="text-xs font-semibold text-gray-500 mb-1">{{ $spk->created_at ? $spk->created_at->format('d M Y - H:i') : 'Tanggal tidak tersedia' }}</p>
                                <h4 class="font-bold text-gray-800">SPK Diajukan</h4>
                                <p class="text-sm text-gray-600 mt-1">
                                    Mahasiswa membuat Surat Pengajuan Kegiatan beserta bukti file PDF ke sistem.
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
// --- LOGIKA TAB GESER (SWIPEABLE) ---
const container = document.getElementById('tab-content-container');
const buttons = document.querySelectorAll('.tab-btn');

function geserTab(index) {
    container.scrollTo({
        left: container.clientWidth * index,
        behavior: 'smooth'
    });
    updateGayaTab(index);
}

container.addEventListener('scroll', () => {
    let indexAktif = Math.round(container.scrollLeft / container.clientWidth);
    updateGayaTab(indexAktif);
});

function updateGayaTab(index) {
    buttons.forEach((btn, i) => {
        if (i === index) {
            btn.className = "tab-btn bg-white border-t border-l border-r border-gray-200 rounded-t-lg px-6 py-3 -mb-[1px] relative z-10 font-bold text-gray-800 whitespace-nowrap transition cursor-pointer";
        } else {
            btn.className = "tab-btn px-6 py-3 text-gray-500 font-bold hover:text-gray-700 whitespace-nowrap border-b border-transparent transition cursor-pointer";
        }
    });
}

// --- LOGIKA SETUJUI & TOLAK SPK ---
function approveSpk(id) {
    Swal.fire({
        title: 'Alasan Persetujuan',
        input: 'textarea',
        inputLabel: 'Catatan Dosen',
        inputPlaceholder: 'Masukkan alasan disetujui...',
        showCancelButton: true,
        confirmButtonText: 'Setujui',
        confirmButtonColor: '#16a34a',
        inputValidator: (value) => {
            if (!value) return 'Alasan wajib diisi';
        }
    }).then((result) => {
        if(result.isConfirmed) {
            let form = document.createElement('form');
            form.method = 'POST';
            form.action = '/dosen/spk/' + id + '/approve';
            form.innerHTML = `
                @csrf
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="catatan_dosen" value="${result.value}">
            `;
            document.body.appendChild(form);
            form.submit();
        }
    });
}

function rejectSpk(id) {
    Swal.fire({
        title: 'Alasan Penolakan',
        input: 'textarea',
        inputLabel: 'Catatan Dosen',
        inputPlaceholder: 'Masukkan alasan ditolak...',
        showCancelButton: true,
        confirmButtonText: 'Tolak',
        confirmButtonColor: '#dc2626',
        inputValidator: (value) => {
            if (!value) return 'Alasan wajib diisi';
        }
    }).then((result) => {
        if(result.isConfirmed) {
            let form = document.createElement('form');
            form.method = 'POST';
            form.action = '/dosen/spk/' + id + '/reject';
            form.innerHTML = `
                @csrf
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="catatan_dosen" value="${result.value}">
            `;
            document.body.appendChild(form);
            form.submit();
        }
    });
}
</script>

</x-app-layout>