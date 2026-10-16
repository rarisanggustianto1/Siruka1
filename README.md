# 🏛️ SIRUKA (Sistem Booking Ruangan Kampus)
### Jurusan Ilmu Komputer &bull; Fakultas Matematika dan Ilmu Pengetahuan Alam (FMIPA) &bull; Universitas Lampung

SIRUKA adalah aplikasi web modern berbasis **Laravel MVC** dan database **PostgreSQL** yang dirancang untuk mengelola peminjaman sarana prasarana dan ruangan (laboratorium komputer, ruang seminar, ruang sidang skripsi, ruang diskusi, dan aula) di lingkungan **Jurusan Ilmu Komputer FMIPA Universitas Lampung**.

Aplikasi ini menggantikan proses peminjaman manual dengan sistem terpusat, memvalidasi ketersediaan secara real-time, mendeteksi bentrok jadwal secara otomatis, dan menyediakan pencetakan bukti peminjaman resmi.

---

## 🎯 Pemenuhan Ketentuan UTP PWL

| No | Ketentuan UTP PWL | Status | Penjelasan Implementasi |
|:---|:---|:---:|:---|
| 1 | **Minimal 2 Role Wajib CRUD** | ✅ Terpenuhi | Terdapat 2 role independen: **Admin Jurusan** (Kelola Ruangan, Fasilitas, Pengguna, Approval Booking) & **Mahasiswa/Peminjam** (Kelola Profil, CRUD Booking). |
| 2 | **Tema Bebas** | ✅ Terpenuhi | Sistem Booking Ruangan Kampus Jurusan Ilmu Komputer FMIPA Unila. |
| 3 | **Deadline** | ✅ Terpenuhi | Diselesaikan sebelum 18 Oktober 2026 23.59. |
| 4 | **Wajib Push GitHub** | ✅ Siap Push | Repositori Git sudah diinisialisasi dan siap di-push ke remote repository. |
| 5 | **CRUD 2 Fitur Selain Login/Register** | ✅ Terpenuhi (Lebih dari 4 Fitur) | **CRUD Ruangan**, **CRUD Fasilitas**, **CRUD Pengguna**, dan **CRUD Pengajuan Booking**. |
| 6 | **Error Handling Bebas Error Laravel** | ✅ Terpenuhi | Error ditangani dengan validasi user-friendly, flash alert, serta custom error page berdesain khusus: `403 (Akses Dibatasi)`, `404 (Data Tidak Ditemukan)`, `419 (Sesi Berakhir)`, dan `500 (Kendala Sistem)`. |
| 7 | **Fitur Harus Selesai Tuntas** | ✅ 100% Selesai | Seluruh 19 unit & feature tests lulus (91 assertions), tidak ada fitur menggantung. |
| 8 | **Tema Unik & Tidak Sama** | ✅ Terpenuhi | Konteks spesifik Ilmu Komputer FMIPA Unila dengan data laboratorium & aturan operasional kampus. |
| 9 | **Tampilan UI Point Plus** | ✅ Desain Premium | UI menggunakan Tailwind CSS, typography Plus Jakarta Sans, status badge modern, layout responsif mobile & desktop, filter interaktif, dan format surat cetak resmi. |

---

## 👥 Hak Akses & Fitur Role

### 1. 👑 Role: Administrator (Admin Jurusan Ilmu Komputer)
- **Dashboard Statistik**:
  - Statistik real-time: Total Ruangan, Total Pengguna/Peminjam, Booking Menunggu Persetujuan, dan Booking Hari Ini.
  - Tabel 5 pengajuan terbaru yang menunggu persetujuan admin.
  - Jadwal peminjaman aktif hari ini.
- **CRUD Ruangan**:
  - *Create*: Tambah ruangan (kode unik, nama, gedung, lantai, kapasitas, deskripsi, upload foto, status, dan pilih relasi fasilitas many-to-many).
  - *Read*: Tabel ruangan dengan live search, filter gedung, dan pagination.
  - *Update*: Ubah data ruangan, fasilitas terkait, dan toggle status (Tersedia / Maintenance).
  - *Delete*: Hapus ruangan dengan validasi proteksi jika ruangan masih memiliki booking aktif.
- **CRUD Fasilitas**:
  - Master fasilitas kampus (Proyektor 4K, AC Inverter, Sound System, WiFi 1Gbps, Smart TV, dll).
  - Proteksi hapus fasilitas jika masih terpasang di ruangan.
