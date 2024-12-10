<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\group;
use App\Models\department;
use App\Models\room;
use App\Models\feecategory;
use App\Models\infragroup;
use Redirect,Response;

class lmsgroupcontroller extends Controller
{

     public function rooms(Request $request){
        $aid=session()->get('ADMIN_ID');
        $result['room']=DB::table('rooms')->where('aid',$aid)->get();
        return view('admin.rooms',$result);
    }

     public function addrooms(Request $request,$id=""){     
        if($id>0){
            $arr=room::where(['id'=>$id])->get();
            $result['id']=$arr['0']->id;
            $result['room']=$arr['0']->roomname;
            $result['allocation']=$arr['0']->allocation;
            
        }
        else{
            $result['id']='';
            $result['room']='';
             $result['allocation']=0;
        }
        return view("admin.addrooms",$result);
    }



     public function saverooms(Request $request){
        $aid=session()->get('ADMIN_ID');
        $allocation=0;
         if($request->post('allocation')=="on"){
            $allocation=1;
         }

        if($request->post('id')>0){
           
                $model=room::find($request->post('id'));
                $model->aid=session()->get('ADMIN_ID');
                $model->roomname=$request->post('room');
                $model->allocation=$allocation;
                $model->save();
                $request->session()->flash('success','Room Updated');
            }else{
                $model=new room();
                $model->aid=session()->get('ADMIN_ID');
                $model->roomname=$request->post('room');
                 $model->allocation=$allocation;
                $model->save();
                $request->session()->flash('success','Room Added');
            }
                return redirect('admin/rooms');
            }
             
    public function group(Request $request){
        $aid=session()->get('ADMIN_ID');
        $result['group']=DB::table('groups')->where('aid',$aid)->get();
        return view('admin.group',$result);
    }

    public function addgroup(Request $request,$id=""){     
        if($id>0){
            $arr=group::where(['id'=>$id])->get();
            $result['id']=$arr['0']->id;
            $result['group']=$arr['0']->group;
            $result['gtype']=$arr['0']->gtype;
        }
        else{
            $result['id']='';
            $result['group']='';
            $result['gtype']='';
        }
        return view("admin.addgroup",$result);
    }
     
    public function savegroup(Request $request){
        $aid=session()->get('ADMIN_ID');
        $group=DB::table('groups')->where('aid',$aid)->where('gtype',2)->get();

        if($request->post('id')>0){
            if($request->post('gtype')==1){
                $model=group::find($request->post('id'));
                $model->aid=session()->get('ADMIN_ID');
                $model->group=$request->post('group');
                $model->gtype=$request->post('gtype');
                $model->save();
                $request->session()->flash('success','Group Updated');
                return redirect('admin/group');
            }
            elseif($request->post('gtype')==2 && count($group)==0){
                    $model=group::find($request->post('id'));
                    $model->aid=session()->get('ADMIN_ID');
                    $model->group=$request->post('group');
                    $model->gtype=$request->post('gtype');
                    $model->save();
                    $request->session()->flash('success','Group Updated');
                    return redirect('admin/group');
            }
            else{
                $request->session()->flash('danger','Optional Limit Exceeded');
                return redirect('admin/group');
            }   
        }
        else{
            if($request->post('gtype')==1){
                $model=new group();
                $model->aid=session()->get('ADMIN_ID');
                $model->group=$request->post('group');
                $model->gtype=$request->post('gtype');
                $model->save();
                $request->session()->flash('success','Group Inserted');
                return redirect('admin/group');
            }
            elseif($request->post('gtype')==2 && count($group)==0){
                $model=new group();
                $model->aid=session()->get('ADMIN_ID');
                $model->group=$request->post('group');
                $model->gtype=$request->post('gtype');
                $model->save();
                $request->session()->flash('success','Group Inserted');
                return redirect('admin/group');
            }
            else{
                $request->session()->flash('danger','Optional Limit Exceeded');
                return redirect('admin/group');
            }   
        }
    } 

    public function department(Request $request){
        $aid=session()->get('ADMIN_ID');
        $result['department']=DB::table('departments')
                            ->join('nontechcategories','departments.category','nontechcategories.id')
                            ->where('departments.aid',$aid)
                            ->select('departments.*','nontechcategories.ntcname')
                            ->get();
        return view('admin.department',$result);
    }
    
    public function adddepartment(Request $request,$id=""){
        $aid=session()->get('ADMIN_ID');
        $result['nontechcategories']=DB::table('nontechcategories')->get();     
        if($id>0){
            $arr=department::where(['id'=>$id])->get();
            $result['id']=$arr['0']->id;
            $result['department']=$arr['0']->department;
            $result['category']=$arr['0']->category;
        }
        else{
            $result['id']='';
            $result['department']='';
            $result['category']='';
        }
        return view("admin.adddepartment",$result);
    }
     
    public function savedepartment(Request $request){ 
        $aid=session()->get('ADMIN_ID');
        if($request->post('id')>0){ 
            $model=department::find($request->post('id'));
            $request->session()->flash('success','Department Updated');
        }
        else{
            $model=new department();
            $request->session()->flash('success','Department Inserted'); 
        }
        $model->aid=$aid;
        $model->department=$request->post('department');
        $model->category=$request->post('cat');
        $model->save();
        return redirect('admin/department'); 
    } 






     public function infragroup(Request $request){
        $aid=session()->get('ADMIN_ID');
        $result['department']=DB::table('infragroups')
                            ->join('infracategories','infragroups.category','infracategories.id')
                            ->where('infragroups.aid',$aid)
                            ->select('infragroups.*','infracategories.infracname')
                            ->get();
        return view('admin.infragroups',$result);
    }
    
    public function addinfragroup(Request $request,$id=""){
        $aid=session()->get('ADMIN_ID');
        $result['nontechcategories']=DB::table('infracategories')->get();  
        $result['infragroups']=DB::table('infragroups')->where('aid',$aid)->get();  
        $result['checkid']=[];
        for($i=0;$i<count($result['infragroups']);$i++){
            $result['checkid'][$i]=$result['infragroups'][$i]->category;
        } 
        if($id>0){
            $arr=infragroup::where(['id'=>$id])->get();
            $result['id']=$arr['0']->id;
            $result['department']=$arr['0']->infragroup;
            $result['category']=$arr['0']->category;
        }
        else{
            $result['id']='';
            $result['department']='';
            $result['category']='';
        }
        return view("admin.addinfragroups",$result);
    }
     
    public function saveinfragroup(Request $request){ 
        $aid=session()->get('ADMIN_ID');
        if($request->post('id')>0){ 
            $model=infragroup::find($request->post('id'));
            $request->session()->flash('success','Infragroup Updated');
        }
        else{
            $model=new infragroup();
            $request->session()->flash('success','Infragroup Inserted'); 
        }
        $model->aid=$aid;
        $model->infragroup=$request->post('department');
        $model->category=$request->post('cat');
        $model->save();
        return redirect('admin/infrastructure/group'); 
    } 
}