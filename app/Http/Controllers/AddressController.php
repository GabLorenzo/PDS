<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Address;

class AddressController extends Controller
{
    public function store(Request $request)
    {
        // Validate the request
        // $validatedData = $request->validate([
        //     'address_type' => 'boolean',
        //     'country' => 'required_if:address_type,Permanent|string',
        //     'province' => 'required_if:address_type,Permanent|string',
        //     'city' => 'required_if:address_type,Permanent|string',
        //     'barangay' => 'required_if:address_type,Permanent|string',
        //     'house_number' => 'required_if:address_type,Permanent|string',
        //     'zip_code' => 'required_if:address_type,Permanent|string',
        //     'temp_country' => 'nullable|string',
        //     'temp_province' => 'nullable|string',
        //     'temp_city' => 'nullable|string',
        //     'temp_barangay' => 'nullable|string',
        //     'temp_house_number' => 'nullable|string',
        //     'temp_zip_code' => 'nullable|string',
        // ]);

        // // Create a new AddressInfo record
        // $addressInfo = Address::create($validatedData);

        $request->validate([
            'address_type' => 'required|boolean',
            'country' => 'nullable|string',
            'province' => 'nullable|string',
            'city' => 'nullable|string',
            'barangay' => 'nullable|string',
            'house_number' => 'nullable|string',
            'zip_code' => 'nullable|string',
            'temp_country' => 'nullable|string',
            'temp_province' => 'nullable|string',
            'temp_city' => 'nullable|string',
            'temp_barangay' => 'nullable|string',
            'temp_house_number' => 'nullable|string',
            'temp_zip_code' => 'nullable|string',
        ]);
    
        // Use authenticated user's username as stud_Id
        $studId = auth()->user()->username;
    
        AddressInfo::create([
            'stud_Id' => $studId,
            'address_type' => $request->address_type,
            'country' => $request->country,
            'province' => $request->province,
            'city' => $request->city,
            'barangay' => $request->barangay,
            'house_number' => $request->house_number,
            'zip_code' => $request->zip_code,
            'temp_country' => $request->temp_country,
            'temp_province' => $request->temp_province,
            'temp_city' => $request->temp_city,
            'temp_barangay' => $request->temp_barangay,
            'temp_house_number' => $request->temp_house_number,
            'temp_zip_code' => $request->temp_zip_code,
        ]);
    
        return response()->json(['message' => 'Address info saved successfully']);
    }
}
