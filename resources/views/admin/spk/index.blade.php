<x-app-layout>
    <div class="max-w-8xl mx-auto py-6">

        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Manajemen Semua SPK</h1>
            <p class="text-gray-500 mt-1">Kelola Semua Satuan Prestasi Kemahasiswaan</p>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-50 border border-emerald-100 rounded-2xl flex items-start sm:items-center gap-3 shadow-sm shadow-emerald-500/5 animate-[fade-in-down_0.5s_ease-out]">
                <div class="bg-emerald-500 text-white rounded-full w-8 h-8 flex items-center justify-center shrink-0 shadow-sm mt-0.5 sm:mt-0">
                    <i class="fas fa-check"></i>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-emerald-800">Berhasil!</h4>
                    <p class="text-xs font-medium text-emerald-600 mt-0.5">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-5 sm:p-6 mb-8 relative overflow-hidden group">
            <div class="absolute right-0 top-0 w-32 h-32 bg-gradient-to-bl from-blue-50 to-transparent rounded-bl-full opacity-50 pointer-events-none"></div>

            <form method="GET" class="relative z-10 flex flex-col gap-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-slate-400 text-sm"></i>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Mhs, NIM, Kegiatan..."
                            class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl pl-10 pr-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors placeholder-slate-400 font-medium">
                    </div>

                    <select name="tahun" class="w-full bg-slate-50 border border-slate-200 text-slate-700 text-sm rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors font-medium cursor-pointer">
                        <option value="">Semua Tahun</option>
                        @foreach($tahunList as $tahun)
                            <option value="{{ $tahun }}" {{ request('tahun') == $tahun ? 'selected' : '' }}>{{ $tahun }}</option>
                        @endforeach
                    </select>

                    <select name="status" class="w-full bg-slate-50 border border-slate-200 text-slate-700 text-sm rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors font-medium cursor-pointer">
                        <option value="">Semua Status</option>
                        <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                        <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>

                    <div class="flex gap-2 h-full">
                        <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-bold transition-colors shadow-sm flex items-center justify-center gap-2">
                            <i class="fas fa-filter"></i> Terapkan
                        </button>
                        @if(request('search') || request('tahun') || request('status'))
                            <a href="{{ route('admin.spk.index') }}" class="px-4 bg-slate-200 hover:bg-slate-300 text-slate-700 rounded-xl text-sm font-bold flex items-center justify-center transition-colors tooltip" title="Reset Filter">
                                <i class="fas fa-redo-alt"></i> Reset
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>

        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left text-slate-600">
            <thead class="bg-slate-50/80 uppercase text-[10px] sm:text-[11px] font-extrabold tracking-wider text-slate-400 border-b border-slate-100">
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

    @if($spks->hasPages())
        <div class="px-6 py-4 bg-slate-50/50 border-t border-slate-100">
            {{ $spks->links() }}
        </div>
    @endif
</div>

    </div>

    <style>
        @keyframes fade-in-down {
            0% { opacity: 0; transform: translateY(-10px); }
            100% { opacity: 1; transform: translateY(0); }
        }
    </style>

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

                Swal.fire({
                    title: 'Memproses...',
                    text: 'Mengirim notifikasi email...',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    didOpen: () => Swal.showLoading()
                });

                let form = document.createElement('form');

                form.method = 'POST';
                form.action = '/admin/spk/' + id + '/approve';

                form.innerHTML = `
                    @csrf
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

                Swal.fire({
                    title: 'Memproses...',
                    text: 'Mengirim notifikasi email...',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    didOpen: () => Swal.showLoading()
                });

                let form = document.createElement('form');

                form.method = 'POST';
                form.action = '/admin/spk/' + id + '/reject';

                form.innerHTML = `
                    @csrf
                    <input type="hidden" name="catatan" value="${result.value}">
                `;

                document.body.appendChild(form);
                form.submit();
            }

        });
    }

    </script>
</x-app-layout>
