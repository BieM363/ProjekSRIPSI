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
                            <li><a class="dropdown-item" href="{{ route('profil_pegawai') }}">Profil Pegawai</a></li>
                            <li><a class="dropdown-item active" href="{{ route('parameter-indikator') }}">Parameter Indikator</a></li>
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
    <section class="main-banner">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="banner-content">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="banner-caption text-center">
                                    <h4>Hello, welcome to <em>Ramayana</em> Dashboard</h4>
                                    <span>MODERN & RESPONSIVE ADMIN TEMPLATE</span>
                                    <p class="mt-4">
                                        <strong>Ramayana</strong> is a free to use Bootstrap 5 admin template designed for modern web applications. 
                                        You can customize and extend it for your personal or corporate needs.
                                    </p>
                                    <div class="primary-button mt-4">
                                        <a href="#">Get Started</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

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
        });
    </script>
</body>
</html>