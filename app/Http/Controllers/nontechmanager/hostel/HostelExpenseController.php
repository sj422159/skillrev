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
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


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
            case '6':
                $layout = 'nontechmanager/account/layout';
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
            case '6':
                $layout = 'nontechmanager/account/layout';
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
            case '6':
                $result['layout'] = 'nontechmanager/account/layout';
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
        $quantityMeasures = DB::table('quantity_measure')->select('id', 'measure')->get();

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
                case '6':
                    $layout = 'nontechmanager/account/layout';
                    break;
            }
            return view('nontechmanager.hostel.expense.create_item', [
                'groups' => $groups,
                'categories' => $categories,
                'subcategories' => $subcategories,
                'quantityMeasures' => $quantityMeasures, 
                'item' => $item, 
                'layout' => $layout, 
            ]);
    }
    
    
    public function store_item(Request $request)
    {
        $aid = session()->get('NONTECH_MANAGER_ADMIN_ID');
        $nontechmanagerid = session()->get('NONTECH_MANAGER_ID');
        
        // Check if the expense item already exists
        $existingItem = expense_item::where('nontechmanagerid', $nontechmanagerid)
            ->where('aid', $aid)
            ->where('groupid', $request->input('groupid'))
            ->where('categoryid', $request->input('categoryid'))
            ->where('subcatid', $request->input('subcategoryid'))
            ->whereRaw('LOWER(item) = ?', [strtolower($request->input('name'))])
            ->first();
        
        if ($existingItem && $request->route('id') == null) {
            return redirect()->route('expense.subitems')->with('success', 'Expense item already exists.');
        }
        
        // Check if we're updating or creating a new expense item
        if ($request->route('id') != null) {
            // Update existing item
            $expenseItem = expense_item::findOrFail($request->route('id'));
            $message = 'Expense item updated successfully.';
        } else {
            // Create new item
            $expenseItem = new expense_item();
            $expenseItem->aid = $aid;
            $expenseItem->nontechmanagerid = $nontechmanagerid;
            $message = 'Expense item created successfully.';
        }
    
        // Set the expense item fields
        $expenseItem->groupid = $request->input('groupid');
        $expenseItem->categoryid = $request->input('categoryid');
        $expenseItem->subcatid = $request->input('subcategoryid');
        $expenseItem->item = $request->input('name');
        $expenseItem->quantity = $request->input('quantity');
        
        // Save the expense item
        $expenseItem->save();
    
        // Return success message
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
        case '6':
            $layout = 'nontechmanager/account/layout';
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
        case '6':
            $layout = 'nontechmanager/account/layout';
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
        '5' => 'nontechmanager/library/layout',
        '6' => 'nontechmanager/account/layout',
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
        'groups' => expenses::where('aid', $aid)->get(),
        'categories' => expense_cat::where('aid', $aid)->pluck('Category', 'id'),
        'subcategories' => expense_subcat::where('nontechmanagerid', $nontechmanagerid)->pluck('subcategory', 'id'),
        'quantity_measures' => ExpenseItem::where('nontechmanagerid', $nontechmanagerid)->distinct()->pluck('quantity'),
        'items' => ExpenseItem::where('nontechmanagerid', $nontechmanagerid)->where('aid', $aid)->get(),
        'expense' => null,
        'selectedItems' => [],
        'expenseItems' => [],
        'quantity_value' => null,
        'quantity_measure' => null,
        'aid' => $aid,
        'nontechmanagerid' => $nontechmanagerid,
    ];

    if ($id) {
        $expense = ExpenseRaise::where('aid', $aid)
            ->where('nontechmanagerid', $nontechmanagerid)
            ->find($id);

        if ($expense) {
            $result['expense'] = $expense;
            $result['expenseItems'] = explode(',', $expense->itemid);
            $result['selectedItems'] = ExpenseItem::whereIn('id', $result['expenseItems'])->get();
            // dd($expense->quantity);
            if ($expense->quantity) {
                $quantityParts = explode(' ', $expense->quantity);
                $result['quantity_value'] = $quantityParts[0] ?? null;
                $result['quantity_measure'] = $quantityParts[1] ?? null;
            }
        }
    }

    return view('nontechmanager.hostel.expense.editraised_expenses', $result);
}




public function getFilteredItems(Request $request)
{
    $aid = session()->get('NONTECH_MANAGER_ADMIN_ID');
    $nontechmanagerid = session()->get('NONTECH_MANAGER_ID');
    $groupId = $request->get('group_id');
    $categoryId = $request->get('category_id');
    $subcategoryId = $request->get('subcategory_id');

    $items = DB::table('expense_item')
        ->join('expenses', 'expense_item.groupid', '=', 'expenses.id')
        ->join('expense_cat', 'expense_item.categoryid', '=', 'expense_cat.id')
        ->join('expense_subcats', 'expense_item.subcatid', '=', 'expense_subcats.id')
        ->select(
            'expense_item.id',
            'expense_item.item',
            'expenses.Group as group_name',
            'expense_cat.Category as category_name',
            'expense_subcats.subcategory as subcategory_name'
        )
        ->where('expense_item.aid', $aid)
        ->where('expense_item.nontechmanagerid', $nontechmanagerid)
        ->when($groupId, function ($query, $groupId) {
            return $query->where('expense_item.groupid', $groupId);
        })
        ->when($categoryId, function ($query, $categoryId) {
            return $query->where('expense_item.categoryid', $categoryId);
        })
        ->when($subcategoryId, function ($query, $subcategoryId) {
            return $query->where('expense_item.subcatid', $subcategoryId);
        })
        ->get();

    return response()->json(['success' => true, 'items' => $items]);
}


