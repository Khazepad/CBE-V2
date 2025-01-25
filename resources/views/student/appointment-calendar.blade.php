@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <div class="flex justify-center mb-6">
            <button id="showCalendarButton" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Show Calendar
            </button>
        </div>

        <h1 class="text-3xl font-bold mb-6">Student Appointments</h1>

        <!-- Success Message -->
        @if(session('success'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: '{{ session('success') }}',
                    showConfirmButton: false,
                    timer: 2000
                });
            </script>
        @endif

        <!-- Error Messages -->
        @if ($errors->any())
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    html: '{!! implode('<br>', $errors->all()) !!}',
                    showConfirmButton: true
                });
            </script>
        @endif

        <!-- Appointment Request Form -->
        <div class="bg-white p-6 rounded-lg shadow-md mb-8">
            <h2 class="text-2xl font-semibold mb-4">Request an Appointment</h2>
            <form id="appointmentForm" class="space-y-4" action="{{ route('appointment.request') }}" method="POST" onsubmit="return confirmSubmission();">
                @csrf
                <div class="flex space-x-4">
                    <div class="relative w-1/2">
                        <label for="teacher_search" class="block mb-1">Search Officer/Teacher</label>
                        <input type="text" id="teacher_search" name="teacher_search" required class="w-full p-2 border rounded pl-8" placeholder="Search by name...">
                        <i class="fas fa-search absolute left-2 top-1/2 transform -translate-y-1/2 text-gray-500"></i>
                        <input type="hidden" id="teacher_id" name="teacher_id">
                        <ul id="suggestions" class="mt-2 border rounded hidden w-full"></ul>
                    </div>
                    <div class="w-1/2">
                        <label for="preferred_date_time" class="block mb-1">Preferred Date and Time</label>
                        <input type="datetime-local" id="preferred_date_time" name="preferred_date_time" required class="w-full p-2 border rounded">
                    </div>
                </div>
                <div class="flex items-center">
                    <input type="checkbox" id="flexible_availability" name="flexible_availability" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="flexible_availability" class="ml-2 block">I'm flexible with the timing</label>
                </div>
                <div>
                    <label for="comments" class="block mb-1">Purpose <span style="color: red;">*</span></label>
                    <textarea id="comments" name="comments" rows="3" class="w-full p-2 border rounded" maxlength="30"></textarea>
                    <div id="charCount" class="text-gray-500 mt-1">0/30 characters</div>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Submit Request</button>
                </div>
            </form>
        </div>

        <!-- Pending Appointments -->
        <div class="bg-white p-6 rounded-lg shadow-md mb-8">
            <h2 class="text-2xl font-semibold mb-4">Pending Appointments</h2>
            <ul id="pendingAppointments" class="space-y-2">
                @forelse($pendingAppointments as $appointment)
                    <li class="border-b pb-2">
                        <strong>{{ $appointment->teacher->name }}</strong> - {{ \Carbon\Carbon::parse($appointment->preferred_date_time)->format('M d, Y h:i A') }}
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Pending</span>
                    </li>
                @empty
                    <p class="text-gray-500">No pending appointments</p>
                @endforelse
            </ul>
        </div>

        <!-- Scheduled Appointments -->
        <div class="bg-white p-6 rounded-lg shadow-md mb-8">
            <h2 class="text-2xl font-semibold mb-4">Scheduled Appointments</h2>
            <ul id="scheduledAppointments" class="space-y-2">
                @forelse($scheduledAppointments as $appointment)
                    <li class="border-b pb-2">
                        <strong>{{ $appointment->teacher->name }}</strong> - {{ \Carbon\Carbon::parse($appointment->scheduled_date_time)->format('M d, Y h:i A') }}
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Confirmed</span>
                    </li>
                @empty
                    <p class="text-gray-500">No scheduled appointments</p>
                @endforelse
            </ul>
        </div>

        <!-- Completed Appointments -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-2xl font-semibold mb-4">Completed Appointments</h2>
            <ul id="completedAppointments" class="space-y-4">
                @forelse($completedAppointments as $appointment)
                    <li class="border rounded-lg p-4">
                        <div class="flex items-center justify-between mb-2">
                            <div>
                                <strong>{{ $appointment->teacher->name }}</strong> - {{ \Carbon\Carbon::parse($appointment->scheduled_date_time)->format('M d, Y h:i A') }}
                            </div>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">Completed</span>
                        </div>
                    </li>
                @empty
                    <p class="text-gray-500">No completed appointments</p>
                @endforelse
            </ul>
        </div>
    </div>

    <!-- Calendar Modal -->
    <div id="calendarModal" class="fixed inset-0 flex items-center justify-center hidden bg-gray-800 bg-opacity-50">
        <div class="bg-white p-6 rounded-lg shadow-md w-full max-w-lg">
            <h2 class="text-2xl font-semibold mb-4">Calendar</h2>
            <div id="calendar"></div>
            <button id="closeCalendarButton" class="mt-4 bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Close</button>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Confirmation alert before form submission
        function confirmSubmission() {
            event.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                text: 'Do you want to submit this appointment request?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, submit it!',
                cancelButtonText: 'No, cancel',
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('appointmentForm').submit();
                }
            });
            return false;
        }

        // Teacher search suggestion functionality
        const officersAndTeachers = @json($officersAndTeachers);
        const teacherSearchInput = document.getElementById('teacher_search');
        const suggestionsList = document.getElementById('suggestions');
        const teacherIdInput = document.getElementById('teacher_id');

        teacherSearchInput.addEventListener('input', function() {
            const searchValue = this.value.toLowerCase();
            suggestionsList.innerHTML = '';

            if (searchValue.length > 0) {
                const filteredOfficersAndTeachers = officersAndTeachers.filter(officerOrTeacher =>
                    officerOrTeacher.name.toLowerCase().includes(searchValue)
                );

                filteredOfficersAndTeachers.forEach(officerOrTeacher => {
                    const listItem = document.createElement('li');
                    listItem.classList.add('p-2', 'cursor-pointer', 'hover:bg-gray-100', 'flex', 'items-center', 'justify-between');

                    const nameSpan = document.createElement('span');
                    nameSpan.textContent = officerOrTeacher.name;

                    const roleSpan = document.createElement('span');
                    roleSpan.classList.add('px-2', 'py-1', 'rounded-full', 'text-xs', 'font-medium');
                    if (officerOrTeacher.role === 'officer') {
                        roleSpan.classList.add('bg-blue-100', 'text-blue-800');
                    } else {
                        roleSpan.classList.add('bg-red-100', 'text-red-800');
                    }
                    roleSpan.textContent = ucfirst(officerOrTeacher.role);

                    listItem.appendChild(nameSpan);
                    listItem.appendChild(roleSpan);

                    listItem.addEventListener('click', function() {
                        teacherSearchInput.value = officerOrTeacher.name;
                        teacherIdInput.value = officerOrTeacher.id;
                        suggestionsList.classList.add('hidden');
                    });

                    suggestionsList.appendChild(listItem);
                });

                // Automatically select the first suggestion if there is an exact match
                if (filteredOfficersAndTeachers.length === 1 && filteredOfficersAndTeachers[0].name.toLowerCase() === searchValue) {
                    teacherSearchInput.value = filteredOfficersAndTeachers[0].name;
                    teacherIdInput.value = filteredOfficersAndTeachers[0].id;
                    suggestionsList.classList.add('hidden');
                } else {
                    suggestionsList.classList.remove('hidden');
                }
            } else {
                suggestionsList.classList.add('hidden');
            }
        });

        document.addEventListener('click', function(event) {
            if (!suggestionsList.contains(event.target) && event.target !== teacherSearchInput) {
                suggestionsList.classList.add('hidden');
            }
        });

        // Character count for comments
        const commentsTextarea = document.getElementById('comments');
        const charCountDisplay = document.getElementById('charCount');

        commentsTextarea.addEventListener('input', function() {
            charCountDisplay.textContent = `${this.value.length}/30 characters`;
        });

        // Helper function for capitalizing first letter
        function ucfirst(string) {
            return string.charAt(0).toUpperCase() + string.slice(1);
        }

        // Show Calendar Modal
        const showCalendarButton = document.getElementById('showCalendarButton');
        const calendarModal = document.getElementById('calendarModal');
        const closeCalendarButton = document.getElementById('closeCalendarButton');

        showCalendarButton.addEventListener('click', function() {
            calendarModal.classList.remove('hidden');
            generateCalendar(currentMonth, currentYear);
        });

        closeCalendarButton.addEventListener('click', function() {
            calendarModal.classList.add('hidden');
        });

        // Simple Calendar (You can replace this with a more sophisticated calendar library)
        const calendar = document.getElementById('calendar');
        const currentDate = new Date();
        const currentMonth = currentDate.getMonth();
        const currentYear = currentDate.getFullYear();

        function generateCalendar(month, year) {
            const firstDay = new Date(year, month, 1);
            const lastDay = new Date(year, month + 1, 0);
            const daysInMonth = lastDay.getDate();
            const startingDay = firstDay.getDay();

            let calendarHTML = '<table class="w-full border-collapse"><thead><tr>';
            const daysOfWeek = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
            daysOfWeek.forEach(day => {
                calendarHTML += `<th class="p-2 border">${day}</th>`;
            });
            calendarHTML += '</tr></thead><tbody>';

            let date = 1;
            for (let i = 0; i < 6; i++) {
                calendarHTML += '<tr>';
                for (let j = 0; j < 7; j++) {
                    if (i === 0 && j < startingDay) {
                        calendarHTML += '<td class="p-2 border"></td>';
                    } else if (date > daysInMonth) {
                        break;
                    } else {
                        calendarHTML += `<td class="p-2 border text-center cursor-pointer" onclick="showAvailableTeachers('${year}-${month + 1}-${date}')">${date}</td>`;
                        date++;
                    }
                }
                calendarHTML += '</tr>';
            }
            calendarHTML += '</tbody></table>';
            calendar.innerHTML = calendarHTML;
        }

        function showAvailableTeachers(date) {
            fetch(`/get-available-teachers/${date}`)
                .then(response => response.json())
                .then(data => {
                    Swal.fire({
                        title: 'Available Teachers',
                        html: data.map(teacher => `<p>${teacher.name}</p>`).join(''),
                        icon: 'info',
                        showConfirmButton: true
                    });
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        generateCalendar(currentMonth, currentYear);
    </script>
@endsection
