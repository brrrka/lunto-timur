@extends('user.layout.app')

@section('content')
<div class="container py-5">

    {{-- SECTION: Fasilitas Layanan Kesehatan (Card View) --}}
    <h2 class="text-center fw-bold mb-4">Fasilitas Layanan Kesehatan</h2>
    <p class="text-center text-muted mb-5">Daftar fasilitas kesehatan yang tersedia di Desa Lunto Timur.</p>

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 mb-5">
        @forelse ($healthFacilities as $facility)
            <div class="col">
                <div class="card h-100 shadow-sm border-0">
                    @if ($facility->photo)
                        <img src="{{ asset('storage/' . $facility->photo) }}" class="card-img-top rounded-top" alt="{{ $facility->name }}" style="height: 200px; object-fit: cover;">
                    @else
                        <img src="{{ asset('images/default-health-facility.png') }}" class="card-img-top rounded-top" alt="Gambar Default" style="height: 200px; object-fit: cover;">
                    @endif
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title fw-bold mb-2">{{ $facility->name }}</h5>
                        <p class="card-text text-muted small mb-1">
                            <i class="fa-solid fa-map-marker-alt me-1"></i> Alamat: {{ Str::limit($facility->address, 50, '...') ?? '-' }}
                        </p>
                        <p class="card-text small mb-2">
                            <i class="fa-solid fa-phone me-1"></i> Telp: {{ $facility->phone_number ?? '-' }}
                        </p>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <p>Belum ada data fasilitas kesehatan yang tersedia.</p>
            </div>
        @endforelse
    </div>
    @if ($healthFacilities instanceof \Illuminate\Pagination\LengthAwarePaginator)
        {{ $healthFacilities->appends(request()->query())->links('vendor.pagination.bootstrap-5') }}
    @endif

    <hr class="my-5">

    {{-- SECTION: Data Penyakit (Table View) --}}
    <h2 class="text-center fw-bold mb-4">Data Penyakit</h2>
    <p class="text-center text-muted mb-5">Beberapa jumlah kasus penyakit yang ada di Nagari Guguak Malalo.</p>

    {{-- Tabel Data Penyakit --}}
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold">Daftar Penyakit</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('user.pages.kesehatan.index') }}" method="GET" class="mb-3"> {{-- Arahkan ke rute halaman ini sendiri --}}
                <div class="row g-3 align-items-center">
                    {{-- Kolom Filter Tahun (Dropdown) --}}
                    @if(isset($availableYearsDiseases) && $availableYearsDiseases->isNotEmpty())
                    <div class="col-md-4 col-lg-3">
                        <select name="year" class="form-select bg-light border-0 small" onchange="this.form.submit()">
                            <option value="">Semua Tahun</option>
                            @foreach ($availableYearsDiseases as $year)
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
                <table class="table table-bordered table-hover w-100" cellspacing="0">
                    <thead>
                        <tr>
                            <th style="width: 50px;">No</th>
                            <th>Nama Penyakit</th>
                            <th>Jumlah Kasus</th>
                            <th>Tahun</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($diseases as $item)
                            <tr>
                                <td>{{ $loop->iteration + ($diseases->currentPage() - 1) * $diseases->perPage() }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ number_format($item->case_count) }}</td>
                                <td>{{ $item->year ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-4">Belum ada data penyakit yang tersedia.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination Navigation --}}
            @if ($diseases instanceof \Illuminate\Pagination\LengthAwarePaginator)
            <div class="d-flex justify-content-center mt-5">
                {{ $diseases->appends(request()->query())->links('vendor.pagination.bootstrap-5') }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection