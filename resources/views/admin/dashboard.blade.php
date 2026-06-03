<x-app-layout>

<div class="py-1">

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        <!-- Judul -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800">
                Dashboard Admin
            </h1>

            <p class="text-gray-500 mt-1">
                Kelola seluruh pengguna SIPRESMA
            </p>
        </div>

        <!-- Card Table -->
        <div class="bg-white overflow-hidden shadow-xl rounded-2xl">

            <!-- HEADER -->
            <div class="p-6 border-b border-gray-100 flex items-center justify-between">

                <!-- kiri -->
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">
                        Daftar Pengguna
                    </h1>

                    <p class="text-sm text-gray-500 mt-1">
                        Data seluruh pengguna sistem
                    </p>
                </div>

                <!-- kanan -->
                <div class="flex items-center gap-3">

                    <!-- 🔍 GLOBAL SEARCH -->
                    <input type="text" id="globalSearch"
                        placeholder="Cari"
                        class="border rounded-xl px-4 py-2 text-sm w-64 focus:ring focus:ring-blue-200">

                    <span id="totalUser"
    class="bg-blue-100 text-blue-700 px-4 py-2 rounded-full text-sm font-semibold">
    Total: {{ $users->count() }} Pengguna
</span>
<button onclick="addUser()"
    class="bg-blue-600 hover:bg-blue-500 text-white px-5 py-2 rounded-xl text-sm font-semibold transition">

    + Tambah Pengguna
</button>

                </div>

            </div>

            <!-- TABLE -->
            <div class="overflow-x-auto">

                <table class="w-full text-sm text-left text-gray-600">

                    <!-- HEAD -->
                    <thead class="bg-white text-black uppercase text-xs tracking-wider">

                        <tr>
                            <th class="px-4 py-4 text-center">No</th>
                            <th class="px-4 py-4">Nama</th>
                            <th class="px-4 py-4">NIM</th>
                            <th class="px-4 py-4">Program Studi</th>
                            <th class="px-4 py-4">Email</th>
                            <th class="px-4 py-4 text-center">Role</th>
                            <th class="px-4 py-4">Tanggal Daftar</th>
                            <th class="px-4 py-4 text-center">Aksi</th>
                        </tr>

                    </thead>

                    <!-- BODY -->
                   <tbody id="userTable">

                       @forelse ($users as $user)

                        <tr id="row-{{ $user->id }}" class="border-b hover:bg-blue-50 transition duration-200">

                            <td class="px-4 py-4 text-center font-semibold text-gray-800">
                                {{ $loop->iteration }}
                            </td>

                            <td class="px-4 py-4 font-semibold text-gray-800">
                                {{ $user->name }}
                            </td>

                            <td class="px-4 py-4">
                                {{ $user->nim }}
                            </td>

                            <td class="px-4 py-4">
                                {{ $user->prodi }}
                            </td>

                            <td class="px-4 py-4">
                                {{ $user->email }}
                            </td>

                            <td class="px-4 py-4 text-center">

                                @foreach ($user->roles as $role)

                                    @if ($role->name == 'Admin')
                                        <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-semibold">
                                            {{ $role->name }}
                                        </span>

                                    @elseif ($role->name == 'Dosen')
                                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">
                                            {{ $role->name }}
                                        </span>

                                    @else
                                        <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-semibold">
                                            {{ $role->name }}
                                        </span>
                                    @endif

                                @endforeach

                            </td>

                            <td class="px-4 py-4">
                                {{ $user->created_at->translatedFormat('d F Y') }}
                            </td>

                            <!-- AKSI -->
                            <td class="px-4 py-4">
                                <div class="flex items-center gap-2">

                                 <button onclick="editUser({{ $user->id }})"
    class="inline-flex items-center gap-2 bg-yellow-500 hover:bg-yellow-400 text-white px-4 py-2 rounded-xl text-sm font-semibold shadow-md transition duration-200">
    Edit
</button>

                                    <button onclick="deleteUser({{ $user->id }})"
    class="bg-red-500 hover:bg-red-400 text-white px-4 py-2 rounded-lg text-sm transition">
    Hapus
</button>

                                </div>
                            </td>

                        </tr>

                        @empty

                        <tr>
                            <td colspan="8" class="text-center py-10 text-gray-400">
                                Belum ada pengguna
                            </td>
                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

