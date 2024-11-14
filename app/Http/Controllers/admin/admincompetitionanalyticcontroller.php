<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Redirect,Response;

class admincompetitionanalyticcontroller extends Controller
{
    
    public function index() {
        // Get the session value for either ADMIN_ID or Controller_ID based on the user role
        $aid = session()->get('ADMIN_ID');  // For admin
        $controller_id = session()->get('Controller_ID');  // For controller
        
        // Initialize result array with default values
        $result['supervisors'] = DB::table('supervisors')
            ->where(function($query) use ($aid, $controller_id) {
                // Filter supervisors by aid (for admin) or Controller_ID (for controller)
                $query->where('aid', $aid)
                      ->orWhere('Controller_ID', $controller_id);
            })
            ->get();  // Fetch supervisors based on the filtered data
    
        $result['sup'] = 0;
        $result['competition'] = 0;
        $result['applied'] = 0;
        $result['notshortlisted'] = 0;
        $result['selected'] = 0;
        $result['completed'] = 0;
        $result['data'] = [];
    
        // Return the view with the populated result data
        return view('admin.competitionanalytic', $result);
    }
    

    public function fetch(request $request) {
        // Get the session value for either ADMIN_ID or Controller_ID based on the user role
        $aid = session()->get('ADMIN_ID');  // For admin
        $controller_id = session()->get('Controller_ID');  // For controller
    
        // Initialize result array with default values
        $result['supervisors'] = DB::table('supervisors')
            ->where(function($query) use ($aid, $controller_id) {
                // Filter supervisors by aid (for admin) or Controller_ID (for controller)
                $query->where('aid', $aid)
                      ->orWhere('Controller_ID', $controller_id);
            })
            ->get();  // Fetch supervisors based on the filtered data
    
        $result['sup'] = $request->post('supervisor');
        $result['competition'] = $request->post('competition');
        $result['applied'] = 0;
        $result['notshortlisted'] = 0;
        $result['selected'] = 0;
        $result['completed'] = 0;
    
        // Get the competition booking data based on the selected competition
        $result['data'] = DB::table('competitionbookings')
            ->where('competitionid', $result['competition'])
            ->get();  // Fetch competition bookings based on the competition ID
    
        // Count different statuses for competition bookings
        for ($i = 0; $i < count($result['data']); $i++) {
            if ($result['data'][$i]->competitionstatus == "1") {
                $result['applied']++;
            } elseif ($result['data'][$i]->competitionstatus == "2") {
                $result['notshortlisted']++;
            } elseif ($result['data'][$i]->competitionstatus == "3") {
                $result['selected']++;
            } elseif ($result['data'][$i]->competitionstatus == "4") {
                $result['completed']++;
            }
        }
    
        // Return the view with the populated result data
        return view('admin.competitionanalytic', $result);
    }
    

    public function getcompetition(){
        $id = $_GET['id'];
        $res = DB::table('competitions')->where('supid',$id)->get();
        return Response::json($res);
    }

}