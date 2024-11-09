<?php

namespace App\Http\Controllers\manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\competition;
use App\Models\competitionbooking;
use Redirect,Response;

class managercompetitionreportcontroller extends Controller{

    public function competition(Request $request){
        $mid=session()->get('MANAGER_ID');
        $manager=DB::table('managers')->where('id',$mid)->get();
        $result['competitions']=DB::table('competitions')->where('supid',$manager[0]->supid)->get();
        $result['competition']="";
        $result['appliedstudents']=[];
        $result['notshortlistedstudents']=[];
        $result['selectedstudents']=[];
        $result['completedstudents']=[];
        return view('manager.competitionreports',$result);
    }

    public function competitionreports(Request $request){
        $mid=session()->get('MANAGER_ID');
        $manager=DB::table('managers')->where('id',$mid)->get();
        $result['competitions']=DB::table('competitions')->where('supid',$manager[0]->supid)->get();
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
        return view('manager.competitionreports',$result);
    }

}