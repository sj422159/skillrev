<?php

namespace App\Http\Controllers\student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\student;
use App\Models\feeselection;
use App\Models\feepayment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Redirect,Response;

class studentfeescontroller extends Controller
{

    public function pendingfeesreports(Request $request){

        $studentid=session()->get('STUDENT_ID');
        $classid=session()->get('STUDENT_CLASS_ID');

        $result['data']=DB::table('feependings')->where('sid',$studentid)->get();

        return view('student.feepending',$result);
    }

    public function selection(Request $request){
        $studentid=session()->get('STUDENT_ID');
        $aid=session()->get('STUDENT_ADMIN_ID');
        $classid=session()->get('STUDENT_CLASS_ID');
        $sectionid=session()->get('STUDENT_SECTION_ID');
            
        DB::table('feeselections')->where('sid',$studentid)->where('status',0)->delete();
        DB::table('feepayments')->where('sid',$studentid)->where('status',0)->delete();

        $studentdata=DB::table('students')->where('id',$studentid)->get(['sdistance','spendingfees','shostelservice']);
          
            if (count($studentdata)==1) {
                if ($studentdata[0]->spendingfees=="0") {
                $result['hostelservice']=$studentdata[0]->shostelservice;
                $result['commonfeeschedules']=DB::table('feeschedules')
                    ->join('feecategories','feecategories.id','feeschedules.shcategory')
                    ->where('feecategories.fctype',1)
                    ->where('feecategories.fcstatus',1)
                    ->where('feeschedules.shtype',$classid)
                    ->where('feecategories.aid',$aid) 
                    ->select('feecategories.fcategory','feecategories.fcmandatoryornot','feeschedules.*')
                    ->get();

                $result['transportfeeschedules']=DB::table('feeschedules')
                    ->join('feecategories','feecategories.id','feeschedules.shcategory')
                    ->where('feecategories.fctype',2)
                    ->where('feecategories.fcstatus',1)
                    ->where('feeschedules.shtype',$studentdata[0]->sdistance)
                    ->where('feecategories.aid',$aid)
                    ->select('feecategories.fcategory','feecategories.fcmandatoryornot','feeschedules.*')
                    ->get();

                $result['types']=array(
                                array("id"=>"shannual","type"=>"Annually"),
                                array("id"=>"shhalf","type"=>"Half-yearly"),
                                array("id"=>"shquater","type"=>"Quarterly"),  
                                array("id"=>"shmonthly","type"=>"Monthly")
                            ); 

              $result['selecty']="";
              for($i=0;$i<count($result['commonfeeschedules']);$i++){
                 
                $a=DB::table('feeselections')->where('sid',$studentid)->where('feescheduleid',$result['commonfeeschedules'][$i]->id)->get();
                if(count($a)>0){
                    $result['commonfeeschedules'][$i]->seltype=$a[0]->feepaymenttype;
                    $result['commonfeeschedules'][$i]->seldiscount=$a[0]->feediscount;
                    if($a[0]->feepaymenttype=="shannual"){
                       $result['commonfeeschedules'][$i]->selfees=$a[0]->feeannual;
                    }else if($a[0]->feepaymenttype=="shhalf"){
                       $result['commonfeeschedules'][$i]->selfees=$a[0]->feehalf;
                    }else if($a[0]->feepaymenttype=="shquater"){
                       $result['commonfeeschedules'][$i]->selfees=$a[0]->feequater;
                    }else if($a[0]->feepaymenttype=="shmonthly"){
                    $result['commonfeeschedules'][$i]->selfees=$a[0]->feemonthly;
                    }
                    $result['selecty']="1";

                 }else{
                    $result['commonfeeschedules'][$i]->seltype="";
                    $result['commonfeeschedules'][$i]->seldiscount="";
                    $result['commonfeeschedules'][$i]->selfees=0;
                 }
              }

              for($i=0;$i<count($result['transportfeeschedules']);$i++){
                 
                $a=DB::table('feeselections')->where('sid',$studentid)->where('feescheduleid',$result['transportfeeschedules'][$i]->id)->get();
                if(count($a)>0){
                    $result['transportfeeschedules'][$i]->seltype=$a[0]->feepaymenttype;
                    $result['transportfeeschedules'][$i]->seldiscount=$a[0]->feediscount;
                    if($a[0]->feepaymenttype=="shannual"){
                       $result['transportfeeschedules'][$i]->selfees=$a[0]->feeannual;
                    }else if($a[0]->feepaymenttype=="shhalf"){
                       $result['transportfeeschedules'][$i]->selfees=$a[0]->feehalf;
                    }else if($a[0]->feepaymenttype=="shquater"){
                       $result['transportfeeschedules'][$i]->selfees=$a[0]->feequater;
                    }else if($a[0]->feepaymenttype=="shmonthly"){
                    $result['transportfeeschedules'][$i]->selfees=$a[0]->feemonthly;
                    }
                    $result['selecty']="1";

                 }else{
                    $result['transportfeeschedules'][$i]->seltype="";
                    $result['transportfeeschedules'][$i]->seldiscount="";
                    $result['transportfeeschedules'][$i]->selfees=0;
                 }
              }
                 
                }else{
                    return redirect('student/dashboard');
               }
            } else {
                session()->flash('danger','Please Fill The Profile');
                return redirect('student/dashboard');
                
            }

        return view('student.feeselection',$result);
    }


