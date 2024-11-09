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

class facultyassignmentanalyticcontroller extends Controller
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
        $result['completed']=0;
        $result['notcompleted']=0;
        $result['data']=[];
        $result['train']=0;
        $result['Name']="";
        $result['assignment']=0;
       return view('faculty.assignmentanalytic',$result); 
    }

     public function gettrainings(){
         $aid=session()->get('FACULTY_ADMIN_ID');
         $cls = $_GET['id'];
         $sec=$_GET['sec'];
         $result=DB::table('studentassignations')
                ->join('trainings','studentassignations.trainingid','trainings.id')
                ->where('studentassignations.aid',$aid)->where('classid',$cls)
                ->where('sectionid',$sec)->select('trainings.*')->get();
          return Response::json($result);
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
        $result['cl']=$request->post('class');
        $result['train']=$request->post('training');
        $result['assignment']=0;
        $result['section']=$request->post('section');
        $result['data']=[];

        $data=DB::table('studentassignations')->where('classid',$request->post('class'))->where('sectionid',$request->post('section'))->where('trainingid',$request->post('training'))->get();
        if(count($data)>0){
           
        $data1=DB::table('studentassignments')->where('assignationid',$data[0]->id)->get();
        if(count($data1)>0){
        $result['assignment']=$data1[0]->id;
        $result['data']=DB::table('studentassignmentbookings')->where('assignmentid',$data1[0]->id)->get();
        $result['Name']=$data1[0]->assignmentname;
        $result['completed']=0;
        $result['notcompleted']=0;
        for($i=0;$i<count($result['data']);$i++){
            if($result['data'][$i]->status==4){
                $result['completed']++;
            }else{
                $result['notcompleted']++;
            }
         
        }
         
        }else{
            $result['data']=[];
            $result['completed']=0;
            $result['notcompleted']=0;
            $result['Name']="";
        }
       
        }



        $result['select']=Array(
                            Array("id"=>"01","data"=>"Not Completed"),Array("id"=>"02","data"=>"Completed"),
                          
                        );

          return view('faculty.assignmentanalytic',$result); 
    

    }

    public function notcompleted(){
         $assignment = $_GET['assignment'];
     

        $result['data'][0]=0;
        $result['data'][1]=0;
        $result['data'][2]=0;
        $result['data'][3]=0;

        $data=DB::table('studentassignmentbookings')->where('assignmentid',$assignment)->get();
         for($i=0;$i<count($data);$i++){
            if($data[$i]->status==1){
                $result['data'][0]++;
            }else if($data[$i]->status==1){
                $result['data'][1]++;
            }else if($data[$i]->status==3){
                 $result['data'][2]++;
            }else{
                $result['data'][3]++;
            }
            
        }   
      
       
        
        return Response::json($result['data']);
    }


    public function completed(){
                 $assignment = $_GET['assignment'];
     

        $result['data'][0]=0;
        $result['data'][1]=0;
        $result['data'][2]=0;
        $result['data'][3]=0;
        $result['data'][4]=0;

        $data=DB::table('studentassignmentbookings')->where('assignmentid',$assignment)->get();
         for($i=0;$i<count($data);$i++){
            if($data[$i]->result=="Outstanding"){
                $result['data'][0]++;
            }else if($data[$i]->result=="Excellent"){
                $result['data'][1]++;
            }else if($data[$i]->result=="Very Good"){
                 $result['data'][2]++;
             }else if($data[$i]->result=="Good"){
                  $result['data'][3]++;
            }else{
                $result['data'][4]++;
            }
            
        }   
      
       
        
        return Response::json($result['data']);
    }
}
