<?php

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\lmsrolecontroller;
use App\Http\Controllers\admin\lmsbatchcontroller;
use App\Http\Controllers\admin\lmsgroupcontroller;
use App\Http\Controllers\admin\adminfeescontroller;
use App\Http\Controllers\admin\adminlifecontroller;
use App\Http\Controllers\admin\lmshostelcontroller;
use App\Http\Controllers\admin\lmsperiodcontroller;
use App\Http\Controllers\admin\ControllerName;

use App\Http\Controllers\caterer\caterercontroller;
use App\Http\Controllers\faculty\facultycontroller;
use App\Http\Controllers\manager\managercontroller;
use App\Http\Controllers\student\studentcontroller;
use App\Http\Controllers\admin\adminleavecontroller;
use App\Http\Controllers\admin\lmsfacultycontroller;
use App\Http\Controllers\admin\lmsholidaycontroller;
use App\Http\Controllers\admin\lmsmanagercontroller;
use App\Http\Controllers\admin\lmssectioncontroller;
use App\Http\Controllers\student\mainexamcontroller;
use App\Http\Controllers\manager\lifecyclecontroller;
use App\Http\Controllers\admin\adminnontechcontroller;
use App\Http\Controllers\admin\schedulelistcontroller;
use App\Http\Controllers\student\examreportcontroller;
use App\Http\Controllers\admin\adminanalyticcontroller;
use App\Http\Controllers\admin\lmsassesmentscontroller;
use App\Http\Controllers\admin\lmsmanagementcontroller;
use App\Http\Controllers\admin\lmssupervisorcontroller;
use App\Http\Controllers\classteacher\reportcontroller;
use App\Http\Controllers\manager\managerfeescontroller;
use App\Http\Controllers\student\studentfeescontroller;
use App\Http\Controllers\student\studentlifecontroller;
use App\Http\Controllers\admin\lmsassignmentscontroller;
use App\Http\Controllers\faculty\facultyleavecontroller;
use App\Http\Controllers\manager\managerleavecontroller;
use App\Http\Controllers\supervisor\supdetailcontroller;
use App\Http\Controllers\admin\adminattendancecontroller;
use App\Http\Controllers\admin\lmsauthenticatecontroller;
use App\Http\Controllers\admin\lmsquestionbankcontroller;
use App\Http\Controllers\manager\studentuploadcontroller;

use App\Http\Controllers\supervisor\supervisorcontroller;
use App\Http\Controllers\admin\lmsuploaddetailscontroller;
use App\Http\Controllers\faculty\facultyreportscontroller;
use App\Http\Controllers\manager\managerpromotecontroller;
use App\Http\Controllers\student\studentcontentcontroller;
use App\Http\Controllers\supervisor\manutilizercontroller;
use App\Http\Controllers\supervisor\supschedulecontroller;
use App\Http\Controllers\classteacher\classinfracontroller;
use App\Http\Controllers\faculty\facculyschedulecontroller;
use App\Http\Controllers\faculty\facultyanalyticcontroller;
use App\Http\Controllers\manager\manageranalyticcontroller;
use App\Http\Controllers\manager\managertrainingcontroller;
use App\Http\Controllers\manager\trainingprogramcontroller;
use App\Http\Controllers\marketingmanager\mmauthcontroller;
use App\Http\Controllers\marketingofficer\moauthcontroller;
use App\Http\Controllers\marketingofficer\moindexcontroller;
use App\Http\Controllers\classteacher\classteachercontroller;
use App\Http\Controllers\faculty\facultyassignmentcontroller;
use App\Http\Controllers\faculty\facultyattendancecontroller;

use App\Http\Controllers\manager\managerattendancecontroller;
use App\Http\Controllers\nontechstaff\nontechstaffcontroller;
use App\Http\Controllers\student\studentassignmentcontroller;
use App\Http\Controllers\student\studentattendancecontroller;
use App\Http\Controllers\supervisor\supcompetitioncontroller;
use App\Http\Controllers\supervisor\supervisorfeescontroller;
use App\Http\Controllers\supervisor\supervisorlifecontroller;
use App\Http\Controllers\supervisor\suputilizationcontroller;
use App\Http\Controllers\admin\lmsassesmentsectionscontroller;
use App\Http\Controllers\admin\lmscontentmanagementcontroller;
use App\Http\Controllers\caterer\catereritemsselectcontroller;
use App\Http\Controllers\manager\managerassignmentscontroller;
use App\Http\Controllers\manager\managercompetitioncontroller;
use App\Http\Controllers\student\studentcompetitioncontroller;
use App\Http\Controllers\supervisor\supervisorleavecontroller;
use App\Http\Controllers\manager\managerdistributioncontroller;
use App\Http\Controllers\manager\managerschedulelistcontroller;
use App\Http\Controllers\marketingmanager\mmcoldcallcontroller;

use App\Http\Controllers\marketingofficer\mocoldcallcontroller;
use App\Http\Controllers\supervisor\supervisorperiodcontroller;
use App\Http\Controllers\admin\admincompetitionreportcontroller;
use App\Http\Controllers\admin\admintotalfeesanalyticcontroller;
use App\Http\Controllers\admin\lmsstudentassignationscontroller;
use App\Http\Controllers\nontechgroupmanager\foodinfocontroller;
use App\Http\Controllers\admin\adminassignmentanalyticcontroller;
use App\Http\Controllers\admin\adminattendanceanalyticcontroller;
use App\Http\Controllers\classteacher\classteacherfeescontroller;
use App\Http\Controllers\classteacher\classteacherlifecontroller;
use App\Http\Controllers\nontechgroupmanager\infrainfocontroller;
use App\Http\Controllers\nontechmanager\nontechmanagercontroller;
use App\Http\Controllers\supervisor\supervisoranalyticcontroller;
use App\Http\Controllers\supervisor\supervisorutilizercontroller;

use App\Http\Controllers\nontechgroupmanager\hostelinfocontroller;
use App\Http\Controllers\supervisor\supcompetitionreportcontroller;
use App\Http\Controllers\supervisor\supervisorattendancecontroller;
use App\Http\Controllers\manager\managercompetitionreportcontroller;
use App\Http\Controllers\manager\managertotalfeesanalyticcontroller;
use App\Http\Controllers\nontechmanager\hostel\hostelroomcontroller;
use App\Http\Controllers\supervisor\supervisoroptionaluticontroller;
use App\Http\Controllers\classteacher\classteacheranalyticcontroller;
use App\Http\Controllers\corporateadmin\corporateadminauthcontroller;

use App\Http\Controllers\corporateadmin\corporateadminusercontroller;
use App\Http\Controllers\faculty\facultyassignmentanalyticcontroller;
use App\Http\Controllers\faculty\facultyattendanceanalyticcontroller;
use App\Http\Controllers\manager\managerassignmentanalyticcontroller;
use App\Http\Controllers\manager\managerattendanceanalyticcontroller;
use App\Http\Controllers\student\studentattendanceanalyticcontroller;
use App\Http\Controllers\supervisor\supervisordistributioncontroller;
use App\Http\Controllers\corporateadmin\corporateadmineventcontroller;
use App\Http\Controllers\classteacher\classteacherattendancecontroller;
use App\Http\Controllers\corporateadmin\corporateadminschoolcontroller;

use App\Http\Controllers\admin\admincompetitionanalyticcontroller;
use App\Http\Controllers\supervisor\supervisorcompetitionanalyticcontroller;
use App\Http\Controllers\manager\managercompetitionanalyticcontroller;
use App\Http\Controllers\classteacher\classteachercompetitionanalyticcontroller;

use App\Http\Controllers\marketingmanager\mmmarketingofficercontroller;
use App\Http\Controllers\nontechmanager\hostel\hostelreportscontroller;
use App\Http\Controllers\classteacher\classteacherassignmentscontroller;
use App\Http\Controllers\corporateadmin\corporateadmincontentcontroller;
use App\Http\Controllers\classteacher\classteacherdistributioncontroller;

use App\Http\Controllers\corporateadmin\corporateadminmarketingcontroller;
use App\Http\Controllers\nontechmanager\cafeteria\cafeteriafoodcontroller;
use App\Http\Controllers\nontechmanager\cafeteria\cafeteriainfocontroller;
use App\Http\Controllers\nontechmanager\hostel\hostelallocationcontroller;
//hostel
use App\Http\Controllers\nontechmanager\nontechmanagertransportcontroller;
use App\Http\Controllers\supervisor\supervisortotalfeesanalyticcontroller;
use App\Http\Controllers\corporateadmin\corporateadminassignmentcontroller;

//infrastructure
use App\Http\Controllers\nontechgroupmanager\nontechgroupmanagercontroller;
use App\Http\Controllers\nontechmanager\nontechmanagerattendancecontroller;
use App\Http\Controllers\nontechmanager\nontechmanagerstransportcontroller;
use App\Http\Controllers\supervisor\supervisorassignmentanalyticcontroller;
use App\Http\Controllers\supervisor\supervisorattendanceanalyticcontroller;



use App\Http\Controllers\classteacher\classteacherattendancereportcontroller;
use App\Http\Controllers\corporateadmin\corporateadminquestionbankcontroller;
use  App\Http\Controllers\nontechmanager\cafeteria\cafeteriareportscontroller;

use App\Http\Controllers\classteacher\classteachercompetitionreportcontroller;

use App\Http\Controllers\classteacher\classteachertotalfeesanalyticcontroller;
use App\Http\Controllers\classteacher\classteacherassignmentanalyticcontroller;

use App\Http\Controllers\classteacher\classteacherattendanceanalyticcontroller;
use App\Http\Controllers\nontechmanager\infrastructure\infrastructureroomcontroller;
use App\Http\Controllers\nontechmanager\infrastructure\infrastructureworkcontroller;

use App\Http\Controllers\nontechgroupmanager\nontechgroupmanagerattendancecontroller;
use App\Http\Controllers\nontechmanager\infrastructure\infrastructureothercontroller;
use App\Http\Controllers\nontechmanager\infrastructure\infrastructureschoolcontroller;
use App\Http\Controllers\nontechmanager\infrastructure\infrastructurecafeteriacontroller;


use App\Http\Controllers\controller\AcademicController;
use App\Http\Controllers\controller\ExaminationController;
use App\Http\Controllers\controller\account\AccountController;

use App\Http\Controllers\controller\academic\AcademicGroupController;
use App\Http\Controllers\controller\academic\AcademicStandardController;
use App\Http\Controllers\controller\academic\AcademicSubjectController;
use App\Http\Controllers\controller\academic\AcademicModuleController;
use App\Http\Controllers\controller\academic\AcademicChapterController;
use App\Http\Controllers\controller\academic\AcademicContent;
use App\Http\Controllers\controller\academic\AcademicReport;
use App\Http\Controllers\controller\exam\Examassesment;
use App\Http\Controllers\faculty\FacultyContentController;
use App\Http\Controllers\controller\account\Feescontroller;
use App\Http\Controllers\controller\account\Feesanalyticcontroller;


Route::get('corporateadmin/login',[corporateadminauthcontroller::class ,'login']);
Route::post('corporateadmin/login/save',[corporateadminauthcontroller::class,'logincheck']);
Route::get('corporateadmin/forgotpassword',[corporateadminauthcontroller::class ,'forgotpassword']);
Route::post('corporateadmin/forgotpassword/check',[corporateadminauthcontroller::class ,'forgotpasswordcheck']);

Route::group(['middleware'=>'corporateadmin_auth'],function(){

Route::get('corporateadmin/dashboard',[corporateadminauthcontroller::class ,'dashboard']);

//new corporate functions
Route::get('corporateadmin/homepage/highlights',[corporateadmineventcontroller::class,'highlights']);
Route::get('corporateadmin/homepage/job-role',[corporateadmineventcontroller::class,'jobrole']);
Route::get('corporateadmin/homepage/courses',[corporateadmineventcontroller::class,'courses']);
Route::get('corporateadmin/homepage/stats',[corporateadmineventcontroller::class,'stats']);
Route::get('corporateadmin/homepage/slideshow',[corporateadmineventcontroller::class,'slideshow']);
Route::get('corporateadmin/homepage/steps',[corporateadmineventcontroller::class,'steps']);
Route::get('corporateadmin/homepage/testimonials',[corporateadmineventcontroller::class,'testimonials']);

Route::post('corporateadmin/highlights/save',[corporateadmineventcontroller::class,'highlights_save']);
Route::post('corporateadmin/jobrole/save',[corporateadmineventcontroller::class,'jobrole_save']);
Route::post('corporateadmin/courses/save',[corporateadmineventcontroller::class,'courses_save']);
Route::post('corporateadmin/stats/save',[corporateadmineventcontroller::class,'stats_save']);
Route::post('corporateadmin/slideshow/save',[corporateadmineventcontroller::class,'slideshow_save']);
Route::post('corporateadmin/steps/save',[corporateadmineventcontroller::class,'steps_save']);
Route::post('corporateadmin/testimonials/save',[corporateadmineventcontroller::class,'testimonials_save']);


//old corporate functions
Route::get('corporateadmin/homepage/events',[corporateadmineventcontroller::class,'events']);
Route::post('corporateadmin/events/save',[corporateadmineventcontroller::class,'save']);

Route::get('corporateadmin/content/data',[corporateadmincontentcontroller::class,'index']);
Route::post('corporateadmin/content/schoolwise',[corporateadmincontentcontroller::class,'fetch']);
Route::get('corporateadmin/questionbank/getdomain',[corporateadmincontentcontroller::class,'questionbankgetdomains']);
Route::get('corporateadmin/questionbank/getskillset',[corporateadmincontentcontroller::class,'questionbankgetskillsets']);

Route::get('corporateadmin/questionbank/getskillattribute',[corporateadmincontentcontroller::class,'getskillattribute']);
Route::get('corporateadmin/content/data/get',[corporateadmincontentcontroller::class,'getContent']);
Route::get('corporateadmin/content/view/{id}/{school}',[corporateadmincontentcontroller::class,'view']);

Route::get('corporateadmin/questions/data',[corporateadminquestionbankcontroller::class,'index']);
Route::post('corporateadmin/questions/schoolwise',[corporateadminquestionbankcontroller::class,'fetch']);
Route::get('corporateadmin/question/data/get',[corporateadminquestionbankcontroller::class,'getQuestion']);
Route::get('corporateadmin/question/view/{id}',[corporateadminquestionbankcontroller::class,'questions']);

Route::get('corporateadmin/assignment/data',[corporateadminassignmentcontroller::class,'index']);
Route::get('corporateadmin/assignment/getsection',[corporateadminassignmentcontroller::class,'getSection']);
Route::post('corporateadmin/assignment/schoolwise',[corporateadminassignmentcontroller::class,'fetch']);
Route::get('corporateadmin/assignment/data/get',[corporateadminassignmentcontroller::class,'getData']);
Route::get('corporateadmin/assignment/gettraining',[corporateadminassignmentcontroller::class,'getTraining']);

Route::get('corporateadmin/users',[corporateadminusercontroller::class,'index']);
Route::get('corporateadmin/create/users',[corporateadminusercontroller::class,'create']);
Route::get('corporateadmin/createuser/{id}',[corporateadminusercontroller::class,'create']);
Route::post('corporateadmin/createuser/processing',[corporateadminusercontroller::class,'usersave']);
Route::get('corporateadmin/createuser/delete/{id}',[corporateadminusercontroller::class,'delete']);
Route::get('admin/createuser/status/{status}/{id}',[corporateadminusercontroller::class,'status']);

Route::get('corporateadmin/adddetails',[corporateadminauthcontroller::class,'adddetails']);
Route::post('corporateadmin/adddetails/processing',[corporateadminauthcontroller::class,'savedetails']);

Route::get('corporateadmin/school/list',[corporateadminschoolcontroller::class,'schoollist']);
Route::get('corporateadmin/school/status/{status}/{id}',[corporateadminschoolcontroller::class,'schoolstatus']);
Route::get('corporateadmin/school/mail/{id}',[corporateadminschoolcontroller::class,'sendmail']);
Route::get('corporateadmin/school/data/{id}',[corporateadminschoolcontroller::class,'schooldata']);

Route::get('corporateadmin/admin/export/{adminid}',[corporateadminschoolcontroller::class,'adminexport']);
Route::get('corporateadmin/groupmanager/export/{adminid}',[corporateadminschoolcontroller::class,'groupmanagerexport']);
Route::get('corporateadmin/manager/export/{adminid}',[corporateadminschoolcontroller::class,'managerexport']);
Route::get('corporateadmin/nontechgroupmanager/export/{adminid}',[corporateadminschoolcontroller::class,'nontechgroupmanagerexport']);
Route::get('corporateadmin/nontechmanager/export/{adminid}',[corporateadminschoolcontroller::class,'nontechmanagerexport']);
Route::get('corporateadmin/nontechstaff/export/{adminid}',[corporateadminschoolcontroller::class,'nontechstaffexport']);
Route::get('corporateadmin/classteacher/export/{adminid}',[corporateadminschoolcontroller::class,'classteacherexport']);
Route::get('corporateadmin/faculty/export/{adminid}',[corporateadminschoolcontroller::class,'facultyexport']);
Route::get('corporateadmin/student/export/{adminid}',[corporateadminschoolcontroller::class,'studentexport']);
Route::get('corporateadmin/caterer/export/{adminid}',[corporateadminschoolcontroller::class,'catererexport']);

Route::get('corporateadmin/marketing/details',[corporateadminmarketingcontroller::class,'marketing']);
Route::get('corporateadmin/marketing/view/{id}',[corporateadminmarketingcontroller::class,'mteam']);
Route::get('corporateadmin/marketingofficer/view/coldcalls/{id}',[corporateadminmarketingcontroller::class,'coldcalls']);
Route::get('corporateadmin/marketingofficer/view/coldcalls/rejected/{id}',[corporateadminmarketingcontroller::class,'rejectreason']);
Route::post('corporateadmin/marketingofficer/view/coldcalls/rejected/mosave',[corporateadminmarketingcontroller::class,'mosave']);
Route::any('corporateadmin/getmarketingofficer',[corporateadminmarketingcontroller::class,'getmarketingofficer']);

Route::get('corporateadmin/infrastructure/items',[corporateadminschoolcontroller::class, 'items']);
Route::get('corporateadmin/infrastructure/items/additems',[corporateadminschoolcontroller::class, 'additems']);
Route::get('corporateadmin/infrastructure/items/additems/{id}',[corporateadminschoolcontroller::class, 'additems']);
Route::post('corporateadmin/infrastructure/items/saveitems',[corporateadminschoolcontroller::class,'saveitems']);

Route::get('corporateadmin/profile',[corporateadminauthcontroller::class,'profile']);
Route::post('corporateadmin/profile/processing',[corporateadminauthcontroller::class,'update']);

});

