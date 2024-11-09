<?php

namespace App\Http\Controllers\nontechgroupmanager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\nontechsupervisor;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\bedinfoExport;
use App\Exports\roominfoExport;
use App\Exports\infrainfoExport;
use App\Exports\infrastructurerepairsinfoExport;
use App\Exports\skiprepairsinfoExport;
use Redirect,Response;

class hostelinfocontroller extends Controller
{
    public function bedinfo($id){
        $sesid=session()->get('NONTECH_GROUPMANAGER_ID');
        $aid=session()->get('NONTECH_GROUPMANAGER_ADMIN_ID');   
        $result['hostels']=DB::table('hostels')->where('aid',$aid)->get();
        $result['id']=$id;
        $result['data']=DB::table('hostelitems')
                        ->join('hostels','hostelitems.hostelid','hostels.id')
                        ->join('hostelrooms','hostelitems.roomid','hostelrooms.id')
                        ->join('infraitems','hostelitems.itemid','infraitems.id')
                        ->join('students','hostelitems.stu_id','students.id')
                        ->join('categories','students.sclassid','categories.id')
                        ->join('lmssections','students.ssectionid','lmssections.id')
                        ->where('hostelitems.mid',$id)
                        ->where('hostelitems.itemid',2)
                        ->select('hostelitems.*','hostels.hostel','hostelrooms.roomname','students.sname','students.slname','students.snumber','infraitems.infraitem','categories.categories','lmssections.section')
                        ->get();
        return view('nontechgroupmanager.allocation',$result); 
    }

    public function bedinfobyfilter(Request $request){
         $aid=session()->get('NONTECH_GROUPMANAGER_ADMIN_ID');   
         $sesid=session()->get('NONTECH_GROUPMANAGER_ID');
         $result['hostels']=DB::table('hostels')->where('aid',$aid)->get();
         $result['id']=$request->id;
          $result['data']=DB::table('hostelitems')
                         ->join('hostels','hostelitems.hostelid','hostels.id')
                         ->join('hostelrooms','hostelitems.roomid','hostelrooms.id')
                         ->join('infraitems','hostelitems.itemid','infraitems.id')
                         ->join('students','hostelitems.stu_id','students.id')
                        ->join('categories','students.sclassid','categories.id')
                        ->join('lmssections','students.ssectionid','lmssections.id')
                         ->where('hostelitems.mid',$request->id)
                         ->where('hostelitems.itemid',2)
                          ->where('hostelitems.hostelid',$request->hostel)
                         ->where('hostelitems.roomid',$request->roomno)
                         ->select('hostelitems.*','hostels.hostel','hostelrooms.roomname','students.sname','students.slname','students.snumber','infraitems.infraitem','categories.categories','lmssections.section')->get();
        return view('nontechgroupmanager.allocation',$result);
    }

    public function bedinfoexport(request $request,$id){
        $name='Bed Allocation List';
        return Excel::download(new bedinfoExport($id), $name.'.xlsx'); 
    }

    public function roominfo($id){
        $aid=session()->get('NONTECH_GROUPMANAGER_ADMIN_ID'); 
        $result['hostels']=DB::table('hostels')->where('aid',$aid)->get();
        $result['hostelid']=0;
        $result['id']=$id;
        $result['room']=DB::table('hostelrooms')
                        ->join('hostels','hostelrooms.hostelid','hostels.id')
                        ->where('mid',$id)
                        ->select('hostelrooms.*','hostels.hostel')
                        ->get();
        for($i=0;$i<count($result['room']);$i++){
            $a=DB::table('hostelitems')->where('roomid',$result['room'][$i]->id)->where('itemid',2)->get();
            $result['room'][$i]->allocated=count($a);
            $b=DB::table('hostelitems')->where('roomid',$result['room'][$i]->id)->where('itemid',2)->where('stu_id','!=',0)->get();
            $result['room'][$i]->assigned=count($b);

        }
        return view('nontechgroupmanager.roominfo',$result);
    }

