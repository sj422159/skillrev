<?php

namespace App\Http\Controllers\student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Redirect,Response;
use Illuminate\Support\Facades\Session;
use App\Models\answer;
use App\Models\finalanswer;
use App\Models\assesmentbooking;
use App\Models\assesments;
use App\Models\assesmentsections;
use App\Models\stureports;
use App\Models\studentassignation;
use App\Models\studentbooking;


class studentlifecontroller extends Controller
{
     public function assindex($id){

        $sesid=session()->get('STUDENT_ID');
         $result['data']=DB::table('studentassignations')
                                    ->join('managers','studentassignations.mid','managers.id')
                                    ->join('studentbookings','studentbookings.assignid','studentassignations.id')
                                    ->join('trainings','studentassignations.trainingid','trainings.id')
                                    ->join('lmssections','studentassignations.sectionid','lmssections.id')
                                    ->where('studentassignations.trainingtype',$id)
                                    ->where('cyclestatus',1)
                                    ->where('studentbookings.sid',$sesid)
                                    ->select('studentassignations.*','lmssections.section','trainings.trainingname','managers.mname','studentbookings.preattempt','studentbookings.pregiven','studentbookings.manpreapprove','studentbookings.preresult','managers.mname')->get();

        $result['train']=$id;
      return view('student.assigned',$result);
    }
    
     

     public function attindex($id){

         $sesid=session()->get('STUDENT_ID');
         $result['data']=DB::table('studentassignations')
                                    ->join('managers','studentassignations.mid','managers.id')
                                    ->join('studentbookings','studentbookings.assignid','studentassignations.id')
                                    ->join('trainings','studentassignations.trainingid','trainings.id')
                                    ->join('lmssections','studentassignations.sectionid','lmssections.id')
                                    ->where('studentassignations.trainingtype',$id)
                                    ->where('cyclestatus',2)
                                    ->where('studentbookings.sid',$sesid)
                                    ->select('studentassignations.*','lmssections.section','trainings.trainingname','managers.mname','studentbookings.preattempt','studentbookings.pregiven','studentbookings.manpreapprove','studentbookings.preresult','managers.mname')->get();
        for($i=0;$i<count($result['data']);$i++){
          $num=DB::table('studentassignmentbookings')->where('sbookingid',$result['data'][$i]->id)->get();
           $comp=0;
          for($m=0;$m<count($num);$m++){
            if($num[$m]->status=="4"){
                $comp++;
            }
          }
          $result['data'][$i]->totassigned=count($num);
          $result['data'][$i]->comassigned=$comp;
        }

        $result['train']=$id;
     
      return view('student.attended',$result);
    }

      

    public function assignments($id){
         $result['data']=DB::table('studentassignmentbookings')
                                  ->join('faculties','studentassignmentbookings.fid','faculties.id')
                                  ->where('sbookingid',$id)->select('studentassignmentbookings.*','faculties.fname')->get();
        return view('student.studentassignments',$result);

    }


     public function comstudents($id){
        $result['data']=DB::table('studentbookings')
                                  ->join('students','studentbookings.sid','students.id')
                                  ->join('trainings','studentbookings.trainingid','trainings.id')
                                  ->where('studentbookings.assignid',$id)
                                  ->select('studentbookings.*','trainings.trainingname','students.sname','students.image')
                                  ->get();

                     for($i=0;$i<count($result['data']);$i++){
          $num=DB::table('studentassignmentbookings')->where('sbookingid',$result['data'][$i]->id)->get();
           $comp=0;
          for($m=0;$m<count($num);$m++){
            if($num[$m]->status=="4"){
                $comp++;
            }
          }
          $result['data'][$i]->totassigned=count($num);
          $result['data'][$i]->comassigned=$comp;
        }
       $result['train']=$id;
      return view('admin.justcompleted',$result);
    }



     public function comindex($id){
         $sesid=session()->get('STUDENT_ID');
       $result['data']=DB::table('studentassignations')
                                    ->join('managers','studentassignations.mid','managers.id')
                                    ->join('studentbookings','studentbookings.assignid','studentassignations.id')
                                    ->join('trainings','studentassignations.trainingid','trainings.id')
                                    ->join('lmssections','studentassignations.sectionid','lmssections.id')
                                    ->where('studentassignations.trainingtype',$id)
                                    ->where('cyclestatus',3)
                                    ->where('studentbookings.sid',$sesid)
                                    ->select('studentassignations.*','lmssections.section','trainings.trainingname','managers.mname','studentbookings.preattempt','studentbookings.pregiven','studentbookings.manpreapprove','studentbookings.preresult','managers.mname')->get();
              for($i=0;$i<count($result['data']);$i++){
          $num=DB::table('studentassignmentbookings')->where('sbookingid',$result['data'][$i]->id)->get();
           $comp=0;
          for($m=0;$m<count($num);$m++){
            if($num[$m]->status=="4"){
                $comp++;
            }
          }
          $result['data'][$i]->totassigned=count($num);
          $result['data'][$i]->comassigned=$comp;
        }

         $result['appdata']=DB::table('studentassignations')
                                    ->join('managers','studentassignations.mid','managers.id')
                                    ->join('studentbookings','studentbookings.assignid','studentassignations.id')
                                    ->join('trainings','studentassignations.trainingid','trainings.id')
                                    ->join('lmssections','studentassignations.sectionid','lmssections.id')
                                    ->where('studentassignations.trainingtype',$id)
                                    ->where('cyclestatus',4)
                                    ->where('studentbookings.sid',$sesid)
                                    ->select('studentassignations.*','lmssections.section','trainings.trainingname','managers.mname','studentbookings.preattempt','studentbookings.pregiven','studentbookings.manpreapprove','studentbookings.preresult','studentbookings.*','managers.mname')->get();


            
       
       $result['train']=$id;
      return view('student.completed',$result);
    }

   
  





}