Route::get('corporateadmin/logout',function(){
session()->forget('CORPORATEADMIN_LOGIN');
session()->forget('CORPORATEADMIN_ID');
session()->forget('CORPORATEADMIN_Name');
session()->forget('CORPORATEADMIN_Email');
session()->forget('CORPORATEADMIN_Number');
session()->flash('logout','Logged Out Sucessfully');
return redirect('/');
});

Route::get('/login',function(){
    return view('views_latest.new_login');
})->name('login');
Route::get('/register',function(){
    return view('views_latest.new_registration');
});
Route::get('/pass',function(){
    return view('views_latest.pass');
});

Route::post('select/login/save',function(){
    return redirect('/login');
});

Route::post('select/forgotpassword',function(){
    return redirect('/pass');
});

Route::get('/original_page',[lmsauthenticatecontroller::class,'legacy_index']);

Route::get('/courses',function(){
    $result['data']=DB::table('courses')->where('id',1)->get();
    return view('views_latest.courses',$result);
});

Route::get('/job-roles',function(){
    $result['data']=DB::table('jobroles')->where('id',1)->get();
    $result['s2']=DB::table('jobroles')->where('id',2)->get();
    $result['s3']=DB::table('jobroles')->where('id',3)->get();
    $result['s4']=DB::table('jobroles')->where('id',4)->get();
    $result['s5']=DB::table('jobroles')->where('id',5)->get();
    return view('views_latest.job-role',$result);
});



Route::get('/',[lmsauthenticatecontroller::class ,'index']);
Route::get('/internal',[lmsauthenticatecontroller::class ,'internal']);
Route::get('/admin',[lmsauthenticatecontroller::class ,'admin']);
Route::get('/manager',[lmsauthenticatecontroller::class ,'manager']);
Route::get('/officer',[lmsauthenticatecontroller::class ,'officer']);

Route::post('contact',[lmsauthenticatecontroller::class,'contact']);
Route::post('internal/contact',[lmsauthenticatecontroller::class,'internalcontact']);
Route::post('admin/contact',[lmsauthenticatecontroller::class,'admincontact']);
Route::post('manager/contact',[lmsauthenticatecontroller::class,'managercontact']);
Route::post('officer/contact',[lmsauthenticatecontroller::class,'officercontact']);

Route::get('admin/register',[lmsauthenticatecontroller::class ,'register']);
Route::post('admin/register/save',[lmsauthenticatecontroller::class ,'save']);
Route::get('admin/login',[lmsauthenticatecontroller::class ,'login']);
Route::post('admin/login/save',[lmsauthenticatecontroller::class,'logincheck']);
Route::get('admin/forgotpassword',[lmsauthenticatecontroller::class ,'forgotpassword']);
Route::post('admin/forgotpassword/check',[lmsauthenticatecontroller::class ,'forgotpasswordcheck']);

Route::group(['middleware'=>'admin_auth'],function(){

Route::get('admin/dashboard',[lmsauthenticatecontroller::class ,'dashboard']);

Route::get('admin/adddetails',[lmsauthenticatecontroller::class,'adddetails']);
Route::post('admin/adddetails/processing',[lmsauthenticatecontroller::class,'savedetails']);

Route::get('admin/studentdetails',[lmsuploaddetailscontroller::class,'studentdetails']);
Route::post('admin/studentdetails/bysection',[lmsuploaddetailscontroller::class,'studentdetailsbysection']);
Route::get('admin/studentdetails/view/{id}',[lmsuploaddetailscontroller::class,'studentdetailsview']);
Route::get('admin/studentdetails/export/{classid}/{sectionid}',[lmsuploaddetailscontroller::class,'studentdetailsexport']);
Route::get('admin/student/status/{status}/{id}',[lmsuploaddetailscontroller::class,'status']);
Route::get('admin/student/delete/{id}',[lmsuploaddetailscontroller::class,'delete']);

Route::get('admin/category',[lmsmanagementcontroller::class, 'category']);
Route::post('admin/category/bygroup',[lmsmanagementcontroller::class, 'categorybygroup']);
Route::get('admin/category/addcategory',[lmsmanagementcontroller::class, 'addcategory']);
Route::get('admin/category/addcategory/{id}',[lmsmanagementcontroller::class, 'addcategory']);
Route::post('admin/category/savecategory',[lmsmanagementcontroller::class,'savecategory']);
Route::get('admin/category/{id}',[lmsmanagementcontroller::class,'categorydelete']);

Route::get('admin/domain',[lmsmanagementcontroller::class, 'domain']);
Route::post('admin/domain/bycategory',[lmsmanagementcontroller::class, 'domainbycategory']);
Route::get('admin/domain/adddomain',[lmsmanagementcontroller::class, 'adddomain']);
Route::get('admin/domain/adddomain/{id}',[lmsmanagementcontroller::class, 'adddomain']);
Route::post('admin/domain/savedomain',[lmsmanagementcontroller::class,'savedomain']);
Route::get('admin/domain/{id}',[lmsmanagementcontroller::class,'delete']);

Route::get('admin/skillset',[lmsmanagementcontroller::class, 'skillset']);
Route::post('admin/skillset/bydomain',[lmsmanagementcontroller::class, 'skillsetbydomain']);
Route::get('admin/skillset/addskillset',[lmsmanagementcontroller::class, 'addskillset']);
Route::get('admin/skillset/addskillset/{id}',[lmsmanagementcontroller::class, 'addskillset']);
Route::post('admin/skillset/saveskillset',[lmsmanagementcontroller::class,'saveskillset']);
Route::get('admin/skillset/{id}',[lmsmanagementcontroller::class,'skillsetdelete']);
Route::get('admin/skillset/getcategory/{id}',[lmsmanagementcontroller::class,'skillsetcategory']);
Route::get('admin/getdomains',[lmsmanagementcontroller::class,'skillsetgetdomains']);
Route::get('admin/skillset/getdomain/{id}',[lmsmanagementcontroller::class,'skillsetdomain']);
Route::get('admin/skillset/domain/{id}/{groupid}',[lmsmanagementcontroller::class,'getdomains']);
Route::get('admin/skillset/getskillset/{id}',[lmsmanagementcontroller::class,'getskillsets']);

Route::get('admin/skillattribute',[lmsmanagementcontroller::class, 'skillattribute']);
Route::post('admin/skillattribute/byskillset',[lmsmanagementcontroller::class, 'skillattributebyskillset']);
Route::get('admin/skillattribute/addskillattribute',[lmsmanagementcontroller::class, 'addskillattribute']);
Route::get('admin/skillattribute/addskillattribute/{id}',[lmsmanagementcontroller::class, 'addskillattribute']);
Route::post('admin/skillattribute/saveskillattribute',[lmsmanagementcontroller::class,'saveskillattribute']);
Route::get('admin/skillattribute/{id}',[lmsmanagementcontroller::class,'skillattributedelete']);
Route::get('admin/skillattribute/domain/{id}',[lmsmanagementcontroller::class,'getdomain']);
Route::get('admin/skillattribute/skillset/{id}',[lmsmanagementcontroller::class,'getskillset']);
Route::get('admin/skillattribute/getskillattribute/{id}',[lmsmanagementcontroller::class,'getskillattribute']);

Route::get('admin/assesments',[lmsassesmentscontroller::class,'colist']);
Route::get('admin/assesment/createassesment',[lmsassesmentscontroller::class,'createassesment']);
Route::get('admin/assesment/edit/{id}',[lmsassesmentscontroller::class,'createassesment']);
Route::get('admin/assesment/delete/{id}',[lmsassesmentscontroller::class,'delete']);
Route::get('admin/trainings/trains/{id}',[lmsassesmentscontroller::class,'gettrainings']);
Route::post('admin/skillattribute/domain/',[lmsassesmentscontroller::class,'getdomain']);
Route::post('admin/skillattribute/skillset/',[lmsassesmentscontroller::class,'getskillset']);
Route::post('admin/skillattribute/getskillattribute/',[lmsassesmentscontroller::class,'getskillattribute']);
Route::post('admin/assesment/createmodule',[lmsassesmentscontroller::class,'createmodule']);
Route::get('admin/assesment/createmodule',[lmsassesmentscontroller::class,'createmodule'])->name('cocreate');
Route::post('admin/createsection',[lmsassesmentsectionscontroller::class,'index']);
Route::get('admin/createsection/{id}',[lmsassesmentsectionscontroller::class,'index']);
Route::post('admin/assesments',[lmsassesmentsectionscontroller::class,'comodule']);
Route::post('admin/assesment/sectioncreation',[lmsassesmentsectionscontroller::class,'createsession']);
Route::get('admin/assesment/section/delete/{id}',[lmsassesmentsectionscontroller::class,'delete']);

Route::get('admin/questions',[lmsquestionbankcontroller::class,'questions']);
Route::post('admin/questions/bysa',[lmsquestionbankcontroller::class,'questionsbysa']);
Route::get('admin/questions/add',[lmsquestionbankcontroller::class,'add']);
Route::post('admin/questions/upload',[lmsquestionbankcontroller::class,'upload']);
Route::get('admin/question/edit/{id}',[lmsquestionbankcontroller::class,'editQuestion']);
Route::get('admin/question/view/{id}',[lmsquestionbankcontroller::class,'examview']);
Route::post('admin/question/update',[lmsquestionbankcontroller::class,'updateQuestion']);
Route::get('admin/question/delete/{id}',[lmsquestionbankcontroller::class,'deleteQuestion']);
Route::any('admin/questionbank/getcategory',[lmsquestionbankcontroller::class,'questionbankgetcategories']);
Route::any('admin/questionbank/getdomain',[lmsquestionbankcontroller::class,'questionbankgetdomains']);
Route::post('admin/questionbank/getskillset',[lmsquestionbankcontroller::class,'questionbankgetskillsets']);
Route::any('admin/questionbank/getskillattribute',[lmsquestionbankcontroller::class,'questionbankgetskillattributes']);
Route::get('admin/questions/mismatch',[lmsquestionbankcontroller::class,'mismatch']);
Route::get('admin/questions/improper',[lmsquestionbankcontroller::class,'improper']);

Route::get('admin/group',[lmsgroupcontroller::class, 'group']);
Route::get('admin/group/addgroup',[lmsgroupcontroller::class, 'addgroup']);
Route::get('admin/group/addgroup/{id}',[lmsgroupcontroller::class, 'addgroup']);
Route::post('admin/group/savegroup',[lmsgroupcontroller::class,'savegroup']);

Route::get('admin/section',[lmssectioncontroller::class,'section']);
Route::post('admin/section/byclass',[lmssectioncontroller::class, 'sectionsbyclass']);
Route::get('admin/section/addsection',[lmssectioncontroller::class, 'addsection']);
Route::get('admin/section/addsection/{id}',[lmssectioncontroller::class, 'addsection']);
Route::post('admin/section/savesection',[lmssectioncontroller::class,'savesection']);
Route::get('admin/section/delete/{id}',[lmssectioncontroller::class,'sectiondelete']);
Route::any('admin/section/group/getclass',[lmssectioncontroller::class,'getclass']);
Route::get('admin/section/getclass/{id}',[lmssectioncontroller::class,'getclasses']);

Route::get('admin/department',[lmsgroupcontroller::class, 'department']);
Route::get('admin/department/adddepartment',[lmsgroupcontroller::class, 'adddepartment']);
Route::get('admin/department/adddepartment/{id}',[lmsgroupcontroller::class, 'adddepartment']);
Route::post('admin/department/savedepartment',[lmsgroupcontroller::class,'savedepartment']);


Route::get('admin/infrastructure/group',[lmsgroupcontroller::class, 'infragroup']);
Route::get('admin/infrastructure/group/addinfragroup',[lmsgroupcontroller::class, 'addinfragroup']);
Route::get('admin/infrastructure/group/addinfragroup/{id}',[lmsgroupcontroller::class, 'addinfragroup']);
Route::post('admin/infrastructure/group/saveinfragroup',[lmsgroupcontroller::class,'saveinfragroup']);

Route::get('admin/rooms',[lmsgroupcontroller::class, 'rooms']);
Route::get('admin/rooms/addrooms',[lmsgroupcontroller::class, 'addrooms']);
Route::get('admin/rooms/addrooms/{id}',[lmsgroupcontroller::class, 'addrooms']);
Route::post('admin/rooms/saverooms',[lmsgroupcontroller::class,'saverooms']);
Route::get('admin/rooms/{id}',[lmsgroupcontroller::class,'roomsdelete']);


Route::get('admin/supervisor',[lmssupervisorcontroller::class, 'supervisor']);
Route::get('admin/supervisor/addsupervisor',[lmssupervisorcontroller::class, 'addsupervisor']);
Route::get('admin/supervisor/addsupervisor/{id}',[lmssupervisorcontroller::class, 'addsupervisor']);
Route::post('admin/supervisor/savesupervisor',[lmssupervisorcontroller::class,'savesupervisor']);
Route::get('admin/supervisor/status/{status}/{id}',[lmssupervisorcontroller::class,'supervisorstatus']);
Route::get('admin/supervisor/delete/{id}',[lmssupervisorcontroller::class,'supervisordelete']);

Route::get('admin/manager',[lmsmanagercontroller::class, 'manager']);
Route::get('admin/manager/addmanager',[lmsmanagercontroller::class, 'addmanager']);
Route::get('admin/manager/addmanager/{id}',[lmsmanagercontroller::class, 'addmanager']);
Route::post('admin/manager/savemanager',[lmsmanagercontroller::class,'savemanager']);
Route::get('admin/manager/status/{status}/{id}',[lmsmanagercontroller::class,'managerstatus']);
Route::get('admin/manager/delete/{id}',[lmsmanagercontroller::class,'managerdelete']);
Route::get('admin/manager/getclass/bygroupid/ofsupervisor/{id}',[lmsmanagercontroller::class,'managergetclass']);

Route::get('admin/role',[lmsrolecontroller::class, 'role']);
Route::get('admin/role/addrole',[lmsrolecontroller::class, 'addrole']);
Route::get('admin/role/addrole/{id}',[lmsrolecontroller::class, 'addrole']);
Route::post('admin/role/saverole',[lmsrolecontroller::class,'saverole']);

Route::get('admin/faculty',[lmsfacultycontroller::class, 'faculty']);
Route::get('admin/faculty/addfaculty',[lmsfacultycontroller::class, 'addfaculty']);
Route::get('admin/faculty/addfaculty/{id}',[lmsfacultycontroller::class, 'addfaculty']);
Route::post('admin/faculty/savefaculty',[lmsfacultycontroller::class,'savefaculty']);
Route::get('admin/faculty/status/{status}/{id}',[lmsfacultycontroller::class,'facultystatus']);
Route::get('admin/faculty/delete/{id}',[lmsfacultycontroller::class,'facultydelete']);
Route::get('admin/class/{id}', [lmsfacultycontroller::class,'getsection']);
Route::get('admin/faculty/getmodule/{id}',[lmsfacultycontroller::class,'getmodules']);
Route::get('admin/faculty/getsubject/{id}',[lmsfacultycontroller::class,'getsubjects']);
Route::get('admin/faculty/getsubject/from/supervisor/{id}',[lmsfacultycontroller::class,'getsubjectsfromsupervisor']);
Route::get('admin/faculty/getsubject/from/multiple/classes/supervisor/{id}',[lmsfacultycontroller::class,'getmultiplesubjectsfromsupervisor']);

Route::get('admin/faculty/getsubject/from/supervisor/faculty/{id}',[lmsfacultycontroller::class,'getsubjectsfaculty']);
Route::get('admin/faculty/supervisor/group/optionalornot/{id}',[lmsfacultycontroller::class,'optionalornot']);



Route::get('admin/holiday',[lmsholidaycontroller::class,'holiday']);
Route::post('admin/holiday/upload',[lmsholidaycontroller::class,'upload']);
Route::get('admin/holiday/edit/{id}',[lmsholidaycontroller::class,'editholiday']);
Route::post('admin/holiday/update',[lmsholidaycontroller::class,'updateholiday']);
Route::get('admin/holiday/delete/{id}',[lmsholidaycontroller::class,'deleteholiday']);


Route::get('admin/hostel',[lmshostelcontroller::class,'hostel']);
Route::get('admin/hostel/add',[lmshostelcontroller::class,'addhostel']);
Route::get('admin/hostel/add/{id}',[lmshostelcontroller::class,'addhostel']);
Route::post('admin/hostel/save',[lmshostelcontroller::class,'savehostel']);
Route::get('admin/hostel/delete/{id}',[lmshostelcontroller::class,'deletehostel']);


Route::get('admin/cafeteria',[lmshostelcontroller::class,'cafeteria']);
Route::get('admin/cafeteria/add',[lmshostelcontroller::class,'addcafeteria']);
Route::get('admin/cafeteria/add/{id}',[lmshostelcontroller::class,'addcafeteria']);
Route::post('admin/cafeteria/save',[lmshostelcontroller::class,'savecafeteria']);
Route::get('admin/cafeteria/delete/{id}',[lmshostelcontroller::class,'deletecafeteria']);




Route::get('admin/content/skillattribute',[lmscontentmanagementcontroller::class, 'contentska']);
Route::post('admin/content/skillattribute/byskillset',[lmscontentmanagementcontroller::class, 'contentskabyskillset']);
Route::get('admin/content/skillattribute/addskillattribute',[lmscontentmanagementcontroller::class, 'addcontentska']);
Route::get('admin/content/skillattribute/addskillattribute/{id}',[lmscontentmanagementcontroller::class, 'addcontentska']);
Route::post('admin/content/skillattribute/saveskillattribute',[lmscontentmanagementcontroller::class,'savecontentska']);
Route::get('admin/content/skillattribute/{id}',[lmscontentmanagementcontroller::class,'contentskadelete']);

Route::get('admin/assigned/{id}',[adminlifecontroller::class,'assindex']);
Route::get('admin/assigned/students/{id}',[adminlifecontroller::class,'assstudents']);


Route::get('admin/attended/{id}',[adminlifecontroller::class,'attindex']);
Route::get('admin/attended/students/{id}',[adminlifecontroller::class,'attstudents']);
Route::get('admin/attended/students/assignments/view/{id}',[adminlifecontroller::class,'assignments']);

Route::get('admin/completed/{id}',[adminlifecontroller::class,'comindex']);
Route::get('admin/completed/students/{id}',[adminlifecontroller::class,'comstudents']);
Route::get('admin/completed/students/approved/{id}',[adminlifecontroller::class,'comapstudents']);
Route::get('admin/completed/students/pass/{id}/{cid}',[adminlifecontroller::class,'postpass']);

Route::get('admin/assignments',[lmsassignmentscontroller::class,'reports']);
Route::post('admin/assignments/trainingwise',[lmsassignmentscontroller::class,'fetchstu']);

Route::get('admin/reports',[lmsstudentassignationscontroller::class,'reports']);
Route::get('admin/classby/section/{id}',[lmsstudentassignationscontroller::class,'classby']);
Route::post('admin/reports/sectionwise',[lmsstudentassignationscontroller::class,'fetchstu']);
Route::get('admin/assignmentreport/{id}',[lmsstudentassignationscontroller::class,'assignmentreport']);
Route::get('admin/examreport/{bid}/{id}',[lmsstudentassignationscontroller::class,'sectionreports']);
Route::post('admin/exam/detailedreport',[lmsstudentassignationscontroller::class,'detailedreport']);
Route::get('admin/exam/swot/{id}',[lmsstudentassignationscontroller::class,'swot']);

Route::get('admin/periods/portal',[lmsperiodcontroller::class, 'portal']);
Route::get('admin/periods/portal/addportal',[lmsperiodcontroller::class, 'addportal']);
Route::get('admin/periods/portal/addportal/{id}',[lmsperiodcontroller::class, 'addportal']);
Route::post('admin/periods/portal/saveportal',[lmsperiodcontroller::class,'saveportal']);

Route::get('admin/periods/class',[lmsperiodcontroller::class, 'class']);
Route::get('admin/periods/class/addclass',[lmsperiodcontroller::class, 'addclass']);
Route::get('admin/schedule/class/getmaxperiod/',[lmsperiodcontroller::class,'getmax']);
Route::get('admin/periods/class/addclass/{id}',[lmsperiodcontroller::class, 'addclass']);
Route::post('admin/periods/class/saveclass',[lmsperiodcontroller::class,'saveclass']);
Route::get('admin/own/list/{id}/{day}',[schedulelistcontroller::class,'groupmanagerlist']);
Route::get('admin/manager/list/{id}/{day}',[schedulelistcontroller::class,'managerlist']);
Route::get('admin/faculty/list/{id}/{day}',[schedulelistcontroller::class,'facultylist']);

Route::get('admin/periods/subject',[lmsperiodcontroller::class, 'subject']);
Route::get('admin/periods/subject/addsubject',[lmsperiodcontroller::class, 'addsubject']);
Route::get('admin/periods/subject/addsubject/{id}',[lmsperiodcontroller::class, 'addsubject']);
Route::post('admin/periods/subject/savesubject',[lmsperiodcontroller::class,'savesubject']);
Route::get('admin/periods/subject/getsubject/{id}',[lmsperiodcontroller::class,'getsubject']);

Route::get('admin/analytics',[adminanalyticcontroller::class,'index']);
Route::post('admin/analytics/fetch',[adminanalyticcontroller::class,'fetch']);
Route::get('admin/analytic/data/pre/',[adminanalyticcontroller::class,'predata']);
Route::get('admin/analytic/data/post/',[adminanalyticcontroller::class,'postdata']);

Route::get('admin/approve/leave',[adminleavecontroller::class, 'approveleave']);
Route::get('admin/approve/leave/status/{status}/{id}',[adminleavecontroller::class,'approveleavestatus']);
Route::get('admin/schedule/index',[schedulelistcontroller::class,'index']);
Route::post('admin/fetch/class/schedule/data',[schedulelistcontroller::class,'getclassdata']);

Route::get('admin/profile',[lmsauthenticatecontroller::class,'profile']);
Route::post('admin/profile/processing',[lmsauthenticatecontroller::class,'update']);

Route::get('admin/attendance/view/months',[adminattendancecontroller::class,'months']);
Route::any('admin/attendance/view/sections',[adminattendancecontroller::class,'getsections']);
Route::any('admin/attendance/view/dates',[adminattendancecontroller::class,'getdates']);
Route::post('admin/attendance/view/students/bydate',[adminattendancecontroller::class,'students']);

Route::get('admin/fees/busroute',[adminfeescontroller::class,'busroute']);
Route::get('admin/fees/addbusroute',[adminfeescontroller::class,'addbusroute']);
Route::get('admin/fees/addbusroute/{id}',[adminfeescontroller::class,'addbusroute']);
Route::post('admin/fees/savebusroute',[adminfeescontroller::class,'savebusroute']);
Route::get('admin/fees/busroute/status/{status}/{id}',[adminfeescontroller::class,'busroutestatus']);
Route::get('admin/fees/busroute/delete/{id}',[adminfeescontroller::class,'deletebusroute']);

Route::get('admin/fees/distance',[adminfeescontroller::class,'distance']);
Route::post('admin/fees/distance/upload',[adminfeescontroller::class,'upload']);
Route::get('admin/fees/adddistance',[adminfeescontroller::class,'adddistance']);
Route::get('admin/fees/adddistance/{id}',[adminfeescontroller::class,'adddistance']);
Route::get('admin/fees/distance/status/{status}/{id}',[adminfeescontroller::class,'disstatus']);
Route::get('admin/fees/distance/delete/{id}',[adminfeescontroller::class,'deletedistance']);
Route::post('admin/fees/savedistance',[adminfeescontroller::class,'savedistance']);

Route::get('admin/fees/category',[adminfeescontroller::class,'category']);
Route::get('admin/fees/addcategory',[adminfeescontroller::class,'addcategory']);
Route::get('admin/fees/addcategory/{id}',[adminfeescontroller::class,'addcategory']);
Route::get('admin/fees/category/status/{status}/{id}',[adminfeescontroller::class,'catstatus']);
Route::get('admin/fees/category/delete/{id}',[adminfeescontroller::class,'deletecategory']);
Route::post('admin/fees/savecategory',[adminfeescontroller::class,'savecategory']);

Route::get('admin/fees/schedule',[adminfeescontroller::class,'schedule']);
Route::get('admin/fees/addschedule',[adminfeescontroller::class,'addschedule']);
Route::get('admin/fees/addschedule/{id}',[adminfeescontroller::class,'addschedule']);
Route::get('admin/fees/schedule/delete/{id}',[adminfeescontroller::class,'deleteschedule']);
Route::post('admin/fees/saveschedule',[adminfeescontroller::class,'saveschedule']);

Route::get('admin/transport/fees/schedule/busroutes',[adminfeescontroller::class,'transportschedule']);
Route::get('admin/transport/fees/schedule/busroutes/location/{moneystatus}/{busrouteid}',[adminfeescontroller::class,'addtransportschedule']);
Route::post('admin/transport/fees/schedule/busroutes/save',[adminfeescontroller::class,'savetransportschedule']);

Route::get('admin/fees/discount',[adminfeescontroller::class,'discount']);
Route::get('admin/fees/adddiscount',[adminfeescontroller::class,'adddiscount']);
Route::get('admin/fees/adddiscount/{id}',[adminfeescontroller::class,'adddiscount']);
Route::get('admin/fees/discount/delete/{id}',[adminfeescontroller::class,'deletediscount']);
Route::post('admin/fees/savediscount',[adminfeescontroller::class,'savediscount']);
Route::get('admin/fees/discount/getfees',[adminfeescontroller::class,'getfees']);
Route::get('admin/fees/getstudents',[adminfeescontroller::class,'getstu']);

Route::get('admin/fees/pending',[adminfeescontroller::class,'pendingfeesstudents']);
Route::post('admin/fees/pending/students/bysection',[adminfeescontroller::class,'pendingfeesstudentsbysection']);
Route::post('admin/fees/pending/students/pendingfees/initial/save',[adminfeescontroller::class,'pendingfeesinitialsave']);
Route::post('admin/fees/pending/students/pendingfees/save',[adminfeescontroller::class,'pendingfeessave']);
Route::get('admin/fees/pending/students/export/{class}/{section}',[adminfeescontroller::class,'pendingfeesexport']);
Route::get('admin/fees/index/students',[adminfeescontroller::class,'indexfeesstudents']);
Route::post('admin/fees/index/students/bysection',[adminfeescontroller::class,'indexfeesstudentsbysection']);
Route::get('admin/fees/index/students/export/{id}',[adminfeescontroller::class,'feesexport']);
Route::get('admin/fees/index/students/view/structure/{id}',[adminfeescontroller::class,'feesstructure']);
Route::post('admin/fees/students/save',[adminfeescontroller::class,'feessave']);
Route::post('admin/fees/index/fees/transfer',[adminfeescontroller::class,'feestransfer']);
Route::get('admin/fees/pending/currentyear',[adminfeescontroller::class,'currentyearpendingfeesstudents']);
Route::post('admin/fees/pending/currentyear/students/bysection',[adminfeescontroller::class,'currentyearpendingfeesstudentsbysection']);
Route::post('admin/fees/pending/currentyear/students/export',[adminfeescontroller::class,'currentyearpendingfeesexport']);

Route::get('admin/analytics/attendance',[adminattendanceanalyticcontroller::class,'index']);
Route::post('admin/analytics/attendance/fetch',[adminattendanceanalyticcontroller::class,'fetch']);
Route::get('admin/analytic/attendance/fetch/datewise',[adminattendanceanalyticcontroller::class,'datewise']);

Route::get('admin/analytic/assignment',[adminassignmentanalyticcontroller::class,'index']);
Route::get('admin/trainings/get',[adminassignmentanalyticcontroller::class,'gettrainings']);
Route::post('admin/analytics/assignment/fetch',[adminassignmentanalyticcontroller::class,'fetch']);
Route::get('admin/analytic/assignment/notcompleted',[adminassignmentanalyticcontroller::class,'notcompleted']);
Route::get('admin/analytic/assignment/completed',[adminassignmentanalyticcontroller::class,'completed']);

Route::get('admin/analytics/pendingfees',[admintotalfeesanalyticcontroller::class,'index']);
Route::post('admin/analytics/pendingfees/fetch',[admintotalfeesanalyticcontroller::class,'fetch']);
Route::get('admin/analytics/currentfees',[admintotalfeesanalyticcontroller::class,'currentindex']);
Route::post('admin/analytics/currentfees/fetch',[admintotalfeesanalyticcontroller::class,'currentfetch']);
Route::get('admin/analytic/currentfees/monthwise',[admintotalfeesanalyticcontroller::class,'getmonth']);

Route::get('admin/nontech/supervisor',[adminnontechcontroller::class,'nontechsupervisor']);
Route::get('admin/nontech/supervisor/addsupervisor',[adminnontechcontroller::class,'addnontechsupervisor']);
Route::get('admin/nontech/supervisor/addsupervisor/{id}',[adminnontechcontroller::class,'addnontechsupervisor']);
Route::post('admin/nontech/supervisor/savesupervisor',[adminnontechcontroller::class,'savenontechsupervisor']);
Route::get('admin/nontech/supervisor/status/{status}/{id}',[adminnontechcontroller::class,'nontechsupervisorstatus']);
Route::get('admin/nontech/supervisor/delete/{id}',[adminnontechcontroller::class,'nontechsupervisordelete']);

Route::get('admin/nontech/manager',[adminnontechcontroller::class,'nontechmanager']);
Route::get('admin/nontech/manager/addmanager',[adminnontechcontroller::class,'addnontechmanager']);
Route::get('admin/nontech/manager/addmanager/{id}',[adminnontechcontroller::class,'addnontechmanager']);
Route::post('admin/nontech/manager/savemanager',[adminnontechcontroller::class,'savenontechmanager']);
Route::get('admin/nontech/manager/status/{status}/{id}',[adminnontechcontroller::class,'nontechmanagerstatus']);
Route::get('admin/nontech/manager/delete/{id}',[adminnontechcontroller::class,'nontechmanagerdelete']);
Route::get('admin/nontech/getdepartment/fromsupervisor/{id}',[adminnontechcontroller::class,'getdepartment']);

Route::get('admin/nontech/staff',[adminnontechcontroller::class,'nontechstaff']);
Route::get('admin/nontech/staff/addstaff',[adminnontechcontroller::class,'addnontechstaff']);
Route::get('admin/nontech/staff/addstaff/{id}',[adminnontechcontroller::class,'addnontechstaff']);
Route::post('admin/nontech/staff/savestaff',[adminnontechcontroller::class,'savenontechstaff']);
Route::get('admin/nontech/staff/status/{status}/{id}',[adminnontechcontroller::class,'nontechstaffstatus']);
Route::get('admin/nontech/staff/delete/{id}',[adminnontechcontroller::class,'nontechstaffdelete']);
Route::get('admin/nontech/class/{id}', [adminnontechcontroller::class,'getsection']);


Route::delete('/controller/{id}', [ControllerName::class, 'destroy'])->name('controller.destroy');

Route::get('admin/competition/reports',[admincompetitionreportcontroller::class,'competition']);
Route::post('admin/competition/reports/view',[admincompetitionreportcontroller::class,'competitionreports']);

Route::get('admin/analytics/competition',[admincompetitionanalyticcontroller::class,'index']);
Route::post('admin/analytics/competition/fetch',[admincompetitionanalyticcontroller::class,'fetch']);
Route::get('admin/competition/bysupervisor/{id}',[admincompetitionanalyticcontroller::class,'getcompetition']);
});

