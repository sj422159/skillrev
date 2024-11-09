<?php

namespace App\Http\Controllers\student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Redirect,Response;
use Illuminate\Support\Facades\Session;
use App\Models\answer;
use App\Models\finalanswer;
use App\Models\assesmentbooking;
use App\Models\temporaryans;
use App\Models\assesments;
use App\Models\assesmentsections;
use App\Models\stureports;
use App\Models\studentassignation;
use App\Models\studentbooking;


class mainexamcontroller extends Controller
{
    public function start($id,$asid,request $req){

        $result['data']=DB::table('assesments')->where('id',$id)->get();
        $assid=$result['data'][0]->id;
        $sid=session()->get('STUDENT_ID');
        $result['sec']=DB::table('assesmentsections')->where('ass_id',$assid)->orderBy('ordering')->get();
       $result['section']=DB::table('temporaryans')->where('stu_id',$sid)->where('ass_id',$id)->get();
      //    $result['section']=[];
        $result['sectionans']=[];
        $result['abid']=$asid;
        for($i=0;$i<count($result['section']);$i++){
            $result['sectionans'][$i]=($result['section'][$i]->sec_id);
        }
  
       return view('student.examstart',$result);
      }


    public function questions($id,$count,$abid){
        $result['secid']=$count;
        if(Session::has('questions['.$count.']')){
            Session::forget('questions['.$count.']');
        
             }
         $quec=0;
        $questions=[];
        $result['sec']=DB::table('assesmentsections')->where('id',$id)->get(); 
        $skill=$result['sec'][0]->skillattrs;
         $no=$result['sec'][0]->noofquestions;
         $level=$result['sec'][0]->level;
         $time=$result['sec'][0]->time;
         $skill1=explode(',', $skill);
         $no1=explode(',',$no);
         $level1=explode(',',$level);
         $time1=explode(',',$time);
         $c1=count($skill1);
         for($k=1;$k<$c1;$k++){
         $skill1[$k].''.$level1[$k].''.$no1[$k];
      //   $raw=DB::table('skill_attributes')->where('id',$skill1[$k])->get();
           
            $questions[$quec]=DB::table('questionbanks')->where('skillattribute','=',$skill1[$k])->where('difficultylevel','=',$level1[$k])
                  ->orderBy(DB::raw('RAND()'))
                 ->limit($no1[$k])->get();
             $quec++;

         } 
         $mainque[$count]=[];
      $mcount=0;
       for($j=0;$j<count($questions);$j++){
         for($m=0;$m<count($questions[$j]);$m++){
           
           $mainque[$count][$mcount]=$questions[$j][$m];
          
           $mcount++;

             
         } 
       
       }

        Session::push('questions['.$count.']', $mainque[$count]); 
       $quons=Session::get('questions['.$count.']');
       // echo "<pre>";
       // return print_r($quons);
       $result['finalque'] =count($quons[0]);
       $result['abid']=$abid;
       return view('student.exampage',$result);
         
    }
     public function getq(){
    
       $id = $_GET['id'];
       $assid=$_GET['assid'];
        $qcount=$_GET['count'];
        $sec=$_GET['sec'];
         $sid=session()->get('STUDENT_ID');
      $quons=Session::get('questions['.$sec.']');
       
      $fquestion=$quons[0][$qcount-1];
    if (isset($fquestion->answer))
     {

         $ans=$fquestion->answer;
       foreach($fquestion as $key => $val){
         if($ans==$val){
            $fquestion->anskey=$key;
            break;
         }      

       }
      }
        return Response::json($fquestion);

    }
    
