@extends('user.layout.app')

@section('content')
    <section class="py-5">
        <div class="container">
            <h2 class="text-center fw-bold mb-5">Seluruh Perangkat Desa</h2>
        </div>
        <div class="container">
            <div class="row row-cols-2 row-cols-lg-4 g-4 justify-content-center">
                {{-- Loop untuk menampilkan daftar Pengurus dari Database --}}
                @forelse ($officials as $official) {{-- Gunakan $officials yang diteruskan dari controller --}}
                    <div class="col">
                        <div class="card h-100 text-center shadow-sm">
                            @if ($official->photo)
                                {{-- Foto dari storage/app/public --}}
                                <img src="{{ asset('storage/' . $official->photo) }}" class="card-img-top mx-auto mt-3 rounded-circle" alt="Foto {{ $official->name }}" style="width: 150px; height: 150px; object-fit: cover;">
                            @else
                                {{-- Gambar placeholder jika tidak ada foto --}}
                                <img src="{{ asset('images/default-profile.png') }}" class="card-img-top mx-auto mt-3 rounded-circle" alt="Foto Default" style="width: 150px; height: 150px; object-fit: cover;">
                            @endif
                            <div class="card-body d-flex flex-column justify-content-between">
                                <div>
                                    <h5 class="card-title fw-bold mb-1">{{ $official->name }}</h5>
                                    <p class="card-text text-muted mb-2">{{ $official->position }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-4">
                        <p class="text-muted">Data perangkat Desa belum tersedia.</p>
                    </div>
                @endforelse
            </div>
            <div class="text-center mt-4">
                <a href="profil-nagari" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i> Kembali
                </a>
            </div>
        </div>
    </section>
@endsection