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
   
       // Fetch the department_id for the Non-Tech Manager from the nontechmanagers table
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

    // Fetch dropdown data filtered by aid
    $result['groups'] = expenses::where('aid', $aid)->get();
    $result['categories'] = expense_cat::where('aid', $aid)->pluck('Category', 'id');
    $result['subcategories'] = expense_subcat::where('nontechmanagerid', $nontechmanagerid)->pluck('subcategory', 'id');
    $result['items'] = ExpenseItem::where('nontechmanagerid', $nontechmanagerid)->pluck('item', 'id');
    $result['quantity_measures'] = ExpenseItem::where('nontechmanagerid', $nontechmanagerid)->distinct()->pluck('quantity');
   
    // If an id is provided, fetch the existing expense data
    if ($id) {
        $result['expense'] = ExpenseRaise::with(['group', 'category', 'subcategory', 'item'])
            ->where('aid', $aid)
            ->findOrFail($id);
    }

    // Return the view with data
    return view('nontechmanager.hostel.expense.raised_expenses', $result);
}


    
 
public function storeRaisedExpense(Request $request, $id = null)
{
    $validated = $request->validate([
        'group' => 'required|exists:expenses,id',
        'category' => 'required|exists:expense_cat,id',
        'subcategory' => 'required|exists:expense_subcats,id',
        'item' => 'required|exists:expense_item,id',
        'quantity_measure' => 'required|string|max:255',
        'quantity' => 'required|string|max:255',
    ]);

    $aid = session()->get('NONTECH_MANAGER_ADMIN_ID');
    $nontechmanagerid = session()->get('NONTECH_MANAGER_ID');

    $quantity_with_measure = $validated['quantity'] . '_' . $validated['quantity_measure'];

    if ($id) {
        $expense = ExpenseRaise::findOrFail($id);
        $expense->update([
            'aid' => $aid,
            'nontechmanagerid' => $nontechmanagerid,
            'groupid' => $validated['group'],
            'categoryid' => $validated['category'],
            'subcatid' => $validated['subcategory'],
            'itemid' => $validated['item'],
            'quantity' => $quantity_with_measure,
            'status' => 0,
        ]);
       
        return redirect()->route('expense.raised_expenses')->with('success', 'Expense updated successfully!');
    } else {
        // Create a new expense item
        ExpenseRaise::create([
            'aid' => $aid,
            'nontechmanagerid' => $nontechmanagerid,
            'groupid' => $validated['group'],
            'categoryid' => $validated['category'],
            'subcatid' => $validated['subcategory'],
            'itemid' => $validated['item'],
            'quantity' => $quantity_with_measure,
        ]);
        return redirect()->route('expense.raised_expenses')->with('success', 'Expense raised successfully!');
    }
}

   public function destroyraise($id)
    {
    $expense = ExpenseRaise::findOrFail($id);
    $expense->delete();

    return redirect()->back()
        ->with('success', 'Expense deleted successfully');
    }
    
}
