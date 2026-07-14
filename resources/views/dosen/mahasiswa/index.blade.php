<x-app-layout>

<div class="py-6">
    <div class="max-w-8xl mx-auto py-6">

        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Mahasiswa Bimbingan</h1>
            <p class="text-gray-500 mt-1">Daftar mahasiswa di bawah bimbingan Anda</p>
        </div>
        {{-- ⚡ STATS CARDS --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-6">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5">
                <p class="text-slate-400 text-xs font-bold uppercase tracking-widest">Total Mahasiswa</p>
                <p class="text-3xl font-extrabold text-slate-800 mt-1">{{ $mahasiswa->count() }}</p>
            </div>
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5">
                <p class="text-slate-400 text-xs font-bold uppercase tracking-widest">Total RPK</p>
                <p class="text-3xl font-extrabold text-slate-800 mt-1">{{ $mahasiswa->sum('total_rpk') }}</p>
            </div>
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5">
                <p class="text-slate-400 text-xs font-bold uppercase tracking-widest">Total SPK</p>
                <p class="text-3xl font-extrabold text-slate-800 mt-1">{{ $mahasiswa->sum('total_spk') }}</p>
            </div>
        </div>

        {{-- ⚡ FILTER --}}
        <div class="bg-white p-4 rounded-2xl shadow-sm border border-slate-100 mb-6">
            <form method="GET" action="{{ route('dosen.mahasiswa.index') }}" class="flex flex-col md:flex-row gap-4 items-end">
                <div class="w-full md:w-64 relative">
                    <label class="block text-xs font-semibold text-gray-500 mb-1 uppercase tracking-wider">Cari</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama, NIM, Prodi..."
                        class="w-full border border-gray-300 rounded-xl pl-10 pr-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <svg class="w-4 h-4 absolute left-3 top-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M11 18a7 7 0 100-14 7 7 0 000 14z"/>
                    </svg>
                </div>
                <div class="w-full md:w-48">
                    <label class="block text-xs font-semibold text-gray-500 mb-1 uppercase tracking-wider">Angkatan</label>
                    <select name="angkatan" class="w-full border border-gray-300 rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Semua</option>
                        @foreach($listAngkatan ?? [] as $angkatan)
                            <option value="{{ $angkatan }}" {{ request('angkatan') == $angkatan ? 'selected' : '' }}>{{ $angkatan }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-xl text-sm font-semibold transition">Filter</button>
                    @if(request('search') || request('angkatan'))
                        <a href="{{ route('dosen.mahasiswa.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-xl text-sm font-semibold transition">Reset</a>
                    @endif
                </div>
            </form>
        </div>

        {{-- ⚡ TABEL --}}
        <div class="bg-white shadow-lg rounded-xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50 uppercase text-xs tracking-wider">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">No</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Nama</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">NIM</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Prodi</th>
                            <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase">Angkatan</th>
                            <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase">Semester</th>
                            <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase">RPK</th>
                            <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase">SPK</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse($mahasiswa as $mhs)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-700">{{ $loop->iteration }}</td>
                            <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $mhs->name }}</td>
                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-700">{{ $mhs->nim ?? '-' }}</td>
                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-700">{{ $mhs->prodi ?? '-' }}</td>
                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-700 text-center">{{ $mhs->angkatan ?? '-' }}</td>
                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-700 text-center">{{ $mhs->semester ?? '-' }}</td>
                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-700 text-center font-bold">
                                {{ $mhs->total_rpk }}
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-700 text-center font-bold">
                                {{ $mhs->total_spk }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="px-6 py-16 text-center text-gray-400">
                                <i class="fas fa-users text-4xl text-gray-300 mb-3 block"></i>
                                <span class="text-sm font-medium">Belum ada mahasiswa bimbingan</span>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- ⚡ PAGINATION --}}
            @if($mahasiswa instanceof \Illuminate\Pagination\LengthAwarePaginator)
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $mahasiswa->links() }}
            </div>
            @endif
        </div>

    </div>
</div>

</x-app-layout>