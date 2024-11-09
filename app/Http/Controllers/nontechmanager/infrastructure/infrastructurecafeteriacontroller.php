<?php

namespace App\Http\Controllers\nontechmanager\infrastructure;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\hostelrooms;
use App\Models\hostelitems;
use App\Models\schoolitems;
use App\Imports\HostelitemsImport;
use App\Imports\cafeteriaitemsImport;
use App\Models\infraitems;
use App\Models\cafeteriaItems;
use Redirect,Response;
use Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\cafeteriadataExport;

class infrastructurecafeteriacontroller extends Controller
{

    public function addcafeteriaitems(){
         $aid=session()->get('NONTECH_MANAGER_ADMIN_ID');
         $result['items']=DB::table('infraitems')->where('allocation',1)->get();
           $result['ctypes']=DB::table('cafeteriatype')->get();
           return view('nontechmanager.infrastructure.addcafeteriaitems',$result);
    }
     public function getnames(){
       $id = $_GET['cid'];
         $res = DB::table('cafeterias')
        ->where('cattype', $id)
        ->get();
        return Response::json($res);
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
            Excel::import(new cafeteriaitemsImport($hostelid,$roomid,$itemid,$aid,$mid),request()->file('excel')->store('temp'));
             
            $msg="Items Uploaded Successfully";
            $request->session()->flash('success',$msg);
            return redirect('nontech/manager/infrastructure/cafeteria/info'); 

        }else{
        return redirect()->back()->with(['errors'=>$validator->errors()->all()]);
        }
    }

    public function editcafeteriaitem($id){
         $mid=session()->get('NONTECH_MANAGER_ID');
         $aid=session()->get('NONTECH_MANAGER_ADMIN_ID');
        $result['data']=DB::table('cafeteria_items')->where('id',$id)->get();
          $result['items']=DB::table('infraitems')->where('allocation',1)->get();
        $result['ctypes']=DB::table('cafeteriatype')->get();
        return view('nontechmanager.infrastructure.editcafeteriaitem',$result);
    }

   public function savedetails(Request $request){
      
      $model=cafeteriaItems::find($request->id);
      $model->cafetype=$request->class;
      $model->cafeid=$request->section;
      $model->itemid=$request->items;
      $model->itemcode=$request->itemcode;
      $model->itemno=$request->itemno;
      $model->save();

      return redirect('nontech/manager/infrastructure/cafeteria/info');
   }

   public function info()
            {
                $id=session()->get('NONTECH_MANAGER_ID');
                 $aid=session()->get('NONTECH_MANAGER_ADMIN_ID');
                    $result['items']=DB::table('infraitems')->where('allocation',1)->get();
                  $result['ctypes']=DB::table('cafeteriatype')->get();
                   $result['data']=DB::table('cafeteria_items')
                         ->join('cafeteriatype','cafeteria_items.cafetype','cafeteriatype.id')
                         ->join('cafeterias','cafeteria_items.cafeid','cafeterias.id')
                         ->join('infraitems','cafeteria_items.itemid','infraitems.id')
                         ->where('cafeteria_items.aid',$aid)
                           ->where('cafeteria_items.mid',$id)
                         ->select('cafeteria_items.*','cafeteriatype.ctype','cafeterias.cafeteria','infraitems.infraitem')->get();
                $result['mid']=$id;
                    return view('nontechmanager.infrastructure.cafeteria',$result);
                
            }


     public function filter(Request $request){
       // return $request->hostel;
          $id=session()->get('NONTECH_MANAGER_ID');
         $aid=session()->get('NONTECH_MANAGER_ADMIN_ID');
         $result['items']=DB::table('infraitems')->where('allocation',1)->get();
          $result['ctypes']=DB::table('cafeteriatype')->get();
         $result['data']=DB::table('cafeteria_items')
                         ->join('cafeteriatype','cafeteria_items.cafetype','cafeteriatype.id')
                         ->join('cafeterias','cafeteria_items.cafeid','cafeterias.id')
                         ->join('infraitems','cafeteria_items.itemid','infraitems.id')
                         ->where('cafeteria_items.mid',$id)
                         ->where('cafeteria_items.cafetype',$request->hostel)
                         ->where('cafeteria_items.cafeid',$request->roomno)
                         ->where('cafeteria_items.itemid',$request->item)
                         ->select('cafeteria_items.*','cafeteriatype.ctype','cafeterias.cafeteria','infraitems.infraitem')->get();
        $result['mid']=$id;
                
        return view('nontechmanager.infrastructure.cafeteria',$result);
    }

    public function cafeteriaexport(request $request,$mid){
        $name='Cafeteria Infra List';
        return Excel::download(new cafeteriadataExport($mid), $name.'.xlsx'); 
    }

}
