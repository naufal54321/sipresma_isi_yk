<x-app-layout>

<style>
    .hide-scrollbar::-webkit-scrollbar { display: none; }
    .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
</style>

<div class="max-w-8xl mx-auto py-6">

    {{-- BANNER UNTUK ANGGOTA --}}
    @php
        $user = Auth::user();
        $isPemilik = $rpk->user_id == $user->id;
        $isAnggota = !$isPemilik && $rpk->kegiatans()
            ->whereHas('anggota', function($q) use ($user) {
                $q->where('user_id', $user->id);
            })->exists();
    @endphp

    @if($isAnggota)
        <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 mb-6">
            <div class="flex items-center gap-3">
                <svg class="w-6 h-6 text-blue-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div>
                    <p class="text-sm font-semibold text-blue-800">Anda adalah Anggota Kelompok</p>
                    <p class="text-xs text-blue-600 mt-1">Anda hanya dapat melihat data. Anda tidak dapat menambah, mengedit, atau menghapus kegiatan.</p>
                </div>
            </div>
        </div>
    @endif

    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
        <h1 class="text-3xl font-bold text-gray-900">Detail Kegiatan RPK</h1>

        <div class="flex items-center gap-3">
    <a href="{{ route('rpks.index') }}"
       class="inline-flex items-center gap-2 bg-white border border-gray-300 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm font-semibold shadow-sm transition">
        ← Kembali
    </a>
    
   {{-- ✅ HANYA TAMPILKAN TOMBOL JIKA BELUM ADA KEGIATAN --}}
    @php
        $jumlahKegiatan = $isAnggota 
            ? $rpk->kegiatans->filter(function($k) use ($user) { 
                return $k->kategori == 'Kelompok' && $k->anggota->contains('id', $user->id); 
            })->count()
            : $rpk->kegiatans->count();
    @endphp
    
    @if($jumlahKegiatan < 1 && ($rpk->status == 'draft' || $rpk->status == 'ditolak'))
        <button onclick="bukaModalTambahKegiatan()"
            class="bg-blue-600 hover:bg-blue-500 text-white px-5 py-2 rounded-xl text-sm font-semibold transition cursor-pointer">
            + Tambah Kegiatan
        </button>
    @elseif($jumlahKegiatan >= 1)
       
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
                        <span class="text-sm font-bold text-gray-600">Nama</span>
                        <span class="col-span-2 text-sm text-gray-800 font-medium">
                            {{ $rpk->user->name }}
                            @if($isPemilik)<span class="text-xs text-blue-500 ml-1"></span>
                            @elseif($isAnggota)<span class="text-xs text-gray-400 ml-1">(Ketua)</span>@endif
                        </span>
                    </div>

                    <div class="grid grid-cols-3 gap-2">
                        <span class="text-sm font-bold text-gray-600">NIM</span>
                        <span class="col-span-2 text-sm text-gray-800 font-medium">{{ $rpk->user->nim ?? '-' }}</span>
                    </div>

                    <div class="grid grid-cols-3 gap-2 pb-4 border-b border-gray-200">
                        <span class="text-sm font-bold text-gray-600">Prodi</span>
                        <span class="col-span-2 text-sm text-gray-800 font-medium">{{ $rpk->user->prodi ?? '-' }}</span>
                    </div>

                    <div class="grid grid-cols-3 gap-2 pt-2">
                        <span class="text-sm font-bold text-gray-600">Tahun RPK</span>
                        <span class="col-span-2 text-sm text-gray-800 font-medium">{{ $rpk->tahun }}</span>
                    </div>

                    <div class="grid grid-cols-3 gap-2 pb-4 border-b border-gray-200">
                        <span class="text-sm font-bold text-gray-600">Semester</span>
                        <span class="col-span-2 text-sm text-gray-800 font-medium">{{ $rpk->semester }}</span>
                    </div>

                   <div class="grid grid-cols-3 gap-2 pb-4">
    <span class="text-sm font-bold text-gray-600">Kategori</span>
    <span class="col-span-2 text-sm text-gray-800 font-medium">
        @if($isAnggota)
            @php
                $kegiatanAnggota = $rpk->kegiatans->filter(function($k) use ($user) { 
                    return $k->kategori == 'Kelompok' && $k->anggota->contains('id', $user->id); 
                })->first();
            @endphp
            {{ $kegiatanAnggota ? $kegiatanAnggota->kategori : '-' }}
        @else
            @php
                $kegiatanPertama = $rpk->kegiatans->first();
            @endphp
            {{ $kegiatanPertama ? $kegiatanPertama->kategori : '-' }}
        @endif
    </span>
