@forelse($prodis as $prodi)
<tr class="border-b hover:bg-blue-50 transition">
    <td class="px-6 py-4 text-center">
        {{ $prodis->firstItem() + $loop->index }}
    </td>
    <td class="px-6 py-4 font-medium text-gray-800">
        {{ $prodi->nama_prodi }}
    </td>
    <td class="px-6 py-4 text-center">
        @if($prodi->status == 'aktif')
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
            <button
                type="button"
                onclick="bukaModalEdit(this)"
                data-id="{{ $prodi->id }}"
                data-nama="{{ $prodi->nama_prodi }}"
                data-status="{{ $prodi->status }}"
                title="Edit Program Studi"
                class="flex items-center justify-center w-9 h-9 bg-yellow-500 hover:bg-yellow-400 text-white rounded-lg transition shadow-sm">
                <i class="fas fa-pen"></i>
            </button>

            <button
                type="button"
                onclick="hapusProdi({{ $prodi->id }}, '{{ addslashes($prodi->nama_prodi) }}')"
                title="Hapus Program Studi"
                class="flex items-center justify-center w-9 h-9 bg-red-600 hover:bg-red-500 text-white rounded-lg transition shadow-sm">
                <i class="fas fa-trash"></i>
            </button>
        </div>
    </td>
</tr>
@empty
<tr>
    <td colspan="4" class="text-center py-10 text-gray-400">
        Belum ada data Program Studi
    </td>
</tr>
@endforelse