<?php

namespace App\Http\Controllers\marketingofficer;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use App\Models\marketingofficer;
use Mail;


class moauthcontroller extends Controller
{

   public function login(){
        return view('marketingofficer.login');
    }


    public function authcheck(request $request){

     $email=$request->post('email');

     $result=marketingofficer::where(['mousername'=>$email])->first();
          if($result){
            if(Hash::check($request->post('password'),$result->mopswd)){
                if($result->mostatus=="1"){
            session()->put('MARKETINGOFFICER_LOGIN',true);
            session()->put('MARKETINGOFFICER_ID',$result->id);
            session()->put('MARKETINGOFFICER_Fname',$result->mofname);
            session()->put('MARKETINGOFFICER_Lname',$result->molname);
            session()->put('MARKETINGOFFICER_Email',$result->moemail);
            session()->put('MARKETINGOFFICER_Number',$result->momobile);
            session()->flash('success','Successfully Logged In');

            return redirect('/employee/marketingofficer/dashboard');

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
        return view('marketingofficer.forgotpassword');
    }

    public function forgotpasswordcheck(request $request){

    $email=$request->post('email');


    $result=marketingofficer::where(['mousername'=>$email])->first();
        if($result){
         $permitted_chars = '0123456789';
         $password = substr(str_shuffle($permitted_chars), 0, 5);

         $model=marketingofficer::find($result->id);
         $model->mopswd=Hash::make($password);
         $model->save();


        $data=['email'=>$result->moemail,'password'=>$password];

       $user['to']=$result->moemail;

       Mail::send('mail.officersforgotmail',$data,function($messages) use ($user){
        $messages->to($user['to']);
        $messages->subject('New Password Of Your Account');
       });

        $request->session()->flash('found','Check Your Mail');
        return redirect('employee/marketingofficer/forgotpassword');

       }else{
           $request->session()->flash("notfound","Not Found");
           return redirect('employee/marketingofficer/forgotpassword');
        }
    }




     public function profile()

    {
        $id=session()->get('MARKETINGOFFICER_ID');
        $model['data']=marketingofficer::where('id',$id)->get();

        return view('marketingofficer.profile',$model);
    }

     public function update(request $request)
    {
        $id=session()->get('MARKETINGOFFICER_ID');
        $pwd=$request->post('npass');
        $repwd=$request->post('cpass');
        if($pwd!==$repwd){
            session()->flash('error',"Password Are Not Matching");
            return redirect('employee/marketingofficer/profile');
        }

       $model1=marketingofficer::find($id);

       if(Hash::check($request->post('opass'),$model1->mopswd)){

        $model=marketingofficer::find($id);
        if($pwd=='' && $repwd=='')
        {
        $model->mopswd=Hash::make($request->post('opass'));
        }
        else{
        $model->mopswd=Hash::make($request->post('npass'));
        }
        $model->save();
        session()->flash('success','Profile Updated Successfully');
        return redirect('employee/marketingofficer/dashboard');

       }
       else{
        session()->flash('error','Old Password Not Matched');
        return redirect('employee/marketingofficer/profile');
       }

    }


    public function dashboard(){
        $mid=session()->get('MARKETINGOFFICER_ID');
        $result['data']=DB::table('marketingofficers')->where('id',$mid)->get();
        $result['coldcallinitiated']=DB::table('mocoldcalllists')->where('moid',$mid)->where('status','<=',2)->get();
        $result['coldcallinprogress']=DB::table('mocoldcalllists')->where('moid',$mid)->where('status',3)->get();
        $result['coldcallcompleted']=DB::table('mocoldcalllists')->where('moid',$mid)->where('status',4)->get();
        return view('marketingofficer.dashboard',$result);
    }


    public function personaldetails(){
        $mid=session()->get('MARKETINGOFFICER_ID');
        $result['data']=DB::table('marketingofficers')->where('id',$mid)->get();
        return view('marketingofficer.personaldetails',$result);
    }


     public function personaldetailssave(request $request){
        $id=$request->post('id');
        $model=marketingofficer::find($id);
        $model->mofname=$request->post('fname');
        $model->molname=$request->post('lname');
        $model->momobile=$request->post('mobile');
        $model->moemail=$request->post('email');
        $model->mousername=$request->post('email');
        $model->mobranchoffice=$request->post('branchoffice');
        $model->moworklocation=$request->post('worklocation');
        $model->moaadhar=$request->post('aadhar');

         if($request->hasfile('image')){
            $image=$request->file('image');
            $ext=$image->extension();
            $image_name=time().'.'.$ext;
            $image->move(public_path().'/internalimages',$image_name);
            $model->moimage=$image_name;
         }
         $model->save();

          session()->flash('success','Personal details Uploaded Successfully');
         return redirect('employee/marketingofficer/dashboard');
    }

}