</div>

                    <div class="col-span-2 md:col-span-4 mt-2 pt-3 border-t border-gray-200">
                        <span class="text-sm font-bold text-gray-600">Status</span>
                        @if($rpk->status == 'draft')
                            <span class="bg-orange-500 text-white px-3 py-1 rounded-full text-xs font-semibold">Draft</span>
                        @elseif($rpk->status == 'disetujui')
                            <span class="bg-green-500 text-white px-3 py-1 rounded-full text-xs font-semibold">Disetujui</span>
                        @elseif($rpk->status == 'ditolak')
                            <span class="bg-red-500 text-white px-3 py-1 rounded-full text-xs font-semibold">Ditolak</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- TABEL KEGIATAN --}}
        <div class="lg:col-span-8">
            <div class="bg-white border border-gray-200 shadow-sm rounded-xl overflow-hidden flex flex-col h-full">
                
                <div class="flex border-b border-gray-200 bg-gray-50 px-2 pt-2 overflow-x-auto hide-scrollbar" id="tab-headers">
                    <button onclick="geserTab(0)" class="tab-btn bg-white border-t border-l border-r border-gray-200 rounded-t-lg px-6 py-3 -mb-[1px] relative z-10 font-bold text-gray-800 whitespace-nowrap transition cursor-pointer">
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
                        
                        <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden mb-6">
                            
                                <table class="w-full text-sm text-left text-gray-600">
                                    <thead class="bg-gray-50 text-gray-700 uppercase text-xs tracking-wider border-b border-gray-200">
                                        <tr>
                                            <th class="px-3 py-3 font-semibold text-center w-10">No</th>
                                            <th class="px-3 py-3 font-semibold">Judul Kegiatan</th>
                                            <th class="px-3 py-3 font-semibold">Nama Kegiatan</th>
                                            <th class="px-3 py-3 font-semibold text-center">Kategori</th>
                                            <th class="px-3 py-3 font-semibold text-center">Tanggal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @php
                                        if($isAnggota) {
                                            $kegiatansTampil = $rpk->kegiatans->filter(function($k) use ($user) {
                                                return $k->kategori == 'Kelompok' && $k->anggota->contains('id', $user->id);
                                            });
                                        } else {
                                            $kegiatansTampil = $rpk->kegiatans;
                                        }
                                    @endphp

                                    @forelse($kegiatansTampil as $kegiatan)
                                    <tr class="bg-white hover:bg-gray-50">
                                        <td class="px-4 py-3 border-r border-gray-200 text-center">{{ $loop->iteration }}</td>
                                        <td class="px-4 py-3 border-r border-gray-200 font-medium text-gray-800">{{ $kegiatan->judul_kegiatan }}</td>
                                        <td class="px-4 py-3 border-r border-gray-200 font-medium text-gray-800">{{ $kegiatan->kegiatan }}</td>
                                        <td class="px-4 py-3 border-r border-gray-200">
                                            @if($kegiatan->kategori == 'Kelompok')
                                                Kelompok
                                                </span>
                                            @else
                                                Individu
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3">{{ $kegiatan->tanggal ? \Carbon\Carbon::parse($kegiatan->tanggal)->format('d M Y') : '-' }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="{{ $isPemilik && ($rpk->status == 'draft' || $rpk->status == 'ditolak') ? '8' : '7' }}" class="text-center py-4 text-gray-500">
                                            Belum ada kegiatan pada RPK ini
                                        </td>
                                    </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            
                        </div>

                        {{-- DAFTAR ANGGOTA KELOMPOK --}}
                        @if($isPemilik || $isAnggota)    {{-- 🔧 TAMPILKAN UNTUK PEMILIK & ANGGOTA --}}
                            @php 
                                if($isAnggota) {
                                    // Anggota hanya lihat kelompok di mana dia terdaftar
                                    $kegiatanKelompok = $rpk->kegiatans->where('kategori', 'Kelompok')->filter(function($k) use ($user) {
                                        return $k->anggota->contains('id', $user->id);
                                    });
                                } else {
                                    $kegiatanKelompok = $rpk->kegiatans->where('kategori', 'Kelompok');
                                }
                            @endphp
                            @if($kegiatanKelompok->count() > 0)
                            <div class="mt-6 bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
                                <div class="px-6 py-4 border-b border-gray-200 bg-blue-50">
                                    <h3 class="text-sm font-bold text-gray-800">
                                        <i class="fas fa-users text-blue-500 mr-2"></i>Daftar Anggota Kelompok
                                    </h3>
                                </div>
                                <div class="p-4 space-y-6">
                                    @foreach($kegiatanKelompok as $kegiatan)
                                        <div class="border border-gray-200 rounded-lg overflow-hidden">
                                            <div class="px-4 py-3 bg-gray-50 border-b border-gray-200">
                                                <div class="flex items-center justify-between flex-wrap gap-2">
                                                    <h4 class="text-sm font-semibold text-gray-700">{{ $kegiatan->judul_kegiatan }}</h4>
                                                    <div class="flex items-center gap-2">
                                                        <span class="bg-purple-100 text-purple-700 px-2 py-0.5 rounded-full text-xs font-semibold">
                                                            <i class="fas fa-users mr-1"></i>Kelompok
                                                        </span>
                                                        <span class="text-xs text-gray-400">{{ $kegiatan->anggota->count() }} anggota</span>
                                                    </div>
                                                </div>
                                                <div class="flex items-center gap-3 mt-1 text-xs text-gray-500">
                                                    <span><i class="far fa-calendar mr-1"></i>{{ \Carbon\Carbon::parse($kegiatan->tanggal)->format('d M Y') }}</span>
                                                    <span><i class="fas fa-tag mr-1"></i>{{ $kegiatan->jenis }}</span>
                                                    <span><i class="fas fa-layer-group mr-1"></i>{{ $kegiatan->tingkat }}</span>
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
                                                        <td class="px-4 py-2 font-medium text-gray-800">{{ $rpk->user->name }} <span class="text-blue-500 text-xs ml-1"></span></td>
                                                        <td class="px-4 py-2 text-gray-500">{{ $rpk->user->nim ?? '-' }}</td>
                                                        <td class="px-4 py-2 text-gray-500">{{ $rpk->user->prodi ?? '-' }}</td>
                                                        <td class="px-4 py-2 text-center"><span class="bg-blue-100 text-blue-700 px-2 py-0.5 rounded-full text-xs font-semibold">Ketua</span></td>
                                                    </tr>
                                                    @foreach($kegiatan->anggota as $index => $anggota)
                                                        <tr class="hover:bg-gray-50">
                                                            <td class="px-4 py-2 text-center text-gray-500">{{ $index + 2 }}</td>
                                                            <td class="px-4 py-2 font-medium text-gray-800">{{ $anggota->name }}</td>
                                                            <td class="px-4 py-2 text-gray-500">{{ $anggota->nim ?? '-' }}</td>
                                                            <td class="px-4 py-2 text-gray-500">{{ $anggota->prodi ?? '-' }}</td>
                                                            <td class="px-4 py-2 text-center"><span class="bg-green-100 text-green-700 px-2 py-0.5 rounded-full text-xs font-semibold">Anggota</span></td>
                                                        </tr>
                                                    @endforeach
                                                    @if($kegiatan->anggota->count() == 0)
                                                        <tr><td colspan="5" class="px-4 py-4 text-center text-gray-400 text-xs">Belum ada anggota ditambahkan</td></tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif
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
                                <p class="text-xs font-semibold text-gray-500 mb-1">{{ $rpk->created_at ? $rpk->created_at->format('d M Y - H:i') : '-' }}</p>
                                <h4 class="font-bold text-gray-800">Kegiatan Diajukan</h4>
                                <p class="text-sm text-gray-600 mt-1">Mahasiswa membuat draf rencana kegiatan dan mengajukannya ke sistem.</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{{-- SCRIPT TABS --}}
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
        if (i === index) btn.className = "tab-btn bg-white border-t border-l border-r border-gray-200 rounded-t-lg px-6 py-3 -mb-[1px] relative z-10 font-bold text-gray-800 whitespace-nowrap transition cursor-pointer";
        else btn.className = "tab-btn px-6 py-3 text-gray-500 font-bold hover:text-gray-700 whitespace-nowrap border-b border-transparent transition cursor-pointer";
    });
};
(function() {
    var container = document.getElementById('tab-content-container');
    if (container) container.onscroll = function() { var i = Math.round(container.scrollLeft / container.clientWidth); window.updateGayaTab(i); };
})();
</script>

