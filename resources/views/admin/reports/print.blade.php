<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Peminjaman Ruangan - SIRUKA</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&family=Space+Mono:wght@700&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: #1e293b;
            background-color: #f8fafc;
            padding: 30px 20px;
            font-size: 13px;
            line-height: 1.5;
        }
        .container {
            max-width: 900px;
            margin: 0 auto;
            background: #fff;
            padding: 40px;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }
        .kop-surat {
            display: flex;
            align-items: center;
            border-bottom: 3px double #0f172a;
            padding-bottom: 16px;
            margin-bottom: 24px;
        }
        .kop-logo {
            width: 70px;
            height: 70px;
            background: #4f46e5;
            color: white;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            font-weight: 800;
            margin-right: 20px;
            flex-shrink: 0;
        }
        .kop-text h2 {
            font-size: 14px;
            font-weight: 700;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            color: #475569;
        }
        .kop-text h1 {
            font-size: 18px;
            font-weight: 900;
            color: #0f172a;
            margin: 2px 0;
        }
        .kop-text p {
            font-size: 11px;
            color: #64748b;
        }
        .report-header {
            text-align: center;
            margin-bottom: 24px;
        }
        .report-title {
            font-size: 16px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #0f172a;
        }
        .report-period {
            font-size: 12px;
            color: #4f46e5;
            font-weight: 700;
            margin-top: 4px;
        }
        .summary-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
            margin-bottom: 24px;
        }
        .summary-card {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 12px;
            text-align: center;
        }
        .summary-label {
            font-size: 10px;
            text-transform: uppercase;
            font-weight: 700;
            color: #64748b;
        }
        .summary-val {
            font-size: 20px;
            font-weight: 800;
            color: #0f172a;
            margin-top: 4px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
            font-size: 12px;
        }
        th {
            background: #f1f5f9;
            color: #334155;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 10px;
            letter-spacing: 0.05em;
            border: 1px solid #cbd5e1;
            padding: 8px 10px;
            text-align: left;
        }
        td {
            border: 1px solid #e2e8f0;
            padding: 8px 10px;
            vertical-align: top;
        }
        tr:nth-child(even) td {
            background: #f8fafc;
        }
        .badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
        }
        .badge-disetujui { background: #dcfce7; color: #166534; }
        .badge-menunggu { background: #fef3c7; color: #92400e; }
        .badge-ditolak { background: #ffe4e6; color: #9f1239; }
        .badge-dibatalkan { background: #f1f5f9; color: #475569; }
        .signature-section {
            margin-top: 40px;
            display: flex;
            justify-content: space-between;
            page-break-inside: avoid;
        }
        .sig-box {
            text-align: center;
            width: 250px;
        }
        .sig-space {
            height: 70px;
        }
        .sig-name {
            font-weight: 700;
            text-decoration: underline;
            color: #0f172a;
        }
        .sig-title {
            font-size: 11px;
            color: #64748b;
        }
        .action-bar {
            text-align: center;
            margin-bottom: 20px;
        }
        .btn-print {
            background: #4f46e5;
            color: white;
            border: none;
            padding: 10px 24px;
            border-radius: 8px;
            font-weight: 700;
            font-size: 13px;
            cursor: pointer;
            box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.3);
        }
        .btn-close {
            background: #e2e8f0;
            color: #475569;
            border: none;
            padding: 10px 18px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 13px;
            cursor: pointer;
            margin-left: 8px;
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
        <button onclick="window.print()" class="btn-print">🖨️ Cetak / Simpan PDF</button>
        <button onclick="window.close()" class="btn-close">Tutup Halaman</button>
    </div>

    <div class="container">
        <!-- Kop Surat Resmi -->
        <div class="kop-surat">
            <div class="kop-logo">🏛️</div>
            <div class="kop-text">
                <h2>Kementerian Pendidikan Tinggi, Sains, dan Teknologi</h2>
                <h1>UNIVERSITAS SIRUKA KAMPUS TERPADU</h1>
                <p>Biro Sarana dan Prasarana Akademik &bull; Kampus Terpadu Gedung Rektorat &bull; Telepon: (021) 7890-1234 &bull; Email: sarpras@siruka.ac.id</p>
            </div>
        </div>

        <!-- Judul Laporan -->
        <div class="report-header">
            <div class="report-title">Laporan Rekapitulasi Peminjaman Ruangan</div>
            <div class="report-period">
                Periode: {{ \Carbon\Carbon::parse($startDate)->isoFormat('D MMMM Y') }} s.d. {{ \Carbon\Carbon::parse($endDate)->isoFormat('D MMMM Y') }}
                @if($selectedRoom)
                    &bull; Ruangan: {{ $selectedRoom->nama }}
                @endif
            </div>
        </div>

        <!-- Ringkasan Statistik -->
        <div class="summary-grid">
            <div class="summary-card">
                <div class="summary-label">Total Pengajuan</div>
                <div class="summary-val">{{ $stats['total'] }}</div>
            </div>
            <div class="summary-card">
                <div class="summary-label">Disetujui</div>
                <div class="summary-val" style="color: #16a34a;">{{ $stats['disetujui'] }}</div>
            </div>
            <div class="summary-card">
                <div class="summary-label">Menunggu</div>
                <div class="summary-val" style="color: #d97706;">{{ $stats['menunggu'] }}</div>
            </div>
            <div class="summary-card">
                <div class="summary-label">Ditolak / Dibatalkan</div>
                <div class="summary-val" style="color: #e11d48;">{{ $stats['ditolak'] + $stats['dibatalkan'] }}</div>
            </div>
        </div>

        <!-- Tabel Data Peminjaman -->
        <table>
            <thead>
                <tr>
                    <th style="width: 30px; text-align: center;">No</th>
                    <th>Peminjam (Mahasiswa)</th>
                    <th>Ruangan & Gedung</th>
                    <th style="width: 140px;">Tanggal & Jam</th>
                    <th>Keperluan / Agenda</th>
                    <th style="width: 80px; text-align: center;">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bookings as $index => $b)
                    <tr>
                        <td style="text-align: center; font-weight: 700;">{{ $index + 1 }}</td>
                        <td>
                            <strong>{{ $b->user->name }}</strong><br>
                            <span style="font-size: 11px; color: #64748b;">NIM: {{ $b->user->nim_nip ?? '-' }}</span>
                        </td>
                        <td>
                            <strong>{{ $b->room->nama }}</strong><br>
                            <span style="font-size: 11px; color: #64748b;">{{ $b->room->gedung }} (Lt. {{ $b->room->lantai }})</span>
                        </td>
                        <td>
                            <strong>{{ \Carbon\Carbon::parse($b->tanggal)->isoFormat('D MMM Y') }}</strong><br>
                            <span style="font-size: 11px; color: #4f46e5; font-weight: 600;">{{ substr($b->jam_mulai, 0, 5) }} - {{ substr($b->jam_selesai, 0, 5) }} WIB</span>
                        </td>
                        <td>
                            {{ $b->keperluan }}<br>
                            <span style="font-size: 10px; color: #94a3b8;">Peserta: {{ $b->jumlah_peserta }} org</span>
                        </td>
                        <td style="text-align: center;">
                            <span class="badge badge-{{ $b->status }}">{{ $b->status_label }}</span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 24px; color: #94a3b8;">
                            Tidak ada data peminjaman dalam rentang filter yang dipilih.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Lembar Tanda Tangan -->
        <div class="signature-section">
            <div class="sig-box">
                <p class="sig-title">Mengetahui,</p>
                <p class="sig-title">Kepala Biro Sarana & Prasarana</p>
                <div class="sig-space"></div>
                <p class="sig-name">Ir. H. Syarifuddin, M.Eng.</p>
                <p class="sig-title">NIP. 197508122003121002</p>
            </div>

            <div class="sig-box">
                <p class="sig-title">Kota Kampus, {{ \Carbon\Carbon::now()->isoFormat('D MMMM Y') }}</p>
                <p class="sig-title">Administrator Sistem SIRUKA</p>
                <div class="sig-space"></div>
                <p class="sig-name">{{ auth()->user()->name }}</p>
                <p class="sig-title">ID Admin: {{ auth()->user()->nim_nip ?? 'SIRUKA-ADM-01' }}</p>
            </div>
        </div>
    </div>
</body>
</html>
