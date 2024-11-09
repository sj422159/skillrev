@extends('corporateadmin/layout')
@section('title','Items') 
@section('dashboard_select','active extra') 
@section('container')


<div class="row">
    <div class="col-6">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title" style="color:#fff !important;">CREATE ITEM</h3>
            </div>
           
         <form action="{{url('corporateadmin/infrastructure/items/saveitems')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="form-row mt-2">  
                    <div class="col-12 col-sm-6 mt-2 mt-sm-0">
                        <label for="jobgroup">ITEM NAME</label>
                        <input type="text" class="form-control" id="jobgroup" required="true" placeholder="Enter Items Name" name="infraitem" value="{{$infraitem}}">
                    </div>
                    <br>
                     <div class="form-row">
                  <div class="form-check mt-3">
                       
                         @if($allocation=="1")
                      <input type="checkbox" checked class="form-check-input" id="check1" name="allocation" style="margin-top:8px;margin-left:0px;">
                    @else
                       <input type="checkbox" class="form-check-input" id="check1" name="allocation" style="margin-top:8px;margin-left:0px;">
                    @endif
                      <label class="form-check-label" for="show" style="margin-left:30px;text-transform:uppercase;"><b>Visible In Infrastructure Allocation</b></label>
                    </div>
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