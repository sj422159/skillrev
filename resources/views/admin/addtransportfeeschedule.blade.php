@extends('admin/layout')
@section('title','Add Transport Fees Schedule')
@section('Dashboard_select','active')
@section('container')
<div class="row">
    <div class="col-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title" style="color:#fff !important;">Transport Fees Schedule</h3>
            </div>
            <form action="{{url('admin/transport/fees/schedule/busroutes/save')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                @foreach($distances as $list)
                <div class="form-row mt-3">
                    <div class="col-12 col-sm-2 mt-4 mt-sm-0">
                       <label for="jobrole">Location</label>
                       <input type="text" name="shlocationname[]" readonly placeholder="Enter Location" class="form-control" required value="{{$list->location}}">
                    </div>
                    <div class="col-12 col-sm-2 mt-4 mt-sm-0">
                       <label for="jobrole">Distance</label>
                       <input type="text" name="shtypename[]" readonly placeholder="Enter Distance" class="form-control" required value="{{$list->distance}}">
                    </div>
                    <div class="col-12 col-sm-2 mt-4 mt-sm-0">
                       <label for="jobrole">Annual</label>
                       <input type="number" name="shannual[]" placeholder="Enter Fees" class="form-control" required value="{{$list->shannual}}">
                    </div>
                    <div class="col-12 col-sm-2 mt-4 mt-sm-0">
                       <label for="jobrole">Half Yearly</label>
                       <input type="number" name="shhalf[]" placeholder="Enter Fees" class="form-control" required value="{{$list->shhalf}}">
                    </div>
                    <div class="col-12 col-sm-2 mt-4 mt-sm-0">
                       <label for="jobrole">Quarterly</label>
                       <input type="number" name="shquater[]" placeholder="Enter Fees" class="form-control" required value="{{$list->shquater}}">
                    </div>
                    <div class="col-12 col-sm-2 mt-4 mt-sm-0">
                       <label for="jobrole">Monthly</label>
                       <input type="number" name="shmonth[]" placeholder="Enter Fees" class="form-control" required value="{{$list->shmonthly}}">
                    </div>
                    <input type="hidden" name="shtype[]" required value="{{$list->distanceid}}">
                    <input type="hidden" name="shfeescheduleid[]" value="{{$list->shfeescheduleid}}">
                </div>
                @endforeach 
                <input type="hidden" name="moneystatus" value="{{$moneystatus}}">
                <input type="hidden" name="busrouteid" value="{{$busrouteid}}">  
                <div class="card-footer mt-4">
                    @if(count($distances)>0)
                    <button type="submit" class="btn btn-primary">Submit</button>
                    @endif
                </div>
        </div>
        </form>
    </div>
</div>
</div>
@endsection