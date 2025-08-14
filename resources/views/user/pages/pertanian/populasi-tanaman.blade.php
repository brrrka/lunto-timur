@extends('user.layout.app')

@section('content')
<div class="container py-5">
    <h2 class="text-center fw-bold mb-4">Data Populasi Tanaman</h2>
    <p class="text-center lead mb-5 mx-auto" style="max-width: 800px;">
        Informasi mengenai populasi tanaman (buah-buahan dan perkebunan) di berbagai wilayah Desa Lunto Timur setiap tahunnya.
    </p>

    {{-- Form Pencarian dan Filter --}}
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold">Cari & Filter Data Populasi Tanaman</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('user.pages.pertanian.populasi-tanaman') }}" method="GET" class="mb-3">
                <div class="row g-3 align-items-center">
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
                    <div class="col-md-8 col-lg-6">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control bg-light border-0 small" placeholder="Cari berdasarkan Komoditi atau Tipe Tanaman..."
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

    {{-- Tampilan Card untuk Populasi Tanaman --}}
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4"> {{-- Grid untuk card --}}
        @forelse ($populasiTanaman as $item)
            <div class="col">
                <div class="card h-100 shadow-sm border-0">
                    @if ($item->image)
                        <img src="{{ asset('storage/' . $item->image) }}" class="card-img-top rounded-top" alt="{{ $item->nama_komoditi }}" style="height: 200px; object-fit: cover;">
                    @else
                        <img src="{{ asset('images/default-tanaman.png') }}" class="card-img-top rounded-top" alt="Gambar Default" style="height: 200px; object-fit: cover;">
                    @endif
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title fw-bold mb-2">{{ $item->nama_komoditi }}</h5>
                        <p class="card-text text-muted small mb-1">
                            <i class="fa-solid fa-tree me-1"></i> Tipe Tanaman: {{ $item->tipe_tanaman }}
                        </p>
                        <p class="card-text small mb-1">
                            <i class="fa-solid fa-industry"></i> Jumlah Panen: {{ number_format($item->jumlah_panen) }}
                        </p>
                        <p class="card-text small text-muted mt-2">
                            <i class="fa-solid fa-calendar-alt me-1"></i> Tahun: {{ $item->tahun ?? '-' }}
                        </p>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <p>Belum ada data populasi tanaman yang tersedia.</p>
            </div>
        @endforelse
    </div>

    {{-- Pagination Navigation --}}
    @if ($populasiTanaman instanceof \Illuminate\Pagination\LengthAwarePaginator)
        <div class="mt-5">
            {{ $populasiTanaman->appends(request()->query())->links('vendor.pagination.bootstrap-5') }}
        </div>
    @endif

    {{-- Tombol Kembali ke Halaman Pertanian Utama --}}
    <div class="mt-4">
        <a href="{{ route('user.pages.pertanian.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i> Kembali
        </a>
    </div>
</div>
@endsection