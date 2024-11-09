<?php

namespace App\Http\Controllers\classteacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\distribution;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Validator;
use Redirect,Response;

class classteacherdistributioncontroller extends Controller{

    public function distributionstudents(request $request){
        $aid=session()->get('CLASSTEACHER_ADMIN_ID');     
        $result['feecategories']= DB::table('feecategories')->where('aid',$aid)->where('fcmandatoryornot',2)->where('fcstatus',1)->get();
        $result['feecategory']="";
        $result['students'] =[];
        return view('classteacher.distributionstudents',$result);
    }

    public function distributionstudentsbysection(request $request){
        $aid=session()->get('CLASSTEACHER_ADMIN_ID');
        $classid=session()->get('CLASSTEACHER_CLASS_ID'); 
        $sectionid=session()->get('CLASSTEACHER_SECTION_ID');
        $feecategory= $request->post('feecategory'); 
        
        $result['students'] = DB::table('students')->where('sclassid',$classid)->where('ssectionid',$sectionid)->get();

        for($i=0;$i<count($result['students']);$i++){
            $a = DB::table('feeselections')
                ->join('feeschedules','feeschedules.id','feeselections.feescheduleid')
                ->join('feecategories','feecategories.id','feeschedules.shcategory')
                ->join('students','feeselections.sid','students.id')
                ->where('feecategories.id',$feecategory)
                ->where('feeselections.sid',$result['students'][$i]->id)
                ->get();
            if(count($a)>0){
              $result['students'][$i]->visible=1;
            }else{
              $result['students'][$i]->visible=0;
            }


            $b = DB::table('distributions')->where('feecategoryid',$feecategory)->where('sid',$result['students'][$i]->id)->get();
            if(count($b)>0){
              $result['students'][$i]->type=$b[0]->type;
              $result['students'][$i]->remark=$b[0]->remark;
              $result['students'][$i]->distributionid=$b[0]->id;
              $result['status']=1;   // 1 means update
            }else{
              $result['students'][$i]->type="";
              $result['students'][$i]->remark="";
              $result['students'][$i]->distributionid="";
              $result['status']=0;   // 0 means create
            }
        }
         //return $result['students'];
        $result['feecategories']= DB::table('feecategories')->where('aid',$aid)->where('fcmandatoryornot',2)->where('fcstatus',1)->get();
        $result['feecategory']= $feecategory;
        return view('classteacher.distributionstudents',$result);
    }
    
    public function distributionsave(request $request){
        //return $request->post();
        $aid=session()->get('CLASSTEACHER_ADMIN_ID');
        $classid=session()->get('CLASSTEACHER_CLASS_ID'); 
        $sectionid=session()->get('CLASSTEACHER_SECTION_ID');
        $feecategory= $request->post('feecategory');
        

        $sid=$request->post('studentid');
        $type=$request->post('type');
        $remark=$request->post('remark');
        $distributionid=$request->post('distributionid');
        $status=$request->post('status');

        if($status==0) {
            for($i=0;$i<count($sid);$i++){
              $model=new distribution();
              $model->aid=$aid;
              $model->classid=$classid;
              $model->sectionid=$sectionid;
              $model->feecategoryid=$feecategory;
              $model->sid=$sid[$i];
              $model->type=$type[$i];
              $model->remark=$remark[$i];
              $model->save();
            }
        }else{
            for($i=0;$i<count($sid);$i++){
              $model=distribution::find($distributionid[$i]);
              $model->type=$type[$i];
              $model->remark=$remark[$i];
              $model->save();
            }
        }

        $request->session()->flash("success","Distribution Saved Successfully");
        return redirect('classteacher/distribution/add');
    }

}