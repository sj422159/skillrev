<?php

namespace App\Http\Controllers\controller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\controllers;
use Illuminate\Support\Facades\DB;
use Redirect,Response;
use Illuminate\Support\Facades\Session;
use App\Models\answer;
use App\Models\finalanswer;
use App\Models\assesmentbooking;
use App\Models\assesments;
use App\Models\assesmentsections;
use App\Models\stureports;
use App\Models\studentassignation;
use App\Models\studentbooking;

class controllerlife extends Controller
{
  public function assindex($id){
    $sesid = session()->get('Controller_ADMIN_ID');
    $Controller_id = session()->get('Controller_ID');
    $controller = controllers::find($Controller_id);
    $result['layout'] = match ($controller->Controller_role_ID) {
      1 => 'controller/academ/layout',
      2 => 'controller/exam/elayout',
      3 => 'controller/account/Alayout',
      default => 'layouts/default',
    };

    $result['data'] = DB::table('studentassignations')
      ->join('managers', 'studentassignations.mid', 'managers.id')
      ->join('trainings', 'studentassignations.trainingid', 'trainings.id')
      ->join('categories', 'studentassignations.classid', 'categories.id')
      ->join('lmssections', 'studentassignations.sectionid', 'lmssections.id')
      ->where('studentassignations.trainingtype', $id)
      ->where('cyclestatus', 1)
      ->where('studentassignations.aid', $sesid)
      ->select('studentassignations.*', 'lmssections.section', 'trainings.trainingname', 'categories.categories', 'managers.mname')->get();

    for ($i = 0; $i < count($result['data']); $i++) {
      $count = DB::table('studentbookings')->where('assignid', $result['data'][$i]->id)->get();
      $pcount = DB::table('studentbookings')->where('assignid', $result['data'][$i]->id)
        ->where(function ($query) {
          $query->where('preresult', "=", "PASS")
            ->orWhere('manpreapprove', "!=", 0);
        })->get();

      $result['data'][$i]->stucount = count($count);
      $result['data'][$i]->pcount = count($pcount);
    }

    $result['train'] = $id;
    return view('controller.assignedbatch', $result);
  }

  public function assstudents($id){
    $Controller_id = session()->get('Controller_ID');
    $controller = controllers::find($Controller_id);
    $result['layout'] = match ($controller->Controller_role_ID) {
      1 => 'controller/academ/layout',
      2 => 'controller/exam/elayout',
      3 => 'controller/account/Alayout',
      default => 'layouts/default',
    };

    $result['data'] = DB::table('studentbookings')
      ->join('students', 'studentbookings.sid', 'students.id')
      ->join('trainings', 'studentbookings.trainingid', 'trainings.id')
      ->where('studentbookings.assignid', $id)
      ->select('studentbookings.*', 'trainings.trainingname', 'students.sname', 'students.image')
      ->get();
    $result['train'] = $id;
    return view('controller.assigned', $result);
  }

  public function attindex($id){
    $sesid = session()->get('Controller_ADMIN_ID');
    $Controller_id = session()->get('Controller_ID');
    $controller = controllers::find($Controller_id);
    $result['layout'] = match ($controller->Controller_role_ID) {
      1 => 'controller/academ/layout',
      2 => 'controller/exam/elayout',
      3 => 'controller/account/Alayout',
      default => 'layouts/default',
    };

    $result['data'] = DB::table('studentassignations')
      ->join('trainings', 'studentassignations.trainingid', 'trainings.id')
      ->join('categories', 'studentassignations.classid', 'categories.id')
      ->join('lmssections', 'studentassignations.sectionid', 'lmssections.id')
      ->where('studentassignations.trainingtype', $id)
      ->where('cyclestatus', 2)
      ->where('studentassignations.aid', $sesid)
      ->select('studentassignations.*', 'lmssections.section', 'trainings.trainingname', 'categories.categories')->get();
    for ($i = 0; $i < count($result['data']); $i++) {
      $count = DB::table('studentbookings')->where('assignid', $result['data'][$i]->id)->get();

      $result['data'][$i]->stucount = count($count);
    }
    $result['train'] = $id;
    return view('controller.attendedbatch', $result);
  }

