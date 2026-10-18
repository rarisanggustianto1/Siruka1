@extends('layouts.app')

@section('title', 'Beranda')

@section('content')

<section class="landing-hero relative flex items-center overflow-hidden">

    <div class="landing-hero__media absolute inset-0 z-0">
        <img
            src="{{ asset('images/gedung-ilkom.png') }}"
            alt="Gedung Ilmu Komputer FMIPA Universitas Lampung"
            class="w-full h-full object-cover"
        >

        <div class="landing-hero__overlay absolute inset-0"></div>
    </div>

    <div class="landing-hero__content relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
        <div class="max-w-3xl">

            <div class="flex items-center space-x-4 mb-8">
                <img
                    src="{{ asset('images/logo-unila-transparent.png') }}"
                    alt="Logo Universitas Lampung"
                    class="unila-logo-image h-16 w-16 drop-shadow-lg"
                >
                <div>
                    <div class="inline-flex items-center px-3 py-1.5 rounded-full bg-white/15 backdrop-blur-sm border border-white/25 text-white text-xs font-bold tracking-wide uppercase">
                        🏛️ FMIPA — Jurusan Ilmu Komputer
                    </div>
                    <p class="text-blue-100 text-xs mt-1 font-medium">Universitas Lampung</p>
                </div>
            </div>

            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black text-white tracking-tight leading-tight drop-shadow-md">
                SIRUKA
                <span class="landing-hero__subtitle block text-2xl sm:text-3xl lg:text-4xl font-bold mt-2">
                    Sistem Booking Ruangan Kampus
                </span>
            </h1>

                <p class="landing-hero__description mt-6 text-base sm:text-lg text-blue-100 leading-relaxed max-w-2xl">
                Platform peminjaman ruangan digital untuk laboratorium, ruang seminar, dan ruang kuliah
                Jurusan Ilmu Komputer FMIPA Unila — cepat, transparan, dan bebas bentrok jadwal.
            </p>

            <div class="mt-10 flex flex-col sm:flex-row items-start gap-4">
                @auth
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}"
                           class="inline-flex items-center justify-center px-8 py-3.5 text-base font-bold rounded-2xl text-blue-900 bg-white hover:bg-blue-50 shadow-xl transition-all">
                            Panel Admin &rarr;
                        </a>
                    @else
                        <a href="{{ route('peminjam.bookings.create') }}"
                           class="inline-flex items-center justify-center px-8 py-3.5 text-base font-bold rounded-2xl text-white bg-blue-600 hover:bg-blue-500 shadow-xl shadow-blue-500/30 transition-all">
                            Ajukan Peminjaman &rarr;
                        </a>
                    @endif
                @else
                    <a href="{{ route('register') }}"
                       class="inline-flex items-center justify-center px-8 py-3.5 text-base font-bold rounded-2xl text-white bg-blue-600 hover:bg-blue-500 shadow-xl shadow-blue-500/30 transition-all">
                        Daftar Peminjam Baru &rarr;
                    </a>
                    <a href="{{ route('login') }}"
                       class="inline-flex items-center justify-center px-8 py-3.5 text-base font-bold rounded-2xl text-white bg-white/15 hover:bg-white/25 border border-white/30 backdrop-blur-sm transition-all">
                        Masuk ke Akun
                    </a>
                @endauth
                <a href="#ruangan"
                   class="landing-hero__link inline-flex items-center justify-center px-6 py-3.5 text-base font-semibold transition-colors">
                    Lihat Daftar Ruangan ↓
                </a>
            </div>
        </div>
    </div>

</section>

<section class="landing-stats" aria-label="Ringkasan SIRUKA">
    <div class="landing-stats__grid">
        <div class="landing-stat-card"><p class="landing-stat-card__value">{{ $stats['total_rooms'] }}</p><p>Total Ruangan</p></div>
        <div class="landing-stat-card"><p class="landing-stat-card__value">{{ $stats['available_rooms'] }}</p><p>Ruang Tersedia</p></div>
        <div class="landing-stat-card"><p class="landing-stat-card__value">{{ $stats['approved_bookings'] }}</p><p>Booking Disetujui</p></div>
        <div class="landing-stat-card"><p class="landing-stat-card__value">{{ $stats['total_users'] }}</p><p>Pengguna Terdaftar</p></div>
    </div>
