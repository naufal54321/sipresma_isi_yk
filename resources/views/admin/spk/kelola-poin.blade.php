<x-app-layout>

<div class="py-6">

    <div class="max-w-8xl mx-auto py-6">

        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800">
                Kelola Poin SPK
            </h1>
            <p class="text-gray-500 mt-1">
                Atur poin prestasi untuk SPK yang sudah disetujui
            </p>
        </div>

        {{-- Ringkasan --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100">
                <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Total Disetujui</p>
                <p class="text-3xl font-bold text-slate-800 mt-1">{{ $totalDisetujui }}</p>
            </div>
            <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100">
                <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Sudah Poin</p>
                <p class="text-3xl font-bold text-blue-600 mt-1">{{ $totalDenganPoin }}</p>
            </div>
            <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100">
                <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Belum Poin</p>
                <p class="text-3xl font-bold text-amber-500 mt-1">{{ $totalTanpaPoin }}</p>
            </div>
            <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100">
                <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Total Poin</p>
                <p class="text-3xl font-bold text-green-600 mt-1">{{ $totalPoin }}</p>
            </div>
        </div>

        {{-- Filter --}}
        <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-200 mb-6">
            <form method="GET" action="{{ route('admin.spk.kelola-poin') }}" class="flex flex-col md:flex-row gap-4 items-end">
                <div class="w-full md:w-56 relative">
                    <label class="block text-xs font-semibold text-gray-500 mb-1 uppercase tracking-wider">Cari</label>
                    <input type="text" name="search" value="{{ $search }}"
                           placeholder="Nama atau Judul Kegiatan..."
                           class="w-full border border-gray-300 rounded-lg pl-10 pr-4 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 absolute left-3 top-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M11 18a7 7 0 100-14 7 7 0 000 14z"/></svg>
                </div>
                <div class="w-full md:w-28">
                    <label class="block text-xs font-semibold text-gray-500 mb-1 uppercase tracking-wider">Tahun</label>
                    <select name="tahun" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none transition bg-white">
                        <option value="">Semua</option>
                        @foreach($listTahun as $tahun)
                            <option value="{{ $tahun }}" {{ $filterTahun == $tahun ? 'selected' : '' }}>{{ $tahun }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="w-full md:w-32">
                    <label class="block text-xs font-semibold text-gray-500 mb-1 uppercase tracking-wider">Status Poin</label>
                    <select name="status_poin" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none transition bg-white">
                        <option value="">Semua</option>
                        <option value="sudah" {{ $filterStatus == 'sudah' ? 'selected' : '' }}>Sudah Poin</option>
                        <option value="belum" {{ $filterStatus == 'belum' ? 'selected' : '' }}>Belum Poin</option>
                    </select>
                </div>
                <div class="flex gap-2 w-full md:w-auto">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-500 text-white px-5 py-2.5 rounded-xl text-sm font-semibold transition w-full md:w-auto">Cari</button>
                    @if($search || $filterTahun || $filterStatus)
                        <a href="{{ route('admin.spk.kelola-poin') }}" class="bg-white border border-slate-300 hover:bg-slate-100 text-slate-700 px-5 py-2.5 rounded-xl text-sm font-semibold transition text-center flex items-center justify-center">Reset</a>
                    @endif
                </div>
            </form>
        </div>

        {{-- Tabel --}}
        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-slate-600">
                    <thead class="bg-slate-50/80 uppercase text-xs font-extrabold tracking-wider text-slate-400 border-b border-slate-100">
                        <tr>
                            <th class="px-2 py-3 text-center w-8">No</th>
                            <th class="px-2 py-3">Mahasiswa</th>
                            <th class="px-2 py-3">NIM</th>
                            <th class="px-2 py-3">Prodi</th>
                            <th class="px-2 py-3 text-center">Tahun</th>
                            <th class="px-2 py-3">Judul Kegiatan</th>
                            <th class="px-2 py-3 text-center">Poin</th>
                            <th class="px-2 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($spks as $index => $spk)
                        <tr class="hover:bg-blue-50/30 transition-colors group">
                            <td class="px-2 py-3 text-center font-bold text-black">{{ $spks->firstItem() + $index }}</td>
                            <td class="px-2 py-3 font-bold text-slate-800">{{ $spk->user->name ?? '-' }}</td>
                            <td class="px-2 py-3 font-semibold text-black">{{ $spk->user->nim ?? '-' }}</td>
                            <td class="px-2 py-3 font-semibold text-black">{{ $spk->user->prodi ?? '-' }}</td>
                            <td class="px-2 py-3 text-center font-semibold text-black">{{ $spk->tahun }}</td>
                            <td class="px-2 py-3 font-semibold text-slate-700">{{ $spk->judul_kegiatan ?? $spk->kegiatan?->judul_kegiatan ?? '-' }}</td>
                            <td class="px-2 py-3 text-center">
                                @if($spk->hasPoin())
                                    <span class="font-bold text-blue-600">{{ $spk->poin }}</span>
                                @else
                                    <span class="text-slate-400 text-xs">Belum</span>
                                @endif
                            </td>
                            <td class="px-2 py-3 text-center">
                                <a href="{{ route('admin.spk.show', $spk->id) }}"
                                   class="inline-flex items-center justify-center w-8 h-8 bg-blue-500 text-white hover:bg-blue-600 rounded-lg transition shadow-sm">
                                    <i class="fas fa-eye text-xs"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-16">
                                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-50 text-slate-300 mb-4">
                                    <i class="fas fa-folder-open text-3xl"></i>
                                </div>
                                <h3 class="text-sm font-bold text-slate-700">Tidak Ada Data</h3>
                                <p class="text-xs text-slate-400 mt-1">Belum ada SPK disetujui yang sesuai filter.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($spks->hasPages())
                <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">{{ $spks->links() }}</div>
            @endif
        </div>

    </div>

</div>

</x-app-layout>