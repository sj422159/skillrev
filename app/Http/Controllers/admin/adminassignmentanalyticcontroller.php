<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\studentassignation;
use App\Models\studentbooking;
use App\Models\assesmentsections;
use App\Models\finalanswer;
use Redirect,Response;

class adminassignmentanalyticcontroller extends Controller
{
    public function index() {
        // Determine user type (admin or controller) and store the relevant ID
        $aid = session()->has('ADMIN_ID') ? session()->get('ADMIN_ID') : 0;
        $controller_id = session()->has('Controller_ID') ? session()->get('Controller_ID') : 0;
    
        // Fetch categories created by the logged-in admin or controller
        $result['class'] = DB::table('categories')
            ->where($aid ? 'aid' : 'controller_id', $aid ?: $controller_id)
            ->get();
    
        // Initialize result variables
        $result['cl'] = 0;
        $result['section'] = 0;
        $result['completed'] = 0;
        $result['notcompleted'] = 0;
        $result['data'] = [];
        $result['train'] = 0;
        $result['Name'] = "";
        $result['assignment'] = 0;
    
        // Return the view with filtered results
        return view('admin.assignmentanalytic', $result);
    }
    
    public function gettrainings() {
        // Determine user type (admin or controller) and store the relevant ID
        $aid = session()->has('ADMIN_ID') ? session()->get('ADMIN_ID') : 0;
        $controller_id = session()->has('Controller_ID') ? session()->get('Controller_ID') : 0;
    
        // Get parameters from the request
        $cls = $_GET['id'];
        $sec = $_GET['sec'];
    
        // Fetch trainings based on the user type and filter by the relevant ID
        $result = DB::table('studentassignations')
            ->join('trainings', 'studentassignations.trainingid', 'trainings.id')
            ->where('studentassignations.' . ($aid ? 'aid' : 'controller_id'), $aid ?: $controller_id)
            ->where('classid', $cls)
            ->where('sectionid', $sec)
            ->select('trainings.*')
            ->get();
    
        // Return the filtered result as JSON
        return Response::json($result);
    }
    

    public function fetch(Request $request) {
        // Determine user type (admin or controller) and store the relevant ID
        $aid = session()->has('ADMIN_ID') ? session()->get('ADMIN_ID') : 0;
        $controller_id = session()->has('Controller_ID') ? session()->get('Controller_ID') : 0;
    
        // Fetch categories based on the user type
        $result['class'] = DB::table('categories')
            ->where(($aid ? 'aid' : 'controller_id'), $aid ?: $controller_id)
            ->get();
    
        // Capture form data
        $result['cl'] = $request->post('class');
        $result['train'] = $request->post('training');
        $result['assignment'] = 0;
        $result['section'] = $request->post('section');
        $result['data'] = [];
    
        // Fetch assignations based on class, section, training, and user type
        $data = DB::table('studentassignations')
            ->where('classid', $request->post('class'))
            ->where('sectionid', $request->post('section'))
            ->where('trainingid', $request->post('training'))
            ->where(($aid ? 'aid' : 'controller_id'), $aid ?: $controller_id)
            ->get();
    
        // Check if there are any assignments for the given assignation ID
        if (count($data) > 0) {
            $data1 = DB::table('studentassignments')
                ->where('assignationid', $data[0]->id)
                ->get();
    
            if (count($data1) > 0) {
                $result['assignment'] = $data1[0]->id;
                $result['data'] = DB::table('studentassignmentbookings')
                    ->where('assignmentid', $data1[0]->id)
                    ->get();
    
                // Assignment information
                $result['Name'] = $data1[0]->assignmentname;
                $result['completed'] = 0;
                $result['notcompleted'] = 0;
    
                // Calculate completed and not completed counts
                foreach ($result['data'] as $item) {
                    if ($item->status == 4) {
                        $result['completed']++;
                    } else {
                        $result['notcompleted']++;
                    }
                }
            } else {
                // No assignment data found
                $result['data'] = [];
                $result['completed'] = 0;
                $result['notcompleted'] = 0;
                $result['Name'] = "";
            }
        }
    
        // Set select options for assignment status
        $result['select'] = [
            ["id" => "01", "data" => "Not Completed"],
            ["id" => "02", "data" => "Completed"],
        ];
    
        // Return the view with the result data
        return view('admin.assignmentanalytic', $result);
    }
    

    public function notcompleted() {
        // Retrieve the assignment ID from the request
        $assignment = $_GET['assignment'];
    
        // Initialize counters for each status
        $result['data'] = [0, 0, 0, 0];
    
        // Fetch data from studentassignmentbookings table based on assignment ID
        $data = DB::table('studentassignmentbookings')
            ->where('assignmentid', $assignment)
            ->get();
    
        // Loop through each booking and increment the respective counter based on status
        foreach ($data as $item) {
            switch ($item->status) {
                case 1:
                    $result['data'][0]++;
                    break;
                case 2:
                    $result['data'][1]++;
                    break;
                case 3:
                    $result['data'][2]++;
                    break;
                default:
                    $result['data'][3]++;
                    break;
            }
        }
    
        // Return the result as a JSON response
        return Response::json($result['data']);
    }
    
    public function completed() {
        // Retrieve the assignment ID from the request
        $assignment = $_GET['assignment'];
    
        // Initialize counters for each result category
        $result['data'] = [0, 0, 0, 0, 0];
    
        // Fetch data from studentassignmentbookings table based on assignment ID
        $data = DB::table('studentassignmentbookings')
            ->where('assignmentid', $assignment)
            ->get();
    
        // Loop through each booking and increment the respective counter based on result category
        foreach ($data as $item) {
            switch ($item->result) {
                case "Outstanding":
                    $result['data'][0]++;
                    break;
                case "Excellent":
                    $result['data'][1]++;
                    break;
                case "Very Good":
                    $result['data'][2]++;
                    break;
                case "Good":
                    $result['data'][3]++;
                    break;
                default:
                    $result['data'][4]++;
                    break;
            }
        }
    
        // Return the result as a JSON response
        return Response::json($result['data']);
    }
    
}
