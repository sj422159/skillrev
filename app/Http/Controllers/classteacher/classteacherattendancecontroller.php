<?php

namespace App\Http\Controllers\classteacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\attendance;
use Carbon\CarbonPeriod;
use Redirect,Response;

class classteacherattendancecontroller extends Controller{

    public function dates(){
        $aid=session()->get('CLASSTEACHER_ADMIN_ID');
        $ctid=session()->get('CLASSTEACHER_ID');
        $classid=session()->get('CLASSTEACHER_CLASS_ID');
        $sectionid=session()->get('CLASSTEACHER_SECTION_ID');

        $result['todaydate'] = date('d-m-Y');
        $result['attendance'] = DB::table('attendances')
                            ->where('classteacherid',$ctid)
                            ->where('classid',$classid)
                            ->where('sectionid',$sectionid)
                            ->where('date',$result['todaydate'])
                            ->get('id');

        $tommorowdate = date('d-m-Y', strtotime('+1 days'));
        $day= date("l", strtotime($tommorowdate));
        if($day=="Sunday" && count($result['attendance'])==0){
            $data = DB::table('students')->where('sclassid',$classid)->where('ssectionid',$sectionid)->get('id');
            $student=[];
            $attendance=[];
            for($i=0;$i<count($data);$i++){
                $student[$i]=$data[$i]->id;
                $attendance[$i]=$day;
            }
            $month=date('m',strtotime($tommorowdate));
            $year=date('Y',strtotime($tommorowdate));

            $model=new attendance();
            $model->adminid=$aid;
            $model->classteacherid=$ctid;
            $model->classid=$classid;
            $model->sectionid=$sectionid;
            $model->date=$tommorowdate;
            $model->month=$month;
            $model->year=$year;
            $model->studentid=implode("##",$student);
            $model->attendance=$day;
            $model->attendancetype=2;  // 2 means sunday
            $model->save();
        }

        $result['attendance'] = DB::table('attendances')
                            ->where('classteacherid',$ctid)
                            ->where('classid',$classid)
                            ->where('sectionid',$sectionid)
                            ->where('date',$result['todaydate'])
                            ->get('id');
        $result['todayholidayornot'] = DB::table('holidays')->where('aid',$aid)->where('date',$result['todaydate'])->get();
        $result['holidays'] = DB::table('holidays')->where('aid',$aid)->get();
        $holidayattendances = DB::table('attendances')
                            ->where('classteacherid',$ctid)
                            ->where('classid',$classid)
                            ->where('sectionid',$sectionid)
                            ->where('attendancetype',3)
                            ->get('attendance');
        $result['holidayattendance']=[];
        for($i=0;$i<count($holidayattendances);$i++){
            $result['holidayattendance'][$i]=$holidayattendances[$i]->attendance;
        }
        return view('classteacher.attendancedates',$result);
    }

    public function students(){
        $aid=session()->get('CLASSTEACHER_ADMIN_ID');
        $ctid=session()->get('CLASSTEACHER_ID');
        $classid=session()->get('CLASSTEACHER_CLASS_ID');
        $sectionid=session()->get('CLASSTEACHER_SECTION_ID');

        $result['students'] = DB::table('students')->where('sclassid',$classid)->where('ssectionid',$sectionid)->get();
        return view('classteacher.attendancestudents',$result);
    } 

    public function saveattendance(request $request){
        $aid=session()->get('CLASSTEACHER_ADMIN_ID');
        $ctid=session()->get('CLASSTEACHER_ID');
        $classid=session()->get('CLASSTEACHER_CLASS_ID');
        $sectionid=session()->get('CLASSTEACHER_SECTION_ID');
        
        $date=date('d-m-Y');
        $month=date('m');
        $year=date('Y');

        $model=new attendance();
        $model->adminid=$aid;
        $model->classteacherid=$ctid;
        $model->classid=$classid;
        $model->sectionid=$sectionid;
        $model->date=$date;
        $model->month=$month;
        $model->year=$year;
        $model->studentid=implode("##",$request->post('studentid'));
        $model->attendance=implode("##",$request->post('attendance'));
        $model->attendancetype=1;  // 1 means normal
        $model->save();

        session()->flash('success','Attendance Saved Successfully');
        return redirect('classteacher/attendance/view/dates');
    }  


    public function holidayattendance($date,$holidayid){
        $aid=session()->get('CLASSTEACHER_ADMIN_ID');
        $ctid=session()->get('CLASSTEACHER_ID');
        $classid=session()->get('CLASSTEACHER_CLASS_ID');
        $sectionid=session()->get('CLASSTEACHER_SECTION_ID');
        
        $h=DB::table('holidays')->where('id',$holidayid)->get();
        $date=$h[0]->date;
        $month=date('m',strtotime($date));
        $year=date('Y',strtotime($date));
        $data = DB::table('students')->where('sclassid',$classid)->where('ssectionid',$sectionid)->get('id');
            $student=[];
            $attendance=[];
            for($i=0;$i<count($data);$i++){
                $student[$i]=$data[$i]->id;
                $attendance[$i]=$h[0]->holidayname;
            }
            $model=new attendance();
            $model->adminid=$aid;
            $model->classteacherid=$ctid;
            $model->classid=$classid;
            $model->sectionid=$sectionid;
            $model->date=$date;
            $model->month=$month;
            $model->year=$year;
            $model->studentid=implode("##",$student);
            $model->attendance=$h[0]->holidayname;
            $model->attendancetype=3;  // 3 means holiday
            $model->save();

        session()->flash('success','Attendance Saved Successfully');
        return redirect('classteacher/attendance/view/dates');
    }  

}