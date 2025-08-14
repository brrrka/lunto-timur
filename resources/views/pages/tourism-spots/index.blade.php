@extends('layout.app')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Manajemen Tempat Wisata</h1>
        <a href="/tourism-spots/create" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"><i
                        class="fas fa-plus fa-sm text-white-50"></i> Tambah</a>
    </div>

    <!-- Table -->
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-body">
                    <form action="{{ route('tourism-spots.index') }}" method="GET" class="mb-3">
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
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Alamat</th>
                                    <th>Thumbnail</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($tourismSpots as $spot)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $spot->name }}</td>
                                    <td>{{ Str::limit($spot->address, 50, '...') }}</td>
                                    <td>
                                        @if ($spot->thumbnail)
                                            <img src="{{ asset('storage/' . $spot->thumbnail) }}" alt="{{ $spot->name }}" width="100">
                                        @else
                                            Tidak ada gambar
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="{{ route('tourism-spots.edit', $spot->slug) }}" class="d-inline-block mr-2 btn-sm btn-warning">
                                                <i class="fas fa-pen"></i>
                                            </a>
                                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteNewsModal{{ $spot->slug }}">
                                                <i class="fas fa-eraser"></i> 
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center">Tidak ada data tempat wisata.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        {{ $tourismSpots->links() }}
                    </div>
                </div>
                {{-- Pagination Navigation --}}
                <div class="card-footer">
                    {{ $tourismSpots->links('vendor.pagination.bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>

    {{-- Modals Konfirmasi Hapus (letakkan di bagian paling bawah file Blade, sebelum @endsection) --}}
    @foreach ($tourismSpots as $spot)
        <div class="modal fade" id="deleteNewsModal{{ $spot->slug }}" tabindex="-1" aria-labelledby="deleteNewsModalLabel{{ $spot->slug }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteNewsModalLabel{{ $spot->slug }}">Konfirmasi Hapus Wisata</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Apakah Anda yakin ingin menghapus wisata "<strong>{{ $spot->slug }}</strong>"?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <form action="{{ route('tourism-spots.destroy', $spot->slug) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection