@extends('user.layout.app')

@section('content')
<div class="container py-5">
    {{-- SECTION: Kontak Hukum (Polsek & Babinsa) --}}
    <h2 class="text-center fw-bold mb-4">Kontak Aparat Hukum</h2>
    <p class="text-center text-muted mb-5">Hubungi pihak berwenang untuk bantuan hukum atau keamanan</p>

    <div class="row row-cols-1 row-cols-md-2 g-4 justify-content-center mb-5">
        @if ($legalContact)
            <div class="col">
                <div class="card h-100 shadow-sm border-0 text-center">
                    <div class="card-body p-4">
                        <i class="fa-solid fa-building-columns fa-4x text-success mb-3"></i>
                        <h5 class="card-title fw-bold mb-2">Polsek Setempat</h5>
                        <p class="card-text mb-1">
                            <strong>{{ $legalContact->contact_polsek_name ?? 'Nama Tidak Tersedia' }}</strong>
                        </p>
                        <p class="card-text mb-0">
                            <i class="fa-solid fa-phone me-1"></i> {{ $legalContact->contact_polsek_phone ?? '-' }}
                        </p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card h-100 shadow-sm border-0 text-center">
                    <div class="card-body p-4">
                        <i class="fa-solid fa-shield-halved fa-4x text-success mb-3"></i>
                        <h5 class="card-title fw-bold mb-2">Babinsa Nagari</h5>
                        <p class="card-text mb-1">
                            <strong>{{ $legalContact->contact_babinsa_name ?? 'Nama Tidak Tersedia' }}</strong>
                        </p>
                        <p class="card-text mb-0">
                            <i class="fa-solid fa-phone me-1"></i> {{ $legalContact->contact_babinsa_phone ?? '-' }}
                        </p>
                    </div>
                </div>
            </div>
        @else
            <div class="col-12 text-center py-4">
                <p class="text-muted">Data kontak hukum belum tersedia.</p>
            </div>
        @endif
    </div>

    <hr class="my-5">

    {{-- SECTION: Dokumen Nagari (Table View) --}}
    <h2 class="text-center fw-bold mb-4">Dokumen Desa</h2>

    {{-- Tabel Dokumen --}}
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered w-100" cellspacing="0">
                    <thead>
                        <tr>
                            <th style="width: 50px;">No</th>
                            <th>Judul Dokumen</th>
                            <th>Deskripsi</th>
                            <th>Tipe File</th>
                            <th>Ukuran File</th>
                            <th>Tanggal Publikasi</th>
                            <th style="width: 100px;">Aksi</th>
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
                                        {{-- Tombol Download --}}
                                        <a href="{{ route('hukum.download', $item->slug) }}" class="btn btn-sm btn-success me-2" title="Download Dokumen">
                                            <i class="fas fa-download"></i>
                                        </a>
                                        {{-- Tombol Lihat/Preview (opsional) --}}
                                        <a href="{{ route('user.pages.hukum.show', $item->slug) }}" class="btn btn-sm btn-info" title="Lihat Detail">
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

            {{-- Pagination Navigation --}}
            @if ($documents instanceof \Illuminate\Pagination\LengthAwarePaginator)
                <div class="d-flex justify-content-center mt-5">
                    {{ $documents->appends(request()->query())->links('vendor.pagination.bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection