<?php

namespace App\Http\Controllers\nontechmanager\infrastructure;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\hostelrooms;
use App\Models\hostelitems;
use App\Models\schoolitems;
use App\Imports\HostelitemsImport;
use App\Imports\othersitemsImport;
use App\Models\infraitems;
use App\Models\othersItems;
use Redirect,Response;
use Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\otherdataExport;

class infrastructureothercontroller extends Controller
{
    public function addotheritems(){
         $aid=session()->get('NONTECH_MANAGER_ADMIN_ID');
         $result['items']=DB::table('infraitems')->where('allocation',1)->get();
         $result['rooms']=DB::table('rooms')->get();
         return view('nontechmanager.infrastructure.addotheritems',$result);
    }
   

    public function upload(Request $request){   
        $validator=validator::make($request->all(),[
          'excel'=>'required|max:5000|mimes:xlsx,xls,csv'
        ]);
        if($validator->passes()){
           
            $roomid=$request->post('roomno');
            $itemid=$request->post('items');

            $mid=session()->get('NONTECH_MANAGER_ID');
            $aid=session()->get('NONTECH_MANAGER_ADMIN_ID');
            Excel::import(new othersitemsImport($roomid,$itemid,$aid,$mid),request()->file('excel')->store('temp'));
             
            $msg="Items Uploaded Successfully";
            $request->session()->flash('success',$msg);
            return redirect('nontech/manager/infrastructure/other/info'); 

        }else{
        return redirect()->back()->with(['errors'=>$validator->errors()->all()]);
        }
    }

    public function editotheritem($id){
         $mid=session()->get('NONTECH_MANAGER_ID');
         $aid=session()->get('NONTECH_MANAGER_ADMIN_ID');
        $result['data']=DB::table('others_items')->where('id',$id)->get();
          $result['items']=DB::table('infraitems')->where('allocation',1)->get();
        $result['rooms']=DB::table('rooms')->where('allocation',1)->get();
        return view('nontechmanager.infrastructure.editotheritem',$result);
    }

   public function savedetails(Request $request){
      
      $model=othersItems::find($request->id);
      $model->roomid=$request->room;
      $model->itemid=$request->items;
      $model->itemcode=$request->itemcode;
      $model->itemno=$request->itemno;
      $model->save();

      return redirect('nontech/manager/infrastructure/other/info');
   }

   public function info()
            {
                $id=session()->get('NONTECH_MANAGER_ID');
                 $aid=session()->get('NONTECH_MANAGER_ADMIN_ID');
                    $result['items']=DB::table('infraitems')->where('allocation',1)->get();
                  $result['rooms']=DB::table('rooms')->get();
                   $result['data']=DB::table('others_items')
                         ->join('rooms','others_items.roomid','rooms.id')
                         ->join('infraitems','others_items.itemid','infraitems.id')
                         ->where('others_items.aid',$aid)
                           ->where('others_items.mid',$id)
                         ->select('others_items.*','rooms.roomname','rooms.capacity','infraitems.infraitem')->get();
                $result['mid']=$id;
                    return view('nontechmanager.infrastructure.othersinfra',$result);
                
            }


    public function filter(Request $request){
        $id=session()->get('NONTECH_MANAGER_ID');
        $aid=session()->get('NONTECH_MANAGER_ADMIN_ID');
        $result['items']=DB::table('infraitems')->where('allocation',1)->get();
        $result['rooms']=DB::table('rooms')->get();

        $result['data']=DB::table('others_items')
                        ->join('rooms','others_items.roomid','rooms.id')
                        ->join('infraitems','others_items.itemid','infraitems.id')
                        ->where('others_items.aid',$aid)
                        ->where('others_items.mid',$id)
                        ->where('others_items.roomid',$request->room)
                        ->where('others_items.itemid',$request->item)
                        ->select('others_items.*','rooms.roomname','rooms.capacity','infraitems.infraitem')
                        ->get();
        $result['mid']=$id;
        return view('nontechmanager.infrastructure.othersinfra',$result);    
    }

    public function otherexport(request $request,$mid){
        $name='Other Infra List';
        return Excel::download(new otherdataExport($mid), $name.'.xlsx'); 
    }
}
