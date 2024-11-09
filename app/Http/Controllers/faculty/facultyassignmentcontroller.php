<?php

namespace App\Http\Controllers\faculty;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\studentassignation;
use App\Models\studentassignment;
use App\Models\studentassignmentbooking;
use App\Models\studentbooking;
use Redirect,Response;

class facultyassignmentcontroller extends Controller
{
    public function assigned(Request $request){
        $fid=session()->get('FACULTY_ID');
        $result['data']=DB::table('studentassignments')->where('fid',$fid)->where('status',1)->get();
        return view('faculty.assignmentassigned',$result);
    }

    public function addassign(Request $request){
        $fid=session()->get('FACULTY_ID');
        $aid=session()->get('FACULTY_ADMIN_ID');
        $result['classes']=DB::table('categories')->where('aid',$aid)->get();
        $result['trainings']=DB::table('trainings')->where('facultyid',$fid)->get();
        return view('faculty.addassignment',$result);
    }

    public function saveassign(Request $request){
        $model=new studentassignment();
        $model->assignationid=$request->post('assignationid');
        $model->aid=session()->get('FACULTY_ADMIN_ID');
        $model->fid=session()->get('FACULTY_ID');
        if($request->hasfile('file')){  
            $file=$request->file('file');
            $ext=$file->extension();
            $file_name=time().'.'.$ext;
            $file->move(public_path().'/assignmentcontent/question',$file_name);
            $model->assignmentcontent=$file_name;
        }
        $model->assignmentname=$request->post('assignmentname');
        $model->status=1;
        $model->save();

        $a=DB::table('studentbookings')->where('assignid',$request->post('assignationid'))->get();
        $b=count($a);

        for($i=0;$i<$b;$i++){
        $m=new studentassignmentbooking();
        $m->assignmentid=$model->id;
        $m->assignationid=$request->post('assignationid');
        $m->trainingtype=$a[$i]->trainingtype;
        $m->trainingid=$a[$i]->trainingid;
        $m->aid=session()->get('FACULTY_ADMIN_ID');
        $m->fid=session()->get('FACULTY_ID');
        $m->sbookingid=$a[$i]->id;
        $m->sid=$a[$i]->sid;
        $m->questioncontent=$model->assignmentcontent;
        $m->answercontent=0;
        $m->result=0;
        $m->status=1;
        $m->save();

        $a=studentbooking::find($a[$i]->id);
        $a->studentassignmentid=$model->id;
        $a->save();
        }

        $mo=studentassignation::find($request->post('assignationid'));
        $mo->assignmentassignedornot=1;    // 1 means assignment assigned
        $mo->save();
        $request->session()->flash('success',"Assignment Assigned Succesfully");
        return redirect('faculty/dashboard');
    }

    public function viewassignedstudents(Request $request,$id){
        $result['data']=DB::table('studentassignmentbookings')
                        ->join('students','students.id','studentassignmentbookings.sid')
                        ->where('studentassignmentbookings.assignmentid',$id)
                        ->select('students.sname','students.snumber','students.semail','studentassignmentbookings.*')
                        ->get();
        $result['assignmentid']=$id;
        return view('faculty.viewassignedstudents',$result);
    }

    public function movetosubmitassignment(Request $request){
        $model=studentassignment::find($request->post('assignmentid'));
        $model->status=2;
        $model->save();
        $request->session()->flash('success',"Moved To Assignment Submitted Succesfully");
        return redirect('faculty/assignment/assigned');
    }

    public function submitted(Request $request){
        $fid=session()->get('FACULTY_ID');
        $result['data']=DB::table('studentassignments')->where('fid',$fid)->where('status',2)->get();
        return view('faculty.assignmentsubmitted',$result);
    }

    public function viewsubmittedstudents(Request $request,$id){
        $result['data']=DB::table('studentassignmentbookings')
                        ->join('students','students.id','studentassignmentbookings.sid')
                        ->where('studentassignmentbookings.assignmentid',$id)
                        ->select('students.sname','students.snumber','students.semail','studentassignmentbookings.*')
                        ->get();
        $result['assignmentid']=$id;
        return view('faculty.viewsubmittedstudents',$result);
    }

    public function viewsubmitteddetails(Request $request,$id){
        $result['data']=DB::table('studentassignmentbookings')->where('id',$id)->get();
        return view('faculty.viewassignmentdetails',$result);
    }

