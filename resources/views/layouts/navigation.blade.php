<nav class="fixed top-0 left-0 z-40 w-64 h-screen bg-[#16233b] text-white shadow-xl">

    <!-- Logo -->
    <div class="flex items-center gap-3 px-6 py-5 border-b border-white/10">

        <img src="{{ asset('images/logo-isi2.png') }}"
             class="w-12 h-12"
             alt="Logo">

        <div>
            <h1 class="text-xl font-bold text-yellow-600">
                SIPRESMA
            </h1>

            <p class="text-xs text-yellow-600">
                Sistem Prestasi Mahasiswa
            </p>
        </div>

    </div>

    <!-- User -->
    <div class="px-6 py-6 border-b border-white/10">

        <h2 class="font-bold uppercase text-sm">
            {{ auth()->user()->name }}
        </h2>

        <p class="text-sm text-gray-300 mt-1">

            @foreach(auth()->user()->roles as $role)

                ({{ $role->name }})

            @endforeach

        </p>

    </div>

    <!-- Menu -->
    <div class="py-4">

        <p class="px-6 mb-2 text-xs text-gray-400 uppercase">
            Menu
        </p>

        <!-- Dashboard -->
        <a href="{{ route('dashboard') }}"
           class="flex items-center gap-3 px-6 py-3 hover:bg-blue-700 transition">

            <svg xmlns="http://www.w3.org/2000/svg"
                 class="w-5 h-5"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke="currentColor">

                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M3 12l2-2m0 0l7-7 7 7m-9 2v8m0-8H5m7 0h7" />

            </svg>

            <span>Home</span>

        </a>

        <!-- Admin -->
        @role('Admin')

        <a href="{{ route('admin.dashboard') }}"
           class="flex items-center gap-3 px-6 py-3 hover:bg-blue-700 transition">

            <svg xmlns="http://www.w3.org/2000/svg"
                 class="w-5 h-5"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke="currentColor">

                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M9 17v-2a4 4 0 014-4h4" />

            </svg>

            <span>Daftar Pengguna</span>

        </a>

        @endrole

        <!-- Profile -->
        <a href="{{ route('profile.edit') }}"
           class="flex items-center gap-3 px-6 py-3 hover:bg-blue-700 transition">

            <svg xmlns="http://www.w3.org/2000/svg"
                 class="w-5 h-5"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke="currentColor">

                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M5.121 17.804A9 9 0 1118.88 17.804" />

            </svg>

            <span>Profile</span>

        </a>

    </div>

    <!-- Logout -->
    <div class="absolute bottom-0 w-full p-6">

        <form method="POST"
              action="{{ route('logout') }}">

            @csrf

            <button
                class="w-full bg-red-500 hover:bg-red-600 text-white py-3 rounded-xl font-semibold transition">

                Logout

            </button>

        </form>

    </div>

</nav>