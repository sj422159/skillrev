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
        $aid = session()->get('Controller_ADMIN_ID');
        if (!$controller_id) {
            return redirect()->route('login');
        }
        

    $result['qtext'] = DB::table('questionbanks')->where('Controller_ID', $controller_id)->get();
    $result['assesmentname'] = DB::table('assesments')->where('Controller_ID', $controller_id)->get();
    $result['image']=controllers::where('id',$controller_id)->get();
     // Fetch all training types
     $result['trainingtype'] = DB::table('trainingtypes')->get();

     // Iterate through the training types and add dynamic properties
     foreach ($result['trainingtype'] as $trainingType) {
         // Fetch assigned count
         $assigned = DB::table('studentassignations')
             ->where('trainingtype', $trainingType->id)
             ->where('cyclestatus', 1)
             ->where('aid', $aid)
             ->count();
 
         // Fetch attended count
         $attended = DB::table('studentassignations')
             ->where('trainingtype', $trainingType->id)
             ->where('cyclestatus', 2)
             ->where('aid', $aid)
             ->count();
 
         // Fetch completed count
         $completed = DB::table('studentassignations')
             ->where('trainingtype', $trainingType->id)
             ->where('cyclestatus', '>', 2)
             ->where('aid', $aid)
             ->count();
 
         // Assign dynamic properties to the training type object
         $trainingType->assigned = $assigned;
         $trainingType->attended = $attended;
         $trainingType->completed = $completed;
     }
 
        return view('controller.exam.edashboard', $result);
    }
    
}
