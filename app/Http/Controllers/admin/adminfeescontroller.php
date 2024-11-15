<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\busroute;
use App\Models\distance;
use App\Models\feecategory;
use App\Models\feeschedule;
use App\Models\student;
use App\Models\feediscount;
use App\Models\feeselection;
use App\Models\feepayment;
use App\Models\feepending;
use App\Imports\distanceImport;
use App\Exports\studentfeesExport;
use App\Exports\studentpendingfeesExport;
use App\Exports\studentcurrentyearpendingfeesExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Validator;
use Redirect, Response;

class adminfeescontroller extends Controller
{
    public function busroute()
    {
        // Check if the session has ADMIN_ID or Controller_ID
        $aid = session()->get('ADMIN_ID');
        $controller_id = session()->get('Controller_ID');

        // If the admin is logged in, use ADMIN_ID for fetching data
        if ($aid) {
            $result['data'] = DB::table('busroutes')->where('aid', $aid)->get();
        }
        // If the controller is logged in, use Controller_ID for fetching data
        elseif ($controller_id) {
            $result['data'] = DB::table('busroutes')->where('Controller_ID', $controller_id)->get();
        }
        // If neither session variable is set, redirect with an error
        else {
            return redirect()->route('home')->with('error', 'You are not authorized to access this page.');
        }

        return view('admin.busroute', $result);
    }


    public function addbusroute(Request $request, $id = "")
    {
        // Check if the session has ADMIN_ID or Controller_ID
        $aid = session()->get('ADMIN_ID');
        $controller_id = session()->get('Controller_ID');

        // If the admin is logged in, use ADMIN_ID to fetch the bus route
        if ($aid) {
            $arr = Busroute::where(['id' => $id, 'aid' => $aid])->get();
        }
        // If the controller is logged in, use Controller_ID to fetch the bus route
        elseif ($controller_id) {
            $arr = Busroute::where(['id' => $id, 'Controller_ID' => $controller_id])->get();
        }
        // If neither session variable is set, redirect with an error
        else {
            return redirect()->route('home')->with('error', 'You are not authorized to access this page.');
        }

        // If the bus route exists, pass its data to the view, else provide default empty data
        if ($arr->count() > 0) {
            $result['id'] = $arr[0]->id;
            $result['busroute'] = $arr[0]->busroute;
        } else {
            $result['id'] = '';
            $result['busroute'] = "";
        }

        return view('admin.addbusroute', $result);
    }


    public function savebusroute(Request $request)
    {
        // Get session values for ADMIN_ID and Controller_ID
        $aid = session()->get('ADMIN_ID');
        $controller_id = session()->get('Controller_ID');

        // If the admin is logged in, store the aid and set Controller_ID as 0
        if ($aid) {
            $model = Busroute::find($request->post('id')) ?: new Busroute();
            $model->aid = $aid;
            $model->Controller_ID = 0;  // Set Controller_ID to 0 for admin
        }
        // If the controller is logged in, store the Controller_ID and set aid as 0
        elseif ($controller_id) {
            $model = Busroute::find($request->post('id')) ?: new Busroute();
            $model->Controller_ID = $controller_id;
            $model->aid = 0;  // Set aid to 0 for controller
        }
        // If neither admin nor controller is logged in, redirect with an error
        else {
            return redirect()->route('home')->with('error', 'You are not authorized to access this page.');
        }

        // Save the bus route details
        $model->busroute = $request->post('busroute');
        $model->status = 1;
        $model->save();

        return redirect('admin/fees/busroute');
    }



    public function busroutestatus($status, $id)
    {
        $model = busroute::find($id);
        $model->status = $status;
        $model->save();
        return redirect("admin/fees/busroute");

    }

    public function deletebusroute($id)
    {
        $model = busroute::find($id);
        $model->delete();
        return redirect("admin/fees/busroute");
    }


    public function distance()
    {
        // Get session values for ADMIN_ID and Controller_ID
        $aid = session()->get('ADMIN_ID');
        $controller_id = session()->get('Controller_ID');

        // Initialize an empty result array
        $result = [];

        // If admin is logged in
        if ($aid) {
            $result['busroutes'] = DB::table('busroutes')->where('aid', $aid)->where('status', 1)->get();
            $result['data'] = DB::table('distances')
                ->join('busroutes', 'busroutes.id', '=', 'distances.busrouteid')
                ->where('distances.aid', $aid)
                ->select('busroutes.busroute', 'distances.*')
                ->get();
        }
        // If controller is logged in
        elseif ($controller_id) {
            $result['busroutes'] = DB::table('busroutes')->where('Controller_ID', $controller_id)->where('status', 1)->get();
            $result['data'] = DB::table('distances')
                ->join('busroutes', 'busroutes.id', '=', 'distances.busrouteid')
                ->where('distances.Controller_ID', $controller_id)
                ->select('busroutes.busroute', 'distances.*')
                ->get();
        }
        // If neither admin nor controller is logged in
        else {
            return redirect()->route('home')->with('error', 'User not logged in');
        }

        // Return the view with the data
        return view('admin.distance', $result);
    }


