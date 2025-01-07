<?php
namespace App\Http\Controllers\nontechmanager\hostel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\expense_item;
use App\Models\ExpenseItem;
use App\Models\expenses;     
use App\Models\expense_cat;  
use App\Models\expense_subcat; 
use App\Models\ExpenseRaise; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Support\Facades\Log;
use App\Imports\ItemsImport; // Adjust the namespace based on your file structure


class HostelExpenseController extends Controller
{
    public function index()
    {
        $nontechManagerId = session()->get('NONTECH_MANAGER_ID');
        $nontechManagerAdminId = session()->get('NONTECH_MANAGER_ADMIN_ID');

        if (!$nontechManagerId) {
            return redirect()->back()->with('error', 'Non-Tech Manager ID not found in session.');
        }

        $nontechManager = DB::table('nontechmanagers')->where('id', $nontechManagerId)->first();
        if (!$nontechManager) {
            return redirect()->back()->with('error', 'Non-Tech Manager not found.');
        }
        $departmentId = $nontechManager->departmentid;

        $department = DB::table('departments')->where('id', $departmentId)->first();
        if (!$department) {
            return redirect()->back()->with('error', 'Department not found.');
        }
        $category = $department->category;
        switch ($category) {
            case '1':
                $layout = 'nontechmanager/transport/layout';
                break;
            case '2':
                $layout = 'nontechmanager/infrastructure/layout';
                break;
            case '3':
                $layout = 'nontechmanager/cafeteria/layout';
                break;
            case '4':
                $layout = 'nontechmanager/hostel/layout';
                break;
            case '5':
                $layout = 'nontechmanager/library/layout';
                break;
            default:
                $layout = 'nontechmanager/hostel/layout';
                break;
        }

        $subcategories = expense_subcat::with(['group', 'category'])
            ->where('nontechmanagerid', $nontechManagerId)
            ->where('aid', $nontechManagerAdminId)
            ->get();

        return view('nontechmanager.hostel.expense.index', [
            'category' => $category,
            'subcategories' => $subcategories,
            'layout' => $layout,
        ]);
    }
    

    
    

    public function subitem(Request $request) 
    {
  
        $nontechManagerId = session()->get('NONTECH_MANAGER_ID');
        $nontechManagerAdminId = session()->get('NONTECH_MANAGER_ADMIN_ID');

        $items = DB::table('expense_item')
            ->join('expenses', 'expense_item.groupid', '=', 'expenses.id')
            ->join('expense_cat', 'expense_item.categoryid', '=', 'expense_cat.id')
            ->join('expense_subcats', 'expense_item.subcatid', '=', 'expense_subcats.id')
            ->where('expense_item.nontechmanagerid', $nontechManagerId)  // Filter by nontechmanagerid
            ->where('expense_item.aid', $nontechManagerAdminId)  // Filter by aid
            ->select(
                'expense_item.*',
                'expenses.Group as Group',
                'expense_cat.Category as Category',
                'expense_subcats.Subcategory as subcategory'
            )
            ->get();
        
        // Fetch the department_id for the Non-Tech Manager from the nontechmanagers table
        $nontechManager = DB::table('nontechmanagers')->where('id', $nontechManagerId)->first();
        if (!$nontechManager) {
            return redirect()->back()->with('error', 'Non-Tech Manager not found.');
        }
        $departmentId = $nontechManager->departmentid;
     
        // Fetch the category for the department from the departments table
        $department = DB::table('departments')->where('id', $departmentId)->first();
        if (!$department) {
            return redirect()->back()->with('error', 'Department not found.');
        }
        $category = $department->category;
     
        // Determine the layout based on the department's category
        switch ($category) {
            case '1':
                $layout = 'nontechmanager/transport/layout';
                break;
            case '2':
                $layout = 'nontechmanager/infrastructure/layout';
                break;
            case '3':
                $layout = 'nontechmanager/cafeteria/layout';
                break;
            case '4':
                $layout = 'nontechmanager/hostel/layout';
                break;
            case '5':
                $layout = 'nontechmanager/library/layout';
                break;
            default:
                $layout = 'nontechmanager/hostel/layout';
                break;
        }
    
        // Pass data to the view
        return view('nontechmanager.hostel.expense.subitem', [
            'items' => $items,
            'layout' => $layout
        ]);
    }
    

