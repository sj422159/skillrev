<?php

namespace App\Http\Controllers\student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\attendance;
use Carbon\CarbonPeriod;
use Redirect,Response;

class studentattendancecontroller extends Controller{
    
    public function months(){
        $result['year'] = date('Y');
        $result['currentmonth'] = date('m');
        $result['month'] = array("January","February","March","April","May","June","July","August","September","October","November","December");

        $studentid=session()->get('STUDENT_ID');
        $d=DB::table('students')->where('id',$studentid)->get();
        $distanceid=$d[0]->sdistance;
        if ($distanceid=="0") {
            $result['transportattendance']=0;
        } else {
            $result['transportattendance']=1;
        } 
        return view('student.attendancemonths',$result);
    }

    public function dates($month){
        $studentid=session()->get('STUDENT_ID');
        $classid=session()->get('STUDENT_CLASS_ID');
        $sectionid=session()->get('STUDENT_SECTION_ID');
        $result['year'] = date('Y');
        $attendances = DB::table('attendances')
                    ->where('month',$month)
                    ->where('year',$result['year'])
                    ->where('classid',$classid)
                    ->where('sectionid',$sectionid)
                    ->get(['studentid','attendancetype','attendance','date']);
        
        $result['attendance']=[];
        $result['attendancetype']=[];
        $result['date']=[];

        for($i=0;$i<count($attendances);$i++){
            $a=explode("##",$attendances[$i]->studentid);
            $b=explode("##",$attendances[$i]->attendance);
            for($j=0;$j<count($attendances);$j++){
              if($a[$j]==$studentid){
                if($attendances[$i]->attendancetype=="1"){
                   $result['attendance'][$i]=$b[$j];
                   $result['attendancetype'][$i]=$attendances[$i]->attendancetype;
                   $result['date'][$i]=$attendances[$i]->date;
                }
                else{
                   $result['attendance'][$i]=$b[0];
                   $result['attendancetype'][$i]=$attendances[$i]->attendancetype;
                   $result['date'][$i]=$attendances[$i]->date;
                }
                break;
              }   
            }
        }
        return view('student.attendancedates',$result);
    }  


    public function busdates($month){
        $studentid=session()->get('STUDENT_ID');
        $result['year'] = date('Y');

        $attendances = DB::table('transportattendances')
                    ->where('month',$month)
                    ->where('year',$result['year'])
                    ->where('pickupstatus',1)
                    ->where('dropstatus',1)
                    ->get(['pickupstudentid','pickupattendance','dropstudentid','dropattendance','date']);
        
        $result['pickupattendance']=[];
        $result['date']=[];

        for($i=0;$i<count($attendances);$i++){

            $a=explode("##",$attendances[$i]->pickupstudentid);
            $b=explode("##",$attendances[$i]->pickupattendance);
            $c=explode("##",$attendances[$i]->dropattendance);

            for($j=0;$j<count($attendances);$j++){
                if($a[$j]==$studentid){
                   $result['pickupattendance'][$i]=$b[$j];
                   $result['dropattendance'][$i]=$c[$j];
                   $result['date'][$i]=$attendances[$i]->date;
                   
                   break;
                }   
            }
        }
        return view('student.attendancebusdates',$result);
    }  


    public function classtimeTable(){
        $studentid=session()->get('STUDENT_ID');
        $classid=session()->get('STUDENT_CLASS_ID');
        $sectionid=session()->get('STUDENT_SECTION_ID');
        $d=DB::table('students')->where('id',$studentid)->get();
        $optmod=explode("#*#",$d[0]->optmod);
        $result['class']=DB::table('categories')->where('id',$d[0]->sclassid)->get();
        $result['sec']=DB::table('lmssections')->where('classid',$d[0]->sclassid)->get();
        $result['cl']=$d[0]->sclassid;
        $result['section']=$d[0]->ssectionid; 
        $sub=DB::table('domains')->where('category',$d[0]->sclassid)->where('stype',1)->get();
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
                if(count($result['monday'.$i])>0){
                    $len=count($result['monday'.$i]);
                   for($k=0;$k<$len;$k++){
                        $a=$result['monday'.$i][$k]->tmoduleid;
                    if(in_array((string)$a,$optmod)){
                        //return $result['monday'.$i][$k];
                        $result['monday'.$i][0]=$result['monday'.$i][$k];
                        if($result['monday'.$i][$k]->roomtype=="ROOM"){
                           $r=DB::table('rooms')->where('id',$result['monday'.$i][$k]->roomno)->get();
                        $result['monday'.$i][0]->roomname="ROOM ".$r[0]->roomname;
                        }else{
                           $r=DB::table('lmssections')->where('id',$result['monday'.$i][$k]->roomno)->get();
                        $result['monday'.$i][0]->roomname="SEC ".$r[0]->section;
                        }
                        break;
                        
                      }else{
                          $r=DB::table('lmssections')->where('id',$d[0]->ssectionid)->get();
                         $result['monday'.$i][0]->roomname="SEC ".$r[0]->section;
                      }
                   }
                }
            }

