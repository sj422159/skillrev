<?php

namespace App\Http\Controllers\supervisor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\studentassignation;
use App\Models\studentbooking;
use App\Models\assesmentsections;
use App\Models\finalanswer;
use App\Models\rescheduletimetable;
use App\Models\pendingtimetable;
use Redirect,Response;

class supschedulecontroller extends Controller
{
    
    public function reschedulelist(){
        $sesid=session()->get('SUPERVISOR_ID');
        $d=DB::table('supervisors')->where('id',$sesid)->get();
        $result['class']=DB::table('categories')->where('groupid',$d[0]->groupid)->get();
        $result['cl']=0;
        $result['section']=0;
        $result['managerrescheduledata']=DB::table('rescheduletimetables')
                        ->join('categories','rescheduletimetables.tclassid','categories.id')
                        ->join('lmssections','rescheduletimetables.tsectionid','lmssections.id')
                        ->join('domains','rescheduletimetables.tsubjectid','domains.id')
                        ->join('managers','rescheduletimetables.tprofileid','managers.id')
                        ->where("tportalid","MANAGER")
                        ->where('tclasstypeid',1)
                        ->where('restatus',0)
                        ->where('rescheduletimetables.supid',$sesid)
                        ->select('rescheduletimetables.*','categories.categories','lmssections.section','domains.dname','managers.mname')
                        ->get();
        $result['managerrescheduledataopt']=DB::table('rescheduletimetables')
                            ->join('categories','rescheduletimetables.tclassid','categories.id')
                            ->join('domains','rescheduletimetables.tsubjectid','domains.id')
                            ->join('managers','rescheduletimetables.tprofileid','managers.id')
                            ->where("tportalid","MANAGER")
                            ->where('tclasstypeid',1)
                            ->where('restatus',0)
                            ->where('tsectionid',0)
                            ->where('rescheduletimetables.supid',$sesid)
                            ->select('rescheduletimetables.*','categories.categories','domains.dname','managers.mname')
                            ->get();

        $result['facultyrescheduledata']=DB::table('rescheduletimetables')
                        ->join('categories','rescheduletimetables.tclassid','categories.id')
                        ->join('faculties','rescheduletimetables.tprofileid','faculties.id')
                        ->join('lmssections','rescheduletimetables.tsectionid','lmssections.id')
                        ->join('domains','rescheduletimetables.tsubjectid','domains.id')
                        ->where("tportalid","FACULTY")
                        ->where('tclasstypeid',1)
                        ->where('restatus',0)
                        ->where('rescheduletimetables.supid',$sesid)
                        ->select('rescheduletimetables.*','categories.categories','lmssections.section','domains.dname','faculties.fname')
                        ->get();
        $result['facultyrescheduledataopt']=DB::table('rescheduletimetables')
                            ->join('categories','rescheduletimetables.tclassid','categories.id')
                            ->join('faculties','rescheduletimetables.tprofileid','faculties.id')
                            ->join('domains','rescheduletimetables.tsubjectid','domains.id')
                            ->where("tportalid","FACULTY")
                            ->where('tclasstypeid',1)
                            ->where('restatus',0)
                            ->where('tsectionid',0)
                            ->where('rescheduletimetables.supid',$sesid)
                            ->select('rescheduletimetables.*','categories.categories','domains.dname','faculties.fname')
                            ->get();



        $result['managerrescheduleddata']=DB::table('rescheduletimetables')
                        ->join('categories','rescheduletimetables.tclassid','categories.id')
                        ->join('lmssections','rescheduletimetables.tsectionid','lmssections.id')
                        ->join('domains','rescheduletimetables.tsubjectid','domains.id')
                        ->join('managers','rescheduletimetables.tprofileid','managers.id')
                        ->where("tportalid","MANAGER")
                        ->where('tclasstypeid',1)
                        ->where('restatus','>',0)
                        ->where('rescheduletimetables.supid',$sesid)
                        ->select('rescheduletimetables.*','categories.categories','lmssections.section','domains.dname','managers.mname')
                        ->get();
        $result['managerrescheduleddataopt']=DB::table('rescheduletimetables')
                            ->join('categories','rescheduletimetables.tclassid','categories.id')
                            ->join('domains','rescheduletimetables.tsubjectid','domains.id')
                            ->join('managers','rescheduletimetables.tprofileid','managers.id')
                            ->where("tportalid","MANAGER")
                            ->where('tclasstypeid',1)
                            ->where('restatus','>',0)
                            ->where('tsectionid',0)
                            ->where('rescheduletimetables.supid',$sesid)
                            ->select('rescheduletimetables.*','categories.categories','domains.dname','managers.mname')
                            ->get();

        $result['facultyrescheduleddata']=DB::table('rescheduletimetables')
                        ->join('categories','rescheduletimetables.tclassid','categories.id')
                        ->join('faculties','rescheduletimetables.tprofileid','faculties.id')
                        ->join('lmssections','rescheduletimetables.tsectionid','lmssections.id')
                        ->join('domains','rescheduletimetables.tsubjectid','domains.id')
                        ->where("tportalid","FACULTY")
                        ->where('tclasstypeid',1)
                        ->where('restatus','>',0)
                        ->where('rescheduletimetables.supid',$sesid)
                        ->select('rescheduletimetables.*','categories.categories','lmssections.section','domains.dname','faculties.fname')
                        ->get();
        $result['facultyrescheduleddataopt']=DB::table('rescheduletimetables')
                            ->join('categories','rescheduletimetables.tclassid','categories.id')
                            ->join('faculties','rescheduletimetables.tprofileid','faculties.id')
                            ->join('domains','rescheduletimetables.tsubjectid','domains.id')
                            ->where("tportalid","FACULTY")
                            ->where('tclasstypeid',1)
                            ->where('restatus','>',0)
                            ->where('tsectionid',0)
                            ->where('rescheduletimetables.supid',$sesid)
                            ->select('rescheduletimetables.*','categories.categories','domains.dname','faculties.fname')
                            ->get();

        return view('supervisor.classrescheduling',$result);
    }