    public function upload(Request $request)
    {
        // Validate the uploaded file
        $validator = validator::make($request->all(), [
            'excel' => 'required|max:5000|mimes:xlsx,xls,csv'
        ]);

        if ($validator->passes()) {
            // Check if admin or controller is logged in
            $aid = session()->get('ADMIN_ID');
            $controller_id = session()->get('Controller_ID');

            // Initialize aid and controller_id
            $aid = $aid ? $aid : 0; // If ADMIN_ID is not present, set it to 0
            $controller_id = $controller_id ? $controller_id : 0; // If Controller_ID is not present, set it to 0

            // If neither admin nor controller is logged in, redirect
            if (!$aid && !$controller_id) {
                return redirect()->route('home')->with('error', 'User not logged in');
            }

            // Get busrouteid from the request
            $busrouteid = $request->post('busrouteid');

            // Handle file import using Laravel Excel
            try {
                // Load the uploaded file
                $file = $request->file('excel');
                $excelData = Excel::toArray([], $file);

                // Loop through the rows and process them, starting from the second row (skip the first row)
                $firstRowSkipped = false;
                foreach ($excelData[0] as $index => $row) {
                    // Skip the first row (header)
                    if (!$firstRowSkipped) {
                        $firstRowSkipped = true;
                        continue;
                    }

                    // Process the data from the second row onwards
                    $model = new Distance();
                    $model->aid = $aid;  // Admin ID or 0
                    $model->Controller_ID = $controller_id;  // Controller ID or 0
                    $model->busrouteid = $busrouteid;  // From the form request
                    $model->location = $row[0];  // Location from Excel
                    $model->distance = $row[1];  // Distance from Excel
                    $model->disstatus = 1;  // Active status
                    $model->save();  // Save the record
                }

                $msg = "File Uploaded Successfully";
                $request->session()->flash('success', $msg);

            } catch (\Exception $e) {
                // Handle any errors during the file import
                $msg = "File failed to upload: " . $e->getMessage();
                $request->session()->flash('error', $msg);
            }

            return redirect('admin/fees/distance');
        } else {
            // Validation failed, return the errors
            return redirect()->back()->with(['errors' => $validator->errors()->all()]);
        }
    }




    public function adddistance(request $request, $id = "")
    {
        // Check if the user is an admin or controller
        $aid = session()->get('ADMIN_ID');
        $controller_id = session()->get('Controller_ID');

        // Initialize $user_id to 0 if neither admin nor controller is logged in
        $user_id = 0;

        if ($aid) {
            // Admin logged in, use ADMIN_ID
            $user_id = $aid;
        } elseif ($controller_id) {
            // Controller logged in, use Controller_ID
            $user_id = $controller_id;
        } else {
            // If neither admin nor controller is logged in, redirect
            return redirect()->route('home')->with('error', 'User not logged in');
        }

        // If an ID is provided, fetch the existing record
        if ($id > 0) {
            $arr = distance::where(['id' => $id])
                ->where(function ($query) use ($user_id) {
                    // Match either aid or Controller_ID based on logged-in user
                    if ($user_id == $aid) {
                        $query->where('aid', $user_id);
                    } else {
                        $query->where('Controller_ID', $user_id);
                    }
                })
                ->get();

            if (count($arr) > 0) {
                $result['id'] = $arr[0]->id;
                $result['busrouteid'] = $arr[0]->busrouteid;
                $result['location'] = $arr[0]->location;
                $result['distance'] = $arr[0]->distance;
            } else {
                return redirect()->route('home')->with('error', 'Record not found or access denied.');
            }
        } else {
            // For new distance records
            $result['id'] = '';
            $result['busrouteid'] = '';
            $result['location'] = '';
            $result['distance'] = '';
        }

        // Fetch bus routes based on the logged-in user's ID (either admin or controller)
        $result['busroutes'] = DB::table('busroutes')
            ->where(function ($query) use ($user_id) {
                if ($user_id == $aid) {
                    $query->where('aid', $user_id);
                } else {
                    $query->where('Controller_ID', $user_id);
                }
            })
            ->where('status', 1)
            ->get();

        return view('admin.adddistance', $result);
    }

    public function savedistance(Request $request)
    {
        $aid = session()->has('ADMIN_ID') ? session()->get('ADMIN_ID') : 0;
        $controller_id = session()->has('Controller_ID') ? session()->get('Controller_ID') : 0;

        if ($request->post('id') > 0) {
            $model = distance::find($request->post('id'));
        } else {
            $model = new distance();
        }

        $model->aid = $aid;
        $model->Controller_ID = $controller_id;
        $model->busrouteid = $request->post('busrouteid');
        $model->location = $request->post('location');
        $model->distance = $request->post('distance');
        $model->disstatus = 1;
        $model->save();

        return redirect("admin/fees/distance");
    }




    public function disstatus($status, $id)
    {
        $model = distance::find($id);
        $model->disstatus = $status;
        $model->save();
        return redirect("admin/fees/distance");

    }

    public function deletedistance($id)
    {
        $model = distance::find($id);
        $model->delete();
        return redirect("admin/fees/distance");
    }



    public function category()
    {
        // Get session values for ADMIN_ID and Controller_ID
        $aid = session()->get('ADMIN_ID');
        $controller_id = session()->get('Controller_ID');

        // If neither ADMIN_ID nor Controller_ID is set, return an error
        if (!$aid && !$controller_id) {
            return redirect('home')->with('error', 'User not authenticated.');
        }

        // Fetch records based on the logged-in user (admin or controller)
        if ($aid) {
            // If admin is logged in, fetch records where aid matches
            $result['data'] = DB::table('feecategories')->where('aid', $aid)->get();
        } else if ($controller_id) {
            // If controller is logged in, fetch records where Controller_ID matches
            $result['data'] = DB::table('feecategories')->where('Controller_ID', $controller_id)->get();
        }

        // Return the view with the data
        return view('admin.feescategory', $result);
    }


