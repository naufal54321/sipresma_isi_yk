<x-app-layout>

<div class="py-6">

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        <!-- Header -->
       <div class="flex items-center justify-between mb-6">


<div>
    <h1 class="text-3xl font-bold text-gray-800">
        Detail RPK
    </h1>

    <p class="text-gray-500 mt-1">
        Daftar kegiatan pada RPK
    </p>
</div>

<div class="flex gap-3">

    <a href="{{ route('rpks.index') }}"
       class="bg-gray-500 hover:bg-gray-400 text-white px-5 py-2 rounded-xl text-sm font-semibold transition">

        ← Kembali

    </a>

    <a href="{{ route('kegiatans.create', $rpk->id) }}"
       class="bg-blue-600 hover:bg-blue-500 text-white px-5 py-2 rounded-xl text-sm font-semibold transition">

        + Tambah Kegiatan

    </a>

</div>


</div>


        <!-- Info RPK -->
        <div class="bg-white shadow rounded-2xl p-6 mb-6">

            <div class="grid grid-cols-3 gap-6">

                <div>
                    <p class="text-sm text-gray-500">
                        Tahun
                    </p>

                    <h1 class="text-lg font-bold text-gray-800">
                        {{ $rpk->tahun }}
                    </h1>
                </div>

                <div>
                    <p class="text-sm text-gray-500">
                        Semester
                    </p>

                    <h1 class="text-lg font-bold text-gray-800">
                        {{ $rpk->semester }}
                    </h1>
                </div>

                <div>
                    <p class="text-sm text-gray-500">
                        Kategori
                    </p>

                    <h1 class="text-lg font-bold text-gray-800">
                        {{ $rpk->kategori }}
                    </h1>
                </div>

            </div>

        </div>

        <!-- Table Kegiatan -->
        <div class="bg-white shadow-xl rounded-2xl overflow-hidden">

            <table class="w-full text-sm text-left text-gray-600">

                <thead class="bg-gray-50 uppercase text-xs tracking-wider">

                    <tr>
                        <th class="px-6 py-4">No</th>
                        <th class="px-6 py-4">Kegiatan</th>
                        <th class="px-6 py-4">Jenis</th>
                        <th class="px-6 py-4">Tingkat</th>
                        <th class="px-6 py-4">Peran</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Catatan Dosen</th>
                        <th class="px-6 py-4 text-center">Poin</th>
                         <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>

                </thead>

                <tbody>

                    @forelse($rpk->kegiatans as $kegiatan)

                    <tr class="border-b hover:bg-blue-50 transition">

                        <td class="px-6 py-4">
                            {{ $loop->iteration }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $kegiatan->kegiatan }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $kegiatan->jenis }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $kegiatan->tingkat }}
                        </td>

                        <td class="px-6 py-4">

                            @if($kegiatan->peran == 'Ketua')

                                <span>
                                    Ketua
                                </span>

                            @else

                                <span>
                                    Anggota
                                </span>

                            @endif

                        </td>

                        <td class="px-6 py-4">

                            @if($kegiatan->status == 'draft')

                                <span class="bg-yellow-500 text-white px-3 py-1 rounded-full text-xs">
                                    Draft
                                </span>

                            @elseif($kegiatan->status == 'disetujui')

                                <span class="bg-green-500 text-white px-3 py-1 rounded-full text-xs">
                                    Disetujui
                                </span>

                            @else

                                <span class="bg-red-500 text-white px-3 py-1 rounded-full text-xs">
                                    Ditolak
                                </span>

                            @endif

                        </td>

                        <td class="px-6 py-4">
    @if($kegiatan->catatan_dosen)

        <span class="text-gray-700">
            {{ $kegiatan->catatan_dosen }}
        </span>

    @else

        <span class="text-gray-400 italic">
            Belum ada catatan
        </span>

    @endif
</td>
<td class="px-6 py-4 text-center">
    {{ $kegiatan->masterKegiatan->poin ?? '-' }}
</td>


<td class="px-6 py-4 text-center">

    @if($kegiatan->status == 'draft' || $kegiatan->status == 'ditolak')

    

    <div class="flex justify-center gap-2">

        <a href="{{ route('kegiatans.edit', $kegiatan->id) }}"
           class="bg-yellow-500 hover:bg-yellow-400 text-white px-3 py-2 rounded-lg text-sm">

            Edit

        </a>

        <form action="{{ route('kegiatans.destroy', $kegiatan->id) }}"
              method="POST">

            @csrf
            @method('DELETE')

            <button type="button"
                    onclick="hapusKegiatan(this)"
                    class="bg-red-600 hover:bg-red-500 text-white px-3 py-2 rounded-lg text-sm">

                Hapus

            </button>

        </form>

    </div>

    @else

    <span class="text-gray-400">
        Selesai
    </span>

    @endif

</td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="8"
                            class="text-center py-10 text-gray-400">

                            Belum ada kegiatan

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

<script>

function hapusKegiatan(button)
{
    Swal.fire({
        title: 'Hapus Kegiatan?',
        text: 'Data yang dihapus tidak dapat dikembalikan.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Ya, Hapus',
        cancelButtonText: 'Batal'
    }).then((result) => {

        if (result.isConfirmed) {
            button.closest('form').submit();
        }

    });
}

</script>

</x-app-layout>