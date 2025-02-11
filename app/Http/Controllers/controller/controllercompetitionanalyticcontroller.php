<?php

namespace App\Http\Controllers\controller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\controllers;
use Redirect,Response;

class controllercompetitionanalyticcontroller extends Controller
{
    
    public function index(){
        $aid=session()->get('Controller_ADMIN_ID');
         $Controller_ID=session()->get('Controller_ID');
         $controller = controllers::find($Controller_ID); 

        $result['layout'] = match ($controller->Controller_role_ID) {
            1 => 'controller/academ/layout',
            2 => 'controller/exam/elayout',
            3 => 'controller/account/Alayout',
            default => 'layouts/default',
        };  
        $result['supervisors']=DB::table('supervisors')->where('aid',$aid)->get();
        $result['sup']=0;
        $result['competition']=0;
        $result['applied']=0;
        $result['notshortlisted']=0;
        $result['selected']=0;
        $result['completed']=0;
        $result['data']=[];   
       return view('controller.competitionanalytic',$result); 
    }

    public function fetch(request $request){
        $aid=session()->get('Controller_ADMIN_ID');
         $Controller_ID=session()->get('Controller_ID');
         $controller = controllers::find($Controller_ID); 

        $result['layout'] = match ($controller->Controller_role_ID) {
            1 => 'controller/academ/layout',
            2 => 'controller/exam/elayout',
            3 => 'controller/account/Alayout',
            default => 'layouts/default',
        };  
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
      return view('controller.competitionanalytic',$result);   
    }

    public function getcompetition(){
        $id = $_GET['id'];
        $res = DB::table('competitions')->where('supid',$id)->get();
        return Response::json($res);
    }

}