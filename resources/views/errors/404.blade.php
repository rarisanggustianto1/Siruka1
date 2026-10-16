@extends('layouts.app')

@section('title', '404 - Halaman Tidak Ditemukan')

@section('content')
<div class="min-h-[70vh] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full text-center space-y-6">
        <div class="inline-flex items-center justify-center w-24 h-24 rounded-3xl bg-indigo-50 border border-indigo-100 text-indigo-600 shadow-sm">
            <svg class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        
        <div>
            <span class="inline-block px-3 py-1 bg-indigo-100/70 text-indigo-700 text-xs font-bold rounded-full mb-3 uppercase tracking-wider">
                Error 404 &bull; Not Found
            </span>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight sm:text-4xl">Halaman Tidak Ditemukan</h1>
            <p class="mt-3 text-sm text-slate-500 leading-relaxed">
                {{ $message ?? 'Maaf, data ruangan atau halaman yang Anda tuju tidak tersedia atau telah dipindahkan oleh pengelola sistem.' }}
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
                <a href="{{ route('home') }}" class="inline-flex items-center justify-center px-5 py-2.5 rounded-xl text-white bg-indigo-600 hover:bg-indigo-700 font-bold text-sm shadow-sm transition-all">
                    Kembali ke Beranda
                </a>
            @endauth
            <a href="javascript:history.back()" class="inline-flex items-center justify-center px-5 py-2.5 rounded-xl border border-slate-300 text-slate-700 hover:bg-slate-50 font-semibold text-sm transition-all">
                &larr; Halaman Sebelumnya
            </a>
        </div>
    </div>
</div>
@endsection
