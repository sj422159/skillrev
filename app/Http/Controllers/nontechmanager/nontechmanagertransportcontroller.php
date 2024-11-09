<?php

namespace App\Http\Controllers\nontechmanager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\nontechsupervisor;
use App\Models\busroute;
use App\Models\distance;
use App\Exports\studenttransportlocationExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Validator;
use Redirect,Response;

class nontechmanagertransportcontroller extends Controller
{
    public function index(){
        $sesid=session()->get('NONTECH_MANAGER_ID');
        $aid=session()->get('NONTECH_MANAGER_ADMIN_ID');
        $result['busroutes']=DB::table('busroutes')->where('aid',$aid)->where('status',1)->get();
        $result['busroute']="";
        $result['location']="";
        $result['loc']=[];
        $result['students']=[];
        return view('nontechmanager.transport.busroutes',$result);
    }

    public function students(request $request){
        $sesid=session()->get('NONTECH_MANAGER_ID');
        $aid=session()->get('NONTECH_MANAGER_ADMIN_ID');
        $result['busroutes']=DB::table('busroutes')->where('aid',$aid)->where('status',1)->get();
        $result['busroute']=$request->post('busroute');
        $result['location']=$request->post('location');
        $result['loc']=DB::table('distances')->where('id',$request->post('location'))->get();
        $result['students']=DB::table('students')
                        ->join('distances','students.sdistance','distances.id')
                        ->join('busroutes','distances.busrouteid','busroutes.id')
                        ->where('distances.id',$request->post('location'))
                        ->where('students.aid',$aid)
                        ->select('students.*','distances.location','busroutes.busroute')
                        ->get();
        return view('nontechmanager.transport.busroutes',$result);
    }

    public function studentsexport(request $request,$location){
        $name='Student List';
        return Excel::download(new studenttransportlocationExport($location), $name.'.xlsx'); 
    }

    public function savetime(Request $request){
        $model=distance::find($request->post('locationid'));
        $model->pickuptime=$request->post('pickuptime');
        $model->droptime=$request->post('droptime');
        $model->save();
        session()->flash('success','Saved Successfully');
        return redirect('nontech/manager/transportstudents');     
    }

    public function getlocations(){
        $id = $_GET['id'];
        $res = DB::table('distances')->where('busrouteid',$id)->where('disstatus',1)->get();
        return Response::json($res);
    }

}