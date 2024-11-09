<?php

namespace App\Http\Controllers\nontechmanager\infrastructure;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\hostelrooms;
use App\Models\hostelitems;
use App\Imports\HostelitemsImport;
use App\Imports\schoolitemsImport;
use App\Models\infraitems;
use App\Models\schoolitems;
use Redirect,Response;
use Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\schooldataExport;

class infrastructureschoolcontroller extends Controller
{
    public function addschoolitems(){
         $aid=session()->get('NONTECH_MANAGER_ADMIN_ID');
         $result['items']=DB::table('infraitems')->where('allocation',1)->get();
           $result['class']=DB::table('categories')->where('aid',$aid)->get();
           return view('nontechmanager.infrastructure.addschoolitems',$result);
    }
     public function getsections(){
       $id = $_GET['cid'];
         $res = DB::table('lmssections')
        ->where('classid', $id)
        ->get();
        return Response::json($res);
 
     }
     
     public function upload(Request $request){   
        $validator=validator::make($request->all(),[
          'excel'=>'required|max:5000|mimes:xlsx,xls,csv'
        ]);
        if($validator->passes()){
            $hostelid=$request->post('class');
            $roomid=$request->post('section');
            $itemid=$request->post('items');
            $facid=0;
            
             $a=DB::table('faculties')->where('classteacher',1)->where('classid',$hostelid)->where('sectionid',$roomid)->get();
            if(count($a)>0){
               $facid=$a[0]->id;
            }else{
                  $msg="Classteacher Not Available, Please Make Sure The Section Contains Classteacher .";
                  $request->session()->flash('failure',$msg);
                  return redirect('nontech/manager/infrastructure/add/schoolitems'); 
            }

            $mid=session()->get('NONTECH_MANAGER_ID');
            $aid=session()->get('NONTECH_MANAGER_ADMIN_ID');
            Excel::import(new schoolitemsImport($hostelid,$roomid,$itemid,$aid,$mid,$facid),request()->file('excel')->store('temp'));
             
            $msg="Items Uploaded Successfully";
            $request->session()->flash('success',$msg);
            return redirect('nontech/manager/infrastructure/school/info'); 

        }else{
        return redirect()->back()->with(['errors'=>$validator->errors()->all()]);
        }
    }

    public function editschoolitem($id){
         $mid=session()->get('NONTECH_MANAGER_ID');
         $aid=session()->get('NONTECH_MANAGER_ADMIN_ID');
        $result['data']=DB::table('schoolitems')->where('id',$id)->get();
          $result['items']=DB::table('infraitems')->where('allocation',1)->get();
       $result['class']=DB::table('categories')->where('aid',$aid)->get();
        return view('nontechmanager.infrastructure.editschoolitem',$result);
    }

   public function savedetails(Request $request){
      
      $model=schoolitems::find($request->id);
      $model->classid=$request->class;
      $model->sectionid=$request->section;
      $model->itemid=$request->items;
      $model->itemcode=$request->itemcode;
      $model->itemno=$request->itemno;
      $model->save();

      return redirect('nontech/manager/infrastructure/school/info');
   }

   public function info()
            {
                 $aid=session()->get('NONTECH_MANAGER_ADMIN_ID');
                    $result['items']=DB::table('infraitems')->where('allocation',1)->get();
                   $result['class']=DB::table('categories')->where('aid',$aid)->get();
                   $result['data']=DB::table('schoolitems')
                         ->join('categories','schoolitems.classid','categories.id')
                         ->join('lmssections','schoolitems.sectionid','lmssections.id')
                         ->join('infraitems','schoolitems.itemid','infraitems.id')
                         ->where('schoolitems.aid',$aid)
                         ->select('schoolitems.*','categories.categories','lmssections.section','infraitems.infraitem')->get();
                    $result['mid']=$id;
                    return view('nontechmanager.infrastructure.school',$result);
                
            }


     public function filter(Request $request){
          $id=session()->get('NONTECH_MANAGER_ID');
         $aid=session()->get('NONTECH_MANAGER_ADMIN_ID');
         $result['items']=DB::table('infraitems')->where('allocation',1)->get();
        $result['class']=DB::table('categories')->where('aid',$aid)->get();
                $result['data']=DB::table('schoolitems')
                          ->join('categories','schoolitems.classid','categories.id')
                          ->join('lmssections','schoolitems.sectionid','lmssections.id')
                         ->join('infraitems','schoolitems.itemid','infraitems.id')
                         ->where('schoolitems.mid',$id)
                         ->where('schoolitems.classid',$request->class)
                         ->where('schoolitems.sectionid',$request->section)
                         ->where('schoolitems.itemid',$request->item)
                         ->select('schoolitems.*','categories.categories','lmssections.section','infraitems.infraitem')->get();
        $result['mid']=$id;

        return view('nontechmanager.infrastructure.school',$result);
    }


    public function schoolexport(request $request,$mid){
        $name='School Infra List';
        return Excel::download(new schooldataExport($mid), $name.'.xlsx'); 
    }

}