    public function createSubcategory($id = null)
    {
        $nontechManagerId = session()->get('NONTECH_MANAGER_ID');
        $nontechManagerAdminId = session()->get('NONTECH_MANAGER_ADMIN_ID');
                if (!$nontechManagerId) {
            return redirect()->back()->with('error', 'Non-Tech Manager ID not found in session.');
        }

        $result['groups'] = expenses::where('expenses.aid', $nontechManagerAdminId)
            ->distinct()
            ->get(['id', 'Group']);

        $result['categories'] = expense_cat::where('expense_cat.aid', $nontechManagerAdminId)
            ->distinct()
            ->get(['id', 'Category']);
        
        if ($id) {
            $result['subcategory'] = expense_subcat::findOrFail($id);
        } else {
            $result['subcategory'] = null;
        }

        $nontechManager = DB::table('nontechmanagers')->where('id', $nontechManagerId)->first();
        if (!$nontechManager) {
            return redirect()->back()->with('error', 'Non-Tech Manager not found.');
        }
        $departmentId = $nontechManager->departmentid;

        $department = DB::table('departments')->where('id', $departmentId)->first();
        if (!$department) {
            return redirect()->back()->with('error', 'Department not found.');
        }
        $category = $department->category;
        switch ($category) {
            case '1':
               $result['layout'] = 'nontechmanager/transport/layout';
                break;
            case '2':
               $result['layout'] = 'nontechmanager/infrastructure/layout';
                break;
            case '3':
               $result['layout'] = 'nontechmanager/cafeteria/layout';
                break;
            case '4':
               $result['layout'] = 'nontechmanager/hostel/layout';
                break;
            case '5':
               $result['layout'] = 'nontechmanager/library/layout';
                break;
            default:
                $result['layout'] = 'nontechmanager/hostel/layout';
                break;
        }

        return view('nontechmanager.hostel.expense.create_subcategory', $result);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'groupid' => 'required|integer',
            'categoryid' => 'required|integer',
            'subcategory' => 'required|string|max:255',
        ]);

        $aid = session()->get('NONTECH_MANAGER_ADMIN_ID');
        $nontechmanagerid = session()->get('NONTECH_MANAGER_ID');

        if ($request->id) {
            $subcategory = expense_subcat::findOrFail($request->id);
            $message = 'Subcategory updated successfully!';
        } else {
            $subcategory = new expense_subcat();
            $subcategory->aid = $aid;
            $subcategory->nontechmanagerid = $nontechmanagerid;
            $message = 'Subcategory created successfully!';
        }

        $subcategory->groupid = $validatedData['groupid'];
        $subcategory->categoryid = $validatedData['categoryid'];
        $subcategory->subcategory = $validatedData['subcategory'];
        $subcategory->save();

        return redirect()->route('subcategory.index')->with('success', $message);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'groupid' => 'required|integer',
            'categoryid' => 'required|integer',
            'subcategory' => 'required|string|max:255',
        ]);

        $subcategory = expense_subcat::findOrFail($id);
        $subcategory->groupid = $validatedData['groupid'];
        $subcategory->categoryid = $validatedData['categoryid'];
        $subcategory->subcategory = $validatedData['subcategory'];
        $subcategory->save();

        return redirect()->route('subcategory.index')->with('success', 'Subcategory updated successfully!');
    }

    public function destroy($id)
    {
        $subcategory = expense_subcat::findOrFail($id);
        $subcategory->delete();

        return redirect()->route('subcategory.index')->with('success', 'Subcategory deleted successfully!');
    }

    public function create_item(Request $request, $id = null)
    {
        $nontechManagerId = session()->get('NONTECH_MANAGER_ID');
    $nontechManagerAdminId = session()->get('NONTECH_MANAGER_ADMIN_ID');


    $groups = expenses::where('expenses.aid', $nontechManagerAdminId)
    ->select('id', 'Group')
    ->distinct()
    ->get();

    $categories = expense_cat::where('expense_cat.aid', $nontechManagerAdminId)
    ->select('id', 'Category')
    ->distinct()
    ->get();

    $subcategories = expense_subcat::where('expense_subcats.nontechmanagerid', $nontechManagerId)
    ->where('expense_subcats.aid', $nontechManagerAdminId)
    ->select('id', 'subcategory')
    ->distinct()
    ->get();

        $item = $id ? expense_item::find($id) : null;
        $nontechManager = DB::table('nontechmanagers')->where('id', $nontechManagerId)->first();
        if (!$nontechManager) {
            return redirect()->back()->with('error', 'Non-Tech Manager not found.');
        }
        $departmentId = $nontechManager->departmentid;

        $department = DB::table('departments')->where('id', $departmentId)->first();
        if (!$department) {
            return redirect()->back()->with('error', 'Department not found.');
        }
        $category = $department->category;
        switch ($category) {
            case '1':
               $layout = 'nontechmanager/transport/layout';
                break;
            case '2':
               $layout = 'nontechmanager/infrastructure/layout';
                break;
            case '3':
               $layout = 'nontechmanager/cafeteria/layout';
                break;
            case '4':
               $layout = 'nontechmanager/hostel/layout';
                break;
            case '5':
               $layout = 'nontechmanager/library/layout';
                break;
            default:
                $layout = 'nontechmanager/hostel/layout';
                break;
        }
        return view('nontechmanager.hostel.expense.create_item', [
            'groups' => $groups,
            'categories' => $categories,
            'subcategories' => $subcategories,
            'item' => $item, 
            'layout' => $layout, 
        ]);
    }
    
    

    public function store_item(Request $request)
    {

        $aid = session()->get('NONTECH_MANAGER_ADMIN_ID');
        $nontechmanagerid = session()->get('NONTECH_MANAGER_ID');
        
        if ($request->route('id') != null) {
            $expenseItem = expense_item::findOrFail($request->route('id'));
            $message = 'Expense item updated successfully.';
        } else {
            $expenseItem = new expense_item();
            $expenseItem->aid = $aid;
            $expenseItem->nontechmanagerid = $nontechmanagerid;
            $message = 'Expense item created successfully.';
        }
    
        // Update fields and save
        $expenseItem->groupid = $request->input('groupid');
        $expenseItem->categoryid = $request->input('categoryid');
        $expenseItem->subcatid = $request->input('subcategoryid');
        $expenseItem->item = $request->input('name');
        $expenseItem->quantity = $request->input('amount');
    
        $expenseItem->save();
    
        return redirect()->route('expense.subitems')->with('success', $message);
    }
    

    
        
    
    public function destroy_item($id)
{
    // Find the expense item by its ID
    $expenseItem = expense_item::findOrFail($id);

    // Delete the expense item
    $expenseItem->delete();

    return redirect()->route('expense.subitems')->with('success', 'Expense item deleted successfully.');
}
    
