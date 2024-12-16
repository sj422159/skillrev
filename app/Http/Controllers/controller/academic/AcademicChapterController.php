<?php

namespace App\Http\Controllers\Controller\Academic;

use App\Http\Controllers\Controller; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\domain;
use App\Models\category;
use App\Models\skillattribute;
use Redirect,Response;

class AcademicChapterController extends Controller
{
    public function skillattribute(Request $request){
        $aid=session()->get('Controller_ADMIN_ID');
        $Controller_ID=session()->get('Controller_ID');
        $result['groups']=DB::table('groups')->where('aid',$aid)->orwhere('Controller_ID',$Controller_ID)->get();
        $result['groupid']='';
        $result['categoryid']='';
        $result['domainid']='';
        $result['skillsetid']='';
        $result['skillattribute']=[];
        return view('controller.academ.skillattribute',$result);
    }

    public function skillattributebyskillset(Request $request){
        $aid=session()->get('Controller_ADMIN_ID');
        $Controller_ID=session()->get('Controller_ID');
        $groupid=$request->post('group');
        $category=$request->post('category');
        $domain=$request->post('domain');
        $skillset=$request->post('skillset');
        $result['groups']=DB::table('groups')->where('aid',$aid)->orwhere('Controller_ID',$Controller_ID)->get();
        $result['groupid']=$groupid;
        $result['categoryid']=$category;
        $result['domainid']=$domain;
        $result['skillsetid']=$skillset;
        $result['skillattribute']=DB::table('skillattributes')->where('skillset',$skillset)->get();
        return view('controller.academ.skillattribute',$result);
    }

    public function addskillattribute(Request $request,$id=""){      
        if($id>0){
            $arr=skillattribute::where(['id'=>$id])->get();
            $result['id']=$arr['0']->id;
            $result['groupid']=$arr['0']->groupid;
            $result['category']=$arr['0']->category;
            $result['domain']=$arr['0']->domain;
            $result['skillset']=$arr['0']->skillset;
            $result['skillattribute']=$arr['0']->skillattribute;
        }
        else{
            $result['id']='';
            $result['groupid']='';
            $result['category']='';
            $result['domain']='';
            $result['skillset']='';
            $result['skillattribute']='';    
        }
        $aid=session()->get('Controller_ADMIN_ID');
        $Controller_ID=session()->get('Controller_ID');
        $result['groups']=DB::table('groups')->where('aid',$aid)->orwhere('Controller_ID',$Controller_ID)->get();
        return view("controller.academ.addskillattribute",$result);
    }
     
    public function saveskillattribute(Request $request){
        
        if($request->post('id')>0){
            $model=skillattribute::find($request->post('id'));
            $msg="Skillattribute updated";
            if($model->skillset!=$request->post('skillset')){
                $name=DB::table('skillsets')->where('id',$request->post('skillset'))->get();
                $skillattributename=$name[0]->skillset.' _ '.$request->post('skillattribute');
                $model->skillattribute=$skillattributename;
            }
        }
        else{
            $model=new skillattribute();
            $msg="Skillattribute inserted";
            $name=DB::table('skillsets')->where('id',$request->post('skillset'))->get();
            $skillattributename=$name[0]->skillset.' _ '.$request->post('skillattribute');
            $model->skillattribute=$skillattributename;
        }
        $model->aid=session()->get('Controller_ADMIN_ID');
        $model->Controller_ID = session()->get('Controller_ID');
        $model->groupid=$request->post('groupid');
        $model->category=$request->post('category');
        $model->domain=$request->post('domain');
        $model->skillset=$request->post('skillset'); 
        $model->save();
        $request->session()->flash('message',$msg);
        return redirect()->route('academic_controller.skillattribute.byskillset', [
            'group' => $request->post('groupid'),
            'category' => $request->post('category'),
            'domain' => $request->post('domain'),
           'skillset'=>$request->post('skillset'),
        ]);

    }

    public function skillattributedelete(Request $request, $id){
        $model=skillattribute::find($id);
        $model->delete();
        $request->session()->flash('message','Skillattribute Deleted');
        return redirect('academic_controller/skillattribute');
    }

    public  function getdomain(){
        $id = $_GET['myID'];
        $res = DB::table('domains')->where('category',$id)->get();
        return Response::json($res);
    }

    public  function getskillset(){
        $id = $_GET['id'];
        $res = DB::table('skillsets')->where('domain', $id)->get();
        return Response::json($res);
    }

    public  function getskillattribute(){
        $id = $_GET['id'];
        $res = DB::table('skillattributes')->where('skillset', $id)->get();
        return Response::json($res);
    }
    public  function questionbankgetskillsets(request $request){
        $sid = $request->post('sid');
        $city = DB::table('skillsets')->where('domain', $sid)->get();
        echo $html='<option value="">Select</option>';
        foreach($city as $list){
        echo  $html='<option value="'.$list->id.'">'.$list->skillset.'</option>';
        }
    } 
    


}
