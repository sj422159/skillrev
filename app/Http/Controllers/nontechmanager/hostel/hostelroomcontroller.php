<?php

namespace App\Http\Controllers\nontechmanager\hostel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\hostelrooms;
use App\Models\cafeteriaItems;
use App\Models\infragroup;
use App\Models\hostelitems;
use App\Models\hostelinfrarepairhistory;
use Redirect,Response;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\roomdataExport;
use App\Exports\hostelinfrastructuredataExport;

class hostelroomcontroller extends Controller
{
     public function rooms(Request $request){
        $sesid=session()->get('NONTECH_MANAGER_ID');
        $result['room']=DB::table('hostelrooms')
                        ->join('hostels','hostelrooms.hostelid','hostels.id')
                        ->where('mid',$sesid)
                        ->select('hostelrooms.*','hostels.hostel')
                        ->get();
            for($i=0;$i<count($result['room']);$i++){
                  $a=DB::table('hostelitems')->where('roomid',$result['room'][$i]->id)->where('itemid',2)->get();
                  $result['room'][$i]->allocated=count($a);
                  $b=DB::table('hostelitems')->where('roomid',$result['room'][$i]->id)->where('itemid',2)->where('stu_id','!=',0)->get();
                  $result['room'][$i]->assigned=count($b);

            }
        $result['mid']=$sesid;
        return view('nontechmanager.hostel.rooms',$result);
    }

    public function menu(){
       $aid=session()->get('NONTECH_MANAGER_ADMIN_ID');
       $result['hostels']=DB::table('hostels')->where('aid',$aid)->get();
       $result['hostelid']=0;
       $result['check']=[];
       return view('nontechmanager.hostel.menu',$result);  
    }

    public function menubyfilter(request $request){
        $aid=session()->get('NONTECH_MANAGER_ADMIN_ID');
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
        return view('nontechmanager.hostel.menu',$result);  
    }

    public function getdata(){
        $id = $_GET['day'];
        $cat= $_GET['cat'];
        $hostel=$_GET['hostel'];
        $res = DB::table('hostelmenus')
            ->join('fooditems','hostelmenus.fitemid','fooditems.id')
            ->join('foodcategories','fooditems.foodcat','foodcategories.id')
            ->where('dayid',$id)
            ->where('fooditems.foodcat',$cat)
            ->where('hostelid', $hostel)
            ->select('hostelmenus.*','fooditems.fooditems','foodcategories.foodcategory')
            ->get();
        return Response::json($res);

    }

     public function addrooms(Request $request,$id=""){  
      $aid=session()->get('NONTECH_MANAGER_ADMIN_ID');   
        if($id>0){
            $arr=hostelrooms::where(['id'=>$id])->get();
            $result['id']=$arr['0']->id;
            $result['hid']=$arr['0']->hostelid;
            $result['room']=$arr['0']->roomname;
            $result['bedcapacity']=$arr['0']->Bedcapacity;
        }
        else{
            $result['id']='';
            $result['hid']='';
            $result['room']='';
            $result['bedcapacity']='';   
        }
        $result['hostels']=DB::table('hostels')->where('aid',$aid)->get();
        return view("nontechmanager.hostel.addrooms",$result);
    }



     public function saverooms(Request $request){
        $sesid=session()->get('NONTECH_MANAGER_ID');
        $aid=session()->get('NONTECH_MANAGER_ADMIN_ID');


        if($request->post('id')>0){
           
                $model=hostelrooms::find($request->post('id'));
                $model->aid=$aid;
                $model->mid=$sesid;
                $model->hostelid=$request->post('hid');
                $model->roomname=$request->post('room');
                if($model->initialcapacity!=$request->post('bedcapacity')){
                    $model->capacitychange=1;
                    $model->status=1;
                }
                $model->Bedcapacity=$request->post('bedcapacity');
                $model->save();
                $request->session()->flash('success','Room Updated');
            }else{
                $model=new hostelrooms();
                $model->aid=$aid;
                $model->mid=$sesid;
                $model->hostelid=$request->post('hid');
                $model->roomname=$request->post('room');
                $model->Bedcapacity=$request->post('bedcapacity');
                $model->initialcapacity=$request->post('bedcapacity');
                $model->save();
                $request->session()->flash('success','Room Added');
            }
                return redirect('nontech/manager/hostel/rooms');
            }



             public function info()
            {
                 $aid=session()->get('NONTECH_MANAGER_ADMIN_ID');
                 $result['items']=DB::table('infraitems')->get();
                 $result['hostels']=DB::table('hostels')->where('aid',$aid)->get();
                   $result['data']=DB::table('hostelitems')
                         ->join('hostels','hostelitems.hostelid','hostels.id')
                         ->join('hostelrooms','hostelitems.roomid','hostelrooms.id')
                         ->join('infraitems','hostelitems.itemid','infraitems.id')
                         ->where('hostelitems.aid',$aid)
                         ->select('hostelitems.*','hostels.hostel','hostelrooms.roomname','infraitems.infraitem')->get();
                    $result['aid']=$aid;
                    return view('nontechmanager.hostel.infrainfo',$result);
            }


            public function infobyfilter(Request $request){
                 $aid=session()->get('NONTECH_MANAGER_ADMIN_ID');
                 $result['items']=DB::table('infraitems')->get();
                 $result['hostels']=DB::table('hostels')->where('aid',$aid)->get();
                  $result['data']=DB::table('hostelitems')
                         ->join('hostels','hostelitems.hostelid','hostels.id')
                         ->join('hostelrooms','hostelitems.roomid','hostelrooms.id')
                         ->join('infraitems','hostelitems.itemid','infraitems.id')
                         ->where('hostelitems.aid',$aid)
                         ->where('hostelitems.hostelid',$request->hostel)
                         ->where('hostelitems.roomid',$request->roomno)
                         ->where('hostelitems.itemid',$request->item)
                         ->select('hostelitems.*','hostels.hostel','hostelrooms.roomname','infraitems.infraitem')->get();
                    $result['aid']=$aid;
                  return view('nontechmanager.hostel.infrainfo',$result);
            }

            public function repair($id){
                $model=hostelitems::find($id);
                $model->repair=1;

                $m=new hostelinfrarepairhistory();
                $m->aid=$model->aid;
                $m->mid=$model->mid;
                $m->hostelid=$model->hostelid;
                $m->roomid=$model->roomid;
                $m->itemid=$model->itemid;
                $m->itemno=$model->itemno;
                $m->repairissued=date('d-m-Y');
                $m->save();

                $model->history=$m->id;
                $model->save();

                return redirect('nontech/manager/hostel/Infrastructure/info');
            }
            public function repairend($id){
                $model=hostelitems::find($id);
                $model->repair=0;
                $m=hostelinfrarepairhistory::find($model->history);
                $m->repairfinished=date('d-m-y');
                $m->save();
                $model->history=0;
                $model->save();
                 return redirect('nontech/manager/hostel/Infrastructure/info');
    
              }
            public function acceptchange($id){
                $model=hostelrooms::find($id);
                $model->status=0;
                $model->save();

                return redirect('nontech/manager/hostel/rooms');
            }

    public function roomdataexport(request $request,$mid){
        $name='Room List';
        return Excel::download(new roomdataExport($mid), $name.'.xlsx'); 
    }

    public function hostelinfrastructuredataexport(request $request,$aid){
        $name='Hostel Infrastructure List';
        return Excel::download(new hostelinfrastructuredataExport($aid), $name.'.xlsx'); 
    }
}
