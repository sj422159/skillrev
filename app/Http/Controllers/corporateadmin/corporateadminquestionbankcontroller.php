<?php

namespace App\Http\Controllers\corporateadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\admin;
use App\Models\homepageEvents;
use Illuminate\Support\Facades\DB;
use Redirect;
use Mail;
use App\Models\contentskillattribute;

class corporateadminquestionbankcontroller extends Controller
{
     public function index(){
    $result['schools']=DB::table('admins')->where('status',1)->get();
    $result['school']=0;
    $result['category']=[];
    return view('corporateadmin.question',$result);
    }
    public function fetch(request $request){
       $result['schools']=DB::table('admins')->where('status',1)->get();
       $result['school']=$request->post('school');
       $result['category']=DB::table('categories')->where('aid',$request->post('school'))->get();
     return view('corporateadmin.question',$result);
    }

    public function getQuestion(request $request){
      $mod = $request->post('mod');
      return $result['data']=DB::table('questionbanks')
                        ->join('skillattributes','skillattributes.id','questionbanks.skillattribute')
                        ->where('questionbanks.skillattribute',$mod)
                        ->select('skillattributes.skillattribute','questionbanks.*')
                        ->get();
        
        return Response::json($result['data']);

    }

    public function questions($id){
         $result['data']=DB::table('questionbanks')->where('id',$id)->get();
        return view('corporateadmin.viewquestion',$result);
    }

}
