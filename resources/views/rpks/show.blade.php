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
    <a href="{{ route('rpks.index') }}"
       class="inline-flex items-center gap-2 bg-white border border-gray-300 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm font-semibold shadow-sm transition">
        ← Kembali
    </a>
@if($rpk->status == 'draft' || $rpk->status == 'ditolak')
<button onclick="bukaModalTambahKegiatan()"
    class="bg-blue-600 hover:bg-blue-500 text-white px-5 py-2 rounded-xl text-sm font-semibold transition cursor-pointer">
    + Tambah Kegiatan
</button>
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
                <span class="text-sm font-bold text-gray-600">Nama</span>
                <span class="col-span-2 text-sm text-gray-800 font-medium">
                    {{ $rpk->user->name }}
                </span>
            </div>

            <div class="grid grid-cols-3 gap-2">
                <span class="text-sm font-bold text-gray-600">NIM</span>
                <span class="col-span-2 text-sm text-gray-800 font-medium">
                    {{ $rpk->user->nim ?? '-' }}
                </span>
            </div>

            <div class="grid grid-cols-3 gap-2 pb-4 border-b border-gray-200">
                <span class="text-sm font-bold text-gray-600">Prodi</span>
                <span class="col-span-2 text-sm text-gray-800 font-medium">
                    {{ $rpk->user->prodi ?? '-' }}
                </span>
            </div>

            <div class="grid grid-cols-3 gap-2 pt-2">
                <span class="text-sm font-bold text-gray-600">Tahun RPK</span>
                <span class="col-span-2 text-sm text-gray-800 font-medium">
                    {{ $rpk->tahun }}
                </span>
            </div>

            <div class="grid grid-cols-3 gap-2 pb-4 border-b border-gray-200">
                <span class="text-sm font-bold text-gray-600">Semester</span>
                <span class="col-span-2 text-sm text-gray-800 font-medium">
                    {{ $rpk->semester }}
                </span>
            </div>

            <div class="grid grid-cols-3 gap-2 pb-4">
                <span class="text-sm font-bold text-gray-600">Kategori</span>
                <span class="col-span-2 text-sm text-gray-800 font-medium">
                    {{ $rpk->kategori }}
                </span>
            </div>

            <div class="grid grid-cols-3 gap-2 pb-4">
                <span class="text-sm font-bold text-gray-600">Jumlah Kegiatan</span>
                <span class="col-span-2 text-sm text-gray-800 font-medium">
                    {{ $rpk->kegiatans->count() }}
                </span>
            </div>


            <div class="col-span-2 md:col-span-4 mt-2 pt-3 border-t border-gray-200">
                <span class="text-sm font-bold text-gray-600">Status</span>

                @if($rpk->status == 'draft')
                    <span class="bg-orange-500 text-white px-3 py-1 rounded-full text-xs font-semibold">
                        Draft
                    </span>

                @elseif($rpk->status == 'disetujui')
                    <span class="bg-green-500 text-white px-3 py-1 rounded-full text-xs font-semibold">
                        Disetujui
                    </span>

                @elseif($rpk->status == 'ditolak')
                    <span class="bg-red-500 text-white px-3 py-1 rounded-full text-xs font-semibold">
                        Ditolak
                    </span>

                @else
                    <span class="bg-gray-500 text-white px-3 py-1 rounded-full text-xs font-semibold">
                        Belum Diketahui
                    </span>
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
                        
                       <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden mb-6">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-600">
            <thead class="bg-gray-50 text-gray-700 uppercase text-xs tracking-wider border-b border-gray-200">
                <tr>
                    <th class="px-4 py-4 font-semibold text-center w-16">Aksi</th>
                    <th class="px-4 py-4 font-semibold text-center w-16">No</th>
                    <th class="px-4 py-4 font-semibold">Nama Kegiatan</th>
                    <th class="px-4 py-4 font-semibold">Jenis</th>
                    <th class="px-4 py-4 font-semibold">Tingkat</th>
                    <th class="px-4 py-4 font-semibold">Hasil</th>
                    <th class="px-4 py-4 font-semibold text-center">Poin</th>
                </tr>
            </thead>
            <tbody>


@forelse($rpk->kegiatans as $kegiatan)
<tr class="bg-white">
    <td class="px-4 py-4 border-r border-gray-200">

    <div class="flex gap-2">

       {{-- Tombol Hapus --}}
                @if($rpk->status == 'draft' || $rpk->status == 'ditolak')
        <form action="{{ route('kegiatans.destroy', $kegiatan->id) }}"
            method="POST">

            @csrf
            @method('DELETE')

            <button type="button"
                    onclick="hapusKegiatan(this)"
                    class="bg-red-600 hover:bg-red-500 text-white px-3 py-1 rounded-lg text-xs font-semibold">
                Hapus
            </button>

        </form>
        @else
        <span class="text-gray-400 text-xs">
            -
        </span>
        @endif

    </div>

</td>
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
    <td colspan="7" class="text-center py-4 text-gray-500">
        Belum ada kegiatan pada RPK ini
    </td>
</tr>
@endforelse
</tbody>
        </table>
    </div>
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


// --- Script Hapus Kegiatan ---
function hapusKegiatan(button) {
    Swal.fire({
        title: 'Hapus Kegiatan?',
        text: 'Data yang dihapus tidak dapat dikembalikan.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Ya, Hapus',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            button.closest('form').submit();
        }
    });
}

// --- FUNGSI HELPER UNTUK LOGIKA DROPDOWN ---
function bindLogikaForm(prefix) {
    const elMaster = document.getElementById(`${prefix}_master`);
    const elJenis = document.getElementById(`${prefix}_jenis`);
    const elTingkat = document.getElementById(`${prefix}_tingkat`);
    const elHasil = document.getElementById(`${prefix}_hasil`);
    const elPoin = document.getElementById(`${prefix}_poin`);
    
    const elKat = document.getElementById(`${prefix}_kategori`);
    const elPeran = document.getElementById(`${prefix}_peran`);
    const elPeranField = document.getElementById(`${prefix}_peranField`);
    const elJumlah = document.getElementById(`${prefix}_jumlah`);
    const elJumlahField = document.getElementById(`${prefix}_jumlahField`);

    // Logika Auto-fill Readonly
    elMaster.addEventListener('change', function() {
        let selected = this.options[this.selectedIndex];
        elJenis.value = selected.dataset.jenis || '';
        elTingkat.value = selected.dataset.tingkat || '';
        elHasil.value = selected.dataset.hasil || '';
        elPoin.value = selected.dataset.poin || '';
    });

    // Logika Kategori Kelompok/Individu
    elKat.addEventListener('change', function() {
        if(this.value === 'Kelompok') {
            elPeranField.classList.remove('hidden');
        } else {
            elPeranField.classList.add('hidden');
            elJumlahField.classList.add('hidden');
            elPeran.value = '';
            elJumlah.value = '';
        }
    });

    // Logika Peran Ketua/Anggota
    elPeran.addEventListener('change', function() {
        if(this.value === 'Ketua') {
            elJumlahField.classList.remove('hidden');
        } else {
            elJumlahField.classList.add('hidden');
            elJumlah.value = '';
        }
    });
}

function validasiForm(prefix) {
    const master = document.getElementById(`${prefix}_master`).value;
    const kat = document.getElementById(`${prefix}_kategori`).value;
    const per = document.getElementById(`${prefix}_peran`).value;
    const jml = document.getElementById(`${prefix}_jumlah`).value;

    if (!master || !kat) {
        Swal.showValidationMessage('Kegiatan dan Kategori wajib diisi!');
        return false;
    }
    if (kat === 'Kelompok' && !per) {
        Swal.showValidationMessage('Karena Kelompok, harap pilih Peran!');
        return false;
    }
    if (kat === 'Kelompok' && per === 'Ketua' && !jml) {
        Swal.showValidationMessage('Karena Anda Ketua, harap isi Jumlah Anggota!');
        return false;
    }
    return true;
}

