<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\leave;
use Mail;
use Redirect,Response;

class adminleavecontroller extends Controller
{
    public function approveleave(Request $request){
        $aid=session()->get('ADMIN_ID');
        $result['facultyleave']=DB::table('leaves')
                            ->join('faculties','faculties.id','leaves.profileid')
                            ->where('leaves.aid',$aid)->where('portalid',4)
                            ->select('faculties.fname','leaves.*')
                            ->latest('leaves.id')
                            ->get();
        $result['managerleave']=DB::table('leaves')
                            ->join('managers','managers.id','leaves.profileid')
                            ->where('leaves.aid',$aid)->where('portalid',2)
                            ->select('managers.mname','leaves.*')
                            ->latest('leaves.id')
                            ->get();
        $result['supervisorleave']=DB::table('leaves')
                            ->join('supervisors','supervisors.id','leaves.profileid')
                            ->where('leaves.aid',$aid)->where('portalid',1)
                            ->select('supervisors.supname','leaves.*')
                            ->latest('leaves.id')
                            ->get();
        return view('admin.approveleave',$result);
    }

    public function approveleavestatus(Request $request,$status,$id){
        $model=leave::find($id);
        $model->status=$status;
        $model->save();
        $request->session()->flash('success','Leave Status Updated Successfully');
        return redirect('admin/approve/leave');

    }
}