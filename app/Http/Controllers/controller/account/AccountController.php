<?php

namespace App\Http\Controllers\controller\account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // For authentication
use Illuminate\Support\Facades\Hash; // For password hashing
use App\Models\controllers;
use App\Models\ExpenseItem;
use App\Models\ExpenseRaise;
use App\Models\expense_cat;
use App\Models\expense_subcat;
    
use Illuminate\Support\Facades\DB;

class AccountController extends Controller
{
    
    public function accountDashboard()
    {
        $controller_id=session()->get('Controller_ID');
        if (!$controller_id) {
            return redirect()->route('login')->withErrors('Controller ID is not set. Please log in.');
        }
        $aid=session()->get('Controller_ADMIN_ID');

        $result['image']=controllers::where('id',$controller_id)->get();
        $approvedCount = DB::table('exp_raise')->where('status', 2)->where('aid', $aid)->distinct('subcatid')->count('subcatid');  // status = 2 (approved)
        $rejectedCount = DB::table('exp_raise')->where('status', -1)->where('aid', $aid)->distinct('subcatid')->count('subcatid'); // status = -1 (rejected)
        $validatecount = DB::table('exp_raise')->where('status', 1)->where('aid', $aid)->distinct('subcatid')->count('subcatid');   // status = 1 (pending)
        $totalCount = DB::table('exp_raise')->where('status', 0)->where('aid', $aid)->distinct('subcatid')->count('subcatid'); // Total records in expense_item table
    
        $result['approvedCount'] = $approvedCount;
        $result['rejectedCount'] = $rejectedCount;
        $result['validatecount'] = $validatecount;
        $result['totalCount'] = $totalCount;

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
    public function showExpensesByType(Request $request, $type) {
        $aid = session()->get('Controller_ADMIN_ID');
        
        $status = match ($type) {
            'raised' => 0,
            'validate' => 1,
            'approve' => 2,
            default => null,
        };
        
        // Fetch groups for the logged-in user's aid
        $groups = DB::table('expenses')
            ->where('aid', $aid)
            ->pluck('Group', 'id'); // Filtered by aid

        // Fetch categories based on selected group
        $categories = collect();
        if ($request->filled('groupid')) {
            $categories = DB::table('expense_cat')
                ->where('aid', $aid)
                ->where('group_id', $request->groupid)
                ->pluck('Category', 'id'); // Filtered by aid and group_id
        }

        // Fetch subcategories based on selected group and category
        $subcategories = collect();
        if ($request->filled('groupid') && $request->filled('categoryid')) {
            $subcategories = DB::table('expense_subcats')
                ->where('aid', $aid)
                ->where('groupid', $request->groupid)
                ->where('categoryid', $request->categoryid)
                ->pluck('subcategory', 'id'); // Filtered by aid, group_id, and category_id
        }
        
        // Initialize items and expenses as empty collections
        $items = collect();
        $expenses = collect();
        
        // If subcategory is selected, fetch the filtered items and expenses
        if ($request->filled('subcatid')) {
            $query = ExpenseRaise::where('status', $status)
                ->where('aid', $aid);
            
            if ($request->filled('groupid')) {
                $query->where('groupid', $request->groupid);
            }
            if ($request->filled('categoryid')) {
                $query->where('categoryid', $request->categoryid);
            }
            if ($request->filled('subcatid')) {
                $query->where('subcatid', $request->subcatid);
            }
            
            // Get filtered items with relationships
            $items = $query->with(['group', 'category', 'subcategory'])->get();
            
            $expenses = ExpenseRaise::with(['group', 'category', 'subcategory'])
                ->where('aid', $aid)
                ->where('status', $status)
                ->when($request->filled('groupid'), function ($query) use ($request) {
                    return $query->where('groupid', $request->groupid);
                })
                ->when($request->filled('categoryid'), function ($query) use ($request) {
                    return $query->where('categoryid', $request->categoryid);
                })
                ->when($request->filled('subcatid'), function ($query) use ($request) {
                    return $query->where('subcatid', $request->subcatid);
                })
                ->get();
            
            foreach ($expenses as $expense) {
                $itemId = $expense->itemid; // Using itemid instead of item
                if ($itemId) {
                    if (strpos($itemId, ',') !== false) {
                        // Handle multiple items
                        $itemIds = array_map('trim', explode(',', $itemId));
                        $items = ExpenseItem::whereIn('id', $itemIds)->pluck('item')->toArray();
                        $expense->item_names = json_encode(['item' => implode(', ', $items)]);
                    } else {
                        // Handle single item
                        $item = ExpenseItem::where('id', $itemId)->value('item');
                        $expense->item_names = json_encode(['item' => $item ?: 'N/A']);
                    }
                } else {
                    $expense->item_names = json_encode(['item' => 'N/A']);
                }
            }
        }
        
        $result = [
            'items' => $items, // Filtered expense items
            'groups' => $groups, // Filtered groups
            'categories' => $categories, // Filtered categories
            'subcategories' => $subcategories, // Filtered subcategories
            'expenses' => $expenses,
            'type' => $type
        ];
        
        return view('controller.account.approveexp', $result);
    }
    
}