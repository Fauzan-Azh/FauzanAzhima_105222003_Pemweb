<script type="text/javascript">
    $(document).ready(function () {

        var eventsData = {!! json_encode($events) !!};
        console.log(eventsData);

        const table = $('.table-schedule').DataTable({
            data: eventsData.original,
            columns: [
                { data: null, render: (data, type, row, meta) => meta.row + 1 },
                { data: "name" },
                {
                    data: "start",
                    render: function(data) {
                        return moment(data).format('YYYY-MM-DD');
                    }
                },
                {
                    data: "end",
                    render: function(data) {
                        return moment(data).format('YYYY-MM-DD');
                    }
                },
                {
                    data: "id",
                    render: (data) => `
                        <button class="btn btn-sm btn-primary btn-edit" data-id="${data}"><i class="bi bi-pencil"></i></button>
                        <button class="btn btn-sm btn-danger btn-delete" data-id="${data}"><i class="bi bi-trash"></i></button>
                    `,
                },
            ],
            language: {
                paginate: {
                    next: '<i class="bi bi-arrow-right"></i>',
                    previous: '<i class="bi bi-arrow-left"></i>',
                },
                emptyTable: "Data tidak ditemukan",
            },
        });

        $(document).on("click", ".btn-edit", function () {
            const id = $(this).data("id");

            $.ajax({
                url: "{{ route('event.getSelectedData') }}",
                type: "GET",
                data: { id },
                success: function (data) {
                    console.log(data);
                    if (data) {
                        $("#editModalLabel").text("Edit Jadwal");
                        $("#submitBtn").text("Update");
                        $("#eventForm").attr("action", "{{ route('event.update') }}");

                        $("#name").val(data.name);
                        $("#start").val(data.start.split('T')[0]);
                        $("#end").val(data.end.split('T')[0]);

                        $("#eventId").val(data.id);

                        $("#editModal").modal("show");
                    }
                },
                error: function () {
                    alert("Gagal mengambil data.");
                },
            });
        });

        $(document).on("click", ".btn-delete", function () {
            const id = $(this).data("id");

            $('#deleteModal').modal('show');

            $("#confirmDeleteBtn").off('click').on('click', function () {
                $.ajax({
                    url: "{{ route('event.delete') }}",
                    type: "POST",
                    data: { id },
                    headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") },
                    success: function (response) {
                        if (response.success) {
                            location.reload();
                        } else {
                            alert("Gagal menghapus event.");
                        }
                        $('#deleteModal').modal('hide');
                    },
                    error: function () {
                        alert("Gagal menghapus event.");
                        $('#deleteModal').modal('hide');
                    },
                });
            });
        });

    });
</script>
