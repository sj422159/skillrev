<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use App\Models\hostel;
use App\Models\cafeteria;
use Redirect,Response;

class lmshostelcontroller extends Controller
{
    public function hostel(Request $request){
        $aid=session()->get('ADMIN_ID');
        $result['hostel']=DB::table('hostels')->where('aid',$aid)->get();
        return view('admin.hostel',$result);
    }

    public function addhostel(Request $request,$id=""){     
        if($id>0){
            $arr=hostel::where(['id'=>$id])->get();
            $result['id']=$arr['0']->id;
            $result['hostel']=$arr['0']->hostel;
        }
        else{
            $result['id']='';
            $result['hostel']='';
        }
        return view("admin.addhostel",$result);
    }
     
    public function savehostel(Request $request){

        if($request->post('id')>0){
            $model=hostel::find($request->post('id'));
            $msg="Hostel updated";
        }
        else{
            $model=new hostel();
            $msg="Hostel inserted";
        }

        $model->aid=session()->get('ADMIN_ID');
        $model->hostel=$request->post('hostel');
        $model->save();
        $request->session()->flash('success',$msg);
        return redirect('admin/hostel');
    } 

    public function deletehostel(Request $request,$id){
        $model=hostel::find($id);
        $model->delete();
        $request->session()->flash('success','Hostel Deleted Successfully');
        return redirect('admin/hostel');
    }


    public function cafeteria(Request $request){
        $aid=session()->get('ADMIN_ID');
        $result['cafeteria']=DB::table('cafeterias')
                              ->join('cafeteriatype','cafeterias.cattype','cafeteriatype.id')
                              ->where('aid',$aid)->select('cafeterias.*','cafeteriatype.ctype')->get();
        return view('admin.cafeteria',$result);
    }

    public function addcafeteria(Request $request,$id=""){  
    $aid=session()->get('ADMIN_ID');
   
        if($id>0){
            $arr=cafeteria::where(['id'=>$id])->get();
            $result['id']=$arr['0']->id;
            $result['cafeteria']=$arr['0']->cafeteria;
            $result['ctype']=$arr['0']->cattype;
            $result['hostelid']=$arr['0']->hostelid;
        }
        else{
            $result['id']='';
            $result['cafeteria']='';
            $result['ctype']='';
            $result['hostelid']=0;
        }
        $result['ctypes']=DB::table('cafeteriatype')->get();
        $result['hostel']=DB::table('hostels')->where('aid',$aid)->get();
        return view("admin.addcafeteria",$result);
    }
     
    public function savecafeteria(Request $request){
        
        if($request->post('id')>0){
            $model=cafeteria::find($request->post('id'));
            $msg="cafeteria updated";
        }
        else{
            $model=new cafeteria();
            $msg="cafeteria inserted";
        }

        $model->aid=session()->get('ADMIN_ID');
        $model->cafeteria=$request->post('cafeteria');
        if($request->post('hostel')){
         $model->hostelid=$request->post('hostel');  
        }
        $model->cattype=$request->post('cattype');
        $model->save();
        $request->session()->flash('success',$msg);
        return redirect('admin/cafeteria');
    } 

    public function deletecafeteria(Request $request,$id){
        $model=cafeteria::find($id);
        $model->delete();
        $request->session()->flash('success','cafeteria Deleted Successfully');
        return redirect('admin/cafeteria');
    }
}