{{-- SCRIPT FORM MODAL (HANYA UNTUK PEMILIK) --}}
@if($isPemilik && ($rpk->status == 'draft' || $rpk->status == 'ditolak'))
<script>
window.hapusKegiatan = function(button) {
    Swal.fire({
        title: 'Hapus Kegiatan?', text: 'Data yang dihapus tidak dapat dikembalikan.', icon: 'warning',
        showCancelButton: true, confirmButtonColor: '#dc2626', cancelButtonColor: '#6b7280',
        confirmButtonText: 'Ya, Hapus', cancelButtonText: 'Batal', allowOutsideClick: false, allowEscapeKey: false,
        customClass: { popup: 'rounded-2xl', confirmButton: 'rounded-xl font-semibold', cancelButton: 'rounded-xl font-semibold' }
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({ title: 'Menghapus...', text: 'Mohon tunggu sebentar', allowOutsideClick: false, showConfirmButton: false, didOpen: () => Swal.showLoading() });
            button.closest('form').submit();
        }
    });
};

window.anggotaTerpilih = {};

// 🔧 FUNGSI TAMPILKAN PESAN
window.tampilkanPesanAnggota = function(prefix, pesan, tipe) {
    var elPesan = document.getElementById(`${prefix}_pesanAnggota`);
    if (elPesan) {
        elPesan.textContent = pesan;
        elPesan.className = tipe === 'error' ? 'text-xs text-red-500 mt-1' : 'text-xs text-green-500 mt-1';
        setTimeout(() => { elPesan.textContent = ''; }, 3000);
    }
};

