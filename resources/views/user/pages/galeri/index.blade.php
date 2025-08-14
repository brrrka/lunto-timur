@extends('user.layout.app')

@section('content')
<div class="container py-5">
    <h2 class="text-center fw-bold mb-4">Galeri Desa</h1>
    <hr class="mb-5">

    <div class="row row-cols-2 row-cols-md-2 row-cols-lg-4 g-4">
        @forelse ($galleries as $item)
            <div class="col">
                <div class="card h-100 shadow-sm border-0">
                    {{-- Targetkan link yang memicu modal --}}
                    <a href="#" class="d-block gallery-item-trigger" {{-- Tambahkan kelas kustom ini --}}
                       data-bs-toggle="modal"
                       data-bs-target="#imageModal"
                       data-image="{{ $item->photo ? asset('storage/' . $item->photo) : asset('images/default-gallery.png') }}"
                       data-title="{{ $item->activity_name }}"
                       data-date="{{ \Carbon\Carbon::parse($item->activity_date)->locale('id')->translatedFormat('d F Y') }}">
                        @if ($item->photo)
                            <img src="{{ asset('storage/' . $item->photo) }}" class="card-img-top rounded-lg" alt="{{ $item->activity_name }}" style="height: 250px; object-fit: cover;">
                        @else
                            <img src="{{ asset('images/default-gallery.png') }}" class="card-img-top rounded-lg" alt="Gambar Default" style="height: 250px; object-fit: cover;">
                        @endif
                    </a>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <p>Belum ada foto galeri yang tersedia.</p>
            </div>
        @endforelse
    </div>

    {{-- Tampilkan tautan pagination --}}
    @if ($galleries instanceof \Illuminate\Pagination\LengthAwarePaginator)
        <div class="d-flex justify-content-center mt-5">
            {{ $galleries->links('vendor.pagination.bootstrap-5') }}
        </div>
    @endif
</div>

{{-- Modal untuk Tampilan Gambar Besar --}}
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="imageModalLabel"></h5>
        
        {{-- Tombol Download Gambar --}}
        <a id="downloadImageBtn" href="#" download class="btn btn-outline-secondary btn-sm ms-4" title="Download Gambar">
            <i class="fa-solid fa-download"></i>
        </a>
        
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
        <img src="" id="modalImage" class="img-fluid rounded" alt="Gambar Besar" style="max-height: 80vh;">
        <p class="text-muted mt-2 mb-0" id="modalDate"></p>
      </div>
    </div>
  </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const imageModal = document.getElementById('imageModal');
        const modalImage = document.getElementById('modalImage');
        const imageModalLabel = document.getElementById('imageModalLabel');
        const modalDate = document.getElementById('modalDate');
        const downloadImageBtn = document.getElementById('downloadImageBtn'); // Ambil elemen tombol download

        document.querySelectorAll('.gallery-item-trigger').forEach(linkElement => {
            linkElement.addEventListener('click', function(event) {
                const imageUrl = this.dataset.image;
                const imageTitle = this.dataset.title;
                const imageDate = this.dataset.date;

                console.log('Image URL:', imageUrl);
                console.log('Image Title:', imageTitle);
                console.log('Image Date:', imageDate);

                modalImage.src = imageUrl;
                imageModalLabel.textContent = imageTitle;
                modalDate.textContent = imageDate;
                downloadImageBtn.href = imageUrl; // Isi href tombol download dengan URL gambar

                // Bootstrap 5 secara otomatis menangani show/hide modal karena data-bs-toggle="modal"
            });
        });

        imageModal.addEventListener('hidden.bs.modal', function () {
            modalImage.src = '';
            imageModalLabel.textContent = '';
            modalDate.textContent = '';
            downloadImageBtn.href = '#'; // Bersihkan href tombol download saat modal tertutup
        });
    });
</script>
@endpush