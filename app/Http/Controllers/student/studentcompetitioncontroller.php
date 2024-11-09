<?php

namespace App\Http\Controllers\student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\competitionbooking;
use Illuminate\Support\Facades\DB;

class studentcompetitioncontroller extends Controller {

    public function viewcompetition(request $request,$id){
        $sesid=session()->get('STUDENT_ID');

        $result['competitions']=DB::table('competitions')->where('id',$id)->where('status',1)->get();
        
        $result['competitionbooking']=DB::table('competitionbookings')->where('competitionid',$id)
                                    ->where('sid',$sesid)->get();

        return view('student.competitionpage',$result);
    }

    public function applycompetition(request $request,$id){   
        $competition=DB::table('competitions')->where('id',$id)->where('status',1)->get();

        $model=new competitionbooking();
        $model->aid=$competition[0]->aid;
        $model->supid=$competition[0]->supid;
        $model->mid=$competition[0]->mid;
        $model->sid=session()->get('STUDENT_ID');
        $model->classid=session()->get('STUDENT_CLASS_ID');
        $model->sectionid=session()->get('STUDENT_SECTION_ID');
        $model->competitionid=$competition[0]->id;
        $model->applydate=date('d-m-Y');
        $model->save();

        $request->session()->flash('success','Applied Successfully');
        return redirect('student/dashboard'); 
    }

    public function competitionstatus(request $request){
        $sesid=session()->get('STUDENT_ID');
        $result['bookedcompetitions']=DB::table('competitionbookings')
                                    ->join('competitions','competitionbookings.competitionid','competitions.id')
                                    ->where('competitionbookings.sid',$sesid)
                                    ->select('competitionbookings.*','competitions.competitionname')
                                    ->get();

        return view('student.competitionstatus',$result);
    }
   
}