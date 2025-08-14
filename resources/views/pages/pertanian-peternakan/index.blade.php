@extends('layout.app')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Manajemen Data Pertanian & Peternakan</h1>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        {{-- Card Kelembagaan Tani --}}
        <div class="col-xl-6 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Data Pertanian
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Kelembagaan Tani</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-fw fa-seedling fa-2x text-gray-300"></i> {{-- Icon tanaman --}}
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('kelembagaan-tani.index') }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit me-1"></i> Kelola
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Card Luas Area Produksi --}}
        <div class="col-xl-6 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Data Pertanian
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Luas Area Produksi</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-fw fa-chart-area fa-2x text-gray-300"></i> {{-- Icon grafik area --}}
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('luas-area-produksi.index') }}" class="btn btn-success btn-sm">
                            <i class="fas fa-edit me-1"></i> Kelola
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Card Populasi Tanaman --}}
        <div class="col-xl-6 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Data Pertanian
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Populasi Tanaman</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-fw fa-tree fa-2x text-gray-300"></i> {{-- Icon pohon --}}
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('populasi-tanaman.index') }}" class="btn btn-info btn-sm">
                            <i class="fas fa-edit me-1"></i> Kelola
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Card Populasi Ternak --}}
        <div class="col-xl-6 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Data Peternakan
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Populasi Ternak</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-fw fa-dove fa-2x text-gray-300"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('populasi-ternak.index') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-edit me-1"></i> Kelola
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection