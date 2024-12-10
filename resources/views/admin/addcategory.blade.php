@extends('admin/layout')
@section('title','Add Standard')
@section('Dashboard_select','active')
@section('container')
<div class="row">
    <div class="col-6">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title" style="color:#fff !important;">Create</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="{{url('admin/category/savecategory')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                <div class="form-row">
                    <div class="col-12 col-sm-6">
                        <label for="jobskill">Group</label>
                        <select id="subbranch" name="groupid" type="text" class="form-control" aria-required="true" aria-invalid="false" required="true">
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
                    <div class="col-12 col-sm-6">
                        <label for="jobskill">Standard</label>
                        <select id="subbranch" name="standardid" type="text" class="form-control" aria-required="true" aria-invalid="false" required="true">
                            <option value="">Select</option>
                            @foreach($standards as $list)
                            @if($standardid==$list->id)
                            <option selected value="{{$list->id}}">{{$list->name}}</option>
                            @else
                            <option value="{{$list->id}}">{{$list->name}}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-row mt-4">
                    <div class="col-12 col-sm-6">
                        <label for="jobrole">Short Name</label>
                        <input type="text" class="form-control" id="jobrole" required="true" placeholder="Enter" name="shortcat" value="{{$shortcateg}}" maxlength="4">
                    </div>
                    <div class="col-12 col-sm-6">
                        <label for="jobrole">Maximum Periods</label>
                        <input type="number" class="form-control" id="jobrole" required="true" name="max" value="{{$max}}">
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