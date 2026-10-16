@extends('layouts.app')

@section('title', '403 - Akses Dibatasi')

@section('content')
<div class="min-h-[70vh] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full text-center space-y-6">
        <div class="inline-flex items-center justify-center w-24 h-24 rounded-3xl bg-rose-50 border border-rose-100 text-rose-600 shadow-sm">
            <svg class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m0 0v2m0-2h2m-2 0H10m11-3.5a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        
        <div>
            <span class="inline-block px-3 py-1 bg-rose-100 text-rose-700 text-xs font-bold rounded-full mb-3 uppercase tracking-wider">
                Error 403 &bull; Akses Dibatasi
            </span>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight sm:text-4xl">Akses Tidak Diizinkan</h1>
            <p class="mt-3 text-sm text-slate-500 leading-relaxed">
                {{ $message ?? 'Akun Anda tidak memiliki izin untuk membuka fitur ini. Pastikan Anda masuk dengan hak akses yang tepat.' }}
            </p>
        </div>

        <div class="flex flex-col sm:flex-row gap-3 justify-center pt-2">
            @auth
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center justify-center px-5 py-2.5 rounded-xl text-white bg-indigo-600 hover:bg-indigo-700 font-bold text-sm shadow-sm transition-all">
                        Kembali ke Panel Admin
                    </a>
                @else
                    <a href="{{ route('peminjam.dashboard') }}" class="inline-flex items-center justify-center px-5 py-2.5 rounded-xl text-white bg-indigo-600 hover:bg-indigo-700 font-bold text-sm shadow-sm transition-all">
                        Kembali ke Dashboard Mahasiswa
                    </a>
                @endif
            @else
                <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-5 py-2.5 rounded-xl text-white bg-indigo-600 hover:bg-indigo-700 font-bold text-sm shadow-sm transition-all">
                    Masuk ke Akun
                </a>
            @endauth
            <a href="javascript:history.back()" class="inline-flex items-center justify-center px-5 py-2.5 rounded-xl border border-slate-300 text-slate-700 hover:bg-slate-50 font-semibold text-sm transition-all">
                &larr; Halaman Sebelumnya
            </a>
        </div>
    </div>
</div>
@endsection
