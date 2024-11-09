@extends('student/layout')
@section('title','Dashboard')
@section('Dashboard_select','active')
@section('container')
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
<link rel="stylesheet" type="text/css" href="{{asset('examcard/style.css')}}">
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<style>
 *{
    scroll-behavior: smooth;
    }
    .wrapper img{
    height:100px;
    width:150px;
    }
    .item{
    height:220px;
    width: 330px;
    }
    h5{
    color: #fff;
    }
    .box{
    padding: 20px;
    background-color: #fff;
    color: #fff;
    margin-top:20px;
    width:60px;
    height: auto;
    }
    .container {
    position: relative;
    max-width: 800px;
    height: 100px; /* Maximum width */
    margin: 0 auto; /* Center it */
    }
    .container .content {
    position: absolute; /* Position the background text */
    top:30px;
    bottom: 0; /* At the bottom. Use top:0 to append it to the top */
    background: rgb(0, 0, 0); /* Fallback color */
    background: rgba(0, 0, 0, 0.5); /* Black background with 0.5 opacity */
    color: #f1f1f1; /* Grey text */
    text-align: center;
    width:90%; /* Full width */
    height: 100%;
    padding: 20px; /* Some padding */
    }
    th,td{
    font-size:9px;
    width:30px;
    }
    p{
        color:#fff;
    }
</style>
<div class="main-content"style="padding: 0px;">
    @if($pendingfees[0]->spendingfees!=0)
    <script type="text/javascript">
        var fees = <?php echo $pendingfees[0]->spendingfees; ?>
    </script>
    <script>
    swal({
    title:"Previous Year Pending Fees",
    text: "Dear Parent / Student ,\n Since there is a Fees outstanding of "+fees+" rupees from the previous year. Hence you have been prohibited to select the Fees schedule for the current year. Please contact the School Management towards this payment, immediately.",
    icon: "warning",
    });
    </script>
    @endif
    @if(session()->has('success'))
    <div class="sufee-alert alert with-close alert-success alert-dismissible fade show">
        <span class="badge badge-pill badge-success"></span>
        {{session('success')}}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
        </button>
    </div>
    @endif
    @if(session()->has('danger'))
    <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
        <span class="badge badge-pill badge-danger"></span>
        {{session('danger')}}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
        </button>
    </div>
    @endif
    <div class="row">
        <div class="card card-widget widget-user" style="width:300px;height: 280px;margin:0px 20px 0px 15px;">
            <div class="widget-user-header bg-primary" style="background-image: linear-gradient(to right,#5235ba,#7e3ded);">
                <h3 class="widget-user-username" style="color:#fff";><?Php echo session()->get('STUDENT_Name'); ?></h3>
               
            </div>
            <div class="widget-user-image">
                @foreach($image as $list)
                <img class="img-circle elevation-2" src="{{asset('studentimages')}}/{{$list->image}}" alt="User Avatar">
                @endforeach
            </div>
            <div class="card-footer" style="background-color: #fff;">
                <div class="row col-12" style="display:flex;align-items:center;justify-content: center;padding: 0;margin: 0;">
                    <a href="{{url('student/adddetails')}}" class="btn btn-block btn-primary btn-sm col-6" style="background-image: linear-gradient(to right,#5235ba,#7e3ded);">
                    <i class="nav-icon fas fa-edit"></i>&nbsp&nbspProfile
                    </a>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-8">
            <!-- small box -->
            <div class="small-box bg-info" style="background-image: linear-gradient(to right,darkblue,blue);">
                <div class="inner">
                    <h3 style="color: #fff" id="profiles">{{count($assignmentassigned)}}</h3>
                    <p>Assignments Assigned</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>                
                <a href="{{url('student/assignment/assigned')}}" class="small-box-footer">More Details<i class="fas fa-arrow-circle-right"></i></a>
            </div>
            <div class="small-box bg-info" style="background-image: linear-gradient(to right,darkblue,blue);">
                <div class="inner">
                    <h3 style="color: #fff">{{count($assignmentsubmitted)}}</h3>
                    <p>Assignments Submitted</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                <a href="{{url('student/assignment/submitted')}}" class="small-box-footer">More Details<i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-4 col-8">
            <!-- small box -->
            <div class="small-box bg-info" style="background-image: linear-gradient(to right,darkgreen,lightgreen);">
                <div class="inner">
                    <h3 style="color: #fff" id="profiles">{{count($assignmentcorrected)}}</h3>
                    <p>Assignments Corrected</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>                
                <a href="{{url('student/assignment/corrected')}}" class="small-box-footer">More Details<i class="fas fa-arrow-circle-right"></i></a>
            </div>
            <div class="small-box bg-info" style="background-image: linear-gradient(to right,darkgreen,lightgreen);">
                <div class="inner">
                    <h3 style="color: #fff">{{count($assignmentcompleted)}}</h3>
                    <p>Assignments Completed</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                <a href="{{url('student/assignment/completed')}}" class="small-box-footer">More Details<i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div> 



            @if(count($competitions)>0)
            <div class="col-6">
            @else
            <div class="col-12">
            @endif
              
                    <!-- Custom Tabs -->
                    <div class="card" style="background-color:rgba(215, 223, 240, 1);">
                        <div class="card-header d-flex p-0" style="background-color:rgba(215, 223, 240, 1);">
                            <!--<h3 class="card-title p-3">Assesments</h3>-->
                             <h5 class="card-title p-3" style="color:black !important;">Assesments</h5>
                            <ul class="nav nav-pills ml-auto p-2">
                                <li class="nav-item"><a class="nav-link active" href="#tab_1" data-toggle="tab">Assigned</a></li>
                                <li class="nav-item"><a class="nav-link" href="#tab_2" data-toggle="tab" id="assesmentsallocated">Completed</a></li>
                            </ul>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab_1">
                                    <div class="row" style="display:flex;justify-content:center">
                                         @if(count($preassesments)==0 && count($postassesments)==0)
                                            <div style="display:flex;flex-direction:column !important;justify-content:center !important;align-items:center!important;">
                                                 <img src="{{asset('assets/img/no.png')}}" title="Sorry No Assigned Assignments Till Now" style="height:90% !important;width:100% !important;">
                                            </div>
                                            @else
                                                <div class="wrapper col-12">
                                            <div class="sam owl-carousel">
                                           
                                             @foreach($preassesments as $list)
    <div class="blog-card" style="width:350px;">
    <div class="meta" style="width:100px">
       <div class="photo" style="background-image: url('{{ asset('assesmentimages')}}/{{$list->img}}');"></div>
    </div>
    <div class="description">
         <div class="ribbon-wrapper ribbon-sm">
                        <div class="ribbon bg-primary text-sm">
                           PRE
                        </div>
                      </div>
      <h4>{{$list->assesmentname}}</h4>
      <p style="color:black;">{{$list->trainingname}}</p>
      <p style="color:black;" style="font-size:10px"><b>Description :</b> {{$list->sdes}}<br>
          <b style="color:black;"> Duration : </b>{{$list->time}} Min 
      </p>
     
        <p class="read-more">
       
       <a href="{{url('student/exam/mainassement')}}/{{$list->preass}}/{{$list->id}}" class="btn btn-block btn-primary btn-sm" style="color:#fff">Take Exam</a>
      </p>
    </div>
</div>
@endforeach




@foreach($postassesments as $list)
    <div class="blog-card" style="width:350px;">
    <div class="meta" style="width:100px">
       <div class="photo" style="background-image: url('{{ asset('assesmentimages')}}/{{$list->img}}');"></div>
    </div>
    <div class="description">
         <div class="ribbon-wrapper ribbon-sm">
                        <div class="ribbon bg-primary text-sm">
                           POST
                        </div>
                      </div>
       <h4>{{$list->assesmentname}}</h4>
      <p style="color:black;">{{$list->trainingname}}</p>
      <p style="color:black;" style="font-size:10px"><b>Description :</b> {{$list->sdes}}<br>
          <b style="color:black;"> Duration : </b>{{$list->time}} Min 
      </p>
     
        <p class="read-more">
       
       <a href="{{url('student/exam/mainassement')}}/{{$list->postass}}/{{$list->id}}" class="btn btn-block btn-primary btn-sm" style="color:#fff">Take Exam</a>
      </p>
    </div>
</div>
@endforeach


                                         

                                            
                                            </div>
                                        </div>
                                            @endif
                                       
                                    </div>
                                    <!-- partial -->
                                </div>
                                <!-- /.tab-pane -->
                                <div class="tab-pane" id="tab_2">
                                    <div class="row" style="display:flex;justify-content:center">
                                         @if(count($compreassesments)==0 && count($compostassesments)==0)
                                            <div style="display:flex;flex-direction:column !important;justify-content:center !important;align-items:center!important;">
                                                 <img src="{{asset('assets/img/comp.png')}}" title="Sorry,You Have Not Completed Any Assignments Till Now" style="height:90% !important;width:100% !important;">
                                            </div>
                                            @else
                                        <div class="wrapper col-12">
                                            <div class="cars owl-carousel">
                                           
                                                @foreach($compreassesments as $list)
    <div class="blog-card" style="width:350px;">
    <div class="meta" style="width:100px">
       <div class="photo" style="background-image: url('{{ asset('assesmentimages')}}/{{$list->img}}');"></div>
    </div>
    <div class="description">
         <div class="ribbon-wrapper ribbon-sm">
                        <div class="ribbon bg-primary text-sm">
                           PRE
                        </div>
                      </div>
      <h4>{{$list->assesmentname}}</h4>
      <p style="color:black;">{{$list->trainingname}}</p>
      <p style="color:black;" style="font-size:10px"><b>Description :</b> {{$list->sdes}}<br>
          <b style="color:black;"> Duration : </b>{{$list->time}} Min 
      </p>
     
        <p class="read-more">
      @if($list->manpreapprove==0)
       @if($list->preresult=="PASS")
       <a href="{{url('exam/sectionreport')}}/{{$list->id}}/{{$list->prereport}}/" class="btn btn-block btn-success btn-sm" style="color:#fff">Check Reports</a>
       @else
        @if($list->preattempt!="3")
       <a href="{{url('student/exam/mainassement')}}/{{$list->preass}}/{{$list->id}}" class="btn btn-block btn-primary btn-sm" style="color:#fff">RETAKE</a>
       @else
         <a href="{{url('exam/sectionreport')}}/{{$list->id}}/{{$list->prereport}}/" class="btn btn-block btn-success btn-sm" style="color:#fff">Check Reports</a>
       @endif
       @endif
      @else
        <a href="{{url('exam/sectionreport')}}/{{$list->id}}/{{$list->prereport}}/" class="btn btn-block btn-success btn-sm" style="color:#fff">Check Reports</a>
      @endif
      </p>
    </div>
</div>
@endforeach




