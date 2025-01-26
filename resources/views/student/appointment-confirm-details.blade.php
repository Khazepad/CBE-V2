@extends('layouts.admin')

@section('title', 'Confirm Appointment Details')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6"></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('student.appointment-calendar') }}">Appointments</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('student.appointment-calendar.select-date') }}">Select Date</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('student.appointment-calendar.date-selected') }}">Select Time</a></li>
                        <li class="breadcrumb-item active">Confirm Details</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Confirm Appointment Details</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('student.appointment-calendar.store') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label>First Name</label>
                                    <input type="text" class="form-control" value="{{ Auth::user()->name }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Middle Name</label>
                                    <input type="text" class="form-control" value="{{ Auth::user()->middle_name ?? 'N/A' }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Last Name</label>
                                    <input type="text" class="form-control" value="{{ Auth::user()->last_name }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Purpose</label>
                                    <textarea class="form-control" readonly>{{ $purpose }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label>Date</label>
                                    <input type="text" class="form-control" value="{{ \Carbon\Carbon::parse($appointmentDate)->format('l, F j, Y') }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Time</label>
                                    <input type="text" class="form-control" value="{{ \Carbon\Carbon::parse($appointmentTime)->format('h:i A') }}" readonly>
                                </div>
                                <div class="card-footer">
                                    <a href="{{ route('student.appointment-calendar.date-selected', ['date' => $appointmentDate]) }}" class="btn btn-secondary">Back</a>
                                    <button type="submit" class="btn btn-primary float-right">Confirm</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('styles')
<style>
    .card {
        box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);
        margin-bottom: 1rem;
    }
    .card-header {
        background-color: rgba(0,0,0,.03);
        border-bottom: 1px solid rgba(0,0,0,.125);
        padding: .75rem 1.25rem;
    }
    .card-title {
        margin-bottom: 0;
    }
</style>
@endpush