    public function addcategory(request $request, $id = "")
    {
        if ($id > 0) {
            $arr = feecategory::where(['id' => $id])->get();
            $result['id'] = $arr['0']->id;
            $result['feescategory'] = $arr['0']->fcategory;
            $result['fctype'] = $arr['0']->fctype;
            $result['fcmandatoryornot'] = $arr['0']->fcmandatoryornot;

        } else {
            $result['id'] = '';
            $result['feescategory'] = "";
            $result['fctype'] = "";
            $result['fcmandatoryornot'] = "";

        }
        $result['type'] = array(array("id" => "1", "type" => "CLASS"), array("id" => "2", "type" => "Pickup/Drop Location"));
        $result['types'] = array(array("id" => "1", "type" => "Mandatory"), array("id" => "2", "type" => "Optional"));
        return view('admin.addfeescategory', $result);
    }

    public function savecategory(request $request)
    {
        // Retrieve the session values for ADMIN_ID and Controller_ID
        $aid = session()->get('ADMIN_ID');
        $controller_id = session()->get('Controller_ID');

        // Set to 0 if not set in session
        $aid = $aid ? $aid : 0;
        $controller_id = $controller_id ? $controller_id : 0;

        // If neither Admin nor Controller is logged in, handle the situation (optional)
        if (!$aid && !$controller_id) {
            return redirect()->route('home')->with('error', 'User not logged in');
        }

        // Find the existing record or create a new one
        if ($request->post('id') > 0) {
            // Update existing category
            $model = feecategory::find($request->post('id'));
        } else {
            // Create new category
            $model = new feecategory();
        }

        // Assign data to the model
        $model->fcategory = $request->post('category');
        $model->fcstatus = 1;  // Assuming it's always active when saving
        $model->aid = $aid;  // Set Admin ID (or 0 if not available)
        $model->Controller_ID = $controller_id;  // Set Controller ID (or 0 if not available)
        $model->fctype = $request->post('type');
        $model->fcmandatoryornot = $request->post('mandatoryornot');

        // Save the model data to the database
        $model->save();

        // Redirect to the fees category page with a success message
        return redirect("admin/fees/category")->with('success', 'Category saved successfully');
    }



    public function catstatus($status, $id)
    {
        $model = feecategory::find($id);
        $model->fcstatus = $status;
        $model->save();
        return redirect("admin/fees/category");

    }

    public function deletecategory($id)
    {
        $model = feecategory::find($id);
        $model->delete();
        return redirect("admin/fees/category");
    }






    //schedule


    public function schedule()
    {

        $aid = session()->get('ADMIN_ID');
        $controller_id = session()->get('Controller_ID');

        $aid = $aid ? $aid : 0;
        $controller_id = $controller_id ? $controller_id : 0;

        // If neither Admin nor Controller is logged in, handle the situation (optional)
        if (!$aid && !$controller_id) {
            return redirect()->route('home')->with('error', 'User not logged in');
        }

        // Fetch data based on the logged-in user
        $result['otherdata'] = DB::table('feeschedules')
            ->join('feecategories', 'feeschedules.shcategory', 'feecategories.id')
            ->where(function ($query) use ($aid, $controller_id) {
                if ($aid) {
                    $query->where('feeschedules.aid', $aid);
                } else {
                    $query->where('feeschedules.Controller_ID', $controller_id);
                }
            })
            ->where('feecategories.fctype', 1)
            ->select('feecategories.fcategory', 'feeschedules.*')
            ->get();

        $result['transportdata'] = DB::table('feeschedules')
            ->join('feecategories', 'feeschedules.shcategory', 'feecategories.id')
            ->where(function ($query) use ($aid, $controller_id) {
                if ($aid) {
                    $query->where('feeschedules.aid', $aid);
                } else {
                    $query->where('feeschedules.Controller_ID', $controller_id);
                }
            })
            ->where('feecategories.fctype', 2)
            ->select('feecategories.fcategory', 'feeschedules.*')
            ->get();

        return view('admin.feeschedule', $result);
    }

    public function addschedule(Request $request, $id = "")
    {
        // Retrieve session values for ADMIN_ID and Controller_ID
        $aid = session()->get('ADMIN_ID');
        $controller_id = session()->get('Controller_ID');

        // Set to 0 if not set in session
        $aid = $aid ? $aid : 0;
        $controller_id = $controller_id ? $controller_id : 0;

        // If neither Admin nor Controller is logged in, handle the situation (optional)
        if (!$aid && !$controller_id) {
            return redirect()->route('home')->with('error', 'User not logged in');
        }

        // If an ID is provided, fetch the schedule data for editing
        if ($id > 0) {
            $arr = feeschedule::where(['id' => $id])
                ->where(function ($query) use ($aid, $controller_id) {
                    if ($aid) {
                        $query->where('feeschedules.aid', $aid);
                    } else {
                        $query->where('feeschedules.Controller_ID', $controller_id);
                    }
                })
                ->get();

            // Assign values from the retrieved schedule data
            $result['id'] = $arr[0]->id;
            $result['shcategory'] = $arr[0]->shcategory;
            $result['shannual'] = $arr[0]->shannual;
            $result['shhalf'] = $arr[0]->shhalf;
            $result['shquater'] = $arr[0]->shquater;
            $result['shmonthly'] = $arr[0]->shmonthly;
            $result['type'] = $arr[0]->shtype;
            $result['shtype'] = $arr[0]->shtypename;
        } else {
            // Default empty values if no ID is provided
            $result['id'] = '';
            $result['shcategory'] = "";
            $result['shannual'] = "";
            $result['shhalf'] = "";
            $result['shquater'] = "";
            $result['shmonthly'] = "";
            $result['type'] = "";
            $result['shtype'] = "";
        }

        // Fetch categories, classes, and distances based on the logged-in user
        $result['categories'] = DB::table('feecategories')
            ->where(function ($query) use ($aid, $controller_id) {
                if ($aid) {
                    $query->where('feecategories.aid', $aid);
                } else {
                    $query->where('feecategories.Controller_ID', $controller_id);
                }
            })
            ->where('fctype', 1)
            ->where('fcstatus', 1)
            ->get();

     $result['class'] = DB::table('categories')
            ->where(function ($query) use ($aid, $controller_id) {
                if ($aid) {
                    $query->where('categories.aid', $aid);
                } else {
                    $query->where('categories.Controller_ID', $controller_id);
                }
            })
            ->select('categories')  // Select only the 'categories' field
            ->get();


        $result['distance'] = DB::table('distances')
            ->where(function ($query) use ($aid, $controller_id) {
                if ($aid) {
                    $query->where('distances.aid', $aid);
                } else {
                    $query->where('distances.Controller_ID', $controller_id);
                }
            })
            ->where('disstatus', 1)
            ->get();

        return view('admin.addfeeschedule', $result);
    }