Route::get('admin/logout',function(){
session()->forget('ADMIN_LOGIN');
session()->forget('ADMIN_ID');
session()->forget('ADMIN_Name');
session()->forget('ADMIN_Email');
session()->forget('ADMIN_Number');
session()->flash('logout','Logged Out Sucessfully');
return redirect('/');
});



Route::get('supervisor/login',[supervisorcontroller::class ,'login']);
Route::post('supervisor/login/save',[supervisorcontroller::class ,'logincheck']);
Route::get('supervisor/forgotpassword',[supervisorcontroller::class ,'forgotpassword']);
Route::post('supervisor/forgotpassword/check',[supervisorcontroller::class ,'forgotpasswordcheck']);

Route::group(['middleware'=>'supervisor_auth'],function(){

Route::get('supervisor/dashboard',[supervisorcontroller::class ,'dashboard']);

Route::get('supervisor/student/assignations',[supervisorcontroller::class, 'assignations']);
Route::get('supervisor/student/assignations/view/{id}',[supervisorcontroller::class, 'assignationsview']);
Route::post('supervisor/student/assignations/save',[supervisorcontroller::class,'saveassignation']);

Route::get('supervisor/studentdetails',[supervisorcontroller::class,'studentdetails']);
Route::post('supervisor/studentdetails/bysection',[supervisorcontroller::class,'studentdetailsbysection']);
Route::get('supervisor/studentdetails/view/{id}',[supervisorcontroller::class,'studentdetailsview']);
Route::get('supervisor/studentdetails/export/{classid}/{sectionid}',[supervisorcontroller::class,'studentdetailsexport']);

Route::get('supervisor/adddetails',[supervisorcontroller::class,'adddetails']);
Route::post('supervisor/adddetails/processing',[supervisorcontroller::class,'savedetails']);

Route::get('supervisor/assignments',[supdetailcontroller::class,'assreports']);
Route::post('supervisor/assignments/trainingwise',[supdetailcontroller::class,'fetchstudent']);

Route::get('supervisor/reports',[supdetailcontroller::class,'reports']);
Route::get('supervisor/classby/section/{id}',[supdetailcontroller::class,'classby']);
Route::post('supervisor/reports/sectionwise',[supdetailcontroller::class,'fetchstu']);
Route::get('supervisor/examreport/{aid}/{id}',[supdetailcontroller::class,'sectionreports']);
Route::post('supervisor/exam/detailedreport',[supdetailcontroller::class,'detailedreport']);
Route::get('supervisor/exam/swot/{id}',[supdetailcontroller::class,'swot']);
Route::get('groupmanager/assignmentreport/{id}',[supdetailcontroller::class,'assignmentreport']);

Route::get('supervisor/profile',[supervisorcontroller::class,'profile']);
Route::post('supervisor/profile/processing',[supervisorcontroller::class,'update']);

Route::get('supervisor/assigned/{id}',[supervisorlifecontroller::class,'assindex']);
Route::get('supervisor/assigned/students/{id}',[supervisorlifecontroller::class,'assstudents']);


Route::get('supervisor/attended/{id}',[supervisorlifecontroller::class,'attindex']);
Route::get('supervisor/attended/students/{id}',[supervisorlifecontroller::class,'attstudents']);
Route::get('supervisor/attended/students/assignments/view/{id}',[supervisorlifecontroller::class,'assignments']);

Route::get('supervisor/completed/{id}',[supervisorlifecontroller::class,'comindex']);
Route::get('supervisor/completed/students/{id}',[supervisorlifecontroller::class,'comstudents']);
Route::get('supervisor/completed/students/approved/{id}',[supervisorlifecontroller::class,'comapstudents']);
Route::get('supervisor/completed/students/pass/{id}/{cid}',[supervisorlifecontroller::class,'postpass']);

Route::get('supervisor/portal/list',[supervisorperiodcontroller::class,'portallist']);
Route::get('supervisor/portal/list/view/members/{portalid}',[supervisorperiodcontroller::class,'portalmemberlist']);
Route::get('supervisor/portal/list/view/subject/{typeid}/{portalid}/{profileid}',[supervisorperiodcontroller::class,'viewsubject']);
Route::get('supervisor/portal/list/view/subject/assign/{typeid}/{portalid}/{profileid}/{subjectid}',[supervisorperiodcontroller::class,'assignsubject']);
Route::post('supervisor/portal/list/savetimetable',[supervisorperiodcontroller::class,'savetimetable']);
Route::post('supervisor/periods/subject/savesubject',[supervisorperiodcontroller::class,'savesubject']);
Route::get('supervisor/periods/subject/getsubject/{id}',[supervisorperiodcontroller::class,'getsubject']);

Route::get('supervisor/analytics',[supervisoranalyticcontroller::class,'index']);
Route::post('supervisor/analytics/fetch',[supervisoranalyticcontroller::class,'fetch']);
Route::get('supervisor/analytic/data/pre/',[supervisoranalyticcontroller::class,'predata']);
Route::get('supervisor/analytic/data/post/',[supervisoranalyticcontroller::class,'postdata']);


Route::get('supervisor/utilization',[suputilizationcontroller::class,'index']);
Route::get('supervisor/schedule',[suputilizationcontroller::class,'scheduleindex']);
Route::get('groupmanager/faculty/schedule/{id}',[suputilizationcontroller::class,'facschedule']);
Route::get('supervisor/getperiod',[suputilizationcontroller::class,'getperiod']);
Route::get('supervisor/getsubject',[suputilizationcontroller::class,'getsubject']);
Route::get('supervisor/getmodule',[suputilizationcontroller::class,'getmodule']);
Route::post('groupmanager/schedule/day',[suputilizationcontroller::class,'schedule']);
Route::get('groupmanager/schedule/edit/{id}',[suputilizationcontroller::class,'edit']);
Route::get('groupmanager/schedule/delete/{lid}/{id}',[suputilizationcontroller::class,'delete']);
Route::get('groupmanager/faculty/list/{stype}/{id}/{day}',[suputilizationcontroller::class,'schedulelist']);
Route::get('groupmanager/utilization/class',[suputilizationcontroller::class,'classindex']);
Route::post('groupmanager/fetch/class/data',[suputilizationcontroller::class,'getclassdata']);

Route::get('groupmanager/optional/utilization',[supervisoroptionaluticontroller::class,'index']);
Route::get('groupmanager/optional/schedule/list',[supervisoroptionaluticontroller::class,'list']);
Route::get('groupmanager/optional/manage/{id}',[supervisoroptionaluticontroller::class,'schedule']);
Route::get('groupmanager/optional/getperiod/',[supervisoroptionaluticontroller::class,'getperiod']);
Route::post('groupmanager/optional/schedule/day',[supervisoroptionaluticontroller::class,'sprocess']);
Route::get('groupmanager/optional/schedule/list/delete/{id}',[supervisoroptionaluticontroller::class,'delete']);
Route::get('groupmanager/optional/schedule/list/edit/{id}',[supervisoroptionaluticontroller::class,'edit']);
Route::get('groupmanager/optional/getfaculty/',[supervisoroptionaluticontroller::class,'getfacs']);
Route::post('groupmanager/optional/schedule/day/update',[supervisoroptionaluticontroller::class,'update']);
Route::get('groupmanager/optional/utilization/class',[supervisoroptionaluticontroller::class,'classindex']);
Route::post('groupmanager/optional/fetch/class/data',[supervisoroptionaluticontroller::class,'getclassdata']);
Route::get('groupmanager/optional/faculty/list/{stype}/{id}/{day}',[supervisoroptionaluticontroller::class,'fschedulelist']);
Route::get('groupmanager/optional/manager/list/{stype}/{id}/{day}',[supervisoroptionaluticontroller::class,'mschedulelist']);
Route::get('groupmanager/optional/own/list/{stype}/{id}/{day}',[supervisoroptionaluticontroller::class,'oschedulelist']);


Route::get('groupmanager/manager/schedule/{id}',[manutilizercontroller::class,'manschedule']);
Route::get('groupmanager/manager/getperiod',[manutilizercontroller::class,'getperiod']);
Route::get('groupmanager/manager/getsubject',[manutilizercontroller::class,'getsubject']);
Route::get('groupmanager/manager/getmodule',[manutilizercontroller::class,'getmodule']);
Route::post('groupmanager/manager/schedule/day',[manutilizercontroller::class,'schedule']);
Route::get('groupmanager/manager/list/{stype}/{id}/{day}',[manutilizercontroller::class,'schedulelist']);
Route::get('groupmanager/manager/schedule/edit/{id}',[manutilizercontroller::class,'edit']);
Route::get('groupmanager/manager/schedule/delete/{lid}/{id}',[manutilizercontroller::class,'delete']);


Route::get('groupmanager/own/schedule/{id}',[supervisorutilizercontroller::class,'ownschedule']);
Route::get('groupmanager/own/getperiod',[supervisorutilizercontroller::class,'getperiod']);
Route::get('groupmanager/own/getsubject',[supervisorutilizercontroller::class,'getsubject']);
Route::get('groupmanager/own/getmodule',[supervisorutilizercontroller::class,'getmodule']);
Route::post('groupmanager/own/schedule/day',[supervisorutilizercontroller::class,'schedule']);
Route::get('groupmanager/own/list/{stype}/{id}/{day}',[supervisorutilizercontroller::class,'schedulelist']);
Route::get('groupmanager/own/schedule/edit/{id}',[supervisorutilizercontroller::class,'edit']);
Route::get('groupmanager/own/schedule/delete/{lid}/{id}',[supervisorutilizercontroller::class,'delete']);



Route::get('supervisor/approve/leave',[supervisorleavecontroller::class, 'approveleave']);
Route::get('supervisor/inprogress/leave/status/{status}/{id}',[supervisorleavecontroller::class,'inprogressleavestatus']);
Route::get('supervisor/approve/leave/status/{status}/{id}',[supervisorleavecontroller::class,'approveleavestatus']);
Route::get('supervisor/pendinglist/{portal}/{id}/{lid}',[supervisorleavecontroller::class,'pending']);
Route::get('supervisor/reschedule/{portal}/{id}/{lid}',[supervisorleavecontroller::class,'reschedule']);
Route::get('groupmanager/reschedule/class/{restimetableid}/{lid}',[supervisorleavecontroller::class,'rescheduleform']);
Route::get('groupmanager/reschedule/getsubjects',[supervisorleavecontroller::class,'reschedulegetsubjects']);
Route::get('groupmanager/reschedule/gettabledata',[supervisorleavecontroller::class,'reschedulegettabledata']);
Route::post('groupmanager/reschedule/day',[supervisorleavecontroller::class,'reschedulesave']);


Route::get('groupmanager/rescheduling/list',[supschedulecontroller::class,'reschedulelist']);
Route::get('groupmanager/reschedule/class/change/complete/{id}',[supschedulecontroller::class,'changecomplete']);
Route::post('groupmanager/rescheduling/list/bysection',[supschedulecontroller::class,'reschedulelistbysection']);
Route::get('groupmanager/rescheduling/classby/section/{id}',[supschedulecontroller::class,'classby']);

Route::get('groupmanager/staff/pendingandextra/classes',[supschedulecontroller::class,'pendingandextraclasses']);
Route::get('groupmanager/staff/pendingandextra/classes/view/{portal}/{profile}',[supschedulecontroller::class,'pendingandextraclassesview']);

Route::get('supervisor/apply/leave',[supervisorleavecontroller::class, 'applyleave']);
Route::get('supervisor/apply/leave/addapplyleave',[supervisorleavecontroller::class, 'addapplyleave']);
Route::get('supervisor/apply/leave/addapplyleave/{id}',[supervisorleavecontroller::class, 'addapplyleave']);
Route::post('supervisor/apply/leave/saveapplyleave',[supervisorleavecontroller::class,'saveapplyleave']);
Route::get('supervisor/apply/leave/delete/{id}',[supervisorleavecontroller::class,'applyleavedelete']);

Route::get('supervisor/attendance/view/months',[supervisorattendancecontroller::class,'months']);
Route::any('supervisor/attendance/view/sections',[supervisorattendancecontroller::class,'getsections']);
Route::get('supervisor/attendance/view/sections/{id}',[supervisorattendancecontroller::class,'getsectionsbyid']);
Route::any('supervisor/attendance/view/dates',[supervisorattendancecontroller::class,'getdates']);
Route::post('supervisor/attendance/view/students/bydate',[supervisorattendancecontroller::class,'students']);

Route::get('supervisor/fees/pending',[supervisorfeescontroller::class,'pendingfeesstudents']);
Route::post('supervisor/fees/pending/students/bysection',[supervisorfeescontroller::class,'pendingfeesstudentsbysection']);
Route::get('supervisor/fees/pending/students/export/{class}/{section}',[supervisorfeescontroller::class,'pendingfeesexport']);
Route::get('supervisor/fees/index/students',[supervisorfeescontroller::class,'indexfeesstudents']);
Route::post('supervisor/fees/index/students/bysection',[supervisorfeescontroller::class,'indexfeesstudentsbysection']);
Route::get('supervisor/fees/index/students/export/{id}',[supervisorfeescontroller::class,'feesexport']);
Route::get('supervisor/fees/index/students/view/structure/{id}',[supervisorfeescontroller::class,'feesstructure']);

Route::get('supervisor/analytics/attendance',[supervisorattendanceanalyticcontroller::class,'index']);
Route::post('supervisor/analytics/attendance/fetch',[supervisorattendanceanalyticcontroller::class,'fetch']);
Route::get('supervisor/analytic/attendance/fetch/datewise',[supervisorattendanceanalyticcontroller::class,'datewise']);

Route::get('supervisor/analytic/assignment',[supervisorassignmentanalyticcontroller::class,'index']);
Route::get('supervisor/trainings/get',[supervisorassignmentanalyticcontroller::class,'gettrainings']);
Route::post('supervisor/analytics/assignment/fetch',[supervisorassignmentanalyticcontroller::class,'fetch']);
Route::get('supervisor/analytic/assignment/notcompleted',[supervisorassignmentanalyticcontroller::class,'notcompleted']);
Route::get('supervisor/analytic/assignment/completed',[supervisorassignmentanalyticcontroller::class,'completed']);

Route::get('supervisor/analytics/pendingfees',[supervisortotalfeesanalyticcontroller::class,'index']);
Route::post('supervisor/analytics/pendingfees/fetch',[supervisortotalfeesanalyticcontroller::class,'fetch']);
Route::get('supervisor/analytics/currentfees',[supervisortotalfeesanalyticcontroller::class,'currentindex']);
Route::post('supervisor/analytics/currentfees/fetch',[supervisortotalfeesanalyticcontroller::class,'currentfetch']);
Route::get('supervisor/analytic/currentfees/monthwise',[supervisortotalfeesanalyticcontroller::class,'getmonth']);

Route::get('supervisor/distribution/reports',[supervisordistributioncontroller::class,'reports']);
Route::post('supervisor/distribution/reports/feecategorywise',[supervisordistributioncontroller::class,'fetchstu']);


Route::get('groupmanager/competition',[supcompetitioncontroller::class, 'competition']);
Route::get('groupmanager/competition/addcompetition',[supcompetitioncontroller::class, 'addcompetition']);
Route::get('groupmanager/competition/addcompetition/{id}',[supcompetitioncontroller::class,'addcompetition']);
Route::post('groupmanager/competition/savecompetition',[supcompetitioncontroller::class,'savecompetition']);
Route::get('groupmanager/competition/delete/{id}',[supcompetitioncontroller::class,'competitiondelete']);
Route::get('groupmanager/competition/status/{status}/{id}',[supcompetitioncontroller::class,'competitionstatus']);
Route::get('groupmanager/competition/view/students/{id}',[supcompetitioncontroller::class,'viewstudents']);
Route::get('groupmanager/competition/student/status/{status}/{id}',[supcompetitioncontroller::class,'changestatus']);
Route::post('groupmanager/competition/student/savecertificate',[supcompetitioncontroller::class,'savecertificate']);

Route::get('supervisor/competition/reports',[supcompetitionreportcontroller::class,'competition']);
Route::post('supervisor/competition/reports/view',[supcompetitionreportcontroller::class,'competitionreports']);

Route::get('supervisor/analytics/competition',[supervisorcompetitionanalyticcontroller::class,'index']);
Route::post('supervisor/analytics/competition/fetch',[supervisorcompetitionanalyticcontroller::class,'fetch']);
});

Route::get('supervisor/logout',function(){
session()->forget('SUPERVISOR_LOGIN');
session()->forget('SUPERVISOR_ID');
session()->forget('SUPERVISOR_ADMIN_ID');
session()->forget('SUPERVISOR_GROUP_ID');
session()->forget('SUPERVISOR_Name');
session()->forget('SUPERVISOR_Email');
session()->forget('SUPERVISOR_Number');
session()->flash('logout','Logged Out Sucessfully');
return redirect('/');
});



Route::get('manager/login',[managercontroller::class ,'login']);
Route::post('manager/login/save',[managercontroller::class ,'logincheck']);
Route::get('manager/forgotpassword',[managercontroller::class ,'forgotpassword']);
Route::post('manager/forgotpassword/check',[managercontroller::class ,'forgotpasswordcheck']);

Route::group(['middleware'=>'manager_auth'],function(){

Route::get('manager/dashboard',[managercontroller::class ,'dashboard']);

Route::get('manager/adddetails',[managercontroller::class,'adddetails']);
Route::post('manager/adddetails/processing',[managercontroller::class,'savedetails']);

Route::get('manager/rescheduled/classes',[managercontroller::class,'rescheduledclasses']);

Route::get('manager/trainingprogram',[trainingprogramcontroller::class, 'trainingprogram']);
Route::post('manager/trainingprogram/bytrainingtypeandsubject',[trainingprogramcontroller::class, 'trainingprogramby']);
Route::any('manager/trainingprogram/view/subjects',[trainingprogramcontroller::class,'getsubjects']);
Route::get('manager/trainingprogram/addtraining',[trainingprogramcontroller::class, 'addtrainingprogram']);
Route::get('manager/trainingprogram/addtraining/{id}',[trainingprogramcontroller::class, 'addtrainingprogram']);
Route::post('manager/trainingprogram/savetraining',[trainingprogramcontroller::class,'savetrainingprogram']);
Route::get('manager/trainingprogram/status/{status}/{id}',[trainingprogramcontroller::class,'trainingprogramstatus']);
Route::get('manager/trainingprogram/delete/{id}',[trainingprogramcontroller::class,'trainingprogramdelete']);
Route::get('manager/skillattribute/domain/{id}',[trainingprogramcontroller::class,'getdomain']);
Route::get('manager/skillattribute/skillset/{id}',[trainingprogramcontroller::class,'getskillset']);
Route::get('manager/skillattribute/getskillattribute/{id}',[trainingprogramcontroller::class,'getskillattribute']);

Route::get('manager/upload/student',[studentuploadcontroller::class,'uploadview']);
Route::post('manager/upload/student/save',[studentuploadcontroller::class,'uploadsave']);
Route::get('manager/mails/trigger',[studentuploadcontroller::class,'tmails']);

Route::get('manager/studentdetails',[studentuploadcontroller::class,'studentdetails']);
Route::post('manager/studentdetails/bysection',[studentuploadcontroller::class,'studentdetailsbysection']);
Route::get('manager/studentdetails/view/{id}',[studentuploadcontroller::class,'studentdetailsview']);
Route::get('manager/studentdetails/export/{sectionid}',[studentuploadcontroller::class,'studentdetailsexport']);
Route::get('manager/student/status/{status}/{id}',[studentuploadcontroller::class,'status']);
Route::get('manager/student/delete/{id}',[studentuploadcontroller::class,'delete']);

Route::get('manager/training/assign/{trainingprogramid}',[managertrainingcontroller::class,'trainingprogramassign']);
Route::post('manager/training/assign/save',[managertrainingcontroller::class, 'trainingprogramassignsave']);

Route::get('manager/profile',[managercontroller::class,'profile']);
Route::post('manager/profile/processing',[managercontroller::class,'update']);

Route::get('manager/assigned/{id}',[lifecyclecontroller::class,'assindex']);
Route::get('manager/assigned/students/{id}',[lifecyclecontroller::class,'assstudents']);
Route::get('manager/assigned/students/pass/{id}/{train}',[lifecyclecontroller::class,'passed']);
Route::get('manager/movetoattended/{id}/{train}',[lifecyclecontroller::class,'movetoattended']);

Route::get('manager/attended/{id}',[lifecyclecontroller::class,'attindex']);
Route::get('manager/attended/students/{id}',[lifecyclecontroller::class,'attstudents']);
Route::get('manager/movetocompleted/{id}/{train}',[lifecyclecontroller::class,'movetocompleted']);
Route::get('manager/attended/students/assignments/view/{id}',[lifecyclecontroller::class,'assignments']);

Route::get('manager/completed/{id}',[lifecyclecontroller::class,'comindex']);
Route::get('manager/completed/students/{id}',[lifecyclecontroller::class,'comstudents']);
Route::get('manager/post/approve/{id}/{train}',[lifecyclecontroller::class,'postapprove']);
Route::get('manager/completed/students/approved/{id}',[lifecyclecontroller::class,'comapstudents']);
Route::get('manager/completed/students/pass/{id}/{cid}',[lifecyclecontroller::class,'postpass']);

Route::get('manager/examreport/{aid}/{id}',[lifecyclecontroller::class,'sectionreports']);
Route::post('manager/exam/detailedreport',[lifecyclecontroller::class,'detailedreport']);
Route::get('manager/exam/swot/{id}',[lifecyclecontroller::class,'swot']);

Route::get('manager/assignments',[managerassignmentscontroller::class,'reports']);
Route::post('manager/assignments/trainingwise',[managerassignmentscontroller::class,'fetchstu']);
Route::get('manager/classby/section/{id}',[managerassignmentscontroller::class,'classby']);

Route::get('manager/reports',[managertrainingcontroller::class,'reports']);
Route::post('manager/reports/sectionwise',[managertrainingcontroller::class,'fetchstu']);
Route::get('manager/assignmentreport/{id}',[managertrainingcontroller::class,'assignmentreport']);

Route::get('manager/analytics',[manageranalyticcontroller::class,'index']);
Route::post('manager/analytics/fetch',[manageranalyticcontroller::class,'fetch']);
Route::get('manager/analytic/data/pre/',[manageranalyticcontroller::class,'predata']);
Route::get('manager/analytic/data/post/',[manageranalyticcontroller::class,'postdata']);

Route::get('manager/schedulelist',[managerschedulelistcontroller::class,'index']);
Route::post('manager/schedule/fetch/section/data',[managerschedulelistcontroller::class,'getclassdata']);
Route::get('manager/own/list/{id}/{day}',[managerschedulelistcontroller::class,'list']);
Route::get('manager/faculty/list/{id}/{day}',[managerschedulelistcontroller::class,'facultylist']);

Route::get('manager/leave',[managerleavecontroller::class, 'leave']);
Route::get('manager/leave/addleave',[managerleavecontroller::class, 'addleave']);
Route::get('manager/leave/addleave/{id}',[managerleavecontroller::class, 'addleave']);
Route::post('manager/leave/saveleave',[managerleavecontroller::class,'saveleave']);
Route::get('manager/leave/delete/{id}',[managerleavecontroller::class,'leavedelete']);

Route::get('manager/attendance/view/months',[managerattendancecontroller::class,'months']);
Route::any('manager/attendance/view/dates',[managerattendancecontroller::class,'getdates']);
Route::post('manager/attendance/view/students/bydate',[managerattendancecontroller::class,'students']);

Route::get('manager/promote/class/students',[managerpromotecontroller::class,'classstudents']);
Route::post('manager/promote/class/students/bysection',[managerpromotecontroller::class,'classstudentsbysection']);
Route::post('manager/promote/class/students/promoteortransfer',[managerpromotecontroller::class,'classpromoteortransfer']);

Route::get('manager/promote/section/students',[managerpromotecontroller::class,'sectionstudents']);
Route::post('manager/promote/section/students/bysection',[managerpromotecontroller::class,'sectionstudentsbysection']);
Route::post('manager/promote/section/students/promoteortransfer',[managerpromotecontroller::class,'sectiontransfer']);

Route::get('manager/timetable',[managerattendancecontroller::class,'timetable']);
Route::post('manager/gettimetable',[managerattendancecontroller::class,'gettimeTable']);

Route::get('manager/fees/pending',[managerfeescontroller::class,'pendingfeesstudents']);
Route::post('manager/fees/pending/students/bysection',[managerfeescontroller::class,'pendingfeesstudentsbysection']);
Route::get('manager/fees/pending/students/export/{class}/{section}',[managerfeescontroller::class,'pendingfeesexport']);
Route::get('manager/fees/index/students',[managerfeescontroller::class,'indexfeesstudents']);
Route::post('manager/fees/index/students/bysection',[managerfeescontroller::class,'indexfeesstudentsbysection']);
Route::get('manager/fees/index/students/export/{id}',[managerfeescontroller::class,'feesexport']);
Route::get('manager/fees/index/students/view/structure/{id}',[managerfeescontroller::class,'feesstructure']);

Route::get('manager/analytics/attendance',[managerattendanceanalyticcontroller::class,'index']);
Route::post('manager/analytics/attendance/fetch',[managerattendanceanalyticcontroller::class,'fetch']);
Route::get('manager/analytic/attendance/fetch/datewise',[managerattendanceanalyticcontroller::class,'datewise']);

Route::get('manager/analytic/assignment',[managerassignmentanalyticcontroller::class,'index']);
Route::get('manager/trainings/get',[managerassignmentanalyticcontroller::class,'gettrainings']);
Route::post('manager/analytics/assignment/fetch',[managerassignmentanalyticcontroller::class,'fetch']);
Route::get('manager/analytic/assignment/notcompleted',[managerassignmentanalyticcontroller::class,'notcompleted']);
Route::get('manager/analytic/assignment/completed',[managerassignmentanalyticcontroller::class,'completed']);

Route::get('manager/analytics/pendingfees',[managertotalfeesanalyticcontroller::class,'index']);
Route::post('manager/analytics/pendingfees/fetch',[managertotalfeesanalyticcontroller::class,'fetch']);
Route::get('manager/analytics/currentfees',[managertotalfeesanalyticcontroller::class,'currentindex']);
Route::post('manager/analytics/currentfees/fetch',[managertotalfeesanalyticcontroller::class,'currentfetch']);
Route::get('manager/analytic/currentfees/monthwise',[managertotalfeesanalyticcontroller::class,'getmonth']);

Route::get('manager/distribution/reports',[managerdistributioncontroller::class,'reports']);
Route::post('manager/distribution/reports/feecategorywise',[managerdistributioncontroller::class,'fetchstu']);

Route::get('manager/competition',[managercompetitioncontroller::class, 'competition']);
Route::get('manager/competition/view/students/{id}',[managercompetitioncontroller::class,'viewstudents']);
Route::post('manager/competition/student/savestatus',[managercompetitioncontroller::class,'savestatus']);

Route::get('manager/competition/reports',[managercompetitionreportcontroller::class,'competition']);
Route::post('manager/competition/reports/view',[managercompetitionreportcontroller::class,'competitionreports']);

Route::get('manager/analytics/competition',[managercompetitionanalyticcontroller::class,'index']);
Route::post('manager/analytics/competition/fetch',[managercompetitionanalyticcontroller::class,'fetch']);
});

