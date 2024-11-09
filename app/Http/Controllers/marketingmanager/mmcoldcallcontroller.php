<?php

namespace App\Http\Controllers\marketingmanager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\mocoldcalllist;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class mmcoldcallcontroller extends Controller
{
    public function list($id){
      $mid=session()->get('MARKETINGMANAGER_ID');
      $result['data']=DB::table('mocoldcalllists')
                      ->join('marketingofficers','marketingofficers.id','mocoldcalllists.moid')
                      ->where('marketingofficers.mmid',$mid)
                      ->where('status',$id)
                      ->select('marketingofficers.mofname','marketingofficers.molname','mocoldcalllists.*')
                      ->get();
      $result['reject']=DB::table('mocoldcalllists')
                      ->join('marketingofficers','marketingofficers.id','mocoldcalllists.moid')
                      ->where('marketingofficers.mmid',$mid)
                      ->where('status',1)  // 1 means rejected 
                      ->select('marketingofficers.mofname','marketingofficers.molname','mocoldcalllists.*')
                      ->get();
      $result['id']=$id;
      return view('marketingmanager.calllist',$result);
    }

    public function status($status,$id){
      $model=mocoldcalllist::find($id);
      $model->status=$status;
      $model->save();
      return redirect('employee/marketingmanager/dashboard');
    }

    public function rejectreason($id){
      $mid=session()->get('MARKETINGMANAGER_ID');
      $result['data']=DB::table('mocoldcalllists')->where('id',$id)->get();
      $result['mo']=DB::table('marketingofficers')->where('mmid',$mid)->get();
      return view('marketingmanager.rejectreason',$result);
    }

    public function mosave(Request $request){
      $model=mocoldcalllist::find($request->post('id'));
      $model->moid=$request->post('mo');
      $model->rejectreason=0;
      $model->status=0;
      $model->save();
      return redirect('employee/marketingmanager/coldcall/2');
    }

    public function mmrejectreason($id){
      $result['data']=DB::table('mocoldcalllists')->where('id',$id)->get();
      return view('marketingmanager.mmrejectreason',$result);
    }

    public function mmreject(Request $request){
      $model=mocoldcalllist::find($request->post('id'));
      $model->mmreject=1;
      $model->mmrejectreason=$request->post('rejectreason');
      $model->save();
      return redirect('employee/marketingmanager/coldcall/3');
    }
    
}
