<?php

namespace App\Http\Controllers\nontechgroupmanager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\nontechsupervisor;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\schoolinfoExport;
use App\Exports\cafeteriainfoExport;
use App\Exports\hostelinfoExport;
use App\Exports\infraitemsinfoExport;
use Redirect,Response;

class infrainfocontroller extends Controller {

    public function infrainfo(request $request){
        $sesid=session()->get('NONTECH_GROUPMANAGER_ID');
        $aid=session()->get('NONTECH_GROUPMANAGER_ADMIN_ID');
        $result['id']=$request->hostel;
        $school=DB::table('schoolitems')
                        ->join('categories','schoolitems.classid','categories.id')
                        ->join('lmssections','schoolitems.sectionid','lmssections.id')
                        ->join('infraitems','schoolitems.itemid','infraitems.id')
                        ->where('schoolitems.mid',$request->hostel)
                        ->select('schoolitems.*','categories.categories','lmssections.section','infraitems.infraitem')
                        ->get();
        $result['school']=count($school);
        $cafeteria=DB::table('cafeteria_items')
                        ->join('cafeteriatype','cafeteria_items.cafetype','cafeteriatype.id')
                        ->join('cafeterias','cafeteria_items.cafeid','cafeterias.id')
                        ->join('infraitems','cafeteria_items.itemid','infraitems.id')
                        ->where('cafeteria_items.mid',$request->hostel)
                        ->select('cafeteria_items.*','cafeteriatype.ctype','cafeterias.cafeteria','infraitems.infraitem')
                        ->get();
        $result['cafeteria']=count($cafeteria);
        $a=DB::table('hostelinfrarepairhistories')
                         ->join('categories','hostelinfrarepairhistories.classid','categories.id')
                         ->join('lmssections','hostelinfrarepairhistories.sectionid','lmssections.id')
                         ->join('infraitems','hostelinfrarepairhistories.itemid','infraitems.id')
                         ->where('hostelinfrarepairhistories.mid',$request->hostel)
                         ->where('type',2)
                         ->select('hostelinfrarepairhistories.*','categories.categories','lmssections.section','infraitems.infraitem')->get();;
           

    
         $b=DB::table('hostelinfrarepairhistories')
                         ->join('hostels','hostelinfrarepairhistories.hostelid','hostels.id')
                         ->join('hostelrooms','hostelinfrarepairhistories.roomid','hostelrooms.id')
                         ->join('infraitems','hostelinfrarepairhistories.itemid','infraitems.id')
                         ->where('hostelinfrarepairhistories.mid',$request->hostel)
                         ->where('type',1)
                         ->select('hostelinfrarepairhistories.*','hostels.hostel','hostelrooms.roomname','infraitems.infraitem')->get();;
            $c=DB::table('cafeteriainfrarepairhistories')
                          ->join('cafeteriatype','cafeteriainfrarepairhistories.cafetype','cafeteriatype.id')
                          ->join('cafeterias','cafeteriainfrarepairhistories.cafeid','cafeterias.id')
                        ->join('infraitems','cafeteriainfrarepairhistories.itemid','infraitems.id')
                         ->where('cafeteriainfrarepairhistories.mid',$request->hostel)
                         ->select('cafeteriatype.ctype','cafeterias.cafeteria','infraitems.infraitem','cafeteriainfrarepairhistories.*')->get();
        $result['repair']=count($a)+count($b)+count($c);
        $hostel=DB::table('hostelitems')
                        ->join('hostels','hostelitems.hostelid','hostels.id')
                        ->join('hostelrooms','hostelitems.roomid','hostelrooms.id')
                        ->join('infraitems','hostelitems.itemid','infraitems.id')
                        ->where('hostelitems.mid',$request->hostel)
                        ->select('hostelitems.*','hostels.hostel','hostelrooms.roomname','infraitems.infraitem')
                        ->get();  
        $result['hostel']=count($hostel);
        $other=DB::table('others_items')
                        ->join('rooms','others_items.roomid','rooms.id')
                        ->join('infraitems','others_items.itemid','infraitems.id')
                        ->where('others_items.mid',$request->hostel)
                        ->select('others_items.*','rooms.roomname','rooms.capacity','infraitems.infraitem')
                        ->get();
        $result['others']=count($other);
        $infraitems=DB::table('infraitems')->get();
        $result['infra']=count($infraitems);
        $result['hostels']= DB::table('nontechmanagers')
                            ->join('departments','nontechmanagers.departmentid','departments.id')
                            ->where('departments.category',2)
                            ->where('supid',$sesid)
                            ->select('nontechmanagers.*')
                            ->get();
        return view('nontechgroupmanager.infrastructure',$result);
    }

