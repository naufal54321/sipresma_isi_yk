<x-app-layout>

    <div class="max-w-4xl mx-auto">

        <div class="bg-white shadow-xl rounded-2xl overflow-hidden">

            <div class="bg-blue-600 px-8 py-6">

                <h1 class="text-3xl font-bold text-white">
                    Tambah Pengguna
                </h1>

            </div>

            <div class="p-8">

                <form action="{{ route('users.store') }}"
                      method="POST">

                    @csrf

                    <div class="mb-5">

                        <label class="block mb-2 font-semibold">
                            Nama
                        </label>

                        <input type="text"
                               name="name"
                               class="w-full rounded-xl border-gray-300">

                    </div>

                    <div class="mb-5">

                        <label class="block mb-2 font-semibold">
                            NIM
                        </label>

                        <input type="text"
                               name="nim"
                               class="w-full rounded-xl border-gray-300">

                    </div>

                    <div class="mb-5">

                        <label class="block mb-2 font-semibold">
                            Program Studi
                        </label>

                        <input type="text"
                               name="prodi"
                               class="w-full rounded-xl border-gray-300">

                    </div>

                    <div class="mb-5">

                        <label class="block mb-2 font-semibold">
                            Email
                        </label>

                        <input type="email"
                               name="email"
                               class="w-full rounded-xl border-gray-300">

                    </div>

                    <div class="mb-5">

                        <label class="block mb-2 font-semibold">
                            Password
                        </label>

                        <input type="password"
                               name="password"
                               class="w-full rounded-xl border-gray-300">

                    </div>

                    <div class="mb-8">

                        <label class="block mb-2 font-semibold">
                            Role
                        </label>

                        <select name="role"
                            class="w-full rounded-xl border-gray-300">

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

                    </div>

                    <div class="flex items-center gap-3">

                        <button
                            type="submit"
                            class="bg-blue-600 hover:bg-blue-500 text-white px-6 py-3 rounded-xl font-semibold">

                            Simpan Pengguna

                        </button>

                        <a href="{{ route('admin.dashboard') }}"
                           class="bg-gray-200 hover:bg-gray-300 px-6 py-3 rounded-xl font-semibold">

                            Kembali

                        </a>

                    </div>

                </form>

            </div>

        </div>

    </div>

</x-app-layout>