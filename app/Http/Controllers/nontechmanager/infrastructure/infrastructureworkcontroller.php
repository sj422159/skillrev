<?php

namespace App\Http\Controllers\nontechmanager\infrastructure;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\hostelrooms;
use App\Models\hostelitems;
use App\Models\schoolitems;
use App\Imports\HostelitemsImport;
use App\Models\infraitems;
use App\Models\cafeteriaItems;
use App\Models\hostelinfrarepairhistory;
use App\Models\cafeteriainfrarepairhistory;
use App\Models\othersItems;
use App\Models\othersinfrarepairhistory;
use Redirect,Response;
use Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\hosteldataExport;

class infrastructureworkcontroller extends Controller
{ 
    public function work($id){
        $sesid=session()->get('NONTECH_MANAGER_ID');
        $aid=session()->get('NONTECH_MANAGER_ADMIN_ID');
        $data=DB::table('infragroups')->where('id',$id)->get();
        if($data[0]->category==1){
            $result['items']=DB::table('infraitems')->where('allocation',1)->get();
            $result['class']=DB::table('categories')->where('aid',$aid)->get();
            $result['data']=DB::table('schoolitems')
                            ->join('categories','schoolitems.classid','categories.id')
                            ->join('lmssections','schoolitems.sectionid','lmssections.id')
                            ->join('infraitems','schoolitems.itemid','infraitems.id')
                            ->where('schoolitems.aid',$aid)
                            ->select('schoolitems.*','categories.categories','lmssections.section','infraitems.infraitem')
                            ->get();
            $result['mid']=$sesid;
            return view('nontechmanager.infrastructure.school',$result);  
        }else if($data[0]->category==2){
            $result['items']=DB::table('infraitems')->where('allocation',1)->get();
            $result['hostels']=DB::table('hostels')->where('aid',$aid)->get();
            $result['data']=DB::table('hostelitems')
                            ->join('hostels','hostelitems.hostelid','hostels.id')
                            ->join('hostelrooms','hostelitems.roomid','hostelrooms.id')
                            ->join('infraitems','hostelitems.itemid','infraitems.id')
                            ->where('hostelitems.mid',$sesid)
                            ->select('hostelitems.*','hostels.hostel','hostelrooms.roomname','infraitems.infraitem')
                            ->get();
            $result['mid']=$sesid;
            return view('nontechmanager.infrastructure.hostel',$result);
       }else if($data[0]->category==3){
            $result['ctypes']=DB::table('cafeteriatype')->get();
            $result['items']=DB::table('infraitems')->where('allocation',1)->get();
            $result['data']=DB::table('cafeteria_items')
                            ->join('cafeteriatype','cafeteria_items.cafetype','cafeteriatype.id')
                            ->join('cafeterias','cafeteria_items.cafeid','cafeterias.id')
                            ->join('infraitems','cafeteria_items.itemid','infraitems.id')
                            ->where('cafeteria_items.aid',$aid)
                            ->where('cafeteria_items.mid',$sesid)
                            ->select('cafeteria_items.*','cafeteriatype.ctype','cafeterias.cafeteria','infraitems.infraitem')   
                            ->get();
            $result['mid']=$sesid;
            return view('nontechmanager.infrastructure.cafeteria',$result);
       }else{
            $result['rooms']=DB::table('rooms')->where('allocation',1)->get();
            $result['items']=DB::table('infraitems')->where('allocation',1)->get();
            $result['data']=DB::table('others_items')
                            ->join('rooms','others_items.roomid','rooms.id')
                            ->join('infraitems','others_items.itemid','infraitems.id')
                            ->where('others_items.aid',$aid)
                            ->where('others_items.mid',$sesid)
                            ->select('others_items.*','rooms.roomname','rooms.capacity','infraitems.infraitem')
                            ->get();
            $result['mid']=$sesid;
            return view("nontechmanager.infrastructure.othersinfra",$result);
       }
    }

    public function getrooms(){
        $id = $_GET['cid'];
        $res = DB::table('hostelrooms')->where('hostelid', $id)->get();
        return Response::json($res);
    }

