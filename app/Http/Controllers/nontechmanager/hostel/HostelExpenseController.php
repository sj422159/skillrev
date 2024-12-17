<?php
namespace App\Http\Controllers\nontechmanager\hostel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\expense_item; // Correct model
use App\Models\expenses;     // Correct model
use App\Models\expense_cat;  // Correct model
use App\Models\expense_subcat; // Correct model
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HostelExpenseController extends Controller
{
    public function index()
    {
        // Fetch the NONTECH_MANAGER_ID and NONTECH_MANAGER_ADMIN_ID from the session
        $nontechManagerId = session()->get('NONTECH_MANAGER_ID');
        $nontechManagerAdminId = session()->get('NONTECH_MANAGER_ADMIN_ID');
    
        // Check if the NONTECH_MANAGER_ID exists in the session
        if (!$nontechManagerId) {
            return redirect()->back()->with('error', 'Non-Tech Manager ID not found in session.');
        }
    
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
    
        // Fetch subcategories where `nontechmanagerid` and `aid` match the session values
        $subcategories = expense_subcat::with(['group', 'category'])
            ->where('nontechmanagerid', $nontechManagerId)
            ->where('aid', $nontechManagerAdminId)
            ->get();
    
        // Pass the data to the view along with the layout
        return view('nontechmanager.hostel.expense.index', [
            'category' => $category,
            'subcategories' => $subcategories,
            'layout' => $layout,
        ]);
    }
    

    
    

    public function subitem(Request $request) // Add Request parameter
    {
        // Fetch session data for NONTECH_MANAGER_ID and NONTECH_MANAGER_ADMIN_ID
        $nontechManagerId = session()->get('NONTECH_MANAGER_ID');
        $nontechManagerAdminId = session()->get('NONTECH_MANAGER_ADMIN_ID');
        
        // Fetch items based on session data
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
        
        // Fetching distinct groups filtered by nontechmanagerid and aid
        $result['groups'] = expenses::where('expenses.aid', $nontechManagerAdminId)
            ->distinct()
            ->get(['id', 'Group']);
        
        // Fetching distinct categories filtered by nontechmanagerid and aid
        $result['categories'] = expense_cat::where('expense_cat.aid', $nontechManagerAdminId)
            ->distinct()
            ->get(['id', 'Category']);
        
        if ($id) {
            $result['subcategory'] = expense_subcat::findOrFail($id);
        } else {
            $result['subcategory'] = null;
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
    
        return view('nontechmanager.hostel.expense.create_item', [
            'groups' => $groups,
            'categories' => $categories,
            'subcategories' => $subcategories,
            'item' => $item, 
        ]);
    }
    
    

    public function store_item(Request $request)
    {
        // Fetch session data for `aid` and `nontechmanagerid`
        $aid = session()->get('NONTECH_MANAGER_ADMIN_ID');
        $nontechmanagerid = session()->get('NONTECH_MANAGER_ID');
        
        // Debug: Check the id being passed
        // dd($request->route('id'));
    
        // Check if the 'id' is present in the request to decide whether to create or update
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

    
}
