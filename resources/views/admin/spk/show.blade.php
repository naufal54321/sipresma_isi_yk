<x-app-layout>

<style>
    .hide-scrollbar::-webkit-scrollbar { display: none; }
    .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
</style>

<div class="max-w-8xl mx-auto py-6">

    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
        <h1 class="text-3xl font-bold text-gray-900">Detail SPK (Admin)</h1>

        <div class="flex items-center gap-3">
            <a href="{{ route('admin.spk.index') }}"
               class="inline-flex items-center gap-2 bg-white border border-gray-300 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm font-semibold shadow-sm transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali
            </a>

            {{-- ⚡ TOMBOL TAMBAH POIN - MUNCUL JIKA SPK DISETUJUI & BELUM ADA POIN --}}
            @if($spk->status === 'disetujui' && !$spk->hasPoin())
                <button onclick="tambahPoinSweetAlert({{ $spk->id }}, '{{ addslashes($spk->judul_kegiatan) }}')"
                        class="inline-flex items-center gap-2 bg-yellow-500 hover:bg-yellow-400 text-white px-4 py-2 rounded-lg text-sm font-semibold shadow-sm transition cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Tambah Poin
                </button>
            @endif

            @if($spk->status == 'draft')
                <button onclick="approveSpk({{ $spk->id }})"
                        class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-500 text-white px-4 py-2 rounded-lg text-sm font-semibold shadow-sm transition cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                    SPK Disetujui
                </button>

                <button onclick="rejectSpk({{ $spk->id }})"
                        class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-500 text-white px-4 py-2 rounded-lg text-sm font-semibold shadow-sm transition cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    SPK Ditolak
                </button>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

        {{-- SIDEBAR --}}
        <div class="lg:col-span-4">
            <div class="bg-gray-50 border border-gray-200 shadow-sm rounded-xl overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-200 bg-white">
                    <h2 class="text-lg font-bold text-gray-900">Detail SPK</h2>
                </div>
                
                <div class="p-6 bg-white space-y-4">
                    <div class="grid grid-cols-3 gap-2">
                        <span class="text-sm font-bold text-gray-600">Nama</span>
                        <span class="col-span-2 text-sm text-gray-800 font-medium">{{ $spk->user->name }}</span>
                    </div>
                    
                    <div class="grid grid-cols-3 gap-2">
                        <span class="text-sm font-bold text-gray-600">NIM</span>
                        <span class="col-span-2 text-sm text-gray-800 font-medium">{{ $spk->user->nim ?? '-' }}</span>
                    </div>

                    <div class="grid grid-cols-3 gap-2">
                        <span class="text-sm font-bold text-gray-600">Prodi</span>
                        <span class="col-span-2 text-sm text-gray-800 font-medium">{{ $spk->user->prodi ?? '-' }}</span>
                    </div>

                    {{-- ⚡ FAKULTAS (AMBIL DARI TABEL PROGRAM_STUDIS) --}}
                    <div class="grid grid-cols-3 gap-2 pb-4 border-b border-gray-200">
                        <span class="text-sm font-bold text-gray-600">Fakultas</span>
                        <span class="col-span-2 text-sm text-gray-800 font-medium">
                            @php
                                $prodi = \App\Models\ProgramStudi::where('nama_prodi', $spk->user->prodi)->first();
                            @endphp
                            {{ $prodi->fakultas ?? '-' }}
                        </span>
                    </div>

                    <div class="grid grid-cols-3 gap-2">
                        <span class="text-sm font-bold text-gray-600">Angkatan</span>
                        <span class="col-span-2 text-sm text-gray-800 font-medium">{{ $spk->user->angkatan ?? '-' }}</span>
                    </div>

            <div class="grid grid-cols-3 gap-2 pb-4 border-b border-gray-200">
                <span class="text-sm font-bold text-gray-600">Semester</span>
                <span class="col-span-2 text-sm text-gray-800 font-medium">{{ $spk->user->semester ?? '-' }}</span>
            </div>

            {{-- ⚡ DOSEN PEMBIMBING --}}
            <div class="grid grid-cols-3 gap-2 pb-4 border-b border-gray-200">
                <span class="text-sm font-bold text-gray-600">Dosen Pembimbing</span>
                <span class="col-span-2 text-sm text-gray-800 font-medium">
                    @if($spk->user->dosenPembimbing)
                        {{ $spk->user->dosenPembimbing->name }}
                    @else
                        <span class="text-red-500 italic text-xs">Belum ada</span>
                    @endif
                </span>
            </div>

            <div class="grid grid-cols-3 gap-2 pt-2">
                <span class="text-sm font-bold text-gray-600">Tahun</span>
                <span class="col-span-2 text-sm text-gray-800 font-medium">{{ $spk->tahun }}</span>
            </div>

            <div class="grid grid-cols-3 gap-2">
                <span class="text-sm font-bold text-gray-600">RPK</span>
                <span class="col-span-2 text-sm text-gray-800 font-medium">{{ $spk->rpk->tahun ?? '-' }} - {{ $spk->rpk->semester ?? '-' }}</span>
            </div>

            <div class="grid grid-cols-3 gap-2">
                <span class="text-sm font-bold text-gray-600">URL Kegiatan</span>
                <span class="col-span-2 text-sm text-blue-600 break-words">
                    @if($spk->url_kegiatan)
                        <a href="{{ $spk->url_kegiatan }}" target="_blank" class="hover:underline">Buka Tautan</a>
                    @else
                        <span class="text-gray-400">-</span>
                    @endif
                </span>
            </div>

            <div class="grid grid-cols-3 gap-2">
                <span class="text-sm font-bold text-gray-600">Link Drive</span>
                <span class="col-span-2 text-sm text-blue-600 break-words">
                    @if($spk->link_drive)
                        <a href="{{ $spk->link_drive }}" target="_blank" class="hover:underline">
                            <i class="fab fa-google-drive mr-1"></i>Buka Drive
                        </a>
                    @else
                        <span class="text-gray-400">-</span>
                    @endif
                </span>
            </div>

            <div class="grid grid-cols-3 gap-2">
                <span class="text-sm font-bold text-gray-600">Keterangan</span>
                <span class="col-span-2 text-sm text-gray-800">{{ $spk->keterangan }}</span>
            </div>

            <div class="grid grid-cols-3 gap-2">
                <span class="text-sm font-bold text-gray-600">Status</span>
                <div class="mt-1">
                    @if($spk->status == 'draft')
                        <span class="bg-orange-500 text-white px-3 py-1 rounded-full text-xs font-semibold">Draft</span>
                    @elseif($spk->status == 'disetujui')
                        <span class="bg-green-500 text-white px-3 py-1 rounded-full text-xs font-semibold">Disetujui</span>
                    @else
                        <span class="bg-red-500 text-white px-3 py-1 rounded-full text-xs font-semibold">Ditolak</span>
                    @endif
                </div>
            </div>

            {{-- ⚡ INFORMASI POIN (DENGAN EDIT) --}}
                    <div class="pt-3 border-t border-gray-200">
                        <span class="text-sm font-bold text-gray-600">Poin</span>
                        <div class="mt-2">
                            @if($spk->status === 'disetujui')
                                @if($spk->hasPoin())
                                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center gap-2">
                                                <span class="text-2xl font-bold text-yellow-600">{{ $spk->poin }}</span>
                                                <span class="text-sm text-gray-600">Poin</span>
                                            </div>
                                            {{-- ⚡ TOMBOL EDIT POIN --}}
                                            <button onclick="editPoin({{ $spk->id }}, {{ $spk->poin }}, '{{ addslashes($spk->judul_kegiatan ?? $spk->kegiatan->judul_kegiatan ?? '') }}')"
                                                    class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-lg text-xs font-semibold transition cursor-pointer">
                                                <i class="fas fa-pen mr-1"></i> Edit
                                            </button>
                                        </div>
                                        @if($spk->poin_added_at)
                                        <p class="text-xs text-gray-500 mt-2">
                                            Oleh: {{ $spk->poinAddedBy->name ?? 'Admin' }}<br>
                                            {{ $spk->poin_added_at->format('d/m/Y H:i') }}
                                        </p>
                                        @endif
                                    </div>
                                @else
                                    <button onclick="tambahPoinSweetAlert({{ $spk->id }}, '{{ addslashes($spk->judul_kegiatan ?? $spk->kegiatan->judul_kegiatan ?? '') }}')"
                                            class="w-full bg-yellow-500 hover:bg-yellow-400 text-white px-4 py-2 rounded-lg text-sm font-semibold transition cursor-pointer">
                                        <i class="fas fa-plus-circle mr-1"></i> Tambah Poin
                                    </button>
                                @endif
                            @else
                                <span class="text-sm text-gray-400">- (SPK belum disetujui)</span>
                            @endif
                        </div>
                    </div>

            @if($spk->catatan_dosen)
            <div class="pt-3 border-t border-gray-200">
                <span class="text-sm font-bold text-gray-600">Catatan</span>
                <p class="text-sm text-red-600 mt-1 bg-red-50 p-2 rounded-lg">{{ $spk->catatan_dosen }}</p>
            </div>
            @endif
        </div>
    </div>


            {{-- Info Admin --}}
            <div class="mt-6 bg-blue-50 border border-blue-100 rounded-xl p-6 shadow-sm">
                <h3 class="text-xl text-blue-800 mb-3 flex items-center gap-2">
                    <i class="fas fa-info-circle"></i> Info Admin
                </h3>
                <p class="text-sm text-blue-700 leading-relaxed mb-4">
                    Anda login sebagai <strong>Admin</strong>. Keputusan persetujuan atau penolakan di halaman ini bersifat mutlak dan akan menimpa keputusan Dosen Pembimbing.
                </p>
                <div class="border-t border-blue-200/60 my-4"></div>
                <p class="text-sm text-red-500 leading-relaxed">
                    <i class="fas fa-exclamation-triangle mr-1"></i>
                    Pastikan data sudah sesuai sebelum melakukan validasi.
                </p>
            </div>
        </div>

        {{-- CONTENT --}}
        <div class="lg:col-span-8">
            <div class="bg-white border border-gray-200 shadow-sm rounded-xl overflow-hidden flex flex-col h-full">
                
                <div class="flex border-b border-gray-200 bg-gray-50 px-2 pt-2 overflow-x-auto hide-scrollbar" id="tab-headers">
                    <button onclick="geserTab(0)" class="tab-btn bg-white border-t border-l border-r border-gray-200 rounded-t-xl px-6 py-3 -mb-[1px] relative z-10 font-bold text-gray-800 whitespace-nowrap transition cursor-pointer">
                        Deskripsi Kegiatan
                    </button>
                    <button onclick="geserTab(1)" class="tab-btn px-6 py-3 text-gray-500 font-bold hover:text-gray-700 whitespace-nowrap border-b border-transparent transition cursor-pointer">
                        Dokumen
                    </button>
                    <button onclick="geserTab(2)" class="tab-btn px-6 py-3 text-gray-500 font-bold hover:text-gray-700 whitespace-nowrap border-b border-transparent transition cursor-pointer">
                        Riwayat SPK
                    </button>
                </div>

                <div class="flex overflow-x-auto snap-x snap-mandatory hide-scrollbar scroll-smooth flex-grow" id="tab-content-container">
                    
                    {{-- TAB 1: DESKRIPSI --}}
                        <div class="w-full flex-shrink-0 snap-start p-6">
                            {{-- Header Section --}}
                            <div class="flex items-center gap-3 mb-6">
                                <div class="w-1 h-6 bg-gradient-to-b from-blue-500 to-blue-600 rounded-full"></div>
                                <h3 class="text-lg font-bold text-gray-800">Informasi Kegiatan</h3>
                            </div>

                        {{-- Card Grid --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                            {{-- Nama Kegiatan --}}
                            <div class="group bg-white border border-gray-200 rounded-xl p-5 hover:border-blue-300 hover:shadow-lg hover:shadow-blue-50 transition-all duration-300 md:col-span-2">
                                <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-widest mb-2">Nama Kegiatan</p>
                                <p class="text-sm font-semibold text-gray-800 leading-relaxed">{{ $spk->kegiatan->kegiatan ?? '-' }}</p>
                            </div>

                            {{-- Judul Kegiatan --}}
                            <div class="group bg-white border border-gray-200 rounded-xl p-5 hover:border-blue-300 hover:shadow-lg hover:shadow-blue-50 transition-all duration-300 md:col-span-2">
                                <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-widest mb-2">Judul Kegiatan</p>
                                <p class="text-sm font-semibold text-gray-800 leading-relaxed">{{ $spk->kegiatan->judul_kegiatan ?? '-' }}</p>
                            </div>

                            {{-- ⚡ Judul Karya/Inovasi/Riset/Prestasi --}}
                            <div class="group bg-white border border-gray-200 rounded-xl p-5 hover:border-blue-300 hover:shadow-lg hover:shadow-blue-50 transition-all duration-300 md:col-span-2">
                                <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-widest mb-2">Judul Karya/Inovasi/Riset/Prestasi</p>
                                <p class="text-sm font-semibold text-gray-800 leading-relaxed">{{ $spk->judul_karya ?? '-' }}</p>
                            </div>

                            {{-- Tanggal Pelaksanaan --}}
                            <div class="group bg-white border border-gray-200 rounded-xl p-5 hover:border-blue-300 hover:shadow-lg hover:shadow-blue-50 transition-all duration-300">
                                <div class="flex items-center gap-2 mb-2">
                                    <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-widest">Tanggal Pelaksanaan</p>
                                </div>
                                <p class="text-sm font-semibold text-gray-800">
                                   {{ $spk->tanggal_kegiatan ?? '-' }}
                                </p>
                            </div>

                            {{-- Tingkat Kegiatan --}}
                            <div class="group bg-white border border-gray-200 rounded-xl p-5 hover:border-blue-300 hover:shadow-lg hover:shadow-blue-50 transition-all duration-300">
                                <div class="flex items-center gap-2 mb-2">
                                    <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12"/>
                                    </svg>
                                    <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-widest">Tingkat Kegiatan</p>
                                </div>
                                <div>
                                    @if($spk->tingkat)
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-100">
                                            <span class="w-1.5 h-1.5 bg-blue-500 rounded-full"></span>{{ $spk->tingkat }}
                                        </span>
                                    @else
                                        <span class="text-sm text-gray-400">-</span>
                                    @endif
                                </div>
                            </div>

                            {{-- Kategori --}}
                            <div class="group bg-white border border-gray-200 rounded-xl p-5 hover:border-blue-300 hover:shadow-lg hover:shadow-blue-50 transition-all duration-300">
                                <div class="flex items-center gap-2 mb-2">
                                    <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                    </svg>
                                    <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-widest">Kategori</p>
                                </div>
                                <div>
                                    @if($spk->kategori == 'Kelompok')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold bg-purple-50 text-purple-700 border border-purple-100">
                                            <span class="w-1.5 h-1.5 bg-purple-500 rounded-full"></span>Kelompok
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold bg-gray-100 text-gray-600 border border-gray-200">
                                            <span class="w-1.5 h-1.5 bg-gray-400 rounded-full"></span>Individu
                                        </span>
                                    @endif
                                </div>
                            </div>

                            {{-- Hasil / Prestasi --}}
                            <div class="group bg-white border border-gray-200 rounded-xl p-5 hover:border-blue-300 hover:shadow-lg hover:shadow-blue-50 transition-all duration-300">
                                <div class="flex items-center gap-2 mb-2">
                                    <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                                    </svg>
                                    <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-widest">Hasil / Prestasi</p>
                                </div>
                                <p class="text-sm font-semibold text-gray-800">{{ $spk->hasil ?? '-' }}</p>
                            </div>

                            {{-- Poin --}}
                            <div class="group bg-gradient-to-br from-blue-50 to-white border border-blue-100 rounded-xl p-5 hover:shadow-lg hover:shadow-blue-50 transition-all duration-300">
                                <div class="flex items-center gap-2 mb-2">
                                    <svg class="w-3.5 h-3.5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                    <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-widest">Poin</p>
                                </div>
                                <p class="text-3xl font-bold text-blue-600">{{ $spk->poin ?? '0' }}</p>
                            </div>
                            

                            {{-- Penyelenggara --}}
                            <div class="group bg-white border border-gray-200 rounded-xl p-5 hover:border-blue-300 hover:shadow-lg hover:shadow-blue-50 transition-all duration-300">
                                <div class="flex items-center gap-2 mb-2">
                                    <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                    </svg>
                                    <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-widest">Penyelenggara</p>
                                </div>
                                <p class="text-sm font-semibold text-gray-800">{{ $spk->penyelenggara }}</p>
                            </div>

                            {{-- Dokumen --}}
                            <div class="group bg-white border border-gray-200 rounded-xl p-5 hover:border-emerald-300 hover:shadow-lg hover:shadow-emerald-50 transition-all duration-300">
                                <div class="flex items-center gap-2 mb-2">
                                    <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-widest">Dokumen</p>
                                </div>
                                <p class="text-sm font-semibold text-emerald-600 flex items-center gap-1.5">
                                    <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>Tersedia (Lihat tab Dokumen)
                                </p>
                            </div>

                            {{-- ⚡ BIOGRAFI --}}
                            @if($spk->biografi)
                            <div class="group bg-white border border-gray-200 rounded-xl p-5 hover:border-purple-300 hover:shadow-lg transition-all duration-300 md:col-span-2">
                                <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-widest mb-2">Biografi/Latar Belakang Individu/Tim</p>
                                <p class="text-sm text-gray-700 leading-relaxed whitespace-pre-line">{{ $spk->biografi }}</p>
                            </div>
                            @endif

                            {{-- ⚡ RINCIAN --}}
                            @if($spk->rincian)
                            <div class="group bg-white border border-gray-200 rounded-xl p-5 hover:border-purple-300 hover:shadow-lg transition-all duration-300 md:col-span-2">
                                <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-widest mb-2">Rincian Inovasi/Riset/Prestasi</p>
                                <p class="text-sm text-gray-700 leading-relaxed whitespace-pre-line">{{ $spk->rincian }}</p>
                            </div>
                            @endif

                            {{-- ⚡ KEBARUAN --}}
                            @if($spk->kebaruan)
                            <div class="group bg-white border border-gray-200 rounded-xl p-5 hover:border-purple-300 hover:shadow-lg transition-all duration-300 md:col-span-2">
                                <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-widest mb-2">Kebaruan/Keunggulan</p>
                                <p class="text-sm text-gray-700 leading-relaxed whitespace-pre-line">{{ $spk->kebaruan }}</p>
                            </div>
                            @endif
                        </div>

                        {{-- DAFTAR ANGGOTA KELOMPOK --}}
                        @if($spk->kategori == 'Kelompok' && $spk->kegiatan && $spk->kegiatan->anggota->count() > 0)
                        <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm">
                            <div class="px-5 py-4 border-b border-gray-100 flex items-center gap-3">
                                <div class="w-1 h-5 bg-purple-500 rounded-full"></div>
                                <h4 class="text-sm font-bold text-gray-800">Anggota Kelompok</h4>
                                <span class="text-xs text-gray-400 font-medium ml-auto">{{ $spk->kegiatan->anggota->count() + 1 }} orang</span>
                            </div>
                            <div class="overflow-x-auto">
                                <table class="w-full text-sm">
                                    <thead>
                                        <tr class="border-b border-gray-50">
                                            <th class="px-5 py-3 text-center w-12 text-[11px] font-semibold text-gray-400 uppercase tracking-wider">No</th>
                                            <th class="px-5 py-3 text-left text-[11px] font-semibold text-gray-400 uppercase tracking-wider">Nama</th>
                                            <th class="px-5 py-3 text-left text-[11px] font-semibold text-gray-400 uppercase tracking-wider">NIM</th>
                                            <th class="px-5 py-3 text-left text-[11px] font-semibold text-gray-400 uppercase tracking-wider">Prodi</th>
                                            <th class="px-5 py-3 text-center w-24 text-[11px] font-semibold text-gray-400 uppercase tracking-wider">Peran</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-50">
                                        <tr class="bg-blue-50/30">
                                            <td class="px-5 py-3 text-center text-gray-500 font-medium">1</td>
                                            <td class="px-5 py-3 font-semibold text-gray-800">
                                                {{ $spk->rpk->user->name ?? $spk->user->name }}
                                                @if($spk->rpk->user_id == Auth::id() || $spk->user_id == Auth::id())
                                                    <span class="text-[11px] text-blue-500 font-medium ml-1.5">(Anda)</span>
                                                @endif
                                            </td>
                                            <td class="px-5 py-3 text-gray-500 font-medium">{{ $spk->rpk->user->nim ?? $spk->user->nim ?? '-' }}</td>
                                            <td class="px-5 py-3 text-gray-500 font-medium">{{ $spk->rpk->user->prodi ?? $spk->user->prodi ?? '-' }}</td>
                                            <td class="px-5 py-3 text-center">
                                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-100">
                                                    <span class="w-1.5 h-1.5 bg-blue-500 rounded-full"></span>
                                                    Ketua
                                                </span>
                                            </td>
                                        </tr>
                                        @foreach($spk->kegiatan->anggota as $index => $anggota)
                                            <tr class="hover:bg-gray-50/50 transition-colors duration-150 @if($anggota->id == Auth::id()) bg-yellow-50/30 @endif">
                                                <td class="px-5 py-3 text-center text-gray-500 font-medium">{{ $index + 2 }}</td>
                                                <td class="px-5 py-3 font-semibold text-gray-800">
                                                    {{ $anggota->name }}
                                                    @if($anggota->id == Auth::id())
                                                        <span class="text-[11px] text-blue-500 font-medium ml-1.5">(Anda)</span>
                                                    @endif
                                                </td>
                                                <td class="px-5 py-3 text-gray-500 font-medium">{{ $anggota->nim ?? '-' }}</td>
                                                <td class="px-5 py-3 text-gray-500 font-medium">{{ $anggota->prodi ?? '-' }}</td>
                                                <td class="px-5 py-3 text-center">
                                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-100">
                                                        <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>
                                                        Anggota
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @endif
                    </div>

                    {{-- TAB 2: DOKUMEN --}}
                    <div class="w-full flex-shrink-0 snap-start p-6">
                        <h3 class="text-gray-800 font-extrabold mb-5 flex items-center gap-2">
                            <span class="p-1.5 rounded-lg bg-orange-50 text-orange-500">
                                <i class="fas fa-folder-open"></i>
                            </span>
                            Dokumen Kegiatan
                        </h3>
                        
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                            {{-- Surat Tugas --}}
                            <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                                <div class="px-4 py-3 bg-gradient-to-r from-blue-50 to-blue-100/50 border-b border-gray-200 flex justify-between items-center">
                                    <h4 class="text-sm font-extrabold text-gray-800 flex items-center gap-2">
                                        <span class="w-7 h-7 bg-blue-500 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-file-contract text-white text-xs"></i>
                                        </span>
                                        Surat Tugas
                                    </h4>
                                    @if($spk->surat_tugas)
                                    <a href="{{ asset('storage/' . $spk->surat_tugas) }}" target="_blank" 
                                    class="inline-flex items-center gap-1 bg-blue-500 hover:bg-blue-600 text-white px-3 py-1.5 rounded-lg text-xs font-bold transition">
                                        <i class="fas fa-eye"></i> Tinjau
                                    </a>
                                    @endif
                                </div>
                                <div class="bg-gray-100 min-h-[250px] relative">
                                    @if($spk->surat_tugas)
                                        <iframe src="{{ asset('storage/' . $spk->surat_tugas) }}" class="w-full h-[250px] border-0"></iframe>
                                    @else
                                        <div class="flex flex-col items-center justify-center h-[250px] text-gray-400">
                                            <i class="fas fa-file-pdf text-4xl mb-2 text-gray-300"></i>
                                            <span class="text-sm font-medium">Belum diupload</span>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            {{-- Sertifikat / Foto Piala --}}
                            <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                                <div class="px-4 py-3 bg-gradient-to-r from-yellow-50 to-yellow-100/50 border-b border-gray-200 flex justify-between items-center">
                                    <h4 class="text-sm font-extrabold text-gray-800 flex items-center gap-2">
                                        <span class="w-7 h-7 bg-yellow-500 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-certificate text-white text-xs"></i>
                                        </span>
                                        Sertifikat / Foto Piala
                                    </h4>
                                    @if($spk->sertifikat)
                                    <a href="{{ asset('storage/' . $spk->sertifikat) }}" target="_blank" 
                                    class="inline-flex items-center gap-1 bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1.5 rounded-lg text-xs font-bold transition">
                                        <i class="fas fa-eye"></i> Tinjau
                                    </a>
                                    @endif
                                </div>
                                <div class="bg-gray-100 min-h-[250px] flex items-center justify-center">
                                    @if($spk->sertifikat)
                                        @if(in_array(pathinfo($spk->sertifikat, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png']))
                                            <img src="{{ asset('storage/' . $spk->sertifikat) }}" class="max-w-full max-h-[350px] object-contain rounded-lg">
                                        @else
                                            <iframe src="{{ asset('storage/' . $spk->sertifikat) }}" class="w-full h-[250px] border-0"></iframe>
                                        @endif
                                    @else
                                        <div class="flex flex-col items-center justify-center h-[250px] text-gray-400">
                                            <i class="fas fa-image text-4xl mb-2 text-gray-300"></i>
                                            <span class="text-sm font-medium">Belum diupload</span>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            {{-- Foto Penyerahan --}}
                            <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                                <div class="px-4 py-3 bg-gradient-to-r from-purple-50 to-purple-100/50 border-b border-gray-200 flex justify-between items-center">
                                    <h4 class="text-sm font-extrabold text-gray-800 flex items-center gap-2">
                                        <span class="w-7 h-7 bg-purple-500 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-camera text-white text-xs"></i>
                                        </span>
                                        Foto Penyerahan Piagam
                                    </h4>
                                    @if($spk->foto_penyerahan)
                                    <a href="{{ asset('storage/' . $spk->foto_penyerahan) }}" target="_blank" 
                                    class="inline-flex items-center gap-1 bg-purple-500 hover:bg-purple-600 text-white px-3 py-1.5 rounded-lg text-xs font-bold transition">
                                        <i class="fas fa-eye"></i> Tinjau
                                    </a>
                                    @endif
                                </div>
                                <div class="bg-gray-100 min-h-[250px] flex items-center justify-center">
                                    @if($spk->foto_penyerahan)
                                        <img src="{{ asset('storage/' . $spk->foto_penyerahan) }}" class="max-w-full max-h-[350px] object-contain rounded-lg">
                                    @else
                                        <div class="flex flex-col items-center justify-center h-[250px] text-gray-400">
                                            <i class="fas fa-camera-retro text-4xl mb-2 text-gray-300"></i>
                                            <span class="text-sm font-medium">Belum diupload</span>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            {{-- Laporan --}}
                            <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                                <div class="px-4 py-3 bg-gradient-to-r from-orange-50 to-orange-100/50 border-b border-gray-200 flex justify-between items-center">
                                    <h4 class="text-sm font-extrabold text-gray-800 flex items-center gap-2">
                                        <span class="w-7 h-7 bg-orange-500 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-file-alt text-white text-xs"></i>
                                        </span>
                                        Laporan (Format Template)
                                    </h4>
                                    @if($spk->laporan)
                                    <a href="{{ asset('storage/' . $spk->laporan) }}" target="_blank" 
                                    class="inline-flex items-center gap-1 bg-orange-500 hover:bg-orange-600 text-white px-3 py-1.5 rounded-lg text-xs font-bold transition">
                                        <i class="fas fa-eye"></i> Tinjau
                                    </a>
                                    @endif
                                </div>
                                <div class="bg-gray-100 min-h-[250px] relative">
                                    @if($spk->laporan)
                                        <iframe src="{{ asset('storage/' . $spk->laporan) }}" class="w-full h-[250px] border-0"></iframe>
                                    @else
                                        <div class="flex flex-col items-center justify-center h-[250px] text-gray-400">
                                            <i class="fas fa-file-alt text-4xl mb-2 text-gray-300"></i>
                                            <span class="text-sm font-medium">Belum diupload</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- TAB 3: RIWAYAT --}}
                    <div class="w-full flex-shrink-0 snap-start p-6">
                        <h3 class="text-gray-600 font-medium mb-6">Timeline Riwayat Pengajuan</h3>
                        
                        <div class="relative border-l-2 border-blue-200 ml-3 space-y-8">
                            <div class="relative pl-6">
                                <div class="absolute w-4 h-4 bg-blue-500 rounded-full -left-[9px] top-1 border-2 border-white shadow"></div>
                                <p class="text-xs font-semibold text-blue-600 mb-1">Status Terkini</p>
                                <h4 class="font-bold text-gray-800">SPK: {{ ucfirst($spk->status) }}</h4>
                                
                                {{-- ⚡ TAMPILKAN INFO POIN DI TIMELINE --}}
                                @if($spk->hasPoin())
                                <div class="mt-2 bg-yellow-50 border border-yellow-200 rounded-lg p-2">
                                    <p class="text-sm text-yellow-700">
                                        Poin: <strong>{{ $spk->poin }}</strong> 
                                        ({{ $spk->poin_added_at->format('d/m/Y H:i') }})
                                    </p>
                                </div>
                                @endif
                                
                                @if($spk->catatan_dosen)
                                <p class="text-sm text-gray-600 mt-1 bg-gray-50 p-3 rounded-lg border border-gray-100">
                                    <span class="font-semibold">Catatan:</span><br>
                                    {{ $spk->catatan_dosen }}
                                </p>
                                @endif
                            </div>

                            <div class="relative pl-6">
                                <div class="absolute w-4 h-4 bg-gray-300 rounded-full -left-[9px] top-1 border-2 border-white shadow"></div>
                                <p class="text-xs font-semibold text-gray-500 mb-1">{{ $spk->created_at ? $spk->created_at->translatedFormat('d F Y - H:i') : '-' }}</p>
                                <h4 class="font-bold text-gray-800">SPK Diajukan</h4>
                                <p class="text-sm text-gray-600 mt-1">
                                    Mahasiswa mengajukan SPK beserta dokumen kegiatan.
                                </p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>

</div>

{{-- ⚡ SWEET ALERT --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
// ⚡ FUNGSI TAMBAH POIN DENGAN SWEET ALERT
window.tambahPoinSweetAlert = function(spkId, judulKegiatan) {
    Swal.fire({
        title: 'Tambah Poin SPK',
        html: `
            <div class="text-left">
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 mb-4">
                    <p class="text-sm text-blue-800">
                        <strong>Judul Kegiatan:</strong><br>
                        ${judulKegiatan}
                    </p>
                </div>
                <div class="mb-4">
                    <label for="swal-poin" class="block text-sm font-bold text-gray-700 mb-2">
                        Jumlah Poin <span class="text-red-500">*</span>
                    </label>
                    <div class="flex rounded-lg shadow-sm">
                        <span class="inline-flex items-center px-3 rounded-l-lg border border-r-0 border-gray-300 bg-yellow-50 text-yellow-600">
                            
                        </span>
                        <input type="number" 
                               id="swal-poin" 
                               class="flex-1 block w-full rounded-none rounded-r-lg border border-gray-300 px-4 py-2 text-gray-900 focus:ring-yellow-500 focus:border-yellow-500" 
                               placeholder="" 
                               min="1" 
                               max="100"
                               value="1"
                               required>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Masukkan poin</p>
                </div>
            </div>
        `,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#eab308',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Simpan Poin',
        cancelButtonText: 'Batal',
        customClass: {
            confirmButton: 'rounded-lg px-6 py-2 font-semibold',
            cancelButton: 'rounded-lg px-6 py-2 font-semibold'
        },
        didOpen: () => {
            setTimeout(() => {
                document.getElementById('swal-poin').focus();
            }, 100);
        },
        preConfirm: () => {
            const poin = document.getElementById('swal-poin').value;
            
            if (!poin || poin < 1 || poin > 100) {
                Swal.showValidationMessage('Poin harus diisi antara 1 - 100');
                return false;
            }
            
            return poin;
        }
    }).then((result) => {
        if (result.isConfirmed) {
            const poin = result.value;
            
            // Tampilkan loading
            Swal.fire({
                title: 'Menyimpan Poin...',
                text: 'Sedang memproses penambahan poin',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            
            // Kirim request AJAX
            fetch(`/admin/spk/${spkId}/tambah-poin`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ poin: poin })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: data.message,
                        showConfirmButton: true,
                        timer: 3000
                    }).then(() => {
                        // Reload halaman
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: data.message || 'Terjadi kesalahan'
                    });
                }
            })
            .catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: 'Terjadi kesalahan saat menyimpan poin'
                });
            });
        }
    });
};

