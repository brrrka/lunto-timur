<!-- Modal Konfirmasi Penolakan -->
<div class="modal fade" id="confirmationApproved-{{ $item->id }}" tabindex="-1" aria-labelledby="confirmationApprovedLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="{{ route('account.approve', $item->id) }}" method="POST">
        @csrf
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="confirmationRejectedLabel">Konfirmasi Persetujuan Akun</h4>
                <button type="button" class="btn btn-default" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin <strong>menyetujui</strong> permintaan akun ini?</p>
                <div class="form-group mt-3">
                <label for="resident_id">Pilih Penduduk</label>
                <select name="resident_id" id="resident_id" class="form-control">
                    <option value=" ">Tidak ada</option>
                    @foreach ($residents as $item)
                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                    @endforeach
                </select>
            </div>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-outline-success">Ya, Setuju</button>
            </div>
        </div>
    </form>
  </div>
</div>
