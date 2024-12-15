<?php
namespace App\Http\Controllers\corporateadmin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\admin;
use App\Models\infraitems;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Redirect;
use Mail;
use App\Exports\admindataExport;
use App\Exports\groupmanagerdataExport;
use App\Exports\managerdataExport;
use App\Exports\nontechgroupmanagerdataExport;
use App\Exports\nontechmanagerdataExport;
use App\Exports\nontechstaffdataExport;
use App\Exports\classteacherdataExport;
use App\Exports\facultydataExport;
use App\Exports\studentdataExport;
use App\Exports\catererdataExport;

class corporateadminschoolcontroller extends Controller{
    
    public function schoollist(){
        $result['schools']=DB::table('admins')->where('status',0)->get();
         $result['schools1']=DB::table('admins')->where('status',1)->get();
        return view('corporateadmin.schoollist',$result);
    }

    public function schoolstatus(Request $request,$status,$id){
        $model=admin::find($id);
        $model->status=$status;
        $model->save();
        $request->session()->flash("success","Status Changed Succesfully");
        return redirect('corporateadmin/school/list');
    }
    public function delete($id)
    {
        // Find the item by its ID
        $mail = admin::find($id);

        // Check if the mail exists
        if ($mail) {
            // Delete the mail record
            $mail->delete();

            // Redirect with success message
            return redirect('corporateadmin/school/list');
        }

        // If the mail doesn't exist, redirect with error message
        return redirect('corporateadmin/school/list');
    }

    public function sendmail(Request $request, $id)
    {
        // Find the admin by ID
        $model = admin::find($id);
        
        // Check if the admin is found
        if (!$model) {
            // Handle the case where the admin isn't found
            return redirect()->back()->with('error', 'Admin not found');
        }
    
        // Update mail status
        $model->mailstatus = 1;
        $model->save();
        
        // Prepare the data to send in the email
        $data = [
            'name' => $model->aname,
            'email' => $model->aemail,
            'number' => $model->anumber,
            'password' => $model->p
        ];
        
        // Set the recipient email address
        $user['to'] = $model->aemail;
        
        // Send the email
        Mail::send('mail.adminregistermail', $data, function($message) use ($user) {
            $message->to($user['to']);
            $message->subject('Login Credentials Of Your Account');
        });
    
        // Flash a success message and redirect
        $request->session()->flash("success", "Mail Sent Successfully");
        return redirect('corporateadmin/school/list');
    }
    

    public function schooldata($id){
        $school=DB::table('admins')->where('id',$id)->get();
        $groupmanager=DB::table('supervisors')->where('aid',$id)->get();
        $manager=DB::table('managers')->where('aid',$id)->get();
        $classteacher=DB::table('faculties')->where('aid',$id)->where('classteacher',1)->get();
        $faculty=DB::table('faculties')->where('aid',$id)->where('classteacher',2)->get();
        $student=DB::table('students')->where('aid',$id)->get();
        $nontechgroupmanager=DB::table('nontechsupervisors')->where('aid',$id)->get();
        $nontechmanager=DB::table('nontechmanagers')->where('aid',$id)->get();
        $nontechstaff=DB::table('nontechstaffs')->where('aid',$id)->get();
        $caterer=DB::table('vendors')->where('aid',$id)->where('role',1)->get();

        $result['school']=count($school);
        $result['groupmanager']=count($groupmanager);
        $result['manager']=count($manager);
        $result['classteacher']=count($classteacher);
        $result['faculty']=count($faculty);
        $result['student']=count($student);
        $result['nontechgroupmanager']=count($nontechgroupmanager);
        $result['nontechmanager']=count($nontechmanager);
        $result['nontechstaff']=count($nontechstaff);
        $result['caterer']=count($caterer);
        $result['totalaccounts']=count($school)+count($groupmanager)+count($manager)+count($classteacher)+count($faculty)
                                +count($student)+count($nontechgroupmanager)+count($nontechmanager)+count($nontechstaff)
                                +count($caterer);
        $result['data']=$school;
        return view('corporateadmin.schooldata',$result);
    }

    public function adminexport(request $request,$adminid){
        $name='Admin Data List';
        return Excel::download(new admindataExport($adminid), $name.'.xlsx'); 
    }

    public function groupmanagerexport(request $request,$adminid){
        $name='Group Manager Data List';
        return Excel::download(new groupmanagerdataExport($adminid), $name.'.xlsx'); 
    }

    public function managerexport(request $request,$adminid){
        $name='Manager Data List';
        return Excel::download(new managerdataExport($adminid), $name.'.xlsx'); 
    }

    public function nontechgroupmanagerexport(request $request,$adminid){
        $name='NonTech Group Manager Data List';
        return Excel::download(new nontechgroupmanagerdataExport($adminid), $name.'.xlsx'); 
    }

    public function nontechmanagerexport(request $request,$adminid){
        $name='NonTech Manager Data List';
        return Excel::download(new nontechmanagerdataExport($adminid), $name.'.xlsx'); 
    }

    public function nontechstaffexport(request $request,$adminid){
        $name='NonTech Staff Data List';
        return Excel::download(new nontechstaffdataExport($adminid), $name.'.xlsx'); 
    }

    public function classteacherexport(request $request,$adminid){
        $name='Class Teacher Data List';
        return Excel::download(new classteacherdataExport($adminid), $name.'.xlsx'); 
    }

    public function facultyexport(request $request,$adminid){
        $name='Faculty Data List';
        return Excel::download(new facultydataExport($adminid), $name.'.xlsx'); 
    }

    public function studentexport(request $request,$adminid){
        $name='Student Data List';
        return Excel::download(new studentdataExport($adminid), $name.'.xlsx'); 
    }

    public function catererexport(request $request,$adminid){
        $name='Caterer Data List';
        return Excel::download(new catererdataExport($adminid), $name.'.xlsx'); 
    }

    public function items(Request $request){
        $sesid=session()->get('NONTECH_MANAGER_ID');
        $result['items']=DB::table('infraitems')->get();
        return view('corporateadmin.items',$result);
    }

    public function additems(Request $request,$id=""){  
      $aid=session()->get('NONTECH_MANAGER_ADMIN_ID');   
        if($id>0){
            $arr=infraitems::where(['id'=>$id])->get();
            $result['id']=$arr['0']->id;
            $result['infraitem']=$arr['0']->infraitem;
            $result['allocation']=$arr['0']->allocation;     
        }
        else{
            $result['id']='';
            $result['infraitem']='';
            $result['allocation']=0;
        }   
        return view("corporateadmin.additems",$result);
    }

    public function saveitems(Request $request){
        $allocation=0;
         if($request->post('allocation')=="on"){
            $allocation=1;
         }
        if($request->post('id')>0){
            $model=infraitems::find($request->post('id'));
            $model->infraitem=$request->post('infraitem');
            $model->allocation=$allocation;
            $model->save();
            $request->session()->flash('success','Items Updated');
        }else{
            $model=new infraitems();
            $model->infraitem=$request->post('infraitem');
              $model->allocation=$allocation;
            $model->save();
            $request->session()->flash('success','Item Added');
        }
        return redirect('corporateadmin/infrastructure/items');
    }
}