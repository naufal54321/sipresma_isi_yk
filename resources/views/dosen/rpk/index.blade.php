<x-app-layout>

@if(session('success'))
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800">
                Validasi RPK
            </h1>

            <p class="text-gray-500 mt-1">
                Persetujuan Rencana Prestasi Kemahasiswaan
            </p>
        </div>

        <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-200 mb-6">
            <form method="GET" action="{{ route('dosen.rpk.index') }}" class="flex flex-col md:flex-row gap-4 items-end">
                
                <div class="w-full md:w-64 relative">
                    <label class="block text-xs font-semibold text-gray-500 mb-1 uppercase tracking-wider">Cari Data</label>
                    <input type="text"
                           name="search"
                           value="{{ request('search') }}"
                           placeholder="Nama, NIM, atau Prodi..."
                           class="w-full border border-gray-300 rounded-lg pl-10 pr-4 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 absolute left-3 top-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M11 18a7 7 0 100-14 7 7 0 000 14z"/>
                    </svg>
                </div>

                <div class="w-full md:w-32">
                    <label class="block text-xs font-semibold text-gray-500 mb-1 uppercase tracking-wider">Tahun</label>
                    <select name="tahun" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none transition bg-white">
                        <option value="">Semua</option>
                        @for($i = date('Y'); $i >= 2020; $i--)
                            <option value="{{ $i }}" {{ request('tahun') == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                </div>

                <div class="w-full md:w-32">
                    <label class="block text-xs font-semibold text-gray-500 mb-1 uppercase tracking-wider">Semester</label>
                    <select name="semester" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none transition bg-white">
                        <option value="">Semua</option>
                        <option value="Ganjil" {{ request('semester') == 'Ganjil' ? 'selected' : '' }}>Ganjil</option>
                        <option value="Genap" {{ request('semester') == 'Genap' ? 'selected' : '' }}>Genap</option>
                    </select>
                </div>

                <div class="w-full md:w-40">
                    <label class="block text-xs font-semibold text-gray-500 mb-1 uppercase tracking-wider">Status</label>
                    <select name="status" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none transition bg-white">
                        <option value="">Semua Status</option>
                        <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                        <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>

                <div class="flex gap-2 w-full md:w-auto">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-500 text-white px-5 py-2 rounded-lg text-sm font-semibold transition w-full md:w-auto">
                        Cari
                    </button>
                    @if(request('search') || request('tahun') || request('semester') || request('status'))
                        <a href="{{ route('dosen.rpk.index') }}" class="bg-gray-100 hover:bg-gray-200 border border-gray-300 text-gray-700 px-4 py-2 rounded-lg text-sm font-semibold transition text-center flex items-center justify-center">
                            Reset
                        </a>
                    @endif
                </div>

            </form>
        </div>
        <div class="bg-white shadow-xl rounded-2xl overflow-hidden">

            <table class="w-full text-sm text-left text-gray-600">

                <thead class="bg-gray-50 uppercase text-xs tracking-wider">
                    <tr>
                        <th class="px-3 py-4 text-center">No</th>
                        <th class="px-4 py-4">Mahasiswa</th>
                        <th class="px-4 py-4">NIM</th>
                        <th class="px-4 py-4">Prodi</th>
                        <th class="px-4 py-4">Tahun</th>
                        <th class="px-4 py-4">Semester</th>
                        <th class="px-4 py-4">Kategori</th>
                        <th class="px-4 py-4">Jumlah Kegiatan</th>
                        <th class="px-4 py-4">Status</th>
                        <th class="px-5 py-4 text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($rpks as $rpk)

                    <tr class="border-b hover:bg-blue-50 transition">

                        <td class="px-3 py-4 text-center">
                            {{ $loop->iteration }}
                        </td>

                        <td class="px-4 py-4 font-medium text-gray-800">
                            {{ $rpk->user->name }}
                        </td>

                        <td class="px-4 py-4">
                            {{ $rpk->user->nim }}
                        </td>

                        <td class="px-4 py-4">
                            {{ $rpk->user->prodi }}
                        </td>

                        <td class="px-4 py-4">
                            {{ $rpk->tahun }}
                        </td>

                        <td class="px-4 py-4">
                            {{ $rpk->semester }}
                        </td>

                        <td class="px-4 py-4">
                            {{ $rpk->kategori }}
                        </td>

                        <td class="px-4 py-4">
                            {{ $rpk->kegiatans->count() }}
                        </td>

                        <td class="px-4 py-4">

                            @if($rpk->status == 'draft')

                                <span class="bg-orange-500 text-white px-3 py-1 rounded-full text-xs">
                                    Draft
                                </span>

                            @elseif($rpk->status == 'disetujui')

                                <span class="bg-green-500 text-white px-3 py-1 rounded-full text-xs">
                                    Disetujui
                                </span>

                            @elseif($rpk->status == 'ditolak')

                                <span class="bg-red-500 text-white px-3 py-1 rounded-full text-xs">
                                    Ditolak
                                </span>

                            @else

                                <span class="bg-gray-500 text-white px-3 py-1 rounded-full text-xs">
                                    -
                                </span>

                            @endif

                        </td>

                        <td class="px-5 py-4">

                            <div class="flex items-center gap-2">
                                <a href="{{ route('dosen.rpk.show', $rpk->id) }}"
                                   class="bg-blue-600 hover:bg-blue-500 text-white px-4 py-2 rounded-lg text-sm">
                                    Detail
                                </a>
                            </div>

                        </td>

                    </tr>

                    @empty

                    <tr>
                        <td colspan="10" class="text-center py-10 text-gray-400">
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
// Tetap biarkan fungsi approveRpk dan rejectRpk bawaan Anda di sini
function approveRpk(id)
{
    Swal.fire({
        title: 'Alasan RPK Disetujui',
        input: 'textarea',
        inputLabel: 'Catatan Dosen',
        inputPlaceholder: 'Masukkan alasan RPK disetujui...',
        showCancelButton: true,
        confirmButtonText: 'Setujui',
        confirmButtonColor: '#16a34a',

        inputValidator: (value) => {
            if (!value) {
                return 'Alasan wajib diisi';
            }
        }

    }).then((result) => {
        if(result.isConfirmed){
            let form = document.createElement('form');
            form.method = 'POST';
            form.action = '/dosen/rpk/' + id + '/approve';

            form.innerHTML = `
                @csrf
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="catatan_dosen" value="${result.value}">
            `;

            document.body.appendChild(form);
            form.submit();
        }
    });
}

function rejectRpk(id)
{
    Swal.fire({
        title: 'Alasan RPK Ditolak',
        input: 'textarea',
        inputLabel: 'Catatan Dosen',
        inputPlaceholder: 'Masukkan alasan RPK ditolak...',
        showCancelButton: true,
        confirmButtonText: 'Tolak',
        confirmButtonColor: '#dc2626',

        inputValidator: (value) => {
            if (!value) {
                return 'Alasan wajib diisi';
            }
        }

    }).then((result) => {
        if(result.isConfirmed){
            let form = document.createElement('form');
            form.method = 'POST';
            form.action = '/dosen/rpk/' + id + '/reject';

            form.innerHTML = `
                @csrf
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="catatan_dosen" value="${result.value}">
            `;

            document.body.appendChild(form);
            form.submit();
        }
    });
}
</script>

</x-app-layout>