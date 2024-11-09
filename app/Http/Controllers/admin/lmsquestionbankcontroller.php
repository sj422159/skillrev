<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Imports\questionsImport;
use Validator;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use App\Models\questionbank;
use Redirect,Response;

class lmsquestionbankcontroller extends Controller
{
    public function examview($id){
        $result['data']=DB::table('questionbanks')->where('id',$id)->get();
        return view('admin.viewquestion',$result);
    }

    public function questions(Request $request) {
        $aid=session()->get('ADMIN_ID');
        $result['categories']=DB::table('categories')->where('aid',$aid)->get();
        $result['categoryid']='';
        $result['domainid']='';
        $result['skillsetid']='';
        $result['skillattributeid']='';
        $result['data']=[]; 
        return view('admin.questions',$result);
    }

    public function questionsbysa(Request $request){
        $aid=session()->get('ADMIN_ID');
        $domain=$request->post('domain');
        $skillset=$request->post('skillset');
        $skillattribute=$request->post('skillattribute');
        $result['domainid']=$domain;
        $result['skillsetid']=$skillset;
        $result['skillattributeid']=$skillattribute;
        $result['categories']=DB::table('categories')->where('aid',$aid)->get();
        $result['categoryid']=$request->post('category');
        $result['data']=DB::table('questionbanks')
        ->join('skillattributes', 'questionbanks.skillattribute' , '=' , 'skillattributes.id')
        ->where(['questionbanks.skillattribute'=>$skillattribute])
        ->select('questionbanks.id', 'skillattributes.skillattribute', 'questionbanks.qtext','questionbanks.qtype','questionbanks.qstatus')
        ->get(); 
        return view('admin.questions',$result); 
    }

    public function add(){
        $aid=session()->get('ADMIN_ID');
        $result['category']=DB::table('categories')->where('aid',$aid)->get();
        return view ('admin.uploadquestion',$result);
    }

    public function upload(Request $request){   
        $validator=validator::make($request->all(),[
          'excel'=>'required|max:5000|mimes:xlsx,xls,csv'
        ]);
        if($validator->passes()){
            $skill_attr=$request->post('skillattribute');
            $aid=session()->get('ADMIN_ID');
            Excel::import(new questionsImport($skill_attr,$aid),request()->file('excel')->store('temp'));
             
            $msg="Questions Uploaded Successfully";
            $request->session()->flash('success',$msg);
            return redirect('admin/questions'); 

        }else{
        return redirect()->back()->with(['errors'=>$validator->errors()->all()]);
        }
    }

    public function editQuestion(Request $request,$id){
        $result['questiontype']=DB::table('questiontypes')->get();
        $resarr=questionbank::where(['id'=>$id])->get();
        $result['id']=$resarr['0']->id;
        $result['qtype']=$resarr['0']->qtype;
        $result['question']=$resarr['0']->qtext;
        $result['choice1']=$resarr['0']->choice1;
        $result['choice2']=$resarr['0']->choice2;
        $result['choice3']=$resarr['0']->choice3;
        $result['choice4']=$resarr['0']->choice4;
        $result['RightChoices']=$resarr['0']->RightChoices;
        $result['qimage']=$resarr['0']->qimage;
        $result['choice1image']=$resarr['0']->choice1image;
        $result['choice2image']=$resarr['0']->choice2image;
        $result['choice3image']=$resarr['0']->choice3image;
        $result['choice4image']=$resarr['0']->choice4image;
        $result['difficultylevel']=$resarr['0']->difficultylevel;
        return view('admin.editquestion',$result);
     }

