<?php

namespace App\Http\Controllers\admin;

use App\Models\admin;
use Redirect,Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class lmsauthenticatecontroller extends Controller
{

    public function legacy_index(request $request){
        $result['schools']=DB::table('admins')->get();
        $result['event']=DB::table('homepage_events')->where('id',1)->get();
        return view("index",$result);
    }
    public function index(request $request){
        $result['schools']=DB::table('admins')->get();
        $result['event']=DB::table('homepages')->where('id',1)->get();
        $result['stats']=DB::table('stats')->where('id',1)->get();
        $result['data']=DB::table('steps')->where('id',1)->get();
        $result['test']=DB::table('testimonials')->where('id',1)->get();
        $result['slide']=DB::table('slideshows')->where('id',1)->get();
        return view('views_latest.new_index',$result);
    }

    public function internal(request $request){
        $result['schools']=DB::table('admins')->get();
        $result['event']=DB::table('homepage_events')->where('id',1)->get();
        return view('internal',$result);
    }

    public function admin(request $request){
        $result['schools']=DB::table('admins')->get();
        $result['event']=DB::table('homepage_events')->where('id',1)->get();
        return view('admin',$result);
    }

    public function manager(request $request){
        $result['schools']=DB::table('admins')->get();
        $result['event']=DB::table('homepage_events')->where('id',1)->get();
        return view('manager',$result);
    }

    public function officer(request $request){
        $result['schools']=DB::table('admins')->get();
        $result['event']=DB::table('homepage_events')->where('id',1)->get();
        return view('officer',$result);
    }

    public function contact(Request $request){
      $data=['name'=>$request->name,'email'=>$request->email,'phone'=>$request->phone,'messages'=>$request->message];
       $user['to']='support@skillrevelation.com';
       Mail::send('mail.mail',$data,function($messages) use ($user){
        $messages->to($user['to']);
        $messages->subject('SMS People Contacted');
       });

        $request->session()->flash('message','Message Sent Succesfully');
        return redirect('/');
    }

    public function internalcontact(Request $request){
      $data=['name'=>$request->name,'email'=>$request->email,'phone'=>$request->phone,'messages'=>$request->message];
       $user['to']='support@skillrevelation.com';
       Mail::send('mail.mail',$data,function($messages) use ($user){
        $messages->to($user['to']);
        $messages->subject('SMS People Contacted');
       });

        $request->session()->flash('message','Message Sent Succesfully');
        return redirect('/internal');
    }

    public function admincontact(Request $request){
      $data=['name'=>$request->name,'email'=>$request->email,'phone'=>$request->phone,'messages'=>$request->message];
       $user['to']='support@skillrevelation.com';
       Mail::send('mail.mail',$data,function($messages) use ($user){
        $messages->to($user['to']);
        $messages->subject('SMS People Contacted');
       });

        $request->session()->flash('message','Message Sent Succesfully');
        return redirect('/admin');
    }

    public function managercontact(Request $request){
      $data=['name'=>$request->name,'email'=>$request->email,'phone'=>$request->phone,'messages'=>$request->message];
       $user['to']='support@skillrevelation.com';
       Mail::send('mail.mail',$data,function($messages) use ($user){
        $messages->to($user['to']);
        $messages->subject('SMS People Contacted');
       });

        $request->session()->flash('message','Message Sent Succesfully');
        return redirect('/manager');
    }

    public function officercontact(Request $request){
      $data=['name'=>$request->name,'email'=>$request->email,'phone'=>$request->phone,'messages'=>$request->message];
       $user['to']='support@skillrevelation.com';
       Mail::send('mail.mail',$data,function($messages) use ($user){
        $messages->to($user['to']);
        $messages->subject('SMS People Contacted');
       });

        $request->session()->flash('message','Message Sent Succesfully');
        return redirect('/officer');
    }

    public function register(request $request){
        return view('admin.register');
    }

    public function save(request $request){

        $request->post();

        $request->validate([
          'email'=>'required|unique:admins,aemail',
          'number'=>'required|unique:admins,anumber'
        ]);

        $p = $request->post('number');
        $password=substr($p,5);

        $model = new admin();
        $model->aname=$request->post('name');
        $model->aemail=$request->post('email');
        $model->anumber=$request->post('number');
        $model->password=Hash::make($password);
        $model->p=$password;
        $model->status=0;
        $model->save();

        $data=['name'=>$request->name,'email'=>$request->email,'number'=>$request->number,'password'=>$password];

       $user['to']=$request->email;

       Mail::send('mail.adminregister',$data,function($messages) use ($user){
        $messages->to($user['to']);
        $messages->subject('Login Credentials Of Your Account');
       });

        $request->session()->flash('successc','Registered Succesfully Check Your Mail');

        return redirect('/');

    }

    public function login(request $request){
        return view('admin.login');
    }

    public function logincheck(request $request){

    $email=$request->post('email');

        $result=admin::where(['aemail'=>$email])->first();
          if($result){
            if(Hash::check($request->post('password'),$result->password)){
            if($result->status=="1"){
            session()->put('ADMIN_LOGIN',true);
            session()->put('ADMIN_ID',$result->id);
            session()->put('ADMIN_Name',$result->aname);
            session()->put('ADMIN_Email',$result->aemail);
            session()->put('ADMIN_Number',$result->anumber);
            session()->flash('success','Successfully Logged In');
            return redirect('admin/dashboard');
             }else{
                $request->session()->flash("error","Access Denied");
           return redirect('/login');
             }
           }else{
             $request->session()->flash("error","Incorrect Password");
           return redirect('/login');
               }
       }else{
           $request->session()->flash("error","Invalid Login Credentials");
           return redirect('/login');
        }
    }


    public function forgotpassword(request $request){
        return view('admin.forgotpassword');
    }

    public function forgotpasswordcheck(request $request){

    $email=$request->post('email');

    $result=admin::where(['aemail'=>$email])->first();
        if($result){
         $permitted_chars = '0123456789';
         $password = substr(str_shuffle($permitted_chars), 0, 5);

         $model=admin::find($result->id);
         $model->password=Hash::make($password);
         $model->save();


        $data=['name'=>$result->aname,'email'=>$result->aemail,'number'=>$result->anumber,'password'=>$password];

        $user['to']=$email;

       Mail::send('mail.adminforgotmail',$data,function($messages) use ($user){
        $messages->to($user['to']);
        $messages->subject('New Password Of Your Account');
       });

        $request->session()->flash('found','Check Your Mail');
        return redirect('admin/forgotpassword');

       }else{
           $request->session()->flash("notfound","Not Found");
           return redirect('admin/forgotpassword');
        }
    }

    public function dashboard(request $request){
      $sesid=session()->get('ADMIN_ID');
      $result['student']=DB::table('students')->where('aid',$sesid)->get();
      $result['question']=DB::table('questionbanks')->where('aid',$sesid)->get();
      $result['assesment']=DB::table('assesments')->where('aid',$sesid)->get();
      $result['leavemanagement']=DB::table('leaves')->where('aid',$sesid)->where('status',1)->get();
      $result['trainingtype']=DB::table('trainingtypes')->get();
      for($i=0;$i<count($result['trainingtype']);$i++){
       $d=DB::table('studentassignations')->where('trainingtype',$result['trainingtype'][$i]->id)->where('cyclestatus',1)->where('aid',$sesid)->get();
        $result['trainingtype'][$i]->assigned=count($d);
        $v=DB::table('studentassignations')->where('trainingtype',$result['trainingtype'][$i]->id)->where('cyclestatus',2)->where('aid',$sesid)->get();
        $result['trainingtype'][$i]->attended=count($v);
        $c=DB::table('studentassignations')->where('trainingtype',$result['trainingtype'][$i]->id)->where('cyclestatus','>',2)->where('aid',$sesid)->get();
        $result['trainingtype'][$i]->completed=count($c);
      }
      $result['image']=admin::where('id',$sesid)->get();
      return view('admin.dashboard',$result);
    }


    public function profile(){
        $id=session()->get('ADMIN_ID');
        $model['data']=admin::where('id',$id)->get();
        return view('admin.profile',$model);
    }

     public function update(request $request)
    {
        $id=session()->get('ADMIN_ID');
        $pwd=$request->post('npass');
        $repwd=$request->post('cpass');
        if($pwd!==$repwd){
            session()->flash('error',"Password Are Not Matching");
            return redirect('admin/profile');
        }

       $model1=admin::find($id);

       if(Hash::check($request->post('opass'),$model1->password)){

        $model=admin::find($id);
        if($pwd=='' && $repwd=='')
        {
        $model->password=Hash::make($request->post('opass'));
        }
        else{
        $model->password=Hash::make($request->post('npass'));
        }
        $model->save();
        session()->flash('message','Profile Updated Successfully');
        return redirect('admin/dashboard');

       }
       else{
        session()->flash('error','Old Password Not Matched');
        return redirect('admin/profile');
       }

    }

    public function adddetails(Request $request,$id="")
    {

            $sesid=session()->get('ADMIN_ID');
            $result['data']=DB::table('admins')->where(['id'=>$sesid])->get();

            if(count($result['data'])>0){
            $arr=DB::table('admins')->where(['id'=>$sesid])->get();

            $result['id']=$arr['0']->id;
            $result['name']=$arr['0']->aname;
            $result['email']=$arr['0']->aemail;
            $result['number']=$arr['0']->anumber;
            $result['paymentlink']=$arr['0']->apaymentlink;
            $result['websitelink']=$arr['0']->awebsitelink;
            $result['image']=$arr['0']->image;
            $result['aadharnumber']=$arr['0']->aadharnumber;

        }else{
            $result['id']='';
            $result['name']='';
            $result['email']='';
            $result['number']='';
            $result['paymentlink']='';
            $result['websitelink']='';
            $result['image']='';
            $result['aadharnumber']='';
        }

        return view('admin.adddetails',$result);
    }

    public function savedetails(Request $request)
    {
          if($request->post('id')>0){
            $model=admin::find($request->post('id'));
            $msg="Corporate Details Updated";
          }else{

            $model=new admin();
            $msg="Corporate Details Inserted";
          }

           if($request->hasfile('image')){
            $image=$request->file('image');
            $ext=$image->extension();
            $image_name=time().'.'.$ext;
            $image->move(public_path().'/adminimages',$image_name);
            $model->image=$image_name;
         }

         $model->aname=$request->post('name');
         $model->aemail=$request->post('email');
         $model->anumber=$request->post('number');
         $model->awebsitelink=$request->post('websitelink');
         $model->apaymentlink=$request->post('paymentlink');
         $model->aadharnumber=$request->post('aadharnumber');
         $model->save();
         session()->flash('message',$msg);
         return redirect('admin/dashboard');
    }


}
