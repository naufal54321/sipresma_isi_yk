<x-app-layout>

<div class="py-6">

   <div class="max-w-8xl mx-auto py-6">

        <div class="flex flex-col md:flex-row md:items-center justify-between mb-6 gap-4">

            <div>
                <h1 class="text-3xl font-bold text-gray-800">
                    RPK
                </h1>
                <p class="text-gray-500 mt-1">
                    Rencana Prestasi Kemahasiswaan
                </p>
            </div>

           {{-- ✅ Semua mahasiswa bisa tambah RPK --}}
                <button onclick="bukaModalTambahRPK()"
                class="bg-blue-600 hover:bg-blue-500 text-white px-5 py-2 rounded-lg text-sm font-semibold transition cursor-pointer">
                    + Tambah RPK
                </button>

        </div>

        

        <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 mb-6">
            <form method="GET" action="{{ route('rpks.index') }}" class="flex flex-col md:flex-row gap-4 items-end">
                
                <div class="w-full md:w-48">
                    <label class="block text-xs font-semibold text-gray-500 mb-1 uppercase tracking-wider">Tahun</label>
                    <select name="tahun" class="w-full border-gray-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Semua Tahun</option>
                        @php
                            $tahunSekarang = date('Y');
                            $tahunAwal = 2020;
                        @endphp
                        @for($i = $tahunSekarang; $i >= $tahunAwal; $i--)
                            <option value="{{ $i }}" {{ request('tahun') == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                </div>

                <div class="w-full md:w-48">
                    <label class="block text-xs font-semibold text-gray-500 mb-1 uppercase tracking-wider">Semester</label>
                    <select name="semester" class="w-full border-gray-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Semua Semester</option>
                        <option value="Ganjil" {{ request('semester') == 'Ganjil' ? 'selected' : '' }}>Ganjil</option>
                        <option value="Genap" {{ request('semester') == 'Genap' ? 'selected' : '' }}>Genap</option>
                    </select>
                </div>

                <div class="w-full md:w-48">
                    <label class="block text-xs font-semibold text-gray-500 mb-1 uppercase tracking-wider">Status</label>
                    <select name="status" class="w-full border-gray-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Semua Status</option>
                        <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="diajukan" {{ request('status') == 'diajukan' ? 'selected' : '' }}>Diajukan</option>
                        <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                        <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>

                <div class="flex gap-2 w-full md:w-auto">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-400 text-white px-5 py-2 rounded-lg text-sm font-semibold transition w-full md:w-auto">
                        Terapkan Filter
                    </button>
                    @if(request('tahun') || request('semester') || request('status'))
                        <a href="{{ route('rpks.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg text-sm font-semibold transition text-center whitespace-nowrap">
                            Reset
                        </a>
                    @endif
                </div>

            </form>
        </div>

        <div class="bg-white shadow-sm border border-gray-200 rounded-2xl overflow-hidden">

            <table class="w-full text-sm text-left text-gray-600">

                <thead class="bg-gray-50 uppercase text-xs tracking-wider border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4">No</th>
                        <th class="px-6 py-4">Pemilik</th> {{-- 🔧 KOLOM BARU --}}
                        <th class="px-6 py-4">NIM</th>
                        <th class="px-6 py-4">Prodi</th>
                        <th class="px-6 py-4">Tahun</th>
                        <th class="px-6 py-4">Semester</th>
                        <th class="px-6 py-4">Jumlah Kegiatan</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">

                    @forelse ($rpks as $rpk)

                    <tr class="hover:bg-blue-50 transition duration-200">

                        <td class="px-6 py-4 font-medium text-gray-900">
                            {{ $loop->iteration }}
                        </td>


                        {{-- 🔧 KOLOM PEMILIK --}}
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <span class="font-medium text-gray-800">{{ $rpk->user->name ?? '-' }}</span>
                                @if($rpk->user_id == Auth::id())
                                @endif
                            </div>
                        </td>

                        <td class="px-4 py-4">
                            {{ $rpk->user->nim }}
                        </td>

                        <td class="px-4 py-4">
                            {{ $rpk->user->prodi }}
                        </td>

                        <td class="px-6 py-4 font-semibold text-gray-800">
                            {{ $rpk->tahun }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $rpk->semester }}
                        </td>

                        <td class="px-6 py-4">
                            @php
                                if($rpk->user_id == Auth::id()) {
                                    $jumlahKegiatan = $rpk->kegiatans->count();
                                } else {
                                    $jumlahKegiatan = $rpk->kegiatans->filter(function($k) {
                                        return $k->anggota->contains('id', Auth::id());
                                    })->count();
                                }
                            @endphp
                            {{ $jumlahKegiatan }} Kegiatan
                        </td>
                        
                        <td class="px-6 py-4">
                            @if($rpk->status == 'draft')
                                <span class="bg-orange-500 text-white px-3 py-1 rounded-full text-xs font-semibold">
                                    Draft
                                </span>
                            @elseif($rpk->status == 'diajukan')
                                <span class="bg-blue-500 text-white px-3 py-1 rounded-full text-xs font-semibold">
                                    Diajukan
                                </span>
                            @elseif($rpk->status == 'disetujui')
                                <span class="bg-green-500 text-white px-3 py-1 rounded-full text-xs font-semibold">
                                    Disetujui
                                </span>
                            @elseif($rpk->status == 'ditolak')
                                <span class="bg-red-500 text-white px-3 py-1 rounded-full text-xs font-semibold">
                                    Ditolak
                                </span>
                            @endif
                        </td>


                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center gap-2">

                                <a href="{{ route('rpks.show', $rpk->id) }}" title="Detail RPK"
                                class="flex items-center justify-center w-9 h-9 bg-gray-400 text-white hover:bg-gray-500 border border-gray-200 rounded-lg transition shadow-sm">
                                    <i class="fas fa-eye"></i>
                                </a>

                                {{-- 🔧 Tombol edit & hapus hanya untuk pemilik --}}
                                @if($rpk->user_id == Auth::id() && in_array($rpk->status, ['draft', 'ditolak']))

                                    <form action="{{ route('rpks.destroy', $rpk->id) }}" method="POST" class="m-0">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button"
                                                onclick="konfirmasiHapus(this)"
                                                title="Hapus RPK"
                                                class="flex items-center justify-center w-9 h-9 bg-red-500 text-white hover:bg-red-600 rounded-lg transition shadow-sm">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                @endif

                            </div>
                        </td>

                    </tr>

                    @empty

                    <tr>
                        <td colspan="8" class="text-center py-12 text-gray-400 font-medium">
                            <i class="fas fa-folder-open text-3xl mb-3 text-gray-300 block"></i>
                            Belum ada data RPK yang ditemukan.
                        </td>
                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('success'))
