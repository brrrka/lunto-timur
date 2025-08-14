@extends('layout.app')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Manajemen UMKM Nagari</h1>
        <a href="{{ route('umkms.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"><i
        class="fas fa-plus fa-sm text-white-50"></i> Tambah</a>
    </div>

    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-body">
                    <form action="{{ route('umkms.index') }}" method="GET" class="mb-3">
                        <div class="row justify-content-end"> 
                            <div class="col-md-8 col-lg-6">  
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control bg-light border-0 small" placeholder="Cari berdasarkan Nama Usaha, Nama Pemilik, atau NIK"
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
                    <table class="table table-responsive table-bordered w-100"> 
                        <thead>
                            <tr>
                                <th style="width: 50px;">No</th>
                                <th>Nama Usaha</th>
                                <th>Pemilik</th>
                                <th style="min-width: 150px;">Alamat</th>
                                <th>No HP</th>
                                <th style="width: 80px;">Foto</th>
                                <th style="width: 150px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($umkms as $item)
                                <tr>
                                    <td>{{ $loop->iteration + ($umkms->currentPage() - 1) * $umkms->perPage() }}</td>
                                    <td>{{ $item->nama_usaha }}</td>
                                    <td>{{ $item->nama_pemilik }}</td>
                                    <td>{{ Str::limit($item->alamat_usaha, 50, '...') ?? '-' }}</td> {{-- Gunakan Str::limit jika alamat panjang --}}
                                    <td>{{ $item->no_hp_usaha ?? '-' }}</td>
                                    <td>
                                        @if ($item->photo)
                                            <img src="{{ asset('storage/' . $item->photo) }}" alt="{{ $item->nama_usaha }}" class="img-thumbnail" style="width: 80px; height: 80px; object-fit: cover;">
                                        @else
                                            <span class="text-muted">Tidak ada</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="{{ route('umkms.edit', $item->slug) }}" class="btn btn-warning btn-sm me-2"> {{-- Pastikan rute edit benar --}}
                                                <i class="fas fa-pen"></i>
                                            </a>
                                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteUmkmModal{{ $item->id }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-4">Belum ada data UMKM yang tersedia.</td> {{-- Sesuaikan colspan --}}
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{-- Pagination Navigation --}}
                @if ($umkms instanceof \Illuminate\Pagination\LengthAwarePaginator)
                    <div class="card-footer">
                        {{ $umkms->appends(request()->query())->links('vendor.pagination.bootstrap-5') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
    {{-- Modals Konfirmasi Hapus --}}
    @foreach ($umkms as $item)
        <div class="modal fade" id="deleteUmkmModal{{ $item->id }}" tabindex="-1" aria-labelledby="deleteUmkmModalLabel{{ $item->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteUmkmModalLabel{{ $item->id }}">Konfirmasi Hapus</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Apakah Anda yakin ingin menghapus data UMKM "<strong>{{ $item->nama_usaha }}</strong>" milik "<strong>{{ $item->nama_pemilik }}</strong>"?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <form action="{{ route('umkms.destroy', $item->slug) }}" method="POST" style="display: inline;">
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
