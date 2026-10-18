<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SIRUKA') - Sistem Booking Ruangan Kampus</title>


    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">


    <link rel="stylesheet" href="{{ asset('css/app.css') }}?v={{ file_exists(public_path('css/app.css')) ? filemtime(public_path('css/app.css')) : '1.0' }}">
    @stack('styles')
</head>
<body class="flex flex-col min-h-screen text-slate-800 antialiased selection:bg-blue-500 selection:text-white">

    <nav class="sticky top-0 z-40 bg-white/95 backdrop-blur-md border-b border-slate-200 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">

                <div class="flex items-center space-x-3">
                    <a href="{{ route('home') }}" class="flex items-center space-x-3 group">
                        <img
                            src="{{ asset('images/logo-unila-transparent.png') }}"
                            onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                            alt="Logo UNILA"
                            class="unila-logo-image h-9 w-9"
                        >
                        <div class="hidden w-9 h-9 rounded-xl bg-gradient-to-tr from-blue-600 to-blue-800 items-center justify-center shadow-md shadow-blue-500/20">
                            <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                        <div>
                            <span class="text-xl font-bold text-blue-700">SIRUKA</span>
                            <span class="hidden sm:inline-block text-xs font-semibold text-blue-700 ml-1.5 px-2 py-0.5 bg-blue-50 rounded-md border border-blue-200">ILKOM UNILA</span>
                        </div>
                    </a>
                </div>


                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('home') }}" class="text-sm font-semibold {{ request()->routeIs('home') ? 'text-blue-600' : 'text-slate-600 hover:text-blue-600' }} transition-colors">
                        Beranda
                    </a>
                    <a href="{{ route('home') }}#ruangan" class="text-sm font-semibold text-slate-600 hover:text-blue-600 transition-colors">
                        Daftar Ruangan
                    </a>
                    <a href="{{ route('home') }}#alur" class="text-sm font-semibold text-slate-600 hover:text-blue-600 transition-colors">
                        Alur Peminjaman
                    </a>

                    @auth
                        <div class="flex items-center space-x-3">
                            @if(auth()->user()->isAdmin())
                                <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-semibold rounded-xl text-white bg-blue-600 hover:bg-blue-700 shadow-sm transition-all">
                                    Panel Admin &rarr;
                                </a>
                            @else
                                <a href="{{ route('peminjam.dashboard') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-semibold rounded-xl text-white bg-blue-600 hover:bg-blue-700 shadow-sm transition-all">
                                    Dashboard Saya &rarr;
                                </a>
                            @endif
                            <form action="{{ route('logout') }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin keluar dari akun?')">
                                @csrf
                                <button type="submit" class="text-xs font-semibold text-rose-600 hover:text-rose-700 px-3 py-2 rounded-lg hover:bg-rose-50 transition-colors">
                                    Keluar
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="flex items-center space-x-3">
                            <a href="{{ route('login') }}" class="text-sm font-semibold text-slate-700 hover:text-blue-600 px-3 py-2 rounded-lg transition-colors">
                                Masuk
                            </a>
                            <a href="{{ route('register') }}" class="inline-flex items-center px-4 py-2 text-sm font-semibold rounded-xl text-white bg-blue-600 hover:bg-blue-700 shadow-sm transition-all">
                                Daftar Akun
                            </a>
                        </div>
                    @endauth
                </div>


                <div class="flex items-center md:hidden">
                    <details class="relative">
                        <summary class="list-none p-2 rounded-lg text-slate-600 hover:bg-slate-100 cursor-pointer">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </summary>
                        <div class="absolute right-0 mt-2 w-56 bg-white rounded-2xl shadow-xl border border-slate-200 py-3 px-4 z-50 space-y-2 text-sm">
                            <a href="{{ route('home') }}" class="block py-1.5 text-slate-700 font-medium hover:text-blue-600">Beranda</a>
                            <a href="{{ route('home') }}#ruangan" class="block py-1.5 text-slate-700 font-medium hover:text-blue-600">Daftar Ruangan</a>
                            <a href="{{ route('home') }}#alur" class="block py-1.5 text-slate-700 font-medium hover:text-blue-600">Alur Peminjaman</a>
                            <div class="pt-2 border-t border-slate-100 flex flex-col space-y-2">
                                @auth
                                    @if(auth()->user()->isAdmin())
                                        <a href="{{ route('admin.dashboard') }}" class="w-full text-center px-3 py-2 rounded-xl text-white bg-blue-600 font-bold text-xs">Panel Admin</a>
                                    @else
                                        <a href="{{ route('peminjam.dashboard') }}" class="w-full text-center px-3 py-2 rounded-xl text-white bg-blue-600 font-bold text-xs">Dashboard Saya</a>
                                    @endif
                                    <form action="{{ route('logout') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin keluar dari akun?')">
                                        @csrf
                                        <button type="submit" class="w-full text-center px-3 py-2 rounded-xl text-rose-600 border border-rose-200 font-bold text-xs hover:bg-rose-50">Keluar</button>
                                    </form>
                                @else
                                    <a href="{{ route('login') }}" class="w-full text-center px-3 py-2 rounded-xl text-slate-700 border border-slate-200 font-bold text-xs">Masuk</a>
                                    <a href="{{ route('register') }}" class="w-full text-center px-3 py-2 rounded-xl text-white bg-blue-600 font-bold text-xs">Daftar Akun</a>
                                @endauth
                            </div>
                        </div>
                    </details>
                </div>
            </div>
        </div>
    </nav>


    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full mt-4">
        @if(session('success'))
            <div class="mb-4 flex items-center justify-between p-4 bg-emerald-50 border border-emerald-200 rounded-xl text-emerald-800 shadow-sm">
                <div class="flex items-center space-x-3">
                    <svg class="w-5 h-5 text-emerald-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <span class="text-sm font-medium">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 flex items-center justify-between p-4 bg-rose-50 border border-rose-200 rounded-xl text-rose-800 shadow-sm">
                <div class="flex items-center space-x-3">
                    <svg class="w-5 h-5 text-rose-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                    <span class="text-sm font-medium">{{ session('error') }}</span>
                </div>
            </div>
        @endif

        @if(isset($errors) && $errors->any())
            <div class="mb-4 p-4 bg-rose-50 border border-rose-200 rounded-xl text-rose-800 shadow-sm">
                <div class="flex items-start space-x-3">
                    <svg class="w-5 h-5 text-rose-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                    <div>
                        <p class="text-sm font-semibold">Terdapat beberapa kesalahan pengisian form:</p>
                        <ul class="mt-1 list-disc list-inside text-xs text-rose-700 space-y-0.5">
                            @foreach($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif
    </div>


    <main class="flex-grow">
        @yield('content')
    </main>


    <footer class="site-footer mt-0 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                <div class="flex items-center space-x-3">
                    <img
                        src="{{ asset('images/logo-unila-transparent.png') }}"
                        onerror="this.style.display='none'"
                        alt="Logo UNILA"
                        class="unila-logo-image h-8 w-8 opacity-80"
                    >
                    <div>
                        <p class="font-bold text-white text-sm">SIRUKA — Sistem Booking Ruangan Kampus</p>
                        <p class="text-blue-300 text-xs mt-0.5">Jurusan Ilmu Komputer, Fakultas MIPA, Universitas Lampung</p>
                    </div>
                </div>
                <div class="text-xs text-blue-400">
                    &copy; {{ date('Y') }} Jurusan Ilmu Komputer, FMIPA Universitas Lampung.
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
