<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\nontechsupervisor;
use App\Models\nontechmanager;
use App\Models\nontechstaff;
use Mail;
use Redirect,Response;

class adminnontechcontroller extends Controller
{
    public function nontechsupervisor(Request $request){
        $aid=session()->get('ADMIN_ID');
        $result['nontechsupervisor']=DB::table('nontechsupervisors')->where('aid',$aid)->get();
        return view('admin.nontechsupervisor',$result);
    }

    public function addnontechsupervisor(Request $request,$id=""){    
        if($id>0){
            $arr=nontechsupervisor::where(['id'=>$id])->get();
            $result['id']=$arr['0']->id;
            $result['name']=$arr['0']->supname;
            $result['email']=$arr['0']->supemail;
            $result['number']=$arr['0']->supnumber;

           
        }
        else{
            $result['id']='';
            $result['name']='';
            $result['email']='';
            $result['number']='';
            
        }
        $aid=session()->get('ADMIN_ID');
        $result['departments']=DB::table('departments')->where('aid',$aid)->get();
        return view("admin.addnontechsupervisor",$result);
    }
     
    public function savenontechsupervisor(Request $request){

        if($request->post('id')>0){
            $model=nontechsupervisor::find($request->post('id'));
            $msg="Supervisor Updated";
            $oldemail=$model->supemail; 
            $oldnumber=$model->supnumber;
        }
        else{
            $model=new nontechsupervisor();
            $msg="Supervisor Inserted";
            $oldemail="";
            $oldnumber="";
        }

        if($oldemail!=$request->post('email')){
            $request->validate([
            'email'=>'required|unique:nontechsupervisors,supemail'  
            ]);
        }
        if($oldnumber!=$request->post('number')){
            $request->validate([
            'number'=>'required|unique:nontechsupervisors,supnumber'   
            ]);
        }

        $permitted_chars = '0123456789';
        $password = substr(str_shuffle($permitted_chars), 0, 5);


        $model->aid=session()->get('ADMIN_ID');
        $model->supname=$request->post('name');
        $model->supemail=$request->post('email');
        $model->supnumber=$request->post('number');
        
        if($oldemail!=$request->post('email')){
        $model->password=Hash::make($password);
        }
        $model->status=1;
        $model->save();
        
        if($oldemail!=$request->post('email')){
        $data=['name'=>$request->name,'email'=>$request->email,'number'=>$request->number,'password'=>$password];
        $user['to']=$request->email;
        Mail::send('mail.nontechsupervisorregister',$data,function($messages) use ($user){
        $messages->to($user['to']);
        $messages->subject('Login Credentials Of Your Account');
        });
        }

        $request->session()->flash('message',$msg);
        return redirect('admin/nontech/supervisor');
    }

    public function nontechsupervisorstatus(Request $request,$status,$id){
        $model=nontechsupervisor::find($id);
        $model->status=$status;
        $model->save();
        $request->session()->flash('message','Supervisor Status Changed');
        return redirect('admin/nontech/supervisor');
    }

    public function nontechsupervisordelete(Request $request, $id){
        $model=nontechsupervisor::find($id);
        $model->delete();
        $request->session()->flash('message','Supervisor Deleted');
        return redirect('admin/nontech/supervisor');
    }

    public function nontechmanager(Request $request){
        $aid=session()->get('ADMIN_ID');
        $result['nontechmanager']=DB::table('nontechmanagers')->where('aid',$aid)->get();
        return view('admin.nontechmanager',$result);
    }

    public function addnontechmanager(Request $request,$id=""){   
        if($id>0){
            $arr=nontechmanager::where(['id'=>$id])->get();
            $result['id']=$arr['0']->id;
            $result['name']=$arr['0']->mname;
            $result['email']=$arr['0']->memail;
            $result['number']=$arr['0']->mnumber;
            $result['departmentid']=$arr['0']->departmentid;
            $result['supid']=$arr['0']->supid;
        }
        else{
            $result['id']='';
            $result['name']='';
            $result['email']='';
            $result['number']='';
            $result['departmentid']='';
            $result['supid']='';
        }
        $aid=session()->get('ADMIN_ID');  
        $result['nontechsupervisors']=DB::table('nontechsupervisors')->where('aid',$aid)->get(); 
        $result['departments']=DB::table('departments')->where('aid',$aid)->get();
        return view("admin.addnontechmanager",$result);

    }
     
