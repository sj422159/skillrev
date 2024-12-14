<?php

namespace App\Http\Controllers\nontechmanager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\nontechmanager;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Mail;

class nontechmanagercontroller extends Controller{

    public function login(request $request){
        return view('nontechmanager.login');
    }

     public  function getsections(request $request){
        $classid = $request->post('classid');
        $state = DB::table('lmssections')->where('classid',$classid)->get();
        echo $html='<option value="">Select</option>';
        foreach($state as $list){
          echo  $html='<option value="'.$list->id.'">'.$list->section.'</option>';
        }
    } 

     public  function getstudents(request $request){
        $classid = $request->post('classid');
        $state = DB::table('students')
                ->join('feepayments','feepayments.sid','students.id')
                ->where('ssectionid',$classid)->where('shostelservice','Yes')->where('bedallocated',0)
                ->select('students.*')
                ->get();
        echo $html='<option value="">Select</option>';
        foreach($state as $list){
          echo  $html='<option value="'.$list->id.'">'.$list->sname .'-'.$list->slname.' / '.$list->semail.' / '.$list->snumber.'</option>';
        }
    } 



    public function logincheck(request $request){
    $email=$request->post('email');
     
        $result=nontechmanager::where(['memail'=>$email])->first();
          if($result){
            if(Hash::check($request->post('password'),$result->password)){
            if($result->status=="1"){
            session()->put('NONTECH_MANAGER_LOGIN',true);
            session()->put('NONTECH_MANAGER_ID',$result->id);
            session()->put('NONTECH_MANAGER_ADMIN_ID',$result->aid);
            session()->put('NONTECH_MANAGER_SUP_ID',$result->supid);
            session()->put('NONTECH_MANAGER_DEPT_ID',$result->departmentid);
            session()->put('NONTECH_MANAGER_Name',$result->mname);
            session()->put('NONTECH_MANAGER_Email',$result->memail);
            session()->put('NONTECH_MANAGER_Number',$result->mnumber);
            session()->flash('success','Successfully Logged In');

            return redirect('nontech/manager/dashboard');
            }else{
                $request->session()->flash("accesserror","Access Denied");
             return redirect('/');
            }
            }else{
             $request->session()->flash("passworderror","InCorrect Password");
             return redirect('/');
            }
       }else{
           $request->session()->flash("detailserror","Incorrect Details");
           return redirect('/');
        }
    }

    public function forgotpassword(request $request){
        return view('nontechmanager.forgotpassword');
    }

    public function forgotpasswordcheck(request $request){
    $email=$request->post('email');
     
    $result=nontechmanager::where(['memail'=>$email])->first();
        if($result){
         $permitted_chars = '0123456789';
         $password = substr(str_shuffle($permitted_chars), 0, 5);

         $model=nontechmanager::find($result->id);
         $model->password=Hash::make($password);
         $model->save();
         

        $data=['name'=>$result->mname,'email'=>$result->memail,'number'=>$result->mnumber,'password'=>$password];

        $user['to']=$request->memail;

       Mail::send('mail.nontechmanagerforgotmail',$data,function($messages) use ($user){
        $messages->to($user['to']);
        $messages->subject('New Password Of Your Account');
       });

        $request->session()->flash('found','Check Your Mail');
        return redirect('nontech/manager/forgotpassword');
             
       }else{
           $request->session()->flash("notfound","Not Found");
           return redirect('nontech/manager/forgotpassword');
        }
    }
    
