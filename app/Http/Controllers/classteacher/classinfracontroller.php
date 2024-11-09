<?php

namespace App\Http\Controllers\classteacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\nontechmanager;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\hostelrooms;
use App\Models\hostelitems;
use App\Imports\HostelitemsImport;
use App\Models\infraitems;
use App\Models\schoolitems;
use App\Models\hostelinfrarepairhistory;

class classinfracontroller extends Controller
{
    public function infrainfo(){
        $classid = session()->get('CLASSTEACHER_CLASS_ID');
          $sec =  session()->get('CLASSTEACHER_SECTION_ID');
          $cid= session()->get('CLASSTEACHER_ID');

          $result['data']=DB::table('schoolitems')
                         ->join('categories','schoolitems.classid','categories.id')
                         ->join('lmssections','schoolitems.sectionid','lmssections.id')
                         ->join('infraitems','schoolitems.itemid','infraitems.id')
                             ->where('facid',$cid)
                             ->select('schoolitems.*','categories.categories','lmssections.section','infraitems.infraitem')->get();
        return view('classteacher.infrainfo',$result);
    }

    public function repair($id){
        $model=schoolitems::find($id);
        $model->repair=1;

         $m=new hostelinfrarepairhistory();
                $m->aid=$model->aid;
                $m->mid=$model->mid;
                $m->type=2;
                $m->classid=$model->classid;
                $m->sectionid=$model->sectionid;
                $m->itemid=$model->itemid;
                $m->itemno=$model->itemno;
                $m->repairissued=date('d-m-Y');
                $m->save();

                $model->history=$m->id;
                $model->save();

        $model->save();

        return redirect('classteacher/infrastructure/info');
    }
     public function repairend($id){
        $model=schoolitems::find($id);
        $model->repair=0;
           $m=hostelinfrarepairhistory::find($model->history);
                $m->repairfinished=date('d-m-y');
                $m->save();
                $model->history=0;
        $model->save();
         return redirect('classteacher/infrastructure/info');
    
         }
}
