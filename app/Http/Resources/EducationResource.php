<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\EducationResource;

class EducationResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'degree' => $this->degree,
            'institution' => $this->institution,
            'yearOfGraduation' => $this->yearOfGraduation,
            'address' => $this->address,
            'basicEducation' => $this->basicEducation,
            'highestLevel' => $this->highestLevel,
        ];
    }
    public function index()
{
    $username = auth()->user()->username;
    $educationEntries = EducationBackground::where('username', $username)->get();

    return EducationResource::collection($educationEntries);
}
}

