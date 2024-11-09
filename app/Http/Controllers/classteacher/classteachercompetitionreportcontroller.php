<?php

namespace App\Http\Controllers\classteacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\competition;
use App\Models\competitionbooking;
use Redirect,Response;

class classteachercompetitionreportcontroller extends Controller{

    public function competition(Request $request){
        $ctid=session()->get('CLASSTEACHER_ID');
        $classteacher=DB::table('faculties')->where('id',$ctid)->get();
        $result['competitions']=DB::table('competitions')->where('supid',$classteacher[0]->fsupid)->get();
        $result['competition']="";
        $result['appliedstudents']=[];
        $result['notshortlistedstudents']=[];
        $result['selectedstudents']=[];
        $result['completedstudents']=[];
        return view('classteacher.competitionreports',$result);
    }

    public function competitionreports(Request $request){
        $ctid=session()->get('CLASSTEACHER_ID');
        $classteacher=DB::table('faculties')->where('id',$ctid)->get();
        $result['competitions']=DB::table('competitions')->where('supid',$classteacher[0]->fsupid)->get();
        $result['competition']=$request->post('competition');
        $result['appliedstudents']=DB::table('competitionbookings')
                                ->join('competitions','competitions.id','competitionbookings.competitionid')
                                ->join('students','students.id','competitionbookings.sid')
                                ->where('competitions.id',$result['competition'])
                                ->where('competitionbookings.competitionstatus',1)
                                ->select('students.sname','students.slname','students.semail','students.snumber','competitions.competitionname','competitionbookings.*')
                                ->get();
        $result['notshortlistedstudents']=DB::table('competitionbookings')
                                ->join('competitions','competitions.id','competitionbookings.competitionid')
                                ->join('students','students.id','competitionbookings.sid')
                                ->where('competitions.id',$result['competition'])
                                ->where('competitionbookings.competitionstatus',2)
                                ->select('students.sname','students.slname','students.semail','students.snumber','competitions.competitionname','competitionbookings.*')
                                ->get();
        $result['selectedstudents']=DB::table('competitionbookings')
                                ->join('competitions','competitions.id','competitionbookings.competitionid')
                                ->join('students','students.id','competitionbookings.sid')
                                ->where('competitions.id',$result['competition'])
                                ->where('competitionbookings.competitionstatus',3)
                                ->select('students.sname','students.slname','students.semail','students.snumber','competitions.competitionname','competitionbookings.*')
                                ->get();
        $result['completedstudents']=DB::table('competitionbookings')
                                ->join('competitions','competitions.id','competitionbookings.competitionid')
                                ->join('students','students.id','competitionbookings.sid')
                                ->where('competitions.id',$result['competition'])
                                ->where('competitionbookings.competitionstatus',4)
                                ->select('students.sname','students.slname','students.semail','students.snumber','competitions.competitionname','competitionbookings.*')
                                ->get();
        return view('classteacher.competitionreports',$result);
    }

}