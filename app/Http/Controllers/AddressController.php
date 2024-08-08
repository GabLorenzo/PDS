<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Address;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
 public function store(Request $request)
{

    // Validate the request
    $validated = $request->validate([
        'permanent.country' => 'required|string|max:255',
        'permanent.province' => 'required|string|max:255',
        'permanent.city' => 'required|string|max:255',
        'permanent.barangay' => 'required|string|max:255',
        'permanent.house_number' => 'required|string|max:255',
        'permanent.zip_code' => 'required|string|max:255',
        'temporary.country' => 'nullable|string|max:255',
        'temporary.province' => 'nullable|string|max:255',
        'temporary.city' => 'nullable|string|max:255',
        'temporary.barangay' => 'nullable|string|max:255',
        'temporary.house_number' => 'nullable|string|max:255',
        'temporary.zip_code' => 'nullable|string|max:255',
    ]);

    $addresses = [
        'permanent' => [
            'user_id' => $request->user_id = auth()->user()->username,
            'address_type' => 'permanent',
            'country' => $request->permanent['country'],
            'province' => $request->permanent['province'],
            'city' => $request->permanent['city'],
            'barangay' => $request->permanent['barangay'],
            'house_number' => $request->permanent['house_number'],
            'zip_code' => $request->permanent['zip_code'],
        ],
        'temporary' => [
            'user_id' => $request->user_id = auth()->user()->username,
            'address_type' => 'temporary',
            'country' => $request->temporary['country'],
            'province' => $request->temporary['province'],
            'city' => $request->temporary['city'],
            'barangay' => $request->temporary['barangay'],
            'house_number' => $request->temporary['house_number'],
            'zip_code' => $request->temporary['zip_code'],
        ],
    ];

    foreach ($addresses as $addressData) {
        Address::updateOrCreate(
            ['user_id' => $addressData['user_id'], 'address_type' => $addressData['address_type']],
            $addressData
        );
    }

    return response()->json(['message' => 'Addresses saved successfully']);
}


}