@foreach($compostassesments as $list)
    <div class="blog-card" style="width:350px;">
    <div class="meta" style="width:100px">
       <div class="photo" style="background-image: url('{{ asset('assesmentimages')}}/{{$list->img}}');"></div>
    </div>
    <div class="description">
         <div class="ribbon-wrapper ribbon-sm">
                        <div class="ribbon badge-success text-sm">
                           POST
                        </div>
                      </div>
       <h4>{{$list->assesmentname}}</h4>
      <p style="color:black;">{{$list->trainingname}}</p>
      <p style="color:black;" style="font-size:10px"><b>Description :</b> {{$list->sdes}}<br>
          <b style="color:black;"> Duration : </b>{{$list->time}} Min 
      </p>
     
        <p class="read-more">
        @if($list->manpostapprove==0)
          @if($list->postresult=="PASS")
            <a href="{{url('exam/sectionreport')}}/{{$list->id}}/{{$list->postreport}}/" class="btn btn-block btn-success btn-sm" style="color:#fff">Check Reports</a>
        @else
        @if($list->postattempt!="3")
           <a href="{{url('student/exam/mainassement')}}/{{$list->postass}}/{{$list->id}}" class="btn btn-block btn-primary btn-sm" style="color:#fff">RETAKE</a>
         @else
          <a href="{{url('exam/sectionreport')}}/{{$list->id}}/{{$list->postreport}}/" class="btn btn-block btn-success btn-sm" style="color:#fff">Check Reports</a>
       @endif
       @endif
      @else
         <a href="{{url('exam/sectionreport')}}/{{$list->id}}/{{$list->postreport}}/" class="btn btn-block btn-success btn-sm" style="color:#fff">Check Reports</a>
      @endif
      </p>
    </div>
</div>
@endforeach
                                            
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                    <!-- partial -->
                                </div>
                            </div>
                            <!-- /.tab-content -->
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- ./card -->
               
                <!-- /.col -->
            </div>

            @if(count($competitions)>0)
            <div class="col-6">
                        <div class="card card-primary " style="background-color:rgba(215, 223, 240, 1);">  
                            <div class="card-body p-3">
                                   <h5 style="color:black !important;text-align:center;font-weight:600;">Competitions</h5>
                                    <hr>
                                <div class="row">
                                    <div class="col-lg-12 ms-auto text-center mt-5 mt-lg-0">
                                        <div class="border-radius-lg h-100" style="border-radius: 20px;display:flex;justify-content:center">
                                            <div class="wrapper col-11">
                                                <div class="car clients-review-carousel owl-carousel owl-theme">
                                                @foreach($competitions as $list)
                                                  <div class="item" style="height:150px;width:300px">
                                                    <div class="blog-card" style="width:350px;height: 200px;">
                                                    <div class="meta" style="width:80px">
                                                        <div class="photo" style="background-image: url('{{ asset('competitionimages')}}/{{$list->image}}');"></div>
                                                    </div>
                                                    <div class="description"style="display: flex;flex-direction: column;justify-content: center;align-items: center;flex-direction:column;">
                                                        <h1 style="font-size:12px;font-weight:700;margin-top:-40px;">{{$list->competitionname}}</h1>
                                                        <p style="font-size:10px;word-break:break-all;width:90%;color:#000;"><b> Description</b><br>
                                                            <i style="color:#000;">{{$list->subtitle}}</i>
                                                        </p>
                                                        <a href="{{url('student/competition/view')}}/{{$list->id}}" style="margin-top: 10px;">
                                                           <button type="button" class="btn btn-success btn-sm" style="font-weight: bold;">View</button>
                                                        </a> 
                                                    </div>
                                                </div>
                                                </div>
                                            @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif


             @php
        $count=1;
        @endphp
        @foreach($trainingtype as $list)
        <div class="col-lg-4 col-8"> 
            @if($count==1)
            <div class="small-box bg-danger" style="background-image:linear-gradient(to right,#283048,#859398);">
            @elseif($count==2)
            <div class="small-box bg-danger" style="background-image:linear-gradient(to right,#cc2b5e,#753a88);">
            @elseif($count==3)
            <div class="small-box bg-danger" style="background-image:linear-gradient(to right,red,orange);">
            @elseif($count==4)
            <div class="small-box bg-danger" style="background-image:linear-gradient(to right,#2193b0,#6dd5ed);">
            @endif
                <div class="inner">
                    <h3 style="color: #fff">{{$list->assigned}}</h3>
                    <p>ASSIGNED - {{$list->type}}</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                <a href="{{url('student/assigned')}}/{{$list->id}}" class="small-box-footer">More Details  <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-4 col-8"> 
            @if($count==1)
            <div class="small-box bg-danger" style="background-image:linear-gradient(to right,#283048,#859398);">
            @elseif($count==2)
            <div class="small-box bg-danger" style="background-image:linear-gradient(to right,#cc2b5e,#753a88);">
            @elseif($count==3)
            <div class="small-box bg-danger" style="background-image:linear-gradient(to right,red,orange);">
            @elseif($count==4)
            <div class="small-box bg-danger" style="background-image:linear-gradient(to right,#2193b0,#6dd5ed);">
            @endif
                <div class="inner">
                    <h3 style="color: #fff">{{$list->attended}}</h3>
                    <p>ATTENDED - {{$list->type}}</p>
                </div>
                 <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                <a href="{{url('student/attended')}}/{{$list->id}}" class="small-box-footer">More Details  <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-4 col-8">
            @if($count==1)
            <div class="small-box bg-danger" style="background-image:linear-gradient(to right,#283048,#859398);">
            @elseif($count==2)
            <div class="small-box bg-danger" style="background-image:linear-gradient(to right,#cc2b5e,#753a88);">
            @elseif($count==3)
            <div class="small-box bg-danger" style="background-image:linear-gradient(to right,red,orange);">
            @elseif($count==4)
            <div class="small-box bg-danger" style="background-image:linear-gradient(to right,#2193b0,#6dd5ed);">
            @endif
                <div class="inner">
                    <h3 style="color: #fff">{{$list->completed}}</h3>
                    <p>COMPLETED - {{$list->type}}</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                <a href="{{url('student/completed')}}/{{$list->id}}" class="small-box-footer">More Details  <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        @php
        $count++;
        @endphp
        @endforeach

