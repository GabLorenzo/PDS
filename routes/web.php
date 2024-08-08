<?php

use Illuminate\Support\Facades\Route;


use App\Http\Controllers\LogController;
use App\Http\Controllers\PersonalInfoController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\FamilyController;
use App\Http\Controllers\EducationController;
use App\Http\Controllers\WorkExperienceController;
use App\Http\Controllers\AwardController;

Route::post('/login', [LogController::class, 'login']);
Route::post('/logout', [LogController::class, 'logout']);

Route::middleware('auth')->group(function () {
Route::get('/get-username', [LogController::class, 'getUsername']);
});


Route::middleware('auth')->group(function () {
Route::get('/get-username', [PersonalInfoController::class, 'getUsername']);
Route::post('/personal-info', [PersonalInfoController::class, 'store']);
});

Route::middleware('auth')->group(function () {
Route::post('/address', [AddressController::class, 'store']);
});

Route::middleware('auth')->group(function () {
Route::post('/family', [FamilyController::class, 'store']);
Route::get('/family', [FamilyController::class, 'index']);
Route::delete('/family/{id}', [FamilyController::class, 'destroy']);
Route::post('/family/bulk', [FamilyController::class, 'bulkStore']);
});

Route::middleware('auth')->group(function () {
    Route::post('/education', [EducationController::class, 'store']);
    Route::get('/education', [EducationController::class, 'index']);
    Route::delete('/education/{id}', [EducationController::class, 'destroy']);
});

Route::middleware('auth')->group(function () {
    Route::post('/work-experiences', [WorkExperienceController::class, 'store']);
    Route::get('/work-experiences', [WorkExperienceController::class, 'index']);
    Route::delete('/work-experiences/{id}', [WorkExperienceController::class, 'destroy']);
});

Route::middleware('auth')->group(function () {
    Route::get('/awards', [AwardController::class, 'index']);
    Route::post('/awards', [AwardController::class, 'store']);
    Route::delete('/awards/{id}', [AwardController::class, 'destroy']);
});





Route::get('/user', function () {
    return response()->json(['user' => Auth::user()]);
})->middleware('auth');

Route::get('/username', function () {
    return response()->json(['username' => auth()->user()->username]);
});
route::get('{any}',function(){

     return view('welcome');
})->where('any','.*');


