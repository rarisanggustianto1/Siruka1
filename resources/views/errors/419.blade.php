@extends('layouts.app')

@section('title', '419 - Sesi Kedaluwarsa')

@section('content')
<div class="min-h-[70vh] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full text-center space-y-6">
        <div class="inline-flex items-center justify-center w-24 h-24 rounded-3xl bg-blue-50 border border-blue-100 text-blue-600 shadow-sm">
            <svg class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>

        <div>
            <span class="inline-block px-3 py-1 bg-blue-100 text-blue-700 text-xs font-bold rounded-full mb-3 uppercase tracking-wider">
                Error 419 &bull; Page Expired
            </span>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight sm:text-4xl">Sesi Anda Telah Berakhir</h1>
            <p class="mt-3 text-sm text-slate-500 leading-relaxed">
                Halaman ini telah terbuka terlalu lama dan token keamanan telah kedaluwarsa. Silakan refresh atau masuk kembali.
            </p>
        </div>

        <div class="flex flex-col sm:flex-row gap-3 justify-center pt-2">
            <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-5 py-2.5 rounded-xl text-white bg-blue-600 hover:bg-blue-700 font-bold text-sm shadow-sm transition-all">
                Masuk Ulang
            </a>
            <a href="javascript:location.reload()" class="inline-flex items-center justify-center px-5 py-2.5 rounded-xl border border-slate-300 text-slate-700 hover:bg-slate-50 font-semibold text-sm transition-all">
                Refresh Halaman
            </a>
        </div>
    </div>
</div>
@endsection