     public function getroominfo(){
       $id = $_GET['room'];
         $res = DB::table('hostelrooms')
        ->where('id', $id)
        ->get();
        $result[0]=$res[0]->Bedcapacity;
          for($i=0;$i<count($res);$i++){
                  $a=DB::table('hostelitems')->where('roomid',$res[$i]->id)->where('itemid',2)->get();
                  $result[1]=count($a);
                  $b=DB::table('hostelitems')->where('roomid',$res[$i]->id)->where('itemid',2)->where('stu_id','!=',0)->get();
                  $result[2]=count($b);

            }
       
        return Response::json($result);
    }

    public function addhostelitems(Request $request){
         $aid=session()->get('NONTECH_MANAGER_ADMIN_ID');
         $result['items']=DB::table('infraitems')->where('allocation',1)->get();
        $result['hostels']=DB::table('hostels')->where('aid',$aid)->get();
        return view('nontechmanager.infrastructure.addhostelitems',$result);

    }
    public function hostelinfo(Request $request){
        $id=session()->get('NONTECH_MANAGER_ID');
        $aid=session()->get('NONTECH_MANAGER_ADMIN_ID');
        $result['items']=DB::table('infraitems')->where('allocation',1)->get();
        $result['hostels']=DB::table('hostels')->where('aid',$aid)->get();
        $result['data']=DB::table('hostelitems')
                         ->join('hostels','hostelitems.hostelid','hostels.id')
                         ->join('hostelrooms','hostelitems.roomid','hostelrooms.id')
                         ->join('infraitems','hostelitems.itemid','infraitems.id')
                         ->where('hostelitems.mid',$id)
                         ->select('hostelitems.*','hostels.hostel','hostelrooms.roomname','infraitems.infraitem')->get();
        $result['mid']=$id;
        return view('nontechmanager.infrastructure.hostel',$result);

    }

    public function filter(Request $request){
          $id=session()->get('NONTECH_MANAGER_ID');
         $aid=session()->get('NONTECH_MANAGER_ADMIN_ID');
         $result['items']=DB::table('infraitems')->where('allocation',1)->get();
        $result['hostels']=DB::table('hostels')->where('aid',$aid)->get();
        $result['data']=DB::table('hostelitems')
                         ->join('hostels','hostelitems.hostelid','hostels.id')
                         ->join('hostelrooms','hostelitems.roomid','hostelrooms.id')
                         ->join('infraitems','hostelitems.itemid','infraitems.id')
                         ->where('hostelitems.mid',$id)
                         ->where('hostelitems.hostelid',$request->hostel)
                         ->where('hostelitems.roomid',$request->roomno)
                         ->where('hostelitems.itemid',$request->item)
                         ->select('hostelitems.*','hostels.hostel','hostelrooms.roomname','infraitems.infraitem')
                         ->get();
        $result['mid']=$id;

        return view('nontechmanager.infrastructure.hostel',$result);
    }

    public function hostelexport(request $request,$mid){
        $name='Hostel Infra List';
        return Excel::download(new hosteldataExport($mid), $name.'.xlsx'); 
    }

     public function upload(Request $request){   
        $validator=validator::make($request->all(),[
          'excel'=>'required|max:5000|mimes:xlsx,xls,csv'
        ]);
        if($validator->passes()){
            $hostelid=$request->post('hostel');
            $roomid=$request->post('roomno');
            $itemid=$request->post('items');
            $mid=session()->get('NONTECH_MANAGER_ID');
            $aid=session()->get('NONTECH_MANAGER_ADMIN_ID');
            Excel::import(new HostelitemsImport($hostelid,$roomid,$itemid,$aid,$mid),request()->file('excel')->store('temp'));
             
            $msg="Items Uploaded Successfully";
            $request->session()->flash('success',$msg);
            return redirect('nontech/manager/infrastructure/hostel/info'); 

        }else{
        return redirect()->back()->with(['errors'=>$validator->errors()->all()]);
        }
    }

