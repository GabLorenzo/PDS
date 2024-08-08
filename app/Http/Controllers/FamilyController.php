<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Family;
use Illuminate\Support\Facades\Auth;

class FamilyController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'relation' => 'required|string',
            'name' => 'required|string',
            'age' => 'required|integer',
            'occupation' => 'required|string',
            'contactNumber' => 'required|string',
            'user_id' => 'required|string', // Changed from userId to user_id
        ]);

        $familyMember = new Family([
            'relation' => $validated['relation'],
            'name' => $validated['name'],
            'age' => $validated['age'],
            'occupation' => $validated['occupation'],
            'contactNumber' => $validated['contactNumber'],
            'user_id' => $validated['user_id'], // Changed from userId to user_id
        ]);

        $familyMember->save();

        return response()->json($familyMember);
    }

    public function index()
    {
        // Retrieve all family members for the authenticated user
        $user = Auth::user();
        return response()->json(Family::where('user_id', $user->username)->get());
    }

    public function bulkStore(Request $request)
    {
        $validated = $request->validate([
            'familyMembers' => 'required|array',
            'familyMembers.*.relation' => 'required|string',
            'familyMembers.*.name' => 'required|string',
            'familyMembers.*.age' => 'required|integer',
            'familyMembers.*.occupation' => 'required|string',
            'familyMembers.*.contactNumber' => 'required|string',
            'familyMembers.*.user_id' => 'required|string',
        ]);

        foreach ($validated['familyMembers'] as $memberData) {
            Family::create($memberData);
        }

        return response()->json(['message' => 'Family members added successfully']);
    }
    public function destroy($id)
{
    // Find the family member by ID and delete it
    $familyMember = Family::findOrFail($id);

    // Optionally check if the user is authorized to delete this record
    if ($familyMember->user_id !== Auth::user()->username) {
        return response()->json(['message' => 'Unauthorized'], 403);
    }

    $familyMember->delete();

    return response()->json(['message' => 'Family member removed successfully']);
}
}
