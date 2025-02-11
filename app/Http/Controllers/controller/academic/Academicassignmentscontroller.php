<?php

namespace App\Http\Controllers\controller\academic;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\studentassignation;
use App\Models\studentbooking;
use App\Models\assesmentsections;
use App\Models\finalanswer;
use App\Models\controllers;
use Redirect,Response;

class Academicassignmentscontroller extends Controller
{

     public function reports(){
        $aid=session()->get('Controller_ADMIN_ID'); 
        $Controller_ID=session()->get('Controller_ID');
        $result['train']=DB::table('trainings')->where('aid',$aid)->where('status',1)->get();
        $result['class']=DB::table('categories')->where('aid',$aid)->get();
        $result['cl']=0;
        $result['section']=0;
        $result['tri']=0;
        $result['data']=[];
        $controller = controllers::find($Controller_ID); 

        $result['layout'] = match ($controller->Controller_role_ID) {
            1 => 'controller/academ/layout',
            2 => 'controller/exam/elayout',
            3 => 'controller/account/Alayout',
            default => 'layouts/default',
        };
        return view('controller.academ.assignments',$result);
    }

    public function fetchstu(request $request){
        $aid=session()->get('Controller_ADMIN_ID');
        $Controller_ID=session()->get('Controller_ID');
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
         $controller = controllers::find($Controller_ID); 

        $result['layout'] = match ($controller->Controller_role_ID) {
            1 => 'controller/academ/layout',
            2 => 'controller/exam/elayout',
            3 => 'controller/account/Alayout',
            default => 'layouts/default',
        };
        return view('controller.academ.assignments',$result);
    }
    public function classby(){
        $id = $_GET['id'];
          $res = DB::table('lmssections')
         ->where('lmssections.classid', $id)
         ->get();
         return Response::json($res);
     }
    public function assignmentreport($id){
        $Controller_ID=session()->get('Controller_ID');
        $controller = controllers::find($Controller_ID); 

        $result['layout'] = match ($controller->Controller_role_ID) {
            1 => 'controller/academ/layout',
            2 => 'controller/exam/elayout',
            3 => 'controller/account/Alayout',
            default => 'layouts/default',
        };
        $result['data']=DB::table('studentassignmentbookings')
                                ->join('trainings','studentassignmentbookings.trainingid','trainings.id')
                                 ->where('studentassignmentbookings.id',$id)
                                 ->select('studentassignmentbookings.*','trainings.trainingname')->get();

        
        return view('controller.academ.assignmentreportsection',$result);
    }
}