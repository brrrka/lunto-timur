@extends ('layout.app')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Manajemen Konten Profil Desa</h1>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-xl-6 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Konten Teks
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Visi dan Misi Desa</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-fw fa-scroll fa-2x text-gray-300"></i> {{-- Ganti fas ke fa-solid jika Font Awesome 6 --}}
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('profile-nagari-content.edit') }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit me-1"></i> Kelola Visi & Misi
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-6 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Daftar Pengurus
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Struktur Organisasi</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-fw fa-sitemap fa-2x text-gray-300"></i> {{-- Ganti fas ke fa-solid jika Font Awesome 6 --}}
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('struktur-organisasi.index') }}" class="btn btn-success btn-sm">
                            <i class="fas fa-users-cog me-1"></i> Kelola Pengurus
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection