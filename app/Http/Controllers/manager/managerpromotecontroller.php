<?php

namespace App\Http\Controllers\manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\student;
use App\Models\category;
use Carbon\CarbonPeriod;
use Redirect,Response;

class managerpromotecontroller extends Controller{
    
    public function classstudents(){
        $aid=session()->get('MANAGER_ADMIN_ID');
        $classid=session()->get('MANAGER_CLASS_ID');

        $result['classes']= DB::table('categories')->where('aid',$aid)->get();
        $result['sections']= DB::table('lmssections')->where('classid',$classid)->get();
        $result['sec']="";
        $result['students']=[];
        $result['type']="";
        return view('manager.promoteclassstudents',$result);
    }

    public function classstudentsbysection(request $request){
        $aid=session()->get('MANAGER_ADMIN_ID');
        $mclassid=session()->get('MANAGER_CLASS_ID');
        $result['sections']= DB::table('lmssections')->where('classid',$mclassid)->get();
        $result['sec']=$request->post('section');
        $result['students']= DB::table('students')
                           ->where('sclassid',$mclassid)
                           ->where('ssectionid',$request->post('section'))
                           ->get();

        $class= DB::table('categories')->where('aid',$aid)->get(['id','categories','standardid']);
        $classid=[];
        for($i=0;$i<count($class);$i++){
            $classid[$i]=$class[$i]->id;
        }
        sort($classid);
        $classidcount=count($classid);

        $currentpos = array_search($mclassid,$classid);
        
        $item=$classid[$classidcount-1];
        if($item==$mclassid){
            $result['classes']= [];
            $result['nextsections']= [];
            $result['type']=2;  // 2 means transfer
        }
        else{
            $categoryid = $classid[$currentpos+1];
            $result['classes']= DB::table('categories')->where('id',$categoryid)->where('aid',$aid)->get();
            $result['nextsections']= DB::table('lmssections')->where('classid',$categoryid)->get();
            $result['type']=1;  // 1 means promote
        }
        return view('manager.promoteclassstudents',$result);
    }  

    public function classpromoteortransfer(request $request){
        $studentid=$request->post('studentid');
        $classid=$request->post('classid');
        $sectionid=$request->post('sectionid');

        if($request->post('type')==1){
          $model=student::find($studentid);
          $model->sclassid=$classid;
          $model->ssectionid=$sectionid;
          $model->save();
          $request->session()->flash('success','Student Promoted Successfully');
        }
        elseif($request->post('type')==2){
          $model=student::find($studentid);
          $model->delete();
          $request->session()->flash('success','Student Transferred Successfully');
        }
        
      
        $mclassid=session()->get('MANAGER_CLASS_ID');
        $students= DB::table('students')->where('sclassid',$mclassid)->get();

        if(count($students)==0){
            $m=category::find($mclassid);
            $m->promotestatus=1;
            $m->save();
        }
        
        $maid=session()->get('MANAGER_ADMIN_ID');

        DB::table('attendances')->where('classid',$classid)->where('sectionid',$sectionid)->delete();
        DB::table('finalanswers')->where('stid',$studentid)->delete();
        DB::table('studentassignations')->where('sid',$studentid)->delete();
        DB::table('studentassignmentbookings')->where('sid',$studentid)->delete();
        DB::table('studentassignments')->where('aid',$maid)->delete();
        DB::table('studentbookings')->where('sid',$studentid)->delete();
        DB::table('stureports')->where('stid',$studentid)->delete();

        return redirect('manager/promote/class/students');
    }  
    






    public function sectionstudents(){
        $aid=session()->get('MANAGER_ADMIN_ID');
        $classid=session()->get('MANAGER_CLASS_ID');

        $result['sections']= DB::table('lmssections')->where('classid',$classid)->get();
        $result['sec']="";
        $result['students']=[];
        return view('manager.promotesectionstudents',$result);
    }

    public function sectionstudentsbysection(request $request){
        $aid=session()->get('MANAGER_ADMIN_ID');
        $classid=session()->get('MANAGER_CLASS_ID');

        $result['sections']= DB::table('lmssections')->where('classid',$classid)->get();
        $result['sec']=$request->post('section');
        $result['students']= DB::table('students')
                           ->where('sclassid',$classid)
                           ->where('ssectionid',$request->post('section'))
                           ->get();
        return view('manager.promotesectionstudents',$result);
    }  

    public function sectiontransfer(request $request){
        $model=student::find($request->post('studentid'));
        $model->ssectionid=$request->post('sectionid');
        $model->save();
        $request->session()->flash('success','Section Changed Successfully');
        return redirect('manager/promote/section/students');
    }  
}