@extends('layouts.admin')

@section('title', 'Appointment Details')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('student.appointment-history') }}">Appointment History</a></li>
                    <li class="breadcrumb-item active">Appointment Details</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8">
                <div class="appointment-slip">
                    <!-- Header with Title and Actions -->
                    <div class="slip-header-container">
                        <h1 class="slip-header">ADMS Appointment Slip</h1>
                        <div class="action-buttons">
                            <button onclick="window.print()" class="btn-print">
                                <i class="fas fa-print"></i> Print
                            </button>
                            <a href="{{ route('appointment.export-pdf', $appointment->id) }}" class="btn-export">
                                <i class="fas fa-file-pdf"></i> Export PDF
                            </a>
                        </div>
                    </div>

                    <!-- QR Code and Status Section -->
                    <div class="info-section">
                        <div class="qr-code-container">
                            {!! $qrCode !!}
                        </div>
                        <div class="status-container">
                            <div class="booking-status">Booked</div>
                            <div class="timestamp">Created on {{ now()->format('l, M j, Y h:i A') }}</div>
                            <div class="timestamp">As of {{ now()->format('l, M j, Y h:i A') }}</div>
                        </div>
                    </div>

                    <!-- Appointment Details Section -->
                    <div class="details-section">
                        <h2 class="appointment-details">Appointment Details</h2>
                        <table class="details-table">
                            <tr>
                                <td>First Name</td>
                                <td>{{ Auth::user()->name }}</td>
                            </tr>
                            <tr>
                                <td>Middle Name</td>
                                <td>{{ Auth::user()->middle_name ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td>Last Name</td>
                                <td>{{ Auth::user()->last_name }}</td>
                            </tr>
                            <tr>
                                <td>Purpose</td>
                                <td>{{ $appointment->purpose }}</td>
                            </tr>
                            <tr>
                                <td>Date</td>
                                <td>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('l, F j, Y') }}</td>
                            </tr>
                            <tr>
                                <td>Time</td>
                                <td>{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}</td>
                            </tr>
                            <tr>
                                <td>Status</td>
                                <td>
                                    <span class="badge badge-success">Confirmed</span>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <!-- Schedule Another Button -->
                    <div class="text-center mt-4">
                        <a href="{{ route('student.appointment-calendar') }}" class="schedule-btn">
                            <i class="fas fa-calendar-plus"></i> Schedule Another Appointment
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    toastr.success('Your appointment has been successfully booked!');
});
</script>
@endpush
