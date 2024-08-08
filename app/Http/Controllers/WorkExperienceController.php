<?php

namespace App\Http\Controllers;

use App\Models\WorkExperience;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WorkExperienceController extends Controller
{
    public function store(Request $request)
{
    // Log or dump the request data
    \Log::info('Request Data:', $request->all());

    // Validate the incoming request
    $request->validate([
        'address' => 'required|string|max:255',
        'contact' => 'required|string|max:255',
        'inclusive_dates' => 'required|string|max:255',
        'position_title' => 'required|string|max:255',
        'department' => 'required|string|max:255',
        'monthly_salary' => 'required|numeric',
        'salary_grade' => 'required|string|max:255',
        'appointment_status' => 'required|string|max:255',
        'govt_service' => 'required|string|max:3',
    ]);

    // Create a new WorkExperience entry
    $workExperience = new WorkExperience($request->all());
    $workExperience->username = Auth::user()->username; // Set the foreign key
    $workExperience->save();

    // Return the saved work experience as a JSON response
    return response()->json($workExperience, 201);
}

    public function index()
    {
        $username = Auth::user()->username;
        $workExperiences = WorkExperience::where('username', $username)->get();

        // Return the list of work experiences as a JSON response
        return response()->json($workExperiences);
    }
    public function destroy($id)
{
    try {
        $workExperience = WorkExperience::findOrFail($id);
        $workExperience->delete();
        return response()->json(['message' => 'Work experience deleted successfully']);
    } catch (\Exception $e) {
        return response()->json(['message' => 'Error deleting work experience'], 500);
    }
}
}
