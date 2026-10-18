@extends('layouts.peminjam')

@section('title', 'Dashboard Peminjam')

@section('content')
<div class="space-y-8">

    <div class="peminjam-dashboard-hero relative overflow-hidden rounded-3xl text-white p-6 sm:p-8 shadow-xl shadow-blue-900/10">
        <div class="relative z-10 max-w-2xl">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-white/15 backdrop-blur-md text-blue-100 border border-white/20 mb-3">
                Portal Peminjaman Ruangan Kampus
            </span>
            <h1 class="text-2xl sm:text-3xl font-black tracking-tight">
                Halo, {{ auth()->user()->name }}! 👋
            </h1>
            <p class="mt-2 text-sm text-blue-100 leading-relaxed">
                Pantau status pengajuan peminjaman ruangan Anda secara berkala, atau temukan ruang kelas, laboratorium, dan aula yang tersedia untuk kegiatan Anda.
            </p>
            <div class="mt-5 flex flex-wrap gap-3">
                <a href="{{ route('peminjam.bookings.create') }}" class="inline-flex items-center px-5 py-2.5 rounded-xl bg-white text-blue-800 font-bold text-xs shadow-md hover:bg-slate-50 transition-all">
                    <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Ajukan Booking Sekarang
                </a>
                <a href="{{ route('peminjam.rooms.index') }}" class="inline-flex items-center px-5 py-2.5 rounded-xl bg-white/10 hover:bg-white/20 text-white font-bold text-xs border border-white/20 backdrop-blur-md transition-all">
                    Cek Ruangan Kosong
                </a>
            </div>
        </div>

        <div class="absolute -right-10 -bottom-10 w-64 h-64 rounded-full bg-white/5 blur-2xl pointer-events-none"></div>
    </div>


    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">

        <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Menunggu Persetujuan</p>
                <p class="text-3xl font-black text-amber-500 mt-1">{{ $stats['menunggu'] }}</p>
                <p class="text-xs text-slate-500 mt-1">Sedang ditinjau bagian umum/admin</p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>


        <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Pengajuan Disetujui</p>
                <p class="text-3xl font-black text-emerald-600 mt-1">{{ $stats['disetujui'] }}</p>
                <p class="text-xs text-slate-500 mt-1">Jadwal ruangan siap digunakan</p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>


        <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Pengajuan Ditolak</p>
                <p class="text-3xl font-black text-rose-600 mt-1">{{ $stats['ditolak'] }}</p>
                <p class="text-xs text-slate-500 mt-1">Dapat dicek alasannya di riwayat</p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>
    </div>


    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between">
            <div class="flex items-center space-x-2">
                <span class="w-2.5 h-2.5 rounded-full bg-blue-600"></span>
                <h2 class="text-base font-bold text-slate-800">Jadwal Peminjaman Terdekat Anda</h2>
            </div>
            <a href="{{ route('peminjam.bookings.index') }}" class="text-xs font-bold text-blue-600 hover:text-blue-700">
                Lihat Semua Riwayat &rarr;
            </a>
        </div>

        <div class="p-6">
            @if($upcomingBookings->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($upcomingBookings as $ub)
                        <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200/80 flex flex-col justify-between hover:border-blue-300 transition-colors">
                            <div>
                                <div class="flex items-center justify-between mb-2">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-bold {{ $ub->status_badge_class }}">
                                        {{ $ub->status_label }}
                                    </span>
                                    <span class="text-xs font-mono font-semibold text-slate-500">
                                        {{ substr($ub->jam_mulai, 0, 5) }} - {{ substr($ub->jam_selesai, 0, 5) }} WIB
                                    </span>
                                </div>
                                <h3 class="font-bold text-slate-900 text-sm">{{ $ub->room->nama }}</h3>
                                <p class="text-xs text-slate-500 mt-0.5">{{ $ub->room->gedung }} &bull; Lt. {{ $ub->room->lantai }}</p>
                                <div class="mt-3 p-2.5 rounded-xl bg-white border border-slate-200/60 text-xs text-slate-700">
                                    <p class="font-medium line-clamp-2">"{{ $ub->keperluan }}"</p>
                                    <p class="text-[11px] text-slate-400 mt-1">Estimasi {{ $ub->jumlah_peserta }} Peserta</p>
                                </div>
                            </div>

                            <div class="mt-4 pt-3 border-t border-slate-200 flex items-center justify-between text-xs">
                                <span class="font-bold text-blue-700">
                                    {{ \Carbon\Carbon::parse($ub->tanggal)->isoFormat('dddd, D MMMM Y') }}
                                </span>
                                <div class="flex items-center space-x-2.5">
                                    <a href="{{ route('peminjam.bookings.show', $ub) }}" class="text-slate-600 hover:text-blue-600 font-bold">
                                        Rincian
                                    </a>
                                    @if($ub->status === 'disetujui')
                                        <a href="{{ route('peminjam.bookings.cetak', $ub) }}" target="_blank" class="text-emerald-600 hover:text-emerald-700 font-bold">
                                            Cetak Bukti
                                        </a>
                                    @elseif($ub->status === 'menunggu')
                                        <a href="{{ route('peminjam.bookings.edit', $ub) }}" class="text-blue-600 hover:underline font-bold">
                                            Ubah
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="py-10 text-center text-slate-400">
                    <svg class="w-12 h-12 mx-auto text-slate-300 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <p class="text-sm font-semibold text-slate-600">Belum ada jadwal peminjaman mendatang</p>
                    <p class="text-xs text-slate-400 mt-1">Ajukan peminjaman ruangan pertama Anda untuk perkuliahan, rapat, atau kegiatan organisasi.</p>
                    <div class="mt-4">
                        <a href="{{ route('peminjam.bookings.create') }}" class="inline-flex items-center px-4 py-2 rounded-xl bg-blue-600 text-white font-bold text-xs shadow-sm">
                            Buat Pengajuan Baru
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
