@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <style>
        .rectangle {
            width: 100%;
            height: 200px;
            background: linear-gradient(to bottom, white, #ffc61a);
            margin: 20px auto;
            border-radius: 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            position: relative;
            overflow: hidden;
        }

        .welcome-text {
            position: absolute;
            left: 50px;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .welcome-text h6 {
            font-size: 24px;
            font-weight: bold;
            margin: 0;
        }

        .welcome-text h1 {
            font-size: 32px;
            font-weight: bold;
            margin: 0;
        }

        .rectangle img {
            max-height: 200px;
            max-width: 40%;
            object-fit: contain;
            margin-left: auto;
            display: block;
        }

        .status-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 0.75rem;
            padding: 0.75rem;
        }

        .status-card {
            background: #fff;
            border-radius: 8px;
            padding: 1rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            transition: transform 0.2s;
        }

        .status-card:hover {
            transform: translateY(-2px);
        }

        .status-title {
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .status-count {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 0.25rem;
        }

        .progress {
            height: 6px;
            margin: 0.5rem 0;
        }

        .calendar-wrapper {
            background: #ffc107;
            border-radius: 8px;
            padding: 1rem;
            margin-top: 0.75rem;
        }

        .calendar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.75rem;
        }

        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 0.25rem;
        }

        .calendar-day {
            aspect-ratio: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255,255,255,0.9);
            border-radius: 4px;
            font-weight: 500;
            padding: 0.25rem;
            font-size: 0.8rem;
        }

        .calendar-day.today {
            background: #fff;
            border: 2px solid #0d6efd;
            font-weight: bold;
        }

        .calendar-day.other-month {
            opacity: 0.5;
        }

        .appointments-section {
            background: #fff;
            border-radius: 8px;
            padding: 1rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            height: 100%;
        }

        @media (max-width: 1024px) {
            .status-grid {
                grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            }
        }

        @media (max-width: 768px) {
            .rectangle {
                height: 180px;
                flex-direction: column;
                text-align: center;
                padding: 1rem;
            }

            .welcome-text {
                position: static;
                margin-bottom: 0.75rem;
                align-items: center;
            }

            .welcome-text h6 {
                font-size: 20px;
            }

            .welcome-text h1 {
                font-size: 28px;
            }

            .rectangle img {
                max-height: 80px !important;
                max-width: 100% !important;
                margin: 0.5rem auto !important;
                display: block;
            }

            .status-grid {
                grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
                padding: 0.5rem;
            }

            .calendar-grid {
                font-size: 0.8rem;
                gap: 0.2rem;
            }

            .calendar-day {
                padding: 0.2rem;
            }

            .row {
                flex-direction: column;
            }

            .col-md-8, .col-md-4 {
                width: 100%;
                padding: 0.5rem;
            }
        }

        @media (max-width: 480px) {
            .rectangle {
                height: 150px;
                padding: 0.75rem;
                margin: 10px auto;
            }

            .welcome-text h6 {
                font-size: 18px;
            }

            .welcome-text h1 {
                font-size: 24px;
            }

            .rectangle img {
                max-height: 60px !important;
            }

            .status-card {
                padding: 0.75rem;
            }

            .status-title {
                font-size: 0.8rem;
            }

            .status-count {
                font-size: 1.2rem;
            }

            .calendar-wrapper {
                padding: 0.75rem;
            }
        }
    </style>

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        
    <!-- /.content-header -->

    <!-- Welcome Banner -->
    <div class="rectangle">
        <div class="welcome-text">
            <h1>Welcome, {{ $name }} {{ $last_name }}!</h1>
        </div>
        <img src="{{ asset('images/dep1.png') }}" alt="Department Image" class="img-fluid">
    </div>

    <!-- Status Cards -->
    <div class="status-grid">
        <div class="status-card">
            <div class="status-title">Approved</div>
            <div class="status-count">0</div>
            <div class="progress">
                <div class="progress-bar bg-success" style="width: 0%"></div>
            </div>
            <div>Applications</div>
        </div>

        <div class="status-card">
            <div class="status-title">Pending</div>
            <div class="status-count">0</div>
            <div class="progress">
                <div class="progress-bar bg-warning" style="width: 0%"></div>
            </div>
            <div>Applications</div>
        </div>

        <div class="status-card">
            <div class="status-title">Rejected</div>
            <div class="status-count">0</div>
            <div class="progress">
                <div class="progress-bar bg-danger" style="width: 0%"></div>
            </div>
            <div>Applications</div>
        </div>

        <div class="status-card">
            <div class="status-title">Archive</div>
            <div class="status-count">0</div>
            <div class="progress">
                <div class="progress-bar bg-light" style="width: 0%"></div>
            </div>
            <div>Applications</div>
        </div>
    </div>

    <!-- Appointments and Calendar Section -->
    <div class="row mt-3">
        <div class="col-md-8">
            <div class="appointments-section">
                <h5 class="card-title mb-3">Upcoming Appointments</h5>
                <p>No upcoming appointments</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="calendar-wrapper">
                <div class="calendar-header">
                    <button class="btn btn-light btn-sm" id="prevMonth">&lt;</button>
                    <h3 id="currentMonth" class="mb-0" style="font-size: 1rem;"></h3>
                    <button class="btn btn-light btn-sm" id="nextMonth">&gt;</button>
                </div>
                <div class="calendar-grid" id="calendarGrid">
                    <div class="calendar-day">Mon</div>
                    <div class="calendar-day">Tue</div>
                    <div class="calendar-day">Wed</div>
                    <div class="calendar-day">Thu</div>
                    <div class="calendar-day">Fri</div>
                    <div class="calendar-day">Sat</div>
                    <div class="calendar-day">Sun</div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let currentDate = new Date();
            let currentMonth = currentDate.getMonth();
            let currentYear = currentDate.getFullYear();

            const monthNames = ["January", "February", "March", "April", "May", "June",
                "July", "August", "September", "October", "November", "December"
            ];

            function updateCalendar() {
                const firstDay = new Date(currentYear, currentMonth, 1);
                const lastDay = new Date(currentYear, currentMonth + 1, 0);
                const startingDay = firstDay.getDay() || 7; // Convert Sunday from 0 to 7
                const monthLength = lastDay.getDate();

                document.getElementById('currentMonth').textContent =
                    `${monthNames[currentMonth]} ${currentYear}`;

                const calendarGrid = document.getElementById('calendarGrid');
                const headerRow = calendarGrid.innerHTML.split('</div>').slice(0, 7).join('</div>') + '</div>';
                calendarGrid.innerHTML = headerRow;

                // Previous month's days
                const prevMonthLastDay = new Date(currentYear, currentMonth, 0).getDate();
                for (let i = startingDay - 2; i >= 0; i--) {
                    calendarGrid.innerHTML += `
                        <div class="calendar-day other-month">
                            ${prevMonthLastDay - i}
                        </div>
                    `;
                }

                // Current month's days
                const today = new Date();
                for (let i = 1; i <= monthLength; i++) {
                    const isToday = today.getDate() === i &&
                                  today.getMonth() === currentMonth &&
                                  today.getFullYear() === currentYear;
                    calendarGrid.innerHTML += `
                        <div class="calendar-day ${isToday ? 'today' : ''}">
                            ${i}
                        </div>
                    `;
                }

                // Next month's days
                const remainingDays = 42 - (startingDay - 1) - monthLength;
                for (let i = 1; i <= remainingDays; i++) {
                    calendarGrid.innerHTML += `
                        <div class="calendar-day other-month">
                            ${i}
                        </div>
                    `;
                }
            }

            document.getElementById('prevMonth').addEventListener('click', function() {
                currentMonth--;
                if (currentMonth < 0) {
                    currentMonth = 11;
                    currentYear--;
                }
                updateCalendar();
            });

            document.getElementById('nextMonth').addEventListener('click', function() {
                currentMonth++;
                if (currentMonth > 11) {
                    currentMonth = 0;
                    currentYear++;
                }
                updateCalendar();
            });

            // Initial calendar render
            updateCalendar();
        });
    </script>
@endsection
