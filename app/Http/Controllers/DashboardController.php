<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        // Get the authenticated student
        $student = Auth::user();

        // Get your actual data from the database
        $data = [
            'approved' => 0,  // Replace with actual count
            'pending' => 0,   // Replace with actual count
            'draft' => 0,     // Replace with actual count
            'all' => 0,       // Replace with actual count
            'rejected' => 0,  // Replace with actual count
            'archive' => 0,   // Replace with actual count
            'appointments' => [], // Replace with actual appointments
        ];

        return view('dashboard', $data);
    }
}
