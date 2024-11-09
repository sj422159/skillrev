<?php

namespace App\Http\Controllers\supervisor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\leave;
use Carbon\CarbonPeriod;
use Mail;
use App\Models\pendinglist;
use App\Models\rescheduletimetable;
use App\Models\pendingtimetable;
use Redirect,Response;

class supervisorleavecontroller extends Controller
{
    public function approveleave(Request $request){
        $aid=session()->get('SUPERVISOR_ADMIN_ID');
        $sid=session()->get('SUPERVISOR_ID');
        $result['facultyleave']=DB::table('leaves')
                            ->join('faculties','faculties.id','leaves.profileid')
                            ->where('leaves.aid',$aid)->where('faculties.fsupid',$sid)->where('portalid',4)
                            ->select('faculties.fname','leaves.*')
                            ->latest('leaves.id')
                            ->get();
        for($i=0;$i<count($result['facultyleave']);$i++){
          $a=DB::table('pendinglists')->where('pportalid',$result['facultyleave'][$i]->portalid)
           ->where('pprofile',$result['facultyleave'][$i]->profileid)->get();
           if(count($a)>0){
            $result['facultyleave'][$i]->visible=1;
           }else{
             $result['facultyleave'][$i]->visible=0;
           } 
        }
        $result['managerleave']=DB::table('leaves')
                            ->join('managers','managers.id','leaves.profileid')
                            ->where('leaves.aid',$aid)->where('managers.supid',$sid)->where('portalid',2)
                            ->select('managers.mname','leaves.*')
                            ->latest('leaves.id')
                            ->get();

         for($i=0;$i<count($result['managerleave']);$i++){
          $a=DB::table('pendinglists')->where('pportalid',$result['managerleave'][$i]->portalid)
           ->where('pprofile',$result['managerleave'][$i]->profileid)->get();
           if(count($a)>0){
            $result['managerleave'][$i]->visible=1;
           }else{
             $result['managerleave'][$i]->visible=0;
           } 
        }
        return view('supervisor.approveleave',$result);
    }

