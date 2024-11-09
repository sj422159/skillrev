<?php

namespace App\Http\Controllers\nontechgroupmanager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\nontechsupervisor;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\schoolExport;
use App\Exports\hostelExport;
use App\Exports\othersExport;
use App\Exports\feedbackExport;
use App\Exports\itemsExport;
use App\Exports\catererExport;
use Redirect,Response;

class foodinfocontroller extends Controller
{
    public function foodinfo(request $request){
        $sesid=session()->get('NONTECH_GROUPMANAGER_ID');
        $aid=session()->get('NONTECH_GROUPMANAGER_ADMIN_ID');
        $result['id']=$request->hostel;
        $school=DB::table('cafeteria_items')
                        ->join('cafeteriatype','cafeteria_items.cafetype','cafeteriatype.id')
                        ->join('cafeterias','cafeteria_items.cafeid','cafeterias.id')
                        ->join('infraitems','cafeteria_items.itemid','infraitems.id')
                        ->where('cafeteria_items.aid',$aid)
                        ->where('cafetype',1)
                        ->select('cafeteria_items.*','cafeteriatype.ctype','cafeterias.cafeteria','infraitems.infraitem')
                        ->get();
        $result['school']=count($school);
        $other=DB::table('cafeteria_items')
                        ->join('cafeteriatype','cafeteria_items.cafetype','cafeteriatype.id')
                        ->join('cafeterias','cafeteria_items.cafeid','cafeterias.id')
                        ->join('infraitems','cafeteria_items.itemid','infraitems.id')
                        ->where('cafeteria_items.aid',$aid)
                        ->where('cafetype',3)
                        ->select('cafeteria_items.*','cafeteriatype.ctype','cafeterias.cafeteria','infraitems.infraitem')
                        ->get();
        $result['other']=count($other);
        $hostel=DB::table('cafeteria_items')
                        ->join('cafeteriatype','cafeteria_items.cafetype','cafeteriatype.id')
                        ->join('cafeterias','cafeteria_items.cafeid','cafeterias.id')
                        ->join('infraitems','cafeteria_items.itemid','infraitems.id')
                        ->where('cafeteria_items.aid',$aid)
                        ->where('cafetype',2)
                        ->select('cafeteria_items.*','cafeteriatype.ctype','cafeterias.cafeteria','infraitems.infraitem')
                        ->get();
        $result['hostel']=count($hostel);
        $feedback=DB::table('foodfeedbacks')
                        ->join('vendors','foodfeedbacks.catererid','vendors.id')
                        ->join('hostels','foodfeedbacks.hostelid','hostels.id')
                        ->join('students','foodfeedbacks.stu_id','students.id')
                        ->where('foodfeedbacks.aid',$aid)
                        ->select('foodfeedbacks.*','vendors.fname','vendors.lname','students.sname','students.slname','hostels.hostel')
                        ->get();
        $result['foodfeed']=count($feedback);

        $fooditem=DB::table('fooditems')
                        ->join('foodcategories','fooditems.foodcat','foodcategories.id')
                        ->join('foodpricetypes','fooditems.pricetype','foodpricetypes.id')
                        ->where('fooditems.aid',$aid)
                        ->where('fooditems.mid',$request->hostel)
                        ->select('fooditems.*','foodcategories.foodcategory','foodpricetypes.ptype')
                        ->get();

        $result['fooditem']=count($fooditem);
        $caterer=DB::table('vendors')
                            ->join('cafeteriatype','vendors.cafeteriatype','cafeteriatype.id')
                            ->where('aid',$aid)
                            ->where('mid',$request->hostel)
                            ->select('vendors.*','cafeteriatype.ctype')
                            ->get();
        $result['foodcaterer']=count($caterer);
        $result['hostels']=DB::table('nontechmanagers')
                           ->join('departments','nontechmanagers.departmentid','departments.id')
                           ->where('departments.category',3)
                           ->where('supid',$sesid)
                           ->select('nontechmanagers.*')
                           ->get();
        return view('nontechgroupmanager.cafeteriadashboard',$result);
    }

    public function school($id){
        $aid=session()->get('NONTECH_GROUPMANAGER_ADMIN_ID');   
        $result['data']=DB::table('cafeteria_items')
                        ->join('cafeteriatype','cafeteria_items.cafetype','cafeteriatype.id')
                        ->join('cafeterias','cafeteria_items.cafeid','cafeterias.id')
                        ->join('infraitems','cafeteria_items.itemid','infraitems.id')
                        ->where('cafeteria_items.aid',$aid)
                        ->where('cafetype',1)
                        ->select('cafeteria_items.*','cafeteriatype.ctype','cafeterias.cafeteria','infraitems.infraitem')
                        ->get();
        $result['aid']=$aid;
        return view('nontechgroupmanager.foodschoolinfra',$result);
    }

