<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>

        <meta charset="utf-8">

        <meta name="viewport"
              content="width=device-width, initial-scale=1">

        <meta name="csrf-token"
              content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect"
              href="https://fonts.bunny.net">

        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap"
              rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

    </head>

    <body class="font-sans antialiased bg-gray-100">

        <div class="min-h-screen flex">

            <!-- Sidebar -->
            @include('layouts.navigation')

            <!-- Content -->
            <div class="flex-1 ml-64">

                <!-- Header -->
                @isset($header)

                    <header class="bg-white shadow">

                        <div class="px-8 py-6">

                            {{ $header }}

                        </div>

                    </header>

                @endisset

                <!-- Top Navbar -->
<div class="bg-white shadow-sm border-b px-8 py-4 flex items-center justify-between">

    <!-- Left -->
    <div>

        <h1 class="text-2xl font-bold text-gray-800">
            SIPRESMA Dashboard
        </h1>

        <p class="text-sm text-gray-500">
            Sistem Informasi Prestasi Mahasiswa
        </p>

    </div>

    <!-- Right -->
    <div class="flex items-center gap-4">

        <!-- Nama -->
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

        <!-- Foto Profil -->
        <div>

            <img
                src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=2563eb&color=fff"
                alt="Profile"
                class="w-12 h-12 rounded-full border-2 border-blue-500 shadow">

        </div>

    </div>

</div>

<!-- Main -->
<main class="p-8">

    {{ $slot }}

</main>

            </div>

        </div>

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
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

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