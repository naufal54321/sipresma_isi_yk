<x-app-layout>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

@php
    \Carbon\Carbon::setLocale('id');
    // Trik: Mengambil data prodi yang aktif langsung dari model
    $programStudis = \App\Models\ProgramStudi::where('status', 'aktif')
                        ->orderBy('nama_prodi', 'asc')
                        ->get();
@endphp

<div class="py-1">
    <div class="max-w-8xl mx-auto py-6">

        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Daftar Pengguna</h1>
            <p class="text-gray-500 mt-1">Kelola seluruh pengguna SIPRESMA</p>
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
                            <th class="px-4 py-4">Program Studi / Fakultas</th>
                            <th class="px-4 py-4">Email</th>
                            <th class="px-4 py-4 text-center">Role</th>
                            <th class="px-4 py-4">Tanggal Daftar</th>
                            <th class="px-4 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody id="userTable">
                        @forelse ($users->where('status', 'aktif') as $user)
                        <tr id="row-{{ $user->id }}" class="border-b hover:bg-blue-50 transition duration-200">
                            <td class="px-4 py-4 text-center font-semibold text-gray-800">
                                {{ method_exists($users, 'firstItem') ? $users->firstItem() + $loop->index : $loop->iteration }}
                            </td>
                            <td class="px-4 py-4 font-semibold text-gray-800">{{ $user->name }}</td>
                            <td class="px-4 py-4">{{ $user->nim }}</td>
                            <td class="px-4 py-4">
                                {{ $user->prodi ?: '-' }}
                            </td>
                            <td class="px-4 py-4">{{ $user->email }}</td>
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
                        <tr>
                            <td colspan="8" class="text-center py-10 text-gray-400">Belum ada pengguna</td>
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
    if (roleName === 'Dosen') roleColor = 'bg-green-100 text-green-700';

    let prodiName = user.prodi ? user.prodi : '-';

    return `
    <tr id="row-${user.id}" class="border-b hover:bg-blue-50 transition duration-200">
        <td class="px-4 py-4 text-center font-semibold text-gray-800">0</td>
        <td class="px-4 py-4 font-semibold text-gray-800">${user.name}</td>
        <td class="px-4 py-4">${user.nim}</td>
        <td class="px-4 py-4">${prodiName}</td>
        <td class="px-4 py-4">${user.email}</td>
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
// ADD USER (DESAIN AWAL + FIX SYNTAX)
// =============================================
function addUser() {
    Swal.fire({
        title: 'Tambahkan Pengguna',
        width: '600px',
        padding: '0',
        showCloseButton: true,
        showCancelButton: true,
        confirmButtonText: '<i class="fas fa-save"></i> Simpan',
        cancelButtonText: '<i class="fas fa-times"></i> Batal',
        reverseButtons: true,
        customClass: {
            confirmButton: 'btn-simpan',
            cancelButton: 'btn-batal'
        },
        position: 'top',
        heightAuto: false,

        html: `
        <style>
            div:where(.swal2-container) h2:where(.swal2-title) {
                text-align: left !important; font-size: 20px; color: #777;
                padding: 25px 40px 15px 30px !important; margin: 0 !important;
                border-bottom: 1px solid #eee;
            }
            div:where(.swal2-container) div:where(.swal2-html-container) {
                padding: 15px 20px 20px 20px !important;
            }
            .form-row { margin-bottom: 10px; }
            .swal2-popup{ overflow: visible !important; }
            .form-row{ overflow: visible !important; }
            .input-wrapper{ overflow: visible !important; }
            div:where(.swal2-container) div:where(.swal2-actions) {
                justify-content: flex-end !important; width: 100%;
                margin: 0 !important; padding: 0 30px 25px 0 !important; box-sizing: border-box;
            }
            .form-row { display: flex; align-items: center; margin-bottom: 15px; }
            .form-row label { width: 30%; text-align: left; font-weight: bold; color: #777; font-size: 14px; }
            .form-row label span { color: red; }
            .form-row .input-wrapper { width: 70%; }
            .custom-input {
                width: 100%; padding: 10px 12px; border: 1px solid #ccc;
                border-radius: 4px; font-size: 14px; color: #555;
                box-sizing: border-box; outline: none; background-color: #fff;
            }
            .custom-input:focus { border-color: #3f51b5; }
            select.custom-input { appearance: none; -webkit-appearance: none; padding-right: 30px; }
            .btn-simpan {
                background-color: #3f51b5 !important; color: white !important;
                border-radius: 4px !important; padding: 8px 25px !important;
                font-size: 14px !important; margin-left: 10px !important;
            }
            .btn-batal {
                background-color: #fff !important; color: #777 !important;
                border: 1px solid #ccc !important; border-radius: 4px !important;
                padding: 8px 25px !important; font-size: 14px !important;
            }
        </style>

        <div class="form-row">
            <label>Nama <span>*</span></label>
            <div class="input-wrapper">
                <input id="name" class="custom-input" placeholder="Masukan Nama">
            </div>
        </div>
        <div class="form-row">
            <label>NIM/NIP <span>*</span></label>
            <div class="input-wrapper">
                <input id="nim" class="custom-input" placeholder="Masukan NIM/NIP">
            </div>
        </div>
        <div class="form-row">
            <label>Roles <span>*</span></label>
            <div class="input-wrapper">
                <select id="role" class="custom-input">
                    <option value="" disabled selected>Pilih Role</option>
                    <option value="Mahasiswa">Mahasiswa</option>
                    <option value="Dosen">Dosen</option>
                    <option value="Admin">Admin</option>
                </select>
            </div>
        </div>
        <div class="form-row" style="margin-bottom:35px;">
            <label>Program Studi <span>*</span></label>
            <div class="input-wrapper" id="prodiWrapper">
                <select id="prodi" class="custom-input">
                    ${getProdiOptions()}
                </select>
            </div>
        </div>
        <div class="form-row">
            <label>Email <span>*</span></label>
            <div class="input-wrapper">
                <input id="email" type="email" class="custom-input" placeholder="Masukan Email">
            </div>
        </div>
        <div class="form-row">
            <label>Password <span>*</span></label>
            <div class="input-wrapper" style="position: relative;">
                <input id="password" type="password" class="custom-input" style="padding-right: 35px;" placeholder="Masukan Password">
                <i class="fas fa-eye-slash" id="togglePassword"
                    style="position:absolute; right:10px; top:50%; transform:translateY(-50%); cursor:pointer; color:#777;"></i>
            </div>
        </div>
        `,

        didOpen: () => {
            const popup = Swal.getPopup();
            popup.style.marginTop = '10px';
            popup.style.overflow = 'visible';

            const toggle = document.getElementById('togglePassword');
            const passInput = document.getElementById('password');
            if (toggle && passInput) {
                toggle.addEventListener('click', function () {
                    const type = passInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passInput.setAttribute('type', type);
                    this.classList.toggle('fa-eye');
                    this.classList.toggle('fa-eye-slash');
                });
            }

            const roleSelect = document.getElementById('role');
            const prodiWrapper = document.getElementById('prodiWrapper');

            if (roleSelect && prodiWrapper) {
                roleSelect.addEventListener('change', function () {
                    if (this.value === 'Admin' || this.value === 'Dosen') {
                        prodiWrapper.innerHTML = '<input id="prodi" type="text" class="custom-input" placeholder="Masukkan Program Studi / Fakultas secara manual">';
                    } else {
                        prodiWrapper.innerHTML = '<select id="prodi" class="custom-input">' + getProdiOptions() + '</select>';
                    }
                });
            }
        },

        preConfirm: () => ({
            name:     document.getElementById('name').value,
            nim:      document.getElementById('nim').value,
            prodi:    document.getElementById('prodi').value,
            email:    document.getElementById('email').value,
            password: document.getElementById('password').value,
            role:     document.getElementById('role').value
        })

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
// EDIT USER (DESAIN AWAL + FIX SYNTAX + FORMDATA)
// =============================================
function editUser(id) {
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
            ? `<input id="prodi" type="text" class="custom-input" value="${user.prodi || ''}" placeholder="Masukkan Program Studi / Fakultas">`
            : `<select id="prodi" class="custom-input">${getProdiOptions(user.prodi)}</select>`;

        Swal.fire({
            title: 'Edit Data Pengguna',
            width: '600px',
            padding: '0',
            showCloseButton: true,
            showCancelButton: true,
            confirmButtonText: 'Perbarui',
            cancelButtonText: 'Batal',
            reverseButtons: true,
            customClass: {
                confirmButton: 'btn-simpan',
                cancelButton: 'btn-batal'
            },
            position: 'top',
            heightAuto: false,

            html: `
            <style>
                div:where(.swal2-container) h2:where(.swal2-title) {
                    text-align: left !important; font-size: 20px; color: #555;
                    padding: 25px 40px 15px 30px !important; margin: 0 !important;
                    border-bottom: 1px solid #eee;
                }
                div:where(.swal2-container) div:where(.swal2-html-container) { padding: 15px 20px 20px 20px !important; }
                .form-row { margin-bottom: 10px; }
                .swal2-popup{ overflow: visible !important; }
                .form-row{ display: flex; align-items: center; margin-bottom: 20px; overflow: visible !important; }
                .input-wrapper{ width: 72%; overflow: visible !important; }
                div:where(.swal2-container) div:where(.swal2-actions) {
                    justify-content: flex-end !important; width: 100%;
                    margin: 0 !important; padding: 0 30px 25px 0 !important; box-sizing: border-box;
                }
                .form-row label { width: 28%; text-align: left; font-weight: 600; color: #555; font-size: 14px; }
                .form-row label span { color: red; }
                .custom-input {
                    width: 100%; padding: 10px 12px; border: 1px solid #ccc;
                    border-radius: 4px; font-size: 14px; color: #333; box-sizing: border-box; outline: none;
                }
                .custom-input:focus { border-color: #3f51b5; }
                .btn-simpan {
                    background-color: #3f51b5 !important; color: white !important;
                    border-radius: 4px !important; padding: 8px 25px !important; font-size: 14px !important; margin-left: 10px !important;
                }
                .btn-batal {
                    background-color: #fff !important; color: #666 !important;
                    border: 1px solid #ccc !important; border-radius: 4px !important; padding: 8px 25px !important; font-size: 14px !important;
                }
            </style>

            <div class="form-row">
                <label>Nama <span>*</span></label>
                <div class="input-wrapper">
                    <input id="name" class="custom-input" value="${user.name}" placeholder="Nama">
                </div>
            </div>
            <div class="form-row">
                <label>NIM/NIP <span>*</span></label>
                <div class="input-wrapper">
                    <input id="nim" class="custom-input" value="${user.nim}" placeholder="NIM/NIP">
                </div>
            </div>
            <div class="form-row">
                <label>Roles <span>*</span></label>
                <div class="input-wrapper">
                    <select id="role" class="custom-input">
                        <option value="Mahasiswa" ${currentRole === 'Mahasiswa' ? 'selected' : ''}>Mahasiswa</option>
                        <option value="Dosen"     ${currentRole === 'Dosen'     ? 'selected' : ''}>Dosen</option>
                        <option value="Admin"     ${currentRole === 'Admin'     ? 'selected' : ''}>Admin</option>
                    </select>
                </div>
            </div>
            <div class="form-row" style="margin-bottom:35px;">
                <label>Program Studi <span>*</span></label>
                <div class="input-wrapper" id="prodiWrapper">
                    ${prodiHTML}
                </div>
            </div>
            <div class="form-row">
                <label>Email <span>*</span></label>
                <div class="input-wrapper">
                    <input id="email" type="email" class="custom-input" value="${user.email}" placeholder="Email">
                </div>
            </div>
            `,

            didOpen: () => {
                const roleSelect = document.getElementById('role');
                const prodiWrapper = document.getElementById('prodiWrapper');
                if (roleSelect && prodiWrapper) {
                    roleSelect.addEventListener('change', function () {
                        if (this.value === 'Admin' || this.value === 'Dosen') {
                            prodiWrapper.innerHTML = `<input id="prodi" type="text" class="custom-input" value="${user.prodi || ''}" placeholder="Masukkan Program Studi / Fakultas secara manual">`;
                        } else {
                            prodiWrapper.innerHTML = `<select id="prodi" class="custom-input">${getProdiOptions()}</select>`;
                        }
                    });
                }
            },

            preConfirm: () => ({
                name:  document.getElementById('name').value,
                nim:   document.getElementById('nim').value,
                prodi: document.getElementById('prodi').value,
                email: document.getElementById('email').value,
                role:  document.getElementById('role').value
            })

        }).then(result => {
            if (!result.isConfirmed) return;

            const formData = new FormData();
            formData.append('_method', 'PUT'); 
            formData.append('name', result.value.name);
            formData.append('nim', result.value.nim);
            formData.append('prodi', result.value.prodi || '');
            formData.append('email', result.value.email);
            formData.append('role', result.value.role);

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
                    row.children[4].innerText = result.value.email;

                    let roleName  = result.value.role;
                    let roleColor = 'bg-blue-100 text-blue-700';
                    if (roleName === 'Admin') roleColor = 'bg-red-100 text-red-700';
                    if (roleName === 'Dosen') roleColor = 'bg-purple-100 text-purple-700';

                    row.children[5].innerHTML = `<span class="${roleColor} px-3 py-1 rounded-full text-xs font-semibold">${roleName}</span>`;
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
    
    document.querySelectorAll('#userTable tr').forEach((row) => {
        const tds = row.querySelectorAll('td');
        if (tds.length > 0) {
            tds[0].innerText = counter;
            counter++;
        }
    });
}

function updateTotalUser() {
    let total = document.querySelectorAll('#userTable tr').length;
    let totalElement = document.getElementById('totalUser');
    if (totalElement) {
        totalElement.innerText = `Total di Halaman Ini: ${total} Pengguna`;
    }
}
</script>

</x-app-layout>