    public function inprogressleavestatus(Request $request,$status,$id){
        $model=leave::find($id);
        $model->status=$status;
        $model->save();
        $from=$model->fromdate;
        $to=$model->todate;
        $result['dates'] = CarbonPeriod::create($from, $to);
        $portal="";
        if($model->portalid==1){
            $portal="GROUPMANAGER";
        }else if($model->portalid==2){
            $portal="MANAGER";
        }else if($model->portalid==3 || $model->portalid==4){
            $portal="FACULTY";
        }

        $result['days']=[];
        $co=0;
        foreach ($result['dates'] as $key) {
            $d= $key->format('d-m-Y');
            $result['days'][$co]=date('l',strtotime($d));
            $result['date'][$co]=$d;
            $co++;
        }
        $scount=0;
        $failcount=0;
        $passcount=0;
        for($i=0;$i<count($result['days']);$i++){
            $s=DB::table('periodtimetables')->where('tportalid',$portal)->where('tprofileid',$model->profileid)->where('tdayid',$result['days'][$i])->get();
            $scount=$scount+count($s);
            for($k=0;$k<count($s);$k++){

             $check=DB::table('rescheduletimetables')->where('tportalid',$portal)->where('tprofileid',$model->profileid)->where('tdayid',$result['days'][$i])->where('tclassid',$s[$k]->tclassid)->where('tsectionid',$s[$k]->tsectionid)->where('tsubjectid',$s[$k]->tsubjectid)->where('restatus',1)->get();
             if(count($check)>0){

                $rmodel=new rescheduletimetable();
            $rmodel->aid=$s[$k]->aid;
            $rmodel->supid=$s[$k]->supid;
            $rmodel->tclasstypeid=$s[$k]->tclasstypeid;
            $rmodel->tportalid=$s[$k]->tportalid;
            $rmodel->tprofileid=$s[$k]->tprofileid;
            $rmodel->tsubjectid=$s[$k]->tsubjectid;
            $rmodel->tmoduleid=$s[$k]->tmoduleid;
            $rmodel->tdayid=$s[$k]->tdayid;
            $rmodel->tclassid=$s[$k]->tclassid;
            $rmodel->tsectionid=$s[$k]->tsectionid;
            $rmodel->tperiodid=$s[$k]->tperiodid;
            $rmodel->roomtype=$s[$k]->roomtype;
            $rmodel->roomno=$s[$k]->roomno;
            $rmodel->stustart=$s[$k]->stustart;
            $rmodel->stuend=$s[$k]->stuend;
            $rmodel->tdateid=$result['date'][$i];
            $rmodel->save();
            
                $remodel=rescheduletimetable::find($check[0]->id);
                $remodel->restatus=2;//got Compensated
                $remodel->save();
                $failcount++;



             }else{

            $rmodel=new rescheduletimetable();
            $rmodel->aid=$s[$k]->aid;
            $rmodel->supid=$s[$k]->supid;
            $rmodel->tclasstypeid=$s[$k]->tclasstypeid;
            $rmodel->tportalid=$s[$k]->tportalid;
            $rmodel->tprofileid=$s[$k]->tprofileid;
            $rmodel->tsubjectid=$s[$k]->tsubjectid;
            $rmodel->tmoduleid=$s[$k]->tmoduleid;
            $rmodel->tdayid=$s[$k]->tdayid;
            $rmodel->tclassid=$s[$k]->tclassid;
            $rmodel->tsectionid=$s[$k]->tsectionid;
            $rmodel->tperiodid=$s[$k]->tperiodid;
            $rmodel->roomtype=$s[$k]->roomtype;
            $rmodel->roomno=$s[$k]->roomno;
            $rmodel->stustart=$s[$k]->stustart;
            $rmodel->stuend=$s[$k]->stuend;
            $rmodel->tdateid=$result['date'][$i];
            $rmodel->save();

            $pmodel=new pendingtimetable();
            $pmodel->aid=$s[$k]->aid;
            $pmodel->supid=$s[$k]->supid;
            $pmodel->tclasstypeid=$s[$k]->tclasstypeid;
            $pmodel->tportalid=$s[$k]->tportalid;
            $pmodel->tprofileid=$s[$k]->tprofileid;
            $pmodel->tsubjectid=$s[$k]->tsubjectid;
            $pmodel->tmoduleid=$s[$k]->tmoduleid;
            $pmodel->tdayid=$s[$k]->tdayid;
            $pmodel->tclassid=$s[$k]->tclassid;
            $pmodel->tsectionid=$s[$k]->tsectionid;
            $pmodel->tperiodid=$s[$k]->tperiodid;
            $pmodel->roomtype=$s[$k]->roomtype;
            $pmodel->roomno=$s[$k]->roomno;
            $pmodel->stustart=$s[$k]->stustart;
            $pmodel->stuend=$s[$k]->stuend;
            $pmodel->tdateid=$result['date'][$i];
            $pmodel->save();
            $passcount++;

             }

           
         }


        }

        $check=DB::table('pendinglists')->where('pportalid',$model->portalid)->where('pprofile',$model->profileid)->get();
        if(count($check)>0){
           $m=pendinglist::find($check[0]->id);
           $m->pcount=(int)$m->pcount+$passcount;
           $m->ecount=(int)$m->ecount-$failcount;
          
        }else{
           $m=new pendinglist();
            $m->pcount=$passcount;
        }
        $m->aid=session()->get('SUPERVISOR_ADMIN_ID');
        $m->pportalid=$model->portalid;
        $m->pprofile=$model->profileid;
        $m->save();

        $request->session()->flash('success','Leave Status Updated Successfully');
        return redirect('supervisor/approve/leave');

    }


    public function approveleavestatus(Request $request,$status,$id){
        $model=leave::find($id);
        $model->status=$status;
        $model->save();

        $request->session()->flash('success','Leave Approved Successfully');
        return redirect('supervisor/approve/leave');

    }

