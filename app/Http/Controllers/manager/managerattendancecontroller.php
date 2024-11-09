<?php

namespace App\Http\Controllers\manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\attendance;
use Carbon\CarbonPeriod;
use Redirect,Response;

class managerattendancecontroller extends Controller{
    
    public function months(){
        $classid=session()->get('MANAGER_CLASS_ID');
        $result['sections']= DB::table('lmssections')->where('classid',$classid)->get();
        $result['sec']="";
        $result['months'] = array("January","February","March","April","May","June","July","August","September","October","November","December"); 
        $result['month']="";
        $result['dates']="";
        $result['year'] = date('Y');
        $result['currentmonth'] = date('m');
        $result['student']=[];
        $result['attendance']=[];
        $result['attendances']=[];
        return view('manager.attendancemonths',$result);
    }

    public  function getdates(request $request){
        $monthid = $request->post('monthid');
        $sectionid = $request->post('sectionid');
        $state = DB::table('attendances')
                ->where('month',$monthid)->where('sectionid',$sectionid)->where('year',date('Y'))->get();
        echo $html='<option value="">Select</option>';
        foreach($state as $list){
          echo  $html='<option value="'.$list->date.'">'.$list->date.'</option>';
        }
    } 
 

    public function students(request $request){
        $classid=session()->get('MANAGER_CLASS_ID');
        $result['sections']= DB::table('lmssections')->where('classid',$classid)->get();
        $result['sec']=$request->post('section');
        $result['months'] = array("January","February","March","April","May","June","July","August","September","October","November","December"); 
        $result['month']=$request->post('month');
        $result['dates']=$request->post('date');
        $result['year'] = date('Y');
        $result['currentmonth'] = date('m');


        $date=$request->post('date');
        $section=$request->post('section');
        $result['attendances'] = DB::table('attendances')
                    ->where('date',$date)
                    ->where('classid',$classid)
                    ->where('sectionid',$section)
                    ->get(['studentid','attendancetype','attendance']);
         
        $a=explode("##",$result['attendances'][0]->studentid);
        $student = DB::table('students')->whereIn('id',$a)->get(['sname','slname']);
        
        $b=explode("##",$result['attendances'][0]->attendance);
        $result['student']=[];
        $result['attendance']=[];
        for($i=0;$i<count($student);$i++){
            $result['student'][$i]=$student[$i]->sname." ".$student[$i]->slname;
            if($result['attendances'][0]->attendancetype=="1"){
                $result['attendance'][$i]=$b[$i];
            }
            else{
                $result['attendance'][$i]=$b[0];
            }
        }
        
        return view('manager.attendancemonths',$result);
    } 


    public function timetable(){
         $mid=session()->get('MANAGER_ID');
        $classid=session()->get('MANAGER_CLASS_ID');
        $sectionid=0;
         $d=DB::table('managers')->where("id",$mid)->get();
         $sup=session()->get('MANAGER_GROUPMANAGER_ID');
         $grp=DB::table('supervisors')->where('id',$sup)->get();
        $result['class']=DB::table('categories')->where('groupid',$grp[0]->groupid)->get();
          $result['sec']=DB::table('lmssections')->where('classid',$d[0]->classid)->get();
        $result['cl']=0;
        $result['section']=0; 
         $result['date']=date('d-m-Y');
        $timestamp = strtotime($result['date']);
        $result['day'] = date('l', $timestamp);
        for($i=1;$i<=8;$i++){ 
           $result['monday'.$i]=[];
           $result['tuesday'.$i]=[];
           $result['wednesday'.$i]=[];
           $result['thursday'.$i]=[];
           $result['friday'.$i]=[];
           $result['saturday'.$i]=[];
        }

        return view('manager.timetable',$result);
    } 



