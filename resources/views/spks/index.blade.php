<x-app-layout>

<div class="py-6">

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        <div class="flex items-center justify-between mb-6">

            <div>
                <h1 class="text-3xl font-bold text-gray-800">
                    Data SPK
                </h1>

                <p class="text-gray-500">
                    Surat Pengajuan Kegiatan
                </p>
            </div>

            <a href="{{ route('spks.create') }}"
               class="bg-blue-600 hover:bg-blue-500 text-white px-5 py-2 rounded-xl text-sm font-semibold">

                + Tambah SPK

            </a>

        </div>

        <div class="bg-white shadow-xl rounded-2xl overflow-hidden">

            <table class="w-full text-sm text-left text-gray-600">

                <thead class="bg-gray-50 uppercase text-xs tracking-wider">

                    <tr>
                        <th class="px-6 py-4 text-center">No</th>
                        <th class="px-6 py-4">Tahun</th>
                        <th class="px-6 py-4">RPK</th>
                        <th class="px-6 py-4">Kegiatan</th>
                        <th class="px-6 py-4">Jenis</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4">Catatan Dosen</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>

                </thead>

                <tbody>

                    @forelse($spks as $spk)

                    <tr class="border-b hover:bg-blue-50 transition">

                        <td class="px-6 py-4 text-center">
                            {{ $loop->iteration }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $spk->tahun }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $spk->rpk->tahun ?? '-' }}
                            -
                            {{ $spk->rpk->semester ?? '-' }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $spk->kegiatan->kegiatan ?? '-' }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $spk->kegiatan->jenis ?? '-' }}
                        </td>

                        <td class="px-6 py-4 text-center">

                            @if($spk->status == 'draft')

                                <span class="bg-yellow-500 text-white px-3 py-1 rounded-full text-xs font-semibold">
                                    Draft
                                </span>

                            @elseif($spk->status == 'disetujui')

                                <span class="bg-green-500 text-white px-3 py-1 rounded-full text-xs font-semibold">
                                    Disetujui
                                </span>

                            @else

                                <span class="bg-red-500 text-white px-3 py-1 rounded-full text-xs font-semibold">
                                    Ditolak
                                </span>

                            @endif

                        </td>

                        

                        <td class="px-6 py-4">
                            {{ $spk->catatan_dosen ?? '-' }}
                        </td>

                        <td class="px-6 py-4 text-center">

    <div class="flex justify-center gap-2">

        @if($spk->status == 'ditolak')

            <a href="{{ route('spks.edit', $spk->id) }}"
               class="bg-yellow-500 hover:bg-yellow-400 text-white px-4 py-2 rounded-lg">

                Edit

            </a>

        @endif

        @if(in_array($spk->status, ['draft', 'ditolak']))

            <form action="{{ route('spks.destroy', $spk->id) }}"
                  method="POST"
                  class="delete-form">

                @csrf
                @method('DELETE')

                <button type="button"
                        onclick="hapusSpk(this)"
                        class="bg-red-600 hover:bg-red-500 text-white px-4 py-2 rounded-lg">

                    Hapus

                </button>

            </form>

        @endif

        @if($spk->status == 'disetujui')

            <span class="text-gray-400">-</span>

        @endif

    </div>

</td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="6"
                            class="text-center py-10 text-gray-400">

                            Belum ada data SPK

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

<script>

function hapusSpk(button)
{
    Swal.fire({
        title: 'Hapus SPK?',
        text: 'Data yang dihapus tidak dapat dikembalikan.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Ya, Hapus',
        cancelButtonText: 'Batal'
    }).then((result) => {

        if(result.isConfirmed){
            button.closest('form').submit();
        }

    });
}

</script>

</x-app-layout>