    public function applyleave(Request $request){
        $sid=session()->get('SUPERVISOR_ID');
        $result['leave']=DB::table('leaves')->where('profileid',$sid)->where('portalid',1)->latest('id')->get();
        return view('supervisor.leave',$result);
    }

    public function addapplyleave(Request $request,$id=""){   
        if($id>0){
            $arr=leave::where(['id'=>$id])->get();
            $result['id']=$arr['0']->id;
            $result['fromdate']=date("Y-m-d", strtotime($arr['0']->fromdate));
            $result['todate']=date("Y-m-d", strtotime($arr['0']->todate));
            $result['reason']=$arr['0']->reason;
        }
        else{
            $result['id']='';
            $result['fromdate']='';
            $result['todate']='';
            $result['reason']='';
        } 
        return view("supervisor.addleave",$result);
    }
     
    public function saveapplyleave(Request $request){
        if($request->post('id')>0){
            $model=leave::find($request->post('id'));
            $msg="Leave Updated Successfully";
        }
        else{
            $model=new leave();
            $msg="Leave Applied Successfully";
        }
        $fromdate = $request->post('fromdate');
        $newfromdate = date("d-m-Y", strtotime($fromdate));
        $todate = $request->post('todate');
        $newtodate = date("d-m-Y", strtotime($todate));
        $model->aid=session()->get('SUPERVISOR_ADMIN_ID');
        $model->portalid=1;
        $model->profileid=session()->get('SUPERVISOR_ID');
        $model->fromdate=$newfromdate;
        $model->todate=$newtodate;
        $model->reason=$request->post('reason');
        $model->status=1;
        $model->save();

        $request->session()->flash('success',$msg);
        return redirect('supervisor/apply/leave');
    }

    public function applyleavedelete(Request $request, $id){
        $model=leave::find($id);
        $model->delete();
        $request->session()->flash('success','Leave Deleted Successfully');
        return redirect('supervisor/apply/leave');
    }


    public function pending($portal,$id,$lid){
        $result['lid']=$lid;

        $result['data']=DB::table('pendinglists')
                         ->where('pportalid',$portal)->where('pprofile',$id)->get();
        if(count($result['data'])>0){
         if($portal=="1"){
            $a=DB::table('supervisors')->where('id',$id)->get();
            $result['data'][0]->name=$a[0]->supname;
            $result['data'][0]->portal="GROUPMANAGER";
            $result['data'][0]->number=$a[0]->supnumber;
         }else if($portal=="2"){
            $a=DB::table('managers')->where('id',$id)->get();
            $result['data'][0]->name=$a[0]->mname;
            $result['data'][0]->portal="MANAGER";
            $result['data'][0]->number=$a[0]->mnumber;
         }else{
            $a=DB::table('faculties')->where('id',$id)->get();
            $result['data'][0]->name=$a[0]->fname;
            $result['data'][0]->portal="FACULTY";
             $result['data'][0]->number=$a[0]->fnumber;
         }
        } 

        $result['portal']=$portal;
        $result['profile']=$id;


        return view("supervisor.pendinglist",$result);
    }

