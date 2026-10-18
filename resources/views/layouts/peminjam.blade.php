<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Peminjam Portal') - SIRUKA</title>


    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">


    <link rel="stylesheet" href="{{ asset('css/app.css') }}?v={{ file_exists(public_path('css/app.css')) ? filemtime(public_path('css/app.css')) : '1.0' }}">
    @stack('styles')
</head>
<body class="flex flex-col min-h-screen text-slate-800 antialiased bg-slate-50">

    <nav class="sticky top-0 z-40 bg-white/95 backdrop-blur-md border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">

                <div class="flex items-center space-x-8">
                    <a href="{{ route('peminjam.dashboard') }}" class="flex items-center space-x-3 group">
                        <img src="{{ asset('images/logo-unila-transparent.png') }}" alt="Logo Universitas Lampung" class="unila-logo-image h-10 w-10">
                        <div>
                            <span class="peminjam-brand-name text-xl font-bold">SIRUKA</span>
                            <span class="text-xs font-semibold text-blue-700 ml-1 px-2 py-0.5 bg-blue-50 rounded-md border border-blue-200">MAHASISWA ILKOM</span>
                        </div>
                    </a>


                    <div class="hidden md:flex items-center space-x-1">
                        <a href="{{ route('peminjam.dashboard') }}" class="px-3.5 py-2 rounded-xl text-sm font-semibold transition-colors {{ request()->routeIs('peminjam.dashboard') ? 'bg-blue-50 text-blue-600 font-bold' : 'text-slate-600 hover:text-blue-600 hover:bg-slate-50' }}">
                            Dashboard
                        </a>
                        <a href="{{ route('peminjam.rooms.index') }}" class="px-3.5 py-2 rounded-xl text-sm font-semibold transition-colors {{ request()->routeIs('peminjam.rooms.*') ? 'bg-blue-50 text-blue-600 font-bold' : 'text-slate-600 hover:text-blue-600 hover:bg-slate-50' }}">
                            Cari Ruangan
                        </a>
                        <a href="{{ route('peminjam.bookings.index') }}" class="px-3.5 py-2 rounded-xl text-sm font-semibold transition-colors {{ request()->routeIs('peminjam.bookings.*') ? 'bg-blue-50 text-blue-600 font-bold' : 'text-slate-600 hover:text-blue-600 hover:bg-slate-50' }}">
                            Riwayat Booking
                        </a>
                    </div>
                </div>


                <div class="flex items-center space-x-4">
                    <a href="{{ route('peminjam.bookings.create') }}" class="hidden sm:inline-flex items-center px-4 py-2 text-sm font-semibold rounded-xl text-white bg-blue-600 hover:bg-blue-700 shadow-sm transition-all">
                        <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Pinjam Ruangan
                    </a>


                    <details class="relative">
                        <summary class="list-none flex items-center space-x-3 p-1.5 rounded-xl hover:bg-slate-100 cursor-pointer focus:outline-none">
                            <div class="peminjam-avatar w-8 h-8 rounded-full flex items-center justify-center text-white text-xs font-bold shadow-sm">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </div>
                            <div class="text-left hidden sm:block">
                                <p class="text-xs font-bold text-slate-800 leading-tight">{{ auth()->user()->name }}</p>
                                <p class="text-[11px] text-slate-500 leading-tight">NIM: {{ auth()->user()->nim_nip ?? '-' }}</p>
                            </div>
                            <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </summary>

                        <div class="absolute right-0 mt-2 w-56 bg-white rounded-2xl shadow-xl border border-slate-200 py-2 z-50">
                            <div class="px-4 py-2 border-b border-slate-100">
                                <p class="text-xs text-slate-400">Login sebagai</p>
                                <p class="text-xs font-semibold text-slate-800 truncate">{{ auth()->user()->email }}</p>
                            </div>
                            <a href="{{ route('peminjam.profile.index') }}" class="flex items-center px-4 py-2.5 text-sm text-slate-700 hover:bg-slate-50 font-medium">
                                <svg class="w-4 h-4 mr-2.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                Profil Saya
                            </a>
                            <a href="{{ route('peminjam.bookings.index') }}" class="flex items-center px-4 py-2.5 text-sm text-slate-700 hover:bg-slate-50 font-medium">
                                <svg class="w-4 h-4 mr-2.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                                Riwayat Pengajuan
                            </a>
                            <div class="border-t border-slate-100 my-1"></div>
                            <form action="{{ route('logout') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin keluar dari akun?')">
                                @csrf
                                <button type="submit" class="w-full text-left flex items-center px-4 py-2.5 text-sm text-rose-600 hover:bg-rose-50 font-medium transition-colors">
                                    <svg class="w-4 h-4 mr-2.5 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                    Keluar
                                </button>
                            </form>
                        </div>
                    </details>
                </div>
            </div>
        </div>


        <div class="md:hidden border-t border-slate-200 bg-slate-50 px-4 py-2 flex items-center justify-around text-xs font-bold text-slate-600">
            <a href="{{ route('peminjam.dashboard') }}" class="{{ request()->routeIs('peminjam.dashboard') ? 'text-blue-600 font-extrabold' : '' }}">Dashboard</a>
            <a href="{{ route('peminjam.rooms.index') }}" class="{{ request()->routeIs('peminjam.rooms.*') ? 'text-blue-600 font-extrabold' : '' }}">Katalog Ruangan</a>
            <a href="{{ route('peminjam.bookings.index') }}" class="{{ request()->routeIs('peminjam.bookings.*') ? 'text-blue-600 font-extrabold' : '' }}">Riwayat</a>
            <a href="{{ route('peminjam.bookings.create') }}" class="text-blue-600 font-extrabold">+ Pinjam</a>
        </div>
    </nav>


    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full mt-6">
        @if(session('success'))
            <div class="mb-6 flex items-center justify-between p-4 bg-emerald-50 border border-emerald-200 rounded-xl text-emerald-800 shadow-sm">
                <div class="flex items-center space-x-3">
                    <svg class="w-5 h-5 text-emerald-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <span class="text-sm font-medium">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 flex items-center justify-between p-4 bg-rose-50 border border-rose-200 rounded-xl text-rose-800 shadow-sm">
                <div class="flex items-center space-x-3">
                    <svg class="w-5 h-5 text-rose-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                    <span class="text-sm font-medium">{{ session('error') }}</span>
                </div>
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 p-4 bg-rose-50 border border-rose-200 rounded-xl text-rose-800 shadow-sm">
                <div class="flex items-start space-x-3">
                    <svg class="w-5 h-5 text-rose-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                    <div>
                        <p class="text-sm font-semibold">Terdapat beberapa kesalahan validasi:</p>
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


    <main class="flex-grow max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full pb-16">
        @yield('content')
    </main>


    <footer class="bg-white border-t border-slate-200 mt-auto py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row justify-between items-center text-xs text-slate-500 space-y-2 sm:space-y-0">
            <div>&copy; {{ date('Y') }} SIRUKA - Sistem Booking Ruangan Kampus.</div>
            <div class="flex space-x-4">
                <a href="{{ route('home') }}" class="hover:text-blue-600">Beranda Publik</a>
                <a href="{{ route('peminjam.rooms.index') }}" class="hover:text-blue-600">Katalog Ruangan</a>
                <a href="{{ route('peminjam.profile.index') }}" class="hover:text-blue-600">Akun</a>
            </div>
        </div>
    </footer>
</body>
</html>