    public function saveschedule(Request $request) {
        // Retrieve session values for ADMIN_ID and Controller_ID
        $aid = session()->get('ADMIN_ID');
        $controller_id = session()->get('Controller_ID');
        
        // Set to 0 if not set in session
        $aid = $aid ? $aid : 0;
        $controller_id = $controller_id ? $controller_id : 0;
    
        // If neither Admin nor Controller is logged in, handle the situation (optional)
        if (!$aid && !$controller_id) {
            return redirect()->route('home')->with('error', 'User not logged in');
        }
    
        // Process the category selection
        $c = explode('**', $request->post('category'));
        $t = [];
    
        // Determine which type of schedule is being used
        if ($c[1] == 1) {
            $t = explode('**', $request->post('type1'));
        } else {
            $t = explode('**', $request->post('type2'));
        }
    
        // Prepare the data to be inserted
        $data = [
            'aid' => $aid,
            'Controller_ID' => $controller_id,
            'shcategory' => $c[0],
            'shannual' => $request->post('annual'),
            'shhalf' => $request->post('half'),
            'shquater' => $request->post('quater'),
            'shmonthly' => $request->post('month'),
            'shtype' => $t[0],
            'shtypename' => $t[0],
            'created_at' => now(),
            'updated_at' => now(),
        ];
    
        // If an ID is provided, update the existing record, otherwise insert a new one
        if ($request->post('id') > 0) {
            // Update existing record
            DB::table('feeschedules')
                ->where('id', $request->post('id'))
                ->update($data);
        } else {
            // Insert new record
            DB::table('feeschedules')->insert($data);
        }
    
        // Redirect to the schedule page
        return redirect("admin/fees/schedule");
    }
    


    public function deleteschedule($id)
    {
        $model = feeschedule::find($id);
        $model->delete();
        return redirect("admin/fees/schedule");
    }


    public function transportschedule()
    {
        // Check if the logged-in user is Admin or Controller
        $aid = session()->get('ADMIN_ID');
        $controller_id = session()->get('Controller_ID');
        
        // Initialize $aid and $controller_id to 0 if not present
        $aid = $aid ? $aid : 0;
        $controller_id = $controller_id ? $controller_id : 0;
    
        // Fetch bus routes based on admin or controller
        if ($aid) {
            $result['data'] = DB::table('busroutes')->where('aid', $aid)->get();
        } elseif ($controller_id) {
            // You could add logic here to fetch based on Controller_ID if needed
            $result['data'] = DB::table('busroutes')->where('controller_id', $controller_id)->get();
        } else {
            return redirect()->route('home')->with('error', 'User not logged in');
        }
        
        return view('admin.transportfeeschedule', $result);
    }
    

    public function addtransportschedule(Request $request, $moneystatus, $busrouteid)
    {
        // Check if the user is logged in as admin or controller
        $aid = session()->get('ADMIN_ID');
        $controller_id = session()->get('Controller_ID');
    
        // Determine which ID to use based on login type
        if ($aid) {
            // If admin is logged in, use $aid
            $user_id = $aid;
            $user_column = 'aid';
        } elseif ($controller_id) {
            // If controller is logged in, use $controller_id
            $user_id = $controller_id;
            $user_column = 'Controller_ID';
        } else {
            // If neither is logged in, handle accordingly (e.g., redirect or show error)
            return redirect()->route('home')->with('error', 'User not logged in');
        }
    
        if ($moneystatus == 1) {
            // Fetch records for admin or controller based on who is logged in
            $result['distances'] = DB::table('distances')
                ->join('feeschedules', 'feeschedules.shtype', '=', 'distances.id')
                ->where('distances.busrouteid', $busrouteid)
                ->where($user_column, $user_id)  // Check if the logged-in user is the creator
                ->where('distances.disstatus', 1)
                ->select('feeschedules.*', 'distances.location', 'distances.distance')
                ->get();
    
            // Modify the results
            for ($i = 0; $i < count($result['distances']); $i++) {
                $result['distances'][$i]->shfeescheduleid = $result['distances'][$i]->id;
                $result['distances'][$i]->distanceid = $result['distances'][$i]->shtype;
            }
        } else {
            // Fetch records for admin or controller based on who is logged in
            $result['distances'] = DB::table('distances')
                ->where('busrouteid', $busrouteid)
                ->where($user_column, $user_id)  // Check if the logged-in user is the creator
                ->where('disstatus', 1)
                ->select('id', 'location', 'distance')
                ->get();
    
            // Modify the results
            for ($i = 0; $i < count($result['distances']); $i++) {
                $result['distances'][$i]->shannual = "";
                $result['distances'][$i]->shhalf = "";
                $result['distances'][$i]->shquater = "";
                $result['distances'][$i]->shmonthly = "";
                $result['distances'][$i]->shfeescheduleid = "";
                $result['distances'][$i]->distanceid = $result['distances'][$i]->id;
            }
        }
    
        // Pass additional data to the view
        $result['moneystatus'] = $moneystatus;
        $result['busrouteid'] = $busrouteid;
    
        return view('admin.addtransportfeeschedule', $result);
    }
    