Route::get('manager/logout',function(){
session()->forget('MANAGER_LOGIN');
session()->forget('MANAGER_ID');
session()->forget('MANAGER_ADMIN_ID');
session()->forget('MANAGER_CLASS_ID');
session()->forget('MANAGER_Name');
session()->forget('MANAGER_Email');
session()->forget('MANAGER_Number');
session()->flash('logout','Logged Out Sucessfully');
return redirect('/');
});

Route::get('classteacher/login',[classteachercontroller::class ,'login']);
Route::post('classteacher/login/save',[classteachercontroller::class ,'logincheck']);
Route::get('classteacher/forgotpassword',[classteachercontroller::class ,'forgotpassword']);
Route::post('classteacher/forgotpassword/check',[classteachercontroller::class ,'forgotpasswordcheck']);

Route::group(['middleware'=>'classteacher_auth'],function(){

Route::get('classteacher/dashboard',[classteachercontroller::class ,'dashboard']);

Route::get('classteacher/studentdetails',[classteachercontroller::class,'studentdetails']);
Route::get('classteacher/studentdetails/view/{id}',[classteachercontroller::class,'studentdetailsview']);

Route::get('classteacher/adddetails',[classteachercontroller::class,'adddetails']);
Route::post('classteacher/adddetails/processing',[classteachercontroller::class,'savedetails']);

Route::get('classteacher/profile',[classteachercontroller::class,'profile']);
Route::post('classteacher/profile/processing',[classteachercontroller::class,'update']);

Route::get('classteacher/assignments',[classteacherassignmentscontroller::class,'reports']);
Route::post('classteacher/assignments/trainingwise',[classteacherassignmentscontroller::class,'fetchstu']);
Route::get('classteacher/classby/section/{id}',[classteacherassignmentscontroller::class,'classby']);

Route::get('classteacher/reports',[reportcontroller::class,'reports']);
Route::post('classteacher/reports/sectionwise',[reportcontroller::class,'fetchstu']);
Route::get('classteacher/examreport/{bid}/{id}',[reportcontroller::class,'sectionreports']);
Route::post('classteacher/exam/detailedreport',[reportcontroller::class,'detailedreport']);
Route::get('classteacher/exam/swot/{id}',[reportcontroller::class,'swot']);
Route::get('classteacher/assignmentreport/{id}',[reportcontroller::class,'assignmentreport']);

Route::get('classteacher/assigned/{id}',[classteacherlifecontroller::class,'assindex']);
Route::get('classteacher/assigned/students/{id}',[classteacherlifecontroller::class,'assstudents']);

Route::get('classteacher/attended/{id}',[classteacherlifecontroller::class,'attindex']);
Route::get('classteacher/attended/students/{id}',[classteacherlifecontroller::class,'attstudents']);
Route::get('classteacher/attended/students/assignments/view/{id}',[classteacherlifecontroller::class,'assignments']);

Route::get('classteacher/completed/{id}',[classteacherlifecontroller::class,'comindex']);
Route::get('classteacher/completed/students/{id}',[classteacherlifecontroller::class,'comstudents']);
Route::get('classteacher/completed/students/approved/{id}',[classteacherlifecontroller::class,'comapstudents']);
Route::get('classteacher/completed/students/pass/{id}/{cid}',[classteacherlifecontroller::class,'postpass']);

Route::get('classteacher/analytics',[classteacheranalyticcontroller::class,'index']);
Route::post('classteacher/analytics/fetch',[classteacheranalyticcontroller::class,'fetch']);
Route::get('classteacher/analytic/data/pre/',[classteacheranalyticcontroller::class,'predata']);
Route::get('classteacher/analytic/data/post/',[classteacheranalyticcontroller::class,'postdata']);

Route::get('classteacher/schedule/index',[classteacheranalyticcontroller::class,'getclassdata']);
Route::get('classteacher/faculty/list/{id}/{day}',[classteacheranalyticcontroller::class,'list']);
Route::post('classteacher/fetch/class/data',[classteacheranalyticcontroller::class,'getclassdata']);

Route::get('classteacher/infrastructure/info',[classinfracontroller::class,'infrainfo']);
Route::get('classteacher/infrastructure/repair/{id}',[classinfracontroller::class,'repair']);
Route::get('classteacher/infrastructure/repair/end/{id}',[classinfracontroller::class,'repairend']);


Route::get('classteacher/attendance/view/dates',[classteacherattendancecontroller::class,'dates']);
Route::get('classteacher/attendance/view/students',[classteacherattendancecontroller::class,'students']);
Route::post('classteacher/attendence/save',[classteacherattendancecontroller::class,'saveattendance']);
Route::get('classteacher/attendence/holiday/save/{date}/{holidayid}',[classteacherattendancecontroller::class,'holidayattendance']);

Route::get('classteacher/attendance/report/view/months',[classteacherattendancereportcontroller::class,'months']);
Route::any('classteacher/attendance/report/view/dates',[classteacherattendancereportcontroller::class,'getdates']);
Route::post('classteacher/attendance/report/view/students/bydate',[classteacherattendancereportcontroller::class,'students']);

Route::get('classteacher/schedule/timetable',[classteacherassignmentscontroller::class,'gettimeTable']);

Route::get('classteacher/fees/pending',[classteacherfeescontroller::class,'pendingfeesstudents']);
Route::post('classteacher/fees/pending/students/bysection',[classteacherfeescontroller::class,'pendingfeesstudentsbysection']);
Route::get('classteacher/fees/pending/students/export/{class}/{section}',[classteacherfeescontroller::class,'pendingfeesexport']);
Route::get('classteacher/fees/index/students',[classteacherfeescontroller::class,'indexfeesstudents']);
Route::post('classteacher/fees/index/students/bysection',[classteacherfeescontroller::class,'indexfeesstudentsbysection']);
Route::get('classteacher/fees/index/students/export/{id}',[classteacherfeescontroller::class,'feesexport']);
Route::get('classteacher/fees/index/students/view/structure/{id}',[classteacherfeescontroller::class,'feesstructure']);

Route::get('classteacher/analytics/attendance',[classteacherattendanceanalyticcontroller::class,'index']);
Route::post('classteacher/analytics/attendance/fetch',[classteacherattendanceanalyticcontroller::class,'fetch']);
Route::get('classteacher/analytic/attendance/fetch/datewise',[classteacherattendanceanalyticcontroller::class,'datewise']);

Route::get('classteacher/analytic/assignment',[classteacherassignmentanalyticcontroller::class,'index']);
Route::get('classteacher/trainings/get',[classteacherassignmentanalyticcontroller::class,'gettrainings']);
Route::post('classteacher/analytics/assignment/fetch',[classteacherassignmentanalyticcontroller::class,'fetch']);
Route::get('classteacher/analytic/assignment/notcompleted',[classteacherassignmentanalyticcontroller::class,'notcompleted']);
Route::get('classteacher/analytic/assignment/completed',[classteacherassignmentanalyticcontroller::class,'completed']);

Route::get('classteacher/analytics/pendingfees',[classteachertotalfeesanalyticcontroller::class,'index']);
Route::post('classteacher/analytics/pendingfees/fetch',[classteachertotalfeesanalyticcontroller::class,'fetch']);
Route::get('classteacher/analytics/currentfees',[classteachertotalfeesanalyticcontroller::class,'currentindex']);
Route::post('classteacher/analytics/currentfees/fetch',[classteachertotalfeesanalyticcontroller::class,'currentfetch']);
Route::get('classteacher/analytic/currentfees/monthwise',[classteachertotalfeesanalyticcontroller::class,'getmonth']);

Route::get('classteacher/distribution/add',[classteacherdistributioncontroller::class,'distributionstudents']);
Route::post('classteacher/distribution/add/bysection',[classteacherdistributioncontroller::class,'distributionstudentsbysection']);
Route::post('classteacher/distribution/save',[classteacherdistributioncontroller::class,'distributionsave']);

Route::get('classteacher/competition/reports',[classteachercompetitionreportcontroller::class,'competition']);
Route::post('classteacher/competition/reports/view',[classteachercompetitionreportcontroller::class,'competitionreports']);

Route::get('classteacher/analytics/competition',[classteachercompetitionanalyticcontroller::class,'index']);
Route::post('classteacher/analytics/competition/fetch',[classteachercompetitionanalyticcontroller::class,'fetch']);
});

Route::get('classteacher/logout',function(){
session()->forget('CLASSTEACHER_LOGIN');
session()->forget('CLASSTEACHER_ID');
session()->forget('CLASSTEACHER_ADMIN_ID');
session()->forget('CLASSTEACHER_SUP_ID');
session()->forget('CLASSTEACHER_CLASS_ID');
session()->forget('CLASSTEACHER_SECTION_ID');
session()->forget('CLASSTEACHER_Name');
session()->forget('CLASSTEACHER_Email');
session()->forget('CLASSTEACHER_Number');
session()->flash('logout','Logged Out Sucessfully');
return redirect('/');
});




Route::get('faculty/login',[facultycontroller::class ,'login']);
Route::post('faculty/login/save',[facultycontroller::class ,'logincheck']);
Route::get('faculty/forgotpassword',[facultycontroller::class ,'forgotpassword']);
Route::post('faculty/forgotpassword/check',[facultycontroller::class ,'forgotpasswordcheck']);

Route::group(['middleware'=>'faculty_auth'],function(){

Route::get('faculty/dashboard',[facultycontroller::class ,'dashboard']);

Route::get('faculty/adddetails',[facultycontroller::class,'adddetails']);
Route::post('faculty/adddetails/processing',[facultycontroller::class,'savedetails']);

Route::get('faculty/rescheduled/classes',[facultycontroller::class,'rescheduledclasses']);
Route::get('faculty/rescheduled/completed/{status}/{id}',[facultycontroller::class,'completedstatus']);

Route::get('faculty/assignment/assigned',[facultyassignmentcontroller::class,'assigned']);
Route::get('faculty/assignment/assign/add',[facultyassignmentcontroller::class,'addassign']);
Route::post('faculty/assignment/assign/save',[facultyassignmentcontroller::class, 'saveassign']);
Route::get('faculty/assignment/assigned/view/students/{id}',[facultyassignmentcontroller::class,'viewassignedstudents']);
Route::post('faculty/assignment/submitted/save',[facultyassignmentcontroller::class, 'movetosubmitassignment']);
Route::get('faculty/assignment/submitted',[facultyassignmentcontroller::class,'submitted']);
Route::get('faculty/assignment/submitted/view/students/{id}',[facultyassignmentcontroller::class,'viewsubmittedstudents']);
Route::get('faculty/assignment/submitted/view/details/{id}',[facultyassignmentcontroller::class,'viewsubmitteddetails']);
Route::post('faculty/assignment/submitted/answer/save',[facultyassignmentcontroller::class, 'savesubmittedanswer']);
Route::post('faculty/assignment/moveto/corrected',[facultyassignmentcontroller::class, 'movetocorrectedassignment']);
Route::get('faculty/assignment/corrected',[facultyassignmentcontroller::class,'corrected']);
Route::get('faculty/assignment/corrected/view/students/{id}',[facultyassignmentcontroller::class,'viewcorrectedstudents']);
Route::get('faculty/assignment/corrected/view/details/{id}',[facultyassignmentcontroller::class,'viewcorrecteddetails']);
Route::post('faculty/assignment/corrected/answer/save',[facultyassignmentcontroller::class, 'savecorrectedanswer']);
Route::post('faculty/assignment/moveto/completed',[facultyassignmentcontroller::class, 'movetocompletedassignment']);
Route::get('faculty/assignment/completed',[facultyassignmentcontroller::class,'completed']);
Route::get('faculty/assignment/completed/view/students/{id}',[facultyassignmentcontroller::class,'viewcompletedstudents']);
Route::get('faculty/getsection/byassignationid/{id}', [facultyassignmentcontroller::class,'getsection']);
Route::get('faculty/gettraining/byassignationid/{id}', [facultyassignmentcontroller::class,'gettraining']);

Route::get('faculty/leave',[facultyleavecontroller::class, 'leave']);
Route::get('faculty/leave/addleave',[facultyleavecontroller::class, 'addleave']);
Route::get('faculty/leave/addleave/{id}',[facultyleavecontroller::class, 'addleave']);
Route::post('faculty/leave/saveleave',[facultyleavecontroller::class,'saveleave']);
Route::get('faculty/leave/delete/{id}',[facultyleavecontroller::class,'leavedelete']);

Route::get('faculty/profile',[facultycontroller::class,'profile']);
Route::post('faculty/profile/processing',[facultycontroller::class,'update']);

Route::get('faculty/schedule/list',[facculyschedulecontroller::class,'list']);

Route::get('faculty/assignments',[facultyreportscontroller::class,'assreports']);
Route::post('faculty/assignments/trainingwise',[facultyreportscontroller::class,'fetchstudent']);

Route::get('faculty/reports',[facultyreportscontroller::class,'reports']);
Route::get('faculty/classby/section/{id}',[facultyreportscontroller::class,'classby']);
Route::post('faculty/reports/sectionwise',[facultyreportscontroller::class,'fetchstu']);
Route::get('faculty/examreport/{id}',[facultyreportscontroller::class,'sectionreports']);
Route::post('faculty/exam/detailedreport',[facultyreportscontroller::class,'detailedreport']);
Route::get('faculty/exam/swot/{id}',[facultyreportscontroller::class,'swot']);
Route::get('faculty/assignmentreport/{id}',[facultyreportscontroller::class,'assignmentreport']);

Route::get('faculty/attendance/view/months',[facultyattendancecontroller::class,'months']);
Route::any('faculty/attendance/view/sections',[facultyattendancecontroller::class,'getsections']);
Route::any('faculty/attendance/view/dates',[facultyattendancecontroller::class,'getdates']);
Route::post('faculty/attendance/view/students/bydate',[facultyattendancecontroller::class,'students']);

Route::get('faculty/analytics',[facultyanalyticcontroller::class,'index']);
Route::post('faculty/analytics/fetch',[facultyanalyticcontroller::class,'fetch']);
Route::get('faculty/analytic/data/pre/',[facultyanalyticcontroller::class,'predata']);
Route::get('faculty/analytic/data/post/',[facultyanalyticcontroller::class,'postdata']);

Route::get('faculty/analytics/attendance',[facultyattendanceanalyticcontroller::class,'index']);
Route::post('faculty/analytics/attendance/fetch',[facultyattendanceanalyticcontroller::class,'fetch']);
Route::get('faculty/analytic/attendance/fetch/datewise',[facultyattendanceanalyticcontroller::class,'datewise']);

Route::get('faculty/analytic/assignment',[facultyassignmentanalyticcontroller::class,'index']);
Route::get('faculty/trainings/get',[facultyassignmentanalyticcontroller::class,'gettrainings']);
Route::post('faculty/analytics/assignment/fetch',[facultyassignmentanalyticcontroller::class,'fetch']);
Route::get('faculty/analytic/assignment/notcompleted',[facultyassignmentanalyticcontroller::class,'notcompleted']);
Route::get('faculty/analytic/assignment/completed',[facultyassignmentanalyticcontroller::class,'completed']);


});

Route::get('faculty/logout',function(){
session()->forget('FACULTY_LOGIN');
session()->forget('FACULTY_ID');
session()->forget('FACULTY_ADMIN_ID');
session()->forget('FACULTY_SUP_ID');
session()->forget('FACULTY_Name');
session()->forget('FACULTY_Email');
session()->forget('FACULTY_Number');
session()->flash('logout','Logged Out Sucessfully');
return redirect('/');
});