// Validasi input poin di Sweet Alert
document.addEventListener('input', function(e) {
    if (e.target.id === 'swal-poin') {
        let val = parseInt(e.target.value);
        if (isNaN(val)) val = 1;
        if (val < 1) e.target.value = 1;
        if (val > 100) e.target.value = 100;
    }
});

// ⚡ FUNGSI TAB (Tetap seperti sebelumnya)
window.geserTab = function(index) {
    var container = document.getElementById('tab-content-container');
    if (!container) return;
    container.scrollTo({ left: container.clientWidth * index, behavior: 'smooth' });
    window.updateGayaTab(index);
};

window.updateGayaTab = function(index) {
    var buttons = document.querySelectorAll('.tab-btn');
    buttons.forEach((btn, i) => {
        if (i === index) {
            btn.className = "tab-btn bg-white border-t border-l border-r border-gray-200 rounded-t-xl px-6 py-3 -mb-[1px] relative z-10 font-bold text-gray-800 whitespace-nowrap transition cursor-pointer";
        } else {
            btn.className = "tab-btn px-6 py-3 text-gray-500 font-bold hover:text-gray-700 whitespace-nowrap border-b border-transparent transition cursor-pointer";
        }
    });
};

(function() {
    var container = document.getElementById('tab-content-container');
    if (container) {
        container.onscroll = function() {
            var indexAktif = Math.round(container.scrollLeft / container.clientWidth);
            window.updateGayaTab(indexAktif);
        };
    }
})();

