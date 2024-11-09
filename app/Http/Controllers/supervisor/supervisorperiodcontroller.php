<?php

namespace App\Http\Controllers\supervisor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\periodforportal;
use App\Models\periodforclass;
use App\Models\periodforsubject;
use App\Models\periodtimetable;
use Redirect,Response;

class supervisorperiodcontroller extends Controller{

    public function portallist(Request $request){
        $result['portal']=DB::table('portals')->get();
        return view('supervisor.portallist',$result);
    }

    public function portalmemberlist(Request $request,$portalid){
        $a=DB::table('classtypes')->get();
        $supid=session()->get('SUPERVISOR_ID');
        $aid=session()->get('SUPERVISOR_ADMIN_ID');
        $result['portals']=DB::table('portals')->get();
            if($portalid=="1"){
                $result['regularportalmember']=DB::table('periodforportals')
                            ->join('supervisors','periodforportals.pid','supervisors.supportalid')
                            ->where('periodforportals.pclasstypeid',1)
                            ->where('periodforportals.aid',$aid)
                            ->where('periodforportals.pid',1)  // 1 means supervisor 
                            ->where('supervisors.id',$supid)
                            ->select('periodforportals.ptotalperiods','supervisors.*')
                            ->get();
                $result['extraportalmember']=DB::table('periodforportals')
                            ->join('supervisors','periodforportals.pid','supervisors.supportalid')
                            ->where('periodforportals.pclasstypeid',2)
                            ->where('periodforportals.aid',$aid)
                            ->where('periodforportals.pid',1)  // 1 means supervisor 
                            ->where('supervisors.id',$supid)
                            ->select('periodforportals.ptotalperiods','supervisors.*')
                            ->get();
            }
            elseif($portalid==2){
                $result['regularportalmember']=DB::table('periodforportals')
                            ->join('managers','periodforportals.pid','managers.mportalid')
                            ->where('periodforportals.pclasstypeid',1)
                            ->where('periodforportals.aid',$aid)
                            ->where('periodforportals.pid',2)  // 2 means manager 
                            ->where('managers.supid',$supid)
                            ->select('periodforportals.ptotalperiods','managers.*')
                            ->get();
                $result['extraportalmember']=DB::table('periodforportals')
                            ->join('managers','periodforportals.pid','managers.mportalid')
                            ->where('periodforportals.pclasstypeid',2)
                            ->where('periodforportals.aid',$aid)
                            ->where('periodforportals.pid',2)  // 2 means manager 
                            ->where('managers.supid',$supid)
                            ->select('periodforportals.ptotalperiods','managers.*')
                            ->get();
            }
            elseif($portalid==3){
                $result['regularportalmember']=DB::table('periodforportals')
                            ->join('faculties','periodforportals.pid','faculties.fportalid')
                            ->where('periodforportals.pclasstypeid',1)
                            ->where('periodforportals.aid',$aid)
                            ->where('periodforportals.pid',3)  // 3 means classteacher 
                            ->where('faculties.fsupid',$supid)
                            ->where('faculties.classteacher',1)
                            ->select('periodforportals.ptotalperiods','faculties.*')
                            ->get();
                $result['extraportalmember']=DB::table('periodforportals')
                            ->join('faculties','periodforportals.pid','faculties.fportalid')
                            ->where('periodforportals.pclasstypeid',2)
                            ->where('periodforportals.aid',$aid)
                            ->where('periodforportals.pid',3)  // 3 means classteacher 
                            ->where('faculties.fsupid',$supid)
                            ->where('faculties.classteacher',1)
                            ->select('periodforportals.ptotalperiods','faculties.*')
                            ->get();
            }
            elseif($portalid==4){
                $result['regularportalmember']=DB::table('periodforportals')
                            ->join('faculties','periodforportals.pid','faculties.fportalid')
                            ->where('periodforportals.pclasstypeid',1)
                            ->where('periodforportals.aid',$aid)
                            ->where('periodforportals.pid',4)  // 4 means faculty 
                            ->where('faculties.fsupid',$supid)
                            ->where('faculties.classteacher',2)
                            ->select('periodforportals.ptotalperiods','faculties.*')
                            ->get();
                $result['extraportalmember']=DB::table('periodforportals')
                            ->join('faculties','periodforportals.pid','faculties.fportalid')
                            ->where('periodforportals.pclasstypeid',2)
                            ->where('periodforportals.aid',$aid)
                            ->where('periodforportals.pid',4)  // 4 means faculty 
                            ->where('faculties.fsupid',$supid)
                            ->where('faculties.classteacher',2)
                            ->select('periodforportals.ptotalperiods','faculties.*')
                            ->get();
            }
        $result['portalid']=$portalid;
        return view('supervisor.portalmemberlist',$result);
    }
    
