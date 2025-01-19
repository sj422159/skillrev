<?php

namespace App\Http\Controllers\nontechmanager\account;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\expense_item;
use App\Models\ExpenseItem;
use App\Models\expenses;     
use App\Models\expense_cat;  
use App\Models\expense_subcat; 
use App\Models\ExpenseRaise; 
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
            ->pluck('subcategory', 'id');
        
        // Prepare data for the view
        $result = [
            'module' => ucfirst($module), // Capitalized module name for display
            'items' => $items, // Filtered expense items
            'groups' => $groups, // Filtered groups
            'categories' => $categories, // Filtered categories
            'subcategories' => $subcategories, // Filtered subcategories
            'nontechmanagerId' => $nontechmanagerId, // Filtered subcategories
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
public function showRaiseExpenseFormedit(Request $request, $id = null)
{
    $aid = session()->get('NONTECH_MANAGER_ADMIN_ID');
    $nontechmanagerid = session()->get('NONTECH_MANAGER_ID');

    $nontechManager = DB::table('nontechmanagers')->where('id', $nontechmanagerid)->first();
    if (!$nontechManager) {
        return redirect()->back()->with('error', 'Non-Tech Manager not found.');
    }
    $departmentId = $nontechManager->departmentid;

    $department = DB::table('departments')->where('id', $departmentId)->first();
    if (!$department) {
        return redirect()->back()->with('error', 'Department not found.');
    }
    $category = $department->category;

    $layouts = [
        '1' => 'nontechmanager/transport/layout',
        '2' => 'nontechmanager/infrastructure/layout',
        '3' => 'nontechmanager/cafeteria/layout',
        '4' => 'nontechmanager/hostel/layout',
        '5' => 'nontechmanager/library/layout',
        '6' => 'nontechmanager/account/layout',
    ];

    $result = [
        'layout' => $layouts[$category] ?? 'nontechmanager/hostel/layout',
        'groups' => DB::table('expenses')->where('aid', $aid)->get(),
        'categories' => DB::table('expense_cat')->where('aid', $aid)->pluck('Category', 'id'),
        'subcategories' => DB::table('expense_subcats')->where('aid', $aid)->pluck('subcategory', 'id'),
        'quantity_measures' => DB::table('expense_item')->where('aid', $aid)->distinct()->pluck('quantity'),
        'items' => DB::table('expense_item')->where('aid', $aid)->get(),
        'expense' => null,
        'selectedItems' => [],
        'expenseItems' => [],
        'quantity_value' => null,
        'quantity_measure' => null,
        'aid' => $aid,
        'nontechmanagerid' => $nontechmanagerid,
    ];

    if ($id) {
        $expense = ExpenseRaise::where('aid', $aid)->find($id);

        if ($expense) {
            $result['expense'] = $expense;
            $result['expenseItems'] = explode(',', $expense->itemid);
            $result['selectedItems'] = ExpenseItem::whereIn('id', $result['expenseItems'])->get();
            if ($expense->quantity) {
                $quantityParts = explode(' ', $expense->quantity);
                $result['quantity_value'] = $quantityParts[0] ?? null;
                $result['quantity_measure'] = $quantityParts[1] ?? null;
            }
        }
    }

    return view('nontechmanager.account.editraised_expenses', $result);
}
public function storeEditedExpense(Request $request, $id)
{
    $aid = session()->get('NONTECH_MANAGER_ADMIN_ID');
    $expense = ExpenseRaise::find($id);

    if (!$expense) {
        return redirect()->back()->with('error', 'Expense not found.');
    }

    $expense->update([
        'groupid' => $request->input('group'),
        'categoryid' => $request->input('category'),
        'subcatid' => $request->input('subcategory'),
        'itemid' => $request->input('item'),
        'quantity' => $request->input('quantity') . ' ' . $request->input('quantity_measure'),
        'status' => 0, 
    ]);

    return redirect()->route('account.manager.expenses', ['module' => 'raise'])->with('success', 'Expense updated successfully.');
} 

}