// ⚡ BUKA DROPDOWN SAAT FOCUS
window.bukaDropdownAnggota = function(prefix) {
    var dropdown = document.getElementById(`${prefix}_dropdownList`);
    if (dropdown) {
        dropdown.classList.remove('hidden');
        window.filterAnggotaDropdown(prefix);
    }
};

// ⚡ TUTUP DROPDOWN SAAT KLIK DI LUAR
document.addEventListener('click', function(e) {
    if (!e.target.closest('[id$="_cariAnggota"]') && !e.target.closest('[id$="_dropdownList"]')) {
        document.querySelectorAll('[id$="_dropdownList"]').forEach(function(el) {
            el.classList.add('hidden');
        });
    }
});

// ⚡ FILTER DROPDOWN
window.filterAnggotaDropdown = function(prefix) {
    var input = document.getElementById(`${prefix}_cariAnggota`);
    var dropdown = document.getElementById(`${prefix}_dropdownList`);
    
    if (!input || !dropdown) return;
    
    dropdown.classList.remove('hidden');
    
    var keyword = input.value.toLowerCase().trim();
    var items = dropdown.querySelectorAll('div[data-value]');
    
    items.forEach(function(item) {
        var nama = item.getAttribute('data-nama') || '';
        var nim = item.getAttribute('data-nim') || '';
        var text = item.textContent.toLowerCase();
        
        if (keyword === '' || nama.includes(keyword) || nim.includes(keyword) || text.includes(keyword)) {
            item.style.display = '';
        } else {
            item.style.display = 'none';
        }
    });
};