    public function repair($id){
         $result['data']=DB::table('hostelinfrarepairhistories')
                         ->join('categories','hostelinfrarepairhistories.classid','categories.id')
                         ->join('lmssections','hostelinfrarepairhistories.sectionid','lmssections.id')
                         ->join('infraitems','hostelinfrarepairhistories.itemid','infraitems.id')
                         ->where('hostelinfrarepairhistories.mid',$id)
                         ->where('type',2)
                         ->select('hostelinfrarepairhistories.*','categories.categories','lmssections.section','infraitems.infraitem')->get();;
           

    
         $result['data1']=DB::table('hostelinfrarepairhistories')
                         ->join('hostels','hostelinfrarepairhistories.hostelid','hostels.id')
                         ->join('hostelrooms','hostelinfrarepairhistories.roomid','hostelrooms.id')
                         ->join('infraitems','hostelinfrarepairhistories.itemid','infraitems.id')
                         ->where('hostelinfrarepairhistories.mid',$id)
                         ->where('type',1)
                         ->select('hostelinfrarepairhistories.*','hostels.hostel','hostelrooms.roomname','infraitems.infraitem')->get();;
            $result['data2']=DB::table('cafeteriainfrarepairhistories')
                          ->join('cafeteriatype','cafeteriainfrarepairhistories.cafetype','cafeteriatype.id')
                          ->join('cafeterias','cafeteriainfrarepairhistories.cafeid','cafeterias.id')
                        ->join('infraitems','cafeteriainfrarepairhistories.itemid','infraitems.id')
                         ->where('cafeteriainfrarepairhistories.mid',$id)
                         ->select('cafeteriatype.ctype','cafeterias.cafeteria','infraitems.infraitem','cafeteriainfrarepairhistories.*')->get();

            return view('nontechgroupmanager.infrarepairs',$result);
    }

    public function schoolinfra($id){
        $aid=session()->get('NONTECH_GROUPMANAGER_ADMIN_ID');
        $sesid=session()->get('NONTECH_GROUPMANAGER_ID');
        $result['items']=DB::table('infraitems')->get();
        $result['class']=DB::table('categories')->where('aid',$sesid)->get();
        $result['id']=$id;
        $result['data']=DB::table('schoolitems')
                        ->join('categories','schoolitems.classid','categories.id')
                        ->join('lmssections','schoolitems.sectionid','lmssections.id')
                        ->join('infraitems','schoolitems.itemid','infraitems.id')
                        ->where('schoolitems.mid',$id)
                        ->select('schoolitems.*','categories.categories','lmssections.section','infraitems.infraitem')
                        ->get();
        return view('nontechgroupmanager.schoolinfra',$result);
    }

