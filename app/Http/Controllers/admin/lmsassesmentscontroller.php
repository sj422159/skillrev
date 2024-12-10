<?php

namespace App\Http\Controllers\admin;

use App\Models\assesments;
use App\Models\assesmentsections;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Redirect,Response;

class lmsassesmentscontroller extends Controller
{

    public function  colist(Request $request){
        $sesid=session()->get('ADMIN_ID');
        $result['data']=DB::table('assesments')->where('status',1)->where('aid',$sesid)->get();
        return view('admin.assesments',$result);
    }

   public function createassesment(Request $request,$id=''){
   	  $sesid=session()->get('ADMIN_ID');
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
      $sesid=session()->get('ADMIN_ID');

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

    public function delete(Request $request,$id=''){
        $model=assesments::find($id);
        $model->delete();
        $model=assesmentsections::where('ass_id',$id)->delete();
        return redirect('admin/assesments');  
    }
}