<script>
Swal.fire({
    icon: 'success',
    title: 'Berhasil',
    text: '{{ session("success") }}',
    timer: 2500,
    showConfirmButton: false,
    toast: true,
    position: 'top-end'
});
</script>
@endif

@if($errors->any())
<script>
    Swal.fire({
        icon: 'error',
        title: 'Gagal Menyimpan!',
        html: `
            <ul style="text-align: left; color: #dc2626; font-size: 14px;">
                @foreach ($errors->all() as $error)
                    <li>- {{ $error }}</li>
                @endforeach
            </ul>
        `,
    });
</script>
@endif

<script>
    function konfirmasiHapus(button) {
        Swal.fire({
            title: 'Hapus RPK?',
            text: "Data yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                button.closest('form').submit();
            }
        });
    }

    function bukaModalTambahRPK() {
        Swal.fire({
            title: '<h2 class="text-2xl font-bold text-gray-800 text-left">Tambah RPK</h2>',
            html: `
                <form id="formTambahRPK" action="{{ route('rpks.store') }}" method="POST" class="text-left mt-4">
                    @csrf
                    
                    <div class="mb-5">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Tahun</label>
                        <input type="number" 
                               name="tahun" 
                               id="inputTahun"
                               class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring focus:ring-blue-200 focus:border-blue-500 outline-none" 
                               placeholder="Contoh: {{ date('Y') }}"
                               value="{{ date('Y') }}"
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
            confirmButtonColor: '#2563EB',
            cancelButtonColor: '#9CA3AF',
            allowOutsideClick: false,
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

                document.getElementById('formTambahRPK').submit();
            }
        });
    }
</script>

</x-app-layout>