@extends('user.layout.app') 

@section('content')
<div class="container py-5">
    <div class="row"> {{-- Row utama untuk membagi 2 kolom --}}
        {{-- Card Kiri: Berita yang Dibaca Saat Ini --}}
        <div class="col-lg-8 mb-4">
            <div class="card shadow-sm h-100"> {{-- Bungkus konten utama dalam card --}}
                <div class="card-body p-4">
                    <h1 class="fw-bold mb-3">{{ $newsItem->title }}</h1>
                    <p class="text-muted small mb-4">
                        Dipublikasikan pada {{ $newsItem->published_at ? \Carbon\Carbon::parse($newsItem->published_at)->locale('id')->translatedFormat('d M Y') : 'Tanggal Tidak Diketahui' }}
                        oleh {{ $newsItem->user->name ?? 'Admin' }}
                    </p>

                    @if ($newsItem->thumbnail)
                        <img src="{{ asset('storage/' . $newsItem->thumbnail) }}" class="img-fluid rounded mb-4" alt="{{ $newsItem->title }}">
                    @else
                        <img src="{{ asset('images/default-news-large.png') }}" class="img-fluid rounded mb-4" alt="Gambar Default">
                    @endif

                    <div class="lead blog-content">
                        {!! $newsItem->content !!}
                    </div>

                    <hr class="my-5">
                    <a href="{{ route('berita.index') }}" class="btn btn-outline-secondary"><i class="fa-solid fa-arrow-left me-2"></i> Kembali</a>
                </div>
            </div>
        </div>

        {{-- Card Kanan: Berita Lainnya (6 Terbaru) --}}
        <div class="col-lg-4 mb-4">
            <div class="card shadow-sm h-100"> {{-- Bungkus konten berita lainnya dalam card --}}
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4">Berita Lainnya</h5>
                    <ul class="list-unstyled">
                        @forelse ($relatedNews as $relatedItem)
                            <li class="mb-3 border-bottom pb-3">
                                @if ($relatedItem->thumbnail)
                                    <img src="{{ asset('storage/' . $relatedItem->thumbnail) }}" alt="{{ $relatedItem->title }}" class="img-fluid rounded mb-2" style="max-height: 80px; object-fit: cover;">
                                @else
                                    <img src="{{ asset('images/default-news.png') }}" alt="Gambar Default" class="img-fluid rounded mb-2" style="max-height: 80px; object-fit: cover;">
                                @endif
                                <h6 class="fw-bold mt-1 mb-1">
                                    <a href="{{ route('berita.show', $relatedItem->slug) }}" class="text-decoration-none text-dark">{{ $relatedItem->title }}</a>
                                </h6>
                                <small class="text-muted">
                                    {{ $relatedItem->published_at ? \Carbon\Carbon::parse($relatedItem->published_at)->locale('id')->translatedFormat('d M Y') : 'Draft' }}
                                </small>
                            </li>
                        @empty
                            <li><p class="text-muted">Tidak ada berita terkait lainnya.</p></li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection