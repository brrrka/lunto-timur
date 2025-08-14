@php
    $menus = [
        1 => [
            (object) [
                'title' => 'Dashboard',
                'path' => 'dashboard',
                'icon' => 'fas fa-fw fa-tachometer-alt',
            ],
            (object) [
                'title' => 'Penduduk',
                'path' => 'resident',
                'icon' => 'fas fa-fw fa-table',
            ],
        ],
        2 => [
            (object) [
                'title' => 'Dashboard',
                'path' => 'dashboard',
                'icon' => 'fas fa-fw fa-tachometer-alt',
            ],
            (object) [
                'title' => 'Pengaduan',
                'path' => 'complaint',
                'icon' => 'fas fa-fw fa-scroll',
            ],
        ],
    ];
@endphp
<!-- Sidebar -->
<ul class="navbar-nav sidebar sidebar-dark accordion" style="background-color: #0d8b0dff;"id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center mt-2 mb-2 ml-2" href="{{ route('pages.dashboard') }}">
        <img src="{{ asset('images/logo_nagari.png') }}" alt="Logo" width="48" height="48">
        <div class="sidebar-brand-text mx-3">Desa Lunto Timur</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <!-- <li class="nav-item {{ request()->is('dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="/dashboard">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li> -->

    <!-- Divider -->
    <!-- <hr class="sidebar-divider"> -->

    <!-- Heading -->
    <!-- <div class="sidebar-heading">
        Manajemen Data
    </div> -->

    <!-- Nav Item - Tables -->
    @foreach($menus[auth()->user()->role_id] as $menu)
    <li class="nav-item {{ request()->is($menu->path. '*') ? 'active' : '' }}">
        <a class="nav-link" href="/{{ $menu->path }}">
            <i class="{{ $menu->icon }}"></i>
            <span>{{ $menu->title }}</span></a>
    </li>
    @endforeach

    @if(auth()->user()->role_id == 1)
    <!-- Menu Konten (Dropdown) -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLayanan"
            aria-expanded="false" aria-controls="collapseLayanan">
            <i class="fas fa-fw fa-folder"></i>
            <span>Layanan</span>
        </a>
        <div id="collapseLayanan" class="collapse {{ request()->is('account-request*') || request()->is('complaint*') ? 'show' : '' }}" aria-labelledby="headingLayanan"
            data-parent="#accordionSidebar">
            <div class="collapse-inner">
                <a class="collapse-item {{ request()->is('account-request*') ? 'active' : '' }}" href="/account-request"><i class="fas fa-fw fa-user mr-2"></i>Permintaan Akun</a>
                <a class="collapse-item {{ request()->is('complaint*') ? 'active' : '' }}" href="/complaint"><i class="fas fa-fw fa-scroll mr-2"></i>Pengaduan Warga</a>
            </div>
        </div>
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseKonten"
            aria-expanded="false" aria-controls="collapseKonten">
            <i class="fas fa-fw fa-folder"></i>
            <span>Konten</span>
        </a>
        <div id="collapseKonten" class="collapse {{ request()->is('profile-nagari-content*') || request()->is('news*') || request()->is('gallery*') || request()->is('umkms*') || request()->is('tourism-spots*') || request()->is('pertanian-peternakan*') || request()->is('health*') || request()->is('law*') ? 'show' : '' }}" aria-labelledby="headingKonten"
            data-parent="#accordionSidebar">
            <div class="collapse-inner">
                <a class="collapse-item {{ request()->is('profile-nagari-content*') ? 'active' : '' }}" href="/profile-nagari-content"><i class="fas fa-fw fa-building mr-2"></i>Profil Nagari</a>
                <a class="collapse-item {{ request()->is('news*') ? 'active' : '' }}" href="/news"><i class="fas fa-fw fa-newspaper mr-2"></i>Berita</a>
                <a class="collapse-item {{ request()->is('gallery*') ? 'active' : '' }}" href="/gallery"><i class="fas fa-fw fa-images mr-2"></i>Galeri</a>
                <a class="collapse-item {{ request()->is('umkms*') ? 'active' : '' }}" href="/umkms"><i class="fas fa-fw fa-store mr-2"></i>UMKM</a>
                <a class="collapse-item {{ request()->is('tourism-spots*') ? 'active' : '' }}" href="/tourism-spots"><i class="fas fa-solid fa-camera-retro mr-2"></i>Wisata</a>
                <a class="collapse-item {{ request()->is('pertanian-peternakan*') ? 'active' : '' }}" href="/pertanian-peternakan"><i class="fas fa-fw fa-seedling mr-2"></i>Tani & Ternak</a>
                <a class="collapse-item {{ request()->is('law*') ? 'active' : '' }}" href="/law"><i class="fas fa-fw fa-balance-scale mr-2"></i>Hukum</a>
                <a class="collapse-item {{ request()->is('health*') ? 'active' : '' }}" href="/health"><i class="fas fa-fw fa-heart mr-2"></i>Kesehatan</a>
                
            </div>
        </div>
    </li>
    @endif



    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->

