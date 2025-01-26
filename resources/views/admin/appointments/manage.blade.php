<!-- resources/views/admin/appointments/manage.blade.php -->

@extends('layouts.admin') <!-- Adjust the layout as needed -->

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Manage Appointments</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<div class="container">

    <div class="tabs">
        <button class="tab {{ $status === 'all' ? 'active' : '' }}" onclick="filterAppointments('all')">All</button>
        <button class="tab {{ $status === 'pending' ? 'active' : '' }}" onclick="filterAppointments('pending')">Pending</button>
        <button class="tab {{ $status === 'accepted' ? 'active' : '' }}" onclick="filterAppointments('accepted')">Accepted</button>
        <button class="tab {{ $status === 'rescheduled' ? 'active' : '' }}" onclick="filterAppointments('rescheduled')">Rescheduled</button>
        <button class="tab {{ $status === 'canceled' ? 'active' : '' }}" onclick="filterAppointments('canceled')">Canceled</button>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Purpose</th>
                <th>Appointment Date</th>
                <th>Appointment Time</th>
                <th>Booking Reference Number</th>
                <th>Student</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($appointments as $appointment)
                <tr>
                    <td>{{ $appointment->purpose }}</td>
                    <td>{{ $appointment->appointment_date }}</td>
                    <td>{{ $appointment->appointment_time }}</td>
                    <td>{{ $appointment->booking_reference_number }}</td>
                    <td>{{ $appointment->user->name }}</td>
                    <td>{{ ucfirst($appointment->status) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
    function filterAppointments(status) {
        window.location.href = "{{ url()->current() }}?status=" + status;
    }
</script>
@endsection
