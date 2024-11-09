<?php

namespace App\Http\Controllers\marketingmanager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\marketingofficer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Mail;

class mmmarketingofficercontroller extends Controller
{
     public function index(){
      $id=session()->get('MARKETINGMANAGER_ID');
      $result['data']=DB::table('marketingofficers')->where('mmid',$id)->get();
      return view('marketingmanager.marketingofficer',$result);
    }
    public function create(Request $request,$id="")
    {
         $result['employment_status']=DB::table('employment_status')->get();
          
        if($id>0){
            $arr=marketingofficer::where(['id'=>$id])->get();
            $result['mofname']=$arr['0']->mofname;
            $result['molname']=$arr['0']->molname;
            $result['momobile']=$arr['0']->momobile;
            $result['moemail']=$arr['0']->moemail;
            $result['mobranchoffice']=$arr['0']->mobranchoffice;
            $result['moworklocation']=$arr['0']->moworklocation;
            $result['moaadhar']=$arr['0']->moaadhar;
            $result['moemploymentstatus']=$arr['0']->moemploymentstatus;
            $result['mostatus']=$arr['0']->mostatus;
            $result['id']=$arr['0']->id;
         
        }
        else
        {
            $result['mofname']='';
            $result['molname']='';
            $result['momobile']='';
            $result['moemail']='';
            $result['mobranchoffice']='';
            $result['moworklocation']='';
            $result['moaadhar']='';
            $result['moemploymentstatus']='';
            $result['mostatus']='';
            $result['id']='';
            
        }
       
        return view("marketingmanager.createmarketingofficer",$result);

    }
     
     public function save(Request $request)
    {
        
         
       if($request->post('id')>0){
            $model=marketingofficer::find($request->post('id'));
            $msg="Marketing Officer Details Updated";

          }else{
            $model=new marketingofficer();
            $msg="Marketing Officer Inserted";
            
          }

        $model->mmid=session()->get('MARKETINGMANAGER_ID');
        $model->mofname=$request->post('mofname');
        $model->molname=$request->post('molname');
        $model->momobile=$request->post('momobile');
        $model->moemail=$request->post('moemail');
        $model->mousername=$request->post('moemail');
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
        $password = substr(str_shuffle($permitted_chars), 0, 4);
        $model->mopswd=Hash::make($password);
        $model->mobranchoffice=$request->post('mobranchoffice');
        $model->moworklocation=$request->post('moworklocation');
        $model->moaadhar=$request->post('moaadhar');
        $model->moemploymentstatus=$request->post('moemploymentstatus');
        $model->mostatus=1;

        $model->save();


        $data=['fname'=>$request->mofname,'lname'=>$request->molname,'email'=>$request->moemail,'mobile'=>$request->momobile,'password'=>$password];

       $user['to']=$request->moemail;

       Mail::send('mail.officers',$data,function($messages) use ($user){
        $messages->to($user['to']);
        $messages->subject('Login Credentials Of Your Account');
       });

        return redirect('employee/marketingmanager/marketingofficers');
    
    }


     public function status(Request $request,$status,$id)
    {
        $model=marketingofficer::find($id);
        $model->mostatus=$status;
        $model->save();
        return redirect('employee/marketingmanager/marketingofficers');

    }


    public function delete(Request $request, $id)
    {
        $model=marketingofficer::find($id);
        $model->delete();
       // $request->session()->flash('message','Category Deleted');
       return redirect('employee/marketingmanager/marketingofficers');
    }

}
