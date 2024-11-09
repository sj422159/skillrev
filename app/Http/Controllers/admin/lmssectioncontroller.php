<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Validator;
use Illuminate\Http\Request;
use App\Imports\lattributeImport;
use App\Models\lmsclass;
use App\Models\lmssection;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Redirect,Response;

class lmssectioncontroller extends Controller
{

    public function section(){
        $aid=session()->get('ADMIN_ID');
        $result['groups']=DB::table('groups')->where('aid',$aid)->get(); 
        $result['section']=DB::table('lmssections')
                            ->join('groups','groups.id','lmssections.groupid')
                            ->join('categories','categories.id','lmssections.classid')
                            ->where('lmssections.aid',$aid)
                            ->select('lmssections.*','categories.categories','groups.group')->get();
        return view('admin.section',$result);
    }

    public function sectionsbyclass(Request $request){
        $aid=session()->get('ADMIN_ID');
        $classid = $request->post('classid');
        $result['groups']=DB::table('groups')->where('aid',$aid)->get(); 
        $result['section']=DB::table('lmssections')
                            ->join('groups','groups.id','lmssections.groupid')
                            ->join('categories','categories.id','lmssections.classid')
                            ->where('lmssections.aid',$aid)
                            ->where('lmssections.classid',$classid)
                            ->select('lmssections.*','categories.categories','groups.group')
                            ->get();
        return view('admin.section',$result);
    }

    public function addsection(Request $request,$id="")
    {
        $aid=session()->get('ADMIN_ID');
        $result['groups']=DB::table('groups')->where('aid',$aid)->get();   
        if($id>0){
            $arr=lmssection::where(['id'=>$id])->get();
            $result['id']=$arr['0']->id;
            $result['groupid']=$arr['0']->groupid;
            $result['classid']=$arr['0']->classid;
            $result['section']=$arr['0']->section;
        }
        else{
            $result['id']='';
            $result['groupid']='';
            $result['classid']='';
            $result['section']='';
        }
        return view("admin.addsection",$result);
    }
     
    public function savesection(Request $request){
        if($request->post('id')>0){
            $model=lmssection::find($request->post('id'));
            $msg="Section Updated";
        }
        else{
            $model=new lmssection();
            $msg="Section Inserted";
        }
        $model->aid=session()->get('ADMIN_ID');
        $model->groupid=$request->post('groupid');
        $model->classid=$request->post('classid');
        $model->section=$request->post('section');
        $model->save();
        $request->session()->flash('message',$msg);
        return redirect('admin/section');
    }
 
    public function sectiondelete(Request $request, $id)
    {
        $model=lmssection::find($id);
        $model->delete();
        $request->session()->flash('message','Option Deleted');
       return redirect('admin/section');
    }

    public  function getclass(request $request){
        $cid = $request->post('cid');
        $state = DB::table('categories')->where('groupid', $cid)->get();
        echo $html='<option value="">Select</option>';
        foreach($state as $list){
        echo  $html='<option value="'.$list->id.'">'.$list->categories.'</option>';
        }
    }

    public function getclasses($id){
        $id = $_GET['myID'];
        $res = DB::table('categories')
        ->where('groupid',$id)
        ->get();
        return Response::json($res);
    } 

 
}               