    public function viewsubject(Request $request,$typeid,$portalid,$profileid){
        $a=DB::table('classtypes')->get();
        $aid=session()->get('SUPERVISOR_ADMIN_ID');
        if($portalid==1){
            $d=DB::table('supervisors')->where(['id'=>$profileid])->get();
            $subjectid=explode("##",$d[0]->ssubjectid);
            $result['subject']=DB::table('domains')->whereIn('id',$subjectid)->get();
            $result['supervisorsubject']=DB::table('periodforportals')
                            ->join('portals','portals.id','periodforportals.pid')
                            ->join('supervisors','portals.id','supervisors.supportalid')
                            ->where('periodforportals.pclasstypeid',$typeid)
                            ->where('periodforportals.aid',$aid)
                            ->where('portals.id',1)  // 1 means supervisor 
                            ->where('supervisors.id',$profileid)
                            ->select('portals.portaltype','periodforportals.pid','periodforportals.ptotalperiods','supervisors.*')
                            ->get();
        }
        elseif($portalid==2){
            $d=DB::table('managers')->where(['id'=>$profileid])->get();
            $subjectid=explode("##",$d[0]->msubjectid);
            $result['subject']=DB::table('domains')->whereIn('id',$subjectid)->get();
            $result['managersubject']=DB::table('periodforportals')
                            ->join('portals','portals.id','periodforportals.pid')
                            ->join('managers','portals.id','managers.mportalid')
                            ->where('periodforportals.pclasstypeid',$typeid)
                            ->where('periodforportals.aid',$aid)
                            ->where('portals.id',2)  // 2 means manager 
                            ->where('managers.id',$profileid)
                            ->select('portals.portaltype','periodforportals.pid','periodforportals.ptotalperiods','managers.*')
                            ->get();
        }
        elseif($portalid==3){
            $d=DB::table('faculties')->where(['id'=>$profileid])->get();
            $subjectid=explode("##",$d[0]->subjectid);
            $result['subject']=DB::table('domains')->whereIn('id',$subjectid)->get();
            $result['classteachersubject']=DB::table('periodforportals')
                            ->join('portals','portals.id','periodforportals.pid')
                            ->join('faculties','portals.id','faculties.fportalid')
                            ->where('periodforportals.pclasstypeid',$typeid)
                            ->where('periodforportals.aid',$aid)
                            ->where('portals.id',3)  // 3 means classteacher 
                            ->where('faculties.id',$profileid)
                            ->where('faculties.classteacher',1)
                            ->select('portals.portaltype','periodforportals.pid','periodforportals.ptotalperiods','faculties.*')
                            ->get();
        }
        elseif($portalid==4){
            $d=DB::table('faculties')->where(['id'=>$profileid])->get();
            $subjectid=explode("##",$d[0]->subjectid);
            $result['subject']=DB::table('domains')->whereIn('id',$subjectid)->get();
            $result['facultysubject']=DB::table('periodforportals')
                            ->join('portals','portals.id','periodforportals.pid')
                            ->join('faculties','portals.id','faculties.fportalid')
                            ->where('periodforportals.pclasstypeid',$typeid)
                            ->where('periodforportals.aid',$aid)
                            ->where('portals.id',3)  // 3 means classteacher 
                            ->where('faculties.id',$profileid)
                            ->where('faculties.classteacher',2)
                            ->select('portals.portaltype','periodforportals.pid','periodforportals.ptotalperiods','faculties.*')
                            ->get();
        }
        $result['typeid']=$typeid;
        $result['portalid']=$portalid;
        $result['profileid']=$profileid;
        return view('supervisor.portaldetailsubjectlist',$result);
    }

