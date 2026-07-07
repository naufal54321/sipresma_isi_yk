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

    {{-- ⚡ WRAPPER DENGAN data-no-spa UNTUK NONAKTIFKAN SPA DI HALAMAN INI --}}
    <div data-no-spa>
    <div class="py-6">
        <div class="max-w-8xl mx-auto py-6">

            {{-- Header Section --}}
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">
                        Master Prestasi
                    </h1>
                    <p class="text-gray-500 mt-1">
                        Kelola tingkatan juara
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
                                <th class="px-8 py-4 text-center">Status</th>
                                <th class="px-6 py-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody" class="divide-y divide-gray-200">
                            @forelse($prestasis as $item)
                            <tr id="row-{{ $item->id }}" class="border-b hover:bg-blue-50 transition duration-150">
                                <td class="px-6 py-4 text-center">
                                    {{ ($prestasis->currentPage() - 1) * $prestasis->perPage() + $loop->iteration }}
                                </td>
                                <td class="px-6 py-4 font-medium text-gray-800">
                                    {{ $item->juara }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    {{ $item->tingkat }}
                                </td>
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
                                <td class="px-6 py-4 text-center">
                                    <div class="flex justify-center gap-2">
                                        <button type="button"
                                                onclick="bukaModalEdit(this)"
                                                data-id="{{ $item->id }}"
                                                data-juara="{{ e($item->juara) }}"
                                                data-tingkat="{{ $item->tingkat }}"
                                                data-is_active="{{ $item->is_active ? '1' : '0' }}"
                                                title="Edit Prestasi"
                                                class="flex items-center justify-center w-9 h-9 bg-yellow-500 hover:bg-yellow-400 text-white rounded-lg transition shadow-sm">
                                            <i class="fas fa-pen"></i>
                                        </button>
                                        <button type="button"
                                                onclick="hapusPrestasi({{ $item->id }}, '{{ e($item->juara) }}')"
                                                title="Hapus Prestasi"
                                                class="flex items-center justify-center w-9 h-9 bg-red-600 hover:bg-red-500 text-white rounded-lg transition shadow-sm">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr id="emptyRow">
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
                {{ $prestasis->withQueryString()->links() }}
            </div>

        </div>
    </div>
    </div>{{-- END data-no-spa --}}

    {{-- Font Awesome --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
{{-- SweetAlert2 --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // ============================================
    // KONFIGURASI
    // ============================================
    const csrfToken = '{{ csrf_token() }}';
    const baseUrl = '{{ route("admin.master-prestasi.index") }}';
    
    function getAjaxHeaders() {
        return {
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        };
    }

    // ============================================
    // RENDER ROW PRESTASI
    // ============================================
    function renderPrestasiRow(item) {
        const statusBadge = item.is_active
            ? '<span class="inline-flex items-center gap-1 min-w-[90px] justify-center bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold"><span class="w-2 h-2 bg-green-500 rounded-full"></span>Aktif</span>'
            : '<span class="inline-flex items-center gap-1 min-w-[90px] justify-center bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-semibold"><span class="w-2 h-2 bg-red-500 rounded-full"></span>Tidak Aktif</span>';

        return `
        <tr id="row-${item.id}" class="border-b hover:bg-blue-50 transition duration-150">
            <td class="px-6 py-4 text-center">0</td>
            <td class="px-6 py-4 font-medium text-gray-800">${item.juara}</td>
            <td class="px-6 py-4 text-center">${item.tingkat}</td>
            <td class="px-6 py-4 text-center">${statusBadge}</td>
            <td class="px-6 py-4 text-center">
                <div class="flex justify-center gap-2">
                    <button type="button" onclick="bukaModalEdit(this)"
                        data-id="${item.id}" data-juara="${item.juara}" data-tingkat="${item.tingkat}" data-is_active="${item.is_active ? '1' : '0'}"
                        title="Edit Prestasi"
                        class="flex items-center justify-center w-9 h-9 bg-yellow-500 hover:bg-yellow-400 text-white rounded-lg transition shadow-sm">
                        <i class="fas fa-pen"></i>
                    </button>
                    <button type="button" onclick="hapusPrestasi(${item.id}, '${item.juara}')"
                        title="Hapus Prestasi"
                        class="flex items-center justify-center w-9 h-9 bg-red-600 hover:bg-red-500 text-white rounded-lg transition shadow-sm">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </td>
        </tr>
        `;
    }

    // ============================================
    // FUNGSI HAPUS PRESTASI (FULL AJAX)
    // ============================================
    function hapusPrestasi(id, namaJuara) {
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
            customClass: { popup: 'rounded-2xl', confirmButton: 'rounded-xl font-semibold', cancelButton: 'rounded-xl font-semibold' }
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Menghapus...',
                    allowOutsideClick: false, allowEscapeKey: false,
                    showConfirmButton: false,
                    didOpen: () => Swal.showLoading()
                });
                
                fetch(`${baseUrl}/${id}`, { method: 'DELETE', headers: getAjaxHeaders() })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const row = document.getElementById(`row-${id}`);
                        if (row) row.remove();
                        
                        resetTableNumber();
                        
                        // Cek apakah tabel kosong
                        const remainingRows = document.querySelectorAll('#tableBody tr[id]').length;
                        if (remainingRows === 0) {
                            document.getElementById('tableBody').innerHTML = `
                                <tr id="emptyRow">
                                    <td colspan="5" class="text-center py-10 text-gray-400">Belum ada data prestasi</td>
                                </tr>
                            `;
                        }
                        
                        Swal.fire({ icon: 'success', title: 'Berhasil!', text: data.message || 'Prestasi berhasil dihapus', timer: 2000, showConfirmButton: false });
                    } else {
                        Swal.fire({ icon: 'error', title: 'Gagal!', text: data.message || 'Gagal menghapus prestasi' });
                    }
                })
                .catch(error => {
                    Swal.fire({ icon: 'error', title: 'Error!', text: 'Terjadi kesalahan saat menghapus data' });
                });
            }
        });
    }

    // ============================================
    // FUNGSI VALIDASI FORM
    // ============================================
    function validasiFormMaster(prefix) {
        const juara = document.getElementById(`${prefix}_juara`).value.trim();
        const tingkat = document.getElementById(`${prefix}_tingkat`).value; 
        if (!juara || !tingkat) { 
            Swal.showValidationMessage('Harap lengkapi semua field wajib (bertanda *)');
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
    // FUNGSI TAMBAH PRESTASI (FULL AJAX - TANPA RELOAD)
    // ============================================
    function bukaModalTambah() {
        Swal.fire({
            title: '<h2 class="text-2xl font-bold text-gray-800 text-left">Tambah Prestasi Baru</h2>',
            width: '600px',
            html: `<div class="text-left mt-4 max-h-[65vh] overflow-y-auto px-2">${generateFormMasterHTML('add')}</div>`,
            showCancelButton: true, confirmButtonText: 'Simpan', cancelButtonText: 'Batal',
            confirmButtonColor: '#2563EB', cancelButtonColor: '#9CA3AF',
            allowOutsideClick: false, allowEscapeKey: false,
            customClass: { popup: 'rounded-2xl p-4' },
            didOpen: () => {
                setTimeout(() => { const input = document.getElementById('add_juara'); if (input) input.focus(); }, 100);
            },
            preConfirm: () => {
                if (!validasiFormMaster('add')) return false;
                
                const formData = {
                    juara: document.getElementById('add_juara').value.trim(),
                    tingkat: document.getElementById('add_tingkat').value,
                    is_active: document.getElementById('add_is_active').value,
                    _token: csrfToken
                };
                
                Swal.showLoading();
                
                return fetch(baseUrl, { method: 'POST', headers: getAjaxHeaders(), body: JSON.stringify(formData) })
                .then(response => response.json())
                .then(data => {
                    if (data.success && data.data) {
                        // ⚡ FULL AJAX: Tambah row langsung
                        const emptyRow = document.getElementById('emptyRow');
                        if (emptyRow) emptyRow.remove();
                        
                        const tableBody = document.getElementById('tableBody');
                        tableBody.insertAdjacentHTML('afterbegin', renderPrestasiRow(data.data));
                        resetTableNumber();
                        
                        Swal.fire({ icon: 'success', title: 'Berhasil!', text: data.message || 'Prestasi berhasil ditambahkan', timer: 1500, showConfirmButton: false });
                        return true;
                    } else {
                        let errorMessage = data.message || 'Gagal menambahkan data';
                        if (data.errors) errorMessage = Object.values(data.errors).flat().join('<br>');
                        Swal.fire({ icon: 'error', title: 'Gagal!', html: errorMessage });
                        return false;
                    }
                })
                .catch(error => {
                    Swal.fire({ icon: 'error', title: 'Error!', text: 'Terjadi kesalahan saat menyimpan data' });
                    return false;
                });
            }
        });
    }

    // ============================================
    // FUNGSI EDIT PRESTASI (FULL AJAX)
    // ============================================
    function bukaModalEdit(button) {
        const id = button.getAttribute('data-id');
        
        Swal.fire({ title: 'Memuat data...', allowOutsideClick: false, allowEscapeKey: false, didOpen: () => Swal.showLoading() });
        
        fetch(`/admin/master-prestasi/${id}`, { headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': csrfToken } })
        .then(res => { if (!res.ok) throw new Error('Gagal mengambil data'); return res.json(); })
        .then(item => {
            Swal.close();
            
            Swal.fire({
                title: '<h2 class="text-2xl font-bold text-gray-800 text-left">Edit Prestasi</h2>',
                width: '600px',
                html: `<div class="text-left mt-4 max-h-[65vh] overflow-y-auto px-2">${generateFormMasterHTML('edit')}</div>`,
                showCancelButton: true, confirmButtonText: 'Perbarui', cancelButtonText: 'Batal',
                confirmButtonColor: '#2563EB', cancelButtonColor: '#9CA3AF',
                allowOutsideClick: false, allowEscapeKey: false,
                customClass: { popup: 'rounded-2xl p-4' },
                didOpen: () => {
                    document.getElementById('edit_juara').value = item.juara || '';
                    document.getElementById('edit_tingkat').value = item.tingkat || '';
                    document.getElementById('edit_is_active').value = item.is_active ? '1' : '0';
                    setTimeout(() => { const input = document.getElementById('edit_juara'); if (input) input.focus(); }, 100);
                },
                preConfirm: () => {
                    if (!validasiFormMaster('edit')) return false;
                    
                    const formData = {
                        juara: document.getElementById('edit_juara').value.trim(),
                        tingkat: document.getElementById('edit_tingkat').value,
                        is_active: document.getElementById('edit_is_active').value,
                        _token: csrfToken,
                        _method: 'PUT'
                    };
                    
                    Swal.showLoading();
                    
                    return fetch(`${baseUrl}/${id}`, { method: 'PUT', headers: getAjaxHeaders(), body: JSON.stringify(formData) })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // ⚡ FULL AJAX: Update row langsung
                            const row = document.getElementById(`row-${id}`);
                            if (row) {
                                row.children[1].innerText = formData.juara;
                                row.children[2].innerText = formData.tingkat;
                                const statusBadge = formData.is_active === '1' 
                                    ? '<span class="inline-flex items-center gap-1 min-w-[90px] justify-center bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold"><span class="w-2 h-2 bg-green-500 rounded-full"></span>Aktif</span>'
                                    : '<span class="inline-flex items-center gap-1 min-w-[90px] justify-center bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-semibold"><span class="w-2 h-2 bg-red-500 rounded-full"></span>Tidak Aktif</span>';
                                row.children[3].innerHTML = statusBadge;
                                
                                const editBtn = row.querySelector('button[title="Edit Prestasi"]');
                                if (editBtn) {
                                    editBtn.setAttribute('data-juara', formData.juara);
                                    editBtn.setAttribute('data-tingkat', formData.tingkat);
                                    editBtn.setAttribute('data-is_active', formData.is_active);
                                }
                            }
                            Swal.fire({ icon: 'success', title: 'Berhasil!', text: data.message || 'Prestasi berhasil diperbarui', timer: 1500, showConfirmButton: false });
                            return true;
                        } else {
                            let errorMessage = data.message || 'Gagal memperbarui data';
                            if (data.errors) errorMessage = Object.values(data.errors).flat().join('<br>');
                            Swal.fire({ icon: 'error', title: 'Gagal!', html: errorMessage });
                            return false;
                        }
                    })
                    .catch(error => { Swal.fire({ icon: 'error', title: 'Error!', text: 'Terjadi kesalahan saat memperbarui data' }); return false; });
                }
            });
        })
        .catch(err => { Swal.close(); Swal.fire({ icon: 'error', title: 'Error!', text: 'Gagal mengambil data: ' + err.message }); });
    }

    // ============================================
    // RESET NOMOR TABEL
    // ============================================
    function resetTableNumber() {
        const rows = document.querySelectorAll('#tableBody tr[id]');
        let counter = 1;
        rows.forEach((row) => {
            const firstCell = row.querySelector('td:first-child');
            if (firstCell) { firstCell.innerText = counter; counter++; }
        });
    }
</script>

</x-app-layout>