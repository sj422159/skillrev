<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Imports\holidayImport;
use Validator;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use App\Models\holiday;
use Redirect,Response;

class lmsholidaycontroller extends Controller
{
    public function holiday(Request $request) {
        $aid=session()->get('ADMIN_ID');
        $result['data']=DB::table('holidays')->where('aid',$aid)->get(); 
        return view('admin.holiday',$result);
    }

    public function upload(Request $request){   
        $validator=validator::make($request->all(),[
          'excel'=>'required|max:5000|mimes:xlsx,xls,csv'
        ]);
        if($validator->passes()){
            $aid=session()->get('ADMIN_ID');
            Excel::import(new holidayImport($aid),request()->file('excel')->store('temp'));
             
            $msg="Holidays Uploaded Successfully";
            $request->session()->flash('success',$msg);
            return redirect('admin/holiday'); 

        }else{
        return redirect()->back()->with(['errors'=>$validator->errors()->all()]);
        }
    }

    public function editholiday(Request $request,$id){
        $arr=holiday::where(['id'=>$id])->get();
        $result['id']=$arr['0']->id;
        $result['holidayname']=$arr['0']->holidayname;
        $result['date']=date("Y-m-d", strtotime($arr['0']->date));
        $result['image']=$arr['0']->image;
        return view('admin.editholiday',$result);
     }

    public function updateholiday(Request $request){
      $model=holiday::find($request->post('id'));
      $model->holidayname=$request->post('holidayname');
      $date = $request->post('date');
      $newdate = date("d-m-Y", strtotime($date));
      $model->date=$newdate;
       if($request->hasfile('image')){  
            $image=$request->file('image');
            $ext=$image->extension();
            $image_name=rand(10,10000).'.'.$ext;
            $image->move(public_path().'/holidayimages',$image_name);
            $model->image=$image_name;
        }
      $model->save();
      $msg="Holiday Updated Successfully";
      $request->session()->flash('success',$msg);
      return redirect('admin/holiday');
    }

    public function deleteholiday(Request $request,$id){
        $model=holiday::find($id);
        $model->delete();
        $request->session()->flash('success','Holiday Deleted Successfully');
        return redirect('admin/holiday');
    }
}