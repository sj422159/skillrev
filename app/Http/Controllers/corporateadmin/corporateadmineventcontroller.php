<?php

namespace App\Http\Controllers\corporateadmin;

use Mail;
use Redirect;
use App\Models\admin;
use App\Models\stats;
use App\Models\steps;
use App\Models\courses;
use App\Models\homepage;
use App\Models\jobroles;
use App\Models\slideshows;
use App\Models\testimonials;
use Illuminate\Http\Request;
use App\Models\homepageEvents;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class corporateadmineventcontroller extends Controller
{
   //old functions
    public function events(){
      $result['data']=DB::table('homepage_events')->where('id',1)->get();
      return view('corporateadmin.events',$result);
    }

   public function save(request $request){
     $model=homepageEvents::find($request->post('id'));
     $model->content=$request->post('school');
     $model->content2=$request->post('special');
     $model->content3=$request->post('skill');
     $model->save();
     return redirect('corporateadmin/homepage/events');
   }


   // new functions

    // 4 main highlights of the system in index page
    public function highlights(){
      $result['data']=DB::table('homepages')->where('id',1)->get();
      return view('corporateadmin.homepage',$result);
    }

    public function slideshow(){
      $result['data']=DB::table('slideshows')->where('id',1)->get();
      return view('corporateadmin.slideshow',$result);
    }

    public function steps()
    {
     $result['data']=DB::table('steps')->where('id',1)->get();
     return view('corporateadmin.steps',$result);
    }

    public function jobrole(){
      $result['data']=DB::table('jobroles')->where('id',1)->get();
      $result['s2']=DB::table('jobroles')->where('id',2)->get();
      $result['s3']=DB::table('jobroles')->where('id',3)->get();
      $result['s4']=DB::table('jobroles')->where('id',4)->get();
      $result['s5']=DB::table('jobroles')->where('id',5)->get();

      return view('corporateadmin.jobrole',$result);
    }

    public function courses(){
      $result['data']=DB::table('courses')->where('id',1)->get();
      return view('corporateadmin.courses',$result);
    }


    public function stats(){
      $result['data']=DB::table('stats')->where('id',1)->get();
      return view('corporateadmin.stats',$result);
    }

    public function testimonials(){
      $result['data']=DB::table('testimonials')->where('id',1)->get();
      return view('corporateadmin.testimonials',$result);
    }


    public function highlights_save(request $request){
      $model=homepage::find($request->post('id'));
      $model->title1=$request->post('title1');
      $model->title2=$request->post('title2');
      $model->title3=$request->post('title3');
      $model->title4=$request->post('title4');
      $model->description1=$request->post('description1');
      $model->description2=$request->post('description2');
      $model->description3=$request->post('description3');
      $model->description4=$request->post('description4');
      $model->mainhead=$request->post('mainhead');
      $model->descrip=$request->post('desc');
      $model->save();
      return redirect('corporateadmin/homepage/highlights');
    }

    public function jobrole_save(request $request)
   {
    $model=jobroles::find($request->post('id1'));
    $model2=jobroles::find($request->post('id2'));
    $model3=jobroles::find($request->post('id3'));
    $model4=jobroles::find($request->post('id4'));
    $model5=jobroles::find($request->post('id5'));

    $model->title1=$request->post('title1');
    $model->title2=$request->post('title2');
    $model->title3=$request->post('title3');
    $model->title4=$request->post('title4');
    $model->title5=$request->post('title5');
    $model->title6=$request->post('title6');
    $model->description1=$request->post('description1');
    $model->description2=$request->post('description2');
    $model->description3=$request->post('description3');
    $model->description4=$request->post('description4');
    $model->description5=$request->post('description5');
    $model->description6=$request->post('description6');

    $model->url1=$request->post('url1');
    $model->url2=$request->post('url2');
    $model->url3=$request->post('url3');
    $model->url4=$request->post('url4');
    $model->url5=$request->post('url5');
    $model->url6=$request->post('url6');

    if($request->file('image1') != null)
    {
      $model->image1=$request->file('image1')->store('courses','public');
    }
    if($request->file('image2') != null)
    {
      $model->image2=$request->file('image2')->store('courses','public');
    }
    if($request->file('image3') != null)
    {
      $model->image3=$request->file('image3')->store('courses','public');
    }
    if($request->file('image4') != null)
    {
      $model->image4=$request->file('image4')->store('courses','public');
    }
    if($request->file('image5') != null)
    {
      $model->image5=$request->file('image5')->store('courses','public');
    }
    if($request->file('image6') != null)
    {
      $model->image6=$request->file('image6')->store('courses','public');
    }


    $k=1;
    for($i=0; $i<5 ;$i++,$k++)
    {  if($request->post('skillset'."$i" . '0') != null)
       {
         $model->{'skillset'."$k"}=$request->post('skillset' . "$i" . '0');
       }
       else
       {
        $model->{'skillset'."$k"} = null;
       }

       if($request->post('skillset'."$i".'1') != null)
       {
         $model2->{'skillset'."$k"}=$request->post('skillset' . "$i" . '1');
       }
       else
       {
        $model2->{'skillset'."$k"} = null;
       }

       if($request->post('skillset'."$i".'2') != null)
       {
         $model3->{'skillset'."$k"}=$request->post('skillset' . "$i" . '2');
       }
       else
       {
        $model3->{'skillset'."$k"} = null;
       }

       if($request->post('skillset'."$i".'3') != null)
       {
         $model4->{'skillset'."$k"}=$request->post('skillset' . "$i" . '3');
       }
       else
       {
        $model4->{'skillset'."$k"} = null;
       }

       if($request->post('skillset'."$i".'4') != null)
       {
         $model5->{'skillset'."$k"}=$request->post('skillset' . "$i" . '4');
       }
       else
       {
        $model5->{'skillset'."$k"} = null;
       }
    }

    $model->save();
    $model2->save();
    $model3->save();
    $model4->save();
    $model5->save();

    return redirect('corporateadmin/homepage/job-role');
  }

  public function courses_save(request $request){

    $model=courses::find($request->post('id'));
    $model->title1=$request->post('title1');
    $model->title2=$request->post('title2');
    $model->title3=$request->post('title3');
    $model->title4=$request->post('title4');
    $model->title5=$request->post('title5');
    $model->title6=$request->post('title6');
    $model->description1=$request->post('description1');
    $model->description2=$request->post('description2');
    $model->description3=$request->post('description3');
    $model->description4=$request->post('description4');
    $model->description5=$request->post('description5');
    $model->description6=$request->post('description6');

    $model->difficulty1=$request->post('difficulty1');
    $model->difficulty2=$request->post('difficulty2');
    $model->difficulty3=$request->post('difficulty3');
    $model->difficulty4=$request->post('difficulty4');
    $model->difficulty5=$request->post('difficulty5');
    $model->difficulty6=$request->post('difficulty6');

    $model->time1=$request->post('time1');
    $model->time2=$request->post('time2');
    $model->time3=$request->post('time3');
    $model->time4=$request->post('time4');
    $model->time5=$request->post('time5');
    $model->time6=$request->post('time6');

    $model->url1=$request->post('url1');
    $model->url2=$request->post('url2');
    $model->url3=$request->post('url3');
    $model->url4=$request->post('url4');
    $model->url5=$request->post('url5');
    $model->url6=$request->post('url6');

    // $result['data']=DB::table('courses')->where('id',1)->get();

    if($request->file('image1') != null)
    {
      $model->image1=$request->file('image1')->store('courses','public');
    }
    if($request->file('image2') != null)
    {
      $model->image2=$request->file('image2')->store('courses','public');
    }
    if($request->file('image3') != null)
    {
      $model->image3=$request->file('image3')->store('courses','public');
    }
    if($request->file('image4') != null)
    {
      $model->image4=$request->file('image4')->store('courses','public');
    }
    if($request->file('image5') != null)
    {
      $model->image5=$request->file('image5')->store('courses','public');
    }
    if($request->file('image6') != null)
    {
      $model->image6=$request->file('image6')->store('courses','public');
    }

    $model->save();
    return redirect('corporateadmin/homepage/courses');
  }

  public function stats_save(Request $request){
      $model=stats::find($request->post('id'));
      $model->title=$request->post('title');
      $model->{'label-1'}=$request->post('label1');
      $model->{'label-2'}=$request->post('label2');
      $model->{'label-3'}=$request->post('label3');
      $model->{'label-4'}=$request->post('label4');
      $model->{'No-1'}=$request->post('no1');
      $model->{'No-2'}=$request->post('no2');
      $model->{'No-3'}=$request->post('no3');
      $model->{'No-4'}=$request->post('no4');
      $model->save();
      return redirect('corporateadmin/homepage/stats');
  }

  public function slideshow_save(Request $request){
    $model=slideshows::find($request->post('id'));

    $model->title1=$request->post('title1');
    $model->title2=$request->post('title2');
    $model->title3=$request->post('title3');
    $model->title4=$request->post('title4');
    $model->title5=$request->post('title5');
    $model->title6=$request->post('title6');
    $model->title7=$request->post('title7');
    $model->title8=$request->post('title8');
    $model->title9=$request->post('title9');
    $model->title10=$request->post('title10');

    $model->description1=$request->post('description1');
    $model->description2=$request->post('description2');
    $model->description3=$request->post('description3');
    $model->description4=$request->post('description4');
    $model->description5=$request->post('description5');
    $model->description6=$request->post('description6');
    $model->description7=$request->post('description7');
    $model->description8=$request->post('description8');
    $model->description9=$request->post('description9');
    $model->description10=$request->post('description10');

    if($request->file('image1') != null)
    {
      $model->image1=$request->file('image1')->store('courses','public');
    }
    if($request->file('image2') != null)
    {
      $model->image2=$request->file('image2')->store('courses','public');
    }
    if($request->file('image3') != null)
    {
      $model->image3=$request->file('image3')->store('courses','public');
    }
    if($request->file('image4') != null)
    {
      $model->image4=$request->file('image4')->store('courses','public');
    }
    if($request->file('image5') != null)
    {
      $model->image5=$request->file('image5')->store('courses','public');
    }
    if($request->file('image6') != null)
    {
      $model->image6=$request->file('image6')->store('courses','public');
    }
    if($request->file('image7') != null)
    {
      $model->image7=$request->file('image7')->store('courses','public');
    }
    if($request->file('image8') != null)
    {
      $model->image8=$request->file('image8')->store('courses','public');
    }
    if($request->file('image9') != null)
    {
      $model->image9=$request->file('image9')->store('courses','public');
    }
    if($request->file('image10') != null)
    {
      $model->image10=$request->file('image10')->store('courses','public');
    }


    $model->save();
    return redirect('corporateadmin/homepage/slideshow');
  }

  public function steps_save(Request $request){
    $model=steps::find($request->post('id'));

    if($request->file('image1') != null)
    {
      $model->image1=$request->file('image1')->store('courses','public');
    }
    if($request->file('image2') != null)
    {
      $model->image2=$request->file('image2')->store('courses','public');
    }
    if($request->file('image3') != null)
    {
      $model->image3=$request->file('image3')->store('courses','public');
    }
    if($request->file('image4') != null)
    {
      $model->image4=$request->file('image4')->store('courses','public');
    }
    if($request->file('image5') != null)
    {
      $model->image5=$request->file('image5')->store('courses','public');
    }

    $model->step1=$request->post('step1');
    $model->step2=$request->post('step2');
    $model->step3=$request->post('step3');
    $model->step4=$request->post('step4');
    $model->step5=$request->post('step5');

    $model->save();
    return redirect('corporateadmin/homepage/steps');


  }

  public function testimonials_save(Request $request)
  {
    $model=testimonials::find($request->post('id'));

    $model->name1=$request->post('name1');
    $model->name2=$request->post('name2');
    $model->name3=$request->post('name3');
    $model->name4=$request->post('name4');
    $model->name5=$request->post('name5');
    $model->name6=$request->post('name6');
    $model->name7=$request->post('name7');
    $model->name8=$request->post('name8');
    $model->name9=$request->post('name9');
    $model->name10=$request->post('name10');

    $model->jobrole1=$request->post('jobrole1');
    $model->jobrole2=$request->post('jobrole2');
    $model->jobrole3=$request->post('jobrole3');
    $model->jobrole4=$request->post('jobrole4');
    $model->jobrole5=$request->post('jobrole5');
    $model->jobrole6=$request->post('jobrole6');
    $model->jobrole7=$request->post('jobrole7');
    $model->jobrole8=$request->post('jobrole8');
    $model->jobrole9=$request->post('jobrole9');
    $model->jobrole10=$request->post('jobrole10');

    $model->desc1=$request->post('desc1');
    $model->desc2=$request->post('desc2');
    $model->desc3=$request->post('desc3');
    $model->desc4=$request->post('desc4');
    $model->desc5=$request->post('desc5');
    $model->desc6=$request->post('desc6');
    $model->desc7=$request->post('desc7');
    $model->desc8=$request->post('desc8');
    $model->desc9=$request->post('desc9');
    $model->desc10=$request->post('desc10');


    if($request->file('image1') != null)
    {
      $model->image1=$request->file('image1')->store('courses','public');
    }
    if($request->file('image2') != null)
    {
      $model->image2=$request->file('image2')->store('courses','public');
    }
    if($request->file('image3') != null)
    {
      $model->image3=$request->file('image3')->store('courses','public');
    }
    if($request->file('image4') != null)
    {
      $model->image4=$request->file('image4')->store('courses','public');
    }
    if($request->file('image5') != null)
    {
      $model->image5=$request->file('image5')->store('courses','public');
    }
    if($request->file('image6') != null)
    {
      $model->image6=$request->file('image6')->store('courses','public');
    }
    if($request->file('image7') != null)
    {
      $model->image7=$request->file('image7')->store('courses','public');
    }
    if($request->file('image8') != null)
    {
      $model->image8=$request->file('image8')->store('courses','public');
    }
    if($request->file('image9') != null)
    {
      $model->image9=$request->file('image9')->store('courses','public');
    }
    if($request->file('image10') != null)
    {
      $model->image10=$request->file('image10')->store('courses','public');
    }

    $model->save();
    return redirect('corporateadmin/homepage/testimonials');

  }

}
