<?php

namespace App\Http\Controllers\manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\studentassignation;
use App\Models\studentbooking;
use App\Models\assesmentsections;
use App\Models\finalanswer;
use Redirect,Response;

class managerassignmentscontroller extends Controller
{

    public function reports(){
        $mid=session()->get('MANAGER_ID');
        $d=DB::table('managers')->where("id",$mid)->get();
        $result['sec']=DB::table('lmssections')->where('classid',$d[0]->classid)->get();
        $result['train']=DB::table('trainings')->where('mid',$mid)->where('status',1)->get();
        $result['class']=DB::table('categories')->get();
        $result['cl']=$d[0]->classid;
        $result['section']=0;
        $result['tri']=0;
        $result['data']=[];
        return view('manager.viewassignments',$result);
    }

    public function fetchstu(request $request){
       $mid=session()->get('MANAGER_ADMIN_ID'); 
        $d=DB::table('managers')->where("id",$mid)->get();
        $result['sec']=DB::table('lmssections')->where('classid',$d[0]->classid)->get();
        $result['train']=DB::table('trainings')->where('mid',$mid)->where('status',1)->get();
        $result['class']=DB::table('categories')->get();
        $result['cl']=$d[0]->classid;
        $result['tri']=$request->post('training');
        $result['section']=$request->post('section');
        $result['data']=DB::table('studentassignmentbookings')
                        ->join('students','studentassignmentbookings.sid','students.id')
                        ->join('trainingtypes','studentassignmentbookings.trainingtype','trainingtypes.id')
                        ->join('trainings','studentassignmentbookings.trainingid','trainings.id')
                        ->join('lmssections','students.ssectionid','lmssections.id')
                        ->join('categories','students.sclassid','categories.id')
                        ->where('students.sclassid',$request->post('class'))
                        ->where('students.ssectionid',$request->post('section'))
                        ->where('studentassignmentbookings.trainingid',$request->post('training'))
                        ->select('studentassignmentbookings.*','students.sname','students.slname','trainingtypes.type','trainings.trainingname','students.image')
                        ->get();
        return view('manager.viewassignments',$result);
    }

    public function classby(){
       $id = $_GET['id'];
         $res = DB::table('lmssections')
        ->where('lmssections.classid', $id)
        ->get();
        return Response::json($res);
    }      
}