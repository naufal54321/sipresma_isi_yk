<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SIPRESMA') }}</title>

    <link rel="icon" type="image/png" href="{{ asset('images/logo_isi_dashboard.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/logo_isi_dashboard.png') }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Animasi modern untuk background */
        @keyframes blob1 {
            0%, 100% { transform: translate(0, 0) scale(1); }
            25% { transform: translate(30px, -50px) scale(1.1); }
            50% { transform: translate(-20px, -100px) scale(0.9); }
            75% { transform: translate(-40px, -30px) scale(1.05); }
        }
        
        @keyframes blob2 {
            0%, 100% { transform: translate(0, 0) scale(1); }
            25% { transform: translate(-30px, 50px) scale(0.9); }
            50% { transform: translate(40px, 80px) scale(1.1); }
            75% { transform: translate(20px, 40px) scale(0.95); }
        }

        @keyframes blob3 {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(50px, -30px) scale(1.05); }
            66% { transform: translate(-30px, -60px) scale(0.95); }
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-15px) rotate(5deg); }
        }

        @keyframes pulse-slow {
            0%, 100% { opacity: 0.3; }
            50% { opacity: 0.6; }
        }

        @keyframes gradient-shift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .animate-blob1 { animation: blob1 20s infinite ease-in-out; }
        .animate-blob2 { animation: blob2 25s infinite ease-in-out; }
        .animate-blob3 { animation: blob3 18s infinite ease-in-out; }
        .animate-float { animation: float 6s infinite ease-in-out; }
        .animate-pulse-slow { animation: pulse-slow 4s infinite ease-in-out; }
        .animate-gradient { background-size: 200% 200%; animation: gradient-shift 15s ease infinite; }

        /* Grid pattern */
        .bg-grid-pattern {
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

        /* Batik pattern subtle */
        .bg-batik-subtle {
            background-image: url('{{ asset('images/batik-pattern.png') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
    </style>
</head>

<body class="font-sans text-gray-900 antialiased overflow-hidden">

    {{-- 🌌 Background Modern dengan Sentuhan Batik --}}
    <div class="min-h-screen flex items-center justify-center p-4 relative overflow-hidden">
        
        {{-- Layer 1: Gradient Background --}}
        <div class="absolute inset-0 bg-gradient-to-br from-slate-900 via-blue-950 to-indigo-950 animate-gradient"></div>
        
        {{-- Layer 2: Batik Pattern dengan Opacity Rendah --}}
        <div class="absolute inset-0 bg-batik-subtle opacity-[0.06] mix-blend-overlay"></div>
        
        {{-- Layer 3: Grid Pattern --}}
        <div class="absolute inset-0 bg-grid-pattern opacity-40"></div>
        
        {{-- Layer 4: Animated Blobs --}}
        <div class="absolute top-20 left-10 w-[500px] h-[500px] bg-blue-500/15 rounded-full mix-blend-screen filter blur-[100px] animate-blob1"></div>
        <div class="absolute bottom-20 right-10 w-[500px] h-[500px] bg-indigo-500/15 rounded-full mix-blend-screen filter blur-[100px] animate-blob2"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-purple-500/10 rounded-full mix-blend-screen filter blur-[120px] animate-blob3"></div>
        
        {{-- Layer 5: Gradient Accent Lines --}}
        <div class="absolute inset-0 opacity-[0.07]">
            <div class="absolute top-0 left-[20%] w-px h-full bg-gradient-to-b from-transparent via-blue-400 to-transparent"></div>
            <div class="absolute top-0 left-[80%] w-px h-full bg-gradient-to-b from-transparent via-indigo-400 to-transparent"></div>
            <div class="absolute top-[30%] left-0 w-full h-px bg-gradient-to-r from-transparent via-blue-400 to-transparent"></div>
            <div class="absolute top-[70%] left-0 w-full h-px bg-gradient-to-r from-transparent via-purple-400 to-transparent"></div>
        </div>
        
        {{-- Layer 6: Floating Elements --}}
        <div class="absolute top-[15%] left-[15%] w-3 h-3 bg-blue-300/30 rounded-full animate-float"></div>
        <div class="absolute top-[25%] right-[20%] w-2 h-2 bg-indigo-300/25 rounded-full animate-float" style="animation-delay: 1s;"></div>
        <div class="absolute bottom-[30%] left-[25%] w-2.5 h-2.5 bg-purple-300/20 rounded-full animate-float" style="animation-delay: 2s;"></div>
        <div class="absolute bottom-[20%] right-[15%] w-1.5 h-1.5 bg-blue-200/30 rounded-full animate-float" style="animation-delay: 3s;"></div>
        <div class="absolute top-[60%] left-[70%] w-2 h-2 bg-white/20 rounded-full animate-pulse-slow"></div>
        <div class="absolute top-[40%] left-[10%] w-1.5 h-1.5 bg-cyan-300/30 rounded-full animate-pulse-slow" style="animation-delay: 2s;"></div>

        {{-- Content Slot --}}
        <div class="relative z-10 w-full">
            {{ $slot }}
        </div>

    </div>

</body>
</html>