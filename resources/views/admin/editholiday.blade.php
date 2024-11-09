@extends('admin/layout')
@section('title','Edit Holiday')
@section('Dashboard_select','active')
@section('container')
<div class="row">
<div class="col-10">
   <a href="{{url('admin/holiday')}}"><button type="submit" class="btn btn-danger btn-sm" style="margin-bottom:15px !important;">Back</button></a>
 <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title" style="color:#fff;">Edit Holiday</h3>
              </div>
              <form action="{{url('admin/holiday/update')}}" method="post" enctype="multipart/form-data">
              	@csrf
                <div class="card-body">  
                <div class="form-row">
                  <div class="col-12 col-sm-4 mt-4 mt-sm-0">
                    <label for="branchname">Holiday Name</label>
                    <input type="text" class="form-control" id="mainbranch" name="holidayname" value="{{$holidayname}}">
                  </div>
                  <div class="col-12 col-sm-4 mt-4 mt-sm-0">
                    <label for="branchname">Date</label>
                    <input type="date" class="form-control" id="mainbranch" name="date" value="{{$date}}">
                  </div>
                <div class="col-12 col-sm-4 mt-4 mt-sm-0">
                    <label for="image" class="control-label">Holiday Image</label>
                    <input id="image" name="image" type="file" class="form-control"> 
                    @if($image!="")
                    <img src="{{asset('holidayimages')}}/{{$image}}" width="130px" height="80px">
                    @endif
                </div>
                </div>
              </div>
                <input type="hidden" name="id" value="{{$id}}">
                <div class="card-footer">
                  <button type="submit" class="btn btn-sm btn-primary">Update</button>
                </div>
              </form>
            </div>
        </div>
    </div>
@endsection