// ⚡ FUNGSI APPROVE & REJECT (Update pakai AJAX/POST)
window.approveSpk = function(id) {
    Swal.fire({
        title: 'Setujui SPK (Admin)',
        input: 'textarea',
        inputLabel: 'Catatan Admin (Opsional)',
        inputPlaceholder: 'Masukkan catatan persetujuan...',
        showCancelButton: true,
        confirmButtonText: 'Setujui',
        confirmButtonColor: '#16a34a',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if(result.isConfirmed) {
            fetch(`/admin/spk/${id}/approve`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ catatan: result.value || '' })
            })
            .then(response => response.json())
            .then(data => {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: data.message || 'SPK berhasil disetujui',
                    timer: 2000
                }).then(() => location.reload());
            })
            .catch(() => {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: 'Terjadi kesalahan'
                });
            });
        }
    });
};

window.rejectSpk = function(id) {
    Swal.fire({
        title: 'Tolak SPK (Admin)',
        input: 'textarea',
        inputLabel: 'Alasan Penolakan (Wajib)',
        inputPlaceholder: 'Masukkan alasan penolakan...',
        showCancelButton: true,
        confirmButtonText: 'Tolak',
        confirmButtonColor: '#dc2626',
        cancelButtonText: 'Batal',
        inputValidator: (value) => {
            if (!value) return 'Alasan wajib diisi';
        }
    }).then((result) => {
        if(result.isConfirmed) {
            fetch(`/admin/spk/${id}/reject`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ catatan: result.value })
            })
            .then(response => response.json())
            .then(data => {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: data.message || 'SPK berhasil ditolak',
                    timer: 2000
                }).then(() => location.reload());
            })
            .catch(() => {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: 'Terjadi kesalahan'
                });
            });
        }
    });
};

