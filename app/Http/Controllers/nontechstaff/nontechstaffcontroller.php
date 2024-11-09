<?php

namespace App\Http\Controllers\nontechstaff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\nontechstaff;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Mail;

class nontechstaffcontroller extends Controller{

    public function login(request $request){
        return view('nontechstaff.login');
    }

    public function logincheck(request $request){
    $email=$request->post('email');
     
        $result=nontechstaff::where(['femail'=>$email])->first();
          if($result){
            if(Hash::check($request->post('password'),$result->password)){
            if($result->status=="1"){
            session()->put('NONTECH_STAFF_LOGIN',true);
            session()->put('NONTECH_STAFF_ID',$result->id);
            session()->put('NONTECH_STAFF_ADMIN_ID',$result->aid);
            session()->put('NONTECH_STAFF_SUP_ID',$result->fsupid);
            session()->put('NONTECH_STAFF_DEPT_ID',$result->fdepartmentid);
            session()->put('NONTECH_STAFF_Name',$result->fname);
            session()->put('NONTECH_STAFF_Email',$result->femail);
            session()->put('NONTECH_STAFF_Number',$result->fnumber);
            session()->flash('success','Successfully Logged In');
            return redirect('nontech/staff/dashboard');
            }else{
                $request->session()->flash("accesserror","Access Denied");
             return redirect('/');
            }
            }else{
             $request->session()->flash("passworderror","InCorrect Password");
             return redirect('/');
            }
       }else{
           $request->session()->flash("detailserror","Incorrect Details");
           return redirect('/');
        }
    }

    public function forgotpassword(request $request){
        return view('nontechstaff.forgotpassword');
    }

    public function forgotpasswordcheck(request $request){
    $email=$request->post('email');
     
    $result=nontechstaff::where(['femail'=>$email])->first();
        if($result){
         $permitted_chars = '0123456789';
         $password = substr(str_shuffle($permitted_chars), 0, 5);

         $model=nontechstaff::find($result->id);
         $model->password=Hash::make($password);
         $model->save();
         

        $data=['name'=>$result->fname,'email'=>$result->femail,'number'=>$result->fnumber,'password'=>$password];

        $user['to']=$request->femail;

       Mail::send('mail.nontechstaffforgotmail',$data,function($messages) use ($user){
        $messages->to($user['to']);
        $messages->subject('New Password Of Your Account');
       });

        $request->session()->flash('found','Check Your Mail');
        return redirect('nontech/staff/forgotpassword');
             
       }else{
           $request->session()->flash("notfound","Not Found");
           return redirect('nontech/staff/forgotpassword');
        }
    }
    
    public function dashboard(request $request){
        $sesid=session()->get('NONTECH_STAFF_ID');
        $result['image']=nontechstaff::where('id',$sesid)->get();
        return view('nontechstaff.dashboard',$result);
    }

    public function profile(){
        $sesid=session()->get('NONTECH_STAFF_ID');
        $model['data']=nontechstaff::where('id',$sesid)->get(); 
        return view('nontechstaff.profile',$model);
    }

    public function update(request $request){
        $sesid=session()->get('NONTECH_STAFF_ID');
        $pwd=$request->post('npass');
        $repwd=$request->post('cpass');
        if($pwd!==$repwd){
            session()->flash('error',"Password Are Not Matching");
            return redirect('nontech/staff/profile');
        }

       $model1=nontechstaff::find($sesid);

       if(Hash::check($request->post('opass'),$model1->password)){

        $model=nontechstaff::find($id);
        if($pwd=='' && $repwd=='')
        {
        $model->password=Hash::make($request->post('opass'));
        }
        else{
        $model->password=Hash::make($request->post('npass'));
        }
        $model->save();
        session()->flash('message','Profile Updated Successfully');
        return redirect('nontech/staff/dashboard');

       }
       else{
        session()->flash('error','Old Password Not Matched');
        return redirect('nontech/staff/profile');
       }
    }

    public function adddetails(Request $request,$id=""){
        $sesid=session()->get('NONTECH_STAFF_ID');
        $aid=session()->get('NONTECH_STAFF_ADMIN_ID');
        $result['data']=DB::table('nontechstaffs')->where(['id'=>$sesid])->get();
        $result['departments']=DB::table('departments')->where('aid',$aid)->get(); 
        if(count($result['data'])>0){
            $arr=DB::table('nontechstaffs')->where(['id'=>$sesid])->get();
            $result['id']=$arr['0']->id;
            $result['name']=$arr['0']->fname;
            $result['email']=$arr['0']->femail;
            $result['number']=$arr['0']->fnumber;
            $result['image']=$arr['0']->image;
            $result['departmentid']=$arr['0']->fdepartmentid;
        }else{
            $result['id']='';
            $result['name']='';
            $result['email']='';
            $result['number']='';
            $result['image']='';
            $result['departmentid']='';
        }
        return view('nontechstaff.adddetails',$result);
    }

    public function savedetails(Request $request){   
          if($request->post('id')>0){
            $model=nontechstaff::find($request->post('id'));
            $msg="Corporate Details Updated";
          }else{ 
            $model=new nontechstaff();
            $msg="Corporate Details Inserted";
          }
           if($request->hasfile('image')){  
            $image=$request->file('image');
            $ext=$image->extension();
            $image_name=time().'.'.$ext;
            $image->move(public_path().'/nontechstaffimages',$image_name);
            $model->image=$image_name;
         }
        $model->fname=$request->post('name');
        $model->femail=$request->post('email');
        $model->fnumber=$request->post('number');
        $model->save();
        session()->flash('message',$msg);
        return redirect('nontech/staff/dashboard');
    }
   
}