    public function savenontechmanager(Request $request){

        if($request->post('id')>0){
            $model=nontechmanager::find($request->post('id'));
            $msg="Manager Updated";
            $oldemail=$model->memail;
            $oldnumber=$model->mnumber; 
        }
        else{
            $model=new nontechmanager();
            $msg="Manager Inserted";
            $oldemail=""; 
            $oldnumber="";
        }

        if($oldemail!=$request->post('email')){
            $request->validate([
            'email'=>'required|unique:nontechmanagers,memail'  
            ]);
        }
        if($oldnumber!=$request->post('number')){
            $request->validate([
            'number'=>'required|unique:nontechmanagers,mnumber'   
            ]);
        }

        $permitted_chars = '0123456789';
        $password = substr(str_shuffle($permitted_chars), 0, 5);

        $model->aid=session()->get('ADMIN_ID');
        $model->mname=$request->post('name');
        $model->memail=$request->post('email');
        $model->mnumber=$request->post('number');
        $model->supid=$request->post('supid');
        $model->departmentid=$request->post('departmentid');
        if($oldemail!=$request->post('email')){
        $model->password=Hash::make($password);
        }
        $model->status=1;
        $model->save();
        
        if($oldemail!=$request->post('email')){
        $data=['name'=>$request->name,'email'=>$request->email,'number'=>$request->number,'password'=>$password];
        $user['to']=$request->email;
        Mail::send('mail.nontechmanagerregister',$data,function($messages) use ($user){
        $messages->to($user['to']);
        $messages->subject('Login Credentials Of Your Account');
        });
        }
        
        $request->session()->flash('message',$msg);
        return redirect('admin/nontech/manager');
    }

    public function nontechmanagerstatus(Request $request,$status,$id){
        $model=nontechmanager::find($id);
        $model->status=$status;
        $model->save();
        $request->session()->flash('message','Manager status changed');
        return redirect('admin/nontech/manager');
    }

    public function nontechmanagerdelete(Request $request, $id){
        $model=nontechmanager::find($id);
        $model->delete();
        $request->session()->flash('message','Manager Deleted');
        return redirect('admin/nontech/manager');
    }

    public function getdepartment($id){
        $id = $_GET['myID'];
        $a = DB::table('nontechsupervisors')->where('id',$id)->get();
        $res = DB::table('departments')->where('id',$a[0]->departmentid)->get();
        return Response::json($res);
    }

    public function nontechstaff(Request $request){
        $aid=session()->get('ADMIN_ID');
        $result['nontechstaff']=DB::table('nontechstaffs')->where('aid',$aid)->get();
        return view('admin.nontechstaff',$result);
    }

    public function addnontechstaff(Request $request,$id=""){
        if($id>0){
            $arr=nontechstaff::where(['id'=>$id])->get();
            $result['id']=$arr['0']->id;
            $result['name']=$arr['0']->fname;
            $result['email']=$arr['0']->femail;
            $result['number']=$arr['0']->fnumber;
            $result['supid']=$arr['0']->fsupid;
            $result['departmentid']=$arr['0']->fdepartmentid;
        }
        else{
            $result['id']='';
            $result['name']='';
            $result['email']='';
            $result['number']='';
            $result['supid']='';
            $result['departmentid']='';
        }
        $aid=session()->get('ADMIN_ID');    
        $result['nontechsupervisors']=DB::table('nontechsupervisors')->where('aid',$aid)->get();
        return view("admin.addnontechstaff",$result);

    }
     
    public function savenontechstaff(Request $request){

        if($request->post('id')>0){
            $model=nontechstaff::find($request->post('id'));
            $msg="Staff Updated";
            $oldemail=$model->femail; 
            $oldnumber=$model->fnumber; 
        }
        else{
            $model=new nontechstaff();
            $msg="Staff Inserted";
            $oldemail="";
            $oldnumber=""; 
        }

        if($oldemail!=$request->post('email')){
            $request->validate([
            'email'=>'required|unique:nontechstaffs,femail'  
            ]);
        }
        if($oldnumber!=$request->post('number')){
            $request->validate([
            'number'=>'required|unique:nontechstaffs,fnumber'   
            ]);
        }

        $permitted_chars = '0123456789';
        $password = substr(str_shuffle($permitted_chars), 0, 5);

        $model->aid=session()->get('ADMIN_ID');
        $model->fsupid=$request->post('supid');
        $model->fname=$request->post('name');
        $model->femail=$request->post('email');
        $model->fnumber=$request->post('number');
        $model->fdepartmentid=$request->post('departmentid');
        if($oldemail!=$request->post('email')){
        $model->password=Hash::make($password);
        }
        $model->status=1;
        $model->save();
        
        if($oldemail!=$request->post('email')){
        $data=['name'=>$request->name,'email'=>$request->email,'number'=>$request->number,'password'=>$password];
        $user['to']=$request->email;
        Mail::send('mail.nontechstaffregister',$data,function($messages) use ($user){
        $messages->to($user['to']);
        $messages->subject('Login Credentials Of Your Account');
        });
        }

        $request->session()->flash('message',$msg);
        return redirect('admin/nontech/staff');
    }

    public function nontechstaffstatus(Request $request,$status,$id){
        $model=nontechstaff::find($id);
        $model->status=$status;
        $model->save();
        $request->session()->flash('message','staff status changed');
        return redirect('admin/nontech/staff');
    }

    public function nontechstaffdelete(Request $request, $id){
        $model=nontechstaff::find($id);
        $model->delete();
        $request->session()->flash('message','staff Deleted');
        return redirect('admin/nontech/staff');
    }

    public  function getsection(){
        $id = $_GET['myID'];
        $res = DB::table('lmssections')->where('classid',$id)->get();
        return Response::json($res);
    }

}