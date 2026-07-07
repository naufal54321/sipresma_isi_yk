<x-app-layout>
    <div class="max-w-8xl mx-auto py-6">
        
       <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Manajemen Seluruh RPK</h1>
            <p class="text-gray-500 mt-1">Kelola seluruh RPK pengguna SIPRESMA</p>
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

                    <select name="status" class="w-full bg-slate-50 border border-slate-200 text-slate-700 text-sm rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors font-medium cursor-pointer">
                        <option value="">Semua Status</option>
                        <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Menunggu (Draft)</option>
                        <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                        <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>

                    <select name="dosen_id" class="w-full bg-slate-50 border border-slate-200 text-slate-700 text-sm rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors font-medium cursor-pointer">
                        <option value="">Semua Pembimbing</option>
                        <option value="tanpa_dosen" class="font-bold text-red-600" {{ request('dosen_id') == 'tanpa_dosen' ? 'selected' : '' }}>
                            ⚠️ TANPA DOSEN PEMBIMBING
                        </option>
                        @foreach($dosens as $dosen)
                            <option value="{{ $dosen->id }}" {{ request('dosen_id') == $dosen->id ? 'selected' : '' }}>{{ $dosen->name }}</option>
                        @endforeach
                    </select>

                    <div class="flex gap-2 h-full">
                        <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-bold transition-colors shadow-sm flex items-center justify-center gap-2">
                            <i class="fas fa-filter"></i> Terapkan
                        </button>
                        @if(request('search') || request('status') || request('dosen_id'))
                            <a href="{{ route('admin.rpk.index') }}" class="px-4 bg-slate-200 hover:bg-slate-300 text-slate-700 rounded-xl text-sm font-bold flex items-center justify-center transition-colors tooltip" title="Reset Filter">
                                <i class="fas fa-redo-alt"></i> Reset
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>

        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="overflow-x-auto w-full">
                <table class="min-w-full text-sm text-left text-slate-600">
                    <thead class="bg-slate-50/80 uppercase text-[10px] sm:text-[11px] font-extrabold tracking-wider text-slate-400 border-b border-slate-100">
                        <tr>
                            <th class="px-4 py-4 text-center w-10">No</th> 
                            <th class="px-5 sm:px-6 py-4 whitespace-nowrap">Mahasiswa</th>
                            <th class="px-5 sm:px-6 py-4">Program Studi</th>
                            <th class="px-5 sm:px-6 py-4">Rencana Kegiatan</th>
                            <th class="px-5 sm:px-6 py-4 whitespace-nowrap">Dosen Pembimbing</th>
                            <th class="px-5 sm:px-6 py-4 text-center whitespace-nowrap">Status</th>
                            <th class="px-5 sm:px-6 py-4 text-center whitespace-nowrap">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($rpks as $item)
                        <tr class="hover:bg-blue-50/30 transition-colors group">
                            <td class="px-4 py-4 text-center font-bold text-black">
                                {{ $loop->iteration }}
                            </td>

                            <td class="px-5 sm:px-6 py-4 min-w-[200px]">
                                <div class="flex items-center gap-3">
                                    <div class="min-w-0">
                                        <p class="font-bold text-slate-800 truncate group-hover:text-blue-600 transition-colors">{{ $item->user->name ?? '-' }}</p>
                                        <p class="text-[15px] text-slate-400 font-semibold truncate">{{ $item->user->nim ?? '-' }}</p>
                                    </div>
                                </div>
                            </td>

                            <td class="px-4 py-4 font-semibold text-black">
                                {{ $item->user->prodi ?? '-' }}
                            </td>

                            <td class="px-5 sm:px-6 py-4 min-w-[250px] max-w-xs">
                                {{-- Cek apakah RPK ini memiliki anak relasi kegiatan --}}
                                @if($item->kegiatans && $item->kegiatans->count() > 0)
                                    <!-- Menampilkan nama kegiatan yang pertama -->
                                    <p class="font-semibold text-slate-700 line-clamp-1 leading-relaxed">
                                        {{ $item->kegiatans->first()->kegiatan }}
                                    </p>
                                    
                                    {{-- Jika kegiatannya ada banyak, munculkan info tambahan --}}
                                    @if($item->kegiatans->count() > 1)
                                        <span class="inline-flex items-center text-[10px] text-blue-600 font-bold bg-blue-50 border border-blue-100 px-1.5 py-0.5 rounded-md mt-1">
                                            +{{ $item->kegiatans->count() - 1 }} Kegiatan Lainnya
                                        </span>
                                    @endif
                                @else
                                    {{-- Jika mahasiswa baru membuat kuota RPK tapi belum mengisi list kegiatannya --}}
                                    <p class="font-semibold text-slate-400 text-xs italic">
                                        RPK Smt {{ $item->semester ?? '-' }} (Thn {{ $item->tahun ?? '-' }})
                                    </p>
                                    <span class="inline-flex items-center text-[10px] text-slate-400 font-bold bg-slate-100 border border-slate-200 px-1.5 py-0.5 rounded-md mt-1">
                                        Belum ada list kegiatan
                                    </span>
                                @endif
                            </td>

                            <td class="font-bold text-black px-5 sm:px-6 py-4 min-w-[180px]">
                                @if($item->user && $item->user->dosenPembimbing)
                                
                                        <span class="truncate max-w-[120px]">{{ $item->user->dosenPembimbing->name }}</span>
                                @else
                                    <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-[11px] font-bold bg-red-50 text-red-600 border border-red-200 shadow-sm shadow-red-500/10 animate-pulse">
                                        <i class="fas fa-exclamation-triangle"></i> Belum Ada
                                    </div>
                                @endif
                            </td>

                            <td class="px-5 sm:px-6 py-4 text-center">
                                @if($item->status == 'disetujui')
                                    <span class="bg-green-500 text-white px-3 py-1 rounded-full text-xs">
                                            Disetujui
                                    </span>
                                @elseif($item->status == 'ditolak')
                                    <span class="bg-red-500 text-white px-3 py-1 rounded-full text-xs">
                                            Ditolak
                                        </span>
                                @else
                                    <span class="bg-orange-500 text-white px-3 py-1 rounded-full text-xs">
                                            Draft
                                    </span>
                                @endif
                            </td>
                            

                            <td class="px-5 sm:px-6 py-4 text-center">
                                <a href="{{ route('admin.rpk.show', $item->id) }}"
                                    title="Detail RPK"
                                            class="flex items-center justify-center w-9 h-9 bg-gray-400 text-white hover:bg-gray-500 border border-gray-200 rounded-lg transition shadow-sm">
                                            <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-16">
                                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-50 text-slate-300 mb-4">
                                    <i class="fas fa-folder-open text-3xl"></i>
                                </div>
                                <h3 class="text-sm font-bold text-slate-700">Tidak Ada RPK</h3>
                                <p class="text-xs text-slate-400 mt-1">Belum ada dokumen yang sesuai dengan filter pencarian Anda.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

            @if($rpks->hasPages())
                <div class="px-6 py-4 bg-slate-50/50 border-t border-slate-100">
                    {{ $rpks->links() }}
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
</x-app-layout>