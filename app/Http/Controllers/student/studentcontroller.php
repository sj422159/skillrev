<?php

namespace App\Http\Controllers\student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\student;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Redirect,Response;
use Mail;

class studentcontroller extends Controller
{
    public function login(request $request){
        return view('student.login');
    }

    public function logincheck(request $request){

    $email=$request->post('email');

        $result=student::where(['semail'=>$email])->first();
          if($result){
            if(Hash::check($request->post('password'),$result->password)){
            if($result->status=="1"){
            session()->put('STUDENT_LOGIN',true);
            session()->put('STUDENT_ID',$result->id);
            session()->put('STUDENT_ADMIN_ID',$result->aid);
            session()->put('STUDENT_MANAGER_ID',$result->mid);
            session()->put('STUDENT_CLASS_ID',$result->sclassid);
            session()->put('STUDENT_SECTION_ID',$result->ssectionid);
            session()->put('STUDENT_Name',$result->sname);
            session()->put('STUDENT_Email',$result->semail);
            session()->put('STUDENT_Number',$result->snumber);
            session()->flash('success','Successfully Logged In');
            return redirect('student/dashboard');
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
        return view('student.forgotpassword');
    }

    public function forgotpasswordcheck(request $request){

    $email=$request->post('email');

    $result=student::where(['semail'=>$email])->first();
        if($result){
         $permitted_chars = '0123456789';
         $password = substr(str_shuffle($permitted_chars), 0, 5);

         $model=student::find($result->id);
         $model->password=Hash::make($password);
         $model->save();


        $data=['name'=>$result->sname,'email'=>$result->semail,'number'=>$result->snumber,'password'=>$password];

        $user['to']=$email;

       Mail::send('mail.studentforgotmail',$data,function($messages) use ($user){
        $messages->to($user['to']);
        $messages->subject('New Password Of Your Account');
       });

        $request->session()->flash('found','Check Your Mail');
        return redirect('student/forgotpassword');

       }else{
           $request->session()->flash("notfound","Not Found");
           return redirect('student/forgotpassword');
        }
    }

    public function dashboard(request $request){
    $sesid=session()->get('STUDENT_ID');
    $aid=session()->get('STUDENT_ADMIN_ID');
    $result['trainingtype']=DB::table('trainingtypes')->get();
    for($i=0;$i<count($result['trainingtype']);$i++){
       $d=DB::table('studentassignations')->where('trainingtype',$result['trainingtype'][$i]->id)->where('cyclestatus',1)->where('sid',$sesid)->get();
        $result['trainingtype'][$i]->assigned=count($d);
        $v=DB::table('studentassignations')->where('trainingtype',$result['trainingtype'][$i]->id)->where('cyclestatus',2)->where('sid',$sesid)->get();
        $result['trainingtype'][$i]->attended=count($v);
        $c=DB::table('studentassignations')->where('trainingtype',$result['trainingtype'][$i]->id)->where('cyclestatus','>',2)->where('sid',$sesid)->get();
        $result['trainingtype'][$i]->completed=count($c);
      }
    $result['assignmentassigned']=DB::table('studentassignmentbookings')->where('sid',$sesid)->where('status',1)->get();
    $result['assignmentsubmitted']=DB::table('studentassignmentbookings')->where('sid',$sesid)->where('status',2)->get();
    $result['assignmentcorrected']=DB::table('studentassignmentbookings')->where('sid',$sesid)->where('status',3)->get();
    $result['assignmentcompleted']=DB::table('studentassignmentbookings')->where('sid',$sesid)->where('status',4)->get();
    $result['image']=student::where('id',$sesid)->get();
    $result['preassesments']=DB::table('studentbookings')
                            ->join('trainings','studentbookings.trainingid','trainings.id')
                            ->join('assesments','studentbookings.preass','assesments.id')
                            ->where('studentbookings.sid',$sesid)
                            ->where('studentbookings.preapprove',1)
                            ->where('studentbookings.pregiven',0)
                            ->select('assesments.assesmentname','assesments.sdes','assesments.time','trainings.trainingname','assesments.img','studentbookings.*')
                            ->get();
    $result['postassesments']=DB::table('studentbookings')
                            ->join('trainings','studentbookings.trainingid','trainings.id')
                            ->join('assesments','studentbookings.postass','assesments.id')
                            ->where('studentbookings.sid',$sesid)
                            ->where('studentbookings.postapprove',1)
                            ->where('studentbookings.postgiven',0)
                           ->select('assesments.assesmentname','assesments.sdes','assesments.time','trainings.trainingname','assesments.img','studentbookings.*')
                            ->get();


    $result['compreassesments']=DB::table('studentbookings')
                            ->join('trainings','studentbookings.trainingid','trainings.id')
                            ->join('assesments','studentbookings.preass','assesments.id')
                            ->where('studentbookings.sid',$sesid)
                            ->where('studentbookings.pregiven',1)
                            ->select('assesments.assesmentname','assesments.sdes','assesments.time','trainings.trainingname','assesments.img','studentbookings.*')
                            ->get();
    $result['compostassesments']=DB::table('studentbookings')
                            ->join('trainings','studentbookings.trainingid','trainings.id')
                            ->join('assesments','studentbookings.postass','assesments.id')
                            ->where('studentbookings.sid',$sesid)
                            ->where('studentbookings.postgiven',1)
                           ->select('assesments.assesmentname','assesments.sdes','assesments.time','trainings.trainingname','assesments.img','studentbookings.*')
                            ->get();

    $mid=session()->get('STUDENT_MANAGER_ID');
    $result['competitions']=DB::table('competitions')->where('mid',$mid)->where('status',1)->get();
    $result['pendingfees']=DB::table('students')->where('id',$sesid)->get();
    return view('student.dashboard',$result);
    }


    public function profile(){
        $id=session()->get('STUDENT_ID');
        $model['data']=student::where('id',$id)->get();
        return view('student.profile',$model);
    }

     public function update(request $request)
    {
        $id=session()->get('STUDENT_ID');
        $pwd=$request->post('npass');
        $repwd=$request->post('cpass');
        if($pwd!==$repwd){
            session()->flash('error',"Password Are Not Matching");
            return redirect('student/profile');
        }

       $model1=student::find($id);

       if(Hash::check($request->post('opass'),$model1->password)){

        $model=student::find($id);
        if($pwd=='' && $repwd=='')
        {
        $model->password=Hash::make($request->post('opass'));
        }
        else{
        $model->password=Hash::make($request->post('npass'));
        }
        $model->save();
        session()->flash('message','Profile Updated Successfully');
        return redirect('student/dashboard');

       }
       else{
        session()->flash('error','Old Password Not Matched');
        return redirect('student/profile');
       }

    }

    public function adddetails(Request $request,$id=""){
            $sesid=session()->get('STUDENT_ID');
            $aid=session()->get('STUDENT_ADMIN_ID');
            $mid=session()->get('STUDENT_MANAGER_ID');
            $result['data']=DB::table('students')->where(['id'=>$sesid])->get();
            $result['class']=DB::table('categories')
                       ->join('managers','managers.classid','categories.id')
                       ->where('managers.id',$mid)
                       ->select('categories.*')
                       ->get();
            $result['optsubs']=DB::table('domains')->where('stype',2)->where('category',$result['class'][0]->id)->get();

        if(count($result['data'])>0){
            $arr=DB::table('students')->where(['id'=>$sesid])->get();

            $result['id']=$arr['0']->id;
            $result['name']=$arr['0']->sname;
            $result['lname']=$arr['0']->slname;
            $result['email']=$arr['0']->semail;
            $result['number']=$arr['0']->snumber;
            $result['dob']=date("Y-m-d", strtotime($arr['0']->sdob));
            $opt=explode("#*#",$arr['0']->optmod);
            $result['optmod']=[];
            if($opt[0]==0 && $opt[0]!=null){
              if(count($opt)!=count($result['optsubs'])){
               for($i=count($opt);$i<count($result['optsubs']);$i++){
                $opt[$i]="0";
               }
               $result['optmod']=$opt;
              }else{
               $result['optmod']=$opt;
              }
            }else{
                 $result['optmod']=$opt;
            }
            // return $result['optmod'];
            $result['gender']=$arr['0']->sgender;
            $result['address1']=$arr['0']->saddress1;
            $result['address2']=$arr['0']->saddress2;
            $result['state']=$arr['0']->sstate;
            $result['city']=$arr['0']->scity;
            $result['classid']=$arr['0']->sclassid;
            $result['sectionid']=$arr['0']->ssectionid;
            $result['image']=$arr['0']->image;
            $result['sfathername']=$arr['0']->sfathername;
            $result['sregistrationnumber']=$arr['0']->sregistrationnumber;
            $result['stransportservice']=$arr['0']->stransportservice;
            $result['shostelservice']=$arr['0']->shostelservice;
            $result['sdistance']=$arr['0']->sdistance;
            $result['aadharnumber']=$arr['0']->aadharnumber;

        }else{
            $result['id']='';
            $result['name']='';
            $result['sfathername']=[];
            $result['lname']='';
            $result['email']='';
            $result['number']='';
            $result['dob']='';
            $result['optmod']=[];
            $result['gender']='';
            $result['address1']='';
            $result['address2']='';
            $result['state']='';
            $result['city']='';
            $result['classid']='';
            $result['sectionid']='';
            $result['image']='';
            $result['sregistrationnumber']='';
            $result['stransportservice']='';
            $result['shostelservice']='';
            $result['sdistance']='';
            $result['aadharnumber']='';
        }


        $result['sections']=DB::table('managers')
                       ->join('lmssections','lmssections.classid','managers.classid')
                       ->where('managers.id',$mid)
                       ->select('lmssections.*')
                       ->get();
        $result['genders']=DB::table('genders')->get();
        $result['optsubs']=DB::table('domains')->where('stype',2)->where('category',$result['class'][0]->id)->get();
        $result['module']=[];
        for($i=0;$i<count($result['optsubs']);$i++){
            $result['module'][$i]=DB::table('skillsets')->where('domain',$result['optsubs'][$i]->id)->get();
        }
        //return $result['module'];
        $result['states']=DB::table('states')->where('country_id',101)->get();
        $result['distances']=DB::table('distances')->where('aid',$aid)->where('disstatus',1)->get();

        return view('student.adddetails',$result);
    }

    public function savedetails(Request $request)
    {

        $dob = $request->post('dob');
        $newdob = date("d-m-Y", strtotime($dob));
        $sub=$request->post('optional');
        $optsub='';
        $optmod='';
        if($sub==null){
            $sub=[];
        }
        for($k=0;$k<count($sub);$k++){
            $s=explode('**',$sub[$k]);
            $optsub=$optsub."#*#".$s[1];
            $optmod=$optmod."#*#".$s[0];
        }

          if($request->post('id')>0){
            $model=student::find($request->post('id'));
            $msg="Corporate Details Updated";
          }else{

            $model=new student();
            $msg="Corporate Details Inserted";
          }

           if($request->hasfile('image')){
            $image=$request->file('image');
            $ext=$image->extension();
            $image_name=time().'.'.$ext;
            $image->move(public_path().'/studentimages',$image_name);
            $model->image=$image_name;
         }

        $model->sname=$request->post('name');
        $model->slname=$request->post('lname');
        $model->sfathername=$request->post('sfathername');
        $model->semail=$request->post('email');
        $model->snumber=$request->post('number');
        $model->sdob=$newdob;
        $model->sgender=$request->post('gender');
        $model->saddress1=$request->post('address1');
        $model->saddress2=$request->post('address2');
        $model->sclassid=$request->post('class');
        $model->ssectionid=$request->post('section');
        $model->sregistrationnumber=$request->post('registrationnumber');
        $model->optsub=ltrim($optsub," #*#");
        $model->optmod=ltrim($optmod," #*#");
        $model->sstate=$request->post('state');
        $model->scity=$request->post('city');
        $model->stransportservice=$request->post('transportservice');
        if($request->post('transportservice')=="Yes"){
         $model->sdistance=$request->post('distance');
        }
        else{
            $model->sdistance=0;
        }
        $model->shostelservice=$request->post('hostelservice');
        $model->aadharnumber=$request->post('aadharnumber');
        $model->save();
        session()->flash('message',$msg);
        return redirect('student/dashboard');
    }


    public  function getcity(){
        $id = $_GET['myID'];
        $res = DB::table('states')
        ->join('cities','states.id','=','cities.state_id')
        ->where('states.id', $id)
        ->get();
        return Response::json($res);

    }



}
