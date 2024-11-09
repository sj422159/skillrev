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

class classteacheranalyticcontroller extends Controller
{
   


    public function index(){
        $sesid=session()->get('CLASSTEACHER_ID');
        $d=DB::table('faculties')->where("id",$sesid)->get();
        $result['cl']=$d[0]->classid;
        $result['section']=$d[0]->sectionid;
        $result['sec']=DB::table('lmssections')->get();
        $result['train']=DB::table('trainings')->where('aid',$d[0]->aid)->where('status',1)->get();
        $result['class']=DB::table('categories')->get();
        $result['tri']=0;
        $result['data']=[];
      
        $result['presec']=[];
        $result['postsec']=[];
        $result['cpass']=0;
        $result['cfail']=0;
        $result['fpass']=0;
        $result['ffail']=0;
        $result['capprove']=0;
        $result['fapprove']=0;
        return view('classteacher.analytics',$result);
    }

    public function fetch(request $request){
        $sesid=session()->get('CLASSTEACHER_ID');
        $d=DB::table('faculties')->where("id",$sesid)->get();
        $result['cl']=$d[0]->classid;
        $result['section']=$d[0]->sectionid;
        $result['sec']=DB::table('lmssections')->get();
        $result['train']=DB::table('trainings')->where('aid',$d[0]->aid)->where('status',1)->get();
        $result['class']=DB::table('categories')->get();
        $result['tri']=$request->training;

      //  return $request->post();
        $jname=DB::table('trainings')->where('id',$request->training)->get();
      if(count($jname)>0){
       $result['jname']=$jname[0]->trainingname;
      }else{
        $result['jname']='';
      }
      $result['section']=$request->section;
      $aid=session()->get('ADMIN_ID');

      $pre=DB::table('assesments')->where('train',$request->training)->where('asstype',"Pre")->where('status',1)->get(); 
           
      if(count($pre)>0){
        $result['presec']=DB::table('assesmentsections')->where('ass_id',$pre[0]->id)->get();
        $cpass=DB::table('studentbookings')
                        ->join('stureports','studentbookings.stureports','stureports.id')
                        ->where('trainingid',$request->post('training'))
                        ->where('ssectionid',$request->post('section'))
                        ->where('stureports.result','PASS')
                        ->where('studentbookings.manpreapprove',0)
                        ->get();

        $result['cpass']=count($cpass);

        $cfail=DB::table('studentbookings')
                        ->join('stureports','studentbookings.stureports','stureports.id')
                        ->where('trainingid',$request->post('training'))
                        ->where('ssectionid',$request->post('section'))
                        ->where('stureports.result','FAIL')
                        ->where('studentbookings.manpreapprove',0)
                        ->get();

        $result['cfail']=count($cfail);

        $capprove=DB::table('studentbookings')
                        ->join('stureports','studentbookings.stureports','stureports.id')
                        ->where('trainingid',$request->post('training'))
                        ->where('ssectionid',$request->post('section'))
                        ->where('studentbookings.manpreapprove',1)
                        ->get();

        $result['capprove']=count($capprove);

      }else{
          $result['presec']=[];
          $result['preid']=0;
          $result['cpass']=0;
          $result['cfail']=0;
          $result['capprove']=0;
      }



      
         $post=DB::table('assesments')->where('train',$request->training)->where('asstype',"Post")->where('status',1)->get();  
      if(count($post)>0){
          $result['postsec']=DB::table('assesmentsections')->where('ass_id',$post[0]->id)->get();
          $fpass=DB::table('studentbookings')
                        ->join('stureports','studentbookings.stureports','stureports.id')
                        ->where('trainingid',$request->post('training'))
                        ->where('ssectionid',$request->post('section'))
                        ->where('stureports.postresult','PASS')
                        ->where('studentbookings.manpreapprove',0)
                        ->get();
          $result['fpass']=count($fpass);
          $ffail=DB::table('studentbookings')
                        ->join('stureports','studentbookings.stureports','stureports.id')
                        ->where('trainingid',$request->post('training'))
                        ->where('ssectionid',$request->post('section'))
                        ->where('stureports.postresult','PASS')
                        ->where('studentbookings.manpreapprove',0)
                        ->get();
          $result['ffail']=count($ffail);

          $fapprove=DB::table('studentbookings')
                        ->join('stureports','studentbookings.stureports','stureports.id')
                        ->where('trainingid',$request->post('training'))
                        ->where('ssectionid',$request->post('section'))
                        ->where('studentbookings.manpreapprove',1)
                        ->get();

             $result['fapprove']=count($fapprove);

      }else{
          $result['fpass']=0;
          $result['ffail']=0;
          $result['postid']=0;
          $result['postsec']=[];
          $result['fapprove']=0;
      }

     
     return view('classteacher.analytics',$result);
    }