    public function updateQuestion(Request $request){
      $model=questionbank::find($request->post('id'));
      $model->qtype=$request->post('qtype');
      $model->qtext=$request->post('qtext');
      $model->choice1=$request->post('choice1');
      $model->choice2=$request->post('choice2');
      $model->choice3=$request->post('choice3');
      $model->choice4=$request->post('choice4');
      $model->RightChoices=$request->post('rightchoice');
      $model->difficultylevel=$request->post('difficultylevel');

       if($request->hasfile('qimage')){  
            $image=$request->file('qimage');
            $ext=$image->extension();
            $image_name=rand(10,10000).'.'.$ext;
            $image->move(public_path().'/questionbankimages',$image_name);
            $model->qimage=$image_name;
            echo 1;
         }

         if($request->hasfile('choice1image')){  
            $image=$request->file('choice1image');
            $ext=$image->extension();
            $image_name=rand(10,10000).'.'.$ext;
            $image->move(public_path().'/questionbankimages',$image_name);
            $model->choice1image=$image_name;
            echo 2;
         }

         if($request->hasfile('choice2image')){  
            $image=$request->file('choice2image');
            $ext=$image->extension();
            $image_name=rand(10,10000).'.'.$ext;
            $image->move(public_path().'/questionbankimages',$image_name);
            $model->choice2image=$image_name;
            echo 3;

         }


         if($request->hasfile('choice3image')){  
            $image=$request->file('choice3image');
            $ext=$image->extension();
            $image_name=rand(10,10000).'.'.$ext;
            $image->move(public_path().'/questionbankimages',$image_name);
            $model->choice3image=$image_name;
            echo 4;
         }

        if($request->hasfile('choice4image')){  
            $image=$request->file('choice4image');
            $ext=$image->extension();
            $image_name=rand(10,10000).'.'.$ext;
            $image->move(public_path().'/questionbankimages',$image_name);
            $model->choice4image=$image_name;
            echo 5;
        }

       $model->qstatus="1"; 
      $model->save();
      $msg="Question updated";
      $request->session()->flash('success',$msg);
      return redirect('admin/questions');
    }

    public function deleteQuestion(Request $request,$id){
        $model=questionbank::find($id);
        $model->delete();
        $request->session()->flash('success','Question Deleted');
        return redirect('admin/questions');
    }

    public  function questionbankgetcategories(request $request){
        $aid=session()->get('ADMIN_ID');
        $cid = $request->post('cid');
        $a=DB::table('groups')->where('id',$cid)->get();
        if($a[0]->gtype==2){
        $state = DB::table('categories')->where('aid',$aid)->get();
        }else{
        $state = DB::table('categories')->where('groupid',$cid)->get();
        }  
        echo $html='<option value="">Select</option>';
        foreach($state as $list){
        echo  $html='<option value="'.$list->id.'">'.$list->categories.'</option>';
        }
    } 

    public  function questionbankgetdomains(request $request){
        $aid=session()->get('ADMIN_ID');
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
        $sid = $request->post('sid');
        $city = DB::table('skillsets')->where('domain', $sid)->get();
        echo $html='<option value="">Select</option>';
        foreach($city as $list){
        echo  $html='<option value="'.$list->id.'">'.$list->skillset.'</option>';
        }
    } 

    public  function questionbankgetskillattributes(request $request){
        $gid = $request->post('gid');
        $b = DB::table('skillattributes')->where('skillset', $gid)->get();
        echo  $html='<option value="">Select</option>';
        foreach($b as $list){
        echo  $html='<option value="'.$list->id.'">'.$list->skillattribute.'</option>';
        }
    } 

    public function mismatch(){
        $result['que']=DB::table('questionbanks')
                         ->join('skillattributes','questionbanks.skillattribute','=','skillattributes.id')
                         ->join('skillsets','skillattributes.skillset','=','skillsets.id')
                         ->join('domains','skillattributes.domain','=','domains.id')
                         ->select('questionbanks.*','skillattributes.skillattribute','skillsets.skillset','domains.domain')->get();
        return view('admin.questionmismatch',$result);
    }

    public function improper(){
        $result['que']=DB::table('questionbanks')
                         ->join('skillattributes','questionbanks.skillattribute','=','skillattributes.id')
                         ->join('skillsets','skillattributes.skillset','=','skillsets.id')
                         ->join('domains','skillattributes.domain','=','domains.id')
                         ->select('questionbanks.*','skillattributes.skillattribute','skillsets.skillset','domains.domain')->get();
        return view('admin.improperquestion',$result);
    }    
}