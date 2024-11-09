<?php

namespace App\Http\Controllers\manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\studentassignation;
use App\Models\studentbooking;
use App\Models\assesmentsections;
use App\Models\finalanswer;
use Redirect,Response;

class manageranalyticcontroller extends Controller
{
  
    public function index(){
         $mid=session()->get('MANAGER_ID');
        $d=DB::table('managers')->where("id",$mid)->get();
        $result['train']=DB::table('trainings')->where('mid',$mid)->where('status',1)->get();
        $result['class']=DB::table('categories')->get();
        $result['cl']=$d[0]->classid;
        $result['sec']=DB::table('lmssections')->where('classid',$d[0]->classid)->get();
        $result['tri']=0;
        $result['section']=0;
        $result['presec']=[];
        $result['postsec']=[];
        $result['cpass']=0;
        $result['cfail']=0;
        $result['fpass']=0;
        $result['ffail']=0;
        $result['capprove']=0;
        $result['fapprove']=0;
        return view('manager.analytics',$result);
    }

    public function fetch(request $request){
            $mid=session()->get('MANAGER_ID');
        $d=DB::table('managers')->where("id",$mid)->get();
        $result['train']=DB::table('trainings')->where('mid',$mid)->where('status',1)->get();
        $result['class']=DB::table('categories')->get();
         $result['sec']=DB::table('lmssections')->where('classid',$d[0]->classid)->get();
        $result['cl']=$d[0]->classid;
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

     
     return view('manager.analytics',$result);
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

    
        $mid=session()->get('MANAGER_ID');
      $data=DB::table('studentbookings')
                        ->join('stureports','studentbookings.stureports','stureports.id')
                        ->where('trainingid',$request->post('train'))
                        ->where('ssectionid',$request->post('section'))
                        ->where('studentbookings.mid',$mid)
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

    
       $mid=session()->get('MANAGER_ID');
      $data=DB::table('studentbookings')
                        ->join('stureports','studentbookings.stureports','stureports.id')
                        ->where('trainingid',$request->post('train'))
                        ->where('ssectionid',$request->post('section'))
                        ->where('studentbookings.mid',$mid)
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


}
