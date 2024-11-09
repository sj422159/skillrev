<?php

namespace App\Http\Controllers\supervisor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\attendance;
use Carbon\CarbonPeriod;
use Redirect,Response;

class supervisorattendancecontroller extends Controller{
    
    public function months(){
        $aid=session()->get('SUPERVISOR_ADMIN_ID');
        $groupid=session()->get('SUPERVISOR_GROUP_ID');
        $group= DB::table('groups')->where('id',$groupid)->get();
        if($group[0]->gtype==1){
            $result['classes']=DB::table('categories')->where('groupid',$groupid)->where('aid',$aid)->get();
        }else{
            $result['classes']=DB::table('categories')->where('aid',$aid)->get();
        }
        $result['class']="";
        $result['months'] = array("January","February","March","April","May","June","July","August","September","October","November","December"); 
        $result['month']="";
        $result['date']="";
        $result['year'] = date('Y');
        $result['currentmonth'] = date('m');
        $result['student']=[];
        $result['attendance']=[];
        $result['attendances']=[];
        $result['method']=0; //for get
        return view('supervisor.attendancemonths',$result);
    }

    public  function getsections(request $request){
        $classid = $request->post('classid');
        $state = DB::table('lmssections')->where('classid',$classid)->get();
        echo $html='<option value="">Select</option>';
        foreach($state as $list){
          echo  $html='<option value="'.$list->id.'">'.$list->section.'</option>';
        }
    }

    public function getsectionsbyid($id){
        $id = $_GET['myID'];
        $res = DB::table('lmssections')->where('classid',$id)->get();
        return Response::json($res);
    } 

    public  function getdates(request $request){
        $monthid = $request->post('monthid');
        $sectionid = $request->post('sectionid');
        $state = DB::table('attendances')
                ->where('month',$monthid)->where('sectionid',$sectionid)->where('year',date('Y'))->get();
        echo $html='<option value="">Select</option>';
        foreach($state as $list){
          echo  $html='<option value="'.$list->date.'">'.$list->date.'</option>';
        }
    } 
 

    public function students(request $request){
        $aid=session()->get('SUPERVISOR_ADMIN_ID');
        $groupid=session()->get('SUPERVISOR_GROUP_ID');
        $group= DB::table('groups')->where('id',$groupid)->get();
        if($group[0]->gtype==1){
            $result['classes']=DB::table('categories')->where('groupid',$groupid)->where('aid',$aid)->get();
        }else{
            $result['classes']=DB::table('categories')->where('aid',$aid)->get();
        }
        $result['class']=$request->post('class');
        $result['months'] = array("January","February","March","April","May","June","July","August","September","October","November","December"); 
        $result['month']=$request->post('month');
        $result['date']=$request->post('date');
        $result['year'] = date('Y');
        $result['currentmonth'] = date('m');


        $date=$request->post('date');
        $classid=$request->post('class');
        $section=$request->post('section');
        $result['attendances'] = DB::table('attendances')
                    ->where('date',$date)
                    ->where('classid',$classid)
                    ->where('sectionid',$section)
                    ->get(['studentid','attendancetype','attendance']);
         
        $a=explode("##",$result['attendances'][0]->studentid);
        $student = DB::table('students')->whereIn('id',$a)->get(['sname','slname']);
        
        $b=explode("##",$result['attendances'][0]->attendance);
        $result['student']=[];
        $result['attendance']=[];
        for($i=0;$i<count($student);$i++){
            $result['student'][$i]=$student[$i]->sname." ".$student[$i]->slname;
            if($result['attendances'][0]->attendancetype=="1"){
                $result['attendance'][$i]=$b[$i];
            }
            else{
                $result['attendance'][$i]=$b[0];
            }
        }
        $result['method']=1; //for post
        return view('supervisor.attendancemonths',$result);
    }  
}