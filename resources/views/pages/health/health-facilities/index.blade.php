@extends('layout.app')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Data Fasilitas Kesehatan</h1>
    <a href="{{ route('health-facilities.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"><i
    class="fas fa-plus fa-sm text-white-50"></i> Tambah</a>
</div>

<div class="row">
    <div class="col">
        <div class="card shadow">
            <div class="card-body">
                <form action="{{ route('health-facilities.index') }}" method="GET" class="mb-3">
                    <div class="row justify-content-end"> 
                        <div class="col-md-8 col-lg-6"> 
                            <div class="input-group">
                                <input type="text" name="search" class="form-control bg-light border-0 small" placeholder="Cari berdasarkan Nama atau Alamat..."
                                    aria-label="Search" aria-describedby="basic-addon2" value="{{ request('search') }}">
                                <div class="input-group-append">
                                    <button class="btn btn-success" type="submit">
                                        <i class="fas fa-search fa-sm"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="table-responsive">
                    <table class="table table-bordered w-100" cellspacing="0"> {{-- Ubah table-hovered jadi table-hover --}}
                        <thead>
                            <tr>
                                <th style="width: 50px;">No</th>
                                <th>Nama</th>
                                <th>Alamat</th>
                                <th>No HP</th>
                                <th style="width: 80px;">Foto</th> {{-- Beri lebar untuk kolom foto --}}
                                <th style="width: 150px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($healthFacilities as $item) {{-- Gunakan @forelse untuk kondisi empty --}}
                                <tr>
                                    <td>{{ $loop->iteration + ($healthFacilities->currentPage() - 1) * $healthFacilities->perPage() }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ Str::limit($item->address, 50, '...') }}</td>
                                    <td>{{ $item->phone_number ?? '-' }}</td>
                                    <td>
                                        @if ($item->photo)
                                            <img src="{{ asset('storage/' . $item->photo) }}" alt="{{ $item->name }}" class="img-thumbnail" style="width: 80px; height: 80px; object-fit: cover;">
                                        @else
                                            <span class="text-muted">Tidak ada</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            {{-- PERBAIKAN: Tombol Edit --}}
                                            <a href="{{ route('health-facilities.edit', $item->slug) }}" class="btn btn-warning btn-sm me-2">
                                                <i class="fas fa-pen"></i>
                                            </a>
                                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteHealthFacilityModal{{ $item->id }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">Belum ada data fasilitas kesehatan yang tersedia.</td> {{-- colspan sudah benar --}}
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if ($healthFacilities instanceof \Illuminate\Pagination\LengthAwarePaginator)
                <div class="card-footer">
                    {{ $healthFacilities->appends(request()->query())->links('vendor.pagination.bootstrap-5') }}
                </div>
            @endif
        </div>
        <div class="d-flex justify-content-start mt-4">
            <a href="{{ route('health.index') }}" class="btn btn-outline-secondary me-2">
            <i class="fas fa-arrow-left me-2"></i>Kembali</a>
        </div>
    </div>
    {{-- Modals Konfirmasi Hapus --}}
    @foreach ($healthFacilities as $item)
        <div class="modal fade" id="deleteHealthFacilityModal{{ $item->id }}" tabindex="-1" aria-labelledby="deleteHealthFacilityModalLabel{{ $item->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteHealthFacilityModalLabel{{ $item->id }}">Konfirmasi Hapus</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Apakah Anda yakin ingin menghapus fasilitas kesehatan "<strong>{{ $item->name }}</strong>"?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <form action="{{ route('health-facilities.destroy', $item->slug) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection

    


   