// --- FUNGSI GENERATE HTML MODAL ---
function generateFormHTML(prefix) {
    return `
        <div class="mb-4">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Kegiatan *</label>
            <select name="master_kegiatan_id" id="${prefix}_master" class="w-full border border-gray-300 rounded-lg px-4 py-3 outline-none" required>
                <option value="">Pilih Kegiatan</option>
                @foreach($masterKegiatans as $item)
                <option value="{{ $item->id }}" data-jenis="{{ $item->jenis }}" data-tingkat="{{ $item->tingkat }}" data-hasil="{{ $item->hasil }}" data-poin="{{ $item->poin }}">
                    {{ $item->nama_kegiatan }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-1">Jenis</label>
                <input type="text" id="${prefix}_jenis" name="jenis" class="w-full bg-gray-50 border border-gray-300 text-gray-500 rounded-lg p-2 outline-none" readonly>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-1">Tingkat</label>
                <input type="text" id="${prefix}_tingkat" name="tingkat" class="w-full bg-gray-50 border border-gray-300 text-gray-500 rounded-lg p-2 outline-none" readonly>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-1">Hasil</label>
                <input type="text" id="${prefix}_hasil" name="hasil" class="w-full bg-gray-50 border border-gray-300 text-gray-500 rounded-lg p-2 outline-none" readonly>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-1">Poin</label>
                <input type="text" id="${prefix}_poin" class="w-full bg-gray-50 border border-gray-300 text-gray-500 rounded-lg p-2 outline-none" readonly>
            </div>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Kategori *</label>
            <select name="kategori" id="${prefix}_kategori" class="w-full border border-gray-300 rounded-lg px-4 py-3 outline-none" required>
                <option value="">Pilih Kategori</option>
                <option value="Individu">Individu</option>
                <option value="Kelompok">Kelompok</option>
            </select>
        </div>

        <div class="mb-4 hidden" id="${prefix}_peranField">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Peran</label>
            <select name="peran" id="${prefix}_peran" class="w-full border border-gray-300 rounded-lg px-4 py-3 outline-none">
                <option value="">Pilih Peran</option>
                <option value="Ketua">Ketua</option>
                <option value="Anggota">Anggota</option>
            </select>
        </div>

        <div class="mb-4 hidden" id="${prefix}_jumlahField">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Jumlah Anggota</label>
            <input type="number" id="${prefix}_jumlah" name="jumlah_anggota" min="1" class="w-full border border-gray-300 rounded-lg px-4 py-3 outline-none">
        </div>
    `;
}

// --- Script Tambah Kegiatan ---
function bukaModalTambahKegiatan() {
    Swal.fire({
        title: '<h2 class="text-2xl font-bold text-gray-800 text-left">Tambah Kegiatan</h2>',
        width: '600px',
        html: `
            <form id="formAdd" action="{{ route('kegiatans.store', $rpk->id) }}" method="POST" class="text-left mt-4 max-h-[65vh] overflow-y-auto px-2">
                @csrf
                ${generateFormHTML('add')}
            </form>
        `,
        showCancelButton: true,
        confirmButtonText: 'Simpan',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#2563EB',
        cancelButtonColor: '#9CA3AF',
        customClass: { popup: 'rounded-2xl p-4' },
        didOpen: () => bindLogikaForm('add'),
        preConfirm: () => {
            if(validasiForm('add')) document.getElementById('formAdd').submit();
        }
    });
}

// --- Script Edit Kegiatan ---
function bukaModalEditKegiatan(button) {
    const id = button.getAttribute('data-id');
    const actionUrl = "{{ route('kegiatans.update', ':id') }}".replace(':id', id);

    Swal.fire({
        title: '<h2 class="text-2xl font-bold text-gray-800 text-left">Edit Kegiatan</h2>',
        width: '600px',
        html: `
            <form id="formEdit" action="${actionUrl}" method="POST" class="text-left mt-4 max-h-[65vh] overflow-y-auto px-2">
                @csrf
                @method('PUT')
                ${generateFormHTML('edit')}
            </form>
        `,
        showCancelButton: true,
        confirmButtonText: 'Update',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#2563EB',
        cancelButtonColor: '#9CA3AF',
        customClass: { popup: 'rounded-2xl p-4' },
        didOpen: () => {
            bindLogikaForm('edit');
            
            // Auto-fill data
            document.getElementById('edit_master').value = button.getAttribute('data-master');
            document.getElementById('edit_kategori').value = button.getAttribute('data-kategori');
            
            // Trigger events to calculate readonly fields
            document.getElementById('edit_master').dispatchEvent(new Event('change'));
            
            if (button.getAttribute('data-kategori') === 'Kelompok') {
                document.getElementById('edit_peranField').classList.remove('hidden');
                document.getElementById('edit_peran').value = button.getAttribute('data-peran');
                
                if (button.getAttribute('data-peran') === 'Ketua') {
                    document.getElementById('edit_jumlahField').classList.remove('hidden');
                    document.getElementById('edit_jumlah').value = button.getAttribute('data-jumlah');
                }
            }
        },
        preConfirm: () => {
            if(validasiForm('edit')) document.getElementById('formEdit').submit();
        }
    });
}

</script>

</x-app-layout>