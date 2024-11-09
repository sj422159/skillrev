@extends('manager/layout')
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
     @if(session()->has('success'))
  <div class="sufee-alert alert with-close alert-success alert-dismissible fade show">
                      <span class="badge badge-pill badge-success"></span>
                      {{session('success')}}
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                      </button>
  </div>
    @endif
    <div class="row">
        <div class="card card-widget widget-user" style="width:300px;height: 280px;margin:0px 20px 0px 15px;">
            <div class="widget-user-header bg-primary" style="background-image: linear-gradient(to right,#5235ba,#7e3ded);">
                <h3 class="widget-user-username" style="color:#fff";><?Php echo session()->get('MANAGER_Name'); ?></h3>
                
            </div>
            <div class="widget-user-image">
                @foreach($image as $list)
                <img class="img-circle elevation-2" src="{{asset('managerimages')}}/{{$list->image}}" alt="User Avatar">
                @endforeach
            </div>
            <div class="card-footer" style="background-color: #fff;">
                <div class="row col-12" style="display:flex;align-items:center;justify-content: center;padding: 0;margin: 0;">
                    <a href="{{url('manager/adddetails')}}" class="btn btn-block btn-primary btn-sm col-6" style="background-image: linear-gradient(to right,#5235ba,#7e3ded);">
                    <i class="nav-icon fas fa-edit"></i>&nbsp&nbspProfile
                    </a>
                </div>
            </div>
        </div>

         <div class="col-lg-4 col-8">
            <!-- small box -->
            <div class="small-box bg-info" style="background-image: linear-gradient(to right,darkblue,blue);">
                <div class="inner">
                    <h3 style="color: #fff" id="profiles">{{count($student)}}</h3>
                    <p>Students</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>                
                <a href="{{url('manager/studentdetails')}}" class="small-box-footer">More Details<i class="fas fa-arrow-circle-right"></i></a>
            </div>
            <div class="small-box bg-info" style="background-image: linear-gradient(to right,darkblue,blue);">
                <div class="inner">
                    <h3 style="color: #fff">{{count($training)}}</h3>
                    <p>Trainings</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                <a href="{{url('manager/trainingprogram')}}" class="small-box-footer">More Details<i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-4 col-8">
            <div class="small-box bg-info" style="background-image: linear-gradient(to right,darkgreen,lightgreen);">
                <div class="inner">
                    <h3 style="color: #fff">{{$rescheduledclasses}}</h3>
                    <p>Rescheduled Classes</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                <a href="{{url('manager/rescheduled/classes')}}" class="small-box-footer">More Details<i class="fas fa-arrow-circle-right"></i></a>
            </div>
            <div class="small-box bg-info" style="background-image: linear-gradient(to right,darkgreen,lightgreen);">
                <div class="inner">
                    <h3 style="color: #fff">{{count($competition)}}</h3>
                    <p>Competition</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                <a href="{{url('manager/competition')}}" class="small-box-footer">More Details<i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
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
                <a href="{{url('manager/assigned')}}/{{$list->id}}" class="small-box-footer">More Details  <i class="fas fa-arrow-circle-right"></i></a>
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
                <a href="{{url('manager/attended')}}/{{$list->id}}" class="small-box-footer">More Details  <i class="fas fa-arrow-circle-right"></i></a>
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
                <a href="{{url('manager/completed')}}/{{$list->id}}" class="small-box-footer"> More Details  <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        @php
        $count++;
        @endphp
        @endforeach      
       
              
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
        

</script>

@endsection