    public function roominfobyfilter(request $request){
        $aid=session()->get('NONTECH_GROUPMANAGER_ADMIN_ID'); 
        $result['hostels']=DB::table('hostels')->where('aid',$aid)->get();
        $result['hostelid']=$request->hostel;
        $result['id']=$request->id;
        $result['room']=DB::table('hostelrooms')
                        ->join('hostels','hostelrooms.hostelid','hostels.id')
                        ->where('hostelid',$request->hostel)
                        ->where('mid',$request->id)
                        ->select('hostelrooms.*','hostels.hostel')
                        ->get();
        for($i=0;$i<count($result['room']);$i++){
            $a=DB::table('hostelitems')->where('roomid',$result['room'][$i]->id)->where('itemid',2)->get();
            $result['room'][$i]->allocated=count($a);
            $b=DB::table('hostelitems')->where('roomid',$result['room'][$i]->id)->where('itemid',2)->where('stu_id','!=',0)->get();
            $result['room'][$i]->assigned=count($b);
        }
        return view('nontechgroupmanager.roominfo',$result);
    }

    public function roominfoexport(request $request,$id){
        $name='Rooms List';
        return Excel::download(new roominfoExport($id), $name.'.xlsx'); 
    }

    public function infrainfo($id){
        $aid=session()->get('NONTECH_GROUPMANAGER_ADMIN_ID');
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
        return view('nontechgroupmanager.hostelinfra',$result);            
    }

    public function infrainfobyfilter(Request $request){
        $aid=session()->get('NONTECH_GROUPMANAGER_ADMIN_ID');
        $result['items']=DB::table('infraitems')->get();
        $result['hostels']=DB::table('hostels')->where('aid',$aid)->get();
        $result['id']=$request->id;
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
        return view('nontechgroupmanager.hostelinfra',$result);
    }

    public function infrainfoexport(request $request,$id){
        $name='Hostel Infrastructure List';
        return Excel::download(new infrainfoExport($id), $name.'.xlsx'); 
    }

    public function foodinfo($id){
        $sesid=$id; 
        $aid=session()->get('NONTECH_GROUPMANAGER_ADMIN_ID');
        $result['hostels']=DB::table('hostels')->where('aid',$aid)->get();
        $result['hostelid']=0;
        $result['check']=[];
        return view('nontechgroupmanager.foodmenu',$result);  
    }

    public function foodinfobyfilter(request $request){
        $aid=session()->get('NONTECH_GROUPMANAGER_ADMIN_ID');
        $result['hostels']=DB::table('hostels')->where('aid',$aid)->get();
        $result['hostelid']=$request->hostel;

        $result['check']=[];
        for ($i=1; $i<=7 ; $i++) { 
            $data1= DB::table('hostelmenus')
                    ->join('fooditems','hostelmenus.fitemid','fooditems.id')
                    ->join('foodcategories','fooditems.foodcat','foodcategories.id')
                    ->where('dayid',$i)
                    ->where('fooditems.foodcat',1)
                    ->where('hostelid',$request->hostel)
                    ->select('hostelmenus.*','fooditems.fooditems','foodcategories.foodcategory')
                    ->get();
            $data2= DB::table('hostelmenus')
                    ->join('fooditems','hostelmenus.fitemid','fooditems.id')
                    ->join('foodcategories','fooditems.foodcat','foodcategories.id')
                    ->where('dayid',$i)
                    ->where('fooditems.foodcat',2)
                    ->where('hostelid',$request->hostel)
                    ->select('hostelmenus.*','fooditems.fooditems','foodcategories.foodcategory')
                    ->get();
            $data4= DB::table('hostelmenus')
                    ->join('fooditems','hostelmenus.fitemid','fooditems.id')
                    ->join('foodcategories','fooditems.foodcat','foodcategories.id')
                    ->where('dayid',$i)
                    ->where('fooditems.foodcat',4)
                    ->where('hostelid',$request->hostel)
                    ->select('hostelmenus.*','fooditems.fooditems','foodcategories.foodcategory')
                    ->get();
            $data6= DB::table('hostelmenus')
                    ->join('fooditems','hostelmenus.fitemid','fooditems.id')
                    ->join('foodcategories','fooditems.foodcat','foodcategories.id')
                    ->where('dayid',$i)
                    ->where('fooditems.foodcat',6)
                    ->where('hostelid',$request->hostel)
                    ->select('hostelmenus.*','fooditems.fooditems','foodcategories.foodcategory')
                    ->get();

            if (count($data1)>0) {
              $result['check'][$i][0]=1;
            }else {
                $result['check'][$i][0]=0;
            } 

            if (count($data2)>0) {
                $result['check'][$i][1]=1;
            }else {
                $result['check'][$i][1]=0;
            } 

            if (count($data4)>0) {
                $result['check'][$i][2]=1;
            }else {
                $result['check'][$i][2]=0;
            } 

            if (count($data6)>0) {
                $result['check'][$i][3]=1;
            }else {
                $result['check'][$i][3]=0;
            } 

        }
        return view('nontechgroupmanager.foodmenu',$result);  
    }

