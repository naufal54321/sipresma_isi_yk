<nav class="fixed top-0 left-0 z-40 w-64 h-screen bg-[#16233b] text-white shadow-xl">

    <div class="flex items-center gap-3 px-6 py-5 border-b border-white/10">
        <img src="{{ asset('images/logo_isi_dashboard.png') }}"
             class="w-12 h-12"
             alt="Logo">
        <div>
            <h1 class="text-xl font-bold text-gray-400">SIPRESMA</h1>
            <p class="text-xs text-gray-400">Sistem Prestasi Mahasiswa</p>
        </div>
    </div>

    <div class="px-6 py-6 border-b border-white/10">
        <h2 class="font-bold text-sm">
            {{ auth()->user()->name }}
        </h2>
        <p class="text-sm text-gray-400 mt-1">
            @foreach(auth()->user()->roles as $role)
                ({{ $role->name }})
            @endforeach
        </p>
    </div>

    <div class="py-4 space-y-1">

        <p class="px-6 mb-2 text-xs text-gray-500 uppercase font-semibold">Menu</p>

        <a href="{{ route('dashboard') }}"
           class="flex items-center gap-3 px-6 py-3 transition border-l-4 {{ request()->routeIs('dashboard') ? 'bg-gray-900 border-yellow-500 text-white' : 'border-transparent text-gray-400 hover:bg-gray-800 hover:text-white' }}">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
            </svg>

            <span>Home</span>
        </a>

        @role('Admin')

        <a href="{{ route('admin.users.approval') }}"
           class="flex items-center gap-3 px-6 py-3 transition border-l-4 {{ request()->routeIs('admin.users.approval') ? 'bg-gray-900 border-yellow-500 text-white' : 'border-transparent text-gray-400 hover:bg-gray-800 hover:text-white' }}">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
</svg>



            <span>Persetujuan Akun</span>
        </a>
        <a href="{{ route('admin.dashboard') }}"
           class="flex items-center gap-3 px-6 py-3 transition border-l-4 {{ request()->routeIs('admin.dashboard') ? 'bg-gray-900 border-yellow-500 text-white' : 'border-transparent text-gray-400 hover:bg-gray-800 hover:text-white' }}">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z" />
            </svg>

            <span>Daftar Pengguna</span>
        </a>

        <a href="{{ route('admin.pembimbing.index') }}"
           class="flex items-center gap-3 px-6 py-3 transition border-l-4 {{ request()->routeIs('admin.pembimbing.*') ? 'bg-gray-900 border-yellow-500 text-white' : 'border-transparent text-gray-400 hover:bg-gray-800 hover:text-white' }}">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5" />
            </svg>

            <span>Dosen Pembimbing</span>
        </a>

       <a href="{{ route('admin.kegiatan.index') }}"
    class="flex items-center gap-3 px-6 py-3 transition border-l-4 {{ request()->routeIs('admin.kegiatan.*') ? 'bg-gray-900 border-yellow-500 text-white' : 'border-transparent text-gray-400 hover:bg-gray-800 hover:text-white' }}">

    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M6 6.878V6a2.25 2.25 0 0 1 2.25-2.25h7.5A2.25 2.25 0 0 1 18 6v.878m-12 0c.235-.083.487-.128.75-.128h10.5c.263 0 .515.045.75.128m-12 0A2.25 2.25 0 0 0 4.5 9v.878m13.5-3A2.25 2.25 0 0 1 19.5 9v.878m0 0a2.246 2.246 0 0 0-.75-.128H5.25c-.263 0-.515.045-.75.128m15 0A2.25 2.25 0 0 1 21 12v6a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 18v-6c0-.98.626-1.813 1.5-2.122" />
</svg>


    <span>Master Kegiatan</span>

</a>

 <a href="{{ route('admin.prodi.index') }}"
    class="flex items-center gap-3 px-6 py-3 transition border-l-4 {{ request()->routeIs('admin.prodi.*') ? 'bg-gray-900 border-yellow-500 text-white' : 'border-transparent text-gray-400 hover:bg-gray-800 hover:text-white' }}">

    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M6.429 9.75 2.25 12l4.179 2.25m0-4.5 5.571 3 5.571-3m-11.142 0L2.25 7.5 12 2.25l9.75 5.25-4.179 2.25m0 0L21.75 12l-4.179 2.25m0 0 4.179 2.25L12 21.75 2.25 16.5l4.179-2.25m11.142 0-5.571 3-5.571-3" />