    public function savesubmittedanswer(Request $request){
        $model=studentassignmentbooking::find($request->post('id'));
        if($request->hasfile('file')){  
            $file=$request->file('file');
            $ext=$file->extension();
            $file_name=time().'.'.$ext;
            $file->move(public_path().'/assignmentcontent/correctanswer',$file_name);
            $model->correctanswercontent=$file_name;
        }
        $model->status=3;
        $model->save();

        $request->session()->flash('success',"Assignment Evaluated Succesfully");
        return redirect('faculty/assignment/submitted/view/students/'.$model->assignmentid);
    }

    public function movetocorrectedassignment(Request $request){
        $model=studentassignment::find($request->post('assignmentid'));
        $model->status=3;
        $model->save();
        $request->session()->flash('success',"Moved To Assignment Corrected Succesfully");
        return redirect('faculty/assignment/submitted');
    }

    public function corrected(Request $request){
        $fid=session()->get('FACULTY_ID');
        $result['data']=DB::table('studentassignments')->where('fid',$fid)->where('status',3)->get();
        return view('faculty.assignmentcorrected',$result);
    }

    public function viewcorrectedstudents(Request $request,$id){
        $result['data']=DB::table('studentassignmentbookings')
                        ->join('students','students.id','studentassignmentbookings.sid')
                        ->where('studentassignmentbookings.assignmentid',$id)
                        ->select('students.sname','students.snumber','students.semail','studentassignmentbookings.*')
                        ->get();
        $result['assignmentid']=$id;
        return view('faculty.viewcorrectedstudents',$result);
    }

    public function viewcorrecteddetails(Request $request,$id){
        $result['data']=DB::table('studentassignmentbookings')->where('id',$id)->get();
        return view('faculty.viewassignmentcorrecteddetails',$result);
    }


    public function savecorrectedanswer(Request $request){
        $model=studentassignmentbooking::find($request->post('id'));
        if($request->post('reassign')=="1"){  
            $model->status=1;
            $model->reassignstatus=1;
            $model->attempt=(int)$model->attempt+1;
        }
        elseif($request->post('reassign')=="2"){
            $model->result=$request->post('remarks');
            $model->status=4;
        }
        $model->save();

        $request->session()->flash('success',"Assignment Changed Succesfully");
        return redirect('faculty/assignment/corrected/view/students/'.$model->assignmentid);
    }

    public function movetocompletedassignment(Request $request){
        $model=studentassignment::find($request->post('assignmentid'));
        $model->status=4;
        $model->save();
        $request->session()->flash('success',"Moved To Assignment Completed Succesfully");
        return redirect('faculty/assignment/corrected');
    }

    public function completed(Request $request){
        $fid=session()->get('FACULTY_ID');
        $result['data']=DB::table('studentassignments')->where('fid',$fid)->where('status',4)->get();
        return view('faculty.assignmentcompleted',$result);
    }

    public function viewcompletedstudents(Request $request,$id){
        $result['data']=DB::table('studentassignmentbookings')
                        ->join('students','students.id','studentassignmentbookings.sid')
                        ->where('studentassignmentbookings.assignmentid',$id)
                        ->select('students.sname','students.snumber','students.semail','studentassignmentbookings.*')
                        ->get();
        $result['assignmentid']=$id;
        return view('faculty.viewcompletedstudents',$result);
    }

    public  function getsection(){
        $id = $_GET['myID'];
        $res = DB::table('lmssections')->where('classid',$id)->get();
        return Response::json($res);
    }

    public  function gettraining(){
        $cl = $_GET['cl'];
        $sec = $_GET['sec'];
        $fid=session()->get('FACULTY_ID');
        $aid=session()->get('FACULTY_ADMIN_ID');
        $res=DB::table('studentassignations')
            ->join('trainings','trainings.id','studentassignations.trainingid')
            ->where('trainings.facultyid',$fid)
            ->where('studentassignations.fid',$fid)
            ->where('studentassignations.classid',$cl)
            ->where('studentassignations.sectionid',$sec)
            ->where('studentassignations.status',2)        // supervisor assignation part completed
            ->where('studentassignations.assignmentassignedornot',0)  // 0 means assignment not assigned
            ->select('trainings.trainingname','studentassignations.*')
            ->get();
        return Response::json($res);
    }
}