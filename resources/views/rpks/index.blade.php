<x-app-layout>

<div class="py-6">

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        <!-- Header -->
        <div class="flex items-center justify-between mb-6">

            <div>
                <h1 class="text-3xl font-bold text-gray-800">
                    RPK Mahasiswa
                </h1>

                <p class="text-gray-500 mt-1">
                    Rencana Prestasi Kemahasiswaan
                </p>
            </div>

            <a href="{{ route('rpks.create') }}"
               class="bg-blue-600 hover:bg-blue-500 text-white px-5 py-2 rounded-xl text-sm font-semibold transition">

                + Tambah RPK

            </a>

        </div>

        <!-- Card -->
        <div class="bg-white shadow-xl rounded-2xl overflow-hidden">

            <table class="w-full text-sm text-left text-gray-600">

                <thead class="bg-gray-50 uppercase text-xs tracking-wider">

    <tr>
        <th class="px-6 py-4">No</th>
        <th class="px-6 py-4">Tahun</th>
        <th class="px-6 py-4">Semester</th>
        <th class="px-6 py-4">Kategori</th>
        <th class="px-6 py-4">Jumlah Kegiatan</th>
        <th class="px-6 py-4 text-center">Aksi</th>
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

                            @if($rpk->kategori == 'Individu')

                                <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs">
                                    Individu
                                </span>

                            @else

                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs">
                                    Kelompok
                                </span>

                            @endif

                        </td>
                        <td class="px-6 py-4">

    <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs">

        {{ $rpk->kegiatans_count }} Kegiatan

    </span>

</td>

                        <td class="px-6 py-4">

                            <div class="flex items-center gap-2">

                               <a href="{{ route('rpks.show', $rpk->id) }}"
   class="bg-blue-600 hover:bg-blue-500 text-white px-4 py-2 rounded-lg text-sm">

    Detail

</a>

                                
                                <form action="{{ route('rpks.destroy', $rpk->id) }}"
                                      method="POST">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                        onclick="return confirm('Yakin hapus?')"
                                        class="bg-red-500 hover:bg-red-400 text-white px-4 py-2 rounded-lg text-sm">

                                        Hapus

                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="5"
                            class="text-center py-10 text-gray-400">

                            Belum ada data RPK

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

</x-app-layout>