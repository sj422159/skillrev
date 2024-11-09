<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\role;
use Redirect,Response;

class lmsrolecontroller extends Controller
{
    public function role(Request $request){
        $aid=session()->get('ADMIN_ID');
        $result['role']=DB::table('roles')->where('aid',$aid)->get();
        return view('admin.role',$result);
    }

    public function addrole(Request $request,$id=""){     
        if($id>0){
            $arr=role::where(['id'=>$id])->get();
            $result['id']=$arr['0']->id;
            $result['role']=$arr['0']->role;
        }
        else{
            $result['id']='';
            $result['role']='';
        }
        return view("admin.addrole",$result);
    }
     
    public function saverole(Request $request){

        if($request->post('id')>0){
            $model=role::find($request->post('id'));
            $msg="Role updated";
        }
        else{
            $model=new role();
            $msg="Role inserted";
        }

        $model->aid=session()->get('ADMIN_ID');
        $model->role=$request->post('role');
        $model->save();
        $request->session()->flash('success',$msg);
        return redirect('admin/role');
    } 
}