    public function changecomplete($id){
        $model=rescheduletimetable::find($id);
        $model->completionstatus=1;
        $model->save();

        $a = DB::table('pendingtimetables')->where("tportalid","FACULTY")->where('tclasstypeid',1)->where('tprofileid',$model->tprofileid)->where('tclassid',$model->tclassid)->where('tsectionid',$model->tsectionid)->where('completionstatus',0)->limit(1)->get();

        if(count($a)>0){
        $m=pendingtimetable::find($a[0]->id);
        $m->completionstatus=1;
        $m->save();
        }
        return redirect('groupmanager/rescheduling/list');
    }

    public function reschedulelistbysection(request $request){
        $sesid=session()->get('SUPERVISOR_ID'); 
        $d=DB::table('supervisors')->where('id',$sesid)->get();
        $result['class']=DB::table('categories')->where('groupid',$d[0]->groupid)->get();
        $result['cl']=$request->post('class');
        $result['section']=$request->post('section');

        $result['managerrescheduledata']=DB::table('rescheduletimetables')
                        ->join('categories','rescheduletimetables.tclassid','categories.id')
                        ->join('lmssections','rescheduletimetables.tsectionid','lmssections.id')
                        ->join('domains','rescheduletimetables.tsubjectid','domains.id')
                        ->join('managers','rescheduletimetables.tprofileid','managers.id')
                        ->where("tportalid","MANAGER")
                        ->where('tclasstypeid',1)
                        ->where('tclassid',$request->post('class'))
                        ->where('tsectionid',$request->post('section'))
                        ->where('restatus',0)
                        ->select('rescheduletimetables.*','categories.categories','lmssections.section','domains.dname','managers.mname')
                        ->get();
        $result['managerrescheduledataopt']=DB::table('rescheduletimetables')
                            ->join('categories','rescheduletimetables.tclassid','categories.id')
                            ->join('domains','rescheduletimetables.tsubjectid','domains.id')
                            ->join('managers','rescheduletimetables.tprofileid','managers.id')
                            ->where("tportalid","MANAGER")
                            ->where('tclasstypeid',1)
                            ->where('tclassid',$request->post('class'))
                            ->where('restatus',0)
                            ->where('tsectionid',0)
                            ->select('rescheduletimetables.*','categories.categories','domains.dname','managers.mname')
                            ->get();

        $result['facultyrescheduledata']=DB::table('rescheduletimetables')
                        ->join('categories','rescheduletimetables.tclassid','categories.id')
                        ->join('faculties','rescheduletimetables.tprofileid','faculties.id')
                        ->join('lmssections','rescheduletimetables.tsectionid','lmssections.id')
                        ->join('domains','rescheduletimetables.tsubjectid','domains.id')
                        ->where("tportalid","FACULTY")
                        ->where('tclasstypeid',1)
                        ->where('tclassid',$request->post('class'))
                        ->where('tsectionid',$request->post('section'))
                        ->where('restatus',0)
                        ->select('rescheduletimetables.*','categories.categories','lmssections.section','domains.dname','faculties.fname')
                        ->get();
        $result['facultyrescheduledataopt']=DB::table('rescheduletimetables')
                            ->join('categories','rescheduletimetables.tclassid','categories.id')
                            ->join('faculties','rescheduletimetables.tprofileid','faculties.id')
                            ->join('domains','rescheduletimetables.tsubjectid','domains.id')
                            ->where("tportalid","FACULTY")
                            ->where('tclasstypeid',1)
                            ->where('tclassid',$request->post('class'))
                            ->where('restatus',0)
                            ->where('tsectionid',0)
                            ->select('rescheduletimetables.*','categories.categories','domains.dname','faculties.fname')
                            ->get();



        $result['managerrescheduleddata']=DB::table('rescheduletimetables')
                        ->join('categories','rescheduletimetables.tclassid','categories.id')
                        ->join('lmssections','rescheduletimetables.tsectionid','lmssections.id')
                        ->join('domains','rescheduletimetables.tsubjectid','domains.id')
                        ->join('managers','rescheduletimetables.tprofileid','managers.id')
                        ->where("tportalid","MANAGER")
                        ->where('tclasstypeid',1)
                        ->where('tclassid',$request->post('class'))
                        ->where('tsectionid',$request->post('section'))
                        ->where('restatus','>',0)
                        ->select('rescheduletimetables.*','categories.categories','lmssections.section','domains.dname','managers.mname')
                        ->get();
        $result['managerrescheduleddataopt']=DB::table('rescheduletimetables')
                            ->join('categories','rescheduletimetables.tclassid','categories.id')
                            ->join('domains','rescheduletimetables.tsubjectid','domains.id')
                            ->join('managers','rescheduletimetables.tprofileid','managers.id')
                            ->where("tportalid","MANAGER")
                            ->where('tclasstypeid',1)
                            ->where('tclassid',$request->post('class'))
                            ->where('restatus','>',0)
                            ->where('tsectionid',0)
                            ->select('rescheduletimetables.*','categories.categories','domains.dname','managers.mname')
                            ->get();

        $result['facultyrescheduleddata']=DB::table('rescheduletimetables')
                        ->join('categories','rescheduletimetables.tclassid','categories.id')
                        ->join('faculties','rescheduletimetables.tprofileid','faculties.id')
                        ->join('lmssections','rescheduletimetables.tsectionid','lmssections.id')
                        ->join('domains','rescheduletimetables.tsubjectid','domains.id')
                        ->where("tportalid","FACULTY")
                        ->where('tclasstypeid',1)
                        ->where('tclassid',$request->post('class'))
                        ->where('tsectionid',$request->post('section'))
                        ->where('restatus','>',0)
                        ->select('rescheduletimetables.*','categories.categories','lmssections.section','domains.dname','faculties.fname')
                        ->get();
        $result['facultyrescheduleddataopt']=DB::table('rescheduletimetables')
                            ->join('categories','rescheduletimetables.tclassid','categories.id')
                            ->join('faculties','rescheduletimetables.tprofileid','faculties.id')
                            ->join('domains','rescheduletimetables.tsubjectid','domains.id')
                            ->where("tportalid","FACULTY")
                            ->where('tclasstypeid',1)
                            ->where('tclassid',$request->post('class'))
                            ->where('restatus','>',0)
                            ->where('tsectionid',0)
                            ->select('rescheduletimetables.*','categories.categories','domains.dname','faculties.fname')
                            ->get();


        return view('supervisor.classrescheduling',$result);
    }

