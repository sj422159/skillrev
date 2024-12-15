<?php

namespace App\Http\Controllers\Controller\Academic;

use App\Http\Controllers\Controller; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\category;
use App\Models\skillset;
use Redirect,Response;

class AcademicModuleController extends Controller
{
    public function skillset(Request $request){
        $Controller_ADMIN_ID=session()->get('Controller_ADMIN_ID');
        $controller_id=session()->get('Controller_ID');
        $result['groups']=DB::table('groups')->where('aid',$Controller_ADMIN_ID)->orwhere('Controller_ID',$controller_id)->get();
        $result['groupid']='';
        $result['categoryid']='';
        $result['domainid']='';
        $result['skillset']=DB::table('skillsets')->where('aid',$Controller_ADMIN_ID)->orwhere('Controller_ID',$controller_id)->get();
        return view('controller.academ.skillset',$result);
    }

    public function skillsetbydomain(Request $request){
        $Controller_ADMIN_ID=session()->get('Controller_ADMIN_ID');
        $controller_id=session()->get('Controller_ID');
        $groupid=$request->post('group');
        $category=$request->post('category');
        $domain=$request->post('domain');
        $result['groups']=DB::table('groups')->where('aid',$Controller_ADMIN_ID)->orwhere('Controller_ID',$controller_id)->get();
        $result['groupid']=$groupid;
        $result['categoryid']=$category;
        $result['domainid']=$domain;
        $result['skillset']=DB::table('skillsets')->where('domain',$domain)->get();
        return view('controller.academ.skillset',$result);
    }

    public function addskillset(Request $request,$id=""){   
        if($id>0){
            // dd($id);
            $arr=skillset::where(['id'=>$id])->get();
            $result['id']=$arr['0']->id;
            $result['groupid']=$arr['0']->groupid;
            $result['category']=$arr['0']->category;
            $result['domain']=$arr['0']->domain;
            $result['skillset']=$arr['0']->skillset;
        }
        else{
            $result['id']='';
            $result['groupid']='';
            $result['category']='';
            $result['domain']='';
            $result['skillset']='';    
        }
        $Controller_ADMIN_ID=session()->get('Controller_ADMIN_ID');
        $controller_id=session()->get('Controller_ID');
        $result['groups']=DB::table('groups')->where('aid',$Controller_ADMIN_ID)->orwhere('Controller_ID',$controller_id)->get();
        return view("controller.academ.addskillset",$result);
    }
     
    public function saveskillset(Request $request){
        $Controller_ADMIN_ID=session()->get('Controller_ADMIN_ID');
        $controller_id=session()->get('Controller_ID');
        if($request->post('id')>0){
            // dd($request->post('id'));
            $model=skillset::find($request->post('id'));
            $msg="skillset updated";

                $name=DB::table('categories')->where('id',$request->post('category'))->get();
                $skillsetname=$name[0]->shortcateg.'_'.$request->post('skillset');
                $model->skillset=$skillsetname;
        }
        else{
            $model=new skillset();
            $msg="skillset inserted";
            $name=DB::table('categories')->where('id',$request->post('category'))->get();
                $skillsetname=$name[0]->shortcateg.'_'.$request->post('skillset');
            $model->skillset=$skillsetname;
        }
        $model->aid=$Controller_ADMIN_ID;
        $model->controller_id=$controller_id;
        $model->groupid=$request->post('groupid');
        $model->category=$request->post('category');
        $model->domain=$request->post('domain');
        $model->save();
        $request->session()->flash('message',$msg);

        if($request->post('id')>0){
        DB::table('skillattributes')->where('skillset',$request->post('id'))
        ->update(['groupid' => $request->post('groupid'),'category' => $request->post('category'),'domain' => $request->post('domain')]);
        }
        return redirect('academic_controller/skillset');
    }

    public function skillsetdelete(Request $request,$id){
        $model=skillset::find($id);
        $model->delete();
        $request->session()->flash('message','skillset Deleted');
       return redirect('academic_controller/skillset');
    }
    public function skillsetcategory($id){
        $controller_id=session()->get('Controller_ID');
        $id = $_GET['myID'];
        $a=DB::table('groups')->where('id',$id)->get();
        if($a[0]->gtype==2){
        $res = DB::table('categories')->where('aid',$Controller_ADMIN_ID)->orwhere('Controller_ID',$controller_id)->get();
        }else{
        $res = DB::table('categories')->where('groupid',$id)->get();
        }
        return Response::json($res);
    }

    public function skillsetdomain($id){
        $id = $_GET['id'];
        $res = DB::table('domains')->where('category',$id)->get();
        return Response::json($res);
    }

    public function getdomains($id){
        $id = $_GET['id'];
        $groupid= $_GET['groupid'];
        if ($groupid==0) {
            $res = DB::table('domains')->where('category',$id)->get();
        } else {
            $res = DB::table('domains')->where('category',$id)->where('groupid',$groupid)->get();
        } 
        return Response::json($res);
    }

    public function getskillsets($id){
        $id = $_GET['id'];
        $res = DB::table('skillsets')->where('domain',$id)->get();
        return Response::json($res);
    }

    public  function skillsetgetdomains(request $request){
        $cid = $request->post('cid');
        $groupid = $request->post('groupid');
        $a=DB::table('groups')->where('id',$groupid)->get();
        $state = DB::table('domains')->where('category', $cid)->where('groupid',$groupid)->get();
        echo $html='<option value="">Select </option>';
        foreach($state as $list){
        echo  $html='<option value="'.$list->id.'">'.$list->domain.'</option>';
        }
    }
    
}