// ⚡ TAMBAH POIN
function tambahPoin(spkId, judulKegiatan) {
    Swal.fire({
        title: 'Tambah Poin SPK',
        html: `
            <div class="text-left">
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 mb-4">
                    <p class="text-sm text-blue-800"><strong>Judul:</strong><br>${judulKegiatan}</p>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Jumlah Poin <span class="text-red-500">*</span></label>
                    <input type="number" id="swal-poin" class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm" placeholder="Masukkan poin (1-100)" min="1" max="100" value="1" required>
                </div>
            </div>
        `,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#eab308',
        cancelButtonColor: '#6b7280',
        confirmButtonText: '💾 Simpan Poin',
        cancelButtonText: '❌ Batal',
        didOpen: () => { setTimeout(() => document.getElementById('swal-poin').focus(), 100); },
        preConfirm: () => {
            const poin = document.getElementById('swal-poin').value;
            if (!poin || poin < 1 || poin > 100) { Swal.showValidationMessage('Poin harus diisi antara 1 - 100'); return false; }
            return poin;
        }
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({ title: 'Menyimpan...', allowOutsideClick: false, didOpen: () => Swal.showLoading() });
            fetch(`/admin/spk/${spkId}/tambah-poin`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify({ poin: result.value })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) { Swal.fire({ icon: 'success', title: 'Berhasil!', text: data.message, timer: 2000, showConfirmButton: false }).then(() => location.reload()); }
                else Swal.fire({ icon: 'error', title: 'Gagal!', text: data.message });
            });
        }
    });
}

