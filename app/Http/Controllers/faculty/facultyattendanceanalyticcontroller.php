<?php

namespace App\Http\Controllers\faculty;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\studentassignation;
use App\Models\studentbooking;
use App\Models\assesmentsections;
use App\Models\finalanswer;
use Redirect,Response;

class facultyattendanceanalyticcontroller extends Controller
{
    public function index(){
        $fid=session()->get('FACULTY_ID');
        $a=DB::table('periodtimetables')->where('tportalid','FACULTY')->where('tprofileid',$fid)
           ->distinct('tclassid')->get('tclassid');
        $b=[];
        for ($i=0; $i <count($a) ; $i++) {
            $b[$i]=$a[$i]->tclassid; 
        }
        if(count($a)>0){
            $result['class']= DB::table('categories')->whereIn('id',$b)->get();
        }
        else{
            $result['class']= [];
        }
        $result['cl']=0;
        $result['section']=0;
        $result['present']=0;
        $result['absent']=0;
        $result['day']=0;

        return view("faculty.attendenceanalytics",$result);
    }


    public function fetch(request $request){
        $fid=session()->get('FACULTY_ID');
        $a=DB::table('periodtimetables')->where('tportalid','FACULTY')->where('tprofileid',$fid)
           ->distinct('tclassid')->get('tclassid');
        $b=[];
        for ($i=0; $i <count($a) ; $i++) {
            $b[$i]=$a[$i]->tclassid; 
        }
        if(count($a)>0){
            $result['class']= DB::table('categories')->whereIn('id',$b)->get();
        }
        else{
            $result['class']= [];
        }
        $result['cl']=$request->class;
        $result['section']=$request->section;
        $result['present']=0;
        $result['absent']=0;
        $result['day']=0;

        $data=DB::table('attendances')->where('classid',$request->class)->where('sectionid',$request->section)->get(); 
           
        if(count($data)>0){
          $result['day']=count($data);
          for($i=0;$i<count($data);$i++){
            $a=explode("##",$data[$i]->attendance);
            for($k=0;$k<count($a);$k++){
                if($a[$k]=="Absent"){
                  $result['absent']++;
                }else{
                    $result['present']++;
                }
            }

          }
        }
        else{
            $result['present']=0;
            $result['absent']=0;
            $result['day']=0;
        }

        $result['months']=Array(
                            Array("id"=>"01","mon"=>"January"),Array("id"=>"02","mon"=>"February"),
                            Array("id"=>"03","mon"=>"March"),Array("id"=>"04","mon"=>"April"),
                            Array("id"=>"05","mon"=>"May"),Array("id"=>"06","mon"=>"June"),
                            Array("id"=>"07","mon"=>"July"),Array("id"=>"08","mon"=>"August"),
                            Array("id"=>"09","mon"=>"September"),Array("id"=>"10","mon"=>"October"),
                            Array("id"=>"11","mon"=>"November"),Array("id"=>"12","mon"=>"December")
                        );
     
     return view('faculty.attendenceanalytics',$result);
    }


    public function datewise(request $request){
      $month = $request->post('month');
      $class = $request->post('cl');
      $section = $request->post('section');

      $data=DB::table('attendances')->where('classid',$class)->where('sectionid',$section)->where('month',$month)->get();

        $result['data'][0]=0;
        $result['data'][1]=0;
           
        if(count($data)>0){  
        for($i=0;$i<count($data);$i++){
            $a=explode("##",$data[$i]->attendance);
            for($k=0;$k<count($a);$k++){
                if($a[$k]=="Absent"){
                  $result['data'][1]++;
                }else{
                    $result['data'][0]++;
                }
            }
          }
        }

        $result['data'][3]=count($data);
        
        return Response::json($result['data']);

    }
}
