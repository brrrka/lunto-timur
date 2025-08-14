<!-- Modal -->
<div class="modal fade" id="accountDetail-{{ $item->id }}" tabindex="-1" aria-labelledby="accountDetail" aria-hidden="true">
  <div class="modal-dialog">
  <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="confirmationDelete">Detail Akun</h4>
            <button type="button" class="btn btn-default" data-bs-dismiss="modal" aria-label="Close">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body">
            <div class="form-group mb-3">
                <label for="name">Nama</label>
                <input type="text" name="name" class="form-control" value="{{ optional($item->user)->name ?? 'Belum terhubung' }}" readonly>
            </div>
            <div class="form-group mb-3">
                <label for="name">Email</label>
                <input type="text" name="email" class="form-control" value="{{ optional($item->user)->email ?? 'Belum terhubung' }}" readonly>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
        </div>
        </div>
  </div>
</div>