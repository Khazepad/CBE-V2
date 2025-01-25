<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;

class StudentAppointmentController extends Controller
{
    public function book(Request $request)
    {
        try {
            $appointment = Appointment::findOrFail($request->appointment_id);
            
            // Check if student already booked this appointment
            if ($appointment->students()->where('student_id', auth()->id())->exists()) {
                return redirect()->back()->with('error', 'You have already booked this appointment.');
            }

            // Check if there are available slots
            if ($appointment->students()->count() >= $appointment->max_students) {
                return redirect()->back()->with('error', 'This appointment is already full.');
            }

            // Attach the student to the appointment
            $appointment->students()->attach(auth()->id());

            return redirect()->back()->with('success', 'Appointment booked successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to book appointment. Please try again.');
        }
    }
}