    public function dashboard(request $request){
        $sesid=session()->get('NONTECH_MANAGER_ID');
        $aid=session()->get('NONTECH_MANAGER_ADMIN_ID');
        $result['image']=nontechmanager::where('id',$sesid)->get();

        $deptid=session()->get('NONTECH_MANAGER_DEPT_ID');
        $department=DB::table('departments')->where('id',$deptid)->get(); 

        if($department[0]->category==1){
            $result['studentattendance']=DB::table('busroutes')->where('aid',$aid)->where('status',1)->get();
            $result['studentmanagement']=DB::table('students')
                                        ->join('distances','students.sdistance','distances.id')
                                        ->join('busroutes','distances.busrouteid','busroutes.id')
                                        ->where('students.aid',$aid)
                                        ->select('students.*','distances.location','busroutes.busroute')
                                        ->get();
            $result['busmanagement']=DB::table('students')
                        ->join('distances','students.sdistance','distances.id')
                        ->join('busroutes','distances.busrouteid','busroutes.id')
                        ->where('students.aid',$aid)
                        ->select('students.*','distances.location','busroutes.busroute')
                        ->get();
            return view('nontechmanager.transport.dashboard',$result);
        }elseif($department[0]->category==2){
            $result['groups']=DB::table('infragroups')->where('aid',$aid)->get();
            for($i=0;$i<count($result['groups']);$i++){
                if($result['groups'][$i]->category=="1"){
                    $school=DB::table('schoolitems')
                         ->join('categories','schoolitems.classid','categories.id')
                         ->join('lmssections','schoolitems.sectionid','lmssections.id')
                         ->join('infraitems','schoolitems.itemid','infraitems.id')
                         ->where('schoolitems.aid',$aid)
                         ->select('schoolitems.*','categories.categories','lmssections.section','infraitems.infraitem')->get();
                 $result['groups'][$i]->count=count($school);

                }else if($result['groups'][$i]->category=="2"){
                    $hostel=DB::table('hostelitems')
                         ->join('hostels','hostelitems.hostelid','hostels.id')
                         ->join('hostelrooms','hostelitems.roomid','hostelrooms.id')
                         ->join('infraitems','hostelitems.itemid','infraitems.id')
                         ->where('hostelitems.mid',$sesid)
                         ->select('hostelitems.*','hostels.hostel','hostelrooms.roomname','infraitems.infraitem')->get();
                         $result['groups'][$i]->count=count($hostel);

                }else if($result['groups'][$i]->category=="3"){
                    $cafeteria=DB::table('cafeteria_items')
                         ->join('cafeteriatype','cafeteria_items.cafetype','cafeteriatype.id')
                         ->join('cafeterias','cafeteria_items.cafeid','cafeterias.id')
                         ->join('infraitems','cafeteria_items.itemid','infraitems.id')
                         ->where('cafeteria_items.aid',$aid)
                           ->where('cafeteria_items.mid',$sesid)
                         ->select('cafeteria_items.*','cafeteriatype.ctype','cafeterias.cafeteria','infraitems.infraitem')->get();;
                         $result['groups'][$i]->count=count($cafeteria);
                }else{
                      $result['groups'][$i]->count=0;
                }
            }
            return view('nontechmanager.infrastructure.dashboard',$result);
        }elseif($department[0]->category==3){
            $school=DB::table('cafeteria_items')
                         ->join('cafeteriatype','cafeteria_items.cafetype','cafeteriatype.id')
                         ->join('cafeterias','cafeteria_items.cafeid','cafeterias.id')
                         ->join('infraitems','cafeteria_items.itemid','infraitems.id')
                         ->where('cafeteria_items.aid',$aid)
                         ->where('cafetype',1)
                         ->select('cafeteria_items.*','cafeteriatype.ctype','cafeterias.cafeteria','infraitems.infraitem')->get();;
            $result['school']=count($school);
            $hostel=DB::table('cafeteria_items')
                         ->join('cafeteriatype','cafeteria_items.cafetype','cafeteriatype.id')
                         ->join('cafeterias','cafeteria_items.cafeid','cafeterias.id')
                         ->join('infraitems','cafeteria_items.itemid','infraitems.id')
                         ->where('cafeteria_items.aid',$aid)
                         ->where('cafetype',2)
                         ->select('cafeteria_items.*','cafeteriatype.ctype','cafeterias.cafeteria','infraitems.infraitem')->get();;
            $result['hostel']=count($hostel);
            $other=DB::table('cafeteria_items')
                         ->join('cafeteriatype','cafeteria_items.cafetype','cafeteriatype.id')
                         ->join('cafeterias','cafeteria_items.cafeid','cafeterias.id')
                         ->join('infraitems','cafeteria_items.itemid','infraitems.id')
                         ->where('cafeteria_items.aid',$aid)
                         ->where('cafetype',3)
                         ->select('cafeteria_items.*','cafeteriatype.ctype','cafeterias.cafeteria','infraitems.infraitem')->get();;
            $result['other']=count($other);
            $foodfeed=DB::table('foodfeedbacks')
                        ->join('vendors','foodfeedbacks.catererid','vendors.id')
                        ->join('hostels','foodfeedbacks.hostelid','hostels.id')
                        ->join('students','foodfeedbacks.stu_id','students.id')
                        ->where('foodfeedbacks.aid',$aid)
                        ->select('foodfeedbacks.*','vendors.fname','vendors.lname','students.sname','students.slname','hostels.hostel')
                        ->get();;
            $result['foodfeed']=count($foodfeed);

            $foodcat=DB::table('foodcategories')->where('aid',$aid)->where('mid',$sesid)->get();;
            $result['foodcat']=count($foodcat);
            $fooditem=DB::table('fooditems')
                           ->join('foodcategories','fooditems.foodcat','foodcategories.id')
                           ->join('foodpricetypes','fooditems.pricetype','foodpricetypes.id')
                           ->where('fooditems.aid',$aid)->where('fooditems.mid',$sesid)->select('fooditems.*','foodcategories.foodcategory','foodpricetypes.ptype')->get();;
            $result['fooditem']=count($fooditem);
            $foodcaterer=DB::table('vendors')
                                   ->join('cafeteriatype','vendors.cafeteriatype','cafeteriatype.id')
                                   ->where('aid',$aid)->where('mid',$sesid)->select('vendors.*','cafeteriatype.ctype')->get();;
            $result['foodcaterer']=count($foodcaterer);

            return view('nontechmanager.cafeteria.dashboard',$result);
        }elseif($department[0]->category==4){
            $room=DB::table('hostelrooms')
                         ->join('hostels','hostelrooms.hostelid','hostels.id')
                         ->where('mid',$sesid)->select('hostelrooms.*','hostels.hostel')->get();
            $result['rooms']=count($room);
            $Bedallocation=DB::table('hostelitems')
                         ->join('hostels','hostelitems.hostelid','hostels.id')
                         ->join('hostelrooms','hostelitems.roomid','hostelrooms.id')
                         ->join('infraitems','hostelitems.itemid','infraitems.id')
                         ->where('hostelitems.aid',$aid)
                         ->where('hostelitems.itemid',2)
                         ->select('hostelitems.*','hostels.hostel','hostelrooms.roomname','infraitems.infraitem')->get();
            $result['Bedallocation']=count($Bedallocation);
            $hostelinfra= DB::table('hostelitems')
                         ->join('hostels','hostelitems.hostelid','hostels.id')
                         ->join('hostelrooms','hostelitems.roomid','hostelrooms.id')
                         ->join('infraitems','hostelitems.itemid','infraitems.id')
                         ->where('hostelitems.aid',$aid)
                         ->select('hostelitems.*','hostels.hostel','hostelrooms.roomname','infraitems.infraitem')->get();;
            $result['hostelinfra']=count($hostelinfra);
            $food=DB::table('hostelmenus')
             ->join('fooditems','hostelmenus.fitemid','fooditems.id')
            ->join('foodcategories','fooditems.foodcat','foodcategories.id')
             ->select('hostelmenus.*','fooditems.fooditems','foodcategories.foodcategory')
             ->get();
            $result['food']=count($food);
            return view('nontechmanager.hostel.dashboard',$result);
        }elseif($department[0]->category==5){
            return view('nontechmanager.library.dashboard',$result);
        }
        elseif($department[0]->category==6){
            return view('nontechmanager.account.dashboards',$result);
        }
       
        
       
    }

