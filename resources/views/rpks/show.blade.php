<x-app-layout>

<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">
                    Detail RPK
                </h1>
                <p class="text-gray-500 mt-1">
                    Daftar kegiatan pada RPK
                </p>
            </div>

            <div class="flex gap-3">
                <a href="{{ route('rpks.index') }}"
                   class="bg-gray-500 hover:bg-gray-400 text-white px-5 py-2 rounded-xl text-sm font-semibold transition">
                    ← Kembali
                </a>

                <button onclick="bukaModalTambahKegiatan()"
                   class="bg-blue-600 hover:bg-blue-500 text-white px-5 py-2 rounded-xl text-sm font-semibold transition cursor-pointer">
                    + Tambah Kegiatan
                </button>
            </div>
        </div>

        <div class="bg-white shadow rounded-2xl p-6 mb-6">
            <div class="grid grid-cols-3 gap-6">
                <div>
                    <p class="text-sm text-gray-500">Tahun</p>
                    <h1 class="text-lg font-bold text-gray-800">{{ $rpk->tahun }}</h1>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Semester</p>
                    <h1 class="text-lg font-bold text-gray-800">{{ $rpk->semester }}</h1>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Kategori</p>
                    <h1 class="text-lg font-bold text-gray-800">{{ $rpk->kategori }}</h1>
                </div>
            </div>
        </div>

        <div class="bg-white shadow-xl rounded-2xl overflow-hidden">
            <table class="w-full text-sm text-left text-gray-600">
                <thead class="bg-gray-50 uppercase text-xs tracking-wider">
                    <tr>
                        <th class="px-6 py-4">No</th>
                        <th class="px-6 py-4">Kegiatan</th>
                        <th class="px-6 py-4">Jenis</th>
                        <th class="px-6 py-4">Tingkat</th>
                        <th class="px-6 py-4">Kategori</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Catatan Dosen</th>
                        <th class="px-6 py-4 text-center">Poin</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($rpk->kegiatans as $kegiatan)
                    <tr class="border-b hover:bg-blue-50 transition">
                        <td class="px-6 py-4">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4">{{ $kegiatan->kegiatan }}</td>
                        <td class="px-6 py-4">{{ $kegiatan->jenis }}</td>
                        <td class="px-6 py-4">{{ $kegiatan->tingkat }}</td>
                        <td class="px-6 py-4">{{ $kegiatan->kategori }}</td>
                        <td class="px-6 py-4">
                            @if($kegiatan->status == 'draft')
                                <span class="bg-orange-500 text-white px-3 py-1 rounded-full text-xs">Draft</span>
                            @elseif($kegiatan->status == 'disetujui')
                                <span class="bg-green-500 text-white px-3 py-1 rounded-full text-xs">Disetujui</span>
                            @else
                                <span class="bg-red-500 text-white px-3 py-1 rounded-full text-xs">Ditolak</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if($kegiatan->catatan_dosen)
                                <span class="text-gray-700">{{ $kegiatan->catatan_dosen }}</span>
                            @else
                                <span class="text-gray-400 italic">Belum ada catatan</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            {{ $kegiatan->masterKegiatan->poin ?? '-' }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($kegiatan->status == 'draft' || $kegiatan->status == 'ditolak')
                            <div class="flex justify-center gap-2">
                                
                                <button type="button"
                                        onclick="bukaModalEditKegiatan(this)"
                                        data-id="{{ $kegiatan->id }}"
                                        data-master="{{ $kegiatan->master_kegiatan_id }}"
                                        data-tanggal="{{ $kegiatan->tanggal }}"
                                        data-kategori="{{ $kegiatan->kategori }}"
                                        data-peran="{{ $kegiatan->peran }}"
                                        data-jumlah="{{ $kegiatan->jumlah_anggota }}"
                                        class="bg-yellow-500 hover:bg-yellow-400 text-white px-3 py-2 rounded-lg text-sm transition">
                                    Edit
                                </button>

                                <form action="{{ route('kegiatans.destroy', $kegiatan->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button"
                                            onclick="hapusKegiatan(this)"
                                            class="bg-red-600 hover:bg-red-500 text-white px-3 py-2 rounded-lg text-sm transition">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                            @else
                            <span class="text-gray-400">Selesai</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center py-10 text-gray-400">
                            Belum ada kegiatan
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
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
    const tgl = document.getElementById(`${prefix}_tanggal`).value;
    const kat = document.getElementById(`${prefix}_kategori`).value;
    const per = document.getElementById(`${prefix}_peran`).value;
    const jml = document.getElementById(`${prefix}_jumlah`).value;

    if (!master || !tgl || !kat) {
        Swal.showValidationMessage('Kegiatan, Tanggal, dan Kategori wajib diisi!');
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
            <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal *</label>
            <input type="date" id="${prefix}_tanggal" name="tanggal" class="w-full border border-gray-300 rounded-lg px-4 py-3 outline-none" required>
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
            document.getElementById('edit_tanggal').value = button.getAttribute('data-tanggal');
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