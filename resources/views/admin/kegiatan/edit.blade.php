<x-app-layout>

    @if(session('success'))
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: '{{ session('success') }}',
            timer: 2000,
            showConfirmButton: false
        });
    </script>
    @endif

    <div class="py-6">
        <div class="max-w-8xl mx-auto py-6 px-4 sm:px-6 lg:px-8">

            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">
                        Master Kegiatan
                    </h1>
                    <p class="text-gray-500 mt-1">
                        Daftar kegiatan yang dapat dipilih mahasiswa
                    </p>
                </div>
            </div>

            <div class="bg-white shadow rounded-xl p-4 mb-4 flex items-center justify-between">
                <form method="GET" action="{{ route('admin.kegiatan.index') }}" class="relative">
                    <input type="text"
                           name="search"
                           value="{{ request('search') }}"
                           placeholder="Cari data..."
                           class="w-72 border border-gray-300 rounded-xl pl-10 pr-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="w-4 h-4 absolute left-3 top-3 text-gray-400"
                         fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M11 18a7 7 0 100-14 7 7 0 000 14z"/>
                    </svg>
                </form>

                <button onclick="bukaModalTambahMaster()"
                   class="bg-blue-600 hover:bg-blue-500 text-white px-5 py-2 rounded-xl text-sm font-semibold transition cursor-pointer">
                    + Tambah Kegiatan
                </button>
            </div>

            <div class="bg-white shadow-xl rounded-2xl overflow-hidden">
                <table class="w-full text-sm text-left text-gray-600">
                    <thead class="bg-gray-50 uppercase text-xs tracking-wider">
                        <tr>
                            <th class="px-6 py-4 text-center">No</th>
                            <th class="px-6 py-4">Nama Kegiatan</th>
                            <th class="px-6 py-4">Jenis</th>
                            <th class="px-6 py-4">Tingkat</th>
                            <th class="px-6 py-4">Hasil</th>
                            <th class="px-4 py-4 text-center">Poin</th>
                            <th class="px-8 py-4 text-center">Status</th>
                            <th class="px-6 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kegiatans as $kegiatan)
                        <tr class="border-b hover:bg-blue-50 transition">
                            <td class="px-6 py-4 text-center">
                                {{ $loop->iteration }}
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-800">
                                {{ $kegiatan->nama_kegiatan }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $kegiatan->jenis }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $kegiatan->tingkat }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $kegiatan->hasil }}
                            </td>
                            <td class="px-4 py-4 text-center">
                                {{ $kegiatan->poin }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($kegiatan->status == 'aktif')
                                    <span class="inline-block min-w-[90px] text-center bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">
                                        Aktif
                                    </span>
                                @else
                                    <span class="inline-block min-w-[90px] text-center bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-semibold">
                                        Tidak Aktif
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex justify-center gap-2">
                                    
                                    <button type="button"
                                            onclick="bukaModalEditMaster(this)"
                                            data-id="{{ $kegiatan->id }}"
                                            data-nama="{{ $kegiatan->nama_kegiatan }}"
                                            data-jenis="{{ $kegiatan->jenis }}"
                                            data-tingkat="{{ $kegiatan->tingkat }}"
                                            data-hasil="{{ $kegiatan->hasil }}"
                                            data-poin="{{ $kegiatan->poin }}"
                                            data-status="{{ $kegiatan->status }}"
                                            class="bg-yellow-500 hover:bg-yellow-400 text-white px-4 py-2 rounded-lg text-sm transition">
                                        Edit
                                    </button>

                                    <form action="{{ route('admin.kegiatan.destroy', $kegiatan->id) }}" method="POST" class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button"
                                                onclick="hapusKegiatan(this)"
                                                class="bg-red-600 hover:bg-red-500 text-white px-4 py-2 rounded-lg text-sm transition">
                                            Hapus
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-10 text-gray-400">
                                Belum ada data kegiatan
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
// --- Script Hapus Master Kegiatan ---
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
        if(result.isConfirmed) {
            button.closest('form').submit();
        }
    });
}

// --- FUNGSI HELPER UNTUK VALIDASI FORM ---
function validasiFormMaster(prefix) {
    const nama = document.getElementById(`${prefix}_nama`).value;
    const jenis = document.getElementById(`${prefix}_jenis`).value;
    const tingkat = document.getElementById(`${prefix}_tingkat`).value;
    const hasil = document.getElementById(`${prefix}_hasil`).value;
    const poin = document.getElementById(`${prefix}_poin`).value;
    const status = document.getElementById(`${prefix}_status`).value;

    if (!nama || !jenis || !tingkat || !hasil || !poin || !status) {
        Swal.showValidationMessage('Harap lengkapi semua field wajib (bertanda *)');
        return false;
    }
    return true;
}

