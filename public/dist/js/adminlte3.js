document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'prev',
            center: 'title',
            right: 'next'
        },
        titleFormat: { year: 'numeric', month: 'long' },
        firstDay: 0,
        height: 'auto',
        selectable: true,
        selectConstraint: {
            start: new Date().setHours(0, 0, 0, 0), // Set to start of today
            end: '2025-02-01' // Include January 31, 2025
        },
        select: function(info) {
            // Handle date selection here
            Swal.fire({
                title: 'Confirm Appointment Date',
                text: 'Are you sure you want to select ' + info.startStr + '?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'No'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '/student/date-selected?date=' + info.startStr;
                }
            });
        },
        dayCellDidMount: function(info) {
            // Disable past dates and Sundays
            var today = new Date();
            today.setHours(0, 0, 0, 0);
            if (info.date < today || info.date.getDay() === 0) {
                info.el.style.backgroundColor = '#f5f5f5';
                info.el.style.cursor = 'not-allowed';
            }
        }
    });
    calendar.render();
});
