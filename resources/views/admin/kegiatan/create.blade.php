<x-app-layout>

<div class="max-w-4xl mx-auto py-6">

    <div class="bg-white rounded-xl shadow p-6">

        <h1 class="text-2xl font-bold mb-6">
            Tambah Master Kegiatan
        </h1>

        <form action="{{ route('admin.kegiatan.store') }}"
              method="POST">

            @csrf

            <!-- Nama Kegiatan -->
            <div class="mb-4">
                <label class="block font-semibold mb-1">
                    Nama Kegiatan <span class="text-red-500">*</span>
                </label>

                <input type="text"
                       name="nama_kegiatan"
                       class="w-full border rounded-lg p-3"
                       required>
            </div>

            <!-- Jenis -->
            <div class="mb-4">
                <label class="block font-semibold mb-1">
                    Jenis <span class="text-red-500">*</span>
                </label>

                <input type="text"
                       name="jenis"
                       class="w-full border rounded-lg p-3"
                       required>
            </div>

            <!-- Tingkat -->
            <div class="mb-4">
                <label class="block font-semibold mb-1">
                    Tingkat <span class="text-red-500">*</span>
                </label>

                <select name="tingkat"
                        class="w-full border rounded-lg p-3">

                    <option value="">Pilih Tingkat</option>
                    <option value="Universitas">Universitas</option>
                    <option value="Regional">Regional</option>
                    <option value="Nasional">Nasional</option>
                    <option value="Internasional">Internasional</option>

                </select>
            </div>

            <!-- Hasil -->
            <div class="mb-4">
                <label class="block font-semibold mb-1">
                    Hasil <span class="text-red-500">*</span>
                </label>

                <input type="text"
                       name="hasil"
                       class="w-full border rounded-lg p-3"
                       placeholder="Contoh: Juara/Sertifikat/Peserta"
                       required>
            </div>

            <!-- Poin -->
            <div class="mb-4">
                <label class="block font-semibold mb-1">
                    Poin <span class="text-red-500">*</span>
                </label>

                <input type="number"
                       name="poin"
                       min="0"
                       class="w-full border rounded-lg p-3"
                       required>
            </div>

            <!-- Status -->
            <div class="mb-6">
                <label class="block font-semibold mb-1">
                    Status Kegiatan <span class="text-red-500">*</span>
                </label>

                <select name="status"
                        class="w-full border rounded-lg p-3">

                    <option value="aktif">Aktif</option>
                    <option value="tidak aktif">Tidak Aktif</option>

                </select>
            </div>

            <div class="flex gap-3">

                <a href="{{ route('admin.kegiatan.index') }}"
                   class="bg-gray-500 text-white px-5 py-2 rounded-lg">

                    Kembali

                </a>

                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-500 text-white px-5 py-2 rounded-lg">

                    Simpan

                </button>

            </div>

        </form>

    </div>

</div>

</x-app-layout>