    public function reschedule($portal,$id,$lid){

        $result['rescheduledata']=[];
        $result['rescheduledataopt']=[];
        $result['lid']=$lid;
   
        
        if($portal=="2"){
            $result['rescheduledata']=DB::table('rescheduletimetables')
                        ->join('categories','rescheduletimetables.tclassid','categories.id')
                        ->join('lmssections','rescheduletimetables.tsectionid','lmssections.id')
                        ->join('domains','rescheduletimetables.tsubjectid','domains.id')
                        ->join('managers','rescheduletimetables.tprofileid','managers.id')
                        ->where("tportalid","MANAGER")
                        ->where('tclasstypeid',1)
                        ->where('tprofileid',$id)
                        ->where('restatus',0)
                        ->select('rescheduletimetables.*','categories.categories','lmssections.section','domains.dname','managers.mname')
                        ->get();
            $result['rescheduledataopt']=DB::table('rescheduletimetables')
                            ->join('categories','rescheduletimetables.tclassid','categories.id')
                            ->join('domains','rescheduletimetables.tsubjectid','domains.id')
                            ->join('managers','rescheduletimetables.tprofileid','managers.id')
                            ->where("tportalid","MANAGER")
                            ->where('tclasstypeid',1)
                            ->where('tprofileid',$id)
                            ->where('restatus',0)
                            ->where('tsectionid',0)
                            ->select('rescheduletimetables.*','categories.categories','domains.dname','managers.mname')
                            ->get();

          
        }else{
            $result['rescheduledata']=DB::table('rescheduletimetables')
                        ->join('categories','rescheduletimetables.tclassid','categories.id')
                        ->join('faculties','rescheduletimetables.tprofileid','faculties.id')
                        ->join('lmssections','rescheduletimetables.tsectionid','lmssections.id')
                        ->join('domains','rescheduletimetables.tsubjectid','domains.id')
                        ->where("tportalid","FACULTY")
                        ->where('tclasstypeid',1)
                        ->where('tprofileid',$id)
                        ->where('restatus',0)
                        ->select('rescheduletimetables.*','categories.categories','lmssections.section','domains.dname','faculties.fname')
                        ->get();
            $result['rescheduledataopt']=DB::table('rescheduletimetables')
                            ->join('categories','rescheduletimetables.tclassid','categories.id')
                            ->join('faculties','rescheduletimetables.tprofileid','faculties.id')
                            ->join('domains','rescheduletimetables.tsubjectid','domains.id')
                            ->where("tportalid","FACULTY")
                            ->where('tclasstypeid',1)
                            ->where('tprofileid',$id)
                            ->where('restatus',0)
                            ->where('tsectionid',0)
                            ->select('rescheduletimetables.*','categories.categories','domains.dname','faculties.fname')
                            ->get();

           
        }
        return view("supervisor.reschedule",$result);
    }