     public function othersinfra($id){
        $aid=session()->get('NONTECH_GROUPMANAGER_ADMIN_ID');
        $sesid=session()->get('NONTECH_GROUPMANAGER_ID');
        $result['items']=DB::table('infraitems')->get();
         $result['rooms']=DB::table('rooms')->get();
        $result['id']=$id;
          $result['data']=DB::table('others_items')
                        ->join('rooms','others_items.roomid','rooms.id')
                        ->join('infraitems','others_items.itemid','infraitems.id')
                        ->where('others_items.mid',$id)
                        ->select('others_items.*','rooms.roomname','rooms.capacity','infraitems.infraitem')
                        ->get();
        return view('nontechgroupmanager.othersinfra',$result);
    }
     public function othersinfrabyfilter(request $request){
        $aid=session()->get('NONTECH_GROUPMANAGER_ADMIN_ID');
        $sesid=session()->get('NONTECH_GROUPMANAGER_ID');
        $result['items']=DB::table('infraitems')->get();
         $result['rooms']=DB::table('rooms')->get();
         $result['id']=$request->id;
         $result['data']=DB::table('others_items')
                        ->join('rooms','others_items.roomid','rooms.id')
                        ->join('infraitems','others_items.itemid','infraitems.id')
                        ->where('others_items.mid',$request->id)
                        ->where('others_items.roomid',$request->hostel)
                        ->where('others_items.itemid',$request->item)
                        ->select('others_items.*','rooms.roomname','rooms.capacity','infraitems.infraitem')
                        ->get();
        return view('nontechgroupmanager.othersinfra',$result);
    }

    public function schoolinfrabyfilter(request $request){
        $aid=session()->get('NONTECH_GROUPMANAGER_ADMIN_ID');
        $sesid=session()->get('NONTECH_GROUPMANAGER_ID');
        $result['items']=DB::table('infraitems')->get();
        $result['class']=DB::table('categories')->where('aid',$sesid)->get();
        $result['id']=$request->id;
        $result['data']=DB::table('schoolitems')
                        ->join('categories','schoolitems.classid','categories.id')
                        ->join('lmssections','schoolitems.sectionid','lmssections.id')
                        ->join('infraitems','schoolitems.itemid','infraitems.id')
                        ->where('schoolitems.classid',$request->class)
                        ->where('schoolitems.sectionid',$request->section)
                        ->where('schoolitems.itemid',$request->item)
                        ->where('schoolitems.mid',$request->id)
                        ->select('schoolitems.*','categories.categories','lmssections.section','infraitems.infraitem')
                        ->get();
        return view('nontechgroupmanager.schoolinfra',$result);
    }

    public function schoolinfraexport(request $request,$id){
        $name='School Infrastructure List';
        return Excel::download(new schoolinfoExport($id), $name.'.xlsx'); 
    }

    public function cafeteriainfra($id){
        $aid=session()->get('NONTECH_GROUPMANAGER_ADMIN_ID');
        $sesid=session()->get('NONTECH_GROUPMANAGER_ID');
        $result['id']=$id;
        $result['items']=DB::table('infraitems')->get();
        $result['ctypes']=DB::table('cafeteriatype')->get();
        $result['data']=DB::table('cafeteria_items')
                        ->join('cafeteriatype','cafeteria_items.cafetype','cafeteriatype.id')
                        ->join('cafeterias','cafeteria_items.cafeid','cafeterias.id')
                        ->join('infraitems','cafeteria_items.itemid','infraitems.id')
                        ->where('cafeteria_items.aid',$aid)
                        ->where('cafeteria_items.mid',$id)
                        ->select('cafeteria_items.*','cafeteriatype.ctype','cafeterias.cafeteria','infraitems.infraitem')
                        ->get();
        return view('nontechgroupmanager.cafeteria',$result); 
    }

    public function cafeteriainfrabyfilter(request $request){
        $aid=session()->get('NONTECH_GROUPMANAGER_ADMIN_ID');
        $sesid=session()->get('NONTECH_GROUPMANAGER_ID');
        $result['id']=$request->id;
        $result['items']=DB::table('infraitems')->get();
        $result['ctypes']=DB::table('cafeteriatype')->get();
        $result['data']=DB::table('cafeteria_items')
                        ->join('cafeteriatype','cafeteria_items.cafetype','cafeteriatype.id')
                        ->join('cafeterias','cafeteria_items.cafeid','cafeterias.id')
                        ->join('infraitems','cafeteria_items.itemid','infraitems.id')
                        ->where('cafeteria_items.aid',$aid)
                        ->where('cafeteria_items.mid',$request->id)
                        ->where('cafeteria_items.cafetype',$request->hostel)
                        ->where('cafeteria_items.cafeid',$request->roomno)
                        ->where('cafeteria_items.itemid',$request->item)
                        ->select('cafeteria_items.*','cafeteriatype.ctype','cafeterias.cafeteria','infraitems.infraitem')
                        ->get();
        return view('nontechgroupmanager.cafeteria',$result); 
    }

