<x-app-layout>

<div class="py-6">

    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

        <div class="bg-white shadow-xl rounded-2xl p-8">

            <h1 class="text-2xl font-bold text-gray-800 mb-6">
                Edit Kegiatan
            </h1>

            <form action="{{ route('kegiatans.update', $kegiatan->id) }}"
                  method="POST">

                @csrf
                @method('PUT')

                <!-- Kegiatan -->
                <div class="mb-4">

                    <label class="font-semibold">
                        Nama Kegiatan *
                    </label>

                    <select name="master_kegiatan_id"
                            id="master_kegiatan_id"
                            class="w-full border rounded-lg p-2">

                        @foreach($masterKegiatans as $item)

                        <option value="{{ $item->id }}"
                            {{ $kegiatan->master_kegiatan_id == $item->id ? 'selected' : '' }}

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
                    <input type="text"
                           id="jenis"
                           class="w-full border rounded-lg p-2"
                           value="{{ $kegiatan->jenis }}"
                           readonly>
                </div>

                <div class="mb-4">
                    <label>Tingkat</label>
                    <input type="text"
                           id="tingkat"
                           class="w-full border rounded-lg p-2"
                           value="{{ $kegiatan->tingkat }}"
                           readonly>
                </div>

                <div class="mb-4">
                    <label>Hasil</label>
                    <input type="text"
                           id="hasil"
                           class="w-full border rounded-lg p-2"
                           value="{{ $kegiatan->hasil }}"
                           readonly>
                </div>

                <div class="mb-4">
                    <label>Poin</label>
                    <input type="text"
                           id="poin"
                           class="w-full border rounded-lg p-2"
                           value="{{ $kegiatan->masterKegiatan->poin ?? '' }}"
                           readonly>
                </div>

                <!-- Tanggal -->
                <div class="mb-5">

                    <label class="block mb-2 font-semibold text-gray-700">
                        Tanggal
                    </label>

                    <input type="date"
                           name="tanggal"
                           value="{{ $kegiatan->tanggal }}"
                           class="w-full border rounded-xl px-4 py-3">

                </div>

                <!-- Peran -->
                <div class="mb-5">

                    <label class="block mb-2 font-semibold text-gray-700">
                        Peran
                    </label>

                    <select name="peran"
                            id="peran"
                            class="w-full border rounded-xl px-4 py-3">

                        <option value="Ketua"
                            {{ $kegiatan->peran == 'Ketua' ? 'selected' : '' }}>
                            Ketua
                        </option>

                        <option value="Anggota"
                            {{ $kegiatan->peran == 'Anggota' ? 'selected' : '' }}>
                            Anggota
                        </option>

                    </select>

                </div>

                <!-- Jumlah Anggota -->
                <div class="mb-6 {{ $kegiatan->peran == 'Ketua' ? '' : 'hidden' }}"
                     id="jumlahAnggotaField">

                    <label class="block mb-2 font-semibold text-gray-700">
                        Jumlah Anggota
                    </label>

                    <input type="number"
                           name="jumlah_anggota"
                           value="{{ $kegiatan->jumlah_anggota }}"
                           class="w-full border rounded-xl px-4 py-3">

                </div>

                <div class="flex items-center gap-3">

                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-500 text-white px-6 py-3 rounded-xl font-semibold">

                        Update

                    </button>

                    <a href="{{ route('kegiatans.index', $kegiatan->rpk_id) }}"
                       class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-3 rounded-xl font-semibold">

                        Kembali

                    </a>

                </div>

            </form>

        </div>

    </div>

</div>

<script>

document.getElementById('peran')
.addEventListener('change', function(){

    let field = document.getElementById('jumlahAnggotaField');

    if(this.value === 'Ketua'){
        field.classList.remove('hidden');
    } else {
        field.classList.add('hidden');
    }

});

document.getElementById('master_kegiatan_id')
.addEventListener('change', function(){

    let selected = this.options[this.selectedIndex];

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