</section>


<div class="py-16 bg-white border-y border-slate-200/80">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto">
            <span class="text-xs font-bold uppercase tracking-wider text-blue-600">Solusi Modern</span>
            <p class="mt-2 text-3xl font-extrabold text-slate-900 tracking-tight">Mengapa Memilih SIRUKA?</p>
            <p class="mt-3 text-slate-600 text-sm">Tinggalkan proses surat-menyurat manual dan antrean panjang dengan sistem otomatis terintegrasi.</p>
        </div>

        <div class="mt-12 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="p-6 rounded-2xl bg-blue-50 border border-blue-100 hover:shadow-md hover:border-blue-200 transition-all">
                <div class="w-12 h-12 rounded-xl bg-blue-600 text-white flex items-center justify-center mb-4 shadow-md shadow-blue-600/25">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h3 class="font-bold text-slate-900 text-base">Cek Bentrok Otomatis</h3>
                <p class="mt-2 text-xs text-slate-600 leading-relaxed">Sistem secara cerdas memeriksa rentang jam sehingga mustahil terjadi tabrakan jadwal pemakaian.</p>
            </div>

            <div class="p-6 rounded-2xl bg-emerald-50 border border-emerald-100 hover:shadow-md hover:border-emerald-200 transition-all">
                <div class="w-12 h-12 rounded-xl bg-emerald-500 text-white flex items-center justify-center mb-4 shadow-md shadow-emerald-500/25">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h3 class="font-bold text-slate-900 text-base">Ketersediaan Real-Time</h3>
                <p class="mt-2 text-xs text-slate-600 leading-relaxed">Informasi status ketersediaan ruangan dan maintenance terupdate secara langsung setiap saat.</p>
            </div>

            <div class="p-6 rounded-2xl bg-amber-50 border border-amber-100 hover:shadow-md hover:border-amber-200 transition-all">
                <div class="w-12 h-12 rounded-xl bg-amber-500 text-white flex items-center justify-center mb-4 shadow-md shadow-amber-500/25">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <h3 class="font-bold text-slate-900 text-base">Persetujuan Transparan</h3>
                <p class="mt-2 text-xs text-slate-600 leading-relaxed">Admin dapat menyetujui atau menolak disertai alasan jelas yang langsung dapat dipantau peminjam.</p>
            </div>

            <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200 hover:shadow-md hover:border-slate-300 transition-all">
                <div class="w-12 h-12 rounded-xl bg-slate-700 text-white flex items-center justify-center mb-4 shadow-md shadow-slate-700/25">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                </div>
                <h3 class="font-bold text-slate-900 text-base">Riwayat Terarsip</h3>
                <p class="mt-2 text-xs text-slate-600 leading-relaxed">Dokumentasi data peminjaman tersimpan rapi untuk laporan akuntabilitas sarana prasarana jurusan.</p>
            </div>
        </div>
    </div>
</div>


