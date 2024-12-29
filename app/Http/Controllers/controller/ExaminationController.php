<?php

namespace App\Http\Controllers\controller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // For authentication
use Illuminate\Support\Facades\Hash; // For password hashing

    
use Illuminate\Support\Facades\DB;
use App\Models\controllers;

class ExaminationController extends Controller
{



    public function edashboard()
    {
        $controller_id = session()->get('Controller_ID');
        if (!$controller_id) {
            return redirect()->route('login');
        }
        

    $result['qtext'] = DB::table('questionbanks')->where('Controller_ID', $controller_id)->get();
    $result['assesmentname'] = DB::table('assesments')->where('Controller_ID', $controller_id)->get();
    $result['image']=controllers::where('id',$controller_id)->get();
        return view('controller.exam.edashboard', $result);
    }
    
}
