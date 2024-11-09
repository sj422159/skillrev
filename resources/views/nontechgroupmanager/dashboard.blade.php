@extends('nontechgroupmanager/layout')
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
                <h3 class="widget-user-username" style="color:#fff";><?Php echo session()->get('NONTECH_GROUPMANAGER_Name'); ?></h3>
            </div>
            <div class="widget-user-image">
                @foreach($image as $list)
                <img class="img-circle elevation-2" src="{{asset('nontechgroupmanagerimages')}}/{{$list->image}}" alt="User Avatar">
                @endforeach
            </div>
            <div class="card-footer" style="background-color: #fff;">
                <div class="row col-12" style="display:flex;align-items:center;justify-content: center;padding: 0;margin: 0;">
                    <a href="{{url('nontech/groupmanager/adddetails')}}" class="btn btn-block btn-primary btn-sm col-6" style="background-image: linear-gradient(to right,#5235ba,#7e3ded);">
                    <i class="nav-icon fas fa-edit"></i>&nbsp&nbspProfile
                    </a>
                </div>
            </div>
        </div>
      
        <div class="col-lg-4 col-8">
            <div class="small-box bg-info" style="background-image: linear-gradient(to right,darkblue,blue);">
                <div class="inner">
                    @if(count($departments)>0)
                    <h3 style="color: #fff" id="profiles">{{count($transportmanager)}}</h3>
                    <p>{{$departments[0]->department}}</p>
                    </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>                
                <a href="{{url('nontechgroupmanager/details/dashboard/view')}}/{{$departments[0]->category}}" class="small-box-footer">More Details<i class="fas fa-arrow-circle-right"></i></a>
            </div>
                    @else
                    <h3 style="color: #fff" id="profiles">0</h3>
                    <p>TBD</p>
                    </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>                
                <a href="#" class="small-box-footer">More Details<i class="fas fa-arrow-circle-right"></i></a>
            </div>
                    @endif
                
            <div class="small-box bg-info" style="background-image: linear-gradient(to right,darkblue,blue);">
                <div class="inner">
                    @if(count($departments)>1)
                    <h3 style="color: #fff" id="profiles">{{count($infrastructuremanager)}}</h3>
                    <p>{{$departments[1]->department}}</p>
                     </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                 <a href="{{url('nontechgroupmanager/details/dashboard/view')}}/{{$departments[1]->category}}" class="small-box-footer">More Details<i class="fas fa-arrow-circle-right"></i></a>
            </div>
                    @else
                    <h3 style="color: #fff" id="profiles">0</h3>
                    <p>TBD</p>
                     </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                <a href="#" class="small-box-footer">More Details<i class="fas fa-arrow-circle-right"></i></a>
               </div>
                    @endif
              
               
        </div>
         <div class="col-lg-4 col-8">
            <div class="small-box bg-info" style="background-image: linear-gradient(to right,darkblue,blue);">
                <div class="inner">
                 
                    @if(count($departments)>2)
                    <h3 style="color: #fff" id="profiles">{{count($hostelmanager)}}</h3>
                    <p>{{$departments[2]->department}}</p>
                     </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>                
                 <a href="{{url('nontechgroupmanager/details/dashboard/view')}}/{{$departments[2]->category}}" class="small-box-footer">More Details<i class="fas fa-arrow-circle-right"></i></a>
            </div>
                    @else
                    <h3 style="color: #fff" id="profiles">0</h3>
                    <p>TBD</p>
                     </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>                
                <a href="#" class="small-box-footer">More Details<i class="fas fa-arrow-circle-right"></i></a>
            </div>
                    @endif
               
            <div class="small-box bg-info" style="background-image: linear-gradient(to right,darkblue,blue);">
                <div class="inner">
                    @if(count($departments)>3)
                    <h3 style="color: #fff" id="profiles">{{count($cafeteriamanager)}}</h3>
                    <p>{{$departments[3]->department}}</p>
                    </div>
                   <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                  </div>
                   <a href="{{url('nontechgroupmanager/details/dashboard/view')}}/{{$departments[3]->category}}" class="small-box-footer">More Details<i class="fas fa-arrow-circle-right"></i></a>
                </div>
                    @else
                    <h3 style="color: #fff" id="profiles">0</h3>
                    <p>TBD</p>
                    </div>
                    <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                   </div>
                   <a href="#" class="small-box-footer">More Details<i class="fas fa-arrow-circle-right"></i></a>
                  </div>
                    @endif
                
        </div>
     
             
</div>

@endsection