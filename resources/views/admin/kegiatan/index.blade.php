<x-app-layout>

    {{-- SweetAlert Success Message --}}
    @if(session('success'))
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            timer: 3000,
            showConfirmButton: false,
            toast: true,
            position: 'top-end'
        });
    </script>
    @endif

    {{-- SweetAlert Error Messages --}}
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

    {{-- ⚡ WRAPPER UNTUK NONAKTIFKAN SPA DI HALAMAN INI --}}
    <div data-no-spa>
    <div class="py-6">
        <div class="max-w-8xl mx-auto py-6">

            {{-- Header Section --}}
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

            {{-- Filter & Search Section --}}
            <div class="bg-white shadow rounded-xl p-4 mb-4 flex flex-col md:flex-row items-center justify-between gap-4">
                
                <form method="GET" action="{{ route('admin.kegiatan.index') }}" 
                      id="filterForm"
                      class="flex flex-col md:flex-row items-center gap-3 w-full md:w-auto">
    
                    {{-- Search Input --}}
                    <div class="relative w-full md:w-auto flex-shrink-0">
                        <input type="text"
                               name="search"
                               value="{{ request('search') }}"
                               placeholder="Cari kegiatan..."
                               class="w-full md:w-64 border border-gray-300 rounded-xl pl-10 pr-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="w-4 h-4 absolute left-3 top-3 text-gray-400"
                             fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M21 21l-4.35-4.35M11 18a7 7 0 100-14 7 7 0 000 14z"/>
                        </svg>
                    </div>

                    {{-- Status Filter --}}
                    <select name="status" 
                            id="statusFilter"
                            class="w-full md:w-48 border border-gray-300 rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 cursor-pointer transition">
                        <option value="">Semua Status</option>
                        <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="tidak aktif" {{ request('status') == 'tidak aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>

                    {{-- Action Buttons --}}
                    <div class="flex gap-2 w-full md:w-auto flex-shrink-0">
                        <button type="submit" 
                                class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-xl text-sm font-semibold transition duration-150 w-full md:w-auto whitespace-nowrap flex items-center justify-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            Cari
                        </button>
                        
                        @if(request('search') || request('status'))
                            <a href="{{ route('admin.kegiatan.index') }}" 
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
                <button onclick="bukaModalTambahMaster()"
                   class="bg-blue-600 hover:bg-blue-500 text-white px-5 py-2 rounded-xl text-sm font-semibold transition duration-150 cursor-pointer w-full md:w-auto whitespace-nowrap flex items-center justify-center gap-2 shadow-sm hover:shadow-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah Kegiatan
                </button>
            </div>

            {{-- Table Section --}}
            <div class="bg-white shadow-xl rounded-2xl overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-600">
                        <thead class="bg-gray-50 uppercase text-xs tracking-wider border-b-2 border-gray-200">
                            <tr>
                                <th class="px-6 py-4 text-center w-16">No</th>
                                <th class="px-6 py-4">Nama Kegiatan</th>
                                <th class="px-8 py-4 text-center">Status</th>
                                <th class="px-6 py-4 text-center w-32">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody" class="divide-y divide-gray-200">
                            @forelse($kegiatans as $index => $kegiatan)
                            <tr id="row-{{ $kegiatan->id }}" class="border-b hover:bg-blue-50 transition duration-150">
                                <td class="px-6 py-4 text-center">
                                    {{ ($kegiatans->currentPage() - 1) * $kegiatans->perPage() + $loop->iteration }}
                                </td>
                                <td class="px-6 py-4 font-medium text-gray-800">
                                    {{ $kegiatan->nama_kegiatan }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if($kegiatan->status == 'aktif')
                                        <span class="inline-flex items-center gap-1 min-w-[100px] justify-center bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">
                                            <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                                            Aktif
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 min-w-[100px] justify-center bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-semibold">
                                            <span class="w-2 h-2 bg-red-500 rounded-full"></span>
                                            Tidak Aktif
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex justify-center gap-2">
                                        <button type="button"
                                                onclick="bukaModalEditMaster(this)"
                                                data-id="{{ $kegiatan->id }}"
                                                data-nama="{{ e($kegiatan->nama_kegiatan) }}"
                                                data-status="{{ $kegiatan->status }}"
                                                title="Edit Kegiatan"
                                                class="flex items-center justify-center w-9 h-9 bg-yellow-500 hover:bg-yellow-400 text-white rounded-lg transition shadow-sm">
                                            <i class="fas fa-pen"></i>
                                        </button>
                                        <button type="button"
                                                onclick="hapusKegiatan({{ $kegiatan->id }}, '{{ e($kegiatan->nama_kegiatan) }}')"
                                                title="Hapus Kegiatan"
                                                class="flex items-center justify-center w-9 h-9 bg-red-600 hover:bg-red-500 text-white rounded-lg transition shadow-sm">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr id="emptyRow">
                                <td colspan="4" class="text-center py-10 text-gray-400">
                                    Belum ada data kegiatan
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Pagination --}}
            <div class="mt-6">
                {{ $kegiatans->withQueryString()->links() }}
            </div>

        </div>
    </div>
    </div>{{-- END data-no-spa --}}

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    {{-- SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
    (function() {
        // ============================================
        // KONFIGURASI
        // ============================================
        const csrfToken = '{{ csrf_token() }}';
        const baseUrl = '{{ route("admin.kegiatan.index") }}';
        
        function getAjaxHeaders() {
            return {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            };
        }

        // ============================================
        // RENDER ROW KEGIATAN
        // ============================================
        function renderKegiatanRow(item) {
            const statusBadge = item.status === 'aktif' 
                ? '<span class="inline-flex items-center gap-1 min-w-[100px] justify-center bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold"><span class="w-2 h-2 bg-green-500 rounded-full"></span>Aktif</span>'
                : '<span class="inline-flex items-center gap-1 min-w-[100px] justify-center bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-semibold"><span class="w-2 h-2 bg-red-500 rounded-full"></span>Tidak Aktif</span>';

            return `
            <tr id="row-${item.id}" class="border-b hover:bg-blue-50 transition duration-150">
                <td class="px-6 py-4 text-center">0</td>
                <td class="px-6 py-4 font-medium text-gray-800">${item.nama_kegiatan}</td>
                <td class="px-6 py-4 text-center">${statusBadge}</td>
                <td class="px-6 py-4 text-center">
                    <div class="flex justify-center gap-2">
                        <button type="button" onclick="bukaModalEditMaster(this)"
                            data-id="${item.id}" data-nama="${item.nama_kegiatan}" data-status="${item.status}"
                            title="Edit Kegiatan"
                            class="flex items-center justify-center w-9 h-9 bg-yellow-500 hover:bg-yellow-400 text-white rounded-lg transition shadow-sm">
                            <i class="fas fa-pen"></i>
                        </button>
                        <button type="button" onclick="hapusKegiatan(${item.id}, '${item.nama_kegiatan}')"
                            title="Hapus Kegiatan"
                            class="flex items-center justify-center w-9 h-9 bg-red-600 hover:bg-red-500 text-white rounded-lg transition shadow-sm">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
            `;
        }

        // ============================================
        // FUNGSI HAPUS KEGIATAN (FULL AJAX)
        // ============================================
        window.hapusKegiatan = function(id, namaKegiatan) {
            Swal.fire({
                title: 'Hapus Kegiatan?',
                html: `Anda akan menghapus kegiatan <strong>"${namaKegiatan}"</strong>.<br>Data yang dihapus tidak dapat dikembalikan.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                customClass: {
                    popup: 'rounded-2xl',
                    confirmButton: 'rounded-xl font-semibold',
                    cancelButton: 'rounded-xl font-semibold'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Menghapus...',
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        didOpen: () => Swal.showLoading()
                    });
                    
                    fetch(`${baseUrl}/${id}`, {
                        method: 'DELETE',
                        headers: getAjaxHeaders()
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            const row = document.getElementById(`row-${id}`);
                            if (row) row.remove();
                            
                            window.resetTableNumber();
                            
                            // ⚡ Cek apakah tabel kosong
                            const remainingRows = document.querySelectorAll('#tableBody tr[id]').length;
                            if (remainingRows === 0) {
                                document.getElementById('tableBody').innerHTML = `
                                    <tr id="emptyRow">
                                        <td colspan="4" class="text-center py-10 text-gray-400">Belum ada data kegiatan</td>
                                    </tr>
                                `;
                            }
                            
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: data.message || 'Kegiatan berhasil dihapus',
                                timer: 2000,
                                showConfirmButton: false
                            });
                        } else {
                            Swal.fire({ icon: 'error', title: 'Gagal!', text: data.message || 'Gagal menghapus kegiatan' });
                        }
                    })
                    .catch(error => {
                        Swal.fire({ icon: 'error', title: 'Error!', text: 'Terjadi kesalahan saat menghapus data' });
                    });
                }
            });
        };

        // ============================================
        // FUNGSI VALIDASI FORM
        // ============================================
        window.validasiFormMaster = function(prefix) {
            const nama = document.getElementById(`${prefix}_nama`)?.value?.trim();
            const status = document.getElementById(`${prefix}_status`)?.value;
            
            if (!nama) { Swal.showValidationMessage('Nama kegiatan wajib diisi'); return false; }
            if (!status) { Swal.showValidationMessage('Status wajib dipilih'); return false; }
            return true;
        };

        // ============================================
        // FUNGSI GENERATE HTML FORM
        // ============================================
        window.generateFormMasterHTML = function(prefix) {
            return `
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Kegiatan *</label>
                    <input type="text" name="nama_kegiatan" id="${prefix}_nama" 
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 outline-none focus:ring focus:ring-blue-200" 
                        placeholder="Masukkan nama kegiatan" required>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Status Kegiatan *</label>
                    <select name="status" id="${prefix}_status" 
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 outline-none focus:ring focus:ring-blue-200" required>
                        <option value="">Pilih Status</option>
                        <option value="aktif">Aktif</option>
                        <option value="tidak aktif">Tidak Aktif</option>
                    </select>
                </div>
            `;
        };

        // ============================================
        // FUNGSI TAMBAH KEGIATAN (FULL AJAX)
        // ============================================
        window.bukaModalTambahMaster = function() {
            Swal.fire({
                title: '<h2 class="text-2xl font-bold text-gray-800 text-left">Tambah Master Kegiatan</h2>',
                width: '600px',
                html: `<div class="text-left mt-4 max-h-[65vh] overflow-y-auto px-2">${window.generateFormMasterHTML('add')}</div>`,
                showCancelButton: true, confirmButtonText: 'Simpan', cancelButtonText: 'Batal',
                confirmButtonColor: '#2563EB', cancelButtonColor: '#9CA3AF',
                allowOutsideClick: false, allowEscapeKey: false,
                customClass: { popup: 'rounded-2xl p-4' },
                didOpen: () => { setTimeout(() => { const input = document.getElementById('add_nama'); if (input) input.focus(); }, 100); },
                preConfirm: () => {
                    if (!window.validasiFormMaster('add')) return false;
                    
                    const formData = { 
                        nama_kegiatan: document.getElementById('add_nama').value.trim(), 
                        status: document.getElementById('add_status').value, 
                        _token: csrfToken 
                    };
                    
                    Swal.showLoading();
                    
                    return fetch(baseUrl, { method: 'POST', headers: getAjaxHeaders(), body: JSON.stringify(formData) })
                    .then(response => response.json())
                    .then(data => {
                        if (!data.success) { 
                            let errorMessage = data.message || 'Gagal menambahkan data'; 
                            if (data.errors) errorMessage = Object.values(data.errors).flat().join('<br>'); 
                            Swal.showValidationMessage(errorMessage); 
                            return false; 
                        }
                        return data;
                    })
                    .catch(error => { Swal.showValidationMessage('Terjadi kesalahan: ' + error.message); return false; });
                }
            }).then((result) => {
                if (result.isConfirmed && result.value) {
                    // ⚡ FULL AJAX: Tambah row langsung
                    const emptyRow = document.getElementById('emptyRow');
                    if (emptyRow) emptyRow.remove();
                    
                    const tbody = document.getElementById('tableBody');
                    tbody.insertAdjacentHTML('afterbegin', renderKegiatanRow(result.value.data || result.value.kegiatan));
                    window.resetTableNumber();
                    
                    Swal.fire({ icon: 'success', title: 'Berhasil!', text: result.value.message || 'Kegiatan berhasil ditambahkan', timer: 2000, showConfirmButton: false });
                }
            });
        };

        // ============================================
        // FUNGSI EDIT KEGIATAN (FULL AJAX)
        // ============================================
        window.bukaModalEditMaster = function(button) {
            const id = button.getAttribute('data-id');
            const nama = button.getAttribute('data-nama');
            const status = button.getAttribute('data-status');

            Swal.fire({
                title: '<h2 class="text-2xl font-bold text-gray-800 text-left">Edit Master Kegiatan</h2>',
                width: '600px',
                html: `<div class="text-left mt-4 max-h-[65vh] overflow-y-auto px-2">${window.generateFormMasterHTML('edit')}</div>`,
                showCancelButton: true, confirmButtonText: 'Perbarui', cancelButtonText: 'Batal',
                confirmButtonColor: '#2563EB', cancelButtonColor: '#9CA3AF',
                allowOutsideClick: false, allowEscapeKey: false,
                customClass: { popup: 'rounded-2xl p-4' },
                didOpen: () => {
                    document.getElementById('edit_nama').value = nama;
                    document.getElementById('edit_status').value = status;
                    setTimeout(() => { const input = document.getElementById('edit_nama'); if (input) input.focus(); }, 100);
                },
                preConfirm: () => {
                    if (!window.validasiFormMaster('edit')) return false;
                    
                    const formData = { 
                        nama_kegiatan: document.getElementById('edit_nama').value.trim(), 
                        status: document.getElementById('edit_status').value, 
                        _token: csrfToken, 
                        _method: 'PUT' 
                    };
                    
                    Swal.showLoading();
                    
                    return fetch(`${baseUrl}/${id}`, { method: 'POST', headers: getAjaxHeaders(), body: JSON.stringify(formData) })
                    .then(response => response.json())
                    .then(data => {
                        if (!data.success) { 
                            let errorMessage = data.message || 'Gagal memperbarui data'; 
                            if (data.errors) errorMessage = Object.values(data.errors).flat().join('<br>'); 
                            Swal.showValidationMessage(errorMessage); 
                            return false; 
                        }
                        return { ...data, formData };
                    })
                    .catch(error => { Swal.showValidationMessage('Terjadi kesalahan: ' + error.message); return false; });
                }
            }).then((result) => {
                if (result.isConfirmed && result.value) {
                    const row = document.getElementById(`row-${id}`);
                    if (row) {
                        const fd = result.value.formData;
                        row.children[1].innerText = fd.nama_kegiatan;
                        
                        const statusBadge = fd.status === 'aktif' 
                            ? '<span class="inline-flex items-center gap-1 min-w-[100px] justify-center bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold"><span class="w-2 h-2 bg-green-500 rounded-full"></span>Aktif</span>'
                            : '<span class="inline-flex items-center gap-1 min-w-[100px] justify-center bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-semibold"><span class="w-2 h-2 bg-red-500 rounded-full"></span>Tidak Aktif</span>';
                        row.children[2].innerHTML = statusBadge;
                        
                        button.setAttribute('data-nama', fd.nama_kegiatan);
                        button.setAttribute('data-status', fd.status);
                    }
                    
                    Swal.fire({ icon: 'success', title: 'Berhasil!', text: result.value.message || 'Kegiatan berhasil diperbarui', timer: 2000, showConfirmButton: false });
                }
            });
        };

        // ============================================
        // RESET NOMOR TABEL
        // ============================================
        window.resetTableNumber = function() {
            const rows = document.querySelectorAll('#tableBody tr[id]');
            let counter = 1;
            rows.forEach((row) => { 
                const firstCell = row.querySelector('td:first-child'); 
                if (firstCell) { firstCell.innerText = counter; counter++; } 
            });
        };

        // ============================================
        // AUTO SUBMIT FILTER SAAT STATUS BERUBAH
        // ============================================
        document.getElementById('statusFilter')?.addEventListener('change', function() {
            document.getElementById('filterForm').submit();
        });

    })();
    </script>

</x-app-layout>