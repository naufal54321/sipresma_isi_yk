<x-app-layout>

<div class="max-w-4xl mx-auto py-6">

    <h1 class="text-2xl font-bold mb-6">
        Tambah SPK
    </h1>

    <form action="{{ route('spks.store') }}"
          method="POST"
          enctype="multipart/form-data">

        @csrf

        <!-- Tahun -->
        <div class="mb-4">
            <label class="font-semibold">Tahun *</label>

            <select name="tahun" class="w-full border rounded-lg p-2">
                @for($i = date('Y'); $i >= date('Y') - 8; $i--)
                    <option value="{{ $i }}">
                        {{ $i }}
                    </option>
                @endfor
            </select>
        </div>

        <!-- RPK -->
        <div class="mb-4">
            <label class="font-semibold">RPK *</label>

           <select name="rpk_id"
        id="rpk_id"
        class="w-full border rounded-lg p-2">

    <option value="">Pilih RPK</option>

    @foreach($rpks as $rpk)
        <option value="{{ $rpk->id }}">
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
        id="kegiatan_id"
        class="w-full border rounded-lg p-2">

    <option value="">
        Pilih RPK terlebih dahulu
    </option>

</select>
</div>

        <div class="mb-4">
    <label class="font-semibold">Tanggal Kegiatan *</label>
    <input type="date"
        name="tanggal_kegiatan"
        class="w-full border rounded-lg p-2"
        required>
</div>

<div class="mb-4">
    <label class="font-semibold">Penyelenggara *</label>
    <input type="text"
        name="penyelenggara"
        class="w-full border rounded-lg p-2"
        required>
</div>

<div class="mb-4">
    <label class="font-semibold">Kategori *</label>

    <select name="kategori"
        class="w-full border rounded-lg p-2"
        required>

        <option value="Individu">Individu</option>
        <option value="Kelompok">Kelompok</option>

    </select>
</div>

<div class="mb-4">
    <label class="font-semibold">URL Kegiatan</label>

    <input type="url"
        name="url_kegiatan"
        class="w-full border rounded-lg p-2">
</div>

<div class="mb-4">
    <label class="font-semibold">Bukti (PDF max 5MB) *</label>

    <input type="file"
        name="bukti"
        accept=".pdf"
        class="w-full border rounded-lg p-2"
        required>
</div>

<div class="mb-4">
    <label class="font-semibold">Keterangan *</label>

    <textarea name="keterangan"
        rows="4"
        class="w-full border rounded-lg p-2"
        required></textarea>
</div>

        <button type="submit"
            class="bg-blue-600 text-white px-4 py-2 rounded-lg">
            Simpan
        </button>

    </form>


    
</div>
<script>

const kegiatanData = @json($kegiatans);

document.getElementById('rpk_id').addEventListener('change', function () {

    let rpkId = this.value;
    let kegiatanSelect = document.getElementById('kegiatan_id');

    kegiatanSelect.innerHTML =
        '<option value="">Pilih Kegiatan</option>';

    kegiatanData.forEach(function(kegiatan){

        if(kegiatan.rpk_id == rpkId){

            kegiatanSelect.innerHTML += `
                <option value="${kegiatan.id}">
                    ${kegiatan.kegiatan}
                </option>
            `;
        }

    });

});

</script>


</x-app-layout>