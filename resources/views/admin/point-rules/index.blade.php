<x-app-layout>

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
                    <h1 class="text-3xl font-bold text-gray-800">Rules Poin</h1>
                    <p class="text-gray-500 mt-1">Kelola aturan poin Kredit Keaktifan Mahasiswa</p>
                </div>
            </div>

            {{-- Stats Cards --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                <div class="bg-white shadow rounded-xl p-5 border-l-4 border-blue-500">
                    <p class="text-sm text-gray-500 font-medium">Total Rules</p>
                    <p class="text-2xl font-bold text-gray-800 mt-1">{{ $stats['total'] }}</p>
                </div>
                <div class="bg-white shadow rounded-xl p-5 border-l-4 border-green-500">
                    <p class="text-sm text-gray-500 font-medium">Aktif</p>
                    <p class="text-2xl font-bold text-green-600 mt-1">{{ $stats['active'] }}</p>
                </div>
                <div class="bg-white shadow rounded-xl p-5 border-l-4 border-red-500">
                    <p class="text-sm text-gray-500 font-medium">Nonaktif</p>
                    <p class="text-2xl font-bold text-red-600 mt-1">{{ $stats['inactive'] }}</p>
                </div>
                @php $fieldEntries = $stats['per_field']; @endphp
                @if($fieldEntries->isNotEmpty())
                <div class="bg-white shadow rounded-xl p-5 border-l-4 border-purple-500">
                    <p class="text-sm text-gray-500 font-medium">Per Bidang</p>
                    <div class="mt-2 space-y-1">
                        @foreach($fieldEntries as $fieldName => $fieldTotal)
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-gray-600 truncate">{{ $fieldName ?? '-' }}</span>
                                <span class="font-semibold text-gray-800 ml-2">{{ $fieldTotal }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <div class="bg-white shadow rounded-xl p-4 mb-4 flex flex-col md:flex-row items-center justify-between gap-4">
                <form method="GET" action="{{ route('admin.point-rules.index') }}"
                      class="flex flex-col md:flex-row items-center gap-3 w-full md:w-auto">

                    <div class="relative w-full md:w-auto flex-shrink-0">
                        <input type="text"
                               name="search"
                               value="{{ request('search') }}"
                               placeholder="Cari jenis kegiatan..."
                               class="w-full md:w-64 border border-gray-300 rounded-xl pl-10 pr-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="w-4 h-4 absolute left-3 top-3 text-gray-400"
                             fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M21 21l-4.35-4.35M11 18a7 7 0 100-14 7 7 0 000 14z"/>
                        </svg>
                    </div>

                    <select name="competency_field_id"
                            class="w-full md:w-56 border border-gray-300 rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 cursor-pointer transition">
                        <option value="">Semua Bidang</option>
                        @foreach($fields as $field)
                            <option value="{{ $field->id }}" {{ request('competency_field_id') == $field->id ? 'selected' : '' }}>{{ $field->name }}</option>
                        @endforeach
                    </select>

                    <select name="activity_type_id"
                            class="w-full md:w-56 border border-gray-300 rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 cursor-pointer transition">
                        <option value="">Semua Jenis</option>
                        @foreach($types as $type)
                            <option value="{{ $type->id }}" {{ request('activity_type_id') == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                        @endforeach
                    </select>

                    <select name="scope_id"
                            class="w-full md:w-48 border border-gray-300 rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 cursor-pointer transition">
                        <option value="">Semua Ruang</option>
                        @foreach($scopes as $scope)
                            <option value="{{ $scope->id }}" {{ request('scope_id') == $scope->id ? 'selected' : '' }}>{{ $scope->name }}</option>
                        @endforeach
                    </select>

                    <select name="role_id"
                            class="w-full md:w-48 border border-gray-300 rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 cursor-pointer transition">
                        <option value="">Semua Peran</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}" {{ request('role_id') == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                        @endforeach
                    </select>

                    <select name="status"
                            class="w-full md:w-48 border border-gray-300 rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 cursor-pointer transition">
                        <option value="">Semua Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                    </select>

                    <div class="flex gap-2 w-full md:w-auto flex-shrink-0">
                        <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-xl text-sm font-semibold transition duration-150 w-full md:w-auto whitespace-nowrap flex items-center justify-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            Cari
                        </button>
                        @if(request('search') || request('competency_field_id') || request('activity_type_id') || request('scope_id') || request('role_id') || request('status'))
                            <a href="{{ route('admin.point-rules.index') }}"
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
                    Tambah Rule
                </button>
            </div>

            <div class="bg-white shadow-xl rounded-2xl overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-600">
                        <thead class="bg-gray-50 uppercase text-xs tracking-wider border-b-2 border-gray-200">
                            <tr>
                                <th class="px-4 py-4 text-center w-12">No</th>
                                <th class="px-4 py-4">Bidang</th>
                                <th class="px-4 py-4">Jenis Kegiatan</th>
                                <th class="px-4 py-4">Ruang Lingkup</th>
                                <th class="px-4 py-4">Peran</th>
                                <th class="px-4 py-4 text-center">Poin</th>
                                <th class="px-4 py-4 text-center">Status</th>
                                <th class="px-4 py-4 text-center w-28">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody" class="divide-y divide-gray-200">
                            @forelse($rules as $rule)
                            <tr id="row-{{ $rule->id }}" class="border-b hover:bg-blue-50 transition duration-150">
                                <td class="px-4 py-4 text-center">
                                    {{ ($rules->currentPage() - 1) * $rules->perPage() + $loop->iteration }}
                                </td>
                                <td class="px-4 py-4">
                                    @php $bidangName = $rule->competencyField->name ?? '-'; @endphp
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
                                <td class="px-4 py-4 font-medium text-gray-800">{{ $rule->activityType->name ?? '-' }}</td>
                                <td class="px-4 py-4">{{ $rule->scope->name ?? '-' }}</td>
                                <td class="px-4 py-4">{{ $rule->role->name ?? '-' }}</td>
                                <td class="px-4 py-4 text-center">
                                    <span class="inline-flex items-center justify-center min-w-[40px] px-2 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700">
                                        {{ $rule->points }}
                                    </span>
                                </td>
                                <td class="px-4 py-4 text-center">
                                    @if($rule->is_active)
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
                                                data-id="{{ $rule->id }}"
                                                data-field-id="{{ $rule->competency_field_id }}"
                                                data-type-id="{{ $rule->activity_type_id }}"
                                                data-scope-id="{{ $rule->scope_id }}"
                                                data-role-id="{{ $rule->role_id }}"
                                                data-achievement-id="{{ $rule->achievement_id ?? '' }}"
                                                data-points="{{ $rule->points }}"
                                                data-max-usage="{{ $rule->max_usage ?? '' }}"
                                                data-active="{{ $rule->is_active ? '1' : '0' }}"
                                                title="Edit Rule"
                                                class="flex items-center justify-center w-9 h-9 bg-yellow-500 hover:bg-yellow-400 text-white rounded-lg transition shadow-sm">
                                            <i class="fas fa-pen"></i>
                                        </button>
                                        <button type="button"
                                                onclick="hapusRule({{ $rule->id }})"
                                                title="Hapus Rule"
                                                class="flex items-center justify-center w-9 h-9 bg-red-600 hover:bg-red-500 text-white rounded-lg transition shadow-sm">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr id="emptyRow">
                                <td colspan="8" class="text-center py-10 text-gray-400">
                                    <div class="flex flex-col items-center">
                                        <i class="fas fa-inbox text-4xl mb-3 text-gray-300"></i>
                                        <p class="font-medium">Belum ada rules poin</p>
                                        <p class="text-sm mt-1">Klik "Tambah Rule" untuk membuat aturan baru</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if($rules->hasPages())
                <div class="px-6 py-4 bg-slate-50/50 border-t border-slate-100">
                    {{ $rules->withQueryString()->links() }}
                </div>
            @endif

        </div>
    </div>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
    const csrfToken = '{{ csrf_token() }}';
    const baseUrl = '{{ route("admin.point-rules.index") }}';
    const apiActivityTypes = '/api/admin/activity-types';
    const apiActivityRoles = '/api/admin/activity-roles';
    const apiPreview = '/api/admin/point-rules/preview';

    const fieldsOptions = @json($fields->map(fn($f) => ['id' => $f->id, 'name' => $f->name]));
    const scopesOptions = @json($scopes->map(fn($s) => ['id' => $s->id, 'name' => $s->name]));
    const rolesOptions = @json($roles->map(fn($r) => ['id' => $r->id, 'name' => $r->name]));

    function escapeHtml(value) {
        return String(value == null ? '' : value)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    function buildSelect(id, label, optionsHtml, required, disabled) {
        const reqStar = required ? '<span class="text-red-500">*</span>' : '';
        const disabledAttr = disabled ? 'disabled' : '';
        const disabledClass = disabled ? 'opacity-50 cursor-not-allowed' : '';
        return `
            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-1">${label} ${reqStar}</label>
                <select id="${id}" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 transition ${disabledClass}" ${disabledAttr}>
                    ${optionsHtml}
                </select>
            </div>`;
    }

    function buildNumberInput(id, label, value, min, max, placeholder, required) {
        const reqStar = required ? '<span class="text-red-500">*</span>' : '';
        return `
            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-1">${label} ${reqStar}</label>
                <input type="number" id="${id}" value="${value || ''}" min="${min}" max="${max}"
                       placeholder="${placeholder}"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 transition">
            </div>`;
    }

    function generateFormHTML(data = {}) {
        let fieldOpts = '<option value="">-- Pilih Bidang --</option>';
        fieldsOptions.forEach(f => {
            const sel = (data.competency_field_id == f.id) ? 'selected' : '';
            fieldOpts += `<option value="${f.id}" ${sel}>${escapeHtml(f.name)}</option>`;
        });

        let scopeOpts = '<option value="">-- Pilih Ruang Lingkup --</option>';
        scopesOptions.forEach(s => {
            const sel = (data.scope_id == s.id) ? 'selected' : '';
            scopeOpts += `<option value="${s.id}" ${sel}>${escapeHtml(s.name)}</option>`;
        });

        let achievementOpts = '<option value="">-- Tidak Ada --</option>';
        achievementOpts += `<option value="">-</option>`;

        const isEdit = !!data.id;
        const prefix = isEdit ? 'edit' : 'add';
        const typeDisabled = !data.competency_field_id;
        const roleDisabled = !data.activity_type_id;

        let typeOpts = '<option value="">-- Pilih Bidang Terlebih Dahulu --</option>';
        let roleOpts = '<option value="">-- Pilih Jenis Terlebih Dahulu --</option>';

        let html = `
            <div class="text-left mt-4 max-h-[65vh] overflow-y-auto overflow-x-hidden px-2">
                ${buildSelect(`${prefix}_competency_field_id`, 'Bidang Kompetensi', fieldOpts, true, false)}
                ${buildSelect(`${prefix}_activity_type_id`, 'Jenis Kegiatan', typeOpts, true, typeDisabled)}
                ${buildSelect(`${prefix}_scope_id`, 'Ruang Lingkup', scopeOpts, false, false)}
                ${buildSelect(`${prefix}_role_id`, 'Peran', roleOpts, false, roleDisabled)}
                ${buildSelect(`${prefix}_achievement_id`, 'Pencapaian (Opsional)', achievementOpts, false, false)}
                <div class="flex gap-4">
                    <div class="w-1/2">${buildNumberInput(`${prefix}_points`, 'Poin', data.points || '', 1, 100, '1 - 100', true)}</div>
                    <div class="w-1/2">${buildNumberInput(`${prefix}_max_usage`, 'Batas Penggunaan', data.max_usage || '', 1, '', 'Kosong = unlimited', false)}</div>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Status <span class="text-red-500">*</span></label>
                    <select id="${prefix}_is_active" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 transition">
                        <option value="1" ${data.is_active === '1' || data.is_active === undefined ? 'selected' : ''}>Aktif</option>
                        <option value="0" ${data.is_active === '0' ? 'selected' : ''}>Nonaktif</option>
                    </select>
                </div>
                <div id="${prefix}_preview" class="mt-2 p-3 bg-blue-50 border border-blue-200 rounded-lg text-sm text-blue-700 hidden">
                </div>
            </div>`;

        return html;
    }

    function fetchActivityTypes(fieldId, prefix, selectedTypeId) {
        const typeSelect = document.getElementById(`${prefix}_activity_type_id`);
        const roleSelect = document.getElementById(`${prefix}_role_id`);
        if (!typeSelect) return;

        typeSelect.innerHTML = '<option value="">Memuat...</option>';
        typeSelect.disabled = true;
        if (roleSelect) {
            roleSelect.innerHTML = '<option value="">-- Pilih Jenis Terlebih Dahulu --</option>';
            roleSelect.disabled = true;
        }

        if (!fieldId) {
            typeSelect.innerHTML = '<option value="">-- Pilih Bidang Terlebih Dahulu --</option>';
            return;
        }

        fetch(`${apiActivityTypes}?competency_field_id=${fieldId}`, {
            headers: { 'Accept': 'application/json' }
        })
        .then(res => res.json())
        .then(types => {
            typeSelect.innerHTML = '<option value="">-- Pilih Jenis Kegiatan --</option>';
            types.forEach(t => {
                const sel = (selectedTypeId && selectedTypeId == t.id) ? 'selected' : '';
                typeSelect.innerHTML += `<option value="${t.id}" ${sel}>${escapeHtml(t.name)}</option>`;
            });
            typeSelect.disabled = false;
            updatePreview(prefix);
        })
        .catch(() => {
            typeSelect.innerHTML = '<option value="">-- Gagal memuat --</option>';
        });
    }

    function fetchActivityRoles(typeId, prefix, selectedRoleId) {
        const roleSelect = document.getElementById(`${prefix}_role_id`);
        if (!roleSelect) return;

        roleSelect.innerHTML = '<option value="">Memuat...</option>';
        roleSelect.disabled = true;

        if (!typeId) {
            roleSelect.innerHTML = '<option value="">-- Pilih Jenis Terlebih Dahulu --</option>';
            return;
        }

        fetch(`${apiActivityRoles}?activity_type_id=${typeId}`, {
            headers: { 'Accept': 'application/json' }
        })
        .then(res => res.json())
        .then(roles => {
            roleSelect.innerHTML = '<option value="">-- Pilih Peran --</option>';
            roles.forEach(r => {
                const sel = (selectedRoleId && selectedRoleId == r.id) ? 'selected' : '';
                roleSelect.innerHTML += `<option value="${r.id}" ${sel}>${escapeHtml(r.name)}</option>`;
            });
            roleSelect.disabled = false;
            updatePreview(prefix);
        })
        .catch(() => {
            roleSelect.innerHTML = '<option value="">-- Gagal memuat --</option>';
        });
    }

    function updatePreview(prefix) {
        const fieldId = document.getElementById(`${prefix}_competency_field_id`)?.value;
        const typeId = document.getElementById(`${prefix}_activity_type_id`)?.value;
        const scopeId = document.getElementById(`${prefix}_scope_id`)?.value;
        const roleId = document.getElementById(`${prefix}_role_id`)?.value;
        const previewEl = document.getElementById(`${prefix}_preview`);

        if (!previewEl) return;

        if (!fieldId && !typeId) {
            previewEl.classList.add('hidden');
            return;
        }

        const params = new URLSearchParams();
        if (fieldId) params.append('competency_field_id', fieldId);
        if (typeId) params.append('activity_type_id', typeId);
        if (scopeId) params.append('scope_id', scopeId);
        if (roleId) params.append('role_id', roleId);

        fetch(`${apiPreview}?${params.toString()}`, {
            headers: { 'Accept': 'application/json' }
        })
        .then(res => res.json())
        .then(data => {
            if (data.found) {
                previewEl.innerHTML = `<i class="fas fa-route mr-1"></i> ${escapeHtml(data.full_path)} = <strong>${data.points} poin</strong>`;
                previewEl.classList.remove('hidden');
            } else {
                previewEl.innerHTML = `<i class="fas fa-info-circle mr-1"></i> Tidak ada rule aktif untuk kombinasi ini`;
                previewEl.classList.remove('hidden');
            }
        })
        .catch(() => {
            previewEl.classList.add('hidden');
        });
    }

    function bindCascadeEvents(prefix) {
        const fieldSelect = document.getElementById(`${prefix}_competency_field_id`);
        const typeSelect = document.getElementById(`${prefix}_activity_type_id`);
        const scopeSelect = document.getElementById(`${prefix}_scope_id`);
        const roleSelect = document.getElementById(`${prefix}_role_id`);

        if (fieldSelect) {
            fieldSelect.addEventListener('change', function() {
                fetchActivityTypes(this.value, prefix, '');
                updatePreview(prefix);
            });
        }
        if (typeSelect) {
            typeSelect.addEventListener('change', function() {
                fetchActivityRoles(this.value, prefix, '');
                updatePreview(prefix);
            });
        }
        if (scopeSelect) {
            scopeSelect.addEventListener('change', function() {
                updatePreview(prefix);
            });
        }
        if (roleSelect) {
            roleSelect.addEventListener('change', function() {
                updatePreview(prefix);
            });
        }
    }

    function validateForm(prefix) {
        const fieldId = document.getElementById(`${prefix}_competency_field_id`)?.value;
        const typeId = document.getElementById(`${prefix}_activity_type_id`)?.value;
        const points = document.getElementById(`${prefix}_points`)?.value;

        if (!fieldId) { Swal.showValidationMessage('Bidang wajib dipilih'); return false; }
        if (!typeId) { Swal.showValidationMessage('Jenis kegiatan wajib dipilih'); return false; }
        if (!points || points < 1) { Swal.showValidationMessage('Poin wajib diisi (minimal 1)'); return false; }
        return true;
    }

    function collectFormData(prefix) {
        return {
            competency_field_id: document.getElementById(`${prefix}_competency_field_id`)?.value,
            activity_type_id: document.getElementById(`${prefix}_activity_type_id`)?.value,
            scope_id: document.getElementById(`${prefix}_scope_id`)?.value || null,
            role_id: document.getElementById(`${prefix}_role_id`)?.value || null,
            achievement_id: document.getElementById(`${prefix}_achievement_id`)?.value || null,
            points: parseInt(document.getElementById(`${prefix}_points`)?.value),
            max_usage: document.getElementById(`${prefix}_max_usage`)?.value || null,
            is_active: document.getElementById(`${prefix}_is_active`)?.value === '1' ? 1 : 0,
        };
    }

    function bukaModalTambah() {
        Swal.fire({
            title: '<h2 class="text-xl font-bold text-gray-800 text-left">Tambah Rule Poin</h2>',
            width: '600px',
            html: `<div class="text-left mt-4">${generateFormHTML()}</div>`,
            showCancelButton: true,
            confirmButtonText: 'Simpan',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#2563EB',
            cancelButtonColor: '#9CA3AF',
            allowOutsideClick: false,
            customClass: { popup: 'rounded-2xl p-6' },
            didOpen: () => {
                bindCascadeEvents('add');
                updatePreview('add');
            },
            preConfirm: () => {
                if (!validateForm('add')) return false;
                Swal.showLoading();
                const data = collectFormData('add');
                return fetch(baseUrl, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
                    body: JSON.stringify(data)
                }).then(res => res.json()).then(json => {
                    if (json.success) return json;
                    throw new Error(json.message || 'Gagal menyimpan rule');
                }).catch(err => { Swal.showValidationMessage(err.message); return false; });
            }
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({ icon: 'success', title: 'Berhasil!', text: 'Rule poin berhasil ditambahkan', timer: 2000, showConfirmButton: false })
                .then(() => location.reload());
            }
        });
    }

    function bukaModalEdit(button) {
        const data = {
            id: button.getAttribute('data-id'),
            competency_field_id: button.getAttribute('data-field-id'),
            activity_type_id: button.getAttribute('data-type-id'),
            scope_id: button.getAttribute('data-scope-id'),
            role_id: button.getAttribute('data-role-id'),
            achievement_id: button.getAttribute('data-achievement-id'),
            points: button.getAttribute('data-points'),
            max_usage: button.getAttribute('data-max-usage'),
            is_active: button.getAttribute('data-active'),
        };
        const id = data.id;

        Swal.fire({
            title: '<h2 class="text-xl font-bold text-gray-800 text-left">Edit Rule Poin</h2>',
            width: '600px',
            html: `<div class="text-left mt-4">${generateFormHTML(data)}</div>`,
            showCancelButton: true,
            confirmButtonText: 'Simpan',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#2563EB',
            cancelButtonColor: '#9CA3AF',
            allowOutsideClick: false,
            customClass: { popup: 'rounded-2xl p-6' },
            didOpen: () => {
                bindCascadeEvents('edit');
                if (data.competency_field_id) {
                    fetchActivityTypes(data.competency_field_id, 'edit', data.activity_type_id);
                }
                if (data.activity_type_id) {
                    fetchActivityRoles(data.activity_type_id, 'edit', data.role_id);
                }
                setTimeout(() => updatePreview('edit'), 500);
            },
            preConfirm: () => {
                if (!validateForm('edit')) return false;
                Swal.showLoading();
                const updatedData = collectFormData('edit');
                return fetch(`${baseUrl}/${id}`, {
                    method: 'PUT',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
                    body: JSON.stringify(updatedData)
                }).then(res => res.json()).then(json => {
                    if (json.success) return json;
                    throw new Error(json.message || 'Gagal memperbarui rule');
                }).catch(err => { Swal.showValidationMessage(err.message); return false; });
            }
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({ icon: 'success', title: 'Berhasil!', text: 'Rule poin berhasil diperbarui', timer: 2000, showConfirmButton: false })
                .then(() => location.reload());
            }
        });
    }

    function hapusRule(id) {
        Swal.fire({
            title: 'Hapus Rule?',
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
                        Swal.fire({ icon: 'success', title: 'Berhasil!', text: data.message, timer: 2000, showConfirmButton: false })
                        .then(() => {
                            if (document.querySelectorAll('#tableBody tr[id]').length === 0) {
                                document.getElementById('tableBody').innerHTML = `
                                    <tr id="emptyRow">
                                        <td colspan="8" class="text-center py-10 text-gray-400">
                                            <div class="flex flex-col items-center">
                                                <i class="fas fa-inbox text-4xl mb-3 text-gray-300"></i>
                                                <p class="font-medium">Belum ada rules poin</p>
                                                <p class="text-sm mt-1">Klik "Tambah Rule" untuk membuat aturan baru</p>
                                            </div>
                                        </td>
                                    </tr>`;
                            }
                        });
                    } else { throw new Error(data.message); }
                }).catch(err => Swal.fire({ icon: 'error', title: 'Gagal!', text: err.message }));
            }
        });
    }
    </script>

</x-app-layout>
