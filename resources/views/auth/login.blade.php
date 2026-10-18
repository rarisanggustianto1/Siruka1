@extends('layouts.app')

@section('title', 'Masuk ke Akun')

@section('content')
<div class="min-h-[80vh] flex flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md text-center">
        <div class="inline-flex w-14 h-14 rounded-2xl bg-gradient-to-tr from-blue-600 to-blue-600 items-center justify-center shadow-lg shadow-blue-500/25 mb-4">
            <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
            </svg>
        </div>
        <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Masuk ke SIRUKA</h2>
        <p class="mt-2 text-sm text-slate-600">
            Sistem Booking Ruangan Jurusan Ilmu Komputer FMIPA Unila
        </p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white py-8 px-6 shadow-xl shadow-slate-200/60 rounded-3xl sm:px-10 border border-slate-100">
            @if(session('success'))
                <div class="mb-5 rounded-xl border border-blue-200 bg-blue-50 px-4 py-3 text-sm font-medium text-blue-800">{{ session('success') }}</div>
            @endif
            <form class="space-y-5" action="{{ route('login.post') }}" method="POST">
                @csrf

                <div>
                    <label for="login" class="block text-sm font-semibold text-slate-700">Email Kampus atau NIM</label>
                    <div class="mt-1.5 relative">
                        <input id="login" name="login" type="text" autocomplete="username" required
                            value="{{ old('login', old('email', $defaultLogin ?? $defaultEmail ?? '')) }}"
                            class="appearance-none block w-full px-4 py-3 border border-slate-300 rounded-xl placeholder-slate-400 text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition-all"
                            placeholder="admin@siruka.ac.id atau NIM (cth: 2217051015)">
                    </div>
                    @error('login')
                        <p class="mt-1 text-xs text-rose-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-semibold text-slate-700">Kata Sandi</label>
                    <div class="mt-1.5 relative">
                        <input id="password" name="password" type="password" autocomplete="current-password" required
                            value="{{ $defaultPassword ?? '' }}"
                            class="appearance-none block w-full px-4 py-3 border border-slate-300 rounded-xl placeholder-slate-400 text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition-all"
                            placeholder="••••••••">
                    </div>
                    @error('password')
                        <p class="mt-1 text-xs text-rose-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember" name="remember" type="checkbox"
                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-slate-300 rounded">
                        <label for="remember" class="ml-2 block text-xs font-medium text-slate-600">
                            Ingat saya di perangkat ini
                        </label>
                    </div>
                </div>

                <div>
                    <button type="submit"
                        class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-md shadow-blue-500/25 text-sm font-bold text-white bg-gradient-to-r from-blue-600 to-blue-600 hover:from-blue-700 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all">
                        Masuk Sekarang
                    </button>
                </div>
            </form>


            <div class="mt-6 pt-6 border-t border-slate-100">
                <p class="text-xs font-semibold text-slate-500 text-center mb-3">Pilihan Akun Demo Cepat:</p>
                <div class="grid grid-cols-2 gap-3">
                    <a href="{{ route('login', ['demo' => 'admin']) }}"
                        class="py-2.5 px-3 text-xs font-bold rounded-xl {{ request('demo') === 'admin' ? 'bg-blue-600 text-white shadow-sm' : 'bg-blue-50 text-blue-700 hover:bg-blue-100' }} text-center transition-colors">
                        👑 Admin Jurusan
                    </a>
                    <a href="{{ route('login', ['demo' => 'user']) }}"
                        class="py-2.5 px-3 text-xs font-bold rounded-xl {{ in_array(request('demo'), ['user', 'mahasiswa', 'peminjam']) ? 'bg-blue-600 text-white shadow-sm' : 'bg-blue-50 text-blue-700 hover:bg-blue-100' }} text-center transition-colors">
                        🎓 Mahasiswa / User
                    </a>
                </div>
                <p class="text-[11px] text-slate-400 text-center mt-2">Password default: <code class="bg-slate-100 px-1 py-0.5 rounded text-slate-600 font-mono">password</code></p>
            </div>

            <div class="mt-6 text-center">
                <p class="text-xs text-slate-600">
                    Belum punya akun peminjam?
                    <a href="{{ route('register') }}" class="font-bold text-blue-600 hover:text-blue-500">
                        Daftar disini
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
