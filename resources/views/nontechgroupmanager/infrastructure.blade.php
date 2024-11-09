@extends('nontechgroupmanager/layout')
@section('title','Infrastructure')
@section('Profile','active')
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
    <div class="row col-12">
        <div class="col-lg-6">
        <form action="{{url('nontech/groupmanager/infra/info')}}" method="post">
            @csrf
        <div class="form-group">
            <select class="form-control" name="hostel" required>
                <option value="">Select Infrastructure</option>
                @foreach($hostels as $list)
                @if($list->id==$id)
                <option value="{{$list->id}}" selected>{{$list->mname}}</option>
                @else
                 <option value="{{$list->id}}">{{$list->mname}}</option>
                @endif
                @endforeach
            </select>

        </div>
    </div>
    <div class="col-lg-6">
        <button type="submit" class="btn btn-primary">Get Details</button>
    </form>
</div>
    </div>
    <div class="row">
       
       
        <div class="col-lg-4 col-8">
            <div class="small-box bg-info" style="background-image: linear-gradient(to right,darkblue,blue);">
                <div class="inner">
                    <h3 style="color: #fff" id="profiles">{{$school}}</h3>
                    <p>School Infrastructure</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div> 
                @if($id==0)
                <a href="#" class="small-box-footer ">Select Infrastructure Manager</a>
                @else
                <a href="{{url('nontech/groupmanager/infra/school/info')}}/{{$id}}" class="small-box-footer">More Details <i class="fas fa-arrow-circle-right"></i></a>
                @endif               
                
            </div>
            <div class="small-box bg-info" style="background-image: linear-gradient(to right,darkblue,blue);">
                <div class="inner">
                    <h3 style="color: #fff" id="profiles">{{$hostel}}</h3>
                    <p>Hostel Infrastructure</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                @if($id==0)
                <a href="#" class="small-box-footer ">Select Infrastructure Manager</a>
                @else
                <a href="{{url('nontech/groupmanager/infra/hostel/info')}}/{{$id}}" class="small-box-footer">More Details <i class="fas fa-arrow-circle-right"></i></a>
                @endif   
            </div>
        </div>
       
        <div class="col-lg-4 col-8">
            <div class="small-box bg-info" style="background-image: linear-gradient(to right,darkblue,blue);">
                <div class="inner">
                    <h3 style="color: #fff" id="profiles">{{$cafeteria}}</h3>
                    <p>Cafeteria Infrastructure</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>                
                 @if($id==0)
                <a href="#" class="small-box-footer ">Select Infrastructure Manager</a>
                @else
                <a href="{{url('nontech/groupmanager/infra/cafeteria/info')}}/{{$id}}" class="small-box-footer">More Details <i class="fas fa-arrow-circle-right"></i></a>
                @endif   
            </div>
            <div class="small-box bg-info" style="background-image: linear-gradient(to right,darkblue,blue);">
                <div class="inner">
                    <h3 style="color: #fff" id="profiles">{{$others}}</h3>
                    <p>Others Infrastructure</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                @if($id==0)
                <a href="#" class="small-box-footer ">Select Infrastructure Manager</a>
                @else
                <a href="{{url('nontech/groupmanager/infra/others/info')}}/{{$id}}" class="small-box-footer">More Details <i class="fas fa-arrow-circle-right"></i></a>
                @endif   
            </div>
        </div>

         <div class="col-lg-4 col-8">
            <div class="small-box bg-info" style="background-image: linear-gradient(to right,darkblue,blue);">
                <div class="inner">
                    <h3 style="color: #fff" id="profiles">{{$repair}}</h3>
                    <p>Repairs </p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>                
                @if($id==0)
                <a href="#" class="small-box-footer ">Select Infrastructure Manager</a>
                @else
                <a href="{{url('nontech/groupmanager/infra/repairs')}}/{{$id}}" class="small-box-footer">More Details <i class="fas fa-arrow-circle-right"></i></a>
                @endif   
            </div>
            <div class="small-box bg-info" style="background-image: linear-gradient(to right,darkblue,blue);">
                <div class="inner">
                    <h3 style="color: #fff" id="profiles">{{$infra}}</h3>
                    <p>Infrastructure Items</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                @if($id==0)
                <a href="#" class="small-box-footer ">Select Infrastructure Manager</a>
                @else
                <a href="{{url('nontech/groupmanager/infra/items')}}/{{$id}}" class="small-box-footer">More Details <i class="fas fa-arrow-circle-right"></i></a>
                @endif   
            </div>
        </div>
             
</div>

@endsection