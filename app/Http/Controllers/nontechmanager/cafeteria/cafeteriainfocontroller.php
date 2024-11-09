<?php

namespace App\Http\Controllers\nontechmanager\cafeteria;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\hostelrooms;
use App\Models\hostelitems;
use App\Models\schoolitems;
use App\Models\cafeteriaItems;
use App\Imports\HostelitemsImport;
use App\Imports\cafeteriaitemsImport;
use App\Models\infraitems;
use Redirect,Response;
use Validator;
use App\Models\cafeteriainfrarepairhistory;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\schoolhostelothersExport;


class cafeteriainfocontroller extends Controller
{
    public function school(){
        $aid=session()->get('NONTECH_MANAGER_ADMIN_ID');   
        $result['data']=DB::table('cafeteria_items')
                        ->join('cafeteriatype','cafeteria_items.cafetype','cafeteriatype.id')
                        ->join('cafeterias','cafeteria_items.cafeid','cafeterias.id')
                        ->join('infraitems','cafeteria_items.itemid','infraitems.id')
                        ->where('cafeteria_items.aid',$aid)
                        ->where('cafetype',1)
                        ->select('cafeteria_items.*','cafeteriatype.ctype','cafeterias.cafeteria','infraitems.infraitem')
                        ->get();
        $result['aid']=$aid;
        return view('nontechmanager.cafeteria.schoolitems',$result);
    }

    public function hostel(){
        $aid=session()->get('NONTECH_MANAGER_ADMIN_ID');   
        $result['data']=DB::table('cafeteria_items')
                        ->join('cafeteriatype','cafeteria_items.cafetype','cafeteriatype.id')
                        ->join('cafeterias','cafeteria_items.cafeid','cafeterias.id')
                        ->join('infraitems','cafeteria_items.itemid','infraitems.id')
                        ->where('cafeteria_items.aid',$aid)
                        ->where('cafetype',2)
                        ->select('cafeteria_items.*','cafeteriatype.ctype','cafeterias.cafeteria','infraitems.infraitem')
                        ->get();
        $result['aid']=$aid;
        return view('nontechmanager.cafeteria.hostelitems',$result);
    }

    public function others(){
        $aid=session()->get('NONTECH_MANAGER_ADMIN_ID');   
        $result['data']=DB::table('cafeteria_items')
                        ->join('cafeteriatype','cafeteria_items.cafetype','cafeteriatype.id')
                        ->join('cafeterias','cafeteria_items.cafeid','cafeterias.id')
                        ->join('infraitems','cafeteria_items.itemid','infraitems.id')
                        ->where('cafeteria_items.aid',$aid)
                        ->where('cafetype',3)
                        ->select('cafeteria_items.*','cafeteriatype.ctype','cafeterias.cafeteria','infraitems.infraitem')
                        ->get();
        $result['aid']=$aid;
        return view('nontechmanager.cafeteria.othersitems',$result);
    }

    public function schoolhostelothersexport(request $request,$type,$aid){
        if ($type==1) {
            $name='School Cafeteria List';
        } else if($type==2){
            $name='Hostel Cafeteria List';
        }
        else{
            $name='Other Cafeteria List';
        }
        return Excel::download(new schoolhostelothersExport($type,$aid), $name.'.xlsx'); 
    }

    public function repair($id){
                $model=cafeteriaItems::find($id);
                $model->repair=1;
                
                $m=new cafeteriainfrarepairhistory();
                $m->aid=$model->aid;
                $m->mid=$model->mid;
                $m->cafetype=$model->cafetype;
                $m->cafeid=$model->cafeid;
                $m->itemid=$model->itemid;
                $m->itemno=$model->itemno;
                $m->repairissued=date('d-m-Y');
                $m->save();
                $model->history=$m->id;
                $model->save();
                if($model->cafetype==1){
                   return redirect('nontech/manager/Cafeteria/school/info');
                }else if($model->cafetype==2){
                   return redirect('nontech/manager/Cafeteria/hostel/info');
                }else{
                   return redirect('nontech/manager/Cafeteria/others/info');
                }
                
            }

    public function completed($id){
    $model=cafeteriaItems::find($id);
    $model->repair=0;
     $m=cafeteriainfrarepairhistory::find($model->history);
                $m->repairfinished=date('d-m-y');
                $m->save();
                $model->history=0;
    $model->save();
    if($model->cafetype==1){
        return redirect('nontech/manager/Cafeteria/school/info');
    }else if($model->cafetype==2){
        return redirect('nontech/manager/Cafeteria/hostel/info');
    }else{
         return redirect('nontech/manager/Cafeteria/others/info');
     }
    
   }
}
