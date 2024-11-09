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

class suputilizationcontroller extends Controller
{
    public function index(request $request){
       $supid=session()->get('SUPERVISOR_ID');
       $d=DB::table('supervisors')->where('id',$supid)->get();
       $type=$d[0]->supsubjecttype;
       
      $class=DB::table('categories')->where('groupid',$d[0]->groupid)->get();
       $cl=[];
       for($i=0;$i<count($class);$i++){
         $cl[$i]=$class[$i]->id;
       }
      $result['type']=$type;
      $result['faculties']=DB::table('faculties')->where('fsubjecttype',$type)->where('fsupid',$supid)->get();
      for($i=0;$i<count($result['faculties']);$i++){
         $m=DB::table('periodtimetables')->where('tdayid',"Monday")->where("tportalid","FACULTY")->where('tclasstypeid',1)->where('tprofileid',$result['faculties'][$i]->id)->get();
         $result['faculties'][$i]->monday=count($m);
          $t=DB::table('periodtimetables')->where('tdayid',"Tuesday")->where("tportalid","FACULTY")->where('tclasstypeid',1)->where('tprofileid',$result['faculties'][$i]->id)->get();
         $result['faculties'][$i]->tuesday=count($t);
          $w=DB::table('periodtimetables')->where('tdayid',"Wednesday")->where("tportalid","FACULTY")->where('tclasstypeid',1)->where('tprofileid',$result['faculties'][$i]->id)->get();
         $result['faculties'][$i]->wednesday=count($w);
          $th=DB::table('periodtimetables')->where('tdayid',"Thursday")->where("tportalid","FACULTY")->where('tclasstypeid',1)->where('tprofileid',$result['faculties'][$i]->id)->get();
         $result['faculties'][$i]->thursday=count($th);
          $f=DB::table('periodtimetables')->where('tdayid',"Friday")->where("tportalid","FACULTY")->where('tclasstypeid',1)->where('tprofileid',$result['faculties'][$i]->id)->get();
         $result['faculties'][$i]->friday=count($f);
          $s=DB::table('periodtimetables')->where('tdayid',"Saturday")->where("tportalid","FACULTY")->where('tclasstypeid',1)->where('tprofileid',$result['faculties'][$i]->id)->get();
         $result['faculties'][$i]->saturday=count($s);
      }
      $result['managers']=DB::table('managers')->whereIn('classid',$cl)->where('msubjecttype',$type)->get();
       for($i=0;$i<count($result['managers']);$i++){
         $m=DB::table('periodtimetables')->where('tdayid',"Monday")->where("tportalid","MANAGER")->where('tclasstypeid',1)->where('tprofileid',$result['managers'][$i]->id)->get();
         $result['managers'][$i]->monday=count($m);
          $t=DB::table('periodtimetables')->where('tdayid',"Tuesday")->where("tportalid","MANAGER")->where('tclasstypeid',1)->where('tprofileid',$result['managers'][$i]->id)->get();
         $result['managers'][$i]->tuesday=count($t);
          $w=DB::table('periodtimetables')->where('tdayid',"Wednesday")->where("tportalid","MANAGER")->where('tclasstypeid',1)->where('tprofileid',$result['managers'][$i]->id)->get();
         $result['managers'][$i]->wednesday=count($w);
          $th=DB::table('periodtimetables')->where('tdayid',"Thursday")->where("tportalid","MANAGER")->where('tclasstypeid',1)->where('tprofileid',$result['managers'][$i]->id)->get();
         $result['managers'][$i]->thursday=count($th);
          $f=DB::table('periodtimetables')->where('tdayid',"Friday")->where("tportalid","MANAGER")->where('tclasstypeid',1)->where('tprofileid',$result['managers'][$i]->id)->get();
         $result['managers'][$i]->friday=count($f);
          $s=DB::table('periodtimetables')->where('tdayid',"Saturday")->where("tportalid","MANAGER")->where('tclasstypeid',1)->where('tprofileid',$result['managers'][$i]->id)->get();
         $result['managers'][$i]->saturday=count($s);
      }
      $result['supervisors']=$d;
      for($i=0;$i<count($result['supervisors']);$i++){
         $m=DB::table('periodtimetables')->where('tdayid',"Monday")->where("tportalid","GROUPMANAGER")->where('tclasstypeid',1)->where('tprofileid',$result['supervisors'][$i]->id)->get();
         $result['supervisors'][$i]->monday=count($m);
          $t=DB::table('periodtimetables')->where('tdayid',"Tuesday")->where("tportalid","GROUPMANAGER")->where('tclasstypeid',1)->where('tprofileid',$result['supervisors'][$i]->id)->get();
         $result['supervisors'][$i]->tuesday=count($t);
          $w=DB::table('periodtimetables')->where('tdayid',"Wednesday")->where("tportalid","GROUPMANAGER")->where('tclasstypeid',1)->where('tprofileid',$result['supervisors'][$i]->id)->get();
         $result['supervisors'][$i]->wednesday=count($w);
          $th=DB::table('periodtimetables')->where('tdayid',"Thursday")->where("tportalid","GROUPMANAGER")->where('tclasstypeid',1)->where('tprofileid',$result['supervisors'][$i]->id)->get();
         $result['supervisors'][$i]->thursday=count($th);
          $f=DB::table('periodtimetables')->where('tdayid',"Friday")->where("tportalid","GROUPMANAGER")->where('tclasstypeid',1)->where('tprofileid',$result['supervisors'][$i]->id)->get();
         $result['supervisors'][$i]->friday=count($f);
          $s=DB::table('periodtimetables')->where('tdayid',"Saturday")->where("tportalid","GROUPMANAGER")->where('tclasstypeid',1)->where('tprofileid',$result['supervisors'][$i]->id)->get();
         $result['supervisors'][$i]->saturday=count($s);
      }
      return view('supervisor.utilization',$result);
    }

