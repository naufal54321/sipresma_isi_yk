<x-app-layout>

<div class="max-w-4xl mx-auto py-6">

    <h1 class="text-2xl font-bold mb-6">
        Edit SPK
    </h1>

    @if($spk->catatan_dosen)
    <div class="bg-red-50 border border-red-200 text-red-700 p-4 rounded-lg mb-6">
        <strong>Catatan Dosen:</strong><br>
        {{ $spk->catatan_dosen }}
    </div>
    @endif

    <form action="{{ route('spks.update', $spk->id) }}"
          method="POST"
          enctype="multipart/form-data">

        @csrf
        @method('PUT')

        <!-- Tahun -->
        <div class="mb-4">
            <label class="font-semibold">Tahun *</label>

            <select name="tahun" class="w-full border rounded-lg p-2">
                @for($i = date('Y'); $i >= date('Y') - 8; $i--)
                    <option value="{{ $i }}"
                        {{ $spk->tahun == $i ? 'selected' : '' }}>
                        {{ $i }}
                    </option>
                @endfor
            </select>
        </div>

        <!-- RPK -->
        <div class="mb-4">
            <label class="font-semibold">RPK *</label>

            <select name="rpk_id" class="w-full border rounded-lg p-2">

                @foreach($rpks as $rpk)

                    <option value="{{ $rpk->id }}"
                        {{ $spk->rpk_id == $rpk->id ? 'selected' : '' }}>

                        {{ $rpk->tahun }} - {{ $rpk->semester }}

                    </option>

                @endforeach

            </select>
        </div>

        <!-- Kegiatan -->
        <div class="mb-4">

            <label class="font-semibold">
                Kegiatan *
            </label>

            <select name="kegiatan_id"
                    class="w-full border rounded-lg p-2">

                <option value="">
                    Pilih Kegiatan
                </option>

                @foreach($kegiatans as $kegiatan)

                    <option value="{{ $kegiatan->id }}"
                        {{ $spk->kegiatan_id == $kegiatan->id ? 'selected' : '' }}>

                        {{ $kegiatan->kegiatan }}

                    </option>

                @endforeach

            </select>

        </div>

        <!-- Tanggal -->
        <div class="mb-4">

            <label class="font-semibold">
                Tanggal Kegiatan *
            </label>

            <input type="date"
                   name="tanggal_kegiatan"
                   value="{{ $spk->tanggal_kegiatan }}"
                   class="w-full border rounded-lg p-2"
                   required>

        </div>

        <!-- Penyelenggara -->
        <div class="mb-4">

            <label class="font-semibold">
                Penyelenggara *
            </label>

            <input type="text"
                   name="penyelenggara"
                   value="{{ $spk->penyelenggara }}"
                   class="w-full border rounded-lg p-2"
                   required>

        </div>

        <!-- Kategori -->
        <div class="mb-4">

            <label class="font-semibold">
                Kategori *
            </label>

            <select name="kategori"
                    class="w-full border rounded-lg p-2"
                    required>

                <option value="Individu"
                    {{ $spk->kategori == 'Individu' ? 'selected' : '' }}>
                    Individu
                </option>

                <option value="Kelompok"
                    {{ $spk->kategori == 'Kelompok' ? 'selected' : '' }}>
                    Kelompok
                </option>

            </select>

        </div>

        <!-- URL -->
        <div class="mb-4">

            <label class="font-semibold">
                URL Kegiatan
            </label>

            <input type="url"
                   name="url_kegiatan"
                   value="{{ $spk->url_kegiatan }}"
                   class="w-full border rounded-lg p-2">

        </div>

        <!-- Bukti -->
        <div class="mb-4">

            <label class="font-semibold">
                Bukti (PDF max 5MB)
            </label>

            @if($spk->bukti)

                <div class="mb-2">

                    <a href="{{ asset('storage/'.$spk->bukti) }}"
                       target="_blank"
                       class="text-blue-600 underline">

                        Lihat Bukti Saat Ini

                    </a>

                </div>

            @endif

            <input type="file"
                   name="bukti"
                   accept=".pdf"
                   class="w-full border rounded-lg p-2">

            <small class="text-gray-500">
                Kosongkan jika tidak ingin mengganti file.
            </small>

        </div>

        <!-- Keterangan -->
        <div class="mb-4">

            <label class="font-semibold">
                Keterangan *
            </label>

            <textarea name="keterangan"
                      rows="4"
                      class="w-full border rounded-lg p-2"
                      required>{{ $spk->keterangan }}</textarea>

        </div>

        <button type="submit"
                class="bg-blue-600 hover:bg-blue-500 text-white px-5 py-2 rounded-lg">

            Simpan Perubahan

        </button>

    </form>

</div>

</x-app-layout>