    public function rescheduleform($restimetableid,$lid){

        $result['lid']=$lid;
        $supid=session()->get('SUPERVISOR_ID');
        
        $a=DB::table('rescheduletimetables')->where('id',$restimetableid)->get();
        
        $result['visible']=1;

         $occupy=[];
         $occupyman=[];
         $occupysup=[];
        if($a[0]->tsectionid=="0"){
            $result['data']=DB::table('rescheduletimetables')
                        ->join('categories','rescheduletimetables.tclassid','categories.id')
                        ->join('faculties','rescheduletimetables.tprofileid','faculties.id')
                        ->join('domains','rescheduletimetables.tsubjectid','domains.id')
                        ->where("tportalid","FACULTY")->where('tclasstypeid',1)
                        ->where('rescheduletimetables.id',$restimetableid)
                        ->where('restatus',0)
                        ->select('rescheduletimetables.*','categories.categories','domains.dname','faculties.fname')
                        ->get();
              $occupy=DB::table('periodtimetables')->where('tdayid',$result['data'][0]->tdayid)->where('tclassid',$result['data'][0]->tclassid)->where('tsectionid',0)->where('tperiodid',$result['data'][0]->tperiodid)->where('tportalid','FACULTY')->get();
            $result['visible']=0;
             $occupyman=DB::table('periodtimetables')->where('tdayid',$result['data'][0]->tdayid)->where('tclassid',$result['data'][0]->tclassid)->where('tsectionid',0)->where('tperiodid',$result['data'][0]->tperiodid)->where('tportalid','MANAGER')->get();
              $occupysup=DB::table('periodtimetables')->where('tdayid',$result['data'][0]->tdayid)->where('tclassid',$result['data'][0]->tclassid)->where('tsectionid',0)->where('tperiodid',$result['data'][0]->tperiodid)->where('tportalid','GROUPMANAGER')->where('tprofileid',$supid)->get();

        }
        else{
            $result['data']=DB::table('rescheduletimetables')
                        ->join('categories','rescheduletimetables.tclassid','categories.id')
                        ->join('faculties','rescheduletimetables.tprofileid','faculties.id')
                        ->join('lmssections','rescheduletimetables.tsectionid','lmssections.id')
                        ->join('domains','rescheduletimetables.tsubjectid','domains.id')
                        ->where("tportalid","FACULTY")->where('tclasstypeid',1)
                        ->where('rescheduletimetables.id',$restimetableid)
                        ->where('restatus',0)
                        ->select('rescheduletimetables.*','categories.categories','lmssections.section','domains.dname','faculties.fname')
                        ->get();
              $occupy=DB::table('periodtimetables')->where('tdayid',$result['data'][0]->tdayid)->where('tclassid',$result['data'][0]->tclassid)->where('tsectionid',$result['data'][0]->tsectionid)->where('tperiodid',$result['data'][0]->tperiodid)->where('tportalid','FACULTY')->get();
               $occupyman=DB::table('periodtimetables')->where('tdayid',$result['data'][0]->tdayid)->where('tclassid',$result['data'][0]->tclassid)->where('tsectionid',$result['data'][0]->tsectionid)->where('tperiodid',$result['data'][0]->tperiodid)->where('tportalid','MANAGER')->get();
                $occupysup=DB::table('periodtimetables')->where('tdayid',$result['data'][0]->tdayid)->where('tclassid',$result['data'][0]->tclassid)->where('tsectionid',$result['data'][0]->tsectionid)->where('tperiodid',$result['data'][0]->tperiodid)->where('tportalid','GROUPMANAGER')->where('tprofileid',$supid)->get();

        }

        $domain=DB::table('domains')->where('category',$result['data'][0]->tclassid)->get();
        $subs=[];
        $result['faculties']=[];
        for($i=0;$i<count($domain);$i++){
            $a=[];
            if($result['data'][0]->tportalid=="FACULTY"){
            $a= DB::table('faculties')->where('fsupid',$supid)
                              ->where('subjectid','Like','%'.$domain[$i]->id.'%')
                              ->where('id','!=',$result['data'][0]->tprofileid)
                             ->get();
            }else{
               $a= DB::table('faculties')->where('fsupid',$supid)
                              ->where('subjectid','Like','%'.$domain[$i]->id.'%')
                             ->get();   
            }
            $result['faculties']=array_merge($result['faculties'],json_decode($a));
          
        }

        $result['facs']=[];
        $result['fid']=[];
        $count=0;
        for($i=0;$i<count($result['faculties']);$i++){
           if(in_array($result['faculties'][$i]->id, $result['fid'])){
           }else{
            $result['facs'][$count]=$result['faculties'][$i];
            $result['fid'][$count]=$result['faculties'][$i]->id;
            $count++;
           }
        }

       $result['occupy']=[];
       for($i=0;$i<count($occupy);$i++){
        $result['occupy'][$i]=$occupy[$i]->tprofileid;
       }


        $result['managers']=[];
        if($result['data'][0]->tportalid=="MANAGER"){
        $result['managers']=DB::table('managers')->where('supid',$supid)
                            ->where('classid',$result['data'][0]->tclassid)
                            ->where('id','!=',$result['data'][0]->tprofileid)
                            ->get(); 
        }else{
        $result['managers']=DB::table('managers')->where('supid',$supid)
                            ->where('classid',$result['data'][0]->tclassid)
                            ->get();    
        }
       

         $result['occupyman']=[];
       for($i=0;$i<count($occupyman);$i++){
        $result['occupyman'][$i]=$occupyman[$i]->tprofileid;
       }
         $result['supervisors']=DB::table('supervisors')->where('id',$supid)->get(); 
        
         if(count($occupysup)>0){
          $result['supervisors']=[];
         }
        
         


        return view("supervisor.rescheduleform",$result);
    }