Route::get('student/login',[studentcontroller::class ,'login']);
Route::post('student/login/save',[studentcontroller::class ,'logincheck']);
Route::get('student/forgotpassword',[studentcontroller::class ,'forgotpassword']);
Route::post('student/forgotpassword/check',[studentcontroller::class ,'forgotpasswordcheck']);

Route::group(['middleware'=>'student_auth'],function(){

Route::get('student/dashboard',[studentcontroller::class ,'dashboard']);

Route::get('student/adddetails',[studentcontroller::class,'adddetails']);
Route::post('student/adddetails/processing',[studentcontroller::class,'savedetails']);
Route::get('student/state/{id}', [studentcontroller::class,'getcity']);

Route::get('student/content/skillattribute',[studentcontentcontroller::class, 'contentska']);
Route::post('student/content/skillattribute/byskillset',[studentcontentcontroller::class, 'contentskabyskillset']);
Route::get('student/content/skillattribute/domain',[studentcontentcontroller::class,'getdomain']);
Route::get('student/content/skillattribute/skillset',[studentcontentcontroller::class,'getskillset']);

Route::get('exam/info/{id}',[mainexamcontroller::class,'examcard']);
Route::get('/skillrevelation/mainassesment/',[mainexamcontroller::class,'start']);
Route::get('/skillrevelation/mainexampage',[mainexamcontroller::class,'exam']);

Route::get('student/exam/mainassement/{id}/{asid}',[mainexamcontroller::class,'start']);
Route::get('exam/section/{id}/{count}/{abid}',[mainexamcontroller::class,'questions']);
Route::get('exam/getquestions/next/{id}/{assid}/{count}/{secid}',[mainexamcontroller::class,'getq']);
Route::get('exam/getquestions/{id}/{assid}/{count}/{secid}',[mainexamcontroller::class,'preq']);
Route::get('exam/answer/{id}/{assid}/{confident}/{count}/{sec}',[mainexamcontroller::class,'ans']);
Route::get('exam/section/submit/{id}/{sec}/{abid}',[mainexamcontroller::class,'sectionsubmit']);
Route::get('exam/final/submit/{id}/{abid}',[mainexamcontroller::class,'finalsubmit']);

//reports
Route::get('exam/reports',[examreportcontroller::class,'index']);
Route::get('exam/sectionreport/{aid}/{id}',[examreportcontroller::class,'sectionreports']);
Route::post('exam/detailedreport',[examreportcontroller::class,'detailedreport']);
Route::get('exam/swot/{id}',[examreportcontroller::class,'swot']);

Route::get('student/assignmentreport/{id}',[examreportcontroller::class,'assignmentreport']);

Route::get('student/profile',[studentcontroller::class,'profile']);
Route::post('student/profile/processing',[studentcontroller::class,'update']);

Route::get('student/assignment/assigned',[studentassignmentcontroller::class,'assigned']);
Route::get('student/assignment/assigned/view/{id}',[studentassignmentcontroller::class,'viewdetails']);
Route::post('student/assignment/assigned/answer/save',[studentassignmentcontroller::class, 'saveanswer']);
Route::get('student/assignment/submitted',[studentassignmentcontroller::class,'submitted']);
Route::get('student/assignment/corrected',[studentassignmentcontroller::class,'corrected']);
Route::get('student/assignment/corrected/view/{id}',[studentassignmentcontroller::class,'viewcorrecteddetails']);
Route::get('student/assignment/completed',[studentassignmentcontroller::class,'completed']);


Route::get('student/assigned/{id}',[studentlifecontroller::class,'assindex']);
Route::get('student/assigned/students/{id}',[studentlifecontroller::class,'assstudents']);


Route::get('student/attended/{id}',[studentlifecontroller::class,'attindex']);
Route::get('student/attended/students/{id}',[studentlifecontroller::class,'attstudents']);
Route::get('student/attended/students/assignments/view/{id}',[studentlifecontroller::class,'assignments']);

Route::get('student/completed/{id}',[studentlifecontroller::class,'comindex']);
Route::get('student/completed/students/{id}',[studentlifecontroller::class,'comstudents']);
Route::get('student/completed/students/approved/{id}',[studentlifecontroller::class,'comapstudents']);
Route::get('student/completed/students/pass/{id}/{cid}',[studentlifecontroller::class,'postpass']);

Route::get('student/attendance/view/months',[studentattendancecontroller::class,'months']);
Route::get('student/attendance/view/monthwise/{month}',[studentattendancecontroller::class,'dates']);
Route::get('student/bus/attendance/view/monthwise/{month}',[studentattendancecontroller::class,'busdates']);

Route::get('student/fees/pending/reports',[studentfeescontroller::class,'pendingfeesreports']);
Route::get('student/fees/selection',[studentfeescontroller::class,'selection']);
Route::post('student/fees/selection/save',[studentfeescontroller::class,'saveselection']);
Route::get('student/fees/payment/view',[studentfeescontroller::class,'paymentview']);
Route::post('student/fees/selection/permanant/save',[studentfeescontroller::class,'saveselectionpermanant']);
Route::get('student/fees/payment',[studentfeescontroller::class,'payment']);
Route::get('student/fees/getmoney',[studentfeescontroller::class,'getmoney']);

//Timetable
Route::get('student/class/timetable',[studentattendancecontroller::class,'classtimeTable']);
Route::get('student/bus/timetable',[studentattendancecontroller::class,'bustimeTable']);
Route::get('student/analytics/attendance',[studentattendanceanalyticcontroller::class,'index']);
Route::get('student/analytics/attendance/monthwise',[studentattendanceanalyticcontroller::class,'getmonth']);

Route::get('student/competition/view/{id}',[studentcompetitioncontroller::class ,'viewcompetition']);
Route::get('student/competition/apply/{id}',[studentcompetitioncontroller::class ,'applycompetition']);
Route::get('student/competition',[studentcompetitioncontroller::class ,'competitionstatus']);

Route::get('student/food/schedule',[studentcontentcontroller::class,'food']);
Route::get('student/menu/getdata',[studentcontentcontroller::class,'getdata']);
Route::get('student/food/skip/{day}/{cat}',[studentcontentcontroller::class,'skipmeal']);
Route::get('student/food/undo/skip/{day}/{cat}',[studentcontentcontroller::class,'undo']);
Route::post('student/food/feedback',[studentcontentcontroller::class,'feedback']);

});

Route::get('student/logout',function(){
session()->forget('STUDENT_LOGIN');
session()->forget('STUDENT_ID');
session()->forget('STUDENT_ADMIN_ID');
session()->forget('STUDENT_MANAGER_ID');
session()->forget('STUDENT_CLASS_ID');
session()->forget('STUDENT_SECTION_ID');
session()->forget('STUDENT_Name');
session()->forget('STUDENT_Email');
session()->forget('STUDENT_Number');
session()->flash('logout','Logged Out Sucessfully');
return redirect('/');
});


Route::get('dashboard/examination', [ExaminationController::class, 'edashboard'])->name('dashboard.examination');
Route::get('Controller/Account/dashboard', [AccountController::class, 'accountDashboard'])->name('dashboard.account');
Route::get('dashboard/account', [AccountController::class, 'accountDashboard'])->name('dashboard.account');
Route::post('Accontrol/login/save', [AcademicController::class, 'save'])->name('accontrol.login.save');
Route::get('Accontrol/forgotpassword', [AcademicController::class, 'forgotpassword']);
Route::post('Accontrol/forgotpassword/check', [AcademicController::class, 'forgotpasswordcheck']);
Route::get('dashboard/academic', [AcademicController::class, 'academicDashboard'])->name('dashboard.academic');
Route::get('Controller/Academ/dashboard', [AcademicController::class, 'academicDashboard'])->name('dashboard.academic');


Route::get('nontech/groupmanager/login',[nontechgroupmanagercontroller::class ,'login']);
Route::post('nontech/groupmanager/login/save',[nontechgroupmanagercontroller::class ,'logincheck']);
Route::get('nontech/groupmanager/forgotpassword',[nontechgroupmanagercontroller::class ,'forgotpassword']);
Route::post('nontech/groupmanager/forgotpassword/check',[nontechgroupmanagercontroller::class ,'forgotpasswordcheck']);

Route::group(['middleware'=>'nontechgroupmanager_auth'],function(){

Route::get('nontech/groupmanager/dashboard',[nontechgroupmanagercontroller::class ,'dashboard']);

Route::get('nontechgroupmanager/details/dashboard/view/{id}',[nontechgroupmanagercontroller::class,'dashboardinfo']);

//Hostel
Route::post('nontech/groupmanager/hostel/info',[hostelinfocontroller::class,'hostelinfo']);
Route::get('nontech/groupmanager/bedallocation/info/{id}',[hostelinfocontroller::class,'bedinfo']);
Route::get('nontech/groupmanager/infrastructure/hostels/getroom',[hostelinfocontroller::class,'getrooms']);
Route::post('nontech/groupmanager/hostel/allocation/filter',[hostelinfocontroller::class,'bedinfobyfilter']);
Route::get('nontech/groupmanager/bedallocation/info/export/{id}',[hostelinfocontroller::class,'bedinfoexport']);
Route::get('nontech/groupmanager/rooms/info/{id}',[hostelinfocontroller::class,'roominfo']);
Route::post('nontech/groupmanager/room/info/byfilter',[hostelinfocontroller::class,'roominfobyfilter']);
Route::get('nontech/groupmanager/room/info/byfilter/export/{id}',[hostelinfocontroller::class,'roominfoexport']);
Route::get('nontech/groupmanager/hostel/infrastructure/info/{id}',[hostelinfocontroller::class,'infrainfo']);
Route::post('nontech/groupmanager/hostel/infrastructure/infobyfilter',[hostelinfocontroller::class,'infrainfobyfilter']);
Route::get('nontech/groupmanager/hostel/infrastructure/infobyfilter/export/{id}',[hostelinfocontroller::class,'infrainfoexport']);
Route::get('nontech/groupmanager/food/info/{id}',[hostelinfocontroller::class,'foodinfo']);
Route::post('nontech/groupmanager/food/infobyfilter',[hostelinfocontroller::class,'foodinfobyfilter']);
Route::get('nontech/groupmanager/hostel/getmenu/data',[hostelinfocontroller::class,'getdata']);
Route::get('nontech/groupmanager/hostel/infrastructure/reports/{id}',[hostelinfocontroller::class,'infrastructurerepairs']);
Route::post('nontech/groupmanager/hostel/infrastructure/reportsbyfilter',[hostelinfocontroller::class,'infrastructurerepairsbyfilter']);
Route::get('nontech/groupmanager/hostel/infrastructure/reportsbyfilter/export/{id}',[hostelinfocontroller::class,'infrastructurerepairsinfoexport']);
Route::get('nontech/groupmanager/hostel/foodskip/reports/{id}',[hostelinfocontroller::class,'skipreports']);
Route::post('nontech/groupmanager/hostel/foodskip/reportsbyfilter',[hostelinfocontroller::class,'skipreportsbyfilter']);
Route::get('nontech/groupmanager/hostel/foodskip/reportsbyfilter/export/{id}',[hostelinfocontroller::class,'skiprepairsinfoexport']);

//Infra
Route::post('nontech/groupmanager/infra/info',[infrainfocontroller::class,'infrainfo']);
Route::get('nontech/groupmanager/infra/school/info/{id}',[infrainfocontroller::class,'schoolinfra']);
Route::get('nontech/groupmanager/view/sections',[infrainfocontroller::class,'getsections']);
Route::post('nontech/groupmanager/infra/school/infobyfilter',[infrainfocontroller::class,'schoolinfrabyfilter']);
Route::get('nontech/groupmanager/infra/school/info/export/{id}',[infrainfocontroller::class,'schoolinfraexport']);
Route::get('nontech/groupmanager/infra/cafeteria/info/{id}',[infrainfocontroller::class,'cafeteriainfra']);
Route::get('nontech/groupmanager/infra/cafeteria/getname',[infrainfocontroller::class,'getnames']);
Route::post('nontech/groupmanager/infra/cafeteria/infobyfilter',[infrainfocontroller::class,'cafeteriainfrabyfilter']);
Route::get('nontech/groupmanager/infra/cafeteria/info/export/{id}',[infrainfocontroller::class,'cafeteriainfraexport']);
Route::get('nontech/groupmanager/infra/hostel/info/{id}',[infrainfocontroller::class,'hostelinfra']);
Route::get('nontech/groupmanager/infra/hostels/getroom',[infrainfocontroller::class,'getrooms']);
Route::post('nontech/groupmanager/infra/hostel/infobyfilter',[infrainfocontroller::class,'hostelinfrabyfilter']);
Route::get('nontech/groupmanager/infra/hostel/info/export/{id}',[infrainfocontroller::class,'hostelinfraexport']);
Route::get('nontech/groupmanager/infra/items/{id}',[infrainfocontroller::class,'infraitems']);
Route::get('nontech/groupmanager/infra/items/export/{id}',[infrainfocontroller::class,'infraitemsexport']);
Route::get('nontech/groupmanager/infra/repairs/{id}',[infrainfocontroller::class,'repair']);
Route::get('nontech/groupmanager/infra/others/info/{id}',[infrainfocontroller::class,'othersinfra']);
Route::get('nontech/groupmanager/view/sections',[infrainfocontroller::class,'getsections']);
Route::post('nontech/groupmanager/others/infrastructure/infobyfilter',[infrainfocontroller::class,'othersinfrabyfilter']);


//Transport
Route::get('nontech/groupmanager/attendance/view/months',[nontechgroupmanagerattendancecontroller::class,'months']);
Route::any('nontech/groupmanager/attendance/view/dates',[nontechgroupmanagerattendancecontroller::class,'getdates']);
Route::post('nontech/groupmanager/attendance/view/students/bydate',[nontechgroupmanagerattendancecontroller::class,'students']);


//Food
Route::post('nontech/groupmanager/food/info',[foodinfocontroller::class,'foodinfo']);
Route::get('nontech/groupmanager/food/school/infrastructure/{id}',[foodinfocontroller::class,'school']);
Route::get('nontech/groupmanager/food/school/infrastructure/export/{aid}',[foodinfocontroller::class,'schoolexport']);
Route::get('nontech/groupmanager/food/hostel/infrastructure/{id}',[foodinfocontroller::class,'hostel']);
Route::get('nontech/groupmanager/food/hostel/infrastructure/export/{aid}',[foodinfocontroller::class,'hostelexport']);
Route::get('nontech/groupmanager/food/others/infrastructure/{id}',[foodinfocontroller::class,'others']);
Route::get('nontech/groupmanager/food/others/infrastructure/export/{aid}',[foodinfocontroller::class,'othersexport']);
Route::get('nontech/groupmanager/food/feedback/{id}',[foodinfocontroller::class,'feedback']);
Route::post('nontech/groupmanager/food/byfilter/feedback',[foodinfocontroller::class,'feedbackbyfilter']);
Route::get('nontech/groupmanager/food/feedback/export/{aid}',[foodinfocontroller::class,'feedbackexport']);
Route::get('nontech/groupmanager/food/items/info/{id}',[foodinfocontroller::class,'items']);
Route::get('nontech/groupmanager/food/items/info/export/{aid}/{mid}',[foodinfocontroller::class,'itemsexport']);
Route::get('nontech/groupmanager/food/caterers/{id}',[foodinfocontroller::class,'caterer']);
Route::get('nontech/groupmanager/food/caterers/export/{aid}/{mid}',[foodinfocontroller::class,'catererexport']);


Route::get('nontech/groupmanager/adddetails',[nontechgroupmanagercontroller::class,'adddetails']);
Route::post('nontech/groupmanager/adddetails/processing',[nontechgroupmanagercontroller::class,'savedetails']);

//Infra Management
Route::get('nontechgroupmanager/infra/others/details',[nontechgroupmanagercontroller::class,'others']);
Route::post('nontechgroupmanager/infra/others/details/byfilter',[nontechgroupmanagercontroller::class,'filter']);
Route::get('nontechgroupmanager/infra/others/repair/{id}',[nontechgroupmanagercontroller::class,'repair']);
Route::get('nontechgroupmanager/infra/others/repair/completed/{id}',[nontechgroupmanagercontroller::class,'repairend']);

Route::get('nontech/groupmanager/profile',[nontechgroupmanagercontroller::class,'profile']);
Route::post('nontech/groupmanager/profile/processing',[nontechgroupmanagercontroller::class,'update']);

});

Route::get('nontech/groupmanager/logout',function(){
session()->forget('NONTECH_GROUPMANAGER_LOGIN');
session()->forget('NONTECH_GROUPMANAGER_ID');
session()->forget('NONTECH_GROUPMANAGER_ADMIN_ID');
session()->forget('NONTECH_GROUPMANAGER_SUP_ID');
session()->forget('NONTECH_GROUPMANAGER_DEPT_ID');
session()->forget('NONTECH_GROUPMANAGER_Name');
session()->forget('NONTECH_GROUPMANAGER_Email');
session()->forget('NONTECH_GROUPMANAGER_Number');
session()->flash('logout','Logged Out Sucessfully');
return redirect('/');
});




Route::get('nontech/manager/login',[nontechmanagercontroller::class ,'login']);
Route::post('nontech/manager/login/save',[nontechmanagercontroller::class ,'logincheck']);
Route::get('nontech/manager/forgotpassword',[nontechmanagercontroller::class ,'forgotpassword']);
Route::post('nontech/manager/forgotpassword/check',[nontechmanagercontroller::class ,'forgotpasswordcheck']);

