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

    @if(session('error'))
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: '{{ session('error') }}',
            timer: 3000,
            showConfirmButton: false,
            toast: true,
            position: 'top-end'
        });
    </script>
    @endif

    <div class="py-6">
        <div class="max-w-8xl mx-auto py-6">

            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">Jenis Kegiatan</h1>
                    <p class="text-gray-500 mt-1">Kelola data jenis kegiatan untuk Kredit Keaktifan Mahasiswa</p>
                </div>
            </div>

            <div class="bg-white shadow rounded-xl p-4 mb-4 flex flex-col md:flex-row items-center justify-between gap-4">
                <form method="GET" action="{{ route('admin.activity-types.index') }}"
                      class="flex flex-col md:flex-row items-center gap-3 w-full md:w-auto">

                    <div class="relative w-full md:w-auto flex-shrink-0">
                        <input type="text"
                               name="search"
                               value="{{ request('search') }}"
                               placeholder="Cari nama/bidang..."
                               class="w-full md:w-64 border border-gray-300 rounded-xl pl-10 pr-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="w-4 h-4 absolute left-3 top-3 text-gray-400"
                             fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>

                    <select name="competency_field_id"
                            class="w-full md:w-56 border border-gray-300 rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 cursor-pointer transition">
                        <option value="">Semua Bidang</option>
                        @foreach($fields as $field)
                            <option value="{{ $field->id }}" {{ request('competency_field_id') == $field->id ? 'selected' : '' }}>
                                {{ $field->name }}
                            </option>
                        @endforeach
                    </select>

                    <select name="status"
                            class="w-full md:w-48 border border-gray-300 rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 cursor-pointer transition">
                        <option value="">Semua Status</option>
                        <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="nonaktif" {{ request('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                    </select>

                    <div class="flex gap-2 w-full md:w-auto flex-shrink-0">
                        <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-xl text-sm font-semibold transition duration-150 w-full md:w-auto whitespace-nowrap flex items-center justify-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            Cari
                        </button>
                        @if(request('search') || request('competency_field_id') || request('status'))
                            <a href="{{ route('admin.activity-types.index') }}"
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
                    Tambah Jenis Kegiatan
                </button>
            </div>

            <div class="bg-white shadow-xl rounded-2xl overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-600">
                        <thead class="bg-gray-50 uppercase text-xs tracking-wider border-b-2 border-gray-200">
                            <tr>
                                <th class="px-4 py-4 text-center w-12">No</th>
                                <th class="px-4 py-4">Bidang</th>
                                <th class="px-4 py-4">Nama</th>
                                <th class="px-4 py-4">Deskripsi</th>
                                <th class="px-4 py-4">Bukti</th>
                                <th class="px-4 py-4 text-center">Jumlah Rules</th>
                                <th class="px-4 py-4 text-center">Status</th>
                                <th class="px-4 py-4 text-center w-28">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody" class="divide-y divide-gray-200">
                            @forelse($types as $type)
                            <tr id="row-{{ $type->id }}" class="border-b hover:bg-blue-50 transition duration-150">
                                <td class="px-4 py-4 text-center">
                                    {{ ($types->currentPage() - 1) * $types->perPage() + $loop->iteration }}
                                </td>
                                <td class="px-4 py-4">
                                    @php $bidangName = $type->competencyField->name ?? '-'; @endphp
                                    @if(str_contains($bidangName, 'Profesional'))
                                        <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-sm font-semibold text-blue-600">
                                            {{ $bidangName }}
                                        </span>
                                    @elseif(str_contains($bidangName, 'Kepribadian'))
                                        <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-sm font-semibold text-purple-600">
                                            {{ $bidangName }}
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-sm font-semibold text-gray-600">
                                            {{ $bidangName }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-4 font-medium text-gray-800">{{ e($type->name) }}</td>
                                <td class="px-4 py-4">{{ e($type->description ?? '-') }}</td>
                                <td class="px-4 py-4">{{ e($type->evidence_required ?? '-') }}</td>
                                <td class="px-4 py-4 text-center">
                                    <span class="inline-flex items-center justify-center min-w-[40px] px-2 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-700">
                                        {{ $type->point_rules_count }}
                                    </span>
                                </td>
                                <td class="px-4 py-4 text-center">
                                    @if($type->is_active)
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
                                                data-id="{{ $type->id }}"
                                                data-field-id="{{ $type->competency_field_id }}"
                                                data-name="{{ e($type->name) }}"
                                                data-description="{{ e($type->description ?? '') }}"
                                                data-evidence="{{ e($type->evidence_required ?? '') }}"
                                                data-active="{{ $type->is_active ? '1' : '0' }}"
                                                title="Edit Jenis Kegiatan"
                                                class="flex items-center justify-center w-9 h-9 bg-yellow-500 hover:bg-yellow-400 text-white rounded-lg transition shadow-sm">
                                            <i class="fas fa-pen"></i>
                                        </button>
                                        <button type="button"
                                                onclick="hapusType({{ $type->id }})"
                                                title="Hapus Jenis Kegiatan"
                                                class="flex items-center justify-center w-9 h-9 bg-red-600 hover:bg-red-500 text-white rounded-lg transition shadow-sm">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr id="emptyRow">
                                <td colspan="8" class="text-center py-10 text-gray-400">
                                    Belum ada data Jenis Kegiatan
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if($types->hasPages())
                <div class="px-6 py-4 bg-slate-50/50 border-t border-slate-100">
                    {{ $types->withQueryString()->links() }}
                </div>
            @endif

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
    var csrfToken = '{{ csrf_token() }}';
    var baseUrl = '{{ route("admin.activity-types.index") }}';

    var fieldsData = @json($fields);

    function generateFormHTML(data = {}) {
        let optionsHTML = '<option value="">-- Pilih Bidang Kompetensi --</option>';
        fieldsData.forEach(field => {
            const isSelected = (data.field_id == field.id) ? 'selected' : '';
            optionsHTML += `<option value="${field.id}" ${isSelected}>${escapeHtml(field.name)}</option>`;
        });

        const isActiveValue = data.active !== undefined ? data.active : '1';

        return `
            <div class="mb-4 text-left">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Bidang Kompetensi <span class="text-red-500">*</span></label>
                <select id="form_field_id" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500">
                    ${optionsHTML}
                </select>
            </div>
            <div class="mb-4 text-left">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Jenis Kegiatan <span class="text-red-500">*</span></label>
                <input type="text" id="form_name" value="${escapeHtml(data.name || '')}"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500"
                       placeholder="Contoh: Kompetisi sesuai bidang keilmuan">
            </div>
            <div class="mb-4 text-left">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Deskripsi</label>
                <textarea id="form_description" rows="2"
                          class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 resize-none"
                          placeholder="Deskripsi singkat jenis kegiatan...">${escapeHtml(data.description || '')}</textarea>
            </div>
            <div class="mb-4 text-left">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Jenis Bukti yang Diperlukan</label>
                <textarea id="form_evidence" rows="2"
                          class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 resize-none"
                          placeholder="Contoh: Sertifikat, Surat Keterangan...">${escapeHtml(data.evidence || '')}</textarea>
            </div>
            <div class="mb-4 text-left">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Status <span class="text-red-500">*</span></label>
                <select id="form_active" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500">
                    <option value="1" ${isActiveValue == '1' ? 'selected' : ''}>Aktif</option>
                    <option value="0" ${isActiveValue == '0' ? 'selected' : ''}>Nonaktif</option>
                </select>
            </div>`;
    }

    function escapeHtml(value) {
        return String(value == null ? '' : value)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    function validasiForm() {
        const fieldId = document.getElementById('form_field_id').value;
        const name = document.getElementById('form_name').value.trim();

        if (!fieldId) { Swal.showValidationMessage('Bidang kompetensi wajib dipilih'); return false; }
        if (!name) { Swal.showValidationMessage('Nama jenis kegiatan wajib diisi'); return false; }
        return true;
    }

    function collectFormData() {
        return {
            competency_field_id: parseInt(document.getElementById('form_field_id').value),
            name: document.getElementById('form_name').value.trim(),
            description: document.getElementById('form_description').value.trim() || null,
            evidence_required: document.getElementById('form_evidence').value.trim() || null,
            is_active: parseInt(document.getElementById('form_active').value),
        };
    }

    function getFieldName(fieldId) {
        const field = fieldsData.find(f => f.id == fieldId);
        return field ? field.name : '-';
    }

    function getFieldType(fieldId) {
        const field = fieldsData.find(f => f.id == fieldId);
        return field ? field.type : 'Kepribadian';
    }

    function bukaModalTambah() {
        Swal.fire({
            title: '<h2 class="text-xl font-bold text-gray-800 text-left">Tambah Jenis Kegiatan</h2>',
            width: '550px',
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
                    throw new Error(json.message || 'Gagal menyimpan data');
                }).catch(err => { Swal.showValidationMessage(err.message); return false; });
            }
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({ icon: 'success', title: 'Berhasil!', text: 'Jenis Kegiatan berhasil ditambahkan', timer: 2000, showConfirmButton: false })
                .then(() => location.reload());
            }
        });
    }

    function bukaModalEdit(button) {
        const data = {
            id: button.getAttribute('data-id'),
            field_id: button.getAttribute('data-field-id'),
            name: button.getAttribute('data-name'),
            description: button.getAttribute('data-description'),
            evidence: button.getAttribute('data-evidence'),
            active: button.getAttribute('data-active'),
        };

        Swal.fire({
            title: '<h2 class="text-xl font-bold text-gray-800 text-left">Edit Jenis Kegiatan</h2>',
            width: '550px',
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
                return fetch(`${baseUrl}/${data.id}`, {
                    method: 'PUT',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
                    body: JSON.stringify(updatedData)
                }).then(res => res.json()).then(json => {
                    if (json.success) return json;
                    throw new Error(json.message || 'Gagal memperbarui data');
                }).catch(err => { Swal.showValidationMessage(err.message); return false; });
            }
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({ icon: 'success', title: 'Berhasil!', text: 'Jenis Kegiatan berhasil diperbarui', timer: 2000, showConfirmButton: false })
                .then(() => location.reload());
            }
        });
    }

    function hapusType(id) {
        Swal.fire({
            title: 'Hapus Jenis Kegiatan?',
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
