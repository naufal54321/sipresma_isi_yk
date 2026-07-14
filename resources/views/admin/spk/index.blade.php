<x-app-layout>

<div class="py-6">

    <div class="max-w-8xl mx-auto py-6">

        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800">
                Manajemen Semua SPK
            </h1>
            <p class="text-gray-500 mt-1">
                Kelola Semua Satuan Prestasi Kemahasiswaan
            </p>
        </div>

        {{-- Filter --}}
        <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-200 mb-6">
            <form method="GET" action="{{ route('admin.spk.index') }}" class="flex flex-col md:flex-row gap-4 items-end">
                
                <div class="w-full md:w-64 relative">
                    <label class="block text-xs font-semibold text-gray-500 mb-1 uppercase tracking-wider">Cari Data</label>
                    <input type="text"
                           name="search"
                           value="{{ request('search') }}"
                           placeholder="Nama, NIM, atau Kegiatan..."
                           class="w-full border border-gray-300 rounded-lg pl-10 pr-4 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 absolute left-3 top-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M11 18a7 7 0 100-14 7 7 0 000 14z"/>
                    </svg>
                </div>

                <div class="w-full md:w-32">
                    <label class="block text-xs font-semibold text-gray-500 mb-1 uppercase tracking-wider">Tahun</label>
                    <select name="tahun" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none transition bg-white">
                        <option value="">Semua</option>
                        @foreach($tahunList as $tahun)
                            <option value="{{ $tahun }}" {{ request('tahun') == $tahun ? 'selected' : '' }}>{{ $tahun }}</option>
                        @endforeach
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
                    <button type="submit" class="bg-blue-600 hover:bg-blue-500 text-white px-5 py-2.5 rounded-xl text-sm font-semibold transition w-full md:w-auto">
                        Cari
                    </button>
                    @if(request('search') || request('tahun') || request('status'))
                        <a href="{{ route('admin.spk.index') }}" class="bg-white border border-slate-300 hover:bg-slate-100 text-slate-700 px-5 py-2.5 rounded-xl text-sm font-semibold transition text-center flex items-center justify-center">
                            Reset
                        </a>
                    @endif
                </div>

            </form>
        </div>

    {{-- Tabel SPK --}}
