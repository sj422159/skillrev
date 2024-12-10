<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\attendance;
use Carbon\CarbonPeriod;
use Redirect,Response;

class adminattendancecontroller extends Controller{
    
    public function months(){
        $adminid=session()->get('ADMIN_ID');
        $result['classes']= DB::table('categories')->where('aid',$adminid)->get();
        $result['class']="";
        $result['months'] = array("January","February","March","April","May","June","July","August","September","October","November","December"); 
        $result['month']="";
        $result['dates']="";
        $result['year'] = date('Y');
        $result['currentmonth'] = date('m');
        $result['student']=[];
        $result['attendance']=[];
        $result['attendances']=[];
        return view('admin.attendancemonths',$result);
    }

    public  function getsections(request $request){
        $classid = $request->post('classid');
        $state = DB::table('lmssections')->where('classid',$classid)->get();
        echo $html='<option value="">Select</option>';
        foreach($state as $list){
          echo  $html='<option value="'.$list->id.'">'.$list->section.'</option>';
        }
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
        $adminid=session()->get('ADMIN_ID');
        $result['classes']= DB::table('categories')->where('aid',$adminid)->get();
        $result['class']=$request->post('class');
        $result['months'] = array("January","February","March","April","May","June","July","August","September","October","November","December"); 
        $result['month']=$request->post('month');
        $result['dates']=$request->post('date');
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
        
        return view('admin.attendancemonths',$result);
    }  
}