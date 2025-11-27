<!DOCTYPE html>
<html>
<head>
    <title>Laporan Analitik SPMB - {{ $tanggal_export }}</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #333; padding-bottom: 20px; }
        .kpi-section { display: flex; justify-content: space-between; margin-bottom: 30px; flex-wrap: wrap; }
        .kpi-card { flex: 1; margin: 0 5px 10px 5px; padding: 15px; border: 1px solid #ddd; text-align: center; min-width: 200px; background: #f8f9fa; }
        .kpi-number { font-size: 24px; font-weight: bold; color: #333; }
        .kpi-label { font-size: 12px; color: #666; margin-top: 5px; }
        .section { margin-bottom: 30px; }
        .section h3 { border-bottom: 1px solid #ddd; padding-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f5f5f5; font-weight: bold; }
        .status-lulus { color: #28a745; font-weight: bold; }
        .status-pending { color: #ffc107; font-weight: bold; }
        .footer { margin-top: 40px; text-align: right; font-size: 12px; color: #666; }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN ANALITIK SISTEM PENERIMAAN SISWA BARU</h1>
        <p>Tanggal Export: {{ $tanggal_export }}</p>
        <p>Kepala Sekolah Dashboard</p>
    </div>

    <div class="kpi-section">
        <div class="kpi-card">
            <div class="kpi-number">{{ $kpi['total_pendaftar'] }}</div>
            <div class="kpi-label">Total Pendaftar</div>
        </div>
        <div class="kpi-card">
            <div class="kpi-number">{{ $kpi['lulus'] }}</div>
            <div class="kpi-label">Siswa Lulus</div>
        </div>
        <div class="kpi-card">
            <div class="kpi-number">{{ $kpi['rasio_verifikasi'] }}%</div>
            <div class="kpi-label">Rasio Terverifikasi</div>
        </div>
        <div class="kpi-card">
            <div class="kpi-number">Rp {{ number_format($kpi['pemasukan'], 0, ',', '.') }}</div>
            <div class="kpi-label">Total Pemasukan</div>
        </div>
    </div>

    <div class="section">
        <h3>Distribusi Pendaftar per Jurusan</h3>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Jurusan</th>
                    <th>Jumlah Pendaftar</th>
                    <th>Persentase</th>
                </tr>
            </thead>
            <tbody>
                @foreach($jurusans as $index => $jurusan)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $jurusan->nama }}</td>
                    <td>{{ $jurusan->pendaftarans_count }}</td>
                    <td>{{ $kpi['total_pendaftar'] > 0 ? round(($jurusan->pendaftarans_count / $kpi['total_pendaftar']) * 100, 1) : 0 }}%</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="section">
        <h3>Daftar Siswa Lulus</h3>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nomor Pendaftaran</th>
                    <th>Nama Lengkap</th>
                    <th>Jurusan</th>
                    <th>Status</th>
                    <th>Tanggal Lulus</th>
                </tr>
            </thead>
            <tbody>
                @php $no = 1; @endphp
                @foreach($pendaftarans->where('status', 'lulus') as $pendaftaran)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $pendaftaran->nomor_pendaftaran }}</td>
                    <td>{{ $pendaftaran->nama_lengkap }}</td>
                    <td>{{ $pendaftaran->jurusan->nama }}</td>
                    <td class="status-lulus">LULUS</td>
                    <td>{{ $pendaftaran->graduated_at ? (is_string($pendaftaran->graduated_at) ? \Carbon\Carbon::parse($pendaftaran->graduated_at)->format('d/m/Y H:i') : $pendaftaran->graduated_at->format('d/m/Y H:i')) : '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="section">
        <h3>Komposisi Asal Sekolah</h3>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Sekolah</th>
                    <th>Jumlah Pendaftar</th>
                    <th>Persentase</th>
                </tr>
            </thead>
            <tbody>
                @foreach($asal_sekolah as $index => $sekolah)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $sekolah->asal_sekolah }}</td>
                    <td>{{ $sekolah->total }}</td>
                    <td>{{ $kpi['total_pendaftar'] > 0 ? round(($sekolah->total / $kpi['total_pendaftar']) * 100, 1) : 0 }}%</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="section">
        <h3>Komposisi Asal Wilayah</h3>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kecamatan</th>
                    <th>Jumlah Pendaftar</th>
                    <th>Persentase</th>
                </tr>
            </thead>
            <tbody>
                @foreach($asal_wilayah as $index => $wilayah)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $wilayah->kecamatan }}</td>
                    <td>{{ $wilayah->total }}</td>
                    <td>{{ $kpi['total_pendaftar'] > 0 ? round(($wilayah->total / $kpi['total_pendaftar']) * 100, 1) : 0 }}%</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="section">
        <h3>Ringkasan Status Pendaftaran</h3>
        <table>
            <thead>
                <tr>
                    <th>Status</th>
                    <th>Jumlah</th>
                    <th>Persentase</th>
                </tr>
            </thead>
            <tbody>
                @php
                $statusCounts = [
                    'Draft' => $pendaftarans->where('status', 'draft')->count(),
                    'Submitted' => $pendaftarans->where('status', 'submitted')->count(),
                    'Valid' => $pendaftarans->where('status', 'valid')->count(),
                    'Lulus' => $pendaftarans->where('status', 'lulus')->count(),
                    'Tidak Valid' => $pendaftarans->where('status', 'tidak_valid')->count(),
                    'Belum Bayar' => $pendaftarans->where('status', 'belum_bayar')->count(),
                ];
                @endphp
                @foreach($statusCounts as $status => $count)
                <tr>
                    <td>{{ $status }}</td>
                    <td>{{ $count }}</td>
                    <td>{{ $kpi['total_pendaftar'] > 0 ? round(($count / $kpi['total_pendaftar']) * 100, 1) : 0 }}%</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="footer">
        <p>Laporan ini digenerate secara otomatis oleh Sistem SPMB</p>
        <p>© {{ date('Y') }} Sistem Penerimaan Siswa Baru</p>
    </div>
</body>
</html>