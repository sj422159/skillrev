@extends('student/layout')
@section('title','Assign')
@section('Dashboard_select','active')
@section('container')
<div class="row">
    <div class="col-6">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title" style="color:#fff !important;">Submit File</h3>
            </div>
            <form action="{{url('student/assignment/assigned/answer/save')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="GenderId" class="form-control-label">Question :</label>&nbsp &nbsp &nbsp
                        <a href="{{url('assignmentcontent/question')}}/{{$data[0]->questioncontent}}" target="_blank">View</a>       
                    </div>
                    <div class="form-group">
                        <label for="jobskill">Upload File</label>
                        <input type="file" class="form-control" name="file" accept="application/*" required="true">
                    </div>
                </div>
                <input type="hidden" name="id" value="{{$data[0]->id}}">
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                </div>
        </div>
        </form>
    </div>
</div>
</div>
@endsection