@extends('marketingmanager/layout')
@section('title','Dashboard')
@section('dashboard_select','active')
@section('container')
<style type="text/css">
  .inner h3,p{
    color: #fff;
  }
</style>
 <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
<style type="text/css">
    .wrapper img{
    height:100px;
    width:150px;
    }
    .item{
    height:150px;
    width: 300px;
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
    .inner p{
        color: #fff;
    }
</style>

<div class="main-content"style="padding: 10px;">
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

        <div class="row mb-4" style="margin-top:10px;">
        <div class="col-lg-4 col-6">
        <div class="card card-widget widget-user" style="width:300px;height: 280px;margin:0px 20px 0px 15px;">
            <div class="widget-user-header"style="background-image: linear-gradient(to right,#5235ba,#7e3ded);">
                <h3 class="widget-user-username" style="color:#fff";><?Php echo session()->get('MARKETINGMANAGER_fname'); ?> <?php echo session()->get('MARKETINGMANAGER_lname'); ?></h3>
                <h6 class="widget-user-desc"style="color: #fff;"><?Php echo session()->get('MARKETINGMANAGER_Email'); ?></h6>
            </div>
            <div class="widget-user-image">
               @if($data[0]->image!="")
                <img class="img-circle elevation-2" src="{{asset('internalimages')}}/{{$data[0]->image}}" alt="User Avatar">
               @endif
               
                
            </div>
            <div class="card-footer" style="background-color:#fff;">
                <div class="row col-12" style="display:flex;align-items:center;justify-content: center;padding: 0;margin: 0;">
                    <a href="{{url('employee/marketingmanager/adddetails')}}" class="btn btn-block btn-sm col-6" style="background-image: linear-gradient(to right,#5235ba,#7e3ded);color:#fff;">
                    <i class="nav-icon fas fa-edit"></i>&nbsp&nbspProfile
                    </a>
                </div>
            </div>
        </div>
      </div>
        <div class="col-lg-4 col-8">
            <div class="small-box" style="background-image:linear-gradient(to right,red,orange);">
                <div class="inner">
                    <h3 style="color: #fff" id="profiles">{{count($marketingofficers)}}</h3>
                    <p>Marketing Officers</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                <a href="{{url('employee/marketingmanager/marketingofficers')}}" class="small-box-footer">More Details<i class="fas fa-arrow-circle-right"></i></a>
            </div>
            <div class="small-box" style="background-image:linear-gradient(to right,red,orange);">
                <div class="inner">
                    <h3 style="color: #fff" id="profiles">0</h3>
                    <p>TBD</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                <a href="#" class="small-box-footer">More Details<i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-4 col-8">
            <div class="small-box" style="background-image:linear-gradient(to right,red,orange);">
                <div class="inner">
                    <h3 style="color: #fff" id="profiles">0</h3>
                    <p>TBD</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                <a href="" class="small-box-footer">More Details<i class="fas fa-arrow-circle-right"></i></a>
            </div>
            <div class="small-box" style="background-image:linear-gradient(to right,red,orange);">
                <div class="inner">
                    <h3 style="color: #fff" id="profiles">0</h3>
                    <p>TBD</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                <a href="#" class="small-box-footer">More Details<i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
      </div>
   
        <div class="row">
        <div class="col-lg-4 col-8">
            <div class="small-box" style="background-image: linear-gradient(to right,darkblue,blue);">
                <div class="inner">
                    <h3 style="color: #fff">{{count($coldcallinitiated)}}</h3>
                    <p>Cold Call Initiation</p>
                </div>
                <div class="icon">
                   <i class="ion ion-stats-bars"></i>
                </div>
                <a href="{{url('employee/marketingmanager/coldcall/2')}}" class="small-box-footer">Know More <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-4 col-8">
            <div class="small-box" style="background-image: linear-gradient(to right,darkblue,blue);">
                <div class="inner">
                    <h3 style="color: #fff">{{count($coldcallinprogress)}}</h3>
                    <p>Inprogress</p>
                </div>
                <div class="icon">
                   <i class="ion ion-stats-bars"></i>
                </div>
                <a href="{{url('employee/marketingmanager/coldcall/3')}}" class="small-box-footer">Know More <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-4 col-8">
            <div class="small-box" style="background-image: linear-gradient(to right,darkblue,blue);">
                <div class="inner">
                    <h3 style="color: #fff">{{count($coldcallcompleted)}}</h3>
                    <p>Completed</p>
                </div>
                <div class="icon">
                   <i class="ion ion-stats-bars"></i>
                </div>
                <a href="{{url('employee/marketingmanager/coldcall/4')}}" class="small-box-footer">Know More <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
      </div>










    </div>
    </div>
</div>
@endsection