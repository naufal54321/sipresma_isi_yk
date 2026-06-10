<x-app-layout>

<div class="py-6">

    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

        <div class="bg-white shadow-xl rounded-2xl p-8">

            <h1 class="text-2xl font-bold text-gray-800 mb-6">
                Tambah Kegiatan
            </h1>

            <form action="{{ route('kegiatans.store', $rpk->id) }}"
                  method="POST">

                @csrf

                <!-- Kegiatan -->
                <div class="mb-4">

    <label class="font-semibold">
        Nama Kegiatan *
    </label>

    <select name="master_kegiatan_id"
            id="master_kegiatan_id"
            class="w-full border rounded-lg p-2">

        <option value="">
            Pilih Kegiatan
        </option>

        @foreach($masterKegiatans as $item)

        <option value="{{ $item->id }}"
                data-jenis="{{ $item->jenis }}"
                data-tingkat="{{ $item->tingkat }}"
                data-hasil="{{ $item->hasil }}"
                data-poin="{{ $item->poin }}">

            {{ $item->nama_kegiatan }}

        </option>

        @endforeach

    </select>

</div>

<div class="mb-4">
    <label>Jenis</label>
    <input type="text" id="jenis" name="jenis"
           class="w-full border rounded-lg p-2" readonly>
</div>

<div class="mb-4">
    <label>Tingkat</label>
    <input type="text" id="tingkat" name="tingkat"
           class="w-full border rounded-lg p-2" readonly>
</div>

<div class="mb-4">
    <label>Hasil</label>
    <input type="text" id="hasil" name="hasil"
           class="w-full border rounded-lg p-2" readonly>
</div>

<div class="mb-4">
    <label>Poin</label>
    <input type="text" id="poin"
           class="w-full border rounded-lg p-2" readonly>
</div>

                <!-- Tanggal -->
                <div class="mb-5">

                    <label class="block mb-2 font-semibold text-gray-700">
                        Tanggal
                    </label>

                    <input type="date"
                           name="tanggal"
                           class="w-full border rounded-xl px-4 py-3">

                </div>

                <!-- Kategori -->
<div class="mb-5">

    <label class="block mb-2 font-semibold text-gray-700">
        Kategori
    </label>

    <select name="kategori"
            id="kategori"
            class="w-full border rounded-xl px-4 py-3">

        <option value="">
            Pilih Kategori
        </option>

        <option value="Individu">
            Individu
        </option>

        <option value="Kelompok">
            Kelompok
        </option>

    </select>

</div>

               <!-- Peran -->
<div class="mb-5 hidden"
     id="peranField">

    <label class="block mb-2 font-semibold text-gray-700">
        Peran
    </label>

    <select name="peran"
            id="peran"
            class="w-full border rounded-xl px-4 py-3">

        <option value="">
            Pilih Peran
        </option>

        <option value="Ketua">
            Ketua
        </option>

        <option value="Anggota">
            Anggota
        </option>

    </select>

</div>

                <!-- Jumlah Anggota -->
               <div class="mb-6 hidden"
     id="jumlahAnggotaField">

    <label class="block mb-2 font-semibold text-gray-700">
        Jumlah Anggota
    </label>

    <input type="number"
           name="jumlah_anggota"
           min="1"
           class="w-full border rounded-xl px-4 py-3">

</div>

                <!-- Tombol -->
                <div class="flex items-center gap-3">

                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-500 text-white px-6 py-3 rounded-xl font-semibold">

                        Simpan

                    </button>

                    <a href="{{ route('kegiatans.index', $rpk->id) }}"
                       class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-3 rounded-xl font-semibold">

                        Kembali

                    </a>

                </div>

            </form>

        </div>

    </div>

</div>

<script>

const kategori =
    document.getElementById('kategori');

const peran =
    document.getElementById('peran');

const peranField =
    document.getElementById('peranField');

const jumlahAnggotaField =
    document.getElementById('jumlahAnggotaField');

kategori.addEventListener('change', function(){

    if(this.value === 'Kelompok'){

        peranField.classList.remove('hidden');

    } else {

        peranField.classList.add('hidden');
        jumlahAnggotaField.classList.add('hidden');

        peran.value = '';

    }

});

peran.addEventListener('change', function(){

    if(this.value === 'Ketua'){

        jumlahAnggotaField.classList.remove('hidden');

    } else {

        jumlahAnggotaField.classList.add('hidden');

    }

});

document.getElementById('master_kegiatan_id')
.addEventListener('change', function(){

    let selected =
        this.options[this.selectedIndex];

    document.getElementById('jenis').value =
        selected.dataset.jenis || '';

    document.getElementById('tingkat').value =
        selected.dataset.tingkat || '';

    document.getElementById('hasil').value =
        selected.dataset.hasil || '';

    document.getElementById('poin').value =
        selected.dataset.poin || '';

});


document.getElementById('master_kegiatan_id')
.addEventListener('change', function() {

    let selected =
        this.options[this.selectedIndex];

    document.getElementById('jenis').value =
        selected.dataset.jenis || '';

    document.getElementById('tingkat').value =
        selected.dataset.tingkat || '';

    document.getElementById('hasil').value =
        selected.dataset.hasil || '';

    document.getElementById('poin').value =
        selected.dataset.poin || '';
});
</script>

</x-app-layout>