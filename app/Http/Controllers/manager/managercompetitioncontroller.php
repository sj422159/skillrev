<?php

namespace App\Http\Controllers\manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\competition;
use App\Models\competitionbooking;
use Redirect,Response;

class managercompetitioncontroller extends Controller{

    public function competition(Request $request){
        $mid=session()->get('MANAGER_ID');
        $result['competition']=DB::table('competitions')->where('mid',$mid)->get();
        return view('manager.competition',$result);
    }

    public function viewstudents(Request $request,$id){
        $result['appliedstudents']=DB::table('competitionbookings')
                                ->join('competitions','competitions.id','competitionbookings.competitionid')
                                ->join('students','students.id','competitionbookings.sid')
                                ->where('competitions.id',$id)
                                ->where('competitionbookings.competitionstatus',1)
                                ->select('students.sname','students.slname','competitions.competitionname','competitionbookings.*')
                                ->get();
        $result['notshortlistedstudents']=DB::table('competitionbookings')
                                ->join('competitions','competitions.id','competitionbookings.competitionid')
                                ->join('students','students.id','competitionbookings.sid')
                                ->where('competitions.id',$id)
                                ->where('competitionbookings.competitionstatus',2)
                                ->select('students.sname','students.slname','competitions.competitionname','competitionbookings.*')
                                ->get();
        $result['selectedstudents']=DB::table('competitionbookings')
                                ->join('competitions','competitions.id','competitionbookings.competitionid')
                                ->join('students','students.id','competitionbookings.sid')
                                ->where('competitions.id',$id)
                                ->where('competitionbookings.competitionstatus',3)
                                ->select('students.sname','students.slname','competitions.competitionname','competitionbookings.*')
                                ->get();
        $result['completedstudents']=DB::table('competitionbookings')
                                ->join('competitions','competitions.id','competitionbookings.competitionid')
                                ->join('students','students.id','competitionbookings.sid')
                                ->where('competitions.id',$id)
                                ->where('competitionbookings.competitionstatus',4)
                                ->select('students.sname','students.slname','competitions.competitionname','competitionbookings.*')
                                ->get();
        return view('manager.competitionstudents',$result);
    }

    public function savestatus(Request $request){
        $model=competitionbooking::find($request->post('competitionbookingid'));
        $model->certificatepdf=$request->post('status');
        $model->remarks=$request->post('remarks');
        $model->save();

        $request->session()->flash('success','Status Changed Successfully');
        return redirect('manager/competition/view/students/'.$model->competitionid);
    }
}