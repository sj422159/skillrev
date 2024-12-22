<?php

namespace App\Http\Controllers\nontechmanager\account;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\ExpenseItem;
use App\Models\expense_cat;
use App\Models\expense_subcat;
use Carbon\CarbonPeriod;
use Redirect,Response;


class accountexpensecontroller extends Controller
{
    public function showExpenses(Request $request, $module)
{
    // Map modules to their respective numeric IDs
    $moduleMapping = [
        'hostel' => 1,
        'asset' => 2,
        'cafeteria' => 3,
        'transport' => 4,
        'library' => 5,
    ];

    // Validate the module and get its ID
    if (!array_key_exists($module, $moduleMapping)) {
        return redirect()->back()->with('error', 'Invalid module selected.');
    }

    $moduleId = $moduleMapping[$module]; // Get the numeric ID for the module
    $nontechmanagerId =session()->get('NONTECH_MANAGER_ID');; // Get the logged-in user's ID
    $aid = session()->get('NONTECH_MANAGER_ADMIN_ID'); // Get the NONTECH_MANAGER_ADMIN_ID from session

    // Query the ExpenseItem table
    $query = ExpenseItem::where('nontechmanagerId', $moduleId);

    // Apply filters from the request
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

    // Fetch groups and categories for the logged-in user's aid
    $groups = DB::table('expenses')
        ->where('aid', $aid)
        ->pluck('Group', 'id'); // Filtered by aid

    $categories = DB::table('expense_cat')
        ->where('aid', $aid)
        ->pluck('Category', 'id'); // Filtered by aid

    // Filter subcategories based on nontechmanagerid and module_id
    $subcategories = DB::table('expense_subcats')
        ->where('nontechmanagerid', $nontechmanagerId)
       
        ->pluck('subcategory', 'id');

    // Prepare data for the view
    $result = [
        'module' => ucfirst($module), // Capitalized module name for display
        'items' => $items,
        'groups' => $groups, // Filtered groups
        'categories' => $categories, // Filtered categories
        'subcategories' => $subcategories, // Filtered subcategories
    ];

    return view('nontechmanager.account.expense', $result);
}

public function updateStatus(Request $request, $id)
{
    // Validate the incoming data
    $request->validate([
        'status' => 'required|in:1,-1', // Ensure status is either 1 (valid) or -1 (rejected)
    ]);

    // Find the expense item by ID
    $expenseItem = ExpenseItem::find($id);

    if (!$expenseItem) {
        return redirect()->back()->with('error', 'Expense item not found.');
    }

    // Update the status of the expense item
    $expenseItem->status = $request->status;
    $expenseItem->save();

    // Redirect back with a success message
    return redirect()->back()->with('success', 'Expense status updated successfully.');
}


    
    

}
