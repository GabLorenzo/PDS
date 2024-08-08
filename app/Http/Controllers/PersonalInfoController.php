<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PersonalInfo;
use Illuminate\Support\Facades\Auth;

class PersonalInfoController extends Controller
{
    public function store(Request $request)
{
    $request->validate([
        'surname' => 'required|string|max:255',
        'firstname' => 'required|string|max:255',
        'middlename' => 'nullable|string|max:255', // Allow null if optional
        'extname' => 'nullable|string|max:255',
        'dob' => 'required|date',
        'place_of_birth' => 'nullable|string|max:255',
        'sex' => 'required|string',
        'citizenship' => 'required|string',
        'dualType' => 'nullable|string',
        'dualCountry' => 'nullable|string',
        'height' => 'required|numeric',
        'weight' => 'required|numeric',
        'bloodType' => 'nullable|string',
        'civil_status' => 'required|string',
        'email' => 'required|email',
    ]);

    $personalInfo = new PersonalInfo();
    $personalInfo->user_id = auth()->user()->username; // Ensure this matches your logic
    $personalInfo->surname = $request->input('surname');
    $personalInfo->firstname = $request->input('firstname');
    $personalInfo->middlename = $request->input('middlename');
    $personalInfo->extname = $request->input('extname');
    $personalInfo->dob = $request->input('dob');
    $personalInfo->place_of_birth = $request->input('place_of_birth');
    $personalInfo->sex = $request->input('sex');
    $personalInfo->citizenship = $request->input('citizenship');
    $personalInfo->dualType = $request->input('dualType');
    $personalInfo->dualCountry = $request->input('dualCountry');
    $personalInfo->height = $request->input('height');
    $personalInfo->weight = $request->input('weight');
    $personalInfo->bloodType = $request->input('bloodType');
    $personalInfo->civil_status = $request->input('civil_status');
    $personalInfo->email = $request->input('email');
    $personalInfo->save();

    return response()->json(['message' => 'Personal info saved successfully']);
}

}
