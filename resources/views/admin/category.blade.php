@extends('admin/layout')
@section('title','Standard')
@section('Dashboard_select','active')
@section('container')

@if(session()->has('danger'))
        <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
            <span class="badge badge-pill badge-danger"></span>
            {{session('danger')}}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
            </button>
        </div>
@endif
<form action="{{url('admin/category/bygroup')}}" method="post">
    @csrf
    <div class="form-row">
        <div class="col-12 col-sm-3 mt-4 mt-sm-0">
            <label>Group</label>
            <select class="form-control" aria-required="true" aria-invalid="false" name="groupid" id="category" onchange="yesnoChecked(this)">
                <option value="">Select</option>
                @foreach($groups as $list)
                   @if($groupid==$list->id)
                    <option selected value="{{$list->id}}">{{$list->group}}</option>
                   @else
                    <option value="{{$list->id}}">{{$list->group}}</option>
                   @endif
                @endforeach 
            </select>
        </div>
        <div class="col-12 col-sm-3 mt-4 mt-sm-0">
            <label></label><br>
           <a href="{{url('admin/category/addcategory')}}">
            <button type="button" class="btn btn-primary" style="margin-top:8px;">Create</button></a>
        </div>
        <div class="col-md-6" style="display:flex !important; align-items: flex-end !important;">
            <button type="submit" class="btn btn-sm btn-success" id="getskillattributes" hidden="true">Category Related Domain
            </button>
        </div>
    </div>
</form>
<div class="row">
    <div class="col-md-12">
        <div class="card-body table-responsive p-0">
            <table class="table table-borderless table-data3">
                <thead>
                    <br>
                    <tr>
                        <th>Standard</th>
                        <th>Maximum Periods</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($category as $list)
                    <tr>
                        <td>{{$list->categories}}</td>
                        <td>{{$list->cmaxperiod}}</td>
                        <td>
                            <a href="{{url('admin/category/addcategory')}}/{{$list->id}}"><button type="button" class="btn btn-success">Edit</button>
                            </a>
                            <a href="{{url('admin/category')}}/{{$list->id}}"><button type="button" class="btn btn-danger">Delete</button>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  function yesnoChecked(that) {
    if (that.value != "") {
        document.getElementById('getskillattributes').click();    
     } 
  }
</script>
@endsection