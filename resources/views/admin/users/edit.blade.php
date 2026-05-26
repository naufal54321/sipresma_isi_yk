<x-app-layout>

    <div class="max-w-4xl mx-auto">

        <div class="bg-white shadow-xl rounded-2xl overflow-hidden">

            <!-- Header -->
            <div class="bg-blue-600 px-8 py-6">

                <h1 class="text-3xl font-bold text-white">
                    Edit Pengguna
                </h1>

                <p class="text-blue-100 mt-1">
                    Perbarui data pengguna SIPRESMA
                </p>

            </div>

            <!-- Form -->
            <div class="p-8">

                <form action="{{ route('users.update', $user->id) }}"
                      method="POST">

                    @csrf
                    @method('PATCH')

                    <!-- Nama -->
                    <div class="mb-6">

                        <label class="block text-sm font-semibold text-gray-700 mb-2">

                            Nama Lengkap

                        </label>

                        <input type="text"
                               name="name"
                               value="{{ old('name', $user->name) }}"
                               class="w-full rounded-xl border-gray-300 focus:ring-blue-500 focus:border-blue-500">

                        @error('name')

                            <p class="text-red-500 text-sm mt-2">
                                {{ $message }}
                            </p>

                        @enderror

                    </div>

                    <!-- NIM -->
                    <div class="mb-6">

                        <label class="block text-sm font-semibold text-gray-700 mb-2">

                            NIM

                        </label>

                        <input type="text"
                               name="nim"
                               value="{{ old('nim', $user->nim) }}"
                               class="w-full rounded-xl border-gray-300 focus:ring-blue-500 focus:border-blue-500">

                        @error('nim')

                            <p class="text-red-500 text-sm mt-2">
                                {{ $message }}
                            </p>

                        @enderror

                    </div>

                    <!-- Prodi -->
                    <div class="mb-6">

                        <label class="block text-sm font-semibold text-gray-700 mb-2">

                            Program Studi

                        </label>

                        <input type="text"
                               name="prodi"
                               value="{{ old('prodi', $user->prodi) }}"
                               class="w-full rounded-xl border-gray-300 focus:ring-blue-500 focus:border-blue-500">

                        @error('prodi')

                            <p class="text-red-500 text-sm mt-2">
                                {{ $message }}
                            </p>

                        @enderror

                    </div>

                    <!-- Email -->
                    <div class="mb-8">

                        <label class="block text-sm font-semibold text-gray-700 mb-2">

                            Email

                        </label>

                        <input type="email"
                               name="email"
                               value="{{ old('email', $user->email) }}"
                               class="w-full rounded-xl border-gray-300 focus:ring-blue-500 focus:border-blue-500">

                        @error('email')

                            <p class="text-red-500 text-sm mt-2">
                                {{ $message }}
                            </p>

                        @enderror

                    </div>

<!-- Role -->
<div class="mb-8">

    <label class="block text-sm font-semibold text-gray-700 mb-2">

        Role Pengguna

    </label>

    <select name="role"
        class="w-full rounded-xl border-gray-300 focus:ring-blue-500 focus:border-blue-500">

        <option value="Mahasiswa"
            {{ $user->hasRole('Mahasiswa') ? 'selected' : '' }}>

            Mahasiswa

        </option>

        <option value="Dosen"
            {{ $user->hasRole('Dosen') ? 'selected' : '' }}>

            Dosen

        </option>

        <option value="Admin"
            {{ $user->hasRole('Admin') ? 'selected' : '' }}>

            Admin

        </option>

    </select>

</div>

                    <!-- Button -->
                    <div class="flex items-center gap-4">

                        <button
                            type="submit"
                            class="bg-blue-600 hover:bg-blue-500 text-white px-6 py-3 rounded-xl font-semibold transition">

                            Update Pengguna

                        </button>

                        <a href="{{ route('admin.dashboard') }}"
                           class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-3 rounded-xl font-semibold transition">

                            Kembali

                        </a>

                    </div>

                </form>

            </div>

        </div>

    </div>

</x-app-layout>