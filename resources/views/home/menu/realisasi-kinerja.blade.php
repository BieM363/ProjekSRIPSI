<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700" rel="stylesheet">

    <title>Ramayana - Realisasi Kinerja</title>

    <!-- Bootstrap core CSS -->
    <link href="/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="/assets/css/realisasi-kinerja.css">
    <link rel="stylesheet" href="/assets/css/parameter-indikator.css">
    <link rel="stylesheet" href="/assets/css/fontawesome.css">
    <link rel="stylesheet" href="/assets/css/templatemo-style.css">
    <link rel="stylesheet" href="/assets/css/owl.css">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom CSS for navbar and buttons -->
    <link rel="stylesheet" href="/css/profil-pegawai.css">
    
    <!-- Custom CSS for Realisasi Kinerja -->
</head>

<body class="is-preload">
    <!-- Navbar Baru -->
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container-fluid">
            <!-- Logo di kiri atas -->
            <a class="navbar-brand" href="{{ route('dashboard') }}">
                <i class="fas fa-home me-2"></i>Ramayana
            </a>
            
            <!-- Toggler untuk mobile -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <!-- Menu di kanan atas -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('dashboard') }}">Homepage</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('parameter-indikator') }}">Parameter Indikator</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('realisasi_kinerja') }}">Realisasi Kinerja</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('profil_pegawai') }}">Profil Pegawai</a>
                    </li>
                    
                    <!-- Dropdown Menu Input -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="menuInputDropdown" 
                           role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Menu Input
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="menuInputDropdown">
                            <li><a class="dropdown-item" href="#">Survei Kepuasan</a></li>
                            <li><a class="dropdown-item" href="#">Sarana & Prasarana</a></li>
                            <li><a class="dropdown-item" href="#">Data Responden</a></li>
                        </ul>
                    </li>
                    
                    <!-- Dropdown Lainnya -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="dropdownTwo" 
                           role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Dropdown Two
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownTwo">
                            <li><a class="dropdown-item" href="#">Sub Menu #1</a></li>
                            <li><a class="dropdown-item" href="#">Sub Menu #2</a></li>
                            <li><a class="dropdown-item" href="#">Sub Menu #3</a></li>
                        </ul>
                    </li>
                    
                    <!-- Logout -->
                    <li class="nav-item">
                        <a class="nav-link" href="#" 
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt me-1"></i>Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
        <div class="container-fluid">
            <!-- Header -->
            <div class="page-heading">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <h1>Realisasi Kinerja</h1>
                            </div>
                        </div>
                    </div>
                </div>
            
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            
            <!-- Summary Cards -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="summary-card bg-primary">
                        <i class="fas fa-users"></i>
                        <h3>{{ $summary['total_pegawai'] }}</h3>
                        <p>Pegawai Aktif</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="summary-card bg-success">
                        <i class="fas fa-check-circle"></i>
                        <h3>{{ number_format($summary['rata_capaian'], 2) }}%</h3>
                        <p>Rata-rata Capaian</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="summary-card bg-warning">
                        <i class="fas fa-exclamation-triangle"></i>
                        <h3>{{ $summary['perlu_evaluasi'] }}</h3>
                        <p>Perlu Evaluasi</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="summary-card bg-info">
                        <i class="fas fa-trophy"></i>
                        <h3>{{ number_format($summary['tertinggi'], 2) }}%</h3>
                        <p>Pencapaian Tertinggi</p>
                    </div>
                </div>
            </div>
            
            <!-- Filter Section -->
            <form action="{{ route('realisasi_kinerja') }}" method="GET">
                <div class="filter-section">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label">Periode</label>
                                <select class="form-select" name="periode">
                                    <option value="semua">Semua Periode</option>
                                    @foreach($periodes as $p)
                                    <option value="{{ $p }}" {{ $periode == $p ? 'selected' : '' }}>{{ $p }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label">Unit Kerja</label>
                                <select class="form-select" name="unit_kerja">
                                    <option value="semua">Semua Unit</option>
                                    @foreach($unitKerjas as $unit)
                                    <option value="{{ $unit }}" {{ $unitKerja == $unit ? 'selected' : '' }}>{{ $unit }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label">Status Capaian</label>
                                <select class="form-select" name="status">
                                    <option value="semua" {{ $status == 'semua' ? 'selected' : '' }}>Semua Status</option>
                                    <option value="tercapai" {{ $status == 'tercapai' ? 'selected' : '' }}>Tercapai</option>
                                    <option value="perlu_perhatian" {{ $status == 'perlu_perhatian' ? 'selected' : '' }}>Perlu Perhatian</option>
                                    <option value="tidak_tercapai" {{ $status == 'tidak_tercapai' ? 'selected' : '' }}>Tidak Tercapai</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-filter me-2"></i>Terapkan Filter
                            </button>
                        </div>
                    </div>
                </div>
            </form>
            
            <!-- Action Bar -->
            <div class="row mb-4">
                <div class="col-md-12 d-flex justify-content-between align-items-center">
                    <div class="d-flex">
                        <a href="{{ route('realisasi_kinerja.create') }}" class="btn btn-primary me-2">
                            <i class="fas fa-plus me-2"></i>Tambah Realisasi
                        </a>
                        <button class="btn btn-outline-secondary me-2">
                            <i class="fas fa-download me-2"></i>Ekspor Data
                        </button>
                    </div>
                    <div class="d-flex">
                        <form action="{{ route('realisasi_kinerja') }}" method="GET" class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Cari data realisasi..." value="{{ request('search') }}">
                            <button class="btn btn-outline-primary" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Table Section -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Daftar Realisasi Kinerja</span>
                <span class="badge bg-light text-dark">Total: {{ $realisasi->total() }} Data</span>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Pegawai</th>
                                <th>Periode</th>
                                <th>Indikator Kinerja</th>
                                <th>Target</th>
                                <th>Realisasi</th>
                                <th>Persentase</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($realisasi as $index => $r)
                            @php
                                // Perbaikan perhitungan persentase untuk handle target=0
                                $persentase = ($r->target > 0) 
                                    ? ($r->realisasi / $r->target * 100) 
                                    : ($r->realisasi > 0 ? 100 : 0);
                                
                                // Penyesuaian status sesuai dengan aturan di controller
                                if($r->target > 0) {
                                    if($persentase >= 90) {
                                        $statusClass = 'bg-success';
                                        $statusText = 'Tercapai';
                                    } elseif($persentase >= 70) {
                                        $statusClass = 'bg-warning';
                                        $statusText = 'Perlu Perhatian';
                                    } else {
                                        $statusClass = 'bg-danger';
                                        $statusText = 'Tidak Tercapai';
                                    }
                                } else {
                                    if($r->realisasi > 0) {
                                        $statusClass = 'bg-success';
                                        $statusText = 'Tercapai';
                                    } else {
                                        $statusClass = 'bg-danger';
                                        $statusText = 'Tidak Tercapai';
                                    }
                                }
                            @endphp
                            <tr>
                                <td>{{ $index + $realisasi->firstItem() }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div>
                                            <div class="fw-bold">{{ $r->nama_pegawai }}</div>
                                            <div class="text-muted">{{ $r->unit_kerja }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $r->periode }}</td>
                                <td>{{ $r->nama_indikator }}</td>
                                <td>{{ $r->target }}</td>
                                <td>{{ $r->realisasi }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="progress w-100 me-2" style="height: 10px;">
                                            <div class="progress-bar 
                                                @if($persentase >= 90) bg-success
                                                @elseif($persentase >= 70) bg-warning
                                                @else bg-danger @endif" 
                                                role="progressbar" 
                                                style="width: {{ min($persentase, 100) }}%" 
                                                aria-valuenow="{{ $persentase }}" 
                                                aria-valuemin="0" 
                                                aria-valuemax="100">
                                            </div>
                                        </div>
                                        <span>{{ number_format($persentase, 2) }}%</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge {{ $statusClass }}">{{ $statusText }}</span>
                                </td>
                                <td>
                                    <a href="{{ route('realisasi_kinerja.edit', $r->id) }}" class="btn btn-sm btn-outline-primary me-1">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('realisasi_kinerja.destroy', $r->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="text-center">Tidak ada data realisasi kinerja</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <nav aria-label="Page navigation">
                    {{ $realisasi->withQueryString()->links('pagination::bootstrap-5') }}
                </nav>
            </div>
        </div>
            
            <!-- Charts Section -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="chart-container">
                        <h5 class="mb-4"><i class="fas fa-chart-pie me-2"></i>Distribusi Capaian Kinerja</h5>
                        <div class="text-center">
                            <div class="d-flex justify-content-center">
                                <div style="width: 250px; height: 250px;">
                                    <canvas id="achievementChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="chart-container">
                        <h5 class="mb-4"><i class="fas fa-chart-bar me-2"></i>Rata-rata Capaian per Unit</h5>
                        <div style="height: 250px;">
                            <canvas id="unitChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/vendor/jquery/jquery.min.js"></script>
    <script src="/assets/js/browser.min.js"></script>
    <script src="/assets/js/breakpoints.min.js"></script>
    <script src="/assets/js/transition.js"></script>
    <script src="/assets/js/owl-carousel.js"></script>
    <script src="/assets/js/custom.js"></script>
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <script>
        // Auto close alerts after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            // Auto close alerts
            setTimeout(function() {
                var alerts = document.querySelectorAll('.alert');
                alerts.forEach(function(alert) {
                    var bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                });
            }, 5000);
            
            // Initialize Achievement Chart
            const achievementCtx = document.getElementById('achievementChart');
            if(achievementCtx) {
                const achievementChart = new Chart(achievementCtx, {
                    type: 'pie',
                    data: {
                        labels: ['Tercapai (≥90%)', 'Perlu Perhatian (70-89%)', 'Tidak Tercapai (<70%)'],
                        datasets: [{
                            data: [
                                {{ $chartData['capaian']['tercapai'] }},
                                {{ $chartData['capaian']['perlu_perhatian'] }},
                                {{ $chartData['capaian']['tidak_tercapai'] }}
                            ],
                            backgroundColor: [
                                '#27ae60',
                                '#f39c12',
                                '#e74c3c'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'bottom',
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return `${context.label}: ${context.parsed}`;
                                    }
                                }
                            }
                        }
                    }
                });
            }
            
            // Initialize Unit Chart
            const unitCtx = document.getElementById('unitChart');
            if(unitCtx) {
                const unitChart = new Chart(unitCtx, {
                    type: 'bar',
                    data: {
                        labels: {!! json_encode($chartData['unit']->pluck('unit_kerja')) !!},
                        datasets: [{
                            label: 'Rata-rata Capaian (%)',
                            data: {!! json_encode($chartData['unit']->pluck('rata_rata')) !!},
                            backgroundColor: '#3498db',
                            borderColor: '#2980b9',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true,
                                max: 100,
                                ticks: {
                                    callback: function(value) {
                                        return value + '%';
                                    }
                                },
                                title: {
                                    display: true,
                                    text: 'Persentase Capaian'
                                }
                            }
                        }
                    }
                });
            }
        });
    </script>
</body>
</html>