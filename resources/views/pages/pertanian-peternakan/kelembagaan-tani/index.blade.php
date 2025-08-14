@extends('layout.app') 

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Data Kelembagaan Tani</h1>
    <a href="{{ route('kelembagaan-tani.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"><i
                    class="fas fa-plus fa-sm text-white-50"></i> Tambah</a>
</div>

<!-- Table  -->
<div class="row">
    <div class="col">
        <div class="card shadow">
            <div class="card-body">
                <form action="{{ route('kelembagaan-tani.index') }}" method="GET" class="mb-3">
                    <div class="row justify-content-end"> 
                        <div class="col-md-8 col-lg-6"> 
                            <div class="input-group">
                                <input type="text" name="search" class="form-control bg-light border-0 small" placeholder="Cari berdasarkan Nama Poktan, Id Poktan, atau Nama Ketua..."
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
                <table class="table table-responsive table-bordered table-hovered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Poktan</th>
                            <th>Kelas Kemampuan</th>
                            <th>ID Poktan</th>
                            <th>Jumlah Anggota</th>
                            <th>Nama Ketua</th>
                            <th>No HP</th>
                            <th>Alamat Sekretariat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($kelembagaanTani as $item)
                            <tr>
                                <td>{{ $loop->iteration + ($kelembagaanTani->currentPage() - 1) * $kelembagaanTani->perPage() }}</td>
                                <td>{{ $item->nama_poktan }}</td>
                                <td>{{ $item->kelas_kemampuan }}</td>
                                <td>{{ $item->id_poktan ?? '-' }}</td>
                                <td>{{ number_format($item->jumlah_anggota) }}</td>
                                <td>{{ $item->nama_ketua }}</td>
                                <td>{{ $item->no_hp ?? '-' }}</td>
                                <td>{{ Str::limit($item->alamat_sekretariat, 50, '...') ?? '-' }}</td>
                                <td>
                                    <div class="d-flex">
                                        <a href="{{ route('kelembagaan-tani.edit', $item->id) }}" class="btn btn-warning btn-sm me-2">
                                            <i class="fas fa-pen"></i>
                                        </a>
                                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteKelembagaanTaniModal{{ $item->id }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="text-center py-4">Belum ada data kelembagaan tani yang tersedia.</td>
                            </tr>
                            @endforelse
                    </tbody>
                </table>
            </div>
            {{-- Pagination Navigation --}}
            @if ($kelembagaanTani instanceof \Illuminate\Pagination\LengthAwarePaginator)
                <div class="card-footer">
                    {{ $kelembagaanTani->appends(request()->query())->links('vendor.pagination.bootstrap-5') }}
                </div>
            @endif
        </div>
        <div class="d-flex justify-content-start mt-4">
            <a href="{{ route('pertanian-peternakan.index') }}" class="btn btn-outline-secondary me-2">
            <i class="fas fa-arrow-left me-2"></i>Kembali</a>
        </div>
    </div>
</div>

    {{-- Modals Konfirmasi Hapus --}}
    @foreach ($kelembagaanTani as $item)
        <div class="modal fade" id="deleteKelembagaanTaniModal{{ $item->id }}" tabindex="-1" aria-labelledby="deleteKelembagaanTaniModalLabel{{ $item->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteKelembagaanTaniModalLabel{{ $item->id }}">Konfirmasi Hapus</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Apakah Anda yakin ingin menghapus data kelembagaan tani "<strong>{{ $item->nama_poktan }}</strong>"?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <form action="{{ route('kelembagaan-tani.destroy', $item->id) }}" method="POST" style="display: inline;">
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