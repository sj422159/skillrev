@extends('admin/layout')
@section('title','Add Group')
@section('Dashboard_select','active')
@section('container')
<div class="row">
    <div class="col-6">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title" style="color:#fff !important;">Create Group</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="{{url('admin/group/savegroup')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="form-row mt-2">
                    <div class="col-12 col-sm-6 mt-2 mt-sm-0">
                    <label for="domain">Type</label>
                    <select id="at" name="gtype" type="text" class="form-control" aria-required="true" aria-invalid="false" required="true">
                    @if($gtype==1)
                    <option selected value="1">Mandatory</option>
                    <option value="2">Optional</option>
                    @elseif($gtype==2)
                    <option value="1">Mandatory</option>
                    <option selected value="2">Optional</option>
                    @else
                    <option value="1">Mandatory</option>
                    <option value="2">Optional</option>
                    @endif
                    </select>
                    </div>
                    <div class="col-12 col-sm-6 mt-2 mt-sm-0">
                        <label for="jobgroup">Group</label>
                        <input type="text" class="form-control" id="jobgroup" required="true" placeholder="Enter Group Name" name="group" value="{{$group}}">
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