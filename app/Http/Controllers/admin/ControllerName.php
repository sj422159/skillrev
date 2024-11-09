<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller; 
use Illuminate\Http\Request;
use App\Models\ControllerModel; // Ensure this is the correct model for the controllers
use Illuminate\Support\Facades\DB;

class ControllerName extends Controller
{
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
        $request->validate([
            'name' => 'required',
            'role' => 'required',
            'email' => 'required|email',
            'number' => 'required',
        ]);

        // Create the controller
        ControllerModel::create($request->all()); // Use the model to create

        return response()->json(['success' => true]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:controller,id', // Ensure this matches your database table
            'name' => 'required',
            'role' => 'required',
            'email' => 'required|email',
            'number' => 'required',
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
