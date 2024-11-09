<?php

namespace App\Http\Controllers\supervisor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\supervisor;
use App\Models\studentassignation;
use App\Models\studentbooking;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use App\Exports\supervisorstudentlistExport;
use Illuminate\Support\Facades\Hash;
use Mail;

class supervisorcontroller extends Controller
{
    public function login(request $request){
        return view('supervisor.login');
    }

    public function logincheck(request $request){

    $email=$request->post('email');

        $result=supervisor::where(['supemail'=>$email])->first();
          if($result){
            if(Hash::check($request->post('password'),$result->password)){
            if($result->status=="1"){
            session()->put('SUPERVISOR_LOGIN',true);
            session()->put('SUPERVISOR_ID',$result->id);
            session()->put('SUPERVISOR_ADMIN_ID',$result->aid);
            session()->put('SUPERVISOR_GROUP_ID',$result->groupid);
            session()->put('SUPERVISOR_TYPE',$result->supsubjecttype);
            session()->put('SUPERVISOR_Name',$result->supname);
            session()->put('SUPERVISOR_Email',$result->supemail);
            session()->put('SUPERVISOR_Number',$result->supnumber);
            session()->flash('success','Successfully Logged In');
            return redirect('supervisor/dashboard');
            }else{
                $request->session()->flash("error","Access Denied");
           return redirect('/login');
             }
           }else{
             $request->session()->flash("error","Incorrect Password");
           return redirect('/login');
               }
       }else{
           $request->session()->flash("error","Invalid Login Credentials");
           return redirect('/login');
        }
    }

    public function forgotpassword(request $request){
        return view('supervisor.forgotpassword');
    }

    public function forgotpasswordcheck(request $request){

    $email=$request->post('email');

    $result=supervisor::where(['supemail'=>$email])->first();
        if($result){
         $permitted_chars = '0123456789';
         $password = substr(str_shuffle($permitted_chars), 0, 5);

         $model=supervisor::find($result->id);
         $model->password=Hash::make($password);
         $model->save();


        $data=['name'=>$result->supname,'email'=>$result->supemail,'number'=>$result->supnumber,'password'=>$password];

        $user['to']=$email;

       Mail::send('mail.supervisorforgotmail',$data,function($messages) use ($user){
        $messages->to($user['to']);
        $messages->subject('New Password Of Your Account');
       });

        $request->session()->flash('found','Check Your Mail');
        return redirect('supervisor/forgotpassword');

       }else{
           $request->session()->flash("notfound","Not Found");
           return redirect('supervisor/forgotpassword');
        }
    }

    public function dashboard(request $request){
        $sesid=session()->get('SUPERVISOR_ID');
        $aid=session()->get('SUPERVISOR_ADMIN_ID');
        $groupid=session()->get('SUPERVISOR_GROUP_ID');
        $facultyleave=DB::table('leaves')
                    ->join('faculties','faculties.id','leaves.profileid')
                    ->where('leaves.aid',$aid)->where('faculties.fsupid',$sesid)->where('portalid',4)
                    ->where('leaves.status',1)
                    ->select('leaves.*')
                    ->get();
        $managerleave=DB::table('leaves')
                    ->join('managers','managers.id','leaves.profileid')
                    ->where('leaves.aid',$aid)->where('managers.supid',$sesid)->where('portalid',2)
                    ->where('leaves.status',1)
                    ->select('leaves.*')
                    ->get();
        $result['leavemanagement']=count($facultyleave)+count($managerleave);
        $result['studentassignation']=DB::table('studentassignations')->where('aid',$aid)->where('status',1)->get();

        $group= DB::table('groups')->where('id',$groupid)->get();
        if($group[0]->gtype==1){
            $result['student']=DB::table('students')
                           ->join('categories','categories.id','students.sclassid')
                           ->where('categories.groupid',$groupid)
                           ->where('students.aid',$aid)
                           ->get();
        }else{
            $result['student']=DB::table('students')->where('students.aid',$aid)->get();

        }
        $result['image']=supervisor::where('id',$sesid)->get();
         $class=DB::table('categories')->where('groupid',$groupid)->get();
         $cv[]=[];
         if(count($class)>0){
         for($i=0;$i<count($class);$i++){
           $cv[$i]=$class[$i]->id;
         }
        }
         else{
            $cv[0]=0;
         }

         $result['trainingtype']=DB::table('trainingtypes')->get();
         for($i=0;$i<count($result['trainingtype']);$i++){
       $d=DB::table('studentassignations')->where('trainingtype',$result['trainingtype'][$i]->id)->where('cyclestatus',1)->whereIn('classid',$cv)->get();
        $result['trainingtype'][$i]->assigned=count($d);
        $v=DB::table('studentassignations')->where('trainingtype',$result['trainingtype'][$i]->id)->where('cyclestatus',2)->whereIn('classid',$cv)->get();
        $result['trainingtype'][$i]->attended=count($v);
        $c=DB::table('studentassignations')->where('trainingtype',$result['trainingtype'][$i]->id)->where('cyclestatus','>',2)->whereIn('classid',$cv)->get();
        $result['trainingtype'][$i]->completed=count($c);
      }
       $result['competition']=DB::table('competitions')->where('supid',$sesid)->get();
        return view('supervisor.dashboard',$result);
    }


