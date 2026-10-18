<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Bukti Peminjaman Ruangan #BK-{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }} - SIRUKA</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=Space+Mono:wght@700&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: #0f172a;
            background-color: #f1f5f9;
            padding: 30px 15px;
            font-size: 13px;
            line-height: 1.6;
        }
        .container {
            max-width: 820px;
            margin: 0 auto;
            background: #fff;
            padding: 48px;
            border-radius: 16px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05);
            position: relative;
        }
        .action-bar {
            text-align: center;
            margin-bottom: 24px;
        }
        .btn-print {
            background: linear-gradient(135deg, #4f46e5, #4338ca);
            color: white;
            border: none;
            padding: 10px 24px;
            border-radius: 10px;
            font-weight: 700;
            font-size: 13px;
            cursor: pointer;
            box-shadow: 0 4px 10px rgba(79, 70, 229, 0.3);
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .btn-back {
            background: #e2e8f0;
            color: #334155;
            border: none;
            padding: 10px 18px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 13px;
            cursor: pointer;
            margin-left: 10px;
            text-decoration: none;
            display: inline-block;
        }
        .kop-surat {
            display: flex;
            align-items: center;
            border-bottom: 3px double #0f172a;
            padding-bottom: 20px;
            margin-bottom: 24px;
        }
        .kop-logo {
            width: 72px;
            height: 72px;
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            color: white;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            font-weight: 900;
            margin-right: 20px;
            flex-shrink: 0;
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.25);
        }
        .kop-text h2 {
            font-size: 13px;
            font-weight: 700;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            color: #475569;
        }
        .kop-text h1 {
            font-size: 19px;
            font-weight: 900;
            color: #0f172a;
            margin: 2px 0;
            letter-spacing: -0.01em;
        }
        .kop-text p {
            font-size: 11px;
            color: #64748b;
        }
        .surat-header {
            text-align: center;
            margin-bottom: 28px;
        }
        .surat-title {
            font-size: 16px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: #0f172a;
            text-decoration: underline;
        }
        .surat-nomor {
            font-size: 12px;
            color: #64748b;
            font-family: 'Space Mono', monospace;
            margin-top: 4px;
        }
        .watermark-badge {
            position: absolute;
            top: 155px;
            right: 48px;
            border: 2px solid #16a34a;
            color: #16a34a;
            padding: 6px 14px;
            border-radius: 8px;
            font-weight: 800;
            font-size: 13px;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            transform: rotate(-5deg);
            background: rgba(220, 252, 231, 0.5);
        }
        .intro-text {
            margin-bottom: 20px;
            text-align: justify;
            font-size: 13px;
            color: #334155;
        }
        .section-title {
            font-size: 12px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #4f46e5;
            margin-bottom: 8px;
            border-left: 3px solid #4f46e5;
            padding-left: 8px;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 22px;
            font-size: 12.5px;
        }
        .info-table td {
            padding: 6px 4px;
            vertical-align: top;
        }
        .info-table td.label {
            width: 190px;
            color: #64748b;
            font-weight: 600;
        }
        .info-table td.colon {
            width: 15px;
            color: #64748b;
            text-align: center;
        }
        .info-table td.value {
            color: #0f172a;
            font-weight: 600;
        }
        .badge-chip {
            display: inline-block;
            background: #f1f5f9;
            color: #334155;
            padding: 2px 8px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 600;
            margin-right: 4px;
            margin-bottom: 4px;
            border: 1px solid #e2e8f0;
        }
        .rules-box {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 14px 18px;
            margin-bottom: 28px;
            font-size: 11.5px;
            color: #475569;
        }
        .rules-box ol {
            padding-left: 18px;
            margin-top: 6px;
        }
        .rules-box li {
            margin-bottom: 3px;
        }
        .signature-section {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-top: 36px;
            page-break-inside: avoid;
        }
        .barcode-box {
            border: 1px dashed #cbd5e1;
            padding: 12px 16px;
            border-radius: 8px;
            text-align: center;
            background: #f8fafc;
            width: 220px;
        }
        .barcode {
            font-family: 'Space Mono', monospace;
            letter-spacing: 0.25em;
            font-size: 18px;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 4px;
        }
        .barcode-caption {
            font-size: 10px;
            color: #64748b;
        }
        .sig-box {
            text-align: center;
            width: 230px;
        }
        .sig-date {
            font-size: 12px;
            color: #475569;
            margin-bottom: 2px;
        }
        .sig-title {
            font-size: 12px;
            font-weight: 600;
            color: #334155;
        }
        .sig-space {
            height: 65px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .digital-stamp {
            border: 2px solid #4f46e5;
            color: #4f46e5;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            font-size: 8px;
            font-weight: 800;
            text-transform: uppercase;
            transform: rotate(-10deg);
            opacity: 0.85;
        }
        .sig-name {
            font-weight: 800;
            text-decoration: underline;
            color: #0f172a;
            font-size: 12.5px;
        }
        .sig-nip {
            font-size: 11px;
            color: #64748b;
        }

        @media print {
            body {
                background: #fff;
                padding: 0;
            }
            .container {
                border: none;
                box-shadow: none;
                padding: 0;
                max-width: 100%;
            }
            .action-bar {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="action-bar">
        <button onclick="window.print()" class="btn-print">
            <svg style="width:16px;height:16px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
            </svg>
            Cetak Surat Izin / Bukti Peminjaman (PDF)
        </button>
        <a href="{{ auth()->user()->isAdmin() ? route('admin.bookings.index') : route('peminjam.bookings.index') }}" class="btn-back">
            &larr; Kembali
        </a>
    </div>

    <div class="container">

        <div class="watermark-badge">
            ✓ Disetujui
        </div>


        <div class="kop-surat">
            <div class="kop-logo">🏛️</div>
            <div class="kop-text">
                <h2>Kementerian Pendidikan Tinggi, Sains, dan Teknologi</h2>
                <h1>UNIVERSITAS SIRUKA KAMPUS TERPADU</h1>
                <p>Biro Sarana dan Prasarana Akademik &bull; Gedung Rektorat Kampus Terpadu Lt. 2 &bull; Hotline: (021) 7890-1234 &bull; Email: sarpras@siruka.ac.id</p>
            </div>
        </div>


        <div class="surat-header">
            <h3 class="surat-title">Surat Bukti Persetujuan Peminjaman Ruangan</h3>
            <p class="surat-nomor">Nomor Dokumen: SIRUKA/{{ date('Y') }}/BK-{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}</p>
        </div>

        <p class="intro-text">
            Berdasarkan verifikasi sistem informasi peminjaman ruangan kampus (SIRUKA), bersama ini Biro Sarana dan Prasarana memberikan izin penggunaan fasilitas ruangan kepada mahasiswa di bawah ini:
        </p>


        <div class="section-title">I. Identitas Mahasiswa Pemohon</div>
        <table class="info-table">
            <tr>
                <td class="label">Nama Lengkap</td>
                <td class="colon">:</td>
                <td class="value">{{ $booking->user->name }}</td>
            </tr>
            <tr>
                <td class="label">Nomor Induk Mahasiswa (NIM)</td>
                <td class="colon">:</td>
                <td class="value">{{ $booking->user->nim_nip ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Email Kampus</td>
                <td class="colon">:</td>
                <td class="value">{{ $booking->user->email }}</td>
            </tr>
            <tr>
                <td class="label">Nomor WhatsApp / HP</td>
                <td class="colon">:</td>
                <td class="value">{{ $booking->user->no_hp ?? '-' }}</td>
            </tr>
        </table>


        <div class="section-title">II. Rincian Ruangan & Jadwal Peminjaman</div>
        <table class="info-table">
            <tr>
                <td class="label">Ruangan yang Dipinjam</td>
                <td class="colon">:</td>
                <td class="value"><strong>{{ $booking->room->nama }}</strong> (Kode: {{ $booking->room->kode }})</td>
            </tr>
            <tr>
                <td class="label">Lokasi / Gedung</td>
                <td class="colon">:</td>
                <td class="value">{{ $booking->room->gedung }} &bull; Lantai {{ $booking->room->lantai }}</td>
            </tr>
            <tr>
                <td class="label">Hari / Tanggal Penggunaan</td>
                <td class="colon">:</td>
                <td class="value"><strong style="color: #4f46e5;">{{ \Carbon\Carbon::parse($booking->tanggal)->isoFormat('dddd, D MMMM Y') }}</strong></td>
            </tr>
            <tr>
                <td class="label">Waktu Peminjaman</td>
                <td class="colon">:</td>
                <td class="value"><strong>{{ substr($booking->jam_mulai, 0, 5) }} &mdash; {{ substr($booking->jam_selesai, 0, 5) }} WIB</strong></td>
            </tr>
            <tr>
                <td class="label">Estimasi Jumlah Peserta</td>
                <td class="colon">:</td>
                <td class="value">{{ $booking->jumlah_peserta }} Orang (Kapasitas Maksimal Ruangan: {{ $booking->room->kapasitas }} Orang)</td>
            </tr>
            <tr>
                <td class="label">Keperluan / Agenda Acara</td>
                <td class="colon">:</td>
                <td class="value">{{ $booking->keperluan }}</td>
            </tr>
            <tr>
                <td class="label">Fasilitas Ruangan</td>
                <td class="colon">:</td>
                <td class="value">
                    @forelse($booking->room->facilities as $f)
                        <span class="badge-chip">✓ {{ $f->nama_fasilitas }}</span>
                    @empty
                        <span style="color: #94a3b8;">Fasilitas standar ruangan kelas</span>
                    @endforelse
                </td>
            </tr>
        </table>


        <div class="rules-box">
            <strong>TATA TERTIB & KETENTUAN PENGGUNAAN RUANGAN:</strong>
            <ol>
                <li>Surat ini wajib ditunjukkan kepada petugas keamanan (Satpam) atau laboran / pengelola gedung sebelum memasuki ruangan.</li>
                <li>Peminjam wajib menjaga kebersihan, ketertiban, dan keutuhan seluruh fasilitas serta peralatan inventaris di dalam ruangan.</li>
                <li>Dilarang merokok, makan/minum di ruangan komputer/laboratorium, dan dilarang mengubah tata letak kabel instalasi listrik/jaringan tanpa izin.</li>
                <li>Setelah kegiatan selesai, pastikan proyektor, komputer, pendingin ruangan (AC), dan lampu telah dimatikan, serta pintu terkunci rapat.</li>
                <li>Segala bentuk kerusakan yang timbul akibat kelalaian peminjam menjadi tanggung jawab pihak pemohon.</li>
            </ol>
        </div>


        <div class="signature-section">
            <div class="barcode-box">
                <div class="barcode">||| | |||| || | ||</div>
                <div class="barcode-caption">
                    ID VALIDASI DIGITAL:<br>
                    <strong>#{{ strtoupper(substr(md5($booking->id . $booking->created_at), 0, 10)) }}</strong><br>
                    Tervalidasi Otomatis SIRUKA
                </div>
            </div>

            <div class="sig-box">
                <p class="sig-date">Kota Kampus, {{ \Carbon\Carbon::parse($booking->updated_at ?? now())->isoFormat('D MMMM Y') }}</p>
                <p class="sig-title">Administrator Bagian Sarana & Prasarana</p>
                <div class="sig-space">
                    <div class="digital-stamp">
                        <span>SIRUKA</span>
                        <span>TERVERIFIKASI</span>
                        <span>RESMI</span>
                    </div>
                </div>
                <p class="sig-name">Biro Sarana dan Prasarana</p>
                <p class="sig-nip">Universitas SIRUKA Kampus Terpadu</p>
            </div>
        </div>
    </div>
</body>
</html>