Route::group(['middleware'=>'nontechmanager_auth'],function(){

Route::get('nontech/manager/dashboard',[nontechmanagercontroller::class ,'dashboard']);

Route::get('nontech/manager/adddetails',[nontechmanagercontroller::class,'adddetails']);
Route::post('nontech/manager/adddetails/processing',[nontechmanagercontroller::class,'savedetails']);

Route::get('nontech/manager/profile',[nontechmanagercontroller::class,'profile']);
Route::post('nontech/manager/profile/processing',[nontechmanagercontroller::class,'update']);

Route::get('nontech/managers/transportstudents',[nontechmanagerstransportcontroller::class,'index']);
Route::post('nontech/managers/transportstudents/by/busroute',[nontechmanagerstransportcontroller::class,'students']);
Route::get('nontech/managers/transportstudents/export/{busroute}',[nontechmanagerstransportcontroller::class,'studentsexport']);
Route::post('nontech/managers/transportstudents/savetime',[nontechmanagerstransportcontroller::class,'savetime']);


Route::get('nontech/manager/transportstudents',[nontechmanagertransportcontroller::class,'index']);
Route::get('nontech/manager/view/locations/{id}',[nontechmanagertransportcontroller::class,'getlocations']);
Route::post('nontech/manager/transportstudents/by/busroute',[nontechmanagertransportcontroller::class,'students']);
Route::get('nontech/manager/transportstudents/export/{location}',[nontechmanagertransportcontroller::class,'studentsexport']);
Route::post('nontech/manager/transportstudents/savetime',[nontechmanagertransportcontroller::class,'savetime']);

Route::get('nontech/manager/attendance',[nontechmanagerattendancecontroller::class,'attendance']);
Route::get('nontech/manager/attendance/pickup/students/{busroute}',[nontechmanagerattendancecontroller::class,'pickupstudents']);
Route::get('nontech/manager/attendance/drop/students/{busroute}',[nontechmanagerattendancecontroller::class,'dropstudents']);
Route::post('nontech/manager/attendence/pickup/save',[nontechmanagerattendancecontroller::class,'pickupsave']);
Route::post('nontech/manager/attendence/drop/save',[nontechmanagerattendancecontroller::class,'dropsave']);
Route::get('nontech/manager/view/sections',[nontechmanagercontroller::class,'getsections']);
Route::get('nontech/manager/view/students',[nontechmanagercontroller::class,'getstudents']);



//Hostel
Route::get('nontech/manager/hostel/rooms',[hostelroomcontroller::class, 'rooms']);
Route::get('nontech/manager/hostel/rooms/addrooms',[hostelroomcontroller::class, 'addrooms']);
Route::get('nontech/manager/hostel/rooms/addrooms/{id}',[hostelroomcontroller::class, 'addrooms']);
Route::post('nontech/manager/hostel/rooms/saverooms',[hostelroomcontroller::class,'saverooms']);
Route::get('nontech/manager/hostel/rooms/export/{mid}',[hostelroomcontroller::class,'roomdataexport']);

Route::get('nontech/manager/hostel/bedallocation',[hostelallocationcontroller::class,'allocation']);
Route::post('nontech/manager/hostel/bed/byfilter',[hostelallocationcontroller::class,'allocationbyfilter']);
Route::get('nontech/manager/hostel/bed/assign/{id}',[hostelallocationcontroller::class,'bedassign']);
Route::get('nontech/manager/hostel/bed/retire/{id}',[hostelallocationcontroller::class,'retire']);
Route::get('nontech/manager/hostel/bed/reassign/{id}',[hostelallocationcontroller::class,'reassign']);
Route::post('nontech/manager/hostel/bed/assign/save',[hostelallocationcontroller::class,'save']);
Route::post('nontech/manager/hostel/bed/reassign/save',[hostelallocationcontroller::class,'resave']);
Route::get('nontech/manager/hostel/bed/byfilter/export/{aid}',[hostelallocationcontroller::class,'beddataexport']);

Route::get('nontech/manager/hostel/Infrastructure/info',[hostelroomcontroller::class,'info']);
Route::post('nontech/manager/hostel/info/byfilter',[hostelroomcontroller::class,'infobyfilter']);
Route::get('nontech/manager/hostel/repair/{id}',[hostelroomcontroller::class,'repair']);
Route::get('nontech/manager/hostel/repair/completed/{id}',[hostelroomcontroller::class,'repairend']);
Route::get('nontech/manager/hostel/rooms/confirm/change/{id}',[hostelroomcontroller::class,'acceptchange']);
Route::get('nontech/manager/hostel/info/byfilter/export/{aid}',[hostelroomcontroller::class,'hostelinfrastructuredataexport']);

Route::get('nontech/manager/hostel/menu',[hostelroomcontroller::class,'menu']);
Route::post('nontech/manager/hostel/menu/byfilter',[hostelroomcontroller::class,'menubyfilter']);
Route::get('nontech/manager/hostel/getmenu/data',[hostelroomcontroller::class,'getdata']);

Route::get('nontech/manager/hostel/allocations/reports',[hostelreportscontroller::class,'allocationreports']);
Route::post('nontech/manager/hostel/allocation/filter',[hostelreportscontroller::class,'allocationreportsbyfilter']);
Route::get('nontech/manager/hostel/infrastructure/repair/reports',[hostelreportscontroller::class,'infrastructurerepairs']);
Route::post('nontech/manager/hostel/infra/repair/history/byfilter',[hostelreportscontroller::class,'infrastructurerepairsbyfilter']);
Route::get('nontech/manager/hostel/food/reports',[hostelreportscontroller::class,'foodreports']);
Route::post('nontech/manager/hostel/food/report/byfilter',[hostelreportscontroller::class,'foodreportsbyfilter']);




//Infrastructure

Route::get('nontech/manager/infrastructure/items',[infrastructureroomcontroller::class, 'items']);
Route::get('nontech/manager/infrastructure/items/additems',[infrastructureroomcontroller::class, 'additems']);
Route::get('nontech/manager/infrastructure/items/additems/{id}',[infrastructureroomcontroller::class, 'additems']);
Route::post('nontech/manager/infrastructure/items/saveitems',[infrastructureroomcontroller::class,'saveitems']);

Route::get('nontech/manager/infrastructure/work/{id}',[infrastructureworkcontroller::class,'work']);

Route::get('nontech/manager/infrastructure/hostels/getroom',[infrastructureworkcontroller::class,'getrooms']);
Route::get('nontech/manager/infrastructure/add/hostelitems',[infrastructureworkcontroller::class,'addhostelitems']);
Route::get('nontech/manager/infrastructure/getroom/info',[infrastructureworkcontroller::class,'getroominfo']);
Route::post('nontech/manager/infrastructure/hostel/uploaditems',[infrastructureworkcontroller::class,'upload']);
Route::get('nontech/manager/infrastructure/hostel/info',[infrastructureworkcontroller::class,'hostelinfo']);
Route::post('nontech/manager/infrastructure/hostel/info/byfilter',[infrastructureworkcontroller::class,'filter']);
Route::get('nontech/manager/infrastructure/hostel/info/export/{mid}',[infrastructureworkcontroller::class,'hostelexport']);
Route::get('nontech/manager/infrastructure/hostel/edit/items/{id}',[infrastructureworkcontroller::class,'edithostelitem']);
Route::post('nontech/manager/infrastructure/hostel/item/savedata',[infrastructureworkcontroller::class,'savedetails']);

Route::get('nontech/manager/infrastructure/repairs/{id}',[infrastructureworkcontroller::class,'repairs']);
Route::get('nontech/manager/infrastructure/repair/start/{id}',[infrastructureworkcontroller::class,'repairstart']);
Route::get('nontech/manager/infrastructure/repair/end/{id}',[infrastructureworkcontroller::class,'repairend']);


Route::get('nontech/manager/infrastructure/school/repair/start/{id}',[infrastructureworkcontroller::class,'schoolrepairstart']);
Route::get('nontech/manager/infrastructure/school/repair/end/{id}',[infrastructureworkcontroller::class,'schoolrepairend']);

Route::get('nontech/manager/infrastructure/cafeteria/repair/start/{id}',[infrastructureworkcontroller::class,'cafeteriarepairstart']);

Route::get('nontech/manager/infrastructure/additional',[infrastructureworkcontroller::class,'additional']);
Route::get('nontech/manager/infrastructure/room/change/approval/{id}/{status}',[infrastructureworkcontroller::class,'changeapproval']);

Route::get('nontech/manager/infrastructure/add/schoolitems',[infrastructureschoolcontroller::class,'addschoolitems']);
Route::post('nontech/manager/infrastructure/school/uploaditems',[infrastructureschoolcontroller::class,'upload']);
Route::get('nontech/manager/infrastructure/school/info',[infrastructureschoolcontroller::class,'info']);
Route::get('nontech/manager/infrastructure/school/edit/items/{id}',[infrastructureschoolcontroller::class,'editschoolitem']);
Route::post('nontech/manager/infrastructure/school/item/savedata',[infrastructureschoolcontroller::class,'savedetails']);
Route::get('nontech/manager/infrastructure/school/getsection',[infrastructureschoolcontroller::class,'getsections']);
Route::post('nontech/manager/infrastructure/school/info/byfilter',[infrastructureschoolcontroller::class,'filter']);
Route::get('nontech/manager/infrastructure/school/info/export/{mid}',[infrastructureschoolcontroller::class,'schoolexport']);
Route::get('nontech/manager/infrastructure/cafeteria/getname',[infrastructurecafeteriacontroller::class,'getnames']);
Route::get('nontech/manager/infrastructure/add/cafeteriaitems',[infrastructurecafeteriacontroller::class,'addcafeteriaitems']);
Route::post('nontech/manager/infrastructure/cafeteria/uploaditems',[infrastructurecafeteriacontroller::class,'upload']);
Route::get('nontech/manager/infrastructure/cafeteria/info',[infrastructurecafeteriacontroller::class,'info']);
Route::get('nontech/manager/infrastructure/cafeteria/edit/items/{id}',[infrastructurecafeteriacontroller::class,'editcafeteriaitem']);
Route::post('nontech/manager/infrastructure/cafeteria/item/savedata',[infrastructurecafeteriacontroller::class,'savedetails']);
Route::get('nontech/manager/infrastructure/cafeteria/getsection',[infrastructurecafeteriacontroller::class,'getsections']);
Route::post('nontech/manager/infrastructure/cafeteria/info/byfilter',[infrastructurecafeteriacontroller::class,'filter']);
Route::get('nontech/manager/infrastructure/cafeteria/info/export/{mid}',[infrastructurecafeteriacontroller::class,'cafeteriaexport']);
Route::get('nontech/manager/infrastructure/reports/repairs/{id}',[infrastructureworkcontroller::class,'reports']);


Route::get('nontech/manager/infrastructure/add/othersitems',[infrastructureothercontroller::class,'addotheritems']);
Route::post('nontech/manager/infrastructure/other/uploaditems',[infrastructureothercontroller::class,'upload']);
Route::get('nontech/manager/infrastructure/other/info',[infrastructureothercontroller::class,'info']);
Route::get('nontech/manager/infrastructure/other/edit/items/{id}',[infrastructureothercontroller::class,'editotheritem']);
Route::post('nontech/manager/infrastructure/other/item/savedata',[infrastructureothercontroller::class,'savedetails']);
Route::post('nontech/manager/infrastructure/other/info/byfilter',[infrastructureothercontroller::class,'filter']);
Route::get('nontech/manager/infrastructure/other/info/export/{mid}',[infrastructureothercontroller::class,'otherexport']);
Route::get('nontech/manager/infrastructure/other/repair/start/{id}',[infrastructureworkcontroller::class,'otherrepairstart']);

//Cafeteria


Route::get('nontech/manager/Cafeteria/school/info',[cafeteriainfocontroller::class,'school']);
Route::get('nontech/manager/Cafeteria/hostel/info',[cafeteriainfocontroller::class,'hostel']);
Route::get('nontech/manager/Cafeteria/others/info',[cafeteriainfocontroller::class,'others']);

Route::get('nontech/manager/Cafeteria/school/hostel/others/export/{type}/{aid}',[cafeteriainfocontroller::class,'schoolhostelothersexport']);

Route::get('nontech/manager/Cafeteria/repair/{id}',[cafeteriainfocontroller::class,'repair']);
Route::get('nontech/manager/Cafeteria/repair/completed/{id}',[cafeteriainfocontroller::class,'completed']);


Route::get('nontech/manager/food/category',[cafeteriafoodcontroller::class,'category']);
Route::get('nontech/manager/food/category/export/{mid}',[cafeteriafoodcontroller::class,'categoryexport']);
Route::get('nontech/manager/food/addcategory',[cafeteriafoodcontroller::class,'addcategory']);
Route::get('nontech/manager/food/addcategory/{id}',[cafeteriafoodcontroller::class,'addcategory']);
Route::get('nontech/manager/food/category/delete/{id}',[cafeteriafoodcontroller::class,'deletecategory']);
Route::post('nontech/manager/food/savecategory',[cafeteriafoodcontroller::class,'savecategory']);

Route::get('nontech/manager/food/items',[cafeteriafoodcontroller::class,'items']);
Route::get('nontech/manager/food/items/export/{mid}',[cafeteriafoodcontroller::class,'itemsexport']);
Route::get('nontech/manager/food/additems',[cafeteriafoodcontroller::class,'additems']);
Route::get('nontech/manager/food/additems/{id}',[cafeteriafoodcontroller::class,'additems']);
Route::get('nontech/manager/food/items/delete/{id}',[cafeteriafoodcontroller::class,'deleteitems']);
Route::post('nontech/manager/food/saveitems',[cafeteriafoodcontroller::class,'saveitems']);



Route::get('nontech/manager/food/caterer',[cafeteriafoodcontroller::class,'caterer']);
Route::get('nontech/manager/food/caterer/export/{mid}',[cafeteriafoodcontroller::class,'catererexport']);
Route::get('nontech/manager/food/create/caterer',[cafeteriafoodcontroller::class,'create']);
Route::get('nontech/manager/food/createuser/{id}',[cafeteriafoodcontroller::class,'create']);
Route::post('nontech/manager/food/createvendor/processing',[cafeteriafoodcontroller::class,'usersave']);
Route::get('nontech/manager/food/createuser/delete/{id}',[cafeteriafoodcontroller::class,'delete']);
Route::get('nontech/manager/food/createuser/status/{status}/{id}',[cafeteriafoodcontroller::class,'status']);


Route::get('nontech/manager/cafeteria/repair/reports',[cafeteriareportscontroller::class,'repairreports']);
Route::get('nontech/manager/cafeteria/items/reports',[cafeteriareportscontroller::class,'itemsreports']);
Route::post('nontech/manager/cafeteria/items/reports/byfilter',[cafeteriareportscontroller::class,'itemsreportsbyfilter']);

Route::get('nontech/manager/cafeteria/feedback/reports',[cafeteriareportscontroller::class,'feedback']);
Route::post('nontech/manager/cafeteria/feedback/reportsbyfilter',[cafeteriareportscontroller::class,'feedbackbyfilter']);
Route::get('nontech/manager/cafeteria/feedback/reportsbyfilter/export/{aid}',[cafeteriareportscontroller::class,'foodfeedbackexport']);

//Transport

Route::get('nontech/manager/attendance/view/months',[nontechmanagerattendancecontroller::class,'months']);
Route::any('nontech/manager/attendance/view/dates',[nontechmanagerattendancecontroller::class,'getdates']);
Route::post('nontech/manager/attendance/view/students/bydate',[nontechmanagerattendancecontroller::class,'students']);

});

Route::get('nontech/manager/logout',function(){
session()->forget('NONTECH_MANAGER_LOGIN');
session()->forget('NONTECH_MANAGER_ID');
session()->forget('NONTECH_MANAGER_ADMIN_ID');
session()->forget('NONTECH_MANAGER_SUP_ID');
session()->forget('NONTECH_MANAGER_DEPT_ID');
session()->forget('NONTECH_MANAGER_Name');
session()->forget('NONTECH_MANAGER_Email');
session()->forget('NONTECH_MANAGER_Number');
session()->flash('logout','Logged Out Sucessfully');
return redirect('/');
});




Route::get('nontech/staff/login',[nontechstaffcontroller::class ,'login']);
Route::post('nontech/staff/login/save',[nontechstaffcontroller::class ,'logincheck']);
Route::get('nontech/staff/forgotpassword',[nontechstaffcontroller::class ,'forgotpassword']);
Route::post('nontech/staff/forgotpassword/check',[nontechstaffcontroller::class ,'forgotpasswordcheck']);

Route::group(['middleware'=>'nontechstaff_auth'],function(){

Route::get('nontech/staff/dashboard',[nontechstaffcontroller::class ,'dashboard']);

Route::get('nontech/staff/adddetails',[nontechstaffcontroller::class,'adddetails']);
Route::post('nontech/staff/adddetails/processing',[nontechstaffcontroller::class,'savedetails']);

Route::get('nontech/staff/profile',[nontechstaffcontroller::class,'profile']);
Route::post('nontech/staff/profile/processing',[nontechstaffcontroller::class,'update']);

});

Route::get('nontech/staff/logout',function(){
session()->forget('NONTECH_STAFF_LOGIN');
session()->forget('NONTECH_STAFF_ID');
session()->forget('NONTECH_STAFF_ADMIN_ID');
session()->forget('NONTECH_STAFF_SUP_ID');
session()->forget('NONTECH_STAFF_DEPT_ID');
session()->forget('NONTECH_STAFF_Name');
session()->forget('NONTECH_STAFF_Email');
session()->forget('NONTECH_STAFF_Number');
session()->flash('logout','Logged Out Sucessfully');
return redirect('/');
});







Route::get('vendor/caterer/login',[caterercontroller::class ,'login']);
Route::post('vendor/caterer/login/save',[caterercontroller::class ,'logincheck']);
Route::get('vendor/caterer/forgotpassword',[caterercontroller::class ,'forgotpassword']);
Route::post('vendor/caterer/forgotpassword/check',[caterercontroller::class ,'forgotpasswordcheck']);

Route::group(['middleware'=>'caterer_auth'],function(){

Route::get('vendor/caterer/dashboard',[caterercontroller::class ,'dashboard']);

Route::get('vendor/caterer/select/fooditems',[catereritemsselectcontroller::class,'index']);
Route::post('vendor/caterer/add/schoolmenu',[catereritemsselectcontroller::class,'addschoolmenu']);
Route::get('vendor/caterer/school/menu',[catereritemsselectcontroller::class,'schoolmenu']);
Route::get('vendor/caterer/school/menu/delete/{id}',[catereritemsselectcontroller::class,'delete']);

Route::get('vendor/caterer/hostel/items',[catereritemsselectcontroller::class,'hostelitems']);
Route::post('vendor/caterer/hostel/items/add',[catereritemsselectcontroller::class,'addhostelmenu']);

Route::get('vendor/caterer/adddetails',[caterercontroller::class,'adddetails']);
Route::post('vendor/caterer/adddetails/processing',[caterercontroller::class,'savedetails']);
Route::get('vendor/caterer/menu/getdata',[catereritemsselectcontroller::class,'getdata']);

Route::get('vendor/caterer/hostel/menu',[catereritemsselectcontroller::class,'menu']);

Route::get('vendor/caterer/profile',[caterercontroller::class,'profile']);
Route::post('vendor/caterer/profile/processing',[caterercontroller::class,'update']);

});

Route::get('vendor/caterer/logout',function(){
session()->forget('CATERER_LOGIN');
session()->forget('CATERER_ID');
session()->forget('CATERER_ADMIN_ID');
session()->forget('CATERER_Name');
session()->forget('CATERER_Email');
session()->forget('CATERER_Number');
session()->flash('logout','Logged Out Sucessfully');
return redirect('/');
});