    public function scheduleindex(request $request){
        $supid=session()->get('SUPERVISOR_ID');
       $d=DB::table('supervisors')->where('id',$supid)->get();
       
      $class=DB::table('categories')->where('groupid',$d[0]->groupid)->get();
       $cl=[];
       for($i=0;$i<count($class);$i++){
         $cl[$i]=$class[$i]->id;
       }
     
      $result['faculties']=DB::table('faculties')->whereIn('classid',$cl)->get();
      $result['managers']=DB::table('managers')->whereIn('classid',$cl)->get();
      $result['supervisor']=$d;
      return view('supervisor.scheduleindex',$result); 
    }

    public function facschedule($id){
        $aid=session()->get('SUPERVISOR_ADMIN_ID'); 
        $result['days']=["1"=>"Monday","2"=>"Tuesday","3"=>"Wednesday","4"=>"Thursday","5"=>"Friday","6"=>"Saturday"];
        $d=DB::table('faculties')->where('id',$id)->get();
        $sub=$d[0]->subjectid;
        $sub=explode("##",$sub);
        $result['name']=$d[0]->fname;
        $result['id']=$d[0]->id;
        $result['role']="FACULTY";
        $result['classtypes']=DB::table('classtypes')->get();
        $result['subject']=DB::table('domains')->whereIn('id',$sub)->get();
        $result['class']= DB::table('categories')->where('aid',$aid)->get();
        $result['cl']="";
        $result['day']="";
        $result['type']="";
        $result['peri']=0;
        $result['subii']=0;
        $result['modi']="";
        $result['rowid']=0;
        $result['sections']=DB::table('lmssections')->where('classid',$d[0]->classid)->get();
        $result['sec']=$d[0]->sectionid;
       return view('supervisor.scheduleform',$result);
    }

