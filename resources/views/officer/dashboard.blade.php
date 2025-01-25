@extends('layouts.app')

@section('title', 'Officer Dashboard')

@section('content')
    <!-- Add Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .info-box {
            width: 18%;
            margin: 10px;
            padding: 20px;
            border-radius: 10px;
            background-color: #f8f9fa;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .info-box p {
            font-size: 24px;
            font-weight: bold;
            color: #333;
            margin-bottom: 0;
            text-align: center;
        }

        .info-box h5 {
            text-align: center;
            margin-bottom: 15px;
            color: #666;
        }

        .rectangle {
            width: 100%;
            height: 200px;
            background: linear-gradient(to bottom, white, #ffc61a);
            margin: 20px auto;
            border-radius: 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .chart-container {
            margin: 20px 0;
        }

        .calendar {
            margin-top: 20px;
            padding: 10px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            width: 80%;
            margin: auto;
        }

        .h1, h6 {
            font-size: 24px;
            font-weight: bold;
            justify-content: left;
        }
    </style>

    <div class="rectangle" style="display: flex; justify-content: space-between;">
        <h6 style="margin-left: 0; margin-bottom: 10px; margin-right: 399px;">WELCOME TO</h6>
        <h1 style="margin-left: -1000px; margin-bottom: -80px;">OFFICER DASHBOARD</h1>
        <img src="{{ asset('images/dep1.png') }}" alt="Description of image" class="img-fluid" style="max-height: 200px; margin-right: 400px;">
    </div>

    <div class="info-boxes d-flex flex-wrap justify-content-between">
        <div class="info-box">
            <h5>Total Students</h5>
            <div class="progress mb-2">
                <div class="progress-bar bg-success" style="width: 75%"></div>
            </div>
            <p>{{ number_format($totalStudents ?? 0) }}</p>
        </div>
        <div class="info-box">
            <h5>Pending Applications</h5>
            <div class="progress">
                <div class="progress-bar bg-warning" style="width: 45%"></div>
            </div>
            <p class="mt-2">{{ $pendingApplications ?? 0 }} </p>
        </div>
        <div class="info-box">
            <h5>Approved Applications</h5>
            <div class="progress">
                <div class="progress-bar bg-info" style="width: 60%"></div>
            </div>
            <p class="mt-2">{{ $approvedApplications ?? 0 }}</p>
        </div>
        <div class="info-box">
            <h5>Rejected Applications</h5>
            <div class="progress">
                <div class="progress-bar bg-danger" style="width: 25%"></div>
            </div>
            <p class="mt-2">{{ $rejectedApplications ?? 0 }}</p>
        </div>
        <div class="info-box">
            <h5>Today's Appointments</h5>
            <div class="progress">
                <div class="progress-bar bg-primary" style="width: 40%"></div>
            </div>
            <p class="mt-2">{{ $todayAppointments ?? 0 }}</p>
        </div>
    </div>

    <div class="d-flex justify-content-between">
        <div class="chart-container" style="flex: 1;">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Recent Applications</h5>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Student Name</th>
                                <th>Application Type</th>
                                <th>Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Add your table rows here -->
                            <tr>
                                <td>John Doe</td>
                                <td>Enrollment</td>
                                <td>2024-03-15</td>
                                <td><span class="badge badge-warning">Pending</span></td>
                            </tr>
                            <!-- Add more rows as needed -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="calendar" style="background-color: #ffc107; padding: 10px; border-radius: 10px; width: 30%; margin-left: 20px;">
            @php
                $defaultDate = Carbon\Carbon::now('Asia/Manila');
                $requestedDate = request('date') ? Carbon\Carbon::parse(request('date')) : $defaultDate;
                $today = Carbon\Carbon::now('Asia/Manila')->day;
            @endphp

            <div class="d-flex justify-content-between align-items-center mb-2">
                <a href="?date={{ $requestedDate->copy()->subMonth()->format('Y-m') }}" class="btn btn-sm btn-light">&lt;</a>
                <h3 style="font-size: 18px; font-weight: bold; margin-bottom: 0;">
                    {{ $requestedDate->format('F Y') }}
                </h3>
                <a href="?date={{ $requestedDate->copy()->addMonth()->format('Y-m') }}" class="btn btn-sm btn-light">&gt;</a>
            </div>
            
            <table class="table table-bordered table-sm text-center">
                <thead>
                    <tr>
                        <th>M</th>
                        <th>T</th>
                        <th>W</th>
                        <th>T</th>
                        <th>F</th>
                        <th>S</th>
                        <th>S</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $date = $requestedDate->copy()->startOfMonth();
                        $daysInMonth = $date->daysInMonth;
                        $firstDayOfWeek = $date->dayOfWeek;
                        $firstDayOfWeek = $firstDayOfWeek == 0 ? 7 : $firstDayOfWeek;
                    @endphp

                    <tr>
                        @for ($i = 1; $i < $firstDayOfWeek; $i++)
                            <td></td>
                        @endfor

                        @for ($day = 1; $day <= $daysInMonth; $day++)
                            @if ($firstDayOfWeek > 7)
                                </tr><tr>
                                @php $firstDayOfWeek = 1 @endphp
                            @endif

                            <td style="@if($day == $today && $requestedDate->format('Y-m') == $defaultDate->format('Y-m')) background-color: #fff3cd; font-weight: bold; 
                                       @elseif(isset($holidays[sprintf('%02d-%02d', $requestedDate->format('m'), $day)])) background-color: #ffcccb; @endif">
                                {{ $day }}
                            </td>

                            @php $firstDayOfWeek++ @endphp
                        @endfor

                        @while($firstDayOfWeek <= 7)
                            <td></td>
                            @php $firstDayOfWeek++ @endphp
                        @endwhile
                    </tr>
                </tbody>
            </table>
            
            <!-- Year Navigation -->
            <div class="d-flex justify-content-between align-items-center mb-2">
                <a href="?date={{ $requestedDate->copy()->subYears(2)->format('Y-m') }}" class="btn btn-sm btn-light">{{ $requestedDate->copy()->subYears(2)->format('Y') }}</a>
                <a href="?date={{ $requestedDate->copy()->subYear()->format('Y-m') }}" class="btn btn-sm btn-light">{{ $requestedDate->copy()->subYear()->format('Y') }}</a>
                <span class="btn btn-sm btn-warning">{{ $requestedDate->format('Y') }}</span>
                <a href="?date={{ $requestedDate->copy()->addYear()->format('Y-m') }}" class="btn btn-sm btn-light">{{ $requestedDate->copy()->addYear()->format('Y') }}</a>
                <a href="?date={{ $requestedDate->copy()->addYears(2)->format('Y-m') }}" class="btn btn-sm btn-light">{{ $requestedDate->copy()->addYears(2)->format('Y') }}</a>
            </div>

            <div class="d-flex justify-content-start mt-2" style="font-size: 12px;">
                <div class="mr-3">
                    <span style="display: inline-block; width: 12px; height: 12px; background-color: #fff3cd; margin-right: 5px;"></span>
                    Today
                </div>
                <div>
                    <span style="display: inline-block; width: 12px; height: 12px; background-color: #ffcccb; margin-right: 5px;"></span>
                    Holiday
                </div>
            </div>
        </div>
    </div>

    @if(session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
@endsection