<script>
function renderUser(user) {

    let totalRows =
        document.querySelectorAll('#userTable tr').length + 1;

    return `
    <tr id="row-${user.id}" class="border-b hover:bg-blue-50 transition duration-200">

        <td class="px-4 py-4 text-center font-semibold text-gray-800">
            ${totalRows}
        </td>

        <td class="px-4 py-4 font-semibold text-gray-800">
            ${user.name}
        </td>

        <td class="px-4 py-4">
            ${user.nim}
        </td>

        <td class="px-4 py-4">
            ${user.prodi}
        </td>

        <td class="px-4 py-4">
            ${user.email}
        </td>

        <td class="px-4 py-4 text-center">
            <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-semibold">
                ${user.roles?.[0]?.name ?? 'User'}
            </span>
        </td>

        <td class="px-4 py-4">
            Baru saja
        </td>

        <td class="px-4 py-4">
            <div class="flex items-center gap-2">

                <button onclick="editUser(${user.id})"
                    class="inline-flex items-center gap-2 bg-yellow-500 hover:bg-yellow-400 text-white px-4 py-2 rounded-xl text-sm font-semibold shadow-md transition duration-200">
                    Edit
                </button>

                <button onclick="deleteUser(${user.id})"
                    class="bg-red-500 hover:bg-red-400 text-white px-4 py-2 rounded-lg text-sm transition">
                    Hapus
                </button>

            </div>
        </td>

    </tr>
    `;
}
</script>

<script>
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
    html: `
    <style>
        /* Mengatur jarak dan posisi judul */
        div:where(.swal2-container) h2:where(.swal2-title) {
            text-align: left !important;
            font-size: 20px;
            color: #777;
            padding: 25px 40px 15px 30px !important; 
            margin: 0 !important;
            border-bottom: 1px solid #eee; 
        }

        /* Mengatur jarak area konten form */
        div:where(.swal2-container) div:where(.swal2-html-container) {
            padding: 25px 30px 10px 30px !important; 
            margin: 0 !important;
        }

        /* Mengatur jarak dan posisi tombol rata kanan */
        div:where(.swal2-container) div:where(.swal2-actions) {
            justify-content: flex-end !important;
            width: 100%;
            margin: 0 !important;
            padding: 0 30px 25px 0 !important; 
            box-sizing: border-box;
        }

        /* Layout Grid/Flex untuk form */
        .form-row {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }

        .form-row label {
            width: 30%;
            text-align: left;
            font-weight: bold;
            color: #777;
            font-size: 14px;
        }
        
        .form-row label span {
            color: red;
        }

        .form-row .input-wrapper {
            width: 70%;
        }

        /* Desain Input dan Select */
        .custom-input {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
            color: #555;
            box-sizing: border-box;
            outline: none;
            background-color: #fff;
        }

        .custom-input:focus {
            border-color: #3f51b5; 
        }

        select.custom-input {
    appearance: none; /* Mematikan panah bawaan browser */
    -webkit-appearance: none; /* Untuk browser Safari/Chrome */
    -moz-appearance: none; /* Untuk browser Firefox */
    padding-right: 30px; /* Memberikan ruang agar teks tidak menabrak panah */
}

        /* Desain Tombol */
        .btn-simpan {
            background-color: #3f51b5 !important;
            color: white !important;
            border-radius: 4px !important;
            padding: 8px 25px !important;
            font-size: 14px !important;
            margin-left: 10px !important;
        }
        
        .btn-batal {
            background-color: #fff !important;
            color: #777 !important;
            border: 1px solid #ccc !important;
            border-radius: 4px !important;
            padding: 8px 25px !important;
            font-size: 14px !important;
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
            <input id="nim" class="custom-input" placeholder="Masukan NIM/NPM">
        </div>
    </div>

    <div class="form-row">
        <label>Prodi/Fakultas <span>*</span></label>
        <div class="input-wrapper">
            <input id="prodi" type="text" class="custom-input" placeholder="Masukan Prodi/ Fakultas">
        </div>
    </div>

    <div class="form-row">
        <label>Roles <span>*</span></label>
        <div class="input-wrapper">
            <select id="role" class="custom-input">
                <option value="" disabled selected>Pilih Dosen/Mahasiswa</option>
                <option value="Mahasiswa">Mahasiswa</option>
                <option value="Dosen">Dosen</option>
                <option value="Admin">Admin</option>
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
            <i class="fas fa-eye-slash" id="togglePassword" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer; color: #777;"></i>
        </div>
    </div>
    `,