    public function edithostelitem($id){
         $mid=session()->get('NONTECH_MANAGER_ID');
         $aid=session()->get('NONTECH_MANAGER_ADMIN_ID');
        $result['data']=DB::table('hostelitems')->where('id',$id)->get();
          $result['items']=DB::table('infraitems')->where('allocation',1)->get();
        $result['hostels']=DB::table('hostels')->where('aid',$aid)->get();
        return view('nontechmanager.infrastructure.edithostelitem',$result);
    }

   public function savedetails(Request $request){
      
      $model=hostelitems::find($request->id);
      $model->hostelid=$request->hostel;
      $model->roomid=$request->roomno;
      $model->itemid=$request->items;
      $model->itemcode=$request->itemcode;
      $model->itemno=$request->itemno;
      $model->save();

      return redirect('nontech/manager/infrastructure/hostel/info');
   }

   public function repairs($id){
      $data=DB::table('infragroups')->where('id',$id)->get();
       $mid=session()->get('NONTECH_MANAGER_ID');
     $aid=session()->get('NONTECH_MANAGER_ADMIN_ID');
       if($data[0]->category==1){
        $result['data1']=DB::table('schoolitems')
                         ->join('categories','schoolitems.classid','categories.id')
                         ->join('lmssections','schoolitems.sectionid','lmssections.id')
                         ->join('infraitems','schoolitems.itemid','infraitems.id')
                         ->join('faculties','schoolitems.facid','faculties.id')
                         ->where('repair','!=',0)
                         ->select('schoolitems.*','categories.categories','lmssections.section','infraitems.infraitem','faculties.fname')->get();
            return view('nontechmanager.infrastructure.schoolrepairs',$result);

       }else if($data[0]->category==2){
         $result['data']=DB::table('hostelitems')
                         ->join('hostels','hostelitems.hostelid','hostels.id')
                         ->join('hostelrooms','hostelitems.roomid','hostelrooms.id')
                         ->join('infraitems','hostelitems.itemid','infraitems.id')
                         ->where('repair','!=',0)
                         ->select('hostelitems.*','hostels.hostel','hostelrooms.roomname','infraitems.infraitem')->get();

               return view('nontechmanager.infrastructure.hostelrepairs',$result);


       }else if($data[0]->category==3){
           $result['data2']=DB::table('cafeteria_items')
                         ->join('cafeteriatype','cafeteria_items.cafetype','cafeteriatype.id')
                         ->join('cafeterias','cafeteria_items.cafeid','cafeterias.id')
                         ->join('infraitems','cafeteria_items.itemid','infraitems.id')
                         ->where('repair','!=',0)
                         ->select('cafeteria_items.*','cafeteriatype.ctype','cafeterias.cafeteria','infraitems.infraitem')->get();
                         return view('nontechmanager.infrastructure.cafeteriarepairs',$result);


       }else{
        $result['data']=DB::table('others_items')
                         ->join('rooms','others_items.roomid','rooms.id')
                         ->join('infraitems','others_items.itemid','infraitems.id')
                         ->where('repair','!=',0)
                         ->select('others_items.*','rooms.roomname','infraitems.infraitem')->get();
                         return view('nontechmanager.infrastructure.otherinfrarepairs',$result);

       }
     
   


    
    return view('nontechmanager.infrastructure.repairs',$result);
   }
   
   public function repairstart($id){
    $model=hostelitems::find($id);
    $model->repair=2;
     
     $m=hostelinfrarepairhistory::find($model->history);
     $m->workstarted=date('d-m-Y');
     $m->save();

    $model->save();
    return Redirect::back()->with('msg', 'Started Successfully');
   }
    public function repairend($id){
    $model=hostelitems::find($id);
    $model->repair=0;
    $model->save();
    return redirect('nontech/manager/infrastructure/repairs');
   }

    public function schoolrepairstart($id){
    $model=schoolitems::find($id);
    $model->repair=2;
     $m=hostelinfrarepairhistory::find($model->history);
     $m->workstarted=date('d-m-Y');
     $m->save();
    $model->save();
    return Redirect::back()->with('msg', 'Started Successfully');
   }
    public function cafeteriarepairstart($id){
    $model=cafeteriaItems::find($id);
    $model->repair=2;
     $m=cafeteriainfrarepairhistory::find($model->history);
     $m->workstarted=date('d-m-Y');
     $m->save();
    $model->save();
    return Redirect::back()->with('msg', 'Started Successfully');
   }

