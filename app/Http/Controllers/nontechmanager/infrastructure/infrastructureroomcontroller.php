<?php

namespace App\Http\Controllers\nontechmanager\infrastructure;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\hostelrooms;
use App\Models\infraitems;
use Redirect,Response;

class infrastructureroomcontroller extends Controller
{
     public function items(Request $request){
         $sesid=session()->get('NONTECH_MANAGER_ID');
        $result['items']=DB::table('infraitems')
                         ->get();
        return view('nontechmanager.infrastructure.items',$result);
    }

     public function additems(Request $request,$id=""){  
      $aid=session()->get('NONTECH_MANAGER_ADMIN_ID');   
        if($id>0){
            $arr=infraitems::where(['id'=>$id])->get();
            $result['id']=$arr['0']->id;
           
            $result['infraitem']=$arr['0']->infraitem;
            
        }
        else{
            $result['id']='';
          
            $result['infraitem']='';
            
        }
       
        return view("nontechmanager.infrastructure.additems",$result);
    }



     public function saveitems(Request $request){
        $sesid=session()->get('NONTECH_MANAGER_ID');
        $aid=session()->get('NONTECH_MANAGER_ADMIN_ID');


        if($request->post('id')>0){
           
                $model=infraitems::find($request->post('id'));
                $model->aid=$aid;
                $model->mid=$sesid;
                $model->infraitem=$request->post('infraitem');
             
                $model->save();
                $request->session()->flash('success','Items Updated');
            }else{
                $model=new infraitems();
                $model->aid=$aid;
                $model->mid=$sesid;
                 $model->infraitem=$request->post('infraitem');
                $model->save();
                $request->session()->flash('success','Item Added');
            }
                return redirect('nontech/manager/infrastructure/items');
            }
}