// ⚡ PILIH ANGGOTA DARI DROPDOWN
window.pilihAnggota = function(prefix, id, text) {
    var input = document.getElementById(`${prefix}_cariAnggota`);
    var hiddenValue = document.getElementById(`${prefix}_anggotaDropdown`);
    var hiddenText = document.getElementById(`${prefix}_anggotaText`);
    var dropdown = document.getElementById(`${prefix}_dropdownList`);
    
    if (input) input.value = text;
    if (hiddenValue) hiddenValue.value = id;
    if (hiddenText) hiddenText.value = text;
    if (dropdown) dropdown.classList.add('hidden');
};

// ⚡ TAMBAH ANGGOTA
window.tambahAnggotaDirect = function(prefix) {
    var hiddenValue = document.getElementById(`${prefix}_anggotaDropdown`);
    var hiddenText = document.getElementById(`${prefix}_anggotaText`);
    var elJumlah = document.getElementById(`${prefix}_jumlah`);
    var inputCari = document.getElementById(`${prefix}_cariAnggota`);
    
    var sv = hiddenValue?.value || '';
    var st = hiddenText?.value || '';
    var max = parseInt(elJumlah?.value || 0);
    
    if (!window.anggotaTerpilih[prefix]) window.anggotaTerpilih[prefix] = [];
    
    if (!sv) { 
        window.tampilkanPesanAnggota(prefix, 'Silakan cari dan pilih mahasiswa terlebih dahulu!', 'error');
        return; 
    }
    if (window.anggotaTerpilih[prefix].find(a => a.id === sv)) { 
        window.tampilkanPesanAnggota(prefix, 'Mahasiswa ini sudah ada dalam daftar!', 'error');
        return; 
    }
    if (window.anggotaTerpilih[prefix].length >= max) { 
        window.tampilkanPesanAnggota(prefix, `Maksimal ${max} anggota!`, 'error');
        return; 
    }
    
    window.anggotaTerpilih[prefix].push({id: sv, text: st}); 
    window.renderAnggotaTerpilih(prefix); 
    
    // Reset
    if (hiddenValue) hiddenValue.value = '';
    if (hiddenText) hiddenText.value = '';
    if (inputCari) {
        inputCari.value = '';
        inputCari.placeholder = '🔍 Cari dan pilih mahasiswa...';
    }
    
    window.tampilkanPesanAnggota(prefix, 'Anggota berhasil ditambahkan', 'sukses');
};

window.bindLogikaForm = function(prefix) {
    var elKat = document.getElementById(`${prefix}_kategori`);
    var elPeran = document.getElementById(`${prefix}_peran`);
    var elPeranField = document.getElementById(`${prefix}_peranField`);
    var elJumlah = document.getElementById(`${prefix}_jumlah`);
    var elJumlahField = document.getElementById(`${prefix}_jumlahField`);
    var elAnggotaContainer = document.getElementById(`${prefix}_anggotaContainer`);
    var elCariAnggota = document.getElementById(`${prefix}_cariAnggota`);

    window.anggotaTerpilih[prefix] = [];
    
    // Reset pencarian
    if (elCariAnggota) {
        elCariAnggota.value = '';
        elCariAnggota.placeholder = '🔍 Cari dan pilih mahasiswa...';
    }

    function updateAnggotaVisibility() {
        var kat = elKat?.value;
        var peran = elPeran?.value;
        var jumlah = parseInt(elJumlah?.value || 0);
        
        if (kat === 'Kelompok' && peran === 'Ketua' && jumlah > 0) {
            if (elAnggotaContainer) {
                elAnggotaContainer.classList.remove('hidden');
                if (elCariAnggota) {
                    elCariAnggota.value = '';
                    elCariAnggota.placeholder = '🔍 Cari dan pilih mahasiswa...';
                }
            }
        } else {
            if (elAnggotaContainer) elAnggotaContainer.classList.add('hidden');
            window.anggotaTerpilih[prefix] = [];
            window.renderAnggotaTerpilih(prefix);
        }
    }
    
    if (elKat) {
        elKat.addEventListener('change', function() {
            if (this.value === 'Kelompok') {
                if (elPeranField) elPeranField.classList.remove('hidden');
            } else { 
                if (elPeranField) elPeranField.classList.add('hidden'); 
                if (elJumlahField) elJumlahField.classList.add('hidden'); 
                if (elAnggotaContainer) elAnggotaContainer.classList.add('hidden'); 
                if (elPeran) elPeran.value = ''; 
                if (elJumlah) elJumlah.value = ''; 
                window.anggotaTerpilih[prefix] = []; 
                window.renderAnggotaTerpilih(prefix); 
            }
        });
    }
    
    if (elPeran) {
        elPeran.addEventListener('change', function() {
            if (this.value === 'Ketua') {
                if (elJumlahField) elJumlahField.classList.remove('hidden');
            } else { 
                if (elJumlahField) elJumlahField.classList.add('hidden'); 
                if (elAnggotaContainer) elAnggotaContainer.classList.add('hidden'); 
                if (elJumlah) elJumlah.value = ''; 
                window.anggotaTerpilih[prefix] = []; 
                window.renderAnggotaTerpilih(prefix); 
            }
        });
    }
    
    if (elJumlah) {
        elJumlah.addEventListener('change', function() { updateAnggotaVisibility(); });
        elJumlah.addEventListener('input', function() {
            var j = parseInt(this.value);
            if (j > 0 && elKat?.value === 'Kelompok' && elPeran?.value === 'Ketua') {
                if (elAnggotaContainer) elAnggotaContainer.classList.remove('hidden');
            }
        });
        elJumlah.addEventListener('blur', function() { updateAnggotaVisibility(); });
    }
};