    public function edit($id){
         $aid=session()->get('SUPERVISOR_ADMIN_ID'); 
        $data=DB::table('periodtimetables')->where('id',$id)->get();
        $result['rowid']=$data[0]->id;
        $result['day']=$data[0]->tdayid;
        $result['type']=$data[0]->tclasstypeid;
        $result['peri']=$data[0]->tperiodid;
        $result['days']=["1"=>"Monday","2"=>"Tuesday","3"=>"Wednesday","4"=>"Thursday","5"=>"Friday","6"=>"Saturday"];
        $d=DB::table('faculties')->where('id',$data[0]->tprofileid)->get();
        $sub=$d[0]->subjectid;
        $sub=explode("##",$sub);
        $result['name']=$d[0]->fname;
        $result['id']=$d[0]->id;
        $result['role']="FACULTY";
        $result['classtypes']=DB::table('classtypes')->get();
        $result['class']= DB::table('categories')->where('aid',$aid)->get();
        $result['cl']=$data[0]->tclassid;
        $result['sections']=DB::table('lmssections')->where('classid',$d[0]->classid)->get();
        $result['sec']=$data[0]->tsectionid;
        $result['subii']=$data[0]->tsubjectid;
        $result['modi']=explode("***",$data[0]->tmoduleid);
       return view('supervisor.scheduleform',$result);
    }

    public function getperiod(){
         $supid=session()->get('SUPERVISOR_ID');
       $d=DB::table('supervisors')->where('id',$supid)->get();
       $type=$d[0]->supsubjecttype;
       $required='';
         $day = $_GET['val'];
         $cl=$_GET['cl'];
         $id=$_GET['id'];
         $sec=$_GET['sec'];
         $need="";
         $scheck="";
         if($day=="Monday"){
            if($type==1){
             $need="cmon";
             $opt="cmonopt";
            }else{
             $need="cmonopt";
            }
            
            $scheck="pmon";
         }else if($day=="Tuesday"){
            if($type==1){
             $need="ctues";
            }else{
             $need="ctuesopt";
            }
            $scheck="ptues";
            $opt="ctuesopt";
         }else if($day=="Wednesday"){
            if($type==1){
             $need="cwednes";
            }else{
             $need="cwednesopt";
            }
            $scheck="pwednes";
            $opt="cwednesopt";
         }else if($day=="Thursday"){
             if($type==1){
             $need="cthurs";
            }else{
             $need="cthursopt";
            }
             $scheck="pthurs";
             $opt="cthursopt";
         }else if($day=="Friday"){
             if($type==1){
             $need="cfri";
            }else{
             $need="cfriopt";
            }
             $scheck="pfri";
             $opt="cfriopt";
         }else if($day=="Saturday"){
             if($type==1){
             $need="csatur";
            }else{
             $need="csaturopt";
            }
             $scheck="psatur";
             $opt="csaturopt";
         }
         
         $check=DB::table('periodtimetables')->where('tclassid',$cl)
                                ->where('tclasstypeid',1)
                                ->where('tsectionid',$sec)->where('tdayid',$day)->get();
        $pcheck=DB::table('periodforportals')->where('pid',4)->get($scheck);
        $optcount=DB::table('periodforclasses')->where('cclassid',$cl)->get($opt);

        $che=DB::table('periodtimetables')->where('tdayid',$day)->where('tportalid','FACULTY')->where('tprofileid',$id)->get();
          $optcheck=DB::table('periodtimetables')->where('tclassid',$cl)->where('tdayid',$day)->where('tsubjecttype',2)->get();
        
        $totclass=DB::table('categories')->where('id',$cl)->get();

        $checking=[];
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
        $result[4]=$totclass[0]->cmaxperiod;
         $result[3]=count($check);

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

         
         $s=DB::table('faculties')->where('id',$id)->get();
         $sub=explode("##",$s[0]->subjectid);
         
      
         $result=DB::table('domains')->whereIn('id',$sub)->get();
          return Response::json($result);
    }
     public function getmodule(){
        $day = $_GET['sub'];
        $day=explode("//",$day);
         $cl=$_GET['cl'];
         $id=$_GET['id'];  
         $s=DB::table('faculties')->where('id',$id)->get();
         $mods=explode("##",$s[0]->moduleid);
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
      $result['role']="FACULTY";
       $d=DB::table('faculties')->where('id',$id)->get();
       $result['Name']=$d[0]->fname;
       $result['id']=$id;
       if($day=='0'){
        if($stype==1){
         $result['data']=DB::table('periodtimetables')
                                       ->join('categories','periodtimetables.tclassid','categories.id')
                                       ->join('lmssections','periodtimetables.tsectionid','lmssections.id')
                                       ->join('domains','periodtimetables.tsubjectid','domains.id')
                                       ->where("tportalid","FACULTY")->where('tclasstypeid',1)
                                       ->where('tprofileid',$id)
                                       ->select('periodtimetables.*','categories.categories','lmssections.section','domains.domain')->get();
        }else{
            $result['data']=DB::table('periodtimetables')
                                       ->join('categories','periodtimetables.tclassid','categories.id')
                                       ->join('domains','periodtimetables.tsubjectid','domains.id')
                                       ->where("tportalid","FACULTY")->where('tclasstypeid',1)
                                       ->where('tprofileid',$id)
                                       ->select('periodtimetables.*','categories.categories','domains.domain')->get(); 
        }
       }else{
        if($stype==1){
        $result['data']=DB::table('periodtimetables')
                                       ->join('categories','periodtimetables.tclassid','categories.id')
                                       ->join('lmssections','periodtimetables.tsectionid','lmssections.id')
                                       ->join('domains','periodtimetables.tsubjectid','domains.id')
                                       ->where("tportalid","FACULTY")->where('tclasstypeid',1)
                                       ->where('tdayid',$day)
                                       ->where('tprofileid',$id)
                                       ->select('periodtimetables.*','categories.categories','lmssections.section','domains.domain')->get();
         }else{
                   $result['data']=DB::table('periodtimetables')
                                       ->join('categories','periodtimetables.tclassid','categories.id')
                                       ->join('domains','periodtimetables.tsubjectid','domains.id')
                                       ->where("tportalid","FACULTY")->where('tclasstypeid',1)
                                       ->where('tdayid',$day)
                                       ->where('tprofileid',$id)
                                       ->select('periodtimetables.*','categories.categories','domains.domain')->get();
         }                              

       }
       $result['stype']=$stype;
       
      return view("supervisor.schedulelist",$result);


    }
    public function delete($lid,$id){
      $model=periodtimetable::find($lid);
      $model->delete();
      return redirect("groupmanager/faculty/list/".$id."/0");
    }

