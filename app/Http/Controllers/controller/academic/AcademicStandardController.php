<?php

namespace App\Http\Controllers\Controller\Academic;

use App\Http\Controllers\Controller; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\category;

class AcademicStandardController extends Controller
{
    public function category(Request $request){
        $Controller_ID=session()->get('Controller_ID');
        $controller_admin_id=session()->get('Controller_ADMIN_ID');
     
        $result['groups']=DB::table('groups')->where('aid',$controller_admin_id)->get();
        $result['groupid']='';
        $result['category']=[];
        return view('controller.academ.category',$result);
    }

    public function categorybygroup(Request $request){
        $groupid=$request->post('groupid');
        $Controller_ID=session()->get('Controller_ID');
        $controller_admin_id=session()->get('Controller_ADMIN_ID');
        $result['groups']=DB::table('groups')->where('aid',$controller_admin_id)->orwhere('Controller_ID',$Controller_ID)->get();
        $result['groupid']=$groupid;
        $result['category']=DB::table('categories')
                        ->join('groups','groups.id','categories.groupid')
                        ->where('categories.aid',$controller_admin_id)
                        ->where('categories.groupid',$groupid)
                        ->select('groups.group','categories.*')
                        ->get();
        return view('controller.academ.category',$result);
    }

    public function addcategory(Request $request,$id=""){   
        if($id>0){
            $arr=category::where(['id'=>$id])->get();
            $result['id']=$arr['0']->id;
            $result['category']=$arr['0']->categories;
            $result['shortcateg']=$arr['0']->shortcateg;
            $result['max']=$arr['0']->cmaxperiod;
            $result['groupid']=$arr['0']->groupid;
            $result['standardid']=$arr['0']->standardid;
        }
        else{
            $result['id']='';
            $result['category']='';
            $result['shortcateg']='';
            $result['groupid']='';
            $result['standardid']='';
            $result['max']=0;
        }
        $controller_admin_id=session()->get('Controller_ADMIN_ID');
        $result['groups']=DB::table('groups') ->where('aid',$controller_admin_id)->get();
        $result['standards']=DB::table('standards')->get();
        return view("controller.academ.addcategory",$result);
    }
     
    public function savecategory(Request $request){
        $Controller_ID=session()->get('Controller_ID');
        $Controller_ADMIN_ID=session()->get('Controller_ADMIN_ID');
      
       
        if($request->post('id')>0){
            $model=category::find($request->post('id'));
            $msg="Category updated";
             $data=DB::table('standards')->where('id',$request->post('standardid'))->get();
            $category="STANDARD ".$data[0]->name;
        $model->Controller_ID=$Controller_ID;
        $model->aid=$Controller_ADMIN_ID;
        $model->groupid=$request->post('groupid');
        $model->standardid=$request->post('standardid');
        $model->categories=$category;
        $model->shortcateg=$request->post('shortcat');
        $model->cmaxperiod=$request->post('max');
        $model->save();
        $request->session()->flash('message',$msg);
        }
        else{
            $d=DB::table('categories')->where('standardid',$request->post('standardid'))->where('Controller_ID',$Controller_ID)->get();
               if(count($d)==0){
            $model=new category();
            $msg="Category inserted";
             $data=DB::table('standards')->where('id',$request->post('standardid'))->get();
            $category="STANDARD ".$data[0]->name;
            $model->Controller_ID=$Controller_ID;
            $model->aid=$Controller_ADMIN_ID;
            $model->groupid=$request->post('groupid');
            $model->standardid=$request->post('standardid');
            $model->categories=$category;
            $model->shortcateg=$request->post('shortcat');
            $model->cmaxperiod=$request->post('max');
            $model->save();
            $request->session()->flash('message',$msg);
        } else{
        $message="Standard  Already Exists";
        $request->session()->flash('danger',$message);
        
       }
       
       }

        if($request->post('id')>0){
        DB::table('domains')->where('category',$request->post('id'))
        ->update(['groupid' => $request->post('groupid')]); 

        DB::table('skillsets')->where('category',$request->post('id'))
        ->update(['groupid' => $request->post('groupid')]);

        DB::table('skillattributes')->where('category',$request->post('id'))
        ->update(['groupid' => $request->post('groupid')]);

        DB::table('lmssections')->where('classid',$request->post('id'))
        ->update(['groupid' => $request->post('groupid')]);
        }

        return redirect()->route('controller.academ.category', [
            'groupid' => $request->post('groupid'),

        ]);
        // return redirect('academic_controller/standard');

      
    }

    public function categorydelete(Request $request, $id){
        $model=category::find($id);
        $model->delete();
        $request->session()->flash('message','Category Deleted');
        return redirect('academic_controller/standard');
    }
    
}
