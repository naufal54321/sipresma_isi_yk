<x-guest-layout>
    <div class="min-h-screen flex flex-col items-center justify-between bg-slate-50">
        
        <div class="flex-grow flex items-center justify-center w-full p-4">
            <div class="max-w-md w-full bg-white shadow-xl rounded-2xl overflow-hidden border border-slate-200 p-8 text-center">
                
                <div class="w-20 h-20 bg-blue-50 rounded-full flex items-center justify-center mx-auto mb-6 ring-4 ring-white shadow-sm">
                    <i class="fas fa-envelope-open-text text-3xl text-blue-600"></i>
                </div>

                <h2 class="text-2xl font-bold text-slate-800 mb-3">Periksa Email Anda</h2>

                <p class="text-sm text-slate-500 mb-8 leading-relaxed">
                    Terima kasih telah mendaftar di SIPRESMA! Sebelum memulai, harap verifikasi alamat email Anda dengan mengeklik tautan yang baru saja kami kirimkan. 
                    Jika Anda tidak menerima email tersebut, kami akan mengirimkan ulang.
                </p>

                <div class="flex flex-col gap-3">
                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-4 rounded-xl transition-all duration-200 shadow-sm flex justify-center items-center gap-2">
                            <i class="fas fa-paper-plane"></i> Kirim Ulang Email
                        </button>
                    </form>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold py-3 px-4 rounded-xl transition-all duration-200 flex justify-center items-center gap-2">
                            <i class="fas fa-sign-out-alt"></i> Keluar
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <footer class="w-full py-5 text-center text-sm text-slate-500 border-t border-slate-200 bg-white/50 backdrop-blur-sm shrink-0">
            &copy; 2026 UPA TIK Institut Seni Indonesia Yogyakarta
        </footer>

    </div>

    @if (session('status') == 'verification-link-sent')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</x-guest-layout>