    public function cafeteriainfraexport(request $request,$id){
        $name='Cafeteria Infrastructure List';
        return Excel::download(new cafeteriainfoExport($id), $name.'.xlsx'); 
    }

    public function hostelinfra($id){
        $aid=session()->get('NONTECH_GROUPMANAGER_ADMIN_ID');
        $sesid=session()->get('NONTECH_GROUPMANAGER_ID');
        $result['id']=$id;
        $result['items']=DB::table('infraitems')->get();
        $result['hostels']=DB::table('hostels')->where('aid',$aid)->get();
        $result['data']=DB::table('hostelitems')
                        ->join('hostels','hostelitems.hostelid','hostels.id')
                        ->join('hostelrooms','hostelitems.roomid','hostelrooms.id')
                        ->join('infraitems','hostelitems.itemid','infraitems.id')
                        ->where('hostelitems.mid',$id)
                        ->select('hostelitems.*','hostels.hostel','hostelrooms.roomname','infraitems.infraitem')
                        ->get();    
        return view('nontechgroupmanager.infrahostelreport',$result);
    }

    public function hostelinfrabyfilter(Request $request){
        $aid=session()->get('NONTECH_GROUPMANAGER_ADMIN_ID');
        $sesid=session()->get('NONTECH_GROUPMANAGER_ID');
        $result['id']=$request->id;
        $result['items']=DB::table('infraitems')->get();
        $result['hostels']=DB::table('hostels')->where('aid',$aid)->get();
        $result['data']=DB::table('hostelitems')
                        ->join('hostels','hostelitems.hostelid','hostels.id')
                        ->join('hostelrooms','hostelitems.roomid','hostelrooms.id')
                        ->join('infraitems','hostelitems.itemid','infraitems.id')
                        ->where('hostelitems.mid',$request->id)
                        ->where('hostelitems.hostelid',$request->hostel)
                        ->where('hostelitems.roomid',$request->roomno)
                        ->where('hostelitems.itemid',$request->item)
                        ->select('hostelitems.*','hostels.hostel','hostelrooms.roomname','infraitems.infraitem')
                        ->get();

        return view('nontechgroupmanager.infrahostelreport',$result);
    }

    public function hostelinfraexport(request $request,$id){
        $name='Hostel Infrastructure List';
        return Excel::download(new hostelinfoExport($id), $name.'.xlsx'); 
    }

    public function infraitems($id){
        $result['items']=DB::table('infraitems')->get();
        $result['id']=$id;
        return view('nontechgroupmanager.infraitems',$result);
    }

    public function infraitemsexport(request $request,$id){
        $name='Infrastructure Items List';
        return Excel::download(new infraitemsinfoExport($id), $name.'.xlsx'); 
    }

    public function getnames(){
        $id = $_GET['cid'];
        $res = DB::table('cafeterias')->where('cattype', $id)->get();
        return Response::json($res);
    }

    public function getrooms(){
        $id = $_GET['cid'];
        $res = DB::table('hostelrooms')->where('hostelid', $id)->get();
        return Response::json($res);
    }

    public  function getsections(request $request){
        $classid = $request->post('classid');
        $state = DB::table('lmssections')->where('classid',$classid)->get();
        echo $html='<option value="">Select</option>';
        foreach($state as $list){
          echo  $html='<option value="'.$list->id.'">'.$list->section.'</option>';
        }
    }

}