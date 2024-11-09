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
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\beddataExport;


class hostelallocationcontroller extends Controller
{
    public function allocation(){
         $aid=session()->get('NONTECH_MANAGER_ADMIN_ID');   
         $result['hostels']=DB::table('hostels')->where('aid',$aid)->get();
         $result['data']=DB::table('hostelitems')
                         ->join('hostels','hostelitems.hostelid','hostels.id')
                         ->join('hostelrooms','hostelitems.roomid','hostelrooms.id')
                         ->join('infraitems','hostelitems.itemid','infraitems.id')
                         ->where('hostelitems.aid',$aid)
                         ->where('hostelitems.itemid',2)
                         ->select('hostelitems.*','hostels.hostel','hostelrooms.roomname','infraitems.infraitem')
                         ->get();
        $result['aid']=$aid;
        return view('nontechmanager.hostel.allocation',$result);
    }
     public function allocationbyfilter(Request $request){
         $aid=session()->get('NONTECH_MANAGER_ADMIN_ID');   
         $sesid=session()->get('NONTECH_MANAGER_ID');
         $result['hostels']=DB::table('hostels')->where('aid',$aid)->get();
         $result['data']=DB::table('hostelitems')
                         ->join('hostels','hostelitems.hostelid','hostels.id')
                         ->join('hostelrooms','hostelitems.roomid','hostelrooms.id')
                         ->join('infraitems','hostelitems.itemid','infraitems.id')
                         ->where('hostelitems.hostelid',$request->hostel)
                         ->where('hostelitems.roomid',$request->roomno)
                         ->where('hostelitems.aid',$aid)
                         ->where('hostelitems.itemid',2)
                         ->select('hostelitems.*','hostels.hostel','hostelrooms.roomname','infraitems.infraitem')->get();
        $result['aid']=$aid;
        return view('nontechmanager.hostel.allocation',$result);
    }

    public function bedassign($id){
         $aid=session()->get('NONTECH_MANAGER_ADMIN_ID');  
        $result['data']=DB::table('hostelitems')
                         ->join('hostels','hostelitems.hostelid','hostels.id')
                         ->join('hostelrooms','hostelitems.roomid','hostelrooms.id')
                         ->join('infraitems','hostelitems.itemid','infraitems.id')
                         ->where('hostelitems.itemid',2)
                         ->where('hostelitems.id',$id)
                         ->select('hostelitems.*','hostels.hostel','hostelrooms.roomname','infraitems.infraitem')->get();;
          $result['class']=DB::table('categories')->where('aid',$aid)->get();
        return view('nontechmanager.hostel.bedassign',$result);
    }

    public function save(Request $request){
        $model=hostelitems::find($request->id);
        $model->stu_id=$request->student;
        $model->save();

        $mod=student::find($request->student);
        $mod->bedallocated=$request->id;
        $mod->save();

        return redirect('nontech/manager/hostel/bedallocation');

    }

     public function resave(Request $request){
        $model=hostelitems::find($request->id);
         $m=student::find($model->stu_id);
        $m->bedallocated=0;
        $m->save();
        $model->stu_id=$request->student;
        $model->save();

        $mod=student::find($request->student);
        $mod->bedallocated=$request->id;
        $mod->save();

        return redirect('nontech/manager/hostel/bedallocation');

    }

    public function retire($id){
        $mod=hostelitems::find($id);
        $m=student::find($mod->stu_id);
        $m->bedallocated=0;
        $m->save();
        $mod->stu_id=0;
        $mod->save();
        return redirect('nontech/manager/hostel/bedallocation');
    }

     public function reassign($id){
         $aid=session()->get('NONTECH_MANAGER_ADMIN_ID');  
        $result['data']=DB::table('hostelitems')
                         ->join('hostels','hostelitems.hostelid','hostels.id')
                         ->join('hostelrooms','hostelitems.roomid','hostelrooms.id')
                         ->join('infraitems','hostelitems.itemid','infraitems.id')
                         ->where('hostelitems.itemid',2)
                         ->where('hostelitems.id',$id)
                         ->select('hostelitems.*','hostels.hostel','hostelrooms.roomname','infraitems.infraitem')->get();
        $st=DB::table('students')->where('id',$result['data'][0]->stu_id)->get();
        $result['student']=$st[0]->sname." - ".$st[0]->slname." / ".$st[0]->semail." / ".$st[0]->snumber;
          $result['class']=DB::table('categories')->where('aid',$aid)->get();
        return view('nontechmanager.hostel.bedreassign',$result);
    }

    public function beddataexport(request $request,$aid){
        $name='Bed List';
        return Excel::download(new beddataExport($aid), $name.'.xlsx'); 
    }

    
}