    public function profile(){
        $sesid=session()->get('NONTECH_MANAGER_ID');
        $model['data']=nontechmanager::where('id',$sesid)->get(); 
        return view('nontechmanager.profile',$model);
    }

    public function update(request $request){
        $sesid=session()->get('NONTECH_MANAGER_ID');
        $pwd=$request->post('npass');
        $repwd=$request->post('cpass');
        if($pwd!==$repwd){
            session()->flash('error',"Password Are Not Matching");
            return redirect('nontech/manager/profile');
        }

       $model1=nontechmanager::find($sesid);

       if(Hash::check($request->post('opass'),$model1->password)){

        $model=nontechmanager::find($id);
        if($pwd=='' && $repwd=='')
        {
        $model->password=Hash::make($request->post('opass'));
        }
        else{
        $model->password=Hash::make($request->post('npass'));
        }
        $model->save();
        session()->flash('message','Profile Updated Successfully');
        return redirect('nontech/manager/dashboard');

       }
       else{
        session()->flash('error','Old Password Not Matched');
        return redirect('nontech/manager/profile');
       }
    }

    public function adddetails(Request $request,$id=""){
        $sesid=session()->get('NONTECH_MANAGER_ID');
        $aid=session()->get('NONTECH_MANAGER_ADMIN_ID');
        $result['data']=DB::table('nontechmanagers')->where(['id'=>$sesid])->get();
        $result['departments']=DB::table('departments')->where('aid',$aid)->get(); 
        if(count($result['data'])>0){
            $arr=DB::table('nontechmanagers')->where(['id'=>$sesid])->get();
            $result['id']=$arr['0']->id;
            $result['name']=$arr['0']->mname;
            $result['email']=$arr['0']->memail;
            $result['number']=$arr['0']->mnumber;
            $result['image']=$arr['0']->image;
            $result['departmentid']=$arr['0']->departmentid;
        }else{
            $result['id']='';
            $result['name']='';
            $result['email']='';
            $result['number']='';
            $result['image']='';
            $result['departmentid']='';
        }
        return view('nontechmanager.transport.adddetails',$result);
    }

    public function savedetails(Request $request){   
          if($request->post('id')>0){
            $model=nontechmanager::find($request->post('id'));
            $msg="Corporate Details Updated";
          }else{ 
            $model=new nontechmanager();
            $msg="Corporate Details Inserted";
          }
           if($request->hasfile('image')){  
            $image=$request->file('image');
            $ext=$image->extension();
            $image_name=time().'.'.$ext;
            $image->move(public_path().'/nontechmanagerimages',$image_name);
            $model->image=$image_name;
         }
        $model->mname=$request->post('name');
        $model->memail=$request->post('email');
        $model->mnumber=$request->post('number');
        $model->save();
        session()->flash('message',$msg);
        return redirect('nontech/manager/dashboard');
    }
   
}