didOpen: () => {
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');

        if(togglePassword && passwordInput) {
            togglePassword.addEventListener('click', function () {
                // Ubah tipe input antara password dan text
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                
                // Ubah ikon mata silang / mata terbuka
                this.classList.toggle('fa-eye');
                this.classList.toggle('fa-eye-slash');
            });
        }
    },

    preConfirm: () => ({
    name: document.getElementById('name').value,
    nim: document.getElementById('nim').value,
    prodi: document.getElementById('prodi').value,
    email: document.getElementById('email').value,
    password: document.getElementById('password').value,
    role: document.getElementById('role').value
})

}).then(result => {

    if(result.isConfirmed){

       fetch("{{ route('users.store') }}", {
    method: "POST",
    headers: {
        "Content-Type": "application/json",
        "Accept": "application/json",
        "X-CSRF-TOKEN": "{{ csrf_token() }}"
    },
    body: JSON.stringify(result.value)
})
.then(async res => {

    let data = await res.json();

    if (!res.ok) {

        let errorText = '';

        if (data.errors) {
            errorText = Object.values(data.errors)
                .map(err => err[0])
                .join('<br>');
        } else {
            errorText = data.message;
        }

        throw new Error(errorText);
    }

    return data;
})
.then(res => {

    document.getElementById('userTable')
    .insertAdjacentHTML('beforeend', renderUser(res.user));

resetTableNumber();
updateTotalUser();

    Swal.close();

    Swal.fire(
        'Sukses',
        'User berhasil ditambahkan',
        'success'
    );

})
.catch(err => {

    Swal.fire(
        'Error',
        err.message,
        'error'
    );

    console.log(err);

});

    }

});
}
</script>

