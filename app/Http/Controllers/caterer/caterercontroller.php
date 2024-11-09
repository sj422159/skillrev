<?php

namespace App\Http\Controllers\caterer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\vendors;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Mail;

class caterercontroller extends Controller{

    public function login(request $request){
        return view('caterer.login');
    }

    public function logincheck(request $request){
    $email=$request->post('email');
     
        $result=vendors::where(['email'=>$email,'role'=>1])->first();
          if($result){
            if(Hash::check($request->post('password'),$result->password)){
            if($result->status=="1"){
            session()->put('CATERER_LOGIN',true);
            session()->put('CATERER_ID',$result->id);
            session()->put('CATERER_ADMIN_ID',$result->aid);
            session()->put('CATERER_MANAGER_ID',$result->mid);
            session()->put('CATERER_HOSTELID',$result->hostelid);
            session()->put('CATERER_Name',$result->fname);
            session()->put('CATERER_Email',$result->email);
            session()->put('CATERER_Number',$result->mobile);
            session()->flash('success','Successfully Logged In');
            return redirect('vendor/caterer/dashboard');
            }else{
                $request->session()->flash("accesserror","Access Denied");
             return redirect('/admin');
            }
            }else{
             $request->session()->flash("passworderror","InCorrect Password");
             return redirect('/admin');
            }
       }else{
           $request->session()->flash("detailserror","Incorrect Details");
           return redirect('/admin');
        }
    }

    public function forgotpassword(request $request){
        return view('caterer.forgotpassword');
    }

    public function forgotpasswordcheck(request $request){
    $email=$request->post('email');
     
    $result=vendors::where(['email'=>$email,'role'=>1])->first();
        if($result){
         $permitted_chars = '0123456789';
         $password = substr(str_shuffle($permitted_chars), 0, 5);

         $model=vendors::find($result->id);
         $model->password=Hash::make($password);
         $model->save();
         

        $data=['name'=>$result->fname,'email'=>$result->email,'number'=>$result->mobile,'password'=>$password];

        $user['to']=$request->email;

       Mail::send('mail.catererforgotmail',$data,function($messages) use ($user){
        $messages->to($user['to']);
        $messages->subject('New Password Of Your Account');
       });

        $request->session()->flash('found','Check Your Mail');
        return redirect('vendor/caterer/forgotpassword');
             
       }else{
           $request->session()->flash("notfound","Not Found");
           return redirect('vendor/caterer/forgotpassword');
        }
    }
    
    public function dashboard(request $request){
        $sesid=session()->get('CATERER_ID');
          $aid=session()->get('CATERER_ADMIN_ID');
        $mid=session()->get('CATERER_MANAGER_ID');
        $result['image']=vendors::where('id',$sesid)->get();
        $hostelid=session()->get('CATERER_HOSTELID');
        $result['costdesign']=0;
        $result['schoolmenu']=0;

        if($hostelid==0){
             $a=DB::table('fooditems')
                           ->join('foodcategories','fooditems.foodcat','foodcategories.id')
                           ->join('foodpricetypes','fooditems.pricetype','foodpricetypes.id')
                           ->where('fooditems.aid',$aid)->where('fooditems.mid',$mid)->select('fooditems.*','foodcategories.foodcategory','foodpricetypes.ptype')->get();
            $b=DB::table('schoolmenus')->where('catererid',$sesid)->get();
            $result['schoolmenu']=count($b);
            $count=0;
            $check=[];
             for($i=0;$i<count($b);$i++){
             $check[$i]=$b[$i]->fitemid;
           }
            for($i=0;$i<count($a);$i++){
             if(in_array($a[$i]->id,$check)){
              
             }else{
                $count++;
             }
             $result['costdesign']=$count;

           }

        }
        return view('caterer.dashboard',$result);
    }

    public function profile(){
        $sesid=session()->get('CATERER_ID');
        $model['data']=vendors::where('id',$sesid)->get(); 
        return view('caterer.profile',$model);
    }

    public function update(request $request){
        $sesid=session()->get('CATERER_ID');
        $pwd=$request->post('npass');
        $repwd=$request->post('cpass');
        if($pwd!==$repwd){
            session()->flash('error',"Password Are Not Matching");
            return redirect('vendor/caterer/profile');
        }

       $model1=vendors::find($sesid);

       if(Hash::check($request->post('opass'),$model1->password)){

        $model=vendors::find($id);
        if($pwd=='' && $repwd=='')
        {
        $model->password=Hash::make($request->post('opass'));
        }
        else{
        $model->password=Hash::make($request->post('npass'));
        }
        $model->save();
        session()->flash('message','Profile Updated Successfully');
        return redirect('vendor/caterer/dashboard');

       }
       else{
        session()->flash('error','Old Password Not Matched');
        return redirect('vendor/caterer/profile');
       }
    }

    public function adddetails(Request $request,$id=""){
        $sesid=session()->get('CATERER_ID');
        $arr=DB::table('vendors')->where(['id'=>$sesid])->get();
        if(count($arr)>0){
            $result['id']=$arr['0']->id;
            $result['name']=$arr['0']->fname;
            $result['email']=$arr['0']->email;
            $result['number']=$arr['0']->mobile;
            $result['image']=$arr['0']->image;
        }else{
            $result['id']='';
            $result['name']='';
            $result['email']='';
            $result['number']='';
            $result['image']='';
        }
        return view('caterer.adddetails',$result);
    }

    public function savedetails(Request $request){   
          if($request->post('id')>0){
            $model=vendors::find($request->post('id'));
            $msg="Corporate Details Updated";
          }else{ 
            $model=new vendors();
            $msg="Corporate Details Inserted";
          }
           if($request->hasfile('image')){  
            $image=$request->file('image');
            $ext=$image->extension();
            $image_name=time().'.'.$ext;
            $image->move(public_path().'/catererimages',$image_name);
            $model->image=$image_name;
         }
        $model->fname=$request->post('name');
        $model->email=$request->post('email');
        $model->mobile=$request->post('number');
        $model->save();
        session()->flash('message',$msg);
        return redirect('vendor/caterer/dashboard');
    }
   
}