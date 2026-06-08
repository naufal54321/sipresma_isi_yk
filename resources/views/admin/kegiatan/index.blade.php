<x-app-layout>

    @if(session('success'))

<script>
Swal.fire({
    icon: 'success',
    title: 'Berhasil',
    text: '{{ session('success') }}',
    timer: 2000,
    showConfirmButton: false
});
</script>

@endif

<div class="py-6">

     <div class="max-w-8xl mx-auto py-6">

        <!-- Header -->
        <div class="flex items-center justify-between mb-6">

            <div>
                <h1 class="text-3xl font-bold text-gray-800">
                    Master Kegiatan
                </h1>

                <p class="text-gray-500 mt-1">
                    Daftar kegiatan yang dapat dipilih mahasiswa
                </p>
            </div>

        </div>
<div class="bg-white shadow rounded-xl p-4 mb-4 flex items-center justify-between">

     

    <form method="GET"
          action="{{ route('admin.kegiatan.index') }}"
          class="relative">

        <input type="text"
               name="search"
               value="{{ request('search') }}"
               placeholder="Cari data..."
               class="w-72 border border-gray-300 rounded-xl pl-10 pr-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">

        <svg xmlns="http://www.w3.org/2000/svg"
             class="w-4 h-4 absolute left-3 top-3 text-gray-400"
             fill="none"
             viewBox="0 0 24 24"
             stroke="currentColor">

            <path stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M21 21l-4.35-4.35M11 18a7 7 0 100-14 7 7 0 000 14z"/>

        </svg>

    </form>

     <a href="{{ route('admin.kegiatan.create') }}"
       class="bg-blue-600 hover:bg-blue-500 text-white px-5 py-2 rounded-xl text-sm font-semibold transition">

        + Tambah Kegiatan

    </a>

</div>
        <!-- Table -->
        <div class="bg-white shadow-xl rounded-2xl overflow-hidden">

            <table class="w-full text-sm text-left text-gray-600">

                <thead class="bg-gray-50 uppercase text-xs tracking-wider">

                    <tr>
                        <th class="px-6 py-4 text-center">No</th>
                        <th class="px-6 py-4">Nama Kegiatan</th>
                        <th class="px-6 py-4">Jenis</th>
                        <th class="px-6 py-4">Tingkat</th>
                        <th class="px-6 py-4">Hasil</th>
                        <th class="px-4 py-4 text-center">Poin</th>
                        <th class="px-8 py-4 text-center">Status</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>

                </thead>

                <tbody>

                    @forelse($kegiatans as $kegiatan)

                    <tr class="border-b hover:bg-blue-50 transition">

                        <td class="px-6 py-4 text-center">
                            {{ $loop->iteration }}
                        </td>

                        <td class="px-6 py-4 font-medium text-gray-800">
                            {{ $kegiatan->nama_kegiatan }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $kegiatan->jenis }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $kegiatan->tingkat }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $kegiatan->hasil }}
                        </td>

                        <td class="px-4 py-4 text-center">
                                {{ $kegiatan->poin }}
                            </span>
                        </td>

                       <td class="px-6 py-4 text-center">

    @if($kegiatan->status == 'aktif')

        <span class="inline-block min-w-[90px] text-center bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">
            Aktif
        </span>

    @else

        <span class="inline-block min-w-[90px] text-center bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-semibold">
            Tidak Aktif
        </span>

    @endif

</td>

                        <td class="px-6 py-4 text-center">

                            <div class="flex justify-center gap-2">

                                <a href="{{ route('admin.kegiatan.edit', $kegiatan->id) }}"
                                   class="bg-yellow-500 hover:bg-yellow-400 text-white px-4 py-2 rounded-lg text-sm">

                                    Edit

                                </a>

                               <form action="{{ route('admin.kegiatan.destroy', $kegiatan->id) }}"
      method="POST"
      class="delete-form">

    @csrf
    @method('DELETE')

    <button type="button"
            onclick="hapusKegiatan(this)"
            class="bg-red-600 hover:bg-red-500 text-white px-4 py-2 rounded-lg text-sm">

        Hapus

    </button>

</form>

                            </div>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="8"
                            class="text-center py-10 text-gray-400">

                            Belum ada data kegiatan

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

        if(result.isConfirmed)
        {
            button.closest('form').submit();
        }

    });
}

</script>

</x-app-layout>