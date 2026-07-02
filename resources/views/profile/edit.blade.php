<x-app-layout>

   @if (session('status') === 'profile-updated' || session('status') === 'password-updated')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Tentukan teks berdasarkan status session
            let alertText = '';
            @if(session('status') === 'profile-updated')
                alertText = 'Profil berhasil diperbarui';
            @elseif(session('status') === 'password-updated')
                alertText = 'Password berhasil diperbarui';
            @endif

            // Konfigurasi Toast Modern
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                background: '#ffffff',
                color: '#0f172a',        // Slate 900 untuk teks
                iconColor: '#10b981',    // Emerald 500 untuk ikon sukses
                
                // Animasi saat kursor diarahkan ke notifikasi
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                    
                    // Injeksi gaya modern
                    toast.style.borderRadius = '16px';
                    toast.style.padding = '12px 20px';
                    toast.style.border = '1px solid #f1f5f9'; // Slate 100
                    toast.style.boxShadow = '0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -4px rgba(0, 0, 0, 0.1)';
                }
            });

            // Eksekusi Toast
            Toast.fire({
                icon: 'success',
                title: alertText
            });
        });
    </script>
@endif

    <div class="max-w-7xl mx-auto py-8">

        <div class="mb-8">
            <h1 class="text-3xl font-bold text-slate-800">
                Kelola Profil
            </h1>
            <p class="text-slate-500 mt-1">
                Perbarui informasi akun, ubah password, dan kelola keamanan akun Anda.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">

            <div class="lg:col-span-1">

                <div class="bg-white rounded-3xl shadow-lg border border-slate-100 p-8 sticky top-24">

                    <div class="flex flex-col items-center">

                        <img
                            src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=eff6ff&color=2563eb&bold=true&size=256"
                            class="w-28 h-28 rounded-full shadow ring-4 ring-blue-100">

                        <h2 class="mt-5 text-xl font-bold text-slate-800">
                            {{ auth()->user()->name }}
                        </h2>

                        <p class="text-sm text-slate-500 mt-1">
                            {{ auth()->user()->email }}
                        </p>

                        @php
                            $role = auth()->user()->roles->first()?->name;
                        @endphp

                        @if($role == 'Admin')
                            <span class="mt-4 px-4 py-1 rounded-full bg-red-100 text-red-600 text-xs font-semibold">
                                Admin
                            </span>

                        @elseif($role == 'Dosen')
                            <span class="mt-4 px-4 py-1 rounded-full bg-green-100 text-green-700 text-xs font-semibold">
                                Dosen
                            </span>

                        @else
                            <span class="mt-4 px-4 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-semibold">
                                Mahasiswa
                            </span>
                        @endif

                    </div>

                    <div class="mt-8 border-t pt-6 space-y-3 text-sm">

                        <div class="flex justify-between">
                            <span class="text-slate-500">NIM</span>
                            <span class="font-semibold text-slate-700">
                                {{ auth()->user()->nim }}
                            </span>
                        </div>

                        <div class="flex justify-between">
                            <span class="text-slate-500">Program Studi</span>
                            <span class="font-semibold text-slate-700">
                                {{ auth()->user()->prodi ?? '-' }}
                            </span>
                        </div>

                    </div>

                </div>

            </div>

            <div class="lg:col-span-3 space-y-8">

                <div class="bg-white rounded-3xl shadow-lg border border-slate-100 overflow-hidden">

                    <div class="px-8 py-5 border-b bg-gradient-to-r from-blue-600 to-indigo-600">

                        <h2 class="text-xl font-bold text-white">
                            Informasi Profil
                        </h2>

                        <p class="text-blue-100 text-sm mt-1">
                            Perbarui data pribadi Anda.
                        </p>

                    </div>

                    <div class="p-8">
                        @include('profile.partials.update-profile-information-form')
                    </div>

                </div>

                <div class="bg-white rounded-3xl shadow-lg border border-slate-100 overflow-hidden">

                    <div class="px-8 py-5 border-b bg-gradient-to-r from-emerald-600 to-teal-600">

                        <h2 class="text-xl font-bold text-white">
                            Ubah Password
                        </h2>

                        <p class="text-emerald-100 text-sm mt-1">
                            Gunakan password yang kuat untuk menjaga keamanan akun.
                        </p>

                    </div>

                    <div class="p-8">
                        @include('profile.partials.update-password-form')
                    </div>

                </div>

                <div class="bg-white rounded-3xl shadow-lg border border-red-200 overflow-hidden">

                    <div class="px-8 py-5 border-b bg-gradient-to-r from-red-600 to-rose-600">

                        <h2 class="text-xl font-bold text-white">
                            Zona Berbahaya
                        </h2>

                        <p class="text-red-100 text-sm mt-1">
                            Tindakan di bawah ini tidak dapat dibatalkan.
                        </p>

                    </div>

                    <div class="p-8">
                        @include('profile.partials.delete-user-form')
                    </div>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>