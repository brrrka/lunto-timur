@extends('layout.app')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Manajemen Dokumen Desa</h1>
    <a href="{{ route('documents.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"><i
    class="fas fa-plus fa-sm text-white-50"></i> Tambah</a>
</div>
<div class="row">
    <div class="col">
        <div class="card shadow">
            <div class="card-body">
                <form action="{{ route('documents.index') }}" method="GET" class="mb-3">
                    <div class="row justify-content-end"> 
                        <div class="col-md-8 col-lg-6"> 
                            <div class="input-group">
                                <input type="text" name="search" class="form-control bg-light border-0 small" placeholder="Cari berdasarkan Judul atau Deskripsi..."
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
                                <th>Judul</th>
                                <th>Deskripsi</th>
                                <th>Tipe File</th>
                                <th>Ukuran File</th>
                                <th>Tanggal Publikasi</th>
                                <th style="width: 150px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($documents as $item)
                                <tr>
                                    <td>{{ $loop->iteration + ($documents->currentPage() - 1) * $documents->perPage() }}</td>
                                    <td>{{ $item->title }}</td>
                                    <td>{{ Str::limit($item->description, 70, '...') ?? '-' }}</td>
                                    <td>{{ $item->file_type ?? '-' }}</td>
                                    <td>{{ $item->file_size ?? '-' }}</td>
                                    <td>{{ $item->published_date ? \Carbon\Carbon::parse($item->published_date)->locale('id')->translatedFormat('d M Y') : '-' }}</td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="{{ route('documents.edit', $item->slug) }}" class="btn btn-warning btn-sm me-2">
                                                <i class="fas fa-pen"></i>
                                            </a>
                                            <button type="button" class="btn btn-danger btn-sm me-2" data-bs-toggle="modal" data-bs-target="#deleteDocumentModal{{ $item->id }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                            <a href="{{ asset('storage/' . $item->file_path) }}" class="btn btn-success btn-sm me-2">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4">Belum ada dokumen yang tersedia.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
                {{-- Pagination Navigation --}}
            @if ($documents instanceof \Illuminate\Pagination\LengthAwarePaginator)
                <div class="card-footer">
                    {{ $documents->appends(request()->query())->links('vendor.pagination.bootstrap-5') }}
                </div>
            @endif
        </div>
        <div class="d-flex justify-content-start mt-4">
            <a href="{{ route('documents.index') }}" class="btn btn-outline-secondary me-2">
            <i class="fas fa-arrow-left me-2"></i>Kembali</a>
        </div>
    </div>
    {{-- Modals Konfirmasi Hapus --}}
    @foreach ($documents as $item)
        <div class="modal fade" id="deleteDocumentModal{{ $item->id }}" tabindex="-1" aria-labelledby="deleteDocumentModalLabel{{ $item->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteDocumentModalLabel{{ $item->id }}">Konfirmasi Hapus Dokumen</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Apakah Anda yakin ingin menghapus dokumen "<strong>{{ $item->title }}</strong>"?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <form action="{{ route('documents.destroy', $item->slug) }}" method="POST" style="display: inline;">
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