    public function classby(){
        $id = $_GET['id'];
        $res = DB::table('lmssections')->where('lmssections.classid',$id)->get();
        return Response::json($res);
    }


    public function pendingandextraclasses(request $request){
        $supid=session()->get('SUPERVISOR_ID');

        $result['supdata']=DB::table('pendinglists')
                        ->join('supervisors','supervisors.id','pendinglists.pprofile')
                        ->where('pportalid',1)
                        ->where('supervisors.id',$supid)
                        ->select('supervisors.supname','supervisors.supnumber','pendinglists.*')
                        ->get();

        $result['mandata']=DB::table('pendinglists')
                        ->join('managers','managers.id','pendinglists.pprofile')
                        ->where('pportalid',2)
                        ->where('managers.supid',$supid)
                        ->select('managers.mname','managers.mnumber','pendinglists.*')
                        ->get();

        $result['facdata']=DB::table('pendinglists')
                        ->join('faculties','faculties.id','pendinglists.pprofile')
                        ->where('pportalid',4)
                        ->where('faculties.fsupid',$supid)
                        ->select('faculties.fname','faculties.fnumber','pendinglists.*')
                        ->get();

        return view('supervisor.staffpendingandextraclasses',$result);
    }

    public function pendingandextraclassesview($portal,$profile){
   
        if($portal=="1"){
            $result['rescheduledata']=DB::table('pendingtimetables')
                        ->join('categories','pendingtimetables.tclassid','categories.id')
                        ->join('lmssections','pendingtimetables.tsectionid','lmssections.id')
                        ->join('domains','pendingtimetables.tsubjectid','domains.id')
                        ->join('supervisors','pendingtimetables.tprofileid','supervisors.id')
                        ->where("tportalid","GROUPMANAGER")
                        ->where('tclasstypeid',1)
                        ->where('tprofileid',$profile)
                        ->select('pendingtimetables.*','categories.categories','lmssections.section','domains.dname','supervisors.supname')
                        ->get();
            $result['rescheduledataopt']=DB::table('pendingtimetables')
                            ->join('categories','pendingtimetables.tclassid','categories.id')
                            ->join('domains','pendingtimetables.tsubjectid','domains.id')
                            ->join('supervisors','pendingtimetables.tprofileid','supervisors.id')
                            ->where("tportalid","GROUPMANAGER")
                            ->where('tclasstypeid',1)
                            ->where('tprofileid',$profile)

                            ->where('tsectionid',0)
                            ->select('pendingtimetables.*','categories.categories','domains.dname','supervisors.mname')
                            ->get();   
        }
        elseif($portal=="2"){
            $result['rescheduledata']=DB::table('pendingtimetables')
                        ->join('categories','pendingtimetables.tclassid','categories.id')
                        ->join('lmssections','pendingtimetables.tsectionid','lmssections.id')
                        ->join('domains','pendingtimetables.tsubjectid','domains.id')
                        ->join('managers','pendingtimetables.tprofileid','managers.id')
                        ->where("tportalid","MANAGER")
                        ->where('tclasstypeid',1)
                        ->where('tprofileid',$profile)
                        ->select('pendingtimetables.*','categories.categories','lmssections.section','domains.dname','managers.mname')
                        ->get();
            $result['rescheduledataopt']=DB::table('pendingtimetables')
                            ->join('categories','pendingtimetables.tclassid','categories.id')
                            ->join('domains','pendingtimetables.tsubjectid','domains.id')
                            ->join('managers','pendingtimetables.tprofileid','managers.id')
                            ->where("tportalid","MANAGER")
                            ->where('tclasstypeid',1)
                            ->where('tprofileid',$profile)

                            ->where('tsectionid',0)
                            ->select('pendingtimetables.*','categories.categories','domains.dname','managers.mname')
                            ->get();

          
        }elseif($portal=="3" || $portal=="4"){
            $result['rescheduledata']=DB::table('pendingtimetables')
                        ->join('categories','pendingtimetables.tclassid','categories.id')
                        ->join('faculties','pendingtimetables.tprofileid','faculties.id')
                        ->join('lmssections','pendingtimetables.tsectionid','lmssections.id')
                        ->join('domains','pendingtimetables.tsubjectid','domains.id')
                        ->where("tportalid","FACULTY")
                        ->where('tclasstypeid',1)
                        ->where('tprofileid',$profile)
                        ->select('pendingtimetables.*','categories.categories','lmssections.section','domains.dname','faculties.fname')
                        ->get();
            $result['rescheduledataopt']=DB::table('pendingtimetables')
                            ->join('categories','pendingtimetables.tclassid','categories.id')
                            ->join('faculties','pendingtimetables.tprofileid','faculties.id')
                            ->join('domains','pendingtimetables.tsubjectid','domains.id')
                            ->where("tportalid","FACULTY")
                            ->where('tclasstypeid',1)
                            ->where('tprofileid',$profile)

                            ->where('tsectionid',0)
                            ->select('pendingtimetables.*','categories.categories','domains.dname','faculties.fname')
                            ->get();

           
        }
        return view("supervisor.pendingclassesview",$result);
    }
  
}