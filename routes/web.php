<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Peminjam;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| SIRUKA (Sistem Booking Ruangan Kampus) - Web Routes
| Jurusan Ilmu Komputer, FMIPA, Universitas Lampung
|--------------------------------------------------------------------------
*/

// Public & Landing Page
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/rooms/{room}', [Peminjam\RoomController::class, 'show'])->name('public.rooms.show');

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Dashboard & General Redirects
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return auth()->user()->isAdmin()
            ? redirect()->route('admin.dashboard')
            : redirect()->route('peminjam.dashboard');
    })->name('dashboard');

    Route::get('/user', function () {
        return redirect()->route('peminjam.dashboard');
    });
});

// ==========================================
// ROLE 1: ADMIN JURUSAN ILMU KOMPUTER FMIPA
// ==========================================
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [Admin\DashboardController::class, 'index'])->name('dashboard');

    // CRUD Ruangan
    Route::resource('rooms', Admin\RoomController::class);
    Route::match(['patch', 'post'], 'rooms/{room}/toggle-status', [Admin\RoomController::class, 'toggleStatus'])->name('rooms.toggle-status');
    Route::match(['patch', 'post'], 'rooms/{room}/toggle_status', [Admin\RoomController::class, 'toggleStatus'])->name('rooms.toggle_status');

    // CRUD Fasilitas
    Route::resource('facilities', Admin\FacilityController::class)->except(['create', 'show']);

    // Kelola Pengguna (CRUD Peminjam / Akun)
    Route::resource('users', Admin\UserController::class);

    // Kelola Booking & Persetujuan
    Route::get('bookings', [Admin\BookingController::class, 'index'])->name('bookings.index');
    Route::get('bookings/{booking}', [Admin\BookingController::class, 'show'])->name('bookings.show');
    Route::get('bookings/{booking}/cetak', [Admin\BookingController::class, 'cetak'])->name('bookings.cetak');
    Route::match(['patch', 'post'], 'bookings/{booking}/approve', [Admin\BookingController::class, 'approve'])->name('bookings.approve');
    Route::get('bookings/{booking}/reject', [Admin\BookingController::class, 'showRejectForm'])->name('bookings.reject_form');
    Route::get('bookings/{booking}/reject-form', [Admin\BookingController::class, 'showRejectForm'])->name('bookings.reject-form');
    Route::match(['patch', 'post'], 'bookings/{booking}/reject', [Admin\BookingController::class, 'reject'])->name('bookings.reject');
    Route::delete('bookings/{booking}', [Admin\BookingController::class, 'destroy'])->name('bookings.destroy');

    // Laporan & Cetak Rekapitulasi
    Route::get('reports', [Admin\ReportController::class, 'index'])->name('reports.index');
    Route::get('reports/print', [Admin\ReportController::class, 'print'])->name('reports.print');
});

// ==========================================
// ROLE 2: PEMINJAM (MAHASISWA / DOSEN)
// ==========================================
Route::middleware(['auth', 'peminjam'])->prefix('peminjam')->name('peminjam.')->group(function () {
    Route::get('/dashboard', [Peminjam\DashboardController::class, 'index'])->name('dashboard');

    // Lihat Ruangan & Ketersediaan
    Route::get('/rooms', [Peminjam\RoomController::class, 'index'])->name('rooms.index');
    Route::get('/rooms/{room}', [Peminjam\RoomController::class, 'show'])->name('rooms.show');
    Route::get('/rooms/{room}/schedule', [Peminjam\RoomController::class, 'scheduleJson'])->name('rooms.schedule-json');

    // CRUD Pengajuan Booking
    Route::resource('bookings', Peminjam\BookingController::class);
    Route::get('/bookings/{booking}/cetak', [Peminjam\BookingController::class, 'cetak'])->name('bookings.cetak');

    // Profil Mahasiswa / Peminjam
    Route::get('/profile', [Peminjam\ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [Peminjam\ProfileController::class, 'update'])->name('profile.update');
});
