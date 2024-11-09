<?php

namespace App\Http\Controllers\nontechmanager\cafeteria;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\hostelrooms;
use App\Models\infragroup;
use App\Models\hostelitems;
use App\Models\student;
use Redirect,Response;
use Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\foodfeedbackExport;


class cafeteriareportscontroller extends Controller
{
    public function repairreports(){
         $aid=session()->get('NONTECH_MANAGER_ADMIN_ID');  
        $result['data']=DB::table('cafeteriainfrarepairhistories')
                          ->join('cafeteriatype','cafeteriainfrarepairhistories.cafetype','cafeteriatype.id')
                          ->join('cafeterias','cafeteriainfrarepairhistories.cafeid','cafeterias.id')
                        ->join('infraitems','cafeteriainfrarepairhistories.itemid','infraitems.id')
                         ->where('cafeteriainfrarepairhistories.aid',$aid)
                         ->select('cafeteriatype.ctype','cafeterias.cafeteria','infraitems.infraitem','cafeteriainfrarepairhistories.*')->get();
        return view('nontechmanager.cafeteria.repairreports',$result);
    }

    public function itemsreports(){
        $mid=session()->get('NONTECH_MANAGER_ID');
        $result['hostels']=DB::table('vendors')->where('cafeteriatype',1)->where('mid',$mid)->get();
        $result['categories']=DB::table('foodcategories')->get();
        $result['data']=DB::table('schoolmenus')
                              ->join('vendors','schoolmenus.catererid','vendors.id')
                              ->join('fooditems','schoolmenus.fitemid','fooditems.id')
                              ->join('foodcategories','fooditems.foodcat','foodcategories.id')
                              ->join('foodpricetypes','fooditems.pricetype','foodpricetypes.id')
                              ->where('vendors.mid',$mid)->select('fooditems.fooditems','foodcategories.foodcategory','foodpricetypes.ptype','schoolmenus.*','vendors.fname','vendors.lname')->get();
        return view('nontechmanager.cafeteria.itemsreports',$result);
    }

    public function itemsreportsbyfilter(request $request){
        $mid=session()->get('NONTECH_MANAGER_ID');
        $result['hostels']=DB::table('vendors')->where('cafeteriatype',1)->where('mid',$mid)->get();
        $result['categories']=DB::table('foodcategories')->get();
        $result['data']=DB::table('schoolmenus')
                              ->join('vendors','schoolmenus.catererid','vendors.id')
                              ->join('fooditems','schoolmenus.fitemid','fooditems.id')
                              ->join('foodcategories','fooditems.foodcat','foodcategories.id')
                              ->join('foodpricetypes','fooditems.pricetype','foodpricetypes.id')
                              ->where('vendors.mid',$mid)
                              ->where('schoolmenus.catererid',$request->hostel)
                              ->where('foodcategories.id',$request->category)
                              ->select('fooditems.fooditems','foodcategories.foodcategory','foodpricetypes.ptype','schoolmenus.*','vendors.fname','vendors.lname')->get();
        return view('nontechmanager.cafeteria.itemsreports',$result);

    }

    public function feedback(){
        $mid=session()->get('NONTECH_MANAGER_ID');
        $aid=session()->get('NONTECH_MANAGER_ADMIN_ID');
        $result['hostels']=DB::table('hostels')->where('aid',$aid)->get();
     
        $result['data']=DB::table('foodfeedbacks')
                        ->join('vendors','foodfeedbacks.catererid','vendors.id')
                        ->join('hostels','foodfeedbacks.hostelid','hostels.id')
                        ->join('students','foodfeedbacks.stu_id','students.id')
                        ->where('foodfeedbacks.aid',$aid)
                        ->select('foodfeedbacks.*','vendors.fname','vendors.lname','students.sname','students.slname','hostels.hostel')
                        ->get();
        $result['aid']=$aid;
        return view('nontechmanager.cafeteria.feedbackreports',$result);

    }

    public function feedbackbyfilter(request $request){
        $mid=session()->get('NONTECH_MANAGER_ID');
        $aid=session()->get('NONTECH_MANAGER_ADMIN_ID');
        $result['hostels']=DB::table('hostels')->where('aid',$aid)->get();
     
        $result['data']=DB::table('foodfeedbacks')
                        ->join('vendors','foodfeedbacks.catererid','vendors.id')
                        ->join('hostels','foodfeedbacks.hostelid','hostels.id')
                        ->join('students','foodfeedbacks.stu_id','students.id')
                        ->where('foodfeedbacks.aid',$aid)
                        ->where('foodfeedbacks.hostelid',$request->hostel)
                        ->select('foodfeedbacks.*','vendors.fname','vendors.lname','students.sname','students.slname','hostels.hostel')
                        ->get();
        $result['aid']=$aid;
        return view('nontechmanager.cafeteria.feedbackreports',$result);
    }

    public function foodfeedbackexport(request $request,$aid){
        $name='Food Feedback List';
        return Excel::download(new foodfeedbackExport($aid), $name.'.xlsx'); 
    }
}