window.renderAnggotaTerpilih = function(prefix) {
    var c = document.getElementById(`${prefix}_anggotaTerpilih`);
    var hi = document.getElementById(`${prefix}_anggotaHidden`);
    if (!c) return;
    
    var h = '', ids = [];
    if (window.anggotaTerpilih[prefix]) {
        window.anggotaTerpilih[prefix].forEach(function(a, i) {
            ids.push(a.id);
            h += `<span class="inline-flex items-center gap-1 px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-medium">${a.text}<button type="button" onclick="window.hapusAnggota('${prefix}',${i})" class="ml-1 text-blue-500 hover:text-red-500 transition"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button></span>`;
        });
    }
    c.innerHTML = h || '<span class="text-xs text-gray-400">Belum ada anggota dipilih</span>';
    if (hi) hi.value = ids.join(',');
};

window.hapusAnggota = function(prefix, index) { 
    if (window.anggotaTerpilih[prefix]) {
        window.anggotaTerpilih[prefix].splice(index, 1); 
    }
    window.renderAnggotaTerpilih(prefix); 
};

window.validasiForm = function(prefix) {
    var m = document.getElementById(`${prefix}_master`)?.value;
    var j = document.getElementById(`${prefix}_judul`)?.value?.trim();
    var t = document.getElementById(`${prefix}_tanggal`)?.value;
    var k = document.getElementById(`${prefix}_kategori`)?.value;
    var p = document.getElementById(`${prefix}_peran`)?.value;
    var jml = document.getElementById(`${prefix}_jumlah`)?.value;
    
    if (!m || !j || !t || !k) { 
        Swal.showValidationMessage('Kegiatan, Judul, Tanggal, dan Kategori wajib diisi!'); 
        return false; 
    }
    if (k === 'Kelompok' && !p) { 
        Swal.showValidationMessage('Karena Kelompok, harap pilih Peran!'); 
        return false; 
    }
    if (k === 'Kelompok' && p === 'Ketua') {
        if (!jml) { 
            Swal.showValidationMessage('Karena Anda Ketua, harap isi Jumlah Anggota!'); 
            return false; 
        }
        var dipilih = (window.anggotaTerpilih[prefix] || []).length;
        var diminta = parseInt(jml);
        if (dipilih < diminta) { 
            Swal.showValidationMessage(`Harap pilih ${diminta} anggota! (Baru ${dipilih})`); 
            return false; 
        }
    }
    return true;
};

