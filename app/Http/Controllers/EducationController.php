<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EducationBackground;

class EducationController extends Controller
{
    public function store(Request $request)
        {
            $data = $request->validate([
                'degree' => 'required|string',
                'institution' => 'required|string',
                'yearOfGraduation' => 'required|integer',
                'address' => 'nullable|string',
                'basicEducation' => 'nullable|string',
                'highestLevel' => 'nullable|string',
            ]);

            $username = auth()->user()->username;

            EducationBackground::updateOrCreate(
                [
                    'degree' => $data['degree'],
                    'username' => $username
                ],
                array_merge($data, ['username' => $username])
            );

            return response()->json(['message' => 'Education data saved successfully']);
        }

    public function index()
        {
            $user = auth()->user();
            if (!$user) {
                return response()->json(['message' => 'Unauthorized'], 401);
            }

            $username = $user->username;
            $educationEntries = EducationBackground::where('username', $username)->get();

            return response()->json($educationEntries);
        }

    public function destroy($id)
        {
            $educationEntry = EducationBackground::find($id);

            if ($educationEntry) {
                $educationEntry->delete();
                return response()->json(['message' => 'Entry deleted successfully.'], 200);
            } else {
                return response()->json(['message' => 'Entry not found.'], 404);
            }
        }
}
