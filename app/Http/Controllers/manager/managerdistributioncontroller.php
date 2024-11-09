<?php

namespace App\Http\Controllers\manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\studentassignation;
use App\Models\studentbooking;
use App\Models\assesmentsections;
use App\Models\finalanswer;
use Redirect,Response;

class managerdistributioncontroller extends Controller
{

    public function reports(){
        $aid=session()->get('MANAGER_ADMIN_ID');
        $mid=session()->get('MANAGER_ID');
        $classid=session()->get('MANAGER_CLASS_ID');
        $result['sections']=DB::table('lmssections')->where('classid',$classid)->get();
        $result['sec']=0;
        $result['feecategories']= DB::table('feecategories')->where('aid',$aid)->where('fcmandatoryornot',2)->where('fcstatus',1)->get();
        $result['feecategory']=0;
        $result['class']=DB::table('categories')->where('id',$classid)->get();
        $result['cl']=0;
        $result['data']=[];
        return view('manager.viewdistributions',$result);
    }

    public function fetchstu(request $request){
        $aid=session()->get('MANAGER_ADMIN_ID');
        $mid=session()->get('MANAGER_ID');
        $classid=session()->get('MANAGER_CLASS_ID');
        $result['sections']=DB::table('lmssections')->where('classid',$classid)->get();
        $result['sec']=$request->post('section');
        $result['feecategories']= DB::table('feecategories')->where('aid',$aid)->where('fcmandatoryornot',2)->where('fcstatus',1)->get();
        $result['feecategory']=$request->post('feecategory');
        $result['class']=DB::table('categories')->where('id',$classid)->get();
        $result['cl']=$request->post('class');
    
        $result['data'] = DB::table('distributions')
                    ->join('students','students.id','distributions.sid')
                    ->where('classid',$classid)
                    ->where('sectionid',$request->post('section'))
                    ->where('feecategoryid',$request->post('feecategory'))
                    ->select('students.sregistrationnumber','students.sname','students.slname','distributions.*')
                    ->get();
        return view('manager.viewdistributions',$result);
    }    
}