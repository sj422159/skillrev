<?php

namespace App\Http\Controllers\faculty;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\faculty;
use App\Models\rescheduletimetable;
use App\Models\pendingtimetable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Mail;

class facultycontroller extends Controller
{
    public function login(request $request){
        return view('faculty.login');
    }

    public function logincheck(request $request){

    $email=$request->post('email');

        $result=faculty::where(['femail'=>$email])->first();
          if($result){
            if(Hash::check($request->post('password'),$result->password)){
            if($result->status=="1"){
            session()->put('FACULTY_LOGIN',true);
            session()->put('FACULTY_ID',$result->id);
            session()->put('FACULTY_ADMIN_ID',$result->aid);
            session()->put('FACULTY_SUP_ID',$result->fsupid);
            session()->put('FACULTY_Name',$result->fname);
            session()->put('FACULTY_Email',$result->femail);
            session()->put('FACULTY_Number',$result->fnumber);
            session()->flash('success','Successfully Logged In');
            return redirect('faculty/dashboard');
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
        return view('faculty.forgotpassword');
    }

    public function forgotpasswordcheck(request $request){

    $email=$request->post('email');

    $result=faculty::where(['femail'=>$email])->first();
        if($result){
         $permitted_chars = '0123456789';
         $password = substr(str_shuffle($permitted_chars), 0, 5);

         $model=faculty::find($result->id);
         $model->password=Hash::make($password);
         $model->save();


        $data=['name'=>$result->fname,'email'=>$result->femail,'number'=>$result->fnumber,'password'=>$password];

        $user['to']=$email;

       Mail::send('mail.facultyforgotmail',$data,function($messages) use ($user){
        $messages->to($user['to']);
        $messages->subject('New Password Of Your Account');
       });

        $request->session()->flash('found','Check Your Mail');
        return redirect('faculty/forgotpassword');

       }else{
           $request->session()->flash("notfound","Not Found");
           return redirect('faculty/forgotpassword');
        }
    }

    public function dashboard(request $request){
    $sesid=session()->get('FACULTY_ID');
    $result['image']=faculty::where('id',$sesid)->get();
    $result['trainingtype']=DB::table('trainingtypes')->get();
    $result['assignmentassigned']=DB::table('studentassignments')->where('fid',$sesid)->where('status',1)->get();
    $result['assignmentsubmitted']=DB::table('studentassignments')->where('fid',$sesid)->where('status',2)->get();
    $result['assignmentcorrected']=DB::table('studentassignments')->where('fid',$sesid)->where('status',3)->get();
    $result['assignmentcompleted']=DB::table('studentassignments')->where('fid',$sesid)->where('status',4)->get();
    return view('faculty.dashboard',$result);
    }


    public function profile(){
        $id=session()->get('FACULTY_ID');
        $model['data']=faculty::where('id',$id)->get();
        return view('faculty.profile',$model);
    }

     public function update(request $request)
    {
        $id=session()->get('FACULTY_ID');
        $pwd=$request->post('npass');
        $repwd=$request->post('cpass');
        if($pwd!==$repwd){
            session()->flash('error',"Password Are Not Matching");
            return redirect('faculty/profile');
        }

       $model1=faculty::find($id);

       if(Hash::check($request->post('opass'),$model1->password)){

        $model=faculty::find($id);
        if($pwd=='' && $repwd=='')
        {
        $model->password=Hash::make($request->post('opass'));
        }
        else{
        $model->password=Hash::make($request->post('npass'));
        }
        $model->save();
        session()->flash('message','Profile Updated Successfully');
        return redirect('faculty/dashboard');

       }
       else{
        session()->flash('error','Old Password Not Matched');
        return redirect('faculty/profile');
       }

    }

    public function adddetails(Request $request,$id="")
    {
        $aid=session()->get('FACULTY_ADMIN_ID');
        $sesid=session()->get('FACULTY_ID');
        $result['data']=DB::table('faculties')->where(['id'=>$sesid])->get();

        $d=DB::table('faculties')->where(['id'=>$sesid])->get();
        $subjectid=explode("##",$d[0]->subjectid);
        $result['subject']=DB::table('domains')->whereIn('id',$subjectid)->get();

        if(count($result['data'])>0){
            $arr=DB::table('faculties')->where(['id'=>$sesid])->get();

            $result['id']=$arr['0']->id;
            $result['name']=$arr['0']->fname;
            $result['email']=$arr['0']->femail;
            $result['number']=$arr['0']->fnumber;
            $result['image']=$arr['0']->image;
            $result['aadharnumber']=$arr['0']->aadharnumber;

        }else{
            $result['id']='';
            $result['name']='';
            $result['email']='';
            $result['number']='';
            $result['image']='';
            $result['aadharnumber']='';
        }
        return view('faculty.adddetails',$result);
    }

    public function savedetails(Request $request){
          if($request->post('id')>0){
            $model=faculty::find($request->post('id'));
            $msg="Corporate Details Updated";
          }else{
            $model=new faculty();
            $msg="Corporate Details Inserted";
          }
           if($request->hasfile('image')){
            $image=$request->file('image');
            $ext=$image->extension();
            $image_name=time().'.'.$ext;
            $image->move(public_path().'/facultyimages',$image_name);
            $model->image=$image_name;
         }
        $model->fname=$request->post('name');
        $model->femail=$request->post('email');
        $model->fnumber=$request->post('number');
        $model->aadharnumber=$request->post('aadharnumber');
        $model->save();
        session()->flash('message',$msg);
        return redirect('faculty/dashboard');
    }


    public function rescheduledclasses(){

        $fid=session()->get('FACULTY_ID');
        $date=date('d-m-Y');

        $result['rescheduledata']=DB::table('rescheduletimetables')
                        ->join('categories','rescheduletimetables.tclassid','categories.id')
                        ->join('faculties','rescheduletimetables.tprofileid','faculties.id')
                        ->join('lmssections','rescheduletimetables.tsectionid','lmssections.id')
                        ->join('domains','rescheduletimetables.tsubjectid','domains.id')
                        ->where("tportalid","FACULTY")
                        ->where('tclasstypeid',1)
                        ->where('restatus','>',0)
                        ->where('tdateid',$date)
                        ->where('tprofileid',$fid)
                        ->select('rescheduletimetables.*','categories.categories','lmssections.section','domains.dname','faculties.fname')
                        ->get();
        $result['rescheduledataopt']=DB::table('rescheduletimetables')
                            ->join('categories','rescheduletimetables.tclassid','categories.id')
                            ->join('faculties','rescheduletimetables.tprofileid','faculties.id')
                            ->join('domains','rescheduletimetables.tsubjectid','domains.id')
                            ->where("tportalid","FACULTY")
                            ->where('tclasstypeid',1)
                            ->where('tsectionid',0)
                            ->where('restatus','>',0)
                            ->where('tdateid',$date)
                            ->where('tprofileid',$fid)
                            ->select('rescheduletimetables.*','categories.categories','domains.dname','faculties.fname')
                            ->get();

        return view("faculty.rescheduledclasses",$result);
    }

    public function completedstatus(Request $request,$status,$id){
        $model=rescheduletimetable::find($id);
        $model->completionstatus=$status;
        $model->save();

        $fid=session()->get('FACULTY_ID');
        $a = DB::table('pendingtimetables')->where("tportalid","FACULTY")->where('tclasstypeid',1)->where('tprofileid',$fid)->where('tclassid',$model->tclassid)->where('tsectionid',$model->tsectionid)->where('completionstatus',0)->limit(1)->get();

        if(count($a)>0){
        $m=pendingtimetable::find($a[0]->id);
        $m->completionstatus=$status;
        $m->save();
        }

        return redirect('faculty/rescheduled/classes');
    }

}