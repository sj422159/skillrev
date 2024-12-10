<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller; 
use Illuminate\Http\Request;
use App\Models\ControllerModel; 
use Illuminate\Support\Facades\DB;

class ControllerName extends Controller
{
    public function index()
    {
        $aid = session()->get('ADMIN_ID'); 
        $result['controllers'] = ControllerModel::where('aid', $aid)->get();
        $result['roles'] = DB::table('controller_role')->get();

        return view('controller.controller', $result);
    }
    
    public function create(Request $request)
    {
        $aid = session()->get('ADMIN_ID'); 

        $result['controllers'] = ControllerModel::where('aid', $aid)->get();

        $result['role_name'] = DB::table('controller_role')->get();

        if ($request->has('id')) {
            $controller = ControllerModel::find($request->id);
            if ($controller) {
                $result['controller'] = $controller;

                $role = DB::table('controller_role')->where('id', $controller->Controller_role_ID)->first();
                $result['selected_role'] = $role ? $role->id : null;
            } else {
                return redirect()->back()->with('error', 'Controller not found!');
            }
        } else {
            $result['controller'] = null;
            $result['selected_role'] = null;
        }

    
        return view('controller.addcontroller', $result);
    }
    
    

    public function store(Request $request)
{
    $controller = new ControllerModel;
    $controller->name = $request->name;
    $controller->email = $request->email;
    $controller->number = $request->number;
    $controller->aid = $request->aid;
    $controller->Controller_role_id = $request->role_id;
    $controller->save();

    return redirect('/controller')->with('success', 'Controller added successfully!');
}


public function update(Request $request)
{
    $request->validate([
        'id' => 'required|exists:controller,id',
        'name' => 'required',
        'Controller_role_ID' => 'required|exists:controller_role,id', // Validate role_id
        'email' => 'required|email',
        'number' => 'required',
    ]);

    $aid = session()->get('ADMIN_ID');

    $controller = DB::table('controller')->where('id', $request->id)->first();
    
    if ($controller) {

        DB::table('controller')
        ->where('id', $request->id)
        ->update([
            'name' => $request->name,
            'Controller_role_ID' => $request->Controller_role_ID, // Update Controller_role_ID
            'email' => $request->email,
            'number' => $request->number,
            'aid' => $aid, 
        ]);

        return redirect()->route('controller.index')->with('success', 'Controller updated successfully.');
    }

    return redirect()->back()->with('error', 'Controller not found.');
}

public function destroy($id)
{
    $controller = ControllerModel::find($id); 
    if ($controller) {
        $controller->delete(); 
        return response()->json(['success' => true]);
    }

    return response()->json(['success' => false], 404);
}
}