  public function attstudents($id){
    $Controller_id = session()->get('Controller_ID');
    $controller = controllers::find($Controller_id);
    $result['layout'] = match ($controller->Controller_role_ID) {
      1 => 'controller/academ/layout',
      2 => 'controller/exam/elayout',
      3 => 'controller/account/Alayout',
      default => 'layouts/default',
    };

    $result['data'] = DB::table('studentbookings')
      ->join('students', 'studentbookings.sid', 'students.id')
      ->join('trainings', 'studentbookings.trainingid', 'trainings.id')
      ->where('studentbookings.assignid', $id)
      ->select('studentbookings.*', 'trainings.trainingname', 'students.sname', 'students.image')
      ->get();
    for ($i = 0; $i < count($result['data']); $i++) {
      $num = DB::table('studentassignmentbookings')->where('sbookingid', $result['data'][$i]->id)->get();
      $comp = 0;
      for ($m = 0; $m < count($num); $m++) {
        if ($num[$m]->status == "4") {
          $comp++;
        }
      }
      $result['data'][$i]->totassigned = count($num);
      $result['data'][$i]->comassigned = $comp;
    }
    $result['train'] = $id;
    return view('controller.attended', $result);
  }

  public function assignments($id){
    $Controller_id = session()->get('Controller_ID');
    $controller = controllers::find($Controller_id);
    $result['layout'] = match ($controller->Controller_role_ID) {
      1 => 'controller/academ/layout',
      2 => 'controller/exam/elayout',
      3 => 'controller/account/Alayout',
      default => 'layouts/default',
    };

    $result['data'] = DB::table('studentassignmentbookings')
      ->join('faculties', 'studentassignmentbookings.fid', 'faculties.id')
      ->where('sbookingid', $id)->select('studentassignmentbookings.*', 'faculties.fname')->get();
    return view('controller.studentassignments', $result);
  }

  public function comstudents($id){
    $Controller_id = session()->get('Controller_ID');
    $controller = controllers::find($Controller_id);
    $result['layout'] = match ($controller->Controller_role_ID) {
      1 => 'controller/academ/layout',
      2 => 'controller/exam/elayout',
      3 => 'controller/account/Alayout',
      default => 'layouts/default',
    };

    $result['data'] = DB::table('studentbookings')
      ->join('students', 'studentbookings.sid', 'students.id')
      ->join('trainings', 'studentbookings.trainingid', 'trainings.id')
      ->where('studentbookings.assignid', $id)
      ->select('studentbookings.*', 'trainings.trainingname', 'students.sname', 'students.image')
      ->get();

    for ($i = 0; $i < count($result['data']); $i++) {
      $num = DB::table('studentassignmentbookings')->where('sbookingid', $result['data'][$i]->id)->get();
      $comp = 0;
      for ($m = 0; $m < count($num); $m++) {
        if ($num[$m]->status == "4") {
          $comp++;
        }
      }
      $result['data'][$i]->totassigned = count($num);
      $result['data'][$i]->comassigned = $comp;
    }
    $result['train'] = $id;
    return view('controller.justcompleted', $result);
  }

