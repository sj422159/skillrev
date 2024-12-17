<?php
namespace App\Http\Controllers\nontechmanager\hostel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\expense_item; // Correct model
use App\Models\expenses;     // Correct model
use App\Models\expense_cat;  // Correct model
use App\Models\expense_subcat; // Correct model
use Illuminate\Support\Facades\Auth;

class HostelExpenseController extends Controller
{
    public function index()
    {
        $result['subcategories'] = expense_subcat::all();
        return view('nontechmanager.hostel.expense.index', $result);
    }

    public function subcategory()
    {
        return view('nontechmanager.hostel.expense.subcategory');
    }

    public function subitem()
    {
        $items = expense_item::all();  // Fetch your items as needed
        $request['items'] = $items;  // Store $items in the request

        return view('nontechmanager.hostel.expense.subitem', $request);
    }

    public function createSubcategory($id = null)
    {
        $result['groups'] = expenses::distinct()->get(['id', 'Group']);
        $result['categories'] = expense_cat::distinct()->get(['id', 'Category']);
        
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

    // Show the form to create a new expense item
    public function create_item(Request $request)
{
    // Fetch unique groups, categories, and subcategories
    $groups = expenses::select('id', 'Group')->distinct()->get();
    $categories = expense_cat::select('id', 'Category')->distinct()->get();
    $subcategories = expense_subcat::select('id', 'subcategory')->distinct()->get();

    // dd($groups, $categories, $subcategories);  // Dumps the data structure to check


    // Store the fetched data in the $request object
    $request->merge([
        'groups' => $groups,
        'categories' => $categories,
        'subcategories' => $subcategories
    ]);

    // Return the view with the necessary data from $request
    return view('nontechmanager.hostel.expense.create_item', [
        'groups' => $request->get('groups'),
        'categories' => $request->get('categories'),
        'subcategories' => $request->get('subcategories')
    ]);
}


    // Store a new expense item
    public function store_item(Request $request)
    {
        // Fetch session data for `aid` and `nontechmanagerid`
        $aid = session()->get('NONTECH_MANAGER_ADMIN_ID');
        $nontechmanagerid = session()->get('NONTECH_MANAGER_ID');
    
        // Create the expense item
        $expenseItem = new expense_item();
        $expenseItem->groupid = $request->input('groupid');  // Directly getting the input
        $expenseItem->categoryid = $request->input('categoryid');
        $expenseItem->subcatid = $request->input('subcategoryid');
        $expenseItem->item = $request->input('name');
        $expenseItem->quantity= $request->input('amount');
        $expenseItem->aid = $aid;  // Assuming `aid` is an admin ID or user ID
        $expenseItem->nontechmanagerid = $nontechmanagerid;  // Assuming it's the non-tech manager ID
    
        // Save the expense item
        $expenseItem->save();
    
        // Redirect to the desired page with a success message
        return redirect()->route('expense.subitems')->with('success', 'Expense item created successfully.');
    }
    public function destroy_item($id)
{
    // Find the expense item by its ID
    $expenseItem = expense_item::findOrFail($id);

    // Delete the expense item
    $expenseItem->delete();

    // Redirect back with a success message
    return redirect()->route('item.index')->with('success', 'Expense item deleted successfully.');
}

    
}