public function storeRaisedExpense(Request $request, $id = null)
{
    // Retrieve session data
    $aid = session()->get('NONTECH_MANAGER_ADMIN_ID');
    $nontechmanagerid = session()->get('NONTECH_MANAGER_ID');

    // Validate required fields
    $request->validate([
        'group' => 'required|integer',
        'category' => 'required|integer',
        'subcategory' => 'required|integer',
        'quantity' => 'required|array',
        'quantity.*' => 'required|numeric|min:1',
        'quantity_measure' => 'required|array',
        'quantity_measure.*' => 'required|string|max:10',
    ]);

    // Prepare data for multiple items
    $items = $request->input('quantity');
    $measures = $request->input('quantity_measure');

    foreach ($items as $itemId => $quantity) {
        $quantityMeasure = $measures[$itemId] ?? null;

        if ($quantityMeasure === null) {
            continue; // Skip if quantity measure is missing
        }

        $expenseData = [
            'aid' => $aid,
            'nontechmanagerid' => $nontechmanagerid,
            'groupid' => $request->input('group'),
            'categoryid' => $request->input('category'),
            'subcatid' => $request->input('subcategory'),
            'itemid' => $itemId,
            'quantity' => $quantity . ' ' . $quantityMeasure,
            'status' => 0, // Default status
        ];

        // Insert or update logic
        if ($id) {
            // Update existing record if matching item ID exists
            $existingExpense = ExpenseRaise::where('id', $id)->where('itemid', $itemId)->first();
            if ($existingExpense) {
                $existingExpense->update($expenseData);
            } else {
                ExpenseRaise::create($expenseData);
            }
        } else {
            // Insert new record
            ExpenseRaise::create($expenseData);
        }
    }

    // Redirect with success message
    $message = $id ? 'Expense updated successfully!' : 'Expenses raised successfully!';
    return redirect()->route('expense.raised_expenses')->with('success', $message);
}

public function storeEditedExpense(Request $request, $id)
{
    $aid = session()->get('NONTECH_MANAGER_ADMIN_ID');
    $nontechmanagerid = session()->get('NONTECH_MANAGER_ID');

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

    return redirect()->route('expense.raised_expenses')->with('success', 'Expense updated successfully.');
}



public function fetchItems(Request $request) {
    $groupid = $request->input('groupid');
    $categoryid = $request->input('categoryid');
    $subcatid = $request->input('subcatid');
    $aid = $request->input('aid');
    $nontechmanagerid = $request->input('nontechmanagerid');
    
    $items = DB::table('expense_item')  // Changed variable name from $itemses to $items
        ->where('groupid', $groupid)
        ->where('categoryid', $categoryid)
        ->where('subcatid', $subcatid)
        ->where('aid', $aid)
        ->where('nontechmanagerid', $nontechmanagerid)
        ->get();
    
    return response()->json($items);
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

            Excel::import(new ItemsImport($groupid, $categoryid, $subcategoryid, $aid, $nontechmanagerid), $request->file('bulkFile')->store('temp'));
    
            return redirect()->route('expense.subitems')->with('success', 'Items imported successfully!');
    } catch (\Exception $e) {
        \Log::error('Error importing items: ' . $e->getMessage());
        return redirect()->back()->with('error', 'An error occurred during import. Please try again.');
    }
    }
    

    public function downloadTemplate()
    {
        $headers = ['item', 'quantity_measure'];
        $fileName = 'item_template.xlsx';
    
        // Fetch quantity measures from the database
        $quantityMeasures = DB::table('quantity_measure')->pluck('measure')->toArray();
    
        // Create a new spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
    
        // Add the header row
        $sheet->fromArray([$headers], null, 'A1');
    
        // Add data validation for the quantity_measure column
        $validation = $sheet->getCell('B2')->getDataValidation();
        $validation->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST);
        $validation->setErrorStyle(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_INFORMATION);
        $validation->setAllowBlank(false);
        $validation->setShowInputMessage(true);
        $validation->setShowErrorMessage(true);
        $validation->setShowDropDown(true);
        $validation->setFormula1('"' . implode(',', $quantityMeasures) . '"');
    
        // Apply the validation to the entire column
        for ($row = 2; $row <= 100; $row++) {
            $sheet->getCell('B' . $row)->setDataValidation(clone $validation);
        }
    
        // Stream the file as a download
        return response()->streamDownload(function () use ($spreadsheet) {
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
        }, $fileName, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Cache-Control' => 'no-store, no-cache',
        ]);
    }

    

}
