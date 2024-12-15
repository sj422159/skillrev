<?php

namespace App\Http\Controllers\Controller\Exam;

use App\Models\assesments;
use App\Models\assesmentsections;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Redirect,Response;

class Examassesment extends Controller
{

    public function  colist(Request $request){
        $sesid=session()->get('Controller_ADMIN_ID');
        $result['data']=DB::table('assesments')->where('status',1)->where('aid',$sesid)->get();
        return view('controller.exam.assesments',$result);
    }

   public function createassesment(Request $request,$id=''){
   	  $sesid=session()->get('Controller_ADMIN_ID');
   	    if($id>0){
            $arr=assesments::where(['id'=>$id])->get();
            $result['id']=$arr['0']->id;
            $result['assesmenttotaltime']=$arr['0']->time;
            $result['atype']=$arr['0']->asstype;
            $result['ttype']=$arr['0']->ttype;
            $result['training']=$arr['0']->train;
            $result['assesmentimage']=$arr['0']->img;
            $result['sdesc']=$arr['0']->sdes;
            $result['mid']=$arr['0']->mid;
        
          

         }else{
           $result['id']='';
           $result['assesmenttotaltime']='';
           $result['atype']='';
           $result['ttype']='';
           $result['training']='';
           $result['assesmentimage']='';
           $result['sdesc']='';
           $result['mid']='';

         }

     $result['trainings']=DB::table('trainingtypes')->get();    
     $result['asstype']=DB::table('asstypes')->get();
     $result['managers']=DB::table('managers')->where('aid',$sesid)->get();
     return view('admin.createassesment',$result);
    }

    public function gettrainings(){
   	    $id = $_GET['id'];
        $mid = $_GET['mid'];
        $res = DB::table('trainings')->where('trainingtype',$id)->where('mid',$mid)->get();
        return Response::json($res);
    }

    public  function getdomain(request $request){
        $cid = $request->post('cid');
        $state = DB::table('domains')->where('category', $cid)->get();
        $html='<option value="">Select</option>';
        foreach($state as $list){
        echo  $html='<option value="'.$list->id.'">'.$list->domain.'</option>';
        }
    } 

    public  function getskillset(request $request){
        $sid = $request->post('sid');
        $main=explode(',',$sid);
        $city = DB::table('skillsets')->whereIn('domain', $main)->get();
        $html='<option value="">Select</option>';
        foreach($city as $list){
        echo  $html='<option value="'.$list->id.'">'.$list->skillset.'</option>';
        }
    }

    public  function getskillattribute(request $request){
        $tid = $request->post('tid');
        $main=explode(',',$tid);
        $city = DB::table('skillattributes')->whereIn('skillset', $main)->get();
        $html='<option value="">Select</option>';
        foreach($city as $list){
        echo  $html='<option value="'.$list->id.'">'.$list->skillattribute.'</option>';
        }
    }

    public function createmodule(Request $request){
      if($request->post('id')>0){
        $model=assesments::find($request->post('id'));
      }else{
        $model=new assesments();
      }
      
      $name=DB::table('trainings')->where('id',$request->post('training'))->get();
      $assname=$request->post('atype').' - '.$name[0]->trainingname;

      $result['assesmentname']=$assname;
      $result['assesmenttotaltime']=$request->post('assesmenttotaltime');
      $result['trainingtype']=$request->post('ttype');
      $sesid=session()->get('Controller_ADMIN_ID');

      $model->aid=$sesid;
      $model->assesmentname=$assname;
       if($request->hasfile('assesmentimage')){  
            $image=$request->file('assesmentimage');
            $ext=$image->extension();
            $image_name=time().'.'.$ext;
            $image->move(public_path().'/assesmentimages',$image_name);
            $model->img=$image_name;
         }
         
      $model->asstype=$request->post('atype');
      $model->ttype=$request->post("ttype");
      $model->train=$request->post('training');
      $model->time=$request->post('assesmenttotaltime');
      $model->sdes=$request->post('sdesc'); 
      $model->mid=$request->post('mid'); 
      $model->save();

      $result['data']=DB::table('assesments')->where(['id'=>$model->id])->get();

       $result['sections']=DB::table('assesmentsections')->where(['ass_id'=>$result['data'][0]->id])
       ->join('skillsets','assesmentsections.skillset','=','skillsets.id')
       ->join('domains','assesmentsections.domain','=','domains.id')
       ->select('skillsets.skillset','domains.domain','assesmentsections.id','assesmentsections.sectionname','assesmentsections.skillset','assesmentsections.totalquestions','assesmentsections.sectionpass','assesmentsections.sectionduration','assesmentsections.ordering')->get();
        
       $managerclassid=DB::table('managers')->where('id',$request->post('mid'))->get();
       $result['categories']=DB::table('categories')->where('id',$managerclassid[0]->classid)->get();

       $trainings=DB::table('trainings')->where('id',$request->post('training'))->get();
       $result['domains']=DB::table('domains')->where('id',$trainings[0]->domain)->get();

       if ($request->post("ttype")=="1") {
          $result['skillsets']=DB::table('skillsets')->where('id',$trainings[0]->skillset)->get(); 
          $result['skillattributes']=DB::table('skillattributes')->where('id',$trainings[0]->skillattribute)->get(); 
       } else {
          $skillsetid=explode("##",$trainings[0]->skillset);
          $result['skillsets']=DB::table('skillsets')->whereIn('id',$skillsetid)->get(); 
          $result['skillattributes']=[]; 
       }
       
      return view('admin.assesmentsection',$result);

   }

  

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
