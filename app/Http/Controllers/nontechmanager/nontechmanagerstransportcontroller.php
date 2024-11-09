<?php

namespace App\Http\Controllers\nontechmanager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\nontechsupervisor;
use App\Models\busroute;
use App\Exports\studenttransportExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Validator;
use Redirect,Response;

class nontechmanagerstransportcontroller extends Controller
{
    public function index(){
        $sesid=session()->get('NONTECH_MANAGER_ID');
        $aid=session()->get('NONTECH_MANAGER_ADMIN_ID');
        $result['busroutes']=DB::table('busroutes')->where('aid',$aid)->where('status',1)->get();
        $result['busroute']="";
        $result['bus']=[];
        $result['students']=[];
        return view('nontechmanager.transport.busroute',$result);
    }

    public function students(request $request){
        $sesid=session()->get('NONTECH_MANAGER_ID');
        $aid=session()->get('NONTECH_MANAGER_ADMIN_ID');
        $result['busroutes']=DB::table('busroutes')->where('aid',$aid)->where('status',1)->get();
        $result['busroute']=$request->post('busroute');
        $result['bus']=DB::table('busroutes')->where('id',$request->post('busroute'))->get();
        $result['students']=DB::table('students')
                        ->join('distances','students.sdistance','distances.id')
                        ->join('busroutes','distances.busrouteid','busroutes.id')
                        ->where('busroutes.id',$request->post('busroute'))
                        ->where('students.aid',$aid)
                        ->select('students.*','distances.location','busroutes.busroute')
                        ->get();
        return view('nontechmanager.transport.busroute',$result);
    }

    public function studentsexport(request $request,$busroute){
        $name='Student List';
        return Excel::download(new studenttransportExport($busroute), $name.'.xlsx'); 
    }

    public function savetime(Request $request){
        $model=busroute::find($request->post('busrouteid'));
        $model->busroutepickupdeparture=$request->post('pdeparture');
        $model->busroutepickuparrival=$request->post('parrival');
        $model->busroutedropdeparture=$request->post('ddeparture');
        $model->busroutedroparrival=$request->post('darrival');
        $model->save();
        session()->flash('success','Saved Successfully');
        return redirect('nontech/managers/transportstudents');     
    }

}
