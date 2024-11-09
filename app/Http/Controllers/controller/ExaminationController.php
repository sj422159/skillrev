<?php

namespace App\Http\Controllers\controller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // For authentication
use Illuminate\Support\Facades\Hash; // For password hashing

    
use Illuminate\Support\Facades\DB;

class ExaminationController extends Controller
{
        
    public function showLoginForm()
    {
        return view('accontrol.login'); 
    }


    public function login(Request $request)
    {
        // Validate user input
        $validatedData = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Authenticate the user with Auth::attempt
        if (Auth::guard('academic_controller')->attempt(['email' => $validatedData['email'], 'password' => $validatedData['password']])) {
            // Authentication passed, redirect to dashboard
            return redirect()->route('dashboard.examination');
        } else {
            // Authentication failed, return with error message
            return back()->with('error', 'Invalid credentials');
        }
    }

    /**
     * Show the forgot password form for examination Controller.
     */
    public function showForgotPasswordForm()
    {
        return view('accontrol.forgotpassword'); // Assuming you have a view file accontrol/forgotpassword.blade.php
    }

    /**
     * Handle the forgot password logic.
     */
    public function forgotPasswordCheck(Request $request)
    {
        // Validate the email input
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        // Add logic to send password reset link or email
        // Example: Sending password reset email
        // PasswordReset::sendResetLink($request->only('email'));

        return redirect()->route('accontrol.login')->with('success', 'Password reset link sent to your email.');
    }

    public function edashboard()
    {
        // Query to fetch data from the 'academics' table
        $list = DB::table('academics')->where('id', session()->get('ADMIN_ID'))->first();
    
      // Fetching different data from 'academics' table based on the 'type' field
    $contentmanagement = DB::table('academics')->where('type', 'contentmanagement')->get();
    $Skillsetmanagement = DB::table('academics')->where('type', 'skillsetmanagement')->get();

        $trainingtype = DB::table('academics')->where('type', 'trainingtype')->get();
    
        return view('controller.edashboard', compact('list', 'contentmanagement', 'Skillsetmanagement', 'trainingtype'));
    }
    
}
