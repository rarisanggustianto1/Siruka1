@extends(auth()->check() && auth()->user()->isAdmin() ? 'layouts.admin' : (auth()->check() ? 'layouts.peminjam' : 'layouts.app'))

@section('title', 'Detail Ruangan - ' . $room->nama)

@section('content')
<div class="max-w-5xl mx-auto space-y-8">
    <!-- Breadcrumb & Back -->
    <div class="flex items-center justify-between">
        <a href="{{ auth()->check() && auth()->user()->isPeminjam() ? route('peminjam.rooms.index') : route('home') . '#ruangan' }}"
            class="inline-flex items-center text-xs font-bold text-slate-500 hover:text-indigo-600 transition-colors">
            <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Daftar Ruangan
        </a>

        @if($room->status === 'tersedia')
            @auth
                @if(auth()->user()->isPeminjam())
                    <a href="{{ route('peminjam.bookings.create', ['room_id' => $room->id, 'tanggal' => $selectedDate]) }}"
                        class="inline-flex items-center px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs shadow-md shadow-indigo-600/25 transition-all">
                        <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Pinjam Ruangan Ini
                    </a>
                @endif
            @else
                <a href="{{ route('login') }}" class="px-4 py-2 rounded-xl bg-indigo-600 text-white font-bold text-xs">
                    Login untuk Pinjam
                </a>
            @endauth
        @endif
    </div>

    <!-- Room Main Detail Card -->
    <div class="bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-sm">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-0">
            <!-- Left: Room Image -->
            <div class="lg:col-span-5 relative bg-slate-900 min-h-[260px] lg:min-h-full">
                <img src="{{ $room->foto_url }}" alt="{{ $room->nama }}" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-slate-950/70 via-transparent to-transparent"></div>
                <div class="absolute top-4 left-4">
                    <span class="px-3 py-1 rounded-lg text-xs font-mono font-bold bg-slate-900/80 text-white backdrop-blur-md">
                        {{ $room->kode }}
                    </span>
                </div>
                <div class="absolute bottom-4 left-4 right-4 flex items-center justify-between text-white text-xs">
                    <span class="font-semibold">{{ $room->gedung }} &bull; Lt. {{ $room->lantai }}</span>
                    <span class="px-2.5 py-1 rounded-full font-bold {{ $room->status === 'tersedia' ? 'bg-emerald-500' : 'bg-rose-600' }}">
                        {{ ucfirst($room->status) }}
                    </span>
                </div>
            </div>

            <!-- Right: Room Specs -->
            <div class="lg:col-span-7 p-6 sm:p-8 flex flex-col justify-between">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-black text-slate-900">{{ $room->nama }}</h1>
                    <p class="text-xs text-slate-500 mt-1">Gedung: <span class="font-semibold text-slate-700">{{ $room->gedung }}</span> &bull; Lantai: <span class="font-semibold text-slate-700">{{ $room->lantai }}</span></p>

                    <!-- Key Spec Chips -->
                    <div class="mt-4 flex flex-wrap gap-2">
                        <div class="inline-flex items-center px-3 py-1.5 rounded-xl bg-indigo-50 border border-indigo-100 text-indigo-700 text-xs font-bold">
                            <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                            Kapasitas: {{ $room->kapasitas }} Orang
                        </div>
                        <div class="inline-flex items-center px-3 py-1.5 rounded-xl bg-slate-100 border border-slate-200 text-slate-700 text-xs font-bold">
                            <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                            {{ $room->facilities->count() }} Fasilitas
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="mt-4">
                        <h3 class="text-xs font-bold text-slate-700 uppercase tracking-wider">Deskripsi Ruangan</h3>
                        <p class="text-xs sm:text-sm text-slate-600 mt-1 leading-relaxed">
                            {{ $room->deskripsi ?? 'Tidak ada keterangan tambahan mengenai ruangan ini.' }}
                        </p>
                    </div>

                    <!-- Facilities -->
                    <div class="mt-5">
                        <h3 class="text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Fasilitas Tersedia</h3>
                        <div class="flex flex-wrap gap-1.5">
                            @forelse($room->facilities as $fac)
                                <span class="px-2.5 py-1 rounded-lg bg-slate-100 text-slate-800 text-xs font-medium border border-slate-200 flex items-center">
                                    <svg class="w-3.5 h-3.5 mr-1 text-emerald-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                    {{ $fac->nama_fasilitas }}
                                </span>
                            @empty
                                <span class="text-xs text-slate-400">Tidak ada fasilitas khusus yang terdata.</span>
                            @endforelse
                        </div>
                    </div>
                </div>

                @if($room->status === 'maintenance')
                    <div class="mt-6 p-3 rounded-xl bg-rose-50 border border-rose-200 text-xs text-rose-700 flex items-center">
                        <svg class="w-4 h-4 mr-2 text-rose-600 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        <span>Ruangan ini sedang dalam pemeliharaan (Maintenance) dan tidak menerima peminjaman baru saat ini.</span>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Interactive Schedule Checker on Date -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6 sm:p-8">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-6 border-b border-slate-200 gap-4">
            <div>
                <h2 class="text-lg font-black text-slate-900">Jadwal Pemakaian Ruangan</h2>
                <p class="text-xs text-slate-500 mt-0.5">Pilih tanggal untuk melihat jadwal peminjaman yang telah disetujui (terkunci) dan jam yang masih kosong.</p>
            </div>

            <!-- Date Selector Form (Pure HTML, Zero JS) -->
            <form action="{{ url()->current() }}" method="GET" class="flex items-center space-x-2">
                <input type="date" name="tanggal" value="{{ $selectedDate }}" min="{{ \Carbon\Carbon::today()->toDateString() }}"
                    class="px-3.5 py-2 text-sm border border-slate-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:outline-none font-medium">
                <button type="submit" class="px-4 py-2 rounded-xl bg-slate-800 text-white font-bold text-xs hover:bg-slate-900 shadow-sm transition-colors">
                    Cek Tanggal
                </button>
            </form>
        </div>

        <!-- Schedule Results for Selected Date -->
        <div class="mt-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-bold text-slate-800">
                    Jadwal pada tanggal: <span class="text-indigo-600">{{ \Carbon\Carbon::parse($selectedDate)->isoFormat('dddd, D MMMM Y') }}</span>
                </h3>

                <div class="flex items-center space-x-4 text-xs font-semibold">
                    <span class="inline-flex items-center text-emerald-700">
                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 mr-1.5"></span>
                        Disetujui (Terkunci)
                    </span>
                    <span class="inline-flex items-center text-amber-700">
                        <span class="w-2.5 h-2.5 rounded-full bg-amber-400 mr-1.5"></span>
                        Menunggu Persetujuan
                    </span>
                </div>
            </div>

            @if($approvedBookings->count() === 0 && $pendingBookings->count() === 0)
                <div class="p-8 text-center bg-emerald-50/60 rounded-2xl border border-emerald-200">
                    <svg class="w-10 h-10 mx-auto text-emerald-600 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="text-sm font-bold text-emerald-900">Ruangan Kosong Seharian Penuh!</p>
                    <p class="text-xs text-emerald-700 mt-1">Belum ada jadwal peminjaman pada tanggal ini. Anda bebas memilih jam mulai dan selesai.</p>
                    @if($room->status === 'tersedia')
                        @auth
                            @if(auth()->user()->isPeminjam())
                                <div class="mt-4">
                                    <a href="{{ route('peminjam.bookings.create', ['room_id' => $room->id, 'tanggal' => $selectedDate]) }}"
                                        class="inline-flex items-center px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-sm transition-colors">
                                        Pesan untuk Tanggal Ini &rarr;
                                    </a>
                                </div>
                            @endif
                        @endauth
                    @endif
                </div>
            @else
                <!-- Timeline / Bookings List -->
                <div class="space-y-3">
                    <!-- Approved Bookings -->
                    @foreach($approvedBookings as $ab)
                        <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                            <div class="flex items-start space-x-3">
                                <div class="w-8 h-8 rounded-xl bg-emerald-600 text-white flex items-center justify-center font-bold text-xs flex-shrink-0 mt-0.5">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                </div>
                                <div>
                                    <div class="flex items-center space-x-2">
                                        <span class="text-xs font-bold uppercase tracking-wider text-emerald-800">Terkunci &bull; Disetujui</span>
                                        <span class="text-xs text-slate-500">&bull; Peminjam: <strong>{{ $ab->user->name }}</strong></span>
                                    </div>
                                    <p class="text-sm font-bold text-slate-900 mt-0.5">"{{ $ab->keperluan }}"</p>
                                    <p class="text-xs text-slate-600 mt-0.5">{{ $ab->jumlah_peserta }} Peserta</p>
                                </div>
                            </div>
                            <div class="sm:text-right">
                                <span class="inline-flex items-center px-3 py-1.5 rounded-xl bg-emerald-600 text-white font-mono font-bold text-xs shadow-sm">
                                    {{ substr($ab->jam_mulai, 0, 5) }} - {{ substr($ab->jam_selesai, 0, 5) }} WIB
                                </span>
                            </div>
                        </div>
                    @endforeach

                    <!-- Pending Bookings -->
                    @foreach($pendingBookings as $pb)
                        <div class="p-4 rounded-2xl bg-amber-50/80 border border-amber-200 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                            <div class="flex items-start space-x-3">
                                <div class="w-8 h-8 rounded-xl bg-amber-500 text-white flex items-center justify-center font-bold text-xs flex-shrink-0 mt-0.5">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </div>
                                <div>
                                    <div class="flex items-center space-x-2">
                                        <span class="text-xs font-bold uppercase tracking-wider text-amber-800">Menunggu Persetujuan Admin</span>
                                        <span class="text-xs text-slate-500">&bull; Peminjam: <strong>{{ $pb->user->name }}</strong></span>
                                    </div>
                                    <p class="text-sm font-semibold text-slate-800 mt-0.5">"{{ $pb->keperluan }}"</p>
                                </div>
                            </div>
                            <div class="sm:text-right">
                                <span class="inline-flex items-center px-3 py-1.5 rounded-xl bg-amber-100 text-amber-800 border border-amber-300 font-mono font-bold text-xs">
                                    {{ substr($pb->jam_mulai, 0, 5) }} - {{ substr($pb->jam_selesai, 0, 5) }} WIB
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