    public  function reschedulegetsubjects(){
        $portal = $_GET['portal'];
        $profile = $_GET['profile'];
        $res=[];

        if($portal=="FACULTY"){
        $data=DB::table('faculties')->where('id',$profile)->get('subjectid');
        $subid=explode("##",$data[0]->subjectid);
        $res=DB::table('domains')->whereIn('id',$subid)->get();
        }

        elseif($portal=="MANAGER"){
        $data=DB::table('managers')->where('id',$profile)->get('msubjectid');
        $subid=explode("##",$data[0]->msubjectid);
        $res=DB::table('domains')->whereIn('id',$subid)->get();
        }

        elseif($portal=="GROUPMANAGER"){
        $data=DB::table('supervisors')->where('id',$profile)->get('ssubjectid');
        $subid=explode("##",$data[0]->ssubjectid);
        $res=DB::table('domains')->whereIn('id',$subid)->get();
        }

        return Response::json($res);
    }

    public  function reschedulegettabledata(){
        $day = $_GET['day'];
        $date = $_GET['date'];
        $class = $_GET['class'];
        $section = $_GET['section'];
        $period = $_GET['period'];
        $portal = $_GET['portal'];
        $profile = $_GET['profile'];
        $subject = $_GET['subject'];
        
        if($section>0){
          $res=DB::table('pendingtimetables')
            ->join('categories','pendingtimetables.tclassid','categories.id')
            ->join('lmssections','pendingtimetables.tsectionid','lmssections.id')
            ->join('domains','pendingtimetables.tsubjectid','domains.id')
            ->where('tclassid',$class)->where('tsectionid',$section)
            ->where('tportalid',$portal)->where('tprofileid',$profile)->where('tsubjectid',$subject)
            ->where('completionstatus',1)
            ->select('pendingtimetables.*','lmssections.section','domains.domain','categories.categories')
            ->get();
        }else{
            $res=DB::table('pendingtimetables')
            ->join('categories','pendingtimetables.tclassid','categories.id')
            ->join('domains','pendingtimetables.tsubjectid','domains.id')
            ->where('tclassid',$class)->where('tsectionid',$section)
            ->where('tportalid',$portal)->where('tprofileid',$profile)->where('tsubjectid',$subject)
            ->where('completionstatus',1)
            ->select('pendingtimetables.*','domains.domain','categories.categories')
            ->get();
            

            for($i=0;$i<count($res);$i++){
                $res[$i]->section="OPTIONAL SUBJECT";
            }
        }

        
        

        return Response::json($res);
    }

    public function reschedulesave(Request $request){
     //  return $request->post(); 
        $a = $request->post('fac');
        $b = explode("**",$a);
        $subtype=DB::table('domains')->where('id',$request->post('sub'))->get('stype');

        $model=rescheduletimetable::find($request->post('id'));
        $model->tportalid=$b[0];
        $model->tprofileid=$b[1];
        $model->tsubjecttype=$subtype[0]->stype;
        $model->tsubjectid=$request->post('sub');
        $model->restatus=1;
        $model->save();
        $portal=0;
       if($b[0]=="FACULTY"){
           $portal=4;
         }else if($b[0]=="MANAGER"){
            $portal=2;
         }else if($b[0]=="GROUPMANAGER"){
            $portal=1;
         }
          $check=DB::table('pendinglists')->where('pportalid',$portal)->where('pprofile',$b[1])->get();
       
        if(count($check)>0){
           $m=pendinglist::find($check[0]->id);
           if($request->has('pid')){
            if(((int)$m->pcount)>0){
               $m->pcount=(int)$m->pcount-1;
            }
            
           
            
           }else{
              $m->ecount=(int)$m->ecount+1;
           }
        
            
         
          
        }else{
           $m=new pendinglist();
            $m->pcount=0;
            $m->ecount=1;
        }
        $m->aid=session()->get('SUPERVISOR_ADMIN_ID');
        $m->pportalid=$portal;
        $m->pprofile=$b[1];
        $m->save();


        if($request->has('pid')){
          $pid=pendingtimetable::find($request->post('pid'));
         $pid->delete();

        }

        $request->session()->flash('success','Reschedule Done Successfully');
        return redirect('supervisor/approve/leave');
    }
}