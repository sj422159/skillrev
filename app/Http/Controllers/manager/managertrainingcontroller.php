<?php

namespace App\Http\Controllers\manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\training;
use App\Models\studentassignation;
use Redirect,Response;

class managertrainingcontroller extends Controller
{

    public function trainingprogramassign(Request $request,$trainingprogramid){
        $mid=session()->get('MANAGER_ID');
        $result['trainingprogram']=DB::table('trainings')->where('id',$trainingprogramid)->get();
        $result['class']=DB::table('categories')
                        ->join('managers','managers.classid','categories.id')
                        ->where('managers.id',$mid)
                        ->select('categories.*')
                        ->get();
        $result['trainingprogramid']=$trainingprogramid;
        return view('manager.trainingprogramassign',$result);
    }

    public function trainingprogramassignsave(Request $request){
        $mid=session()->get('MANAGER_ID');
        $sections=DB::table('lmssections')->where('classid',$request->post('class'))->get();
        $sectionexist="No Students Exist In";
        $bo=false;
        if(count($sections)>0){

        for($k=0;$k<count($sections);$k++){
       
        $students=DB::table('students')->where('mid',$mid)
                           ->where('sclassid',$request->post('class'))
                           ->where('ssectionid',$sections[$k]->id)
                           ->where('status',1)->get();
        if(count($students)>0){
        $stid="";
        for ($i=0; $i<count($students); $i++) { 
            $stid=$stid."##".$students[$i]->id;
        }  
        $model=new studentassignation();
        $model->aid=session()->get('MANAGER_ADMIN_ID');
        $model->mid=session()->get('MANAGER_ID');
        $model->sid=$stid;
        $model->fid=$request->post('facultyid');
        $model->trainingtype=$request->post('trainingtypeid');
        $model->trainingid=$request->post('trainingprogramid');
        $model->classid=$request->post('class');
        $model->sectionid=$sections[$k]->id;
        $model->assigndate=date('d-m-Y');
        $model->status=1;
        $model->save();
       }else{

        $sectionexist=$sectionexist."[ SEC ".$sections[$k]->section." ] ";
        $bo=true;
       }
    } //end


        $m=training::find($request->post('trainingprogramid'));
        $m->assignedornot=1;
        $m->save();

        if($bo){
           $request->session()->flash('success',"Assigned Succesfully ,".$sectionexist);
        }else{
          
           $request->session()->flash('success',"Assigned Succesfully");
        }
        
        return redirect('manager/dashboard');

    }
      else{
        $request->session()->flash('danger',"No Sections Available");
        return redirect('manager/training/assign/'.$request->post('trainingprogramid'));
      } 

    }

    public  function getsection(){
        $id = $_GET['myID'];
        $res = DB::table('categories')
        ->join('lmssections','categories.id','lmssections.classid')
        ->where('categories.id',$id)
        ->get();
        return Response::json($res);
    }

    public function reports(){
        $mid=session()->get('MANAGER_ID');
        $d=DB::table('managers')->where("id",$mid)->get();
        $result['sec']=DB::table('lmssections')->where('classid',$d[0]->classid)->get();
        $result['train']=DB::table('trainings')->where('mid',$mid)->where('status',1)->get();
        $result['class']=DB::table('categories')->get();
        $result['cl']=$d[0]->classid;
        $result['tri']=0;
        $result['section']=0;
        $result['data']=[];
        return view('manager.reports',$result);
    }

    public function assignmentreport($id){
        $result['data']=DB::table('studentassignmentbookings')
                                ->join('trainings','studentassignmentbookings.trainingid','trainings.id')
                                 ->where('studentassignmentbookings.id',$id)->select('studentassignmentbookings.*','trainings.trainingname')->get();
        return view('manager.assignmentreportsection',$result);
    }

    public function fetchstu(request $request){
        $mid=session()->get('MANAGER_ID');
        $d=DB::table('managers')->where("id",$mid)->get();
        $result['sec']=DB::table('lmssections')->where('classid',$d[0]->classid)->get();
        $result['train']=DB::table('trainings')->where('mid',$mid)->where('status',1)->get();
        $result['tri']=$request->post('training');
        $result['section']=$request->post('section');
        $result['class']=DB::table('categories')->get();
        $result['cl']=$d[0]->classid;
        $result['data']=DB::table('studentbookings')
                           ->join('students','studentbookings.sid','students.id')
                           ->join('trainings','studentbookings.trainingid','trainings.id')
                           ->join('lmssections','students.ssectionid','lmssections.id')
                           ->where('students.ssectionid',$request->post('section'))
                           ->where('studentbookings.trainingid',$request->post('training'))
                           ->select('studentbookings.*','students.sname','students.slname','trainings.trainingname','lmssections.section','students.image')
                           ->get();
        return view('manager.reports',$result);
    }
}