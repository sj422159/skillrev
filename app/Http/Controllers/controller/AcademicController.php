<?php
namespace App\Http\Controllers\controller;


use App\Models\ControllerModel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Hash; 
use App\Models\User; 
use App\Models\controllers;
use App\Models\skillset;
use App\Models\category;
use App\Models\domain;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\find;
use Illuminate\Support\Facades\Response;
use App\Models\admin;
use Illuminate\Support\Str;

use Mail;


class AcademicController extends Controller
{
    public function group(Request $request)
    {
        \Log::info("Entering group method");
    
        // Check if either 'ADMIN_ID' or 'Controller_ID' is set in the session
        if (session()->has('ADMIN_ID')) {
            $aid = session()->get('ADMIN_ID');
            \Log::info("Using ADMIN_ID session value: " . $aid);
    
            // Fetch groups created by the admin (matching `aid` with `ADMIN_ID`)
            $result['group'] = DB::table('groups')->where('aid', $aid)->get();
        } elseif (session()->has('Controller_ID')) {
            $controllerId = session()->get('Controller_ID');
            \Log::info("Using Controller_ID session value: " . $controllerId);
    
            // Fetch groups created by the controller (matching `controller_id` with `Controller_ID`)
            $result['group'] = DB::table('groups')->where('controller_id', $controllerId)->get();
        } else {
            \Log::info("Neither ADMIN_ID nor Controller_ID is set in session");
            return redirect()->route('home')->with('error', 'User ID is not set in the session.');
        }
    
        return view('admin.group', $result);
    }
    


    public function category(Request $request)
    {
        $aid = session()->get('ADMIN_ID');
        $controller_id = session()->get('Controller_ID');

        $result['groups'] = DB::table('groups')
            ->where('aid', $aid)
            ->orWhere('groups.controller_id', $controller_id) 
            ->get();
    
        $result['groupid'] = '';

        $result['category'] = DB::table('categories')
            ->join('groups', 'groups.id', '=', 'categories.groupid')
            ->where('groups.aid', $aid)
            ->orWhere('categories.controller_id', $controller_id) 
            ->select('groups.group', 'categories.*')
            ->get();
    
        return view('admin.category', $result);
    }
    
        
    public function categorybygroup(Request $request){
        $groupid=$request->post('groupid');
        $aid = session()->get('ADMIN_ID');
        $controller_id = session()->get('Controller_ID');
        $result['groups']=DB::table('groups')->where('aid', $aid)->orWhere('controller_id', $controller_id)->get();
        $result['groupid']=$groupid;
        $result['category']=DB::table('categories')
                                ->join('groups','groups.id','categories.groupid')
                                ->where('categories.aid',$aid)->orwhere('categories.controller_id',$controller_id)
                                ->where('categories.groupid',$groupid)
                                ->select('groups.group','categories.*')
                                ->get();
                return view('admin.category',$result);
            }
        
            public function addcategory(Request $request, $id = "") {   
                $aid = session()->get('ADMIN_ID');
                $controller_id = session()->get('Controller_ID', 0);
            
                if ($id > 0) {
                    $arr = category::where(['id' => $id])->get();
                    $result['id'] = $arr[0]->id;
                    $result['category'] = $arr[0]->categories;
                    $result['shortcateg'] = $arr[0]->shortcateg;
                    $result['max'] = $arr[0]->cmaxperiod;
                    $result['groupid'] = $arr[0]->groupid;
                    $result['standardid'] = $arr[0]->standardid;
                } else {
                    $result['id'] = '';
                    $result['category'] = '';
                    $result['shortcateg'] = '';
                    $result['groupid'] = '';
                    $result['standardid'] = '';
                    $result['max'] = 0;
                }
                $result['groups'] = DB::table('groups')
                    ->where(function ($query) use ($aid, $controller_id) {
                        $query->where('aid', $aid)->orWhere('controller_id', $controller_id);
                    })
                    ->get();
                
                $result['standards'] = DB::table('standards')->get();
                return view("admin.addcategory", $result);
            }
            
