<?php

namespace App\Http\Controllers\nontechmanager\hostel;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\expenses;
use App\Models\expense_cat;
use App\Models\expense_subcat;

class HostelExpenseController extends Controller
{
    public function index()
    {
        $result['subcategories'] = expense_subcat::all();
        return view('nontechmanager.hostel.expense.index', $result);
    }

    public function subcategory()
    {
        // Show a specific subcategory view
        return view('nontechmanager.hostel.expense.subcategory');
    }

    public function subitem()
    {
        // Show expense items view
        return view('nontechmanager.hostel.expense.subitem');
    }

    public function createSubcategory()
    {
        $result['groups'] = expenses::distinct()->get(['id', 'Group']);
        $result['categories'] = expense_cat::distinct()->get(['id', 'Category']);

        return view('nontechmanager.hostel.expense.create_subcategory', $result);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'aid' => 'required|integer',
            'nontechmanagerid' => 'required|integer',
            'groupid' => 'required|integer',
            'categoryid' => 'required|integer',
            'subcategory' => 'required|string|max:255',
        ]);

        // Save new subcategory
        $subcategory = new expense_subcat();
        $subcategory->aid = $validatedData['aid'];
        $subcategory->nontechmanagerid = $validatedData['nontechmanagerid'];
        $subcategory->groupid = $validatedData['groupid'];
        $subcategory->categoryid = $validatedData['categoryid'];
        $subcategory->subcategory = $validatedData['subcategory'];
        $subcategory->save();

        return redirect()->route('subcategory.index')->with('success', 'Subcategory created successfully!');
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'aid' => 'required|integer',
            'nontechmanagerid' => 'required|integer',
            'groupid' => 'required|integer',
            'categoryid' => 'required|integer',
            'subcategory' => 'required|string|max:255',
        ]);

        $subcategory = expense_subcat::findOrFail($id);
        $subcategory->aid = $validatedData['aid'];
        $subcategory->nontechmanagerid = $validatedData['nontechmanagerid'];
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
}
