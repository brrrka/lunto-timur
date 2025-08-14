@extends('layout.app')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Manajemen Hukum & Dokumen Desa</h1>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        {{-- Card Kontak Hukum --}}
        <div class="col-xl-6 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Data Hukum
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Kontak Polsek & Babinsa</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-fw fa-phone-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('law.legal-contact-edit') }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit me-1"></i> Kelola Kontak
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Card Dokumen --}}
        <div class="col-xl-6 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Data Hukum
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Dokumen Nagari</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-fw fa-file-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        {{-- PERBAIKAN DI SINI --}}
                        <a href="{{ route('documents.index') }}" class="btn btn-success btn-sm">
                            <i class="fas fa-edit me-1"></i> Kelola Dokumen
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection