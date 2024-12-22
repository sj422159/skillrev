@extends('nontechmanager/account/layout')
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
                <h3 class="widget-user-username" style="color:#fff";><?Php echo session()->get('NONTECH_MANAGER_Name'); ?></h3>
            </div>
            <div class="widget-user-image">
                @foreach($image as $list)
                <img class="img-circle elevation-2" src="{{asset('nontechmanagerimages')}}/{{$list->image}}" alt="User Avatar">
                @endforeach
            </div>
            <div class="card-footer" style="background-color: #fff;">
                <div class="row col-12" style="display:flex;align-items:center;justify-content: center;padding: 0;margin: 0;">
                    <a href="{{url('nontech/manager/adddetails')}}" class="btn btn-block btn-primary btn-sm col-6" style="background-image: linear-gradient(to right,#5235ba,#7e3ded);">
                    <i class="nav-icon fas fa-edit"></i>&nbsp&nbspProfile
                    </a>
                </div>
            </div>
        </div>
      
        <div class="col-lg-4 col-8">
            <!-- Expense Raised -->
            <div class="small-box bg-info" style="background-image: linear-gradient(to right,darkblue,blue);">
                <div class="inner">
                    <h3 style="color: #fff" id="profiles">{{ $totalCount }}</h3>
                    <p>Expense Raised</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                <a href="#" class="small-box-footer" data-toggle="modal" data-target="#detailsModal">More Details<i class="fas fa-arrow-circle-right"></i></a>
            </div>
        
            <!-- Expense Validated -->
            <div class="small-box bg-info" style="background-image: linear-gradient(to right,darkblue,blue);">
                <div class="inner">
                    <h3 style="color: #fff" id="profiles">{{ $approvedCount }}</h3>
                    <p>Expense Validated</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                <a href="#" class="small-box-footer" data-toggle="modal" data-target="#detailsModal">More Details<i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        
        <div class="col-lg-4 col-8">
            <!-- Expense Rejected -->
            <div class="small-box bg-info" style="background-image: linear-gradient(to right,darkblue,blue);">
                <div class="inner">
                    <h3 style="color: #fff" id="profiles">{{ $rejectedCount }}</h3>
                    <p>Expense Rejected</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                <a href="#" class="small-box-footer" data-toggle="modal" data-target="#detailsModal">More Details<i class="fas fa-arrow-circle-right"></i></a>
            </div>
        
            <!-- Expense Approved -->
            <div class="small-box bg-info" style="background-image: linear-gradient(to right,darkblue,blue);">
                <div class="inner">
                    <h3 style="color: #fff" id="profiles">{{ $pendingCount }}</h3>
                    <p>Expense Approved</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                <a href="#" class="small-box-footer" data-toggle="modal" data-target="#detailsModal">More Details<i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        
        <!-- Modal -->
        <div class="modal fade" id="detailsModal" tabindex="-1" role="dialog" aria-labelledby="detailsModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="detailsModalLabel">Select Module</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <select id="moduleDropdown" class="form-control">
                            <option value="transport">Transport</option>
                            <option value="hostel">Hostel</option>
                            <option value="cafeteria">Cafeteria</option>
                            <option value="asset">Asset</option>
                            <option value="library">Library</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="goButton">Go</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        
        <script>
            document.getElementById('goButton').addEventListener('click', function () {
                const module = document.getElementById('moduleDropdown').value;
                const baseUrl = '/account/manager/expenses/'; // Absolute path from the domain root
                window.location.href = baseUrl + module;
            });
        </script>
        
        
          
</div>
@endsection