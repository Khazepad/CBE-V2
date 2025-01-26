<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;
use DateTime;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use PDF;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Mail\AppointmentConfirmation;
use Illuminate\Support\Facades\Mail;

class StudentAppointmentController extends Controller
{
    public function index()
    {
        return view('student.appointment-calendar');
    }

    public function searchAdmins(Request $request)
    {
        $query = $request->input('query');
        $admins = User::whereHas('role', function ($q) {
            $q->where('role_name', 'Admin');
        })->where(function ($q) use ($query) {
            $q->where('name', 'like', '%' . $query . '%')
              ->orWhere('last_name', 'like', '%' . $query . '%');
        })->with('role:id,role_name')->get(['id', 'name', 'last_name', 'role_id']);

        return response()->json($admins);
    }

    public function storeStep1(Request $request)
    {
        $request->validate([
            'teacher_id' => 'required|exists:users,id',
            'comments' => 'required|string|max:500'
        ]);

        $request->session()->put('admin_id', $request->input('teacher_id'));
        $request->session()->put('purpose', $request->input('comments'));
        return redirect()->route('student.appointment-calendar.select-date');
    }

    public function selectDate()
    {
        return view('student.select-date');
    }

    public function dateSelected(Request $request)
    {
        $request->validate([
            'date' => 'required|date|after_or_equal:today' // Allow today and future dates
        ]);

        $request->session()->put('appointment_date', $request->query('date'));
        $date = $request->query('date');

        // Get available slots for the selected date
        $slots = $this->getAvailableSlots($date);

        return view('student.date-selected', compact('date', 'slots'));
    }

    public function storeStep2(Request $request)
    {
        $request->validate([
            'time' => 'required|string'
        ]);

        $time = $request->input('time');
        $formattedTime = DateTime::createFromFormat('h:i A', $time)->format('H:i:s');
        $request->session()->put('appointment_time', $formattedTime);
        return redirect()->route('student.appointment-calendar.confirm-details');
    }

    public function confirmDetails(Request $request)
    {
        // Validate session data
        if (!$request->session()->has(['admin_id', 'purpose', 'appointment_date', 'appointment_time'])) {
            return redirect()->route('student.appointment-calendar')
                           ->with('error', 'Please complete all steps of the appointment booking process.');
        }

        $adminId = $request->session()->get('admin_id');
        $purpose = $request->session()->get('purpose');
        $appointmentDate = $request->session()->get('appointment_date');
        $appointmentTime = $request->session()->get('appointment_time');
        $admin = User::find($adminId);

        return view('student.appointment-confirm-details', compact('admin', 'purpose', 'appointmentDate', 'appointmentTime'));
    }

    public function store(Request $request)
    {
        // Validate session data
        if (!$request->session()->has(['admin_id', 'purpose', 'appointment_date', 'appointment_time'])) {
            return redirect()->route('student.appointment-calendar')
                           ->with('error', 'Please complete all steps of the appointment booking process.');
        }

        $adminId = $request->session()->get('admin_id');
        $purpose = $request->session()->get('purpose');
        $appointmentDate = $request->session()->get('appointment_date');
        $appointmentTime = $request->session()->get('appointment_time');
        $userId = Auth::id();

        // Generate Booking Reference Number
        $bookingReferenceNumber = $this->generateBookingReferenceNumber();

        // Create appointment
        $appointment = new Appointment();
        $appointment->admin_id = $adminId;
        $appointment->user_id = $userId;
        $appointment->purpose = $purpose;
        $appointment->appointment_date = $appointmentDate;
        $appointment->appointment_time = $appointmentTime;
        $appointment->status = 'pending'; // Default status
        $appointment->booking_reference_number = $bookingReferenceNumber;
        $appointment->save();

        // Generate QR Code
        $qrCode = QrCode::size(100)->generate($bookingReferenceNumber);

        // Send email notification
        Mail::to(Auth::user()->email)->send(new AppointmentConfirmation($appointment));

        // Clear session data
        $request->session()->forget(['admin_id', 'purpose', 'appointment_date', 'appointment_time']);

        return view('student.appointment-success', compact('appointment', 'qrCode'));
    }

    public function appointmentHistory()
    {
        $appointments = Appointment::where('user_id', Auth::id())->get();
        return view('student.appointment-history', compact('appointments'));
    }

    public function showAppointmentDetails($id)
    {
        $appointment = Appointment::with('admin')->findOrFail($id);
        $user = Auth::user();

        // Generate QR Code
        $qrCode = QrCode::size(100)->generate($appointment->booking_reference_number);

        return view('student.appointment-details', compact('appointment', 'qrCode'));
    }

    public function appointmentDetails($id)
    {
        $appointment = Appointment::with('admin')->findOrFail($id);
        return view('student.appointment-details', compact('appointment'));
    }

    public function exportPDF($id)
    {
        $appointment = Appointment::with('admin')->findOrFail($id);
        $user = Auth::user();

        // Generate QR Code
        $qrCode = QrCode::size(100)->generate($appointment->booking_reference_number);

        // Load PDF view
        $pdf = PDF::loadView('student.appointment-pdf', compact('appointment', 'qrCode'));

        // Set PDF options
        $pdf->setPaper('A4');
        $pdf->setOptions([
            'isHtml5ParserEnabled' => true,
            'isPhpEnabled' => true,
            'isRemoteEnabled' => true,
            'isFontSubsettingEnabled' => true
        ]);

        // Generate filename
        $filename = 'appointment-' . $appointment->id . '-' . Carbon::now()->format('Y-m-d') . '.pdf';

        // Download PDF
        return $pdf->download($filename);
    }

    public function print($id)
    {
        $appointment = Appointment::with('admin')->findOrFail($id);
        $user = Auth::user();

        // Generate QR Code
        $qrCode = QrCode::size(100)->generate($appointment->booking_reference_number);

        return view('student.appointment-print', compact('appointment', 'qrCode'));
    }

    private function getAvailableSlots($date)
    {
        // Sample time slots - You can modify this based on your requirements
        return [
            ['time' => '07:00 AM', 'available_slots' => 26, 'percentage' => 47.3],
            ['time' => '07:30 AM', 'available_slots' => 49, 'percentage' => 83.1],
            ['time' => '08:00 AM', 'available_slots' => 12, 'percentage' => 78.4],
            ['time' => '08:30 AM', 'available_slots' => 52, 'percentage' => 94.5],
            ['time' => '09:00 AM', 'available_slots' => 30, 'percentage' => 54.5],
            ['time' => '09:30 AM', 'available_slots' => 51, 'percentage' => 92.7],
            ['time' => '10:00 AM', 'available_slots' => 32, 'percentage' => 58.2],
            ['time' => '10:30 AM', 'available_slots' => 49, 'percentage' => 89.1],
        ];
    }

    private function generateBookingReferenceNumber()
    {
        $uppercase = Str::random(3); // Generate 3 uppercase letters
        $lowercase = Str::random(3); // Generate 3 lowercase letters
        return strtoupper($uppercase) . strtolower($lowercase);
    }
}
