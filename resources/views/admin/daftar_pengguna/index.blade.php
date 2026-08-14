<x-app-layout>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        .swal2-html-container { overflow-x: hidden !important; }
        .swal2-html-container * { box-sizing: border-box; }
        .swal2-html-container input,
        .swal2-html-container select { max-width: 100%; }
    </style>

@php
    \Carbon\Carbon::setLocale('id');
    $programStudis = \App\Models\ProgramStudi::where('status', 'aktif')
                        ->orderBy('nama_prodi', 'asc')
                        ->get();
@endphp

<div class="py-1">
    <div class="max-w-8xl mx-auto py-6">

        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Daftar Pengguna</h1>
            <p class="text-gray-500 mt-1">Kelola seluruh pengguna</p>
        </div>
        
        <div class="bg-white overflow-hidden shadow-xl rounded-2xl">

    <div class="p-6 border-b border-gray-100">
    
        <div class="mb-4">
            <h2 class="text-2xl font-bold text-gray-800">Data seluruh pengguna sistem</h2>
            <p class="text-sm text-gray-500 mt-1"></p>
        </div>
        
        <div class="flex flex-col xl:flex-row xl:items-center justify-between gap-4">
            
            <div class="flex flex-wrap items-center gap-3">
                <form method="GET" action="{{ route('admin.users.index') }}" class="flex flex-wrap items-center gap-2">
                    
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari Pengguna..."
                        class="border border-gray-300 rounded-xl px-4 py-2 text-sm w-48 md:w-64 focus:ring-2 focus:ring-blue-300 focus:border-blue-400 outline-none transition">

                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                            <i class="fas fa-filter"></i>
                        </span>
                        <select name="role"
                            class="border border-gray-300 rounded-xl pl-10 pr-8 py-2 text-sm bg-white focus:ring-2 focus:ring-blue-300 focus:border-blue-400 outline-none transition cursor-pointer">
                            <option value="">Semua Role</option>
                            <option value="Mahasiswa" {{ request('role') == 'Mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                            <option value="Dosen" {{ request('role') == 'Dosen' ? 'selected' : '' }}>Dosen</option>
                            <option value="Admin" {{ request('role') == 'Admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                    </div>

                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl text-sm font-semibold transition">
                        Cari
                    </button>

                    @if(request('search') || request('role'))
                        <a href="{{ route('admin.users.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-xl text-sm font-semibold transition flex items-center justify-center">
                            Reset
                        </a>
                    @endif
                </form>

                <span id="totalUser"
                    class="bg-blue-100 text-blue-700 px-4 py-2 rounded-xl text-sm font-semibold whitespace-nowrap">
                    Total: {{ $users->total() ?? $users->count() }} Pengguna
                </span>
            </div>

            <div>
                <button type="button" onclick="addUser()"
                    class="bg-blue-600 hover:bg-blue-500 text-white px-5 py-2 rounded-xl text-sm font-semibold shadow-md transition whitespace-nowrap">
                    + Tambah Pengguna
                </button>
            </div>
            
        </div>
    </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-600">
                    <thead class="bg-gray-50 text-black uppercase text-xs tracking-wider">
                        <tr>
                            <th class="px-4 py-4 text-center">No</th>
                            <th class="px-4 py-4">Nama</th>
                            <th class="px-4 py-4">NIM / NIP</th>
                            <th class="px-4 py-4">Program Studi</th>
                            {{-- ⚡ KOLOM ANGKATAN --}}
                            <th class="px-4 py-4 text-center">Angkatan</th>
                            {{-- ⚡ KOLOM SEMESTER --}}
                            <th class="px-4 py-4 text-center">Semester</th>
                            <th class="px-4 py-4">Email</th>
                            <th class="px-4 py-4 text-center">Role</th>
                            <th class="px-4 py-4">Tanggal Daftar</th>
                            <th class="px-4 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody id="userTable" data-first-item="{{ method_exists($users, 'firstItem') ? $users->firstItem() : 1 }}">
                        @forelse ($users as $user)
                        <tr id="row-{{ $user->id }}" class="border-b hover:bg-blue-50 transition duration-200">
                            <td class="px-4 py-4 text-center font-semibold text-gray-800">
                                {{ method_exists($users, 'firstItem') ? $users->firstItem() + $loop->index : $loop->iteration }}
                            </td>
                            <td class="px-4 py-4 font-semibold text-gray-800">{{ $user->name }}</td>
                            <td class="px-4 py-4">{{ $user->nim }}</td>
                            <td class="px-4 py-4">{{ $user->prodi ?: '-' }}</td>
                            {{-- ⚡ ANGKATAN --}}
                            <td class="px-4 py-4 text-center">{{ $user->angkatan ?: '-' }}</td>
                            {{-- ⚡ SEMESTER --}}
                            <td class="px-4 py-4 text-center">{{ $user->semester ?: '-' }}</td>
                            <td class="px-4 py-4">
                                    <div class="w-[155px] break-all">{{ $user->email }}</div>
                                </td>
                            <td class="px-4 py-4 text-center">
                                @foreach ($user->roles as $role)
                                    @if ($role->name == 'Admin')
                                        <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-semibold">{{ $role->name }}</span>
                                    @elseif ($role->name == 'Dosen')
                                        <span class="bg-purple-100 text-purple-700 px-3 py-1 rounded-full text-xs font-semibold">{{ $role->name }}</span>
                                    @else
                                        <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-semibold">{{ $role->name }}</span>
                                    @endif
                                @endforeach
                            </td>
                            <td class="px-4 py-4"> {{ $user->created_at->translatedFormat('d F Y') }}
                                <div class="text-sm text-gray-500">
                                {{ $user->created_at->format('H:i') }} WIB
                                </div>
                            </td>
                            
                            <td class="px-4 py-4">
                                <div class="flex items-center gap-2">
                                    <button onclick="editUser({{ $user->id }})" title="Edit Pengguna"
                                        class="flex items-center justify-center w-9 h-9 bg-yellow-500 hover:bg-yellow-400 text-white rounded-xl shadow-md transition duration-200">
                                        <i class="fas fa-pen"></i>
                                    </button>
                                    
                                    <button onclick="deleteUser({{ $user->id }})" title="Hapus Pengguna"
                                        class="flex items-center justify-center w-9 h-9 bg-red-500 hover:bg-red-400 text-white rounded-xl shadow-md transition duration-200">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr id="noUsersRow">
                            <td colspan="10" class="text-center py-10 text-gray-400">Belum ada pengguna</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if(method_exists($users, 'links'))
            <div class="p-6 border-t border-gray-100">
                {{ $users->links() }}
            </div>
            @endif

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// =============================================
// FUNGSI HELPER: GENERATE DROPDOWN PRODI
// =============================================
function getProdiOptions(selectedValue) {
    let selected = selectedValue || '';
    let options = '<option value="" disabled ' + (!selected ? 'selected' : '') + '>Pilih Program Studi</option>';
    
    @foreach($programStudis as $prodi)
        options += '<option value="{{ $prodi->nama_prodi }}" ' + (selected === '{{ $prodi->nama_prodi }}' ? 'selected' : '') + '>{{ $prodi->nama_prodi }}</option>';
    @endforeach

    return options;
}

// ⚡ FUNGSI HELPER: GENERATE DROPDOWN SEMESTER
function getSemesterOptions(selectedValue) {
    let selected = selectedValue || '';
    let options = '<option value="" disabled ' + (!selected ? 'selected' : '') + '>Pilih Semester</option>';
    
    for (let i = 1; i <= 14; i++) {
        options += '<option value="' + i + '" ' + (selected == i ? 'selected' : '') + '>Semester ' + i + '</option>';
    }

    return options;
}

// =============================================
// FUNGSI HELPER: ESCAPE HTML
// =============================================
function escapeHtml(value) {
    return String(value == null ? '' : value)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;');
}

// =============================================
// RENDER USER
// =============================================
function renderUser(user) {
    let roleName = 'Mahasiswa';
    if (user.roles && user.roles.length > 0) {
        roleName = user.roles[0].name;
    }

    let roleColor = 'bg-blue-100 text-blue-700';
    if (roleName === 'Admin') roleColor = 'bg-red-100 text-red-700';
    if (roleName === 'Dosen') roleColor = 'bg-purple-100 text-purple-700';

    let prodiName = user.prodi ? user.prodi : '-';
    let angkatan = user.angkatan ? user.angkatan : '-';
    let semester = user.semester ? user.semester : '-';

    return `
    <tr id="row-${user.id}" class="border-b hover:bg-blue-50 transition duration-200">
        <td class="px-4 py-4 text-center font-semibold text-gray-800">0</td>
        <td class="px-4 py-4 font-semibold text-gray-800">${escapeHtml(user.name)}</td>
        <td class="px-4 py-4">${escapeHtml(user.nim)}</td>
        <td class="px-4 py-4">${escapeHtml(prodiName)}</td>
        <td class="px-4 py-4 text-center">${escapeHtml(angkatan)}</td>
        <td class="px-4 py-4 text-center">${escapeHtml(semester)}</td>
        <td class="px-4 py-4">
                <div class="w-[155px] break-all">${escapeHtml(user.email)}</div>
            </td>
        <td class="px-4 py-4 text-center">
            <span class="${roleColor} px-3 py-1 rounded-full text-xs font-semibold">${roleName}</span>
        </td>
        <td class="px-4 py-4">Baru saja</td>
        <td class="px-4 py-4">
            <div class="flex items-center gap-2">
                <button onclick="editUser(${user.id})" title="Edit Pengguna"
                    class="flex items-center justify-center w-9 h-9 bg-yellow-500 hover:bg-yellow-400 text-white rounded-xl shadow-md transition duration-200">
                    <i class="fas fa-pen"></i>
                </button>
                <button onclick="deleteUser(${user.id})" title="Hapus Pengguna"
                    class="flex items-center justify-center w-9 h-9 bg-red-500 hover:bg-red-400 text-white rounded-xl shadow-md transition duration-200">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </td>
    </tr>
    `;
}

// =============================================
// ADD USER
// =============================================
function addUser() {
    const currentYear = new Date().getFullYear();
    const inputCls = 'w-full border border-gray-300 rounded-lg px-4 py-3 outline-none focus:ring focus:ring-blue-200';
    
    Swal.fire({
        title: '<h2 class="text-2xl font-bold text-gray-800 text-left">Tambahkan Pengguna</h2>',
        width: '600px',
        showCancelButton: true,
        confirmButtonText: 'Simpan',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#2563EB',
        cancelButtonColor: '#9CA3AF',
        allowOutsideClick: false,
        allowEscapeKey: false,
        customClass: { popup: 'rounded-2xl p-4' },

        html: `
        <div class="text-left mt-4 max-h-[65vh] overflow-y-auto overflow-x-hidden px-2">
            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Nama <span class="text-red-500">*</span></label>
                <input id="name" class="${inputCls}" placeholder="Masukan Nama" required>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-2">NIM/NIP <span class="text-red-500">*</span></label>
                <input id="nim" class="${inputCls}" placeholder="Masukan NIM/NIP" required>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Roles <span class="text-red-500">*</span></label>
                <select id="role" class="${inputCls}" required>
                    <option value="" disabled selected>Pilih Role</option>
                    <option value="Mahasiswa">Mahasiswa</option>
                    <option value="Dosen">Dosen</option>
                    <option value="Admin">Admin</option>
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Program Studi <span class="text-red-500">*</span></label>
                <div id="prodiWrapper">
                    <select id="prodi" class="${inputCls}">
                        ${getProdiOptions()}
                    </select>
                </div>
            </div>
            {{-- ⚡ ANGKATAN & SEMESTER (untuk Mahasiswa) --}}
            <div class="mb-4 mahasiswa-only">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Angkatan <span class="text-red-500">*</span></label>
                <select id="angkatan" class="${inputCls}">
                    <option value="" disabled selected>Pilih Angkatan</option>
                    ${Array.from({length: currentYear - 2014}, (_, i) => currentYear - i).map(year => 
                        `<option value="${year}">${year}</option>`
                    ).join('')}
                </select>
            </div>
            <div class="mb-4 mahasiswa-only">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Semester <span class="text-red-500">*</span></label>
                <select id="semester" class="${inputCls}">
                    ${getSemesterOptions()}
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Email <span class="text-red-500">*</span></label>
                <input id="email" type="email" class="${inputCls}" placeholder="Masukan Email" required>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Password <span class="text-red-500">*</span></label>
                <div class="relative w-full">
                    <input id="password" type="password" class="${inputCls} pr-12" placeholder="Masukan Password" required>
                    <button type="button" id="togglePassword"
                        class="absolute inset-y-0 right-0 flex items-center px-4 text-gray-400 hover:text-gray-600">
                        <i class="fas fa-eye-slash" id="togglePasswordIcon"></i>
                    </button>
                </div>
            </div>
        </div>
        `,

        didOpen: () => {
            setTimeout(() => { const input = document.getElementById('name'); if (input) input.focus(); }, 100);

            const toggle = document.getElementById('togglePassword');
            const toggleIcon = document.getElementById('togglePasswordIcon');
            const passInput = document.getElementById('password');
            if (toggle && toggleIcon && passInput) {
                toggle.addEventListener('click', function () {
                    const type = passInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passInput.setAttribute('type', type);
                    toggleIcon.classList.toggle('fa-eye');
                    toggleIcon.classList.toggle('fa-eye-slash');
                });
            }

            const roleSelect = document.getElementById('role');
            const prodiWrapper = document.getElementById('prodiWrapper');
            const mahasiswaRows = document.querySelectorAll('.mahasiswa-only');

            // ⚡ Toggle tampilan angkatan/semester & prodi berdasarkan role
            function toggleMahasiswaFields() {
                const isMahasiswa = roleSelect.value === 'Mahasiswa';
                mahasiswaRows.forEach(row => {
                    row.style.display = isMahasiswa ? 'block' : 'none';
                });
                
                // Set required untuk input angkatan/semester
                const angkatanInput = document.getElementById('angkatan');
                const semesterInput = document.getElementById('semester');
                if (angkatanInput) angkatanInput.required = isMahasiswa;
                if (semesterInput) semesterInput.required = isMahasiswa;
            }

            if (roleSelect && prodiWrapper) {
                roleSelect.addEventListener('change', function () {
                    if (this.value === 'Admin' || this.value === 'Dosen') {
                        prodiWrapper.innerHTML = `<input id="prodi" type="text" class="${inputCls}" placeholder="Masukkan Program Studi / Fakultas secara manual">`;
                    } else {
                        prodiWrapper.innerHTML = `<select id="prodi" class="${inputCls}">` + getProdiOptions() + '</select>';
                    }
                    toggleMahasiswaFields();
                });
                
                // Initial state
                toggleMahasiswaFields();
            }
        },

        preConfirm: () => {
            const role = document.getElementById('role').value;
            const data = {
                name:     document.getElementById('name').value,
                nim:      document.getElementById('nim').value,
                prodi:    document.getElementById('prodi').value,
                email:    document.getElementById('email').value,
                password: document.getElementById('password').value,
                role:     role
            };
            
            // ⚡ Tambah angkatan & semester jika role Mahasiswa
            if (role === 'Mahasiswa') {
                data.angkatan = document.getElementById('angkatan').value;
                data.semester = document.getElementById('semester').value;
            }
            
            return data;
        }

    }).then(result => {
        if (!result.isConfirmed) return;

        fetch("{{ route('admin.users.store') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify(result.value)
        })
        .then(async res => {
            let data = await res.json();
            if (!res.ok) {
                let errorText = data.errors ? Object.values(data.errors).map(e => e[0]).join('<br>') : data.message;
                throw new Error(errorText);
            }
            return data;
        })
        .then(data => {
            const tableBody = document.getElementById('userTable');
            if (tableBody) {
                const emptyRow = document.getElementById('noUsersRow');
                if (emptyRow) emptyRow.remove();
                tableBody.insertAdjacentHTML('afterbegin', renderUser(data.user));
            }
            resetTableNumber();
            updateTotalUser();
            Swal.fire('Sukses', 'User berhasil ditambahkan', 'success');
        })
        .catch(err => {
            Swal.fire('Error', err.message, 'error');
        });
    });
}

// =============================================
// EDIT USER
// =============================================
function editUser(id) {
    const currentYear = new Date().getFullYear();
    const inputCls = 'w-full border border-gray-300 rounded-lg px-4 py-3 outline-none focus:ring focus:ring-blue-200';
    
    fetch(`/admin/users/${id}`, {
        headers: { 'Accept': 'application/json' }
    })
    .then(res => {
        if (!res.ok) throw new Error('Gagal mengambil data dari server.');
        return res.json();
    })
    .then(user => {
        let currentRole = 'Mahasiswa';
        if (user.roles && user.roles.length > 0) {
            currentRole = user.roles[0].name;
        }

        let isManualInput = ['Admin', 'Dosen'].includes(currentRole);
        let prodiHTML = isManualInput 
            ? `<input id="prodi" type="text" class="${inputCls}" value="${escapeHtml(user.prodi || '')}" placeholder="Masukkan Program Studi / Fakultas">`
            : `<select id="prodi" class="${inputCls}">${getProdiOptions(user.prodi)}</select>`;

        // ⚡ Angkatan & Semester
        let angkatanValue = user.angkatan || '';
        let semesterValue = user.semester || '';

Swal.fire({
            title: '<h2 class="text-2xl font-bold text-gray-800 text-left">Edit Data Pengguna</h2>',
            width: '600px',
            showCancelButton: true,
            confirmButtonText: 'Perbarui',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#2563EB',
            cancelButtonColor: '#9CA3AF',
            allowOutsideClick: false,
            allowEscapeKey: false,
            customClass: { popup: 'rounded-2xl p-4' },

            html: `
            <div class="text-left mt-4 max-h-[65vh] overflow-y-auto px-2">
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nama <span class="text-red-500">*</span></label>
                    <input id="name" class="${inputCls}" value="${escapeHtml(user.name)}" placeholder="Nama" required>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">NIM/NIP <span class="text-red-500">*</span></label>
                    <input id="nim" class="${inputCls}" value="${escapeHtml(user.nim)}" placeholder="NIM/NIP" required>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Roles <span class="text-red-500">*</span></label>
                    <select id="role" class="${inputCls}" required>
                        <option value="Mahasiswa" ${currentRole === 'Mahasiswa' ? 'selected' : ''}>Mahasiswa</option>
                        <option value="Dosen"     ${currentRole === 'Dosen'     ? 'selected' : ''}>Dosen</option>
                        <option value="Admin"     ${currentRole === 'Admin'     ? 'selected' : ''}>Admin</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Program Studi <span class="text-red-500">*</span></label>
                    <div id="prodiWrapper">
                        ${prodiHTML}
                    </div>
                </div>
                {{-- ⚡ ANGKATAN --}}
                <div class="mb-4 mahasiswa-only" style="display: ${currentRole === 'Mahasiswa' ? 'block' : 'none'};">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Angkatan <span class="text-red-500">*</span></label>
                    <select id="angkatan" class="${inputCls}">
                        <option value="" disabled ${!angkatanValue ? 'selected' : ''}>Pilih Angkatan</option>
                        ${Array.from({length: currentYear - 2014}, (_, i) => currentYear - i).map(year => 
                            `<option value="${year}" ${angkatanValue == year ? 'selected' : ''}>${year}</option>`
                        ).join('')}
                    </select>
                </div>
                {{-- ⚡ SEMESTER --}}
                <div class="mb-4 mahasiswa-only" style="display: ${currentRole === 'Mahasiswa' ? 'block' : 'none'};">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Semester <span class="text-red-500">*</span></label>
                    <select id="semester" class="${inputCls}">
                        ${getSemesterOptions(semesterValue)}
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Email <span class="text-red-500">*</span></label>
                    <input id="email" type="email" class="${inputCls}" value="${escapeHtml(user.email)}" placeholder="Email" required>
                </div>
            </div>
            `,

            didOpen: () => {
                setTimeout(() => { const input = document.getElementById('name'); if (input) input.focus(); }, 100);

                const roleSelect = document.getElementById('role');
                const prodiWrapper = document.getElementById('prodiWrapper');
                const mahasiswaRows = document.querySelectorAll('.mahasiswa-only');

                function toggleMahasiswaFields() {
                    const isMahasiswa = roleSelect.value === 'Mahasiswa';
                    mahasiswaRows.forEach(row => {
                        row.style.display = isMahasiswa ? 'block' : 'none';
                    });

                    const angkatanInput = document.getElementById('angkatan');
                    const semesterInput = document.getElementById('semester');
                    if (angkatanInput) angkatanInput.required = isMahasiswa;
                    if (semesterInput) semesterInput.required = isMahasiswa;
                }

                if (roleSelect && prodiWrapper) {
                    roleSelect.addEventListener('change', function () {
                        if (this.value === 'Admin' || this.value === 'Dosen') {
                            prodiWrapper.innerHTML = `<input id="prodi" type="text" class="${inputCls}" value="${escapeHtml(user.prodi || '')}" placeholder="Masukkan Program Studi / Fakultas secara manual">`;
                        } else {
                            prodiWrapper.innerHTML = `<select id="prodi" class="${inputCls}">${getProdiOptions(user.prodi)}</select>`;
                        }
                        toggleMahasiswaFields();
                    });
                }
            },

            preConfirm: () => {
                const role = document.getElementById('role').value;
                const data = {
                    name:  document.getElementById('name').value,
                    nim:   document.getElementById('nim').value,
                    prodi: document.getElementById('prodi').value,
                    email: document.getElementById('email').value,
                    role:  role
                };
                
                // ⚡ Tambah angkatan & semester jika role Mahasiswa
                if (role === 'Mahasiswa') {
                    data.angkatan = document.getElementById('angkatan').value;
                    data.semester = document.getElementById('semester').value;
                }
                
                return data;
            }

        }).then(result => {
            if (!result.isConfirmed) return;

            const formData = new FormData();
            formData.append('_method', 'PUT'); 
            formData.append('name', result.value.name);
            formData.append('nim', result.value.nim);
            formData.append('prodi', result.value.prodi || '');
            formData.append('email', result.value.email);
            formData.append('role', result.value.role);
            
            // ⚡ Tambah angkatan & semester
            if (result.value.role === 'Mahasiswa') {
                formData.append('angkatan', result.value.angkatan || '');
                formData.append('semester', result.value.semester || '');
            }

            fetch(`/admin/users/${id}`, {
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
                return data;
            })
            .then(() => {
                const row = document.getElementById(`row-${id}`);
                if (row) {
                    row.children[1].innerText = result.value.name;
                    row.children[2].innerText = result.value.nim;
                    row.children[3].innerText = result.value.prodi || '-';
                    // ⚡ Update angkatan & semester
                    row.children[4].innerText = result.value.role === 'Mahasiswa' ? (result.value.angkatan || '-') : '-';
                    row.children[5].innerText = result.value.role === 'Mahasiswa' ? (result.value.semester || '-') : '-';
                    row.children[6].innerText = result.value.email;

                    let roleName  = result.value.role;
                    let roleColor = 'bg-blue-100 text-blue-700';
                    if (roleName === 'Admin') roleColor = 'bg-red-100 text-red-700';
                    if (roleName === 'Dosen') roleColor = 'bg-purple-100 text-purple-700';

                    row.children[7].innerHTML = `<span class="${roleColor} px-3 py-1 rounded-full text-xs font-semibold">${roleName}</span>`;
                }

                Swal.fire('Sukses', 'User berhasil diupdate', 'success');
            })
            .catch(err => {
                Swal.fire('Error saat Update', err.message, 'error');
            });
        });
    })
    .catch(err => {
        Swal.fire('Error', err.message, 'error');
    });
}

// =============================================
// DELETE USER
// =============================================
function deleteUser(id) {
    Swal.fire({
        title: 'Yakin hapus user?',
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

        fetch(`/admin/users/${id}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(async res => {
            let data = await res.json();
            if (!res.ok) throw new Error(data.message || 'Gagal menghapus pengguna.');
            return data;
        })
        .then(() => {
            let rowElement = document.getElementById(`row-${id}`);
            if (rowElement) {
                rowElement.remove();
            }
            if (document.querySelectorAll('#userTable tr[id]').length === 0) {
                document.getElementById('userTable').innerHTML = `
                    <tr id="noUsersRow">
                        <td colspan="10" class="text-center py-10 text-gray-400">Belum ada pengguna</td>
                    </tr>
                `;
            }
            resetTableNumber();
            updateTotalUser();
            Swal.fire('Berhasil', 'User berhasil dihapus', 'success');
        })
        .catch(err => {
            Swal.fire('Error saat Hapus', err.message, 'error');
        });
    });
}

// =============================================
// HELPER: RESET NOMOR TABEL & TOTAL
// =============================================
function resetTableNumber() {
    const table = document.getElementById('userTable');
    if (!table) return;
    
    let firstItem = parseInt(table.getAttribute('data-first-item')) || 1;
    let counter = firstItem;
    
    document.querySelectorAll('#userTable tr[id]').forEach((row) => {
        const tds = row.querySelectorAll('td');
        if (tds.length > 0) {
            tds[0].innerText = counter;
            counter++;
        }
    });
}

function updateTotalUser() {
    let total = document.querySelectorAll('#userTable tr[id]').length;
    let totalElement = document.getElementById('totalUser');
    if (totalElement) {
        totalElement.innerText = `Total di Halaman Ini: ${total} Pengguna`;
    }
}
</script>

</x-app-layout>