@extends('admin/layout')
@section('title','Add Category')
@section('Dashboard_select','active')
@section('container')
<div class="row">
    <div class="col-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title" style="color:#fff !important;">FEES Categories</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="{{url('admin/fees/savecategory')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                <div class="form-row">
                  
                    <div class="col-12 col-sm-4">
                        <label for="jobrole">Category</label>
                        <input type="text" class="form-control" id="jobrole" required="true" placeholder="Enter Category Name" name="category" value="{{$feescategory}}">
                    </div>
                    <div class="col-12 col-sm-4">
                        <label for="jobrole">Selection Type</label>
                        <select class="form-control" required name="type">
                        <option value="">Select</option>
                         @foreach($type as $list)
                         @if($fctype==$list['id'])
                           <option value="{{$list['id']}}" selected>{{$list['type']}}</option>
                         @else
                           <option value="{{$list['id']}}">{{$list['type']}}</option>
                         @endif
                         @endforeach
                     </select>
                    </div>
                    <div class="col-12 col-sm-4">
                        <label for="jobrole">Category Type</label>
                        <select class="form-control" required name="mandatoryornot">
                        <option value="">Select</option>
                         @foreach($types as $list)
                         @if($fcmandatoryornot==$list['id'])
                           <option value="{{$list['id']}}" selected>{{$list['type']}}</option>
                         @else
                           <option value="{{$list['id']}}">{{$list['type']}}</option>
                         @endif
                         @endforeach
                     </select>
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