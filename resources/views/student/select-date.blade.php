@extends('layouts.admin')

@section('title', 'Select Date')

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
                        <li class="breadcrumb-item active">Select Date</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid1 py-4">
        <h3 class="text-primary mb-4 text-center">Please select your preferred date and time of appointment.</h3>

        <!-- Calendar Container -->
        <div class="calendar-wrapper">
            <div id="calendar"></div>
        </div>

        <!-- Back Button -->
        <div class="mt-4">
            <a href="{{ route('student.appointment-calendar') }}" class="btn btn-secondary">Back</a>
        </div>
    </div>
@stop