            public function savecategory(Request $request) {
                try {
                    $aid = session()->get('ADMIN_ID');
                    $controller_id = session()->get('Controller_ID');
                    $controller_admin_id = session()->get('Controller_ADMIN_ID');
            
                    if ($request->post('id') > 0) {
                        $model = category::find($request->post('id'));
            
                        if (!$model) {
                            $request->session()->flash('danger', 'Category not found.');
                            return redirect()->back();
                        }
            
                        $msg = "Category updated";
                        $data = DB::table('standards')->where('id', $request->post('standardid'))->get();
            
                        if ($data->isEmpty()) {
                            $request->session()->flash('danger', 'Standard not found.');
                            return redirect()->back();
                        }
            
                        $category = "STANDARD " . $data[0]->name;
                        if ($aid) {
                            $model->aid = $aid;
                        }elseif ($controller_id) {
                            $model->aid =$controller_admin_id;
                            $model->controller_id = $controller_id;
                        }
                       
                       
                        $model->groupid = $request->post('groupid');
                        $model->standardid = $request->post('standardid');
                        $model->categories = $category;
                        $model->shortcateg = $request->post('shortcat');
                        $model->cmaxperiod = $request->post('max');
                        $model->save();
            
                        $request->session()->flash('message', $msg);
                    } else {
                        $existingCategory = DB::table('categories')
                            ->where('standardid', $request->post('standardid'))
                            ->where(function ($query) use ($aid, $controller_id) {
                                $query->where('aid', $aid)->orWhere('controller_id', $controller_id);
                            })
                            ->get();
            
                        if ($existingCategory->isEmpty()) {
                            $model = new category();
                            $msg = "Category inserted";
            
                            $data = DB::table('standards')->where('id', $request->post('standardid'))->get();
            
                            if ($data->isEmpty()) {
                                $request->session()->flash('danger', 'Standard not found.');
                                return redirect()->back();
                            }
            
                            $category = "STANDARD " . $data[0]->name;
                            if ($aid) {
                                $model->aid = $aid;
                            }elseif ($controller_id) {
                                $model->aid =$controller_admin_id;
                                $model->controller_id = $controller_id;
                            }
                           
                            $model->groupid = $request->post('groupid');
                            $model->standardid = $request->post('standardid');
                            $model->categories = $category;
                            $model->shortcateg = $request->post('shortcat');
                            $model->cmaxperiod = $request->post('max');
                            $model->save();
            
                            $request->session()->flash('message', $msg);
                        } else {
                            $request->session()->flash('danger', 'Standard Already Exists.');
                            return redirect()->back();
                        }
                    }
            
                    if ($request->post('id') > 0) {
                        DB::table('domains')->where('category', $request->post('id'))
                            ->update(['groupid' => $request->post('groupid')]);
            
                        DB::table('skillsets')->where('category', $request->post('id'))
                            ->update(['groupid' => $request->post('groupid')]);
            
                        DB::table('skillattributes')->where('category', $request->post('id'))
                            ->update(['groupid' => $request->post('groupid')]);
            
                        DB::table('lmssections')->where('classid', $request->post('id'))
                            ->update(['groupid' => $request->post('groupid')]);
                    }
            
                    return redirect('controller/standard');
                } catch (\Exception $e) {
                    \Log::error('Error saving category: ' . $e->getMessage());
                    $request->session()->flash('danger', 'An error occurred: ' . $e->getMessage());
                    return redirect()->back();
                }
            }
            
            
        
            public function categorydelete(Request $request, $id){
                $model=category::find($id);
                $model->delete();
                $request->session()->flash('message','Category Deleted');
                return redirect('controller/standard');
            }
        
    public function login()
    {
        // Return login view
        return view('controller.login');
    }
    public function adddetails(Request $request, $id = "")
    {
        // Retrieve the session's Controller ID
        $sesid = session()->get('Controller_ID');
        $result = [];
    
        // Fetch controller details from the database
        $controllerData = DB::table('controller')->where(['id' => $sesid])->first();
    
        if ($controllerData) {
            $result['id'] = $controllerData->id;
            $result['name'] = $controllerData->name;
            $result['email'] = $controllerData->email;
            $result['number'] = $controllerData->number;
            $result['image'] = $controllerData->image;
            $controllerRoleId = $controllerData->Controller_role_ID; // Use proper field name
        } else {
            // Default values if no data found
            $result['id'] = '';
            $result['name'] = '';
            $result['email'] = '';
            $result['number'] = '';
            $result['image'] = '';
            $controllerRoleId = null;
        }
    
        // Handle role-based view rendering
        switch ($controllerRoleId) {
            case 1:
                return view('controller.academ.adddetails', $result);
            case 2:
                return view('controller.exam.adddetails', $result);
            case 3:
                return view('controller.account.adddetails', $result);
            default:
                return redirect('/'); // Redirect to home or an appropriate page
        }
    }
    

    public function savedetails(Request $request)
    {
        $controllerRoleId = null;
    
        if ($request->post('id') > 0) {
            // Find the record by ID
            $model = controllers::find($request->post('id'));
            if (!$model) {
                return redirect()->back()->with('error', 'Record not found for update.');
            }
    
            // Fetch Controller_role_id
            $controllerRoleId = $model->Controller_role_id;
            $msg = "Corporate Details Updated";
        } else {
            $model = new controllers();
            $msg = "Corporate Details Inserted";
        }
    
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $ext = $image->extension();
            $image_name = time() . '.' . $ext;
            $image->move(public_path('adminimages'), $image_name);
            $model->image = $image_name;
        }
    
        // Assign other fields
        $model->name = $request->post('name');
        $model->email = $request->post('email');
        $model->number = $request->post('number');
    
        // Save the model
        $model->save();
    
        // If new, fetch the Controller_role_id after saving
        if (!$controllerRoleId) {
            $controllerRoleId = $model->Controller_role_ID;
        }
        // dd($controllerRoleId);
        // Determine redirection based on Controller_role_id
        switch ($controllerRoleId) {
            case 1:
                $redirectUrl = '/Controller/Academ/dashboard';
                break;
            case 2:
                $redirectUrl = '/dashboard/examination';
                break;
            case 3:
                $redirectUrl = '/Controller/Account/dashboard';
                break;
            default:
                $redirectUrl = '/';
                break;
        }
    
