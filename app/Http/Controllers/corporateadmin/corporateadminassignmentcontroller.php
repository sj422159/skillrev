<?php

namespace App\Http\Controllers\corporateadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\admin;
use App\Models\homepageEvents;
use Illuminate\Support\Facades\DB;
use Redirect;
use Mail;
use Response;
use App\Models\contentskillattribute;

class corporateadminassignmentcontroller extends Controller
{
    public function index(){
    $result['schools']=DB::table('admins')->where('status',1)->get();
    $result['school']=0;
    $result['category']=[];
    return view('corporateadmin.assignment',$result);
    }
    public function fetch(request $request){
       $result['schools']=DB::table('admins')->where('status',1)->get();
       $result['school']=$request->post('school');
       $result['category']=DB::table('categories')->where('aid',$request->post('school'))->get();
     return view('corporateadmin.assignment',$result);
    }

     public  function getSection(request $request){
        $aid=$request->post('aid');
        $cid=$request->post('cid');
        $state=DB::table('lmssections')->where('classid',$cid)->get();

        echo $html='<option value="">Select </option>';
        foreach($state as $list){
        echo  $html='<option value="'.$list->id.'">'.$list->section.'</option>';
        }
    } 

     public  function getTraining(request $request){
        $aid=$request->post('aid');
        $cid=$request->post('sid');
        $state=DB::table('trainings')->where('category',$cid)->where('status',1)->get();

        echo $html='<option value="">Select </option>';
        foreach($state as $list){
        echo  $html='<option value="'.$list->id.'">'.$list->trainingname.'</option>';
        }
    } 

    public function getData(request $request){
      $train = $request->post('train');
      $clas=$request->post('clas');
      $sec=$request->post('sec');

       $result['data']=DB::table('studentassignmentbookings')
                        ->join('students','studentassignmentbookings.sid','students.id')
                        ->join('trainingtypes','studentassignmentbookings.trainingtype','trainingtypes.id')
                        ->join('trainings','studentassignmentbookings.trainingid','trainings.id')
                        ->join('lmssections','students.ssectionid','lmssections.id')
                        ->join('categories','students.sclassid','categories.id')
                        ->where('students.sclassid',$clas)
                        ->where('students.ssectionid',$sec)
                        ->where('studentassignmentbookings.trainingid',$train)
                        ->where('studentassignmentbookings.status',4)
                        ->select('studentassignmentbookings.*','students.sname','students.slname','trainingtypes.type','trainings.trainingname','students.image')
                        ->get();
        
        return Response::json($result['data']);

    }

}
