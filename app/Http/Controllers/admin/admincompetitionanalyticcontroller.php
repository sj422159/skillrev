<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Redirect,Response;

class admincompetitionanalyticcontroller extends Controller
{
    
    public function index(){
        $aid=session()->get('ADMIN_ID');  
        $result['supervisors']=DB::table('supervisors')->where('aid',$aid)->get();
        $result['sup']=0;
        $result['competition']=0;
        $result['applied']=0;
        $result['notshortlisted']=0;
        $result['selected']=0;
        $result['completed']=0;
        $result['data']=[];   
       return view('admin.competitionanalytic',$result); 
    }

    public function fetch(request $request){
        $aid=session()->get('ADMIN_ID');  
        $result['supervisors']=DB::table('supervisors')->where('aid',$aid)->get();
        $result['sup']=$request->post('supervisor');
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
      return view('admin.competitionanalytic',$result);   
    }

    public function getcompetition(){
        $id = $_GET['id'];
        $res = DB::table('competitions')->where('supid',$id)->get();
        return Response::json($res);
    }

}