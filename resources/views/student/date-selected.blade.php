@extends('layouts.admin')

@section('title', 'Selected Date')

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
                        <li class="breadcrumb-item active">Select Time</li>
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
                            <h3 class="card-title">Available slots for <strong>{{ $date }}</strong></h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('student.appointment-calendar.store-step2') }}" method="POST">
                                @csrf
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Time</th>
                                                <th>Available Slots</th>
                                                <th>Availability Percentage</th>
                                                <th>Select</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($slots as $slot)
                                                <tr>
                                                    <td>{{ $slot['time'] }}</td>
                                                    <td>{{ $slot['available_slots'] }}</td>
                                                    <td>
                                                        <div class="progress">
                                                            <div class="progress-bar" role="progressbar" style="width: {{ $slot['percentage'] }}%;" aria-valuenow="{{ $slot['percentage'] }}" aria-valuemin="0" aria-valuemax="100">{{ $slot['percentage'] }}%</div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <input type="radio" name="time" value="{{ $slot['time'] }}" required>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="card-footer">
                                    <a href="{{ route('student.appointment-calendar.select-date') }}" class="btn btn-secondary">Back</a>
                                    <button type="submit" class="btn btn-primary float-right">Next</button>
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
    .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }
    .progress {
        height: 20px;
    }
    .progress-bar {
        background-color: #007bff;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>
@endpush