    public function infrastructurerepairs($id){
        $result['id']=$id;
        $aid=session()->get('NONTECH_GROUPMANAGER_ADMIN_ID');
        $result['items']=DB::table('infraitems')->get();
        $result['hostels']=DB::table('hostels')->where('aid',$aid)->get();
        $result['data']=DB::table('hostelinfrarepairhistories')
                        ->join('hostels','hostelinfrarepairhistories.hostelid','hostels.id')
                        ->join('hostelrooms','hostelinfrarepairhistories.roomid','hostelrooms.id')
                        ->join('infraitems','hostelinfrarepairhistories.itemid','infraitems.id')
                        ->where('hostelinfrarepairhistories.mid',$id)
                        ->select('hostelinfrarepairhistories.*','hostels.hostel','hostelrooms.roomname','infraitems.infraitem')->get();            
        return view('nontechgroupmanager.infrarepairreports',$result);
    }

    public function infrastructurerepairsbyfilter(request $request){
        $result['id']=$request->id;
        $aid=session()->get('NONTECH_GROUPMANAGER_ADMIN_ID');
        $result['items']=DB::table('infraitems')->get();
        $result['hostels']=DB::table('hostels')->where('aid',$aid)->get();
        $result['data']=DB::table('hostelinfrarepairhistories')
                        ->join('hostels','hostelinfrarepairhistories.hostelid','hostels.id')
                        ->join('hostelrooms','hostelinfrarepairhistories.roomid','hostelrooms.id')
                        ->join('infraitems','hostelinfrarepairhistories.itemid','infraitems.id')
                        ->where('hostelinfrarepairhistories.mid',$request->id)
                        ->where('hostelinfrarepairhistories.hostelid',$request->hostel)
                        ->where('hostelinfrarepairhistories.roomid',$request->roomno)
                        ->where('hostelinfrarepairhistories.itemid',$request->item)
                        ->select('hostelinfrarepairhistories.*','hostels.hostel','hostelrooms.roomname','infraitems.infraitem')
                        ->get();
        return view('nontechgroupmanager.infrarepairreports',$result);  
    }

    public function infrastructurerepairsinfoexport(request $request,$id){
        $name='Repairs History List';
        return Excel::download(new infrastructurerepairsinfoExport($id), $name.'.xlsx'); 
    }

    public function skipreports($id){
        $aid=session()->get('NONTECH_GROUPMANAGER_ADMIN_ID');
        $result['hostels']=DB::table('hostels')->where('aid',$aid)->get();
        $result['data']=DB::table('skipmeals')
                        ->join('hostels','skipmeals.hostelid','hostels.id')
                        ->join('foodcategories','skipmeals.catid','foodcategories.id')
                        ->join('students','skipmeals.stu_id','students.id')
                        ->where('hostels.aid',$aid)
                        ->select('skipmeals.*','foodcategories.foodcategory','students.sname','students.slname','hostels.hostel')
                        ->get();
        $result['id']=$aid;
        return view('nontechgroupmanager.foodskipreports',$result);
    }

    public function skipreportsbyfilter(request $request){
        $aid=session()->get('NONTECH_GROUPMANAGER_ADMIN_ID');
        $result['hostels']=DB::table('hostels')->where('aid',$aid)->get();
        $result['data']=DB::table('skipmeals')
                        ->join('hostels','skipmeals.hostelid','hostels.id')
                        ->join('foodcategories','skipmeals.catid','foodcategories.id')
                        ->join('students','skipmeals.stu_id','students.id')
                        ->where('skipmeals.hostelid',$request->hostel)
                        ->select('skipmeals.*','foodcategories.foodcategory','students.sname','students.slname','hostels.hostel')
                        ->get();
        $result['id']=$aid;
        return view('nontechgroupmanager.foodskipreports',$result);
    }

    public function skiprepairsinfoexport(request $request,$id){
        $name='Food Skipped Report List';
        return Excel::download(new skiprepairsinfoExport($id), $name.'.xlsx'); 
    }

