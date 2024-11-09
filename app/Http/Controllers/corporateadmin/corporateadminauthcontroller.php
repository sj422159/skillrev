<?php

namespace App\Http\Controllers\corporateadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\corporateadmin;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Mail;
use Redirect,Response;

class corporateadminauthcontroller extends Controller{

    public function login(request $request){
        return view('corporateadmin.login');
    }

    public function logincheck(request $request){

    $email=$request->post('email');

        $result=corporateadmin::where(['caemail'=>$email])->first();
          if($result){
            if(Hash::check($request->post('password'),$result->password)){
            if($result->status=="1"){
            session()->put('CORPORATEADMIN_LOGIN',true);
            session()->put('CORPORATEADMIN_ID',$result->id);
            session()->put('CORPORATEADMIN_Name',$result->caname);
            session()->put('CORPORATEADMIN_Email',$result->caemail);
            session()->put('CORPORATEADMIN_Number',$result->canumber);
            session()->flash('success','Successfully Logged In');
            return redirect('corporateadmin/dashboard');
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
        return view('corporateadmin.forgotpassword');
    }

    public function forgotpasswordcheck(request $request){

    $email=$request->post('email');

    $result=corporateadmin::where(['caemail'=>$email])->first();
        if($result){
         $permitted_chars = '0123456789';
         $password = substr(str_shuffle($permitted_chars), 0, 5);

         $model=corporateadmin::find($result->id);
         $model->password=Hash::make($password);
         $model->save();


        $data=['name'=>$result->caname,'email'=>$result->caemail,'number'=>$result->canumber,'password'=>$password];

        $user['to']=$request->caemail;

       Mail::send('mail.adminforgotmail',$data,function($messages) use ($user){
        $messages->to($user['to']);
        $messages->subject('New Password Of Your Account');
       });

        $request->session()->flash('found','Check Your Mail');
        return redirect('corporateadmin/forgotpassword');

       }else{
           $request->session()->flash("notfound","Not Found");
           return redirect('corporateadmin/forgotpassword');
        }
    }

    public function dashboard(request $request){
      $sesid=session()->get('CORPORATEADMIN_ID');
      $result['schools']=DB::table('admins')->get();
      $result['image']=corporateadmin::where('id',$sesid)->get();

      $result['marketingmanager']=DB::table('userroles')->where('role',1)->get('id');
      $result['marketingofficer']=DB::table('marketingofficers')->get('id');
      $result['totalmarketing']=count($result['marketingmanager'])+count($result['marketingofficer']);
      return view('corporateadmin.dashboard',$result);
    }


    public function profile(){
        $id=session()->get('CORPORATEADMIN_ID');
        $model['data']=corporateadmin::where('id',$id)->get();
        return view('corporateadmin.profile',$model);
    }

    public function update(request $request)
    {
        $id=session()->get('CORPORATEADMIN_ID');
        $pwd=$request->post('npass');
        $repwd=$request->post('cpass');
        if($pwd!==$repwd){
            session()->flash('error',"Password Are Not Matching");
            return redirect('corporateadmin/profile');
        }

       $model1=corporateadmin::find($id);

       if(Hash::check($request->post('opass'),$model1->password)){

        $model=corporateadmin::find($id);
        if($pwd=='' && $repwd=='')
        {
        $model->password=Hash::make($request->post('opass'));
        }
        else{
        $model->password=Hash::make($request->post('npass'));
        }
        $model->save();
        session()->flash('message','Profile Updated Successfully');
        return redirect('corporateadmin/dashboard');

       }
       else{
        session()->flash('error','Old Password Not Matched');
        return redirect('corporateadmin/profile');
       }

    }


}