- **Kelola Booking (Approval Engine)**:
  - Filter pengajuan berdasarkan status (Menunggu, Disetujui, Ditolak, Dibatalkan), tanggal, dan ruangan.
  - **Setujui (Approve)**: Memvalidasi ketiadaan bentrok dan status ruangan, lalu mengunci jadwal.
  - **Tolak (Reject)**: Menolak pengajuan dengan **wajib mengisi alasan penolakan** yang transparan kepada peminjam.
  - **Cetak Bukti**: Mencetak surat izin peminjaman ruangan resmi.
  - **Hapus Data**: Menghapus data riwayat booking.
- **CRUD Pengguna**:
  - Kelola akun peminjam (Nama, Email, NIM/NIP, No HP, Role, Password).
  - Proteksi hapus akun jika user masih memiliki jadwal booking aktif mendatang.
- **Laporan & Rekapitulasi**:
  - Filter laporan berdasarkan rentang tanggal, status, dan ruangan.
  - Ringkasan metrics: Total pengajuan periode, Approval rate (%), ruangan paling sering dipinjam.
  - Fitur Cetak Rekapitulasi Laporan Siap Print.

### 2. 🎓 Role: Peminjam (Mahasiswa Ilmu Komputer)
- **Dashboard Mahasiswa**:
  - Ringkasan status pengajuan: Menunggu, Disetujui, Ditolak, dan Total Booking.
  - Jadwal peminjaman terdekat dan riwayat aktivitas terakhir.
- **CRUD Pengajuan Booking**:
  - *Create*: Memilih ruangan, tanggal peminjaman, jam mulai, jam selesai, keperluan, dan jumlah peserta.
  - *Read*: Riwayat pengajuan dengan status badge interaktif.
  - *Update*: Ubah detail pengajuan (hanya jika status masih **Menunggu**).
  - *Delete*: Batalkan pengajuan (hanya jika status masih **Menunggu**).
  - *Cetak Bukti*: Mencetak Surat Bukti Peminjaman resmi setelah status disetujui Admin.
- **Katalog & Cek Ketersediaan Ruangan**:
  - Pencarian ruangan dengan filter gedung, kapasitas minimal, dan fasilitas yang diinginkan.
  - Detail ruangan lengkap dengan jadwal pemakaian harian agar peminjam mengetahui jam yang sudah terisi.
- **Profil Akun**:
  - Memperbarui nama lengkap, nomor WhatsApp/HP, dan mengganti password akun.

---

## 🛡️ Batasan Sistem & Validasi Bisnis

1. **Jam Selesai > Jam Mulai**: Jam selesai harus lebih besar dari jam mulai.
2. **Jam Operasional Kampus**: Peminjaman dibatasi pada rentang operasional 07:00 – 22:00 WIB.
3. **Validasi Masa Depan**: Tanggal booking tidak boleh di masa lalu. Untuk hari yang sama, jam mulai tidak boleh waktu yang sudah terlewat.
4. **Kapasitas Ruangan**: Jumlah peserta tidak boleh melebihi kapasitas maksimal ruangan.
5. **Ruangan Maintenance**: Ruangan dengan status *Maintenance* tidak dapat dipesan.
6. **Pencegahan Bentrok Otomatis (Overlap Prevention)**: Sistem otomatis memblokir pengajuan yang bertabrakan dengan booking berstatus **Disetujui** pada ruangan dan waktu yang sama (`jam_mulai < booking_selesai` AND `jam_selesai > booking_mulai`).
7. **Hak Akses Kepemilikan**: Peminjam hanya dapat melihat, mengubah, atau membatalkan pengajuan miliknya sendiri.
8. **Integritas Data Master**: Ruangan atau fasilitas yang sedang terpakai tidak dapat dihapus sembarangan.

---

## 🗄️ Struktur Basis Data (PostgreSQL)

```
[ users ]
   │
   ├── (1:N) ──> [ bookings ] <── (N:1) ── [ rooms ]
                                               │
                                            (N:M via facility_room)
                                               │
                                         [ facilities ]
```

### Tabel: `users`
- `id` (bigint, PK)
- `name` (varchar 255)
- `email` (varchar 255, unique)
- `password` (varchar 255)
- `role` (enum: 'admin', 'peminjam')
- `nim_nip` (varchar 50, nullable)
- `no_hp` (varchar 20, nullable)
- `timestamps`

