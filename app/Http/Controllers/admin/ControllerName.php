<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller; 
use Illuminate\Http\Request;
use App\Models\ControllerModel; // Ensure this is the correct model for the controllers
use Illuminate\Support\Facades\DB;

class ControllerName extends Controller
{
    public function index()
    {
        $controllers = ControllerModel::all(); // Or use any query to get the controllers
        $roles = Role::all(); // Or wherever you are getting roles from
        return view('controller.addcontroller', compact('controllers', 'roles'));
    }
    public function create()
    {
        $controllers = ControllerModel::all(); // Fetch controllers using the model
        $roles = DB::table('controller_role')->get();

        return view('controller.addcontroller', [
            'controllers' => $controllers, // Pass controllers to the view
            'roles' => $roles // Pass roles to the view
        ]);
    }

    public function store(Request $request)
{
    $controller = new ControllerModel;
    $controller->name = $request->name;
    $controller->role = $request->role;
    $controller->email = $request->email;
    $controller->number = $request->number;
    $controller->aid = $request->aid;  // Storing aid from session or form
    $controller->role_id = $request->role_id;  // Store role_id
    $controller->save();

    return response()->json(['success' => true]);
}


public function update(Request $request)
{
    $request->validate([
        'id' => 'required|exists:controller,id',
        'name' => 'required',
        'role_id' => 'required|exists:roles,id', // Ensure role_id is valid
        'email' => 'required|email',
        'number' => 'required',
    ]);

    // Get the aid from the session
    $aid = session()->get('ADMIN_ID'); 

    if (!$aid) {
        return response()->json(['error' => 'Administrator ID (aid) is not set in session'], 400);
    }

    // Find the controller and update the record
    $controller = ControllerModel::find($request->id);
    if ($controller) {
        $controller->update([
            'name' => $request->name,
            'role_id' => $request->role_id,
            'email' => $request->email,
            'number' => $request->number,
            'aid' => $aid, // Update the aid in the record
        ]);
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
