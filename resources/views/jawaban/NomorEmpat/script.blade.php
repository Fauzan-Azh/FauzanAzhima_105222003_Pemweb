<script type="text/javascript">
    $(document).ready(function () {

        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            headerToolbar: {
                right: 'prev,next',
                center: 'title',
                left: null,
            },
            locale: 'id',
            initialView: 'dayGridMonth',
            events: function (info, successCallback, failureCallback) {
                $.ajax({
                    url: "{{ route('event.getJson') }}",
                    method: 'GET',
                    dataType: 'json',
                    success: function (data) {
                        var events = [];

                        data.forEach(function (event) {
                            events.push({
                                id: event.id,
                                title: event.title,
                                start: event.start,
                                end: event.end,
                                color: event.color,
                            });
                        });

                        successCallback(events);
                    },
                    error: function (xhr, status, error) {
                        alert("Gagal memuat data jadwal.");
                        failureCallback();
                    }
                });
            }
        });

        calendar.render();
    });
</script>
