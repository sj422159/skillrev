<?php

namespace App\Http\Controllers\admin;

use App\Models\assesmentsections;
use App\Models\assesments;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Redirect,Response;
use Illuminate\Support\Facades\DB;

class lmsassesmentsectionscontroller extends Controller
{
    
    public function index(Request $request,$id='')
    {
        if($id!=''){
          $section=DB::table('assesmentsections')->where(['id'=>$id])->get();
          $result['id']=$section[0]->ass_id;
          $result['subskillset']=$section[0]->skillset;
          $result['skillset']=$section[0]->domain;
          $result['sectionname']=$section[0]->sectionname;
          $result['sectionduration']=$section[0]->sectionduration;
          $result['skillgroup']=$section[0]->category;
          $result['totalquestions']=$section[0]->totalquestions;
          $result['pass']=$section[0]->sectionpass;
          $skill1=$section[0]->skillattrs;
          $skill2 = ltrim($skill1, ',');
           $result['skill_arr'] = explode (",", $skill2); 
           $result['subs']=[];
           $result['skillid']=[];
           $result['skillatt']=[];
           $sc=0;
            for($i=0;$i<count($result['skill_arr']);$i++){
                $data=DB::table('skillattributes')
                      ->join('skillsets','skillattributes.skillset','=','skillsets.id')
                      ->where('skillattributes.id',$result['skill_arr'][$i])
                      ->select('skillattributes.id','skillattributes.skillattribute','skillsets.skillset')->get();
                if(count($data)>0){
                 $result['subs'][$sc]=$data[0]->skillset;
                 $result['skillid'][$sc]=$data[0]->id;
                 $result['skillatt'][$sc]=$data[0]->skillattribute;
                 $sc++;
                }
            }
          $questions1=$section[0]->noofquestions;

          $questions2 = ltrim($questions1, ',');
          //return $questions2;
          $result['questions3'] = explode (",", $questions2);
          //return $result['questions3'];

          $level1=$section[0]->level;
          $level2 = ltrim($level1, ',');
          $result['level3'] = explode (",", $level2);
          //return $result['level3'];
  
          $time1=$section[0]->time;
          $time2 = ltrim($time1, ',');
          $result['time3'] = explode (",", $time2);
          $result['levels']=DB::table('difficultylevel')->get();
          $result['count']=count( $result['skill_arr']);
          $result['sectionid']=$id;
         // return $result;
          
        return view('admin.assesmentordering',$result);


       }else{
        $sections=$request->post('section');
        $result['totalsubskillset']=$sections;
       
        $skillsets=$request->post('skillset');
        $result['sectionid']=$id;
        $result['id']=$request->post('id');
        $result['sectionname']=$request->post('sectionname');

        $chapter=$request->post('chapter');
        if($request->post('trainingtype')=="1"){
          $result['sectionset']=DB::table('skillattributes')
                          ->join('skillsets','skillattributes.skillset','=','skillsets.id')
                          ->where('skillattributes.id',$chapter)
                          ->select('skillattributes.id','skillattributes.skillattribute','skillsets.skillset')
                          ->get();
        }
        else{
        $result['sectionset']=DB::table('skillattributes')
                          ->join('skillsets','skillattributes.skillset','=','skillsets.id')
                          ->whereIn('skillattributes.skillset',$sections)
                          ->select('skillattributes.id','skillattributes.skillattribute','skillsets.skillset')
                          ->get();
        }
        $ite= count($result['sectionset']);
        $skill='';
        $skillid='';
        $subs='';
        for($i=0;$i<$ite;$i++){
          $skill=$skill.','.$result['sectionset'][$i]->skillattribute;
          $skillid=$skillid.','.$result['sectionset'][$i]->id;
          $subs=$subs.','.$result['sectionset'][$i]->skillset;
        }
       // return $skill;
        $string3= ltrim($subs,',');
        $result['subs']=explode(",",$string3);
        $string4= ltrim($skillid,',');
        $result['skillid']=explode(",",$string4);
        $string2 = ltrim($skill, ',');
        $result['skill_arr'] = explode (",", $string2); 
      
         $result['skillgroup']=$request->post('skillgroup');
         $result['skillset']=implode(',',$skillsets);
         $result['subskillset']=implode(',',$sections);
         $result['levels']=DB::table('difficultylevel')->get();
         $result['questions3']='';
         $result['level3']='';
         $result['time3']='';
         $result['count']=0;
         $result['sectionduration']='';
         $result['pass']='';
         $result['totalquestions']='';
       // return $result['subs'];
         // return $result;
         return view('admin.assesmentordering',$result);
     }
     
    }