  public function comindex($id){
    $sesid = session()->get('Controller_ADMIN_ID');
    $Controller_id = session()->get('Controller_ID');
    $controller = controllers::find($Controller_id);
    $result['layout'] = match ($controller->Controller_role_ID) {
      1 => 'controller/academ/layout',
      2 => 'controller/exam/elayout',
      3 => 'controller/account/Alayout',
      default => 'layouts/default',
    };

    $result['data'] = DB::table('studentassignations')
      ->join('trainings', 'studentassignations.trainingid', 'trainings.id')
      ->join('categories', 'studentassignations.classid', 'categories.id')
      ->join('lmssections', 'studentassignations.sectionid', 'lmssections.id')
      ->where('studentassignations.trainingtype', $id)
      ->where('cyclestatus', 3)
      ->where('studentassignations.aid', $sesid)
      ->select('studentassignations.*', 'lmssections.section', 'trainings.trainingname', 'categories.categories')->get();
    for ($i = 0; $i < count($result['data']); $i++) {
      $count = DB::table('studentbookings')->where('assignid', $result['data'][$i]->id)->get();

      $result['data'][$i]->stucount = count($count);
    }
    $result['appdata'] = DB::table('studentassignations')
      ->join('trainings', 'studentassignations.trainingid', 'trainings.id')
      ->join('lmssections', 'studentassignations.sectionid', 'lmssections.id')
      ->join('categories', 'studentassignations.classid', 'categories.id')
      ->where('studentassignations.trainingtype', $id)
      ->where('cyclestatus', 4)
      ->where('studentassignations.aid', $sesid)
      ->select('studentassignations.*', 'lmssections.section', 'trainings.trainingname', 'categories.categories')->get();
    for ($i = 0; $i < count($result['appdata']); $i++) {
      $count = DB::table('studentbookings')->where('assignid', $result['appdata'][$i]->id)->get();
      $result['appdata'][$i]->stucount = count($count);
    }

    $result['train'] = $id;
    return view('controller.completedbatch', $result);
  }

  public function comapstudents($id){
    $sesid = session()->get('Controller_ADMIN_ID');
    $Controller_id = session()->get('Controller_ID');
    $controller = controllers::find($Controller_id);
    $result['layout'] = match ($controller->Controller_role_ID) {
      1 => 'controller/academ/layout',
      2 => 'controller/exam/elayout',
      3 => 'controller/account/Alayout',
      default => 'layouts/default',
    };

    $result['appdata'] = DB::table('studentbookings')
      ->join('students', 'studentbookings.sid', 'students.id')
      ->join('trainings', 'studentbookings.trainingid', 'trainings.id')
      ->where('studentbookings.assignid', $id)
      ->where('postapprove', 1)
      ->where('studentbookings.aid', $sesid)
      ->select('studentbookings.*', 'trainings.trainingname', 'students.sname', 'students.image')
      ->get();
    $result['cid'] = $id;
    return view('controller.completed', $result);
  }


