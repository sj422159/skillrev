<?php

namespace App\Http\Controllers\student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\studentassignation;
use App\Models\studentbooking;
use App\Models\assesmentsections;
use App\Models\finalanswer;
use Redirect,Response;

class studentattendanceanalyticcontroller extends Controller
{
    public function index(request $request){
        $studentid=session()->get('STUDENT_ID');
        $classid=session()->get('STUDENT_CLASS_ID');
        $sectionid=session()->get('STUDENT_SECTION_ID');
        $attendances = DB::table('attendances')
                    ->where('classid',$classid)
                    ->where('sectionid',$sectionid)
                    ->where('attendancetype',1)
                    ->get(['studentid','attendancetype','attendance','date']);
        
        $result['present']=[];
        $result['absent']=[];
        $presentcount=0;
        $absentcount=0;

        for($i=0;$i<count($attendances);$i++){
            $a=explode("##",$attendances[$i]->studentid);
            $b=explode("##",$attendances[$i]->attendance);
            for($j=0;$i<count($attendances);$j++){
              if($a[$j]==$studentid){
                if($b[$j]=="Present"){
                   $presentcount++;
                }
                else if($b[$j]=="Absent"){
                   $absentcount++;
                }
                break;
              }   
            }
        }

        $result['present']=$presentcount;
        $result['absent']=$absentcount;

        $result['months']=array(
                        array("month"=>"April","val"=>"04"),array("month"=>"May","val"=>"05"),
                        array("month"=>"June","val"=>"06"),array("month"=>"July","val"=>"07"),
                        array("month"=>"August","val"=>"08"),array("month"=>"September","val"=>"09"),
                        array("month"=>"October","val"=>"10"),array("month"=>"November","val"=>"11"),
                        array("month"=>"December","val"=>"12"),array("month"=>"January","val"=>"01"),
                        array("month"=>"February","val"=>"02"),array("month"=>"March","val"=>"03")
                    );
      return view('student.attendanceanalytics',$result);   
    }

    public function getmonth(){
        $month=$_GET['val'];

        $studentid=session()->get('STUDENT_ID');
        $classid=session()->get('STUDENT_CLASS_ID');
        $sectionid=session()->get('STUDENT_SECTION_ID');
        $attendances = DB::table('attendances')
                    ->where('month',$month)
                    ->where('classid',$classid)
                    ->where('sectionid',$sectionid)
                    ->where('attendancetype',1)
                    ->get(['studentid','attendancetype','attendance','date']);
        
        $result['present']=[];
        $result['absent']=[];
        $presentcount=0;
        $absentcount=0;

        for($i=0;$i<count($attendances);$i++){
            $a=explode("##",$attendances[$i]->studentid);
            $b=explode("##",$attendances[$i]->attendance);
            for($j=0;$i<count($attendances);$j++){
              if($a[$j]==$studentid){
                if($b[$j]=="Present"){
                   $presentcount++;
                }
                else if($b[$j]=="Absent"){
                   $absentcount++;
                }
                break;
              }   
            }
        }
        $result[0]=$presentcount;
        $result[1]=$absentcount;

        return Response::json($result);
    }

}