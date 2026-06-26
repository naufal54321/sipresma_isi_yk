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
                <h1 class="text-3xl font-bold text-gray-800">Laporan Prestasi Mahasiswa</h1>
                <p class="text-slate-500 mt-1">Rekapitulasi seluruh data prestasi (SPK) mahasiswa di dalam sistem.</p>
            </div>
            <div class="flex gap-2 w-full md:w-auto">
                <a href="{{ route('admin.laporan.export', request()->query()) }}" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2.5 rounded-xl text-sm font-semibold transition-all flex items-center justify-center gap-2 w-full md:w-auto shadow-sm shadow-emerald-200">
                    <i class="fas fa-file-excel"></i> Export Excel
                </a>
                <a href="{{ route('admin.laporan.export-pdf', request()->query()) }}" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2.5 rounded-xl text-sm font-semibold transition-all flex items-center justify-center gap-2 w-full md:w-auto shadow-sm shadow-red-200">
                    <i class="fas fa-file-pdf"></i> Export PDF
                </a>
            </div>
        </div>

        {{-- Statistik Cards --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
                <p class="text-xs text-gray-500 uppercase tracking-wider">Total Mahasiswa</p>
                <p class="text-2xl font-bold text-blue-600">{{ $totalMahasiswa }}</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
                <p class="text-xs text-gray-500 uppercase tracking-wider">Total Dosen</p>
                <p class="text-2xl font-bold text-indigo-600">{{ $totalDosen }}</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
                <p class="text-xs text-gray-500 uppercase tracking-wider">Total SPK</p>
                <p class="text-2xl font-bold text-orange-500">{{ $totalSpk }}</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
                <p class="text-xs text-gray-500 uppercase tracking-wider">Total Disetujui</p>
                <p class="text-2xl font-bold text-green-600">{{ $totalPrestasi }}</p>
            </div>
        </div>

        <div class="bg-white shadow-xl shadow-slate-200/40 rounded-2xl border border-slate-100 overflow-hidden">
            
            <div class="p-5 bg-slate-50/50 border-b border-slate-100">
                <form method="GET" action="{{ route('admin.laporan.index') }}" class="w-full">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
                        
                        <div class="relative w-full">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Nama, NIM, Kegiatan..." class="w-full border border-slate-300 rounded-xl pl-10 pr-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition-shadow">
                            <i class="fas fa-search absolute left-3.5 top-3.5 text-slate-400"></i>
                        </div>

                        <select name="tahun" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 cursor-pointer transition-shadow text-slate-600">
                            <option value="">Semua Tahun</option>
                            @for($i = date('Y'); $i >= date('Y') - 5; $i--)
                                <option value="{{ $i }}" {{ request('tahun') == $i ? 'selected' : '' }}>Tahun {{ $i }}</option>
                            @endfor
                        </select>

                        <select name="prodi" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 cursor-pointer transition-shadow text-slate-600">
                            <option value="">Semua Program Studi</option>
                            @foreach($prodis as $p)
                                <option value="{{ $p->nama_prodi }}" {{ request('prodi') == $p->nama_prodi ? 'selected' : '' }}>
                                    {{ $p->nama_prodi }}
                                </option>
                            @endforeach
                        </select>

                        {{-- 🔧 TINGKAT DARI DATABASE --}}
                        <select name="tingkat" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 cursor-pointer transition-shadow text-slate-600">
                            <option value="">Semua Tingkat</option>
                            @foreach($tingkatList as $tingkat)
                                <option value="{{ $tingkat }}" {{ request('tingkat') == $tingkat ? 'selected' : '' }}>
                                    {{ $tingkat }}
                                </option>
                            @endforeach
                        </select>

                    </div>

                    <div class="flex justify-end gap-2 w-full">
                        @if(request('search') || request('tahun') || request('prodi') || request('tingkat'))
                            <a href="{{ route('admin.laporan.index') }}" class="bg-slate-200 hover:bg-slate-300 text-slate-700 px-5 py-2.5 rounded-xl text-sm font-semibold transition flex items-center justify-center gap-2 whitespace-nowrap w-full md:w-auto">
                                <i class="fas fa-sync-alt"></i> Reset
                            </a>
                        @endif
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-xl text-sm font-semibold transition flex items-center justify-center gap-2 whitespace-nowrap w-full md:w-auto shadow-sm shadow-blue-200">
                            <i class="fas fa-filter"></i> Terapkan Filter
                        </button>
                    </div>

                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-slate-600">
                    <thead class="bg-slate-50 uppercase text-[11px] font-bold tracking-wider text-slate-500 border-b border-slate-200">
                        <tr>
                            <th class="px-6 py-4 text-center w-12">No</th>
                            <th class="px-6 py-4">Mahasiswa</th>
                            <th class="px-6 py-4">NIM</th>
                            <th class="px-6 py-4">Prodi</th>
                            <th class="px-6 py-4">Judul Kegiatan</th>
                            <th class="px-6 py-4">Nama Kegiatan</th>
                            <th class="px-6 py-4">Tingkat</th>
                            <th class="px-6 py-4">Hasil</th>
                            <th class="px-6 py-4 text-center">Poin</th>
                            <th class="px-6 py-4 text-center">Tgl Kegiatan</th>
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
                            </td>
                            <td class="px-6 py-4 text-slate-700">{{ $item->user->nim ?? '-' }}</td>
                            <td class="px-6 py-4 text-slate-700">{{ $item->user->prodi ?? '-' }}</td>
                            {{-- 🔧 JUDUL KEGIATAN --}}
                            <td class="px-6 py-4 font-medium text-slate-800">
                                {{ $item->judul_kegiatan ?? $item->kegiatan->judul_kegiatan ?? $item->kegiatan->kegiatan ?? '-' }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $item->kegiatan->kegiatan ?? '-' }}
                                <div class="text-xs text-slate-400 font-normal mt-0.5">{{ $item->penyelenggara ?? '-' }} ({{ $item->tahun }})</div>
                            </td>
                            {{-- 🔧 TINGKAT DARI SPK --}}
                            <td class="px-6 py-4">
                                @if($item->tingkat)
                                    <span class="bg-green-100 text-green-700 px-2 py-1 rounded-full text-xs font-semibold">{{ $item->tingkat }}</span>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            {{-- 🔧 HASIL DARI SPK --}}
                            <td class="px-6 py-4">{{ $item->hasil ?? '-' }}</td>
                            {{-- 🔧 POIN DARI SPK --}}
                            <td class="px-6 py-4 text-center font-bold text-blue-600">{{ $item->poin ?? 0 }}</td>
                            <td class="px-6 py-4 text-center">
                                {{ $item->tanggal_kegiatan ? \Carbon\Carbon::parse($item->tanggal_kegiatan)->format('d-m-Y') : '-' }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="text-center py-12">
                                <div class="flex flex-col items-center justify-center text-slate-400">
                                    <i class="fas fa-folder-open text-4xl mb-3 text-slate-300"></i>
                                    <p class="font-medium text-sm">Tidak ada data prestasi yang sesuai dengan filter.</p>
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