public function showRaisedExpenses()
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

    switch ($category) {
        case '1':
            $layout = 'nontechmanager/transport/layout';
            break;
        case '2':
            $layout = 'nontechmanager/infrastructure/layout';
            break;
        case '3':
            $layout = 'nontechmanager/cafeteria/layout';
            break;
        case '4':
            $layout = 'nontechmanager/hostel/layout';
            break;
        case '5':
            $layout = 'nontechmanager/library/layout';
            break;
        default:
            $layout = 'nontechmanager/hostel/layout';
            break;
    }

    $raisedExpenses = ExpenseRaise::with(['group', 'category', 'subcategory', 'item'])
        ->where('aid', $aid)->where('nontechmanagerid', $nontechmanagerid)->where('status',0)->orwhere('status',-1)
        ->get();
      

    return view('nontechmanager.hostel.expense.expense_list', compact('raisedExpenses','layout'));
}
public function showapprovedRaisedExpenses()
{

    $aid = session()->get('NONTECH_MANAGER_ADMIN_ID');
    $nontechmanagerid = session()->get('NONTECH_MANAGER_ID');

    $nontechManager = DB::table('nontechmanagers')->where('id', $nontechmanagerid)->first();
           if (!$nontechManager) {
               return redirect()->back()->with('error', 'Non-Tech Manager not found.');
           }
           $departmentId = $nontechManager->departmentid;
        
           // Fetch the category for the department from the departments table
    $department = DB::table('departments')->where('id', $departmentId)->first();
    if (!$department) {
        return redirect()->back()->with('error', 'Department not found.');
    }
    $category = $department->category;

    // Determine the layout based on the department's category
    switch ($category) {
        case '1':
            $layout = 'nontechmanager/transport/layout';
            break;
        case '2':
            $layout = 'nontechmanager/infrastructure/layout';
            break;
        case '3':
            $layout = 'nontechmanager/cafeteria/layout';
            break;
        case '4':
            $layout = 'nontechmanager/hostel/layout';
            break;
        case '5':
            $layout = 'nontechmanager/library/layout';
            break;
        default:
            $layout = 'nontechmanager/hostel/layout';
            break;
    }

    $raisedExpenses = ExpenseRaise::with(['group', 'category', 'subcategory', 'item'])
        ->where('aid', $aid)->where('nontechmanagerid', $nontechmanagerid)->where('status',2)
        ->get();

    return view('nontechmanager.hostel.expense.expense_list', compact('raisedExpenses','layout'));
}

    
public function showRaiseExpenseForm(Request $request, $id = null)
{
    $aid = session()->get('NONTECH_MANAGER_ADMIN_ID');
    $nontechmanagerid = session()->get('NONTECH_MANAGER_ID');
    
    // Fetch the department_id for the Non-Tech Manager
    $nontechManager = DB::table('nontechmanagers')->where('id', $nontechmanagerid)->first();
    if (!$nontechManager) {
        return redirect()->back()->with('error', 'Non-Tech Manager not found.');
    }
    $departmentId = $nontechManager->departmentid;

    // Fetch department category
    $department = DB::table('departments')->where('id', $departmentId)->first();
    if (!$department) {
        return redirect()->back()->with('error', 'Department not found.');
    }
    $category = $department->category;

    // Layouts based on department category
    $layouts = [
        '1' => 'nontechmanager/transport/layout',
        '2' => 'nontechmanager/infrastructure/layout',
        '3' => 'nontechmanager/cafeteria/layout',
        '4' => 'nontechmanager/hostel/layout',
        '5' => 'nontechmanager/library/layout'
    ];
    
    $result = [
        'layout' => $layouts[$category] ?? 'nontechmanager/hostel/layout',
        'groups' => expenses::where('aid', $aid)->get(),
        'categories' => expense_cat::where('aid', $aid)->pluck('Category', 'id'),
        'subcategories' => expense_subcat::where('nontechmanagerid', $nontechmanagerid)->pluck('subcategory', 'id'),
        'quantity_measures' => ExpenseItem::where('nontechmanagerid', $nontechmanagerid)->distinct()->pluck('quantity'),
        'items' => ExpenseItem::where('nontechmanagerid', $nontechmanagerid)->get(),
        'expense' => null,
        'selectedItems' => [], // Empty selected items initially
        'expenseItems' => [] // Empty expense items initially
    ];

    // If editing an existing expense
    if ($id) {
        $expense = ExpenseRaise::where('aid', $aid)
            ->where('nontechmanagerid', $nontechmanagerid)
            ->find($id);
        if ($expense) {
            $result['expense'] = $expense;
            $result['expenseItems'] = explode(',', $expense->itemid); // Populate items
            $result['selectedItems'] = $expense->selectedItems; // Fetch the actual selected items
        }
     

    }
    // dd($result['items']);
    // dd($result['expenseItems']);

    return view('nontechmanager.hostel.expense.raised_expenses', $result);
}
public function showRaiseExpenseFormedit(Request $request, $id = null)
{
    $aid = session()->get('NONTECH_MANAGER_ADMIN_ID');
    $nontechmanagerid = session()->get('NONTECH_MANAGER_ID');
    
    // Fetch the department_id for the Non-Tech Manager
    $nontechManager = DB::table('nontechmanagers')->where('id', $nontechmanagerid)->first();
    if (!$nontechManager) {
        return redirect()->back()->with('error', 'Non-Tech Manager not found.');
    }
    $departmentId = $nontechManager->departmentid;

    // Fetch department category
    $department = DB::table('departments')->where('id', $departmentId)->first();
    if (!$department) {
        return redirect()->back()->with('error', 'Department not found.');
    }
    $category = $department->category;

    // Layouts based on department category
    $layouts = [
        '1' => 'nontechmanager/transport/layout',
        '2' => 'nontechmanager/infrastructure/layout',
        '3' => 'nontechmanager/cafeteria/layout',
        '4' => 'nontechmanager/hostel/layout',
        '5' => 'nontechmanager/library/layout'
    ];
    
    $result = [
        'layout' => $layouts[$category] ?? 'nontechmanager/hostel/layout',
        'groups' => expenses::where('aid', $aid)->get(),
        'categories' => expense_cat::where('aid', $aid)->pluck('Category', 'id'),
        'subcategories' => expense_subcat::where('nontechmanagerid', $nontechmanagerid)->pluck('subcategory', 'id'),
        'quantity_measures' => ExpenseItem::where('nontechmanagerid', $nontechmanagerid)->distinct()->pluck('quantity'),
        'items' => ExpenseItem::where('nontechmanagerid', $nontechmanagerid)->get(),
        'expense' => null,
        'selectedItems' => [], // Empty selected items initially
        'expenseItems' => [] // Empty expense items initially
    ];

    // If editing an existing expense
    if ($id) {
        $expense = ExpenseRaise::where('aid', $aid)
            ->where('nontechmanagerid', $nontechmanagerid)
            ->find($id);
    
        if ($expense) {
            // Convert itemid string into an array
            $result['expense'] = $expense;
            $result['expenseItems'] = array_map('trim', explode(',', $expense->itemid)); // Explode to array of item IDs
          
            // Retrieve selected items based on itemid values
            $result['selectedItems'] = ExpenseItem::whereIn('id', $result['expenseItems'])->get(); // Fetch item details from database
           
        }
        

    }
    // dd($result['items']);
    // dd($result['expenseItems']);

    return view('nontechmanager.hostel.expense.editraised_expenses', $result);
}


