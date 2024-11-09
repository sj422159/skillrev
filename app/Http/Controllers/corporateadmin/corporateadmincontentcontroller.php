<?php

namespace App\Http\Controllers\corporateadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\admin;
use App\Models\homepageEvents;
use Illuminate\Support\Facades\DB;
use Redirect;
use Mail;
use App\Models\contentskillattribute;


class corporateadmincontentcontroller extends Controller
{
    
    public function index(){
    $result['schools']=DB::table('admins')->where('status',1)->get();
    $result['school']=0;
    $result['category']=[];
    return view('corporateadmin.content',$result);
    }
    public function fetch(request $request){
       $result['schools']=DB::table('admins')->where('status',1)->get();
       $result['school']=$request->post('school');
       $result['category']=DB::table('categories')->where('aid',$request->post('school'))->get();
     return view('corporateadmin.content',$result);
    }

     public  function questionbankgetdomains(request $request){
        $aid=$request->post('aid');
        $cid = $request->post('cid');
        $a=DB::table('categories')->where('id',$cid)->get();
        $b=DB::table('groups')->where('id',$a[0]->groupid)->get();
        if($b[0]->gtype==2){
        $state = DB::table('domains')->where('category', $cid)->where('stype',2)->get();
        }else{
        $state = DB::table('domains')->where('category', $cid)->get();
        } 

        echo $html='<option value="">Select </option>';
        foreach($state as $list){
        echo  $html='<option value="'.$list->id.'">'.$list->domain.'</option>';
        }
    } 

    public  function questionbankgetskillsets(request $request){
         $aid=$request->post('aid');
        $sid = $request->post('sid');
        $city = DB::table('skillsets')->where('domain', $sid)->get();
        echo $html='<option value="">Select</option>';
        foreach($city as $list){
        echo  $html='<option value="'.$list->id.'">'.$list->skillset.'</option>';
        }
    } 

      public  function getskillattribute(request $request){
        $gid = $request->post('gid');
        $b = DB::table('skillattributes')->where('skillset', $gid)->get();
        echo  $html='<option value="">Select</option>';
        foreach($b as $list){
        echo  $html='<option value="'.$list->id.'">'.$list->skillattribute.'</option>';
        }
    } 

    public function getContent(request $request){
      $mod = $request->post('mod');
      return $result['data']=DB::table('contentskillattributes')
                        ->join('skillattributes','skillattributes.id','contentskillattributes.skillattribute')
                        ->where('contentskillattributes.skillset',$mod)
                        ->select('skillattributes.skillattribute','contentskillattributes.id')
                        ->get();
        
        return Response::json($result['data']);

    }
    public function view($id,$school){
         $arr=contentskillattribute::where(['id'=>$id])->get();
            $result['id']=$arr['0']->id;
            $result['category']=$arr['0']->category;
            $result['domain']=$arr['0']->domain;
            $result['skillset']=$arr['0']->skillset;
            $result['skillattribute']=$arr['0']->skillattribute;
            $result['type1']=$arr['0']->type1;
            $result['content1']=$arr['0']->content1;
            $result['type2']=$arr['0']->type2;
            $result['content2']=$arr['0']->content2;
            $result['type3']=$arr['0']->type3;
            $result['content3']=$arr['0']->content3;
            $result['type4']=$arr['0']->type4;
            $result['content4']=$arr['0']->content4;
         $result['skill']=DB::table('skillattributes')->where('id',$result['skillattribute'])->get();


        $result['categories']=DB::table('categories')->where('aid',$school)->get();
        $result['contenttypes1']=DB::table('contenttypes')->where('id',1)->get();
        $result['contenttypes2']=DB::table('contenttypes')->where('id',2)->get();
        $result['contenttypes3']=DB::table('contenttypes')->where('id',3)->get();
        $result['contenttypes4']=DB::table('contenttypes')->where('id',4)->get();
        return view('corporateadmin.viewcontent',$result);
    }

}
