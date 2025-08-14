@extends('layout.app') 

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Manajemen Data Kesehatan</h1>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        {{-- Card Data Fasilitas Layanan Kesehatan --}}
        <div class="col-xl-6 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Data Kesehatan
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Fasilitas Layanan Kesehatan</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-fw fa-hospital fa-2x text-gray-300"></i> {{-- Icon rumah sakit --}}
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('health-facilities.index') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-edit me-1"></i> Kelola
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Card Data Penyakit --}}
        <div class="col-xl-6 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Data Kesehatan
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Data Penyakit</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-fw fa-viruses fa-2x text-gray-300"></i> {{-- Icon virus --}}
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('diseases.index') }}" class="btn btn-danger btn-sm">
                            <i class="fas fa-edit me-1"></i> Kelola
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection