<?php

namespace App\Http\Controllers\faculty;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\skipmeals;
use App\Models\contentskillattribute;
use App\Models\foodfeedback;
use Redirect,Response;

class FacultyContentController extends Controller
{
    public function contentska(Request $request){
        $aid=session()->get('FACULTY_ADMIN_ID');
        $sid=session()->get('FACULTY_ID');
        $class = DB::table('faculties')->where('id', $sid)->first();
        $subjectIds = explode('##', $class->subjectid);
        $domain = DB::table('domains')->whereIn('id', $subjectIds)->get();
        $categoryIds = $domain->pluck('category')->toArray();
        $category = DB::table('categories')->where('aid', $aid)->whereIn('id', $categoryIds)->get();
        $result['category'] = $category;
        $result['data']=[];
        return view('faculty.contentskillattribute',$result); 
    }

    public function contentskabyskillset(Request $request)
    {
        $skillset = $request->post('skillset');
        $standard = $request->post('category'); // Posted category ID
        $domain = $request->post('domain');
    
        $aid = session()->get('FACULTY_ADMIN_ID');
        $sid = session()->get('FACULTY_ID');
    
        $class = DB::table('faculties')->where('id', $sid)->first();
        $subjectIds = explode('##', $class->subjectid);
        $domainData = DB::table('domains')->whereIn('id', $subjectIds)->get();
    
        $categoryIds = $domainData->pluck('category')->toArray();
        $category = DB::table('categories')
            ->where('aid', $aid)
            ->whereIn('id', $categoryIds)
            ->get();
    
        // Fetch the category name as a string for the prefilled dropdown
        $categorydetails = DB::table('categories')
            ->where('aid', $aid)
            ->where('id', $standard)
            ->value('categories'); // This returns a string
    
        $data = DB::table('contentskillattributes')
            ->join('skillattributes', 'skillattributes.id', '=', 'contentskillattributes.skillattribute')
            ->where('contentskillattributes.aid', $aid)
            ->where('contentskillattributes.skillset', $skillset)
            ->select(
                'skillattributes.skillattribute',
                'contentskillattributes.id',
                'contentskillattributes.type1',
                'contentskillattributes.content1',
                'contentskillattributes.type2',
                'contentskillattributes.content2',
                'contentskillattributes.type3',
                'contentskillattributes.content3',
                'contentskillattributes.type4',
                'contentskillattributes.content4'
            )
            ->get();
    
        $skillsetDetails = DB::table('skillsets')
            ->where('id', $skillset)
            ->select('skillset')
            ->first();
    
        $domainDetails = DB::table('domains')
            ->where('id', $domain)
            ->select('dname')
            ->first();
    
        $result = [
            'class' => $class,
            'category' => $category, // All categories for dropdown
            'data' => $data,
            'skillset' => $skillsetDetails->skillset ?? '', // Safe access
            'domain' => $domainDetails->dname ?? '',       // Safe access
            'standard' => $standard,                       // Posted category ID
            'categorydetails' => $categorydetails ?? '',   // Prefill dropdown with category name
        ];
    
        return view('faculty.contentskillattribute', $result);
    }
    
    
    
    

    public  function getdomain(request $request){
       
        $aid=session()->get('FACULTY_ADMIN_ID');
        $sid=session()->get('FACULTY_ID');
        $cid = $request->post('cid');
        $class = DB::table('faculties')->where('id', $sid)->first();
        $subjectIds = explode('##', $class->subjectid);
        $state = DB::table('domains')->whereIn('id', $subjectIds)->where('category', $cid)->get();
        echo $html='<option value="">Select </option>';
        foreach($state as $list){
        echo  $html='<option value="'.$list->id.'">'.$list->domain.'</option>';
        }
    } 

    public  function getskillset(request $request){

        $aid=session()->get('FACULTY_ADMIN_ID');
        $sesid=session()->get('FACULTY_ID');
        $sid = $request->post('sid');
        $class = DB::table('faculties')->where('id', $sesid)->first();
        $moduleIds = explode('##', $class->moduleid);
        $city = DB::table('skillsets')->whereIn('id', $moduleIds)->where('domain',$sid)->get();
        echo $html='<option value="">Select</option>';
        foreach($city as $list){
        echo  $html='<option value="'.$list->id.'">'.$list->skillset.'</option>';
        }
    } 
}