        // Set flash message and redirect
        session()->flash('message', $msg);
        return redirect($redirectUrl);
    }
    
    


public function save(Request $request)
{
    $validatedData = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $email = $request->post('email');

    // Use ControllerModel to check credentials from the 'controller' table
    $result = ControllerModel::where('email', $email)->first();
    
    if ($result) {
        if (Hash::check($request->post('password'), $result->password)) {
            // Set session values after successful login
            session()->put('LOGIN', true);
            session()->put('Controller_ID', $result->id);
            session()->put('Controller_ADMIN_ID', $result->aid);
            session()->put('Controller_Name', $result->name);
            session()->put('Controller_image', $result->image);
            session()->put('Controller_Email', $result->email);
            session()->put('Controller_Number', $result->number);
            session()->flash('success', 'Successfully Logged In');
            switch ($result->Controller_role_ID) {
                case 1:
                    return redirect()->route('dashboard.academic');
                case 2:
                    return redirect()->route('dashboard.examination');
                case 3:
                    return redirect()->route('dashboard.account');
            }
        } else {
            $request->session()->flash("error", "Incorrect Password");
            return redirect()->route('login');
        }
    } else {
        $request->session()->flash("error", "Invalid Login Credentials");
        return redirect()->route('login');
    }
}

    public function showForgotPasswordForm()
    {
        return view('accontrol.forgotpassword'); // Assuming you have a view file accontrol/forgotpassword.blade.php
    }

    /**
     * Handle the forgot password logic.
     */
    public function forgotPasswordCheck(Request $request)
    {
        // Validate the email input
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        // Add logic to send password reset link or email
        // Example: Sending password reset email
        // PasswordReset::sendResetLink($request->only('email'));

        return redirect()->route('login')->with('success', 'Password reset link sent to your email.');
    }

    

    public function academicDashboard()
    {
       $controller_name=session()->get('Controller_Name');
       $sesid=session()->get('Controller_ID');

       $result['image']=controllers::where('id',$sesid)->get();
        return view('controller.dashboard',$result);
    }
    
    public function domain(Request $request){
        $aid=session()->get('ADMIN_ID');
        $controller_id=session()->get('Controller_ID');

        $result['groups']=DB::table('groups')->where('aid',$aid)->orWhere('controller_id', $controller_id)->get();
        $result['domain']=DB::table('domains')->where('aid',$aid)->orwhere('Controller_ID',$controller_id)->get();
        $result['groupid']='';
        $result['categoryid']='';
        return view('admin.domain',$result);
    }

    public function domainbycategory(Request $request){
        $category=$request->post('category');
        $groupid=$request->post('group');
        $aid=session()->get('ADMIN_ID');
        $controller_id=session()->get('Controller_ID');

        $result['groups']=DB::table('groups')->where('aid',$aid)->orWhere('controller_id', $controller_id)->get();
        $result['groupid']=$groupid;
        $result['categoryid']=$category;
        $result['domain']=DB::table('domains')->where('groupid',$groupid)->where('category',$category)->get();
        return view('admin.domain',$result);
    }

    public function adddomain(Request $request, $id = "")
    {
        // Initialize the $result array with default values
        $result = [
            'id' => '',
            'groupid' => '',
            'category' => '',
            'domain' => '',
            'stype' => '',
            'subtype' => '',
            'show' => '',
            'dname' => '',
        ];
        $result['categoryid']='';
        // Check if $id is greater than 0, and fetch domain data
        if ($id > 0) {
            $arr = DB::table('domains')->where('id', $id)->first();
            
            if ($arr) {
                // Populate $result with data from the domain record
                $result = [
                    'id' => $arr->id,
                    'groupid' => $arr->groupid,
                    'category' => $arr->category,
                    'domain' => $arr->domain,
                    'stype' => $arr->stype,
                    'subtype' => $arr->subtype,
                    'show' => $arr->showsub,
                    'dname' => $arr->dname,
                ];
            }
        }
    
        // Fetch session data
        $aid = session()->get('ADMIN_ID');
        $controller_id = session()->get('Controller_ID');

        // Fetch subtypes, groups, and categories based on session data
        $result['subtypes'] = ["CURRICULAR", "EXTRACURICULLAR", "MANDATORY"];
        $result['groups'] = DB::table('groups')
            ->where('aid', $aid)
            ->orWhere('controller_id', $controller_id)
            ->get();
    
      
    
        // Return the view with the result data
        return view('admin.adddomain', $result);
    }
    
    
    public function savedomain(Request $request)
    {
        \Log::info("Entering savedomain method");
    
        $show = ($request->post('show') == "on") ? 1 : 0;
    
        // Prefix setting based on stype
        $pre = match ($request->post('stype')) {
            "CURRICULAR" => "CU",
            "MANDATORY" => "MAN",
            default => "ECU",
        };
    
        // Determine domain model and action
        if ($request->post('id') > 0) {
            $model = domain::find($request->post('id'));
            $msg = "Domain updated";
        } else {
            $model = new domain();
            $msg = "Domain inserted";
        }
    
        // Fetch category name and construct domain name
        $name = DB::table('categories')->where('id', $request->post('category'))->first();
        $domainname = $name->categories . '_' . $name->shortcateg . '_' . $request->post('dname');
        $model->domain = $domainname;
        $model->dname = $request->post('dname');
    
        // Assign the correct ID and set the other to 0
        if (session()->has('ADMIN_ID')) {
            $model->aid = session()->get('ADMIN_ID');
            $model->controller_id = 0;
        } elseif (session()->has('Controller_ID')) {
            $model->controller_id = session()->get('Controller_ID');
            $model->aid = session()->get('Controller_ADMIN_ID');
        } else {
            \Log::info("No ADMIN_ID or Controller_ID in session");
            return redirect()->route('home')->with('error', 'User ID is not set in the session.');
        }
    
        // Assign other model values
        $model->groupid = $request->post('groupid');
        $groupType = DB::table('groups')->where('id', $request->post('groupid'))->value('gtype');
        $model->stype = $groupType;
        $model->category = $request->post('category');
        $model->subtype = $request->post('stype');
        $model->showsub = $show;
        $model->save();
    
        // Flash message for insertion or update
        $request->session()->flash('message', $msg);
    
        // Update related tables if updating an existing domain
        if ($request->post('id') > 0) {
            DB::table('skillsets')->where('domain', $request->post('id'))
                ->update(['groupid' => $request->post('groupid'), 'category' => $request->post('category')]);
    
            DB::table('skillattributes')->where('domain', $request->post('id'))
                ->update(['groupid' => $request->post('groupid'), 'category' => $request->post('category')]);
        }
    
        return redirect('admin/domain');
    }
    
    public function delete(Request $request, $id){
        $model=domain::find($id);
        $model->delete();
        $request->session()->flash('message','Domain Deleted');
        return redirect('admin/domain');
    }
    
    public function skillset(Request $request){
        $aid=session()->get('ADMIN_ID');
        $controller_id=session()->get('Controller_ID');
        $controller_admin_id=session()->get('Controller_ADMIN_ID');

        $result['skillset']=DB::table('skillsets')->where('aid',$aid)->orwhere('aid',$controller_admin_id)->get();
    
         $result['groups'] = DB::table('groups')
        ->distinct()
        ->select('id', 'group')
        ->where(function($query) use ($aid, $controller_id) {
            $query->where('groups.aid', $aid)
                  ->orWhere('groups.Controller_ID', $controller_id);
        })
        ->get();
    
    
        $result['groupid']='';
        $result['categoryid']='';
        $result['domain']='';
        // $result['skillset']=[];
        return view('admin.skillset',$result);
    }

    public function skillsetbydomain(Request $request){
        $aid=session()->get('ADMIN_ID');
        $controller_id=session()->get('Controller_ID');
        $controller_admin_id=session()->get('Controller_ADMIN_ID');

        $groupid=$request->post('group');
        $category=$request->post('category');
        $domain=$request->post('domain');
        $result['groups']=DB::table('groups')->where('aid',$aid)->orWhere('aid',$controller_admin_id)->get();
        $result['groupid']=$groupid;
        $result['categoryid']=$category;
        $result['domainid']=$domain;
        $result['skillset']=DB::table('skillsets')->where('domain',$domain)->where('aid',$controller_admin_id)->get();
        return view('admin.skillset',$result);
    }

    public function addSkillset($id = null)
    {
        $aid=session()->get('ADMIN_ID');
        $controller_id=session()->get('Controller_ID');
        $controller_admin_id=session()->get('Controller_ADMIN_ID');

        if ($id) {
            // Fetch skillset data for editing
            $skillset = DB::table('skillsets')->where('id', $id)->first();
    
            if (!$skillset) {
                return redirect('admin/skillset')->with('error', 'Skillset not found!');
            }
        } else {
            // Initialize an empty object for creating a new skillset
            $skillset = (object) [
                'groupid' => '',
                'category' => '',
                'domain' => '',
                'skillset' => '',
                'id' => ''
            ];
        }
    
        $groups=DB::table('groups')->where('aid',$aid)->orWhere('Controller_ID',$controller_id)->get();
        $categories=DB::table('categories')->where('aid',$aid)->orwhere('Controller_ID',$controller_id)->get();
        $domain=DB::table('domains')->where('aid',$aid)->orwhere('Controller_ID',$controller_id)->get();
        
        // Pass data to the view
        return view('admin.addskillset', compact('skillset', 'groups', 'categories', 'domain'));
    }
    
     
    public function saveskillset(Request $request)
    {
        $adminId = session()->get('ADMIN_ID');
        $controllerId = session()->get('Controller_ID');
        $controllerAdminId = session()->get('Controller_ADMIN_ID');

        $id = $request->post('id');
        $domainData = DB::table('domains')->where('id', $request->post('domain'))->first();

        if (!$domainData) {
            return back()->withErrors(['error' => 'Invalid domain selected']);
        }

        $skillsetName = $domainData->domain . '_' . $request->post('skillset');

        if ($id && DB::table('skillsets')->where('id', $id)->exists()) {
            DB::table('skillsets')
                ->where('id', $id)
                ->update([
                    'skillset' => $skillsetName,
                    'aid' => $adminId ? $adminId : $controllerAdminId,
                    'controller_id' => $adminId ? 0 : $controllerId,
                    'groupid' => $request->post('groupid'),
                    'category' => $request->post('category'),
                    'domain' => $request->post('domain'),
                    'updated_at' => now(),
                ]);
            $request->session()->flash('message', 'Skillset updated successfully');
        } else {
            if ($id) {
                logger()->error("Skillset ID {$id} not found for update.");
            }

            DB::table('skillsets')->insert([
                'skillset' => $skillsetName,
                'aid' => $adminId ? $adminId : $controllerAdminId,
                'controller_id' => $adminId ? 0 : $controllerId,
                'groupid' => $request->post('groupid'),
                'category' => $request->post('category'),
                'domain' => $request->post('domain'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $request->session()->flash('message', 'Skillset inserted successfully');
        }
        
    
        return redirect('admin/skillset');
    }
    
    public function editSkillset($id)
    {
        $aid=session()->get('ADMIN_ID');
        $controller_id=session()->get('Controller_ID');
 $skillset = DB::table('skillsets')->where('id', $id)->first();

 // Check if the skillset exists
 if (!$skillset) {
     return redirect('admin/skillset')->with('error', 'Skillset not found!');
 }

 // Fetch the group related to the skillset's groupid
 $groups=DB::table('groups')->where('aid',$aid)->orWhere('Controller_ID',$controller_id)->get();
 $categories=DB::table('categories')->where('aid',$aid)->orwhere('Controller_ID',$controller_id)->get();
 $selectedGroup = DB::table('groups')->where('id', $skillset->groupid)->first();

 // Fetch the remaining dropdown data
 $categories = DB::table('categories')->get();
 $domain = DB::table('domains')->get();

 // Pass the data to the view
        return view('admin.addskillset', compact('skillset', 'groups', 'categories', 'domain'));
    }
    
    
    public function skillsetdelete(Request $request,$id){
        $model=skillset::find($id);
        $model->delete();
        $request->session()->flash('message','skillset Deleted');
       return redirect('admin/skillset');
    }

    public function skillattribute(Request $request){
        $aid=session()->get('ADMIN_ID');
        $controller_id=session()->get('Controller_ID');
        $result['groups']=DB::table('groups')->where('aid',$aid)->orWhere('Controller_ID',$controller_id)->get();
        $result['groupid']='';
        $result['categoryid']='';
        $result['domainid']='';
        $result['skillsetid']='';
        $result['skillattribute']=DB::table('skillattributes')->where('aid',$aid)->orwhere('Controller_ID',$controller_id)->get();
        return view('admin.skillattribute',$result);
    }

    public function skillattributebyskillset(Request $request){
        $aid=session()->get('ADMIN_ID');
        $controller_id=session()->get('Controller_ID');
        $groupid=$request->post('group');
        $category=$request->post('category');
        $domain=$request->post('domain');
        $skillset=$request->post('skillset');
        $result['groups']=DB::table('groups')->where('aid',$aid)->orWhere('Controller_ID',$controller_id)->get();
        $result['groupid']=$groupid;
        $result['categoryid']=$category;
        $result['domainid']=$domain;
        $result['skillsetid']=$skillset;
        $result['skillattribute']=DB::table('skillattributes')->where('skillset',$skillset)->get();
        return view('admin.skillattribute',$result);
    }

    public function addskillattribute(Request $request,$id=""){      
        if ($id > 0) {
            // Retrieve the record using the query builder
            $arr = DB::table('skillattributes')->where('id', $id)->first();
        
            // Check if the record exists
            if ($arr) {
                $result['id'] = $arr->id;
                $result['groupid'] = $arr->groupid;
                $result['category'] = $arr->category;
                $result['domain'] = $arr->domain;
                $result['skillset'] = $arr->skillset;
                $result['skillattribute'] = $arr->skillattribute;
            } else {
                return redirect()->back()->with('error', 'Record not found.');
            }
        }
        
        else{
            $result['id']='';
            $result['groupid']='';
            // $result['category']='';
            // $result['categoryid']='';
            $result['domain']='';
            $result['skillset']='';
            $result['skillattribute']='';    
        }
        $aid=session()->get('ADMIN_ID');
        $controller_id=session()->get('Controller_ID');
        $result['groups']=DB::table('groups')->where('aid',$aid)->orWhere('controller_id',$controller_id)->get();

        $result['skillsets'] = DB::table('skillsets')
    
    ->join('groups', 'skillsets.groupid', '=', 'groups.id')

    ->join('categories', 'skillsets.category', '=', 'categories.id')

    ->join('domains', 'skillsets.domain', '=', 'domains.id')

    ->select('skillsets.*', 'groups.group as group_name', 'categories.categories as category_name', 'domains.dname')

    ->where(function($query) use ($aid, $controller_id) {
        $query->where('skillsets.aid', $aid)
              ->orWhere('skillsets.Controller_ID', $controller_id);
    })
    ->get();





        return view("admin.addskillattribute",$result);
    }
    public function saveskillattribute(Request $request)
    {
        if (session()->has('ADMIN_ID')) {
            $aid = session()->get('ADMIN_ID');
            $controller_id = 0;
        } elseif (session()->has('Controller_ID')) {
            $controller_id = session()->get('Controller_ID');
            $aid = session()->get('Controller_ADMIN_ID');  
        } else {
            return redirect()->back()->with('error', 'No valid session found for Admin or Controller');
        }

        if (is_null($aid)) {
            return redirect()->back()->with('error', 'No valid admin or controller session available');
        }
        $name = DB::table('skillsets')->where('id', $request->post('skillset'))->first();
        $skillattributename = $name->skillset . ' _ ' . $request->post('skillattribute');

        $data = [
            'skillattribute' => $skillattributename,
            'aid' => $aid,
            'controller_id' => $controller_id,
            'groupid' => $request->post('groupid'),
            'category' => $request->post('category'),
            'domain' => $request->post('domain'),
            'skillset' => $request->post('skillset'),
        ];
    
        // Check if ID exists for update or insert
        if ($request->post('id') > 0) {
            // Update existing record
            DB::table('skillattributes')
                ->where('id', $request->post('id'))
                ->update($data);
    
            $msg = "Skillattribute updated";
        } else {
            // Insert new record
            DB::table('skillattributes')->insert($data);
            $msg = "Skillattribute inserted";
        }
    
        // Flash message and redirect
        $request->session()->flash('message', $msg);
        return redirect('admin/skillattribute');
    }
    
    

    public function skillattributedelete(Request $request, $id){
        $model=skillattribute::find($id);
        $model->delete();
        $request->session()->flash('message','Skillattribute Deleted');
        return redirect('admin/skillattribute');
    }

    public  function getdomain(){
        $id = $_GET['myID'];
        $res = DB::table('domains')->where('category',$id)->get();
        return Response::json($res);
    }

    public  function getskillset(){
        $id = $_GET['id'];
        $res = DB::table('skillsets')->where('domain', $id)->get();
        return Response::json($res);
    }
    public function getskillattribute(Request $request)
    {
        // Validate input fields
        $group = $request->group;
        $category = $request->category;
        $domain = $request->domain;
    
        // Query skill attributes based on filters
        $skillattributes = DB::table('skillattributes')
            ->where('groupid', $group)
            ->where('category', $category)
            ->where('domain', $domain)
            ->get(['id', 'name']); // Return only id and name for the dropdown
    
        // Return data as JSON response
        return response()->json($skillattributes);
    }
    
    public function getSkillAttributes(Request $request)
    {
        // Get session values for admin or controller
        if (session()->has('ADMIN_ID')) {
            $aid = session()->get('ADMIN_ID');
            $controller_id = 0;
        } elseif (session()->has('Controller_ID')) {
            $controller_id = session()->get('Controller_ID');
            $aid = session()->get('Controller_ADMIN_ID');  // Use Controller_ADMIN_ID for aid
        } else {
            return redirect()->back()->with('error', 'No valid session found for Admin or Controller');
        }
    
        // Start query for skill attributes
        $query = DB::table('skillattributes')->where(function ($q) use ($aid, $controller_id) {
            // Filter based on session user (aid or controller_id)
            if ($aid > 0) {
                $q->where('aid', $aid);
            } elseif ($controller_id > 0) {
                $q->where('controller_id', $controller_id);
            }
        });
    
        // Apply filters if any
        if ($request->has('group') && $request->group != '') {
            $query->where('groupid', $request->group);
            $group = $request->group; // Pass the group filter
        } else {
            $group = null; // No group filter, pass null
        }
    
        if ($request->has('category') && $request->category != '') {
            $query->where('category', $request->category);
            $category = $request->category; // Pass the category filter
        } else {
            $category = null; // No category filter, pass null
        }
    
        if ($request->has('domain') && $request->domain != '') {
            $query->where('domain', $request->domain);
            $domain = $request->domain; // Pass the domain filter
        } else {
            $domain = null; // No domain filter, pass null
        }
    
        if ($request->has('skillset') && $request->skillset != '') {
            $query->where('skillset', $request->skillset);
            $skillset = $request->skillset; // Pass the skillset filter
        } else {
            $skillset = null; // No skillset filter, pass null
        }
    
        // Get the filtered skill attributes
        $skillattribute = $query->get();
    
        // Get the filter options for the dropdowns
        $groups = DB::table('groups')->get(); // Adjust as needed
        $categories = DB::table('categories')->get(); // Adjust as needed
        $domains = DB::table('domains')->get(); // Adjust as needed
        $skillsets = DB::table('skillsets')->get(); // Adjust as needed
    
        return view('admin.skillattribute.index', compact('skillattribute', 'groups', 'categories', 'domains', 'skillsets', 'group', 'category', 'domain', 'skillset'));
    }
    
    

    public function skillsetcategory($id){
        $aid=session()->get('ADMIN_ID');
        $controller_id=session()->get('Controller_ID');
        $controller_admin_id=session()->get('Controller_ADMIN_ID');
        $id = $_GET['myID'];
       
        $res = DB::table('categories')->where('groupid',$id)->where('aid',$aid)->orwhere('Controller_ID',$controller_id)->get();
     
        return Response::json($res);
    }

    public function skillsetdomain($id){
        $id = $_GET['id'];
        $res = DB::table('domains')->where('category',$id)->get();
        return Response::json($res);
    }

    public function getdomains($id){
        $id = $_GET['id'];
        $groupid= $_GET['groupid'];
        if ($groupid==0) {
            $res = DB::table('domains')->where('category',$id)->get();
        } else {
            $res = DB::table('domains')->where('category',$id)->where('groupid',$groupid)->get();
        } 
        return Response::json($res);
    }

    public function getskillsets($id){
        $id = $_GET['id'];
        $res = DB::table('skillsets')->where('domain',$id)->get();
        return Response::json($res);
    }

    public  function skillsetgetdomains(request $request){
        $aid=session()->get('ADMIN_ID');
        $controller_id=session()->get('Controller_ID');
        $controller_admin_id=session()->get('Controller_ADMIN_ID');
        $cid = $request->post('cid');
        $groupid = $request->post('groupid');
        $a=DB::table('groups')->where('id',$groupid)->get();
        $state = DB::table('domains')->where('category', $cid)->where('aid',$aid)->orwhere('aid',$controller_admin_id)->get();
        echo $html='<option value="">Select </option>';
        foreach($state as $list){
        echo  $html='<option value="'.$list->id.'">'.$list->domain.'</option>';
        }
    } 
    public function reports(){
        $aid=session()->get('ADMIN_ID'); 
        $controller_id=session()->get('Controller_ID');
        $result['train']=DB::table('trainings')->where('aid',$aid)->orwhere('Controller_ID',$controller_id)->where('status',1)->get();
        $result['class']=DB::table('categories')->where('aid',$aid)->orwhere('Controller_ID',$controller_id)->get();
        $result['cl']=0;
        $result['section']=0;
        $result['tri']=0;
        $result['data']=[];
        return view('admin.assignments',$result);
    }

    public function fetchstu(request $request){
        $aid=session()->get('ADMIN_ID');
        $controller_id=session()->get('Controller_ID');
        $result['train']=DB::table('trainings')->where('aid',$aid)->orwhere('Controller_ID',$controller_id)->where('status',1)->get();
        $result['class']=DB::table('categories')->where('aid',$aid)->orwhere('Controller_ID',$controller_id)->get(); 
        $result['cl']=$request->post('class');
        $result['tri']=$request->post('training');
        $result['section']=$request->post('section');
        $result['data']=DB::table('studentassignmentbookings')
                        ->join('students','studentassignmentbookings.sid','students.id')
                        ->join('trainingtypes','studentassignmentbookings.trainingtype','trainingtypes.id')
                        ->join('trainings','studentassignmentbookings.trainingid','trainings.id')
                        ->join('lmssections','students.ssectionid','lmssections.id')
                        ->join('categories','students.sclassid','categories.id')
                        ->where('students.sclassid',$request->post('class'))
                        ->where('students.ssectionid',$request->post('section'))
                        ->where('studentassignmentbookings.trainingid',$request->post('training'))
                        ->select('studentassignmentbookings.*','students.sname','students.slname','trainingtypes.type','trainings.trainingname','students.image')
                        ->get();
        return view('admin.assignments',$result);
    } 
    public function months() {
       
        $adminid = session()->get('ADMIN_ID');
        $controller_id=session()->get('Controller_ID');
        $result['classes'] = DB::table('categories')->where('aid', $adminid)->orwhere('Controller_ID',$controller_id)->get();
        $result['class'] = ""; 
        $result['month'] = ""; 
        $result['months'] = array(
            "January", "February", "March", "April", "May", "June", "July",
            "August", "September", "October", "November", "December"
        ); 
        $result['dates'] = ""; 
        $result['year'] = date('Y'); 
        $result['currentmonth'] = date('m'); 

        $result['student'] = [];
        $result['attendance'] = [];
        $result['attendances'] = [];

        return view('admin.attendancemonths', $result);
    }
    

    public  function getsections(request $request){
        $classid = $request->post('classid');
        $state = DB::table('lmssections')->where('classid',$classid)->get();
        echo $html='<option value="">Select</option>';
        foreach($state as $list){
          echo  $html='<option value="'.$list->id.'">'.$list->section.'</option>';
        }
    } 

    public  function getdates(request $request){
        $monthid = $request->post('monthid');
        $sectionid = $request->post('sectionid');
        $state = DB::table('attendances')
                ->where('month',$monthid)->where('sectionid',$sectionid)->where('year',date('Y'))->get();
        echo $html='<option value="">Select</option>';
        foreach($state as $list){
          echo  $html='<option value="'.$list->date.'">'.$list->date.'</option>';
        }
    } 
 
    public function students(Request $request){
       
        $aid = session()->get('ADMIN_ID');
        $controller_id = session()->get('Controller_ID'); 
    
        $result['classes'] = DB::table('categories')->where('aid', $aid)->orWhere('Controller_ID', $controller_id)->get(); // Fetching classes based on the logged-in user's ID
        $result['class'] = $request->post('class');
        $result['months'] = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"); 
        $result['month'] = $request->post('month');
        $result['dates'] = $request->post('date');
        $result['year'] = date('Y');
        $result['currentmonth'] = date('m');
    
        // Retrieving attendance data
        $date = $request->post('date');
        $classid = $request->post('class');
        $section = $request->post('section');
        
        $result['attendances'] = DB::table('attendances')
            ->where('date', $date)
            ->where('classid', $classid)
            ->where('sectionid', $section)
            ->get(['studentid', 'attendancetype', 'attendance']);
    
        // Split student IDs and attendance statuses
        $a = explode("##", $result['attendances'][0]->studentid);
        $student = DB::table('students')->whereIn('id', $a)->get(['sname', 'slname']);
    
        // Split the attendance values
        $b = explode("##", $result['attendances'][0]->attendance);
        $result['student'] = [];
        $result['attendance'] = [];
    
        // Prepare the result arrays for student names and attendance statuses
        for ($i = 0; $i < count($student); $i++) {
            $result['student'][$i] = $student[$i]->sname . " " . $student[$i]->slname;
            if ($result['attendances'][0]->attendancetype == "1") {
                $result['attendance'][$i] = $b[$i];
            } else {
                $result['attendance'][$i] = $b[0];
            }
        }
    
        return view('admin.attendancemonths', $result);
    }
    public function sendmail($id, Request $request)
    {
        // Fetch the controller using the provided ID
        $model = controllers::find($id);
    
        // Check if the model is found
        if (!$model) {
            return redirect('controller')->with('error', 'Controller not found!');
        }
    
        // Generate a random password
        $randomPassword = Str::random(10); // You can adjust the length as needed
    
        // Set the random password to the model and save it
        $model->password = bcrypt($randomPassword); // Hash the password before saving
        $model->save();
    
        // Prepare the data to send via mail
        $data = [
            'name' => $model->name,
            'email' => $model->email,
            'number' => $model->number,
            'password' => $randomPassword, // Send the raw password in the email
        ];
    
        // Define the recipient email address
        $user['to'] = $model->email;
    
        try {
            // Send the email
            Mail::send('mail.controllerregistermail', $data, function ($messages) use ($user) {
                $messages->to($user['to']);
                $messages->subject('Login Credentials Of Your Account');
            });
    
            // Update mailstatus only after mail is successfully sent
            $model->mailstatus = 1;
            $model->save();
    
            // Flash success message
            $request->session()->flash('success', 'Mail Sent Successfully');
            return redirect('controller');
        } catch (\Exception $e) {
            // Catch any errors and display them
            return redirect('controller')->with('error', 'Error sending mail: ' . $e->getMessage());
        }
    }
    public function profile()
    {
        $id = session()->get('Controller_ID');
        $controller = controllers::find($id); // Fetch the controller data
    
        // Determine layout based on Controller_role_ID
        $layout = match ($controller->Controller_role_ID) {
            1 => 'controller/academ/layout',
            2 => 'controller/exam/elayout',
            3 => 'controller/account/Alayout',
            default => 'layouts/default',
        };
    
        $model['data'] = controllers::where('id', $id)->get();
    
        // Pass the layout dynamically to the view
        return view('controller.profile', ['model' => $model, 'layout' => $layout]);
    }
    

    public function update(Request $request)
    {
        $id = session()->get('Controller_ID');
        $pwd = $request->post('npass');
        $repwd = $request->post('cpass');
    
        if ($pwd !== $repwd) {
            session()->flash('error', "Passwords Are Not Matching");
            return redirect('controller/profile');
        }
    
        $model1 = controllers::find($id);
    
        if (Hash::check($request->post('opass'), $model1->password)) {
            $model = controllers::find($id);
    
            if ($pwd == '' && $repwd == '') {
                $model->password = Hash::make($request->post('opass'));
            } else {
                $model->password = Hash::make($request->post('npass'));
            }
    
            $model->save();
            session()->flash('message', 'Profile Updated Successfully');
    
            // Fetch the Controller_role_ID for redirection
            $controllerRoleId = $model->Controller_role_ID;
    
            // Determine redirection based on Controller_role_ID
            switch ($controllerRoleId) {
                case 1:
                    $redirectUrl = '/Controller/Academ/dashboard';
                    break;
                case 2:
                    $redirectUrl = '/dashboard/examination';
                    break;
                case 3:
                    $redirectUrl = '/Controller/Account/dashboard';
                    break;
                default:
                    $redirectUrl = '/';
                    break;
            }
    
            return redirect($redirectUrl);
        } else {
            session()->flash('error', 'Old Password Not Matched');
            return redirect('controller/profile');
        }
    }
    
    
}


