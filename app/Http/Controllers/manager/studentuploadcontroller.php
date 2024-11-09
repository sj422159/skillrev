<?php

namespace App\Http\Controllers\manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Imports\studentImport;
use App\Models\student;
use App\Exports\managerstudentlistExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Redirect;
use Mail;

class studentuploadcontroller extends Controller
{
    public function uploadview(){
        $result['sections']=DB::table('lmssections')->where('classid',session()->get('MANAGER_CLASS_ID'))->get();
        return view('manager.uploadstudents',$result);
    }

    public function uploadsave(request $request) {
      Excel::import(new studentImport($request->post('sec')),request()->file('file'));     
      return Redirect::back()->with('success', 'Uploaded Successfully');
    }

    public function tmails(request $request){
       $mid=session()->get('MANAGER_ID');
       $redata=DB::table('students')->where('mid',$mid)->where('tmails',0)->get();

       for($i=0;$i<count($redata);$i++){
        $data=['name'=>$redata[$i]->sname,'email'=>$redata[$i]->semail,'number'=>$redata[$i]->snumber,'password'=>$redata[$i]->snumber];
       $user['to']=$redata[$i]->semail;

       Mail::send('mail.studentregister',$data,function($messages) use ($user){
        $messages->to($user['to']);
        $messages->subject('Login Credentials Of Your Account');
       });

       $model=student::find($redata[$i]->id);
       $model->tmails=1;
       $model->save();

     }
      $request->session()->flash('success','Mails Sent Succesfully');

        return redirect('manager/dashboard');
    }

    public function studentdetails(){
        $mid=session()->get('MANAGER_ID');
        $mclassid=session()->get('MANAGER_CLASS_ID');
        $result['classes']=DB::table('categories')->where('id',$mclassid)->get();
        $result['sections']=DB::table('lmssections')->where('classid',$mclassid)->get();
        $result['section']='';
        $result['details']=[];
        return view('manager.studentlist',$result);
    }

    public function studentdetailsbysection(request $request){
        $mid=session()->get('MANAGER_ID');
        $mclassid=session()->get('MANAGER_CLASS_ID');
        $result['classes']=DB::table('categories')->where('id',$mclassid)->get();
        $result['sections']=DB::table('lmssections')->where('classid',$mclassid)->get();
        $result['section']=$request->post('section');
        $result['details']= DB::table('students')->where('mid',$mid)->where('sclassid',$mclassid)
                            ->where('ssectionid',$result['section'])
                            ->select('students.*')
                            ->get();
        return view('manager.studentlist',$result);
    }

    public function studentdetailsview(request $request,$id){
        $aid=session()->get('MANAGER_ADMIN_ID');
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
        return view('manager.studentdetails',$result);
    }

    public function status(Request $request,$status,$id){
        $model=student::find($id);
        $model->status=$status;
        $model->save();
        return redirect('manager/studentdetails');
    }

    public function delete(Request $request, $id){
        $model=student::find($id);
        $model->delete();
        $request->session()->flash('message','Student Deleted');
       return redirect('manager/studentdetails');
    }

    public function studentdetailsexport(request $request,$sectionid){
        $name='Student List';
        $classid=session()->get('MANAGER_CLASS_ID');
        return Excel::download(new managerstudentlistExport($classid,$sectionid), $name.'.xlsx'); 
    }
}