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
                    <h1 class="text-3xl font-bold text-gray-800">Poin Kegiatan</h1>
                    <p class="text-gray-500 mt-1">Kelola aturan poin Kredit Keaktifan Mahasiswa (KKM)</p>
                </div>
            </div>

            <div class="bg-white shadow rounded-xl p-4 mb-4 flex flex-col md:flex-row items-center justify-between gap-4">
                <form method="GET" action="{{ route('admin.kkm-rules.index') }}"
                      class="flex flex-col md:flex-row items-center gap-3 w-full md:w-auto">

                    <div class="relative w-full md:w-auto flex-shrink-0">
                        <input type="text"
                               name="search"
                               value="{{ request('search') }}"
                               placeholder="Cari jenis/ruang/peran..."
                               class="w-full md:w-64 border border-gray-300 rounded-xl pl-10 pr-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="w-4 h-4 absolute left-3 top-3 text-gray-400"
                             fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M21 21l-4.35-4.35M11 18a7 7 0 100-14 7 7 0 000 14z"/>
                        </svg>
                    </div>

                    <select name="bidang"
                            class="w-full md:w-56 border border-gray-300 rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 cursor-pointer transition">
                        <option value="">Semua Bidang</option>
                        <option value="Bidang Orientasi Kompetensi Profesional" {{ request('bidang') == 'Bidang Orientasi Kompetensi Profesional' ? 'selected' : '' }}>Bidang Orientasi Kompetensi Profesional</option>
                        <option value="Bidang Kompetensi Kepribadian dan Sosial" {{ request('bidang') == 'Bidang Kompetensi Kepribadian dan Sosial' ? 'selected' : '' }}>Bidang Kompetensi Kepribadian dan Sosial</option>
                    </select>

                    <select name="status"
                            class="w-full md:w-48 border border-gray-300 rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 cursor-pointer transition">
                        <option value="">Semua Status</option>
                        <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="tidak aktif" {{ request('status') == 'tidak aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>

                    <div class="flex gap-2 w-full md:w-auto flex-shrink-0">
                        <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-xl text-sm font-semibold transition duration-150 w-full md:w-auto whitespace-nowrap flex items-center justify-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            Cari
                        </button>
                        @if(request('search') || request('bidang') || request('status'))
                            <a href="{{ route('admin.kkm-rules.index') }}"
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
                    Tambah Aturan
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
                            @forelse($rules as $index => $rule)
                            <tr id="row-{{ $rule->id }}" class="border-b hover:bg-blue-50 transition duration-150">
                                <td class="px-4 py-4 text-center">
                                    {{ ($rules->currentPage() - 1) * $rules->perPage() + $loop->iteration }}
                                </td>
                                <td class="px-4 py-4">
                                    @if($rule->bidang === 'Bidang Orientasi Kompetensi Profesional')
                                        <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-sm font-semibold text-blue-700">
                                            Orientasi Kompetensi Profesional
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-sm font-semibold text-purple-700">
                                            Kompetensi Kepribadian dan Sosial
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-4 font-medium text-gray-800">{{ $rule->jenis_kegiatan }}</td>
                                <td class="px-4 py-4">{{ $rule->ruang_lingkup ?? '-' }}</td>
                                <td class="px-4 py-4">{{ $rule->peran }}</td>
                                <td class="px-4 py-4 text-center">
                                    <span class="inline-flex items-center justify-center min-w-[40px] px-2 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700">
                                        {{ $rule->poin }}
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
                                                data-bidang="{{ e($rule->bidang) }}"
                                                data-jenis="{{ e($rule->jenis_kegiatan) }}"
                                                data-ruang="{{ e($rule->ruang_lingkup ?? '') }}"
                                                data-peran="{{ e($rule->peran) }}"
                                                data-poin="{{ $rule->poin }}"
                                                data-active="{{ $rule->is_active ? '1' : '0' }}"
                                                title="Edit Aturan"
                                                class="flex items-center justify-center w-9 h-9 bg-yellow-500 hover:bg-yellow-400 text-white rounded-lg transition shadow-sm">
                                            <i class="fas fa-pen"></i>
                                        </button>
                                        <button type="button"
                                                onclick="hapusRule({{ $rule->id }})"
                                                title="Hapus Aturan"
                                                class="flex items-center justify-center w-9 h-9 bg-red-600 hover:bg-red-500 text-white rounded-lg transition shadow-sm">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr id="emptyRow">
                                <td colspan="9" class="text-center py-10 text-gray-400">
                                    Belum ada aturan KKM
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
    const baseUrl = '{{ route("admin.kkm-rules.index") }}';

    // 1. Data Hierarkis: Bidang -> Jenis Kegiatan -> Opsi Peran/Sifat
    const kkmData = {
        'Bidang Orientasi Kompetensi Profesional': {
            'Kompetisi sesuai dengan bidang keilmuan': ['Peserta', 'Finalis', 'Juara III', 'Juara II', 'Juara I'],
            'Penelitian': ['Terlibat Penelitian Dosen'],
            'Program Kreativitas Mahasiswa (PKM)/Program Mahasiswa Wirausaha (PMW) (kegiatan lain sejenis)': ['Proposal', 'Proposal diunggah', 'Pelaksanaan dan Pelaporan'],
            'Kegiatan ilmiah (Seminar, Workshop, dll)': ['Peserta', 'Moderator', 'Narasumber'],
            'Publikasi': ['Tulisan di koran/majalah', 'Karya seni dipublikasikan', 'Artikel Jurnal Ilmiah Non Terakreditasi', 'Artikel Jurnal Ilmiah Terakreditasi', 'Buku ISBN (bukan penulis utama)', 'Buku ISBN (penulis utama)', 'Memperoleh HKI'],
            'Pengabdian Masyarakat sesuai bidang': ['Rutin (Min. 8 Jam)', 'Insidental'],
            'Pertunjukan/Konser sesuai bidang': ['Tunggal', 'Bersama']
        },
        'Bidang Kompetensi Kepribadian dan Sosial': {
            'Kerohanian': ['Peserta (Rutin)', 'Peserta (Insidental)', 'Fasilitator/Mentor (Rutin)', 'Fasilitator/Mentor (Insidental)'],
            'Fasilitator/Mentor/Narasumber': ['Rutin', 'Insidental'],
            'Kepemimpinan': ['Peserta Pelatihan', 'Pemateri/Pelatih'],
            'Organisasi - Lembaga Kemahasiswaan': ['Anggota bidang', 'Sekretaris/Bendahara/Kabid', 'Ketua'],
            'Organisasi - Kelompok Minat Bakat': ['Anggota', 'Sekretaris/Bendahara/Kabid', 'Ketua'],
            'Organisasi - Kepanitiaan': ['Tim Pengarah/Satgas', 'Sekretaris/Bendahara/Kabid', 'Ketua Panitia'],
            'Bakat dan Minat - Kompetisi': ['Peserta', 'Finalis', 'Juara III', 'Juara II', 'Juara I'],
            'Bakat dan Minat - Konser/Pameran Luar Bidang': ['Tunggal', 'Bersama'],
            'Pengabdian Masyarakat luar bidang': ['Rutin (Min. 8 Jam)', 'Insidental'],
            'Peserta pertukaran mahasiswa': ['Peserta'],
            'Membantu pembuatan web/database': ['Tim/Kreator'],
            'Kegiatan di luar kompetensi profesional & sosial': ['Peserta/Panitia'],
            'Kegiatan pengelolaan kampus': ['Asisten Dosen', 'Kehumasan', 'Tim Akreditasi']
        }
    };

    // Daftar Standar Ruang Lingkup
    const ruangLingkupOptions = [
        'Tidak Ada / Statis', 'Kampus', 'Program Studi', 'Fakultas', 'Institut/Kampus', 'Lokal (DIY & Sekitarnya)', 'Nasional', 'Internasional'
    ];

    // 2. Fungsi Update Dropdown Jenis Kegiatan
    function updateJenisDropdown(prefix, selectedJenis = '', selectedPeran = '') {
        const bidang = document.getElementById(`${prefix}_bidang`).value;
        const jenisSelect = document.getElementById(`${prefix}_jenis`);
        const peranSelect = document.getElementById(`${prefix}_peran`);

        jenisSelect.innerHTML = '<option value="">-- Pilih Jenis Kegiatan --</option>';
        peranSelect.innerHTML = '<option value="">-- Pilih Peran/Sifat --</option>';
        peranSelect.disabled = true;

        if (bidang && kkmData[bidang]) {
            jenisSelect.disabled = false;
            Object.keys(kkmData[bidang]).forEach(jenis => {
                const isSelected = (jenis === selectedJenis) ? 'selected' : '';
                jenisSelect.innerHTML += `<option value="${jenis}" ${isSelected}>${jenis}</option>`;
            });

            if (selectedJenis) updatePeranDropdown(prefix, selectedPeran);
        } else {
            jenisSelect.disabled = true;
        }
    }

    // 3. Fungsi Update Dropdown Peran/Sifat
    function updatePeranDropdown(prefix, selectedPeran = '') {
        const bidang = document.getElementById(`${prefix}_bidang`).value;
        const jenis = document.getElementById(`${prefix}_jenis`).value;
        const peranSelect = document.getElementById(`${prefix}_peran`);

        peranSelect.innerHTML = '<option value="">-- Pilih Peran/Sifat --</option>';

        if (bidang && jenis && kkmData[bidang][jenis]) {
            peranSelect.disabled = false;
            kkmData[bidang][jenis].forEach(peran => {
                const isSelected = (peran === selectedPeran) ? 'selected' : '';
                peranSelect.innerHTML += `<option value="${peran}" ${isSelected}>${peran}</option>`;
            });
        } else {
            peranSelect.disabled = true;
        }
    }

    // 4. Generator HTML Modal SweetAlert
    function generateFormHTML(prefix, data = {}) {
        let ruangLingkupHTML = '<option value="">-- Pilih Ruang Lingkup --</option>';
        ruangLingkupOptions.forEach(opt => {
            let isSelected = ((data.ruang || '').trim() === opt.trim()) ? 'selected' : '';
            ruangLingkupHTML += `<option value="${opt}" ${isSelected}>${opt}</option>`;
        });

        return `
            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Bidang <span class="text-red-500">*</span></label>
                <select id="${prefix}_bidang" onchange="updateJenisDropdown('${prefix}')" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500">
                    <option value="">Pilih Bidang</option>
                    <option value="Bidang Orientasi Kompetensi Profesional" ${data.bidang === 'Bidang Orientasi Kompetensi Profesional' ? 'selected' : ''}>Bidang Orientasi Kompetensi Profesional</option>
                    <option value="Bidang Kompetensi Kepribadian dan Sosial" ${data.bidang === 'Bidang Kompetensi Kepribadian dan Sosial' ? 'selected' : ''}>Bidang Kompetensi Kepribadian dan Sosial</option>
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Jenis Kegiatan <span class="text-red-500">*</span></label>
                <select id="${prefix}_jenis" onchange="updatePeranDropdown('${prefix}')" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500" disabled>
                    <option value="">-- Pilih Bidang Terlebih Dahulu --</option>
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Peran / Sifat Kegiatan <span class="text-red-500">*</span></label>
                <select id="${prefix}_peran" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500" disabled>
                    <option value="">-- Pilih Jenis Terlebih Dahulu --</option>
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Ruang Lingkup <span class="text-red-500">*</span></label>
                <select id="${prefix}_ruang" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500">
                    ${ruangLingkupHTML}
                </select>
                <p class="text-xs text-gray-400 mt-1">Pilih "Tidak Ada / Statis" jika poin bersifat mutlak tanpa ruang lingkup.</p>
            </div>
            <div class="flex gap-4">
                <div class="mb-4 w-1/2">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Poin <span class="text-red-500">*</span></label>
                    <input type="number" id="${prefix}_poin" value="${data.poin || ''}" min="1" max="100" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="mb-4 w-1/2">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Status <span class="text-red-500">*</span></label>
                    <select id="${prefix}_active" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500">
                        <option value="1" ${data.active === '1' || data.active === undefined ? 'selected' : ''}>Aktif</option>
                        <option value="0" ${data.active === '0' ? 'selected' : ''}>Nonaktif</option>
                    </select>
                </div>
            </div>`;
    }

    // 5. Validasi Data
    function validasiForm(prefix) {
        const bidang = document.getElementById(`${prefix}_bidang`).value;
        const jenis = document.getElementById(`${prefix}_jenis`).value;
        const peran = document.getElementById(`${prefix}_peran`).value;
        const ruang = document.getElementById(`${prefix}_ruang`).value;
        const poin = document.getElementById(`${prefix}_poin`).value;

        if (!bidang) { Swal.showValidationMessage('Bidang wajib dipilih'); return false; }
        if (!jenis) { Swal.showValidationMessage('Jenis kegiatan wajib dipilih'); return false; }
        if (!peran) { Swal.showValidationMessage('Peran/Sifat wajib dipilih'); return false; }
        if (!ruang) { Swal.showValidationMessage('Ruang Lingkup wajib dipilih'); return false; }
        if (!poin || poin < 1) { Swal.showValidationMessage('Poin wajib diisi (minimal 1)'); return false; }
        return true;
    }

    // 6. Kolektor Data Payload
    function collectFormData(prefix) {
        return {
            bidang: document.getElementById(`${prefix}_bidang`).value,
            jenis_kegiatan: document.getElementById(`${prefix}_jenis`).value,
            ruang_lingkup: document.getElementById(`${prefix}_ruang`).value || null,
            peran: document.getElementById(`${prefix}_peran`).value,
            poin: parseInt(document.getElementById(`${prefix}_poin`).value),
            is_active: document.getElementById(`${prefix}_active`).value === '1' ? 1 : 0,
        };
    }

    // 7. Action Modal Tambah
    function bukaModalTambah() {
        Swal.fire({
            title: '<h2 class="text-xl font-bold text-gray-800 text-left">Tambah Aturan KKM</h2>',
            width: '550px',
            html: `<div class="text-left mt-4">${generateFormHTML('add')}</div>`,
            showCancelButton: true,
            confirmButtonText: 'Simpan',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#2563EB',
            cancelButtonColor: '#9CA3AF',
            allowOutsideClick: false,
            customClass: { popup: 'rounded-2xl p-6' },
            didOpen: () => {
                updateJenisDropdown('add');
            },
            preConfirm: () => {
                if (!validasiForm('add')) return false;
                Swal.showLoading();
                const data = collectFormData('add');
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
                Swal.fire({ icon: 'success', title: 'Berhasil!', text: 'Aturan KKM berhasil ditambahkan', timer: 2000, showConfirmButton: false })
                .then(() => location.reload());
            }
        });
    }

    // 8. Action Modal Edit
    function bukaModalEdit(button) {
        const decode = (str) => { const t = document.createElement('textarea'); t.innerHTML = str; return t.value; };
        const data = {
            bidang: decode(button.getAttribute('data-bidang')),
            jenis: decode(button.getAttribute('data-jenis')),
            ruang: decode(button.getAttribute('data-ruang')),
            peran: decode(button.getAttribute('data-peran')),
            poin: button.getAttribute('data-poin'),
            active: button.getAttribute('data-active'),
        };
        const id = button.getAttribute('data-id');

        Swal.fire({
            title: '<h2 class="text-xl font-bold text-gray-800 text-left">Edit Aturan KKM</h2>',
            width: '550px',
            html: `<div class="text-left mt-4">${generateFormHTML('edit', data)}</div>`,
            showCancelButton: true,
            confirmButtonText: 'Simpan',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#2563EB',
            cancelButtonColor: '#9CA3AF',
            allowOutsideClick: false,
            customClass: { popup: 'rounded-2xl p-6' },
            didOpen: () => {
                updateJenisDropdown('edit', data.jenis, data.peran);
                const ruangSelect = document.getElementById('edit_ruang');
                if (ruangSelect && data.ruang) {
                    ruangSelect.value = data.ruang;
                }
            },
            preConfirm: () => {
                if (!validasiForm('edit')) return false;
                Swal.showLoading();
                const updatedData = collectFormData('edit');
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
                Swal.fire({ icon: 'success', title: 'Berhasil!', text: 'Aturan KKM berhasil diperbarui', timer: 2000, showConfirmButton: false })
                .then(() => location.reload());
            }
        });
    }

    // 9. Action Hapus Data
    function hapusRule(id) {
        Swal.fire({
            title: 'Hapus Aturan?',
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
