<!-- Modal -->
<div class="modal fade" id="confirmationReject{{ $item->id }}" tabindex="-1" aria-labelledby="confirmationRejectLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <form action="/account-request/approval/{{ $item->id }}" method="POST">
            @csrf
            @method('POST')
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title fs-5" id="confirmationRejectLabel">Konfirmasi Penolakan</h4>
                    <button type="button" class="btn btn-default" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <input type="hidden" name ="for" value="reject">
                <div class="modal-body">
                    <span>Apakah anda yakin akan menolak akun ini? </span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-outline-danger">Ya, Tolak!</button>
                </div>
            </div>
        </form>
    </div>
</div>