window.generateFormHTML = function(prefix) {
    return `
        <div class="mb-4">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Kegiatan *</label>
            <select name="master_kegiatan_id" id="${prefix}_master" class="w-full border border-gray-300 rounded-lg px-4 py-3 outline-none focus:ring-2 focus:ring-blue-500 transition" required>
                <option value="">Pilih Kegiatan</option>
                @foreach($masterKegiatans as $item)
                    <option value="{{ $item->id }}">{{ $item->nama_kegiatan }}</option>
                @endforeach
            </select>
        </div>
    
        <div class="mb-4">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Judul Kegiatan *</label>
            <input type="text" name="judul_kegiatan" id="${prefix}_judul" class="w-full border border-gray-300 rounded-lg px-4 py-3 outline-none focus:ring-2 focus:ring-blue-500 transition" placeholder="Masukkan judul kegiatan" required>
        </div>
        
        <div class="mb-4">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Kegiatan *</label>
            <input type="date" name="tanggal" id="${prefix}_tanggal" class="w-full border border-gray-300 rounded-lg px-4 py-3 outline-none focus:ring-2 focus:ring-blue-500 transition" required>
        </div>
        
        <div class="mb-4">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Kategori *</label>
            <select name="kategori" id="${prefix}_kategori" class="w-full border border-gray-300 rounded-lg px-4 py-3 outline-none focus:ring-2 focus:ring-blue-500 transition" required>
                <option value="">Pilih Kategori</option>
                <option value="Individu">Individu</option>
                <option value="Kelompok">Kelompok</option>
            </select>
        </div>
        
        <div class="mb-4 hidden" id="${prefix}_peranField">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Peran</label>
            <select name="peran" id="${prefix}_peran" class="w-full border border-gray-300 rounded-lg px-4 py-3 outline-none focus:ring-2 focus:ring-blue-500 transition">
                <option value="">Pilih Peran</option>
                <option value="Ketua">Ketua</option>
            </select>
        </div>
        
        <div class="mb-4 hidden" id="${prefix}_jumlahField">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Jumlah Anggota</label>
            <input type="number" id="${prefix}_jumlah" name="jumlah_anggota" min="1" class="w-full border border-gray-300 rounded-lg px-4 py-3 outline-none focus:ring-2 focus:ring-blue-500 transition" placeholder="Masukkan jumlah anggota">
        </div>
        
        <div class="mb-4 hidden" id="${prefix}_anggotaContainer">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Tambah Anggota</label>
            
            {{-- ⚡ DROPDOWN DENGAN PENCARIAN DI DALAMNYA --}}
            <div class="flex gap-2 mb-3">
                <div class="relative flex-1">
                    <input type="text" 
                        id="${prefix}_cariAnggota" 
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm outline-none focus:ring-2 focus:ring-blue-500 transition" 
                        placeholder="Cari dan pilih mahasiswa..."
                        onfocus="window.bukaDropdownAnggota('${prefix}')"
                        oninput="window.filterAnggotaDropdown('${prefix}')"
                        onclick="window.bukaDropdownAnggota('${prefix}')"
                        autocomplete="off">
                    
                    <div id="${prefix}_dropdownList" 
                        class="absolute z-50 w-full mt-1 bg-white border border-gray-200 rounded-lg shadow-lg max-h-48 overflow-y-auto hidden">
                        @foreach(\App\Models\User::role('Mahasiswa')->where('id', '!=', auth()->id())->orderBy('name')->get() as $mhs)
                            <div class="px-4 py-2 text-sm hover:bg-blue-50 cursor-pointer border-b border-gray-100 last:border-b-0" 
                                data-value="{{ $mhs->id }}" 
                                data-text="{{ $mhs->name }} ({{ $mhs->nim }})"
                                data-nama="{{ strtolower($mhs->name) }}" 
                                data-nim="{{ $mhs->nim }}"
                                onclick="window.pilihAnggota('${prefix}', '{{ $mhs->id }}', '{{ $mhs->name }} ({{ $mhs->nim }})')">
                                {{ $mhs->name }} ({{ $mhs->nim }})
                            </div>
                        @endforeach
                    </div>
                </div>
                <button type="button" onclick="window.tambahAnggotaDirect('${prefix}')" 
                    class="px-4 py-2 bg-blue-600 hover:bg-blue-500 text-white rounded-lg text-sm font-semibold transition whitespace-nowrap">
                    + Tambah
                </button>
            </div>
            
            <input type="hidden" id="${prefix}_anggotaDropdown" value="">
            <input type="hidden" id="${prefix}_anggotaText" value="">
            
            <p id="${prefix}_pesanAnggota" class="text-xs mt-1"></p>
            
            <div class="p-3 bg-gray-50 rounded-lg border border-gray-200 min-h-[50px]">
                <p class="text-xs text-gray-400 mb-2">Anggota terpilih:</p>
                <div id="${prefix}_anggotaTerpilih" class="flex flex-wrap gap-2">
                    <span class="text-xs text-gray-400">Belum ada anggota dipilih</span>
                </div>
            </div>
            <input type="hidden" name="anggota_ids" id="${prefix}_anggotaHidden" value="">
        </div>`;
};