### Tabel: `rooms`
- `id` (bigint, PK)
- `kode` (varchar 50, unique)
- `nama` (varchar 255)
- `gedung` (varchar 255)
- `lantai` (integer)
- `kapasitas` (integer)
- `deskripsi` (text, nullable)
- `foto` (varchar 255, nullable)
- `status` (enum: 'tersedia', 'maintenance')
- `timestamps`

### Tabel: `facilities`
- `id` (bigint, PK)
- `nama_fasilitas` (varchar 255, unique)
- `timestamps`

### Tabel: `facility_room` (Pivot Many-to-Many)
- `id` (bigint, PK)
- `room_id` (foreignId -> rooms, cascade)
- `facility_id` (foreignId -> facilities, cascade)
- `timestamps`

### Tabel: `bookings`
- `id` (bigint, PK)
- `user_id` (foreignId -> users, cascade)
- `room_id` (foreignId -> rooms, cascade)
- `tanggal` (date)
- `jam_mulai` (time)
- `jam_selesai` (time)
- `keperluan` (varchar 500)
- `jumlah_peserta` (integer)
- `status` (enum: 'menunggu', 'disetujui', 'ditolak', 'dibatalkan')
- `alasan_penolakan` (text, nullable)
- `timestamps`

---

## 🔑 Akun Uji Coba Cepat (Seeded)

Pada halaman login (`/login`), terdapat tombol cepat satu-klik untuk masuk tanpa mengetik manual:

| Role | Email / Login | Password | Keterangan |
|:---|:---|:---|:---|
| **Admin Jurusan** | `admin@siruka.ac.id` *(atau `admin@ilkom.unila.ac.id`)* | `password` | Akses penuh dashboard admin, kelola ruangan, fasilitas, persetujuan booking & laporan |
| **Mahasiswa** | `alya@siruka.ac.id` *(NIM: `2217051015`)* | `password` | Akun mahasiswa Ilmu Komputer untuk simulasi peminjaman |
| **Mahasiswa 2** | `raris@student.unila.ac.id` *(NIM: `2217051042`)* | `password` | Akun peminjam dengan riwayat peminjaman aktif & selesai |

---

## 🚀 Panduan Menjalankan Sistem di Laragon (PHP 8.3 & PostgreSQL)

### 1. Prasyarat Sistem
- **PHP 8.3** (Ekstensi `pdo_pgsql` dan `pgsql` aktif di Laragon).
- **PostgreSQL** aktif (Port default: `5432`).
- Database bernama `siruka` sudah dibuat di PostgreSQL.

### 2. Konfigurasi Lingkungan (`.env`)
Pastikan file `.env` memiliki konfigurasi database:
```dotenv
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=siruka
DB_USERNAME=postgres
DB_PASSWORD=root
```

### 3. Migrasi & Seeding Data Awal
Jalankan perintah berikut pada terminal:
```bash
php artisan migrate:fresh --seed
php artisan storage:link
```

### 4. Menjalankan Server Lokal
```bash
php artisan serve
```
Akses melalui peramban web: [http://127.0.0.1:8000](http://127.0.0.1:8000)

---

## 🧪 Menjalankan Pengujian Otomatis (PHPUnit)

Aplikasi dilengkapi 19 test case komprehensif yang mencakup seluruh alur autentikasi, otorisasi role middleware, CRUD ruangan, CRUD fasilitas, validasi bentrok jadwal, dan persetujuan:
```bash
php artisan test --compact
```
Hasil:
```
Tests:    19 passed (91 assertions)
Duration: 2.56s
```

---

## 📦 Panduan Push ke Repositori GitHub

Repositori Git lokal sudah diinisialisasi. Untuk mengunggah ke GitHub milik Anda:

1. Buat repositori baru di akun [GitHub](https://github.com/new) Anda (misal dengan nama `siruka-unila`).
2. Jalankan perintah berikut di terminal:
```bash
git add .
git commit -m "feat: complete SIRUKA Campus Room Booking System - Jurusan Ilmu Komputer FMIPA Unila"
git branch -M main
git remote add origin https://github.com/USERNAME-ANDA/siruka-unila.git
git push -u origin main
```

---
*Dibuat untuk Ujian Tengah Praktikum (UTP) Pemrograman Web Lanjut &bull; Jurusan Ilmu Komputer FMIPA Universitas Lampung.*