     public function preq(){
       
       $id = $_GET['id'];
       $assid=$_GET['assid'];
       $qcount=$_GET['qcount'];
       $sec=$_GET['sec'];
       $sid=session()->get('STUDENT_ID');
       $quons=Session::get('questions['.$sec.']');
       $fquestion=$quons[0][$qcount-1];
       $ans=$fquestion->answer;
       foreach($fquestion as $key => $val){
         if($ans==$val){
            $fquestion->anskey=$key;
            break;
         }      

       }
        return Response::json($fquestion);

    }
    public function ans(){
       $sid=session()->get('STUDENT_ID');
       $ans = $_GET['id'];
       $assid=$_GET['assid'];
       $confident=$_GET['confident'];
       $qcount=$_GET['qcount'];
       $sec=$_GET['sec'];

       $result['0']=explode('$ans$',$ans);
       
       $finalq=(int)$qcount-1;
       
       $str='questions.'.$sec.'.0.'.$finalq;
       $quons=Session::get('questions['.$sec.']');
     // return $quons[0][0];
         //return $quons;
         $quons[0][$finalq]->q_id=$result['0']['1'];
         $quons[0][$finalq]->confident=$confident;
         $quons[0][$finalq]->answer=$result['0']['0'];
         $quons[0][$finalq]->qcount=$qcount;

       
       
         $quons=Session::get('questions['.$sec.']');
        //  echo "<pre>";
        // return print_r($quons);
       return Response::json($quons);
   }
 
  public function sectionsubmit($id,$sec,$abid){

      $id = $id;
     $result['data']=DB::table('assesmentsections')->where('id',$id)->get();

      $count=$sec;
      $sid=session()->get('STUDENT_ID');  
       $quons=Session::get('questions['.$count.']');
      $anscount=0;
      $questions='';
      $questionno='';
      $answer='';
      $confident='';
      for($m=0;$m<count($quons[0]);$m++){
         if (isset($quons[0][$m]->answer)){
             $anscount++;
               $questions=$questions.'&&/'.$quons[0][$m]->q_id;
         $questionno=$questionno.'&&/'.$quons[0][$m]->qcount;
         $answer=$answer.'&&/'.$quons[0][$m]->answer;
         $confident=$confident.'&&/'.$quons[0][$m]->confident;
          }
      }
      
    $model=new temporaryans();
    $model->stu_id=$sid;
    $model->sec_id=$id;
    $model->ass_id=$result['data'][0]->ass_id;
    $model->q_id=$questions;
    $model->answer=$answer;
    $model->q_count=$questionno;
    $model->confident=$confident;
    $model->save();
    if(Session::has('questions['.$count.']')){
            Session::forget('questions['.$count.']');
             }
     return redirect('student/exam/mainassement/'.$result['data'][0]->ass_id.'/'.$abid);
   }

