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

class infrastruturecafecontroller extends Controller
{
    public function addcafeitems(){
         $aid=session()->get('NONTECH_MANAGER_ADMIN_ID');
         $result['items']=DB::table('infraitems')->get();
           $result['class']=DB::table('categories')->where('aid',$aid)->get();
           return view('nontechmanager.infrastructure.addschoolitems',$result);
    }
}