    public function savetransportschedule(Request $request)
    {
        // Determine if the user is an admin or controller and set the appropriate ID
        $aid = 0;
        $controller_id = 0;
    
        if (session()->has('ADMIN_ID')) {
            $aid = session()->get('ADMIN_ID');
        } else if (session()->has('Controller_ID')) {
            $controller_id = session()->get('Controller_ID');
        }
    
        // Fetch the fee category based on the appropriate ID
        $feecategory = DB::table('feecategories')
            ->where(function ($query) use ($aid, $controller_id) {
                if ($aid > 0) {
                    $query->where('aid', $aid);
                } else if ($controller_id > 0) {
                    $query->where('Controller_ID', $controller_id);
                }
            })
            ->where('fctype', 2)
            ->get();
    
        if ($request->post('moneystatus') == 1) {
            // Update existing records
            for ($i = 0; $i < count($request->post('shtype')); $i++) {
                $model = feeschedule::find($request->post('shfeescheduleid')[$i]);
                if ($model) {
                    $model->aid = $aid;
                    $model->Controller_ID = $controller_id;
                    $model->shcategory = $feecategory[0]->id;
                    $model->shannual = $request->post('shannual')[$i];
                    $model->shhalf = $request->post('shhalf')[$i];
                    $model->shquater = $request->post('shquater')[$i];
                    $model->shmonthly = $request->post('shmonth')[$i];
                    $model->shtype = $request->post('shtype')[$i];
                    $model->shtypename = $request->post('shtypename')[$i] . " Km";
                    $model->save();
                }
            }
        } else {
            // Insert new records
            for ($i = 0; $i < count($request->post('shtype')); $i++) {
                $model = new feeschedule();
                $model->aid = $aid;
                $model->Controller_ID = $controller_id;
                $model->shcategory = $feecategory[0]->id;
                $model->shannual = $request->post('shannual')[$i];
                $model->shhalf = $request->post('shhalf')[$i];
                $model->shquater = $request->post('shquater')[$i];
                $model->shmonthly = $request->post('shmonth')[$i];
                $model->shtype = $request->post('shtype')[$i];
                $model->shtypename = $request->post('shtypename')[$i] . " Km";
                $model->save();
            }
        }
    
        // Update the busroute
        $model = busroute::find($request->post('busrouteid'));
        if ($model) {
            $model->moneystatus = 1;
            $model->save();
        }
    
        return redirect("admin/transport/fees/schedule/busroutes");
    }
    





    //discount


    public function discount()
    {
        $aid = 0;
        $controller_id = 0;
        if (session()->has('ADMIN_ID')) {
            $aid = session()->get('ADMIN_ID');
        } 
        if (session()->has('Controller_ID')) {
            $controller_id = session()->get('Controller_ID');
        }

        $query = DB::table('feediscounts')
            ->join('students', 'feediscounts.stu_id', '=', 'students.id')
            ->join('categories', 'feediscounts.discls', '=', 'categories.id')
            ->join('lmssections', 'feediscounts.dissec', '=', 'lmssections.id')
            ->join('feecategories', 'feediscounts.discat', '=', 'feecategories.id')
            ->select('feecategories.fcategory', 'feediscounts.*', 'students.sname', 'students.image', 'categories.categories', 'lmssections.section');
        if ($aid > 0) {
            $query->where('feediscounts.aid', $aid);
        } elseif ($controller_id > 0) {
            $query->where('feediscounts.Controller_ID', $controller_id);
        }
    
        // Execute the query and fetch the results
        $result['data'] = $query->get();
    
        // Return the view with the result data
        return view('admin.feesdiscount', $result);
    }
    

    public function adddiscount(Request $request, $id = "")
    {
        // Determine whether the user is an admin or controller and set the appropriate ID
        $aid = 0;
        $controller_id = 0;
    
        if (session()->has('ADMIN_ID')) {
            $aid = session()->get('ADMIN_ID');
        } else if (session()->has('Controller_ID')) {
            $controller_id = session()->get('Controller_ID');
        }
    
        // Fetch the discount data if the ID is provided
        if ($id > 0) {
            $arr = feediscount::where(['id' => $id])
                ->where(function ($query) use ($aid, $controller_id) {
                    if ($aid > 0) {
                        $query->where('aid', $aid);
                    } else if ($controller_id > 0) {
                        $query->where('Controller_ID', $controller_id);
                    }
                })
                ->get();
    
            if ($arr->isNotEmpty()) {
                $result['id'] = $arr[0]->id;
                $result['discat'] = $arr[0]->discat;
                $result['discls'] = $arr[0]->discls;
                $result['dissec'] = $arr[0]->dissec;
                $result['distype'] = $arr[0]->distype;
                $result['stu'] = $arr[0]->stu_id;
                $result['dis'] = $arr[0]->dis;
                $result['fees'] = $arr[0]->fees;
                $result['disprice'] = $arr[0]->disprice;
                $result['distance'] = $arr[0]->distance;
                $result['studentid'] = $arr[0]->stu_id;
            } else {
                // Return empty values if no discount record found
                $result['id'] = "";
                $result['discat'] = "";
                $result['discls'] = "";
                $result['dissec'] = "";
                $result['distype'] = "";
                $result['stu'] = "";
                $result['dis'] = 0;
                $result['fees'] = 0;
                $result['disprice'] = 0;
                $result['distance'] = "";
                $result['studentid'] = "";
            }
        } else {
            // Return empty fields for a new discount
            $result['id'] = "";
            $result['discat'] = "";
            $result['discls'] = "";
            $result['dissec'] = "";
            $result['distype'] = "";
            $result['stu'] = "";
            $result['dis'] = 0;
            $result['fees'] = 0;
            $result['disprice'] = 0;
            $result['distance'] = "";
            $result['studentid'] = "";
        }
    
        // Fetch categories and distances based on role
        $result['categories'] = DB::table('feecategories')
            ->where(function ($query) use ($aid, $controller_id) {
                if ($aid > 0) {
                    $query->where('aid', $aid);
                } else if ($controller_id > 0) {
                    $query->where('Controller_ID', $controller_id);
                }
            })
            ->where('fcstatus', 1)
            ->get();
    
        $result['class'] = DB::table('categories')
            ->where(function ($query) use ($aid, $controller_id) {
                if ($aid > 0) {
                    $query->where('aid', $aid);
                } else if ($controller_id > 0) {
                    $query->where('Controller_ID', $controller_id);
                }
            })
            ->get();
    
        $result['types'] = [
            ["id" => "Annually", "type" => "shannual"],
            ["id" => "Half-yearly", "type" => "shhalf"],
            ["id" => "Quarterly", "type" => "shquater"],
            ["id" => "Monthly", "type" => "shmonthly"]
        ];
    
        $result['per'] = [10, 20, 30, 40, 50, 60, 70, 80, 90, 100];
    
        // Fetch distances based on role
        $result['distances'] = DB::table('distances')
            ->where(function ($query) use ($aid, $controller_id) {
                if ($aid > 0) {
                    $query->where('aid', $aid);
                } else if ($controller_id > 0) {
                    $query->where('Controller_ID', $controller_id);
                }
            })
            ->where('disstatus', 1)
            ->get();
    
        return view('admin.addfeesdiscount', $result);
    }
    
