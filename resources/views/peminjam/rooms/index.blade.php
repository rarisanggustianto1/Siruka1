@extends('layouts.peminjam')

@section('title', 'Katalog Ruangan')

@section('content')
<div class="space-y-6">

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Katalog Ruangan Kampus</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">Eksplorasi ruangan, cek ketersediaan jam kosong, dan ajukan peminjaman secara mandiri.</p>
        </div>
        <a href="{{ route('peminjam.bookings.create') }}" class="inline-flex items-center px-4 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm shadow-md shadow-blue-600/20 transition-all self-start sm:self-auto">
            <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Formulir Peminjaman
        </a>
    </div>


    <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm">
        <form action="{{ route('peminjam.rooms.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">
            <div>
                <label class="block text-xs font-bold text-slate-600 mb-1">Cari Nama / Kode</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Contoh: A201, Lab..."
                    class="w-full px-3.5 py-2 text-sm border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-600 mb-1">Gedung</label>
                <select name="gedung" class="w-full px-3.5 py-2 text-sm border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    <option value="">Semua Gedung</option>
                    @foreach($buildings as $b)
                        <option value="{{ $b }}" {{ request('gedung') == $b ? 'selected' : '' }}>{{ $b }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-600 mb-1">Min. Kapasitas (Org)</label>
                <input type="number" name="min_kapasitas" value="{{ request('min_kapasitas') }}" placeholder="Min. peserta" min="1"
                    class="w-full px-3.5 py-2 text-sm border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-600 mb-1">Fasilitas</label>
                <select name="facility_id" class="w-full px-3.5 py-2 text-sm border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    <option value="">Semua Fasilitas</option>
                    @foreach($facilities as $f)
                        <option value="{{ $f->id }}" {{ request('facility_id') == $f->id ? 'selected' : '' }}>{{ $f->nama_fasilitas }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex items-end space-x-2">
                <button type="submit" class="flex-1 py-2 px-4 rounded-xl bg-slate-800 hover:bg-slate-900 text-white font-bold text-xs shadow-sm transition-colors">
                    Terapkan
                </button>
                @if(request()->hasAny(['search', 'gedung', 'min_kapasitas', 'facility_id']))
                    <a href="{{ route('peminjam.rooms.index') }}" class="py-2 px-3 rounded-xl border border-slate-300 text-slate-600 hover:bg-slate-100 text-xs font-semibold">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>


    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($rooms as $room)
            <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300 flex flex-col group">

                <div class="relative h-48 bg-slate-100 overflow-hidden">
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
                        <span class="px-2.5 py-1 rounded-lg text-xs font-mono font-bold bg-slate-900/80 text-white backdrop-blur-sm">
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
                            {{ $room->deskripsi ?? 'Ruangan kampus siap pakai untuk kegiatan belajar mengajar atau pertemuan.' }}
                        </p>


                        <div class="mt-4 flex flex-wrap gap-1.5">
                            @forelse($room->facilities->take(3) as $fac)
                                <span class="px-2 py-0.5 rounded-md bg-slate-100 text-slate-700 text-[11px] font-medium border border-slate-200">
                                    {{ $fac->nama_fasilitas }}
                                </span>
                            @empty
                                <span class="text-[11px] text-slate-400">Fasilitas standar</span>
                            @endforelse
                            @if($room->facilities->count() > 3)
                                <span class="px-2 py-0.5 rounded-md bg-blue-50 text-blue-700 text-[11px] font-bold border border-blue-100">
                                    +{{ $room->facilities->count() - 3 }} lainnya
                                </span>
                            @endif
                        </div>
                    </div>


                    <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between gap-2">
                        <a href="{{ route('peminjam.rooms.show', $room) }}" class="text-xs font-bold text-slate-600 hover:text-blue-600 flex items-center transition-colors">
                            Cek Jadwal
                            <svg class="w-3.5 h-3.5 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>

                        @if($room->status === 'tersedia')
                            <a href="{{ route('peminjam.bookings.create', ['room_id' => $room->id]) }}" class="px-3.5 py-1.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold shadow-sm transition-colors">
                                Booking Ruangan
                            </a>
                        @else
                            <span class="px-3 py-1.5 rounded-xl bg-slate-100 text-slate-400 text-xs font-semibold cursor-not-allowed">
                                Tidak Tersedia
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full py-12 text-center bg-white rounded-2xl border border-slate-200">
                <p class="text-base font-bold text-slate-700">Tidak ada ruangan yang cocok dengan filter</p>
                <div class="mt-4">
                    <a href="{{ route('peminjam.rooms.index') }}" class="px-4 py-2 rounded-xl bg-blue-600 text-white font-bold text-xs">Reset Filter</a>
                </div>
            </div>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $rooms->links() }}
    </div>
</div>
@endsection
