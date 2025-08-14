@extends('user.layout.app')

@section('content')
<div class="container py-5">
    <h2 class="text-center fw-bold mb-4">Potensi Pertanian Desa</h2>
    <p class="text-center lead mb-5 mx-auto" style="max-width: 800px;">
        Desa Lunto Timur memiliki lahan subur dan sumber daya alam melimpah yang menopang sektor pertanian sebagai salah satu pilar ekonomi utama. Berbagai komoditi unggulan dihasilkan melalui praktik pertanian berkelanjutan oleh para petani.
    </p>

    <hr class="my-5">

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 justify-content-center">
        {{-- Card Kelembagaan Tani --}}
        <div class="col">
            <div class="card shadow-sm h-100 d-flex flex-column justify-content-center text-center">
                <div class="card-body p-4">
                    <i class="fa-solid fa-seedling fa-4x text-success mb-3"></i>
                    <h3 class="card-title display-5 fw-bold text-success">{{ number_format($totalKelembagaanTani) }}</h3>
                    <p class="card-text fs-5">Kelembagaan Tani</p>
                    <a href="{{ route('user.pages.pertanian.kelembagaan-tani') }}" class="btn btn-sm btn-custom-readmore mt-3">Lihat Detail</a> {{-- Arahkan ke halaman detail jika ada --}}
                </div>
            </div>
        </div>

        {{-- Card Luas Area Produksi --}}
        <div class="col">
            <div class="card shadow-sm h-100 d-flex flex-column justify-content-center text-center">
                <div class="card-body p-4">
                    <i class="fa-solid fa-chart-area fa-4x text-success mb-3"></i>
                    <h3 class="card-title display-5 fw-bold text-success">{{ number_format($totalLuasAreaProduksi) }}</h3>
                    <p class="card-text fs-5">Luas Area Produksi</p>
                    <a href="{{ route('user.pages.pertanian.luas-area-produksi') }}" class="btn btn-sm btn-custom-readmore mt-3">Lihat Detail</a>
                </div>
            </div>
        </div>

        {{-- Card Populasi Tanaman --}}
        <div class="col">
            <div class="card shadow-sm h-100 d-flex flex-column justify-content-center text-center">
                <div class="card-body p-4">
                    <i class="fa-solid fa-tree fa-4x text-success mb-3"></i>
                    <h3 class="card-title display-5 fw-bold text-success">{{ number_format($totalPopulasiTanaman) }}</h3>
                    <p class="card-text fs-5">Populasi Tanaman</p>
                    <a href="{{ route('user.pages.pertanian.populasi-tanaman') }}" class="btn btn-sm btn-custom-readmore mt-3">Lihat Detail</a>
                </div>
            </div>
        </div>
    </div>


</div>
@endsection