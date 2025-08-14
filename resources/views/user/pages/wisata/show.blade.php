@extends('user.layout.app')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8 mb-4 mb-lg-0">
            <div class="card shadow-sm h-100">
                <div class="card-body p-4">
                    <h1 class="fw-bold mb-3">{{ $tourismSpot->name }}</h1>
                    <p class="text-muted small mb-4">
                        <i class="fa-solid fa-map-marker-alt me-1"></i> {{ $tourismSpot->address ?? 'Alamat tidak tersedia' }}
                        @if ($tourismSpot->latitude && $tourismSpot->longitude)
                        <a href="https://maps.google.com/?q={{ $tourismSpot->latitude }},{{ $tourismSpot->longitude }}" target="_blank" class="btn btn-sm btn-custom-readmore ms-2">
                            <i class="fa-solid fa-location-arrow"></i> Lihat di Peta
                        </a>
                        @endif
                    </p>

                    @if ($tourismSpot->thumbnail)
                        <img src="{{ asset('storage/' . $tourismSpot->thumbnail) }}" class="img-fluid rounded mb-4" alt="{{ $tourismSpot->name }}" style="max-height: 500px; object-fit: cover; width: 100%;">
                    @else
                        <img src="{{ asset('images/default-tourism-large.png') }}" class="img-fluid rounded mb-4" alt="Gambar Default" style="max-height: 500px; object-fit: cover; width: 100%;">
                    @endif

                    @if ($tourismSpot->video_url)
                        <h5 class="mt-4 mb-3 text-center">Video Profile {{ $tourismSpot->name }}</h5>
                        <div class="ratio ratio-16x9 mb-4">
                            @php
                                // Memastikan URL adalah embedable YouTube atau Vimeo
                                $videoId = '';
                                $embedUrl = null;
                                if (Str::contains($tourismSpot->video_url, ['youtube.com/watch', 'youtu.be/'])) {
                                    if (Str::contains($tourismSpot->video_url, 'youtube.com/watch')) {
                                        parse_str(parse_url($tourismSpot->video_url, PHP_URL_QUERY), $vars);
                                        $videoId = $vars['v'] ?? '';
                                    } elseif (Str::contains($tourismSpot->video_url, 'youtu.be/')) {
                                        $videoId = Str::afterLast($tourismSpot->video_url, '/');
                                    }
                                    if (!empty($videoId)) {
                                        $embedUrl = "https://www.youtube.com/embed/" . $videoId;
                                    }
                                } elseif (Str::contains($tourismSpot->video_url, 'vimeo.com/')) {
                                    $videoId = Str::afterLast($tourismSpot->video_url, '/');
                                    $embedUrl = "https://player.vimeo.com/video/" . $videoId;
                                }
                            @endphp
                            @if ($embedUrl)
                                <iframe src="{{ $embedUrl }}" title="Video Player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            @else
                                <p class="text-muted">Link video tidak didukung atau tidak valid.</p>
                            @endif
                        </div>
                    @endif

                    <div class="lead blog-content">
                        {!! nl2br(e($tourismSpot->description)) !!}
                    </div>

                    <hr class="my-5">
                    <a href="{{ route('wisata.index') }}" class="btn btn-outline-secondary"><i class="fa-solid fa-arrow-left me-2"></i> Kembali</a>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm p-4">
                <h5 class="fw-bold mb-4">Wisata Lainnya</h5>
                <div class="list-group list-group-flush">
                    {{-- Loop untuk menampilkan wisata lainnya --}}
                    @forelse ($otherTourismSpots as $otherSpot) {{-- Pastikan Anda melewatkan $otherTourismSpots dari controller --}}
                        <a href="{{ route('wisata.show', $otherSpot->slug) }}" class="list-group-item list-group-item-action d-flex align-items-center mb-2 rounded">
                            @if ($otherSpot->thumbnail)
                                <img src="{{ asset('storage/' . $otherSpot->thumbnail) }}" alt="{{ $otherSpot->name }}" class="img-fluid rounded me-3" style="width: 60px; height: 40px; object-fit: cover;">
                            @else
                                <img src="{{ asset('images/default-tourism-small.png') }}" alt="Gambar Default" class="img-fluid rounded me-3" style="width: 60px; height: 40px; object-fit: cover;">
                            @endif
                            <div>
                                <h6 class="mb-0 fw-semibold">{{ $otherSpot->name }}</h6>
                                <small class="text-muted"><i class="fa-solid fa-map-marker-alt me-1"></i> {{ $otherSpot->address ?? 'Lokasi' }}</small>
                            </div>
                        </a>
                    @empty
                        <p class="text-muted">Tidak ada wisata lainnya.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection