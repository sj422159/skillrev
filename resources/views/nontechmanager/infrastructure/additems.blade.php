@extends('nontechmanager/infrastructure/layout')
@section('title','Item Details')
@section('Dashboard_select','active')
@section('container')

<div class="row">
    <div class="col-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title" style="color:#fff !important;">CREATE ITEM</h3>
            </div>
           
            <form action="{{url('nontech/manager/infrastructure/items/saveitems')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="form-row mt-2">  
                    <div class="col-12 col-sm-6 mt-2 mt-sm-0">
                        <label for="jobgroup">ITEM NAME</label>
                        <input type="text" class="form-control" id="jobgroup" required="true" placeholder="Enter Items Name" name="infraitem" value="{{$infraitem}}">
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