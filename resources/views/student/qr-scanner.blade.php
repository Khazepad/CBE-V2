@extends('layouts.admin')

@section('title', 'QR Code Scanner')

@section('content_header')
    <h1>QR Code Scanner</h1>
@stop

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Scan QR Code</h3>
                    </div>
                    <div class="card-body">
                        <!-- Camera Selection Dropdown -->
                        <div class="form-group mb-3">
                            <select id="cameraSelection" class="form-control">
                                <option value="">Select Camera</option>
                            </select>
                        </div>
                        
                        <!-- QR Reader Container with fixed dimensions -->
                        <div id="qr-reader" style="width: 100%; max-width: 600px; min-height: 400px;"></div>
                        <div id="qr-reader-results" class="mt-3"></div>
                    </div>
                </div>
            </div>
            
            <!-- Results Panel -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Scan Results</h3>
                    </div>
                    <div class="card-body">
                        <div id="appointment-details" style="display: none;">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th style="width: 30%">Appointment ID</th>
                                        <td id="appointment-id"></td>
                                    </tr>
                                    <tr>
                                        <th>Purpose</th>
                                        <td id="appointment-purpose"></td>
                                    </tr>
                                    <tr>
                                        <th>Date</th>
                                        <td id="appointment-date"></td>
                                    </tr>
                                    <tr>
                                        <th>Time</th>
                                        <td id="appointment-time"></td>
                                    </tr>
                                    <tr>
                                        <th>Admin</th>
                                        <td id="appointment-admin"></td>
                                    </tr>
                                    <tr>
                                        <th>Student</th>
                                        <td id="appointment-student"></td>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <td><span id="appointment-status" class="badge badge-primary"></span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div id="scan-message" class="text-center py-4">
                            <i class="fas fa-qrcode fa-3x mb-3"></i>
                            <p class="text-muted">Please scan a QR code to view appointment details</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <style>
        #qr-reader {
            border: 2px solid #ddd;
            border-radius: 4px;
        }
        
        #qr-reader__scan_region {
            background: white;
        }
        
        #qr-reader__dashboard {
            padding: 10px;
        }
        
        .result-container {
            padding: 15px;
            margin-top: 20px;
            border-radius: 4px;
        }
    </style>
@stop

@section('js')
    <script src="https://unpkg.com/html5-qrcode"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const html5QrCode = new Html5Qrcode("qr-reader");
            const cameraSelection = document.getElementById('cameraSelection');
            
            // First, get all cameras
            Html5Qrcode.getCameras().then(devices => {
                if (devices && devices.length) {
                    // Add cameras to dropdown
                    devices.forEach(device => {
                        const option = document.createElement('option');
                        option.value = device.id;
                        option.text = device.label || `Camera ${cameraSelection.length + 1}`;
                        cameraSelection.add(option);
                    });
                    
                    // Start scanner with first camera
                    startScanner(devices[0].id);
                }
            }).catch(err => {
                console.error('Error getting cameras', err);
                alert('Error getting cameras. Please make sure you have granted camera permissions.');
            });
            
            // Handle camera selection change
            cameraSelection.addEventListener('change', function(e) {
                if (e.target.value) {
                    html5QrCode.stop().then(() => {
                        startScanner(e.target.value);
                    });
                }
            });
            
            function startScanner(cameraId) {
                html5QrCode.start(
                    cameraId,
                    {
                        fps: 10,
                        qrbox: { width: 250, height: 250 }
                    },
                    onScanSuccess,
                    onScanFailure
                ).catch(err => {
                    console.error('Error starting scanner:', err);
                    alert('Error starting scanner. Please check camera permissions.');
                });
            }
            
            function onScanSuccess(decodedText, decodedResult) {
                // Play success sound
                const audio = new Audio('/audio/beep.mp3');
                audio.play().catch(e => console.log('Audio play failed:', e));
                
                // Extract appointment ID from URL
                try {
                    const url = new URL(decodedText);
                    const pathSegments = url.pathname.split('/');
                    const appointmentId = pathSegments[pathSegments.length - 1];
                    
                    // Show loading state
                    document.getElementById('scan-message').innerHTML = `
                        <div class="spinner-border text-primary" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                        <p class="mt-2">Loading appointment details...</p>
                    `;
                    
                    // Fetch appointment details
                    fetch(`/appointment-scan/${appointmentId}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                document.getElementById('appointment-details').style.display = 'block';
                                document.getElementById('scan-message').style.display = 'none';
                                
                                // Update all fields
                                document.getElementById('appointment-id').textContent = data.appointment.id;
                                document.getElementById('appointment-purpose').textContent = data.appointment.purpose;
                                document.getElementById('appointment-date').textContent = data.appointment.appointment_date;
                                document.getElementById('appointment-time').textContent = data.appointment.appointment_time;
                                document.getElementById('appointment-admin').textContent = data.appointment.admin;
                                document.getElementById('appointment-student').textContent = data.appointment.student;
                                document.getElementById('appointment-status').textContent = data.appointment.status;
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Failed to fetch appointment details. Please try again.'
                            });
                        });
                } catch (error) {
                    console.error('Error processing QR code:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Invalid QR Code',
                        text: 'The scanned QR code is not valid for this system.'
                    });
                }
            }
            
            function onScanFailure(error) {
                // Handle scan failure silently
                console.warn(`QR scan error = ${error}`);
            }
        });
    </script>
@stop