           // return $result['monday'.$i];


           
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

                                      
                if(count($result['tuesday'.$i])>0){
                    $len=count($result['tuesday'.$i]);
                   for($k=0;$k<$len;$k++){
                        $a=$result['tuesday'.$i][$k]->tmoduleid;
                    if(in_array((string)$a,$optmod)){
                        //return $result['tuesday'.$i][$k];
                        $result['tuesday'.$i][0]=$result['tuesday'.$i][$k];
                        if($result['tuesday'.$i][$k]->roomtype=="ROOM"){
                           $r=DB::table('rooms')->where('id',$result['tuesday'.$i][$k]->roomno)->get();
                        $result['tuesday'.$i][0]->roomname="ROOM ".$r[0]->roomname;
                        }else{
                           $r=DB::table('lmssections')->where('id',$result['tuesday'.$i][$k]->roomno)->get();
                        $result['tuesday'.$i][0]->roomname="SEC ".$r[0]->section;
                        }
                        break;
                        
                      }else{
                          $r=DB::table('lmssections')->where('id',$d[0]->ssectionid)->get();
                         $result['tuesday'.$i][0]->roomname="SEC ".$r[0]->section;
                      }
                   }
                }
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

                             if(count($result['wednesday'.$i])>0){
                    $len=count($result['wednesday'.$i]);
                   for($k=0;$k<$len;$k++){
                        $a=$result['wednesday'.$i][$k]->tmoduleid;
                    if(in_array((string)$a,$optmod)){
                        //return $result['wednesday'.$i][$k];
                        $result['wednesday'.$i][0]=$result['wednesday'.$i][$k];
                        if($result['wednesday'.$i][$k]->roomtype=="ROOM"){
                           $r=DB::table('rooms')->where('id',$result['wednesday'.$i][$k]->roomno)->get();
                        $result['wednesday'.$i][0]->roomname="ROOM ".$r[0]->roomname;
                        }else{
                           $r=DB::table('lmssections')->where('id',$result['wednesday'.$i][$k]->roomno)->get();
                        $result['wednesday'.$i][0]->roomname="SEC ".$r[0]->section;
                        }
                        break;
                        
                      }else{
                          $r=DB::table('lmssections')->where('id',$d[0]->ssectionid)->get();
                         $result['wednesday'.$i][0]->roomname="SEC ".$r[0]->section;
                      }
                   }
                }
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

                              if(count($result['thursday'.$i])>0){
                    $len=count($result['thursday'.$i]);
                   for($k=0;$k<$len;$k++){
                        $a=$result['thursday'.$i][$k]->tmoduleid;
                    if(in_array((string)$a,$optmod)){
                        //return $result['thursday'.$i][$k];
                        $result['thursday'.$i][0]=$result['thursday'.$i][$k];
                        if($result['thursday'.$i][$k]->roomtype=="ROOM"){
                           $r=DB::table('rooms')->where('id',$result['thursday'.$i][$k]->roomno)->get();
                        $result['thursday'.$i][0]->roomname="ROOM ".$r[0]->roomname;
                        }else{
                           $r=DB::table('lmssections')->where('id',$result['thursday'.$i][$k]->roomno)->get();
                        $result['thursday'.$i][0]->roomname="SEC ".$r[0]->section;
                        }
                        break;
                        
                      }else{
                          $r=DB::table('lmssections')->where('id',$d[0]->ssectionid)->get();
                         $result['thursday'.$i][0]->roomname="SEC ".$r[0]->section;
                      }
                   }
                }
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

                               if(count($result['friday'.$i])>0){
                    $len=count($result['friday'.$i]);
                   for($k=0;$k<$len;$k++){
                        $a=$result['friday'.$i][$k]->tmoduleid;
                    if(in_array((string)$a,$optmod)){
                        //return $result['friday'.$i][$k];
                        $result['friday'.$i][0]=$result['friday'.$i][$k];
                        if($result['friday'.$i][$k]->roomtype=="ROOM"){
                           $r=DB::table('rooms')->where('id',$result['friday'.$i][$k]->roomno)->get();
                        $result['friday'.$i][0]->roomname="ROOM ".$r[0]->roomname;
                        }else{
                           $r=DB::table('lmssections')->where('id',$result['friday'.$i][$k]->roomno)->get();
                        $result['friday'.$i][0]->roomname="SEC ".$r[0]->section;
                        }
                        break;
                        
                      }else{
                          $r=DB::table('lmssections')->where('id',$d[0]->ssectionid)->get();
                         $result['friday'.$i][0]->roomname="SEC ".$r[0]->section;
                      }
                   }
                }
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

                             if(count($result['saturday'.$i])>0){
                    $len=count($result['saturday'.$i]);
                   for($k=0;$k<$len;$k++){
                        $a=$result['saturday'.$i][$k]->tmoduleid;
                    if(in_array((string)$a,$optmod)){
                        //return $result['saturday'.$i][$k];
                        $result['saturday'.$i][0]=$result['saturday'.$i][$k];
                        if($result['saturday'.$i][$k]->roomtype=="ROOM"){
                           $r=DB::table('rooms')->where('id',$result['saturday'.$i][$k]->roomno)->get();
                        $result['saturday'.$i][0]->roomname="ROOM ".$r[0]->roomname;
                        }else{
                           $r=DB::table('lmssections')->where('id',$result['saturday'.$i][$k]->roomno)->get();
                        $result['saturday'.$i][0]->roomname="SEC ".$r[0]->section;
                        }
                        break;
                        
                      }else{
                          $r=DB::table('lmssections')->where('id',$d[0]->ssectionid)->get();
                         $result['saturday'.$i][0]->roomname="SEC ".$r[0]->section;
                      }
                   }
                }
            }
        
        }
        
        return view('student.classtimetable',$result);
    }

    public function bustimeTable(){
        $studentid=session()->get('STUDENT_ID');
        $d=DB::table('students')->where('id',$studentid)->get();
        $distanceid=$d[0]->sdistance;
        if ($distanceid=="0") {
            $result['distance']=[];
        } else {
            $result['distance']=DB::table('distances')->where('id',$distanceid)->get();
        }
        return view('student.bustimetable',$result);
    }
}