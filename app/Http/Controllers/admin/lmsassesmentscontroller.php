<?php

namespace App\Http\Controllers\admin;

use App\Models\assesments;
use App\Models\training;
use App\Models\assesmentsections;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Redirect,Response;

class lmsassesmentscontroller extends Controller
{

  public function colist(Request $request) {
    $aid = session()->get('ADMIN_ID');  
    $controller_id = session()->get('Controller_ID');  
    $result['data'] = DB::table('assesments')
        ->where('status', 1)
        ->where(function($query) use ($aid, $controller_id) {
            $query->where('aid', $aid)
                  ->orWhere('Controller_ID', $controller_id);
        })
        ->get();

    return view('admin.assesments', $result); 
}

public function createassesment(Request $request, $id = '') {
  $sesid = session()->get('ADMIN_ID');  
  $controller_id = session()->get('Controller_ID'); 
 if ($sesid) {
  $result['managers'] = DB::table('managers')->where('aid', $sesid)->get();  // For admin
} elseif ($controller_id) {
  $result['managers'] = DB::table('managers')->where('controller_id', $controller_id)->get();  // For controller
} else {
  $result['managers'] = [];  // Default case if no valid session is found
}
  if ($id > 0) {
      $arr = assesments::where(['id' => $id])->get();
      $result['id'] = $arr['0']->id;
      $result['assesmenttotaltime'] = $arr['0']->time;
      $result['atype'] = $arr['0']->asstype;
      $result['ttype'] = $arr['0']->ttype;
      $result['training'] = $arr['0']->train;
      $result['assesmentimage'] = $arr['0']->img;
      $result['sdesc'] = $arr['0']->sdes;
      $result['mid'] = $arr['0']->mid;
  } else {
      $result['id'] = '';
      $result['assesmenttotaltime'] = '';
      $result['atype'] = '';
      $result['ttype'] = '';
      $result['training'] = '';
      $result['assesmentimage'] = '';
      $result['sdesc'] = '';
      $result['mid'] = '';
  }

  $result['trainings'] = DB::table('trainingtypes')->get();
  $result['asstype'] = DB::table('asstypes')->get();

  return view('admin.createassesment', $result);
}











public function createmodule(Request $request) {
  $sesid = session()->get('ADMIN_ID');  
  $controller_id = session()->get('Controller_ID');  
  $controller_admin_id = session()->get('Controller_ADMIN_ID');  

  if ($request->post('id') > 0) {
      $model = assesments::find($request->post('id'));
  } else {
      $model = new assesments();
  }

  $name = DB::table('trainings')->where('id', $request->post('training'))->first();
  if ($name) {
      $assname = $request->post('atype') . ' - ' . $name->trainingname;
  } else {
      return back()->withErrors(['training' => 'Training program not found.']);
  }

  $result['assesmentname'] = $assname;
  $result['assesmenttotaltime'] = $request->post('assesmenttotaltime');
  $result['trainingtype'] = $request->post('ttype');

  if ($sesid) {
      $model->aid = $sesid;  
      $model->controller_id = 0;  
  } else if ($controller_id) {
      $model->controller_id = $controller_id;  
      $model->aid = $controller_admin_id;  
  }

  $model->assesmentname = $assname;
  if ($request->hasfile('assesmentimage')) {
      $image = $request->file('assesmentimage');
      $ext = $image->extension();
      $image_name = time() . '.' . $ext;
      $image->move(public_path() . '/assesmentimages', $image_name);
      $model->img = $image_name;
  }

  $model->asstype = $request->post('atype');
  $model->ttype = $request->post("ttype");
  $model->train = $request->post('training');
  $model->time = $request->post('assesmenttotaltime');
  $model->sdes = $request->post('sdesc');
  $model->mid = $request->post('mid');
  $model->save();

  $result['data'] = DB::table('assesments')->where(['Controller_ID' => $controller_id])->first();
  if (!$result['data']) {
      return back()->withErrors(['assesment' => 'Assessment not found after saving.']);
  }

    $result['sections'] = DB::table('assesmentsections')
      ->where(['ass_id' => $result['data']->id])
      ->join('skillsets', 'assesmentsections.skillset', '=', 'skillsets.id')
      ->join('domains', 'assesmentsections.domain', '=', 'domains.id')
      ->select('skillsets.skillset', 'domains.domain', 'assesmentsections.id', 'assesmentsections.sectionname', 
               'assesmentsections.skillset', 'assesmentsections.totalquestions', 'assesmentsections.sectionpass', 
               'assesmentsections.sectionduration', 'assesmentsections.ordering')
      ->get();

    $managerclassid = DB::table('managers')->where('id', $request->post('mid'))->first();
    $result['categories'] = DB::table('categories')->where('aid',$sesid)->orwhere('Controller_ID',$controller_id)->get();

    $trainings = DB::table('trainings')->where('id', $request->post('training'))->first();

    $result['dname'] = DB::table('domains')->where('aid',$sesid)->orwhere('Controller_ID',$controller_id)->get();


  if ($request->post("ttype") == "1") {
      $result['skillsets'] = DB::table('skillsets')->where('id', $trainings->skillset ?? null)->get();
      $result['skillattributes'] = DB::table('skillattributes')->where('id', $trainings->skillattribute ?? null)->get();
  } else {
      $skillsetid = explode("##", $trainings->skillset ?? "");
      $result['skillsets'] = DB::table('skillsets')->whereIn('id', $skillsetid)->get();
      $result['skillattributes'] = [];
  }

  return view('admin.assesmentsection', $result);
}


public function createmodules(Request $request, $id)
{
    $assesment = assesments::find($id);
    $sesid = session()->get('ADMIN_ID');  
    $controller_id = session()->get('Controller_ID');  
    $controller_admin_id = session()->get('Controller_ADMIN_ID'); 

    if (!$assesment) {
        return redirect()->route('admin.assesment.list')->with('error', 'Assessment not found.');
    }

    // Handle request parameters
    if ($request->post('id') > 0) {
        $model = assesments::find($request->post('id'));
    } else {
        $model = new assesments();
    }
  


    $categories = DB::table('categories')
        ->where('aid', $sesid)
        ->orWhere('Controller_ID', $controller_id)
        ->orWhere('aid', $controller_admin_id)
        ->get();

    $dname = DB::table('domains')->where('aid', $sesid)->orWhere('Controller_ID', $controller_id)->get();
    $trainingtype = $request->post('ttype');
    $trainings = DB::table('trainings')->where('id', $request->post('training'))->first();

    if ($request->post("ttype") == "1") {
        $skillsets = DB::table('skillsets')->where('id', $trainings->skillset ?? null)->get();
        $sections = DB::table('skillattributes')->where('id', $trainings->skillset ?? null)->orwhere('aid', $controller_admin_id)->get();
    } else {
        $skillsetid = explode("##", $trainings->skillset ?? "");
        $skillsets = DB::table('skillsets')->where('aid', $controller_admin_id)->get();
        $sections = DB::table('assesmentsections')->where('aid', $controller_admin_id)->get();
    }
  

    // Pass the assesment data to the view
    return view('admin.assesmentsection', compact('assesment', 'categories', 'dname', 'trainingtype','skillsets','sections'));
}




public function savemodule(Request $request) {
    $sesid = session()->get('ADMIN_ID');  
    $controller_id = session()->get('Controller_ID');  
    $controller_admin_id = session()->get('Controller_ADMIN_ID');  

    if ($request->post('id') > 0) {
        $model = assesments::find($request->post('id'));
    } else {
        $model = new assesments();
    }

    $name = DB::table('trainings')->where('id', $request->post('training'))->first();
    if ($name) {
        $assname = $request->post('atype') . ' - ' . $name->trainingname;
    } else {
        return back()->withErrors(['training' => 'Training program not found.']);
    }

    // Set fields
    $model->assesmentname = $assname;
    $model->asstype = $request->post('atype');
    $model->ttype = $request->post("ttype");
    $model->train = $request->post('training');
    $model->time = $request->post('assesmenttotaltime');
    $model->sdes = $request->post('sdesc');
    $model->mid = $request->post('mid');

    // Set aid and controller_id based on session
    if ($sesid) {
        $model->aid = $sesid;  
        $model->controller_id = 0;  
    } else if ($controller_id) {
        $model->controller_id = $controller_id;  
        $model->aid = $controller_admin_id;  
    }

    // Handle image upload
    if ($request->hasfile('assesmentimage')) {
        $image = $request->file('assesmentimage');
        $ext = $image->extension();
        $image_name = time() . '.' . $ext;
        $image->move(public_path() . '/assesmentimages', $image_name);
        $model->img = $image_name;
    }

    // Save the model
    $model->save();

    return redirect()->route('admin.createmodules', ['id' => $model->id]);
}

public function saveAssessment(Request $request)
{
   // Validate incoming data
   $validated = $request->validate([
    'sectionname' => 'required|string|max:255',
    'skillgroup' => 'required|exists:categories,id',
    'skillset' => 'required|array', // ensures it's an array
    'section' => 'required|array', // ensures it's an array
    'trainingtype' => 'required|in:1,2', // valid training type
]);

// Retrieve session values for Controller_ADMIN_ID and Controller_ID
$adminId = session()->get('Controller_ADMIN_ID'); // Retrieve admin ID from session
$controllerId = session()->get('Controller_ID'); // Retrieve controller ID from session

// Insert the section into the assessmentsection table
$sectionId = DB::table('assessmentsection')->insertGetId([
    'sectionname' => $request->sectionname,
    'skillgroup_id' => $request->skillgroup,
    'trainingtype' => $request->trainingtype,
    'admin_id' => $adminId,  // Save the Controller_ADMIN_ID in the section
    'controller_id' => $controllerId, // Save the Controller_ID in the section
    'created_at' => now(),
    'updated_at' => now(),
]);



// Update the status in the assessments table to 1
DB::table('assesments')
    ->where('id', $request->assessment_id)  // Replace with the actual assessment ID
    ->update(['status' => 1]);

// Redirect to the admin/assesment page after successful save
return redirect()->route('admin.assessment');
}

public function gettrainings()
{
    // Fetch the necessary training data
    $trainings = training::all(); // Replace with actual logic to fetch trainings
    return response()->json($trainings);
}


    public function delete(Request $request,$id=''){
        $model=assesments::find($id);
        $model->delete();
        $model=assesmentsections::where('ass_id',$id)->delete();
        return redirect('admin/assesments');  
    }
}
