<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SchoolYear;
use App\Models\Semester;

class AcademicSettingsController extends Controller
{
    public function index()
    {
        $schoolYears = SchoolYear::all();
        $semesters = Semester::all();
        $settings = [
            'defaultSchoolYear' => SchoolYear::where('is_default', true)->first(),
            'defaultSemester' => Semester::where('is_default', true)->first(),
        ];

        return view('admin.general.settings', compact('schoolYears', 'semesters', 'settings'));
    }

    public function setDefaultSchoolYear(Request $request)
    {
        // Validate the request
        $request->validate([
            'year' => 'required|string|exists:school_years,year',
        ]);

        // Update the default school year
        SchoolYear::where('is_default', true)->update(['is_default' => false]);
        SchoolYear::where('year', $request->input('year'))->update(['is_default' => true]);

        return redirect()->back()->with('success', 'Default school year set successfully.');
    }

    public function setDefaultSemester(Request $request)
    {
        // Validate the request
        $request->validate([
            'semester' => 'required|string|exists:semesters,semester',
        ]);

        // Update the default semester
        Semester::where('is_default', true)->update(['is_default' => false]);
        Semester::where('semester', $request->input('semester'))->update(['is_default' => true]);

        return redirect()->back()->with('success', 'Default semester set successfully.');
    }
}
