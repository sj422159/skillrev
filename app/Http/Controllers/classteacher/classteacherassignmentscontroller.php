<?php

namespace App\Http\Controllers\classteacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\studentassignation;
use App\Models\studentbooking;
use App\Models\assesmentsections;
use App\Models\finalanswer;
use Redirect,Response;

class classteacherassignmentscontroller extends Controller
{

    public function reports(){
        $sesid=session()->get('CLASSTEACHER_ID');
        $d=DB::table('faculties')->where("id",$sesid)->get();
        $result['cl']=$d[0]->classid;
        $result['section']=$d[0]->sectionid;
        $result['sec']=DB::table('lmssections')->get();
        $result['train']=DB::table('trainings')->where('aid',$d[0]->aid)->where('status',1)->get();
        $result['class']=DB::table('categories')->get();
        $result['tri']=0;
        $result['data']=[];
        return view('classteacher.viewassignments',$result);
    }

    public function fetchstu(request $request){
          $sesid=session()->get('CLASSTEACHER_ID');
       $d=DB::table('faculties')->where("id",$sesid)->get();
         $result['cl']=$d[0]->classid;
        $result['section']=$d[0]->sectionid;
         $result['sec']=DB::table('lmssections')->get();
        $result['train']=DB::table('trainings')->where('aid',$d[0]->aid)->where('status',1)->get();
        $result['class']=DB::table('categories')->get();
       $result['tri']=$request->post('training');
        $result['data']=DB::table('studentassignmentbookings')
                        ->join('students','studentassignmentbookings.sid','students.id')
                        ->join('trainingtypes','studentassignmentbookings.trainingtype','trainingtypes.id')
                        ->join('trainings','studentassignmentbookings.trainingid','trainings.id')
                        ->join('lmssections','students.ssectionid','lmssections.id')
                        ->join('categories','students.sclassid','categories.id')
                        ->where('students.sclassid',$result['cl'])
                        ->where('students.ssectionid',$result['section'])
                        ->where('studentassignmentbookings.trainingid',$request->post('training'))
                        ->select('studentassignmentbookings.*','students.sname','students.slname','trainingtypes.type','trainings.trainingname','students.image')
                        ->get();
        return view('classteacher.viewassignments',$result);
    }

    public function classby(){
       $id = $_GET['id'];
         $res = DB::table('lmssections')
        ->where('lmssections.classid', $id)
        ->get();
        return Response::json($res);
    }  






     public function gettimeTable(){
        
         $sesid=session()->get('CLASSTEACHER_ID');
        $d=DB::table('faculties')->where("id",$sesid)->get();
        
        $result['class']=DB::table('categories')->where('id',$d[0]->classid)->get();
        $result['sec']=DB::table('lmssections')->where('classid',$d[0]->classid)->get();
       $result['cl']=$d[0]->classid;
        $result['section']=$d[0]->sectionid;
        $classid=$result['cl'];
        $sectionid=$result['section'];
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
        
        return view('classteacher.timetable',$result);
    }      
}