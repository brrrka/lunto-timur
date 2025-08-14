<!-- Modal -->
<div class="modal fade" id="confirmationDelete-{{ $item->id }}" tabindex="-1" aria-labelledby="confirmationDelete" aria-hidden="true">
  <div class="modal-dialog">
    <form action="/complaint/{{ $item->id }}" method="POST">
        @csrf
        @method('DELETE')
        <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="confirmationDelete">Konfirmasi Hapus</h4>
            <button type="button" class="btn btn-default" data-bs-dismiss="modal" aria-label="Close">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body">
            <span>Apakah anda yakin ingin pengaduan ini?</span>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-outline-danger">Ya, hapus!</button>
        </div>
        </div>
    </form>
  </div>
</div>