   public function otherrepairstart($id){
    $model=othersItems::find($id);
    $model->repair=2;
    $m=othersinfrarepairhistory::find($model->history);
    $m->workstarted=date('d-m-Y');
    $m->save();
    $model->save();
    return Redirect::back()->with('msg', 'Started Successfully');
   }
  
    public function schoolrepairend($id){
    $model=schoolitems::find($id);
    $model->repair=0;
    $model->save();
    return redirect('nontech/manager/infrastructure/repairs');
   }

   public function additional(){
       $mid=session()->get('NONTECH_MANAGER_ID');
     $aid=session()->get('NONTECH_MANAGER_ADMIN_ID');
    $result['data']=DB::table('hostelrooms')
                         ->join('hostels','hostelrooms.hostelid','hostels.id')
                         ->where('status','!=',0)
                         ->select('hostelrooms.*','hostels.hostel')->get();
    return view('nontechmanager.infrastructure.additionals',$result);
   }

   public function changeapproval($id,$status){
    $model=hostelrooms::find($id);
    if($status==2){
     $model->Bedcapacity=$model->initialcapacity;
    }else{
      $model->initialcapacity=$model->Bedcapacity;
    }
    $model->status=$status;
    $model->save();
    return redirect('nontech/manager/infrastructure/additional');
   }

   public function reports($id){
    $aid=session()->get('NONTECH_MANAGER_ADMIN_ID');
    $sesid=session()->get('NONTECH_MANAGER_ID');
    if($id==1){

        $result['data']=DB::table('hostelinfrarepairhistories')
                         ->join('categories','hostelinfrarepairhistories.classid','categories.id')
                         ->join('lmssections','hostelinfrarepairhistories.sectionid','lmssections.id')
                         ->join('infraitems','hostelinfrarepairhistories.itemid','infraitems.id')
                         ->where('hostelinfrarepairhistories.mid',$sesid)
                         ->where('type',2)
                         ->select('hostelinfrarepairhistories.*','categories.categories','lmssections.section','infraitems.infraitem')->get();;
           return view('nontechmanager.infrastructure.schoolrepairhistory',$result);


    }else if($id==2){
         $result['data']=DB::table('hostelinfrarepairhistories')
                         ->join('hostels','hostelinfrarepairhistories.hostelid','hostels.id')
                         ->join('hostelrooms','hostelinfrarepairhistories.roomid','hostelrooms.id')
                         ->join('infraitems','hostelinfrarepairhistories.itemid','infraitems.id')
                         ->where('hostelinfrarepairhistories.mid',$sesid)
                         ->where('type',1)
                         ->select('hostelinfrarepairhistories.*','hostels.hostel','hostelrooms.roomname','infraitems.infraitem')->get();;
           return view('nontechmanager.infrastructure.hostelrepairhistory',$result);

    }else if($id==3){

         $result['data']=DB::table('cafeteriainfrarepairhistories')
                          ->join('cafeteriatype','cafeteriainfrarepairhistories.cafetype','cafeteriatype.id')
                          ->join('cafeterias','cafeteriainfrarepairhistories.cafeid','cafeterias.id')
                        ->join('infraitems','cafeteriainfrarepairhistories.itemid','infraitems.id')
                         ->where('cafeteriainfrarepairhistories.mid',$sesid)
                         ->select('cafeteriatype.ctype','cafeterias.cafeteria','infraitems.infraitem','cafeteriainfrarepairhistories.*')->get();
            return view('nontechmanager.infrastructure.cafeteriarepairhistory',$result);

    }else{
          $result['data']=DB::table('othersinfrarepairhistories')
                          ->join('rooms','othersinfrarepairhistories.roomid','rooms.id')
                        ->join('infraitems','othersinfrarepairhistories.itemid','infraitems.id')
                         ->where('othersinfrarepairhistories.mid',$sesid)
                         ->select('rooms.roomname','infraitems.infraitem','othersinfrarepairhistories.*')->get();
            return view('nontechmanager.infrastructure.otherrepairhistory',$result);
    }

   }
}
