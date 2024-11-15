<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Imports\questionsImport;
use Validator;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use App\Models\questionbank;
use Redirect,Response;

class lmsquestionbankcontroller extends Controller
{
    public function examview($id){
        $result['data']=DB::table('questionbanks')->where('id',$id)->get();
        return view('admin.viewquestion',$result);
    }

    public function questions(Request $request) {
        // Check if ADMIN_ID is set for admin or Controller_ID is set for controller
        $aid = session()->get('ADMIN_ID');
        $controller_id = session()->get('Controller_ID');
        
        // Initialize variables for data
        $result['categories'] = [];
        $result['categoryid'] = '';
        $result['domainid'] = '';
        $result['skillsetid'] = '';
        $result['skillattributeid'] = '';
        $result['data'] = [];
        
        if ($aid) {
            $result['categories'] = DB::table('categories')->where('aid', $aid)->get();
            $result['domain'] = DB::table('domains')->where('aid', $aid)->get();
        } elseif ($controller_id) {
            $result['categories'] = DB::table('categories')->where('Controller_ID', $controller_id)->get();
            $result['domain'] = DB::table('domains')->where('Controller_ID', $controller_id) ->get();
        } else {
            // If neither is found, redirect or return an error
            return redirect()->route('home')->with('error', 'No valid session found.');
        }
        
        return view('admin.questions', $result);
    }
    

    public function questionsbysa(Request $request){
        // Check if ADMIN_ID or Controller_ID is set
        $aid = session()->get('ADMIN_ID');
        $controller_id = session()->get('Controller_ID');
        
        // Get POST data
        $domain = $request->post('domain');
        $skillset = $request->post('skillset');
        $skillattribute = $request->post('skillattribute');
        
        // Prepare result data
        $result['domainid'] = $domain;
        $result['skillsetid'] = $skillset;
        $result['skillattributeid'] = $skillattribute;
        $result['categoryid'] = $request->post('category');
        
        // Initialize categories and data
        $result['categories'] = [];
        $result['data'] = [];
        
        if ($aid) {
            // If admin is logged in, fetch all categories created by the admin
            $result['categories'] = DB::table('categories')->where('aid', $aid)->get();
        } elseif ($controller_id) {
            // If controller is logged in, fetch only categories created by the controller
            $result['categories'] = DB::table('categories')
                ->where('aid', $controller_id)
                ->get();
        } else {
            // Redirect if no valid session found
            return redirect()->route('home')->with('error', 'No valid session found.');
        }
        
        // Fetch question data
        if ($aid) {
            // If admin is logged in, fetch all question banks based on skill attribute
            $result['data'] = DB::table('questionbanks')
                ->join('skillattributes', 'questionbanks.skillattribute', '=', 'skillattributes.id')
                ->where(['questionbanks.skillattribute' => $skillattribute])
                ->select('questionbanks.id', 'skillattributes.skillattribute', 'questionbanks.qtext', 'questionbanks.qtype', 'questionbanks.qstatus')
                ->get();
        } elseif ($controller_id) {
            // If controller is logged in, fetch only question banks created by the controller
            $result['data'] = DB::table('questionbanks')
                ->join('skillattributes', 'questionbanks.skillattribute', '=', 'skillattributes.id')
                ->where(['questionbanks.skillattribute' => $skillattribute])
                ->where('questionbanks.aid', $controller_id)  // Only fetch questions created by the controller
                ->select('questionbanks.id', 'skillattributes.skillattribute', 'questionbanks.qtext', 'questionbanks.qtype', 'questionbanks.qstatus')
                ->get();
        }
        
        // Return the view with the result data
        return view('admin.questions', $result);
    }
    
    

    public function add(){
        // Check if ADMIN_ID or Controller_ID is set
        $aid = session()->get('ADMIN_ID');
        $controller_id = session()->get('Controller_ID');
        
        // Initialize result data
        $result['category'] = [];
        
        // Check for session and fetch categories accordingly
        if ($aid) {
            // If admin is logged in, fetch all categories created by the admin
            $result['category'] = DB::table('categories')->where('aid', $aid)->get();
        } elseif ($controller_id) {
            // If controller is logged in, fetch only categories created by the controller
            $result['category'] = DB::table('categories')
                ->where('Controller_ID', $controller_id)
                ->get();
        } else {
            // Redirect if no valid session found
            return redirect()->route('home')->with('error', 'No valid session found.');
        }
    
        // Return the view with the result data
        return view('admin.uploadquestion', $result);
    }
    

