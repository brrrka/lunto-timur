@extends('user.layout.app')

@section('content')
<div class="container py-5">
    <h2 class="text-center fw-bold mb-4">Data Kelembagaan Tani</h2>
    <p class="text-center lead mb-5 mx-auto" style="max-width: 800px;">
        Berikut adalah daftar kelembagaan tani yang aktif di Desa Lunto Timur, berperan penting dalam memajukan sektor pertanian.
    </p>

    {{-- Tabel Data Kelembagaan Tani --}}
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold">Daftar Kelembagaan Tani</h6>
        </div>

        <div class="card-body">
            <form action="{{ route('user.pages.pertanian.kelembagaan-tani') }}" method="GET" class="mb-3">
                <div class="row g-3 align-items-center justify-content-end">
                    {{-- Kolom Pencarian --}}
                    <div class="col-md-8 col-lg-6 justify">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control bg-light border-0 small" placeholder="Cari berdasarkan Nama Kelompok atau Jenis..."
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
                <table class="table table-bordered table-hover w-100" cellspacing="0">
                    <thead>
                        <tr>
                            <th style="width: 50px;">No</th>
                            <th>Nama Poktan</th>   
                            <th>Kelas Kemampuan</th> 
                            <th>Jumlah Anggota</th>
                            <th>Nama Ketua</th>     
                            <th>No HP</th>          
                            <th>Alamat Sekretariat</th> 
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($kelembagaanTani as $item)
                            <tr>
                                <td>{{ $loop->iteration + ($kelembagaanTani->currentPage() - 1) * $kelembagaanTani->perPage() }}</td>
                                <td>{{ $item->nama_poktan }}</td>    
                                <td>{{ $item->kelas_kemampuan }}</td> 
                                <td>{{ number_format($item->jumlah_anggota) }}</td>
                                <td>{{ $item->nama_ketua ?? '-' }}</td>
                                <td>{{ $item->no_hp ?? '-' }}</td>
                                <td>{{ Str::limit($item->alamat_sekretariat, 50, '...') ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">Belum ada data kelembagaan tani yang tersedia.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
            {{-- Pagination Navigation --}}
            @if ($kelembagaanTani instanceof \Illuminate\Pagination\LengthAwarePaginator)
                <div class="card-footer">
                    {{ $kelembagaanTani->appends(request()->query())->links('vendor.pagination.bootstrap-5') }}
                </div>
            @endif
    </div>

    {{-- Tombol Kembali ke Halaman Pertanian Utama --}}
    <div class="mt-4">
        <a href="{{ route('user.pages.pertanian.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i> Kembali
        </a>
    </div>
</div>
@endsection