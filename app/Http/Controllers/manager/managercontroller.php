<?php

namespace App\Http\Controllers\manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\manager;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Mail;

class managercontroller extends Controller
{
    public function login(request $request){
        return view('manager.login');
    }

    public function logincheck(request $request){

    $email=$request->post('email');

        $result=manager::where(['memail'=>$email])->first();
          if($result){
            if(Hash::check($request->post('password'),$result->password)){
            if($result->status=="1"){
            session()->put('MANAGER_LOGIN',true);
            session()->put('MANAGER_ID',$result->id);
            session()->put('MANAGER_ADMIN_ID',$result->aid);
            session()->put('MANAGER_CLASS_ID',$result->classid);
            session()->put('MANAGER_GROUPMANAGER_ID',$result->supid);
            session()->put('MANAGER_Name',$result->mname);
            session()->put('MANAGER_Email',$result->memail);
            session()->put('MANAGER_Number',$result->mnumber);
            session()->flash('success','Successfully Logged In');
            return redirect('manager/dashboard');
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
        return view('manager.forgotpassword');
    }

    public function forgotpasswordcheck(request $request){

    $email=$request->post('email');

    $result=manager::where(['memail'=>$email])->first();
        if($result){
         $permitted_chars = '0123456789';
         $password = substr(str_shuffle($permitted_chars), 0, 5);

         $model=manager::find($result->id);
         $model->password=Hash::make($password);
         $model->save();


        $data=['name'=>$result->mname,'email'=>$result->memail,'number'=>$result->mnumber,'password'=>$password];

        $user['to']=$email;

       Mail::send('mail.managerforgotmail',$data,function($messages) use ($user){
        $messages->to($user['to']);
        $messages->subject('New Password Of Your Account');
       });

        $request->session()->flash('found','Check Your Mail');
        return redirect('manager/forgotpassword');

       }else{
           $request->session()->flash("notfound","Not Found");
           return redirect('manager/forgotpassword');
        }
    }

    public function dashboard(request $request){
      $sesid=session()->get('MANAGER_ID');
      $aid=session()->get('MANAGER_ADMIN_ID');
      $result['trainingtype']=DB::table('trainingtypes')->get();
      for($i=0;$i<count($result['trainingtype']);$i++){
       $d=DB::table('studentassignations')->where('trainingtype',$result['trainingtype'][$i]->id)->where('cyclestatus',1)->where('mid',$sesid)->get();
        $result['trainingtype'][$i]->assigned=count($d);
        $v=DB::table('studentassignations')->where('trainingtype',$result['trainingtype'][$i]->id)->where('cyclestatus',2)->where('mid',$sesid)->get();
        $result['trainingtype'][$i]->attended=count($v);
        $c=DB::table('studentassignations')->where('trainingtype',$result['trainingtype'][$i]->id)->where('cyclestatus','>',2)->where('mid',$sesid)->get();
        $result['trainingtype'][$i]->completed=count($c);
      }
      $result['training']=DB::table('trainings')->where('mid',$sesid)->where('status',1)->get();
      $result['student']=DB::table('students')->where('mid',$sesid)->get();
      $result['image']=manager::where('id',$sesid)->get();

        $date=date('d-m-Y');
        $rescheduledata=DB::table('rescheduletimetables')
                            ->where("tportalid","MANAGER")
                            ->where('tsectionid','!=',0)
                            ->where('tclasstypeid',1)
                            ->where('restatus','>',0)
                            ->where('tdateid',$date)
                            ->where('tprofileid',$sesid)
                            ->get();
        $rescheduledataopt=DB::table('rescheduletimetables')
                            ->where("tportalid","MANAGER")
                            ->where('tclasstypeid',1)
                            ->where('tsectionid',0)
                            ->where('restatus','>',0)
                            ->where('tdateid',$date)
                            ->where('tprofileid',$sesid)
                            ->get();

        $result['rescheduledclasses']=count($rescheduledata)+count($rescheduledataopt);
        $result['competition']=DB::table('competitions')->where('mid',$sesid)->get();

      return view('manager.dashboard',$result);
    }


    public function profile(){
        $id=session()->get('MANAGER_ID');
        $model['data']=manager::where('id',$id)->get();
        return view('manager.profile',$model);
    }

     public function update(request $request)
    {
        $id=session()->get('MANAGER_ID');
        $pwd=$request->post('npass');
        $repwd=$request->post('cpass');
        if($pwd!==$repwd){
            session()->flash('error',"Password Are Not Matching");
            return redirect('manager/profile');
        }

       $model1=manager::find($id);

       if(Hash::check($request->post('opass'),$model1->password)){

        $model=manager::find($id);
        if($pwd=='' && $repwd=='')
        {
        $model->password=Hash::make($request->post('opass'));
        }
        else{
        $model->password=Hash::make($request->post('npass'));
        }
        $model->save();
        session()->flash('message','Profile Updated Successfully');
        return redirect('manager/dashboard');

       }
       else{
        session()->flash('error','Old Password Not Matched');
        return redirect('manager/profile');
       }

    }

    public function adddetails(Request $request,$id=""){
        $sesid=session()->get('MANAGER_ID');
        $result['data']=DB::table('managers')->where(['id'=>$sesid])->get();

        if(count($result['data'])>0){
            $arr=DB::table('managers')->where(['id'=>$sesid])->get();
            $result['id']=$arr['0']->id;
            $result['name']=$arr['0']->mname;
            $result['email']=$arr['0']->memail;
            $result['number']=$arr['0']->mnumber;
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
        return view('manager.adddetails',$result);
    }

    public function savedetails(Request $request)
    {
          if($request->post('id')>0){
            $model=manager::find($request->post('id'));
            $msg="Corporate Details Updated";
          }else{

            $model=new manager();
            $msg="Corporate Details Inserted";
          }

           if($request->hasfile('image')){
            $image=$request->file('image');
            $ext=$image->extension();
            $image_name=time().'.'.$ext;
            $image->move(public_path().'/managerimages',$image_name);
            $model->image=$image_name;
         }

        $model->mname=$request->post('name');
        $model->memail=$request->post('email');
        $model->mnumber=$request->post('number');
        $model->aadharnumber=$request->post('aadharnumber');
        $model->save();
        session()->flash('message',$msg);
        return redirect('manager/dashboard');
    }

    public function rescheduledclasses(){

        $mid=session()->get('MANAGER_ID');
        $date=date('d-m-Y');

        $result['rescheduledata']=DB::table('rescheduletimetables')
                        ->join('categories','rescheduletimetables.tclassid','categories.id')
                        ->join('managers','rescheduletimetables.tprofileid','managers.id')
                        ->join('lmssections','rescheduletimetables.tsectionid','lmssections.id')
                        ->join('domains','rescheduletimetables.tsubjectid','domains.id')
                        ->where("tportalid","MANAGER")
                        ->where('tclasstypeid',1)
                        ->where('restatus','>',0)
                        ->where('tdateid',$date)
                        ->where('tprofileid',$mid)
                        ->select('rescheduletimetables.*','categories.categories','lmssections.section','domains.dname','managers.mname')
                        ->get();
        $result['rescheduledataopt']=DB::table('rescheduletimetables')
                            ->join('categories','rescheduletimetables.tclassid','categories.id')
                            ->join('managers','rescheduletimetables.tprofileid','managers.id')
                            ->join('domains','rescheduletimetables.tsubjectid','domains.id')
                            ->where("tportalid","MANAGER")
                            ->where('tclasstypeid',1)
                            ->where('tsectionid',0)
                            ->where('restatus','>',0)
                            ->where('tdateid',$date)
                            ->where('tprofileid',$mid)
                            ->select('rescheduletimetables.*','categories.categories','domains.dname','managers.mname')
                            ->get();

        return view("manager.rescheduledclasses",$result);
    }

}