public function getFilteredItems(Request $request, $id = null)
{
    $aid = session()->get('NONTECH_MANAGER_ADMIN_ID');
    $nontechmanagerid = session()->get('NONTECH_MANAGER_ID');

    $query = ExpenseItem::query()
        ->where('aid', $aid)
        ->where('nontechmanagerid', $nontechmanagerid);

    if ($request->filled('group_id')) {
        $query->where('groupid', $request->group_id);
    }

    if ($request->filled('category_id')) {
        $query->where('categoryid', $request->category_id);
    }

    if ($request->filled('subcategory_id')) {
        $query->where('subcatid', $request->subcategory_id);
    }
    if ($id) {
        $expense = ExpenseRaise::where('aid', $aid)
            ->where('nontechmanagerid', $nontechmanagerid)
            ->find($id);
        if ($expense) {
            $result['expense'] = $expense;
            $result['expenseItems'] = explode(',', $expense->itemid); // Populate items
            $result['selectedItems'] = $expense->selectedItems; // Fetch the actual selected items
        }
     

    }
    // Ensure the `item` attribute is selected correctly
    $items = $query->select('id', 'item as item_name')->get(); // Rename to match usage in frontend

    return response()->json([
        'success' => true,
        'items' => $items
    ]);
}

    






 
public function storeRaisedExpense(Request $request, $id = null)
{
    // Validate the input data
    $validated = $request->validate([
        'group' => 'required|exists:expenses,id', // Check that the group exists in expenses table
        'category' => 'required|exists:expense_cat,id', // Check that the category exists in expense_cat table
        'subcategory' => 'required|exists:expense_subcats,id', // Check that the subcategory exists in expense_subcats table
        'item' => 'required|array', // Ensure it's an array of items
        'item.*' => 'exists:expense_item,id', // Each item should exist in expense_item table
        'quantity_measure' => 'required|string|max:255', // Ensure quantity_measure is a valid string
        'quantity' => 'required|string|max:255', // Ensure quantity is a valid string
    ]);

    // Get the session values for admin and non-tech manager
    $aid = session()->get('NONTECH_MANAGER_ADMIN_ID');
    $nontechmanagerid = session()->get('NONTECH_MANAGER_ID');

    // Combine quantity and quantity measure
    $quantity_with_measure = $validated['quantity'] . '_' . $validated['quantity_measure'];

    // Convert the array of selected items to a comma-separated string
    $itemIds = implode(',', $validated['item']); // Join the array of items into a string

    // Prepare the expense data array
    $expenseData = [
        'aid' => $aid,
        'nontechmanagerid' => $nontechmanagerid,
        'groupid' => $validated['group'],
        'categoryid' => $validated['category'],
        'subcatid' => $validated['subcategory'],
        'itemid' => $itemIds, // Store the comma-separated string
        'quantity' => $quantity_with_measure,
    ];

    // If updating an existing expense
    if ($id) {
        $expense = ExpenseRaise::findOrFail($id); // Find the expense by ID
        $expenseData['status'] = 0; // Set the status to 0 (e.g., pending)
        $expense->update($expenseData); // Update the expense with the new data
        $message = 'Expense updated successfully!'; // Success message for update
    } else {
        // Create a new expense if no ID is provided
        ExpenseRaise::create($expenseData);
        $message = 'Expense raised successfully!'; // Success message for creation
    }

    // Redirect to the raised expenses page with a success message
    return redirect()->route('expense.raised_expenses')->with('success', $message);
}


   public function destroyraise($id)
    {
    $expense = ExpenseRaise::findOrFail($id);
    $expense->delete();

    return redirect()->back()
        ->with('success', 'Expense deleted successfully');
    }

    public function uploadItems(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'bulkFile' => 'required|file|mimes:xlsx,xls|max:5000',
            'groupid' => 'required|exists:expenses,id',
            'categoryid' => 'required|exists:expense_cat,id',
            'subcategoryid' => 'required|exists:expense_subcats,id',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 400);
        }
    
        try {
            $groupid = $request->input('groupid');
            $categoryid = $request->input('categoryid');
            $subcategoryid = $request->input('subcategoryid');
            $aid = session()->get('NONTECH_MANAGER_ADMIN_ID');
            $nontechmanagerid = session()->get('NONTECH_MANAGER_ID');
    
            // Import Excel
            Excel::import(new ItemsImport($groupid, $categoryid, $subcategoryid, $aid, $nontechmanagerid), $request->file('bulkFile')->store('temp'));
    
            return redirect()->route('expense.subitems')->with('success', 'Items imported successfully!');
    } catch (\Exception $e) {
        \Log::error('Error importing items: ' . $e->getMessage());
        return redirect()->back()->with('error', 'An error occurred during import. Please try again.');
    }
    }
    

    public function downloadTemplate()
    {
        $headers = ['groupid', 'categoryid', 'subcatid', 'item', 'quantity'];
        $fileName = 'item_template.xlsx';

        return Excel::download(new TemplateExport($headers), $fileName);
    }

    

}
