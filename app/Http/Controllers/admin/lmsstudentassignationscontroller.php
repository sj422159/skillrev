<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\studentassignation;
use App\Models\studentbooking;
use App\Models\assesmentsections;
use App\Models\finalanswer;
use Redirect,Response;

class lmsstudentassignationscontroller extends Controller
{
     public function reports(){
        $aid=session()->get('ADMIN_ID'); 
        $d=DB::table('admins')->where("id",$aid)->get();
        $result['train']=DB::table('trainings')->where('aid',$aid)->where('status',1)->get();
        $result['class']=DB::table('categories')->where('aid',$aid)->get();
        $result['cl']=0;
        $result['tri']=0;
        $result['section']=0;
        $result['data']=[];
        return view('admin.reports',$result);
    }

    public function classby(){
       $id = $_GET['id'];
         $res = DB::table('lmssections')
        ->where('lmssections.classid', $id)
        ->get();
        return Response::json($res);
    }

     public function assignmentreport($id){
        $result['data']=DB::table('studentassignmentbookings')
                                ->join('trainings','studentassignmentbookings.trainingid','trainings.id')
                                 ->where('studentassignmentbookings.id',$id)->select('studentassignmentbookings.*','trainings.trainingname')->get();
        return view('admin.assignmentreportsection',$result);
    }

    public function fetchstu(request $request){
       $aid=session()->get('ADMIN_ID'); 
        $d=DB::table('admins')->where("id",$aid)->get();
       
        $result['train']=DB::table('trainings')->where('aid',$aid)->where('status',1)->get();
        $result['tri']=$request->post('training');
        $result['section']=$request->post('section');
        $result['class']=DB::table('categories')->where('aid',$aid)->get();
        $result['cl']=$request->post('class');
        $result['data']=DB::table('studentbookings')
                           ->join('students','studentbookings.sid','students.id')
                           ->join('trainings','studentbookings.trainingid','trainings.id')
                           ->join('lmssections','students.ssectionid','lmssections.id')
                           ->where('students.ssectionid',$request->post('section'))
                           ->where('studentbookings.trainingid',$request->post('training'))
                           ->select('studentbookings.*','students.sname','students.slname','trainings.trainingname','lmssections.section','students.image')
                           ->get();
        return view('admin.reports',$result);
    }


      public function sectionreports($bid,$id){
         $book=DB::table('studentbookings')->where('id',$bid)->get();
       
       
       $sid=session()->get('STUDENT_ID');
       
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
        // echo "<pre>";
        // print_r($score);
        // echo "--------------------------------------------------<br>";
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
        

       // echo $skr.'--'.$tqskr.'---'.$atq.'---'.$per."<br>";
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
               }else{
                 $result['section'][$w][$secname]=array($atq,$tqskr,$per,$secname);   
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
        $result['seccount']=count($result['section'][0]);
    }

    // echo "<pre>";
    //      print_r($result);
    //      echo "----------------------------";
    //      return 1;

      //return print_r($result['section'][0]);
         //return $result['res'];
       // return $result['data'][0]->sector;
       // return $result;
      
    
     //  return $result;
     
         $result['finalassname']=$asfname;
      
        
        return view('admin.sectionreport',$result);
    }

  public function detailedreport( request $request){
 // return $request->post();
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
        return view('admin.detailedreport',$result);
   }

   public function swot($id){
        
        $model=finalanswer::find($id);
        $result['name']=DB::table('assesments')->where('id',$model->assid)->get();
        $result['a']=$model->a;
        $result['b']=$model->b;
        $result['c']=$model->c;
        $result['d']=$model->d;
         $result['studentimage']=DB::table('students')->where('id',$model->stid)->get();
        return view('admin.swot',$result);
    }
}