  public function sectionreports($bid,$id){
    $book=DB::table('studentbookings')->where('id',$bid)->get();
  
  
  $sid=session()->get('Controller_ID');
  
  $fans=DB::table('finalanswers')->where('id',$id)->get();
   
   $result['swot']=$fans[0]->id;
  
 $result['count']=count($fans);
 for($w=0;$w<count($fans);$w++){
 
  $id=$fans[$w]->assid;
  $result['data'][$w]=DB::table('assesments')
                    ->select('assesments.assesmentname')
                    ->where('assesments.id',$id)->get();
      $asfname=$result['data'][$w][0]->assesmentname;
    $skills=DB::table('assesmentsections')->where('ass_id',$id)->orderBy('ordering')->get();
    $result['sec']=$skills;
    $count=count($skills);
    $str='';
    $noque='';
    for($i=0;$i<$count;$i++){
       $b=$skills[$i]->noofquestions;
       $noque=$noque.$b;
       $a=$skills[$i]->skillattrs;
       $str=$str.$a;
   
    }
    $t=ltrim($noque,',,');
    $result['noque']=explode(',',$t);
    $s=ltrim($str,',,');
     $result['skills']=explode(',',$s);
     $result['scount']=count($result['skills']);
     $ans=$fans;

   $q_id=explode('&&/',$ans[0]->questionid);
   $answer=explode('&&/',$ans[0]->answer);
   $q_count=explode('&&/',$ans[0]->questionno);

   $skills=[];
   $score=[];
   $cnum=0;
   $r=0;
   $p=0;

   for($k=1;$k<count($q_id);$k++){
       if($q_id[$k]==""){
           continue; 
       }

         $que=DB::table('questionbanks')->where('id',$q_id[$k])->get();
         $name=DB::table('skillattributes')->where('id',$que[0]->skillattribute)->get();
          
       if($que[0]->RightChoices==$answer[$k]){
         $skills[$cnum] = $name[0]->id;

          if(array_key_exists( $name[0]->id,$score)){
               $score[$name[0]->id]=$score[$name[0]->id]+1;
          }else{
              $score[$name[0]->id]=1;
          }
          $r++;
       }else{
           $skills[$cnum] = $name[0]->id;
          if(array_key_exists( $name[0]->id,$score)){
               $score[$name[0]->id]=$score[$name[0]->id];
          }else{
              $score[$name[0]->id]=0;
          }
          $p++;
         
       }
       $cnum++;
   }
    $result['subskillset'][$w]=[];
    $result['section'][$w]=[];
    
   for($p=0;$p<$result['scount'];$p++){
       $atq=0;
       $skr= $result['skills'][$p];
        $n1=DB::table('skillattributes')
                      ->join('skillsets','skillattributes.skillset','=','skillsets.id')
                     ->where('skillattributes.id',$skr)
                     ->select('skillsets.skillset')->get();
       $tqskr=$result['noque'][$p];
       if(isset($score[$result['skills'][$p]])){
           $atq=($score[$result['skills'][$p]]);
       }else{
           $atq=0;
       }
        if($tqskr!=0 && $atq!=0){
       $per=round(($atq/$tqskr)*100,2);
       }else{
           $per=0;
       }
    $sname=$n1[0]->skillset;
   $sections=assesmentsections::where('skillattrs','LIKE','%'.$skr.'%')->where('ass_id',$id)->get();
    $secname=$sections[0]->sectionname;
     $result['res'][$w][$p]=array($skr,$tqskr,$atq,$per,$n1[0]->skillset,$sections[0]->sectionname);
    if(array_key_exists( $secname,$result['section'][$w])){
             $result['section'][$w][$secname][0]=$result['section'][$w][$secname][0]+$atq;

             $result['section'][$w][$secname][1]=$result['section'][$w][$secname][1]+$tqskr;

             $result['section'][$w][$secname][2]=round(($result['section'][$w][$secname][0]/$result['section'][$w][$secname][1])*100,2); 
             $result['section'][$w][$secname][3]=$secname;
          }else{
            $result['section'][$w][$secname]=array($atq,$tqskr,$per,$secname);   
          }



     if(array_key_exists( $sname,$result['subskillset'][$w])){
             $result['subskillset'][$w][$sname][0]=$result['subskillset'][$w][$sname][0]+$atq;

             $result['subskillset'][$w][$sname][1]=$result['subskillset'][$w][$sname][1]+$tqskr;

             $result['subskillset'][$w][$sname][2]=round(($result['subskillset'][$w][$sname][0]/$result['subskillset'][$w][$sname][1])*100,2); 
             $result['subskillset'][$w][$sname][3]=$sname;
             $result['subskillset'][$w][$sname][4]=$secname;
          }else{
            $result['subskillset'][$w][$sname]=array($atq,$tqskr,$per,$sname,$secname);   
          }
        
        
   }
   $result['seccount']=count($result['section'][0]);
}
    $result['finalassname']=$asfname;
 
   
   return view('controller.sectionreport',$result);
}

public function detailedreport( request $request){
    $res= $request->post();
     $data=$res['res'];
     $sub=$res['sub'];
      $co=count($sub);
     for($i=0;$i<$co;$i++){
    $sub[$i]=explode('&%$',$sub[$i]);
     } 
     $count=count($data);
     for($i=0;$i<$count;$i++){
    $data[$i]=explode('&%$',$data[$i]);
     } 
     for ($i=0; $i <count($data) ; $i++) { 
         $name=DB::table('skillattributes')->where('id',$data[$i][0])->get();
         $data[$i][5]=$name[0]->skillattribute;
     }
    $result['data'] =$data;
    $result['sub']=$sub;
    $result['subcount']=count($sub);
    $result['count']=count($data);
    $result['aname']=$request->post('aname');
    $result['subs']=$request->post('attr');
   return view('controller.detailedreport',$result);
}

public function swot($id){
   
   $model=finalanswer::find($id);
   $result['name']=DB::table('assesments')->where('id',$model->assid)->get();
   $result['a']=$model->a;
   $result['b']=$model->b;
   $result['c']=$model->c;
   $result['d']=$model->d;
    $result['studentimage']=DB::table('students')->where('id',$model->stid)->get();
   return view('controller.swot',$result);
}
}
