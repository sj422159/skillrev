<?php

namespace App\Http\Controllers\faculty;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\leave;
use Mail;
use Redirect,Response;

class facultyleavecontroller extends Controller
{
    public function leave(Request $request){
        $fid=session()->get('FACULTY_ID');
        $result['leave']=DB::table('leaves')->where('profileid',$fid)->where('portalid',4)->latest('id')->get();
        return view('faculty.leave',$result);
    }

    public function addleave(Request $request,$id=""){   
        if($id>0){
            $arr=leave::where(['id'=>$id])->get();
            $result['id']=$arr['0']->id;
            $result['fromdate']=date("Y-m-d", strtotime($arr['0']->fromdate));
            $result['todate']=date("Y-m-d", strtotime($arr['0']->todate));
            $result['reason']=$arr['0']->reason;
        }
        else{
            $result['id']='';
            $result['fromdate']='';
            $result['todate']='';
            $result['reason']='';
        } 
        return view("faculty.addleave",$result);
    }
     
    public function saveleave(Request $request){
        if($request->post('id')>0){
            $model=leave::find($request->post('id'));
            $msg="Leave Updated Successfully";
        }
        else{
            $model=new leave();
            $msg="Leave Applied Successfully";
        }
        $fromdate = $request->post('fromdate');
        $newfromdate = date("d-m-Y", strtotime($fromdate));
        $todate = $request->post('todate');
        $newtodate = date("d-m-Y", strtotime($todate));
        $model->aid=session()->get('FACULTY_ADMIN_ID');
        $model->portalid=4;
        $model->profileid=session()->get('FACULTY_ID');
        $model->fromdate=$newfromdate;
        $model->todate=$newtodate;
        $model->reason=$request->post('reason');
        $model->status=1;
        $model->save();

        $request->session()->flash('success',$msg);
        return redirect('faculty/leave');
    }

    public function leavedelete(Request $request, $id){
        $model=leave::find($id);
        $model->delete();
        $request->session()->flash('success','Leave Deleted Successfully');
        return redirect('faculty/leave');
    }
}