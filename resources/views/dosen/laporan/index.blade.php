<x-app-layout>

    @if(session('success'))
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: '{{ session('success') }}',
            timer: 2500,
            showConfirmButton: false,
            toast: true,
            position: 'top-end',
            customClass: { popup: 'rounded-2xl' }
        });
    </script>
    @endif

    <div class="max-w-8xl mx-auto py-6">

        <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4 mb-6">
            <div>
                 <h1 class="text-3xl font-bold text-gray-800">Laporan Mahasiswa Bimbingan</h1>
                <p class="text-slate-500 mt-1">Rekapitulasi prestasi (SPK) mahasiswa yang berada di bawah bimbingan Anda.</p>
            </div>
            <div class="flex gap-2 w-full md:w-auto">
                <a href="{{ route('dosen.laporan.export', request()->query()) }}" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2.5 rounded-xl text-sm font-semibold transition-all flex items-center justify-center gap-2 w-full md:w-auto shadow-sm shadow-emerald-200">
                    <i class="fas fa-file-excel"></i> Export Excel
                </a>
                <a href="{{ route('dosen.laporan.export-pdf', request()->query()) }}" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2.5 rounded-xl text-sm font-semibold transition-all flex items-center justify-center gap-2 w-full md:w-auto shadow-sm shadow-red-200">
                    <i class="fas fa-file-pdf"></i> Export PDF
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 flex justify-between items-center group hover:-translate-y-1 transition-transform duration-300">
                <div>
                    <p class="text-slate-400 text-sm font-semibold mb-1 uppercase tracking-wider">Mhs Bimbingan</p>
                    <p class="text-3xl font-extrabold text-slate-800">{{ $totalBimbingan ?? 0 }}</p>
                </div>
                <div class="bg-blue-50 w-14 h-14 rounded-2xl flex items-center justify-center text-blue-500 text-xl">
                    <i class="fas fa-user-graduate"></i>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 flex justify-between items-center group hover:-translate-y-1 transition-transform duration-300">
                <div>
                    <p class="text-slate-400 text-sm font-semibold mb-1 uppercase tracking-wider">Prestasi Disetujui</p>
                    <p class="text-3xl font-extrabold text-emerald-600">{{ $totalDisetujui ?? 0 }}</p>
                </div>
                <div class="bg-emerald-50 w-14 h-14 rounded-2xl flex items-center justify-center text-emerald-500 text-xl">
                    <i class="fas fa-medal"></i>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 flex justify-between items-center group hover:-translate-y-1 transition-transform duration-300">
                <div>
                    <p class="text-slate-400 text-sm font-semibold mb-1 uppercase tracking-wider">Perlu Validasi</p>
                    <p class="text-3xl font-extrabold text-orange-500">{{ $totalMenunggu ?? 0 }}</p>
                </div>
                <div class="bg-orange-50 w-14 h-14 rounded-2xl flex items-center justify-center text-orange-500 text-xl">
                    <i class="fas fa-clock"></i>
                </div>
            </div>
        </div>

        <div class="bg-white shadow-xl shadow-slate-200/40 rounded-2xl border border-slate-100 overflow-hidden">
            
            <div class="p-5 bg-slate-50/50 border-b border-slate-100">
                <form method="GET" action="{{ route('dosen.laporan.index') }}" class="flex flex-col md:flex-row items-center gap-3">
                    
                    <div class="relative w-full md:w-72 flex-shrink-0">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Nama Mhs, NIM, Kegiatan..." class="w-full border border-slate-300 rounded-xl pl-10 pr-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition-shadow">
                        <i class="fas fa-search absolute left-3.5 top-3.5 text-slate-400"></i>
                    </div>

                    <select name="status" class="w-full md:w-48 border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 cursor-pointer transition-shadow">
                        <option value="">Semua Status SPK</option>
                        <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Menunggu Validasi</option>
                        <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                        <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>

                    <select name="tahun" class="w-full md:w-36 border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 cursor-pointer transition-shadow">
                        <option value="">Semua Tahun</option>
                        @for($i = date('Y'); $i >= date('Y') - 5; $i--)
                            <option value="{{ $i }}" {{ request('tahun') == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>

                    <div class="flex gap-2 w-full md:w-auto flex-shrink-0">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl text-sm font-semibold transition w-full md:w-auto whitespace-nowrap">
                            Filter
                        </button>
                        @if(request('search') || request('status') || request('tahun'))
                            <a href="{{ route('dosen.laporan.index') }}" class="bg-slate-200 hover:bg-slate-300 text-slate-700 px-5 py-2.5 rounded-xl text-sm font-semibold transition flex items-center justify-center w-full md:w-auto whitespace-nowrap">
                                Reset
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-slate-600">
                    <thead class="bg-slate-50 uppercase text-[11px] font-bold tracking-wider text-slate-500 border-b border-slate-200">
                        <tr>
                            <th class="px-6 py-4 text-center w-16">No</th>
                            <th class="px-6 py-4">Mahasiswa</th>
                            <th class="px-6 py-4">Nama Kegiatan</th>
                            <th class="px-6 py-4">Tingkat</th>
                            <th class="px-6 py-4 text-center">Poin</th>
                            <th class="px-6 py-4 text-center">Status</th>
                            <th class="px-6 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($laporan ?? [] as $item)
                        <tr class="hover:bg-blue-50/50 transition duration-200">
                            <td class="px-6 py-4 text-center font-medium text-slate-900">
                                {{ $loop->iteration + (($laporan->currentPage() - 1) * $laporan->perPage()) }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-bold text-slate-800">{{ $item->user->name ?? '-' }}</div>
                                <div class="text-xs text-slate-500 mt-0.5">{{ $item->user->nim ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4 font-medium text-slate-800">
                                {{ $item->kegiatan->kegiatan ?? '-' }}
                                <div class="text-xs text-slate-400 font-normal mt-0.5">{{ $item->penyelenggara ?? '-' }} ({{ $item->tahun }})</div>
                            </td>
                            <td class="px-6 py-4">
                                {{ $item->kegiatan->tingkat ?? '-' }}
                            </td>
                            <td class="px-6 py-4 text-center font-bold text-blue-600">
                                {{ $item->kegiatan->masterKegiatan->poin ?? 0 }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($item->status == 'disetujui')
                                    <span class="inline-flex items-center justify-center min-w-[90px] bg-emerald-100 text-emerald-700 px-3 py-1 rounded-full text-[11px] font-bold uppercase tracking-wide">
                                        Disetujui
                                    </span>
                                @elseif($item->status == 'ditolak')
                                    <span class="inline-flex items-center justify-center min-w-[90px] bg-red-100 text-red-700 px-3 py-1 rounded-full text-[11px] font-bold uppercase tracking-wide">
                                        Ditolak
                                    </span>
                                @else
                                    <span class="inline-flex items-center justify-center min-w-[90px] bg-orange-100 text-orange-700 px-3 py-1 rounded-full text-[11px] font-bold uppercase tracking-wide">
                                        Menunggu
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                <a href="{{ route('spks.show', $item->id) }}" class="inline-block bg-white border border-slate-200 text-slate-600 hover:bg-blue-50 hover:text-blue-600 hover:border-blue-200 px-3 py-1.5 rounded-lg text-xs font-semibold transition-all">
                                    <i class="fas fa-eye mr-1"></i> Detail
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-12">
                                <div class="flex flex-col items-center justify-center text-slate-400">
                                    <i class="fas fa-folder-open text-4xl mb-3 text-slate-300"></i>
                                    <p class="font-medium text-sm">Tidak ada data prestasi mahasiswa bimbingan.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if(isset($laporan) && $laporan->hasPages())
                <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
                    {{ $laporan->links() }}
                </div>
            @endif

        </div>

    </div>

</x-app-layout>