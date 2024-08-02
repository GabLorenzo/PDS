<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PersonalInfo;
use Illuminate\Support\Facades\Auth;

class PersonalInfoController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate the request data
        dd(Auth::user());
        $request->validate([
            'surname' => 'required|string|max:100',
            'firstname' => 'required|string|max:100',
            'middlename' => 'nullable|string|max:100',
            'extname' => 'nullable|string|max:50',
            'dob' => 'required|date',
            'placeOfBirth' => 'required|string|max:255',
            'sex' => 'required|in:Male,Female',
            'citizenship' => 'required|in:Filipino,Dual',
            'dualType' => 'nullable|required_if:citizenship,Dual|in:By Birth,By Naturalization',
            'dualCountry' => 'nullable|required_if:citizenship,Dual|string|max:100',
            'height' => 'required|numeric',
            'weight' => 'required|numeric',
            'bloodType' => 'nullable|string|max:5',
            'civilStatus' => 'required|in:Single,Married,Widowed,Separated,Divorced',
            'email' => 'required|email|max:255',
        ]);
        
        
        // Create a new PersonalInfo record
        $personalInfo = new PersonalInfo($request->all());
        $personalInfo->stud_Id = Auth::user()->username; // Set the foreign key
        $personalInfo->save();

        return response()->json(['message' => 'Form data saved successfully!'], 200);
    }
}
