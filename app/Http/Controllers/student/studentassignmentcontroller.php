<?php

namespace App\Http\Controllers\student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\studentassignmentbooking;
use Redirect,Response;

class studentassignmentcontroller extends Controller
{
    public function assigned(Request $request){
        $sid=session()->get('STUDENT_ID');
        $result['data']=DB::table('studentassignments')
                    ->join('studentassignmentbookings','studentassignmentbookings.assignmentid','studentassignments.id')
                    ->where('studentassignmentbookings.sid',$sid)
                    ->where('studentassignmentbookings.status',1)
                    ->select('studentassignments.assignmentname','studentassignmentbookings.*')
                    ->get();
        return view('student.assignmentassigned',$result);
    }

    public function viewdetails(Request $request,$id){
        $result['data']=DB::table('studentassignmentbookings')->where('id',$id)->get();
        return view('student.viewassignmentdetails',$result);
    }

    public function saveanswer(Request $request){
        $model=studentassignmentbooking::find($request->post('id'));
        if($request->hasfile('file')){  
            $file=$request->file('file');
            $ext=$file->extension();
            $file_name=time().'.'.$ext;
            $file->move(public_path().'/assignmentcontent/answer',$file_name);
            $model->answercontent=$file_name;
        }
        if($model->attempt=="1"){
        $model->status=2;
         }else{
           $model->status=3;
        }
        $model->save();

        $request->session()->flash('success',"Assignment Submitted Succesfully");
        return redirect('student/assignment/assigned');
    }

    public function viewassignedstudents(Request $request,$id){
        $result['data']=DB::table('studentassignmentbookings')
                        ->join('students','students.id','studentassignmentbookings.sid')
                        ->where('studentassignmentbookings.assignmentid',$id)
                        ->select('students.sname','students.snumber','students.semail','studentassignmentbookings.*')
                        ->get();
        $totalassigns=DB::table('studentassignmentbookings')->where('assignmentid',$id)->get();
        $submitassigns=DB::table('studentassignmentbookings')->where('assignmentid',$id)->where('status',2)->get();
        $result['remainingassigns']=count($totalassigns)-count($submitassigns);
        $result['assignmentid']=$id;
        return view('student.viewassignedstudents',$result);
    }

    public function submitassignment(Request $request){
        $model=studentassignment::find($request->post('assignmentid'));
        $model->status=2;
        $model->save();
        $request->session()->flash('success',"Assignment Submitted Succesfully");
        return redirect('student/assignment/assigned');
    }

    public function submitted(Request $request){
        $sid=session()->get('STUDENT_ID');
        $result['data']=DB::table('studentassignments')
                    ->join('studentassignmentbookings','studentassignmentbookings.assignmentid','studentassignments.id')
                    ->where('studentassignmentbookings.sid',$sid)
                    ->where('studentassignmentbookings.status',2)
                    ->select('studentassignments.assignmentname','studentassignmentbookings.*')
                    ->get();
        return view('student.assignmentsubmitted',$result);
    }

    public function corrected(Request $request){
        $sid=session()->get('STUDENT_ID');
        $result['data']=DB::table('studentassignments')
                    ->join('studentassignmentbookings','studentassignmentbookings.assignmentid','studentassignments.id')
                    ->where('studentassignmentbookings.sid',$sid)
                    ->where('studentassignmentbookings.status',3)
                    ->select('studentassignments.assignmentname','studentassignmentbookings.*')
                    ->get();
        return view('student.assignmentcorrected',$result);
    }

    public function viewcorrecteddetails(Request $request,$id){
        $result['data']=DB::table('studentassignmentbookings')->where('id',$id)->get();
        return view('student.viewassignmentcorrecteddetails',$result);
    }

    public function completed(Request $request){
        $sid=session()->get('STUDENT_ID');
        $result['data']=DB::table('studentassignments')
                    ->join('studentassignmentbookings','studentassignmentbookings.assignmentid','studentassignments.id')
                    ->where('studentassignmentbookings.sid',$sid)
                    ->where('studentassignmentbookings.status',4)
                    ->select('studentassignments.assignmentname','studentassignmentbookings.*')
                    ->get();
        return view('student.assignmentcompleted',$result);
    }
}