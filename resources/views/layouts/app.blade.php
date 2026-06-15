<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    </head>

    <body class="font-sans antialiased bg-gray-100">

        <div class="min-h-screen flex">

            @include('layouts.navigation')

            <div class="flex-1 ml-64">

                @isset($header)
                    <header class="bg-white shadow">
                        <div class="px-8 py-6">
                            {{ $header }}
                        </div>
                    </header>
                @endisset

                <div class="bg-white shadow-sm border-b px-8 py-4 flex items-center justify-between">

                    <div>
                        <h1 class="text-2xl font-bold text-white"></h1>
                        <p class="text-sm text-white"></p>
                    </div>

                    <div class="relative" x-data="{ open: false }" @click.outside="open = false">
                        
                        <button @click="open = !open" class="flex items-center gap-4 hover:bg-gray-50 p-2 rounded-xl transition focus:outline-none">
                            
                            <div class="text-right">
                                <h2 class="font-semibold text-gray-800">
                                    {{ auth()->user()->name }}
                                </h2>
                                <p class="text-sm text-gray-500">
                                    @foreach(auth()->user()->roles as $role)
                                        {{ $role->name }}
                                    @endforeach
                                </p>
                            </div>

                            <div>
                                <img
                                    src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=2563eb&color=fff"
                                    alt="Profile"
                                    class="w-12 h-12 rounded-full border-2 border-blue-500 shadow">
                            </div>

                            <i class="fas fa-chevron-down text-gray-400 text-sm transition-transform duration-200" 
                               :class="{'rotate-180': open}"></i>

                        </button>

                        <div x-show="open" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             class="absolute right-0 mt-3 w-48 bg-white border border-gray-100 rounded-xl shadow-lg py-2 z-50"
                             style="display: none;">

                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition">
                                <i class="fas fa-user w-5"></i> Kelola Profil
                            </a>

                            <div class="border-t border-gray-100 my-1"></div>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition">
                                    <i class="fas fa-sign-out-alt w-5"></i> Logout
                                </button>
                            </form>

                        </div>

                    </div>

                </div>

                <main class="p-8">
                    {{ $slot }}
                </main>

            </div>

        </div>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        @if(session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: '{{ session('success') }}',
                confirmButtonColor: '#2563eb',
                timer: 2500,
                showConfirmButton: false
            });
        </script>
        @endif

        @if(session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '{{ session('error') }}',
                confirmButtonColor: '#dc2626',
            });
        </script>
        @endif

    </body>
</html>