<div id="ruangan" class="py-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex flex-col md:flex-row md:items-end justify-between mb-8">
        <div>
            <span class="text-xs font-bold uppercase tracking-wider text-blue-600">Eksplorasi Sarana</span>
            <h2 class="text-3xl font-extrabold text-slate-900 mt-1">Daftar Ruangan Kampus</h2>
            <p class="text-slate-600 text-sm mt-1">Pilih ruangan yang sesuai dengan kapasitas dan fasilitas yang Anda butuhkan.</p>
        </div>
        <div class="mt-4 md:mt-0 text-sm text-slate-500 font-medium">
            Menampilkan {{ $rooms->total() }} ruangan terdaftar
        </div>
    </div>


    <div class="bg-white rounded-2xl p-4 sm:p-5 border border-slate-200 shadow-sm mb-8">
        <form action="{{ route('home') }}#ruangan" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Cari Nama / Kode</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Contoh: GIK, Lab, MIPA..."
                    class="w-full px-3.5 py-2 text-sm border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:outline-none transition-colors">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Gedung</label>
                <select name="gedung" class="w-full px-3.5 py-2 text-sm border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:outline-none transition-colors">
                    <option value="">Semua Gedung</option>
                    @foreach($buildings as $b)
                        <option value="{{ $b }}" {{ request('gedung') == $b ? 'selected' : '' }}>{{ $b }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Fasilitas</label>
                <select name="facility_id" class="w-full px-3.5 py-2 text-sm border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:outline-none transition-colors">
                    <option value="">Semua Fasilitas</option>
                    @foreach($facilities as $f)
                        <option value="{{ $f->id }}" {{ request('facility_id') == $f->id ? 'selected' : '' }}>{{ $f->nama_fasilitas }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex items-end space-x-2">
                <button type="submit" class="flex-1 py-2 px-4 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm shadow transition-colors flex items-center justify-center">
                    <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    Terapkan Filter
                </button>
                @if(request()->hasAny(['search', 'gedung', 'facility_id', 'min_kapasitas']))
                    <a href="{{ route('home') }}#ruangan" class="py-2 px-3 rounded-xl border border-slate-300 text-slate-600 hover:bg-slate-100 text-sm font-semibold transition-colors">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>


    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($rooms as $room)
            <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm hover:shadow-lg hover:border-blue-200 transition-all duration-300 flex flex-col group">

                <div class="relative h-48 bg-gradient-to-br from-blue-50 to-blue-100 overflow-hidden">
                    <img src="{{ $room->foto_url }}" alt="{{ $room->nama }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute top-3 right-3">
                        @if($room->status === 'tersedia')
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-500 text-white shadow-sm">
                                <span class="w-1.5 h-1.5 rounded-full bg-white mr-1.5 animate-pulse"></span>
                                Tersedia
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-rose-600 text-white shadow-sm">
                                Maintenance
                            </span>
                        @endif
                    </div>
                    <div class="absolute bottom-3 left-3">
                        <span class="px-2.5 py-1 rounded-lg text-xs font-bold bg-slate-900/80 text-white backdrop-blur-sm">
                            {{ $room->kode }}
                        </span>
                    </div>
                </div>


                <div class="p-5 flex-1 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between text-xs text-slate-500 font-medium mb-1">
                            <span>{{ $room->gedung }} &bull; Lt. {{ $room->lantai }}</span>
                            <span class="inline-flex items-center text-blue-600 font-bold">
                                <svg class="w-3.5 h-3.5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                {{ $room->kapasitas }} Orang
                            </span>
                        </div>

                        <h3 class="text-lg font-bold text-slate-900 group-hover:text-blue-600 transition-colors line-clamp-1">
                            {{ $room->nama }}
                        </h3>

                        <p class="text-xs text-slate-500 mt-2 line-clamp-2 leading-relaxed">
                            {{ $room->deskripsi ?? 'Ruangan serbaguna untuk aktivitas akademik dan kegiatan kemahasiswaan kampus.' }}
                        </p>


                        <div class="mt-4 flex flex-wrap gap-1.5">
                            @forelse($room->facilities->take(3) as $fac)
                                <span class="px-2 py-0.5 rounded-md bg-blue-50 text-blue-700 text-[11px] font-medium border border-blue-100">
                                    {{ $fac->nama_fasilitas }}
                                </span>
                            @empty
                                <span class="text-[11px] text-slate-400">Fasilitas standar</span>
                            @endforelse
                            @if($room->facilities->count() > 3)
                                <span class="px-2 py-0.5 rounded-md bg-slate-100 text-slate-700 text-[11px] font-bold border border-slate-200">
                                    +{{ $room->facilities->count() - 3 }} lainnya
                                </span>
                            @endif
                        </div>
                    </div>


                    <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between">
                        <a href="{{ route('public.rooms.show', $room) }}" class="text-xs font-bold text-slate-600 hover:text-blue-600 flex items-center transition-colors">
                            Lihat Jadwal
                            <svg class="w-3.5 h-3.5 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>

                        @auth
                            @if(auth()->user()->isPeminjam() && $room->status === 'tersedia')
                                <a href="{{ route('peminjam.bookings.create', ['room_id' => $room->id]) }}" class="px-3.5 py-1.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold shadow-sm transition-colors">
                                    Booking Sekarang
                                </a>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="px-3.5 py-1.5 rounded-xl bg-slate-100 hover:bg-blue-50 hover:text-blue-600 text-slate-700 text-xs font-bold transition-colors">
                                Booking Ruangan
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full py-12 text-center bg-white rounded-2xl border border-slate-200">
                <svg class="mx-auto w-12 h-12 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
                <p class="mt-3 text-base font-bold text-slate-700">Tidak ada ruangan yang cocok dengan kriteria filter</p>
                <p class="text-xs text-slate-500 mt-1">Coba ubah kata kunci pencarian atau reset filter Anda.</p>
                <div class="mt-4">
                    <a href="{{ route('home') }}#ruangan" class="px-4 py-2 rounded-xl bg-blue-600 text-white font-bold text-xs">Reset Semua Filter</a>
                </div>
            </div>
        @endforelse
    </div>


    <div class="mt-8">
        {{ $rooms->links() }}
    </div>
</div>


<div id="alur" class="booking-flow-section py-16 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto">
            <h2 class="text-xs font-bold uppercase tracking-wider text-blue-300">Sederhana & Cepat</h2>
            <p class="mt-2 text-3xl font-extrabold tracking-tight">Alur Peminjaman 4 Langkah</p>
            <p class="booking-flow-muted mt-3 text-sm">Mudah, praktis, dan dapat diakses dari mana saja tanpa antre ke bagian umum.</p>
        </div>

        <div class="mt-12 grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="booking-flow-card relative p-6 rounded-2xl bg-white/10 border border-white/15 backdrop-blur-sm flex flex-col items-center text-center hover:bg-white/15 transition-all">
                <div class="w-12 h-12 rounded-2xl bg-blue-500 text-white font-black text-lg flex items-center justify-center shadow-lg shadow-blue-500/30 mb-4">
                    1
                </div>
                <h3 class="font-bold text-base">Pilih Ruangan</h3>
                <p class="booking-flow-muted mt-2 text-xs leading-relaxed">
                    Eksplorasi ruangan, cek foto, fasilitas pendukung, kapasitas, serta jadwal terpakai pada tanggal yang diinginkan.
                </p>
            </div>

            <div class="booking-flow-card relative p-6 rounded-2xl bg-white/10 border border-white/15 backdrop-blur-sm flex flex-col items-center text-center hover:bg-white/15 transition-all">
                <div class="w-12 h-12 rounded-2xl bg-blue-500 text-white font-black text-lg flex items-center justify-center shadow-lg shadow-blue-500/30 mb-4">
                    2
                </div>
                <h3 class="font-bold text-base">Isi Form Booking</h3>
                <p class="booking-flow-muted mt-2 text-xs leading-relaxed">
                    Tentukan tanggal, jam mulai dan selesai, keperluan kegiatan, dan jumlah estimasi peserta. Sistem memvalidasi kapasitas dan tabrakan jam.
                </p>
            </div>

            <div class="booking-flow-card relative p-6 rounded-2xl bg-white/10 border border-white/15 backdrop-blur-sm flex flex-col items-center text-center hover:bg-white/15 transition-all">
                <div class="w-12 h-12 rounded-2xl bg-blue-500 text-white font-black text-lg flex items-center justify-center shadow-lg shadow-blue-500/30 mb-4">
                    3
                </div>
                <h3 class="font-bold text-base">Verifikasi Admin</h3>
                <p class="booking-flow-muted mt-2 text-xs leading-relaxed">
                    Admin sarana dan prasarana mereview pengajuan secara online, memberikan persetujuan atau catatan penolakan jika tidak sesuai.
                </p>
            </div>

            <div class="booking-flow-card relative p-6 rounded-2xl bg-white/10 border border-white/15 backdrop-blur-sm flex flex-col items-center text-center hover:bg-white/15 transition-all">
                <div class="w-12 h-12 rounded-2xl bg-blue-500 text-white font-black text-lg flex items-center justify-center shadow-lg shadow-blue-500/30 mb-4">
                    4
                </div>
                <h3 class="font-bold text-base">Ruangan Terkunci</h3>
                <p class="booking-flow-muted mt-2 text-xs leading-relaxed">
                    Setelah disetujui, jadwal ruangan langsung otomatis terkunci di sistem dan siap digunakan tanpa kekhawatiran bentrok jadwal.
                </p>
            </div>
        </div>


        <div class="mt-12 text-center">
            @guest
            <a href="{{ route('register') }}" class="booking-flow-cta inline-flex items-center px-8 py-3.5 text-base font-bold rounded-2xl bg-white shadow-xl transition-all">
                Mulai Booking Sekarang &rarr;
            </a>
            @endguest
        </div>
    </div>
</div>
@endsection
