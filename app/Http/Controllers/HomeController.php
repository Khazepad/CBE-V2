<?php

namespace App\Http\Controllers;

use App\Http\Controllers\HomeController; // Ensure this line is present
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application home.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('home'); // Ensure you have a home.blade.php view
    }
}
