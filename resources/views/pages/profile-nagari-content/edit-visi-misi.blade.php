@extends('layout.app')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Visi dan Misi Desa</h1>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <form action="{{ route('profile-nagari-content.update') }}" method="POST"> {{-- Pastikan nama rute ini benar, bisa juga admin.profile-nagari-content.update --}}
        @csrf
        @method('PUT')

        <div class="card-body bg-white mb-3 shadow-sm">
            {{-- Input untuk Visi Nagari --}}
            <div class="mb-3">
                <label for="visi_content" class="form-label">Visi Desa</label>
                <textarea id="visi_content" name="visi_content" rows="5" class="form-control @error('visi_content') is-invalid @enderror">{{ old('visi_content', $visi->content ?? '') }}</textarea>
                @error('visi_content')
                    <span class="invalid-feedback">
                        {{ $message }}
                    </span>
                @enderror
            </div>

            {{-- Input untuk Misi Nagari (Dinamis) --}}
            <hr class="my-4">
            <h5 class="mb-3 fw-bold">Misi Desa</h5>
            <div id="misi-items-container">
                @forelse ($misiItems as $key => $misi)
                    <div class="mb-3 misi-item" data-index="{{ $key }}">
                        <input type="hidden" name="misi_items[{{ $key }}][id]" value="{{ $misi->id }}">
                        <label for="misi_items_{{ $key }}_content" class="form-label">Misi {{ $key + 1 }}</label>
                        <textarea id="misi_items_{{ $key }}_content" name="misi_items[{{ $key }}][content]" rows="3" class="form-control @error("misi_items.{$key}.content") is-invalid @enderror">{{ old("misi_items.{$key}.content", $misi->content) }}</textarea>
                        @error("misi_items.{$key}.content")
                            <span class="invalid-feedback">
                                {{ $message }}
                            </span>
                        @enderror
                        <div class="d-flex justify-content-end mt-2">
                             <input type="number" name="misi_items[{{ $key }}][order]" value="{{ old("misi_items.{$key}.order", $misi->order ?? $key + 1) }}" class="form-control w-auto me-2" placeholder="Urutan" style="max-width: 100px;">
                            <button type="button" class="btn btn-danger btn-sm remove-misi-item">Hapus</button>
                        </div>
                    </div>
                @empty
                    <p class="text-muted" id="no-misi-message">Belum ada Misi Nagari. Klik "Tambah Misi" untuk menambahkan.</p>
                @endforelse
            </div>
            <button type="button" id="add-misi-item" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"><i class="fas fa-plus fa-sm text-white-50"></i> Tambah Misi</button>
        </div>

        <div class="card-footer d-flex justify-content-end" style="gap: 10px;">
            <a href="{{ route('profile-nagari-content.index') }}" class="btn btn-outline-secondary">Kembali</a>
            <button type="submit" class="btn btn-warning">Update</button>
        </div>
    </form>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const misiContainer = document.getElementById('misi-items-container');
        const addMisiButton = document.getElementById('add-misi-item');
        // --- Perubahan di sini: Gunakan variabel PHP yang sudah dihitung ---
        let misiIndex = {{ $misiIndex }};
        // --- End Perubahan ---

        addMisiButton.addEventListener('click', function() {
            const noMisiMessage = document.getElementById('no-misi-message');
            if (noMisiMessage) {
                noMisiMessage.remove();
            }

            const newMisiItem = document.createElement('div');
            newMisiItem.classList.add('mb-3', 'misi-item');
            newMisiItem.setAttribute('data-index', misiIndex);
            newMisiItem.innerHTML = `
                <label for="misi_items_${misiIndex}_content" class="form-label">Misi ${misiIndex + 1}</label>
                <textarea id="misi_items_${misiIndex}_content" name="misi_items[${misiIndex}][content]" rows="3" class="form-control @error("misi_items.${misiIndex}.content") is-invalid @enderror"></textarea>
                <div class="d-flex justify-content-end mt-2">
                    <input type="number" name="misi_items[${misiIndex}][order]" value="${misiIndex + 1}" class="form-control w-auto me-2" placeholder="Urutan" style="max-width: 100px;">
                    <button type="button" class="btn btn-danger btn-sm remove-misi-item"><i class="fa-solid fa-trash me-1"></i> Hapus</button>
                </div>
            `;
            misiContainer.appendChild(newMisiItem);
            misiIndex++;
            updateMisiItemLabelsAndOrder();
        });

        misiContainer.addEventListener('click', function(event) {
            if (event.target.closest('.remove-misi-item')) {
                event.target.closest('.misi-item').remove();
                updateMisiItemLabelsAndOrder();
                if (misiContainer.children.length === 0) {
                    const p = document.createElement('p');
                    p.classList.add('text-muted');
                    p.id = 'no-misi-message';
                    p.textContent = 'Belum ada Misi Nagari. Klik "Tambah Misi" untuk menambahkan.';
                    misiContainer.appendChild(p);
                }
            }
        });

        function updateMisiItemLabelsAndOrder() {
            const items = misiContainer.querySelectorAll('.misi-item');
            items.forEach((item, index) => {
                const label = item.querySelector('.form-label');
                if (label) {
                    label.textContent = `Misi ${index + 1}`;
                }
                const textarea = item.querySelector('textarea');
                if (textarea) {
                    textarea.setAttribute('name', `misi_items[${index}][content]`);
                }
                const orderInput = item.querySelector('input[type="number"]');
                if (orderInput) {
                    orderInput.setAttribute('name', `misi_items[${index}][order]`);
                    if (orderInput.value === '' || orderInput.value == (parseInt(item.getAttribute('data-index')) + 1) ) {
                         orderInput.value = index + 1;
                    }
                }
                item.setAttribute('data-index', index);
                 const hiddenIdInput = item.querySelector('input[type="hidden"][name^="misi_items"]');
                 if(hiddenIdInput) {
                     hiddenIdInput.setAttribute('name', `misi_items[${index}][id]`);
                 }
            });
            misiIndex = items.length;
        }
        updateMisiItemLabelsAndOrder();
    });
</script>
@endpush