<div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left text-slate-600">
            <thead class="bg-slate-50/80 uppercase text-xs font-extrabold tracking-wider text-slate-400 border-b border-slate-100">
                <tr>
                    <th class="px-2 py-3 text-center w-8">No</th>
                    <th class="px-2 py-3 w-[14%]">Mahasiswa</th>
                    <th class="px-2 py-3 w-[10%]">NIM</th>
                    <th class="px-2 py-3 w-[10%]">Prodi</th>
                    <th class="px-2 py-3 text-center w-[6%]">Tahun</th>
                    <th class="px-2 py-3 w-[8%]">RPK</th>
                    <th class="px-2 py-3 w-[15%]">Judul Kegiatan</th>
                    <th class="px-2 py-3 text-center w-[8%]">Kategori</th>
                    <th class="px-2 py-3 text-center w-[7%]">Poin</th>
                    <th class="px-2 py-3 text-center w-[8%]">Status</th>
                    <th class="px-2 py-3 text-center w-10">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($spks as $index => $spk)
                <tr class="hover:bg-blue-50/30 transition-colors group">
                    
                    {{-- No --}}
                    <td class="px-2 py-3 text-center font-bold text-black">
                        {{ $spks->firstItem() + $index }}
                    </td>

                    {{-- Mahasiswa --}}
                    <td class="px-2 py-3">
                        <p class="font-bold text-slate-800 group-hover:text-blue-600 transition-colors">
                            {{ $spk->user->name ?? '-' }}
                        </p>
                    </td>

                    {{-- NIM --}}
                    <td class="px-2 py-3 font-semibold text-black">
                        {{ $spk->user->nim ?? '-' }}
                    </td>

                    {{-- Prodi --}}
                    <td class="px-2 py-3 font-semibold text-black">
                        {{ $spk->user->prodi ?? '-' }}
                    </td>

                    {{-- Tahun --}}
                    <td class="px-2 py-3 text-center font-semibold text-black">
                        {{ $spk->tahun }}
                    </td>

                    {{-- RPK --}}
                    <td class="px-2 py-3 font-semibold text-black">
                        {{ $spk->rpk->tahun ?? '-' }}/{{ $spk->rpk->semester ?? '-' }}
                    </td>

                    {{-- Judul Kegiatan --}}
                    <td class="px-2 py-3">
                        <p class="font-semibold text-slate-700 leading-relaxed">
                            {{ $spk->judul_kegiatan ?? $spk->kegiatan->judul_kegiatan ?? '-' }}
                        </p>
                    </td>

                    {{-- Kategori --}}
                    <td class="px-2 py-3 text-center">
                        @if($spk->kategori == 'Kelompok')
                            <span class="inline-block bg-purple-100 text-purple-700 px-1.5 py-0.5 rounded-full text-xs font-semibold">
                                Kelompok
                            </span>
                        @else
                            <span class="inline-block bg-gray-100 text-gray-600 px-1.5 py-0.5 rounded-full text-xs font-semibold">
                                Individu
                            </span>
                        @endif
                    </td>

                    {{-- Poin --}}
                    <td class="px-2 py-3 text-center">
                        @if($spk->status === 'disetujui' && $spk->hasPoin())
                            <span class="px-6 py-4 text-center font-bold text-blue-600">
                                {{ $spk->poin }}
                            </span>
                        @elseif($spk->status === 'disetujui' && !$spk->hasPoin())
                            <span class="text-slate-400 text-xs">Belum</span>
                        @else
                            <span class="text-slate-300 text-xs">-</span>
                        @endif
                    </td>

                    {{-- Status --}}
                    <td class="px-2 py-3 text-center">
                        @if($spk->status == 'draft')
                            <span class="inline-block bg-orange-500 text-white px-1.5 py-0.5 rounded-full text-xs">
                                Draft
                            </span>
                        @elseif($spk->status == 'disetujui')
                            <span class="inline-block bg-green-500 text-white px-1.5 py-0.5 rounded-full text-xs">
                                Disetujui
                            </span>
                        @else
                            <span class="inline-block bg-red-500 text-white px-1.5 py-0.5 rounded-full text-xs">
                                Ditolak
                            </span>
                        @endif
                    </td>

                    {{-- Aksi --}}
                    <td class="px-2 py-3 text-center">
                        <a href="{{ route('admin.spk.show', $spk->id) }}"
                           title="Detail SPK"
                           class="inline-flex items-center justify-center w-8 h-8 bg-gray-400 text-white hover:bg-gray-500 border border-gray-200 rounded-lg transition shadow-sm">
                            <i class="fas fa-eye text-xs"></i>
                        </a>
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="11" class="text-center py-16">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-50 text-slate-300 mb-4">
                            <i class="fas fa-folder-open text-3xl"></i>
                        </div>
                        <h3 class="text-sm font-bold text-slate-700">Tidak Ada SPK</h3>
                        <p class="text-xs text-slate-400 mt-1">Belum ada data SPK yang sesuai dengan filter pencarian Anda.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if($spks->hasPages())
        <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
            {{ $spks->links() }}
        </div>
    @endif
</div>

            
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>

function hapusSpk(button) {
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
        if (result.isConfirmed) {
            button.closest('form').submit();
        }
    });
}

function approveSpk(id)
{
    Swal.fire({
        title: 'Setujui SPK (Admin)',
        input: 'textarea',
        inputLabel: 'Catatan Admin',
        inputPlaceholder: 'Masukkan catatan persetujuan...',
        showCancelButton: true,
        confirmButtonText: 'Setujui',
        confirmButtonColor: '#16a34a',
        cancelButtonText: 'Batal'

    }).then((result) => {

        if(result.isConfirmed){

            let form = document.createElement('form');

            form.method = 'POST';
            form.action = '/admin/spk/' + id + '/approve';

            form.innerHTML = `
                @csrf
                <input type="hidden" name="_method" value="PATCH">
                <input type="hidden" name="catatan" value="${result.value || ''}">
            `;

            document.body.appendChild(form);
            form.submit();
        }

    });
}

function rejectSpk(id)
{
    Swal.fire({
        title: 'Tolak SPK (Admin)',
        input: 'textarea',
        inputLabel: 'Alasan Penolakan',
        inputPlaceholder: 'Masukkan alasan penolakan...',
        showCancelButton: true,
        confirmButtonText: 'Tolak',
        confirmButtonColor: '#dc2626',
        cancelButtonText: 'Batal',

        inputValidator: (value) => {
            if (!value) {
                return 'Alasan wajib diisi';
            }
        }

    }).then((result) => {

        if(result.isConfirmed){

            let form = document.createElement('form');

            form.method = 'POST';
            form.action = '/admin/spk/' + id + '/reject';

            form.innerHTML = `
                @csrf
                <input type="hidden" name="_method" value="PATCH">
                <input type="hidden" name="catatan" value="${result.value}">
            `;

            document.body.appendChild(form);
            form.submit();
        }

    });
}

</script>

@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: '{{ session("success") }}',
        timer: 3000,
        showConfirmButton: false,
        toast: true,
        position: 'top-end'
    });
</script>
@endif

</x-app-layout>