@extends('manager/layout')
@section('title','Assign')
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
<div class="row">
    <div class="col-6">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title" style="color:#fff !important;">Assign To Student</h3>
            </div>
            <form action="{{url('manager/training/assign/save')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="form-row">
                    <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                        <label for="jobrole">Training</label>
                        <input type="text" class="form-control" id="jobrole" name="trainingprogram" value="{{$trainingprogram[0]->trainingname}}" disabled>
                    </div>
                    <div class="col-12 col-sm-6 mt-4 mt-sm-0">
                        <label for="jobrole">Class</label>
                        <select id="mainbranch" name="class" type="text" class="form-control" aria-required="true" aria-invalid="false" required="true">
                            @foreach($class as $list)
                            <option value="{{$list->id}}">{{$list->categories}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <input type="hidden" name="facultyid" value="{{$trainingprogram[0]->facultyid}}">
                <input type="hidden" name="trainingtypeid" value="{{$trainingprogram[0]->trainingtype}}">
                <input type="hidden" name="trainingprogramid" value="{{$trainingprogramid}}">
                <div class="card-footer mt-4">
                    <button type="submit" class="btn btn-primary btn-sm">Assign</button>
                </div>
        </div>
        </form>
    </div>
</div>
</div>
<script src="{{asset('assets/js/multiselect-dropdown.js')}}"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endsection