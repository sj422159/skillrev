<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\manager;
use Mail;
use Redirect,Response;

class lmsmanagercontroller extends Controller
{

    public function manager(Request $request){
        $aid=session()->get('ADMIN_ID');
        $result['manager']=DB::table('managers')->where('aid',$aid)->get();
        return view('admin.manager',$result);
    }


    public function addmanager(Request $request,$id=""){   
        if($id>0){
            $arr=manager::where(['id'=>$id])->get();
            $result['id']=$arr['0']->id;
            $result['name']=$arr['0']->mname;
            $result['email']=$arr['0']->memail;
            $result['number']=$arr['0']->mnumber;
            $result['classid']=$arr['0']->classid;
            $result['teachingclasses']=explode("##",$arr['0']->teachingclasses);
            $result['supid']=$arr['0']->supid;
            $result['subjectid']=explode("##",$arr['0']->msubjectid);
            $result['module']=explode("##",$arr['0']->mmoduleid);
        }
        else
        {
            $result['id']='';
            $result['name']='';
            $result['email']='';
            $result['number']='';
            $result['classid']='';
            $result['supid']='';
            $result['subjectid']='';
            $result['module']='';
            $result['teachingclasses']='';
        }

        $aid=session()->get('ADMIN_ID');  
        $result['supervisors']=DB::table('supervisors')->where('aid',$aid)->get(); 
        return view("admin.addmanager",$result);

    }
     
    public function savemanager(Request $request){

        if($request->post('id')>0){
            $model=manager::find($request->post('id'));
            $msg="manager updated";
            $oldemail=$model->memail;
            $oldnumber=$model->mnumber; 
        }
        else{
            $model=new manager();
            $msg="manager inserted";
            $oldemail=""; 
            $oldnumber="";
        }

        if($oldemail!=$request->post('email')){
            $request->validate([
            'email'=>'required|unique:managers,memail'  
            ]);
        }
        if($oldnumber!=$request->post('number')){
            $request->validate([
            'number'=>'required|unique:managers,mnumber'   
            ]);
        }

        $permitted_chars = '0123456789';
        $password = substr(str_shuffle($permitted_chars), 0, 5);

        $model->aid=session()->get('ADMIN_ID');
        $model->mname=$request->post('name');
        $model->memail=$request->post('email');
        $model->mnumber=$request->post('number');
        $model->supid=$request->post('supid');
        $g=DB::table('supervisors')->where('id',$request->post('supid'))->get('supsubjecttype');
        $model->msubjecttype=$g[0]->supsubjecttype;
        $model->classid=$request->post('classid');
        $model->teachingclasses=implode("##",$request->post('teachingclass'));
        $model->msubjectid=implode("##",$request->post('subject'));
        $model->mmoduleid=implode("##",$request->post('module'));
        if($oldemail!=$request->post('email')){
        $model->password=Hash::make($password);
        }
        $model->status=1;
        $model->save();
        
        if($oldemail!=$request->post('email')){
        $data=['name'=>$request->name,'email'=>$request->email,'number'=>$request->number,'password'=>$password];
        $user['to']=$request->email;
        Mail::send('mail.managerregister',$data,function($messages) use ($user){
        $messages->to($user['to']);
        $messages->subject('Login Credentials Of Your Account');
        });
        }
        
        $request->session()->flash('message',$msg);
        return redirect('admin/manager');
    }

    public function managerstatus(Request $request,$status,$id){
        $model=manager::find($id);
        $model->status=$status;
        $model->save();
        $request->session()->flash('message','Manager status changed');
        return redirect('admin/manager');
    }


    public function managerdelete(Request $request, $id){
        $model=manager::find($id);
        $model->delete();
        $request->session()->flash('message','Manager Deleted');
        return redirect('admin/manager');
    }

    public function managergetclass($id){
        $id = $_GET['myID'];
        $a = DB::table('supervisors')->where('id',$id)->get();
        $res = DB::table('categories')
        ->where('groupid',$a[0]->groupid)
        ->get();
        return Response::json($res);
    }
}