window.bukaModalTambahKegiatan = function() {
    Swal.fire({
        title: '<h2 class="text-2xl font-bold text-gray-800 text-left">Tambah Kegiatan</h2>', width: '650px',
        html: `<form id="formAdd" action="{{ route('kegiatans.store', $rpk->id) }}" method="POST" class="text-left mt-4 max-h-[65vh] overflow-y-auto px-2">@csrf ${window.generateFormHTML('add')}</form>`,
        showCancelButton: true, confirmButtonText: 'Simpan', cancelButtonText: 'Batal', confirmButtonColor: '#2563EB', cancelButtonColor: '#9CA3AF',
        allowOutsideClick: false, allowEscapeKey: false, customClass: { popup: 'rounded-2xl p-6' },
        didOpen: () => { window.bindLogikaForm('add'); window.anggotaTerpilih['add'] = []; },
        preConfirm: () => { if(window.validasiForm('add')) { Swal.showLoading(); document.getElementById('formAdd').submit(); return false; } return false; }
    });
};

window.bukaModalEditKegiatan = function(button) {
    var id = button.getAttribute('data-id');
    var actionUrl = "{{ route('kegiatans.update', ':id') }}".replace(':id', id);
    Swal.fire({
        title: '<h2 class="text-2xl font-bold text-gray-800 text-left">Edit Kegiatan</h2>', width: '650px',
        html: `<form id="formEdit" action="${actionUrl}" method="POST" class="text-left mt-4 max-h-[65vh] overflow-y-auto px-2">@csrf @method('PUT') ${window.generateFormHTML('edit')}</form>`,
        showCancelButton: true, confirmButtonText: 'Update', cancelButtonText: 'Batal', confirmButtonColor: '#2563EB', cancelButtonColor: '#9CA3AF',
        allowOutsideClick: false, allowEscapeKey: false, customClass: { popup: 'rounded-2xl p-6' },
        didOpen: () => {
            window.bindLogikaForm('edit'); window.anggotaTerpilih['edit'] = [];
            document.getElementById('edit_master').value = button.getAttribute('data-master');
            document.getElementById('edit_judul').value = button.getAttribute('data-judul') || '';
            document.getElementById('edit_tanggal').value = button.getAttribute('data-tanggal') || '';
            
            var katValue = button.getAttribute('data-kategori');
            document.getElementById('edit_kategori').value = katValue;
            
            if (katValue === 'Kelompok') {
                document.getElementById('edit_peranField').classList.remove('hidden');
                document.getElementById('edit_peran').value = button.getAttribute('data-peran');
                if (button.getAttribute('data-peran') === 'Ketua') {
                    document.getElementById('edit_jumlahField').classList.remove('hidden');
                    document.getElementById('edit_jumlah').value = button.getAttribute('data-jumlah');
                    document.getElementById('edit_anggotaContainer').classList.remove('hidden');
                }
            }
            
            // Trigger change events
            setTimeout(() => {
                document.getElementById('edit_kategori').dispatchEvent(new Event('change'));
                document.getElementById('edit_peran').dispatchEvent(new Event('change'));
                document.getElementById('edit_jumlah').dispatchEvent(new Event('change'));
            }, 100);
        },
        preConfirm: () => { if(window.validasiForm('edit')) { Swal.showLoading(); document.getElementById('formEdit').submit(); return false; } return false; }
    });
};
</script>
@endif

</x-app-layout>