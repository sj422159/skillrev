@extends('admin/layout')
@section('title','Add Department')
@section('Dashboard_select','active')
@section('container')
<div class="row">
    <div class="col-6">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title" style="color:#fff !important;">Create Department</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="{{url('admin/department/savedepartment')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="form-row mt-2">
                    <div class="col-12 col-sm-6 mt-2 mt-sm-0">
                        <label for="jobdepartment">Categories</label>
                        <select class="form-control" name="cat" required> 
                            <option value="">Select</option>
                                @foreach($nontechcategories as $list)
                                  @if($list->id==$category))
                                   <option value="{{$list->id}}" selected>{{$list->ntcname}}</option>
                                  @else
                                   <option value="{{$list->id}}">{{$list->ntcname}}</option>
                                  @endif
                                @endforeach
                          
                             
                        </select>
                    </div>
                    <div class="col-12 col-sm-6 mt-2 mt-sm-0">
                        <label for="jobdepartment">Department</label>
                        <input type="text" class="form-control" id="jobdepartment" required="true" placeholder="Enter" name="department" value="{{$department}}">
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