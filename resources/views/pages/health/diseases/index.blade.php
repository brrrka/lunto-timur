@extends('layout.app')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Data Penyakit</h1>
    <a href="{{ route('diseases.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"><i
    class="fas fa-plus fa-sm text-white-50"></i> Tambah</a>
</div>
<div class="row">
    <div class="col">
        <div class="card shadow">
            <div class="card-body">
                <form action="{{ route('diseases.index') }}" method="GET" class="mb-3">
                    <div class="row g-3 align-items-center">
                        {{-- Kolom Filter Tahun (Dropdown) --}}
                        @if(isset($availableYears) && $availableYears->isNotEmpty())
                        <div class="col-md-4 col-lg-3">
                            <select name="year" class="form-select bg-light border-0 small" onchange="this.form.submit()">
                                <option value="">Semua Tahun</option>
                                @foreach ($availableYears as $year)
                                    <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>
                                        {{ $year }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @endif
                        {{-- Kolom Pencarian --}}
                        <div class="col-md-8 col-lg-6">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control bg-light border-0 small" placeholder="Cari berdasarkan Nama Penyakit..."
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
                    <table class="table table-bordered w-100" cellspacing="0">
                        <thead>
                            <tr>
                                <th style="width: 50px;">No</th>
                                <th>Nama Penyakit</th>
                                <th>Jumlah Kasus</th>
                                <th>Tahun</th>
                                <th style="width: 150px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($diseases as $item)
                                <tr>
                                    <td>{{ $loop->iteration + ($diseases->currentPage() - 1) * $diseases->perPage() }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ number_format($item->case_count) }}</td>
                                    <td>{{ $item->year ?? '-' }}</td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="{{ route('diseases.edit', $item->id) }}" class="btn btn-warning btn-sm me-2">
                                                <i class="fas fa-pen"></i>
                                            </a>
                                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteDiseaseModal{{ $item->id }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4">Belum ada data penyakit yang tersedia.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if ($diseases instanceof \Illuminate\Pagination\LengthAwarePaginator)
                <div class="card-footer">
                    {{ $diseases->appends(request()->query())->links('vendor.pagination.bootstrap-5') }}
                </div>
            @endif
        </div>
        <div class="d-flex justify-content-start mt-4">
            <a href="{{ route('health.index') }}" class="btn btn-outline-secondary me-2">
            <i class="fas fa-arrow-left me-2"></i>Kembali</a>
        </div>
    </div>
    {{-- Modals Konfirmasi Hapus --}}
    @foreach ($diseases as $item)
            <div class="modal fade" id="deleteDiseaseModal{{ $item->id }}" tabindex="-1" aria-labelledby="deleteDiseaseModalLabel{{ $item->id }}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteDiseaseModalLabel{{ $item->id }}">Konfirmasi Hapus</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Apakah Anda yakin ingin menghapus data penyakit "<strong>{{ $item->name }}</strong>"?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <form action="{{ route('diseases.destroy', $item->id) }}" method="POST" style="display: inline;">
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

   
    


   