<?php

namespace App\Http\Controllers\supervisor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\distance;
use App\Models\feecategory;
use App\Models\feeschedule;
use App\Models\student;
use App\Models\feediscount;
use App\Models\feeselection;
use App\Models\feepayment;
use App\Models\feepending;
use App\Imports\distanceImport;
use App\Exports\studentfeesExport;
use App\Exports\studentpendingfeesExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Validator;
use Redirect,Response;

class supervisorfeescontroller extends Controller{

    public function pendingfeesstudents(){
        $gid=session()->get('SUPERVISOR_GROUP_ID');  
        $result['classes']=DB::table('categories')->where('groupid',$gid)->get();
        $result['students']=[];
        $result['class']='';
        $result['section']=[];
        return view('supervisor.pendingfeesstudents',$result);
    }

    public function pendingfeesstudentsbysection(request $request){
        $gid=session()->get('SUPERVISOR_GROUP_ID');  
        $result['classes']=DB::table('categories')->where('groupid',$gid)->get();
        $class=$request->post('class');
        $section=$request->post('section');
        $result['class']=$class;
        $result['section']=$section;
        $result['students'] =DB::table('students')->where('sclassid',$class)->where('ssectionid',$section)->get();
        for($i=0;$i<count($result['students']);$i++){
            $a=DB::table('feependings')->where('sid',$result['students'][$i]->id)->get();
            if(count($a)>0){
                $fee=0;
                for($j=0;$j<count($a);$j++){
                    $fee=$fee+$a[$j]->feepaid;
                }
                $result['students'][$i]->pendingfeepaid=$fee;
            }else{
             $result['students'][$i]->pendingfeepaid=0;
            }
        }
        return view('supervisor.pendingfeesstudents',$result);
    } 

    public function pendingfeesexport(request $request,$class,$section){
        $name='Student Pending Fees List';
        return Excel::download(new studentpendingfeesExport($class,$section), $name.'.xlsx'); 
    }

    public function indexfeesstudents(){
        $gid=session()->get('SUPERVISOR_GROUP_ID');  
        $result['classes']=DB::table('categories')->where('groupid',$gid)->get();
        $result['students']=[];
        $result['class']=[];
        $result['section']=[];
        $result['paymentcount']=[];
        return view('supervisor.paidindex',$result);
    }

    public function indexfeesstudentsbysection(request $request){
        $gid=session()->get('SUPERVISOR_GROUP_ID');  
        $result['classes']=DB::table('categories')->where('groupid',$gid)->get();
        $class=$request->post('class');
        $section=$request->post('section');
        $result['students'] =DB::table('students')->where('sclassid',$class)->where('ssectionid',$section)->get();
        $result['paymentcount']=0;
        for($i=0;$i<count($result['students']);$i++){
            $a=DB::table('feeselections')->where('sid',$result['students'][$i]->id)->where('status',1)->get();
            if(count($a)>0){
              $result['students'][$i]->visible=1;
              $result['paymentcount']=$result['paymentcount']+1;
            }else{
             $result['students'][$i]->visible=0;
            }
        }
        $result['class']=$class;
        $result['section']=$section;
        return view('supervisor.paidindex',$result);
    }

    public function feesexport(request $request,$id){
        $name='Student Fees List';
        return Excel::download(new studentfeesExport($id), $name.'.xlsx'); 
    }


    public function feesstructure(Request $request,$id){
        $studentdata=DB::table('feeselections')->where('sid',$id)->get();
        $result['data']=DB::table('feeselections')
                    ->join('feeschedules','feeschedules.id','feeselections.feescheduleid')
                    ->join('feecategories','feecategories.id','feeschedules.shcategory')
                    ->where('feeselections.sid',$id)
                    ->where('feeselections.status',1)
                    ->select('feecategories.fcategory','feeselections.*')
                    ->get();
        $result['sid']=$id;
        return view('supervisor.paidintsallment',$result);
    }
}