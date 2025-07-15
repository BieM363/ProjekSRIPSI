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
    <link rel="stylesheet" href="/assets/css/profil-pegawai.css">
    <link rel="stylesheet" href="/assets/css/fontawesome.css">
    <link rel="stylesheet" href="/assets/css/templatemo-style02.css">
    <link rel="stylesheet" href="/assets/css/owl.css">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
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
                        <a class="nav-link" href="{{ route('simple_page') }}">Simple Page</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('shortcodes') }}">Shortcodes</a>
                    </li>
                    
                    <!-- Dropdown Menu Input -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="menuInputDropdown" 
                           role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Menu Input
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="menuInputDropdown">
                            <li><a class="dropdown-item active" href="{{ route('profil_pegawai') }}">Profil Pegawai</a></li>
                            <li><a class="dropdown-item" href="{{ route('parameter-indikator') }}">Parameter Indikator</a></li>
                            <li><a class="dropdown-item" href="#">Realisasi Kinerja</a></li>
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
                    
                    @if($errors->any()))
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
                                <h1>Profil Pegawai</h1>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="container my-5">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2 class="mb-0"><i class="fas fa-users me-2"></i>Manajemen Akun Pegawai</h2>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
                            <i class="fas fa-plus me-1"></i> Tambah Pegawai
                        </button>
                    </div>

                    <!-- Search -->
                    <div class="search-container mb-4">
                        <form action="{{ route('profil_pegawai') }}" method="GET" class="d-flex">
                            <input type="text" name="search"
                                placeholder="Cari nama, nip, jabatan, unit kerja, atau email..."
                                value="{{ request('search') }}" class="form-control me-2">
                            <button type="submit" class="btn btn-outline-primary" style="
                                    margin-left: 500px;
                                    height: 39px;
                                    width: 494px;
                                    padding-bottom: 0px;
                                    padding-top: 0px;
                                ">
                                <i class="fas fa-search me-1"> Cari</i>
                            </button>
                        </form>
                    </div>

                    <!-- Table -->
                    <div class="table-responsive">
                        <form action="{{ route('profil_pegawai') }}" method="GET" id="filterForm">
                            <table class="table table-bordered align-middle pegawai-table">
                                <thead class="table-light">
                                    <tr>
                                        <th width="50">No.</th>
                                        <th width="200">Nama</th>
                                        <th width="150">NIP</th>
                                        <th width="200">Jabatan</th>
                                        <th width="200">Unit Kerja</th>
                                        <th width="200">Email</th>
                                        <th width="200" class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pegawais as $index => $pegawai)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $pegawai->name }}</td>
                                        <td>{{ $pegawai->nip }}</td>
                                        <td>{{ $pegawai->jabatan }}</td>
                                        <td>{{ $pegawai->unit_kerja }}</td>
                                        <td>{{ $pegawai->email }}</td>
                                        <td class="text-center table-actions">
                                            <div class="d-flex flex-wrap gap-1 justify-content-center">
                                                <button class="btn btn-sm btn-success me-1" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#editModal-{{ $pegawai->id }}">
                                                    <i class="fas fa-edit"></i> Edit
                                                </button>
                                                
                                                <form action="{{ route('profil_pegawai.destroy', $pegawai) }}" 
                                                    method="POST" 
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="btn btn-sm btn-danger" 
                                                            onclick="return confirm('Yakin hapus akun {{ $pegawai->name }}?')">
                                                        <i class="fas fa-trash-alt"></i> Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </form>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center mt-4">
                        {{ $pegawais->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ===== CREATE MODAL ===== -->
    <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="createModalLabel">
                        <i class="fas fa-plus-circle me-2"></i>Tambah Pegawai Baru
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="{{ route('profil_pegawai.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">
                                <i class="fas fa-user me-1"></i> Nama Pegawai
                            </label>
                            <input type="text" class="form-control" id="name" name="name" 
                                   value="{{ old('name') }}" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="nip" class="form-label">
                                <i class="fas fa-id-card me-1"></i> NIP
                            </label>
                            <input type="text" class="form-control" id="nip" name="nip" 
                                   value="{{ old('nip') }}" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="jabatan" class="form-label">
                                <i class="fas fa-briefcase me-1"></i> Jabatan
                            </label>
                            <input type="text" class="form-control" id="jabatan" name="jabatan" 
                                   value="{{ old('jabatan') }}" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="unit_kerja" class="form-label">
                                <i class="fas fa-building me-1"></i> Unit Kerja
                            </label>
                            <input type="text" class="form-control" id="unit_kerja" name="unit_kerja" 
                                   value="{{ old('unit_kerja') }}">
                        </div>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">
                                <i class="fas fa-envelope me-1"></i> Email
                            </label>
                            <input type="email" class="form-control" id="email" name="email" 
                                   value="{{ old('email') }}" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="password" class="form-label">
                                <i class="fas fa-lock me-1"></i> Password
                            </label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>  

                        <!-- TAMBAHKAN FIELD KONFIRMASI PASSWORD -->
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">
                                <i class="fas fa-lock me-1"></i> Konfirmasi Password
                            </label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
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

    <!-- Edit Modals for each employee -->
    @foreach($pegawais as $pegawai)
    <div class="modal fade" id="editModal-{{ $pegawai->id }}" tabindex="-1" 
         aria-labelledby="editModalLabel-{{ $pegawai->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title" id="editModalLabel-{{ $pegawai->id }}">
                        <i class="fas fa-edit me-2"></i>Edit Profil Pegawai
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <form action="{{ route('profil_pegawai.update', $pegawai->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="editName-{{ $pegawai->id }}" class="form-label">
                                <i class="fas fa-user me-1"></i> Nama Pegawai
                            </label>
                            <input type="text" class="form-control" id="editName-{{ $pegawai->id }}" 
                                   name="name" value="{{ $pegawai->name }}" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="editNip-{{ $pegawai->id }}" class="form-label">
                                <i class="fas fa-id-card me-1"></i> NIP
                            </label>
                            <input type="text" class="form-control" id="editNip-{{ $pegawai->id }}" 
                                   name="nip" value="{{ $pegawai->nip }}" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="editJabatan-{{ $pegawai->id }}" class="form-label">
                                <i class="fas fa-briefcase me-1"></i> Jabatan
                            </label>
                            <input type="text" class="form-control" id="editJabatan-{{ $pegawai->id }}" 
                                   name="jabatan" value="{{ $pegawai->jabatan }}" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="editUnitKerja-{{ $pegawai->id }}" class="form-label">
                                <i class="fas fa-building me-1"></i> Unit Kerja
                            </label>
                            <input type="text" class="form-control" id="editUnitKerja-{{ $pegawai->id }}" 
                                   name="unit_kerja" value="{{ $pegawai->unit_kerja }}">
                        </div>
                        
                        <div class="mb-3">
                            <label for="editEmail-{{ $pegawai->id }}" class="form-label">
                                <i class="fas fa-envelope me-1"></i> Email
                            </label>
                            <input type="email" class="form-control" id="editEmail-{{ $pegawai->id }}" 
                                   name="email" value="{{ $pegawai->email }}" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="editPassword-{{ $pegawai->id }}" class="form-label">
                                <i class="fas fa-lock me-1"></i> Password Baru
                            </label>
                            <input type="password" class="form-control" id="editPassword-{{ $pegawai->id }}" 
                                name="password">
                            <small class="form-text text-muted">
                                Kosongkan jika tidak ingin mengubah password
                            </small>
                        </div>
                        
                        <!-- TAMBAHKAN FIELD KONFIRMASI PASSWORD -->
                        <div class="mb-3">
                            <label for="editPasswordConfirmation-{{ $pegawai->id }}" class="form-label">
                                <i class="fas fa-lock me-1"></i> Konfirmasi Password Baru
                            </label>
                            <input type="password" class="form-control" id="editPasswordConfirmation-{{ $pegawai->id }}" 
                                name="password_confirmation">
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
        // Auto close alerts after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                var alerts = document.querySelectorAll('.alert');
                alerts.forEach(function(alert) {
                    var bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                });
            }, 5000);
            
            // Reset Filter Button
            document.getElementById('resetFilter').addEventListener('click', function() {
                // Reset all filter inputs
                var inputs = document.querySelectorAll('.table-filters input');
                inputs.forEach(function(input) {
                    input.value = '';
                });
                
                // Submit the filter form
                document.getElementById('filterForm').submit();
            });
        });
    </script>
</body>
</html>