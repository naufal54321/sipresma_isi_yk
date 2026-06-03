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

        <a href="{{ route('admin.pembimbing.index') }}"
   class="flex items-center gap-3 px-6 py-3 hover:bg-blue-700 transition">

    <!-- Icon -->
    <svg xmlns="http://www.w3.org/2000/svg"
         class="w-5 h-5"
         fill="none"
         viewBox="0 0 24 24"
         stroke="currentColor">

        <path stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M12 14l9-5-9-5-9 5 9 5z" />

        <path stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 01-6.825-2.998 12.083 12.083 0 01.665-6.479L12 14z" />

    </svg>

    <span>Penentuan Dosen Pembimbing</span>

</a>

        @endrole

        

        @role('Dosen')

        <!-- Mahasiswa Bimbingan (TANPA DROPDOWN) -->
<a href="{{ route('dosen.mahasiswa.index') }}"
   class="flex items-center gap-3 px-6 py-3 hover:bg-blue-700 transition">

    <!-- Icon -->
    <svg xmlns="http://www.w3.org/2000/svg"
         class="w-5 h-5"
         fill="none"
         viewBox="0 0 24 24"
         stroke="currentColor">

        <path stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M12 12c2.28 0 4-1.72 4-4s-1.72-4-4-4-4 1.72-4 4 1.72 4 4 4z" />

        <path stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M6 20a6 6 0 0112 0" />

    </svg>

    <span>Mahasiswa Bimbingan</span>

</a>
<div x-data="{ open: false }" class="px-6">

    <!-- Tombol Dropdown -->
    <button @click="open = !open"
            class="flex items-center justify-between w-full py-3 hover:bg-blue-700 transition px-3 rounded">

        <div class="flex items-center gap-3">
            <!-- Icon -->
            <svg xmlns="http://www.w3.org/2000/svg"
                 class="w-5 h-5"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke="currentColor">

                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />

            </svg>

            <span>Validasi</span>
        </div>

        <!-- Arrow -->
        <svg xmlns="http://www.w3.org/2000/svg"
             class="w-4 h-4 transform transition"
             :class="open ? 'rotate-180' : ''"
             fill="none"
             viewBox="0 0 24 24"
             stroke="currentColor">

            <path stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M19 9l-7 7-7-7" />

        </svg>

    </button>

    <!-- Dropdown Menu -->
    <div x-show="open" class="ml-8 mt-2 space-y-2">

        <!-- RPK -->
        <a href="{{ route('dosen.kegiatan.index') }}"
           class="block py-2 px-3 rounded hover:bg-blue-700 transition">
            📄 RPK
        </a>

        <!-- SPK -->
        <a href="{{ route('dosen.spk.index') }}"
           class="block py-2 px-3 rounded hover:bg-blue-700 transition">
            📊 SPK
        </a>

    </div>

</div>
@endrole

       @role('Mahasiswa')

<a href="{{ route('rpks.index') }}"
   class="flex items-center gap-3 px-6 py-3 hover:bg-blue-700 transition">
    <span>RPK</span>
</a>

<a href="{{ route('spks.index') }}"
   class="flex items-center gap-3 px-6 py-3 hover:bg-blue-700 transition">
    <span>SPK</span>
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