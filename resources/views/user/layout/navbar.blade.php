        <nav class="navbar navbar-expand-lg navbar-dark shadow-lg fixed-top" style="background-color: #4CAF50;">
        <div class="container">
            <!-- Logo dan Nama -->
            <a class="navbar-brand fw-semibold d-flex align-items-center" href="#">
                <img src="{{ asset('images/logo_nagari.png') }}" alt="Logo" width="32" height="32" class="me-2">
                Desa Lunto Timur
            </a>
      
            <!-- Toggle (untuk layar kecil) -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
      
            <!-- Menu & Login -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto me-3">
                    <li class="nav-item">
                        <a class="nav-link fw-semibold {{ Request::is('/') ? 'active' : '' }}" aria-current="page" href="{{ url('/') }}">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-semibold {{ Request::routeIs('profil-nagari') ? 'active' : '' }}" href="{{ route('profil-nagari') }}">Profil Desa</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link fw-semibold dropdown-toggle" href="#" id="navbarDropdownInformasi" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Informasi
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownInformasi">
                            <li><a class="dropdown-item" href="{{ url('/berita') }}">Berita</a></li>
                            <li><a class="dropdown-item" href="{{ url('/galeri') }}">Galeri</a></li>
                            <li><a class="dropdown-item" href="{{ url('/wisata') }}">Wisata</a></li>
                            <li><a class="dropdown-item" href="{{ url('/pertanian') }}">Pertanian</a></li>
                            <li><a class="dropdown-item" href="{{ url('/peternakan') }}">Peternakan</a></li>
                            <li><a class="dropdown-item" href="{{ url('/kesehatan') }}">Kesehatan</a></li>

                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-semibold {{ Request::routeIs('umkm') ? 'active' : '' }}" href="{{ route('user.pages.umkm.index') }}">UMKM</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link fw-semibold dropdown-toggle" href="#" id="navbarDropdownLayanan" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Layanan
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownLayanan">
                            <li><a class="dropdown-item" href="{{ url('/hukum') }}">Hukum</a></li>
                        </ul>
                    </li>
                </ul>
                
            </div>
        </div>
    </nav>