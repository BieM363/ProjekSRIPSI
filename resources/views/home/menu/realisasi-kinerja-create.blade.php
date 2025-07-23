{{-- resources/views/home/menu/realisasi-kinerja-create.blade.php --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700" rel="stylesheet">

    <title>Ramayana - Tambah Realisasi Kinerja</title>

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
    
    <!-- Tailwind-like utility classes -->
    <style>
        .bg-purple-50 { background-color: #f5f3ff; }
        .bg-purple-700 { background-color: #6d28d9; }
        .bg-purple-800 { background-color: #5b21b6; }
        .text-purple-800 { color: #5b21b6; }
        .border-purple-300 { border-color: #d8b4fe; }
        .focus\:ring-purple-500:focus { 
            --tw-ring-color: rgba(139, 92, 246, 0.5);
            box-shadow: 0 0 0 3px var(--tw-ring-color);
        }
        .grid { display: grid; }
        .grid-cols-1 { grid-template-columns: repeat(1, minmax(0, 1fr)); }
        .md\:grid-cols-2 { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .md\:grid-cols-3 { grid-template-columns: repeat(3, minmax(0, 1fr)); }
        .gap-4 { gap: 1rem; }
        .card { border-radius: 0.5rem; overflow: hidden; }
        .shadow-md { box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); }
        .flex { display: flex; }
        .justify-end { justify-content: flex-end; }
        .items-center { align-items: center; }
        .mr-2 { margin-right: 0.5rem; }
        .mt-6 { margin-top: 1.5rem; }
        .mb-4 { margin-bottom: 1rem; }
        .p-2 { padding: 0.5rem; }
        .w-full { width: 100%; }
        .rounded { border-radius: 0.25rem; }
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.5rem 1rem;
            border-radius: 0.25rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        .btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .btn:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.5);
        }
        .bg-gray-500 { background-color: #6b7280; }
        .hover\:bg-gray-600:hover { background-color: #4b5563; }
        .bg-purple-700 { background-color: #6d28d9; }
        .hover\:bg-purple-800:hover { background-color: #5b21b6; }
        .text-white { color: white; }
        .block { display: block; }
        .font-medium { font-weight: 500; }
        .text-red-600 { color: #dc2626; }
    </style>
</head>

<body class="is-preload">
    <!-- Navbar -->
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
                            <h1>Tambah Realisasi Kinerja Baru</h1>
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
            
            @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <!-- Form Section -->
            <div class="card bg-purple-50 shadow-md">
                <div class="card-header bg-purple-700 text-white">
                    <h3 class="text-xl font-bold m-0">Tambah Realisasi Kinerja Baru</h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('realisasi_kinerja.store') }}">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Input Pegawai -->
                            <div class="mb-4">
                                <label class="block text-purple-800 font-medium mb-2">Pegawai</label>
                                <select name="pegawai_id" class="w-full p-2 border border-purple-300 rounded focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                    @foreach($pegawai as $p)
                                        <option value="{{ $p->id }}" {{ old('pegawai_id') == $p->id ? 'selected' : '' }}>
                                            {{ $p->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('pegawai_id')
                                    <span class="text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <!-- Input Indikator -->
                            <div class="mb-4">
                                <label class="block text-purple-800 font-medium mb-2">Indikator Kinerja</label>
                                <select name="indikator_id" class="w-full p-2 border border-purple-300 rounded focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                    @foreach($indikator as $i)
                                        <option value="{{ $i->id }}" {{ old('indikator_id') == $i->id ? 'selected' : '' }}>
                                            {{ $i->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('indikator_id')
                                    <span class="text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <!-- Input Periode -->
                            <div class="mb-4">
                                <label class="block text-purple-800 font-medium mb-2">Periode</label>
                                <select name="periode" class="w-full p-2 border border-purple-300 rounded focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                    @foreach($periodes as $p)
                                        <option value="{{ $p }}" {{ old('periode') == $p ? 'selected' : '' }}>
                                            {{ $p }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('periode')
                                    <span class="text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <!-- Input Target -->
                            <div class="mb-4">
                                <label class="block text-purple-800 font-medium mb-2">Target</label>
                                <input type="number" name="target" min="0" step="0.01" 
                                       value="{{ old('target', '') }}"
                                       class="w-full p-2 border border-purple-300 rounded focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                @error('target')
                                    <span class="text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <!-- Input Realisasi -->
                            <div class="mb-4">
                                <label class="block text-purple-800 font-medium mb-2">Realisasi</label>
                                <input type="number" name="realisasi" min="0" step="0.01" 
                                       value="{{ old('realisasi', '') }}"
                                       class="w-full p-2 border border-purple-300 rounded focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                @error('realisasi')
                                    <span class="text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="flex justify-end mt-6">
                            <a href="{{ route('realisasi_kinerja') }}" class="btn bg-gray-500 text-white hover:bg-gray-600 mr-2">
                                Batal
                            </a>
                            <button type="submit" class="btn bg-purple-700 text-white hover:bg-purple-800">
                                <i class="fas fa-save mr-1"></i>
                                Simpan
                            </button>
                        </div>
                    </form>
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
        });
    </script>
</body>
</html>