<x-app-layout>

    <div class="py-1">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <h1 class="text-3xl font-bold text-black-600">
                    Dashboard Admin
                </h1>
                <br
            </div>

<!-- Card Table -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl">

                <!-- Header -->
                <div class="p-6 border-b border-gray-100 flex items-center justify-between">

                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">
                            Daftar Pengguna
                        </h1>
                    </div>

                    <div>
                        <span class="bg-blue-100 text-blue-700 px-4 py-2 rounded-full text-sm font-semibold">
                            Total:
                            {{ $users->count() }} Pengguna
                        </span>
                    </div>

                </div>

                <!-- Table -->
                <div>

                    <table class="w-full table-auto text-sm text-left text-gray-600">

                        <thead class="bg-white-600 text-black uppercase text-xs tracking-wider">

                            <tr>

                                <th class="px-3 py-4">
                                    No
                                </th>

                                <th class="px-3 py-4">
                                    Nama
                                </th>

                                <th class="px-3 py-4">
                                    NIM
                                </th>

                                <th class="px-3 py-4">
                                    Program Studi
                                </th>

                                <th class="px-3 py-4">
                                    Email
                                </th>

                                <th class="px-3 py-4">
                                    Role
                                </th>

                                <th class="px-3 py-4">
                                    Tanggal Daftar
                                </th>

                                <th class="px-3 py-4 text-center">
                                    Aksi
                                </th>

                            </tr>

                        </thead>

                        <tbody>

                            @forelse ($users as $user)

                                <tr class="border-b hover:bg-blue-50 transition duration-200">

                                    <td class="px-3 py-4 font-medium text-gray-800">
                                        {{ $loop->iteration }}
                                    </td>

                                    <td class="px-3 py-4">
                                        {{ $user->name }}
                                    </td>

                                    <td class="px-3 py-4">
                                        {{ $user->nim }}
                                    </td>

                                    <td class="px-3 py-4">
                                        {{ $user->prodi }}
                                    </td>

                                    <td class="px-3 py-4">
                                        {{ $user->email }}
                                    </td>

                                    <td class="px-3 py-4">

                                        @foreach ($user->roles as $role)

                                            <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-semibold">
                                                {{ $role->name }}
                                            </span>

                                        @endforeach

                                    </td>

                                    <td class="px-3 py-4">
                                        {{ $user->created_at->translatedFormat('d F Y') }}
                                    </td>

                                    <td class="px-3 py-4">

                                        <form action="{{ route('users.role', $user->id) }}"
                                              method="POST">

                                            @csrf
                                            @method('PATCH')

                                            <div class="flex items-center gap-2">

                                                <select name="role"
                                                    class="rounded-lg border-gray-300 text-sm">

                                                    <option value="Mahasiswa">
                                                        Mahasiswa
                                                    </option>

                                                    <option value="Dosen">
                                                        Dosen
                                                    </option>

                                                    <option value="Admin">
                                                        Admin
                                                    </option>

                                                </select>

                                                <button
                                                    class="bg-blue-600 hover:bg-blue-500 text-white px-4 py-2 rounded-lg text-sm">

                                                    Simpan

                                                </button>

                                            </div>

                                        </form>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="8"
                                        class="text-center py-8 text-gray-400">

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

</x-app-layout>