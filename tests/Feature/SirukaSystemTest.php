<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Facility;
use App\Models\Room;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SirukaSystemTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected User $peminjam;

    protected Room $room;

    protected Facility $facility;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::create([
            'name' => 'Admin Test',
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $this->peminjam = User::create([
            'name' => 'Peminjam Test',
            'email' => 'peminjam@test.com',
            'password' => bcrypt('password'),
            'role' => 'peminjam',
            'nim_nip' => '12345678',
            'no_hp' => '0812345678',
        ]);

        $this->facility = Facility::create([
            'nama_fasilitas' => 'Proyektor HD',
        ]);

        $this->room = Room::create([
            'kode' => 'R101',
            'nama' => 'Ruang 101',
            'gedung' => 'Gedung A',
            'lantai' => 1,
            'kapasitas' => 30,
            'status' => 'tersedia',
        ]);
        $this->room->facilities()->attach($this->facility->id);
    }

    public function test_landing_page_is_accessible()
    {
        $response = $this->get(route('home'));
        $response->assertStatus(200);
        $response->assertSee('SIRUKA');
        $response->assertSee('Ruang 101');
    }

    public function test_user_authentication_and_redirection()
    {
        // Admin login redirects to admin dashboard
        $response = $this->post(route('login.post'), [
            'email' => 'admin@test.com',
            'password' => 'password',
        ]);
        $response->assertRedirect(route('admin.dashboard'));

        $this->post(route('logout'));

        // Peminjam login redirects to peminjam dashboard
        $response = $this->post(route('login.post'), [
            'email' => 'peminjam@test.com',
            'password' => 'password',
        ]);
        $response->assertRedirect(route('peminjam.dashboard'));
    }

    public function test_role_authorization_middleware()
    {
        // Peminjam trying to access admin dashboard is blocked with 403
        $response = $this->actingAs($this->peminjam)->get(route('admin.dashboard'));
        $response->assertStatus(403);

        // Admin accessing peminjam dashboard is redirected to admin dashboard
        $response = $this->actingAs($this->admin)->get(route('peminjam.dashboard'));
        $response->assertRedirect(route('admin.dashboard'));
    }

    public function test_peminjam_registration()
    {
        $response = $this->post(route('register.post'), [
            'name' => 'New Student',
            'email' => 'student@test.com',
            'nim_nip' => '998877',
            'no_hp' => '08999999',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertRedirect(route('peminjam.dashboard'));
        $this->assertDatabaseHas('users', [
            'email' => 'student@test.com',
            'role' => 'peminjam',
        ]);
    }

    public function test_admin_cannot_delete_room_with_active_bookings()
    {
        // Create active booking for tomorrow
        Booking::create([
            'user_id' => $this->peminjam->id,
            'room_id' => $this->room->id,
            'tanggal' => Carbon::tomorrow()->toDateString(),
            'jam_mulai' => '08:00',
            'jam_selesai' => '10:00',
            'keperluan' => 'Kuliah',
            'jumlah_peserta' => 20,
            'status' => 'disetujui',
        ]);

        $response = $this->actingAs($this->admin)->delete(route('admin.rooms.destroy', $this->room));
        $response->assertSessionHas('error');
        $this->assertDatabaseHas('rooms', ['id' => $this->room->id]);
    }

    public function test_admin_cannot_delete_facility_in_use()
    {
        $response = $this->actingAs($this->admin)->delete(route('admin.facilities.destroy', $this->facility));
        $response->assertSessionHas('error');
        $this->assertDatabaseHas('facilities', ['id' => $this->facility->id]);
    }

    public function test_booking_validation_rules()
    {
        $tomorrow = Carbon::tomorrow()->toDateString();
        $yesterday = Carbon::yesterday()->toDateString();

        // 1. Date cannot be in the past
        $response = $this->actingAs($this->peminjam)->post(route('peminjam.bookings.store'), [
            'room_id' => $this->room->id,
            'tanggal' => $yesterday,
            'jam_mulai' => '08:00',
            'jam_selesai' => '10:00',
            'keperluan' => 'Masa lalu',
            'jumlah_peserta' => 10,
        ]);
        $response->assertSessionHasErrors('tanggal');

        // 2. Jam selesai must be > jam mulai
        $response = $this->actingAs($this->peminjam)->post(route('peminjam.bookings.store'), [
            'room_id' => $this->room->id,
            'tanggal' => $tomorrow,
            'jam_mulai' => '11:00',
            'jam_selesai' => '09:00',
            'keperluan' => 'Jam salah',
            'jumlah_peserta' => 10,
        ]);
        $response->assertSessionHasErrors('jam_selesai');

        // 3. Attendees cannot exceed capacity (room capacity is 30)
        $response = $this->actingAs($this->peminjam)->post(route('peminjam.bookings.store'), [
            'room_id' => $this->room->id,
            'tanggal' => $tomorrow,
            'jam_mulai' => '08:00',
            'jam_selesai' => '10:00',
            'keperluan' => 'Peserta berlebih',
            'jumlah_peserta' => 50,
        ]);
        $response->assertSessionHasErrors('jumlah_peserta');

        // 4. Room in maintenance cannot be booked
        $maintenanceRoom = Room::create([
            'kode' => 'RM-MT',
            'nama' => 'Ruang Rusak',
            'gedung' => 'B',
            'lantai' => 1,
            'kapasitas' => 20,
            'status' => 'maintenance',
        ]);
        $response = $this->actingAs($this->peminjam)->post(route('peminjam.bookings.store'), [
            'room_id' => $maintenanceRoom->id,
            'tanggal' => $tomorrow,
            'jam_mulai' => '08:00',
            'jam_selesai' => '10:00',
            'keperluan' => 'Coba booking maintenance',
            'jumlah_peserta' => 10,
        ]);
        $response->assertSessionHasErrors('room_id');
    }

    public function test_booking_conflict_prevention()
    {
        $tomorrow = Carbon::tomorrow()->toDateString();

        // Existing approved booking from 09:00 to 12:00
        Booking::create([
            'user_id' => $this->peminjam->id,
            'room_id' => $this->room->id,
            'tanggal' => $tomorrow,
            'jam_mulai' => '09:00',
            'jam_selesai' => '12:00',
            'keperluan' => 'Seminar Utama',
            'jumlah_peserta' => 20,
            'status' => 'disetujui',
        ]);

        // Attempt overlapping booking 10:00 to 11:00 (inside)
        $response = $this->actingAs($this->peminjam)->post(route('peminjam.bookings.store'), [
            'room_id' => $this->room->id,
            'tanggal' => $tomorrow,
            'jam_mulai' => '10:00',
            'jam_selesai' => '11:00',
            'keperluan' => 'Overlap test',
            'jumlah_peserta' => 15,
        ]);
        $response->assertSessionHasErrors('jam_mulai');

        // Attempt non-overlapping booking 13:00 to 15:00 (success)
        $response = $this->actingAs($this->peminjam)->post(route('peminjam.bookings.store'), [
            'room_id' => $this->room->id,
            'tanggal' => $tomorrow,
            'jam_mulai' => '13:00',
            'jam_selesai' => '15:00',
            'keperluan' => 'Kegiatan Siang',
            'jumlah_peserta' => 15,
        ]);
        $response->assertRedirect(route('peminjam.bookings.index'));
        $this->assertDatabaseHas('bookings', [
            'keperluan' => 'Kegiatan Siang',
            'status' => 'menunggu',
        ]);
    }

    public function test_admin_approve_and_reject_booking()
    {
        $tomorrow = Carbon::tomorrow()->toDateString();

        $booking = Booking::create([
            'user_id' => $this->peminjam->id,
            'room_id' => $this->room->id,
            'tanggal' => $tomorrow,
            'jam_mulai' => '15:00',
            'jam_selesai' => '17:00',
            'keperluan' => 'Rapat Himpunan',
            'jumlah_peserta' => 20,
            'status' => 'menunggu',
        ]);

        // Admin approves
        $response = $this->actingAs($this->admin)->post(route('admin.bookings.approve', $booking));
        $response->assertSessionHas('success');
        $this->assertEquals('disetujui', $booking->fresh()->status);

        // Reject requires reason
        $booking2 = Booking::create([
            'user_id' => $this->peminjam->id,
            'room_id' => $this->room->id,
            'tanggal' => $tomorrow,
            'jam_mulai' => '17:30',
            'jam_selesai' => '19:00',
            'keperluan' => 'Rapat Malam',
            'jumlah_peserta' => 10,
            'status' => 'menunggu',
        ]);

        // Attempt reject without reason -> fails
        $response = $this->actingAs($this->admin)->post(route('admin.bookings.reject', $booking2), [
            'alasan_penolakan' => '',
        ]);
        $response->assertSessionHasErrors('alasan_penolakan');

        // Reject with reason -> succeeds
        $response = $this->actingAs($this->admin)->post(route('admin.bookings.reject', $booking2), [
            'alasan_penolakan' => 'Jam operasional gedung hanya sampai pukul 17:00 WIB.',
        ]);
        $response->assertSessionHas('success');
        $this->assertEquals('ditolak', $booking2->fresh()->status);
        $this->assertEquals('Jam operasional gedung hanya sampai pukul 17:00 WIB.', $booking2->fresh()->alasan_penolakan);
    }

    public function test_peminjam_can_cancel_pending_booking()
    {
        $tomorrow = Carbon::tomorrow()->toDateString();

        $booking = Booking::create([
            'user_id' => $this->peminjam->id,
            'room_id' => $this->room->id,
            'tanggal' => $tomorrow,
            'jam_mulai' => '07:00',
            'jam_selesai' => '08:30',
            'keperluan' => 'Diskusi Pagi',
            'jumlah_peserta' => 5,
            'status' => 'menunggu',
        ]);

        $response = $this->actingAs($this->peminjam)->delete(route('peminjam.bookings.destroy', $booking));
        $response->assertRedirect(route('peminjam.bookings.index'));
        $this->assertEquals('dibatalkan', $booking->fresh()->status);
    }

    public function test_all_views_render_successfully()
    {
        $tomorrow = Carbon::tomorrow()->toDateString();
        $booking = Booking::create([
            'user_id' => $this->peminjam->id,
            'room_id' => $this->room->id,
            'tanggal' => $tomorrow,
            'jam_mulai' => '13:00',
            'jam_selesai' => '15:00',
            'keperluan' => 'View render test',
            'jumlah_peserta' => 10,
            'status' => 'menunggu',
        ]);

        // Admin views
        $this->actingAs($this->admin)->get(route('admin.dashboard'))->assertStatus(200);
        $this->actingAs($this->admin)->get(route('admin.rooms.index'))->assertStatus(200);
        $this->actingAs($this->admin)->get(route('admin.rooms.create'))->assertStatus(200);
        $this->actingAs($this->admin)->get(route('admin.rooms.edit', $this->room))->assertStatus(200);
        $this->actingAs($this->admin)->get(route('admin.facilities.index'))->assertStatus(200);
        $this->actingAs($this->admin)->get(route('admin.bookings.index'))->assertStatus(200);
        $this->actingAs($this->admin)->get(route('admin.bookings.show', $booking))->assertStatus(200);
        $this->actingAs($this->admin)->get(route('admin.bookings.reject_form', $booking))->assertStatus(200);
        $this->actingAs($this->admin)->get(route('admin.reports.index'))->assertStatus(200);
        $this->actingAs($this->admin)->get(route('admin.reports.print'))->assertStatus(200);
        $this->actingAs($this->admin)->get(route('admin.users.index'))->assertStatus(200);
        $this->actingAs($this->admin)->get(route('admin.users.create'))->assertStatus(200);
        $this->actingAs($this->admin)->get(route('admin.users.edit', $this->peminjam))->assertStatus(200);

        // Peminjam views
        $this->actingAs($this->peminjam)->get(route('peminjam.dashboard'))->assertStatus(200);
        $this->actingAs($this->peminjam)->get(route('peminjam.rooms.index'))->assertStatus(200);
        $this->actingAs($this->peminjam)->get(route('peminjam.rooms.show', $this->room))->assertStatus(200);
        $this->actingAs($this->peminjam)->get(route('peminjam.bookings.index'))->assertStatus(200);
        $this->actingAs($this->peminjam)->get(route('peminjam.bookings.show', $booking))->assertStatus(200);
        $this->actingAs($this->peminjam)->get(route('peminjam.bookings.create'))->assertStatus(200);
        $this->actingAs($this->peminjam)->get(route('peminjam.bookings.edit', $booking))->assertStatus(200);
        $this->actingAs($this->peminjam)->get(route('peminjam.profile.index'))->assertStatus(200);
    }

    public function test_cetak_surat_bukti_peminjaman()
    {
        $approvedBooking = Booking::create([
            'user_id' => $this->peminjam->id,
            'room_id' => $this->room->id,
            'tanggal' => Carbon::tomorrow()->toDateString(),
            'jam_mulai' => '09:00',
            'jam_selesai' => '11:00',
            'keperluan' => 'Cetak surat bukti test',
            'jumlah_peserta' => 15,
            'status' => 'disetujui',
        ]);

        // Peminjam can print their approved booking
        $response = $this->actingAs($this->peminjam)->get(route('peminjam.bookings.cetak', $approvedBooking));
        $response->assertStatus(200);
        $response->assertSee('Surat Bukti Persetujuan Peminjaman Ruangan');
        $response->assertSee('Disetujui');

        // Admin can also print it
        $adminResponse = $this->actingAs($this->admin)->get(route('admin.bookings.cetak', $approvedBooking));
        $adminResponse->assertStatus(200);
    }

    public function test_admin_can_toggle_room_status()
    {
        $this->assertEquals('tersedia', $this->room->status);

        $response = $this->actingAs($this->admin)->post(route('admin.rooms.toggle_status', $this->room));
        $response->assertRedirect();
        $this->assertEquals('maintenance', $this->room->fresh()->status);

        $response = $this->actingAs($this->admin)->post(route('admin.rooms.toggle_status', $this->room));
        $response->assertRedirect();
        $this->assertEquals('tersedia', $this->room->fresh()->status);
    }

    public function test_user_can_login_with_nim()
    {
        $response = $this->post(route('login.post'), [
            'login' => '12345678', // NIM of $this->peminjam
            'password' => 'password',
        ]);

        $response->assertRedirect(route('peminjam.dashboard'));
        $this->assertAuthenticatedAs($this->peminjam);
    }

    public function test_user_login_clears_admin_intended_url()
    {
        // Simulate previous visit to an admin route
        session()->put('url.intended', route('admin.dashboard'));

        $response = $this->post(route('login.post'), [
            'login' => 'peminjam@test.com',
            'password' => 'password',
        ]);

        // Should NOT redirect to admin.dashboard (which would cause 403)
        $response->assertRedirect(route('peminjam.dashboard'));
        $this->assertAuthenticatedAs($this->peminjam);
    }

    public function test_login_page_renders_with_user_demo()
    {
        $response = $this->get(route('login', ['demo' => 'user']));
        $response->assertStatus(200);
        $response->assertSee('alya@siruka.ac.id');
        $response->assertSee('Mahasiswa / User');
    }

    public function test_dashboard_and_user_routes_redirect_correctly()
    {
        $response = $this->actingAs($this->peminjam)->get('/dashboard');
        $response->assertRedirect(route('peminjam.dashboard'));

        $userRouteResponse = $this->actingAs($this->peminjam)->get('/user');
        $userRouteResponse->assertRedirect(route('peminjam.dashboard'));

        $adminDashboardResponse = $this->actingAs($this->admin)->get('/dashboard');
        $adminDashboardResponse->assertRedirect(route('admin.dashboard'));
    }
}
