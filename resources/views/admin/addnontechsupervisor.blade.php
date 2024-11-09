@extends('admin/layout')
@section('title','Add Group Manager')
@section('manager_select','active')
@section('container')
<div class="row">
    <div class="col-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title" style="color:#fff !important;">Create Group Manager</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="{{url('admin/nontech/supervisor/savesupervisor')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                <div class="form-row">
                  
                  <div class="col-12 col-sm-3 mt-4 mt-sm-0">
                    <label for="jobrole">Name</label>
                    <input type="text" class="form-control" id="jobrole" required="true" placeholder="Enter Name" name="name" value="{{$name}}">
                  </div>
                  <div class="col-12 col-sm-3 mt-4 mt-sm-0">
                    <label for="jobrole">Email</label>
                    <input type="email" class="form-control" id="jobrole" required="true" placeholder="Enter Email" name="email" value="{{$email}}">
                  </div>
                  <div class="col-12 col-sm-3 mt-4 mt-sm-0">
                    <label for="jobrole">Number</label>
                    <input type="text" class="form-control" id="jobrole" required="true" placeholder="Enter Number" name="number" value="{{$number}}">
                  </div>
              </div>
                    <input type="hidden" name="id" value="{{$id}}">
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
        </div>
        </form>
    </div>
</div>
</div>
@endsection