<?php

namespace App\Http\Controllers\manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\periodforportal;
use App\Models\periodforclass;
use App\Models\periodforsubject;
use App\Models\periodtimetable;
use Redirect,Response;


class managerschedulelistcontroller extends Controller
{
    public function index(request $request){
          $result['data']=[];
           $mid=session()->get('MANAGER_ID');
        $d=DB::table('managers')->where("id",$mid)->get();
         $result['class']=DB::table('categories')->where('id',$d[0]->classid)->get();
         $result['sec']=DB::table('lmssections')->where('classid',$d[0]->classid)->get();
         $result['cl']=$d[0]->classid;
         $result['section']=0;
         $result['mid']=$mid;
        return view('manager.classindex',$result);
    }

     public function getclassdata(request $request){
          $mid=session()->get('MANAGER_ID');
        $d=DB::table('managers')->where("id",$mid)->get();
         $result['class']=DB::table('categories')->where('id',$d[0]->classid)->get();
         $result['sec']=DB::table('lmssections')->where('classid',$d[0]->classid)->get();
         $result['cl']=$d[0]->classid;
         $result['section']=$request->post('section');
         $result['data']=DB::table('domains')->where('category',$request->post('class'))->get();
         $result['mid']=$mid;
         for($i=0;$i<count($result['data']);$i++){
            $m=DB::table('periodtimetables')
                        ->join('faculties','periodtimetables.tprofileid','faculties.id')
                        ->where('tportalid','FACULTY')
                        ->where('tsubjectid',$result['data'][$i]->id)
                         ->where('tclassid',$request->post('class'))
                         ->where('tsectionid',$request->post('section'))
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
                        ->where('tprofileid',$mid)
                        ->where('tsubjectid',$result['data'][$i]->id)
                         ->where('tclassid',$request->post('class'))
                         ->where('tsectionid',$request->post('section'))
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

          
           




             $result['data'][$i]->monday=count($m)+count($mm);


             $m=DB::table('periodtimetables')
                        ->join('faculties','periodtimetables.tprofileid','faculties.id')
                        ->where('tportalid','FACULTY')
                        ->where('tsubjectid',$result['data'][$i]->id)
                         ->where('tclassid',$request->post('class'))
                         ->where('tsectionid',$request->post('section'))
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
                         ->where('tprofileid',$mid)
                        ->where('tsubjectid',$result['data'][$i]->id)
                         ->where('tclassid',$request->post('class'))
                         ->where('tsectionid',$request->post('section'))
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


           

             $result['data'][$i]->tuesday=count($m)+count($mm);


             $m=DB::table('periodtimetables')
                        ->join('faculties','periodtimetables.tprofileid','faculties.id')
                        ->where('tportalid','FACULTY')
                        ->where('tsubjectid',$result['data'][$i]->id)
                         ->where('tclassid',$request->post('class'))
                         ->where('tsectionid',$request->post('section'))
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
                         ->where('tprofileid',$mid)
                        ->where('tsubjectid',$result['data'][$i]->id)
                         ->where('tclassid',$request->post('class'))
                         ->where('tsectionid',$request->post('section'))
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

           


           

             $result['data'][$i]->wednesday=count($m)+count($mm);


             $m=DB::table('periodtimetables')
                        ->join('faculties','periodtimetables.tprofileid','faculties.id')
                        ->where('tportalid','FACULTY')
                        ->where('tsubjectid',$result['data'][$i]->id)
                         ->where('tclassid',$request->post('class'))
                         ->where('tsectionid',$request->post('section'))
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
                         ->where('tprofileid',$mid)
                        ->where('tsubjectid',$result['data'][$i]->id)
                         ->where('tclassid',$request->post('class'))
                         ->where('tsectionid',$request->post('section'))
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

            


             $result['data'][$i]->thursday=count($m)+count($mm);


             $m=DB::table('periodtimetables')
                        ->join('faculties','periodtimetables.tprofileid','faculties.id')
                        ->where('tportalid','FACULTY')
                        ->where('tsubjectid',$result['data'][$i]->id)
                         ->where('tclassid',$request->post('class'))
                         ->where('tsectionid',$request->post('section'))
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
                         ->where('tprofileid',$mid)
                        ->where('tsubjectid',$result['data'][$i]->id)
                         ->where('tclassid',$request->post('class'))
                         ->where('tsectionid',$request->post('section'))
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

            


             $result['data'][$i]->friday=count($m)+count($mm);


             $m=DB::table('periodtimetables')
                        ->join('faculties','periodtimetables.tprofileid','faculties.id')
                        ->where('tportalid','FACULTY')
                        ->where('tsubjectid',$result['data'][$i]->id)
                         ->where('tclassid',$request->post('class'))
                         ->where('tsectionid',$request->post('section'))
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
                         ->where('tprofileid',$mid)
                         ->where('tsubjectid',$result['data'][$i]->id)
                         ->where('tclassid',$request->post('class'))
                         ->where('tsectionid',$request->post('section'))
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


            


             $result['data'][$i]->saturday=count($m)+count($mm);

         }
        return view('manager.classindex',$result);
    }


     public function facultylist($id,$day=''){
      $result['role']="FACULTY";
       $d=DB::table('faculties')->where('id',$id)->get();
       $result['Name']=$d[0]->fname;
       $result['id']=$id;
       if($day=='0'){
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
                                       ->join('lmssections','periodtimetables.tsectionid','lmssections.id')
                                       ->join('domains','periodtimetables.tsubjectid','domains.id')
                                       ->where("tportalid","FACULTY")->where('tclasstypeid',1)
                                       ->where('tdayid',$day)
                                       ->where('tprofileid',$id)
                                       ->select('periodtimetables.*','categories.categories','lmssections.section','domains.domain')->get();

       }
       
      return view("manager.schedulelist",$result);


    }

     public function list($id,$day=''){
      $result['role']="MANAGER";
       $d=DB::table('managers')->where('id',$id)->get();
       $result['Name']=$d[0]->mname;
       $result['id']=$id;
       if($day=='0'){
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
                                       ->join('lmssections','periodtimetables.tsectionid','lmssections.id')
                                       ->join('domains','periodtimetables.tsubjectid','domains.id')
                                       ->where("tportalid","MANAGER")->where('tclasstypeid',1)
                                       ->where('tdayid',$day)
                                       ->where('tprofileid',$id)
                                       ->select('periodtimetables.*','categories.categories','lmssections.section','domains.domain')->get();

       }
       
      return view("manager.schedulelist",$result);


    }
}
