<?php

namespace App\Http\Controllers\student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\skipmeals;
use App\Models\contentskillattribute;
use App\Models\foodfeedback;
use Redirect,Response;

class studentcontentcontroller extends Controller
{
    public function contentska(Request $request){
        $aid=session()->get('STUDENT_ADMIN_ID');
        $sid=session()->get('STUDENT_ID');
        $class=DB::table('students')->where('id',$sid)->get();
        $result['category']=DB::table('categories')->where('aid',$aid)->where('id',$class[0]->sclassid)->get();
        $result['data']=DB::table('contentskillattributes')
                        ->join('skillattributes','skillattributes.id','contentskillattributes.skillattribute')
                        ->where('contentskillattributes.aid',$aid)
                        ->select('skillattributes.skillattribute','contentskillattributes.id','contentskillattributes.type1','contentskillattributes.content1','contentskillattributes.type2','contentskillattributes.content2','contentskillattributes.type3','contentskillattributes.content3','contentskillattributes.type4','contentskillattributes.content4')
                        ->get();
        return view('student.contentskillattribute',$result); 
    }

    public function contentskabyskillset(Request $request){
        $skillset=$request->post('skillset');
        $aid=session()->get('STUDENT_ADMIN_ID');
        $sid=session()->get('STUDENT_ID');
        $class=DB::table('students')->where('id',$sid)->get();
        $result['category']=DB::table('categories')->where('aid',$aid)->where('id',$class[0]->sclassid)->get();
        $result['data']=DB::table('contentskillattributes')
                        ->join('skillattributes','skillattributes.id','contentskillattributes.skillattribute')
                        ->where('contentskillattributes.aid',$aid)
                        ->where('contentskillattributes.skillset',$skillset)
                        ->select('skillattributes.skillattribute','contentskillattributes.id','contentskillattributes.type1','contentskillattributes.content1','contentskillattributes.type2','contentskillattributes.content2','contentskillattributes.type3','contentskillattributes.content3','contentskillattributes.type4','contentskillattributes.content4')
                        ->get();
        return view('student.contentskillattribute',$result);
    }

    public  function getdomain(request $request){
        $cid = $request->post('cid');
        $state = DB::table('domains')->where('category', $cid)->get();
        echo $html='<option value="">Select </option>';
        foreach($state as $list){
        echo  $html='<option value="'.$list->id.'">'.$list->domain.'</option>';
        }
    } 

    public  function getskillset(request $request){
        $sid = $request->post('sid');
        $city = DB::table('skillsets')->where('domain', $sid)->get();
        echo $html='<option value="">Select</option>';
        foreach($city as $list){
        echo  $html='<option value="'.$list->id.'">'.$list->skillset.'</option>';
        }
    } 


    public function food(){
        $sid=session()->get('STUDENT_ID');
        $result['exist']=true;
        $result['hostelid']=0;
        $data=DB::table('hostelitems')->where('stu_id',$sid)->get();

        if(count($data)>0){
            $result['exist']=false;
            $result['hostelid']=$data[0]->hostelid;
        }

        $result['check']=[];
        $check=DB::table('skipmeals')->where('stu_id',$sid)->get();
        if(count($check)>0){
          for($i=0;$i<count($check);$i++){
            $result['check'][$i]=array("day"=>$check[$i]->dayid,"cat"=>$check[$i]->catid);
          }
        }else{
         $result['check']=array(array("day"=>"0","cat"=>"0"));
        }
        $result['che']=count($result['check']);


        $result['feedbackcheck']=[];
        $feedbackcheck=DB::table('foodfeedbacks')->where('stu_id',$sid)->get();
        if(count($feedbackcheck)>0){
          for($i=0;$i<count($feedbackcheck);$i++){
            $result['feedbackcheck'][$i]=array("day"=>$feedbackcheck[$i]->day);
          }
        }else{
         $result['feedbackcheck']=array(array("day"=>"0"));
        }
        $result['feedbackche']=count($result['feedbackcheck']);
                              
        $result['tommorowdate']=date('d-m-Y',strtotime('+1 days'));
        
        return view('student.foodtimetable',$result);
    }

    public function getdata(){

      $id = $_GET['day'];
      $cat= $_GET['cat'];
      $hostel=$_GET['hostel'];

      return $res = DB::table('hostelmenus')
             ->join('fooditems','hostelmenus.fitemid','fooditems.id')
            ->join('foodcategories','fooditems.foodcat','foodcategories.id')
             ->where('dayid',$id)
             ->where('fooditems.foodcat',$cat)
             ->where('hostelid', $hostel)
             ->select('hostelmenus.*','fooditems.fooditems','foodcategories.foodcategory')
             ->get();
        return Response::json($res);
    }

    public function skipmeal($day,$cat){
        $sid=session()->get('STUDENT_ID');
        $data=DB::table('hostelitems')->where('stu_id',$sid)->get();
        
        if ($day==1) {
            $dayname='monday this week';
        }
        else if ($day==2) {
            $dayname='tuesday this week';
        }
        else if ($day==3) {
            $dayname='wednesday this week';
        }
        else if ($day==4) {
            $dayname='thursday this week';
        }
        else if ($day==5) {
            $dayname='friday this week';
        }
        else if ($day==6) {
            $dayname='saturday this week';
        }
        else if ($day==7) {
            $dayname='sunday this week';
        }

        $date = date('d-m-Y', strtotime($dayname));
        
        $model=new skipmeals();
        $model->hostelid=$data[0]->hostelid;
        $model->dayid=$day;
        $model->catid=$cat;
        $model->stu_id=$sid;
        $model->skipday=$date;
        $model->save();

        return redirect('student/food/schedule');

    }

     public function undo($day,$cat){
          $sid=session()->get('STUDENT_ID');
           $data=DB::table('skipmeals')->where('stu_id',$sid)->where('dayid',$day)->where('catid',$cat)->delete();
        return redirect('student/food/schedule');

    }

    public function feedback(request $request){
        $sid=session()->get('STUDENT_ID');
        $aid=session()->get('STUDENT_ADMIN_ID');
        $data=DB::table('hostelitems')->where('stu_id',$sid)->get();
        $hostel=0;
        if(count($data)>0){
         $hostel=$data[0]->hostelid;
        }
        
        $day=$request->post('day');
        if ($day==1) {
            $dayname='monday this week';
        }
        else if ($day==2) {
            $dayname='tuesday this week';
        }
        else if ($day==3) {
            $dayname='wednesday this week';
        }
        else if ($day==4) {
            $dayname='thursday this week';
        }
        else if ($day==5) {
            $dayname='friday this week';
        }
        else if ($day==6) {
            $dayname='saturday this week';
        }
        else if ($day==7) {
            $dayname='sunday this week';
        }

        $date = date('d-m-Y', strtotime($dayname));

        $cater=DB::table('vendors')->where('role',1)->where('hostelid',$hostel)->get();
        $catererid=0;
        if(count($cater)){
           $catererid=$cater[0]->id;
        }


        $model=new foodfeedback();
        $model->aid=$aid;
        $model->stu_id=$sid;
        $model->hostelid=$hostel;
        $model->catererid=$catererid;
        $model->day=$day;
        $model->date=$date;
        $model->quantity=$request->quantity;
        $model->quality=$request->quality;
        $model->taste=$request->taste;
        $model->save();

        return redirect("student/food/schedule");
    }
}