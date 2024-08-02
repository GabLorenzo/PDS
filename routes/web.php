<?php

use App\Http\Controllers\LogController;
use App\Http\Controllers\PersonalInfoController;
use App\Http\Controllers\AddressController;
use Illuminate\Support\Facades\Route;


Route::post('/login', [LogController::class, 'login']);
// Route::post('/Check', [LogController::class, 'CheckUser']);


Route::post('/personal-info', [PersonalInfoController::class, 'store'])->name('personal-info.store');
Route::post('/address-info', [AddressController::class, 'store']);
Route::get('/get-student-id', [PersonalInfoController::class, 'getStudent_id']);


Route::get('/test-model', [AddressController::class, 'testModel']);



route::get('{any}',function(){
     
     return view('welcome');
})->where('any','.*');
