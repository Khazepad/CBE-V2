<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment; // Assuming you have an Appointment model

class OfficerAppointmentController extends Controller
{
    public function create()
    {
        // Fetch appointments from the database
        $appointments = Appointment::all();

        // Pass the appointments to the view
        return view('officer.appointments-create', compact('appointments'));
    }

    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'date' => 'required|date',
            'time' => 'required',
            'duration' => 'required|integer',
            'max_students' => 'required|integer|min:1',
            'purpose' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        // Create a new appointment
        $appointment = new Appointment();
        $appointment->officer_id = auth()->id();
        $appointment->date = $validatedData['date'];
        $appointment->time = $validatedData['time'];
        $appointment->duration = $validatedData['duration'];
        $appointment->max_students = $validatedData['max_students'];
        $appointment->purpose = $validatedData['purpose'];
        $appointment->notes = $validatedData['notes'] ?? '';
        $appointment->save();

        // Redirect with a success message
        return redirect()->route('officer.appointments.index')->with('status', 'Appointment created successfully!');
    }

    public function index()
    {
        $appointments = Appointment::with('students')->where('officer_id', auth()->id())->get();
        return view('officer.appointments.index', compact('appointments'));
    }
}
