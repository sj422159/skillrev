@extends('corporateadmin/layout')
@section('title','School Data')
@section('useradmin','active extra')
@section('container')
<style type="text/css">
  .inner h3,p{
    color: #fff;
  }
  img{
     height: 100px;
     width: 100px;
  }
</style>
<div class="container-fluid">
    <div class="row col-12">
        <div class="col-6" style="display:flex;align-items: flex-end;justify-content: right;">
        	<img class="img-circle" src="{{asset('adminimages')}}/{{$data[0]->image}}" alt="User Avatar">
        </div>
        <div class="col-6" style="display:flex;justify-content:center;align-items:flex-start;flex-direction: column;">
        	<h1>{{$data[0]->aname}}</h1>
        	<a href="{{$data[0]->awebsitelink}}" target="_blank">Go To Website</a>
          <a>Total Accounts : {{$totalaccounts}}</a>
        </div>
    </div>
    <br>
        <div class="row">
          <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box"style="background-image: linear-gradient(to right,darkblue,blue);">
              <div class="inner">
                <h3> {{$school}} </h3>
                <p>Admin</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="{{url('corporateadmin/admin/export')}}/{{$data[0]->id}}" class="small-box-footer">Export</a>
            </div>
          </div>
          <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box"style="background-image: linear-gradient(to right,darkblue,blue);">
              <div class="inner">
                <h3> {{$groupmanager}} </h3>
                <p>Technical Group Manager</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="{{url('corporateadmin/groupmanager/export')}}/{{$data[0]->id}}" class="small-box-footer">Export</a>
            </div>
          </div>
          <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box"style="background-image: linear-gradient(to right,darkblue,blue);">
              <div class="inner">
                <h3> {{$manager}} </h3>
                <p>Technical Manager</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="{{url('corporateadmin/manager/export')}}/{{$data[0]->id}}" class="small-box-footer">Export</a>
            </div>
          </div>
      </div>

      <div class="row">
          <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box"style="background-image: linear-gradient(to right,darkblue,blue);">
              <div class="inner">
                <h3> {{$nontechgroupmanager}} </h3>
                <p>Non Technical Group Manager</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="{{url('corporateadmin/nontechgroupmanager/export')}}/{{$data[0]->id}}" class="small-box-footer">Export</a>
            </div>
          </div>
          <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box"style="background-image: linear-gradient(to right,darkblue,blue);">
              <div class="inner">
                <h3> {{$nontechmanager}} </h3>
                <p>Non Technical Manager</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="{{url('corporateadmin/nontechmanager/export')}}/{{$data[0]->id}}" class="small-box-footer">Export</a>
            </div>
          </div>
          <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box"style="background-image: linear-gradient(to right,darkblue,blue);">
              <div class="inner">
                <h3> {{$nontechstaff}} </h3>
                <p>Non Technical Staff</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="{{url('corporateadmin/nontechstaff/export')}}/{{$data[0]->id}}" class="small-box-footer">Export</a>
            </div>
          </div>
      </div>

      <div class="row">
       	  <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box"style="background-image: linear-gradient(to right,darkblue,blue);">
              <div class="inner">
                <h3> {{$classteacher}} </h3>
                <p>Class Teacher</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="{{url('corporateadmin/classteacher/export')}}/{{$data[0]->id}}" class="small-box-footer">Export</a>
            </div>
          </div>
          <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box"style="background-image: linear-gradient(to right,darkblue,blue);">
              <div class="inner">
                <h3> {{$faculty}} </h3>
                <p>Faculty</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="{{url('corporateadmin/faculty/export')}}/{{$data[0]->id}}" class="small-box-footer">Export</a>
            </div>
          </div>
          <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box"style="background-image: linear-gradient(to right,darkblue,blue);">
              <div class="inner">
                <h3> {{$student}} </h3>
                <p>Student</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="{{url('corporateadmin/student/export')}}/{{$data[0]->id}}" class="small-box-footer">Export</a>
            </div>
          </div>
      </div>

      <div class="row">
          <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box"style="background-image: linear-gradient(to right,darkblue,blue);">
              <div class="inner">
                <h3> {{$caterer}} </h3>
                <p>Caterer</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="{{url('corporateadmin/caterer/export')}}/{{$data[0]->id}}" class="small-box-footer">Export</a>
            </div>
          </div>
          <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box"style="background-image: linear-gradient(to right,darkblue,blue);">
              <div class="inner">
                <h3>0</h3>
                <p>TBD</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="#" class="small-box-footer">Export</a>
            </div>
          </div>
          <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box"style="background-image: linear-gradient(to right,darkblue,blue);">
              <div class="inner">
                <h3>0</h3>
                <p>TBD</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="#" class="small-box-footer">Export</a>
            </div>
          </div>
      </div>

  </div>
@endsection