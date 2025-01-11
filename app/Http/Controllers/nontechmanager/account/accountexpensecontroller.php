<?php

namespace App\Http\Controllers\nontechmanager\account;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\ExpenseItem;
use App\Models\ExpenseRaise;
use App\Models\expense_cat;
use App\Models\expense_subcat;
use Carbon\CarbonPeriod;
use Redirect,Response;


class accountexpensecontroller extends Controller
{
    public function showExpenses(Request $request, $module)
    {
        $nontechmanagerId = session()->get('NONTECH_MANAGER_ID'); // Get the logged-in user's ID
        $aid = session()->get('NONTECH_MANAGER_ADMIN_ID'); // Get the NONTECH_MANAGER_ADMIN_ID from session

        $moduleStatusMapping = [
            'raise' => 0,
            'rejected' => -1,
            'approved' => 2,
            'validate' => 1,
        ];
    
        // Validate the module and get the corresponding status
        if (!array_key_exists($module, $moduleStatusMapping)) {
            return redirect()->back()->with('error', 'Invalid module name.');
        }
    
        $status = $moduleStatusMapping[$module];
    
        // Query the ExpenseRaise table based on the status and aid
        $query = ExpenseRaise::where('status', $status)
            ->where('aid', $aid);
    
        // Apply optional filters from the request
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
    
        // Filter subcategories based on nontechmanagerid
        $subcategories = DB::table('expense_subcats')
            ->where('aid', $aid)
            ->where('nontechmanagerid', $nontechmanagerId)
            ->pluck('subcategory', 'id');
    
        // Prepare data for the view
        $result = [
            'module' => ucfirst($module), // Capitalized module name for display
            'items' => $items, // Filtered expense items
            'groups' => $groups, // Filtered groups
            'categories' => $categories, // Filtered categories
            'subcategories' => $subcategories, // Filtered subcategories
        ];
        // dd($result);
        return view('nontechmanager.account.expense', $result);
    }
    
    

public function updateStatus(Request $request, $id)
{
    // Validate the incoming data
    $request->validate([
        'status' => 'required|in:1,-1', // Ensure status is either 1 (valid) or -1 (rejected)
    ]);

    // Find the expense item by ID
    $expenseItem = ExpenseRaise::find($id);

    if (!$expenseItem) {
        return redirect()->back()->with('error', 'Expense item not found.');
    }

    // Update the status of the expense item
    $expenseItem->status = $request->status;
    $expenseItem->save();

    // Redirect back with a success message
    return redirect()->back()->with('success', 'Expense status updated successfully.');
}
public function showApproved(Request $request)
{
    $aid = session()->get('Controller_ADMIN_ID');
    if (!$aid) {
        return redirect('/login')->with('error', 'Please log in to continue.');
    }
    $expenses = DB::table('exp_raise')->where('aid', $aid)->where('status', 2)->get();
    return view('controller.account.approvexp', ['expenses' => $expenses, 'type' => 'approve']);
}

public function showValidated(Request $request)
{
    $aid = session()->get('Controller_ADMIN_ID');
    if (!$aid) {
        return redirect('/login')->with('error', 'Please log in to continue.');
    }
    $expenses = DB::table('exp_raise')->where('aid', $aid)->where('status', 1)->get();
    dd($expenses->first()->item);
    return view('controller.account.approvexp', ['expenses' => $expenses, 'type' => 'validate']);
}

public function showRaised(Request $request)
{
    $aid = session()->get('Controller_ADMIN_ID');
    if (!$aid) {
        return redirect('/login')->with('error', 'Please log in to continue.');
    }
    $expenses = DB::table('exp_raise')->where('aid', $aid)->where('status', 0)->get();
    return view('controller.account.approvexp', ['expenses' => $expenses, 'type' => 'raised']);
}

public function approveExpense(Request $request)
{
    $expenseId = $request->input('expense_id');
    DB::table('exp_raise')->where('id', $expenseId)->update(['status' => 2]);
    return redirect()->back()->with('success', 'Expense approved successfully.');
}

public function rejectExpense(Request $request)
{
    $expenseId = $request->input('expense_id');
    DB::table('exp_raise')->where('id', $expenseId)->update(['status' => -1]);
    return redirect()->back()->with('error', 'Expense rejected successfully.');
}
public function showExpensesByType($type) {
    $aid = session()->get('Controller_ADMIN_ID');
    
    $status = match ($type) {
        'raised' => 0,
        'validate' => 1,
        'approve' => 2,
        default => null,
    };
    
    $expenses = ExpenseRaise::with(['group', 'category', 'subcategory'])
        ->where('aid', $aid)
        ->where('status', $status)
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
    
    return view('controller.account.approveexp', [
        'expenses' => $expenses,
        'type' => $type
    ]);
}







    
    

}
