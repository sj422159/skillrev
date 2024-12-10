<?php

namespace App\Http\Controllers\controller\account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // For authentication
use Illuminate\Support\Facades\Hash; // For password hashing
use App\Models\controllers;
    
use Illuminate\Support\Facades\DB;

class AccountController extends Controller
{
    
    public function accountDashboard()
    {
        $controller_id=session()->get('Controller_ID');

        $result['image']=controllers::where('id',$controller_id)->get();

    
        return view('controller.account.Adashboard',$result);
    }

   public function create()
    {
        $controller_id = session()->get('Controller_ID');
        if (!$controller_id) {
            return redirect()->route('login')->withErrors('Controller ID is not set. Please log in.');
        }
        return view('controller.account.expcreate', compact('controller_id'));
    }
    public function createcat()
    {
        $controller_id = session()->get('Controller_ID');
        $controller_admin_id = session()->get('Controller_ADMIN_ID');
        if (!$controller_id) {
            return redirect()->route('login')->withErrors('Controller ID is not set. Please log in.');
        }
        $expenseGroups = DB::table('expenses') ->where('Controller_ID', $controller_id)->where('aid', $controller_admin_id)->distinct()->get();
        return view('controller.account.expcreatecat', compact('controller_id', 'expenseGroups'));
    }
    //expense store
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'expense_group' => 'required|string|max:255',
        ]);
    
        $controller_id = session()->get('Controller_ID');
        $controller_admin_id = session()->get('Controller_ADMIN_ID');

        DB::table('expenses')->insert([
            'controller_id' => $controller_id, 
            'aid' => $controller_admin_id,
            'Group' => $validatedData['expense_group'],
        ]);
        return redirect('controller/expgrp')->with('success', 'Expense created successfully.');
    }
    public function storecat(Request $request)
    {
        $validatedData = $request->validate([
            'group_id' => 'required|integer', // Validate group_id instead of expense_group
            'expense_category' => 'required|string|max:255',
        ]);
    
        $controller_id = session()->get('Controller_ID');
        $controller_admin_id = session()->get('Controller_ADMIN_ID');
    
        // Save the group_id instead of the group name
        DB::table('expense_cat')->insert([
            'controller_id' => $controller_id,
            'aid' => $controller_admin_id,
            'group_id' => $validatedData['group_id'], // Use group_id from the request
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

    DB::table('expense_cat')
        ->where('id', $id)
        ->update([
            'group_id' => $request->group_name,
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
    DB::table('expense_cat')->where('id', $id)->delete();
    return response()->json(['success' => true]);
}


    public function accountexpgrp()
    {
        $controller_id = session()->get('Controller_ID');
        $controller_admin_id = session()->get('Controller_ADMIN_ID');
    $expenses = DB::table('expenses')->where('Controller_ID', $controller_id)->where('expenses.aid', $controller_admin_id)->select('id', 'Group')->get();
    return view('controller.account.expgrp', compact('expenses'));
    }
    public function accountexpcat()
    {
        $controller_id = session()->get('Controller_ID');
        $controller_admin_id = session()->get('Controller_ADMIN_ID');
    
        // Fetch expense categories with the Group name by joining expense_cat and expenses tables
        $exps = DB::table('expense_cat')
            ->join('expenses', 'expense_cat.group_id', '=', 'expenses.id')
            ->where('expense_cat.Controller_ID', $controller_id)
            ->where('expense_cat.aid', $controller_admin_id)
            ->select('expense_cat.id', 'expenses.Group', 'expense_cat.Category','expense_cat.group_id')
            ->get();
    
        // Fetch distinct groups for the dropdown
        $expenseGroups = DB::table('expenses')
            ->where('Controller_ID', $controller_id)
            ->distinct()
            ->select('id', 'Group') // Select id to use as group_id
            ->get();
    
        return view('controller.account.expcat', compact('exps', 'expenseGroups'));
    }
    
}