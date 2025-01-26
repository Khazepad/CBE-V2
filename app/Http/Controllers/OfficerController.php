<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OfficerController extends Controller
{
    public function login()
    {
        return view('officer.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Check if user exists and has officer or teacher role
        $user = User::where('email', $request->email)->first();

        if (!$user || !in_array($user->role->role_name, ['Admin', 'Teacher'])) {
            return back()->withErrors([
                'email' => 'This account does not have officer or teacher privileges.',
            ])->onlyInput('email');
        }

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('officer/dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function dashboard()
    {
        if (!Auth::check() || !in_array(Auth::user()->role->role_name, ['Admin', 'Teacher'])) {
            Auth::logout();
            return redirect()->route('officer.login')->withErrors([
                'email' => 'You do not have permission to access this area.',
            ]);
        }

        // Get your actual data from the database
        $data = [
            'totalStudents' => User::whereHas('role', function ($query) {
                $query->where('role_name', 'Students');
            })->count(),
            'pendingApplications' => 0, // Add your logic here
            'approvedApplications' => 0, // Add your logic here
            'rejectedApplications' => 0, // Add your logic here
            'todayAppointments' => 0, // Add your logic here
        ];

        return view('officer.dashboard', $data);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
