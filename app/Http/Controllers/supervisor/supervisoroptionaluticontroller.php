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

class supervisoroptionaluticontroller extends Controller
{
    public function index(){
        $sesid=session()->get('SUPERVISOR_ID');
        $data=DB::table('supervisors')->where('id',$sesid)->get();
        $sub=explode("##",$data['0']->ssubjectid);
        $result['data']=[];
        for($i=0;$i<count($sub);$i++){
            $result['data'][$i]=DB::table('domains')->where('id',$sub[$i])->get();
        }
        //return $result['data'];
        return view('supervisor.optionalindex',$result);
    }

      public function classindex(){
        $result['data']=[];
        $aid=session()->get('SUPERVISOR_ADMIN_ID');
         $supid=session()->get('SUPERVISOR_ID');
         $d=DB::table('supervisors')->where('id',$supid)->get();
         $result['class']=DB::table('categories')->where('aid',$aid)->get();
         $result['cl']=0;
         $result['section']=0;
        return view('supervisor.classindexoptional',$result);
    }


     public function fschedulelist($stype,$id,$day=''){
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
       
      return view("supervisor.schedulelistoptional",$result);


    }











       public function getclassdata(request $request){
         $supid=session()->get('SUPERVISOR_ID');
         $aid=session()->get('SUPERVISOR_ADMIN_ID');
         $d=DB::table('supervisors')->where('id',$supid)->get();
         $result['class']=DB::table('categories')->where('aid',$aid)->get();
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
        return view('supervisor.classindexoptional',$result);
    }

     public function mschedulelist($stype,$id,$day=''){
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
       
      return view("supervisor.schedulelistoptional",$result);


    }


    public function oschedulelist($stype,$id,$day=''){
      $result['role']="GROUPMANAGER";
       $supid=session()->get('SUPERVISOR_ID');
       $d=DB::table('supervisors')->where('id',$supid)->get();
       $result['Name']=$d[0]->supname;
       $result['id']=$id;
       if($day=='0'){
         if($stype==1){
         $result['data']=DB::table('periodtimetables')
                                       ->join('categories','periodtimetables.tclassid','categories.id')
                                       ->join('lmssections','periodtimetables.tsectionid','lmssections.id')
                                       ->join('domains','periodtimetables.tsubjectid','domains.id')
                                       ->where("tportalid","GROUPMANAGER")->where('tclasstypeid',1)
                                       ->where('tprofileid',$id)
                                       ->select('periodtimetables.*','categories.categories','lmssections.section','domains.domain')->get();
          }else{
             $result['data']=DB::table('periodtimetables')
                                       ->join('categories','periodtimetables.tclassid','categories.id')
                                       ->join('domains','periodtimetables.tsubjectid','domains.id')
                                       ->where("tportalid","GROUPMANAGER")->where('tclasstypeid',1)
                                       ->where('tprofileid',$id)
                                       ->select('periodtimetables.*','categories.categories','domains.domain')->get();
          }
       }else{
         if($stype==1){
        $result['data']=DB::table('periodtimetables')
                                       ->join('categories','periodtimetables.tclassid','categories.id')
                                       ->join('lmssections','periodtimetables.tsectionid','lmssections.id')
                                       ->join('domains','periodtimetables.tsubjectid','domains.id')
                                       ->where("tportalid","GROUPMANAGER")->where('tclasstypeid',1)
                                       ->where('tdayid',$day)
                                       ->where('tprofileid',$id)
                                       ->select('periodtimetables.*','categories.categories','lmssections.section','domains.domain')->get();
         }else{
               $result['data']=DB::table('periodtimetables')
                                       ->join('categories','periodtimetables.tclassid','categories.id')
                                       ->join('domains','periodtimetables.tsubjectid','domains.id')
                                       ->where("tportalid","GROUPMANAGER")->where('tclasstypeid',1)
                                       ->where('tdayid',$day)
                                       ->where('tprofileid',$id)
                                       ->select('periodtimetables.*','categories.categories','domains.domain')->get();
         }

       }
       $result['stype']=$stype;
       
      return view("supervisor.schedulelistoptional",$result);


    }













