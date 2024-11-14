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

class adminattendanceanalyticcontroller extends Controller
{
  public function index() {
    // Determine if the logged-in user is an admin or a controller
    $aid = session()->get('ADMIN_ID'); // Admin ID
    $controller_id = session()->get('Controller_ID'); // Controller ID

    // Fetching classes based on the logged-in user's ID
    $result['class'] = DB::table('categories')
        ->where('aid', $aid)
        ->orWhere('Controller_ID', $controller_id)
        ->get();

    // Initialize result data
    $result['cl'] = 0;
    $result['section'] = 0;
    $result['present'] = 0;
    $result['absent'] = 0;
    $result['day'] = 0;

    // Return the view with the results
    return view("admin.attendenceanalytics", $result);
}


public function fetch(request $request) {
  // Determine if the logged-in user is an admin or a controller
  $aid = session()->get('ADMIN_ID'); // Admin ID
  $controller_id = session()->get('Controller_ID'); // Controller ID

  // Fetching classes based on the logged-in user's ID
  $result['class'] = DB::table('categories')
      ->where('aid', $aid)
      ->orWhere('Controller_ID', $controller_id)
      ->get();

  // Initialize result data
  $result['cl'] = $request->class;
  $result['section'] = $request->section;
  $result['present'] = 0;
  $result['absent'] = 0;
  $result['day'] = 0;

  // Fetch attendance data filtered by class and section
  $data = DB::table('attendances')
      ->where('classid', $request->class)
      ->where('sectionid', $request->section)
      ->get();

  if (count($data) > 0) {
      $result['day'] = count($data);
      // Count present and absent students
      for ($i = 0; $i < count($data); $i++) {
          $a = explode("##", $data[$i]->attendance);
          for ($k = 0; $k < count($a); $k++) {
              if ($a[$k] == "Absent") {
                  $result['absent']++;
              } else {
                  $result['present']++;
              }
          }
      }
  } else {
      $result['present'] = 0;
      $result['absent'] = 0;
      $result['day'] = 0;
  }

  // List of months for selection
  $result['months'] = Array(
      Array("id" => "01", "mon" => "January"), Array("id" => "02", "mon" => "February"),
      Array("id" => "03", "mon" => "March"), Array("id" => "04", "mon" => "April"),
      Array("id" => "05", "mon" => "May"), Array("id" => "06", "mon" => "June"),
      Array("id" => "07", "mon" => "July"), Array("id" => "08", "mon" => "August"),
      Array("id" => "09", "mon" => "September"), Array("id" => "10", "mon" => "October"),
      Array("id" => "11", "mon" => "November"), Array("id" => "12", "mon" => "December")
  );

  // Return the view with the results
  return view('admin.attendenceanalytics', $result);
}


public function datewise(request $request) {
  // Determine if the logged-in user is an admin or a controller
  $aid = session()->get('ADMIN_ID'); // Admin ID
  $controller_id = session()->get('Controller_ID'); // Controller ID

  // Get request parameters
  $month = $request->post('month');
  $class = $request->post('cl');
  $section = $request->post('section');

  // Fetch attendance data filtered by class, section, and month
  $data = DB::table('attendances')
      ->where('classid', $class)
      ->where('sectionid', $section)
      ->where('month', $month)
      ->where(function($query) use ($aid, $controller_id) {
          // Allow data access based on admin or controller ID
          $query->where('aid', $aid)
                ->orWhere('Controller_ID', $controller_id);
      })
      ->get();

  // Initialize result array for attendance status
  $result['data'][0] = 0; // Present
  $result['data'][1] = 0; // Absent
  $result['data'][3] = 0; // Total records

  // Process attendance data if any is found
  if (count($data) > 0) {
      for ($i = 0; $i < count($data); $i++) {
          $a = explode("##", $data[$i]->attendance); // Split attendance data
          for ($k = 0; $k < count($a); $k++) {
              if ($a[$k] == "Absent") {
                  $result['data'][1]++; // Increment absent count
              } else {
                  $result['data'][0]++; // Increment present count
              }
          }
      }
  }

  // Set total number of records
  $result['data'][3] = count($data);

  // Return the result as JSON response
  return Response::json($result['data']);
}

}