// ⚡ EDIT POIN
function editPoin(spkId, poinSekarang, judulKegiatan) {
    Swal.fire({
        title: 'Edit Poin SPK',
        html: `
            <div class="text-left">
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 mb-4">
                    <p class="text-sm text-blue-800"><strong>Judul:</strong><br>${judulKegiatan}</p>
                    <p class="text-sm text-blue-800 mt-1"><strong>Poin Saat Ini:</strong> ${poinSekarang}</p>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Jumlah Poin Baru <span class="text-red-500">*</span></label>
                    <input type="number" id="swal-poin" class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm" min="1" max="100" value="${poinSekarang}" required>
                </div>
            </div>
        `,
        showCancelButton: true,
        confirmButtonColor: '#3b82f6',
        confirmButtonText: 'Update Poin',
        preConfirm: () => {
            const poin = document.getElementById('swal-poin').value;
            if (!poin || poin < 1 || poin > 100) { Swal.showValidationMessage('Poin harus 1-100'); return false; }
            return poin;
        }
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({ title: 'Mengupdate...', allowOutsideClick: false, didOpen: () => Swal.showLoading() });
            
            // ⚡ PAKAI ROUTE edit-poin
            fetch(`/admin/spk/${spkId}/edit-poin`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
                body: JSON.stringify({ poin: result.value })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) { Swal.fire({ icon: 'success', title: 'Berhasil!', text: data.message, timer: 2000 }).then(() => location.reload()); }
                else Swal.fire({ icon: 'error', title: 'Gagal!', text: data.message });
            });
        }
    });
}
</script>

</x-app-layout>
