<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Keuangan SPMB</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header h1 {
            margin: 0;
            color: #333;
        }
        .info {
            margin-bottom: 20px;
        }
        .info p {
            margin: 5px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .text-right {
            text-align: right;
        }
        .total-row {
            background-color: #f8f9fa;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Laporan Keuangan SPMB</h1>
    </div>
    
    <div class="info">
        <p><strong>Tanggal Cetak:</strong> {{ $tanggal }}</p>
        <p><strong>Total Pembayaran:</strong> {{ $pembayarans->count() }} transaksi</p>
        <p><strong>Total Pemasukan:</strong> Rp {{ number_format($total, 0, ',', '.') }}</p>
    </div>
    
    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="15%">No. Pendaftaran</th>
                <th width="25%">Nama</th>
                <th width="20%">Jurusan</th>
                <th width="15%">Nominal</th>
                <th width="20%">Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pembayarans as $index => $pembayaran)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $pembayaran->pendaftaran->nomor_pendaftaran ?? '-' }}</td>
                <td>{{ $pembayaran->pendaftaran->nama_lengkap ?? $pembayaran->pendaftaran->user->name ?? '-' }}</td>
                <td>{{ $pembayaran->pendaftaran->jurusan->nama ?? '-' }}</td>
                <td class="text-right">Rp {{ number_format($pembayaran->nominal, 0, ',', '.') }}</td>
                <td>{{ $pembayaran->tanggal_bayar ? $pembayaran->tanggal_bayar->format('d/m/Y H:i') : $pembayaran->updated_at->format('d/m/Y H:i') }}</td>
            </tr>
            @endforeach
            <tr class="total-row">
                <td colspan="4" class="text-right"><strong>TOTAL:</strong></td>
                <td class="text-right"><strong>Rp {{ number_format($total, 0, ',', '.') }}</strong></td>
                <td></td>
            </tr>
        </tbody>
    </table>
</body>
</html>