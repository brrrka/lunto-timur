<!-- Modal Konfirmasi Penolakan -->
<div class="modal fade" id="confirmationRejected-{{ $item->id }}" tabindex="-1" aria-labelledby="confirmationRejectedLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="{{ route('account.reject', $item->id) }}" method="POST">
        @csrf
        @method('PATCH')
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="confirmationRejectedLabel">Konfirmasi Penolakan</h4>
                <button type="button" class="btn btn-default" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin <strong>menolak</strong> permintaan akun ini?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-outline-danger">Ya, Tolak</button>
            </div>
        </div>
    </form>
  </div>
</div>
