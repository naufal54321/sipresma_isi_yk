<x-guest-layout>
    <div class="w-full max-w-md mx-auto px-4 py-8 relative z-10 animate-fade-in-up">

        {{-- Kartu Verifikasi — Glassmorphism --}}
        <div class="bg-white/10 backdrop-blur-xl border border-white/20 rounded-3xl p-8 md:p-10 shadow-2xl shadow-black/30 relative overflow-hidden">

            {{-- Elemen Dekoratif --}}
            <div class="absolute -top-16 -right-16 w-32 h-32 bg-blue-400/20 rounded-full blur-3xl animate-pulse-slow"></div>
            <div class="absolute -bottom-16 -left-16 w-32 h-32 bg-purple-400/20 rounded-full blur-3xl animate-pulse-slow animation-delay-2000"></div>

            {{-- Icon --}}
            <div class="flex justify-center mb-6 animate-float">
                <div class="w-20 h-20 rounded-2xl bg-white/10 border border-white/20 flex items-center justify-center">
                    <span class="material-symbols-outlined text-white text-5xl">mark_email_read</span>
                </div>
            </div>

            {{-- Judul --}}
            <h2 class="text-2xl font-bold text-white text-center mb-3">
                Periksa Email Anda
            </h2>

            <p class="text-white/70 text-sm text-center leading-relaxed mb-8">
                Terima kasih telah mendaftar! Kami telah mengirimkan tautan verifikasi ke email Anda.
                Klik tautan tersebut untuk mengaktifkan akun.
            </p>

            {{-- Langkah-langkah --}}
            <div class="space-y-4 mb-8">
                <div class="flex items-center gap-4 bg-white/5 rounded-xl p-4 border border-white/10 animate-fade-in-up animation-delay-200">
                    <span class="w-8 h-8 rounded-lg bg-blue-500/20 flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-blue-300 text-xl">mail</span>
                    </span>
                    <div>
                        <p class="text-white font-semibold text-sm">Cek Kotak Masuk Email</p>
                        <p class="text-white/50 text-xs">Cari email dari PRATAMA di inbox Anda</p>
                    </div>
                </div>

                <div class="flex items-center gap-4 bg-white/5 rounded-xl p-4 border border-white/10 animate-fade-in-up animation-delay-300">
                    <span class="w-8 h-8 rounded-lg bg-green-500/20 flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-green-300 text-xl">how_to_reg</span>
                    </span>
                    <div>
                        <p class="text-white font-semibold text-sm">Klik Tautan Verifikasi</p>
                        <p class="text-white/50 text-xs">Konfirmasi alamat email Anda dalam satu klik</p>
                    </div>
                </div>

                <div class="flex items-center gap-4 bg-white/5 rounded-xl p-4 border border-white/10 animate-fade-in-up animation-delay-400">
                    <span class="w-8 h-8 rounded-lg bg-purple-500/20 flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-purple-300 text-xl">login</span>
                    </span>
                    <div>
                        <p class="text-white font-semibold text-sm">Masuk ke Dashboard</p>
                        <p class="text-white/50 text-xs">Akses penuh setelah verifikasi berhasil</p>
                    </div>
                </div>
            </div>

            {{-- Tombol --}}
            <div class="flex flex-col gap-3 animate-fade-in-up animation-delay-500">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit"
                        class="ripple-btn w-full rounded-full bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-500 hover:to-blue-400 text-white py-3 text-base font-semibold transition-all duration-300 shadow-lg hover:shadow-blue-500/50 transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined text-xl">refresh</span>
                        Kirim Ulang Email
                    </button>
                </form>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="ripple-btn w-full rounded-full bg-white/10 hover:bg-white/20 border border-white/20 text-white py-3 text-base font-semibold transition-all duration-300 flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined text-xl">logout</span>
                        Keluar
                    </button>
                </form>
            </div>

            {{-- Footer info --}}
            <p class="text-white/40 text-xs text-center mt-6 animate-fade-in animation-delay-600">
                Tidak menerima email? Periksa folder spam atau klik "Kirim Ulang"
            </p>

        </div>

        {{-- Footer copyright --}}
        <p class="text-white/40 text-xs text-center mt-6 animate-fade-in animation-delay-700">
            &copy; 2026 UPA TIK Institut Seni Indonesia Yogyakarta
        </p>

    </div>

    {{-- SweetAlert untuk notifikasi --}}
    @if (session('status') == 'verification-link-sent')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11" defer></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Terkirim!',
                    text: 'Tautan verifikasi baru telah dikirim ke email Anda.',
                    timer: 3500,
                    showConfirmButton: false,
                    toast: true,
                    position: 'top-end',
                    customClass: { popup: 'rounded-2xl shadow-xl border border-gray-100' }
                });
            });
        </script>
    @endif
</x-guest-layout>