   public function finalsubmit($id,$abid){
     $sid=session()->get('STUDENT_ID');
    $data=DB::table('temporaryans')->where('stu_id',$sid)->where('ass_id',$id)->get();
     $result['name']=DB::table('assesments')->where('id',$id)->get();
     $restype=$result['name'][0]->asstype;

     $questionid='';
     $answer='';
     $questionno='';
     $confident='';
     for($i=0;$i<count($data);$i++){
        $questionid=$data[$i]->q_id.'&&/'.$questionid;
        $answer=$data[$i]->answer.'&&/'.$answer;
        $questionno=$data[$i]->q_count.'&&/'.$questionno;
        $confident=$data[$i]->confident.'&&/'.$confident;
     }

     $model=new finalanswer();
     $model->stid=$sid;
     $model->assid=$id;
     $model->abid=$abid;
     $model->questionid=$questionid;
     $model->answer=$answer;
     $model->questionno=$questionno;
     $model->confident=$confident;
     $model->save();
     
     for($i=0;$i<count($data);$i++){

       $mo=temporaryans::find($data[$i]->id);
    //  $mo->delete();

     }

     $q_id=explode('&&/',$questionid);
        $ans=explode('&&/',$answer);
       $con=explode('&&/',$confident);

       $tc=0;
       $tnc=0;

       For($n=1;$n<count($con);$n++){
        if($con[$n]==0){
            $tnc++;
           // echo $n."--0--<br>";
        }
        if($con[$n]==1){
           $tc++;
           //echo $n."---1--<br>";
        }
       }
      //return $q_id;

        $skills=[];
        $score=[];
        $cnum=0;
        $cc=0;
        $cnc=0;
        $nc=0;
        $nnc=0;
       
      
        for($k=0;$k<count($q_id);$k++){
            if(empty($q_id[$k])){
               continue;
            }
       //     echo $k;
            $que=DB::table('questionbanks')->where('id',$q_id[$k])->get();
              $name=DB::table('skillattributes')->where('id',$que[0]->skillattribute)->get();
              //return  $que[0]->RightChoices."--".
            if($que[0]->RightChoices==$ans[$k]){
              $skills[$cnum] = $name[0]->skillattribute;
                   
               if(array_key_exists( $name[0]->skillattribute,$score)){
                    $score[$name[0]->skillattribute]=$score[$name[0]->skillattribute]+1;
               }else{
                   $score[$name[0]->skillattribute]=1;
               }
               if($con[$k]==0){
                  $nc++;
               }
               if($con[$k]==1){
                   $cc++;
               }
             
            }else{
                $skills[$cnum] = $name[0]->skillattribute;
               if(array_key_exists( $name[0]->skillattribute,$score)){
                    $score[$name[0]->skillattribute]=$score[$name[0]->skillattribute];
               }else{
                   $score[$name[0]->skillattribute]=0;
               }
              if($con[$k]==0){
                  $nnc++;
               }
               if($con[$k]==1){
                  $cnc++;
               }
              
              
            }
            $cnum++;
        }
  
  //  echo $cc."--".$nc."--".$nnc."--".$cnc;
    if($tc>0){
    $result['cc']=round(($cc/$tc)*100,2);
    $result['cnc']=round(($cnc/$tc)*100,2);
    }
    else{
        $result['cc']=0;
        $result['cnc']=0;
    }
    if($tnc>0){
    $result['nc']=round(($nc/$tnc)*100,2);
    $result['nnc']=round(($nnc/$tnc)*100,2);
   }else{
    $result['nc']=0;
    $result['nnc']=0;
   }

    $result['studentimage']=DB::table('students')->where('id',$sid)->get();
        $answerid=$model->id;

         $fans=DB::table('finalanswers')->where('id',$answerid)->get();
     
        // $model=assesmentbooking::find($abid);
        // $model->astatus=1;
        // $model->save();
        
     
      $result['count']=count($fans);
      for($w=0;$w<count($fans);$w++){
      
       $id=$fans[$w]->assid;
       $result['data'][$w]=DB::table('assesments')
                           ->where('assesments.id',$id)->get();

         $skills=DB::table('assesmentsections')->where('ass_id',$id)->orderBy('ordering')->get();
         $secdet=$skills;
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
       $ans=DB::table('finalanswers')->where('id',$answerid)->get();
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
        //return $score;


        
         $result['subskillset'][$w]=[];
         $result['section'][$w]=[];
         
         $sc=0;


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
            //return $atq;
            if($tqskr!=0 && $atq!=0){
            $per=round(($atq/$tqskr)*100,2);
            }else{
                $per=0;
            }

        // echo $skr.'--'.$tqskr.'---'.$atq.'---'.$per."<br>";
         //return 1;
         $sname=$n1[0]->skillset;
         $sections=assesmentsections::where('skillattrs','LIKE','%'.$skr.'%')->where('ass_id',$id)->get();
         $secname=$sections[0]->sectionname;
          $result['res'][$w][$p]=array($skr,$tqskr,$atq,$per,$n1[0]->skillset,$sections[0]->sectionname);
       //  echo $secname."--".$skr."<br>";
         if(array_key_exists( $secname,$result['section'][$w])){
                  $result['section'][$w][$secname][0]=$result['section'][$w][$secname][0]+$atq;

                  $result['section'][$w][$secname][1]=$result['section'][$w][$secname][1]+$tqskr;
                  //  echo $result['section'][$w][$secname][1]."<br>--";
                  // echo "tq--".$tqskr."<br>";
                  // echo $secname."------skr".$skr."<br>";
                  $result['section'][$w][$secname][2]=round(($result['section'][$w][$secname][0]/$result['section'][$w][$secname][1])*100,2); 
                  $result['section'][$w][$secname][3]=$secname;
                  //$secdata[$sc]=$result['section'][$w][$secname];
               }else{
                 $result['section'][$w][$secname]=array($atq,$tqskr,$per,$secname); 
                // $secdata[$sc]=$result['section'][$w][$secname];

               }

            if(array_key_exists( $sname,$result['subskillset'][$w])){
                  $result['subskillset'][$w][$sname][0]=$result['subskillset'][$w][$sname][0]+$atq;

                  $result['subskillset'][$w][$sname][1]=$result['subskillset'][$w][$sname][1]+$tqskr;
                  //  echo $result['subskillset'][$w][$sname][1]."<br>--";
                  // echo "tq--".$tqskr."<br>";
                 // echo $sname."------skr".$skr."<br>";
                  $result['subskillset'][$w][$sname][2]=round(($result['subskillset'][$w][$sname][0]/$result['subskillset'][$w][$sname][1])*100,2); 
                  $result['subskillset'][$w][$sname][3]=$sname;
                  $result['subskillset'][$w][$sname][4]=$secname;
               }else{
                 $result['subskillset'][$w][$sname]=array($atq,$tqskr,$per,$sname,$secname);   
               }    
            
        }

    }
      // return $result['section'];
      