<script>
function editUser(id){

fetch(`/users/${id}`)
.then(res => res.json())
.then(user => {

Swal.fire({
    title: 'Edit Data Pengguna',
    width: '600px',
    padding: '0', // Reset padding bawaan SweetAlert agar bisa kita atur manual di CSS
    showCloseButton: true,
    showCancelButton: true,
    confirmButtonText: 'Simpan', 
    cancelButtonText: 'Batal',
    reverseButtons: true, 
    customClass: {
        confirmButton: 'btn-simpan',
        cancelButton: 'btn-batal'
    },
    html: `
    <style>
        /* --- 1. PERBAIKAN JARAK JUDUL --- */
        div:where(.swal2-container) h2:where(.swal2-title) {
            text-align: left !important;
            font-size: 20px;
            color: #555;
            /* Padding: Atas 25px, Kanan 40px (untuk tombol X), Bawah 15px, Kiri 30px */
            padding: 25px 40px 15px 30px !important; 
            margin: 0 !important;
            border-bottom: 1px solid #eee; /* Opsional: garis bawah judul */
        }

        /* --- 2. PERBAIKAN JARAK KONTEN (Form) --- */
        div:where(.swal2-container) div:where(.swal2-html-container) {
            padding: 25px 30px 10px 30px !important; /* Mengatur jarak aman form dari kotak putih */
            margin: 0 !important;
        }

        /* --- 3. PERBAIKAN JARAK TOMBOL --- */
        div:where(.swal2-container) div:where(.swal2-actions) {
            justify-content: flex-end !important;
            width: 100%;
            margin: 0 !important;
            /* Padding: Atas 0, Kanan 30px, Bawah 25px, Kiri 0 */
            padding: 0 30px 25px 0 !important; 
            box-sizing: border-box;
        }

        /* --- STYLING FORM (Tetap Sama) --- */
        .form-row {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .form-row label {
            width: 28%;
            text-align: left;
            font-weight: 600;
            color: #555;
            font-size: 14px;
        }
        
        .form-row label span {
            color: red;
        }

        .form-row .input-wrapper {
            width: 72%;
        }

        .custom-input {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
            color: #333;
            box-sizing: border-box;
            outline: none;
        }

        .custom-input:focus {
            border-color: #3f51b5;
        }

        /* --- STYLING TOMBOL --- */
        .btn-simpan {
            background-color: #3f51b5 !important;
            color: white !important;
            border-radius: 4px !important;
            padding: 8px 25px !important;
            font-size: 14px !important;
            margin-left: 10px !important; /* Jarak antara Batal dan Simpan */
        }
        
        .btn-batal {
            background-color: #fff !important;
            color: #666 !important;
            border: 1px solid #ccc !important;
            border-radius: 4px !important;
            padding: 8px 25px !important;
            font-size: 14px !important;
        }
    </style>

    <div class="form-row">
        <label>Nama <span>*</span></label>
        <div class="input-wrapper">
            <input id="name" class="custom-input" value="${user.name || 'Iqbal'}" placeholder="Nama">
        </div>
    </div>

    <div class="form-row">
        <label>NIM/NIP <span>*</span></label>
        <div class="input-wrapper">
            <input id="nim" class="custom-input" value="${user.nim || '231111100010'}" placeholder="NIM/NIP">
        </div>
    </div>

    <div class="form-row">
        <label>Prodi/Fakultas <span>*</span></label>
        <div class="input-wrapper">
            <input id="prodi" class="custom-input" value="${user.prodi || 'Ilmu Komunikasi'}" placeholder="Prodi/Fakultas">
        </div>
    </div>

    <div class="form-row">
        <label>Roles <span>*</span></label>
        <div class="input-wrapper">
            <select id="role" class="custom-input">
                <option value="Mahasiswa" ${user.roles?.[0]?.name === 'Mahasiswa' ? 'selected' : ''}>Mahasiswa</option>
                <option value="Dosen" ${user.roles?.[0]?.name === 'Dosen' ? 'selected' : ''}>Dosen</option>
                <option value="Admin" ${user.roles?.[0]?.name === 'Admin' ? 'selected' : ''}>Admin</option>
            </select>
        </div>
    </div>

    <div class="form-row">
        <label>Email <span>*</span></label>
        <div class="input-wrapper">
            <input id="email" type="email" class="custom-input" value="${user.email || 'iqbal@gmail.com'}" placeholder="Email">
        </div>
    </div>
    `,
    focusConfirm: false,
    preConfirm: () => {

        return {
            name: document.getElementById('name').value,
            nim: document.getElementById('nim').value,
            prodi: document.getElementById('prodi').value,
            email: document.getElementById('email').value,
            role: document.getElementById('role').value
        };

    }

}).then(result => {

    if(result.isConfirmed){

        fetch(`/users/${id}`, {
            method: "PUT",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify(result.value)
        })
        .then(res => res.json())
        .then(() => {

            Swal.fire('Success','User updated','success');
            location.reload();

        });

    }

});

});
}
</script>


<script>
function deleteUser(id){

    Swal.fire({
        title: 'Yakin hapus user?',
        text: 'Data tidak bisa dikembalikan',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, Hapus',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6b7280'
    }).then((result) => {

        if(result.isConfirmed){

            fetch(`/users/${id}`, {
                method: 'DELETE',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(async res => {

                let data = await res.json();

                if(!res.ok){
                    throw new Error(data.message || 'Gagal menghapus');
                }

                return data;
            })
            .then(() => {

    document.getElementById(`row-${id}`)?.remove();

    resetTableNumber();
    updateTotalUser();

    Swal.fire(
        'Berhasil',
        'User berhasil dihapus',
        'success'
    );

})
            .catch(err => {

                Swal.fire(
                    'Error',
                    err.message,
                    'error'
                );

                console.log(err);

            });

        }

    });

}
</script>
<script>
   function resetTableNumber() {

    document.querySelectorAll('#userTable tr').forEach((row, index) => {

        row.querySelectorAll('td')[0].innerText = index + 1;

    });

}
</script>

<script>
    function updateTotalUser() {

    let total =
        document.querySelectorAll('#userTable tr').length;

    document.getElementById('totalUser')
        .innerText = `Total: ${total} Pengguna`;

}
</script>

<!-- GLOBAL SEARCH -->
<script>
document.getElementById('globalSearch').addEventListener('keyup', function () {

    let filter = this.value.toLowerCase().trim();

    document.querySelectorAll('tbody tr').forEach(row => {

        let cells = row.querySelectorAll('td');

        let rowText = '';

        cells.forEach(cell => {
            rowText += cell.textContent.toLowerCase() + ' ';
        });

        if (rowText.includes(filter)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }

    });

});
</script>

</x-app-layout>