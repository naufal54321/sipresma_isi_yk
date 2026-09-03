<x-app-layout>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

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

            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">Ruang Lingkup Kegiatan</h1>
                    <p class="text-gray-500 mt-1">Kelola data ruang lingkup kegiatan mahasiswa</p>
                </div>
            </div>

            <div class="bg-white shadow rounded-xl p-4 mb-4 flex flex-col md:flex-row items-center justify-between gap-4">
                <form method="GET" action="{{ route('admin.activity-scopes.index') }}"
                      class="flex flex-col md:flex-row items-center gap-3 w-full md:w-auto">

                    <div class="relative w-full md:w-auto flex-shrink-0">
                        <input type="text"
                               name="search"
                               value="{{ request('search') }}"
                               placeholder="Cari ruang lingkup..."
                               class="w-full md:w-64 border border-gray-300 rounded-xl pl-10 pr-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="w-4 h-4 absolute left-3 top-3 text-gray-400"
                             fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M21 21l-4.35-4.35M11 18a7 7 0 100-14 7 7 0 000 14z"/>
                        </svg>
                    </div>

                    <div class="flex gap-2 w-full md:w-auto flex-shrink-0">
                        <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-xl text-sm font-semibold transition duration-150 w-full md:w-auto whitespace-nowrap flex items-center justify-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            Cari
                        </button>
                        @if(request('search'))
                            <a href="{{ route('admin.activity-scopes.index') }}"
                               class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-2 rounded-xl text-sm font-semibold transition duration-150 flex items-center justify-center w-full md:w-auto whitespace-nowrap gap-2">
                                Reset
                            </a>
                        @endif
                    </div>
                </form>

                <button onclick="bukaModalTambah()"
                   class="bg-blue-600 hover:bg-blue-500 text-white px-5 py-2 rounded-xl text-sm font-semibold transition duration-150 cursor-pointer w-full md:w-auto whitespace-nowrap flex items-center justify-center gap-2 shadow-sm hover:shadow-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah Ruang Lingkup
                </button>
            </div>

            <div class="bg-white shadow-xl rounded-2xl overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-600">
                        <thead class="bg-gray-50 uppercase text-xs tracking-wider border-b-2 border-gray-200">
                            <tr>
                                <th class="px-4 py-4 text-center w-12">No</th>
                                <th class="px-4 py-4">Kode</th>
                                <th class="px-4 py-4">Nama</th>
                                <th class="px-4 py-4 text-center">Jumlah Rules</th>
                                <th class="px-4 py-4 text-center">Status</th>
                                <th class="px-4 py-4 text-center w-28">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody" class="divide-y divide-gray-200">
                            @forelse($scopes as $index => $scope)
                            <tr id="row-{{ $scope->id }}" class="border-b hover:bg-blue-50 transition duration-150">
                                <td class="px-4 py-4 text-center">
                                    {{ ($scopes->currentPage() - 1) * $scopes->perPage() + $loop->iteration }}
                                </td>
                                <td class="px-4 py-4">
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-700">
                                        {{ e($scope->code) }}
                                    </span>
                                </td>
                                <td class="px-4 py-4 font-medium text-gray-800">{{ e($scope->name) }}</td>
                                <td class="px-4 py-4 text-center">
                                    <span class="inline-flex items-center justify-center min-w-[40px] px-2 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-700">
                                        {{ $scope->point_rules_count }}
                                    </span>
                                </td>
                                <td class="px-4 py-4 text-center">
                                    @if($scope->is_active)
                                        <span class="inline-flex items-center gap-1 min-w-[80px] justify-center bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">
                                            <span class="w-2 h-2 bg-green-500 rounded-full"></span> Aktif
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 min-w-[80px] justify-center bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-semibold">
                                            <span class="w-2 h-2 bg-red-500 rounded-full"></span> Nonaktif
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-4 text-center">
                                    <div class="flex justify-center gap-2">
                                        <button type="button"
                                                onclick="bukaModalEdit(this)"
                                                data-id="{{ $scope->id }}"
                                                data-code="{{ e($scope->code) }}"
                                                data-name="{{ e($scope->name) }}"
                                                data-active="{{ $scope->is_active ? '1' : '0' }}"
                                                title="Edit Ruang Lingkup"
                                                class="flex items-center justify-center w-9 h-9 bg-yellow-500 hover:bg-yellow-400 text-white rounded-lg transition shadow-sm">
                                            <i class="fas fa-pen"></i>
                                        </button>
                                        <button type="button"
                                                onclick="hapusData({{ $scope->id }})"
                                                title="Hapus Ruang Lingkup"
                                                class="flex items-center justify-center w-9 h-9 bg-red-600 hover:bg-red-500 text-white rounded-lg transition shadow-sm">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr id="emptyRow">
                                <td colspan="6" class="text-center py-10 text-gray-400">
                                    Belum ada data ruang lingkup
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if($scopes->hasPages())
                <div class="px-6 py-4 bg-slate-50/50 border-t border-slate-100">
                    {{ $scopes->withQueryString()->links() }}
                </div>
            @endif

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
    const csrfToken = '{{ csrf_token() }}';
    const baseUrl = '{{ route("admin.activity-scopes.index") }}';

    function generateFormHTML(data = {}) {
        return `
            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Kode <span class="text-red-500">*</span></label>
                <input type="text" id="form_code" value="${data.code || ''}"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500"
                       placeholder="Contoh: NAS, INS, INT" maxlength="10">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Nama <span class="text-red-500">*</span></label>
                <input type="text" id="form_name" value="${data.name || ''}"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500"
                       placeholder="Contoh: Nasional">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Status <span class="text-red-500">*</span></label>
                <select id="form_is_active" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500">
                    <option value="1" ${data.active === '1' || data.active === undefined ? 'selected' : ''}>Aktif</option>
                    <option value="0" ${data.active === '0' ? 'selected' : ''}>Nonaktif</option>
                </select>
            </div>`;
    }

    function validasiForm() {
        const code = document.getElementById('form_code').value.trim();
        const name = document.getElementById('form_name').value.trim();
        if (!code) { Swal.showValidationMessage('Kode wajib diisi'); return false; }
        if (!name) { Swal.showValidationMessage('Nama wajib diisi'); return false; }
        return true;
    }

    function collectFormData() {
        return {
            code: document.getElementById('form_code').value.trim(),
            name: document.getElementById('form_name').value.trim(),
            is_active: document.getElementById('form_is_active').value === '1' ? 1 : 0,
        };
    }

    function bukaModalTambah() {
        Swal.fire({
            title: '<h2 class="text-xl font-bold text-gray-800 text-left">Tambah Ruang Lingkup</h2>',
            width: '500px',
            html: `<div class="text-left mt-4">${generateFormHTML()}</div>`,
            showCancelButton: true,
            confirmButtonText: 'Simpan',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#2563EB',
            cancelButtonColor: '#9CA3AF',
            allowOutsideClick: false,
            customClass: { popup: 'rounded-2xl p-6' },
            preConfirm: () => {
                if (!validasiForm()) return false;
                Swal.showLoading();
                const data = collectFormData();
                return fetch(baseUrl, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
                    body: JSON.stringify(data)
                }).then(res => res.json()).then(json => {
                    if (json.success) return json;
                    throw new Error(json.message || 'Gagal');
                }).catch(err => { Swal.showValidationMessage(err.message); return false; });
            }
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({ icon: 'success', title: 'Berhasil!', text: 'Ruang lingkup berhasil ditambahkan', timer: 2000, showConfirmButton: false })
                .then(() => location.reload());
            }
        });
    }

    function bukaModalEdit(button) {
        const data = {
            code: button.getAttribute('data-code'),
            name: button.getAttribute('data-name'),
            active: button.getAttribute('data-active'),
        };
        const id = button.getAttribute('data-id');

        Swal.fire({
            title: '<h2 class="text-xl font-bold text-gray-800 text-left">Edit Ruang Lingkup</h2>',
            width: '500px',
            html: `<div class="text-left mt-4">${generateFormHTML(data)}</div>`,
            showCancelButton: true,
            confirmButtonText: 'Simpan',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#2563EB',
            cancelButtonColor: '#9CA3AF',
            allowOutsideClick: false,
            customClass: { popup: 'rounded-2xl p-6' },
            preConfirm: () => {
                if (!validasiForm()) return false;
                Swal.showLoading();
                const updatedData = collectFormData();
                return fetch(`${baseUrl}/${id}`, {
                    method: 'PUT',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
                    body: JSON.stringify(updatedData)
                }).then(res => res.json()).then(json => {
                    if (json.success) return json;
                    throw new Error(json.message || 'Gagal');
                }).catch(err => { Swal.showValidationMessage(err.message); return false; });
            }
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({ icon: 'success', title: 'Berhasil!', text: 'Ruang lingkup berhasil diperbarui', timer: 2000, showConfirmButton: false })
                .then(() => location.reload());
            }
        });
    }

    function hapusData(id) {
        Swal.fire({
            title: 'Hapus Ruang Lingkup?',
            text: 'Data yang dihapus tidak dapat dikembalikan.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({ title: 'Menghapus...', allowOutsideClick: false, showConfirmButton: false, didOpen: () => Swal.showLoading() });
                fetch(`${baseUrl}/${id}`, {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }
                }).then(res => res.json()).then(data => {
                    if (data.success) {
                        const row = document.getElementById(`row-${id}`);
                        if (row) row.remove();
                        Swal.fire({ icon: 'success', title: 'Berhasil!', text: data.message, timer: 2000, showConfirmButton: false });
                    } else { throw new Error(data.message); }
                }).catch(err => Swal.fire({ icon: 'error', title: 'Gagal!', text: err.message }));
            }
        });
    }
    </script>

</x-app-layout>
