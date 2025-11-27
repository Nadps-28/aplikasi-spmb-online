<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Kelulusan</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; font-weight: bold; }
        .header { text-align: center; margin-bottom: 30px; }
        .lulus { color: #28a745; }
        .tidak-lulus { color: #dc3545; }
    </style>
</head>
<body>
    <div class="header">
        <h2>LAPORAN KELULUSAN SISWA</h2>
        <h3>SMK NEGERI 1 BANDUNG</h3>
        <p>Periode: {{ now()->format('Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>No. Pendaftaran</th>
                <th>Nama Lengkap</th>
                <th>Jurusan</th>
                <th>Email</th>
                <th>Status</th>
                <th>Catatan</th>
                <th>Tanggal Keputusan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pendaftarans as $index => $pendaftaran)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $pendaftaran->nomor_pendaftaran }}</td>
                <td>{{ $pendaftaran->nama_lengkap }}</td>
                <td>{{ $pendaftaran->jurusan->nama }}</td>
                <td>{{ $pendaftaran->user->email }}</td>
                <td class="{{ $pendaftaran->status == 'lulus' ? 'lulus' : 'tidak-lulus' }}">
                    {{ $pendaftaran->status == 'lulus' ? 'LULUS' : 'TIDAK LULUS' }}
                </td>
                <td>{{ $pendaftaran->catatan_kelulusan ?? '-' }}</td>
                <td>{{ $pendaftaran->updated_at->format('d/m/Y H:i') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top: 30px;">
        <p><strong>Ringkasan:</strong></p>
        <p>Total Lulus: {{ $pendaftarans->where('status', 'lulus')->count() }} siswa</p>
        <p>Total Tidak Lulus: {{ $pendaftarans->where('status', 'tidak_lulus')->count() }} siswa</p>
        <p>Total Keseluruhan: {{ $pendaftarans->count() }} siswa</p>
    </div>

    <div style="margin-top: 50px; text-align: right;">
        <p>Bandung, {{ now()->format('d F Y') }}</p>
        <br><br><br>
        <p>Kepala Sekolah</p>
    </div>
</body>
</html>