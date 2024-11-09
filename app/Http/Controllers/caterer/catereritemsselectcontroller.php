<?php

namespace App\Http\Controllers\caterer;

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
use App\Models\hostelmenu;
use App\Models\schoolmenu;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Hash;

class catereritemsselectcontroller extends Controller
{
    public function index(){
        $sesid=session()->get('CATERER_ID');
        $aid=session()->get('CATERER_ADMIN_ID');
        $mid=session()->get('CATERER_MANAGER_ID');
        
        $result['data']=DB::table('fooditems')
                           ->join('foodcategories','fooditems.foodcat','foodcategories.id')
                           ->join('foodpricetypes','fooditems.pricetype','foodpricetypes.id')
                           ->where('fooditems.aid',$aid)->where('fooditems.mid',$mid)->select('fooditems.*','foodcategories.foodcategory','foodpricetypes.ptype')->get();
        $check=DB::table('schoolmenus')->where('catererid',$sesid)->get();
        $result['check']=[];
        for($i=0;$i<count($check);$i++){
            $result['check'][$i]=$check[$i]->fitemid;
        }
        $result['price']=array(array("val"=>"0","type"=> "Increase By 10%"),
            array("val"=>"1","type"=>"Same Price"),array("val"=>2,"type"=>"Decrease By 10%"));

        return view('caterer.selectfooditems',$result);
    }

    public function hostelitems(){
        $sesid=session()->get('CATERER_ID');
        $aid=session()->get('CATERER_ADMIN_ID');
        $mid=session()->get('CATERER_MANAGER_ID');
       
        $result['days']=array(
                        array("day"=>"1","name"=>"MONDAY"),array("day"=>"2","name"=>"TUESDAY"),
                        array("day"=>"3","name"=>"WEDNESDAY"),array("day"=>"4","name"=>"THURSDAY"),
                        array("day"=>"5","name"=>"FRIDAY"),array("day"=>"6","name"=>"SATURDAY"),
                        array("day"=>"7","name"=>"SUNDAY")
                    );
        $result['data']=DB::table('fooditems')
                           ->join('foodcategories','fooditems.foodcat','foodcategories.id')
                           ->join('foodpricetypes','fooditems.pricetype','foodpricetypes.id')
                           ->where('fooditems.aid',$aid)->where('fooditems.mid',$mid)->select('fooditems.*','foodcategories.foodcategory','foodpricetypes.ptype')->get();
       

        return view('caterer.hostelfooditems',$result);
    }

    public function addhostelmenu(request $request){

        $sesid=session()->get('CATERER_ID');
        $aid=session()->get('CATERER_ADMIN_ID');
        $mid=session()->get('CATERER_MANAGER_ID');
        $hid=session()->get('CATERER_HOSTELID');
        $id=$request->post('id');
        $day=$request->post('days');

        
          $data=DB::table('fooditems')->where('id',$id)->get();
          $model=new hostelmenu();
          $model->aid=$aid;
          $model->catererid=$sesid;
          $model->dayid=$day;
          $model->hostelid=$hid;
          $model->fitemid=$id;
          $model->hstatus=1;
          $model->save();


          return redirect('vendor/caterer/hostel/items');    

    }

     public function addschoolmenu(request $request){

        $sesid=session()->get('CATERER_ID');
        $aid=session()->get('CATERER_ADMIN_ID');
        $mid=session()->get('CATERER_MANAGER_ID');
        $id=$request->post('id');
        $type=$request->post('catererprice');
         $data=DB::table('fooditems')->where('id',$id)->get();
         $updatedprice=0;
        if($type==0){
          $updatedprice=(int)$data[0]->price+(((int)$data[0]->price*10)/100);
        }else if($type==1){
          $updatedprice=(int)$data[0]->price;
        }else{
          $updatedprice=(int)$data[0]->price-(((int)$data[0]->price*10)/100);
        }

        
         
          $model=new schoolmenu();
          $model->aid=$aid;
          $model->catererid=$sesid;
          $model->fitemid=$id;
          $model->price=$data[0]->price;
          $model->catererpricetype=$type;
          $model->catererprice=$updatedprice;
          $model->sstatus=1;
          $model->save();


          return redirect('vendor/caterer/select/fooditems');
        

    }

