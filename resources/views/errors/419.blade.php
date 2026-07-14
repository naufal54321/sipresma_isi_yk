<x-guest-layout>
    <div class="text-center">
        <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-orange-100 mb-6">
            <svg class="w-10 h-10 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m0 0v2m0-2h2m-2 0H9m3-3a9 9 0 100-18 9 9 0 000 18z"/>
            </svg>
        </div>
        <h1 class="text-6xl font-extrabold text-white mb-2">419</h1>
        <p class="text-xl font-semibold text-white/80 mb-2">Sesi Berakhir</p>
        <p class="text-white/60 mb-8 max-w-md mx-auto">Sesi Anda telah berakhir. Silakan login kembali.</p>
        <a href="{{ route('login') }}" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-500 text-white px-6 py-3 rounded-xl font-semibold transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
            Login Ulang
        </a>
    </div>
</x-guest-layout>