</svg>



    <span>Master Prodi</span>

</a>

<a href="{{ route('admin.laporan.index') }}"
    class="flex items-center gap-3 px-6 py-3 transition border-l-4 {{ request()->routeIs('admin.laporan.*') ? 'bg-gray-900 border-yellow-500 text-white' : 'border-transparent text-gray-400 hover:bg-gray-800 hover:text-white' }}">

    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
</svg>




    <span>Laporan</span>

</a>
        @endrole

        @role('Dosen')
        <a href="{{ route('dosen.mahasiswa.index') }}"
           class="flex items-center gap-3 px-6 py-3 transition border-l-4 {{ request()->routeIs('dosen.mahasiswa.*') ? 'bg-gray-900 border-yellow-500 text-white' : 'border-transparent text-gray-400 hover:bg-gray-800 hover:text-white' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
            </svg>
            <span>Mahasiswa Bimbingan</span>
        </a>

        <div x-data="{ open: {{ request()->routeIs('dosen.rpk.*', 'dosen.spk.*') ? 'true' : 'false' }} }">
            <button @click="open = !open"
                    class="flex items-center justify-between w-full px-6 py-3 transition border-l-4 {{ request()->routeIs('dosen.rpk.*', 'dosen.spk.*') ? 'bg-gray-900 border-yellow-500 text-white' : 'border-transparent text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                <div class="flex items-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z" />
                    </svg>
                    <span>Validasi</span>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 transform transition" :class="open ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                </svg>
            </button>

            <div x-show="open" class="bg-[#111b2e] py-2">
                <a href="{{ route('dosen.rpk.index') }}"
                   class="flex items-center gap-3 pl-14 pr-6 py-2 transition {{ request()->routeIs('dosen.rpk.*') ? 'text-white font-semibold' : 'text-gray-400 hover:text-white' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                    </svg>
                    RPK
                </a>
                <a href="{{ route('dosen.spk.index') }}"
                   class="flex items-center gap-3 pl-14 pr-6 py-2 transition {{ request()->routeIs('dosen.spk.*') ? 'text-white font-semibold' : 'text-gray-400 hover:text-white' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                    </svg>
                    SPK
                </a>
            </div>
        </div>
        @endrole

        @role('Mahasiswa')
        <a href="{{ route('rpks.index') }}"
           class="flex items-center gap-3 px-6 py-3 transition border-l-4 {{ request()->routeIs('rpks.*') ? 'bg-gray-900 border-yellow-500 text-white' : 'border-transparent text-gray-400 hover:bg-gray-800 hover:text-white' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
            </svg>
            <span>RPK</span>
        </a>

        <a href="{{ route('spks.index') }}"
           class="flex items-center gap-3 px-6 py-3 transition border-l-4 {{ request()->routeIs('spks.*') ? 'bg-gray-900 border-yellow-500 text-white' : 'border-transparent text-gray-400 hover:bg-gray-800 hover:text-white' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
            </svg>
            <span>SPK</span>
        </a>
        @endrole

        <p class="px-6 mt-4 mb-2 text-xs text-gray-500 uppercase font-semibold">Setting</p>

        <a href="{{ route('profile.edit') }}"
           class="flex items-center gap-3 px-6 py-3 transition border-l-4 {{ request()->routeIs('profile.edit') ? 'bg-gray-900 border-yellow-500 text-white' : 'border-transparent text-gray-400 hover:bg-gray-800 hover:text-white' }}">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
            </svg>


            <span>Profile</span>
        </a>

    </div>

    <div class="absolute bottom-0 w-full p-6 border-t border-white/10 bg-[#16233b]">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="w-full flex justify-center items-center gap-2 bg-red-500/10 text-red-500 hover:bg-red-500 hover:text-white py-3 rounded-xl font-semibold transition border border-red-500/20">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                </svg>
                Logout
            </button>
        </form>
    </div>

</nav>