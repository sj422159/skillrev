<?php

namespace App\Http\Controllers\controller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // For authentication
use Illuminate\Support\Facades\Hash; // For password hashing

    
use Illuminate\Support\Facades\DB;

class AccountController extends Controller
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
            return redirect()->route('dashboard.account');
        } else {
            // Authentication failed, return with error message
            return back()->with('error', 'Invalid credentials');
        }
    }

    /**
     * Show the forgot password form for Academic Controller.
     */
    public function showForgotPasswordForm()
    {
        return view('accontrol.forgotpassword'); // Assuming you have a view file accontrol/forgotpassword.blade.php
    }
    public function forgotPasswordCheck(Request $request)
    {
        // Validate the email input
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        return redirect()->route('accontrol.login')->with('success', 'Password reset link sent to your email.');
    }

    public function accountDashboard()
    {
        $list = DB::table('academics')->where('id', session()->get('Controller_ID'))->first();
        $contentmanagement = DB::table('academics')->where('type', 'contentmanagement')->get();
        $Skillsetmanagement = DB::table('academics')->where('type', 'skillsetmanagement')->get();

        $trainingtype = DB::table('academics')->where('type', 'trainingtype')->get();
    
        return view('controller.Adashboard', compact('list', 'contentmanagement', 'Skillsetmanagement', 'trainingtype'));
    }
    //expense create
    public function create()
    {
        
        $controller_id = session()->get('Controller_ID');
        if (!$controller_id) {
            return redirect()->route('accontrol.login')->withErrors('Controller ID is not set. Please log in.');
        }
        return view('controller.expcreate', compact('controller_id'));
    }
    public function createcat()
    {
        $controller_id = session()->get('Controller_ID');
        if (!$controller_id) {
            return redirect()->route('accontrol.login')->withErrors('Controller ID is not set. Please log in.');
        }
        $expenseGroups = DB::table('expenses')->select('Group') ->where('Controller_ID', $controller_id)->distinct()->get();
        return view('controller.expcreatecat', compact('controller_id', 'expenseGroups'));
    }
    //expense store
    public function store(Request $request)
    {
        // Validate the incoming data (without checking for controller_id existence)
        $validatedData = $request->validate([
            'expense_group' => 'required|string|max:255',
        ]);
    
        $controller_id = session()->get('Controller_ID');

        DB::table('expenses')->insert([
            'controller_id' => $controller_id, 
            'Group' => $validatedData['expense_group'],
        ]);
        return redirect('controller/expgrp')->with('success', 'Expense created successfully.');
    }
    public function storecat(Request $request)
    {
        $validatedData = $request->validate([
            'expense_group' => 'required|string|max:255',
            'expense_category' => 'required|string|max:255',
        ]);
    
        $controller_id = session()->get('Controller_ID');

        DB::table('finalexpenses')->insert([
            'controller_id' => $controller_id, 
            'Group' => $validatedData['expense_group'],
            'Category' => $validatedData['expense_category'],
        ]);
        return redirect('controller/expcat')->with('success', 'Expense created successfully.');
    }
    
    public function update(Request $request, $id)
{
    DB::table('expenses')
        ->where('id', $id)
        ->update([
            'Group' => $request->group_name,
            
        ]);

    return response()->json(['success' => true]);
}
    public function updatecat(Request $request, $id)
{
    DB::table('finalexpenses')
        ->where('id', $id)
        ->update([
            'Group' => $request->group_name,
            'Category' => $request->category_name,
            
        ]);

    return response()->json(['success' => true]);
}

public function destroy($id)
{
    DB::table('expenses')->where('id', $id)->delete();
    return response()->json(['success' => true]);
}
public function destroycat($id)
{
    DB::table('finalexpenses')->where('id', $id)->delete();
    return response()->json(['success' => true]);
}
    public function accountexpgrp()
    {
        $controller_id = session()->get('Controller_ID');
    $expenses = DB::table('expenses')->where('Controller_ID', $controller_id)->select('id', 'Group')->get();
    return view('controller.expgrp', compact('expenses'));
    }
    public function accountexpcat()
    {
        $controller_id = session()->get('Controller_ID');
    $exps = DB::table('finalexpenses')->select('id', 'Group','Category')->get();
    $expenseGroups = DB::table('expenses')->select('Group')->where('Controller_ID', $controller_id)->distinct()->get();
    return view('controller.expcat', compact('exps','expenseGroups'));
    }
}