    public function upload(Request $request){   
        // Validate the uploaded file
        $validator = validator::make($request->all(), [
            'excel' => 'required|max:5000|mimes:xlsx,xls,csv'
        ]);
        
        // Check if the validation passes
        if($validator->passes()){
            // Get the skill attribute and session data
            $skill_attr = $request->post('skillattribute');
            $aid = session()->get('ADMIN_ID');
            $controller_id = session()->get('Controller_ID');
            
            // Check if the session contains ADMIN_ID or Controller_ID
            if ($aid) {
                // If Admin is logged in, use the ADMIN_ID
                $importer = new questionsImport($skill_attr, $aid);
            } elseif ($controller_id) {
                // If Controller is logged in, use the Controller_ID and set aid as 0
                $importer = new questionsImport($skill_attr, 0); // For Controller, aid will be 0
            } else {
                // If neither is logged in, redirect with an error
                return redirect()->route('home')->with('error', 'No valid session found.');
            }
    
            // Import the Excel file
            Excel::import($importer, request()->file('excel')->store('temp'));
            
            // Success message
            $msg = "Questions Uploaded Successfully";
            $request->session()->flash('success', $msg);
            
            return redirect('admin/questions');
        } else {
            // Return validation errors if the validation fails
            return redirect()->back()->with(['errors' => $validator->errors()->all()]);
        }
    }
    

    public function editQuestion(Request $request,$id){
        $result['questiontype']=DB::table('questiontypes')->get();
        $resarr=questionbank::where(['id'=>$id])->get();
        $result['id']=$resarr['0']->id;
        $result['qtype']=$resarr['0']->qtype;
        $result['question']=$resarr['0']->qtext;
        $result['choice1']=$resarr['0']->choice1;
        $result['choice2']=$resarr['0']->choice2;
        $result['choice3']=$resarr['0']->choice3;
        $result['choice4']=$resarr['0']->choice4;
        $result['RightChoices']=$resarr['0']->RightChoices;
        $result['qimage']=$resarr['0']->qimage;
        $result['choice1image']=$resarr['0']->choice1image;
        $result['choice2image']=$resarr['0']->choice2image;
        $result['choice3image']=$resarr['0']->choice3image;
        $result['choice4image']=$resarr['0']->choice4image;
        $result['difficultylevel']=$resarr['0']->difficultylevel;
        return view('admin.editquestion',$result);
     }

    public function updateQuestion(Request $request){
      $model=questionbank::find($request->post('id'));
      $model->qtype=$request->post('qtype');
      $model->qtext=$request->post('qtext');
      $model->choice1=$request->post('choice1');
      $model->choice2=$request->post('choice2');
      $model->choice3=$request->post('choice3');
      $model->choice4=$request->post('choice4');
      $model->RightChoices=$request->post('rightchoice');
      $model->difficultylevel=$request->post('difficultylevel');

       if($request->hasfile('qimage')){  
            $image=$request->file('qimage');
            $ext=$image->extension();
            $image_name=rand(10,10000).'.'.$ext;
            $image->move(public_path().'/questionbankimages',$image_name);
            $model->qimage=$image_name;
            echo 1;
         }

         if($request->hasfile('choice1image')){  
            $image=$request->file('choice1image');
            $ext=$image->extension();
            $image_name=rand(10,10000).'.'.$ext;
            $image->move(public_path().'/questionbankimages',$image_name);
            $model->choice1image=$image_name;
            echo 2;
         }

         if($request->hasfile('choice2image')){  
            $image=$request->file('choice2image');
            $ext=$image->extension();
            $image_name=rand(10,10000).'.'.$ext;
            $image->move(public_path().'/questionbankimages',$image_name);
            $model->choice2image=$image_name;
            echo 3;

         }


         if($request->hasfile('choice3image')){  
            $image=$request->file('choice3image');
            $ext=$image->extension();
            $image_name=rand(10,10000).'.'.$ext;
            $image->move(public_path().'/questionbankimages',$image_name);
            $model->choice3image=$image_name;
            echo 4;
         }

        if($request->hasfile('choice4image')){  
            $image=$request->file('choice4image');
            $ext=$image->extension();
            $image_name=rand(10,10000).'.'.$ext;
            $image->move(public_path().'/questionbankimages',$image_name);
            $model->choice4image=$image_name;
            echo 5;
        }

       $model->qstatus="1"; 
      $model->save();
      $msg="Question updated";
      $request->session()->flash('success',$msg);
      return redirect('admin/questions');
    }

    public function deleteQuestion(Request $request,$id){
        $model=questionbank::find($id);
        $model->delete();
        $request->session()->flash('success','Question Deleted');
        return redirect('admin/questions');
    }

