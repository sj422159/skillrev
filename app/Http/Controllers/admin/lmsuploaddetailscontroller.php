<?php
namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\student;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use App\Exports\adminstudentlistExport;
use Redirect;
use Mail;

class lmsuploaddetailscontroller extends Controller
{
    public function studentdetails(){
        $aid=session()->get('ADMIN_ID');
        $result['classes']=DB::table('categories')->where('aid',$aid)->get();
        $result['class']='';
        $result['section']='';
        $result['details']=[];
        return view('admin.studentlist',$result);
    }

    public function studentdetailsbysection(request $request){
        $aid=session()->get('ADMIN_ID');
        $result['classes']=DB::table('categories')->where('aid',$aid)->get();
        $result['class']=$request->post('class');
        $result['section']=$request->post('section');
        $result['details']= DB::table('students')->where('aid',$aid)->where('sclassid',$result['class'])
                            ->where('ssectionid',$result['section'])
                            ->select('students.*')
                            ->get();
        return view('admin.studentlist',$result);
    }

    public function studentdetailsview(request $request,$id){
        $aid=session()->get('ADMIN_ID');
        $result['profile']=DB::table('students')->where('id',$id)->get();
        $result['class']=DB::table('categories')
                        ->where('id',$result['profile'][0]->sclassid)
                        ->get();
        $result['section']=DB::table('lmssections')
                        ->where('id',$result['profile'][0]->ssectionid)
                        ->get();
        $result['state']=DB::table('states')
                        ->where('id',$result['profile'][0]->sstate)
                        ->get();
        $result['city']=DB::table('cities')
                        ->where('id',$result['profile'][0]->scity)
                        ->get();
        return view('admin.studentdetails',$result);
    }

    public function status(Request $request,$status,$id){
        $model=student::find($id);
        $model->status=$status;
        $model->save();
        return redirect('admin/studentdetails');
    }

    public function delete(Request $request, $id){
        $model=student::find($id);
        $model->delete();
        $request->session()->flash('message','Student Deleted');
       return redirect('admin/studentdetails');
    }

    public function studentdetailsexport(request $request,$classid,$sectionid){
        $name='Student List';
        return Excel::download(new adminstudentlistExport($classid,$sectionid), $name.'.xlsx'); 
    }
}
