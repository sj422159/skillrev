@extends('marketingmanager/layout')
@section('title','Profile')
@section('Profile','active')
@section('container')

<div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">

   @if(session()->has('error'))
  <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                      <span class="badge badge-pill badge-danger"></span>
                      {{session('error')}}
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                      </button>
        </div>
    @endif
          </div>
    </div>
</div>
 

<div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg"><b>Update Profile Details</b></p>

      <form action="{{url('employee/marketingmanager/profile/processing')}}" method="post">
        @csrf
       

         <div class="input-group mb-3">
          <input type="password" class="form-control" required="true" name="opass" placeholder="Current Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control"   name="npass" placeholder="New Password" >
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="cpass" placeholder="Confirm New password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>

        <div class="row">
            <div class="col-12">
              <button type="submit" class="btn btn-primary btn-block">Update</button>
            </div>
    
          <!-- /.col -->
        </div>

      </form>

     
      
    </div>
    <!-- /.form-box -->
  </div>
  @endsection