    public function assignsubject(Request $request,$typeid,$portalid,$profileid,$subjectid){
        $aid=session()->get('SUPERVISOR_ADMIN_ID');

        $result['subject']=DB::table('domains')->where('id',$subjectid)->get();
        $result['class']=DB::table('categories')->where('id',$result['subject'][0]->category)->get();
        $result['section']=DB::table('lmssections')->where('classid',$result['subject'][0]->category)->get();

        $result['portal']=DB::table('periodforportals')->where('pclasstypeid',$typeid)->where('pid',$portalid)->get();
        $result['available']=DB::table('periodforsubjects')->where('sclasstypeid',$typeid)->where('ssubjectid',$subjectid)->get();
        $result['periods']=DB::table('periodnumbers')->get();

        $result['typeid']=$typeid;
        $result['portalid']=$portalid;
        $result['profileid']=$profileid;
        $result['subjectid']=$subjectid;
        return view('supervisor.portaldetaillistedit',$result);
    }


    public function savetimetable(Request $request){
        if($request->post('monday')=="1"){
            $model=new periodtimetable();
            $model->aid=session()->get('SUPERVISOR_ADMIN_ID');
            $model->supid=session()->get('SUPERVISOR_ID');
            $model->tclasstypeid=$request->post('typeid');
            $model->tportalid=$request->post('portalid'); 
            $model->tprofileid=$request->post('profileid'); 
            $model->tsubjectid=$request->post('subjectid');
            $model->tdayid=$request->post('monday');
            $model->tclassid=$request->post('mondayclass'); 
            $model->tsectionid=$request->post('mondaysection'); 
            $model->tperiodid=$request->post('mondayperiod'); 
            $model->save();
        }
        if($request->post('tuesday')=="2"){
            $model=new periodtimetable();
            $model->aid=session()->get('SUPERVISOR_ADMIN_ID');
            $model->supid=session()->get('SUPERVISOR_ID');
            $model->tclasstypeid=$request->post('typeid');
            $model->tportalid=$request->post('portalid'); 
            $model->tprofileid=$request->post('profileid'); 
            $model->tsubjectid=$request->post('subjectid');
            $model->tdayid=$request->post('tuesday');
            $model->tclassid=$request->post('tuesdayclass'); 
            $model->tsectionid=$request->post('tuesdaysection'); 
            $model->tperiodid=$request->post('tuesdayperiod'); 
            $model->save();
        }
        if($request->post('wednesday')=="3"){
            $model=new periodtimetable();
            $model->aid=session()->get('SUPERVISOR_ADMIN_ID');
            $model->supid=session()->get('SUPERVISOR_ID');
            $model->tclasstypeid=$request->post('typeid');
            $model->tportalid=$request->post('portalid'); 
            $model->tprofileid=$request->post('profileid'); 
            $model->tsubjectid=$request->post('subjectid');
            $model->tdayid=$request->post('wednesday');
            $model->tclassid=$request->post('wednesdayclass'); 
            $model->tsectionid=$request->post('wednesdaysection'); 
            $model->tperiodid=$request->post('wednesdayperiod'); 
            $model->save();
        }
        if($request->post('thursday')=="4"){
            $model=new periodtimetable();
            $model->aid=session()->get('SUPERVISOR_ADMIN_ID');
            $model->supid=session()->get('SUPERVISOR_ID');
            $model->tclasstypeid=$request->post('typeid');
            $model->tportalid=$request->post('portalid'); 
            $model->tprofileid=$request->post('profileid'); 
            $model->tsubjectid=$request->post('subjectid');
            $model->tdayid=$request->post('thursday');
            $model->tclassid=$request->post('thursdayclass'); 
            $model->tsectionid=$request->post('thursdaysection'); 
            $model->tperiodid=$request->post('thursdayperiod');
            $model->save(); 
        }
        if($request->post('friday')=="5"){
            $model=new periodtimetable();
            $model->aid=session()->get('SUPERVISOR_ADMIN_ID');
            $model->supid=session()->get('SUPERVISOR_ID');
            $model->tclasstypeid=$request->post('typeid');
            $model->tportalid=$request->post('portalid'); 
            $model->tprofileid=$request->post('profileid'); 
            $model->tsubjectid=$request->post('subjectid');
            $model->tdayid=$request->post('friday');
            $model->tclassid=$request->post('fridayclass'); 
            $model->tsectionid=$request->post('fridaysection'); 
            $model->tperiodid=$request->post('fridayperiod'); 
            $model->save();
        }
        if($request->post('saturday')=="6"){
            $model=new periodtimetable();
            $model->aid=session()->get('SUPERVISOR_ADMIN_ID');
            $model->supid=session()->get('SUPERVISOR_ID');
            $model->tclasstypeid=$request->post('typeid');
            $model->tportalid=$request->post('portalid'); 
            $model->tprofileid=$request->post('profileid'); 
            $model->tsubjectid=$request->post('subjectid');
            $model->tdayid=$request->post('saturday');
            $model->tclassid=$request->post('saturdayclass'); 
            $model->tsectionid=$request->post('saturdaysection'); 
            $model->tperiodid=$request->post('saturdayperiod');
            $model->save(); 
        }      
        $request->session()->flash('success','Inserted Successfully');
        return redirect('supervisor/portal/list');
    }