    public function savediscount(Request $request)
    {
        // Get the session values for admin and controller
        $aid = session()->get('ADMIN_ID');
        $controller_id = session()->get('Controller_ID');
        
        // Determine which ID to use based on whether it's an admin or controller
        if ($aid) {
            $model = feediscount::find($request->post('id'));
            if ($model) {
                // Check if the current admin is trying to edit a record created by another admin
                if ($model->aid != $aid) {
                    return redirect()->back()->with('error', 'You are not authorized to edit this record.');
                }
            }
        } else if ($controller_id) {
            $model = feediscount::find($request->post('id'));
            if ($model) {
                // Check if the current controller is trying to edit a record created by another controller
                if ($model->Controller_ID != $controller_id) {
                    return redirect()->back()->with('error', 'You are not authorized to edit this record.');
                }
            }
        } else {
            return redirect()->route('home')->with('error', 'No user role is set.');
        }
    
        // Handle discount data
        if ($request->post('id') > 0) {
            $model = feediscount::find($request->post('id'));
        } else {
            $model = new feediscount();
        }
    
        // Split category and discount type
        $c = explode('**', $request->post('category'));
        $disc = explode('**', $request->post('discat'));
        $distance = 0;
        $ty = explode("**", $request->post('type'));
        $name = $ty[1];
        
        if ($request->post('type2') != "") {
            $a = explode("**", $request->post('type2'));
            $distance = $a[0];
            $name = $a[1];
        }
    
        // Set appropriate values for the discount record
        if ($aid) {
            $model->aid = $aid;
            $model->Controller_ID = 0; // Ensure controller_id is 0 for admin
        } else if ($controller_id) {
            $model->Controller_ID = $controller_id;
            $model->aid = 0; // Ensure aid is 0 for controller
        }
    
        $model->stu_id = $request->post('students');
        $model->discat = $disc[0];
        $model->discls = $c[0];
        $model->dissec = $request->post('section');
        $model->distype = $ty[0];
        $model->fees = $request->post('fees');
        $model->dis = $request->post('dis');
        $model->disprice = $request->post('tfees');
        $model->distance = $distance;
        $model->disname = $name;
    
        // Save the record
        $model->save();
        
        return redirect("admin/fees/discount");
    }
    
    public function deletediscount($id)
    {
        $model = feediscount::find($id);
        $model->delete();
        return redirect("admin/fees/discount");
    }

    public function getfees()
    {
        // Check if ADMIN_ID or Controller_ID exists in the session
        $aid = session()->get('ADMIN_ID');
        $controller_id = session()->get('Controller_ID');
    
        // Initialize variables for category, type, and class
        $cat = $_GET['cat'];
        $ty = explode("**", $_GET['type']);
        $type = $ty[0];
        $cls = $_GET['cls'];
        $dis = explode("**", $_GET['dis']);
    
        // Initialize result and data variables
        $result = [];
        $data = 0;
    
        // Check if the user is an admin or a controller and adjust the query accordingly
        if ($aid) {
            // If admin, use aid in the query
            if (count($dis) < 2) {
                $result = DB::table('feeschedules')->where('aid', $aid)->where('shcategory', $cat)->where('shtype', $cls)->get([$type]);
                if (count($result) > 0) {
                    $data = $result[0]->$type;
                }
            } else {
                $result = DB::table('feeschedules')->where('aid', $aid)->where('shcategory', $cat)->where('shtype', $dis[0])->get([$type]);
                if (count($result) > 0) {
                    $data = $result[0]->$type;
                }
            }
        } elseif ($controller_id) {
            // If controller, use Controller_ID in the query
            if (count($dis) < 2) {
                $result = DB::table('feeschedules')->where('Controller_ID', $controller_id)->where('shcategory', $cat)->where('shtype', $cls)->get([$type]);
                if (count($result) > 0) {
                    $data = $result[0]->$type;
                }
            } else {
                $result = DB::table('feeschedules')->where('Controller_ID', $controller_id)->where('shcategory', $cat)->where('shtype', $dis[0])->get([$type]);
                if (count($result) > 0) {
                    $data = $result[0]->$type;
                }
            }
        }
    
        // Return the data in JSON format
        return Response::json($data);
    }
    public function getstu()
    {
        // Get the session values for ADMIN_ID and Controller_ID
        $aid = session()->get('ADMIN_ID');
        $controller_id = session()->get('Controller_ID');
        
        // Get the class ID and section ID from the request
        $cls = $_GET['id'];
        $sec = $_GET['sec'];
    
        // Initialize the result array
        $result = [];
    
        // Check if the user is an admin or a controller
        if ($aid) {
            // If the user is an admin, use the aid column in the query
            $result = DB::table('students')->where('aid', $aid)->where('sclassid', $cls)->where('ssectionid', $sec)->get();
        } elseif ($controller_id) {
            // If the user is a controller, use the Controller_ID column in the query
            $result = DB::table('students')->where('Controller_ID', $controller_id)->where('sclassid', $cls)->where('ssectionid', $sec)->get();
        }
    
        // Return the result in JSON format
        return Response::json($result);
    }
    

