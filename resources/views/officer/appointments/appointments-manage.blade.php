@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-bold mb-6">Manage Appointments</h1>

        <!-- Success Message -->
        @if(session('success'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: '{{ session('success') }}',
                    showConfirmButton: false,
                    timer: 3000
                });
            </script>
        @endif

        <!-- Pending Appointments -->
        <div class="bg-white p-6 rounded-lg shadow-md mb-8">
            <h2 class="text-2xl font-semibold mb-4">Pending Appointments</h2>
            <ul id="pendingAppointments" class="space-y-2">
                @forelse($pendingAppointments as $appointment)
                    <li class="border-b pb-2">
                        <strong>{{ $appointment->student->name }}</strong> - {{ \Carbon\Carbon::parse($appointment->preferred_date_time)->format('M d, Y h:i A') }}
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Pending</span>
                        <form action="{{ route('appointment.schedule', $appointment->id) }}" method="POST" class="inline-block ml-4">
                            @csrf
                            <input type="datetime-local" name="scheduled_date_time" required class="p-2 border rounded">
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Schedule</button>
                        </form>
                        <form action="{{ route('appointment.cancel', $appointment->id) }}" method="POST" class="inline-block ml-4">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Cancel</button>
                        </form>
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
                        <div class="flex justify-between items-center">
                            <div>
                                <strong>{{ $appointment->student->name }}</strong> - {{ \Carbon\Carbon::parse($appointment->scheduled_date_time)->format('M d, Y h:i A') }}
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Confirmed</span>
                            </div>
                            <div class="flex items-center">
                                <button class="mark-as-completed text-green-500 hover:text-green-700 ml-auto" data-appointment-id="{{ $appointment->id }}" {{ $appointment->status === 'completed' ? 'disabled' : '' }}>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                    </svg>
                                </button>
                                <form action="{{ route('appointment.reschedule', $appointment->id) }}" method="POST" class="inline-block ml-4">
                                    @csrf
                                    <input type="datetime-local" name="rescheduled_date_time" required class="p-2 border rounded">
                                    @if($appointment->old_scheduled_date_time)
                                        <input type="text" value="{{ \Carbon\Carbon::parse($appointment->old_scheduled_date_time)->format('M d, Y h:i A') }}" readonly class="p-2 border rounded ml-2 bg-gray-100">
                                    @endif
                                    <button type="submit" class="bg-orange-500 text-white px-4 py-2 rounded hover:bg-orange-600 reschedule-button" data-appointment-id="{{ $appointment->id }}">Reschedule</button>
                                </form>
                            </div>
                        </div>
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
                                <strong>{{ $appointment->student->name }}</strong> - {{ \Carbon\Carbon::parse($appointment->scheduled_date_time)->format('M d, Y h:i A') }}
                            </div>
                        </div>
                    </li>
                @empty
                    <p class="text-gray-500">No completed appointments</p>
                @endforelse
            </ul>
        </div>
    </div>

    <script>
        document.querySelectorAll('.mark-as-completed').forEach(button => {
            button.addEventListener('click', function() {
                const appointmentId = this.getAttribute('data-appointment-id');

                Swal.fire({
                    title: 'Mark as Completed?',
                    text: "Are you sure you want to mark this appointment as completed?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, mark it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch(`/appointment/mark-completed/${appointmentId}`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({})
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                this.disabled = true;
                                Swal.fire('Marked!', data.success, 'success');
                                // Reload the page to reflect the changes
                                location.reload();
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                    }
                });
            });
        });

        document.querySelectorAll('.reschedule-button').forEach(button => {
            button.addEventListener('click', function(event) {
                event.preventDefault();
                const form = this.closest('form');
                const appointmentId = this.getAttribute('data-appointment-id');

                Swal.fire({
                    title: 'Reschedule Appointment?',
                    text: "Are you sure you want to reschedule this appointment?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, reschedule it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>
@endsection
