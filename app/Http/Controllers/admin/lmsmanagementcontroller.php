<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\domain;
use App\Models\skillset;
use App\Models\category;
use App\Models\skillattribute;
use Redirect,Response;

class lmsmanagementcontroller extends Controller{

    public function category(Request $request){
        $aid=session()->get('ADMIN_ID');
        $result['groups']=DB::table('groups')->where('aid',$aid)->get();
        $result['groupid']='';
        $result['category']=DB::table('categories')
                        ->join('groups','groups.id','categories.groupid')
                        ->where('categories.aid',$aid)
                        ->select('groups.group','categories.*')
                        ->get();
        return view('admin.category',$result);
    }

    public function categorybygroup(Request $request){
        $groupid=$request->post('groupid');
        $aid=session()->get('ADMIN_ID');
        $result['groups']=DB::table('groups')->where('aid',$aid)->get();
        $result['groupid']=$groupid;
        $result['category']=DB::table('categories')
                        ->join('groups','groups.id','categories.groupid')
                        ->where('categories.aid',$aid)
                        ->where('categories.groupid',$groupid)
                        ->select('groups.group','categories.*')
                        ->get();
        return view('admin.category',$result);
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
        $aid=session()->get('ADMIN_ID');
        $result['groups']=DB::table('groups')->where('aid',$aid)->get();
        $result['standards']=DB::table('standards')->get();
        return view("admin.addcategory",$result);
    }
     
