<?php

namespace App\Http\Controllers\nontechgroupmanager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\nontechsupervisor;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\othersItems;
use App\Models\othersinfrarepairhistory;
use Mail;

class nontechgroupmanagercontroller extends Controller{

    public function login(request $request){
        return view('nontechgroupmanager.login');
    }

    public function logincheck(request $request){
    $email=$request->post('email');
     
        $result=nontechsupervisor::where(['supemail'=>$email])->first();
          if($result){
            if(Hash::check($request->post('password'),$result->password)){
            if($result->status=="1"){
            session()->put('NONTECH_GROUPMANAGER_LOGIN',true);
            session()->put('NONTECH_GROUPMANAGER_ID',$result->id);
            session()->put('NONTECH_GROUPMANAGER_ADMIN_ID',$result->aid);
           
            session()->put('NONTECH_GROUPMANAGER_Name',$result->supname);
            session()->put('NONTECH_GROUPMANAGER_Email',$result->supemail);
            session()->put('NONTECH_GROUPMANAGER_Number',$result->supnumber);
            session()->flash('success','Successfully Logged In');
            return redirect('nontech/groupmanager/dashboard');
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
        return view('nontechgroupmanager.forgotpassword');
    }

    public function forgotpasswordcheck(request $request){
    $email=$request->post('email');
     
    $result=nontechsupervisor::where(['supemail'=>$email])->first();
        if($result){
         $permitted_chars = '0123456789';
         $password = substr(str_shuffle($permitted_chars), 0, 5);

         $model=nontechsupervisor::find($result->id);
         $model->password=Hash::make($password);
         $model->save();
         

        $data=['name'=>$result->supname,'email'=>$result->supemail,'number'=>$result->supnumber,'password'=>$password];

        $user['to']=$request->supemail;

       Mail::send('mail.nontechgroupmanagerforgotmail',$data,function($messages) use ($user){
        $messages->to($user['to']);
        $messages->subject('New Password Of Your Account');
       });

        $request->session()->flash('found','Check Your Mail');
        return redirect('nontech/groupmanager/forgotpassword');
             
       }else{
           $request->session()->flash("notfound","Not Found");
           return redirect('nontech/groupmanager/forgotpassword');
        }
    }
    
    public function dashboard(request $request){
        $sesid=session()->get('NONTECH_GROUPMANAGER_ID');
        $result['image']=nontechsupervisor::where('id',$sesid)->get();
        
        $deptid=session()->get('NONTECH_GROUPMANAGER_DEPT_ID');
        $department=DB::table('departments')->get(); 
        $result['departments']=$department;
        //return count($result['departments']);
        $result['departmentexists']=0;
        if(count($department)>0){
            $result['departmentexists']=1;
        }

        $result['transportmanager']=DB::table('nontechmanagers')
                                    ->join('departments','departments.id','nontechmanagers.departmentid')
                                    ->where('departments.category',1)
                                    ->where('supid',$sesid)
                                    ->select('nontechmanagers.*')
                                    ->get();
        $result['infrastructuremanager']=DB::table('nontechmanagers')
                                    ->join('departments','departments.id','nontechmanagers.departmentid')
                                    ->where('departments.category',2)
                                    ->where('supid',$sesid)
                                    ->select('nontechmanagers.*')
                                    ->get();
        $result['cafeteriamanager']=DB::table('nontechmanagers')
                                    ->join('departments','departments.id','nontechmanagers.departmentid')
                                    ->where('departments.category',3)
                                    ->where('supid',$sesid)
                                    ->select('nontechmanagers.*')
                                    ->get();
        $result['hostelmanager']=DB::table('nontechmanagers')
                                    ->join('departments','departments.id','nontechmanagers.departmentid')
                                    ->where('departments.category',4)
                                    ->where('supid',$sesid)
                                    ->select('nontechmanagers.*')
                                    ->get();
        
        return view('nontechgroupmanager.dashboard',$result);
    }

    public function profile(){
        $sesid=session()->get('NONTECH_GROUPMANAGER_ID');
        $model['data']=nontechsupervisor::where('id',$sesid)->get(); 
        return view('nontechgroupmanager.profile',$model);
    }

    public function update(request $request){
        $sesid=session()->get('NONTECH_GROUPMANAGER_ID');
        $pwd=$request->post('npass');
        $repwd=$request->post('cpass');
        if($pwd!==$repwd){
            session()->flash('error',"Password Are Not Matching");
            return redirect('nontech/groupmanager/profile');
        }

       $model1=nontechsupervisor::find($sesid);

       if(Hash::check($request->post('opass'),$model1->password)){

        $model=nontechsupervisor::find($sesid);
        if($pwd=='' && $repwd=='')
        {
        $model->password=Hash::make($request->post('opass'));
        }
        else{
        $model->password=Hash::make($request->post('npass'));
        }
        $model->save();
        session()->flash('message','Profile Updated Successfully');
        return redirect('nontech/groupmanager/dashboard');

       }
       else{
        session()->flash('error','Old Password Not Matched');
        return redirect('nontech/groupmanager/profile');
       }
    }

    public function adddetails(Request $request,$id=""){
        $sesid=session()->get('NONTECH_GROUPMANAGER_ID');
        $aid=session()->get('NONTECH_GROUPMANAGER_ADMIN_ID');
        $result['data']=DB::table('nontechsupervisors')->where(['id'=>$sesid])->get();
        $result['departments']=DB::table('departments')->where('aid',$aid)->get(); 
        if(count($result['data'])>0){
            $arr=DB::table('nontechsupervisors')->where(['id'=>$sesid])->get();
            $result['id']=$arr['0']->id;
            $result['name']=$arr['0']->supname;
            $result['email']=$arr['0']->supemail;
            $result['number']=$arr['0']->supnumber;
            $result['image']=$arr['0']->image;
            
        }else{
            $result['id']='';
            $result['name']='';
            $result['email']='';
            $result['number']='';
            $result['image']='';
      
        }
        return view('nontechgroupmanager.adddetails',$result);
    }

    public function savedetails(Request $request){   
          if($request->post('id')>0){
            $model=nontechsupervisor::find($request->post('id'));
            $msg="Corporate Details Updated";
          }else{ 
            $model=new nontechsupervisor();
            $msg="Corporate Details Inserted";
          }
           if($request->hasfile('image')){  
            $image=$request->file('image');
            $ext=$image->extension();
            $image_name=time().'.'.$ext;
            $image->move(public_path().'/nontechgroupmanagerimages',$image_name);
            $model->image=$image_name;
         }
        $model->supname=$request->post('name');
        $model->supemail=$request->post('email');
        $model->supnumber=$request->post('number');
        $model->save();
        session()->flash('message',$msg);
        return redirect('nontech/groupmanager/dashboard');
    }

    public function dashboardinfo($id){
        $sesid=session()->get('NONTECH_GROUPMANAGER_ID');
        $aid=session()->get('NONTECH_GROUPMANAGER_ADMIN_ID');
        if($id==1){
            $result['transportdelayreport']=DB::table('transportattendances')->where('adminid',$aid)->get();
            return view('nontechgroupmanager.transport.transport',$result);
        }else if($id==2){
            $result['id']=0;
            $result['school']=0;
            $result['cafeteria']=0;
            $result['repair']=0;
            $result['hostel']=0;
            $result['others']=0;
            $result['infra']=0;
            $result['hostels']=DB::table('nontechmanagers')
                            ->join('departments','nontechmanagers.departmentid','departments.id')
                            ->where('departments.category',$id)
                            ->where('supid',$sesid)
                            ->select('nontechmanagers.*')
                            ->get();
            return view('nontechgroupmanager.infrastructure',$result);
        }else if($id==3){
            $result['id']=0;
            $result['school']=0;
            $result['hostel']=0;
            $result['cafeteria']=0;
            $result['other']=0;
            $result['foodfeed']=0;
            $result['fooditem']=0;
            $result['foodcaterer']=0;
            $result['hostels']=DB::table('nontechmanagers')
                            ->join('departments','nontechmanagers.departmentid','departments.id')
                            ->where('departments.category',$id)
                            ->where('supid',$sesid)
                            ->select('nontechmanagers.*')
                            ->get();
            return view('nontechgroupmanager.cafeteriadashboard',$result);
        }else{
            $result['id']=0;
            $result['bed']=0;
            $result['room']=0;
            $result['repair']=0;
            $result['hostelinfra']=0;
            $result['food']=0;
            $result['foodfeed']=0;
            $result['hostels']=DB::table('nontechmanagers')
                            ->join('departments','nontechmanagers.departmentid','departments.id')
                            ->where('departments.category',$id)
                            ->where('supid',$sesid)
                            ->select('nontechmanagers.*')
                            ->get();
            return view('nontechgroupmanager.hostel',$result);
        }
    }


     public function others()
            {
                $id=session()->get('NONTECH_GROUPMANAGER_ID');
                 $aid=session()->get('NONTECH_GROUPMANAGER_ADMIN_ID');
                    $result['items']=DB::table('infraitems')->where('allocation',1)->get();
                  $result['rooms']=DB::table('rooms')->where('allocation',1)->get();
                   $result['data']=DB::table('others_items')
                         ->join('rooms','others_items.roomid','rooms.id')
                         ->join('infraitems','others_items.itemid','infraitems.id')
                         ->where('others_items.aid',$aid)
                         ->select('others_items.*','rooms.roomname','rooms.capacity','infraitems.infraitem')->get();;
                    return view('nontechgroupmanager.othersinframanagement',$result);
                
            }


     public function filter(Request $request){
       //return $request->post();
     $id=session()->get('NONTECH_GROUPMANAGER_ID');
                 $aid=session()->get('NONTECH_GROUPMANAGER_ADMIN_ID');
           $result['items']=DB::table('infraitems')->where('allocation',1)->get();
                  $result['rooms']=DB::table('rooms')->where('allocation',1)->get();

                  $result['data']=DB::table('others_items')
                         ->join('rooms','others_items.roomid','rooms.id')
                         ->join('infraitems','others_items.itemid','infraitems.id')
                         ->where('others_items.aid',$aid)
                           ->where('others_items.roomid',$request->room)
                           ->where('others_items.itemid',$request->item)
                         ->select('others_items.*','rooms.roomname','rooms.capacity','infraitems.infraitem')->get();;
                   return view('nontechgroupmanager.othersinframanagement',$result);
    }

      public function repair($id){
                $model=othersItems::find($id);
                $model->repair=1;

                $m=new othersinfrarepairhistory();
                $m->aid=$model->aid;
                $m->mid=$model->mid;
                $m->roomid=$model->roomid;
                $m->itemid=$model->itemid;
                $m->itemno=$model->itemno;
                $m->repairissued=date('d-m-Y');
                $m->save();

                $model->history=$m->id;
                $model->save();

                return redirect('nontechgroupmanager/infra/others/details');
            }
            public function repairend($id){
                $model=othersItems::find($id);
                $model->repair=0;
                $m=othersinfrarepairhistory::find($model->history);
                $m->repairfinished=date('d-m-y');
                $m->save();
                $model->history=0;
                $model->save();
                 return redirect('nontechgroupmanager/infra/others/details');
    
              }

}