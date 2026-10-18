@extends('layouts.app')

@section('title', '500 - Terjadi Kesalahan Server')

@section('content')
<div class="min-h-[70vh] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full text-center space-y-6">
        <div class="inline-flex items-center justify-center w-24 h-24 rounded-3xl bg-amber-50 border border-amber-100 text-amber-600 shadow-sm">
            <svg class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
        </div>

        <div>
            <span class="inline-block px-3 py-1 bg-amber-100 text-amber-800 text-xs font-bold rounded-full mb-3 uppercase tracking-wider">
                Error 500 &bull; Server Error
            </span>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight sm:text-4xl">Terjadi Kendala Sistem</h1>
            <p class="mt-3 text-sm text-slate-500 leading-relaxed">
                Sistem SIRUKA mengalami kendala teknis saat memproses permintaan Anda. Tim administrator telah menerima laporan log ini.
            </p>
        </div>

        <div class="flex flex-col sm:flex-row gap-3 justify-center pt-2">
            <a href="{{ route('home') }}" class="inline-flex items-center justify-center px-5 py-2.5 rounded-xl text-white bg-blue-600 hover:bg-blue-700 font-bold text-sm shadow-sm transition-all">
                Muat Ulang Beranda
            </a>
            <a href="javascript:location.reload()" class="inline-flex items-center justify-center px-5 py-2.5 rounded-xl border border-slate-300 text-slate-700 hover:bg-slate-50 font-semibold text-sm transition-all">
                Coba Lagi
            </a>
        </div>
    </div>
</div>
@endsection
