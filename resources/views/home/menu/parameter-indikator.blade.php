<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700" rel="stylesheet">

    <title>Ramayana - HTML5 Template</title>

    <!-- Bootstrap core CSS -->
    <link href="/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="/assets/css/parameter-indikator.css">
    <link rel="stylesheet" href="/assets/css/fontawesome.css">
    <link rel="stylesheet" href="/assets/css/templatemo-style.css">
    <link rel="stylesheet" href="/assets/css/owl.css">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom CSS for navbar and buttons -->
    <link rel="stylesheet" href="/css/profil-pegawai.css">
    
    <style>
        .total-bobot {
            background-color: #e9f7ef;
            font-weight: bold;
        }
        .alert-container {
            position: fixed;
            top: 80px;
            right: 20px;
            z-index: 1050;
            min-width: 300px;
        }
        .table-actions {
            white-space: nowrap;
        }
    </style>
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
    <div class="container-fluid main-content">
        <div class="row justify-content-center">
            <div class="col-lg-11">
                <!-- Alert Container -->
                <div class="alert-container">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    
                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                </div>

                <!-- Page Heading -->
                <div class="page-heading">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <h1>Parameter Indikator Kinerja</h1> <!-- Judul diperbarui -->
                            </div>
                        </div>
                    </div>
                </div>


                <!-- ===== MAIN CONTENT ===== -->
                <div class="container my-5">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2 class="mb-0"><i class="fas fa-list-alt me-2"></i>Parameter Indikator Kinerja</h2> <!-- Judul diperbarui -->
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
                            <i class="fas fa-plus me-1"></i> Tambah Parameter
                        </button>
                    </div>

                     <!-- Peringatan Total Bobot -->
                    @if($parameters->sum('bobot') != 100)
                        <div class="alert alert-warning mb-4">
                            <i class="fas fa-exclamation-triangle me-2"></i> 
                            <strong>Perhatian!</strong> Total bobot saat ini {{ $parameters->sum('bobot') }}%. 
                            Pastikan total bobot tepat 100% untuk pengukuran kinerja yang valid.
                        </div>
                    @endif

                    <!-- Table Listing -->
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th width="50">No.</th>
                                    <th>Nama Indikator</th>
                                    <th width="150">Satuan</th>
                                    <th width="100">Target</th>
                                    <th width="120">Bobot (%)</th>
                                    <th width="200" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($parameters as $param)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $param->nama }}</td>
                                    <td>{{ $param->satuan }}</td>
                                    <td>{{ $param->target }}</td>
                                    <td>{{ $param->bobot }}</td>
                                    <td class="text-center table-actions">
                                        <button class="btn btn-sm btn-warning me-1" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#editModal-{{ $param->id }}">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>

                                        <form action="{{ route('parameter-indikator.destroy', $param->id) }}" 
                                              method="POST" 
                                              class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="btn btn-sm btn-danger" 
                                                    onclick="return confirm('Yakin ingin menghapus data ini?')">
                                                <i class="fas fa-trash-alt"></i> Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="total-bobot">
                                    <td colspan="4" class="text-end fw-bold">Total Bobot:</td>
                                    <td class="fw-bold">{{ $parameters->sum('bobot') }}%</td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    
                    <!-- Explanation Card -->
                    <div class="card mt-4 explanation-card">
                        <div class="card-header">
                            <i class="fas fa-lightbulb me-2"></i>Penjelasan Parameter Indikator Kinerja
                        </div>
                        <div class="card-body">
                            <p>
                                <strong>Parameter Indikator Kinerja</strong> adalah alat ukur kunci untuk mengevaluasi keberhasilan organisasi:
                            </p>
                            <ul>
                                <li><strong>Nama Indikator</strong> = Variabel yang diukur (Contoh: "Indeks Kepuasan DPRD terhadap layanan Sekretariat DPRD")</li>
                                <li><strong>Target</strong> = Nilai yang ingin dicapai (Contoh: "90")</li>
                                <li><strong>Satuan</strong> = Metrik pengukuran (Contoh: "indeks")</li>
                                <li><strong>Bobot</strong> = Tingkat kepentingan relatif (Contoh: "30" untuk 30%)</li>
                            </ul>
                            <p class="mb-0">
                                Berdasarkan <strong>LKIP Sekretariat DPRD Kota Gorontalo 2024</strong>, indikator utama yang digunakan adalah 
                                <em>"Indeks Kepuasan DPRD"</em> dengan target 90 indeks. Pastikan semua parameter telah terdefinisi dengan baik dan 
                                <strong>total bobot tepat 100%</strong> sebelum melakukan pengukuran kinerja.
                            </p>
                        </div>
                    </div>
                </div>
                <!-- ===== /MAIN CONTENT ===== -->

            </div>
        </div>
    </div>

    <!-- ===== CREATE MODAL ===== -->
    <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="createModalLabel">
                        <i class="fas fa-plus-circle me-2"></i>Tambah Parameter Baru
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="{{ route('parameter-indikator.store') }}" method="POST" id="parameterForm">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nama" class="form-label">
                            <i class="fas fa-tag me-1"></i> Nama Indikator
                        </label>
                        <input type="text" class="form-control" id="nama" name="nama" required
                            placeholder="Contoh: Indeks Kepuasan DPRD terhadap layanan Sekretariat DPRD">
                            </div>
                            
                            <div class="mb-3">
                        <label for="satuan" class="form-label">
                            <i class="fas fa-ruler me-1"></i> Satuan
                        </label>
                        <input type="text" class="form-control" id="satuan" name="satuan" required
                            placeholder="Contoh: indeks, dokumen, persen"> <!-- Placeholder diperbarui -->
                    </div>
                    
                    <div class="mb-3">
                        <label for="target" class="form-label">
                            <i class="fas fa-bullseye me-1"></i> Target
                        </label>
                        <input type="number" class="form-control" id="target" name="target" 
                            min="0" step="1" required
                            placeholder="Contoh: 90"> <!-- Placeholder diperbarui -->
                    </div>
                    
                    <div class="mb-3">
                        <label for="bobot" class="form-label">
                            <i class="fas fa-weight-hanging me-1"></i> Bobot (%) 
                        </label>
                        <input type="number" class="form-control" id="bobot" name="bobot" 
                            min="0" max="100" step="0.1" required
                            placeholder="Contoh: 30">
                        <small class="form-text text-muted">
                            Total semua bobot harus tepat 100%
                        </small>
                    </div>
                </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i> Batal
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- ===== /CREATE MODAL ===== -->

    <!-- Edit Modals for each parameter -->
    @foreach ($parameters as $param)
    <div class="modal fade" id="editModal-{{ $param->id }}" tabindex="-1" 
         aria-labelledby="editModalLabel-{{ $param->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title" id="editModalLabel-{{ $param->id }}">
                        <i class="fas fa-edit me-2"></i>Edit Parameter
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="{{ route('parameter-indikator.update', $param->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nama-{{ $param->id }}" class="form-label">
                                <i class="fas fa-tag me-1"></i> Nama Indikator
                            </label>
                            <input type="text" class="form-control" id="nama-{{ $param->id }}" 
                                   name="nama" value="{{ $param->nama }}" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="satuan-{{ $param->id }}" class="form-label">
                                <i class="fas fa-ruler me-1"></i> Satuan
                            </label>
                            <input type="text" class="form-control" id="satuan-{{ $param->id }}" 
                                   name="satuan" value="{{ $param->satuan }}" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="target-{{ $param->id }}" class="form-label">
                                <i class="fas fa-bullseye me-1"></i> Target
                            </label>
                            <input type="number" class="form-control" id="target-{{ $param->id }}" 
                                   name="target" value="{{ $param->target }}" 
                                   min="0" step="1" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="bobot-{{ $param->id }}" class="form-label">
                                <i class="fas fa-weight-hanging me-1"></i> Bobot (%) 
                            </label>
                            <input type="number" class="form-control" id="bobot-{{ $param->id }}" 
                                   name="bobot" value="{{ $param->bobot }}" 
                                   min="0" max="100" step="0.1" required>
                            <small class="form-text text-muted">
                                Total semua bobot harus 100%
                            </small>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i> Batal
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach

  <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/vendor/jquery/jquery.min.js"></script>
    <script src="/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/browser.min.js"></script>
    <script src="/assets/js/breakpoints.min.js"></script>
    <script src="/assets/js/transition.js"></script>
    <script src="/assets/js/owl-carousel.js"></script>
    <script src="/assets/js/custom.js"></script>
    
    <script>

        // Validasi tambahan untuk memastikan total bobot 100%
        document.getElementById('parameterForm').addEventListener('submit', function(e) {
            const bobotInput = document.getElementById('bobot');
            const currentTotal = {{ $parameters->sum('bobot') }};
            const newBobot = parseFloat(bobotInput.value);
            
            if (currentTotal + newBobot > 100) {
                e.preventDefault();
                alert(`Total bobot tidak boleh melebihi 100%. Bobot saat ini: ${currentTotal}%`);
                bobotInput.focus();
            }
        });

        // Auto close alerts after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                var alerts = document.querySelectorAll('.alert');
                alerts.forEach(function(alert) {
                    var bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                });
            }, 5000);
        });
    </script>
</body>
</html>