<x-app-layout>

    @if(session('success'))
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: '{{ session('success') }}',
            timer: 3000,
            showConfirmButton: false,
            toast: true,
            position: 'top-end'
        });
    </script>
    @endif

    @if($errors->any())
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Validasi Gagal!',
            html: `<ul class="text-left list-disc pl-4">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>`,
            confirmButtonColor: '#dc2626'
        });
    </script>
    @endif

    <div class="py-6">
        <div class="max-w-8xl mx-auto py-6">

            {{-- Header Section --}}
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">
                        Master Prestasi
                    </h1>
                    <p class="text-gray-500 mt-1">
                        Kelola tingkatan juara beserta bobot poinnya
                    </p>
                </div>
            </div>

            {{-- Filter & Search Section --}}
            <div class="bg-white shadow rounded-xl p-4 mb-4 flex flex-col md:flex-row items-center justify-between gap-4">
                
                <form method="GET" action="{{ route('admin.master-prestasi.index') }}" 
                      id="filterForm"
                      class="flex flex-col md:flex-row items-center gap-3 w-full md:w-auto">
    
                    {{-- Search Input --}}
                    <div class="relative w-full md:w-auto flex-shrink-0">
                        <input type="text"
                               name="search"
                               value="{{ request('search') }}"
                               placeholder="Cari prestasi..."
                               class="w-full md:w-64 border border-gray-300 rounded-xl pl-10 pr-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="w-4 h-4 absolute left-3 top-3 text-gray-400"
                             fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M21 21l-4.35-4.35M11 18a7 7 0 100-14 7 7 0 000 14z"/>
                        </svg>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="flex gap-2 w-full md:w-auto flex-shrink-0">
                        <button type="submit" 
                                class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-xl text-sm font-semibold transition duration-150 w-full md:w-auto whitespace-nowrap flex items-center justify-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            Cari
                        </button>
                        
                        @if(request('search'))
                            <a href="{{ route('admin.master-prestasi.index') }}" 
                               onclick="return confirm('Reset semua filter?')"
                               class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-2 rounded-xl text-sm font-semibold transition duration-150 flex items-center justify-center w-full md:w-auto whitespace-nowrap gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                </svg>
                                Reset
                            </a>
                        @endif
                    </div>
                </form>

                {{-- Add Button --}}
                <button onclick="bukaModalTambah()"
                   class="bg-blue-600 hover:bg-blue-500 text-white px-5 py-2 rounded-xl text-sm font-semibold transition duration-150 cursor-pointer w-full md:w-auto whitespace-nowrap flex items-center justify-center gap-2 shadow-sm hover:shadow-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah Prestasi
                </button>
            </div>

            {{-- Table Section --}}
            <div class="bg-white shadow-xl rounded-2xl overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-600">
                        <thead class="bg-gray-50 uppercase text-xs tracking-wider border-b-2 border-gray-200">
                            <tr>
                                <th class="px-6 py-4 text-center">No</th>
                                <th class="px-6 py-4">Nama Prestasi / Juara</th>
                                <th class="px-4 py-4 text-center">Tingkat</th>
                                <th class="px-4 py-4 text-center">Bobot Poin</th>
                                <th class="px-8 py-4 text-center">Status</th>
                                <th class="px-6 py-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($prestasis as $item)
                            <tr class="border-b hover:bg-blue-50 transition duration-150">
                                {{-- Nomor --}}
                                <td class="px-6 py-4 text-center">
                                    {{ ($prestasis->currentPage() - 1) * $prestasis->perPage() + $loop->iteration }}
                                </td>
                                
                                {{-- Nama Prestasi --}}
                                <td class="px-6 py-4 font-medium text-gray-800">
                                    {{ $item->juara }}
                                </td>

                                {{-- Nama Tingkat --}}
                                <td class="px-6 py-4 font-medium text-gray-800">
                                    {{ $item->tingkat }}
                                </td>
                                
                                {{-- Poin --}}
                                <td class="px-4 py-4 text-center">
                                    {{ $item->poin }}
                                </td>
                                
                                {{-- Status --}}
                                <td class="px-6 py-4 text-center">
                                    @if($item->is_active)
                                        <span class="inline-flex items-center gap-1 min-w-[90px] justify-center bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">
                                            <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                                            Aktif
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 min-w-[90px] justify-center bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-semibold">
                                            <span class="w-2 h-2 bg-red-500 rounded-full"></span>
                                            Tidak Aktif
                                        </span>
                                    @endif
                                </td>
                                
                                {{-- Aksi --}}
                                <td class="px-6 py-4 text-center">
                                    <div class="flex justify-center gap-2">
                                        
                                        {{-- 🔧 PERBAIKAN: Pastikan data-is_active bernilai 1 atau 0 --}}
                                        <button type="button"
                                                onclick="bukaModalEdit(this)"
                                                data-id="{{ $item->id }}"
                                                data-juara="{{ e($item->juara) }}"
                                                data-poin="{{ $item->poin }}"
                                                data-tingkat="{{ $item->tingkat }}"
                                                data-is_active="{{ $item->is_active ? '1' : '0' }}"
                                                title="Edit Prestasi"
                                                class="flex items-center justify-center w-9 h-9 bg-yellow-500 hover:bg-yellow-400 text-white rounded-lg transition shadow-sm">
                                            <i class="fas fa-pen"></i>
                                        </button>

                                        {{-- Delete Button --}}
                                        <form action="{{ route('admin.master-prestasi.destroy', $item->id) }}" 
                                              method="POST" 
                                              class="delete-form m-0">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button"
                                                    onclick="hapusPrestasi(this, '{{ e($item->juara) }}')"
                                                    title="Hapus Prestasi"
                                                    class="flex items-center justify-center w-9 h-9 bg-red-600 hover:bg-red-500 text-white rounded-lg transition shadow-sm">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>

                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-10 text-gray-400">
                                    Belum ada data prestasi
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Pagination --}}
            <div class="mt-6">
                @if($prestasis->hasPages())
                    <div class="text-sm text-gray-600 mb-2">
                        Menampilkan 
                        <span class="font-medium">{{ $prestasis->firstItem() }}</span> 
                        sampai 
                        <span class="font-medium">{{ $prestasis->lastItem() }}</span> 
                        dari 
                        <span class="font-medium">{{ $prestasis->total() }}</span> 
                        data
                    </div>
                @endif
                {{ $prestasis->withQueryString()->links() }}
            </div>

        </div>
    </div>

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    {{-- SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // ============================================
    // FUNGSI HAPUS PRESTASI
    // ============================================
    function hapusPrestasi(button, namaJuara) {
        Swal.fire({
            title: 'Hapus Prestasi?',
            html: `Anda akan menghapus prestasi <strong>"${namaJuara}"</strong>.<br>Data yang dihapus tidak dapat dikembalikan.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal',
            reverseButtons: true,
            allowOutsideClick: false,
            allowEscapeKey: false,
            customClass: {
                popup: 'rounded-2xl',
                confirmButton: 'rounded-xl font-semibold',
                cancelButton: 'rounded-xl font-semibold'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Menghapus...',
                    text: 'Mohon tunggu sebentar',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                button.closest('form').submit();
            }
        });
    }

    // ============================================
    // FUNGSI VALIDASI FORM
    // ============================================
    function validasiFormMaster(prefix) {
        const juara = document.getElementById(`${prefix}_juara`).value.trim();
        const poin = document.getElementById(`${prefix}_poin`).value.trim();
        const tingkat = document.getElementById(`${prefix}_tingkat`).value; // 🔧 TAMBAH

        if (!juara || !poin || !tingkat) { // 🔧 TAMBAH tingkat
            Swal.showValidationMessage('Harap lengkapi semua field wajib (bertanda *)');
            return false;
        }

        if (isNaN(poin) || poin === '') {
            Swal.showValidationMessage('Poin harus berupa angka');
            return false;
        }

        if (parseInt(poin) < 0) {
            Swal.showValidationMessage('Poin tidak boleh negatif');
            return false;
        }

        return true;
    }

    // ============================================
    // FUNGSI GENERATE HTML FORM
    // ============================================
    function generateFormMasterHTML(prefix) {
        return `
            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Prestasi / Juara *</label>
                <input type="text" name="juara" id="${prefix}_juara" class="w-full border border-gray-300 rounded-lg px-4 py-3 outline-none focus:ring focus:ring-blue-200" placeholder="Contoh: Juara 1 Nasional" required>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Bobot Poin *</label>
                <input type="number" name="poin" id="${prefix}_poin" min="0" class="w-full border border-gray-300 rounded-lg px-4 py-3 outline-none focus:ring focus:ring-blue-200" placeholder="Contoh: 10" required>
            </div>

            {{-- 🔧 TINGKAT --}}
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
                <label class="block text-sm font-semibold text-gray-700 mb-2">Status Aktif</label>
                <select name="is_active" id="${prefix}_is_active" class="w-full border border-gray-300 rounded-lg px-4 py-3 outline-none focus:ring focus:ring-blue-200">
                    <option value="1">Aktif</option>
                    <option value="0">Tidak Aktif</option>
                </select>
            </div>
        `;
    }

    // ============================================
    // FUNGSI TAMBAH PRESTASI
    // ============================================
    function bukaModalTambah() {
        Swal.fire({
            title: '<h2 class="text-2xl font-bold text-gray-800 text-left">Tambah Prestasi Baru</h2>',
            width: '600px',
            html: `
                <form id="formTambahMaster" action="{{ route('admin.master-prestasi.store') }}" method="POST" class="text-left mt-4 max-h-[65vh] overflow-y-auto px-2">
                    @csrf
                    ${generateFormMasterHTML('add')}
                </form>
            `,
            showCancelButton: true,
            confirmButtonText: 'Simpan',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#2563EB',
            cancelButtonColor: '#9CA3AF',
            allowOutsideClick: false,
            allowEscapeKey: false,
            customClass: { popup: 'rounded-2xl p-4' },
            didOpen: () => {
                setTimeout(() => {
                    const input = document.getElementById('add_juara');
                    if (input) input.focus();
                }, 100);
            },
            preConfirm: () => {
                if (validasiFormMaster('add')) {
                    Swal.showLoading();
                    document.getElementById('formTambahMaster').submit();
                    return false;
                }
                return false;
            }
        });
    }

    // ============================================
    // FUNGSI EDIT PRESTASI
    // ============================================
    function bukaModalEdit(button) {
        const id = button.getAttribute('data-id');
        const juara = button.getAttribute('data-juara');
        const poin = button.getAttribute('data-poin');
        const tingkat = button.getAttribute('data-tingkat'); // 🔧 TAMBAH
        const isActive = button.getAttribute('data-is_active');

        let actionUrl = "{{ route('admin.master-prestasi.update', ':id') }}".replace(':id', id);

        Swal.fire({
            title: '<h2 class="text-2xl font-bold text-gray-800 text-left">Edit Prestasi</h2>',
            width: '600px',
            html: `
                <form id="formEditMaster" action="${actionUrl}" method="POST" class="text-left mt-4 max-h-[65vh] overflow-y-auto px-2">
                    @csrf
                    @method('PUT')
                    ${generateFormMasterHTML('edit')}
                </form>
            `,
            showCancelButton: true,
            confirmButtonText: 'Perbarui',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#2563EB',
            cancelButtonColor: '#9CA3AF',
            allowOutsideClick: false,
            allowEscapeKey: false,
           didOpen: () => {
    // Isi nilai form
    document.getElementById('edit_juara').value = juara;
    document.getElementById('edit_poin').value = poin;
    // 🔧 HAPUS BARIS INI: document.getElementById('edit_poin').value = tingkat;
    
    // Set nilai tingkat
    const selectTingkat = document.getElementById('edit_tingkat');
    if (selectTingkat) {
        selectTingkat.value = tingkat;
    }
    
    // Set nilai select is_active
    const selectIsActive = document.getElementById('edit_is_active');
    if (selectIsActive) {
        selectIsActive.value = isActive;
    }
    
    setTimeout(() => {
        const input = document.getElementById('edit_juara');
        if (input) input.focus();
    }, 100);
},
            preConfirm: () => {
                if (validasiFormMaster('edit')) {
                    Swal.showLoading();
                    document.getElementById('formEditMaster').submit();
                    return false;
                }
                return false;
            }
        });
    }
</script>

</x-app-layout>