    public function profile(){
        $id=session()->get('SUPERVISOR_ID');
        $model['data']=supervisor::where('id',$id)->get();
        return view('supervisor.profile',$model);
    }

     public function update(request $request)
    {
        $id=session()->get('SUPERVISOR_ID');
        $pwd=$request->post('npass');
        $repwd=$request->post('cpass');
        if($pwd!==$repwd){
            session()->flash('error',"Password Are Not Matching");
            return redirect('supervisor/profile');
        }

       $model1=supervisor::find($id);

       if(Hash::check($request->post('opass'),$model1->password)){

        $model=supervisor::find($id);
        if($pwd=='' && $repwd=='')
        {
        $model->password=Hash::make($request->post('opass'));
        }
        else{
        $model->password=Hash::make($request->post('npass'));
        }
        $model->save();
        session()->flash('message','Profile Updated Successfully');
        return redirect('supervisor/dashboard');

       }
       else{
        session()->flash('error','Old Password Not Matched');
        return redirect('supervisor/profile');
       }

    }

    public function adddetails(Request $request,$id=""){
        $sesid=session()->get('SUPERVISOR_ID');
        $aid=session()->get('SUPERVISOR_ADMIN_ID');
        $result['data']=DB::table('supervisors')->where(['id'=>$sesid])->get();
        $result['groups']=DB::table('groups')->where('aid',$aid)->get();
        if(count($result['data'])>0){
            $arr=DB::table('supervisors')->where(['id'=>$sesid])->get();
            $result['id']=$arr['0']->id;
            $result['name']=$arr['0']->supname;
            $result['email']=$arr['0']->supemail;
            $result['number']=$arr['0']->supnumber;
            $result['image']=$arr['0']->image;
            $result['groupid']=$arr['0']->groupid;
            $result['aadharnumber']=$arr['0']->aadharnumber;
        }else{
            $result['id']='';
            $result['name']='';
            $result['email']='';
            $result['number']='';
            $result['image']='';
            $result['groupid']='';
            $result['aadharnumber']='';
        }
        return view('supervisor.adddetails',$result);
    }

    public function savedetails(Request $request){
          if($request->post('id')>0){
            $model=supervisor::find($request->post('id'));
            $msg="Corporate Details Updated";
          }else{
            $model=new supervisor();
            $msg="Corporate Details Inserted";
          }
           if($request->hasfile('image')){
            $image=$request->file('image');
            $ext=$image->extension();
            $image_name=time().'.'.$ext;
            $image->move(public_path().'/supervisorimages',$image_name);
            $model->image=$image_name;
         }
        $model->supname=$request->post('name');
        $model->supemail=$request->post('email');
        $model->supnumber=$request->post('number');
        $model->aadharnumber=$request->post('aadharnumber');
        $model->save();
        session()->flash('message',$msg);
        return redirect('supervisor/dashboard');
    }


    public function studentdetails(){
        $sesid=session()->get('SUPERVISOR_ID');
        $aid=session()->get('SUPERVISOR_ADMIN_ID');
        $groupid=session()->get('SUPERVISOR_GROUP_ID');
        $group= DB::table('groups')->where('id',$groupid)->get();
        if($group[0]->gtype==1){
            $result['classes']=DB::table('categories')->where('groupid',$groupid)->where('aid',$aid)->get();
        }else{
            $result['classes']=DB::table('categories')->where('aid',$aid)->get();
        }
        $result['class']='';
        $result['section']='';
        $result['details']=[];
        return view('supervisor.studentlist',$result);
    }

    public function studentdetailsbysection(request $request){
        $sesid=session()->get('SUPERVISOR_ID');
        $aid=session()->get('SUPERVISOR_ADMIN_ID');
        $groupid=session()->get('SUPERVISOR_GROUP_ID');
        $group= DB::table('groups')->where('id',$groupid)->get();
        if($group[0]->gtype==1){
            $result['classes']=DB::table('categories')->where('groupid',$groupid)->where('aid',$aid)->get();
        }else{
            $result['classes']=DB::table('categories')->where('aid',$aid)->get();
        }
        $result['class']=$request->post('class');
        $result['section']=$request->post('section');
        $result['details']= DB::table('students')->where('aid',$aid)->where('sclassid',$result['class'])
                            ->where('ssectionid',$result['section'])
                            ->select('students.*')
                            ->get();
        return view('supervisor.studentlist',$result);
    }

