@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Manage Appointments</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <h2>Pending Appointment Requests</h2>
    @if($pendingAppointments->count() > 0)
        <ul>
            @foreach($pendingAppointments as $appointment)
                <li>
                    {{ $appointment->student->name }} - {{ $appointment->preferred_date_time }}
                    <form action="{{ route('appointment.confirm', $appointment->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <div class="form-group">
                            <label for="scheduled_date_time">Schedule Date and Time</label>
                            <input type="datetime-local" name="scheduled_date_time" id="scheduled_date_time" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Schedule</button>
                    </form>
                </li>
            @endforeach
        </ul>
    @else
        <p>No pending appointment requests.</p>
    @endif

    <h2>Scheduled Appointments</h2>
    @if($scheduledAppointments->count() > 0)
        <ul>
            @foreach($scheduledAppointments as $appointment)
                <li>{{ $appointment->student->name }} - {{ $appointment->scheduled_date_time }}</li>
            @endforeach
        </ul>
    @else
        <p>No scheduled appointments.</p>
    @endif

    <h2>Completed Appointments</h2>
    @if($completedAppointments->count() > 0)
        <ul>
            @foreach($completedAppointments as $appointment)
                <li>{{ $appointment->student->name }} - {{ $appointment->scheduled_date_time }}</li>
            @endforeach
        </ul>
    @else
        <p>No completed appointments.</p>
    @endif
</div>
@endsection