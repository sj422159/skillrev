<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\studentassignation;
use App\Models\studentbooking;
use App\Models\assesmentsections;
use App\Models\finalanswer;
use Redirect,Response;

class lmsassignmentscontroller extends Controller
{

     public function reports(){
        $aid=session()->get('ADMIN_ID'); 
        $result['train']=DB::table('trainings')->where('aid',$aid)->where('status',1)->get();
        $result['class']=DB::table('categories')->where('aid',$aid)->get();
        $result['cl']=0;
        $result['section']=0;
        $result['tri']=0;
        $result['data']=[];
        return view('admin.assignments',$result);
    }

    public function fetchstu(request $request){
        $aid=session()->get('ADMIN_ID');
        $result['train']=DB::table('trainings')->where('aid',$aid)->where('status',1)->get();
        $result['class']=DB::table('categories')->where('aid',$aid)->get(); 
        $result['cl']=$request->post('class');
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
        return view('admin.assignments',$result);
    }      
}