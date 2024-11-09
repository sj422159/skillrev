<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\contentskillattribute;
use Redirect,Response;

class lmscontentmanagementcontroller extends Controller
{
    public function contentska(Request $request){
        $aid=session()->get('ADMIN_ID');
        $result['category']=DB::table('categories')->where('aid',$aid)->get();
        $result['categoryid']='';
        $result['domainid']='';
        $result['skillsetid']='';
        $result['data']=[];
        return view('admin.contentskillattribute',$result); 
    }

    public function contentskabyskillset(Request $request){
        $aid=session()->get('ADMIN_ID');
        $domain=$request->post('domain');
        $skillset=$request->post('skillset');
        $result['domainid']=$domain;
        $result['skillsetid']=$skillset;
        $result['category']=DB::table('categories')->where('aid',$aid)->get();
        $result['categoryid']=$request->post('category');
        $result['data']=DB::table('contentskillattributes')
                        ->join('skillattributes','skillattributes.id','contentskillattributes.skillattribute')
                        ->where('contentskillattributes.aid',$aid)
                        ->where('contentskillattributes.skillset',$skillset)
                        ->select('skillattributes.skillattribute','contentskillattributes.id')
                        ->get();
        return view('admin.contentskillattribute',$result);
    }

    public function addcontentska(Request $request,$id=""){     
        if($id>0){
            $arr=contentskillattribute::where(['id'=>$id])->get();
            $result['id']=$arr['0']->id;
            $result['category']=$arr['0']->category;
            $result['domain']=$arr['0']->domain;
            $result['skillset']=$arr['0']->skillset;
            $result['skillattribute']=$arr['0']->skillattribute;
            $result['type1']=$arr['0']->type1;
            $result['content1']=$arr['0']->content1;
            $result['type2']=$arr['0']->type2;
            $result['content2']=$arr['0']->content2;
            $result['type3']=$arr['0']->type3;
            $result['content3']=$arr['0']->content3;
            $result['type4']=$arr['0']->type4;
            $result['content4']=$arr['0']->content4;
        }
        else{
            $result['id']='';
            $result['category']='';
            $result['domain']='';
            $result['skillset']='';
            $result['skillattribute']='';
            $result['type1']=''; 
            $result['content1']=''; 
            $result['type2']=''; 
            $result['content2']=''; 
            $result['type3']=''; 
            $result['content3']=''; 
            $result['type4']=''; 
            $result['content4']='';   
        }
        $aid=session()->get('ADMIN_ID');
        $result['categories']=DB::table('categories')->where('aid',$aid)->get();
        $result['contenttypes1']=DB::table('contenttypes')->where('id',1)->get();
        $result['contenttypes2']=DB::table('contenttypes')->where('id',2)->get();
        $result['contenttypes3']=DB::table('contenttypes')->where('id',3)->get();
        $result['contenttypes4']=DB::table('contenttypes')->where('id',4)->get();
        return view("admin.addcontentskillattribute",$result);
    }
     
    public function savecontentska(Request $request){
        if($request->post('id')>0){
            $model=contentskillattribute::find($request->post('id'));
            $msg="Content Updated";
        }
        else{
            $model=new contentskillattribute();
            $msg="Content Inserted";
        }
        $model->aid=session()->get('ADMIN_ID');
        $model->category=$request->post('category');
        $model->domain=$request->post('domain');
        $model->skillset=$request->post('skillset');
        $model->skillattribute=$request->post('skillattribute');


        $model->type1=$request->post('contenttype1');
        if($request->post('contenttype1')=="1"){
          if($request->hasfile('file1')){  
            $file=$request->file('file1');
            $ext=$file->extension();
            $file_name=time().'.'.$ext;
            $file->move(public_path().'/content/type1',$file_name);
            $model->content1=$file_name;
          }
        }


        $model->type2=$request->post('contenttype2');
        if($request->post('contenttype2')=="2"){
          if($request->hasfile('file2')){  
            $file=$request->file('file2');
            $ext=$file->extension();
            $file_name=time().'.'.$ext;
            $file->move(public_path().'/content/type2',$file_name);
            $model->content2=$file_name;
          }
        }


        $model->type3=$request->post('contenttype3');
        if($request->post('contenttype3')=="3"){
          if($request->post('video3')!=""){
           $model->content3=$request->post('video3'); 
          }
        }


        $model->type4=$request->post('contenttype4');
        if($request->post('contenttype4')=="4"){
          if($request->post('video4')!=""){
           $model->content4=$request->post('video4'); 
          }
        }
       
       
        $model->save();
        $request->session()->flash('success',$msg);
        return redirect('admin/content/skillattribute');
    }

    public function contentskadelete(Request $request, $id){
        $model=contentskillattribute::find($id);
        $model->delete();
        $request->session()->flash('success','Deleted Successfully');
        return redirect('admin/content/skillattribute');
    }
}