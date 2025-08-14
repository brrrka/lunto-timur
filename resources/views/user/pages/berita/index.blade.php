@extends('user.layout.app')

@section('content')
<div class="container py-5">
    <h2 class="text-center fw-bold mb-4">Berita Desa</h1>
    <hr class="mb-5">

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        @forelse ($news as $item) {{-- $news adalah koleksi berita dari controller --}}
            <div class="col">
                <div class="card h-100 shadow-sm">
                    @if ($item->thumbnail)
                        {{-- Tampilkan thumbnail berita dari storage --}}
                        <img src="{{ asset('storage/' . $item->thumbnail) }}" class="card-img-top" alt="{{ $item->title }}" style="height: 200px; object-fit: cover;">
                    @else
                        {{-- Tampilkan gambar default jika tidak ada thumbnail --}}
                        <img src="{{ asset('images/default-news.png') }}" class="card-img-top" alt="Gambar Default" style="height: 200px; object-fit: cover;">
                    @endif
                    <div class="card-body d-flex flex-column">
                        <small class="text-muted mb-2">
                            {{-- Tampilkan tanggal publikasi --}}
                            {{ $item->published_at ? \Carbon\Carbon::parse($item->published_at)->locale('id')->translatedFormat('d M Y') : 'Draft' }}
                        </small>
                        <h5 class="card-title fw-bold mt-2 mb-3">{{ $item->title }}</h5>
                        {{-- Tampilkan sebagian kecil konten (maksimal 100 karakter) dan bersihkan tag HTML --}}
                        <p class="card-text flex-grow-1">{{ Str::limit(strip_tags($item->content), 100, '...') }}</p>
                    </div>
                    <div class="card-footer bg-white border-0 d-flex justify-content-end">
                        {{-- Tombol baca selengkapnya, mengarah ke halaman detail berita --}}
                        <a href="{{ route('berita.show', $item->slug) }}" class="btn btn-sm btn-custom-readmore">Baca Selengkapnya</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <p>Belum ada berita terbaru yang tersedia.</p>
            </div>
        @endforelse
    </div>

    {{-- Tampilkan tautan pagination --}}
    @if ($news instanceof \Illuminate\Pagination\LengthAwarePaginator)
        <div class="d-flex justify-content-center mt-5">
            {{ $news->links('vendor.pagination.bootstrap-5') }}
        </div>
    @endif
</div>
@endsection