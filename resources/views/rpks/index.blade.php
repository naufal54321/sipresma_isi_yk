<x-app-layout>

<div class="py-6">

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        <div class="flex items-center justify-between mb-6">

            <div>
                <h1 class="text-3xl font-bold text-gray-800">
                    RPK Mahasiswa
                </h1>

                <p class="text-gray-500 mt-1">
                    Rencana Prestasi Kemahasiswaan
                </p>
            </div>

            <button onclick="bukaModalTambahRPK()"
                    class="bg-blue-600 hover:bg-blue-500 text-white px-5 py-2 rounded-xl text-sm font-semibold transition cursor-pointer">
                + Tambah RPK
            </button>

        </div>

        <div class="bg-white shadow-xl rounded-2xl overflow-hidden">

            <table class="w-full text-sm text-left text-gray-600">

                <thead class="bg-gray-50 uppercase text-xs tracking-wider">
                    <tr>
                        <th class="px-6 py-4">No</th>
                        <th class="px-6 py-4">Tahun</th>
                        <th class="px-6 py-4">Semester</th>
                        <th class="px-6 py-4">Jumlah Kegiatan</th>
                        <th class="px-6 py-4">Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse ($rpks as $rpk)

                    <tr class="border-b hover:bg-blue-50 transition">

                        <td class="px-6 py-4">
                            {{ $loop->iteration }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $rpk->tahun }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $rpk->semester }}
                        </td>

                        <td class="px-6 py-4">
                            <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-semibold">
                                {{ $rpk->kegiatans_count }} Kegiatan
                            </span>
                        </td>

                        <td class="px-6 py-4">

                            <div class="flex items-center gap-2">

                                <a href="{{ route('rpks.show', $rpk->id) }}"
                                   class="bg-blue-600 hover:bg-blue-500 text-white px-4 py-2 rounded-lg text-sm transition">
                                    Detail
                                </a>
                                
                                <form action="{{ route('rpks.destroy', $rpk->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                        onclick="return confirm('Yakin ingin menghapus data ini?')"
                                        class="bg-red-500 hover:bg-red-400 text-white px-4 py-2 rounded-lg text-sm transition">
                                        Hapus
                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                    @empty

                    <tr>
                        <td colspan="5" class="text-center py-10 text-gray-400 font-medium">
                            Belum ada data RPK
                        </td>
                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function bukaModalTambahRPK() {
        Swal.fire({
            title: '<h2 class="text-2xl font-bold text-gray-800 text-left">Tambah RPK</h2>',
            html: `
                <form id="formTambahRPK" action="{{ route('rpks.store') }}" method="POST" class="text-left mt-4">
                    @csrf
                    
                    <div class="mb-5">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Tahun</label>
                        <input type="text" 
                               name="tahun" 
                               id="inputTahun"
                               class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring focus:ring-blue-200 focus:border-blue-500 outline-none" 
                               placeholder="Contoh: {{ date('Y') }}"
                               required>
                    </div>

                    <div class="mb-5">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Semester</label>
                        <select name="semester" 
                                id="inputSemester"
                                class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring focus:ring-blue-200 focus:border-blue-500 outline-none"
                                required>
                            <option value="">Pilih Semester</option>
                            <option value="Ganjil">Ganjil</option>
                            <option value="Genap">Genap</option>
                        </select>
                    </div>
                </form>
            `,
            showCancelButton: true,
            confirmButtonText: 'Simpan',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#2563EB', // Warna bg-blue-600
            cancelButtonColor: '#9CA3AF',  // Warna bg-gray-400
            customClass: {
                popup: 'rounded-2xl p-4'
            },
            preConfirm: () => {
                const tahun = document.getElementById('inputTahun').value;
                const semester = document.getElementById('inputSemester').value;

                if (!tahun || !semester) {
                    Swal.showValidationMessage('Harap lengkapi Tahun dan Semester!');
                    return false;
                }

                // Submit form otomatis
                document.getElementById('formTambahRPK').submit();
            }
        });
    }
</script>

</x-app-layout>