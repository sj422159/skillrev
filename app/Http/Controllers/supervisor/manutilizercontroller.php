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

class manutilizercontroller extends Controller
{
     public function manschedule($id){
       $id=session()->get('SUPERVISOR_ID');
        $supdata=DB::table('supervisors')->where('id',$id)->get();
          $aid=session()->get('SUPERVISOR_ADMIN_ID'); 
        $result['days']=["1"=>"Monday","2"=>"Tuesday","3"=>"Wednesday","4"=>"Thursday","5"=>"Friday","6"=>"Saturday"];
        $d=DB::table('managers')->where('id',$id)->get();
        $sub=$d[0]->msubjectid;
        $sub=explode("##",$sub);
        $result['name']=$d[0]->mname;
        $result['id']=$d[0]->id;
        $result['role']="MANAGER";
        $result['classtypes']=DB::table('classtypes')->get();
        $result['subject']=DB::table('domains')->whereIn('id',$sub)->get();
       $result['class']= DB::table('categories')->where('groupid',$supdata[0]->groupid)->get();
        $result['cl']="";
        $result['day']="";
        $result['type']="";
        $result['peri']=0;
        $result['subii']=0;
        $result['modi']="";
        $result['rowid']=0;
        $result['sec']="";
       return view('supervisor.manscheduleform',$result);
    }

     public function getperiod(){
         $day = $_GET['val'];
         $cl=$_GET['cl'];
         $id=$_GET['id'];
         $sec=$_GET['sec'];
         $need="";
         $scheck="";
         if($day=="Monday"){
            $need="cmon";
            $scheck="pmon";
            $opt="cmonopt";
         }else if($day=="Tuesday"){
            $need="ctues";
            $scheck="ptues";
            $opt="ctuesopt";
         }else if($day=="Wednesday"){
            $need="cwednes";
            $scheck="pwednes";
            $opt="cwednesopt";
         }else if($day=="Thursday"){
            $need="cthurs";
             $scheck="pthurs";
             $opt="cthursopt";
         }else if($day=="Friday"){
            $need="cfri";
             $scheck="pfri";
             $opt="cfriopt";
         }else if($day=="Saturday"){
            $need="csatur";
             $scheck="psatur";
             $opt="csaturopt";
         }
         
         $check=DB::table('periodtimetables')->where('tclassid',$cl)
                                ->where('tclasstypeid',1)
                                ->where('tsectionid',$sec)->where('tdayid',$day)->get();
        $pcheck=DB::table('periodforportals')->where('pid',2)->get($scheck);
         $optcount=DB::table('periodforclasses')->where('cclassid',$cl)->get($opt);
        $che=DB::table('periodtimetables')->where('tdayid',$day)->where('tportalid','MANAGER')->where('tprofileid',$id)->get();
        $checking=[];
         $optcheck=DB::table('periodtimetables')->where('tclassid',$cl)->where('tdayid',$day)->where('tsubjecttype',2)->get();
        $totclass=DB::table('categories')->where('id',$cl)->get();
        for($i=0;$i<count($check);$i++){
          $checking[$i]=$check[$i]->tperiodid;
        }
        $cv=count($check);
        for($i=0;$i<count($che);$i++){
         $checking[$cv]=$che[$i]->tperiodid;
         $cv++;
        }

          for($i=0;$i<count($optcheck);$i++){
         $checking[$cv]=$optcheck[$i]->tperiodid;
         $cv++;
        }

         $res = DB::table('periodforclasses')->where('cclassid',$cl)->where('cclasstypeid',1)->get($need);
         $result=[];
          $result[0]=$res[0]->$need;
         $result[1]=$checking;
         $result[2]=0;
         $result[3]=count($check);
          $result[4]=$totclass[0]->cmaxperiod;

        if(count($che)>=$pcheck[0]->$scheck){
          $result[2]=1;
        }
        if(count($optcheck)<$optcount[0]->$opt){
         $result[2]=2;
        }
        

        return Response::json($result);
    }
    public function getsubject(){
        $day = $_GET['val'];
         $cl=$_GET['cl'];
         $id=$_GET['id'];
         $need="";
         $scheck=""; 
         if($day=="Monday"){
            $need="cmon";
            $scheck="smon";
         }else if($day=="Tuesday"){
            $need="ctues";
            $scheck="stues";
         }else if($day=="Wednesday"){
            $need="cwednes";
            $scheck="swednes";
         }else if($day=="Thursday"){
            $need="cthurs";
             $scheck="sthurs";
         }else if($day=="Friday"){
            $need="cfri";
             $scheck="sfri";
         }else if($day=="Saturday"){
            $need="csatur";
             $scheck="ssatur";
         }

         
         $s=DB::table('managers')->where('id',$id)->get();
         $sub=explode("##",$s[0]->msubjectid);
         
      
         $result=DB::table('domains')->whereIn('id',$sub)->where('category',$cl)->get();
          return Response::json($result);
    }