    public function addportal(Request $request,$id=""){
        if($id>0){
            $arr=periodforportal::where(['id'=>$id])->get();
            $result['id']=$arr['0']->id;
            $result['pclasstypeid']=$arr['0']->pclasstypeid;
            $result['pid']=$arr['0']->pid;
            $result['pmon']=$arr['0']->pmon;
            $result['ptues']=$arr['0']->ptues;
            $result['pwednes']=$arr['0']->pwednes;
            $result['pthurs']=$arr['0']->pthurs;
            $result['pfri']=$arr['0']->pfri;
            $result['psatur']=$arr['0']->psatur;
            $result['ptotalperiods']=$arr['0']->ptotalperiods;
        }
        else{
            $result['id']='';
            $result['pclasstypeid']='';
            $result['pid']='';
            $result['pmon']='';
            $result['ptues']='';
            $result['pwednes']='';
            $result['pthurs']='';
            $result['pfri']='';
            $result['psatur']='';
            $result['ptotalperiods']='';
        }
        $result['portals']=DB::table('portals')->get();
        $result['classtypes']=DB::table('classtypes')->get();
        $result['periodnumbers']=DB::table('periodnumbers')->get();
        return view("admin.defineperiodsportaledit",$result);
    }
     
    public function saveportal(Request $request){
        if($request->post('id')>0){
            $model=periodforportal::find($request->post('id'));
            $msg="Portal Updated Successfully";
        }
        else{
            $model=new periodforportal();
            $msg="Portal Inserted Successfully";
        }
        $model->aid=session()->get('ADMIN_ID');
        $model->pclasstypeid=$request->post('pclasstypeid');
        $model->pid=$request->post('pid');   
        $model->pmon=$request->post('pmon');   
        $model->ptues=$request->post('ptues');   
        $model->pwednes=$request->post('pwednes');   
        $model->pthurs=$request->post('pthurs');   
        $model->pfri=$request->post('pfri');   
        $model->psatur=$request->post('psatur');
        $count=$request->post('pmon')+$request->post('ptues')+$request->post('pwednes')+$request->post('pthurs')+$request->post('pfri')+$request->post('psatur');   
        $model->ptotalperiods=$count;      
        $model->save();
        $request->session()->flash('success',$msg);
        return redirect('admin/periods/portal');
    }

