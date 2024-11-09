@extends('faculty/layout')
@section('title','Submit')
@section('Dashboard_select','active')
@section('container')
<div class="row">
    <div class="col-6">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title" style="color:#fff !important;">Submit File</h3>
            </div>
            <form action="{{url('faculty/assignment/submitted/answer/save')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="form-row">
                        <div class="col-12 col-sm-6">
                        <label for="GenderId" class="form-control-label">Question :</label>&nbsp &nbsp &nbsp
                        <a href="{{url('assignmentcontent/question')}}/{{$data[0]->questioncontent}}"target="_blank">View</a> 
                        </div>
                        <div class="col-12 col-sm-6">
                            <label for="GenderId" class="form-control-label">Answer :</label>&nbsp &nbsp &nbsp
                        <a href="{{url('assignmentcontent/answer')}}/{{$data[0]->answercontent}}" target="_blank">View</a>
                        </div>
                              
                    </div>
                    
                    <div class="form-group mt-4">
                        <label for="jobskill">Upload File :</label>
                        <input type="file" class="form-control" name="file" accept="application/*" required="true">
                    </div>

                    <div class="form-row mt-4">
                    <div class="col-12 col-sm-12">
                        <h6>Note : <a href="https://www.docfly.com/"target="_blank"> Please click this text for evaluating the answers !!</a></h6>
                    </div> 
                    
                </div>
                <input type="hidden" name="id" value="{{$data[0]->id}}">
                <div class="card-footer mt-4">
                    <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                </div>
        </div>
        </form>
    </div>
</div>
</div>
@endsection