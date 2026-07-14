<x-app-layout>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

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
        <div class="max-w-8xl mx-auto py-6">

            <!-- Header -->
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">
                        Master Program Studi
                    </h1>
                    <p class="text-gray-500 mt-1">
                        Kelola data program studi untuk registrasi mahasiswa
                    </p>
                </div>
            </div>

            <div class="bg-white shadow rounded-xl p-4 mb-6 flex flex-col md:flex-row items-center justify-between gap-4">
    
                <form method="GET" action="{{ route('admin.prodi.index') }}" class="flex flex-col md:flex-row items-center gap-3 w-full md:w-auto">
        
                    <div class="relative w-full md:w-auto flex-shrink-0">
                        <input type="text"
                               name="search"
                               value="{{ request('search') }}"
                               placeholder="Cari Program Studi..."
                               class="w-full md:w-64 border border-gray-300 rounded-xl pl-10 pr-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="w-4 h-4 absolute left-3 top-3 text-gray-400"
                             fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M11 18a7 7 0 100-14 7 7 0 000 14z"/>
                        </svg>
                    </div>

                    {{-- ⚡ FILTER FAKULTAS --}}
                    <select name="fakultas" class="w-full md:w-48 border border-gray-300 rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 cursor-pointer">
                        <option value="">Semua Fakultas</option>
                        @foreach($fakultasList ?? [] as $fak)
                            <option value="{{ $fak }}" {{ request('fakultas') == $fak ? 'selected' : '' }}>{{ $fak }}</option>
                        @endforeach
                    </select>

                    <select name="status" class="w-full md:w-48 border border-gray-300 rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 cursor-pointer">
                        <option value="">Semua Status</option>
                        <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="tidak aktif" {{ request('status') == 'tidak aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>

                    <div class="flex gap-2 w-full md:w-auto flex-shrink-0">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-xl text-sm font-semibold transition w-full md:w-auto whitespace-nowrap">
                            Cari
                        </button>
            
                        @if(request('search') || request('status') || request('fakultas'))
                            <a href="{{ route('admin.prodi.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-2 rounded-xl text-sm font-semibold transition flex items-center justify-center w-full md:w-auto whitespace-nowrap">
                                Reset
                            </a>
                        @endif
                    </div>
                </form>

                <button onclick="bukaModalTambah()"
                        class="bg-blue-600 hover:bg-blue-500 text-white px-5 py-2 rounded-xl text-sm font-semibold transition cursor-pointer w-full md:w-auto whitespace-nowrap">
                    + Tambah Prodi
                </button>

            </div>

            <!-- Tabel -->
            <div class="bg-white shadow-xl rounded-2xl overflow-hidden">

                <table class="w-full text-sm text-left text-gray-600">

                    <thead class="bg-gray-50 uppercase text-xs tracking-wider border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-4 text-center w-16">No</th>
                            <th class="px-6 py-4">Nama Program Studi</th>
                            <th class="px-6 py-4">Fakultas</th> {{-- ⚡ KOLOM BARU --}}
                            <th class="px-6 py-4 text-center">Status</th>
                            <th class="px-6 py-4 text-center w-48">Aksi</th>
                        </tr>
                    </thead>

                    <tbody id="tableBody">
                        @forelse($prodis as $prodi)
                        <tr id="row-{{ $prodi->id }}" class="border-b hover:bg-blue-50 transition">
                            <td class="px-6 py-4 text-center">
                                {{ $prodis->firstItem() + $loop->index }}
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-800">
                                {{ $prodi->nama_prodi }}
                            </td>
                            {{-- ⚡ KOLOM FAKULTAS --}}
                            <td class="px-6 py-4 text-gray-700">
                                {{ $prodi->fakultas ?? '-' }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($prodi->status == 'aktif')
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
                                    <button onclick="editProdi({{ $prodi->id }})" title="Edit Program Studi"
                                        class="flex items-center justify-center w-9 h-9 bg-yellow-500 hover:bg-yellow-400 text-white rounded-lg transition shadow-sm">
                                        <i class="fas fa-pen"></i>
                                    </button>
                                    
                                    <button onclick="deleteProdi({{ $prodi->id }})" title="Hapus Program Studi"
                                        class="flex items-center justify-center w-9 h-9 bg-red-600 hover:bg-red-500 text-white rounded-lg transition shadow-sm">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-10 text-gray-400">
                                Belum ada data Program Studi
                            </td>
                        </tr>
                        @endforelse
                    </tbody>

                </table>

            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $prodis->links() }}
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // ============================================
        // RENDER PRODI (Untuk Tambah)
        // ============================================
        function renderProdi(prodi) {
            const statusBadge = prodi.status === 'aktif' 
                ? '<span class="inline-block min-w-[90px] text-center bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">Aktif</span>'
                : '<span class="inline-block min-w-[90px] text-center bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-semibold">Tidak Aktif</span>';
            
            return `
            <tr id="row-${prodi.id}" class="border-b hover:bg-blue-50 transition">
                <td class="px-6 py-4 text-center">0</td>
                <td class="px-6 py-4 font-medium text-gray-800">${prodi.nama_prodi}</td>
                <td class="px-6 py-4 text-gray-700">${prodi.fakultas ?? '-'}</td> {{-- ⚡ FAKULTAS --}}
                <td class="px-6 py-4 text-center">${statusBadge}</td>
                <td class="px-6 py-4 text-center">
                    <div class="flex justify-center gap-2">
                        <button onclick="editProdi(${prodi.id})" title="Edit Program Studi"
                            class="flex items-center justify-center w-9 h-9 bg-yellow-500 hover:bg-yellow-400 text-white rounded-lg transition shadow-sm">
                            <i class="fas fa-pen"></i>
                        </button>
                        <button onclick="deleteProdi(${prodi.id})" title="Hapus Program Studi"
                            class="flex items-center justify-center w-9 h-9 bg-red-600 hover:bg-red-500 text-white rounded-lg transition shadow-sm">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
            `;
        }

        // ============================================
        // TAMBAH PRODI
        // ============================================
        function bukaModalTambah() {
            Swal.fire({
                title: '<h2 class="text-2xl font-bold text-gray-800 text-left">Tambah Prodi</h2>',
                width: '500px',
                html: `
                    <div class="mb-4 text-left">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Program Studi *</label>
                        <input type="text" id="add_nama" class="w-full border border-gray-300 rounded-lg px-4 py-3 outline-none" placeholder="Contoh: S1 Teknik Informatika" required>
                    </div>
                    {{-- ⚡ FIELD FAKULTAS --}}
                    <div class="mb-4 text-left">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Fakultas</label>
                        <input type="text" id="add_fakultas" class="w-full border border-gray-300 rounded-lg px-4 py-3 outline-none" placeholder="Contoh: Fakultas Teknik">
                    </div>
                    <div class="mb-4 text-left">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Status *</label>
                        <select id="add_status" class="w-full border border-gray-300 rounded-lg px-4 py-3 outline-none" required>
                            <option value="aktif">Aktif</option>
                            <option value="tidak aktif">Tidak Aktif</option>
                        </select>
                    </div>
                `,
                showCancelButton: true,
                confirmButtonText: 'Simpan',
                confirmButtonColor: '#2563EB',
                customClass: {
                    popup: 'rounded-2xl p-4'
                },
                preConfirm: () => {
                    const nama = document.getElementById('add_nama').value.trim();
                    
                    if (!nama) {
                        Swal.showValidationMessage('Nama prodi wajib diisi!');
                        return false;
                    }
                    
                    return fetch('{{ route("admin.prodi.store") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            nama_prodi: nama,
                            fakultas: document.getElementById('add_fakultas').value.trim(), // ⚡ FAKULTAS
                            status: document.getElementById('add_status').value
                        })
                    })
                    .then(async res => {
                        let data = await res.json();
                        if (!res.ok) {
                            let errorText = data.errors ? Object.values(data.errors).map(e => e[0]).join('<br>') : data.message;
                            throw new Error(errorText);
                        }
                        return data;
                    });
                }
            }).then(result => {
                if (!result.isConfirmed) return;
                
                const tableBody = document.getElementById('tableBody');
                if (tableBody) {
                    tableBody.insertAdjacentHTML('afterbegin', renderProdi(result.value.data));
                }
                resetTableNumber();
                Swal.fire('Sukses', result.value.message || 'Program studi berhasil ditambahkan', 'success');
            })
            .catch(err => {
                Swal.fire('Error', err.message, 'error');
            });
        }

        // ============================================
        // EDIT PRODI
        // ============================================
        function editProdi(id) {
            fetch(`/admin/prodi/${id}`, {
                headers: { 'Accept': 'application/json' }
            })
            .then(res => {
                if (!res.ok) throw new Error('Gagal mengambil data.');
                return res.json();
            })
            .then(prodi => {
                Swal.fire({
                    title: '<h2 class="text-2xl font-bold text-gray-800 text-left">Edit Prodi</h2>',
                    width: '500px',
                    html: `
                        <div class="mb-4 text-left">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Program Studi *</label>
                            <input type="text" id="edit_nama" class="w-full border border-gray-300 rounded-lg px-4 py-3 outline-none" value="${prodi.nama_prodi}" required>
                        </div>
                        {{-- ⚡ FIELD FAKULTAS --}}
                        <div class="mb-4 text-left">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Fakultas</label>
                            <input type="text" id="edit_fakultas" class="w-full border border-gray-300 rounded-lg px-4 py-3 outline-none" value="${prodi.fakultas ?? ''}" placeholder="Contoh: Fakultas Teknik">
                        </div>
                        <div class="mb-4 text-left">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Status *</label>
                            <select id="edit_status" class="w-full border border-gray-300 rounded-lg px-4 py-3 outline-none" required>
                                <option value="aktif" ${prodi.status === 'aktif' ? 'selected' : ''}>Aktif</option>
                                <option value="tidak aktif" ${prodi.status === 'tidak aktif' ? 'selected' : ''}>Tidak Aktif</option>
                            </select>
                        </div>
                    `,
                    showCancelButton: true,
                    confirmButtonText: 'Perbarui',
                    confirmButtonColor: '#2563EB',
                    customClass: {
                        popup: 'rounded-2xl p-4'
                    },
                    preConfirm: () => {
                        const namaBaru = document.getElementById('edit_nama').value.trim();
                        
                        if (!namaBaru) {
                            Swal.showValidationMessage('Nama prodi wajib diisi!');
                            return false;
                        }
                        
                        const formData = new FormData();
                        formData.append('_method', 'PUT');
                        formData.append('nama_prodi', namaBaru);
                        formData.append('fakultas', document.getElementById('edit_fakultas').value.trim()); // ⚡ FAKULTAS
                        formData.append('status', document.getElementById('edit_status').value);
                        
                        return fetch(`/admin/prodi/${id}`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            },
                            body: formData
                        })
                        .then(async res => {
                            let data = await res.json();
                            if (!res.ok) {
                                let errorText = data.errors ? Object.values(data.errors).map(e => e[0]).join('<br>') : data.message;
                                throw new Error(errorText);
                            }
                            return { ...data, namaBaru, fakultasBaru: document.getElementById('edit_fakultas').value.trim(), statusBaru: document.getElementById('edit_status').value };
                        });
                    }
                }).then(result => {
                    if (!result.isConfirmed) return;
                    
                    const row = document.getElementById(`row-${id}`);
                    if (row) {
                        row.children[1].innerText = result.value.namaBaru;
                        row.children[2].innerText = result.value.fakultasBaru || '-'; // ⚡ UPDATE FAKULTAS
                        
                        const statusBadge = result.value.statusBaru === 'aktif' 
                            ? '<span class="inline-block min-w-[90px] text-center bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">Aktif</span>'
                            : '<span class="inline-block min-w-[90px] text-center bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-semibold">Tidak Aktif</span>';
                        row.children[3].innerHTML = statusBadge; // ⚡ INDEX BERUBAH KARENA ADA KOLOM FAKULTAS
                    }
                    
                    Swal.fire('Sukses', result.value.message || 'Program studi berhasil diupdate', 'success');
                })
                .catch(err => {
                    Swal.fire('Error saat Update', err.message, 'error');
                });
            })
            .catch(err => {
                Swal.fire('Error', err.message, 'error');
            });
        }

        // ============================================
        // DELETE PRODI
        // ============================================
        function deleteProdi(id) {
            Swal.fire({
                title: 'Yakin hapus prodi?',
                text: 'Data tidak bisa dikembalikan',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6b7280'
            }).then(result => {
                if (!result.isConfirmed) return;
                
                const formData = new FormData();
                formData.append('_method', 'DELETE');
                
                fetch(`/admin/prodi/${id}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: formData
                })
                .then(async res => {
                    let data = await res.json();
                    if (!res.ok) throw new Error(data.message || 'Gagal menghapus.');
                    return data;
                })
                .then(() => {
                    let rowElement = document.getElementById(`row-${id}`);
                    if (rowElement) {
                        rowElement.remove();
                    }
                    resetTableNumber();
                    Swal.fire('Berhasil', 'Program studi berhasil dihapus', 'success');
                })
                .catch(err => {
                    Swal.fire('Error saat Hapus', err.message, 'error');
                });
            });
        }

        // ============================================
        // RESET NOMOR TABEL
        // ============================================
        function resetTableNumber() {
            document.querySelectorAll('#tableBody tr').forEach((row, index) => {
                const tds = row.querySelectorAll('td');
                if (tds.length > 0) {
                    tds[0].innerText = index + 1;
                }
            });
        }
    </script>

</x-app-layout>