    public function class(Request $request){
        $a=DB::table('classtypes')->get();
        $aid=session()->get('ADMIN_ID');
        $result['regularclass']=DB::table('periodforclasses')
                            ->join('categories','categories.id','periodforclasses.cclassid')
                            ->where('periodforclasses.cclasstypeid',$a[0]->id)
                            ->where('periodforclasses.aid',$aid)
                            ->select('categories.categories','periodforclasses.*')
                            ->get();
        $result['extraclass']=DB::table('periodforclasses')
                            ->join('categories','categories.id','periodforclasses.cclassid')
                            ->where('periodforclasses.cclasstypeid',$a[1]->id)
                            ->where('periodforclasses.aid',$aid)
                            ->select('categories.categories','periodforclasses.*')
                            ->get();
        return view('admin.defineperiodsclass',$result);
    }

    public function addclass(Request $request,$id=""){
        if($id>0){
            $arr=periodforclass::where(['id'=>$id])->get();
            $result['id']=$arr['0']->id;
            $result['cclasstypeid']=$arr['0']->cclasstypeid;
            $result['cclassid']=$arr['0']->cclassid;
            $result['cmon']=$arr['0']->cmon;
            $result['ctues']=$arr['0']->ctues;
            $result['cwednes']=$arr['0']->cwednes;
            $result['cthurs']=$arr['0']->cthurs;
            $result['cfri']=$arr['0']->cfri;
            $result['csatur']=$arr['0']->csatur;
            $result['ctotalperiods']=$arr['0']->ctotalperiods;
        }
        else{
            $result['id']='';
            $result['cclasstypeid']='';
            $result['cclassid']='';
            $result['cmon']='';
            $result['ctues']='';
            $result['cwednes']='';
            $result['cthurs']='';
            $result['cfri']='';
            $result['csatur']='';
            $result['ctotalperiods']='';
        }
        $aid=session()->get('ADMIN_ID');
        $result['class']=DB::table('categories')->where('aid',$aid)->get();
        $result['classtypes']=DB::table('classtypes')->get();
        $result['periodnumbers']=DB::table('periodnumbers')->get();
        return view("admin.defineperiodsclassedit",$result);
    }
     
    public function saveclass(Request $request){
        if($request->post('id')>0){
            $model=periodforclass::find($request->post('id'));
            $msg="Class Updated Successfully";
        }
        else{
            $model=new periodforclass();
            $msg="Class Inserted Successfully";
        }
        $model->aid=session()->get('ADMIN_ID');
        $model->cclasstypeid=$request->post('cclasstypeid');
        $model->cclassid=$request->post('cclassid');   
        $model->cmon=$request->post('cmon');   
        $model->ctues=$request->post('ctues');   
        $model->cwednes=$request->post('cwednes');   
        $model->cthurs=$request->post('cthurs');   
        $model->cfri=$request->post('cfri');   
        $model->csatur=$request->post('csatur');
        $count=$request->post('cmon')+$request->post('ctues')+$request->post('cwednes')+$request->post('cthurs')+$request->post('cfri')+$request->post('csatur');   
        $model->ctotalperiods=$count;      
        $model->save();
        $request->session()->flash('success',$msg);
        return redirect('admin/periods/class');
    }


