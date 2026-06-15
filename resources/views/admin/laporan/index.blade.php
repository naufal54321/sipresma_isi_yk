<x-app-layout>

<div class="max-w-8xl mx-auto py-6">

    <h1 class="text-3xl font-bold mb-6">
        Laporan Prestasi Mahasiswa
    </h1>

    

        <div class="bg-white rounded-xl shadow p-4 mb-6">

    <form method="GET">
<div class="grid md:grid-cols-4 gap-4">

    <input
        type="text"
        name="nama"
        value="{{ request('nama') }}"
        placeholder="Cari Nama Mahasiswa"
        class="border rounded-lg p-2">

    <input
        type="text"
        name="tahun"
        value="{{ request('tahun') }}"
        placeholder="Tahun"
        class="border rounded-lg p-2">
<select name="prodi" class="border rounded-lg p-2">
    <option value="">Semua Program Studi</option>

    @foreach($prodis as $prodi)
        <option value="{{ $prodi->nama_prodi }}"
            {{ request('prodi') == $prodi->nama_prodi ? 'selected' : '' }}>
            {{ $prodi->nama_prodi }}
        </option>
    @endforeach
</select>

</div>
        <div class="mt-4 flex gap-2">

            <button
                class="bg-blue-600 text-white px-4 py-2 rounded-lg">
                Filter
            </button>

           <a href="{{ route('admin.laporan.export', request()->query()) }}"
   class="bg-green-600 text-white px-4 py-2 rounded-lg">
    Export CSV
</a>

 <a href="{{ route('admin.laporan.export-pdf', request()->query()) }}"
       class="bg-red-600 text-white px-4 py-2 rounded-lg">
        Export PDF
    </a>
        </div>

    </form>

</div>

    </div>

    <div class="bg-white rounded-xl shadow overflow-hidden">

        <table class="w-full">

           <thead class="bg-gray-100">
    <tr>
        <th class="p-3 text-left">Nama</th>
        <th class="p-3 text-left">NIM</th>
        <th class="p-3 text-left">Prodi</th>
        <th class="p-3 text-left">Kegiatan</th>
        <th class="p-3 text-left">Penyelenggara</th>
        <th class="p-3 text-left">Tingkat</th>
        <th class="p-3 text-left">Poin</th>
        <th class="p-3 text-left">Status</th>
        <th class="p-3 text-left">Tanggal</th>
    </tr>
</thead>

           <tbody>

@forelse($laporan as $item)


    <td class="p-3">
        {{ $item->user->name }}
    </td>

    <td class="p-3">
        {{ $item->user->nim }}
    </td>

    <td class="p-3">
        {{ $item->user->prodi }}
    </td>

    <td class="p-3">
        {{ $item->kegiatan->kegiatan ?? '-' }}
    </td>

    <td class="p-3">
        {{ $item->penyelenggara ?? '-' }}
    </td>

    <td class="p-3">
        {{ $item->kegiatan->tingkat ?? '-' }}
    </td>

    <td class="p-3 font-semibold">
        {{ $item->kegiatan->masterKegiatan->poin ?? 0 }}
    </td>

    <td class="p-3">

        @if($item->status == 'disetujui')
            <span class="bg-green-500 text-white px-3 py-1 rounded-full text-xs">
                Disetujui
            </span>
        @elseif($item->status == 'ditolak')
            <span class="bg-red-500 text-white px-3 py-1 rounded-full text-xs">
                Ditolak
            </span>
        @else
            <span class="bg-orange-500 text-white px-3 py-1 rounded-full text-xs">
                Draft
            </span>
        @endif

    </td>

    <td class="p-3">
        {{ $item->created_at->format('d-m-Y') }}
    </td>

</tr>

@empty

<tr>
    <td colspan="9" class="text-center py-6 text-gray-500">
        Tidak ada data laporan
    </td>
</tr>

@endforelse

</tbody>

        </table>

    </div>

    <div class="mt-4">
        {{ $laporan->links() }}
    </div>

</div>

</x-app-layout>