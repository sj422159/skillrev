<?php

namespace App\Http\Controllers\faculty;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\attendance;
use Carbon\CarbonPeriod;
use Redirect,Response;

class facultyattendancecontroller extends Controller{
    
    public function months(){
        $fid=session()->get('FACULTY_ID');
        $a=DB::table('periodtimetables')->where('tportalid','FACULTY')->where('tprofileid',$fid)
           ->distinct('tclassid')->get('tclassid');
        $b=[];
        for ($i=0; $i <count($a) ; $i++) {
            $b[$i]=$a[$i]->tclassid; 
        }
        if(count($a)>0){
            $result['classes']= DB::table('categories')->whereIn('id',$b)->get();
        }
        else{
            $result['classes']= [];
        }
        $result['class']="";
        $result['months'] = array("January","February","March","April","May","June","July","August","September","October","November","December"); 
        $result['month']="";
        $result['dates']="";
        $result['year'] = date('Y');
        $result['currentmonth'] = date('m');
        $result['student']=[];
        $result['attendance']=[];
        $result['attendances']=[];
        return view('faculty.attendancemonths',$result);
    }

    public  function getsections(request $request){
        $classid = $request->post('classid');
        $fid=session()->get('FACULTY_ID');
        $a=DB::table('periodtimetables')->where('tportalid','FACULTY')->where('tprofileid',$fid)
           ->where('tclassid',$classid)->distinct('tsectionid')->get('tsectionid');
        $b=[];
        for ($i=0; $i <count($a) ; $i++) {
            $b[$i]=$a[$i]->tsectionid; 
        }
        $state = DB::table('lmssections')->whereIn('id',$b)->get();
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
        $fid=session()->get('FACULTY_ID');
        $a=DB::table('periodtimetables')->where('tportalid','FACULTY')->where('tprofileid',$fid)
           ->distinct('tclassid')->get('tclassid');
        $b=[];
        for ($i=0; $i <count($a) ; $i++) {
            $b[$i]=$a[$i]->tclassid; 
        }
        if(count($a)>0){
            $result['classes']= DB::table('categories')->whereIn('id',$b)->get();
        }
        else{
            $result['classes']= [];
        }
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
        
        return view('faculty.attendancemonths',$result);
    }  
}