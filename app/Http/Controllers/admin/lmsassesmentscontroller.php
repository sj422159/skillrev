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
    // Get the session value for either ADMIN_ID or Controller_ID based on the user role
    $aid = session()->get('ADMIN_ID');  // For admin
    $controller_id = session()->get('Controller_ID');  // For controller

    // Fetch assessments based on the logged-in user's access (aid or controller_id)
    $result['data'] = DB::table('assesments')
        ->where('status', 1)
        ->where(function($query) use ($aid, $controller_id) {
            // Ensure that only the admin or controller can access their respective data
            $query->where('aid', $aid)
                  ->orWhere('Controller_ID', $controller_id);
        })
        ->get();

    return view('admin.assesments', $result);  // Return the filtered data to the view
}

public function createassesment(Request $request, $id = '') {
  $sesid = session()->get('ADMIN_ID');  // Get admin ID from session
  $controller_id = session()->get('Controller_ID');  // Get controller ID from session
 // Check if it's an admin or a controller
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

  // Retrieve necessary data for creating the assessment
  $result['trainings'] = DB::table('trainingtypes')->get();
  $result['asstype'] = DB::table('asstypes')->get();
  
  
  return view('admin.createassesment', $result);
}
public function createmodule(Request $request) {
  $sesid = session()->get('ADMIN_ID');  
  $controller_id = session()->get('Controller_ID');  

  // Determine if it's a new assessment or updating an existing one
  if ($request->post('id') > 0) {
      $model = assesments::find($request->post('id'));
  } else {
      $model = new assesments();
  }

  // Get training name from the database
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
      $model->aid = 0;  
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

  // Get the saved assessment details
  $result['data'] = DB::table('assesments')->where(['id' => $model->id])->first();
  if (!$result['data']) {
      return back()->withErrors(['assesment' => 'Assessment not found after saving.']);
  }

  // Fetch sections, categories, and other related data
  $result['sections'] = DB::table('assesmentsections')
      ->where(['ass_id' => $result['data']->id])
      ->join('skillsets', 'assesmentsections.skillset', '=', 'skillsets.id')
      ->join('domains', 'assesmentsections.domain', '=', 'domains.id')
      ->select('skillsets.skillset', 'domains.domain', 'assesmentsections.id', 'assesmentsections.sectionname', 
               'assesmentsections.skillset', 'assesmentsections.totalquestions', 'assesmentsections.sectionpass', 
               'assesmentsections.sectionduration', 'assesmentsections.ordering')
      ->get();

  $managerclassid = DB::table('managers')->where('id', $request->post('mid'))->first();
  if ($managerclassid) {
      $result['categories'] = DB::table('categories')->where('id', $managerclassid->classid)->get();
  } else {
      $result['categories'] = [];
  }

  $trainings = DB::table('trainings')->where('id', $request->post('training'))->first();
  if ($trainings) {
      $result['domains'] = DB::table('domains')->where('id', $trainings->domain)->get();
  } else {
      $result['domains'] = [];
  }

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
