<?php

namespace App\Http\Controllers\supervisor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\studentassignation;
use App\Models\studentbooking;
use App\Models\assesmentsections;
use App\Models\finalanswer;
use Redirect,Response;

class supervisortotalfeesanalyticcontroller extends Controller
{
    
    public function index(){
        $gid=session()->get('SUPERVISOR_GROUP_ID');  
        $result['class']=DB::table('categories')->where('groupid',$gid)->get();
        $result['cl']=0;
        $result['section']=0;
        $result['completed']=0;
        $result['notcompleted']=0;
        $result['data']=[];
        
       return view('supervisor.pendingfeesanalytic',$result); 
    }


    public function fetch(request $request){
        $gid=session()->get('SUPERVISOR_GROUP_ID');  
        $result['class']=DB::table('categories')->where('groupid',$gid)->get();
        $result['cl']=$request->post('class');
        $result['section']=$request->post('section');
        $result['completed']=0;
        $result['notcompleted']=0;
        $result['data']=DB::table('students')->where('sclassid',$result['cl'])->where('ssectionid',$result['section'])->get();
       for($i=0;$i<count($result['data']);$i++){
        if($result['data'][$i]->spendingfees=="0"){
            $result['completed']++;
        }else{
            $result['notcompleted']++;
        }
     }
      return view('supervisor.pendingfeesanalytic',$result);   
    }


     public function currentindex(){
        $gid=session()->get('SUPERVISOR_GROUP_ID');  
        $result['class']=DB::table('categories')->where('groupid',$gid)->get();
        $result['cl']=0;
        $result['section']=0;
        $result['January']=0;
        $result['February']=0;
        $result['March']=0;
        $result['April']=0;
        $result['May']=0;
        $result['June']=0;
        $result['July']=0;
        $result['August']=0;
        $result['September']=0;
        $result['October']=0;
        $result['November']=0;
        $result['December']=0;
        $result['data']=[];
        $result['months']=[];
        
       return view('supervisor.currentfeesanalytic',$result); 
    }


    public function currentfetch(request $request){
        $gid=session()->get('SUPERVISOR_GROUP_ID');  
        $result['class']=DB::table('categories')->where('groupid',$gid)->get();
        $result['cl']=$request->post('class');
        $result['section']=$request->post('section');
        $january=[];
        $february=[];
        $march=[];
        $april=[];
        $may=[];
        $june=[];
        $july=[];
        $august=[];
        $september=[];
        $october=[];
        $november=[];
        $december=[];
        $count=[0,0,0,0,0,0,0,0,0,0,0,0];
        
        $data=DB::table('students')->where('sclassid',$result['cl'])->where('ssectionid',$result['section'])->get();
        $result['data']=$data;

        for($i=0;$i<count($data);$i++){
           $fees=DB::table('feeselections')->where('sid',$data[$i]->id)->get();
           for($k=0;$k<count($fees);$k++){
                if($fees[$k]->feepaymenttype=="shmonthly"){
                     
                    $january[$count[0]]=$fees[$k]->sid;
                    $count[0]++;
                    $february[$count[1]]=$fees[$k]->sid;
                    $count[1]++;
                    $march[$count[2]]=$fees[$k]->sid;
                    $count[2]++;

                    $april[$count[3]]=$fees[$k]->sid;
                    $count[3]++;
                    $may[$count[4]]=$fees[$k]->sid;
                    $count[4]++;
                    $june[$count[5]]=$fees[$k]->sid;
                    $count[5]++;

                    $july[$count[6]]=$fees[$k]->sid;
                    $count[6]++;
                    $august[$count[7]]=$fees[$k]->sid;
                    $count[7]++;
                    $september[$count[8]]=$fees[$k]->sid;
                    $count[8]++;

                    $october[$count[9]]=$fees[$k]->sid;
                    $count[9]++;
                    $november[$count[10]]=$fees[$k]->sid;
                    $count[10]++;
                    $december[$count[11]]=$fees[$k]->sid;
                    $count[11]++;

                }else if($fees[$k]->feepaymenttype=="shquater"){
                    $april[$count[3]]=$fees[$k]->sid;
                    $count[3]++;
                    $july[$count[6]]=$fees[$k]->sid;
                    $count[6]++;
                  
                    $october[$count[9]]=$fees[$k]->sid;
                    $count[9]++;
                    $january[$count[0]]=$fees[$k]->sid;
                    $count[0]++;
                }else if($fees[$k]->feepaymenttype=="shhalf"){
                    $april[$count[3]]=$fees[$k]->sid;
                    $count[3]++;
                    $october[$count[9]]=$fees[$k]->sid;
                    $count[9]++;
                }else{
                    $april[$count[3]]=$fees[$k]->sid;
                    $count[3]++;
                }
           }
        }
        $result['January']=count(array_unique($january));
        $result['February']=count(array_unique($february));
        $result['March']=count(array_unique($march));
        $result['April']=count(array_unique($april));
        $result['May']=count(array_unique($may));
        $result['June']=count(array_unique($june));
        $result['July']=count(array_unique($july));
        $result['August']=count(array_unique($august));
        $result['September']=count(array_unique($september));
        $result['October']=count(array_unique($october));
        $result['November']=count(array_unique($november));
        $result['December']=count(array_unique($december));
        
        $result['months']=array(array("month"=>"April","val"=>"feeaprpay"),array("month"=>"May","val"=>"feemaypay"),
                                array("month"=>"June","val"=>"feejunpay"),array("month"=>"July","val"=>"feejulpay"),
                            array("month"=>"August","val"=>"feeaugpay"),array("month"=>"September","val"=>"feeseppay"),
                        array("month"=>"October","val"=>"feeoctpay"),array("month"=>"November","val"=>"feenovpay"),
                    array("month"=>"December","val"=>"feedecpay"),array("month"=>"January","val"=>"feejanpay"),
                array("month"=>"February","val"=>"feefebpay"),array("month"=>"March","val"=>"feemarpay"));
      return view('supervisor.currentfeesanalytic',$result);   
    }

    public function getmonth(){
        $cls = $_GET['cl'];
        $section=$_GET['section'];
        $val=$_GET['val'];
        $da=$_GET['da'];
        $paid=0;
        $notpaid=$da;

        $data=DB::table('students')->where('sclassid',$cls)->where('ssectionid',$section)->get(); 
        for($i=0;$i<count($data);$i++){
            $check=DB::table('feepayments')->where('sid',$data[$i]->id)->get();
            if(count($check)>0){
                if($check[0]->$val=="PAID"){
                    $paid++;
                }
            }
        }
        $result[0]=$paid;
        $result[1]=(int)$da-(int)$paid;

        return Response::json($result);
    }

}