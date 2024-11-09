<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\faculty;
use Mail;
use Redirect,Response;

class lmsfacultycontroller extends Controller
{

    public function faculty(Request $request){
        $aid=session()->get('ADMIN_ID');
        $result['faculty']=DB::table('faculties')->where('aid',$aid)->get();
        return view('admin.faculty',$result);
    }


    public function addfaculty(Request $request,$id=""){
        if($id>0){
            $arr=faculty::where(['id'=>$id])->get();
            $result['id']=$arr['0']->id;
            $result['name']=$arr['0']->fname;
            $result['email']=$arr['0']->femail;
            $result['number']=$arr['0']->fnumber;
            $result['supid']=$arr['0']->fsupid;
            $result['subjectid']=explode("##",$arr['0']->subjectid);
            $result['module']=explode("##",$arr['0']->moduleid);
            $result['classteacher']=$arr['0']->classteacher;
            $result['classid']=$arr['0']->classid;
            $result['sectionid']=$arr['0']->sectionid;
        }
        else{
            $result['id']='';
            $result['name']='';
            $result['email']='';
            $result['number']='';
            $result['supid']='';
            $result['subjectid']='';
            $result['module']='';
            $result['classteacher']='';
            $result['classid']='';
            $result['sectionid']='';
        }
        $aid=session()->get('ADMIN_ID');    
        $result['class']=DB::table('categories')->where('aid',$aid)->get(); 
        $result['supervisors']=DB::table('supervisors')->where('aid',$aid)->get();
        return view("admin.addfaculty",$result);

    }
     
    public function savefaculty(Request $request){

        if($request->post('id')>0){
            $model=faculty::find($request->post('id'));
            $msg="Faculty updated";
            $oldemail=$model->femail;
            $oldnumber=$model->fnumber; 
        }
        else{
            $model=new faculty();
            $msg="Faculty inserted";
            $oldemail="";
            $oldnumber=""; 
        }

        if($oldemail!=$request->post('email')){
            $request->validate([
            'email'=>'required|unique:faculties,femail'  
            ]);
        }
        if($oldnumber!=$request->post('number')){
            $request->validate([
            'number'=>'required|unique:faculties,fnumber'   
            ]);
        }

        $permitted_chars = '0123456789';
        $password = substr(str_shuffle($permitted_chars), 0, 5);

        $model->aid=session()->get('ADMIN_ID');
        $model->fsupid=$request->post('supid');
        $g=DB::table('supervisors')->where('id',$request->post('supid'))->get('supsubjecttype');
        $model->fsubjecttype=$g[0]->supsubjecttype;
        $model->subjectid=implode("##",$request->post('subject'));
        $model->moduleid=implode("##",$request->post('module'));
        $model->fname=$request->post('name');
        $model->femail=$request->post('email');
        $model->fnumber=$request->post('number');
        $model->classteacher=$request->post('classteacher');
        if($request->post('classteacher')=="1"){
        $model->fportalid=3;
        }
        else{
        $model->fportalid=4;
        }
        $model->classid=$request->post('class');
        $model->sectionid=$request->post('section');
        if($oldemail!=$request->post('email')){
        $model->password=Hash::make($password);
        }
        $model->status=1;
        $model->save();
        
        if($oldemail!=$request->post('email')){
        $data=['name'=>$request->name,'email'=>$request->email,'number'=>$request->number,'password'=>$password];
        $user['to']=$request->email;
        Mail::send('mail.facultyregister',$data,function($messages) use ($user){
        $messages->to($user['to']);
        $messages->subject('Login Credentials Of Your Account');
        });
        }

        $request->session()->flash('message',$msg);
        return redirect('admin/faculty');
    }

    public function facultystatus(Request $request,$status,$id){
        $model=faculty::find($id);
        $model->status=$status;
        $model->save();
        $request->session()->flash('message','Faculty status changed');
        return redirect('admin/faculty');
    }


    public function facultydelete(Request $request, $id){
        $model=faculty::find($id);
        $model->delete();
        $request->session()->flash('message','Faculty Deleted');
        return redirect('admin/faculty');
    }

    public  function getsection(){
        $id = $_GET['myID'];
        $res = DB::table('lmssections')
        ->where('classid',$id)
        ->get();
        return Response::json($res);
    }


    public  function getmodules($id){
        $aid=session()->get('ADMIN_ID');   
        $id = $_GET['myID'];
        $res=DB::table('skillsets')->whereIn('domain',$id)->where('aid',$aid)->get();
        return Response::json($res);
    }

    public  function getsubjects($id){
        $aid=session()->get('ADMIN_ID');
        $id = $_GET['myID'];
        $a=DB::table('groups')->where('id',$id)->get();
        $res=[];
        if($a[0]->gtype==2){
        $res=DB::table('domains')->where('stype',2)->where('aid',$aid)->get();
        }else{
        $res=DB::table('domains')->where('stype',1)->where('groupid',$id)->where('aid',$aid)->get();
        }
        return Response::json($res);
    }

    public  function getsubjectsfromsupervisor($id){
        $id = $_GET['myID'];
        $res=DB::table('domains')->where('category',$id)->get();
        return Response::json($res);
    }
    public  function getmultiplesubjectsfromsupervisor($id){
        $id = $_GET['myID'];
       return $res=DB::table('domains')->whereIn('category',$id)->get();
        return Response::json($res);
    }

    public  function getsubjectsfaculty($id){
        $id = $_GET['myID'];
        $g=DB::table('supervisors')->where('id',$id)->get('groupid');
        $res=DB::table('domains')->where('groupid',$g[0]->groupid)->get();
        return Response::json($res);
    }

    public  function optionalornot($id){
        $id = $_GET['myID'];
        $g=DB::table('supervisors')->where('id',$id)->get('groupid');
        $res=DB::table('groups')->where('id',$g[0]->groupid)->get('gtype');

        if ($res[0]->gtype=="2") {
            return 2;
        } else {
            return 1; 
        }
    }
}