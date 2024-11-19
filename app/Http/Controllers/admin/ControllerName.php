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
        $aid = session()->get('ADMIN_ID'); 
        $controllers = ControllerModel::where('aid', $aid)->get();
        $roles = Role::where('aid', $aid)->get();
    
        // Pass the data to the view
        return view('controller.addcontroller', compact('controllers', 'roles'));
    }
    
    public function create()
    {
        $aid = session()->get('ADMIN_ID'); 
        $controllers = ControllerModel::where('aid', $aid)->get();// Fetch controllers using the model
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
    $controller->Controller_role_id = $request->role_id;  // Store role_id
    $controller->save();

    return response()->json(['success' => true]);
}


public function update(Request $request)
{
    $request->validate([
        'id' => 'required|exists:controller,id',
        'name' => 'required',
        'role_id' => 'required|exists:roles,id', 
        'email' => 'required|email',
        'number' => 'required',
    ]);

    $aid = session()->get('ADMIN_ID'); 

    $controller = ControllerModel::find($request->id);
    if ($controller) {
        $controller->update([
            'name' => $request->name,
            'role_id' => $request->role_id,
            'role' => $request->role,
            'email' => $request->email,
            'number' => $request->number,
            'aid' => $aid, 
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
