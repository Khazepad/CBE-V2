@extends('layouts.app')

@section('content')
<div class="container">
    <header class="header">
        <h1>Create Appointment Slots</h1>
        <p>Set available appointment slots for students</p>
    </header>

    <div class="grid">
        <div class="card">
            <form id="appointment-form" method="POST" action="{{ route('officer.appointments.store') }}">
                @csrf

                <div class="form-group">
                    <label for="date">Date</label>
                    <input type="date" id="date" name="date" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="time">Time</label>
                    <input type="time" id="time" name="time" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="duration">Duration (minutes)</label>
                    <select id="duration" name="duration" class="form-control" required>
                        <option value="15">15 minutes</option>
                        <option value="30" selected>30 minutes</option>
                        <option value="45">45 minutes</option>
                        <option value="60">1 hour</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="max_students">Maximum Students</label>
                    <input type="number" id="max_students" name="max_students" class="form-control" min="1" value="1" required>
                </div>

                <div class="form-group">
                    <label for="purpose">Purpose</label>
                    <select id="purpose" name="purpose" class="form-control" required>
                        <option value="consultation">Consultation</option>
                        <option value="document_request">Document Request</option>
                        <option value="academic_advising">Academic Advising</option>
                        <option value="other">Other</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="notes">Additional Notes</label>
                    <textarea id="notes" name="notes" class="form-control" rows="3"></textarea>
                </div>

                <button type="submit" class="btn">Create Appointment Slot</button>
            </form>
        </div>

        <div class="card">
            <h2>Students with Appointments</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>Student Name</th>
                        <th>Appointment Date</th>
                        <th>Appointment Time</th>
                        <th>Purpose</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($appointments as $appointment)
                        @foreach($appointment->students as $student)
                            <tr>
                                <td data-label="Student Name">{{ $student->name }}</td>
                                <td data-label="Appointment Date">{{ $appointment->date }}</td>
                                <td data-label="Appointment Time">{{ $appointment->time }}</td>
                                <td data-label="Purpose">{{ $appointment->purpose }}</td>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    /* Reset and base styles */
    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    body {
        font-family: Arial, sans-serif;
        line-height: 1.6;
        color: #333;
        background-color: #f4f4f4;
    }

    .container {
        width: 90%;
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }

    /* Header styles */
    .header {
        margin-bottom: 30px;
    }

    .header h1 {
        font-size: 24px;
        color: #2c3e50;
    }

    .header p {
        color: #7f8c8d;
    }

    /* Grid layout */
    .grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 20px;
    }

    @media (min-width: 768px) {
        .grid {
            grid-template-columns: 1fr 2fr;
        }
    }

    /* Card styles */
    .card {
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        padding: 20px;
    }

    /* Form styles */
    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
    }

    .form-control {
        width: 100%;
        padding: 8px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 16px;
    }

    select.form-control {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%23333' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14L2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 8px center;
        padding-right: 28px;
    }

    .btn {
        display: inline-block;
        background-color: #3498db;
        color: #fff;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
        transition: background-color 0.3s;
    }

    .btn:hover {
        background-color: #2980b9;
    }

    /* Table styles */
    .table {
        width: 100%;
        border-collapse: collapse;
    }

    .table th,
    .table td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    .table th {
        background-color: #f2f2f2;
        font-weight: bold;
    }

    .table tr:last-child td {
        border-bottom: none;
    }

    @media (max-width: 600px) {
        .table, .table thead, .table tbody, .table th, .table td, .table tr {
            display: block;
        }

        .table thead tr {
            position: absolute;
            top: -9999px;
            left: -9999px;
        }

        .table tr {
            border: 1px solid #ccc;
            margin-bottom: 10px;
        }

        .table td {
            border: none;
            position: relative;
            padding-left: 50%;
        }

        .table td:before {
            content: attr(data-label);
            position: absolute;
            left: 6px;
            width: 45%;
            padding-right: 10px;
            white-space: nowrap;
            font-weight: bold;
        }
    }
</style>
@endsection