    public function list(){
       $sesid=session()->get('SUPERVISOR_ID');
       $result['data']=DB::table('periodtimetables')
                                       ->join('categories','periodtimetables.tclassid','categories.id')
                                       ->join('domains','periodtimetables.tsubjectid','domains.id')
                                       ->where('tsubjecttype',2)
                                       ->where('supid',$sesid)
                                       ->select('periodtimetables.*','categories.categories','domains.domain')->get(); 
       for($i=0;$i<count($result['data']);$i++){
          if($result['data'][$i]->roomtype=="SECTION"){
            $a=DB::table('lmssections')->where('id',$result['data'][$i]->roomno)->get();
            $result['data'][$i]->roomname="SECTION - ".$a[0]->section;
          }else{
             $a=DB::table('rooms')->where('id',$result['data'][$i]->roomno)->get();
            $result['data'][$i]->roomname=$a[0]->roomname;
          }
          if($result['data'][$i]->tportalid=="FACULTY"){
            $a=DB::table('faculties')->where('id',$result['data'][$i]->tprofileid)->get();
            $result['data'][$i]->name=$a[0]->fname;
          }
          if($result['data'][$i]->tportalid=="MANAGER"){
            $a=DB::table('managers')->where('id',$result['data'][$i]->tprofileid)->get();
            $result['data'][$i]->name=$a[0]->mname;
          }
          if($result['data'][$i]->tportalid=="GROUPMANAGER"){
            $a=DB::table('supervisors')->where('id',$result['data'][$i]->tprofileid)->get();
            $result['data'][$i]->name=$a[0]->supname;
          }

       }
       return view('supervisor.optionallist',$result);
    }
    public function delete($id){
      $model=periodtimetable::find($id);
      $model->delete();
      return redirect("groupmanager/optional/schedule/list");
    }
    public function edit($id){
        $aid=session()->get('SUPERVISOR_ADMIN_ID');
      $result['days']=["1"=>"Monday","2"=>"Tuesday","3"=>"Wednesday","4"=>"Thursday","5"=>"Friday","6"=>"Saturday"];
      $sesid=session()->get('SUPERVISOR_ID');
      $result['supervisors']=DB::table('supervisors')->where('id',$sesid)->get();
      $data=DB::table('periodtimetables')->where('id',$id)->get();
      $sub=DB::table('domains')->where('id',$data[0]->tsubjectid)->get();
      $mod=DB::table('skillsets')->where('id',$data[0]->tmoduleid)->get();
      $result['id']=$id;
       $result['name']=$sub[0]->domain;
       $result['sid']=$data[0]->tsubjectid;
       $result['module']=$mod[0]->skillset;
       $result['day']=$data[0]->tdayid;
       $result['period']=$data[0]->tperiodid;
       $result['type']=$data[0]->tclasstypeid;
       $result['roomtype']=$data[0]->roomtype;
       $result['roomno']=$data[0]->roomno;
       $result['per']=$data[0]->tperiodid;
       $result['classtypes']=DB::table('classtypes')->get();
       $result['fid']=$data[0]->tprofileid;
       $result['fac']='';
       
       if($data[0]->tportalid=="FACULTY"){
         $a=DB::table('faculties')->where('id',$data[0]->tprofileid)->get();
         $result['ftype']="FACULTY";
         $result['fac']=$a[0]->fname;
       }else if($data[0]->tportalid=="MANAGER"){
          $b=DB::table('managers')->where('id',$data[0]->tprofileid)->get();
         $result['fac']=$b[0]->mname;
         $result['ftype']="MANAGER";
       }else{
        $result['fac']=$result['supervisors'][0]->supname;
        $result['ftype']="GROUPMANAGER";
       }
       $result['cl']=$data[0]->tclassid;
       $result['room']="";
       if($data[0]->roomtype=="ROOM"){
         $rm=DB::table('rooms')->where("id",$data[0]->roomno)->get();
         $result['room']=$rm[0]->roomname;
       }else{
         $sc=DB::table('lmssections')->where('id',$data[0]->roomno)->get();
         $result['room']=$sc[0]->section;
       }
       $result['class']=DB::table('categories')->where('aid',$aid)->get();
       $day=$data[0]->tdayid;
       $sub=$data[0]->tsubjectid;
       $pr=$data[0]->tperiodid;
       $cl=$data[0]->tclassid;

       $result['days']=["1"=>"Monday","2"=>"Tuesday","3"=>"Wednesday","4"=>"Thursday","5"=>"Friday","6"=>"Saturday"]; 


         $result['managers']=DB::table('managers')->where('msubjectid','LIKE','%'.$sub.'%')->get();
          $man=DB::table('periodtimetables')->where('tclassid',$cl)
                                ->where('tclasstypeid',1)
                                ->where('tdayid',$day)->where('tportalid','MANAGER')->where('tperiodid',$pr)->get()->unique('tprofileid');
         $result['maval']=[];
         for($i=0;$i<count($man);$i++){
           $result['maval'][$i]=$man[$i]->tprofileid;
         }

          $result['faculties']=DB::table('faculties')->where('subjectid','LIKE','%'.$sub.'%')->get();
          $fac=DB::table('periodtimetables')->where('tclassid',$cl)
                                ->where('tclasstypeid',1)
                                ->where('tdayid',$day)->where('tportalid','FACULTY')->where('tperiodid',$pr)->get()->unique('tprofileid');
         $result['faval']=[];
         for($i=0;$i<count($fac);$i++){
           $result['faval'][$i]=$fac[$i]->tprofileid;
         }

          $result['supervisors']=DB::table('supervisors')->where('ssubjectid','LIKE','%'.$sub.'%')->get();
          $sup=DB::table('periodtimetables')->where('tclassid',$cl)
                                ->where('tclasstypeid',1)
                                ->where('tdayid',$day)->where('tportalid','GROUPMANAGER')->where('tperiodid',$pr)->get()->unique('tprofileid');
         $result['saval']=[];
         for($i=0;$i<count($sup);$i++){
           $result['saval'][$i]=$sup[$i]->tprofileid;
         }

          $result['rooms']=DB::table('rooms')->where('aid',$data[0]->aid)->get();
          $roomocc=DB::table('periodtimetables')->where('tclassid',$cl)
                                ->where('tclasstypeid',1)
                                ->where('tsubjecttype',2)
                                ->where('tdayid',$day)->where('roomtype','ROOM')->where('tperiodid',$pr)->get();
         $result['roomsocc']=[];
         for($i=0;$i<count($roomocc);$i++){
           $result['roomsocc'][$i]=$roomocc[$i]->roomno;
         }



       return view('supervisor.optionaleditform',$result);

    }
    public function update(request $request){
       // return $request->post();
      $model=periodtimetable::find($request->post('id'));
      $data=explode("**",$request->post('facs'));
      $room=explode("**",$request->post('rooms'));
      $model->tportalid=$data[0];
      $model->tprofileid=$data[1];
      $model->roomtype=$room[0];
      $model->roomno=$room[1];
      $model->save();
      return redirect('groupmanager/optional/schedule/list');
    }
    public function schedule($id){
        $sesid=session()->get('SUPERVISOR_ID');
        $result['supervisors']=DB::table('supervisors')->where('id',$sesid)->get();
      $data=DB::table('domains')->where('id',$id)->get();
      $skill=DB::table('skillsets')->where('domain',$data[0]->id)->get();
      $result['finalcount']=0;
      $result['scount']=count($skill);
      for ($i=0; $i <count($skill) ; $i++) { 
        $count=0;
          $stu=DB::table('students')->where('sclassid',$data[0]->category)->get();
          for($j=0;$j<count($stu);$j++){
            $mod=$stu[$j]->optmod;
            $modarr=explode("#*#", $mod);
            if(in_array($skill[$i]->id, $modarr)){
                $count++;
                $result['finalcount']++;
            }
          }
          $skill[$i]->stucount=$count;
      }
     $result['skills']=$skill;
      $result['name']=$data[0]->domain;
      $result['sid']=$data[0]->id;
      $result['type']=0;
      $result['day']=0;
      $result['id']=0;
      $result['rowid']=0;
      $aid=session()->get('SUPERVISOR_ADMIN_ID');
      $result['role']=0;
      $result['class']=DB::table('categories')->where('aid',$aid)->get();
      $result['cl']=$data[0]->category;
      $result['rooms']=DB::table('lmssections')->where('classid',$data[0]->category)->get();
      $result['exrooms']=DB::table('rooms')->where('allocation',1)->where('aid',$result['supervisors'][0]->aid)->get();
     
       $result['faculties']=DB::table('faculties')->where('subjectid','LIKE','%'.$id.'%')->get();
       $result['managers']=DB::table('managers')->where('msubjectid','LIKE','%'.$id.'%')->get();
       $result['supervisors']=DB::table('supervisors')->where('id',$sesid)->get();

      $result['days']=["1"=>"Monday","2"=>"Tuesday","3"=>"Wednesday","4"=>"Thursday","5"=>"Friday","6"=>"Saturday"];
      $result['classtypes']=DB::table('classtypes')->get();
      return view("supervisor.optionalform",$result);
    }

