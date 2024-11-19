<?php
namespace App\Http\Controllers\nontechmanager\hostel;

use App\Http\Controllers\Controller;
use App\Imports\ExpenseItemImportNew;
use Illuminate\Http\Request;
use App\Models\HostelExpenseSubcategory;
use Illuminate\Support\Facades\DB;
use App\Models\ExpenseItem;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;

class HostelExpenseController extends Controller
{
    public function subcategory()
    {
        return view('nontechmanager.hostel.subcategory');
    }

    public function subitem()
    {
        return view('nontechmanager.hostel.items');
    }
    public function createSubcategory()
{
    $groups = DB::table('finalexpenses')->select('Group')->distinct()->pluck('Group');
    $categories = DB::table('finalexpenses')->select('Category')->distinct()->pluck('Category');
    
    return view('nontechmanager.hostel.create_subcategory', compact('groups', 'categories'));
}

public function store(Request $request)
{
    // Validate the request data
    $request->validate([
        'group' => 'required',
        'category' => 'required',
        'subcategory' => 'required|string|max:255',
    ]);

    // Get nontechmanager_id from the session
    $nontechmanager_id = session()->get('nontechmanager_id');

    // Create a new record in the HostelExpenseSubcategory model
    HostelExpenseSubcategory::create([
        'group' => $request->input('group'),
        'category' => $request->input('category'),
        'subcategory' => $request->input('subcategory'),
        'nontechm_id' => $nontechmanager_id, // Store nontechmanager_id in the appropriate column
    ]);

    // Redirect with a success message
    return redirect()->route('subcategory.index')->with('success', 'Subcategory created successfully!');
}

public function update(Request $request)
{
    // Validate the input data
    $request->validate([
        'group' => 'required|string|max:255',
        'category' => 'required|string|max:255',
        'subcategory' => 'required|string|max:255',
    ]);

    // Find the subcategory by ID
    $subcategory = HostelExpenseSubcategory::findOrFail($request->input('id'));

    // Update the subcategory details
    $subcategory->group = $request->input('group');
    $subcategory->category = $request->input('category');
    $subcategory->subcategory = $request->input('subcategory');
    $subcategory->save();

    // Redirect back with success message
    return redirect()->route('subcategory.index')->with('success', 'Subcategory updated successfully!');
}
public function destroy($id)
{
    // Find and delete the expense subcategory
    $expense = HostelExpenseSubcategory::findOrFail($id);
    $expense->delete();
    
    // Redirect back with a success message
    return redirect()->back()->with('success', 'Subcategory deleted successfully!');
}
public function index()
{
    // Fetch all subcategory data from the hostelexp_subcat table
    $expenses = HostelExpenseSubcategory::all();
    
    // Return the view with the expenses data
    return view('nontechmanager.hostel.subcategory', compact('expenses'));
}
public function showSubcategory()
{
    // Fetch distinct groups and categories from the finalexpenses table
    $groups = DB::table('finalexpenses')->distinct()->pluck('Group');
    $categories = DB::table('finalexpenses')->distinct()->pluck('Category');

    // Return the view and pass the groups and categories to the view
    return view('nontechmanager.hostel.subcategory', compact('groups', 'categories'));
}
public function indexExpenseItems()
{
    // Fetch distinct values for group, category, and subcategory
    $distinctGroups = ExpenseItem::distinct()->pluck('group');
    $distinctCategories = ExpenseItem::distinct()->pluck('category');
    $distinctSubcategories = ExpenseItem::distinct()->pluck('subcategory');

    // Fetch all expense items
    $expenseItems = ExpenseItem::all();

    return view('nontechmanager.hostel.expenseitems', compact('expenseItems', 'distinctGroups', 'distinctCategories', 'distinctSubcategories'));
}

public function expenseItems()
    {
        $expenseItems = ExpenseItem::all();
        return view('nontechmanager.hostel.expenseitems', compact('expenseItems'));
    }

    // Fetch categories based on group
    public function fetchCategories(Request $request)
    {
        $categories = ExpenseItem::getUniqueCategories($request->group);
        return response()->json($categories);
    }

    // Fetch subcategories based on group and category
    public function fetchSubcategories(Request $request)
    {
        $subcategories = ExpenseItem::getUniqueSubcategories($request->group, $request->category);
        return response()->json($subcategories);
    }
// Update Existing Expense Item
public function updateItem(Request $request)
{
    $request->validate([
        'id' => 'required|exists:expenseitems,id',
        'group' => 'required|string|max:255',
        'category' => 'required|string|max:255',
        'subcategory' => 'required|string|max:255',
        'items' => 'required|string|max:255',
    ]);

    // Find item and update it
    $expenseItem = ExpenseItem::findOrFail($request->id);
    $expenseItem->update([
        'group' => $request->group,
        'category' => $request->category,
        'subcategory' => $request->subcategory,
        'items' => $request->items,
    ]);

    return redirect()->route('expense.items')->with('success', 'Expense item updated successfully!');
}

// Delete Expense Item
public function deleteItem($id)
{
    $expenseItem = ExpenseItem::findOrFail($id);
    $expenseItem->delete();

    return redirect()->route('expense.items')->with('success', 'Expense item deleted successfully!');
}


public function createExpenseItem()
{
    // Fetch distinct group and category names directly from the `hostelexp_subcat` table
    $groups = DB::table('hostelexp_subcat')->distinct()->pluck('group');
    $categories = DB::table('hostelexp_subcat')->distinct()->pluck('category');
    $subcategories = DB::table('hostelexp_subcat')->distinct()->pluck('subcategory');

    return view('nontechmanager.hostel.create_expenseitem', compact('groups', 'categories', 'subcategories'));
}
public function storeExpenseItem(Request $request)
{
    // Validate the request data
    $request->validate([
        'group' => 'required|string|max:255',
        'category' => 'required|string|max:255',
        'subcategory' => 'required|string|max:255',
        'items' => 'required|string|max:255',
    ]);

    // Prepare data for insertion
    $data = [
        'group' => $request->input('group'),
        'category' => $request->input('category'),
        'subcategory' => $request->input('subcategory'),
        'items' => $request->input('items'),
        'created_at' => now(),
    ];

    // Insert data into the expense items table
    DB::table('expenseitems')->insert($data);

    return redirect('nontech/manager/hostel/expense/items')
    ->with('success', 'Expense item created successfully.');
}

public function downloadTemplate()
{
    $filePath = storage_path('app/temp/expense_item_template.xlsx');
    return response()->download($filePath, 'expense_item_template.csv');
}
public function uploadExpenseItems(Request $request)
{
    // Validate the uploaded file format
    $validator = Validator::make($request->all(), [
        'excel_file' => 'required|file|mimes:xlsx,xls,csv|max:5000',
    ]);

    if ($validator->fails()) {
        return back()->with('alert', 'Invalid file format. Please upload a valid Excel or CSV file.');
    }

    try {
        Excel::import(new UsersImport, $request->file('excel_file'));
        return back()->with('success', 'Expense items imported successfully!');
    } catch (\Exception $e) {
        return back()->with('alert', 'Error uploading expense items: ' . $e->getMessage());
    }
    
    
}
}
