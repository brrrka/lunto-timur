@extends('user.layout.app')

@section('content')
<div class="container py-5">
    <h2 class="text-center fw-bold mb-4">UMKM Unggulan</h2>
    <p class="text-center text-muted mb-5">Desa Lunto Timur memiliki UMKM pilihan dengan kualitas terbaik dan produk menarik.</p>

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 mb-5"> {{-- Grid untuk card --}}
        @forelse ($featuredUmkms as $item)
            <div class="col">
                <div class="card h-100 shadow-sm border-0">
                    @if ($item->photo)
                        <img src="{{ asset('storage/' . $item->photo) }}" class="card-img-top rounded-top" alt="{{ $item->nama_usaha }}" style="height: 200px; object-fit: cover;">
                    @else
                        {{-- Ini seharusnya tidak tercapai jika hanya memilih yang punya foto --}}
                        <img src="{{ asset('images/default-umkm.png') }}" class="card-img-top rounded-top" alt="Gambar Default" style="height: 200px; object-fit: cover;">
                    @endif
                    <div class="card-body d-flex flex-column"> 
                        <h5 class="card-title fw-bold mt-2 mb-2">{{ $item->nama_usaha }}</h5>
                        <p class="card-text text-muted small mb-1">
                            Pemilik: {{ $item->nama_pemilik }}
                        </p>
                        <p class="card-text small mb-2">
                            Alamat: {{ Str::limit($item->alamat_usaha, 100, '...') ?? '-' }}
                        </p>
                        <div class="mt-auto text-end"> 
                            @if ($item->no_hp_usaha)
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $item->no_hp_usaha) }}" target="_blank" class="btn btn-sm btn-success">
                                    <i class="fab fa-whatsapp me-1"></i> Hubungi
                                </a>
                            @else
                                <span class="btn btn-sm btn-secondary disabled">No HP Tidak Tersedia</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <p>Belum ada UMKM unggulan yang dapat ditampilkan.</p>
            </div>
        @endforelse
    </div>

    <hr class="my-5"> {{-- Pembatas antara section unggulan dan daftar lengkap --}}

    {{-- SECTION: Seluruh Daftar UMKM (Table View) --}}
    <h2 class="text-center fw-bold mb-4">Seluruh Daftar UMKM</h2>
    {{-- Form Pencarian (Tetap di sini untuk tabel) --}}
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold">Daftar UMKM</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('user.pages.umkm.index') }}" method="GET" class="mb-3">
                <div class="row g-3 align-items-center justify-content-end">
                    {{-- Kolom Pencarian --}}
                    <div class="col-md-8 col-lg-6 justify">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control bg-light border-0 small" placeholder="Cari berdasarkan Nama Usaha, Pemilik, atau NIK..."
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
                            <th>Nama Usaha</th>
                            <th>Pemilik</th>
                            <th style="min-width: 150px;">Alamat</th>
                            <th>No HP</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($allUmkms as $item)
                            <tr>
                                <td>{{ $loop->iteration + ($allUmkms->currentPage() - 1) * $allUmkms->perPage() }}</td>
                                <td>{{ $item->nama_usaha }}</td>
                                <td>{{ $item->nama_pemilik }}</td>
                                <td>{{ Str::limit($item->alamat_usaha, 50, '...') ?? '-' }}</td>
                                <td>{{ $item->no_hp_usaha ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">Belum ada data UMKM yang tersedia.</td> {{-- colspan disesuaikan (7 kolom - 1 foto = 6) --}}
                            </tr>
                        @endforelse
                    </tbody>
                </table>`
            </div>
        </div>
        {{-- Pagination Navigation --}}
        @if ($allUmkms instanceof \Illuminate\Pagination\LengthAwarePaginator)
            <div class="d-flex justify-content-center mt-5">
                {{ $allUmkms->appends(request()->query())->links('vendor.pagination.bootstrap-5') }}
            </div>
        @endif
    </div>
</div>