<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\periodforportal;
use App\Models\periodforclass;
use App\Models\periodforsubject;
use Redirect,Response;

class lmsperiodcontroller extends Controller{

    public function portal(Request $request){
        $a=DB::table('classtypes')->get();
        $aid=session()->get('ADMIN_ID');
        $result['regularportal']=DB::table('periodforportals')
                            ->join('portals','portals.id','periodforportals.pid')
                            ->where('periodforportals.pclasstypeid',$a[0]->id)
                            ->where('periodforportals.aid',$aid)
                            ->select('portals.portaltype','periodforportals.*')
                            ->get();
        $result['extraportal']=DB::table('periodforportals')
                            ->join('portals','portals.id','periodforportals.pid')
                            ->where('periodforportals.pclasstypeid',$a[1]->id)
                            ->where('periodforportals.aid',$aid)
                            ->select('portals.portaltype','periodforportals.*')
                            ->get();
        return view('admin.defineperiodsportal',$result);
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
            $a=DB::table('categories')->where('id',$arr['0']->cclassid)->get();
            $result['cmax']=$a[0]->cmaxperiod;
            $result['cmonopt']=$arr['0']->cmonopt;
            $result['ctuesopt']=$arr['0']->ctuesopt;
            $result['cwednesopt']=$arr['0']->cwednesopt;
            $result['cthursopt']=$arr['0']->cthursopt;
            $result['cfriopt']=$arr['0']->cfriopt;
            $result['csaturopt']=$arr['0']->csaturopt;
            $result['ctotalperiodsopt']=$arr['0']->ctotalperiodsopt;
        }
        else{
            $result['id']='';
            $result['cclasstypeid']='';
            $result['cclassid']='';
            $result['cmon']='';
            $result['cmax']=0;
            $result['ctues']='';
            $result['cwednes']='';
            $result['cthurs']='';
            $result['cfri']='';
            $result['csatur']='';
            $result['ctotalperiods']='';
            $result['cmonopt']='';
            $result['ctuesopt']='';
            $result['cwednesopt']='';
            $result['cthursopt']='';
            $result['cfriopt']='';
            $result['csaturopt']='';
            $result['ctotalperiodsopt']='';
        }
        $aid=session()->get('ADMIN_ID');
        $result['class']=DB::table('categories')->where('aid',$aid)->get();
        $result['classtypes']=DB::table('classtypes')->get();
        $result['periodnumbers']=DB::table('periodnumbers')->get();
        return view("admin.defineperiodsclassedit",$result);
    }

    public function getmax(){
          $id = $_GET['id'];
         $res = DB::table('categories')
        ->where('categories.id', $id)
        ->get();
        return Response::json($res);
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

        $model->cmonopt=$request->post('cmonopt');   
        $model->ctuesopt=$request->post('ctuesopt');   
        $model->cwednesopt=$request->post('cwednesopt');   
        $model->cthursopt=$request->post('cthursopt');   
        $model->cfriopt=$request->post('cfriopt');   
        $model->csaturopt=$request->post('csaturopt');
        $countopt=$request->post('cmonopt')+$request->post('ctuesopt')+$request->post('cwednesopt')+$request->post('cthursopt')+$request->post('cfriopt')+$request->post('csaturopt');   
        $model->ctotalperiodsopt=$countopt;          
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