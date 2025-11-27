<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ExportKeuanganController extends Controller
{
    public function exportPembayaran(Request $request)
    {
        $format = $request->get('format', 'excel'); // default excel
        
        $pembayarans = Pembayaran::with(['pendaftaran.user', 'pendaftaran.jurusan'])
            ->where('status', 'terbayar')
            ->get();
        
        switch ($format) {
            case 'pdf':
                return $this->exportPDF($pembayarans);
            case 'csv':
                return $this->exportCSV($pembayarans);
            default:
                return $this->exportExcel($pembayarans);
        }
    }
    
    private function exportExcel($pembayarans)
    {
        $filename = 'laporan_keuangan_' . date('Y-m-d') . '.xls';
        
        $headers = [
            'Content-Type' => 'application/vnd.ms-excel',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];
        
        $callback = function() use ($pembayarans) {
            // Create HTML table format that Excel can read
            echo "<html><head><meta charset='UTF-8'></head><body>";
            echo "<table border='1'>";
            echo "<tr>";
            echo "<th>No Pendaftaran</th>";
            echo "<th>Nama</th>";
            echo "<th>Jurusan</th>";
            echo "<th>Nominal</th>";
            echo "<th>Tanggal Bayar</th>";
            echo "<th>Status</th>";
            echo "</tr>";
            
            foreach ($pembayarans as $pembayaran) {
                echo "<tr>";
                echo "<td>" . ($pembayaran->pendaftaran->nomor_pendaftaran ?? '-') . "</td>";
                echo "<td>" . ($pembayaran->pendaftaran->nama_lengkap ?? $pembayaran->pendaftaran->user->name ?? '-') . "</td>";
                echo "<td>" . ($pembayaran->pendaftaran->jurusan->nama ?? '-') . "</td>";
                echo "<td>" . $pembayaran->nominal . "</td>";
                echo "<td>" . ($pembayaran->tanggal_bayar ? $pembayaran->tanggal_bayar->format('d/m/Y H:i') : $pembayaran->updated_at->format('d/m/Y H:i')) . "</td>";
                echo "<td>" . ucfirst($pembayaran->status) . "</td>";
                echo "</tr>";
            }
            
            echo "</table>";
            echo "</body></html>";
        };
        
        return response()->stream($callback, 200, $headers);
    }
    
    private function exportCSV($pembayarans)
    {
        $filename = 'laporan_keuangan_' . date('Y-m-d') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];
        
        $callback = function() use ($pembayarans) {
            $file = fopen('php://output', 'w');
            
            fputcsv($file, [
                'No Pendaftaran', 'Nama', 'Jurusan', 'Nominal', 
                'Tanggal Bayar', 'Status'
            ]);
            
            foreach ($pembayarans as $pembayaran) {
                fputcsv($file, [
                    $pembayaran->pendaftaran->nomor_pendaftaran ?? '-',
                    $pembayaran->pendaftaran->nama_lengkap ?? $pembayaran->pendaftaran->user->name ?? '-',
                    $pembayaran->pendaftaran->jurusan->nama ?? '-',
                    $pembayaran->nominal,
                    $pembayaran->tanggal_bayar ? $pembayaran->tanggal_bayar->format('d/m/Y H:i') : $pembayaran->updated_at->format('d/m/Y H:i'),
                    ucfirst($pembayaran->status),
                ]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
    
    public function exportPDF($pembayarans = null)
    {
        if ($pembayarans === null) {
            $pembayarans = Pembayaran::with(['pendaftaran.user', 'pendaftaran.jurusan'])
                ->where('status', 'terbayar')
                ->get();
        }
            
        $total = $pembayarans->sum('nominal');
        $data = [
            'pembayarans' => $pembayarans,
            'total' => $total,
            'tanggal' => date('d/m/Y')
        ];
        
        try {
            $pdf = Pdf::loadView('exports.keuangan-pdf', $data);
            return $pdf->download('laporan_keuangan_' . date('Y-m-d') . '.pdf');
        } catch (\Exception $e) {
            // Fallback to HTML if PDF library not available
            return $this->exportHTML($pembayarans, $total);
        }
    }
    
    private function exportHTML($pembayarans, $total)
    {
        $html = '<!DOCTYPE html><html><head><meta charset="UTF-8"><title>Laporan Keuangan</title>';
        $html .= '<style>body{font-family:Arial,sans-serif;margin:20px;}table{width:100%;border-collapse:collapse;}th,td{border:1px solid #ddd;padding:8px;text-align:left;}th{background-color:#f2f2f2;}</style>';
        $html .= '</head><body>';
        $html .= '<h2>Laporan Keuangan SPMB</h2>';
        $html .= '<p>Tanggal: ' . date('d/m/Y') . '</p>';
        $html .= '<p>Total Pemasukan: Rp ' . number_format($total, 0, ',', '.') . '</p><br>';
        $html .= '<table>';
        $html .= '<tr><th>No</th><th>No. Pendaftaran</th><th>Nama</th><th>Jurusan</th><th>Nominal</th><th>Tanggal</th></tr>';
        
        $no = 1;
        foreach ($pembayarans as $pembayaran) {
            $html .= '<tr>';
            $html .= '<td>' . $no++ . '</td>';
            $html .= '<td>' . ($pembayaran->pendaftaran->nomor_pendaftaran ?? '-') . '</td>';
            $html .= '<td>' . ($pembayaran->pendaftaran->nama_lengkap ?? $pembayaran->pendaftaran->user->name ?? '-') . '</td>';
            $html .= '<td>' . ($pembayaran->pendaftaran->jurusan->nama ?? '-') . '</td>';
            $html .= '<td>Rp ' . number_format($pembayaran->nominal, 0, ',', '.') . '</td>';
            $html .= '<td>' . ($pembayaran->tanggal_bayar ? $pembayaran->tanggal_bayar->format('d/m/Y H:i') : $pembayaran->updated_at->format('d/m/Y H:i')) . '</td>';
            $html .= '</tr>';
        }
        
        $html .= '</table></body></html>';
        
        return response($html)
            ->header('Content-Type', 'text/html')
            ->header('Content-Disposition', 'attachment; filename="laporan_keuangan_' . date('Y-m-d') . '.html"');
    }
}