</div>



                                           
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    
                                  
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
</div>





</div>

<script type="text/javascript">
    $(".carousel").owlCarousel({
          margin:20,
          loop: true,
          autoplay: true,
          autoplayTimeout: 2000,
          autoplayHoverPause: true,
          responsive: {
            0:{
              items:1,
              nav: false
            },
             600:{
              items:2,
              nav: false
            },
            
            
           
          }
        });
     $(".car").owlCarousel({
          margin:20,
          loop: true,
          autoplay: true,
          autoplayTimeout: 2000,
          autoplayHoverPause: true,
          responsive: {
            0:{
              items:1,
              nav: false
            }
            
           
          }
        });
    
      $(".car2").owlCarousel({
          margin:20,
          loop: true,
          autoplay: true,
          autoplayTimeout: 2000,
          autoplayHoverPause: true,
          responsive: {
            0:{
              items:1,
              nav: false
            }
            
           
          }
        });

       $(".car3").owlCarousel({
          margin:20,
          loop: true,
          autoplay: true,
          autoplayTimeout: 2000,
          autoplayHoverPause: true,
          nav:true,
          responsive: {
            0:{
              items:1,
              nav: true
            }
            
           
          }
        });
    
    
    
    $(".cars").owlCarousel({
          margin: 40,
          loop: true,
          autoplay: true,
          autoplayTimeout: 2000,
          autoplayHoverPause: true,
          responsive: {
          0:{
              items:1,
              nav: false
            },
                 
          },
          
        });
         $(".sam").owlCarousel({
          margin: 40,
          loop: true,
          autoplay: true,
          autoplayTimeout: 2000,
          autoplayHoverPause: true,
          responsive: {
          0:{
              items:1,
              nav: false
            },
                 
          },
          
        });
    
      
       
          $(".free").owlCarousel({
          margin: 40,
          loop: true,
          autoplay: true,
          autoplayTimeout: 2000,
          autoplayHoverPause: true,
          
          responsive: {
              
          0:{
              
              items:orfree,
              nav: false
            },
                 
          },
          
        }); 

</script>

@endsection