    //pending fees


    public function pendingfeesstudents()
    {
        $aid = session()->get('ADMIN_ID');
        $controller_id = session()->get('Controller_ID');
        $result['classes'] = DB::table('categories')->where('aid', $aid)->orWhere('Controller_ID',$controller_id)->get();
        $result['students'] = [];
        $result['class'] = [];
        $result['section'] = [];
        return view('admin.pendingfeesstudents', $result);
    }

    public function pendingfeesstudentsbysection(request $request)
    {
        $aid = session()->get('ADMIN_ID');
        $controller_id = session()->get('Controller_ID');
        $class = $request->post('class');
        $section = $request->post('section');
        $result['class'] = $class;
        $result['section'] = $section;
        $result['classes'] = DB::table('categories')->where('aid', $aid)->orWhere('Controller_ID',$controller_id)->get();
        $result['students'] = DB::table('students')->where('sclassid', $class)->where('ssectionid', $section)->get();
        return view('admin.pendingfeesstudents', $result);
    }


    public function pendingfeesinitialsave(request $request)
    {
        //return $request->post();
        for ($i = 0; $i < count($request->post('studentid')); $i++) {
            $model = student::find($request->post('studentid')[$i]);
            $model->spendingfees = $request->post('amount')[$i];
            $model->save();
        }
        $request->session()->flash("success", "Pending Fees Saved Successfully");
        return redirect('admin/fees/pending');
    }

    public function pendingfeessave(request $request)
    {


        $c = count($request->post('paidamount'));
        for ($i = 0; $i < $c; $i++) {
            if ($request->hasfile('photos' . ((int) $i + 1))) {
                $filename = $request->file('photos' . ((int) $i + 1))->getClientOriginalName();
                $extension = $request->file('photos' . ((int) $i + 1))->getClientOriginalExtension();
                $image_name = time() . rand(1, 1000) . '.' . $extension;
                $request->file('photos' . ((int) $i + 1))->move(public_path() . '/feereciepts', $image_name);
                $files[$i] = $image_name;
            } else {
                $files[$i] = "";
            }
        }



        $aid = session()->get('ADMIN_ID');
        for ($i = 0; $i < count($files); $i++) {
            if ((int) $request->post('paidamount')[$i] != "") {
                $model = student::find($request->post('studentid')[$i]);
                $model->spendingfees = (int) $request->post('amount')[$i] - (int) $request->post('paidamount')[$i];
                $model->save();

                $m = new feepending();
                $m->aid = $aid;
                $m->classid = $model->sclassid;
                $m->sectionid = $model->ssectionid;
                $m->sid = $request->post('studentid')[$i];
                $m->feetobepaid = (int) $request->post('amount')[$i];
                $m->feepaid = (int) $request->post('paidamount')[$i];
                $m->feebalance = (int) $request->post('amount')[$i] - (int) $request->post('paidamount')[$i];
                $m->feepaymentdate = date('d-m-Y');
                $m->feereciept = $files[$i];
                $m->save();
            }
        }
        $request->session()->flash("success", "Pending Fees Saved Successfully");
        return redirect('admin/fees/pending');
    }

    public function pendingfeesexport(request $request, $class, $section)
    {
        $name = 'Student Pending Fees List';
        return Excel::download(new studentpendingfeesExport($class, $section), $name . '.xlsx');
    }

    public function indexfeesstudents()
    {
        $aid = session()->get('ADMIN_ID');
        $result['classes'] = DB::table('categories')->where('aid', $aid)->get();
        $result['students'] = [];
        $result['class'] = [];
        $result['section'] = [];
        $result['paymentcount'] = [];
        return view('admin.paidindex', $result);
    }

    public function indexfeesstudentsbysection(request $request)
    {
        $aid = session()->get('ADMIN_ID');
        $class = $request->post('class');
        $section = $request->post('section');
        $result['classes'] = DB::table('categories')->where('aid', $aid)->get();
        $result['students'] = DB::table('students')->where('sclassid', $class)->where('ssectionid', $section)->get();
        $result['paymentcount'] = 0;
        for ($i = 0; $i < count($result['students']); $i++) {
            $a = DB::table('feeselections')->where('sid', $result['students'][$i]->id)->where('status', 1)->get();
            if (count($a) > 0) {
                $result['students'][$i]->visible = 1;
                $result['paymentcount'] = $result['paymentcount'] + 1;
            } else {
                $result['students'][$i]->visible = 0;
            }
        }
        $result['class'] = $class;
        $result['section'] = $section;
        return view('admin.paidindex', $result);
    }


