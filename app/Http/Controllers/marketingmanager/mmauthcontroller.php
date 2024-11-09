<?php

namespace App\Http\Controllers\marketingmanager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\userroles;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Mail;
use Redirect,Response;

class mmauthcontroller extends Controller
{
     public function login(request $request){
        return view('marketingmanager.login');
    }

    public function logincheck(request $request){

        $email=$request->post('email');
        $role=1;
        $result=Userroles::where(['email'=>$email,'role'=>1])->first();
          if($result){
            if(Hash::check($request->post('password'),$result->password)){
            if($result->status=="1"){
            session()->put('MARKETINGMANAGER_LOGIN',true);
            session()->put('MARKETINGMANAGER_ID',$result->id);
            session()->put('MARKETINGMANAGER_fname',$result->fname);
            session()->put('MARKETINGMANAGER_lname',$result->lname);
            session()->put('MARKETINGMANAGER_Email',$result->email);
            session()->put('MARKETINGMANAGER_Number',$result->mobile);
            session()->flash('success','Successfully Logged In');
            return redirect('employee/marketingmanager/dashboard');
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
        return view('marketingmanager.forgotpassword');
    }

    public function forgotpasswordcheck(request $request){
    $email=$request->post('email');
    $role=1;
    $result=Userroles::where(['email'=>$email,'role'=>1])->first();
        if($result){
         $permitted_chars = '0123456789';
         $password = substr(str_shuffle($permitted_chars), 0, 5);

         $model=Userroles::find($result->id);
         $model->password=Hash::make($password);
         $model->save();


        $data=['name'=>$result->fname,'email'=>$result->email,'number'=>$result->mobile,'password'=>$password];

        $user['to']=$request->email;

       Mail::send('mail.managersforgotmail',$data,function($messages) use ($user){
        $messages->to($user['to']);
        $messages->subject('New Password Of Your Account');
       });

        $request->session()->flash('found','Check Your Mail');
        return redirect('employee/marketingmanager/forgotpassword');

       }else{
           $request->session()->flash("notfound","Not Found");
           return redirect('employee/marketingmanager/forgotpassword');
        }
    }

    public function dashboard(request $request){
      $sesid=session()->get('MARKETINGMANAGER_ID');
      $result['data']=DB::table('userroles')->where('id',$sesid)->get();
      $result['coldcallinitiated']=DB::table('mocoldcalllists')
                                    ->join('marketingofficers','marketingofficers.id','mocoldcalllists.moid')
                                    ->where('marketingofficers.mmid',$sesid)
                                    ->where('status',2)
                                    ->get();
        $result['coldcallinprogress']=DB::table('mocoldcalllists')
                                    ->join('marketingofficers','marketingofficers.id','mocoldcalllists.moid')
                                    ->where('marketingofficers.mmid',$sesid)
                                    ->where('status',3)
                                    ->get();
        $result['coldcallcompleted']=DB::table('mocoldcalllists')
                                    ->join('marketingofficers','marketingofficers.id','mocoldcalllists.moid')
                                    ->where('marketingofficers.mmid',$sesid)
                                    ->where('status',4)
                                    ->get();
      $result['marketingofficers']=DB::table('marketingofficers')->where('mmid',$sesid)->get();

      return view('marketingmanager.dashboard',$result);
    }

    public function adddetails(){
        $id=session()->get('MARKETINGMANAGER_ID');
        $model['data']=userroles::where('id',$id)->get();
        return view('marketingmanager.adddetails',$model);
    }

    public function savedetails(request $request){
        $id=$request->post('id');
        $model=Userroles::find($id);
        $model->fname=$request->post('fname');
        $model->lname=$request->post('lname');
        $model->mobile=$request->post('mobile');
        $model->email=$request->post('email');
        $model->branchoffice=$request->post('branchoffice');
        $model->worklocation=$request->post('worklocation');
        $model->aadhar=$request->post('aadhar');

         if($request->hasfile('image')){
            $image=$request->file('image');
            $ext=$image->extension();
            $image_name=time().'.'.$ext;
            $image->move(public_path().'/internalimages',$image_name);
            $model->image=$image_name;
         }
         $model->save();

          session()->flash('success','Personal details Uploaded Successfully');
         return redirect('employee/marketingmanager/dashboard');
    }

    public function profile(){
        $sesid=session()->get('MARKETINGMANAGER_ID');
        $model['data']=Userroles::where('id',$sesid)->get();
        return view('marketingmanager.profile',$model);
    }

    public function update(request $request){
        $sesid=session()->get('MARKETINGMANAGER_ID');
        $pwd=$request->post('npass');
        $repwd=$request->post('cpass');
        if($pwd!==$repwd){
            session()->flash('error',"Password Are Not Matching");
            return redirect('employee/marketingmanager/profile');
        }

       $model1=Userroles::find($sesid);

       if(Hash::check($request->post('opass'),$model1->password)){

        $model=Userroles::find($id);
        if($pwd=='' && $repwd=='')
        {
        $model->password=Hash::make($request->post('opass'));
        }
        else{
        $model->password=Hash::make($request->post('npass'));
        }
        $model->save();
        session()->flash('message','Profile Updated Successfully');
        return redirect('employee/marketingmanager/dashboard');

       }
       else{
        session()->flash('error','Old Password Not Matched');
        return redirect('employee/marketingmanager/profile');
       }
    }

}
