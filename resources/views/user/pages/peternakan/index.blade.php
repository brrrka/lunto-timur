@extends('user.layout.app')

@section('content')
<div class="container py-5">
    <h2 class="text-center fw-bold mb-4">Data Populasi Ternak</h2>
    <p class="text-center lead mb-5 mx-auto" style="max-width: 800px;">
        Informasi mengenai populasi hewan ternak di berbagai wilayah Desa Lunto Timur setiap tahunnya.
    </p>

    {{-- Form Pencarian dan Filter --}}
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold">Cari & Filter Data Populasi Ternak</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('user.pages.peternakan.index') }}" method="GET" class="mb-3">
                <div class="row g-3 align-items-center">
                    {{-- Kolom Filter Tahun (Dropdown) --}}
                    @if(isset($availableYears) && $availableYears->isNotEmpty())
                    <div class="col-md-4 col-lg-3">
                        <select name="tahun" class="form-select bg-light border-0 small" onchange="this.form.submit()">
                            <option value="">Semua Tahun</option>
                            @foreach ($availableYears as $year)
                                <option value="{{ $year }}" {{ request('tahun') == $year ? 'selected' : '' }}>
                                    {{ $year }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @endif

                    {{-- Kolom Pencarian --}}
                    <div class="col-md-8 col-lg-6">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control bg-light border-0 small" placeholder="Cari berdasarkan Jenis Ternak..."
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
        </div>
    </div>

    {{-- Tampilan Card untuk Populasi Ternak --}}
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        @forelse ($populasiTernak as $item)
            <div class="col">
                <div class="card h-100 shadow-sm border-0">
                    @if ($item->image)
                        <img src="{{ asset('storage/' . $item->image) }}" class="card-img-top rounded-top" alt="{{ $item->jenis_ternak }}" style="height: 200px; object-fit: cover;">
                    @else
                        <img src="{{ asset('images/default-ternak.png') }}" class="card-img-top rounded-top" alt="Gambar Default" style="height: 200px; object-fit: cover;">
                    @endif
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title fw-bold mb-2">{{ $item->jenis_ternak }}</h5>
                        <p class="card-text small mb-1">
                            <i class="fa-solid fa-person me-1"></i><strong>Peternak:</strong> {{ $item->nama_peternak }}
                        </p>
                        <p class="card-text small mb-1">
                            <strong>Jumlah Ternak:</strong> {{ $item->jumlah_ternak }}
                        </p>
                        <p class="card-text small text-muted mt-auto">
                            <i class="fa-solid fa-calendar-alt me-1"></i> Tahun: {{ $item->tahun ?? '-' }}
                        </p>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <p>Belum ada data populasi ternak yang tersedia.</p>
            </div>
        @endforelse
    </div>

    {{-- Pagination Navigation --}}
    @if ($populasiTernak instanceof \Illuminate\Pagination\LengthAwarePaginator)
        <div class="d-flex justify-content-center mt-5">
            {{ $populasiTernak->appends(request()->query())->links('vendor.pagination.bootstrap-5') }}
        </div>
    @endif
</div>
@endsection
