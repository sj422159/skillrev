<?php

namespace App\Http\Controllers\Controller\Academic;

use App\Http\Controllers\Controller; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\domain;
use App\Models\category;
use Redirect,Response;

class AcademicSubjectController extends Controller
{
    public function domain(Request $request){
        $Controller_ADMIN_ID=session()->get('Controller_ADMIN_ID');
          $Controller_ID=session()->get('Controller_ID');
        $result['groups']=DB::table('groups')->where('aid',$Controller_ADMIN_ID)->orwhere('Controller_ID',$Controller_ID)->get();
        $result['domain']=[];
        $result['groupid']='';
        $result['categoryid']='';
        return view('controller.academ.domain',$result);
    }

    public function domainbycategory(Request $request){
        $category=$request->post('category');
        $groupid=$request->post('group');
        $Controller_ADMIN_ID=session()->get('Controller_ADMIN_ID');
          $Controller_ID=session()->get('Controller_ID');
        $result['groups']=DB::table('groups')->where('aid',$Controller_ADMIN_ID)->orwhere('Controller_ID',$Controller_ID)->get();
        $result['groupid']=$groupid;
        $result['categoryid']=$category;
        $result['domain']=DB::table('domains')->where('groupid',$groupid)->where('category',$category)->get();
        return view('controller.academ.domain',$result);
    }

    public function adddomain(Request $request,$id=""){  
        if($id>0){
            $arr=domain::where(['id'=>$id])->get();
            $result['id']=$arr['0']->id;
            $result['groupid']=$arr['0']->groupid;
            $result['category']=$arr['0']->category;
            $result['domain']=$arr['0']->domain;
            $result['stype']=$arr['0']->stype;
            $result['subtype']=$arr['0']->subtype;
            $result['show']=$arr['0']->showsub;
            $result['dname']=$arr['0']->dname;
        }
        else{
            $result['id']='';
            $result['groupid']='';
            $result['category']='';
            $result['domain']='';
            $result['stype']='';
            $result['subtype']='';
            $result['show']='';
            $result['dname']='';
        }
        $Controller_ADMIN_ID=session()->get('Controller_ADMIN_ID');
          $Controller_ID=session()->get('Controller_ID');
        $result['subtypes']=["CURRICULAR","EXTRACURICULLAR","MANDATORY"];
        $result['groups']=DB::table('groups')->where('aid',$Controller_ADMIN_ID)->orwhere('Controller_ID',$Controller_ID)->get();
        return view("controller.academ.adddomain",$result);
    }
     
    public function savedomain(Request $request){
        // dd($request);
        $Controller_ADMIN_ID=session()->get('Controller_ADMIN_ID');
          $Controller_ID=session()->get('Controller_ID');
         $show=0;
         if($request->post('show')=="on"){
            $show=1;
         }
         $pre="";
         if($request->post('stype')=="CURRICULAR"){
           $pre="CU";
         }else if($request->post('stype')=="MANDATORY"){
            $pre="MAN";
         }
         else{
            $pre="ECU";
         }

        if($request->post('id')>0){
            $model=domain::find($request->post('id'));
          
            $msg="Domain updated";
            $name=DB::table('categories')->where('id',$request->post('category'))->get();
            $domainname=$name[0]->categories.'_'.$name[0]->shortcateg.'_'.$request->post('dname');
            $model->domain=$domainname;
            $model->dname=$request->post('dname');
        }
        else{
            $model=new domain();
            $msg="Domain inserted";
            $name=DB::table('categories')->where('id',$request->post('category'))->get();
            $domainname=$name[0]->categories.'_'.$name[0]->shortcateg.'_'.$request->post('domain');
            $model->domain=$domainname;
            $model->dname=$request->post('dname');
        }
        $model->aid= $Controller_ADMIN_ID;
        $model->Controller_ID= $Controller_ID;
        $model->groupid=$request->post('groupid');

        $g=DB::table('groups')->where('id',$request->post('groupid'))->get('gtype');
        $model->stype=$g[0]->gtype;
        $model->category=$request->post('category'); 
        $model->subtype=$request->post('stype');
        $model->showsub=$show;
        $model->save();
        $request->session()->flash('message',$msg);

        if($request->post('id')>0){
        DB::table('skillsets')->where('domain',$request->post('id'))
        ->update(['groupid' => $request->post('groupid'),'category' => $request->post('category')]);

        DB::table('skillattributes')->where('domain',$request->post('id'))
        ->update(['groupid' => $request->post('groupid'),'category' => $request->post('category')]);
        }

        return redirect()->route('academic_controller.domain.bycategory', [
            'group' => $request->post('groupid'),
            'category' => $request->post('category'),
           
        ]);

    }

    public function delete(Request $request, $id){
        $model=domain::find($id);
        $model->delete();
        $request->session()->flash('message','Domain Deleted');
        return redirect(url('academic_controller/domain'));

    }
    public  function questionbankgetcategories(request $request){
        $controller_id=session()->get('Controller_ID');
        $cid = $request->post('cid');
        $a=DB::table('groups')->where('id',$cid)->get();
        if($a[0]->gtype==2){
        $state = DB::table('categories')->where('aid',$Controller_ADMIN_ID)->orwhere('Controller_ID',$controller_id)->get();
        }else{
        $state = DB::table('categories')->where('groupid',$cid)->get();
        }  
        echo $html='<option value="">Select</option>';
        foreach($state as $list){
        echo  $html='<option value="'.$list->id.'">'.$list->categories.'</option>';
        }
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

}
