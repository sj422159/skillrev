@extends('faculty/layout')
@section('title','Corrected')
@section('Dashboard_select','active')
@section('container')
<div class="row">
    <div class="col-6">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title" style="color:#fff !important;">Evaluated File</h3>
            </div>
             <form action="{{url('faculty/assignment/corrected/answer/save')}}" method="post"  enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="form-row">
                       <div class="col-12 col-sm-4">
                       <label for="GenderId" class="form-control-label">Question :</label>&nbsp &nbsp &nbsp<br>
                       <a href="{{url('assignmentcontent/question')}}/{{$data[0]->questioncontent}}"target="_blank">View</a> 
                       </div>
                        <div class="col-12 col-sm-4">
                            <label for="GenderId" class="form-control-label">Answer :</label>&nbsp &nbsp &nbsp<br>
                        <a href="{{url('assignmentcontent/answer')}}/{{$data[0]->answercontent}}" target="_blank">View</a>
                        </div>
                        <div class="col-12 col-sm-4">
                            <label for="GenderId" class="form-control-label">Evaluated  :</label>&nbsp &nbsp &nbsp<br>
                        <a href="{{url('assignmentcontent/correctanswer')}}/{{$data[0]->correctanswercontent}}" target="_blank">View</a>
                        </div>
                              
                    </div>


                                    <div class="form-row mt-4">

                <div class="col-6 col-sm-4 mt-4 mt-sm-0" id="type">
                @if($data[0]->attempt==3)
                <label for="domain">Reassign</label>
                <select id="at" name="reassign" type="text" class="form-control" aria-required="true" aria-invalid="false" onchange="edu(this)" required="true" disabled>
                <option value="">Select</option>
                <option value="1">Yes</option>
                <option value="2" selected>No</option>
                </select>
                @else
                <label for="domain">Reassign</label>
                <select id="at" name="reassign" type="text" class="form-control" aria-required="true" aria-invalid="false" onchange="edu(this)" required="true">
                <option value="">Select</option>
                <option value="1">Yes</option>
                <option value="2">No</option>
                </select>
                @endif
                </div>
                
                <div class="col-6 col-sm-4 mt-4 mt-sm-0" id="class" style="display:none">
                <label for="GenderId" class="form-control-label">Remarks</label>
                <select id="subbranch" name="remarks" type="text" class="form-control" aria-required="true" aria-invalid="false">
                <option value="Outstanding">Outstanding</option>
                <option value="Excellent">Excellent</option>
                <option value="Very Good">Very Good</option>
                <option value="Good">Good</option>
                <option value="Average">Average</option>
                </select>        
                </div>

               
                </div>
                    
                    
                </div>
                <input type="hidden" name="id" value="{{$data[0]->id}}">
                <div class="card-footer">
                    <a href="{{url('faculty/assignment/corrected')}}">
                    <button type="submit" class="btn btn-danger btn-sm">Back</button>
                    </a>
                    <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                </div>
        </form>
        </div>
    </div>
</div>
</div>
<script type="text/javascript">
    function edu(that){
        if(that.value==2){
        document.getElementById('class').style.display="block";
        }else{
        document.getElementById('class').style.display="none"; 
        }
    }
</script>
@endsection