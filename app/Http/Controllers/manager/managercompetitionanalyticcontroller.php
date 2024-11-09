<?php

namespace App\Http\Controllers\manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Redirect,Response;

class managercompetitionanalyticcontroller extends Controller
{
    
    public function index(){
        $mid=session()->get('MANAGER_ID');  
        $result['competitions']=DB::table('competitions')->where('mid',$mid)->get();
        $result['competition']=0;
        $result['applied']=0;
        $result['notshortlisted']=0;
        $result['selected']=0;
        $result['completed']=0;
        $result['data']=[];   
       return view('manager.competitionanalytic',$result); 
    }

    public function fetch(request $request){
        $mid=session()->get('MANAGER_ID');  
        $result['competitions']=DB::table('competitions')->where('mid',$mid)->get();
        $result['competition']=$request->post('competition');
        $result['applied']=0;
        $result['notshortlisted']=0;
        $result['selected']=0;
        $result['completed']=0;
        $result['data']=DB::table('competitionbookings')->where('competitionid',$result['competition'])->get();
        for($i=0;$i<count($result['data']);$i++){
            if($result['data'][$i]->competitionstatus=="1"){
                $result['applied']++;
            }elseif($result['data'][$i]->competitionstatus=="2"){
                $result['notshortlisted']++;
            }
            elseif($result['data'][$i]->competitionstatus=="3"){
                $result['selected']++;
            }
            elseif($result['data'][$i]->competitionstatus=="4"){
                $result['completed']++;
            }
        }
      return view('manager.competitionanalytic',$result);   
    }

}