    public function predata(request $request){
        $re = $request->post('id');
      $name=explode('//', $re);
      $need='';
      $result['data']['name']="PRE - ".$name[0];
      if($name[1]==1){
       $need="secAmark";
      }
      if($name[1]==2){
       $need="secBmark";
      }
      if($name[1]==3){
       $need="secCmark";
      }
      if($name[1]==4){
       $need="secDmark";
      }

    
          $sesid=session()->get('CLASSTEACHER_ID');
        $d=DB::table('faculties')->where("id",$sesid)->get();
      $data=DB::table('studentbookings')
                        ->join('stureports','studentbookings.stureports','stureports.id')
                        ->where('trainingid',$request->post('train'))
                        ->where('ssectionid',$request->post('section'))
                        ->where('studentbookings.ssectionid',$d[0]->sectionid)
                        ->get($need);

        $result['data'][0]=0;
        $result['data'][1]=0;
        $result['data'][2]=0;
        $result['data'][3]=0;
        $result['data'][4]=0;
        $result['data'][5]=0;
        $result['data'][6]=0;
        $result['data'][7]=0;

      for($i=0;$i<count($data);$i++){
         if($data[$i]->$need>=90){
                    $result['data'][7]++;   
                   }
          else if($data[$i]->$need>=80){
                        $result['data'][6]++; 
                     }

          else if($data[$i]->$need>=70){
                         $result['data'][5]++; 
                      }
          else if($data[$i]->$need>=60){
                          $result['data'][4]++; 
                       }
          else if($data[$i]->$need>=50){
                           $result['data'][3]++; 
                       }
          else if($data[$i]->$need>=40){
                          $result['data'][2]++; 
                       }
          else if($data[$i]->$need>=30){
                        $result['data'][1]++; 
                     }
          else if($data[$i]->$need<30){
                               $result['data'][0]++; 
                           }

          }
      
        return Response::json($result['data']);

    
    }

    public function postdata(request $request){
        $re = $request->post('id');
      $name=explode('//', $re);
      $need='';
      $result['data']['name']="POST - ".$name[0];
      if($name[1]==1){
       $need="psecAmark";
      }
      if($name[1]==2){
       $need="psecBmark";
      }
      if($name[1]==3){
       $need="psecCmark";
      }
      if($name[1]==4){
       $need="psecDmark";
      }

    
        $sesid=session()->get('CLASSTEACHER_ID');
        $d=DB::table('faculties')->where("id",$sesid)->get();
      $data=DB::table('studentbookings')
                        ->join('stureports','studentbookings.stureports','stureports.id')
                        ->where('trainingid',$request->post('train'))
                        ->where('ssectionid',$request->post('section'))
                        ->where('studentbookings.ssectionid',$d[0]->sectionid)
                        ->get($need);

        $result['data'][0]=0;
        $result['data'][1]=0;
        $result['data'][2]=0;
        $result['data'][3]=0;
        $result['data'][4]=0;
        $result['data'][5]=0;
        $result['data'][6]=0;
        $result['data'][7]=0;

      for($i=0;$i<count($data);$i++){
         if($data[$i]->$need>=90){
                    $result['data'][7]++;   
                   }
          else if($data[$i]->$need>=80){
                        $result['data'][6]++; 
                     }

          else if($data[$i]->$need>=70){
                         $result['data'][5]++; 
                      }
          else if($data[$i]->$need>=60){
                          $result['data'][4]++; 
                       }
          else if($data[$i]->$need>=50){
                           $result['data'][3]++; 
                       }
          else if($data[$i]->$need>=40){
                          $result['data'][2]++; 
                       }
          else if($data[$i]->$need>=30){
                        $result['data'][1]++; 
                     }
          else if($data[$i]->$need<30){
                               $result['data'][0]++; 
                           }

          }
      
        return Response::json($result['data']);

    
    }

