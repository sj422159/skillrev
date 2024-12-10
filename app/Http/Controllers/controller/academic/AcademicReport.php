<?php

namespace App\Http\Controllers\Controller\Academic;

use App\Http\Controllers\Controller; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\category;
use App\Models\skillset;
use Redirect,Response;

class AcademicReport extends Controller
{
    public function reports(){
        $aid=session()->get('Controller_ADMIN_ID'); 
     
        $d=DB::table('admins')->where("id",$aid)->get();
        $result['train']=DB::table('trainings')->where('aid',$aid)->where('status',1)->get();
        $result['category']=DB::table('categories')->where('aid',$aid)->get();
        $result['cl']=0;
        $result['tri']=0;
        $result['section']=0;
        $result['data']=DB::table('studentbookings')
        ->join('students','studentbookings.sid','students.id')
        ->join('trainings','studentbookings.trainingid','trainings.id')
        ->join('lmssections','students.ssectionid','lmssections.id')
        ->where('students.aid',$aid)
        ->select('studentbookings.*','students.sname','students.slname','trainings.trainingname','lmssections.section','students.image')
        ->get();;
        return view('controller.academ.reports',$result);
    }
    public function fetchstu(request $request){
        $aid=session()->get('Controller_ADMIN_ID'); 
         $d=DB::table('admins')->where("id",$aid)->get();
        
         $result['train']=DB::table('trainings')->where('aid',$aid)->where('status',1)->get();
         $result['tri']=$request->post('training');
         $result['section']=$request->post('section');
         $result['class']=DB::table('categories')->where('aid',$aid)->get();
         $result['cl']=$request->post('class');
         $result['data']=DB::table('studentbookings')
                            ->join('students','studentbookings.sid','students.id')
                            ->join('trainings','studentbookings.trainingid','trainings.id')
                            ->join('lmssections','students.ssectionid','lmssections.id')
                            ->where('students.ssectionid',$request->post('section'))
                            ->where('studentbookings.trainingid',$request->post('training'))
                            ->select('studentbookings.*','students.sname','students.slname','trainings.trainingname','lmssections.section','students.image')
                            ->get();
         return view('controller.academ.reports',$result);
     }
    
}
