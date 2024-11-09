<?php

namespace App\Http\Controllers\nontechgroupmanager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\attendance;
use Carbon\CarbonPeriod;
use Redirect,Response;

class nontechgroupmanagerattendancecontroller extends Controller{
    
    public function months(){
        $sesid=session()->get('NONTECH_GROUPMANAGER_ID');
        $aid=session()->get('NONTECH_GROUPMANAGER_ADMIN_ID');
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
        return view('nontechgroupmanager.transport.attendancemonths',$result);
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
        $sesid=session()->get('NONTECH_GROUPMANAGER_ID');
        $aid=session()->get('NONTECH_GROUPMANAGER_ADMIN_ID');
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
        
        return view('nontechgroupmanager.transport.attendancemonths',$result);
    } 
}