       $result['seccount']=count($result['section'][0]);
       $seccountno=count($secdet);
       $numc=0;
       $passcount=0;
       foreach($result['section'][0] as $list){
          if((int)$list[2]>=(int)$secdet[$numc]->sectionpass){
             $passcount++;
          }
          $numc++;

       }
      
       

         $bookmod=studentbooking::find($abid);
         if($restype=="Pre"){
         $bookmod->prereport=$answerid;
         $bookmod->pregiven=1;
         $att=$bookmod->preattempt;
         $bookmod->preattempt=$att+1;
         }else{
           $bookmod->postreport=$answerid; 
           $bookmod->postgiven=1;
           $att=$bookmod->postattempt;
         $bookmod->postattempt=$att+1;
         }
        $cd=finalanswer::find($model->id);
        $cd->a=$result['cc'];
        $cd->b=$result['cnc'];
        $cd->c=$result['nc'];
        $cd->d=$result['nnc'];
        $cd->save();

        if($restype=="Pre"){
           $mod=new stureports();
           $mod->stid=$bookmod->sid; 
           $mod->asstype=1;

            $mod->ans=$answerid;
           
            $mod->assid=$id;

             foreach($result['section'][0] as $list){
             if($sc==0){
                $mod->secA=$list[3];
                $mod->secAmark=$list[2];
             }
              if($sc==1){
                $mod->secB=$list[3];
                $mod->secBmark=$list[2];
             }
              if($sc==2){
                $mod->secC=$list[3];
                $mod->secCmark=$list[2];
             }
              if($sc==3){
                $mod->secD=$list[3];
                $mod->secDmark=$list[2];
             }
                $sc++;
            }

        if($seccountno==$passcount){
           $bookmod->preresult="PASS";
           $mod->result="PASS";    
           }else{
           $bookmod->preresult="FAIL";
            $mod->result="FAIL";
          }

        $mod->save(); 
        $bookmod->stureports=$mod->id; 
        $bookmod->save();

     }else{
        
            $mod=stureports::find($bookmod->stureports);
            $mod->postans=$answerid;
           
            $mod->postassid=$id;

             foreach($result['section'][0] as $list){
             if($sc==0){
                $mod->psecA=$list[3];
                $mod->psecAmark=$list[2];
             }
              if($sc==1){
                $mod->psecB=$list[3];
                $mod->psecBmark=$list[2];
             }
              if($sc==2){
                $mod->psecC=$list[3];
                $mod->psecCmark=$list[2];
             }
              if($sc==3){
                $mod->psecD=$list[3];
                $mod->psecDmark=$list[2];
             }
                $sc++;
            }

        if($seccountno==$passcount){
           $mod->postresult="PASS"; 
            $bookmod->postresult="PASS";   
           }else{
            $mod->postresult="FAIL";
             $bookmod->postresult="FAIL";
          }

          $mod->save(); 
        $bookmod->stureports=$mod->id; 
        $bookmod->save();



     }



       //  return 1456;
        return view('student.examswot',$result);

   }
}
