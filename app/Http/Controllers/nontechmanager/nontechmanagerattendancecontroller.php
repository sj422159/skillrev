<?php

namespace App\Http\Controllers\nontechmanager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\transportattendance;
use Carbon\CarbonPeriod;
use Redirect,Response;

class nontechmanagerattendancecontroller extends Controller{

    public function attendance(){
        $sesid=session()->get('NONTECH_MANAGER_ID');
        $aid=session()->get('NONTECH_MANAGER_ADMIN_ID');

        $result['todaydate'] = date('d-m-Y');

        $result['busroutes'] = DB::table('busroutes')->where('aid',$aid)->where('status',1)->get();

        for($i=0;$i<count($result['busroutes']);$i++){
            $a= DB::table('transportattendances')
                ->where('date',$result['todaydate'])
                ->where('busrouteid',$result['busroutes'][$i]->id)
                ->select('transportattendances.pickupstatus','transportattendances.dropstatus')
                ->get();
            if(count($a)>0){
              if($a[0]->pickupstatus=="1" && $a[0]->dropstatus=="0"){
                $result['busroutes'][$i]->pstatus=1;
                $result['busroutes'][$i]->dstatus=0;
              }
              else if($a[0]->pickupstatus=="1" && $a[0]->dropstatus=="1"){
                $result['busroutes'][$i]->pstatus=1;
                $result['busroutes'][$i]->dstatus=1;
              }
            }
            else{
                $result['busroutes'][$i]->pstatus=0;
                $result['busroutes'][$i]->dstatus=1;
            }
        }
        return view('nontechmanager.transport.attendancebusroutes',$result);
    }

    public function pickupstudents($busroute){
        $sesid=session()->get('NONTECH_MANAGER_ID');
        $aid=session()->get('NONTECH_MANAGER_ADMIN_ID');

        $result['students']=DB::table('students')
                        ->join('distances','students.sdistance','distances.id')
                        ->join('busroutes','distances.busrouteid','busroutes.id')
                        ->join('feepayments','feepayments.sid','students.id')
                        ->where('stransportservice','Yes')
                        ->where('busroutes.id',$busroute)
                        ->where('students.aid',$aid)
                        ->select('students.*','distances.location','busroutes.busroute')
                        ->get();
        $result['busroute']=$busroute;
        return view('nontechmanager.transport.attendancepickupstudents',$result);
    } 

    public function dropstudents($busroute){
        $sesid=session()->get('NONTECH_MANAGER_ID');
        $aid=session()->get('NONTECH_MANAGER_ADMIN_ID');

        $result['students']=DB::table('students')
                        ->join('distances','students.sdistance','distances.id')
                        ->join('busroutes','distances.busrouteid','busroutes.id')
                        ->join('feepayments','feepayments.sid','students.id')
                        ->where('stransportservice','Yes')
                        ->where('busroutes.id',$busroute)
                        ->where('students.aid',$aid)
                        ->select('students.*','distances.location','busroutes.busroute')
                        ->get();
        $result['busroute']=$busroute;
        return view('nontechmanager.transport.attendancedropstudents',$result);
    } 

    public function pickupsave(request $request){
        $sesid=session()->get('NONTECH_MANAGER_ID');
        $aid=session()->get('NONTECH_MANAGER_ADMIN_ID');
        
        $date=date('d-m-Y');
        $month=date('m');
        $year=date('Y');

        $data=DB::table('transportattendances')->where('busrouteid',$request->post('busroute'))
            ->where('date',$date)->where('pickupstatus',1)->get();
       
       if (count($data)==0) {
           $model=new transportattendance();
           $model->adminid=$aid;
           $model->nontechmanagerid=$sesid;
           $model->busrouteid=$request->post('busroute');
           $model->date=$date;
           $model->month=$month;
           $model->year=$year;
           $model->pickupdeparturetime=$request->post('pickupdeparturetime');
           $model->pickuparrivaltime=$request->post('pickuparrivaltime');
           $model->pickupdeparturereason=$request->post('pickupdeparturereason');
           $model->pickuparrivalreason=$request->post('pickuparrivalreason');
           $model->pickupstudentid=implode("##",$request->post('studentid'));
           $model->pickupattendance=implode("##",$request->post('attendance'));
           $model->pickupstatus=1;
           $model->save();

           session()->flash('success','Attendance Saved Successfully');
           return redirect('nontech/manager/attendance');
       } else {
           session()->flash('danger','Attendance Already Exists');
           return redirect('nontech/manager/attendance');
       }         
    } 

