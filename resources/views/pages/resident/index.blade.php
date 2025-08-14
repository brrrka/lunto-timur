@extends('layout.app')

@section('content')

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Data Penduduk</h1>
        <a href="/resident/create" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"><i
                        class="fas fa-plus fa-sm text-white-50"></i> Tambah</a>
    </div>

    <!-- Table  -->
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-body">
                    <form action="{{ route('pages.resident.index') }}" method="GET" class="mb-3">
                        <div class="row justify-content-end"> 
                            <div class="col-md-8 col-lg-6">  
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control bg-light border-0 small" placeholder="Cari berdasarkan NIK atau Nama..."
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
                                <th>Nama</th>
                                <th>Jenis Kelamin</th>
                                <th>Tempat, Tanggal Lahir</th>
                                <th>Alamat</th>
                                <th>Agama</th>
                                <th>Status Perkawinan</th>
                                <th>Pekerjaan</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        @if ($residents->isEmpty())
                        <tbody>
                            <tr>
                                <td colspan="12">
                                    <p class="pt-3 text-center">Tidak ada data</p>
                                </td>
                            </tr>
                        </tbody>
                        @else
                        <tbody>
                            @foreach ($residents as $item)
                                <tr>
                                    <td>{{ $loop->iteration + ($residents->currentPage() - 1) * $residents->perPage() }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->gender }}</td>
                                    <td>{{ $item->birth_place }}, {{ $item->birth_date }}</td>
                                    <td>{{ $item->address }}</td>
                                    <td>{{ $item->religion }}</td>
                                    <td>{{ $item->marital_status }}</td>
                                    <td>{{ $item->occupation }}</td>
                                    <td>{{ $item->status }}</td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="{{ route('resident.edit', $item->id) }}" class="d-inline-block me-2 btn-sm btn-warning">
                                                <i class="fas fa-pen"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-danger me-2" data-bs-toggle="modal" data-bs-target="#confirmationDelete-{{ $item->id }}">
                                                <i class="fas fa-eraser"></i> 
                                            </button>
                                            <button type="button" class="btn btn-sm btn-success me-2" data-bs-toggle="modal" data-bs-target="#accountDetail-{{ $item->id }}">
                                                <i class="fas fa-search"></i> 
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @include('pages.resident.confirmation-delete')
                                @include('pages.resident.detail-account')
                            @endforeach
                        </tbody>
                        @endif
                    </table>
                </div>
                {{-- Pagination Navigation --}}
                <div class="card-footer">
                    {{ $residents->links('vendor.pagination.bootstrap-5') }}
                </div>
            </div>

        </div>

    </div>
@endsection