// --- FUNGSI GENERATE HTML MODAL ---
function generateFormMasterHTML(prefix) {
    return `
        <div class="mb-4">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Kegiatan *</label>
            <input type="text" name="nama_kegiatan" id="${prefix}_nama" class="w-full border border-gray-300 rounded-lg px-4 py-3 outline-none focus:ring focus:ring-blue-200" required>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Jenis *</label>
            <input type="text" name="jenis" id="${prefix}_jenis" class="w-full border border-gray-300 rounded-lg px-4 py-3 outline-none focus:ring focus:ring-blue-200" required>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Tingkat *</label>
            <select name="tingkat" id="${prefix}_tingkat" class="w-full border border-gray-300 rounded-lg px-4 py-3 outline-none focus:ring focus:ring-blue-200" required>
                <option value="">Pilih Tingkat</option>
                <option value="Universitas">Universitas</option>
                <option value="Regional">Regional</option>
                <option value="Nasional">Nasional</option>
                <option value="Internasional">Internasional</option>
            </select>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Hasil *</label>
            <input type="text" name="hasil" id="${prefix}_hasil" class="w-full border border-gray-300 rounded-lg px-4 py-3 outline-none focus:ring focus:ring-blue-200" placeholder="Contoh: Juara/Sertifikat/Peserta" required>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Poin *</label>
            <input type="number" name="poin" id="${prefix}_poin" min="0" class="w-full border border-gray-300 rounded-lg px-4 py-3 outline-none focus:ring focus:ring-blue-200" required>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Status Kegiatan *</label>
            <select name="status" id="${prefix}_status" class="w-full border border-gray-300 rounded-lg px-4 py-3 outline-none focus:ring focus:ring-blue-200" required>
                <option value="aktif">Aktif</option>
                <option value="tidak aktif">Tidak Aktif</option>
            </select>
        </div>
    `;
}

// --- Script Tambah Master Kegiatan ---
function bukaModalTambahMaster() {
    Swal.fire({
        title: '<h2 class="text-2xl font-bold text-gray-800 text-left">Tambah Master Kegiatan</h2>',
        width: '600px',
        html: `
            <form id="formTambahMaster" action="{{ route('admin.kegiatan.store') }}" method="POST" class="text-left mt-4 max-h-[65vh] overflow-y-auto px-2">
                @csrf
                ${generateFormMasterHTML('add')}
            </form>
        `,
        showCancelButton: true,
        confirmButtonText: 'Simpan',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#2563EB',
        cancelButtonColor: '#9CA3AF',
        customClass: { popup: 'rounded-2xl p-4' },
        preConfirm: () => {
            if (validasiFormMaster('add')) {
                document.getElementById('formTambahMaster').submit();
            }
        }
    });
}

// --- Script Edit Master Kegiatan ---
function bukaModalEditMaster(button) {
    // 1. Ambil data dari atribut tombol
    const id = button.getAttribute('data-id');
    const nama = button.getAttribute('data-nama');
    const jenis = button.getAttribute('data-jenis');
    const tingkat = button.getAttribute('data-tingkat');
    const hasil = button.getAttribute('data-hasil');
    const poin = button.getAttribute('data-poin');
    const status = button.getAttribute('data-status');

    // 2. Buat URL dinamis untuk form action PUT
    let actionUrl = "{{ route('admin.kegiatan.update', ':id') }}".replace(':id', id);

    // 3. Panggil SweetAlert
    Swal.fire({
        title: '<h2 class="text-2xl font-bold text-gray-800 text-left">Edit Master Kegiatan</h2>',
        width: '600px',
        html: `
            <form id="formEditMaster" action="${actionUrl}" method="POST" class="text-left mt-4 max-h-[65vh] overflow-y-auto px-2">
                @csrf
                @method('PUT')
                ${generateFormMasterHTML('edit')}
            </form>
        `,
        showCancelButton: true,
        confirmButtonText: 'Update',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#D97706', // Warna Kuning/Orange (Sesuai tombol edit)
        cancelButtonColor: '#9CA3AF',
        customClass: { popup: 'rounded-2xl p-4' },
        didOpen: () => {
            // Auto-fill value ke dalam inputan saat modal terbuka
            document.getElementById('edit_nama').value = nama;
            document.getElementById('edit_jenis').value = jenis;
            document.getElementById('edit_tingkat').value = tingkat;
            document.getElementById('edit_hasil').value = hasil;
            document.getElementById('edit_poin').value = poin;
            document.getElementById('edit_status').value = status;
        },
        preConfirm: () => {
            if (validasiFormMaster('edit')) {
                document.getElementById('formEditMaster').submit();
            }
        }
    });
}
</script>

</x-app-layout>