    public function menu(){
        $sesid=session()->get('CATERER_ID');
        $data=DB::table('vendors')->where('id',$sesid)->get();
        $result['check']=[];
        for ($i=1; $i<=7 ; $i++) { 
            $data1= DB::table('hostelmenus')
                    ->join('fooditems','hostelmenus.fitemid','fooditems.id')
                    ->join('foodcategories','fooditems.foodcat','foodcategories.id')
                    ->where('dayid',$i)
                    ->where('fooditems.foodcat',1)
                    ->where('hostelid',$data[0]->hostelid)
                    ->where('catererid',$sesid)
                    ->select('hostelmenus.*','fooditems.fooditems','foodcategories.foodcategory')
                    ->get();
            $data2= DB::table('hostelmenus')
                    ->join('fooditems','hostelmenus.fitemid','fooditems.id')
                    ->join('foodcategories','fooditems.foodcat','foodcategories.id')
                    ->where('dayid',$i)
                    ->where('fooditems.foodcat',2)
                    ->where('hostelid',$data[0]->hostelid)
                    ->where('catererid',$sesid)
                    ->select('hostelmenus.*','fooditems.fooditems','foodcategories.foodcategory')
                    ->get();
            $data4= DB::table('hostelmenus')
                    ->join('fooditems','hostelmenus.fitemid','fooditems.id')
                    ->join('foodcategories','fooditems.foodcat','foodcategories.id')
                    ->where('dayid',$i)
                    ->where('fooditems.foodcat',4)
                    ->where('hostelid',$data[0]->hostelid)
                    ->where('catererid',$sesid)
                    ->select('hostelmenus.*','fooditems.fooditems','foodcategories.foodcategory')
                    ->get();
            $data6= DB::table('hostelmenus')
                    ->join('fooditems','hostelmenus.fitemid','fooditems.id')
                    ->join('foodcategories','fooditems.foodcat','foodcategories.id')
                    ->where('dayid',$i)
                    ->where('fooditems.foodcat',6)
                    ->where('hostelid',$data[0]->hostelid)
                    ->where('catererid',$sesid)
                    ->select('hostelmenus.*','fooditems.fooditems','foodcategories.foodcategory')
                    ->get();

            if (count($data1)>0) {
              $result['check'][$i][0]=1;
            }else {
                $result['check'][$i][0]=0;
            } 

            if (count($data2)>0) {
                $result['check'][$i][1]=1;
            }else {
                $result['check'][$i][1]=0;
            } 

            if (count($data4)>0) {
                $result['check'][$i][2]=1;
            }else {
                $result['check'][$i][2]=0;
            } 

            if (count($data6)>0) {
                $result['check'][$i][3]=1;
            }else {
                $result['check'][$i][3]=0;
            } 

        }

        return view('caterer.hostelmenu',$result);
    }

    public function getdata(){
        $sesid=session()->get('CATERER_ID');
        $data=DB::table('vendors')->where('id',$sesid)->get();
        $id=$_GET['day'];
        $cat=$_GET['cat'];
        $res=DB::table('hostelmenus')
            ->join('fooditems','hostelmenus.fitemid','fooditems.id')
            ->join('foodcategories','fooditems.foodcat','foodcategories.id')
            ->where('dayid',$id)
            ->where('fooditems.foodcat',$cat)
            ->where('hostelid',$data[0]->hostelid)
            ->where('catererid',$sesid)
            ->select('hostelmenus.*','fooditems.fooditems','foodcategories.foodcategory')
            ->get();
        return Response::json($res);
    }

    public function schoolmenu(){
        $hid=session()->get('CATERER_HOSTELID'); 
        $sesid=session()->get('CATERER_ID');
        $result['data']=DB::table('schoolmenus')
                        ->join('fooditems','schoolmenus.fitemid','fooditems.id')
                        ->join('foodcategories','fooditems.foodcat','foodcategories.id')
                        ->join('foodpricetypes','fooditems.pricetype','foodpricetypes.id')
                        ->where('catererid',$sesid)
                        ->select('fooditems.fooditems','foodcategories.foodcategory','foodpricetypes.ptype','schoolmenus.*')
                        ->get();
        return view('caterer.schoolmenu',$result); 
    }

    public function delete($id){
        $model=schoolmenu::find($id);
        $model->delete();
        return redirect('vendor/caterer/school/menu');
    }






}
