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

                    <span class="bg-blue-100 text-blue-700 px-4 py-2 rounded-full text-sm font-semibold">
                        Total: {{ $users->count() }} Pengguna
                    </span>

                    <a href="{{ route('users.create') }}"
                       class="bg-blue-600 hover:bg-blue-500 text-white px-5 py-2 rounded-xl text-sm font-semibold transition">

                        + Tambah Pengguna
                    </a>

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
                    <tbody>

                        @forelse ($users as $user)

                        <tr class="border-b hover:bg-blue-50 transition duration-200">

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

                                    <a href="{{ route('users.edit', $user->id) }}"
                                       class="bg-yellow-500 hover:bg-yellow-400 text-white px-4 py-2 rounded-lg text-sm transition">
                                        Edit
                                    </a>

                                    <form action="{{ route('users.destroy', $user->id) }}"
                                          method="POST"
                                          class="form-delete">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                            class="bg-red-500 hover:bg-red-400 text-white px-4 py-2 rounded-lg text-sm transition">
                                            Hapus
                                        </button>

                                    </form>

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

<!-- SWEETALERT DELETE -->
<script>
document.querySelectorAll('.form-delete').forEach(form => {

    form.addEventListener('submit', function(e) {
        e.preventDefault();

        Swal.fire({
            title: 'Yakin?',
            text: "Data pengguna akan dihapus permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {

            if (result.isConfirmed) {
                form.submit();
            }

        });

    });

});
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