     public function gettimeTable(request $request){
         $mid=session()->get('MANAGER_ID');
          $classid=$request->class;
        $sectionid=$request->post('section');
         $d=DB::table('managers')->where("id",$mid)->get();
       $sup=session()->get('MANAGER_GROUPMANAGER_ID');
         $grp=DB::table('supervisors')->where('id',$sup)->get();
        $result['class']=DB::table('categories')->where('groupid',$grp[0]->groupid)->get();
       
        $result['cl']=$request->class;
        $result['section']=$request->post('sec'); 
        $sub=DB::table('domains')->where('category',$d[0]->classid)->where('stype',1)->get();
        $result['date']=date('d-m-Y');
        $timestamp = strtotime($result['date']);
        $result['day'] = date('l', $timestamp);

        $startDate =strtotime("this week");
        $endDate =strtotime("Sunday");
        $dates = [];     

        for ($currentDate = $startDate; $currentDate <= $endDate; $currentDate += (86400)) {
            $date = date('d-m-Y', $currentDate);
            $dates[] = $date;
        }
    
     
    

        for($i=1;$i<=8;$i++){ 

            
            $monday=DB::table('rescheduletimetables')
                ->where('tdateid',$dates[0])
                ->where('tclassid',$classid)
                ->join('domains','rescheduletimetables.tsubjectid','domains.id')
                ->where('tperiodid',$i)
                ->where(function($query) use ($sectionid){
                                $query->where('tsectionid',$sectionid);
                                $query->orWhere('tsectionid',0);
                            })->orderBy('tperiodid')->select('rescheduletimetables.*','domains.dname')->get();
            if(count($monday)>0){
                $result['monday'.$i]=$monday;

            }else{
                 $result['monday'.$i]=DB::table('periodtimetables')
                            ->join('domains','periodtimetables.tsubjectid','domains.id')
                            ->where('tclassid',$classid)
                            ->where('tdayid','Monday')
                            ->where('tperiodid',$i)
                            ->where(function($query) use ($sectionid){
                                $query->where('tsectionid',$sectionid);
                                $query->orWhere('tsectionid',0);
                            })
                            ->orderBy('tperiodid')->select('periodtimetables.*','domains.dname')->get();
            }


           
            $tuesday=DB::table('rescheduletimetables')
                ->where('tdateid',$dates[1])
                ->where('tclassid',$classid)
                ->join('domains','rescheduletimetables.tsubjectid','domains.id')
                ->where('tperiodid',$i)
                ->where(function($query) use ($sectionid){
                                $query->where('tsectionid',$sectionid);
                                $query->orWhere('tsectionid',0);
                            })->orderBy('tperiodid')->select('rescheduletimetables.*','domains.dname')->get();
            if(count($tuesday)>0){
                $result['tuesday'.$i]=$tuesday;

            }else{
            $result['tuesday'.$i]=DB::table('periodtimetables')
                            ->join('domains','periodtimetables.tsubjectid','domains.id')
                            ->where('tclassid',$classid)
                            ->where('tdayid','Tuesday')
                            ->where('tperiodid',$i)
                            ->where(function($query) use ($sectionid){
                                $query->where('tsectionid',$sectionid);
                                $query->orWhere('tsectionid',0);
                            })
                            ->orderBy('tperiodid')->select('periodtimetables.*','domains.dname')->get();
            }
            

            $wednesday=DB::table('rescheduletimetables')
                ->where('tdateid',$dates[2])
                ->where('tclassid',$classid)
                ->join('domains','rescheduletimetables.tsubjectid','domains.id')
                ->where('tperiodid',$i)
                ->where(function($query) use ($sectionid){
                                $query->where('tsectionid',$sectionid);
                                $query->orWhere('tsectionid',0);
                            })->orderBy('tperiodid')->select('rescheduletimetables.*','domains.dname')->get();
            if(count($wednesday)>0){
                $result['wednesday'.$i]=$wednesday;

            }else{
            $result['wednesday'.$i]=DB::table('periodtimetables')
                            ->join('domains','periodtimetables.tsubjectid','domains.id')
                            ->where('tclassid',$classid)
                            ->where('tdayid','Wednesday')
                            ->where('tperiodid',$i)
                            ->where(function($query) use ($sectionid){
                                $query->where('tsectionid',$sectionid);
                                $query->orWhere('tsectionid',0);
                            })
                            ->orderBy('tperiodid')->select('periodtimetables.*','domains.dname')->get();
            }
            

            $thursday=DB::table('rescheduletimetables')
                ->where('tdateid',$dates[3])
                ->where('tclassid',$classid)
                ->join('domains','rescheduletimetables.tsubjectid','domains.id')
                ->where('tperiodid',$i)
                ->where(function($query) use ($sectionid){
                                $query->where('tsectionid',$sectionid);
                                $query->orWhere('tsectionid',0);
                            })->orderBy('tperiodid')->select('rescheduletimetables.*','domains.dname')->get();
            if(count($thursday)>0){
                $result['thursday'.$i]=$thursday;

            }else{
            $result['thursday'.$i]=DB::table('periodtimetables')
                            ->join('domains','periodtimetables.tsubjectid','domains.id')
                            ->where('tclassid',$classid)
                            ->where('tdayid','Thursday')
                            ->where('tperiodid',$i)
                            ->where(function($query) use ($sectionid){
                                $query->where('tsectionid',$sectionid);
                                $query->orWhere('tsectionid',0);
                            })
                            ->orderBy('tperiodid')->select('periodtimetables.*','domains.dname')->get();
            }

            
            $friday=DB::table('rescheduletimetables')
                ->where('tdateid',$dates[4])
                ->where('tclassid',$classid)
                ->join('domains','rescheduletimetables.tsubjectid','domains.id')
                ->where('tperiodid',$i)
                ->where(function($query) use ($sectionid){
                                $query->where('tsectionid',$sectionid);
                                $query->orWhere('tsectionid',0);
                            })->orderBy('tperiodid')->select('rescheduletimetables.*','domains.dname')->get();
            if(count($friday)>0){
                $result['friday'.$i]=$friday;

            }else{
            $result['friday'.$i]=DB::table('periodtimetables')
                            ->join('domains','periodtimetables.tsubjectid','domains.id')
                            ->where('tclassid',$classid)
                            ->where('tdayid','Friday')
                            ->where('tperiodid',$i)
                            ->where(function($query) use ($sectionid){
                                $query->where('tsectionid',$sectionid);
                                $query->orWhere('tsectionid',0);
                            })
                            ->orderBy('tperiodid')->select('periodtimetables.*','domains.dname')->get();
            }

            
            $saturday=DB::table('rescheduletimetables')
                ->where('tdateid',$dates[5])
                ->where('tclassid',$classid)
                ->join('domains','rescheduletimetables.tsubjectid','domains.id')
                ->where('tperiodid',$i)
                ->where(function($query) use ($sectionid){
                                $query->where('tsectionid',$sectionid);
                                $query->orWhere('tsectionid',0);
                            })->orderBy('tperiodid')->select('rescheduletimetables.*','domains.dname')->get();
            if(count($saturday)>0){
                $result['saturday'.$i]=$saturday;

            }else{
            $result['saturday'.$i]=DB::table('periodtimetables')
                            ->join('domains','periodtimetables.tsubjectid','domains.id')
                            ->where('tclassid',$classid)
                            ->where('tdayid','Saturday')
                            ->where('tperiodid',$i)
                            ->where(function($query) use ($sectionid){
                                $query->where('tsectionid',$sectionid);
                                $query->orWhere('tsectionid',0);
                            })
                            ->orderBy('tperiodid')->select('periodtimetables.*','domains.dname')->get();
            }
        
        }
        
        return view('manager.timetable',$result);
    }
}