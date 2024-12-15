<?php

namespace App\Http\Controllers\Controller\Academic;

use App\Http\Controllers\Controller; 
use Illuminate\Http\Request;
use App\Models\ControllerModel; // Ensure this is the correct model for the controllers
use Illuminate\Support\Facades\DB;
use App\Models\Expense;
use App\Models\group;

class AcademicGroupController extends Controller
{
    public function group(Request $request){
        $controller_id=session()->get('Controller_ID');
        $controller_admin_id=session()->get('Controller_ADMIN_ID');
        $result['group']=DB::table('groups')->where('aid',$controller_admin_id)->get();
        return view('controller.academ.group',$result);
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
        return view("controller.academ.addgroup",$result);
    }
     
    public function savegroup(Request $request){
        $Controller_ID=session()->get('Controller_ID');
        $group=DB::table('groups')->where('Controller_ID',$Controller_ID)->where('gtype',2)->get();

        if($request->post('id')>0){
            if($request->post('gtype')==1){
                $model=group::find($request->post('id'));
                $model->Controller_ID=session()->get('Controller_ID');
                $model->aid=session()->get('Controller_ADMIN_ID');
                $model->group=$request->post('group');
                $model->gtype=$request->post('gtype');
                $model->save();
                $request->session()->flash('success','Group Updated');
                return redirect('academic_controller/groups');
            }
            elseif($request->post('gtype')==2 && count($group)==0){
                    $model=group::find($request->post('id'));
                    $model->Controller_ID=session()->get('Controller_ID');
                    $model->aid=session()->get('Controller_ADMIN_ID');-
                    $model->group=$request->post('group');
                    $model->gtype=$request->post('gtype');
                    $model->save();
                    $request->session()->flash('success','Group Updated');
                    return redirect('academic_controller/groups');
            }
            else{
                $request->session()->flash('danger','Optional Limit Exceeded');
                return redirect('academic_controller/groups');
            }   
        }
        else{
            if($request->post('gtype')==1){
                $model=new group();
                $model->Controller_ID=session()->get('Controller_ID');
                $model->aid=session()->get('Controller_ADMIN_ID');
                $model->group=$request->post('group');
                $model->gtype=$request->post('gtype');
                $model->save();
                $request->session()->flash('success','Group Inserted');
                return redirect('academic_controller/groups');
            }
            elseif($request->post('gtype')==2 && count($group)==0){
                $model=new group();
                $model->Controller_ID=session()->get('Controller_ID');
                $model->aid=session()->get('Controller_ADMIN_ID');
                $model->group=$request->post('group');
                $model->gtype=$request->post('gtype');
                $model->save();
                $request->session()->flash('success','Group Inserted');
                return redirect('academic_controller/groups');
            }
            else{
                $request->session()->flash('danger','Optional Limit Exceeded');
                return redirect('academic_controller/groups');
            }   
        }
    } 
    
}
