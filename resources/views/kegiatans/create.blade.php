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
                <div class="mb-5">

                    <label class="block mb-2 font-semibold text-gray-700">
                        Nama Kegiatan
                    </label>

                    <input type="text"
                           name="kegiatan"
                           class="w-full border rounded-xl px-4 py-3">

                </div>

                <!-- Jenis -->
                <div class="mb-5">

                    <label class="block mb-2 font-semibold text-gray-700">
                        Jenis
                    </label>

                    <input type="text"
                           name="jenis"
                           class="w-full border rounded-xl px-4 py-3">

                </div>

                <!-- Tingkat -->
                <div class="mb-5">

                    <label class="block mb-2 font-semibold text-gray-700">
                        Tingkat
                    </label>

                    <select name="tingkat"
                            class="w-full border rounded-xl px-4 py-3">

                        <option value="">Pilih Tingkat</option>
                        <option value="Universitas">Universitas</option>
                        <option value="Regional">Regional</option>
                        <option value="Nasional">Nasional</option>
                        <option value="Internasional">Internasional</option>

                    </select>

                </div>

                <!-- Hasil -->
                <div class="mb-5">

                    <label class="block mb-2 font-semibold text-gray-700">
                        Hasil
                    </label>

                    <input type="text"
                           name="hasil"
                           class="w-full border rounded-xl px-4 py-3">

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

                <!-- Peran -->
                <div class="mb-5">

                    <label class="block mb-2 font-semibold text-gray-700">
                        Peran
                    </label>

                    <select name="peran"
                            id="peran"
                            class="w-full border rounded-xl px-4 py-3">

                        <option value="">Pilih Peran</option>
                        <option value="Ketua">Ketua</option>
                        <option value="Anggota">Anggota</option>

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

document.getElementById('peran')
.addEventListener('change', function(){

    let field =
        document.getElementById('jumlahAnggotaField');

    if(this.value === 'Ketua'){

        field.classList.remove('hidden');

    } else {

        field.classList.add('hidden');

    }

});

</script>

</x-app-layout>