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

<!--
Ramayana CSS Template
https://templatemo.com/tm-529-ramayana
-->

    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="/assets/css/fontawesome.css">
    <link rel="stylesheet" href="/assets/css/templatemo-style.css">
    <link rel="stylesheet" href="/assets/css/owl.css">
    <link rel="stylesheet" href="{{ asset('assets/css/profil-pegawai.css') }}">
    


  </head>

<body class="is-preload">

    <!-- Wrapper -->
    <div id="wrapper">

      <!-- Main -->
        <div id="main">
          <div class="inner">

            <!-- Header -->
            <header id="header">
              <div class="logo">
                <a href="{{ route('dashboard') }}">Ramayana</a>
              </div>
            </header>

            <!-- Page Heading -->
            <div class="page-heading">
              <div class="container-fluid">
                <div class="row">
                  <div class="col-md-12">
                    <h1>Profil Pegawai</h1>

                    {{-- Pesan sukses setelah menambah pegawai --}}
                    @if(session('success'))
                      <div class="alert alert-success">
                        {{ session('success') }}
                      </div>
                    @endif
                  </div>
                </div>
              </div>
            </div>

                    {{-- Form untuk menambah akun pegawai --}}
              <div class="form-container">
                <h2>Tambah Akun Pegawai</h2>
                <form action="{{ route('profil_pegawai.store') }}" method="POST">
                  @csrf

                  <div class="form-group">
                    <label for="name">Nama Pegawai</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required>
                  </div>
                  @error('name')<div class="error">{{ $message }}</div>@enderror

                  <div class="form-group">
                    <label for="jabatan">Jabatan</label>
                    <input type="text" id="jabatan" name="jabatan" value="{{ old('jabatan') }}" required>
                  </div>
                  @error('jabatan')<div class="error">{{ $message }}</div>@enderror

                  <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required>
                  </div>
                  @error('email')<div class="error">{{ $message }}</div>@enderror

                  <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                  </div>
                  @error('password')<div class="error">{{ $message }}</div>@enderror

                  <button type="submit">Tambah Pegawai</button>
                </form>
              </div>
                  <br>
                  <br>

            <div class="table-wrapper">

                  <!-- Search -->
              <div class="search-container">
                <form action="{{ route('profil_pegawai') }}" method="GET">
                  <input type="text" name="search"
                        placeholder="Cari nama, jabatan, atau email..."
                        value="{{ request('search') }}">
                  <button type="submit">Cari</button>
                </form>
              </div>
            
            {{-- Tabel daftar pegawai dengan pagination --}}
            <table class="pegawai-table">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Jabatan</th>
                        <th>Email</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pegawais as $pegawai)
                    <tr>
                      <td>{{ $pegawai->name }}</td>
                      <td>{{ $pegawai->jabatan }}</td>
                      <td>{{ $pegawai->email }}</td>
                      <td>
                        <form action="{{ route('profil_pegawai.destroy', $pegawai) }}"
                              method="POST"
                              onsubmit="return confirm('Yakin hapus akun {{ $pegawai->name }}?')">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn-delete">Hapus</button>
                        </form>
                      </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            

            {{-- Navigasi pagination --}}
            <div>
                {{ $pegawais->links() }}
            </div>
          </div>
          </div>
        </div>

      <!-- Sidebar -->
        <div id="sidebar">

          <div class="inner">

            <!-- Search Box -->
            <section id="search" class="alt">
              <form method="get" action="#">
                <input type="text" name="search" id="search" placeholder="Search..." />
              </form>
            </section>
              
            <!-- Menu -->
           <nav id="menu">
              <ul>
                <li><a href="{{ route('dashboard') }}">Homepage</a></li>
                <li><a href="{{ route('simple_page') }}">Simple Page</a></li>
                <li><a href="{{ route('shortcodes') }}">Shortcodes</a></li>
                <li>
                  <span class="opener">Menu Input</span>
                  <ul>
                    <li><a href="{{ route('profil_pegawai') }}">Profil Pegawai</a></li>
                    <li><a href="#">Parameter Indikator</a></li>
                    <li><a href="#">Realisasi Kinerja</a></li>
                    <li><a href="#">Survei Kepuasan</a></li>
                    <li><a href="#">Sarana & Prasarana</a></li>
                    <li><a href="#">Data Responden</a></li>
                  </ul>
                <li>
                  <span class="opener">Dropdown Two</span>
                  <ul>
                    <li><a href="#">Sub Menu #1</a></li>
                    <li><a href="#">Sub Menu #2</a></li>
                    <li><a href="#">Sub Menu #3</a></li>
                  </ul>
                </li>
                <li>
                    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                      Logout
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                      @csrf
                    </form>
                </li>
              </ul>
            </nav>

            <!-- Featured Posts -->
            <div class="featured-posts">
              <div class="heading">
                <h2>Featured Posts</h2>
              </div>
              <div class="owl-carousel owl-theme">
                <a href="#">
                  <div class="featured-item">
                    <img src="/assets/images/featured_post_01.jpg" alt="featured one">
                    <p>Aliquam egestas convallis eros sed gravida. Curabitur consequat sit.</p>
                  </div>
                </a>
                <a href="#">
                  <div class="featured-item">
                    <img src="/assets/images/featured_post_01.jpg" alt="featured two">
                    <p>Donec a scelerisque massa. Aliquam non iaculis quam. Duis arcu turpis.</p>
                  </div>
                </a>
                <a href="#">
                  <div class="featured-item">
                    <img src="/assets/images/featured_post_01.jpg" alt="featured three">
                    <p>Suspendisse ac convallis urna, vitae luctus ante. Donec sit amet.</p>
                  </div>
                </a>
              </div>
            </div>

            <!-- Footer -->
            <footer id="footer">
              <p class="copyright">Copyright &copy; 2019 Company Name
              <br>Designed by <a rel="nofollow" href="https://www.facebook.com/templatemo">Template Mo</a></p>
            </footer>
            
          </div>
        </div>

    </div>

  <!-- Scripts -->
  <!-- Bootstrap core JavaScript -->
    <script src="/vendor/jquery/jquery.min.js"></script>
    <script src="/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script src="/assets/js/browser.min.js"></script>
    <script src="/assets/js/breakpoints.min.js"></script>
    <script src="/assets/js/transition.js"></script>
    <script src="/assets/js/owl-carousel.js"></script>
    <script src="/assets/js/custom.js"></script>
</body>


  </body>

</html>
