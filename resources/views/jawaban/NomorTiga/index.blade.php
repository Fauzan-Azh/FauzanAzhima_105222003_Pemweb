<meta name="csrf-token" content="{{ csrf_token() }}">

<table class="table table-bordered table-schedule">
    <thead>
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Start</th>
            <th>End</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody></tbody>
</table>

<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form class="modal-content" method="POST" action="{{ route('event.update') }}">
            @csrf
            @method('PUT')  <!-- Tambahkan metode PUT untuk update -->
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Jadwal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="name">Nama</label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="Masukkan nama event" required>
                    @error('name')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="start">Start</label>
                    <input type="date" class="form-control" name="start" id="start" required>
                    @error('start')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="end">End</label>
                    <input type="date" class="form-control" name="end" id="end" required>
                    @error('end')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Input tersembunyi untuk event_id -->
                <input type="hidden" name="event_id" id="eventId">
            </div>
            <div class="modal-footer">
                <button type="submit" id="submitBtn" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="successeditModal" tabindex="-1" role="dialog" aria-labelledby="successeditModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="successeditModalLabel">Jadwal Berhasil Diedit</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                <p>Jadwal telah berhasil diedit.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Penghapusan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus event ini?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Hapus</button>
            </div>
        </div>
    </div>
</div>

<script>
    @if(session('berhasil'))
        document.addEventListener('DOMContentLoaded', function () {
            var successeditModal = new bootstrap.Modal(document.getElementById('successeditModal'));
            successeditModal.show();
        });
    @endif
</script>