      public function getperiod(){
         $supid=session()->get('SUPERVISOR_ID');
       $d=DB::table('supervisors')->where('id',$supid)->get();
       $type=$d[0]->supsubjecttype;
       $required='';
         $day = $_GET['val'];
         $cl=$_GET['cl'];
        
         
         $need="";
         $scheck="";
         if($day=="Monday"){
            if($type==1){
             $need="cmon";
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
         }else if($day=="Wednesday"){
            if($type==1){
             $need="cwednes";
            }else{
             $need="cwednesopt";
            }
            $scheck="pwednes";
         }else if($day=="Thursday"){
             if($type==1){
             $need="cthurs";
            }else{
             $need="cthursopt";
            }
             $scheck="pthurs";
         }else if($day=="Friday"){
             if($type==1){
             $need="cfri";
            }else{
             $need="cfriopt";
            }
             $scheck="pfri";
         }else if($day=="Saturday"){
             if($type==1){
             $need="csatur";
            }else{
             $need="csaturopt";
            }
             $scheck="psatur";
         }
         
         $check=DB::table('periodtimetables')->where('tclassid',$cl)
                                ->where('tclasstypeid',1)
                                ->where('tsubjecttype',$type)
                                ->where('tdayid',$day)->get();
        $pcheck=0;
        $totclass=DB::table('categories')->where('id',$cl)->get();

        $che=DB::table('periodtimetables')->where('tdayid',$day)->get();

        


        $checking=[];
        for($i=0;$i<count($check);$i++){
          $checking[$i]=$check[$i]->tperiodid;
        }
        $cv=count($check);
        for($i=0;$i<count($che);$i++){
         $checking[$cv]=$che[$i]->tperiodid;
         $cv++;
        }

         $res = DB::table('periodforclasses')->where('cclassid',$cl)->where('cclasstypeid',1)->get($need);
         $result=[];
          $result[0]=$totclass[0]->cmaxperiod;
         $result[1]=$checking;
         
         $result[2]=count($check);
         $result[3]=$res[0]->$need;

       
        

        return Response::json($result);
    }

    public function getfacs(){
          $supid=session()->get('SUPERVISOR_ID');
       $d=DB::table('supervisors')->where('id',$supid)->get();
       $type=$d[0]->supsubjecttype;
       
         $day = $_GET['val'];
         $cl=$_GET['cl'];
         $pr=$_GET['per'];
         $sub=$_GET['sub'];

         $result[0]=DB::table('managers')->where('msubjectid','LIKE','%'.$sub.'%')->get();
          $man=DB::table('periodtimetables')->where('tclassid',$cl)
                                ->where('tclasstypeid',1)
                                ->where('tsubjecttype',2)
                                ->where('tdayid',$day)->where('tportalid','MANAGER')->where('tperiodid',$pr)->get()->unique('tprofileid');
         $result[1]=[];
         for($i=0;$i<count($man);$i++){
           $result[1][$i]=$man[$i]->tprofileid;
         }

          $result[2]=DB::table('faculties')->where('subjectid','LIKE','%'.$sub.'%')->get();
          $fac=DB::table('periodtimetables')->where('tclassid',$cl)
                                ->where('tclasstypeid',1)
                                ->where('tsubjecttype',2)
                                ->where('tdayid',$day)->where('tportalid','FACULTY')->where('tperiodid',$pr)->get()->unique('tprofileid');
         $result[3]=[];
         for($i=0;$i<count($man);$i++){
           $result[3][$i]=$fac[$i]->tprofileid;
         }

          $result[4]=DB::table('supervisors')->where('ssubjectid','LIKE','%'.$sub.'%')->get();
          $sup=DB::table('periodtimetables')->where('tclassid',$cl)
                                ->where('tclasstypeid',1)
                                ->where('tsubjecttype',2)
                                ->where('tdayid',$day)->where('tportalid','GROUPMANAGER')->where('tperiodid',$pr)->get()->unique('tprofileid');
         $result[5]=[];
         for($i=0;$i<count($man);$i++){
           $result[4][$i]=$fac[$i]->tprofileid;
         }

          $result[6]=DB::table('lmssections')->where('classid',$cl)->get();;
          $sec=DB::table('periodtimetables')->where('tclassid',$cl)
                                ->where('tclasstypeid',1)
                                ->where('tsubjecttype',2)
                                ->where('tdayid',$day)->where('roomtype','SECTION')->where('tperiodid',$pr)->get();
         $result[7]=[];
         for($i=0;$i<count($man);$i++){
           $result[7][$i]=$sec[$i]->roomno;
         }
         
         $result[8]=DB::table('rooms')->where('allocation',1)->where('aid',$d[0]->aid)->get();
          $room=DB::table('periodtimetables')->where('tclassid',$cl)
                                ->where('tclasstypeid',1)
                                ->where('tsubjecttype',2)
                                ->where('tdayid',$day)->where('roomtype','ROOM')->where('tperiodid',$pr)->get();
         $result[9]=[];
         for($i=0;$i<count($man);$i++){
           $result[9][$i]=$room[$i]->roomno;
         }


       return Response::json($result); 
    }

    public function sprocess(request $request){
     // return $request->post();
        $f= $request->post('faculties');
        $r=$request->post('rooms');
        $m=$request->post('module');
        $supid=session()->get('SUPERVISOR_ID');
        $d=DB::table('supervisors')->where('id',$supid)->get();
       for($i=0;$i<count($f);$i++){
        if($f[$i]==null){

        }else{
         $v=explode("**",$f[$i]);
          $rm=explode('**',$r[$i]);
         

          $model=new periodtimetable();
         $model->aid=$d[0]->aid;
         $model->supid=$supid;
         $model->tclasstypeid=$request->post('type');
         $model->tsubjecttype=2;
         $model->tportalid=$v[1];
         $model->tprofileid=$v[0];
         $model->tsubjectid=$request->post('sid');
         $model->tmoduleid=$m[$i];
         $model->tdayid=$request->post('day');
         $model->tclassid=$request->post('class');
         $model->tsectionid=0;
         $model->tperiodid=$request->post('Period');
         $model->roomtype=$rm[1];
         $model->roomno=$rm[0];
         $model->save();
       }
          

       }


      
      
       
      
         

        
         
         
         
      
      return redirect("groupmanager/optional/schedule/list");
    }

}
