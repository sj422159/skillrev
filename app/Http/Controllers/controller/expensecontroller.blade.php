<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller; 
use Illuminate\Http\Request;
use App\Models\ControllerModel; // Ensure this is the correct model for the controllers
use Illuminate\Support\Facades\DB;
use App\Models\Expense;

class ControllerName extends Controller
{
    public function create()
    {
        // Fetch the controller_id from session
        $controller_id = session()->get('Controller_ID');
    
        // Check if controller_id exists in the session
        if (!$controller_id) {
            return redirect()->route('login')->withErrors('Controller ID is not set. Please log in.');
        }
    
        // Pass controller_id to the view
        return view('controller.expcreate', compact('controller_id'));
    }
    
    

    public function store(Request $request)
{
    // Validate the request data
    $validated = $request->validate([
        'controller_id' => 'required|exists:controllers,id',
        'expense_group' => 'required|string|max:255',
        'expense_category' => 'required|string|max:255',
    ]);

    // Create a new expense with the validated data
    Expense::create([
        'controller_id' => $validated['controller_id'],
        'group_name' => $validated['expense_group'],
        'category_name' => $validated['expense_category'],
    ]);

    // Redirect with a success message
    return redirect()->route('expenses.create')->with('success', 'Expense created successfully.');
}

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:controller,id', // Ensure this matches your database table
           'Group' => 'required',
            'Category' => 'required',
        ]);

        $controller = ControllerModel::find($request->id); // Use the model to find
        if ($controller) {
            $controller->update($request->all()); // Update using the model
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 404);
    }

    public function destroy($id)
    {
        $controller = ControllerModel::find($id); // Use the model to find
        if ($controller) {
            $controller->delete(); // Delete using the model
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 404);
    }
}
