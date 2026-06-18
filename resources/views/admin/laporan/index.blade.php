<x-app-layout>
    <div class="max-w-8xl mx-auto py-6">
        
        <h1 class="text-3xl font-bold text-gray-800">
            Laporan Prestasi Mahasiswa
        </h1>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5 mb-6">
            <form method="GET">
                <div class="grid md:grid-cols-4 gap-4">
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari Nama, NIM, Kegiatan, dll..."
                        class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition-shadow">

                    <select name="tingkat" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 cursor-pointer text-slate-700 transition-shadow">
                        <option value="">Semua Tingkat</option>
                        <option value="Universitas" {{ request('tingkat') == 'Universitas' ? 'selected' : '' }}>Universitas</option>
                        <option value="Regional" {{ request('tingkat') == 'Regional' ? 'selected' : '' }}>Regional</option>
                        <option value="Nasional" {{ request('tingkat') == 'Nasional' ? 'selected' : '' }}>Nasional</option>
                        <option value="Internasional" {{ request('tingkat') == 'Internasional' ? 'selected' : '' }}>Internasional</option>
                    </select>

                    <select name="prodi" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 cursor-pointer text-slate-700 transition-shadow">
                        <option value="">Semua Program Studi</option>
                        @foreach($prodis as $prodi)
                            <option value="{{ $prodi->nama_prodi }}"
                                {{ request('prodi') == $prodi->nama_prodi ? 'selected' : '' }}>
                                {{ $prodi->nama_prodi }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="mt-5 flex flex-wrap gap-2">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl text-sm font-semibold transition">
                        Filter
                    </button>
                    <a href="{{ route('admin.laporan.index') }}" class="bg-slate-500 hover:bg-slate-600 text-white px-5 py-2.5 rounded-xl text-sm font-semibold transition flex items-center">
                        Reset
                    </a>
                    <a href="{{ route('admin.laporan.export', request()->query()) }}" class="bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2.5 rounded-xl text-sm font-semibold transition flex items-center">
                        Export CSV
                    </a>
                    <a href="{{ route('admin.laporan.export-pdf', request()->query()) }}" class="bg-red-600 hover:bg-red-700 text-white px-5 py-2.5 rounded-xl text-sm font-semibold transition flex items-center">
                        Export PDF
                    </a>
                </div>
            </form>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-slate-600">
                    <thead class="bg-slate-50 uppercase text-[11px] font-bold tracking-wider text-slate-500 border-b border-slate-200">
                        <tr>
                            <th class="px-5 py-4">Nama</th>
                            <th class="px-5 py-4">NIM</th>
                            <th class="px-5 py-4">Prodi</th>
                            <th class="px-5 py-4">Kegiatan</th>
                            <th class="px-5 py-4">Penyelenggara</th>
                            <th class="px-5 py-4 text-center">Tingkat</th>
                            <th class="px-5 py-4 text-center">Poin</th>
                            <th class="px-5 py-4 text-center">Status</th>
                            <th class="px-5 py-4 text-center">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($laporan as $item)
                        <tr class="hover:bg-slate-50 transition duration-200">
                            <td class="px-5 py-4 font-semibold text-slate-800">{{ $item->user->name ?? '-' }}</td>
                            <td class="px-5 py-4">{{ $item->user->nim ?? '-' }}</td>
                            <td class="px-5 py-4">{{ $item->user->prodi ?? '-' }}</td>
                            <td class="px-5 py-4">{{ $item->kegiatan->kegiatan ?? '-' }}</td>
                            <td class="px-5 py-4">{{ $item->penyelenggara ?? '-' }}</td>
                            <td class="px-5 py-4 text-center">{{ $item->kegiatan->tingkat ?? '-' }}</td>
                            <td class="px-5 py-4 text-center font-bold text-blue-600">{{ $item->kegiatan->masterKegiatan->poin ?? 0 }}</td>
                            <td class="px-5 py-4 text-center">
                                @if($item->status == 'disetujui')
                                    <span class="bg-emerald-500 text-white px-3 py-1 rounded-full text-xs font-medium">Disetujui</span>
                                @elseif($item->status == 'ditolak')
                                    <span class="bg-red-500 text-white px-3 py-1 rounded-full text-xs font-medium">Ditolak</span>
                                @else
                                    <span class="bg-orange-500 text-white px-3 py-1 rounded-full text-xs font-medium">Draft</span>
                                @endif
                            </td>
                            <td class="px-5 py-4 text-center whitespace-nowrap">{{ $item->created_at->format('d-m-Y') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center py-8 text-slate-500">
                                Tidak ada data laporan yang ditemukan.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-6">
            {{ $laporan->links() }}
        </div>
        
    </div>
</x-app-layout>