    public function classindex(){
        $result['data']=[];
         $supid=session()->get('SUPERVISOR_ID');
         $d=DB::table('supervisors')->where('id',$supid)->get();
         $result['class']=DB::table('categories')->where('groupid',$d[0]->groupid)->get();
         $result['cl']=0;
         $result['section']=0;
        return view('supervisor.classindex',$result);
    }

    public function getclassdata(request $request){
         $supid=session()->get('SUPERVISOR_ID');
         $d=DB::table('supervisors')->where('id',$supid)->get();
         $result['class']=DB::table('categories')->where('groupid',$d[0]->groupid)->get();
         $result['cl']=$request->post('class');
         $result['section']=$request->post('section');
         $result['data']=DB::table('domains')->where('category',$request->post('class'))->get();

         for($i=0;$i<count($result['data']);$i++){
            $sec="";
            if($result['data'][$i]->stype==1){
                $sec=$request->post('section');
            }else{
                $sec=0;
            }
            $m=DB::table('periodtimetables')
                        ->join('faculties','periodtimetables.tprofileid','faculties.id')
                        ->where('tportalid','FACULTY')
                        ->where('tsubjectid',$result['data'][$i]->id)
                         ->where('tclassid',$request->post('class'))
                         ->where('tsectionid',$sec)
                         ->where('tdayid','Monday')
                         ->select('faculties.id','faculties.fname')
                         ->get();
            $name=[];
            $v=0;
            $fid=[];

            for($k=0;$k<count($m);$k++){
                if(in_array($m[$k]->fname, $name)){

                }else{
                    $name[$v]=$m[$k]->fname;
                    $fid[$v]=$m[$k]->id;
                    $v++;

                }
            }

           
            $result['data'][$i]->monname=$name;
            $result['data'][$i]->mfid=$fid;


             $mm=DB::table('periodtimetables')
                        ->join('managers','periodtimetables.tprofileid','managers.id')
                        ->where('tportalid','MANAGER')
                        ->where('tsubjectid',$result['data'][$i]->id)
                         ->where('tclassid',$request->post('class'))
                         ->where('tsectionid',$sec)
                         ->where('tdayid','Monday')
                         ->select('managers.id','managers.mname')
                         ->get();
            $namem=[];
            $vm=0;
            $fidm=[];

            for($k=0;$k<count($mm);$k++){
                if(in_array($mm[$k]->mname, $namem)){

                }else{
                    $namem[$vm]=$mm[$k]->mname;
                    $fidm[$vm]=$mm[$k]->id;
                    $vm++;

                }
            }

           
            $result['data'][$i]->monmname=$namem;
            $result['data'][$i]->mmfid=$fidm;

          
            $om=DB::table('periodtimetables')
                        ->join('supervisors','periodtimetables.tprofileid','supervisors.id')
                        ->where('tportalid','GROUPMANAGER')
                        ->where('tsubjectid',$result['data'][$i]->id)
                         ->where('tclassid',$request->post('class'))
                         ->where('tsectionid',$sec)
                         ->where('tdayid','Monday')
                         ->select('supervisors.id','supervisors.supname')
                         ->get();
            $name=[];
            $v=0;
            $fid=[];

            for($k=0;$k<count($om);$k++){
                if(in_array($om[$k]->supname, $name)){

                }else{
                    $name[$v]=$om[$k]->supname;
                    $fid[$v]=$om[$k]->id;
                    $v++;

                }
            }

           
            $result['data'][$i]->mononame=$name;
            $result['data'][$i]->mofid=$fid;





             $result['data'][$i]->monday=count($m)+count($mm)+count($om);


             $m=DB::table('periodtimetables')
                        ->join('faculties','periodtimetables.tprofileid','faculties.id')
                        ->where('tportalid','FACULTY')
                        ->where('tsubjectid',$result['data'][$i]->id)
                         ->where('tclassid',$request->post('class'))
                         ->where('tsectionid',$sec)
                         ->where('tdayid','Tuesday')
                         ->select('faculties.id','faculties.fname')
                         ->get();
            $name=[];
            $v=0;
             $fid=[];
            for($k=0;$k<count($m);$k++){
                if(in_array($m[$k]->fname, $name)){

                }else{
                    $name[$v]=$m[$k]->fname;
                     $fid[$v]=$m[$k]->id;
                    $v++;
                }
            }

           
            $result['data'][$i]->tuename=$name;
             $result['data'][$i]->tfid=$fid;




              $mm=DB::table('periodtimetables')
                        ->join('managers','periodtimetables.tprofileid','managers.id')
                        ->where('tportalid','MANAGER')
                        ->where('tsubjectid',$result['data'][$i]->id)
                         ->where('tclassid',$request->post('class'))
                         ->where('tsectionid',$sec)
                         ->where('tdayid','Tuesday')
                         ->select('managers.id','managers.mname')
                         ->get();
            $namem=[];
            $vm=0;
            $fidm=[];

            for($k=0;$k<count($mm);$k++){
                if(in_array($mm[$k]->mname, $namem)){

                }else{
                    $namem[$vm]=$mm[$k]->mname;
                    $fidm[$vm]=$mm[$k]->id;
                    $vm++;

                }
            }

           
            $result['data'][$i]->tuemname=$namem;
            $result['data'][$i]->tmfid=$fidm;


            $om=DB::table('periodtimetables')
                        ->join('supervisors','periodtimetables.tprofileid','supervisors.id')
                        ->where('tportalid','GROUPMANAGER')
                        ->where('tsubjectid',$result['data'][$i]->id)
                         ->where('tclassid',$request->post('class'))
                         ->where('tsectionid',$sec)
                         ->where('tdayid','Tuesday')
                         ->select('supervisors.id','supervisors.supname')
                         ->get();
            $name=[];
            $v=0;
            $fid=[];

            for($k=0;$k<count($om);$k++){
                if(in_array($om[$k]->supname, $name)){

                }else{
                    $name[$v]=$om[$k]->supname;
                    $fid[$v]=$om[$k]->id;
                    $v++;

                }
            }

           
            $result['data'][$i]->tueoname=$name;
            $result['data'][$i]->tofid=$fid;


             $result['data'][$i]->tuesday=count($m)+count($mm)+count($om);


             $m=DB::table('periodtimetables')
                        ->join('faculties','periodtimetables.tprofileid','faculties.id')
                        ->where('tportalid','FACULTY')
                        ->where('tsubjectid',$result['data'][$i]->id)
                         ->where('tclassid',$request->post('class'))
                         ->where('tsectionid',$sec)
                         ->where('tdayid','Wednesday')
                         ->select('faculties.id','faculties.fname')
                         ->get();
            $name=[];
            $v=0;
             $fid=[];
            for($k=0;$k<count($m);$k++){
                if(in_array($m[$k]->fname, $name)){

                }else{
                    $name[$v]=$m[$k]->fname;
                     $fid[$v]=$m[$k]->id;
                    $v++;
                }
            }

           
            $result['data'][$i]->wedname=$name;
             $result['data'][$i]->wfid=$fid;


             $mm=DB::table('periodtimetables')
                        ->join('managers','periodtimetables.tprofileid','managers.id')
                        ->where('tportalid','MANAGER')
                        ->where('tsubjectid',$result['data'][$i]->id)
                         ->where('tclassid',$request->post('class'))
                         ->where('tsectionid',$sec)
                         ->where('tdayid','Wednesday')
                         ->select('managers.id','managers.mname')
                         ->get();
            $namem=[];
            $vm=0;
            $fidm=[];

            for($k=0;$k<count($mm);$k++){
                if(in_array($mm[$k]->mname, $namem)){

                }else{
                    $namem[$vm]=$mm[$k]->mname;
                    $fidm[$vm]=$mm[$k]->id;
                    $vm++;

                }
            }

           
            $result['data'][$i]->wedmname=$namem;
            $result['data'][$i]->wmfid=$fidm;

            $om=DB::table('periodtimetables')
                        ->join('supervisors','periodtimetables.tprofileid','supervisors.id')
                        ->where('tportalid','GROUPMANAGER')
                        ->where('tsubjectid',$result['data'][$i]->id)
                         ->where('tclassid',$request->post('class'))
                         ->where('tsectionid',$sec)
                         ->where('tdayid','Wednesday')
                         ->select('supervisors.id','supervisors.supname')
                         ->get();
            $name=[];
            $v=0;
            $fid=[];

            for($k=0;$k<count($om);$k++){
                if(in_array($om[$k]->supname, $name)){

                }else{
                    $name[$v]=$om[$k]->supname;
                    $fid[$v]=$om[$k]->id;
                    $v++;

                }
            }

           
            $result['data'][$i]->wedoname=$name;
            $result['data'][$i]->wofid=$fid;


           

             $result['data'][$i]->wednesday=count($m)+count($mm)+count($om);


             $m=DB::table('periodtimetables')
                        ->join('faculties','periodtimetables.tprofileid','faculties.id')
                        ->where('tportalid','FACULTY')
                        ->where('tsubjectid',$result['data'][$i]->id)
                         ->where('tclassid',$request->post('class'))
                         ->where('tsectionid',$sec)
                         ->where('tdayid','Thursday')
                         ->select('faculties.id','faculties.fname')
                         ->get();
            $name=[];
            $v=0;
             $fid=[];
            for($k=0;$k<count($m);$k++){
                if(in_array($m[$k]->fname, $name)){

                }else{
                    $name[$v]=$m[$k]->fname;
                     $fid[$v]=$m[$k]->id;
                    $v++;
                }
            }

           
            $result['data'][$i]->thuname=$name;
             $result['data'][$i]->thfid=$fid;

              $mm=DB::table('periodtimetables')
                        ->join('managers','periodtimetables.tprofileid','managers.id')
                        ->where('tportalid','MANAGER')
                        ->where('tsubjectid',$result['data'][$i]->id)
                         ->where('tclassid',$request->post('class'))
                         ->where('tsectionid',$sec)
                         ->where('tdayid','Thursday')
                         ->select('managers.id','managers.mname')
                         ->get();
            $namem=[];
            $vm=0;
            $fidm=[];

            for($k=0;$k<count($mm);$k++){
                if(in_array($mm[$k]->mname, $namem)){

                }else{
                    $namem[$vm]=$mm[$k]->mname;
                    $fidm[$vm]=$mm[$k]->id;
                    $vm++;

                }
            }

           
            $result['data'][$i]->thumname=$namem;
            $result['data'][$i]->thmfid=$fidm;

             $om=DB::table('periodtimetables')
                        ->join('supervisors','periodtimetables.tprofileid','supervisors.id')
                        ->where('tportalid','GROUPMANAGER')
                        ->where('tsubjectid',$result['data'][$i]->id)
                         ->where('tclassid',$request->post('class'))
                         ->where('tsectionid',$sec)
                         ->where('tdayid','Thursday')
                         ->select('supervisors.id','supervisors.supname')
                         ->get();
            $name=[];
            $v=0;
            $fid=[];

            for($k=0;$k<count($om);$k++){
                if(in_array($om[$k]->supname, $name)){

                }else{
                    $name[$v]=$om[$k]->supname;
                    $fid[$v]=$om[$k]->id;
                    $v++;

                }
            }

           
            $result['data'][$i]->thuoname=$name;
            $result['data'][$i]->thofid=$fid;


             $result['data'][$i]->thursday=count($m)+count($mm)+count($om);


             $m=DB::table('periodtimetables')
                        ->join('faculties','periodtimetables.tprofileid','faculties.id')
                        ->where('tportalid','FACULTY')
                        ->where('tsubjectid',$result['data'][$i]->id)
                         ->where('tclassid',$request->post('class'))
                         ->where('tsectionid',$sec)
                         ->where('tdayid','Friday')
                         ->select('faculties.id','faculties.fname')
                         ->get();
            $name=[];
            $v=0;
             $fid=[];
            for($k=0;$k<count($m);$k++){
                if(in_array($m[$k]->fname, $name)){

                }else{
                    $name[$v]=$m[$k]->fname;
                     $fid[$v]=$m[$k]->id;
                    $v++;
                }
            }

            
            $result['data'][$i]->friname=$name;
             $result['data'][$i]->ffid=$fid;

                           $mm=DB::table('periodtimetables')
                        ->join('managers','periodtimetables.tprofileid','managers.id')
                        ->where('tportalid','MANAGER')
                        ->where('tsubjectid',$result['data'][$i]->id)
                         ->where('tclassid',$request->post('class'))
                         ->where('tsectionid',$sec)
                         ->where('tdayid','Friday')
                         ->select('managers.id','managers.mname')
                         ->get();
            $namem=[];
            $vm=0;
            $fidm=[];

            for($k=0;$k<count($mm);$k++){
                if(in_array($mm[$k]->mname, $namem)){

                }else{
                    $namem[$vm]=$mm[$k]->mname;
                    $fidm[$vm]=$mm[$k]->id;
                    $vm++;

                }
            }

           
            $result['data'][$i]->frimname=$namem;
            $result['data'][$i]->fmfid=$fidm;

             $om=DB::table('periodtimetables')
                        ->join('supervisors','periodtimetables.tprofileid','supervisors.id')
                        ->where('tportalid','GROUPMANAGER')
                        ->where('tsubjectid',$result['data'][$i]->id)
                         ->where('tclassid',$request->post('class'))
                         ->where('tsectionid',$sec)
                         ->where('tdayid','Friday')
                         ->select('supervisors.id','supervisors.supname')
                         ->get();
            $name=[];
            $v=0;
            $fid=[];

            for($k=0;$k<count($om);$k++){
                if(in_array($om[$k]->supname, $name)){

                }else{
                    $name[$v]=$om[$k]->supname;
                    $fid[$v]=$om[$k]->id;
                    $v++;

                }
            }

           
            $result['data'][$i]->frioname=$name;
            $result['data'][$i]->fofid=$fid;


             $result['data'][$i]->friday=count($m)+count($mm)+count($om);


             $m=DB::table('periodtimetables')
                        ->join('faculties','periodtimetables.tprofileid','faculties.id')
                        ->where('tportalid','FACULTY')
                        ->where('tsubjectid',$result['data'][$i]->id)
                         ->where('tclassid',$request->post('class'))
                         ->where('tsectionid',$sec)
                         ->where('tdayid','Saturday')
                         ->select('faculties.id','faculties.fname')
                         ->get();
            $name=[];
            $v=0;
             $fid=[];
            for($k=0;$k<count($m);$k++){
                if(in_array($m[$k]->fname, $name)){

                }else{
                    $name[$v]=$m[$k]->fname;
                     $fid[$v]=$m[$k]->id;
                    $v++;
                }
            }

            
            $result['data'][$i]->satname=$name;
             $result['data'][$i]->sfid=$fid;

                           $mm=DB::table('periodtimetables')
                        ->join('managers','periodtimetables.tprofileid','managers.id')
                        ->where('tportalid','MANAGER')
                        ->where('tsubjectid',$result['data'][$i]->id)
                         ->where('tclassid',$request->post('class'))
                         ->where('tsectionid',$sec)
                         ->where('tdayid','Saturday')
                         ->select('managers.id','managers.mname')
                         ->get();
            $namem=[];
            $vm=0;
            $fidm=[];

            for($k=0;$k<count($mm);$k++){
                if(in_array($mm[$k]->mname, $namem)){

                }else{
                    $namem[$vm]=$mm[$k]->mname;
                    $fidm[$vm]=$mm[$k]->id;
                    $vm++;

                }
            }

           
            $result['data'][$i]->satmname=$namem;
            $result['data'][$i]->smfid=$fidm;


             $om=DB::table('periodtimetables')
                        ->join('supervisors','periodtimetables.tprofileid','supervisors.id')
                        ->where('tportalid','GROUPMANAGER')
                        ->where('tsubjectid',$result['data'][$i]->id)
                         ->where('tclassid',$request->post('class'))
                         ->where('tsectionid',$sec)
                         ->where('tdayid','Saturday')
                         ->select('supervisors.id','supervisors.supname')
                         ->get();
            $name=[];
            $v=0;
            $fid=[];

            for($k=0;$k<count($om);$k++){
                if(in_array($om[$k]->supname, $name)){

                }else{
                    $name[$v]=$om[$k]->supname;
                    $fid[$v]=$om[$k]->id;
                    $v++;

                }
            }

           
            $result['data'][$i]->satoname=$name;
            $result['data'][$i]->sofid=$fid;


             $result['data'][$i]->saturday=count($m)+count($mm)+count($om);

         }
        return view('supervisor.classindex',$result);
    }
}
