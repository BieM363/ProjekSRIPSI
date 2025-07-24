<?php

namespace App\Http\Controllers;

use App\Models\RealisasiKinerja;
use App\Models\User;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use Illuminate\Support\Facades\DB; // TAMBAHKAN INI


class ExportController extends Controller
{
    public function exportRealisasi(Request $request)
    {
        // Ambil parameter filter yang sama dengan halaman utama
        $periode = $request->input('periode', 'semua');
        $unitKerja = $request->input('unit_kerja', 'semua');
        $status = $request->input('status', 'semua');
        
        // Buat spreadsheet baru
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        // Header tabel
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Pegawai');
        $sheet->setCellValue('C1', 'Unit Kerja');
        $sheet->setCellValue('D1', 'Periode');
        $sheet->setCellValue('E1', 'Indikator Kinerja');
        $sheet->setCellValue('F1', 'Target');
        $sheet->setCellValue('G1', 'Realisasi');
        $sheet->setCellValue('H1', 'Persentase');
        $sheet->setCellValue('I1', 'Status');
        
        // Query data (sama seperti di RKinerjaController)
        $query = RealisasiKinerja::with(['pegawai', 'indikator'])
            ->join('users', 'realisasi_kinerja.pegawai_id', '=', 'users.id')
            ->join('parameter_indikators', 'realisasi_kinerja.indikator_id', '=', 'parameter_indikators.id')
            ->select(
                'realisasi_kinerja.*',
                'users.name as nama_pegawai',
                'users.unit_kerja',
                'parameter_indikators.nama as nama_indikator'
            );
        
        if ($periode !== 'semua') {
            $query->where('realisasi_kinerja.periode', $periode);
        }
        
        if ($unitKerja !== 'semua') {
            $query->where('users.unit_kerja', $unitKerja);
        }
        
        if ($status !== 'semua') {
            switch ($status) {
                case 'tercapai':
                    $query->where(function($q) {
                        $q->whereRaw('realisasi_kinerja.target > 0 AND (realisasi_kinerja.realisasi / realisasi_kinerja.target * 100) >= 90')
                          ->orWhereRaw('realisasi_kinerja.target = 0 AND realisasi_kinerja.realisasi > 0');
                    });
                    break;
                case 'perlu_perhatian':
                    $query->whereRaw('realisasi_kinerja.target > 0 AND (realisasi_kinerja.realisasi / realisasi_kinerja.target * 100) BETWEEN 70 AND 89');
                    break;
                case 'tidak_tercapai':
                    $query->where(function($q) {
                        $q->whereRaw('realisasi_kinerja.target > 0 AND (realisasi_kinerja.realisasi / realisasi_kinerja.target * 100) < 70')
                          ->orWhereRaw('realisasi_kinerja.target = 0 AND realisasi_kinerja.realisasi = 0');
                    });
                    break;
            }
        }
        
        // Ambil data
        $data = $query->get();
        
        // Isi data ke spreadsheet
        $row = 2;
        foreach ($data as $index => $item) {
            $persentase = ($item->target > 0) 
                ? ($item->realisasi / $item->target * 100) 
                : ($item->realisasi > 0 ? 100 : 0);
            
            $persentase = number_format($persentase, 2);
            
            if($item->target > 0) {
                if($persentase >= 90) {
                    $statusText = 'Tercapai';
                } elseif($persentase >= 70) {
                    $statusText = 'Perlu Perhatian';
                } else {
                    $statusText = 'Tidak Tercapai';
                }
            } else {
                if($item->realisasi > 0) {
                    $statusText = 'Tercapai';
                } else {
                    $statusText = 'Tidak Tercapai';
                }
            }

            $sheet->setCellValue('A' . $row, $index + 1);
            $sheet->setCellValue('B' . $row, $item->nama_pegawai);
            $sheet->setCellValue('C' . $row, $item->unit_kerja);
            $sheet->setCellValue('D' . $row, $item->periode);
            $sheet->setCellValue('E' . $row, $item->nama_indikator);
            $sheet->setCellValue('F' . $row, $item->target);
            $sheet->setCellValue('G' . $row, $item->realisasi);
            $sheet->setCellValue('H' . $row, $persentase . '%');
            $sheet->setCellValue('I' . $row, $statusText);
            $row++;
        }
        
        // Styling header
        $headerStyle = [
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF']
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '6D28D9'] // Warna ungu
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            ]
        ];
        $sheet->getStyle('A1:I1')->applyFromArray($headerStyle);
        
        // Auto size column
        foreach (range('A', 'I') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }
        
        // Tambahkan data ringkasan dan chart
        $this->addSummaryAndChartData($sheet, $periode, $row);
        
        // Download file
        $writer = new Xlsx($spreadsheet);
        $fileName = 'realisasi-kinerja-' . date('YmdHis') . '.xlsx';
        
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $fileName . '"');
        header('Cache-Control: max-age=0');
        
        $writer->save('php://output');
        exit;
    }
    
    private function addSummaryAndChartData($sheet, $periode, $startRow)
    {
        // Hitung statistik ringkasan (sama seperti di RKinerjaController)
        $summary = [
            'total_pegawai' => User::count(),
            'rata_capaian' => RealisasiKinerja::selectRaw('AVG(CASE WHEN target > 0 THEN (realisasi / target) * 100 ELSE 0 END) as rata_rata')
                ->value('rata_rata') ?? 0,
            'perlu_evaluasi' => RealisasiKinerja::where(function($q) {
                    $q->whereRaw('target > 0 AND (realisasi / target * 100) < 70')
                      ->orWhereRaw('target = 0 AND realisasi = 0');
                })->count(),
            'tertinggi' => RealisasiKinerja::selectRaw('MAX(CASE WHEN target > 0 THEN (realisasi / target) * 100 ELSE 0 END) as max_capaian')
                ->value('max_capaian') ?? 0,
        ];
        
        // Data untuk chart (sama seperti di RKinerjaController)
        $chartData = $this->getChartData($periode);
        
        // Tambahkan row kosong
        $startRow += 2;
        
        // Tambahkan summary
        $sheet->setCellValue("A{$startRow}", "Ringkasan Statistik");
        $sheet->mergeCells("A{$startRow}:B{$startRow}");
        $sheet->getStyle("A{$startRow}")->getFont()->setBold(true);
        
        $sheet->setCellValue("A" . ($startRow + 1), "Total Pegawai");
        $sheet->setCellValue("B" . ($startRow + 1), $summary['total_pegawai']);
        
        $sheet->setCellValue("A" . ($startRow + 2), "Rata-rata Capaian");
        $sheet->setCellValue("B" . ($startRow + 2), number_format($summary['rata_capaian'], 2) . '%');
        
        $sheet->setCellValue("A" . ($startRow + 3), "Perlu Evaluasi");
        $sheet->setCellValue("B" . ($startRow + 3), $summary['perlu_evaluasi']);
        
        $sheet->setCellValue("A" . ($startRow + 4), "Pencapaian Tertinggi");
        $sheet->setCellValue("B" . ($startRow + 4), number_format($summary['tertinggi'], 2) . '%');
        
        // Tambahkan data distribusi capaian
        $chartRow = $startRow + 6;
        $sheet->setCellValue("A{$chartRow}", "Distribusi Capaian Kinerja");
        $sheet->mergeCells("A{$chartRow}:B{$chartRow}");
        $sheet->getStyle("A{$chartRow}")->getFont()->setBold(true);
        
        $sheet->setCellValue("A" . ($chartRow + 1), "Kategori");
        $sheet->setCellValue("B" . ($chartRow + 1), "Jumlah");
        
        $sheet->setCellValue("A" . ($chartRow + 2), "Tercapai (≥90%)");
        $sheet->setCellValue("B" . ($chartRow + 2), $chartData['capaian']['tercapai'] ?? 0);
        
        $sheet->setCellValue("A" . ($chartRow + 3), "Perlu Perhatian (70-89%)");
        $sheet->setCellValue("B" . ($chartRow + 3), $chartData['capaian']['perlu_perhatian'] ?? 0);
        
        $sheet->setCellValue("A" . ($chartRow + 4), "Tidak Tercapai (<70%)");
        $sheet->setCellValue("B" . ($chartRow + 4), $chartData['capaian']['tidak_tercapai'] ?? 0);
        
        // Tambahkan data per unit
        $unitRow = $chartRow + 6;
        $sheet->setCellValue("A{$unitRow}", "Rata-rata Capaian per Unit");
        $sheet->mergeCells("A{$unitRow}:B{$unitRow}");
        $sheet->getStyle("A{$unitRow}")->getFont()->setBold(true);
        
        $sheet->setCellValue("A" . ($unitRow + 1), "Unit Kerja");
        $sheet->setCellValue("B" . ($unitRow + 1), "Rata-rata Capaian");
        
        $rowNum = $unitRow + 2;
        foreach($chartData['unit'] as $unit) {
            $sheet->setCellValue("A{$rowNum}", $unit->unit_kerja);
            $sheet->setCellValue("B{$rowNum}", number_format($unit->rata_rata, 2) . '%');
            $rowNum++;
        }
    }
    
    private function getChartData($periode)
    {
        // Replikasi fungsi dari RKinerjaController
        $capaianData = DB::table('realisasi_kinerja')
            ->selectRaw("
                SUM(CASE 
                    WHEN target > 0 AND (realisasi / target * 100) >= 90 THEN 1 
                    WHEN target = 0 AND realisasi > 0 THEN 1 
                    ELSE 0 
                END) as tercapai,
                SUM(CASE 
                    WHEN target > 0 AND (realisasi / target * 100) BETWEEN 70 AND 89 THEN 1 
                    ELSE 0 
                END) as perlu_perhatian,
                SUM(CASE 
                    WHEN target > 0 AND (realisasi / target * 100) < 70 THEN 1 
                    WHEN target = 0 AND realisasi = 0 THEN 1 
                    ELSE 0 
                END) as tidak_tercapai
            ")
            ->when($periode !== 'semua', function ($query) use ($periode) {
                return $query->where('periode', $periode);
            })
            ->first();

        $unitData = DB::table('realisasi_kinerja')
            ->join('users', 'realisasi_kinerja.pegawai_id', '=', 'users.id')
            ->selectRaw("
                users.unit_kerja,
                AVG(CASE WHEN realisasi_kinerja.target > 0 
                    THEN (realisasi_kinerja.realisasi / realisasi_kinerja.target) * 100 
                    ELSE 0 
                END) as rata_rata
            ")
            ->when($periode !== 'semua', function ($query) use ($periode) {
                return $query->where('realisasi_kinerja.periode', $periode);
            })
            ->whereNotNull('users.unit_kerja')
            ->groupBy('users.unit_kerja')
            ->get();

        return [
            'capaian' => [
                'tercapai' => $capaianData->tercapai ?? 0,
                'perlu_perhatian' => $capaianData->perlu_perhatian ?? 0,
                'tidak_tercapai' => $capaianData->tidak_tercapai ?? 0,
            ],
            'unit' => $unitData,
        ];
    }
}