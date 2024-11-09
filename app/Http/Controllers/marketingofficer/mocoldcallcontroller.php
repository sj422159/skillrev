<?php

namespace App\Http\Controllers\marketingofficer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\mocoldcalllist;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class mocoldcallcontroller extends Controller
{
    public function index(){
      $mid=session()->get('MARKETINGOFFICER_ID');
      $result['data']=DB::table('mocoldcalllists')->where('moid',$mid)->where('status','<=',2)->get();
      return view('marketingofficer.calllist',$result);
    }

    public function create(Request $request)
    {    
        $result['type']='';
        $result['name']='';
        $result['location']='';
        $result['address']='';
        $result['poc']='';
        $result['designation']='';
        $result['number']='';
        $result['email']='';
        $result['id']='';     
        return view("marketingofficer.createcalllist",$result);
    }

    public function save(Request $request)
    {
        $model=new mocoldcalllist();
        $msg="Call Inserted";      
        $model->moid=session()->get('MARKETINGOFFICER_ID');
        $model->type=$request->post('type');
        $model->name=$request->post('name');
        $model->location=$request->post('location');
        $model->address=$request->post('address');
        $model->poc=$request->post('poc');
        $model->designation=$request->post('designation');
        $model->number=$request->post('number');
        $model->email=$request->post('email');
        $model->rejectreason=0;
        $model->status=0;
        $model->save();
        return redirect('employee/marketingofficer/coldcallinitial');
    }
    public function needhelp($id){
      $model=mocoldcalllist::find($id);
      $model->status=2;
      $model->save();
      return redirect('employee/marketingofficer/coldcallinitial');
    }
    public function rejectreason($id){
      $result['data']=DB::table('mocoldcalllists')->where('id',$id)->get();
      return view('marketingofficer.rejectreason',$result);
    }
    public function reject(Request $request){
      $model=mocoldcalllist::find($request->post('id'));
      $model->status=1;
      $model->rejectreason=$request->post('rejectreason');
      $model->save();
      return redirect('employee/marketingofficer/coldcallinitial');
    }
    public function progressorcomplist($id){
      $mid=session()->get('MARKETINGOFFICER_ID');
      $result['data']=DB::table('mocoldcalllists')->where('moid',$mid)->where('status',$id)->get();
      return view('marketingofficer.callprogorcomplist',$result);
    }
    public function mmrejectreason($id){
      $result['data']=DB::table('mocoldcalllists')->where('id',$id)->get();
      return view('marketingofficer.mmrejectreason',$result);
    }
    
}
