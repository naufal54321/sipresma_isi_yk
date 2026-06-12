<x-app-layout>

<style>
    /* Menyembunyikan scrollbar tapi tetap bisa di-scroll */
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
            @else
                <span class="inline-flex items-center gap-2 bg-gray-100 border border-gray-200 text-gray-600 px-4 py-2 rounded-lg text-sm font-semibold">
                    Selesai
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
                        <span class="col-span-2 text-sm text-gray-800 font-medium">{{ $rpk->user->name }}</span>
                    </div>
                    
                    <div class="grid grid-cols-3 gap-2 pb-4 ">
                        <span class="col-span-1 text-sm font-bold text-gray-600">NIM</span>
                        <span class="col-span-2 text-sm text-gray-800 font-medium">{{ $rpk->user->nim ?? '-' }}</span>
                    </div>

                    <div class="grid grid-cols-3 gap-2 pb-4 border-b border-gray-200">
                        <span class="col-span-1 text-sm font-bold text-gray-600">Prodi</span>
                        <span class="col-span-2 text-sm text-gray-800 font-medium">{{ $rpk->user->prodi ?? '-' }}</span>
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
                        <span class="col-span-1 text-sm font-bold text-gray-600">Tanggal</span>
                        <span class="col-span-2 text-sm text-gray-800 font-medium">{{ $rpk->tanggal }}</span>
                    </div>

                    <div class="grid grid-cols-3 gap-2 pb-4">
                        <span class="col-span-1 text-sm font-bold text-gray-600">Kategori</span>
                        <span class="col-span-2 text-sm text-gray-800 font-medium">{{ $rpk->kategori }}</span>
                    </div>

                     @if($rpk->kategori == 'Kelompok')
                    <div class="grid grid-cols-3 gap-2 pb-4">
                        <span class="col-span-1 text-sm font-bold text-gray-600">Peran</span>
                        <span class="col-span-2 text-sm text-gray-800 font-medium">{{ $rpk->peran }}</span>
                    </div>
                    <div class="grid grid-cols-3 gap-2 pb-4">
                        <span class="col-span-1 text-sm font-bold text-gray-600">Anggota</span>
                        <span class="col-span-2 text-sm text-gray-800 font-medium">{{ $rpk->jumlah_anggota ?? '-' }}</span>
                    </div>
                    @endif

                    <div class="grid grid-cols-3 gap-2 pb-4">
                        <span class="col-span-1 text-sm font-bold text-gray-600">Catatan Dosen</span>
                        <span class="col-span-2 text-sm text-gray-800 font-medium">{{ $rpk->catatan_dosen ?? 'Belum ada catatan' }}</span>
                    </div>

                    <div class="col-span-2 md:col-span-4 mt-2 pt-3 border-t border-gray-200">
                        <span class="col-span-1 text-sm font-bold text-gray-600">Status Saat Ini</span>
                         @if($rpk->status == 'draft')
                        <span class="bg-orange-500 text-white px-3 py-1 rounded-full text-xs font-semibold border border-yellow-200">Draft</span>
                         @elseif($rpk->status == 'disetujui')
                        <span class="bg-green-500 text-white px-3 py-1 rounded-full text-xs font-semibold border border-green-200">Disetujui</span>
                        @else
                        <span class="bg-red-500 text-white px-3 py-1 rounded-full text-xs font-semibold border border-red-200">Ditolak</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="lg:col-span-8">
            <div class="bg-white border border-gray-200 shadow-sm rounded-xl overflow-hidden flex flex-col h-full">
                
                <div class="flex border-b border-gray-200 bg-gray-50 px-2 pt-2 overflow-x-auto hide-scrollbar" id="tab-headers">
                    <button onclick="geserTab(0)" class="tab-btn bg-white border-t border-l border-r border-gray-200 rounded-t-lg px-6 py-3 -mb-[1px] relative z-10 font-bold text-gray-800 whitespace-nowrap transition cursor-pointer">
                        Rencana Kegiatan
                    </button>
                   
                    <button onclick="geserTab(2)" class="tab-btn px-6 py-3 text-gray-500 font-bold hover:text-gray-700 whitespace-nowrap border-b border-transparent transition cursor-pointer">
                        Riwayat RPK
                    </button>
                </div>

                <div class="flex overflow-x-auto snap-x snap-mandatory hide-scrollbar scroll-smooth flex-grow" id="tab-content-container">
                    
                    <div class="w-full flex-shrink-0 snap-start p-6">
                        <h3 class="text-gray-600 font-medium mb-4">Daftar Rencana Kegiatan</h3>
                        
                        <div class="border border-gray-200 rounded-lg overflow-hidden mb-6">
                            <table class="w-full text-sm text-left text-gray-600">
                                <thead class="border-b border-gray-200 bg-white">
                                    <tr>
                                        <th class="px-4 py-3 font-semibold border-r border-gray-200">No.</th>
                                        <th class="px-4 py-3 font-semibold border-r border-gray-200">Nama Kegiatan</th>
                                        <th class="px-4 py-3 font-semibold border-r border-gray-200">Jenis</th>
                                        <th class="px-4 py-3 font-semibold border-r border-gray-200">Tingkat</th>
                                        <th class="px-4 py-3 font-semibold border-r border-gray-200">Hasil</th>
                                         <th class="px-4 py-3 font-semibold">Poin</th>
                                    </tr>
                                </thead>
                                <tbody>
    @forelse($rpk->kegiatans as $kegiatan)
    <tr class="bg-white">
        <td class="px-4 py-4 border-r border-gray-200">
            {{ $loop->iteration }}
        </td>

        <td class="px-4 py-4 border-r border-gray-200 font-medium text-gray-800">
            {{ $kegiatan->kegiatan }}
        </td>

        <td class="px-4 py-4 border-r border-gray-200">
            {{ $kegiatan->jenis }}
        </td>

        <td class="px-4 py-4 border-r border-gray-200">
            {{ $kegiatan->tingkat }}
        </td>

        <td class="px-4 py-4 border-r border-gray-200">
            {{ $kegiatan->hasil }}
        </td>

        <td class="px-4 py-4">
            {{ $kegiatan->masterKegiatan->poin ?? '-' }}
        </td>
    </tr>
    @empty
    <tr>
        <td colspan="6" class="text-center py-6 text-gray-500">
            Belum ada kegiatan pada RPK ini
        </td>
    </tr>
    @endforelse
