@extends('student/layout')
@section('title','Corrected')
@section('Dashboard_select','active')
@section('container')
<div class="row">
    <div class="col-6">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title" style="color:#fff !important;">Evaluated File</h3>
            </div>
                <div class="card-body">
                    <div class="form-row">
                       <div class="col-12 col-sm-6">
                       <label for="GenderId" class="form-control-label">Question :</label>&nbsp &nbsp &nbsp
                       <a href="{{url('assignmentcontent/question')}}/{{$data[0]->questioncontent}}"target="_blank">View</a> 
                       </div>
                        <div class="col-12 col-sm-6">
                            <label for="GenderId" class="form-control-label">Your Answer :</label>&nbsp &nbsp &nbsp
                        <a href="{{url('assignmentcontent/answer')}}/{{$data[0]->answercontent}}" target="_blank">View</a>
                        </div>
                        </div>
                        <div class="form-row mt-2">
                        <div class="col-12 col-sm-12">
                            <label for="GenderId" class="form-control-label">Evaluated Answer :</label>&nbsp &nbsp &nbsp
                        <a href="{{url('assignmentcontent/correctanswer')}}/{{$data[0]->correctanswercontent}}" target="_blank">View</a>
                        </div>
                              
                    </div>
                    
                    
                </div>
                <div class="card-footer">
                    <a href="{{url('student/assignment/corrected')}}">
                    <button type="submit" class="btn btn-danger btn-sm">Back</button>
                    </a>
                </div>
        </div>
    </div>
</div>
</div>
@endsection