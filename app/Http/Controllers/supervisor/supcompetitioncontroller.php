<?php

namespace App\Http\Controllers\supervisor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\competition;
use App\Models\competitionbooking;
use Redirect,Response;

class supcompetitioncontroller extends Controller{

    public function competition(Request $request){
        $supid=session()->get('SUPERVISOR_ID');
        $result['competition']=DB::table('competitions')->where('supid',$supid)->get();
        return view('supervisor.competition',$result);
    }

    public function addcompetition(Request $request,$id=""){    
        if($id>0){
            $arr=competition::where(['id'=>$id])->get();
            $result['id']=$arr['0']->id;
            $result['mid']=$arr['0']->mid;
            $result['fromdate']=date("Y-m-d",strtotime($arr['0']->fromdate));
            $result['todate']=date("Y-m-d",strtotime($arr['0']->todate));
            $result['competitionname']=$arr['0']->competitionname;
            $result['subtitle']=$arr['0']->subtitle;
            $result['description']=$arr['0']->description;
            $result['image']=$arr['0']->image;
        }
        else{
            $result['id']='';
            $result['mid']='';
            $result['fromdate']='';
            $result['todate']='';
            $result['competitionname']='';
            $result['subtitle']='';
            $result['description']='';
            $result['image']='';     
        }
        $supid=session()->get('SUPERVISOR_ID');
        $result['managers']=DB::table('managers')->where('supid',$supid)->get();
        return view("supervisor.addcompetition",$result);
    }
     
    public function savecompetition(Request $request){
        $fromdate = $request->post('fromdate');
        $newfromdate = date("d-m-Y", strtotime($fromdate));
        $todate = $request->post('todate');
        $newtodate = date("d-m-Y", strtotime($todate));

        if($request->post('id')>0){
            $model=competition::find($request->post('id'));
            $msg="Competition updated";
        }
        else{
            $model=new competition();
            $msg="Competition inserted";
        }
        if($request->hasfile('image')){  
            $image=$request->file('image');
            $ext=$image->extension();
            $image_name=time().'.'.$ext;
            $image->move(public_path().'/competitionimages',$image_name);
            $model->image=$image_name;
        }
        $model->aid=session()->get('SUPERVISOR_ADMIN_ID');
        $model->supid=session()->get('SUPERVISOR_ID');
        $model->mid=$request->post('mid');
        $model->fromdate=$newfromdate;
        $model->todate=$newtodate;
        $model->competitionname=$request->post('competitionname');
        $model->subtitle=$request->post('subtitle');
        $model->description=$request->post('description');
        $model->save();

        $request->session()->flash('message',$msg);
        return redirect('groupmanager/competition');
    }
  
    public function competitiondelete(Request $request,$id){
        $model=competition::find($id);
        $model->delete();

        $request->session()->flash('message','Competition Deleted');
        return redirect('groupmanager/competition');  
    }

    public function competitionstatus(Request $request,$status,$id){
        $model=competition::find($id);
        $model->status=$status;
        $model->save();

        $request->session()->flash('message','Competition Updated');
        return redirect('groupmanager/competition');
    }

    public function viewstudents(Request $request,$id){
        $result['appliedstudents']=DB::table('competitionbookings')
                                ->join('competitions','competitions.id','competitionbookings.competitionid')
                                ->join('students','students.id','competitionbookings.sid')
                                ->where('competitions.id',$id)
                                ->where('competitionbookings.competitionstatus',1)
                                ->select('students.sname','students.slname','students.semail','students.snumber','competitions.competitionname','competitionbookings.*')
                                ->get();
        $result['notshortlistedstudents']=DB::table('competitionbookings')
                                ->join('competitions','competitions.id','competitionbookings.competitionid')
                                ->join('students','students.id','competitionbookings.sid')
                                ->where('competitions.id',$id)
                                ->where('competitionbookings.competitionstatus',2)
                                ->select('students.sname','students.slname','students.semail','students.snumber','competitions.competitionname','competitionbookings.*')
                                ->get();
        $result['selectedstudents']=DB::table('competitionbookings')
                                ->join('competitions','competitions.id','competitionbookings.competitionid')
                                ->join('students','students.id','competitionbookings.sid')
                                ->where('competitions.id',$id)
                                ->where('competitionbookings.competitionstatus',3)
                                ->select('students.sname','students.slname','students.semail','students.snumber','competitions.competitionname','competitionbookings.*')
                                ->get();
        $result['completedstudents']=DB::table('competitionbookings')
                                ->join('competitions','competitions.id','competitionbookings.competitionid')
                                ->join('students','students.id','competitionbookings.sid')
                                ->where('competitions.id',$id)
                                ->where('competitionbookings.competitionstatus',4)
                                ->select('students.sname','students.slname','students.semail','students.snumber','competitions.competitionname','competitionbookings.*')
                                ->get();
        return view('supervisor.competitionstudents',$result);
    }

    public function changestatus(Request $request,$status,$id){
        $model=competitionbooking::find($id);
        $model->competitionstatus=$status;
        $model->save();

        $request->session()->flash('success','Student Status Changed Successfully');
        return redirect('groupmanager/competition/view/students/'.$model->competitionid);
    }

    public function savecertificate(Request $request){
        $model=competitionbooking::find($request->post('competitionbookingid'));
        if($request->hasfile('file')){  
            $image=$request->file('file');
            $ext=$image->extension();
            $image_name=time().'.'.$ext;
            $image->move(public_path().'/pdf/competition',$image_name);
            $model->certificatepdf=$image_name;
        }
        $model->competitionstatus=4;
        $model->save();

        $request->session()->flash('success','Certificate Uploaded Successfully');
        return redirect('groupmanager/competition/view/students/'.$model->competitionid);
    }
}