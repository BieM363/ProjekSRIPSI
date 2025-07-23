<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ParameterIndikator;
use App\Models\RealisasiKinerja;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class RKinerjaController extends Controller
{
    public function index(Request $request)
    {
        // Ambil parameter filter dari request
        $periode = $request->input('periode', 'Q3 - 2024');
        $unitKerja = $request->input('unit_kerja', 'semua');
        $status = $request->input('status', 'semua');
        
        // Query dasar
        $query = RealisasiKinerja::with(['pegawai', 'indikator'])
            ->join('users', 'realisasi_kinerja.pegawai_id', '=', 'users.id')
            ->join('parameter_indikators', 'realisasi_kinerja.indikator_id', '=', 'parameter_indikators.id')
            ->select('realisasi_kinerja.*', 'users.name as nama_pegawai', 'users.unit_kerja', 'parameter_indikators.nama as nama_indikator');
        
        // Terapkan filter
        if ($periode !== 'semua') {
            $query->where('realisasi_kinerja.periode', $periode);
        }
        
        if ($unitKerja !== 'semua') {
            $query->where('users.unit_kerja', $unitKerja);
        }
        
        // PERBAIKAN #1: Handle target=0 dalam filter status
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
        
        // Paginasi hasil
        $realisasi = $query->paginate(10);
        
        // Hitung statistik ringkasan
        // PERBAIKAN #2: Optimasi query dan handle target=0
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
        
        // Data untuk chart
        $chartData = $this->getChartData($periode);
        
        // Generate pilihan periode (untuk dropdown filter)
        $periodes = $this->generatePeriodOptions();
        // Daftar unit kerja (untuk dropdown filter)
        $unitKerjas = User::distinct()->pluck('unit_kerja')->filter();
        
        return view('home.menu.realisasi-kinerja', [
        'realisasi' => $realisasi,
        'summary' => $summary,
        'chartData' => $chartData,
        'periodes' => $periodes,
        'unitKerjas' => $unitKerjas,
        'periode' => $periode,
        'unitKerja' => $unitKerja,
        'status' => $status
        ]);
    }

    private function getChartData($periode)
    {
        // PERBAIKAN #3: Handle target=0 dalam chart data
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

        // Data bar chart - Rata-rata per Unit
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

    /**
     * Menampilkan form untuk membuat realisasi kinerja baru
     */
    public function create()
{
    $pegawai = User::all();
    $indikator = ParameterIndikator::all();
    $periodes = $this->generatePeriodOptions();
    
    return view('home.menu.realisasi-kinerja-create', compact(
        'pegawai',
        'indikator',
        'periodes'
    ));
}

    /**
     * Menyimpan realisasi kinerja baru ke database
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pegawai_id' => 'required|exists:users,id',
            'indikator_id' => 'required|exists:parameter_indikators,id',
            'periode' => 'required|string',
            'target' => 'required|numeric|min:0',
            'realisasi' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        RealisasiKinerja::create($request->all());

        return redirect()->route('realisasi_kinerja')
            ->with('success', 'Realisasi kinerja berhasil ditambahkan!');
    }

    /**
     * Menampilkan form untuk mengedit realisasi kinerja
     */
    public function edit($id)
{
    $realisasi = RealisasiKinerja::findOrFail($id);
    $pegawai = User::all();
    $indikator = ParameterIndikator::all();
    $periodes = $this->generatePeriodOptions();
    
    return view('home.menu.realisasi-kinerja-edit', compact(
        'realisasi',
        'pegawai',
        'indikator',
        'periodes'
    ));
}

    /**
     * Memperbarui realisasi kinerja di database
     */
    public function update(Request $request, $id)
    {
        $realisasi = RealisasiKinerja::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'pegawai_id' => 'required|exists:users,id',
            'indikator_id' => 'required|exists:parameter_indikators,id',
            'periode' => 'required|string',
            'target' => 'required|numeric|min:0',
            'realisasi' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $realisasi->update($request->all());

        return redirect()->route('realisasi_kinerja')
            ->with('success', 'Realisasi kinerja berhasil diperbarui!');
    }

    /**
     * Menghapus realisasi kinerja dari database
     */
    public function destroy($id)
    {
        $realisasi = RealisasiKinerja::findOrFail($id);
        $realisasi->delete();

        return redirect()->route('realisasi_kinerja')
            ->with('success', 'Realisasi kinerja berhasil dihapus!');
    }

    /**
     * Menghasilkan opsi periode untuk dropdown
     */
    private function generatePeriodOptions()
    {
        $periodes = [];
        $currentYear = Carbon::now()->year;
        $currentQuarter = ceil(Carbon::now()->month / 3);
        
        // Buat opsi untuk 2 tahun terakhir dan tahun depan
        for ($year = $currentYear - 1; $year <= $currentYear + 1; $year++) {
            for ($quarter = 1; $quarter <= 4; $quarter++) {
                // Hanya tambahkan periode masa lalu dan periode berjalan
                if ($year < $currentYear || 
                    ($year == $currentYear && $quarter <= $currentQuarter)) {
                    $periodes[] = "Q$quarter - $year";
                }
            }
        }
        
        return $periodes;
    }
}