    public function savecategory(Request $request){
        $aid=session()->get('ADMIN_ID');
      
       
        if($request->post('id')>0){
            $model=category::find($request->post('id'));
            $msg="Category updated";
             $data=DB::table('standards')->where('id',$request->post('standardid'))->get();
            $category="STANDARD ".$data[0]->name;
        $model->aid=$aid;
        $model->groupid=$request->post('groupid');
        $model->standardid=$request->post('standardid');
        $model->categories=$category;
        $model->shortcateg=$request->post('shortcat');
        $model->cmaxperiod=$request->post('max');
        $model->save();
        $request->session()->flash('message',$msg);
        }
        else{
            $d=DB::table('categories')->where('standardid',$request->post('standardid'))->where('aid',$aid)->get();
               if(count($d)==0){
            $model=new category();
            $msg="Category inserted";
             $data=DB::table('standards')->where('id',$request->post('standardid'))->get();
            $category="STANDARD ".$data[0]->name;
            $model->aid=$aid;
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

        return redirect('admin/category');

      
    }

    public function categorydelete(Request $request, $id){
        $model=category::find($id);
        $model->delete();
        $request->session()->flash('message','Category Deleted');
        return redirect('admin/category');
    }

    public function domain(Request $request){
        $aid=session()->get('ADMIN_ID');
        $result['groups']=DB::table('groups')->where('aid',$aid)->get();
        $result['domain']=DB::table('domains')->where('aid',$aid)->get();
        $result['groupid']='';
        $result['categoryid']='';
        return view('admin.domain',$result);
    }

    public function domainbycategory(Request $request){
        $category=$request->post('category');
        $groupid=$request->post('group');
        $aid=session()->get('ADMIN_ID');
        $result['groups']=DB::table('groups')->where('aid',$aid)->get();
        $result['groupid']=$groupid;
        $result['categoryid']=$category;
        $result['domain']=DB::table('domains')->where('groupid',$groupid)->where('category',$category)->get();
        return view('admin.domain',$result);
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
        $aid=session()->get('ADMIN_ID');
        $result['subtypes']=["CURRICULAR","EXTRACURICULLAR","MANDATORY"];
        $result['groups']=DB::table('groups')->where('aid',$aid)->get();
        return view("admin.adddomain",$result);
    }
     
    public function savedomain(Request $request){
       // return $request->post();
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
        $model->aid=session()->get('ADMIN_ID');
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

        return redirect('admin/domain');
    }

    public function delete(Request $request, $id){
        $model=domain::find($id);
        $model->delete();
        $request->session()->flash('message','Domain Deleted');
        return redirect('admin/domain');
    }

    public function skillset(Request $request){
        $aid=session()->get('ADMIN_ID');
        $result['groups']=DB::table('groups')->where('aid',$aid)->get();
        $result['groupid']='';
        $result['categoryid']='';
        $result['domainid']='';
        $result['skillset']=[];
        return view('admin.skillset',$result);
    }

    public function skillsetbydomain(Request $request){
        $aid=session()->get('ADMIN_ID');
        $groupid=$request->post('group');
        $category=$request->post('category');
        $domain=$request->post('domain');
        $result['groups']=DB::table('groups')->where('aid',$aid)->get();
        $result['groupid']=$groupid;
        $result['categoryid']=$category;
        $result['domainid']=$domain;
        $result['skillset']=DB::table('skillsets')->where('domain',$domain)->get();
        return view('admin.skillset',$result);
    }

    public function addskillset(Request $request,$id=""){   
        if($id>0){
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
        $aid=session()->get('ADMIN_ID');
        $result['groups']=DB::table('groups')->where('aid',$aid)->get();
        return view("admin.addskillset",$result);
    }
     
    public function saveskillset(Request $request){
        if($request->post('id')>0){
            $model=skillset::find($request->post('id'));
            $msg="skillset updated";
            if($model->domain!=$request->post('domain')){
                $name=DB::table('domains')->where('id',$request->post('domain'))->get();
                $skillsetname=$name[0]->domain.'_'.$request->post('skillset');
                $model->skillset=$skillsetname;
            }
        }
        else{
            $model=new skillset();
            $msg="skillset inserted";
            $name=DB::table('domains')->where('id',$request->post('domain'))->get();
            $skillsetname=$name[0]->domain.'_'.$request->post('skillset');
            $model->skillset=$skillsetname;
        }
        $model->aid=session()->get('ADMIN_ID');
        $model->groupid=$request->post('groupid');
        $model->category=$request->post('category');
        $model->domain=$request->post('domain');
        $model->save();
        $request->session()->flash('message',$msg);

        if($request->post('id')>0){
        DB::table('skillattributes')->where('skillset',$request->post('id'))
        ->update(['groupid' => $request->post('groupid'),'category' => $request->post('category'),'domain' => $request->post('domain')]);
        }
        return redirect('admin/skillset');
    }

    public function skillsetdelete(Request $request,$id){
        $model=skillset::find($id);
        $model->delete();
        $request->session()->flash('message','skillset Deleted');
       return redirect('admin/skillset');
    }

    public function skillattribute(Request $request){
        $aid=session()->get('ADMIN_ID');
        $result['groups']=DB::table('groups')->where('aid',$aid)->get();
        $result['groupid']='';
        $result['categoryid']='';
        $result['domainid']='';
        $result['skillsetid']='';
        $result['skillattribute']=[];
        return view('admin.skillattribute',$result);
    }

    public function skillattributebyskillset(Request $request){
        $aid=session()->get('ADMIN_ID');
        $groupid=$request->post('group');
        $category=$request->post('category');
        $domain=$request->post('domain');
        $skillset=$request->post('skillset');
        $result['groups']=DB::table('groups')->where('aid',$aid)->get();
        $result['groupid']=$groupid;
        $result['categoryid']=$category;
        $result['domainid']=$domain;
        $result['skillsetid']=$skillset;
        $result['skillattribute']=DB::table('skillattributes')->where('skillset',$skillset)->get();
        return view('admin.skillattribute',$result);
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
        $aid=session()->get('ADMIN_ID');
        $result['groups']=DB::table('groups')->where('aid',$aid)->get();
        return view("admin.addskillattribute",$result);
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
        $model->aid=session()->get('ADMIN_ID');
        $model->groupid=$request->post('groupid');
        $model->category=$request->post('category');
        $model->domain=$request->post('domain');
        $model->skillset=$request->post('skillset'); 
        $model->save();
        $request->session()->flash('message',$msg);
        return redirect('admin/skillattribute');
    }

    public function skillattributedelete(Request $request, $id){
        $model=skillattribute::find($id);
        $model->delete();
        $request->session()->flash('message','Skillattribute Deleted');
        return redirect('admin/skillattribute');
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

    public function skillsetcategory($id){
        $aid=session()->get('ADMIN_ID');
        $id = $_GET['myID'];
        $a=DB::table('groups')->where('id',$id)->get();
        if($a[0]->gtype==2){
        $res = DB::table('categories')->where('aid',$aid)->get();
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
        $aid=session()->get('ADMIN_ID');
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