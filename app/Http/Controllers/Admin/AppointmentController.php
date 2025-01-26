<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    /**
     * Show the form for managing appointments.
     *
     * @return \Illuminate\View\View
     */
    public function manage(Request $request)
    {
        $user = Auth::user();

        // Check if the logged-in user has the 'Admin' role
        if ($user->role->role_name === 'Admin') {
            $status = $request->query('status', 'all');

            $query = Appointment::with(['user', 'admin'])
                ->where('admin_id', $user->id)
                ->whereHas('user', function ($query) {
                    $query->whereHas('role', function ($q) {
                        $q->where('role_name', 'Students');
                    });
                });

            if ($status !== 'all') {
                $query->where('status', $status);
            }

            $appointments = $query->get();

            return view('admin.appointments.manage', compact('appointments', 'status'));
        } else {
            // Redirect or show an error message if the user does not have the 'Admin' role
            return redirect()->back()->withErrors(['You do not have permission to access this page.']);
        }
    }
}
