@extends('user.layout.app')

@section('content')
<div class="container py-5">
<h2 class="text-center fw-bold mb-4">Tempat Wisata Desa</h1>
    <hr class="mb-5">

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        @forelse ($tourismSpots as $spot)
            <div class="col">
                <div class="card h-100 shadow-sm border-0">
                    @if ($spot->thumbnail)
                        <img src="{{ asset('storage/' . $spot->thumbnail) }}" class="card-img-top rounded-top" alt="{{ $spot->name }}" style="height: 200px; object-fit: cover;">
                    @else
                        <img src="{{ asset('images/default-tourism.png') }}" class="card-img-top rounded-top" alt="Gambar Default" style="height: 200px; object-fit: cover;">
                    @endif
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title fw-bold mt-2 mb-3">{{ $spot->name }}</h5>
                        <p class="card-text text-muted small mb-2"><i class="fa-solid fa-map-marker-alt me-1"></i> {{ Str::limit($spot->address, 50, '...') ?? 'Alamat tidak tersedia' }}</p>
                        <p class="card-text flex-grow-1">{{ Str::limit(strip_tags($spot->description), 100, '...') }}</p>
                    </div>
                    <div class="card-footer bg-white border-0 d-flex justify-content-end">
                        <a href="{{ route('wisata.show', $spot->slug) }}" class="btn btn-sm btn-custom-readmore">Lihat Detail</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <p>Belum ada tempat wisata yang tersedia.</p>
            </div>
        @endforelse
    </div>

    {{-- Tampilkan tautan pagination --}}
    @if ($tourismSpots instanceof \Illuminate\Pagination\LengthAwarePaginator)
        <div class="d-flex justify-content-center mt-5">
            {{ $tourismSpots->links('vendor.pagination.bootstrap-5') }}
        </div>
    @endif
</div>
@endsection