</tbody>
                            </table>
                        </div>

                        
                    </div>


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
// --- LOGIKA TAB GESER (SWIPEABLE) ---
const container = document.getElementById('tab-content-container');
const buttons = document.querySelectorAll('.tab-btn');

// Fungsi saat tombol tab diklik
function geserTab(index) {
    container.scrollTo({
        left: container.clientWidth * index,
        behavior: 'smooth'
    });
    updateGayaTab(index);
}

// Fungsi mendeteksi posisi geser (swipe layar HP) untuk mengubah tombol aktif
container.addEventListener('scroll', () => {
    // Math.round membantu mendeteksi div mana yang paling dominan terlihat di layar
    let indexAktif = Math.round(container.scrollLeft / container.clientWidth);
    updateGayaTab(indexAktif);
});

// Fungsi untuk mengganti warna tombol tab
function updateGayaTab(index) {
    buttons.forEach((btn, i) => {
        if (i === index) {
            btn.className = "tab-btn bg-white border-t border-l border-r border-gray-200 rounded-t-lg px-6 py-3 -mb-[1px] relative z-10 font-bold text-gray-800 whitespace-nowrap transition cursor-pointer";
        } else {
            btn.className = "tab-btn px-6 py-3 text-gray-500 font-bold hover:text-gray-700 whitespace-nowrap border-b border-transparent transition cursor-pointer";
        }
    });
}

// --- LOGIKA SETUJUI & TOLAK ---
function approveKegiatan(id) {
    Swal.fire({
        title: 'Alasan RPK Disetujui',
        input: 'textarea',
        inputLabel: 'Catatan Dosen',
        inputPlaceholder: 'Masukkan alasan RPK disetujui...',
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
            form.action = '/dosen/rpk/' + id + '/approve';
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

function rejectKegiatan(id) {
    Swal.fire({
        title: 'Alasan RPK Ditolak',
        input: 'textarea',
        inputLabel: 'Catatan Dosen',
        inputPlaceholder: 'Masukkan alasan RPK ditolak...',
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
            form.action = '/dosen/rpk/' + id + '/reject';
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