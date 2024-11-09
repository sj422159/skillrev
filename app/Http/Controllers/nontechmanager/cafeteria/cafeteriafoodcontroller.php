<?php

namespace App\Http\Controllers\nontechmanager\cafeteria;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\hostelrooms;
use App\Models\hostelitems;
use App\Models\schoolitems;
use App\Models\cafeteriaItems;
use App\Imports\HostelitemsImport;
use App\Imports\cafeteriaitemsImport;
use App\Models\infraitems;
use App\Models\foodcategories;
use App\Models\fooditems;
use Redirect,Response;
use Validator;
use App\Models\vendors;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Hash;
use App\Exports\foodcategoryExport;
use App\Exports\fooditemExport;
use App\Exports\foodcatererExport;

class cafeteriafoodcontroller extends Controller
{
    public function category(){
        $mid=session()->get('NONTECH_MANAGER_ID');
        $aid=session()->get('NONTECH_MANAGER_ADMIN_ID');
        $result['data']=DB::table('foodcategories')->where('aid',$aid)->where('mid',$mid)->get();
        $result['mid']=$mid;
        return view('nontechmanager.cafeteria.foodcategory',$result);
    }

    public function categoryexport(request $request,$mid){
        $name='Food Category List';
        return Excel::download(new foodcategoryExport($mid), $name.'.xlsx'); 
    }

    public function addcategory(request $request,$id=""){
        if($id>0){
            $arr=foodcategories::where(['id'=>$id])->get();
            $result['id']=$arr['0']->id;
            $result['foodcategory']=$arr['0']->foodcategory;    
        }
        else{
            $result['id']='';
            $result['foodcategory']="";   
        }
        return view('nontechmanager.cafeteria.addfoodcategory',$result);
    }

    public function savecategory(request $request){
        $sesid=session()->get('NONTECH_MANAGER_ID');
        $aid=session()->get('NONTECH_MANAGER_ADMIN_ID');
        if($request->post('id')>0){
            $model=foodcategories::find($request->post('id'));
        }else{
            $model=new foodcategories();
        }
        $model->foodcategory=$request->post('category');
        $model->mid=$sesid;
        $model->aid=$aid;
        $model->save();
        return redirect("nontech/manager/food/category");
    }

    public function deletecategory($id){
        $model=foodcategories::find($id);
        $model->delete();
        return redirect("nontech/manager/food/category");
    }

    public function items(){
        $mid=session()->get('NONTECH_MANAGER_ID');
        $aid=session()->get('NONTECH_MANAGER_ADMIN_ID');
        $result['data']=DB::table('fooditems')
                        ->join('foodcategories','fooditems.foodcat','foodcategories.id')
                        ->join('foodpricetypes','fooditems.pricetype','foodpricetypes.id')
                        ->where('fooditems.aid',$aid)
                        ->where('fooditems.mid',$mid)
                        ->select('fooditems.*','foodcategories.foodcategory','foodpricetypes.ptype')
                        ->get();
        $result['mid']=$mid;
        return view('nontechmanager.cafeteria.fooditems',$result);
    }

    public function itemsexport(request $request,$mid){
        $name='Food Items List';
        return Excel::download(new fooditemExport($mid), $name.'.xlsx'); 
    }

    public function additems(request $request,$id=""){
        $mid=session()->get('NONTECH_MANAGER_ID');
        $aid=session()->get('NONTECH_MANAGER_ADMIN_ID');
        if($id>0){
            $arr=fooditems::where(['id'=>$id])->get();
            $result['id']=$arr['0']->id;
            $result['foodcategory']=$arr['0']->foodcat;
            $result['fooditem']=$arr['0']->fooditems;
            $result['ptype']=$arr['0']->pricetype;
            $result['price']=$arr['0']->price;         
        }
        else{
            $result['id']='';
            $result['foodcategory']="";
            $result['fooditem']="";
            $result['price']="";
            $result['ptype']="";
        }
        $result['categories']=DB::table('foodcategories')->where('aid',$aid)->where('mid',$mid)->get();
        $result['ptypes']=DB::table('foodpricetypes')->get();
        return view('nontechmanager.cafeteria.addfooditems',$result);
    }

    public function saveitems(request $request){
        $sesid=session()->get('NONTECH_MANAGER_ID');
        $aid=session()->get('NONTECH_MANAGER_ADMIN_ID');
        if($request->post('id')>0){
        $model=fooditems::find($request->post('id'));
        }else{
        $model=new fooditems();
      }
      $model->foodcat=$request->post('category');
      $model->fooditems=$request->post('items');
      $model->pricetype=$request->post('ptype');
      $model->price=$request->post('price');
      $model->mid=$sesid;
      $model->aid=$aid;
      $model->save();
      return redirect("nontech/manager/food/items");
    }

    public function deleteitems($id){
        $model=fooditems::find($id);
        $model->delete();
        return redirect("nontech/manager/food/items");
    }