Route::get('employee/marketingmanager/login',[mmauthcontroller::class ,'login']);
Route::post('employee/marketingmanager/login/save',[mmauthcontroller::class,'logincheck']);
Route::get('employee/marketingmanager/forgotpassword',[mmauthcontroller::class ,'forgotpassword']);
Route::post('employee/marketingmanager/forgotpassword/check',[mmauthcontroller::class ,'forgotpasswordcheck']);

Route::group(['middleware'=>'marketingmanager_auth'],function(){

Route::get('employee/marketingmanager/dashboard',[mmauthcontroller::class,'dashboard']);

Route::get('employee/marketingmanager/adddetails',[mmauthcontroller::class,'adddetails']);
Route::post('employee/marketingmanager/adddetails/processing',[mmauthcontroller::class,'savedetails']);

Route::get('employee/marketingmanager/profile',[mmauthcontroller::class,'profile']);
Route::post('employee/marketingmanager/profile/processing',[mmauthcontroller::class,'update']);

Route::get('employee/marketingmanager/marketingofficers',[mmmarketingofficercontroller::class,'index']);
Route::get('employee/marketingmanager/createmarketingofficer',[mmmarketingofficercontroller::class,'create']);
Route::post('employee/marketingmanager/marketingofficer/save',[mmmarketingofficercontroller::class,'save']);
Route::get('employee/marketingmanager/marketingofficer/status/{status}/{id}',[mmmarketingofficercontroller::class,'status']);
Route::get('employee/marketingmanager/marketingofficer/edit/{id}',[mmmarketingofficercontroller::class,'create']);
Route::get('employee/marketingmanager/marketingofficer/delete/{id}',[mmmarketingofficercontroller::class,'delete']);

Route::get('employee/marketingmanager/coldcall/{id}',[mmcoldcallcontroller::class,'list']);
Route::get('employee/marketingmanager/coldcall/status/{status}/{id}',[mmcoldcallcontroller::class,'status']);
Route::get('employee/marketingmanager/coldcall/initialrejectreason/view/{id}',[mmcoldcallcontroller::class,'rejectreason']);
Route::post('employee/marketingmanager/coldcall/initialrejectreason/mo/save',[mmcoldcallcontroller::class,'mosave']);
Route::get('employee/marketingmanager/coldcall/reject/{id}',[mmcoldcallcontroller::class,'mmrejectreason']);
Route::post('employee/marketingmanager/coldcall/rejectreason/save',[mmcoldcallcontroller::class,'mmreject']);


});
Route::get('employee/marketingmanager/logout',function(){
session()->forget('MARKETINGMANAGER_LOGIN');
session()->forget('MARKETINGMANAGER_fname');
session()->forget('MARKETINGMANAGER_lame');
session()->forget('MARKETINGMANAGER_Email');
session()->forget('MARKETINGMANAGER_Number');
session()->flash('logout','Logged Out Sucessfully');
return redirect('/');
});


Route::get('employee/marketingofficer/login',[moauthcontroller::class,'login']);
Route::post('employee/marketingofficer/login/save',[moauthcontroller::class,'authcheck']);
Route::get('employee/marketingofficer/forgotpassword',[moauthcontroller::class ,'forgotpassword']);
Route::post('employee/marketingofficer/forgotpassword/check',[moauthcontroller::class ,'forgotpasswordcheck']);

Route::group(['middleware'=>'marketingofficer_auth'],function(){

Route::get('employee/marketingofficer/dashboard',[moauthcontroller::class,'dashboard']);
Route::get('employee/marketingofficer/personaldetails',[moauthcontroller::class,'personaldetails']);
Route::post('employee/marketingofficer/personaldetails/save',[moauthcontroller::class,'personaldetailssave']);


Route::get('employee/marketingofficer/coldcallinitial',[mocoldcallcontroller::class,'index']);
Route::get('employee/marketingofficer/createcoldcall',[mocoldcallcontroller::class,'create']);
Route::post('employee/marketingofficer/coldcall/save',[mocoldcallcontroller::class,'save']);
Route::get('employee/marketingofficer/coldcall/status/{status}/{id}',[mocoldcallcontroller::class,'status']);
Route::get('employee/marketingofficer/coldcall/need/help/{id}',[mocoldcallcontroller::class,'needhelp']);
Route::get('employee/marketingofficer/coldcall/reject/{id}',[mocoldcallcontroller::class,'rejectreason']);
Route::post('employee/marketingofficer/coldcall/rejectreason/save',[mocoldcallcontroller::class,'reject']);
Route::get('employee/marketingofficer/coldcall/{id}',[mocoldcallcontroller::class,'progressorcomplist']);
Route::get('employee/marketingofficer/coldcall/mmreject/{id}',[mocoldcallcontroller::class,'mmrejectreason']);

Route::get('employee/marketingofficer/profile',[moauthcontroller::class,'profile']);
Route::post('employee/marketingofficer/profile/save',[moauthcontroller::class,'update']);

});


Route::get('employee/marketingofficer/logout',function(){
 session()->forget('MARKETINGOFFICER_LOGIN');
 session()->forget('MARKETINGOFFICER_ID');
 session()->forget('MARKETINGOFFICER_Fname');
 session()->forget('MARKETINGOFFICER_Lname');
 session()->forget('MARKETINGOFFICER_Email');
 session()->forget('MARKETINGOFFICER_Number');
 session()->flash('logout','Logged Out Sucessfully');
 return redirect('/');
});


Route::get('/controller', [ControllerName::class, 'index'])->name('controller.index');
Route::get('admin/addcontroller', [ControllerName::class, 'create'])->name('controller.create');
Route::post('admin/savecontroller', [ControllerName::class, 'store'])->name('controller.store');
//new added
Route::post('admin/updatecontroller', [ControllerName::class, 'update'])->name('controller.update');
//new chngs
Route::get('academic_controller/adddetails',[AcademicController::class,'adddetails']);
Route::post('academic_controller/adddetails/processing',[AcademicController::class,'savedetails']);
Route::get('academic_controller/groups',[AcademicGroupController::class, 'group']);
Route::get('academic_controller/group/addgroup',[AcademicGroupController::class, 'addgroup']);
Route::get('academic_controller/group/addgroup/{id}',[AcademicGroupController::class, 'addgroup']);
Route::post('academic_controller/group/savegroup',[AcademicGroupController::class,'savegroup']);


Route::get('academic_controller/standard',[AcademicStandardController::class, 'category']);
Route::post('academic_controller/category/bygroup',[AcademicStandardController::class, 'categorybygroup']);
Route::get('academic_controller/category/addcategory',[AcademicStandardController::class, 'addcategory']);
Route::get('academic_controller/category/addcategory/{id}',[AcademicStandardController::class, 'addcategory']);
Route::post('academic_controller/category/savecategory',[AcademicStandardController::class,'savecategory']);
Route::get('academic_controller/category/{id}',[AcademicStandardController::class,'categorydelete']);


Route::get('academic_controller/domain',[AcademicSubjectController::class, 'domain'])->name('controller.academ.domain');
Route::post('academic_controller/domain/bycategory',[AcademicSubjectController::class, 'domainbycategory']);
Route::get('academic_controller/domain/adddomain',[AcademicSubjectController::class, 'adddomain']);
Route::get('academic_controller/domain/adddomain/{id}',[AcademicSubjectController::class, 'adddomain']);
Route::post('academic_controller/domain/savedomain',[AcademicSubjectController::class,'savedomain']);
Route::get('academic_controller/domain/{id}',[AcademicSubjectController::class,'delete']);
Route::any('academic_controller/questionbank/getcategory',[AcademicSubjectController::class,'questionbankgetcategories']);
Route::get('academic_controller/skillset/getcategory/{id}',[AcademicSubjectController::class,'skillsetcategory']);


Route::get('academic_controller/skillset',[AcademicModuleController::class, 'skillset']);
Route::post('academic_controller/skillset/bydomain',[AcademicModuleController::class, 'skillsetbydomain']);
Route::get('academic_controller/skillset/addskillset',[AcademicModuleController::class, 'addskillset']);
Route::get('academic_controller/skillset/addskillset/{id}',[AcademicModuleController::class, 'addskillset']);
Route::post('academic_controller/skillset/saveskillset',[AcademicModuleController::class,'saveskillset']);
Route::get('academic_controller/skillset/{id}',[AcademicModuleController::class,'skillsetdelete']);

Route::get('academic_controller/getdomains',[AcademicModuleController::class,'skillsetgetdomains']);
Route::get('academic_controller/skillset/getdomain/{id}',[AcademicModuleController::class,'skillsetdomain']);
Route::get('academic_controller/skillset/domain/{id}/{groupid}',[AcademicModuleController::class,'getdomains']);
Route::get('academic_controller/skillset/getskillset/{id}',[AcademicModuleController::class,'getskillsets']);

Route::get('academic_controller/skillattribute',[AcademicChapterController::class, 'skillattribute']);
Route::post('academic_controller/skillattribute/byskillset',[AcademicChapterController::class, 'skillattributebyskillset']);
Route::get('academic_controller/skillattribute/addskillattribute',[AcademicChapterController::class, 'addskillattribute']);
Route::get('academic_controller/skillattribute/addskillattribute/{id}',[AcademicChapterController::class, 'addskillattribute']);
Route::post('academic_controller/skillattribute/saveskillattribute',[AcademicChapterController::class,'saveskillattribute']);
Route::get('academic_controller/skillattribute/{id}',[AcademicChapterController::class,'skillattributedelete']);
Route::get('academic_controller/skillattribute/domain/{id}',[AcademicChapterController::class,'getdomain']);
Route::get('academic_controller/skillattribute/skillset/{id}',[AcademicChapterController::class,'getskillset']);
Route::get('academic_controller/skillattribute/getskillattribute/{id}',[AcademicChapterController::class,'getskillattribute']);
Route::post('academic_controller/questionbank/getskillset',[AcademicChapterController::class,'questionbankgetskillsets']);


Route::get('academic_controller/content/skillattribute',[AcademicContent::class, 'contentska']);
Route::post('academic_controller/content/skillattribute/byskillset',[AcademicContent::class, 'contentskabyskillset']);
Route::get('academic_controller/content/skillattribute/addskillattribute',[AcademicContent::class, 'addcontentska']);
Route::get('academic_controller/content/skillattribute/addskillattribute/{id}',[AcademicContent::class, 'addcontentska']);
Route::post('academic_controller/content/skillattribute/saveskillattribute',[AcademicContent::class,'savecontentska']);
Route::get('academic_controller/content/skillattribute/{id}',[AcademicContent::class,'contentskadelete']);
Route::any('academic_controller/questionbank/getdomain',[AcademicContent::class,'questionbankgetdomains']);

Route::get('academic_controller/reports',[AcademicReport::class,'reports']);
Route::post('academic_controller/reports/sectionwise',[AcademicReport::class,'fetchstu']);

Route::get('exam_controller/assesments',[Examassesment::class,'colist']);
Route::get('exam_controller/assesment/createassesment',[Examassesment::class,'createassesment']);
Route::get('exam_controller/assesment/edit/{id}',[Examassesment::class,'createassesment']);
Route::get('exam_controller/assesment/delete/{id}',[Examassesment::class,'delete']);
Route::get('exam_controller/trainings/trains/{id}',[Examassesment::class,'gettrainings']);
Route::post('exam_controller/skillattribute/domain/',[Examassesment::class,'getdomain']);
Route::post('exam_controller/skillattribute/skillset/',[Examassesment::class,'getskillset']);
Route::post('exam_controller/skillattribute/getskillattribute/',[Examassesment::class,'getskillattribute']);
Route::post('exam_controller/assesment/createmodule',[Examassesment::class,'createmodule']);
Route::get('exam_controller/assesment/createmodule',[Examassesment::class,'createmodule'])->name('cocreate');
Route::post('exam_controller/createsection',[Examassesment::class,'index']);
Route::get('exam_controller/createsection/{id}',[Examassesment::class,'index']);
Route::post('exam_controller/assesments',[Examassesment::class,'comodule']);
Route::post('exam_controller/assesment/sectioncreation',[Examassesment::class,'createsession']);
Route::get('exam_controller/assesment/section/delete/{id}',[Examassesment::class,'delete']);



Route::get('Faculty/content/skillattribute',[FacultyContentController::class, 'contentska']);
Route::post('Faculty/content/skillattribute/byskillset',[FacultyContentController::class, 'contentskabyskillset']);
Route::get('Faculty/content/skillattribute/domain',[FacultyContentController::class,'getdomain']);
Route::get('Faculty/content/skillattribute/skillset',[FacultyContentController::class,'getskillset']);


Route::get('account/fees/distance',[Feescontroller::class,'distance']);
Route::post('account/fees/distance/upload',[Feescontroller::class,'upload']);
Route::get('account/fees/adddistance',[Feescontroller::class,'adddistance']);
Route::get('account/fees/adddistance/{id}',[Feescontroller::class,'adddistance']);
Route::get('account/fees/distance/status/{status}/{id}',[Feescontroller::class,'disstatus']);
Route::get('account/fees/distance/delete/{id}',[Feescontroller::class,'deletedistance']);
Route::post('account/fees/savedistance',[Feescontroller::class,'savedistance']);


Route::get('account/fees/category',[Feescontroller::class,'category']);
Route::get('account/fees/addcategory',[Feescontroller::class,'addcategory']);
Route::get('account/fees/addcategory/{id}',[Feescontroller::class,'addcategory']);
Route::get('account/fees/category/status/{status}/{id}',[Feescontroller::class,'catstatus']);
Route::get('account/fees/category/delete/{id}',[Feescontroller::class,'deletecategory']);
Route::post('account/fees/savecategory',[Feescontroller::class,'savecategory']);

Route::get('account/fees/schedule',[Feescontroller::class,'schedule']);
Route::get('account/fees/addschedule',[Feescontroller::class,'addschedule']);
Route::get('account/fees/addschedule/{id}',[Feescontroller::class,'addschedule']);
Route::get('account/fees/schedule/delete/{id}',[Feescontroller::class,'deleteschedule']);
Route::post('account/fees/saveschedule',[Feescontroller::class,'saveschedule']);


Route::get('account/transport/fees/schedule/busroutes',[Feescontroller::class,'transportschedule']);
Route::get('account/transport/fees/schedule/busroutes/location/{moneystatus}/{busrouteid}',[Feescontroller::class,'addtransportschedule']);
Route::post('account/transport/fees/schedule/busroutes/save',[Feescontroller::class,'savetransportschedule']);


Route::get('account/fees/discount',[Feescontroller::class,'discount']);
Route::get('account/fees/adddiscount',[Feescontroller::class,'adddiscount']);
Route::get('account/fees/adddiscount/{id}',[Feescontroller::class,'adddiscount']);
Route::get('account/fees/discount/delete/{id}',[Feescontroller::class,'deletediscount']);
Route::post('account/fees/savediscount',[Feescontroller::class,'savediscount']);
Route::get('account/fees/discount/getfees',[Feescontroller::class,'getfees']);
Route::get('account/fees/getstudents',[Feescontroller::class,'getstu']);
Route::get('account/classby/section/{id}',[Feescontroller::class,'classby']);



Route::get('account/fees/pending',[Feescontroller::class,'pendingfeesstudents']);
Route::post('account/fees/pending/students/bysection',[Feescontroller::class,'pendingfeesstudentsbysection']);
Route::post('account/fees/pending/students/pendingfees/initial/save',[Feescontroller::class,'pendingfeesinitialsave']);
Route::post('account/fees/pending/students/pendingfees/save',[Feescontroller::class,'pendingfeessave']);
Route::get('account/fees/pending/students/export/{class}/{section}',[Feescontroller::class,'pendingfeesexport']);
Route::get('account/fees/index/students',[Feescontroller::class,'indexfeesstudents']);
Route::post('account/fees/index/students/bysection',[Feescontroller::class,'indexfeesstudentsbysection']);
Route::get('account/fees/index/students/export/{id}',[Feescontroller::class,'feesexport']);
Route::get('account/fees/index/students/view/structure/{id}',[Feescontroller::class,'feesstructure']);
Route::post('account/fees/students/save',[Feescontroller::class,'feessave']);
Route::post('account/fees/index/fees/transfer',[Feescontroller::class,'feestransfer']);
Route::get('account/fees/pending/currentyear',[Feescontroller::class,'currentyearpendingfeesstudents']);
Route::post('account/fees/pending/currentyear/students/bysection',[Feescontroller::class,'currentyearpendingfeesstudentsbysection']);
Route::post('account/fees/pending/currentyear/students/export',[Feescontroller::class,'currentyearpendingfeesexport']);
Route::any('account/attendance/view/sections',[Feescontroller::class,'getsections']);

Route::get('account/fees/pending/currentyear',[Feescontroller::class,'currentyearpendingfeesstudents']);
Route::post('account/fees/pending/currentyear/students/bysection',[Feescontroller::class,'currentyearpendingfeesstudentsbysection']);
Route::post('account/fees/pending/currentyear/students/export',[Feescontroller::class,'currentyearpendingfeesexport']);


Route::get('account/analytics/pendingfees',[Feesanalyticcontroller::class,'index']);
Route::post('account/analytics/pendingfees/fetch',[Feesanalyticcontroller::class,'fetch']);
Route::get('account/analytics/currentfees',[Feesanalyticcontroller::class,'currentindex']);
Route::post('account/analytics/currentfees/fetch',[Feesanalyticcontroller::class,'currentfetch']);
Route::get('account/analytic/currentfees/monthwise',[Feesanalyticcontroller::class,'getmonth']);




Route::get('controller/expgrp', [AccountController::class, 'accountexpgrp']);
Route::get('controller/expcat', [AccountController::class, 'accountexpcat']);
Route::get('controller/exp/create', [AccountController::class, 'create'])->name('expenses.create');
Route::get('controller/exp/cat/create', [AccountController::class, 'createcat'])->name('expensescat.create');
Route::post('controller/exp/store', [AccountController::class, 'store'])->name('expenses.store');
Route::post('controller/exp/storecat', [AccountController::class, 'storecat'])->name('expenses.storecat');
Route::put('/expenses/{id}', [AccountController::class, 'update'])->name('expenses.update');
Route::put('/expcat/{id}', [AccountController::class, 'updatecat'])->name('exp.update');
Route::delete('expenses/{id}', [AccountController::class, 'destroy'])->name('expenses.destroy');
Route::delete('expcat/{id}', [AccountController::class, 'destroycat'])->name('expcat.destroy');
Route::resource('expenses', AccountController::class)->only(['create', 'store', 'destroy']);



Route::get('controller/logout',function(){
    session()->forget('Controller_ID');
    session()->forget('Controller_ADMIN_ID');
    session()->forget('Controller_Name');
    session()->forget('Controller_Email');
    session()->forget('Controller_Number');
    session()->flash('logout','Logged Out Sucessfully');
    return redirect('/');
    });