    public function getmoney(){
        $cat = $_GET['cat'];
        $val = $_GET['val'];
        $row = $_GET['row'];
        $studentid=session()->get('STUDENT_ID');
        $a=DB::table('feediscounts')->where('stu_id',$studentid)->where('discat',$cat)->where('distype',$val)->get();
        $b=DB::table('feeschedules')->where('id',$row)->get();
        $data=[];
        if(count($a)>0){
           $data[0]=$a[0]->dis;
           $data[1]=$a[0]->disprice;
        }else{
           $data[0]=0;
           $data[1]=$b[0]->$val;
        } 
        return Response::json($data);
    }

    public function saveselection(Request $request){
        $feetotal=0; 
        for($i=0;$i<count($request->post('feescheduleid'));$i++){
        if($request->post('type')[$i]!=null){
        $model=new feeselection();
        $model->aid=session('STUDENT_ADMIN_ID');
        $model->sid=session('STUDENT_ID');
        $model->feescheduleid=$request->post('feescheduleid')[$i];
        $model->feepaymenttype=$request->post('type')[$i];
        $model->feediscount=$request->post('discount')[$i];
        if($request->post('type')[$i]=="shannual"){
           $model->feeannual=$request->post('val')[$i];
           $feetotal=$feetotal+$request->post('val')[$i]*1;
        }else if($request->post('type')[$i]=="shhalf"){
           $model->feehalf=$request->post('val')[$i];
           $feetotal=$feetotal+$request->post('val')[$i]*2;
        }else if($request->post('type')[$i]=="shquater"){
           $model->feequater=$request->post('val')[$i];
           $feetotal=$feetotal+$request->post('val')[$i]*4;
        }else if($request->post('type')[$i]=="shmonthly"){
           $model->feemonthly=$request->post('val')[$i];
           $feetotal=$feetotal+$request->post('val')[$i]*12;
        }
        $model->status=0;
        $model->save();
        }
       }

        $m=new feepayment();
        $m->aid=session('STUDENT_ADMIN_ID');
        $m->sid=session('STUDENT_ID');
        $m->feetotalremaining=$feetotal;
        $m->feetotal=$feetotal;
        $m->status=0;
        $m->save();

        session()->flash('success','View Fee Payment Structure Based on Your Selection');
        return redirect('student/fees/payment/view');
    }


    public function paymentview(Request $request){
            $studentid=session()->get('STUDENT_ID');
            $classid=session()->get('STUDENT_CLASS_ID');
            $sectionid=session()->get('STUDENT_SECTION_ID');

            $studentdata=DB::table('feeselections')->where('sid',$studentid)->where('status',0)->get();

            if(count($studentdata)>0) {
                $result['data']=DB::table('feeselections')
                    ->join('feeschedules','feeschedules.id','feeselections.feescheduleid')
                    ->join('feecategories','feecategories.id','feeschedules.shcategory')
                    ->where('feeselections.sid',$studentid)
                    ->where('feeselections.status',0)
                    ->select('feecategories.fcategory','feeselections.*')
                    ->get();
            } else {
                session()->flash('danger','Please Select The Fees Selection');
                return redirect('student/fees/selection');     
            }

        return view('student.feepaymentview',$result);
    }


    public function saveselectionpermanant(Request $request){
        $studentid=session()->get('STUDENT_ID');
        DB::table('feeselections')->where('sid',$studentid)->where('status',0)->update(['status'=>1]);
        DB::table('feepayments')->where('sid',$studentid)->where('status',0)
        ->update(
        ['feeaprmoney'=>$request->post('feeaprmoney'),
         'feemaymoney'=>$request->post('feemaymoney'),
         'feejunmoney'=>$request->post('feejunmoney'),
         'feejulmoney'=>$request->post('feejulmoney'),
         'feeaugmoney'=>$request->post('feeaugmoney'),
         'feesepmoney'=>$request->post('feesepmoney'),
         'feeoctmoney'=>$request->post('feeoctmoney'),
         'feenovmoney'=>$request->post('feenovmoney'),
         'feedecmoney'=>$request->post('feedecmoney'),
         'feejanmoney'=>$request->post('feejanmoney'),
         'feefebmoney'=>$request->post('feefebmoney'),
         'feemarmoney'=>$request->post('feemarmoney'),
         'status'=>1
        ]);

        session()->flash('success','Fees Selection Saved Successfully');
        return redirect('student/fees/selection');
    }

    public function payment(Request $request){
            $studentid=session()->get('STUDENT_ID');
            $aid=session()->get('STUDENT_ADMIN_ID');
            $classid=session()->get('STUDENT_CLASS_ID');
            $sectionid=session()->get('STUDENT_SECTION_ID');

            $studentdata=DB::table('feeselections')->where('sid',$studentid)->where('status',1)->get();

            if (count($studentdata)>0) {
                $result['data']=DB::table('feeselections')
                    ->join('feeschedules','feeschedules.id','feeselections.feescheduleid')
                    ->join('feecategories','feecategories.id','feeschedules.shcategory')
                    ->where('feeselections.sid',$studentid)
                    ->where('feeselections.status',1)
                    ->select('feecategories.fcategory','feeselections.*')
                    ->get();
                $result['paymentlink']=DB::table('admins')->where('id',$aid)->get('apaymentlink');
            } else {
                session()->flash('danger','Please Select The Fees Selection');
                return redirect('student/fees/selection');     
            }

        return view('student.feepayment',$result);
    }

}