    public function dropsave(request $request){
        $sesid=session()->get('NONTECH_MANAGER_ID');
        $aid=session()->get('NONTECH_MANAGER_ADMIN_ID');
        
        $date=date('d-m-Y');
        $month=date('m');
        $year=date('Y');

        $data=DB::table('transportattendances')->where('busrouteid',$request->post('busroute'))
            ->where('date',$date)->where('dropstatus',1)->get();

        $dropid=DB::table('transportattendances')->where('busrouteid',$request->post('busroute'))
            ->where('date',$date)->get();
       
        if (count($data)==0 && count($dropid)>0) {
           $model=transportattendance::find($dropid[0]->id);
           $model->adminid=$aid;
           $model->nontechmanagerid=$sesid;
           $model->busrouteid=$request->post('busroute');
           $model->date=$date;
           $model->month=$month;
           $model->year=$year;
           $model->dropdeparturetime=$request->post('dropdeparturetime');
           $model->droparrivaltime=$request->post('droparrivaltime');
           $model->dropdeparturereason=$request->post('dropdeparturereason');
           $model->droparrivalreason=$request->post('droparrivalreason');
           $model->dropstudentid=implode("##",$request->post('studentid'));
           $model->dropattendance=implode("##",$request->post('attendance'));
           $model->dropstatus=1;
           $model->save();

           session()->flash('success','Attendance Saved Successfully');
           return redirect('nontech/manager/attendance');
       } else {
           session()->flash('danger','Attendance Already Exists');
           return redirect('nontech/manager/attendance');
       }         
    }


    public function months(){
        $sesid=session()->get('NONTECH_MANAGER_ID');
        $aid=session()->get('NONTECH_MANAGER_ADMIN_ID');
        $result['busroutes']=DB::table('busroutes')->where('aid',$aid)->where('status',1)->get();
        $result['busroute']="";
        $result['months'] = array("January","February","March","April","May","June","July","August","September","October","November","December"); 
        $result['month']="";
        $result['dates']="";
        $result['year'] = date('Y');
        $result['currentmonth'] = date('m');
        $result['student']=[];
        $result['attendance']=[];
        $result['attendances']=[];
        return view('nontechmanager.transport.attendancemonths',$result);
    }

    public function getdates(request $request){
        $monthid = $request->post('monthid');
        $busrouteid = $request->post('busrouteid');
        $state = DB::table('transportattendances')
                ->where('month',$monthid)
                ->where('busrouteid',$busrouteid)
                ->where('year',date('Y'))
                ->get();
        echo $html='<option value="">Select</option>';
        foreach($state as $list){
          echo  $html='<option value="'.$list->date.'">'.$list->date.'</option>';
        }
    } 
 

    public function students(request $request){
        $sesid=session()->get('NONTECH_MANAGER_ID');
        $aid=session()->get('NONTECH_MANAGER_ADMIN_ID');
        $result['busroutes']=DB::table('busroutes')->where('aid',$aid)->where('status',1)->get();
        $result['busroute']=$request->post('busroute');
        $result['months'] = array("January","February","March","April","May","June","July","August","September","October","November","December"); 
        $result['month']=$request->post('month');
        $result['dates']=$request->post('date');
        $result['year'] = date('Y');
        $result['currentmonth'] = date('m');

        
        $busroute = $request->post('busroute');
        $month = $request->post('month');
        $date=$request->post('date');

        $result['attendances'] = DB::table('transportattendances')
                                ->where('busrouteid',$busroute)
                                ->where('month',$month)
                                ->where('date',$date)
                                ->get(['pickupstudentid','pickupattendance','dropattendance','pickupdeparturereason','pickuparrivalreason','dropdeparturereason','droparrivalreason']);
         
        $a=explode("##",$result['attendances'][0]->pickupstudentid);
        $student = DB::table('students')->whereIn('id',$a)->get(['sname','slname']);
        
        $b=explode("##",$result['attendances'][0]->pickupattendance);
        $c=explode("##",$result['attendances'][0]->dropattendance);
        $result['student']=[];
        $result['pickupattendance']=[];
        $result['dropattendance']=[];
        for($i=0;$i<count($student);$i++){
            $result['student'][$i]=$student[$i]->sname." ".$student[$i]->slname;
            $result['pickupattendance'][$i]=$b[$i];
            $result['dropattendance'][$i]=$c[$i];
        }
        
        return view('nontechmanager.transport.attendancemonths',$result);
    } 
  
}