    public function hostelinfo(request $request){
        $sesid=session()->get('NONTECH_GROUPMANAGER_ID');
              $aid=session()->get('NONTECH_GROUPMANAGER_ADMIN_ID');
        $result['id']=$request->hostel;
        $bed=DB::table('hostelitems')
                        ->join('hostels','hostelitems.hostelid','hostels.id')
                        ->join('hostelrooms','hostelitems.roomid','hostelrooms.id')
                        ->join('infraitems','hostelitems.itemid','infraitems.id')
                        ->join('students','hostelitems.stu_id','students.id')
                        ->join('categories','students.sclassid','categories.id')
                        ->join('lmssections','students.ssectionid','lmssections.id')
                        ->where('hostelitems.mid',$request->hostel)
                        ->where('hostelitems.itemid',2)
                        ->select('hostelitems.*','hostels.hostel','hostelrooms.roomname','students.sname','students.slname','students.snumber','infraitems.infraitem','categories.categories','lmssections.section')
                        ->get();
        $result['bed']=count($bed);
        $room=DB::table('hostelrooms')
                        ->join('hostels','hostelrooms.hostelid','hostels.id')
                        ->where('mid',$request->hostel)
                        ->select('hostelrooms.*','hostels.hostel')
                        ->get();
        $result['room']=count($room);
        $repair=DB::table('hostelinfrarepairhistories')
                        ->join('hostels','hostelinfrarepairhistories.hostelid','hostels.id')
                        ->join('hostelrooms','hostelinfrarepairhistories.roomid','hostelrooms.id')
                        ->join('infraitems','hostelinfrarepairhistories.itemid','infraitems.id')
                        ->where('hostelinfrarepairhistories.mid',$request->hostel)
                        ->select('hostelinfrarepairhistories.*','hostels.hostel','hostelrooms.roomname','infraitems.infraitem')->get();    
        $result['repair']=count($repair);
        $hostelinfra=DB::table('hostelitems')
                        ->join('hostels','hostelitems.hostelid','hostels.id')
                        ->join('hostelrooms','hostelitems.roomid','hostelrooms.id')
                        ->join('infraitems','hostelitems.itemid','infraitems.id')
                        ->where('hostelitems.mid',$request->hostel)
                        ->select('hostelitems.*','hostels.hostel','hostelrooms.roomname','infraitems.infraitem')
                        ->get();
        $result['hostelinfra']=count($hostelinfra);
        $food=DB::table('hostelmenus')
            ->join('fooditems','hostelmenus.fitemid','fooditems.id')
            ->join('foodcategories','fooditems.foodcat','foodcategories.id')
            ->where('hostelmenus.aid',$aid)
            ->select('hostelmenus.*','fooditems.fooditems','foodcategories.foodcategory')
            ->get();
        $result['food']=count($food);
        $foodskip=DB::table('skipmeals')
                        ->join('hostels','skipmeals.hostelid','hostels.id')
                        ->join('foodcategories','skipmeals.catid','foodcategories.id')
                        ->join('students','skipmeals.stu_id','students.id')
                        ->where('hostels.aid',$aid)
                        ->select('skipmeals.*','foodcategories.foodcategory','students.sname','students.slname','hostels.hostel')
                        ->get();
        $result['foodfeed']=count($foodskip);
        $result['hostels']=DB::table('nontechmanagers')
                            ->join('departments','nontechmanagers.departmentid','departments.id')
                            ->where('departments.category',4)
                            ->where('supid',$sesid)
                            ->select('nontechmanagers.*')
                            ->get();
        return view('nontechgroupmanager.hostel',$result);
    }

    public function getdata(){
        $id = $_GET['day'];
        $cat= $_GET['cat'];
        $hostel=$_GET['hostel'];
        $res=DB::table('hostelmenus')
            ->join('fooditems','hostelmenus.fitemid','fooditems.id')
            ->join('foodcategories','fooditems.foodcat','foodcategories.id')
            ->where('dayid',$id)
            ->where('fooditems.foodcat',$cat)
            ->where('hostelid', $hostel)
            ->select('hostelmenus.*','fooditems.fooditems','foodcategories.foodcategory')
            ->get();
        return Response::json($res);
    }

    public function getrooms(){
        $id = $_GET['cid'];
        $res = DB::table('hostelrooms')->where('hostelid', $id)->get();
        return Response::json($res);
    }

}