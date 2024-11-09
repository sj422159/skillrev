<?php

namespace App\Http\Controllers\corporateadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\admin;
use Illuminate\Support\Facades\DB;
use Redirect;
use Mail;
use App\Models\userroles;
use Illuminate\Support\Facades\Hash;


class corporateadminusercontroller extends Controller
{
    public function index(){
        $result['Userroles']=DB::table('userroles')->select('userroles.*')->get();
        return view('corporateadmin.user',$result);
    }


    public function create(request $request,$id=""){
    $result['roles']=Array(Array('id'=>1,'name'=>'Marketing Manager'));
    $result['employment_status']=DB::table('employment_status')->get();

    if($id>0){

            $arr=DB::table('userroles')->where(['id'=>$id])->get();
            
            $result['id']=$arr['0']->id;
            $result['role']=$arr['0']->role;
            $result['fname']=$arr['0']->fname;
            $result['lname']=$arr['0']->lname;
            $result['mobile']=$arr['0']->mobile;
            $result['email']=$arr['0']->email;
            $result['branchoffice']=$arr['0']->branchoffice;
            $result['worklocation']=$arr['0']->worklocation;
            $result['aadhar']=$arr['0']->aadhar;
            $result['employmentstatus']=$arr['0']->employmentstatus;
            $result['status']=$arr['0']->status;
            

        }else{

            $result['id']='';
            $result['role']='';
            $result['fname']='';
            $result['lname']='';
            $result['mobile']='';
            $result['email']='';
            $result['branchoffice']='';
            $result['worklocation']='';
            $result['aadhar']='';
            $result['employmentstatus']='';
            $result['status']='';
            
        }

   
        return view('corporateadmin.adduser',$result);
    }

      public function usersave(Request $request)
    {
         if($request->post('id')>0){
            $model=Userroles::find($request->post('id'));
            $msg="User Details Updated";

          }else{
            $model=new Userroles();
            $msg="User Details Inserted";
          }
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
        $password = substr(str_shuffle($permitted_chars), 0, 5);

        $model->role=$request->post('role');
        $model->fname=$request->post('fname');
        $model->lname=$request->post('lname');
        $model->mobile=$request->post('mobile');
        $model->email=$request->post('email');
        $model->branchoffice=$request->post('branchoffice');
        $model->worklocation=$request->post('worklocation');
        $model->aadhar=$request->post('aadhar');
        $model->employmentstatus=$request->post('employmentstatus');
        $model->status=1;
        $model->password=Hash::make($password);

        $model->save();


        $data=['fname'=>$request->fname,'lname'=>$request->lname,'email'=>$request->email,'mobile'=>$request->mobile,'password'=>$password];

       $user['to']=$request->email;

       Mail::send('mail.managers',$data,function($messages) use ($user){
        $messages->to($user['to']);
        $messages->subject('Login Credentials Of Your Account');
       });

        return redirect('corporateadmin/users');
    }

    public function status(Request $request,$status,$id)
    {
        $model=Userroles::find($id);
        $model->status=$status;
        $model->save();
        $request->session()->flash('message','Role Updated');
        return redirect('corporateadmin/users');

    }

   
    public function delete(Request $request, $id)
    {   
      $a=DB::table('userroles')->where('id', $id)->delete();
      
      $request->session()->flash('message','Employee Deleted');
      return redirect('corporateadmin/users');
    }

   
}
