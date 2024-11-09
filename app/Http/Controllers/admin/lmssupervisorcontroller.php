<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\supervisor;
use Mail;
use Redirect,Response;

class lmssupervisorcontroller extends Controller
{
    public function supervisor(Request $request){
        $aid=session()->get('ADMIN_ID');
        $result['supervisor']=DB::table('supervisors')->where('aid',$aid)->get();
        return view('admin.supervisor',$result);
    }

    public function addsupervisor(Request $request,$id=""){    
        if($id>0){
            $arr=supervisor::where(['id'=>$id])->get();
            $result['id']=$arr['0']->id;
            $result['name']=$arr['0']->supname;
            $result['email']=$arr['0']->supemail;
            $result['number']=$arr['0']->supnumber;
            $result['groupid']=$arr['0']->groupid;
            $result['subjectid']=explode("##",$arr['0']->ssubjectid);
            $result['module']=explode("##",$arr['0']->smoduleid);
        }
        else{
            $result['id']='';
            $result['name']='';
            $result['email']='';
            $result['number']='';
            $result['groupid']='';
            $result['subjectid']='';
            $result['module']=[];
        }
        $aid=session()->get('ADMIN_ID');
        $result['groups']=DB::table('groups')->where('aid',$aid)->get();
        return view("admin.addsupervisor",$result);
    }
     
    public function savesupervisor(Request $request){

        if($request->post('id')>0){
            $model=supervisor::find($request->post('id'));
            $msg="Supervisor Updated";
            $oldemail=$model->supemail;
            $oldnumber=$model->supnumber; 
        }
        else{
            $model=new supervisor();
            $msg="Supervisor Inserted";
            $oldemail="";
            $oldnumber="";
        }
        if($oldemail!=$request->post('email')){
            $request->validate([
            'email'=>'required|unique:supervisors,supemail'  
            ]);
        }
        if($oldnumber!=$request->post('number')){
            $request->validate([
            'number'=>'required|unique:supervisors,supnumber'   
            ]);
        }
        $permitted_chars = '0123456789';
        $password = substr(str_shuffle($permitted_chars), 0, 5);


        $model->aid=session()->get('ADMIN_ID');
        $model->supname=$request->post('name');
        $model->supemail=$request->post('email');
        $model->supnumber=$request->post('number');
        $model->groupid=$request->post('groupid');
        $g=DB::table('groups')->where('id',$request->post('groupid'))->get('gtype');
        $model->supsubjecttype=$g[0]->gtype;
        $model->ssubjectid=implode("##",$request->post('subject'));
        $model->smoduleid=implode("##",$request->post('module'));
        if($oldemail!=$request->post('email')){
        $model->password=Hash::make($password);
        }
        $model->status=1;
        $model->save();
        
        if($oldemail!=$request->post('email')){
        $data=['name'=>$request->name,'email'=>$request->email,'number'=>$request->number,'password'=>$password];
        $user['to']=$request->email;
        Mail::send('mail.supervisorregister',$data,function($messages) use ($user){
        $messages->to($user['to']);
        $messages->subject('Login Credentials Of Your Account');
        });
        }

        $request->session()->flash('message',$msg);
        return redirect('admin/supervisor');
    }

    public function supervisorstatus(Request $request,$status,$id){
        $model=supervisor::find($id);
        $model->status=$status;
        $model->save();
        $request->session()->flash('message','Supervisor Status Changed');
        return redirect('admin/supervisor');
    }

    public function supervisordelete(Request $request, $id){
        $model=supervisor::find($id);
        $model->delete();
        $request->session()->flash('message','Supervisor Deleted');
        return redirect('admin/supervisor');
    }
}