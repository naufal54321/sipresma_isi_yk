<x-app-layout>

<style>
    .hide-scrollbar::-webkit-scrollbar { display: none; }
    .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
</style>

<div class="max-w-8xl mx-auto py-6">

    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
       <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Detail RPK</h1>
            <p class="text-gray-500 mt-1"></p>
        </div>

        <div class="flex flex-wrap items-center gap-3 w-full md:w-auto">
            <a href="{{ route('admin.rpk.index') }}"
               class="inline-flex items-center justify-center gap-2 bg-white border border-slate-300 hover:bg-slate-100 text-slate-700 px-4 py-2.5 rounded-xl text-sm font-bold shadow-sm transition flex-1 md:flex-none">
                <i class="fas fa-arrow-left text-xs"></i> Kembali
            </a>

            @if($rpk->status == 'draft' || $rpk->status == 'diajukan')
                <button onclick="approveKegiatan({{ $rpk->id }})"
                        class="inline-flex items-center justify-center gap-2 bg-emerald-500 hover:bg-emerald-600 text-white px-5 py-2.5 rounded-xl text-sm font-bold shadow-sm shadow-emerald-500/20 transition flex-1 md:flex-none">
                    <i class="fas fa-check-circle"></i> Setujui RPK
                </button>

                <button onclick="rejectKegiatan({{ $rpk->id }})"
                        class="inline-flex items-center justify-center gap-2 bg-red-500 hover:bg-red-600 text-white px-5 py-2.5 rounded-xl text-sm font-bold shadow-sm shadow-red-500/20 transition flex-1 md:flex-none">
                    <i class="fas fa-times-circle"></i> Tolak RPK
                </button>
            @else
                <form action="{{ route('admin.rpk.update-status', $rpk->id) }}" method="POST" class="w-full md:w-auto flex">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="draft">
                    <button type="submit" class="w-full inline-flex items-center justify-center gap-2 bg-slate-800 hover:bg-slate-700 text-white px-5 py-2.5 rounded-xl text-sm font-bold shadow-sm transition">
                        <i class="fas fa-undo"></i> Kembalikan ke Draft
                    </button>
                </form>
            @endif
        </div>
    </div>

    @if(!$rpk->user->dosenPembimbing)
        <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-800 rounded-2xl flex items-center gap-3 shadow-sm">
            <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
            <div>
                <p class="text-sm font-extrabold">Mahasiswa Tanpa Dosen Pembimbing!</p>
                <p class="text-xs font-medium mt-0.5">Admin berhak melakukan validasi dan memberikan keputusan mutlak untuk dokumen ini.</p>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

        {{-- SIDEBAR --}}
        <div class="lg:col-span-4 space-y-6">
            <div class="bg-slate-50 border border-slate-200 shadow-sm rounded-3xl overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-200 bg-white">
                    <h2 class="text-lg font-extrabold text-slate-900">Detail & Periode</h2>
                </div>
                
                <div class="p-6 bg-white space-y-4">
                    <div class="grid grid-cols-3 gap-2">
                        <span class="col-span-1 text-sm font-bold text-slate-500">Nama</span>
                        <span class="col-span-2 text-sm text-slate-800 font-extrabold">{{ $rpk->user->name ?? '-' }}</span>
                    </div>
                    
                    <div class="grid grid-cols-3 gap-2 pb-4">
                        <span class="col-span-1 text-sm font-bold text-slate-500">NIM</span>
                        <span class="col-span-2 text-sm text-slate-800 font-bold">{{ $rpk->user->nim ?? '-' }}</span>
                    </div>

                    <div class="grid grid-cols-3 gap-2 pb-4 border-b border-slate-100">
                        <span class="col-span-1 text-sm font-bold text-slate-500">Prodi</span>
                        <span class="col-span-2 text-sm text-slate-800 font-bold">{{ $rpk->user->prodi ?? '-' }}</span>
                    </div>

                    <div class="grid grid-cols-3 gap-2 pt-2">
                        <span class="col-span-1 text-sm font-bold text-slate-500">Tahun RPK</span>
                        <span class="col-span-2 text-sm text-slate-800 font-bold">{{ $rpk->tahun ?? '-' }}</span>
                    </div>

                    <div class="grid grid-cols-3 gap-2 pb-4 border-b border-slate-100">
                        <span class="col-span-1 text-sm font-bold text-slate-500">Semester</span>
                        <span class="col-span-2 text-sm text-slate-800 font-bold">{{ $rpk->semester ?? '-' }}</span>
                    </div>

                    <div class="grid grid-cols-3 gap-2 pb-4">
                        <span class="col-span-1 text-sm font-bold text-slate-500">Jumlah Kegiatan</span>
                        <span class="col-span-2 text-sm text-slate-800 font-bold">{{ $rpk->kegiatans->count() }}</span>
                    </div>

                    <div class="grid grid-cols-3 gap-2 pb-4 border-t border-slate-100 pt-4">
                        <span class="col-span-1 text-sm font-bold text-slate-500">Dosen Pembimbing</span>
                        <span class="col-span-2 text-sm text-slate-800 font-bold">
                            {{ $rpk->user->dosenPembimbing->name ?? 'Belum ada' }}
                        </span>
                    </div>

                    <div class="col-span-2 md:col-span-4 mt-2 pt-4 border-t border-slate-100 flex items-center justify-between">
                        <span class="text-sm font-bold text-slate-500">Status Saat Ini</span>
                        @if($rpk->status == 'draft')
                            <span class="bg-amber-100 text-amber-700 px-3 py-1 rounded-full text-[11px] font-extrabold tracking-wider uppercase border border-amber-200">Draft</span>
                        @elseif($rpk->status == 'diajukan')
                            <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-[11px] font-extrabold tracking-wider uppercase border border-blue-200">Diajukan</span>
                        @elseif($rpk->status == 'disetujui')
                            <span class="bg-emerald-100 text-emerald-700 px-3 py-1 rounded-full text-[11px] font-extrabold tracking-wider uppercase border border-emerald-200">Disetujui</span>
                        @else
                            <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-[11px] font-extrabold tracking-wider uppercase border border-red-200">Ditolak</span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="bg-blue-50 border border-blue-100 rounded-2xl p-6 shadow-sm">
                <h3 class="text-lg font-bold text-blue-800 mb-2 flex items-center gap-2"><i class="fas fa-info-circle"></i> Info Administrator</h3>
                <p class="text-xs text-blue-700 leading-relaxed mb-4">
                    Anda sedang login sebagai Admin. Keputusan persetujuan atau penolakan di halaman ini akan menimpa (override) hak akses Dosen Pembimbing yang bersangkutan.
                </p>
            </div>
        </div>

        {{-- TABEL KEGIATAN --}}
        <div class="lg:col-span-8">
            <div class="bg-white border border-slate-200 shadow-sm rounded-3xl overflow-hidden flex flex-col h-full">
                
                <div class="flex border-b border-slate-200 bg-slate-50/50 px-2 pt-2 overflow-x-auto hide-scrollbar" id="tab-headers">
                    <button onclick="geserTab(0)" class="tab-btn bg-white border-t border-l border-r border-slate-200 rounded-t-xl px-6 py-3 -mb-[1px] relative z-10 font-extrabold text-slate-800 whitespace-nowrap transition cursor-pointer">
                        Rencana Kegiatan
                    </button>
                    <button onclick="geserTab(1)" class="tab-btn px-6 py-3 text-slate-500 font-bold hover:text-slate-700 whitespace-nowrap border-b border-transparent transition cursor-pointer">
                        Riwayat RPK
                    </button>
                </div>

                <div class="flex overflow-x-auto snap-x snap-mandatory hide-scrollbar scroll-smooth flex-grow" id="tab-content-container">
                    
                    {{-- TAB 1: RENCANA KEGIATAN --}}
                    <div class="w-full flex-shrink-0 snap-start p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-slate-800 font-extrabold">Daftar Rencana Kegiatan</h3>
                        </div>
                        
                        <div class="border border-slate-200 rounded-xl overflow-hidden">
                            <table class="min-w-full text-sm text-left text-slate-600">
                                <thead class="bg-slate-50 border-b border-slate-200 uppercase text-[10px] font-extrabold tracking-wider text-slate-500">
                                    <tr>
                                        <th class="px-4 py-3 border-r border-slate-200 w-10 text-center">No</th>
                                        <th class="px-4 py-3 border-r border-slate-200">Judul Kegiatan</th>
                                        <th class="px-4 py-3 border-r border-slate-200">Nama Kegiatan</th>
                                        <th class="px-4 py-3 border-r border-slate-200 text-center">Kategori</th>
                                        <th class="px-4 py-3 border-r border-slate-200">Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @forelse($rpk->kegiatans as $kegiatan)
                                    <tr class="bg-white hover:bg-slate-50 transition-colors">
                                        <td class="px-4 py-3 border-r border-slate-200 text-center font-semibold">{{ $loop->iteration }}</td>
                                        <td class="px-4 py-3 border-r border-slate-200 font-bold text-slate-800">{{ $kegiatan->judul_kegiatan ?? '-' }}</td>
                                        <td class="px-4 py-3 border-r border-slate-200">{{ $kegiatan->kegiatan }}</td>
                                        <td class="px-4 py-3 border-r border-slate-200 text-center">
                                            @if($kegiatan->kategori == 'Kelompok')
                                                <span class=" text-purple-700 text-xs font-semibold">
                                                    <i class="fas fa-users mr-1"></i>Kelompok
                                                </span>
                                            @else
                                                <span class="text-gray-600 text-xs font-semibold">
                                                    <i class="fas fa-user mr-1"></i>Individu
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 border-r border-slate-200">{{ $kegiatan->tanggal ? \Carbon\Carbon::parse($kegiatan->tanggal)->format('d M Y') : '-' }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-10 text-slate-400">
                                            <i class="fas fa-folder-open text-3xl mb-2 text-slate-200"></i>
                                            <p class="text-sm font-medium">Belum ada kegiatan pada RPK ini.</p>
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
                            <h3 class="text-slate-800 font-extrabold mb-3">
                                <i class="fas fa-users text-blue-500 mr-2"></i>Daftar Anggota Kelompok
                            </h3>
                            <div class="space-y-4">
                                @foreach($kegiatanKelompok as $kegiatan)
                                    <div class="border border-slate-200 rounded-xl overflow-hidden">
                                        <div class="px-4 py-3 bg-slate-50 border-b border-slate-200">
                                            <h4 class="text-sm font-bold text-slate-800">📋 {{ $kegiatan->judul_kegiatan }}</h4>
                                            <div class="flex items-center gap-2 mt-1 text-xs text-slate-500">
                                                <span class="bg-purple-100 text-purple-700 px-2 py-0.5 rounded-full text-xs font-semibold">Kelompok</span>
                                                <span>{{ $kegiatan->anggota->count() }} anggota</span>
                                            </div>
                                        </div>
                                        <table class="w-full text-sm">
                                            <thead class="bg-gray-100 text-xs uppercase text-slate-500">
                                                <tr>
                                                    <th class="px-4 py-2 text-center w-12">No</th>
                                                    <th class="px-4 py-2 text-left">Nama</th>
                                                    <th class="px-4 py-2 text-left">NIM</th>
                                                    <th class="px-4 py-2 text-left">Prodi</th>
                                                    <th class="px-4 py-2 text-center w-24">Peran</th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-slate-100">
                                                <tr class="bg-blue-50">
                                                    <td class="px-4 py-2 text-center text-slate-500">1</td>
                                                    <td class="px-4 py-2 font-medium text-slate-800">{{ $rpk->user->name }}</td>
                                                    <td class="px-4 py-2 text-slate-500">{{ $rpk->user->nim ?? '-' }}</td>
                                                    <td class="px-4 py-2 text-slate-500">{{ $rpk->user->prodi ?? '-' }}</td>
                                                    <td class="px-4 py-2 text-center">
                                                        <span class="bg-blue-100 text-blue-700 px-2 py-0.5 rounded-full text-xs font-semibold">Ketua</span>
                                                    </td>
                                                </tr>
                                                @foreach($kegiatan->anggota as $index => $anggota)
                                                    <tr class="hover:bg-slate-50">
                                                        <td class="px-4 py-2 text-center text-slate-500">{{ $index + 2 }}</td>
                                                        <td class="px-4 py-2 font-medium text-slate-800">{{ $anggota->name }}</td>
                                                        <td class="px-4 py-2 text-slate-500">{{ $anggota->nim ?? '-' }}</td>
                                                        <td class="px-4 py-2 text-slate-500">{{ $anggota->prodi ?? '-' }}</td>
                                                        <td class="px-4 py-2 text-center">
                                                            <span class="bg-green-100 text-green-700 px-2 py-0.5 rounded-full text-xs font-semibold">Anggota</span>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                @if($kegiatan->anggota->count() == 0)
                                                    <tr>
                                                        <td colspan="5" class="px-4 py-4 text-center text-slate-400 text-xs">Belum ada anggota</td>
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
                        <h3 class="text-slate-800 font-extrabold mb-6">Timeline Riwayat Pengajuan</h3>
                        
                        <div class="relative border-l-2 border-blue-200 ml-3 space-y-8">
                            <div class="relative pl-6">
                                <div class="absolute w-4 h-4 bg-blue-500 rounded-full -left-[9px] top-1 border-2 border-white shadow"></div>
                                <p class="text-[10px] font-extrabold text-blue-600 uppercase tracking-widest mb-1">Status Terkini</p>
                                <h4 class="font-extrabold text-slate-800">Dokumen: {{ ucfirst($rpk->status) }}</h4>
                                <div class="mt-2 bg-slate-50 p-4 rounded-xl border border-slate-100">
                                    <p class="text-xs text-slate-600 font-medium">
                                        Catatan: {{ $rpk->catatan_dosen ?? 'Tidak ada catatan.' }}
                                    </p>
                                </div>
                            </div>

                            <div class="relative pl-6">
                                <div class="absolute w-4 h-4 bg-slate-300 rounded-full -left-[9px] top-1 border-2 border-white shadow"></div>
                                <p class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest mb-1">
                                    {{ $rpk->created_at ? $rpk->created_at->format('d M Y - H:i') : '-' }}
                                </p>
                                <h4 class="font-bold text-slate-800">Kegiatan Diajukan</h4>
                                <p class="text-xs text-slate-500 mt-1">
                                    Mahasiswa ({{ $rpk->user->name ?? '-' }}) membuat draf rencana kegiatan.
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
// ==========================================
// --- LOGIKA TAB GESER ---
// ==========================================
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
            btn.className = "tab-btn bg-white border-t border-l border-r border-slate-200 rounded-t-xl px-6 py-3 -mb-[1px] relative z-10 font-extrabold text-slate-800 whitespace-nowrap transition cursor-pointer";
        } else {
            btn.className = "tab-btn px-6 py-3 text-slate-500 font-bold hover:text-slate-700 whitespace-nowrap border-b border-transparent transition cursor-pointer";
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

// ==========================================
// --- LOGIKA SETUJUI & TOLAK ADMIN ---
// ==========================================
window.approveKegiatan = function(id) {
    Swal.fire({
        title: 'Setujui RPK (Admin Override)',
        input: 'textarea',
        inputLabel: 'Catatan Admin (Opsional)',
        inputPlaceholder: 'Tambahkan catatan jika perlu...',
        showCancelButton: true,
        confirmButtonText: '<i class="fas fa-check"></i> Setujui RPK',
        confirmButtonColor: '#10b981',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if(result.isConfirmed) {
            let form = document.createElement('form');
            form.method = 'POST';
            form.action = '/admin/rpk/' + id + '/status'; 
            form.innerHTML = `
                @csrf
                <input type="hidden" name="_method" value="PATCH">
                <input type="hidden" name="status" value="disetujui">
                <input type="hidden" name="catatan" value="${result.value}">
            `;
            document.body.appendChild(form);
            form.submit();
        }
    });
};

window.rejectKegiatan = function(id) {
    Swal.fire({
        title: 'Tolak RPK (Admin Override)',
        input: 'textarea',
        inputLabel: 'Alasan Penolakan (Wajib)',
        inputPlaceholder: 'Masukkan alasan RPK ini ditolak...',
        showCancelButton: true,
        confirmButtonText: '<i class="fas fa-times"></i> Tolak RPK',
        confirmButtonColor: '#ef4444',
        cancelButtonText: 'Batal',
        inputValidator: (value) => {
            if (!value) return 'Alasan penolakan wajib diisi oleh Admin!';
        }
    }).then((result) => {
        if(result.isConfirmed) {
            let form = document.createElement('form');
            form.method = 'POST';
            form.action = '/admin/rpk/' + id + '/status';
            form.innerHTML = `
                @csrf
                <input type="hidden" name="_method" value="PATCH">
                <input type="hidden" name="status" value="ditolak">
                <input type="hidden" name="catatan" value="${result.value}">
            `;
            document.body.appendChild(form);
            form.submit();
        }
    });
};
</script>

</x-app-layout>