    public function createsession(Request $request){


    $ass_id=$request->post('ass_id');
    $count=count($request->post('skr'));
    $subskillset=$request->post('subskillset');
    $skr='';
    $questions='';
    $level='';
    $time='';
    for($i=0;$i<$count;$i++){
      $skr=$skr.','.$request->post('skr')[$i];
      $questions=$questions.','.$request->post('noquestions')[$i];
      $level=$level.','.$request->post('level')[$i];
      $time=$time.','.$request->post('time')[$i];
    }
     if($request->post('sectionid')!=''){
        $model=assesmentsections::find($request->post('sectionid'));
    }else{
    $model= new assesmentsections();
    }
    $model->ass_id=$ass_id;
    $model->sectionname=$request->post('sectionname');
    $model->sectionduration=$request->post('sectionduration');
    $model->sectionpass=$request->post('secpass');
    $model->domain=$request->post('skillset');
    $model->skillset=$subskillset;
    $model->skillattrs=$skr;
    $model->noofquestions=$questions;
    $model->category=$request->post('skillgroup');
    $model->totalquestions=$request->post('totalquestion');
    $model->sectionpass=$request->post('pass');
    $model->level=$level;
    $model->time=$time;
    $model->save();

    

    $result['data']=DB::table('assesments')->where(['id'=>$ass_id])->get();

    $result['trainingtype']=$result['data'][0]->ttype;

    $result['sections']=DB::table('assesmentsections')->where(['ass_id'=>$result['data'][0]->id])
       ->join('skillsets','assesmentsections.skillset','=','skillsets.id')
       ->join('domains','assesmentsections.domain','=','domains.id')
       ->orderBy('ordering','Asc')
       ->select('skillsets.skillset','domains.domain','assesmentsections.ordering','assesmentsections.id','assesmentsections.sectionname','assesmentsections.sectionduration','assesmentsections.sectionpass','assesmentsections.totalquestions')->get();

    
       $managerclassid=DB::table('managers')->where('id',$result['data'][0]->mid)->get();
       $result['categories']=DB::table('categories')->where('id',$managerclassid[0]->classid)->get();

       $trainings=DB::table('trainings')->where('id',$result['data'][0]->train)->get();
       $result['domains']=DB::table('domains')->where('id',$trainings[0]->domain)->get();

       if ($result['data'][0]->ttype=="1") {
          $result['skillsets']=DB::table('skillsets')->where('id',$trainings[0]->skillset)->get(); 
          $result['skillattributes']=DB::table('skillattributes')->where('id',$trainings[0]->skillattribute)->get(); 
       } else {
          $skillsetid=explode("##",$trainings[0]->skillset);
          $result['skillsets']=DB::table('skillsets')->whereIn('id',$skillsetid)->get(); 
          $result['skillattributes']=[]; 
       }
    
    return view('admin.assesmentsection',$result);

   }

   public function comodule(Request $request){
     $count= count($request->post('sectionid'));
     $sectionid=$request->post('sectionid');
     $section = array_map('intval', $sectionid);
     $order=$request->post('order');
     $ordering = array_map('intval', $order);
     //return $ordering;
     for($i=0;$i<$count;$i++){
      $model=assesmentsections::find($section[$i]);
      $model->ordering=$ordering[$i];
      $model->save();
     }

    $model=assesments::find($request->post('id'));
    $model->status=1;
    $model->save();


    return redirect('admin/assesments');
   }

    public function delete(Request $request,$id){
       $model=assesmentsections::find($id);
       $result['data']=DB::table('assesments')->where(['id'=>$model->ass_id])->get();
       $model->delete();
       
       $request->session()->flash('message','section Deleted');
        return redirect()->route('cocreate', ['training'=>$result['data'][0]->train,'atype'=>$result['data'][0]->asstype,'assesmenttotaltime'=>$result['data'][0]->time,'assesmentimage'=>$result['data'][0]->img,'ttype'=>$result['data'][0]->ttype,'training'=>$result['data'][0]->train,'sdesc'=>$result['data'][0]->sdes,'id'=>$result['data'][0]->id]);
    }
}