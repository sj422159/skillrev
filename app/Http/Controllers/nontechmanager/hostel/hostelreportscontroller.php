<?php

namespace App\Http\Controllers\nontechmanager\hostel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\hostelrooms;
use App\Models\infragroup;
use App\Models\hostelitems;
use App\Models\student;
use Redirect,Response;

class hostelreportscontroller extends Controller
{
    public function allocationreports(){
          $aid=session()->get('NONTECH_MANAGER_ADMIN_ID');   
         $result['hostels']=DB::table('hostels')->where('aid',$aid)->get();
         $result['data']=DB::table('hostelitems')
                         ->join('hostels','hostelitems.hostelid','hostels.id')
                         ->join('hostelrooms','hostelitems.roomid','hostelrooms.id')
                         ->join('infraitems','hostelitems.itemid','infraitems.id')
                         ->join('students','hostelitems.stu_id','students.id')
                        ->join('categories','students.sclassid','categories.id')
                        ->join('lmssections','students.ssectionid','lmssections.id')
                         ->where('hostelitems.aid',$aid)
                         ->where('hostelitems.itemid',2)
                         ->select('hostelitems.*','hostels.hostel','hostelrooms.roomname','students.sname','students.slname','students.snumber','infraitems.infraitem','categories.categories','lmssections.section')->get();;
       
        return view('nontechmanager.hostel.allocationreports',$result);
    }

     public function allocationreportsbyfilter(Request $request){
         $aid=session()->get('NONTECH_MANAGER_ADMIN_ID');   
         $sesid=session()->get('NONTECH_MANAGER_ID');
         $result['hostels']=DB::table('hostels')->where('aid',$aid)->get();
          $result['data']=DB::table('hostelitems')
                         ->join('hostels','hostelitems.hostelid','hostels.id')
                         ->join('hostelrooms','hostelitems.roomid','hostelrooms.id')
                         ->join('infraitems','hostelitems.itemid','infraitems.id')
                         ->join('students','hostelitems.stu_id','students.id')
                        ->join('categories','students.sclassid','categories.id')
                        ->join('lmssections','students.ssectionid','lmssections.id')
                         ->where('hostelitems.aid',$aid)
                         ->where('hostelitems.itemid',2)
                          ->where('hostelitems.hostelid',$request->hostel)
                         ->where('hostelitems.roomid',$request->roomno)
                         ->select('hostelitems.*','hostels.hostel','hostelrooms.roomname','students.sname','students.slname','students.snumber','infraitems.infraitem','categories.categories','lmssections.section')->get();
        return view('nontechmanager.hostel.allocationreports',$result);
    }

    public function infrastructurerepairs(){
         $aid=session()->get('NONTECH_MANAGER_ADMIN_ID');
                 $result['items']=DB::table('infraitems')->get();
                 $result['hostels']=DB::table('hostels')->where('aid',$aid)->get();
                   $result['data']=DB::table('hostelinfrarepairhistories')
                         ->join('hostels','hostelinfrarepairhistories.hostelid','hostels.id')
                         ->join('hostelrooms','hostelinfrarepairhistories.roomid','hostelrooms.id')
                         ->join('infraitems','hostelinfrarepairhistories.itemid','infraitems.id')
                         ->where('hostelinfrarepairhistories.aid',$aid)
                         ->select('hostelinfrarepairhistories.*','hostels.hostel','hostelrooms.roomname','infraitems.infraitem')->get();;
                    
        return view('nontechmanager.hostel.hostelinfrarepairreports',$result);
    }

    public function infrastructurerepairsbyfilter(request $request){
       $aid=session()->get('NONTECH_MANAGER_ADMIN_ID');
                 $result['items']=DB::table('infraitems')->get();
                 $result['hostels']=DB::table('hostels')->where('aid',$aid)->get();
                   $result['data']=DB::table('hostelinfrarepairhistories')
                         ->join('hostels','hostelinfrarepairhistories.hostelid','hostels.id')
                         ->join('hostelrooms','hostelinfrarepairhistories.roomid','hostelrooms.id')
                         ->join('infraitems','hostelinfrarepairhistories.itemid','infraitems.id')
                         ->where('hostelinfrarepairhistories.aid',$aid)
                          ->where('hostelinfrarepairhistories.hostelid',$request->hostel)
                         ->where('hostelinfrarepairhistories.roomid',$request->roomno)
                         ->where('hostelinfrarepairhistories.itemid',$request->item)
                         ->select('hostelinfrarepairhistories.*','hostels.hostel','hostelrooms.roomname','infraitems.infraitem')->get();;
                    
        return view('nontechmanager.hostel.hostelinfrarepairreports',$result);  
    }

    public function foodreports(){
          $aid=session()->get('NONTECH_MANAGER_ADMIN_ID');
         $result['hostels']=DB::table('hostels')->where('aid',$aid)->get();
         $result['data']=DB::table('skipmeals')
                           ->join('hostels','skipmeals.hostelid','hostels.id')
                           ->join('foodcategories','skipmeals.catid','foodcategories.id')
                           ->join('students','skipmeals.stu_id','students.id')
                           ->select('skipmeals.*','foodcategories.foodcategory','students.sname','students.slname','hostels.hostel')->get();
        return view('nontechmanager.hostel.foodreports',$result);
    }
     public function foodreportsbyfilter(request $request){
          $aid=session()->get('NONTECH_MANAGER_ADMIN_ID');
         $result['hostels']=DB::table('hostels')->where('aid',$aid)->get();
         $result['data']=DB::table('skipmeals')
                           ->join('hostels','skipmeals.hostelid','hostels.id')
                           ->join('foodcategories','skipmeals.catid','foodcategories.id')
                           ->join('students','skipmeals.stu_id','students.id')
                           ->where('skipmeals.hostelid',$request->hostel)
                           ->select('skipmeals.*','foodcategories.foodcategory','students.sname','students.slname','hostels.hostel')->get();
        return view('nontechmanager.hostel.foodreports',$result);
    }

}
