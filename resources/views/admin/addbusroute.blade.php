@extends('admin/layout')
@section('title','Add Bus Route')
@section('Dashboard_select','active')
@section('container')
<div class="row">
    <div class="col-6">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title" style="color:#fff !important;">Bus Route</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="{{url('admin/fees/savebusroute')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                <div class="form-row">
                  
                    <div class="col-12 col-sm-6">
                        <label for="jobrole">Bus Route</label>
                        <input type="text" class="form-control" id="jobrole" required="true" placeholder="Enter Bus Route Name" name="busroute" value="{{$busroute}}">
                    </div>
                    <input type="hidden" name="id" value="{{$id}}">
                </div>
                <div class="card-footer mt-4">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
        </div>
        </form>
    </div>
</div>
</div>
@endsection