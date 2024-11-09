<?php

namespace App\Http\Controllers\manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\training;
use Redirect,Response;

class trainingprogramcontroller extends Controller
{
    public function trainingprogram(Request $request){
        $mid=session()->get('MANAGER_ID');
        $result['trainingtypes']=DB::table('trainingtypes')->get();
        $result['trainingprogram']=[];
        return view('manager.trainingprogram',$result);
    }

    public function trainingprogramby(Request $request){
        $mid=session()->get('MANAGER_ID');
        $result['trainingtypes']=DB::table('trainingtypes')->get();
        $result['trainingprogram']=DB::table('trainings')
                                ->join('trainingtypes','trainingtypes.id','trainings.trainingtype')
                                ->where('trainings.trainingtype',$request->post('trainingtype'))
                                ->where('trainings.domain',$request->post('subject'))
                                ->where('trainings.mid',$mid)
                                ->select('trainingtypes.type','trainings.*')
                                ->get();
        return view('manager.trainingprogram',$result);
    }

    public  function getsubjects(request $request){
        $mid=session()->get('MANAGER_ID');
        $trainingtypeid = $request->post('trainingtypeid');
        $state = DB::table('domains')
                ->join('trainings','trainings.domain','domains.id')
                ->where('trainings.trainingtype',$trainingtypeid)
                ->where('trainings.mid',$mid)
                ->select('domains.*')
                ->distinct('trainings.domain')
                ->get();
        echo $html='<option value="">Select</option>';
        foreach($state as $list){
          echo  $html='<option value="'.$list->id.'">'.$list->domain.'</option>';
        }
    } 

    public function addtrainingprogram(Request $request,$id=""){      
        if($id>0){
            $arr=training::where(['id'=>$id])->get();
            $result['id']=$arr['0']->id;
            $result['trainingtype']=$arr['0']->trainingtype;
            $result['trainingname']=$arr['0']->trainingname;
            $result['facultyid']=$arr['0']->facultyid;
            $result['category']=$arr['0']->category;
            $result['domain']=$arr['0']->domain;
            $result['skillset']=$arr['0']->skillset;
            $result['skillattribute']=$arr['0']->skillattribute;
            $result['description']=$arr['0']->description;
            $result['image']=$arr['0']->image;
            $skillset=explode("##",$arr['0']->skillset);
            $result['skillsets']=DB::table('skillsets')->whereIn('id',$skillset)->get();
        }
        else{
            $result['id']='';
            $result['trainingtype']='';
            $result['trainingname']='';
            $result['facultyid']='';
            $result['category']='';
            $result['domain']='';
            $result['skillset']='';
            $result['skillattribute']='';
            $result['description']='';
            $result['image']='';
            $result['skillsets']='';    
        }
        $aid=session()->get('MANAGER_ADMIN_ID');
        $classid=session()->get('MANAGER_CLASS_ID');
        $result['categories']=DB::table('categories')->where('id',$classid)->get();
        $result['faculties']=DB::table('faculties')->where('aid',$aid)->get();
        $result['trainingtypes']=DB::table('trainingtypes')->get();
        return view("manager.addtrainingprogram",$result);
    }

    public function savetrainingprogram(Request $request){
        if($request->post('id')>0){
            $model=training::find($request->post('id'));
            $msg="Training updated";
        }
        else{
            $model=new training();
            $msg="Training inserted";
        }

        if($request->hasfile('image')){  
            $image=$request->file('image');
            $ext=$image->extension();
            $image_name=time().'.'.$ext;
            $image->move(public_path().'/trainingimages',$image_name);
            $model->image=$image_name;
        }

        $model->aid=session()->get('MANAGER_ADMIN_ID');
        $model->mid=session()->get('MANAGER_ID');
        $model->facultyid=$request->post('facultyid');
        $model->trainingtype=$request->post('trainingtype');
        $model->trainingname=$request->post('trainingname');
        $model->category=$request->post('category');
        $model->domain=$request->post('domain');
        if ($request->post('trainingtype')=="1") {
            $model->skillset=$request->post('skillset');
            $model->skillattribute=$request->post('skillattribute');
        } else {
            $model->skillset=implode("##",$request->post('skillset'));
            $model->skillattribute=0;
        }
        
        $model->description=$request->post('description');
        $model->status=1;
        $model->save();
        $request->session()->flash('message',$msg);
        return redirect('manager/trainingprogram');
    }

    public function trainingprogramstatus(Request $request,$status,$id){
        $model=training::find($id);
        $model->status=$status;
        $model->save();
        $request->session()->flash('message','Training Program Updated');
        return redirect('manager/trainingprogram');
    }

    public function trainingprogramdelete(Request $request,$id) {
        $model=training::find($id);
        $ans=$model->trainingtype;
        $model->delete();
        $request->session()->flash('message','Training Program Deleted');
        return redirect('manager/trainingprogram');       
    }


     public  function getdomain()
    {
        $id = $_GET['myID'];
        $res = DB::table('domains')
        ->where('category',$id)
        ->get();
        return Response::json($res);
 
    }
    public  function getskillset()
    {
        $id = $_GET['id'];
        $res = DB::table('skillsets')
        ->where('domain', $id)
        ->get();
        return Response::json($res);
    }

     public  function getskillattribute()
    {
        $id = $_GET['id'];
        $res = DB::table('skillattributes')
        ->where('skillset', $id)
        ->get();
        return Response::json($res);
    }

}