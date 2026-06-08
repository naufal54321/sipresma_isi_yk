<x-app-layout>

<div class="max-w-4xl mx-auto py-6">

```
<div class="bg-white rounded-xl shadow p-6">

    <h1 class="text-2xl font-bold mb-6">
        Edit Master Kegiatan
    </h1>

    <form action="{{ route('admin.kegiatan.update', $kegiatan->id) }}"
          method="POST">

        @csrf
        @method('PUT')

        <!-- Nama Kegiatan -->
        <div class="mb-4">
            <label class="block font-semibold mb-1">
                Nama Kegiatan <span class="text-red-500">*</span>
            </label>

            <input type="text"
                   name="nama_kegiatan"
                   value="{{ old('nama_kegiatan', $kegiatan->nama_kegiatan) }}"
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
                   value="{{ old('jenis', $kegiatan->jenis) }}"
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

                <option value="Universitas"
                    {{ $kegiatan->tingkat == 'Universitas' ? 'selected' : '' }}>
                    Universitas
                </option>

                <option value="Regional"
                    {{ $kegiatan->tingkat == 'Regional' ? 'selected' : '' }}>
                    Regional
                </option>

                <option value="Nasional"
                    {{ $kegiatan->tingkat == 'Nasional' ? 'selected' : '' }}>
                    Nasional
                </option>

                <option value="Internasional"
                    {{ $kegiatan->tingkat == 'Internasional' ? 'selected' : '' }}>
                    Internasional
                </option>

            </select>
        </div>

        <!-- Hasil -->
        <div class="mb-4">
            <label class="block font-semibold mb-1">
                Hasil <span class="text-red-500">*</span>
            </label>

            <input type="text"
                   name="hasil"
                   value="{{ old('hasil', $kegiatan->hasil) }}"
                   class="w-full border rounded-lg p-3"
                   placeholder="Contoh: Juara 1"
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
                   value="{{ old('poin', $kegiatan->poin) }}"
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

                <option value="aktif"
                    {{ $kegiatan->status == 'aktif' ? 'selected' : '' }}>
                    Aktif
                </option>

                <option value="tidak aktif"
                    {{ $kegiatan->status == 'tidak aktif' ? 'selected' : '' }}>
                    Tidak Aktif
                </option>

            </select>
        </div>

        <div class="flex gap-3">

            <a href="{{ route('admin.kegiatan.index') }}"
               class="bg-gray-500 hover:bg-gray-400 text-white px-5 py-2 rounded-lg">

                Kembali

            </a>

            <button type="submit"
                    class="bg-yellow-600 hover:bg-yellow-500 text-white px-5 py-2 rounded-lg">

                Update

            </button>

        </div>

    </form>

</div>
```

</div>

</x-app-layout>
