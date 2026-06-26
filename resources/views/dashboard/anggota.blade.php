<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Banner Anggota --}}
            <div class="bg-blue-50 border border-blue-200 rounded-xl p-6 mb-6">
                <div class="flex items-center gap-4">
                    <div class="flex-shrink-0">
                        <svg class="w-10 h-10 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-blue-800">Anda adalah Anggota Kelompok</h2>
                        <p class="text-sm text-blue-600 mt-1">Anda terdaftar sebagai anggota dalam kegiatan kelompok. Anda hanya dapat melihat data.</p>
                    </div>
                </div>
            </div>

            {{-- Statistik --}}
<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
        <p class="text-xs text-gray-500 uppercase tracking-wider">Total RPK</p>
        <p class="text-2xl font-bold text-gray-800">{{ $rpkAnggota->count() }}</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
        <p class="text-xs text-gray-500 uppercase tracking-wider">Total Kegiatan</p>
        <p class="text-2xl font-bold text-gray-800">{{ $totalKegiatanAnggota ?? 0 }}</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
        <p class="text-xs text-gray-500 uppercase tracking-wider">Total SPK</p>
        <p class="text-2xl font-bold text-gray-800">{{ $totalSpkAnggota ?? 0 }}</p>
    </div>
    {{-- 🔧 CARD POIN --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
        <p class="text-xs text-gray-500 uppercase tracking-wider">Total Poin</p>
        <p class="text-2xl font-bold text-blue-600">{{ $totalPoinAnggota ?? 0 }}</p>
    </div>
</div>

            {{-- TABS: RPK & SPK --}}
            <div class="flex border-b border-gray-200 mb-4">
                <button onclick="geserTabDashboard(0)" id="tabBtnRpk" class="tab-dashboard-btn bg-white border-t border-l border-r border-gray-200 rounded-t-lg px-6 py-3 -mb-[1px] relative z-10 font-bold text-gray-800 transition cursor-pointer">
                    <i class="fas fa-folder-open text-blue-500 mr-2"></i>RPK
                </button>
                <button onclick="geserTabDashboard(1)" id="tabBtnSpk" class="tab-dashboard-btn px-6 py-3 text-gray-500 font-bold hover:text-gray-700 border-b border-transparent transition cursor-pointer">
                    <i class="fas fa-file-alt text-green-500 mr-2"></i>SPK
                </button>
            </div>

            <div class="flex overflow-x-auto snap-x snap-mandatory scroll-smooth" id="tabDashboardContainer" style="scrollbar-width: none; -ms-overflow-style: none;">
                
                {{-- TAB 1: RPK --}}
                <div class="w-full flex-shrink-0 snap-start">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">
                        <i class="fas fa-folder-open text-blue-500 mr-2"></i>RPK yang Dapat Anda Lihat
                    </h3>
                    
                    @forelse($rpkAnggota as $rpk)
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-4 hover:shadow-md transition">
                            <div class="flex flex-col sm:flex-row justify-between sm:items-start gap-4">
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-2">
                                        <span class="text-sm text-gray-500">Ketua:</span>
                                        <span class="font-semibold text-gray-800">{{ $rpk->user->name }}</span>
                                        <span class="text-xs text-gray-400">({{ $rpk->user->nim ?? '-' }})</span>
                                    </div>
                                    
                                    <div class="flex flex-wrap items-center gap-3 text-sm text-gray-500">
                                        <span><i class="far fa-calendar mr-1"></i>{{ $rpk->tahun }}</span>
                                        <span><i class="fas fa-graduation-cap mr-1"></i>{{ $rpk->semester }}</span>
                                        <span>
                                            @if($rpk->status == 'draft')
                                                <span class="bg-yellow-100 text-yellow-700 px-2 py-0.5 rounded-full text-xs font-semibold">Draft</span>
                                            @elseif($rpk->status == 'diajukan')
                                                <span class="bg-blue-100 text-blue-700 px-2 py-0.5 rounded-full text-xs font-semibold">Diajukan</span>
                                            @elseif($rpk->status == 'disetujui')
                                                <span class="bg-green-100 text-green-700 px-2 py-0.5 rounded-full text-xs font-semibold">Disetujui</span>
                                            @else
                                                <span class="bg-red-100 text-red-700 px-2 py-0.5 rounded-full text-xs font-semibold">Ditolak</span>
                                            @endif
                                        </span>
                                        <span class="text-xs text-gray-400">
                                            <i class="fas fa-tasks mr-1"></i>
                                            @php
                                                $jmlKegiatan = $rpk->kegiatans->filter(function($k) {
                                                    return $k->kategori == 'Kelompok' && $k->anggota->contains('id', Auth::id());
                                                })->count();
                                            @endphp
                                            {{ $jmlKegiatan }} kegiatan
                                        </span>
                                    </div>
                                </div>
                                <a href="{{ route('rpks.show', $rpk->id) }}" 
                                   class="px-4 py-2 bg-blue-600 hover:bg-blue-500 text-white rounded-xl text-sm font-semibold transition flex-shrink-0 text-center">
                                    <i class="fas fa-eye mr-1"></i> Lihat Detail
                                </a>
                            </div>
                            
                            {{-- Kegiatan Kelompok --}}
                            <div class="mt-4">
                                <p class="text-sm font-semibold text-gray-700 mb-3">
                                    <i class="fas fa-tasks text-blue-500 mr-1"></i>Kegiatan Kelompok Anda:
                                </p>
                                
                                @php
                                    $kegiatanAnggota = $rpk->kegiatans->filter(function($kegiatan) {
                                        return $kegiatan->kategori == 'Kelompok' && 
                                               $kegiatan->anggota->contains('id', Auth::id());
                                    });
                                @endphp
                                
                                @if($kegiatanAnggota->count() > 0)
                                    <div class="space-y-3">
                                        @foreach($kegiatanAnggota as $kegiatan)
                                            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                                                <h5 class="text-sm font-bold text-gray-800 mb-1">
                                                    <i class="fas fa-clipboard-list text-gray-400 mr-1"></i>{{ $kegiatan->judul_kegiatan }}
                                                </h5>
                                                <p class="text-xs text-gray-500 mb-2">{{ $kegiatan->kegiatan }}</p>
                                                
                                                <div class="flex flex-wrap items-center gap-2 text-xs text-gray-500 mb-3">
                                                    <span class="bg-purple-100 text-purple-700 px-2 py-0.5 rounded-full font-semibold">
                                                        <i class="fas fa-users mr-1"></i>Kelompok
                                                    </span>
                                                    <span><i class="fas fa-tag mr-1"></i>{{ $kegiatan->jenis }}</span>
                                                    <span><i class="fas fa-layer-group mr-1"></i>{{ $kegiatan->tingkat }}</span>
                                                    <span><i class="far fa-calendar mr-1"></i>{{ \Carbon\Carbon::parse($kegiatan->tanggal)->format('d M Y') }}</span>
                                                </div>
                                                
                                                {{-- Tim Kelompok --}}
                                                <div class="pt-3 border-t border-gray-200">
                                                    <p class="text-xs font-semibold text-gray-600 mb-2">Tim Kelompok:</p>
                                                    <div class="flex flex-wrap gap-2">
                                                        <span class="inline-flex items-center gap-1 px-2 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-medium">
                                                            <i class="fas fa-crown text-xs"></i> {{ $rpk->user->name }} (Ketua)
                                                        </span>
                                                        @foreach($kegiatan->anggota as $anggota)
                                                            <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-medium
                                                                         @if($anggota->id == Auth::id()) bg-yellow-100 text-yellow-700 border border-yellow-300 @else bg-gray-100 text-gray-600 @endif">
                                                                <i class="fas fa-user text-xs"></i> {{ $anggota->name }}
                                                                @if($anggota->id == Auth::id()) (Anda) @endif
                                                            </span>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-sm text-gray-400 italic">Tidak ada kegiatan kelompok untuk Anda di RPK ini.</p>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-16 bg-white rounded-xl border border-gray-200">
                            <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                            </svg>
                            <p class="text-gray-500 font-medium">Belum ada RPK yang dapat diakses.</p>
                            <p class="text-gray-400 text-sm mt-1">Anda belum terdaftar sebagai anggota dalam kegiatan kelompok manapun.</p>
                        </div>
                    @endforelse
                </div>

                {{-- TAB 2: SPK --}}
                <div class="w-full flex-shrink-0 snap-start">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">
                        <i class="fas fa-file-alt text-green-500 mr-2"></i>SPK yang Dapat Anda Lihat
                    </h3>
                    
                    @php
                        $spkAnggota = \App\Models\Spk::with(['rpk', 'kegiatan', 'user'])
                            ->whereHas('kegiatan.anggota', function($q) {
                                $q->where('user_id', Auth::id());
                            })
                            ->latest()
                            ->get();
                    @endphp

                    @forelse($spkAnggota as $spk)
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-4 hover:shadow-md transition">
                            <div class="flex flex-col sm:flex-row justify-between sm:items-start gap-4">
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-2">
                                        <span class="text-sm text-gray-500">Pengaju:</span>
                                        <span class="font-semibold text-gray-800">{{ $spk->user->name ?? '-' }}</span>
                                        <span class="text-xs text-gray-400">({{ $spk->user->nim ?? '-' }})</span>
                                        @if($spk->user_id == Auth::id())
                                            <span class="text-xs text-blue-500">(Anda)</span>
                                        @endif
                                    </div>
                                    
                                    <div class="flex flex-wrap items-center gap-3 text-sm text-gray-500">
                                        <span><i class="far fa-calendar mr-1"></i>{{ $spk->tahun }}</span>
                                        <span><i class="fas fa-trophy mr-1"></i>{{ $spk->hasil ?? '-' }}</span>
                                        <span class="font-bold text-blue-600">{{ $spk->poin ?? '0' }} Poin</span>
                                        <span>
                                            @if($spk->status == 'draft')
                                                <span class="bg-yellow-100 text-yellow-700 px-2 py-0.5 rounded-full text-xs font-semibold">Draft</span>
                                            @elseif($spk->status == 'diajukan')
                                                <span class="bg-blue-100 text-blue-700 px-2 py-0.5 rounded-full text-xs font-semibold">Diajukan</span>
                                            @elseif($spk->status == 'disetujui')
                                                <span class="bg-green-100 text-green-700 px-2 py-0.5 rounded-full text-xs font-semibold">Disetujui</span>
                                            @else
                                                <span class="bg-red-100 text-red-700 px-2 py-0.5 rounded-full text-xs font-semibold">Ditolak</span>
                                            @endif
                                        </span>
                                    </div>
                                    
                                    <p class="text-xs text-gray-500 mt-2">
                                        <i class="fas fa-clipboard-list mr-1"></i>{{ $spk->kegiatan->judul_kegiatan ?? $spk->kegiatan->kegiatan ?? '-' }}
                                    </p>
                                </div>
                                <a href="{{ route('spks.show', $spk->id) }}" 
                                   class="px-4 py-2 bg-green-600 hover:bg-green-500 text-white rounded-xl text-sm font-semibold transition flex-shrink-0 text-center">
                                    <i class="fas fa-eye mr-1"></i> Lihat Detail
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-16 bg-white rounded-xl border border-gray-200">
                            <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <p class="text-gray-500 font-medium">Belum ada SPK yang dapat diakses.</p>
                            <p class="text-gray-400 text-sm mt-1">Belum ada SPK yang diajukan oleh ketua kelompok Anda.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <style>
        #tabDashboardContainer::-webkit-scrollbar { display: none; }
    </style>

    <script>
        function geserTabDashboard(index) {
            var container = document.getElementById('tabDashboardContainer');
            if (!container) return;
            container.scrollTo({ left: container.clientWidth * index, behavior: 'smooth' });
            updateTabDashboard(index);
        }

        function updateTabDashboard(index) {
            var btnRpk = document.getElementById('tabBtnRpk');
            var btnSpk = document.getElementById('tabBtnSpk');
            
            if (index === 0) {
                btnRpk.className = "tab-dashboard-btn bg-white border-t border-l border-r border-gray-200 rounded-t-lg px-6 py-3 -mb-[1px] relative z-10 font-bold text-gray-800 transition cursor-pointer";
                btnSpk.className = "tab-dashboard-btn px-6 py-3 text-gray-500 font-bold hover:text-gray-700 border-b border-transparent transition cursor-pointer";
            } else {
                btnSpk.className = "tab-dashboard-btn bg-white border-t border-l border-r border-gray-200 rounded-t-lg px-6 py-3 -mb-[1px] relative z-10 font-bold text-gray-800 transition cursor-pointer";
                btnRpk.className = "tab-dashboard-btn px-6 py-3 text-gray-500 font-bold hover:text-gray-700 border-b border-transparent transition cursor-pointer";
            }
        }

        (function() {
            var container = document.getElementById('tabDashboardContainer');
            if (container) {
                container.onscroll = function() {
                    var indexAktif = Math.round(container.scrollLeft / container.clientWidth);
                    updateTabDashboard(indexAktif);
                };
            }
        })();
    </script>

</x-app-layout>