    public function schoolexport(request $request,$aid){
        $name='School Cafeteria List';
        return Excel::download(new schoolExport($aid), $name.'.xlsx'); 
    }

    public function hostel($id){
        $aid=session()->get('NONTECH_GROUPMANAGER_ADMIN_ID');   
        $result['data']=DB::table('cafeteria_items')
                        ->join('cafeteriatype','cafeteria_items.cafetype','cafeteriatype.id')
                        ->join('cafeterias','cafeteria_items.cafeid','cafeterias.id')
                        ->join('infraitems','cafeteria_items.itemid','infraitems.id')
                        ->where('cafeteria_items.aid',$aid)
                        ->where('cafetype',2)
                        ->select('cafeteria_items.*','cafeteriatype.ctype','cafeterias.cafeteria','infraitems.infraitem')
                        ->get();
        $result['aid']=$aid;
        return view('nontechgroupmanager.foodhostelinfra',$result);
    }
    
    public function hostelexport(request $request,$aid){
        $name='Hostel Infrastructure List';
        return Excel::download(new hostelExport($aid), $name.'.xlsx'); 
    }

    public function others($id){
        $aid=session()->get('NONTECH_GROUPMANAGER_ADMIN_ID');   
        $result['data']=DB::table('cafeteria_items')
                        ->join('cafeteriatype','cafeteria_items.cafetype','cafeteriatype.id')
                        ->join('cafeterias','cafeteria_items.cafeid','cafeterias.id')
                        ->join('infraitems','cafeteria_items.itemid','infraitems.id')
                        ->where('cafeteria_items.aid',$aid)
                        ->where('cafetype',3)
                        ->select('cafeteria_items.*','cafeteriatype.ctype','cafeterias.cafeteria','infraitems.infraitem')
                        ->get();
        $result['aid']=$aid;
        return view('nontechgroupmanager.foodothersinfra',$result);
    }

    public function othersexport(request $request,$aid){
        $name='Other Cafeteria List';
        return Excel::download(new othersExport($aid), $name.'.xlsx'); 
    }

    public function feedback($id){
        $aid=session()->get('NONTECH_GROUPMANAGER_ADMIN_ID');
        $result['hostels']=DB::table('hostels')->where('aid',$aid)->get();
        $result['data']=DB::table('foodfeedbacks')
                        ->join('vendors','foodfeedbacks.catererid','vendors.id')
                        ->join('hostels','foodfeedbacks.hostelid','hostels.id')
                        ->join('students','foodfeedbacks.stu_id','students.id')
                        ->where('foodfeedbacks.aid',$aid)
                        ->select('foodfeedbacks.*','vendors.fname','vendors.lname','students.sname','students.slname','hostels.hostel')
                        ->get();
        $result['aid']=$aid;
        return view('nontechgroupmanager.feedbackinfo',$result);
    }

    public function feedbackbyfilter(request $request){
        $aid=session()->get('NONTECH_GROUPMANAGER_ADMIN_ID');
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
        return view('nontechgroupmanager.feedbackinfo',$result);
    }

    public function feedbackexport(request $request,$aid){
        $name='Food Feedbacks List';
        return Excel::download(new feedbackExport($aid), $name.'.xlsx'); 
    }

    public function items($id){  
        $aid=session()->get('NONTECH_GROUPMANAGER_ADMIN_ID');
        $result['data']=DB::table('fooditems')
                        ->join('foodcategories','fooditems.foodcat','foodcategories.id')
                        ->join('foodpricetypes','fooditems.pricetype','foodpricetypes.id')
                        ->where('fooditems.aid',$aid)
                        ->where('fooditems.mid',$id)
                        ->select('fooditems.*','foodcategories.foodcategory','foodpricetypes.ptype')
                        ->get();
        $result['mid']=$id;
        $result['aid']=$aid;
        return view('nontechgroupmanager.fooditems',$result);
    }

    public function itemsexport(request $request,$aid,$mid){
        $name='Food Items List';
        return Excel::download(new itemsExport($aid,$mid), $name.'.xlsx'); 
    }

    public function caterer($id){    
        $aid=session()->get('NONTECH_GROUPMANAGER_ADMIN_ID');
        $result['userroles']=DB::table('vendors')
                            ->join('cafeteriatype','vendors.cafeteriatype','cafeteriatype.id')
                            ->where('aid',$aid)
                            ->where('mid',$id)
                            ->select('vendors.*','cafeteriatype.ctype')
                            ->get();
        $result['mid']=$id;
        $result['aid']=$aid;
        return view('nontechgroupmanager.caterer',$result);
    }

    public function catererexport(request $request,$aid,$mid){
        $name='Food Caterer List';
        return Excel::download(new catererExport($aid,$mid), $name.'.xlsx'); 
    }

}