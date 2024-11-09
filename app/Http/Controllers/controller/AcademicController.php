<?php
namespace App\Http\Controllers\controller;


use App\Models\ControllerModel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // For authentication
use Illuminate\Support\Facades\Hash; // For password hashing
use App\Models\User; // Assuming you have a User model for the academic controller
use App\Models\Controllers;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class AcademicController extends Controller
{
    public function group(Request $request)
            {
                \Log::info("Entering group method");
                
                if (!session()->has('Controller_ID')) {
                    \Log::info("Controller_ID not set in session");
                    return redirect()->route('home')->with('error', 'Controller ID is not set in the session.');
                }
            
                $aid = session()->get('Controller_ID');
                \Log::info("Controller_ID session value: " . $aid);
            
                $result['group'] = DB::table('groups')->where('aid', $aid)->get();
                return view('admin.group', $result);
            }


            public function category(Request $request){
                $aid=session()->get('Controller_ID');
                $result['groups']=DB::table('groups')->where('aid',$aid)->get();
                $result['groupid']='';
                $result['category']=DB::table('categories')
                                ->join('groups','groups.id','categories.groupid')
                                ->where('categories.aid',$aid)
                                ->select('groups.group','categories.*')
                                ->get();
                return view('admin.category',$result);
            }
        
            public function categorybygroup(Request $request){
                $groupid=$request->post('groupid');
                $aid=session()->get('Controller_ID');
                $result['groups']=DB::table('groups')->where('aid',$aid)->get();
                $result['groupid']=$groupid;
                $result['category']=DB::table('categories')
                                ->join('groups','groups.id','categories.groupid')
                                ->where('categories.aid',$aid)
                                ->where('categories.groupid',$groupid)
                                ->select('groups.group','categories.*')
                                ->get();
                return view('admin.category',$result);
            }
        
            public function addcategory(Request $request,$id=""){   
                if($id>0){
                    $arr=category::where(['id'=>$id])->get();
                    $result['id']=$arr['0']->id;
                    $result['category']=$arr['0']->categories;
                    $result['shortcateg']=$arr['0']->shortcateg;
                    $result['max']=$arr['0']->cmaxperiod;
                    $result['groupid']=$arr['0']->groupid;
                    $result['standardid']=$arr['0']->standardid;
                }
                else{
                    $result['id']='';
                    $result['category']='';
                    $result['shortcateg']='';
                    $result['groupid']='';
                    $result['standardid']='';
                    $result['max']=0;
                }
                $aid=session()->get('Controller_ID');
                $result['groups']=DB::table('groups')->where('aid',$aid)->get();
                $result['standards']=DB::table('standards')->get();
                return view("admin.addcategory",$result);
            }
             
            public function savecategory(Request $request){
                $aid=session()->get('Controller_ID');
              
               
                if($request->post('id')>0){
                    $model=category::find($request->post('id'));
                    $msg="Category updated";
                     $data=DB::table('standards')->where('id',$request->post('standardid'))->get();
                    $category="STANDARD ".$data[0]->name;
                $model->aid=$aid;
                $model->groupid=$request->post('groupid');
                $model->standardid=$request->post('standardid');
                $model->categories=$category;
                $model->shortcateg=$request->post('shortcat');
                $model->cmaxperiod=$request->post('max');
                $model->save();
                $request->session()->flash('message',$msg);
                }
                else{
                    $d=DB::table('categories')->where('standardid',$request->post('standardid'))->where('aid',$aid)->get();
                       if(count($d)==0){
                    $model=new category();
                    $msg="Category inserted";
                     $data=DB::table('standards')->where('id',$request->post('standardid'))->get();
                    $category="STANDARD ".$data[0]->name;
                    $model->aid=$aid;
                    $model->groupid=$request->post('groupid');
                    $model->standardid=$request->post('standardid');
                    $model->categories=$category;
                    $model->shortcateg=$request->post('shortcat');
                    $model->cmaxperiod=$request->post('max');
                    $model->save();
                    $request->session()->flash('message',$msg);
                } else{
                $message="Standard  Already Exists";
                $request->session()->flash('danger',$message);
                
               }
               
               }
        
                if($request->post('id')>0){
                DB::table('domains')->where('category',$request->post('id'))
                ->update(['groupid' => $request->post('groupid')]); 
        
                DB::table('skillsets')->where('category',$request->post('id'))
                ->update(['groupid' => $request->post('groupid')]);
        
                DB::table('skillattributes')->where('category',$request->post('id'))
                ->update(['groupid' => $request->post('groupid')]);
        
                DB::table('lmssections')->where('classid',$request->post('id'))
                ->update(['groupid' => $request->post('groupid')]);
                }
        
                return redirect('admin/category');
        
              
            }
        
            public function categorydelete(Request $request, $id){
                $model=category::find($id);
                $model->delete();
                $request->session()->flash('message','Category Deleted');
                return redirect('admin/category');
            }
        
    public function login()
    {
        // Return login view
        return view('controller.login');
    }



public function save(Request $request)
{
    $validatedData = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $email = $request->post('email');

    // Use ControllerModel to check credentials from the 'controller' table
    $result = ControllerModel::where('email', $email)->first();
    
    if ($result) {
        if (Hash::check($request->post('password'), $result->password)) {
            // Set session values after successful login
            session()->put('LOGIN', true);
            session()->put('Controller_ID', $result->id);
            session()->put('Controller_Name', $result->name);
            session()->put('Controller_Email', $result->email);
            session()->put('Controller_Number', $result->number);
            session()->flash('success', 'Successfully Logged In');
            switch ($result->role) {
                case 'Academic Controller':
                    return redirect()->route('dashboard.academic');
                case 'Examination Controller':
                    return redirect()->route('dashboard.examination');
                case 'Account Controller':
                    return redirect()->route('dashboard.account');
            }
        } else {
            $request->session()->flash("error", "Incorrect Password");
            return redirect()->route('accontrol.login');
        }
    } else {
        $request->session()->flash("error", "Invalid Login Credentials");
        return redirect()->route('accontrol.login');
    }
}

    public function showForgotPasswordForm()
    {
        return view('accontrol.forgotpassword'); // Assuming you have a view file accontrol/forgotpassword.blade.php
    }

    /**
     * Handle the forgot password logic.
     */
    public function forgotPasswordCheck(Request $request)
    {
        // Validate the email input
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        // Add logic to send password reset link or email
        // Example: Sending password reset email
        // PasswordReset::sendResetLink($request->only('email'));

        return redirect()->route('accontrol.login')->with('success', 'Password reset link sent to your email.');
    }

    

    public function academicDashboard()
    {
        // Query to fetch data from the 'academics' table
        $list = DB::table('academics')->where('id', session()->get('Controller_ID'))->first();
    
      // Fetching different data from 'academics' table based on the 'type' field
        $contentmanagement = DB::table('academics')->where('type', 'contentmanagement')->get();
        $Skillsetmanagement = DB::table('academics')->where('type', 'skillsetmanagement')->get();
        $trainingtype = DB::table('academics')->where('type', 'trainingtype')->get();
    
        return view('controller.dashboard', compact('list', 'contentmanagement', 'Skillsetmanagement', 'trainingtype'));
    }
    
    public function domain(Request $request){
        $aid=session()->get('Controller_ID');
        $result['groups']=DB::table('groups')->where('aid',$aid)->get();
        $result['domain']=DB::table('domains')->where('aid',$aid)->get();
        $result['groupid']='';
        $result['categoryid']='';
        return view('admin.domain',$result);
    }

    public function domainbycategory(Request $request){
        $category=$request->post('category');
        $groupid=$request->post('group');
        $aid=session()->get('Controller_ID');
        $result['groups']=DB::table('groups')->where('aid',$aid)->get();
        $result['groupid']=$groupid;
        $result['categoryid']=$category;
        $result['domain']=DB::table('domains')->where('groupid',$groupid)->where('category',$category)->get();
        return view('admin.domain',$result);
    }

    public function adddomain(Request $request,$id=""){  
        if($id>0){
            $arr=domain::where(['id'=>$id])->get();
            $result['id']=$arr['0']->id;
            $result['groupid']=$arr['0']->groupid;
            $result['category']=$arr['0']->category;
            $result['domain']=$arr['0']->domain;
            $result['stype']=$arr['0']->stype;
            $result['subtype']=$arr['0']->subtype;
            $result['show']=$arr['0']->showsub;
            $result['dname']=$arr['0']->dname;
        }
        else{
            $result['id']='';
            $result['groupid']='';
            $result['category']='';
            $result['domain']='';
            $result['stype']='';
            $result['subtype']='';
            $result['show']='';
            $result['dname']='';
        }
        $aid=session()->get('Controller_ID');
        $result['subtypes']=["CURRICULAR","EXTRACURICULLAR","MANDATORY"];
        $result['groups']=DB::table('groups')->where('aid',$aid)->get();
        return view("admin.adddomain",$result);
    }
     
    public function savedomain(Request $request){
       // return $request->post();
         $show=0;
         if($request->post('show')=="on"){
            $show=1;
         }
         $pre="";
         if($request->post('stype')=="CURRICULAR"){
           $pre="CU";
         }else if($request->post('stype')=="MANDATORY"){
            $pre="MAN";
         }
         else{
            $pre="ECU";
         }

        if($request->post('id')>0){
            $model=domain::find($request->post('id'));
            $msg="Domain updated";
            $name=DB::table('categories')->where('id',$request->post('category'))->get();
            $domainname=$name[0]->categories.'_'.$name[0]->shortcateg.'_'.$request->post('dname');
            $model->domain=$domainname;
            $model->dname=$request->post('dname');
        }
        else{
            $model=new domain();
            $msg="Domain inserted";
            $name=DB::table('categories')->where('id',$request->post('category'))->get();
            $domainname=$name[0]->categories.'_'.$name[0]->shortcateg.'_'.$request->post('domain');
            $model->domain=$domainname;
            $model->dname=$request->post('dname');
        }
        $model->aid=session()->get('Controller_ID');
        $model->groupid=$request->post('groupid');

        $g=DB::table('groups')->where('id',$request->post('groupid'))->get('gtype');
        $model->stype=$g[0]->gtype;
        $model->category=$request->post('category'); 
        $model->subtype=$request->post('stype');
        $model->showsub=$show;
        $model->save();
        $request->session()->flash('message',$msg);

        if($request->post('id')>0){
        DB::table('skillsets')->where('domain',$request->post('id'))
        ->update(['groupid' => $request->post('groupid'),'category' => $request->post('category')]);

        DB::table('skillattributes')->where('domain',$request->post('id'))
        ->update(['groupid' => $request->post('groupid'),'category' => $request->post('category')]);
        }

        return redirect('admin/domain');
    }

    public function delete(Request $request, $id){
        $model=domain::find($id);
        $model->delete();
        $request->session()->flash('message','Domain Deleted');
        return redirect('admin/domain');
    }
    
    public function skillset(Request $request){
        $aid=session()->get('Controller_ID');
        $result['groups']=DB::table('groups')->where('aid',$aid)->get();
        $result['groupid']='';
        $result['categoryid']='';
        $result['domainid']='';
        $result['skillset']=[];
        return view('admin.skillset',$result);
    }

    public function skillsetbydomain(Request $request){
        $aid=session()->get('Controller_ID');
        $groupid=$request->post('group');
        $category=$request->post('category');
        $domain=$request->post('domain');
        $result['groups']=DB::table('groups')->where('aid',$aid)->get();
        $result['groupid']=$groupid;
        $result['categoryid']=$category;
        $result['domainid']=$domain;
        $result['skillset']=DB::table('skillsets')->where('domain',$domain)->get();
        return view('admin.skillset',$result);
    }

    public function addskillset(Request $request,$id=""){   
        if($id>0){
            $arr=skillset::where(['id'=>$id])->get();
            $result['id']=$arr['0']->id;
            $result['groupid']=$arr['0']->groupid;
            $result['category']=$arr['0']->category;
            $result['domain']=$arr['0']->domain;
            $result['skillset']=$arr['0']->skillset;
        }
        else{
            $result['id']='';
            $result['groupid']='';
            $result['category']='';
            $result['domain']='';
            $result['skillset']='';    
        }
        $aid=session()->get('Controller_ID');
        $result['groups']=DB::table('groups')->where('aid',$aid)->get();
        return view("admin.addskillset",$result);
    }
     
    public function saveskillset(Request $request){
        if($request->post('id')>0){
            $model=skillset::find($request->post('id'));
            $msg="skillset updated";
            if($model->domain!=$request->post('domain')){
                $name=DB::table('domains')->where('id',$request->post('domain'))->get();
                $skillsetname=$name[0]->domain.'_'.$request->post('skillset');
                $model->skillset=$skillsetname;
            }
        }
        else{
            $model=new skillset();
            $msg="skillset inserted";
            $name=DB::table('domains')->where('id',$request->post('domain'))->get();
            $skillsetname=$name[0]->domain.'_'.$request->post('skillset');
            $model->skillset=$skillsetname;
        }
        $model->aid=session()->get('Controller_ID');
        $model->groupid=$request->post('groupid');
        $model->category=$request->post('category');
        $model->domain=$request->post('domain');
        $model->save();
        $request->session()->flash('message',$msg);

        if($request->post('id')>0){
        DB::table('skillattributes')->where('skillset',$request->post('id'))
        ->update(['groupid' => $request->post('groupid'),'category' => $request->post('category'),'domain' => $request->post('domain')]);
        }
        return redirect('admin/skillset');
    }

    public function skillsetdelete(Request $request,$id){
        $model=skillset::find($id);
        $model->delete();
        $request->session()->flash('message','skillset Deleted');
       return redirect('admin/skillset');
    }

    public function skillattribute(Request $request){
        $aid=session()->get('Controller_ID');
        $result['groups']=DB::table('groups')->where('aid',$aid)->get();
        $result['groupid']='';
        $result['categoryid']='';
        $result['domainid']='';
        $result['skillsetid']='';
        $result['skillattribute']=[];
        return view('admin.skillattribute',$result);
    }

    public function skillattributebyskillset(Request $request){
        $aid=session()->get('Controller_ID');
        $groupid=$request->post('group');
        $category=$request->post('category');
        $domain=$request->post('domain');
        $skillset=$request->post('skillset');
        $result['groups']=DB::table('groups')->where('aid',$aid)->get();
        $result['groupid']=$groupid;
        $result['categoryid']=$category;
        $result['domainid']=$domain;
        $result['skillsetid']=$skillset;
        $result['skillattribute']=DB::table('skillattributes')->where('skillset',$skillset)->get();
        return view('admin.skillattribute',$result);
    }

    public function addskillattribute(Request $request,$id=""){      
        if($id>0){
            $arr=skillattribute::where(['id'=>$id])->get();
            $result['id']=$arr['0']->id;
            $result['groupid']=$arr['0']->groupid;
            $result['category']=$arr['0']->category;
            $result['domain']=$arr['0']->domain;
            $result['skillset']=$arr['0']->skillset;
            $result['skillattribute']=$arr['0']->skillattribute;
        }
        else{
            $result['id']='';
            $result['groupid']='';
            $result['category']='';
            $result['domain']='';
            $result['skillset']='';
            $result['skillattribute']='';    
        }
        $aid=session()->get('Controller_ID');
        $result['groups']=DB::table('groups')->where('aid',$aid)->get();
        return view("admin.addskillattribute",$result);
    }
     
    public function saveskillattribute(Request $request){
        if($request->post('id')>0){
            $model=skillattribute::find($request->post('id'));
            $msg="Skillattribute updated";
            if($model->skillset!=$request->post('skillset')){
                $name=DB::table('skillsets')->where('id',$request->post('skillset'))->get();
                $skillattributename=$name[0]->skillset.' _ '.$request->post('skillattribute');
                $model->skillattribute=$skillattributename;
            }
        }
        else{
            $model=new skillattribute();
            $msg="Skillattribute inserted";
            $name=DB::table('skillsets')->where('id',$request->post('skillset'))->get();
            $skillattributename=$name[0]->skillset.' _ '.$request->post('skillattribute');
            $model->skillattribute=$skillattributename;
        }
        $model->aid=session()->get('Controller_ID');
        $model->groupid=$request->post('groupid');
        $model->category=$request->post('category');
        $model->domain=$request->post('domain');
        $model->skillset=$request->post('skillset'); 
        $model->save();
        $request->session()->flash('message',$msg);
        return redirect('admin/skillattribute');
    }

    public function skillattributedelete(Request $request, $id){
        $model=skillattribute::find($id);
        $model->delete();
        $request->session()->flash('message','Skillattribute Deleted');
        return redirect('admin/skillattribute');
    }

    public  function getdomain(){
        $id = $_GET['myID'];
        $res = DB::table('domains')->where('category',$id)->get();
        return Response::json($res);
    }

    public  function getskillset(){
        $id = $_GET['id'];
        $res = DB::table('skillsets')->where('domain', $id)->get();
        return Response::json($res);
    }

    public  function getskillattribute(){
        $id = $_GET['id'];
        $res = DB::table('skillattributes')->where('skillset', $id)->get();
        return Response::json($res);
    }

    public function skillsetcategory($id){
        $aid=session()->get('Controller_ID');
        $id = $_GET['myID'];
        $a=DB::table('groups')->where('id',$id)->get();
        if($a[0]->gtype==2){
        $res = DB::table('categories')->where('aid',$aid)->get();
        }else{
        $res = DB::table('categories')->where('groupid',$id)->get();
        }
        return Response::json($res);
    }

    public function skillsetdomain($id){
        $id = $_GET['id'];
        $res = DB::table('domains')->where('category',$id)->get();
        return Response::json($res);
    }

    public function getdomains($id){
        $id = $_GET['id'];
        $groupid= $_GET['groupid'];
        if ($groupid==0) {
            $res = DB::table('domains')->where('category',$id)->get();
        } else {
            $res = DB::table('domains')->where('category',$id)->where('groupid',$groupid)->get();
        } 
        return Response::json($res);
    }

    public function getskillsets($id){
        $id = $_GET['id'];
        $res = DB::table('skillsets')->where('domain',$id)->get();
        return Response::json($res);
    }

    public  function skillsetgetdomains(request $request){
        $aid=session()->get('Controller_ID');
        $cid = $request->post('cid');
        $groupid = $request->post('groupid');
        $a=DB::table('groups')->where('id',$groupid)->get();
        $state = DB::table('domains')->where('category', $cid)->where('groupid',$groupid)->get();
        echo $html='<option value="">Select </option>';
        foreach($state as $list){
        echo  $html='<option value="'.$list->id.'">'.$list->domain.'</option>';
        }
    } 
    public function reports(){
        $aid=session()->get('ADMIN_ID'); 
        $result['train']=DB::table('trainings')->where('aid',$aid)->where('status',1)->get();
        $result['class']=DB::table('categories')->where('aid',$aid)->get();
        $result['cl']=0;
        $result['section']=0;
        $result['tri']=0;
        $result['data']=[];
        return view('admin.assignments',$result);
    }

    public function fetchstu(request $request){
        $aid=session()->get('ADMIN_ID');
        $result['train']=DB::table('trainings')->where('aid',$aid)->where('status',1)->get();
        $result['class']=DB::table('categories')->where('aid',$aid)->get(); 
        $result['cl']=$request->post('class');
        $result['tri']=$request->post('training');
        $result['section']=$request->post('section');
        $result['data']=DB::table('studentassignmentbookings')
                        ->join('students','studentassignmentbookings.sid','students.id')
                        ->join('trainingtypes','studentassignmentbookings.trainingtype','trainingtypes.id')
                        ->join('trainings','studentassignmentbookings.trainingid','trainings.id')
                        ->join('lmssections','students.ssectionid','lmssections.id')
                        ->join('categories','students.sclassid','categories.id')
                        ->where('students.sclassid',$request->post('class'))
                        ->where('students.ssectionid',$request->post('section'))
                        ->where('studentassignmentbookings.trainingid',$request->post('training'))
                        ->select('studentassignmentbookings.*','students.sname','students.slname','trainingtypes.type','trainings.trainingname','students.image')
                        ->get();
        return view('admin.assignments',$result);
    } 
    public function months(){
        $adminid=session()->get('ADMIN_ID');
        $result['classes']= DB::table('categories')->where('aid',$adminid)->get();
        $result['class']="";
        $result['months'] = array("January","February","March","April","May","June","July","August","September","October","November","December"); 
        $result['month']="";
        $result['dates']="";
        $result['year'] = date('Y');
        $result['currentmonth'] = date('m');
        $result['student']=[];
        $result['attendance']=[];
        $result['attendances']=[];
        return view('admin.attendancemonths',$result);
    }

    public  function getsections(request $request){
        $classid = $request->post('classid');
        $state = DB::table('lmssections')->where('classid',$classid)->get();
        echo $html='<option value="">Select</option>';
        foreach($state as $list){
          echo  $html='<option value="'.$list->id.'">'.$list->section.'</option>';
        }
    } 

    public  function getdates(request $request){
        $monthid = $request->post('monthid');
        $sectionid = $request->post('sectionid');
        $state = DB::table('attendances')
                ->where('month',$monthid)->where('sectionid',$sectionid)->where('year',date('Y'))->get();
        echo $html='<option value="">Select</option>';
        foreach($state as $list){
          echo  $html='<option value="'.$list->date.'">'.$list->date.'</option>';
        }
    } 
 

    public function students(request $request){
        $adminid=session()->get('ADMIN_ID');
        $result['classes']= DB::table('categories')->where('aid',$adminid)->get();
        $result['class']=$request->post('class');
        $result['months'] = array("January","February","March","April","May","June","July","August","September","October","November","December"); 
        $result['month']=$request->post('month');
        $result['dates']=$request->post('date');
        $result['year'] = date('Y');
        $result['currentmonth'] = date('m');


        $date=$request->post('date');
        $classid=$request->post('class');
        $section=$request->post('section');
        $result['attendances'] = DB::table('attendances')
                    ->where('date',$date)
                    ->where('classid',$classid)
                    ->where('sectionid',$section)
                    ->get(['studentid','attendancetype','attendance']);
         
        $a=explode("##",$result['attendances'][0]->studentid);
        $student = DB::table('students')->whereIn('id',$a)->get(['sname','slname']);
        
        $b=explode("##",$result['attendances'][0]->attendance);
        $result['student']=[];
        $result['attendance']=[];
        for($i=0;$i<count($student);$i++){
            $result['student'][$i]=$student[$i]->sname." ".$student[$i]->slname;
            if($result['attendances'][0]->attendancetype=="1"){
                $result['attendance'][$i]=$b[$i];
            }
            else{
                $result['attendance'][$i]=$b[0];
            }
        }
        
        return view('admin.attendancemonths',$result);
    } 
}