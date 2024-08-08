<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Award;
use Illuminate\Support\Facades\Auth;

class AwardController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'awardType' => 'required|string',   
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
           
        ]);

        $award = new Award();
        $award->name = $request->input('name');
        $award->description = $request->input('description');
        $award->awardType = $request->input('awardType');
        $award->username = Auth::user()->username; // Associate with the logged-in user
        $award->save();

        return response()->json($award);
    }

    public function index()
    {
        // Get awards for the logged-in user
        $username = Auth::user()->username;
        $awards = Award::where('username', $username)->get();
        return response()->json($awards);
    }

    public function destroy($id)
    {
        $award = Award::where('id', $id)
                      ->where('username', Auth::user()->username) // Ensure only the owner can delete
                      ->firstOrFail();
        $award->delete();
        return response()->json(['message' => 'Award removed successfully']);
    }
}