    public function list($id,$day=''){
       

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
      
         
       
      return view("classteacher.schedulelist",$result);
    }

    public function classindex(){
          $result['data']=[];
          $id=session()->get('CLASSTEACHER_ID');
        $d=DB::table('faculties')->where("id",$id)->get();
         $result['class']=DB::table('categories')->where('id',$d[0]->classid)->get();
         $result['sec']=DB::table('lmssections')->where('classid',$d[0]->classid)->get();
         $result['cl']=$d[0]->classid;
         $result['section']=$d[0]->sectionid;
         $result['mid']=$id;
     
      return view('classteacher.classindex',$result);
    }



      public function getclassdata(request $request){
         $id=session()->get('CLASSTEACHER_ID');
        $d=DB::table('faculties')->where("id",$id)->get();
         $result['class']=DB::table('categories')->where('id',$d[0]->classid)->get();
         $result['sec']=DB::table('lmssections')->where('classid',$d[0]->classid)->get();
         $result['cl']=$d[0]->classid;
         $result['section']=$d[0]->sectionid;
         $result['data']=DB::table('domains')->where('category',$result['cl'])->get();
         $result['mid']=$id;
         for($i=0;$i<count($result['data']);$i++){
             $m=DB::table('periodtimetables')
                        ->join('faculties','periodtimetables.tprofileid','faculties.id')
                        ->where('tportalid','FACULTY')
                        ->where('tsubjectid',$result['data'][$i]->id)
                         ->where('tclassid',$result['cl'])
                         ->where('tsectionid',$result['section'])
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



          
           




             $result['data'][$i]->monday=count($m);


             $m=DB::table('periodtimetables')
                        ->join('faculties','periodtimetables.tprofileid','faculties.id')
                        ->where('tportalid','FACULTY')
                        ->where('tsubjectid',$result['data'][$i]->id)
                         ->where('tclassid',$result['cl'])
                         ->where('tsectionid',$result['section'])
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





             $result['data'][$i]->tuesday=count($m);


             $m=DB::table('periodtimetables')
                        ->join('faculties','periodtimetables.tprofileid','faculties.id')
                        ->where('tportalid','FACULTY')
                        ->where('tsubjectid',$result['data'][$i]->id)
                         ->where('tclassid',$result['cl'])
                         ->where('tsectionid',$result['section'])
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


        
           


           

             $result['data'][$i]->wednesday=count($m);


             $m=DB::table('periodtimetables')
                        ->join('faculties','periodtimetables.tprofileid','faculties.id')
                        ->where('tportalid','FACULTY')
                        ->where('tsubjectid',$result['data'][$i]->id)
                         ->where('tclassid',$result['cl'])
                         ->where('tsectionid',$result['section'])
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

            

            


             $result['data'][$i]->thursday=count($m);


             $m=DB::table('periodtimetables')
                        ->join('faculties','periodtimetables.tprofileid','faculties.id')
                        ->where('tportalid','FACULTY')
                        ->where('tsubjectid',$result['data'][$i]->id)
                         ->where('tclassid',$result['cl'])
                         ->where('tsectionid',$result['section'])
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

                       

            


             $result['data'][$i]->friday=count($m);


             $m=DB::table('periodtimetables')
                        ->join('faculties','periodtimetables.tprofileid','faculties.id')
                        ->where('tportalid','FACULTY')
                        ->where('tsubjectid',$result['data'][$i]->id)
                         ->where('tclassid',$result['cl'])
                         ->where('tsectionid',$result['section'])
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

                       


             $result['data'][$i]->saturday=count($m);

         }
        return view('classteacher.classindex',$result);
    }

}