    public function subject(Request $request){
        $a=DB::table('classtypes')->get();
        $aid=session()->get('ADMIN_ID');
        $result['regularsubject']=DB::table('periodforsubjects')
                            ->join('categories','categories.id','periodforsubjects.sclassid')
                            ->join('domains','domains.id','periodforsubjects.ssubjectid')
                            ->where('periodforsubjects.sclasstypeid',$a[0]->id)
                            ->where('periodforsubjects.aid',$aid)
                            ->select('categories.categories','domains.domain','periodforsubjects.*')
                            ->get();
        $result['extrasubject']=DB::table('periodforsubjects')
                            ->join('categories','categories.id','periodforsubjects.sclassid')
                            ->join('domains','domains.id','periodforsubjects.ssubjectid')
                            ->where('periodforsubjects.sclasstypeid',$a[1]->id)
                            ->where('periodforsubjects.aid',$aid)
                            ->select('categories.categories','domains.domain','periodforsubjects.*')
                            ->get();
        return view('admin.defineperiodssubject',$result);
    }

    public function addsubject(Request $request,$id=""){
        if($id>0){
            $arr=periodforsubject::where(['id'=>$id])->get();
            $result['id']=$arr['0']->id;
            $result['sclasstypeid']=$arr['0']->sclasstypeid;
            $result['sclassid']=$arr['0']->sclassid;
            $result['ssubjectid']=$arr['0']->ssubjectid;
            $result['smon']=$arr['0']->smon;
            $result['stues']=$arr['0']->stues;
            $result['swednes']=$arr['0']->swednes;
            $result['sthurs']=$arr['0']->sthurs;
            $result['sfri']=$arr['0']->sfri;
            $result['ssatur']=$arr['0']->ssatur;
            $result['stotalperiods']=$arr['0']->stotalperiods;
        }
        else{
            $result['id']='';
            $result['sclasstypeid']='';
            $result['sclassid']='';
            $result['ssubjectid']='';
            $result['smon']='';
            $result['stues']='';
            $result['swednes']='';
            $result['sthurs']='';
            $result['sfri']='';
            $result['ssatur']='';
            $result['stotalperiods']='';
        }
        $aid=session()->get('ADMIN_ID');
        $result['class']=DB::table('categories')->where('aid',$aid)->get();
        $result['classtypes']=DB::table('classtypes')->get();
        $result['subjectavailabilitytypes']=DB::table('subjectavailabilitytypes')->get();
        return view("admin.defineperiodssubjectedit",$result);
    }
     
    public function savesubject(Request $request){
        if($request->post('id')>0){
            $model=periodforsubject::find($request->post('id'));
            $msg="Subject Updated Successfully";
        }
        else{
            $model=new periodforsubject();
            $msg="Subject Inserted Successfully";
        }
        $model->aid=session()->get('ADMIN_ID');
        $model->sclasstypeid=$request->post('sclasstypeid');
        $model->sclassid=$request->post('sclassid'); 
        $model->ssubjectid=$request->post('ssubjectid');   
        $model->smon=$request->post('smon');   
        $model->stues=$request->post('stues');   
        $model->swednes=$request->post('swednes');   
        $model->sthurs=$request->post('sthurs');   
        $model->sfri=$request->post('sfri');   
        $model->ssatur=$request->post('ssatur');
        $count=0;
        if($request->post('smon')=="1"){
        $count++;
        }if($request->post('stues')=="1"){
        $count++;
        }if($request->post('swednes')=="1"){
        $count++;
        }if($request->post('sthurs')=="1"){
        $count++;
        }if($request->post('sfri')=="1"){
        $count++;
        }if($request->post('ssatur')=="1"){
        $count++;
        }   
        $model->stotalperiods=$count;      
        $model->save();
        $request->session()->flash('success',$msg);
        return redirect('admin/periods/subject');
    }

    public function getsubject($id){
        $id = $_GET['myID'];
        $res = DB::table('domains')->where('category',$id)->get();
        return Response::json($res);
    }
}