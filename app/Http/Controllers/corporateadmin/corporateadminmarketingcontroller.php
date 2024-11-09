<?php

namespace App\Http\Controllers\corporateadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\mocoldcalllist;
use Illuminate\Support\Facades\Hash;
use Redirect,Response;


class corporateadminmarketingcontroller extends Controller
{
    public function marketing(request $request){
        $result['data']=DB::table('userroles')->where('role',1)->get();
        $result['role']=1;
        return view('corporateadmin.marketingoverview',$result);
    }

    public function mteam(request $request,$id){
        $result['marketingofficer']=DB::table('userroles')
                        ->join('marketingofficers','userroles.id','marketingofficers.mmid')
                        ->where('marketingofficers.mmid',$id)
                        ->where('userroles.role',1)
                        ->select('marketingofficers.*','userroles.fname','userroles.lname')
                        ->get();
        $result['id']=$id;
        return view('corporateadmin.marketingteam',$result);
    }

    public function coldcalls($id){
        $result['rejected']=DB::table('mocoldcalllists')->where('moid',$id)->where('status',1)->get();
        $result['needhelp']=DB::table('mocoldcalllists')->where('moid',$id)->where('status',2)->get();
        $result['inprogress']=DB::table('mocoldcalllists')->where('moid',$id)->where('status',3)->get();
        $result['completed']=DB::table('mocoldcalllists')->where('moid',$id)->where('status',4)->get();
        return view('corporateadmin.marketingofficercoldcalllist',$result);
    }

    public function rejectreason($id){
      $result['data']=DB::table('mocoldcalllists')->where('id',$id)->get();
      $result['mm']=DB::table('userroles')->where('role',1)->get();
      return view('corporateadmin.marketingofficercoldcallrejectreason',$result);
    }

    public function mosave(Request $request){
      $a=DB::table('mocoldcalllists')->where('id',$request->post('id'))->get();
      $model=mocoldcalllist::find($request->post('id'));
      $model->moid=$request->post('mo');
      $model->mmreject=0;
      $model->mmrejectreason=0;
      $model->status=0;
      $model->save();
      return redirect('corporateadmin/marketingofficer/view/coldcalls/'.$a[0]->moid);
    }

    public  function getmarketingofficer(request $request)
    {
        $mmid = $request->post('id');
        $res = DB::table('marketingofficers')->where('mmid',$mmid)->get();
        echo $html='<option value="">Select</option>';
        foreach($res as $list){
        echo  $html='<option value="'.$list->id.'">'.$list->mofname.' '.$list->molname.'</option>';
        }
    }  

}
