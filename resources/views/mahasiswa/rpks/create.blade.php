<x-app-layout>

<div class="py-6">

    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

        <div class="bg-white shadow-xl rounded-2xl p-8">

            <h1 class="text-2xl font-bold text-gray-800 mb-6">
                Tambah RPK
            </h1>

            <form action="{{ route('rpks.store') }}"
                  method="POST">

                @csrf

                <!-- Tahun -->
                <div class="mb-5">

                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Tahun
                    </label>

                    <input type="text"
                           name="tahun"
                           class="w-full border rounded-xl px-4 py-3 focus:ring focus:ring-blue-200"
                           placeholder="Contoh: 2025">

                </div>

                <!-- Semester -->
                <div class="mb-5">

                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Semester
                    </label>

                    <select name="semester"
                            class="w-full border rounded-xl px-4 py-3 focus:ring focus:ring-blue-200">

                        <option value="">Pilih Semester</option>
                        <option value="Ganjil">Ganjil</option>
                        <option value="Genap">Genap</option>

                    </select>

                </div>

                

                <!-- Tombol -->
                <div class="flex items-center gap-3">

                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-500 text-white px-6 py-3 rounded-xl font-semibold">

                        Simpan

                    </button>

                    <a href="{{ route('rpks.index') }}"
                       class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-3 rounded-xl font-semibold">

                        Kembali

                    </a>

                </div>

            </form>

        </div>

    </div>

</div>

</x-app-layout>