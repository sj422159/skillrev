<?php

namespace App\Http\Controllers\supervisor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\studentassignation;
use App\Models\studentbooking;
use App\Models\assesmentsections;
use App\Models\finalanswer;
use Redirect,Response;

class supervisordistributioncontroller extends Controller
{

    public function reports(){
        $aid=session()->get('SUPERVISOR_ADMIN_ID');
        $mid=session()->get('SUPERVISOR_ID');
        $groupid=session()->get('SUPERVISOR_GROUP_ID');
        $result['sec']=0;
        $result['feecategories']= DB::table('feecategories')->where('aid',$aid)->where('fcmandatoryornot',2)->where('fcstatus',1)->get();
        $result['feecategory']=0;
        $result['class']=DB::table('categories')->where('groupid',$groupid)->get();
        $result['cl']=0;
        $result['data']=[];
        return view('supervisor.viewdistributions',$result);
    }

    public function fetchstu(request $request){
        $aid=session()->get('SUPERVISOR_ADMIN_ID');
        $mid=session()->get('SUPERVISOR_ID');
        $groupid=session()->get('SUPERVISOR_GROUP_ID');
        $result['sec']=$request->post('section');
        $result['feecategories']= DB::table('feecategories')->where('aid',$aid)->where('fcmandatoryornot',2)->where('fcstatus',1)->get();
        $result['feecategory']=$request->post('feecategory');
        $result['class']=DB::table('categories')->where('groupid',$groupid)->get();
        $result['cl']=$request->post('classid');
    
        $result['data'] = DB::table('distributions')
                    ->join('students','students.id','distributions.sid')
                    ->where('classid',$request->post('classid'))
                    ->where('sectionid',$request->post('section'))
                    ->where('feecategoryid',$request->post('feecategory'))
                    ->select('students.sregistrationnumber','students.sname','students.slname','distributions.*')
                    ->get();
        return view('supervisor.viewdistributions',$result);
    }     
}