    public function questionbankgetcategories(Request $request) {
        // Get session data for ADMIN_ID and Controller_ID
        $aid = session()->get('ADMIN_ID');
        $controller_id = session()->get('Controller_ID');
        
        // Get the cid from the request
        $cid = $request->post('cid');
        
        // Check if the user is an admin or controller
        if ($aid) {
            $group = DB::table('groups')->where('id', $cid)->first();
            if ($group->gtype == 2) {
                $state = DB::table('categories')->where('aid', $aid)->get();
            } else {
                $state = DB::table('categories')->where('groupid', $cid)->get();
            }
        } elseif ($controller_id) {
            $group = DB::table('groups')->where('id', $cid)->first();
            if ($group->gtype == 2) {
                $state = DB::table('categories')->where('Controller_ID', $controller_id)->get();
            } else {
                // Fetch categories where groupid matches the cid and the controller's ID
                $state = DB::table('categories')->where('groupid', $cid)->where('Controller_ID', $controller_id)->get();
            }
        } else {
            // If no valid session is found, return an error
            return response()->json(['error' => 'No valid session found.']);
        }
        
        // Generate the HTML for the dropdown options
        $html = '<option value="">Select</option>';
        foreach ($state as $list) {
            $html .= '<option value="' . $list->id . '">' . $list->categories . '</option>';
        }
        
        // Return the generated HTML
        echo $html;
    }
     
    public function questionbankgetdomains(Request $request) {
        // Get session data for ADMIN_ID and Controller_ID
        $aid = session()->get('ADMIN_ID');
        $controller_id = session()->get('Controller_ID');
        $cid = $request->post('cid');
        $category = DB::table('categories')->where('id', $cid)->first();
        $group = DB::table('groups')->where('id', $category->groupid)->first();
    
        // Initialize domains
        $state = [];
    
        // Check if the user is an admin or controller
        if ($aid) {
            if ($group->gtype == 2) {
                $state = DB::table('domains')->where('category', $cid)->where('stype', 2)->get();
            } else {
                $state = DB::table('domains')->where('category', $cid)->get();
            }
        } elseif ($controller_id) {
            // If controller is logged in, fetch domains based on Controller_ID
            if ($group->gtype == 2) {
                $state = DB::table('domains')->where('category', $cid)->where('stype', 2)->where('Controller_ID', $controller_id)->get();
            } else {
                $state = DB::table('domains')->where('category', $cid)->where('Controller_ID', $controller_id)->get();
            }
        } else {
            // If no valid session found, return an error
            return response()->json(['error' => 'No valid session found.']);
        }
        
        // Generate the HTML for the dropdown options
        $html = '<option value="">Select</option>';
        foreach ($state as $list) {
            $html .= '<option value="' . $list->id . '">' . $list->domain . '</option>';
        }
        
        // Return the generated HTML
        echo $html;
    }
    

    public  function questionbankgetskillsets(request $request){
        $sid = $request->post('sid');
        $city = DB::table('skillsets')->where('domain', $sid)->get();
        echo $html='<option value="">Select</option>';
        foreach($city as $list){
        echo  $html='<option value="'.$list->id.'">'.$list->skillset.'</option>';
        }
    } 

    public  function questionbankgetskillattributes(request $request){
        $gid = $request->post('gid');
        $b = DB::table('skillattributes')->where('skillset', $gid)->get();
        echo  $html='<option value="">Select</option>';
        foreach($b as $list){
        echo  $html='<option value="'.$list->id.'">'.$list->skillattribute.'</option>';
        }
    } 

    public function mismatch(){
        $result['que']=DB::table('questionbanks')
                         ->join('skillattributes','questionbanks.skillattribute','=','skillattributes.id')
                         ->join('skillsets','skillattributes.skillset','=','skillsets.id')
                         ->join('domains','skillattributes.domain','=','domains.id')
                         ->select('questionbanks.*','skillattributes.skillattribute','skillsets.skillset','domains.domain')->get();
        return view('admin.questionmismatch',$result);
    }

    public function improper(){
        $result['que']=DB::table('questionbanks')
                         ->join('skillattributes','questionbanks.skillattribute','=','skillattributes.id')
                         ->join('skillsets','skillattributes.skillset','=','skillsets.id')
                         ->join('domains','skillattributes.domain','=','domains.id')
                         ->select('questionbanks.*','skillattributes.skillattribute','skillsets.skillset','domains.domain')->get();
        return view('admin.improperquestion',$result);
    }    
}