     public function getmodule(){
        $day = $_GET['sub'];
        $day=explode("//",$day);
         $cl=$_GET['cl'];
         $id=$_GET['id'];  
         $s=DB::table('managers')->where('id',$id)->get();
         $mods=explode("##",$s[0]->mmoduleid);
         $res=DB::table('skillsets')->whereIn('domain',$day)->get();
          $result=[];
          $c=0;
          for($i=0;$i<count($res);$i++){
           if(in_array($res[$i]->id, $mods)){
            $result[$c]=$res[$i];
            $c++;
           }
          }
          return Response::json($result);
    }

    public function schedule(request $request){
     
      $supid=session()->get('SUPERVISOR_ID');
      $d=DB::table('supervisors')->where('id',$supid)->get();
      if($request->post('rowid')>0){
        $model=periodtimetable::find($request->post('rowid'));
      }else{
        $model=new periodtimetable();
      }
      
      $model->aid=$d[0]->aid;
      $model->supid=$supid;
      $model->tclasstypeid=$request->post('type');
      $model->tportalid=$request->post('role');
      $model->tprofileid=$request->post('id');
      $model->tsubjectid=$request->post('Subject');
      $model->tmoduleid=implode("***",$request->post('module'));
      $model->tdayid=$request->post('day');
      $model->tclassid=$request->post('class');
      $model->tsectionid=$request->post('section');
      $model->tperiodid=$request->post('Period');
      $model->save();

      return redirect("supervisor/utilization");
    }


    public function schedulelist($stype,$id,$day=''){
      $result['role']="MANAGER";
       $d=DB::table('managers')->where('id',$id)->get();
       $result['Name']=$d[0]->mname;
       $result['id']=$id;
       if($day=='0'){
         if($stype==1){
         $result['data']=DB::table('periodtimetables')
                                       ->join('categories','periodtimetables.tclassid','categories.id')
                                       ->join('lmssections','periodtimetables.tsectionid','lmssections.id')
                                       ->join('domains','periodtimetables.tsubjectid','domains.id')
                                       ->where("tportalid","MANAGER")->where('tclasstypeid',1)
                                       ->where('tprofileid',$id)
                                       ->select('periodtimetables.*','categories.categories','lmssections.section','domains.domain')->get();
           }else{
                    $result['data']=DB::table('periodtimetables')
                                       ->join('categories','periodtimetables.tclassid','categories.id')
                                       ->join('domains','periodtimetables.tsubjectid','domains.id')
                                       ->where("tportalid","MANAGER")->where('tclasstypeid',1)
                                       ->where('tprofileid',$id)
                                       ->select('periodtimetables.*','categories.categories','domains.domain')->get();
           }
       }else{
         if($stype==1){
        $result['data']=DB::table('periodtimetables')
                                       ->join('categories','periodtimetables.tclassid','categories.id')
                                       ->join('lmssections','periodtimetables.tsectionid','lmssections.id')
                                       ->join('domains','periodtimetables.tsubjectid','domains.id')
                                       ->where("tportalid","MANAGER")->where('tclasstypeid',1)
                                       ->where('tdayid',$day)
                                       ->where('tprofileid',$id)
                                       ->select('periodtimetables.*','categories.categories','lmssections.section','domains.domain')->get();
            }else{
               $result['data']=DB::table('periodtimetables')
                                       ->join('categories','periodtimetables.tclassid','categories.id')
                                       ->join('domains','periodtimetables.tsubjectid','domains.id')
                                       ->where("tportalid","MANAGER")->where('tclasstypeid',1)
                                       ->where('tdayid',$day)
                                       ->where('tprofileid',$id)
                                       ->select('periodtimetables.*','categories.categories','domains.domain')->get(); 
            }

       }
       $result['stype']=$stype;
       
      return view("supervisor.schedulelist",$result);


    }

     public function edit($id){
        $aid=session()->get('SUPERVISOR_ADMIN_ID'); 
        $data=DB::table('periodtimetables')->where('id',$id)->get();
        $result['rowid']=$data[0]->id;
        $result['day']=$data[0]->tdayid;
        $result['type']=$data[0]->tclasstypeid;
        $result['peri']=$data[0]->tperiodid;
        $result['days']=["1"=>"Monday","2"=>"Tuesday","3"=>"Wednesday","4"=>"Thursday","5"=>"Friday","6"=>"Saturday"];
        $d=DB::table('managers')->where('id',$data[0]->tprofileid)->get();
        $sub=$d[0]->msubjectid;
        $sub=explode("##",$sub);
        $result['name']=$d[0]->mname;
        $result['id']=$d[0]->id;
        $result['role']="MANAGER";
        $result['classtypes']=DB::table('classtypes')->get();
        $result['class']= DB::table('categories')->where('aid',$aid)->get();
        $result['cl']=$data[0]->tclassid;
        $result['sections']=DB::table('lmssections')->where('classid',$d[0]->classid)->get();
        $result['sec']=$data[0]->tsectionid;
        $result['subii']=$data[0]->tsubjectid;
        $result['modi']=explode("***",$data[0]->tmoduleid);
       return view('supervisor.manscheduleform',$result);
    }
    

     public function delete($lid,$id){
      $model=periodtimetable::find($lid);
      $model->delete();
      return redirect("groupmanager/manager/list/".$id."/0");
    }




}
