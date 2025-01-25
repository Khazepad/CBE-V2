<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\User;
use App\Models\Notification;
use App\Models\AvailableDate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    public function showAppointmentCalendar()
    {
        $officersAndTeachers = User::whereIn('role', ['officer', 'teacher'])->get();
        $pendingAppointments = Appointment::where('student_id', Auth::id())->where('status', 'pending')->get();
        $scheduledAppointments = Appointment::where('student_id', Auth::id())->where('status', 'scheduled')->get();
        $completedAppointments = Appointment::where('student_id', Auth::id())->where('status', 'completed')->get();

        return view('student.appointment-calendar', compact('officersAndTeachers', 'pendingAppointments', 'scheduledAppointments', 'completedAppointments'));
    }

    public function showTeacherAppointments()
    {
        $pendingAppointments = Appointment::where('teacher_id', Auth::id())->where('status', 'pending')->get();
        $scheduledAppointments = Appointment::where('teacher_id', Auth::id())->where('status', 'scheduled')->get();
        $completedAppointments = Appointment::where('teacher_id', Auth::id())->where('status', 'completed')->get();

        return view('officer.appointments.appointments-manage', compact('pendingAppointments', 'scheduledAppointments', 'completedAppointments'));
    }

    public function requestAppointment(Request $request)
    {
        $request->validate([
            'teacher_id' => 'required|exists:users,id',
            'preferred_date_time' => [
                'nullable',
                'date',
                function ($attribute, $value, $fail) use ($request) {
                    $existingAppointment = Appointment::where('student_id', Auth::id())
                        ->where('teacher_id', $request->teacher_id)
                        ->where('preferred_date_time', $value)
                        ->where('status', 'pending')
                        ->first();

                    if ($existingAppointment) {
                        $fail('You already have a pending appointment request for this date and time.');
                    }
                },
            ],
            'flexible_availability' => 'boolean',
            'comments' => 'required|string|max:30',
        ]);

        $appointment = new Appointment([
            'student_id' => Auth::id(),
            'teacher_id' => $request->teacher_id,
            'preferred_date_time' => $request->preferred_date_time,
            'flexible_availability' => $request->has('flexible_availability') ? true : false,
            'comments' => $request->comments,
            'status' => 'pending',
        ]);

        $appointment->save();

        // Create notification for the teacher
        $notification = new Notification([
            'user_id' => $request->teacher_id,
            'message' => 'You have a new appointment request from ' . Auth::user()->name,
            'read' => false,
            'type' => 'appointment_request', // Add the type field
        ]);
        $notification->save();

        return redirect()->back()->with('success', 'Appointment request sent successfully.');
    }

    public function confirmAppointment(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->scheduled_date_time = $request->scheduled_date_time;
        $appointment->status = 'scheduled';
        $appointment->save();

        // Create notification for the student
        $notification = new Notification([
            'user_id' => $appointment->student_id,
            'message' => 'Your appointment has been confirmed for ' . $request->scheduled_date_time,
            'read' => false,
            'type' => 'appointment_confirmation', // Add the type field
        ]);
        $notification->save();

        return redirect()->back()->with('success', 'Appointment confirmed successfully.');
    }

    public function provideFeedback(Request $request, $id)
    {
        $request->validate([
            'feedback' => 'required|string',
        ]);

        $appointment = Appointment::findOrFail($id);
        $appointment->feedback = $request->feedback;
        $appointment->status = 'completed';
        $appointment->save();

        // Create notification for the teacher
        $notification = new Notification([
            'user_id' => $appointment->teacher_id,
            'message' => 'You have received feedback for the appointment with ' . Auth::user()->name,
            'read' => false,
            'type' => 'feedback_received', // Add the type field
        ]);
        $notification->save();

        return redirect()->back()->with('success', 'Feedback provided successfully.');
    }

    public function scheduleAppointment(Request $request, $appointmentId)
    {
        $request->validate([
            'scheduled_date_time' => 'required|date',
        ]);

        $appointment = Appointment::findOrFail($appointmentId);
        $appointment->update([
            'scheduled_date_time' => $request->scheduled_date_time,
            'status' => 'scheduled',
        ]);

        // Create notification for the student
        $notification = new Notification([
            'user_id' => $appointment->student_id,
            'message' => 'Your appointment has been scheduled for ' . $request->scheduled_date_time,
            'read' => false,
            'type' => 'appointment_scheduled', // Add the type field
        ]);
        $notification->save();

        return redirect()->back()->with('success', 'Appointment scheduled successfully!');
    }

    public function cancelAppointment($id)
    {
        $appointment = Appointment::findOrFail($id);

        // Create notification for the teacher
        $notificationForTeacher = new Notification([
            'user_id' => $appointment->teacher_id,
            'message' => 'The appointment with ' . Auth::user()->name . ' has been cancelled.',
            'read' => false,
            'type' => 'appointment_cancelled', // Add the type field
        ]);
        $notificationForTeacher->save();

        // Create notification for the student
        $notificationForStudent = new Notification([
            'user_id' => $appointment->student_id,
            'message' => 'Your appointment with ' . $appointment->teacher->name . ' has been cancelled.',
            'read' => false,
            'type' => 'appointment_cancelled', // Add the type field
        ]);
        $notificationForStudent->save();

        // Delete the appointment
        $appointment->delete();

        return redirect()->back()->with('success', 'Appointment cancelled successfully.');
    }

    public function markAsCompleted(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->status = 'completed';
        $appointment->save();

        // Create notification for the student
        $notification = new Notification([
            'user_id' => $appointment->student_id,
            'message' => 'Your appointment has been marked as completed.',
            'read' => false,
            'type' => 'appointment_completed', // Add the type field
        ]);
        $notification->save();

        return response()->json(['success' => 'Appointment marked as completed successfully.']);
    }

    public function markAvailability(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
        ]);

        $user = Auth::user();
        $user->available_dates()->create([
            'date' => $request->date,
        ]);

        return redirect()->back()->with('success', 'Availability marked successfully.');
    }

    public function getAvailableTeachers($date)
    {
        $availableTeachers = User::where('role', 'teacher')
            ->whereHas('available_dates', function ($query) use ($date) {
                $query->where('date', $date);
            })
            ->get();

        return response()->json($availableTeachers);
    }

    public function rescheduleAppointment(Request $request, $appointmentId)
    {
        $request->validate([
            'rescheduled_date_time' => 'required|date',
        ]);

        $appointment = Appointment::findOrFail($appointmentId);

        // Store the old scheduled date
        $appointment->old_scheduled_date_time = $appointment->scheduled_date_time;

        $appointment->update([
            'scheduled_date_time' => $request->rescheduled_date_time,
            'status' => 'scheduled',
        ]);

        // Create notification for the student
        $notification = new Notification([
            'user_id' => $appointment->student_id,
            'message' => 'Your appointment has been rescheduled from ' . \Carbon\Carbon::parse($appointment->old_scheduled_date_time)->format('M d, Y h:i A') . ' to ' . \Carbon\Carbon::parse($request->rescheduled_date_time)->format('M d, Y h:i A'),
            'read' => false,
            'type' => 'appointment_rescheduled', // Add the type field
        ]);
        $notification->save();

        return redirect()->back()->with('success', 'Appointment rescheduled successfully!');
    }
}
