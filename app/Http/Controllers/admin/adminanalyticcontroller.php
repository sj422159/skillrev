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

class adminanalyticcontroller extends Controller
{
  public function index() {
    // Check if admin or controller is logged in
    $aid = session()->has('ADMIN_ID') ? session()->get('ADMIN_ID') : 0;
    $controller_id = session()->has('Controller_ID') ? session()->get('Controller_ID') : 0;

    // Initialize result array
    $result = [
        'cl' => 0,
        'tri' => 0,
        'section' => 0,
        'presec' => [],
        'postsec' => [],
        'cpass' => 0,
        'cfail' => 0,
        'fpass' => 0,
        'ffail' => 0,
        'capprove' => 0,
        'fapprove' => 0
    ];

    // Get data based on logged-in user type
    if ($aid) {
        $result['train'] = DB::table('trainings')->where('aid', $aid)->where('status', 1)->get();
        $result['class'] = DB::table('categories')->where('aid', $aid)->get();
    } elseif ($controller_id) {
        $result['train'] = DB::table('trainings')->where('controller_id', $controller_id)->where('status', 1)->get();
        $result['class'] = DB::table('categories')->where('controller_id', $controller_id)->get();
    }
    
    return view('admin.analytics', $result);
}

public function fetch(Request $request) {
  $aid = session()->has('ADMIN_ID') ? session()->get('ADMIN_ID') : 0;
  $controller_id = session()->has('Controller_ID') ? session()->get('Controller_ID') : 0;

  if ($aid) {
      $result['train'] = DB::table('trainings')->where('aid', $aid)->where('status', 1)->get();
      $result['class'] = DB::table('categories')->where('aid', $aid)->get();
  } elseif ($controller_id) {
      $result['train'] = DB::table('trainings')->where('controller_id', $controller_id)->where('status', 1)->get();
      $result['class'] = DB::table('categories')->where('controller_id', $controller_id)->get();
  }

  // Assign other request data
  $result['cl'] = $request->class;
  $result['tri'] = $request->training;
  $result['section'] = $request->section;

  // Fetch pre-assessment sections and counts
  $pre = DB::table('assesments')->where('train', $request->training)->where('asstype', "Pre")->where('status', 1)->first();
  if ($pre) {
      $result['presec'] = DB::table('assesmentsections')->where('ass_id', $pre->id)->get();

      $query = DB::table('studentbookings')
                  ->join('stureports', 'studentbookings.stureports', '=', 'stureports.id')
                  ->where('trainingid', $request->post('training'))
                  ->where('ssectionid', $request->post('section'))
                  ->where('studentbookings.manpreapprove', 0);

      if ($aid) {
          $result['cpass'] = $query->where('stureports.result', 'PASS')->where('studentbookings.aid', $aid)->count();
          $result['cfail'] = $query->where('stureports.result', 'FAIL')->where('studentbookings.aid', $aid)->count();
      } elseif ($controller_id) {
          $result['cpass'] = $query->where('stureports.result', 'PASS')->where('studentbookings.controller_id', $controller_id)->count();
          $result['cfail'] = $query->where('stureports.result', 'FAIL')->where('studentbookings.controller_id', $controller_id)->count();
      }
  } else {
      $result['presec'] = [];
      $result['cpass'] = 0;
      $result['cfail'] = 0;
  }

  // Fetch post-assessment sections and counts (similar to above for post data)
  $post = DB::table('assesments')->where('train', $request->training)->where('asstype', "Post")->where('status', 1)->first();
  if ($post) {
      $result['postsec'] = DB::table('assesmentsections')->where('ass_id', $post->id)->get();

      $query = DB::table('studentbookings')
                  ->join('stureports', 'studentbookings.stureports', '=', 'stureports.id')
                  ->where('trainingid', $request->post('training'))
                  ->where('ssectionid', $request->post('section'))
                  ->where('studentbookings.manpreapprove', 0);

      if ($aid) {
          $result['fpass'] = $query->where('stureports.postresult', 'PASS')->where('studentbookings.aid', $aid)->count();
          $result['ffail'] = $query->where('stureports.postresult', 'FAIL')->where('studentbookings.aid', $aid)->count();
      } elseif ($controller_id) {
          $result['fpass'] = $query->where('stureports.postresult', 'PASS')->where('studentbookings.controller_id', $controller_id)->count();
          $result['ffail'] = $query->where('stureports.postresult', 'FAIL')->where('studentbookings.controller_id', $controller_id)->count();
      }
  } else {
      $result['postsec'] = [];
      $result['fpass'] = 0;
      $result['ffail'] = 0;
  }

  return view('admin.analytics', $result);
}



public function predata(Request $request) {
  $aid = session()->has('ADMIN_ID') ? session()->get('ADMIN_ID') : 0;
  $controller_id = session()->has('Controller_ID') ? session()->get('Controller_ID') : 0;

  $re = $request->post('id');
  $name = explode('//', $re);
  $need = match ($name[1]) {
      1 => "secAmark",
      2 => "secBmark",
      3 => "secCmark",
      4 => "secDmark",
      default => ''
  };
  
  $result['data']['name'] = "PRE - " . $name[0];
  $data = DB::table('studentbookings')
            ->join('stureports', 'studentbookings.stureports', '=', 'stureports.id')
            ->where('trainingid', $request->post('train'))
            ->where('ssectionid', $request->post('section'));

  if ($aid) {
      $data = $data->where('studentbookings.aid', $aid)->get($need);
  } elseif ($controller_id) {
      $data = $data->where('studentbookings.controller_id', $controller_id)->get($need);
  }

  $result['data'] = array_fill(0, 8, 0);
  foreach ($data as $d) {
      $score = $d->$need;
      if ($score >= 90) $result['data'][7]++;
      elseif ($score >= 80) $result['data'][6]++;
      elseif ($score >= 70) $result['data'][5]++;
      elseif ($score >= 60) $result['data'][4]++;
      elseif ($score >= 50) $result['data'][3]++;
      elseif ($score >= 40) $result['data'][2]++;
      elseif ($score >= 30) $result['data'][1]++;
      else $result['data'][0]++;
  }

  return response()->json($result['data']);
}


public function postdata(Request $request) {
  // Retrieve the logged-in user's aid or controller_id
  $aid = session()->has('ADMIN_ID') ? session()->get('ADMIN_ID') : 0;
  $controller_id = session()->has('Controller_ID') ? session()->get('Controller_ID') : 0;

  // Extract assessment section from the posted id
  $re = $request->post('id');
  $name = explode('//', $re);
  $need = match ($name[1]) {
      1 => "secAmark",
      2 => "secBmark",
      3 => "secCmark",
      4 => "secDmark",
      default => ''
  };

  // Prepare the result data structure
  $result['data']['name'] = "POST - " . $name[0];
  $result['data'] = array_fill(0, 8, 0);

  // Fetch the post-assessment data based on the training and section
  $data = DB::table('studentbookings')
            ->join('stureports', 'studentbookings.stureports', '=', 'stureports.id')
            ->where('trainingid', $request->post('train'))
            ->where('ssectionid', $request->post('section'));

  // Apply filtering based on user type (ADMIN_ID or Controller_ID)
  if ($aid) {
      $data = $data->where('studentbookings.aid', $aid)->get($need);
  } elseif ($controller_id) {
      $data = $data->where('studentbookings.controller_id', $controller_id)->get($need);
  }

  // Process data to count marks in different ranges
  foreach ($data as $d) {
      $score = $d->$need;
      if ($score >= 90) $result['data'][7]++;
      elseif ($score >= 80) $result['data'][6]++;
      elseif ($score >= 70) $result['data'][5]++;
      elseif ($score >= 60) $result['data'][4]++;
      elseif ($score >= 50) $result['data'][3]++;
      elseif ($score >= 40) $result['data'][2]++;
      elseif ($score >= 30) $result['data'][1]++;
      else $result['data'][0]++;
  }

  // Return the result data as JSON response
  return response()->json($result['data']);
}

}
