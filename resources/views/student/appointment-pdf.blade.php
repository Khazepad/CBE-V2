<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            margin: 0;
            padding: 20px;
        }
        .appointment-slip {
            max-width: 750px;
            margin: 0 auto;
            background: white;
            padding: 20px;
        }
        .slip-header {
            color: #4a76c4;
            border-bottom: 1px solid #4a76c4;
            padding-bottom: 10px;
            margin-bottom: 20px;
            font-size: 24px;
            text-align: center;
        }
        .booking-status {
            color: #4a76c4;
            font-size: 20px;
            margin-bottom: 5px;
        }
        .timestamp {
            color: #666;
            font-size: 14px;
            margin-bottom: 3px;
        }
        .details-table {
            width: 100%;
            margin-top: 20px;
            background: #f8f9fa;
            border-radius: 5px;
            border-collapse: collapse;
        }
        .details-table td {
            padding: 10px;
            border-bottom: 1px solid #eee;
        }
        .details-table td:first-child {
            width: 200px;
            text-align: right;
            color: #4a76c4;
            padding-right: 20px;
        }
        .appointment-details {
            color: #4a76c4;
            margin: 20px 0 10px 20px;
            font-size: 18px;
        }
        .qr-code-container {
            text-align: center;
            margin: 40px 0;
        }
        .badge-success {
            color: #155724;
            background-color: #d4edda;
            border-radius: 4px;
            padding: 5px 10px;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="appointment-slip">
        <h1 class="slip-header">ADMS Appointment Slip</h1>
        
        <div class="qr-code-container">
            {!! $qrCode !!}
        </div>
        
        <div class="booking-status">Booked</div>
        <div class="timestamp">Created on {{ now()->format('l, M j, Y h:i A') }}</div>
        <div class="timestamp">As of {{ now()->format('l, M j, Y h:i A') }}</div>

        <div class="appointment-details">Appointment Details</div>
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
                    <span class="badge-success">Confirmed</span>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>