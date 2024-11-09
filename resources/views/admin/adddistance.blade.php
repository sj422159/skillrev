@extends('admin/layout')
@section('title','Add Distance')
@section('Dashboard_select','active')
@section('container')
<div class="row">
    <div class="col-6">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title" style="color:#fff !important;">Distance</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="{{url('admin/fees/savedistance')}}" method="post" enctype="multipart/form-data">
            @csrf
                <div class="card-body">
                <div class="form-row">
                    <div class="col-12 col-sm-4">
                        <label for="jobrole">Bus Route</label>
                        <select id="mainbranch" name="busrouteid" type="text" class="form-control" aria-required="true" aria-invalid="false" required="true">
                            <option value="">Select</option>
                            @foreach($busroutes as $list)
                            @if($busrouteid==$list->id)
                            <option selected value="{{$list->id}}">{{$list->busroute}}</option>
                            @else
                            <option value="{{$list->id}}">{{$list->busroute}}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-sm-4">
                        <label for="jobrole">Location</label>
                        <input type="text" class="form-control"  required="true" placeholder="Enter location" name="location" value="{{$location}}">
                    </div>
                    <div class="col-12 col-sm-4">
                        <label for="jobrole">Distance</label>
                        <input type="number" class="form-control"  required="true" placeholder="Enter Distance" name="distance" value="{{$distance}}" min="1">
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