    public function caterer(){
        $mid=session()->get('NONTECH_MANAGER_ID');
        $aid=session()->get('NONTECH_MANAGER_ADMIN_ID');
        $result['data']=DB::table('vendors')
                            ->join('cafeteriatype','vendors.cafeteriatype','cafeteriatype.id')
                            ->where('aid',$aid)
                            ->where('mid',$mid)
                            ->select('vendors.*','cafeteriatype.ctype')
                            ->get();
        $result['mid']=$mid;
        return view('nontechmanager.cafeteria.caterer',$result);
    }

    public function catererexport(request $request,$mid){
        $name='Food Caterer List';
        return Excel::download(new foodcatererExport($mid), $name.'.xlsx'); 
    }


    public function create(request $request,$id=""){
     $sesid=session()->get('NONTECH_MANAGER_ID');
        $aid=session()->get('NONTECH_MANAGER_ADMIN_ID');
    $result['employment_status']=DB::table('employment_status')->get();

    if($id>0){

            $arr=DB::table('vendors')->where(['id'=>$id])->get();
            
            $result['id']=$arr['0']->id;
            $result['ctype']=$arr['0']->cafeteriatype;
            $result['hostel']=$arr['0']->hostelid;
            $result['fname']=$arr['0']->fname;
            $result['lname']=$arr['0']->lname;
            $result['mobile']=$arr['0']->mobile;
            $result['email']=$arr['0']->email;
            $result['branchoffice']=$arr['0']->branchoffice;
            $result['worklocation']=$arr['0']->worklocation;
            $result['aadhar']=$arr['0']->aadhar;
            $result['employmentstatus']=$arr['0']->employmentstatus;
            $result['status']=$arr['0']->status;
            

        }else{

            $result['id']='';
            $result['ctype']=0;
            $result['hostel']=0;
            $result['fname']='';
            $result['lname']='';
            $result['mobile']='';
            $result['email']='';
            $result['branchoffice']='';
            $result['worklocation']='';
            $result['aadhar']='';
            $result['employmentstatus']='';
            $result['status']='';
            
        }
          $result['ctypes']=DB::table('cafeteriatype')->get();
           $result['hostels']=DB::table('hostels')->where('aid',$aid)->get();

   
        return view('nontechmanager.cafeteria.addcaterer',$result);
    }

    public function usersave(Request $request){

        if($request->post('id')>0){
            $model=vendors::find($request->post('id'));
            $msg="User Details Updated";
            $oldemail=$model->email;
            $oldmobile=$model->mobile;

        }else{
            $model=new vendors();
            $msg="User Details Inserted";
            $oldemail="";
            $oldmobile="";
        }

        if($oldemail!=$request->post('email')){
            $request->validate([
            'email'=>'required|unique:vendors,email'  
            ]);
        }
        if($oldmobile!=$request->post('mobile')){
            $request->validate([
            'mobile'=>'required|unique:vendors,mobile'   
            ]);
        }

        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
        $password = substr(str_shuffle($permitted_chars), 0, 5);
        $sesid=session()->get('NONTECH_MANAGER_ID');
        $aid=session()->get('NONTECH_MANAGER_ADMIN_ID');
        $model->aid=$aid;
        $model->mid=$sesid;
        $model->role=1;
        $model->cafeteriatype=$request->post('ctype');
        if($request->post('ctype')==2){
           $model->hostelid=$request->post('hostel');
        }else{
           $model->hostelid=0;
        }
        $model->fname=$request->post('fname');
        $model->lname=$request->post('lname');
        $model->mobile=$request->post('mobile');
        $model->email=$request->post('email');
        $model->branchoffice=$request->post('branchoffice');
        $model->worklocation=$request->post('worklocation');
        $model->aadhar=$request->post('aadhar');
        $model->employmentstatus=$request->post('employmentstatus');
        $model->status=1;
        if($oldemail!=$request->post('email')){
        $model->password=Hash::make($password);
        }
        $model->save();
        

        // if($oldemail!=$request->post('email')){
        //     $data=['fname'=>$request->fname,'lname'=>$request->lname,'email'=>$request->email,'mobile'=>$request->mobile,'password'=>$password];
        //     $user['to']=$request->email;
        //     Mail::send('mail.managers',$data,function($messages) use ($user){
        //     $messages->to($user['to']);
        //     $messages->subject('Login Credentials Of Your Account');
        //     });
        // }

        return redirect('nontech/manager/food/caterer');
    }

    public function status(Request $request,$status,$id)
    {
        $model=vendors::find($id);
        $model->status=$status;
        $model->save();
        $request->session()->flash('message','Role Updated');
        return redirect('nontech/manager/food/caterer');

    }

   
    public function delete(Request $request, $id)
    {   
      $a=DB::table('vendors')->where('id', $id)->delete();
      
      $request->session()->flash('message','Employee Deleted');
      return redirect('nontech/manager/food/caterer');
    }


}
