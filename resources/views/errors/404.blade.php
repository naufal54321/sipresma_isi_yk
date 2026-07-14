<x-guest-layout>
    <div class="text-center">
        <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-yellow-100 mb-6">
            <svg class="w-10 h-10 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
            </svg>
        </div>
        <h1 class="text-6xl font-extrabold text-white mb-2">404</h1>
        <p class="text-xl font-semibold text-white/80 mb-2">Halaman Tidak Ditemukan</p>
        <p class="text-white/60 mb-8 max-w-md mx-auto">Halaman yang Anda cari tidak tersedia atau telah dipindahkan.</p>
        <a href="{{ url('/dashboard') }}" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-500 text-white px-6 py-3 rounded-xl font-semibold transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Dashboard
        </a>
    </div>
</x-guest-layout>