    public function feestransfer(request $request)
    {
        $class = $request->post('class');
        $section = $request->post('section');
        $students = DB::table('students')->where('sclassid', $class)->where('ssectionid', $section)->get();
        for ($i = 0; $i < count($students); $i++) {
            $a = DB::table('feepayments')->where('sid', $students[$i]->id)->where('status', 1)->get();
            $totalmoney = $students[$i]->spendingfees + $a[0]->feetotalremaining;

            DB::table('students')->where('id', $students[$i]->id)->update(['spendingfees' => $totalmoney]);

            DB::table('feependings')->where('sid', $students[$i]->id)->delete();
            DB::table('feeselections')->where('sid', $students[$i]->id)->delete();
            DB::table('feepayments')->where('sid', $students[$i]->id)->delete();
            DB::table('distributions')->where('sid', $students[$i]->id)->delete();
        }
        $request->session()->flash("success", "Current Year Payments Has Transferred To Last Year Pending Successfully");
        return redirect("admin/fees/index/students");
    }


    public function feesexport(request $request, $id)
    {
        $name = 'Student Fees List';
        return Excel::download(new studentfeesExport($id), $name . '.xlsx');
    }


    public function feesstructure(Request $request, $id)
    {
        $studentdata = DB::table('feeselections')->where('sid', $id)->get();
        $result['data'] = DB::table('feeselections')
            ->join('feeschedules', 'feeschedules.id', 'feeselections.feescheduleid')
            ->join('feecategories', 'feecategories.id', 'feeschedules.shcategory')
            ->where('feeselections.sid', $id)
            ->where('feeselections.status', 1)
            ->select('feecategories.fcategory', 'feeselections.*')
            ->get();
        $result['sid'] = $id;
        return view('admin.paidintsallment', $result);
    }

    public function feessave(request $request)
    {
        //return $request->post();
        $sid = $request->post('studentid');
        $fee = $request->post('fee');
        $studentfeedata = DB::table('feeselections')->where('sid', $sid)->where('status', 1)->get();
        $feemonth = $request->post('feemonth');

        if ($request->hasfile('file')) {
            $image = $request->file('file');
            $ext = $image->extension();
            $image_name = time() . '.' . $ext;
            $image->move(public_path() . '/feereciepts', $image_name);
        }

        for ($i = 0; $i < count($studentfeedata); $i++) {
            $model = feeselection::find($studentfeedata[$i]->id);
            $model->$feemonth = $image_name;
            $model->save();
        }

        $a = DB::table('feepayments')->where('sid', $sid)->get();
        $paid = $a[0]->feetotalpaid + $fee;
        $remaining = $a[0]->feetotalremaining - $fee;

        DB::table('feepayments')->where('sid', $sid)
            ->update([$feemonth . 'pay' => 'PAID', 'feetotalpaid' => $paid, 'feetotalremaining' => $remaining]);

        $request->session()->flash("success", "Fees Saved Successfully");
        return redirect('admin/fees/index/students/view/structure/' . $request->post('studentid'));
    }

    public function currentyearpendingfeesstudents()
    {
        $aid = session()->get('ADMIN_ID');
        $result['classes'] = DB::table('categories')->where('aid', $aid)->get();
        $result['students'] = [];
        $result['class'] = [];
        $result['section'] = [];
        $result['month'] = [];
        return view('admin.currentyearpendingfeesstudents', $result);
    }

    public function currentyearpendingfeesstudentsbysection(request $request)
    {
        $aid = session()->get('ADMIN_ID');
        $class = $request->post('class');
        $section = $request->post('section');
        $result['class'] = $class;
        $result['section'] = $section;
        $result['classes'] = DB::table('categories')->where('aid', $aid)->get();
        $result['month'] = date('F');
        $result['students'] = DB::table('students')
            ->join('feepayments', 'feepayments.sid', 'students.id')
            ->join('categories', 'categories.id', 'students.sclassid')
            ->join('lmssections', 'lmssections.id', 'students.ssectionid')
            ->where('sclassid', $class)
            ->where('ssectionid', $section)
            ->select(
                'students.sname',
                'students.slname',
                'students.sfathername',
                'sregistrationnumber',
                'categories.categories',
                'lmssections.section',
                'feepayments.id',
                'feepayments.feetotalremaining',
                'feepayments.feetotalpaid',
                'feepayments.feetotal',
                'feepayments.feeaprmoney',
                'feepayments.feemaymoney',
                'feepayments.feejunmoney',
                'feepayments.feejulmoney',
                'feepayments.feeaugmoney',
                'feepayments.feesepmoney',
                'feepayments.feeoctmoney',
                'feepayments.feenovmoney',
                'feepayments.feedecmoney',
                'feepayments.feejanmoney',
                'feepayments.feefebmoney',
                'feepayments.feemarmoney',
                'feepayments.feeaprpay',
                'feepayments.feemaypay',
                'feepayments.feejunpay',
                'feepayments.feejulpay',
                'feepayments.feeaugpay',
                'feepayments.feeseppay',
                'feepayments.feeoctpay',
                'feepayments.feenovpay',
                'feepayments.feedecpay',
                'feepayments.feejanpay',
                'feepayments.feefebpay',
                'feepayments.feemarpay'
            )
            ->get();
        return view('admin.currentyearpendingfeesstudents', $result);
    }

    public function currentyearpendingfeesexport(request $request)
    {
        for ($i = 0; $i < count($request->post('feepaymentid')); $i++) {
            $model = feepayment::find($request->post('feepaymentid')[$i]);
            $model->exportmonth = date('F');
            $model->exportpendingmoney = $request->post('pendingmoney')[$i];
            $model->save();
        }
        $class = $request->post('class');
        $section = $request->post('section');
        $name = 'Student Current Year Pending Fees List';
        return Excel::download(new studentcurrentyearpendingfeesExport($class, $section), $name . '.xlsx');
    }
}