    public function studentdetailsview(request $request,$id){
        $result['profile']=DB::table('students')->where('id',$id)->get();
        $result['class']=DB::table('categories')
                        ->where('id',$result['profile'][0]->sclassid)
                        ->get();
        $result['section']=DB::table('lmssections')
                        ->where('id',$result['profile'][0]->ssectionid)
                        ->get();
        $result['state']=DB::table('states')
                        ->where('id',$result['profile'][0]->sstate)
                        ->get();
        $result['city']=DB::table('cities')
                        ->where('id',$result['profile'][0]->scity)
                        ->get();
        return view('supervisor.studentdetails',$result);
    }

    public function studentdetailsexport(request $request,$classid,$sectionid){
        $name='Student List';
        return Excel::download(new supervisorstudentlistExport($classid,$sectionid), $name.'.xlsx'); 
    }

    public function assignations(Request $request){
        $aid=session()->get('SUPERVISOR_ADMIN_ID');
        $result['studentassignation']=DB::table('studentassignations')
                            ->join('managers','managers.id','studentassignations.mid')
                            ->join('trainingtypes','trainingtypes.id','studentassignations.trainingtype')
                            ->join('categories','studentassignations.classid','categories.id')
                            ->join('trainings','studentassignations.trainingid','trainings.id',)
                            ->join('lmssections','lmssections.id','studentassignations.sectionid')
                            ->where('studentassignations.aid',$aid)
                            ->where('studentassignations.status',1)
                            ->select('categories.categories','lmssections.section','managers.mname','trainingtypes.type','trainings.trainingname','studentassignations.*')
                            ->latest('studentassignations.id')
                            ->get();
        return view('supervisor.studentassignations',$result);
    }

    public function assignationsview(Request $request,$id){
        $aid=session()->get('SUPERVISOR_ADMIN_ID');
        $a=DB::table('studentassignations')->where('id',$id)->get();
        $b=explode("##",$a[0]->sid);
        $result['student']=DB::table('students')->whereIn('id',$b)->get();
        $result['preassesment']=DB::table('assesments')
                            ->where('aid',$aid)
                            ->where('ttype',$a[0]->trainingtype)
                            ->where('train',$a[0]->trainingid)
                            ->where('asstype','Pre')
                            ->where('status',1)
                            ->get();
        $result['postassesment']=DB::table('assesments')
                            ->where('aid',$aid)
                            ->where('ttype',$a[0]->trainingtype)
                            ->where('train',$a[0]->trainingid)
                            ->where('asstype','Post')
                            ->where('status',1)
                            ->get();
        $result['studentassignationid']=$id;
        return view("supervisor.viewstudentassignation",$result);
    }

    public function saveassignation(Request $request){
       // return $request->post();
        $a=DB::table('studentassignations')->where('id',$request->post('studentassignationid'))->get();
        $b=count($request->post('studentid'));
        $c=$request->post('studentid');
        $cycle=0;

        for($i=0;$i<$b;$i++){
        $model=new studentbooking();
        $model->assignid=$request->post('studentassignationid');
        $model->aid=$a[0]->aid;
        $model->mid=$a[0]->mid;
        $model->sid=$c[$i];
        $model->sclassid=$a[0]->classid;
        $model->ssectionid=$a[0]->sectionid;
        $model->trainingtype=$a[0]->trainingtype;
        $model->trainingid=$a[0]->trainingid;
        if($request->post("preapp")==1){
        $model->preapprove=1;
         $model->preass=$request->post('preass');
         $cycle=1;
         }else{
         $model->preapprove=0;
         $model->preass=$request->post('preass');
         $cycle=2;
         }

        $model->postapprove=0;
        $model->postass=$request->post('postass');
        $model->pregiven=0;
        $model->postgiven=0;
        $model->prereport=0;
        $model->postreport=0;
        $model->preresult=0;
        $model->postresult=0;
        $model->date=date('d-m-Y');
        $model->status=1;
        $model->save();
        }

        $model=studentassignation::find($request->post('studentassignationid'));
        $model->sid=implode("##",$request->post('studentid'));
        $model->status=2;
        $model->cyclestatus=$cycle;
        $model->save();

        $request->session()->flash('success',"Approved Succesfully");
        return redirect('supervisor/student/assignations');
    }

}