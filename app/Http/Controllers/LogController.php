<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Student;

class LogController extends Controller
{
     // Show the login form
     public function showLoginForm()
     {
         return view('auth.login'); // Adjust to your view path
     }
 
     // Handle login request
     public function login(Request $request)
     {
         $credentials = $request->only('username', 'password');
 
         if(Student::where('username', $credentials['username'])->exists()){
             $user = Student::where('username', $credentials['username'])->first();
             if(Hash::check($credentials['password'], $user->password) && $user->username===$credentials['username']){
                Auth::login($user);
             }
         }else{
             return 0;
         }
 
     }
 
     // Handle logout request
     public function logout(Request $request)
     {
         Auth::logout();
 
         $request->session()->invalidate();
         $request->session()->regenerateToken();
 
         return redirect('/login'); // Redirect to login page
     }

    //  public function CheckUser()
    //  {
    //     return Auth::check();
    //  }
}
