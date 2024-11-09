<?php

namespace App\Http\Controllers\classteacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\faculty;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Mail;

class classteachercontroller extends Controller
{
    public function login(request $request){
        return view('classteacher.login');
    }

    public function logincheck(request $request){

    $email=$request->post('email');

        $result=faculty::where(['femail'=>$email])->first();
          if($result){
            if(Hash::check($request->post('password'),$result->password)){
            if($result->status=="1" && $result->classteacher=="1"){
            session()->put('CLASSTEACHER_LOGIN',true);
            session()->put('CLASSTEACHER_ID',$result->id);
            session()->put('CLASSTEACHER_ADMIN_ID',$result->aid);
            session()->put('CLASSTEACHER_SUP_ID',$result->fsupid);
            session()->put('CLASSTEACHER_CLASS_ID',$result->classid);
            session()->put('CLASSTEACHER_SECTION_ID',$result->sectionid);
            session()->put('CLASSTEACHER_Name',$result->fname);
            session()->put('CLASSTEACHER_Email',$result->femail);
            session()->put('CLASSTEACHER_Number',$result->fnumber);
            $c=DB::table('categories')->where('id',$result->classid)->get('shortcateg');
            $s=DB::table('lmssections')->where('id',$result->sectionid)->get('section');
            session()->put('CLASSTEACHER_CLASS',$c[0]->shortcateg);
            session()->put('CLASSTEACHER_SECTION',$s[0]->section);
            session()->flash('success','Successfully Logged In');
            return redirect('classteacher/dashboard');
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
        return view('classteacher.forgotpassword');
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
        return redirect('classteacher/forgotpassword');

       }else{
           $request->session()->flash("notfound","Not Found");
           return redirect('classteacher/forgotpassword');
        }
    }

    public function dashboard(request $request){
        $sesid=session()->get('CLASSTEACHER_ID');
        $aid=session()->get('CLASSTEACHER_ADMIN_ID');
        $classid=session()->get('CLASSTEACHER_CLASS_ID');
        $sectionid=session()->get('CLASSTEACHER_SECTION_ID');
        $date=date('d-m-Y');
        $result['student']=DB::table('students')->where('aid',$aid)
                        ->where('sclassid',$classid)->where('ssectionid',$sectionid)->get();
        $result['image']=faculty::where('id',$sesid)->get();
        $result['trainingtype']=DB::table('trainingtypes')->get();
           for($i=0;$i<count($result['trainingtype']);$i++){
       $d=DB::table('studentassignations')->where('trainingtype',$result['trainingtype'][$i]->id)->where('cyclestatus',1)->where('sectionid',$sectionid)->get();
        $result['trainingtype'][$i]->assigned=count($d);
        $v=DB::table('studentassignations')->where('trainingtype',$result['trainingtype'][$i]->id)->where('cyclestatus',2)->where('sectionid',$sectionid)->get();
        $result['trainingtype'][$i]->attended=count($v);
        $c=DB::table('studentassignations')->where('trainingtype',$result['trainingtype'][$i]->id)->where('cyclestatus','>',2)->where('sectionid',$sectionid)->get();
        $result['trainingtype'][$i]->completed=count($c);
      }
        $result['attendance']=DB::table('attendances')->where('classid',$classid)->where('sectionid',$sectionid)->where('date',$date)->get();
        return view('classteacher.dashboard',$result);
    }


    public function profile(){
        $id=session()->get('CLASSTEACHER_ID');
        $model['data']=faculty::where('id',$id)->get();
        return view('classteacher.profile',$model);
    }

     public function update(request $request)
    {
        $id=session()->get('CLASSTEACHER_ID');
        $pwd=$request->post('npass');
        $repwd=$request->post('cpass');
        if($pwd!==$repwd){
            session()->flash('error',"Password Are Not Matching");
            return redirect('classteacher/profile');
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
        return redirect('classteacher/dashboard');

       }
       else{
        session()->flash('error','Old Password Not Matched');
        return redirect('classteacher/profile');
       }

    }

    public function adddetails(Request $request,$id="")
    {
        $aid=session()->get('CLASSTEACHER_ADMIN_ID');
        $sesid=session()->get('CLASSTEACHER_ID');
        $result['data']=DB::table('faculties')->where(['id'=>$sesid])->get();
        // $result['roles']=DB::table('roles')
        //                 ->join('faculties','faculties.roleid','roles.id')
        //                 ->where('faculties.aid',$aid)
        //                 ->select('roles.*')
        //                 ->get();

        $d=DB::table('faculties')->where(['id'=>$sesid])->get();
        $subjectid=explode("##",$d[0]->subjectid);
        $result['subject']=DB::table('domains')->whereIn('id',$subjectid)->get();

        $result['class']=DB::table('categories')
                        ->join('faculties','faculties.classid','categories.id')
                        ->where('faculties.aid',$aid)
                        ->select('categories.*')
                        ->get();
        $result['section']=DB::table('lmssections')
                        ->join('faculties','faculties.sectionid','lmssections.id')
                        ->where('faculties.aid',$aid)
                        ->select('lmssections.*')
                        ->get();

        if(count($result['data'])>0){
            $arr=DB::table('faculties')->where(['id'=>$sesid])->get();

            $result['id']=$arr['0']->id;
           // $result['role']=$arr['0']->roleid;
            $result['name']=$arr['0']->fname;
            $result['email']=$arr['0']->femail;
            $result['number']=$arr['0']->fnumber;
            $result['image']=$arr['0']->image;
            $result['classid']=$arr['0']->classid;
            $result['sectionid']=$arr['0']->sectionid;
            $result['aadharnumber']=$arr['0']->aadharnumber;


        }else{
            $result['id']='';
           // $result['role']='';
            $result['name']='';
            $result['email']='';
            $result['number']='';
            $result['image']='';
            $result['classid']='';
            $result['sectionid']='';
            $result['aadharnumber']='';
        }
        return view('classteacher.adddetails',$result);
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
        return redirect('classteacher/dashboard');
    }


    public function studentdetails(){
        $aid=session()->get('CLASSTEACHER_ADMIN_ID');
        $classid=session()->get('CLASSTEACHER_CLASS_ID');
        $sectionid=session()->get('CLASSTEACHER_SECTION_ID');
        $result['details']=DB::table('students')->where('aid',$aid)
                        ->where('sclassid',$classid)->where('ssectionid',$sectionid)
                        ->select('students.*')
                        ->get();
        return view('classteacher.studentlist',$result);
    }

    public function studentdetailsview(request $request,$id){
        $aid=session()->get('CLASSTEACHER_ADMIN_ID');
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
        return view('classteacher.studentdetails',$result);
    }

}