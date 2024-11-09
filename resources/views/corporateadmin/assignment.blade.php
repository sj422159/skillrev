@extends('corporateadmin/layout')
@section('title','Assignment')
@section('home','active')
@section('container')

<form action="{{url('corporateadmin/assignment/schoolwise')}}" method="post">
    @csrf
    <div class="form-row">
        <div class="col-12 col-sm-4 mt-4 mt-sm-0">
            <label>School</label>
            <select class="form-control" aria-required="true" aria-invalid="false" name="school" id="school">
                <option value="">Select</option>
                @foreach($schools as $list)
                 @if($school==$list->id)
                   <option value="{{$list->id}}" selected>{{$list->aname}}</option>
                 @else
                   <option value="{{$list->id}}">{{$list->aname}}</option>
                 @endif
                     
                @endforeach 
            </select>
        </div>
         <div class="col-12 col-sm-4 mt-4 mt-sm-0" style="display:flex !important; align-items: flex-end !important;">
            <button type="submit" class="btn btn-sm btn-success form-control">Get Content</button>
        </div>
    </div>
   </form>
    <div class="form-row mt-4">
        <div class="col-12 col-sm-4 mt-4 mt-sm-0">
            <label>Standard</label>
            <select class="form-control" aria-required="true" aria-invalid="false" name="category" id="category">
                <option value="">Select</option>
                 @foreach($category as $list)
                     <option value="{{$list->id}}">{{$list->categories}}</option>
                @endforeach 
            </select>
        </div>
         <div class="col-12 col-sm-4 mt-4 mt-sm-0">
            <label>Section</label>
            <select class="form-control" id="domain" aria-required="true"aria-invalid="false"name="domain">
                <option value="">Select</option>
            </select>
        </div>
        <div class="col-12 col-sm-4 mt-4 mt-sm-0">
            <label>Training</label>
            <select class="form-control" required="true" name="skillset" id="skillset" onchange="getcontent(this)">
                <option selected="selected" value="">Select</option>
            </select>
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
                        <th>Student</th>
                        <th>Training Type</th>
                        <th>Training Name</th>
                        <th>Question</th>
                        <th>Answer</th>
                        <th>Evaluated Answer</th>
                       
                    </tr>
                </thead>
                <tbody id="contable">
                   
                </tbody>
            </table>
        </div>
    </div>
</div>





<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>

var school=<?php echo $school;?>

jQuery(document).ready(function(){

           jQuery('#category').change(function (){
             let cid=jQuery(this).val();
             jQuery.ajax({
              url:'{{url("corporateadmin/assignment/getsection")}}',
              type:'get',
              data:'cid='+cid+'&aid='+school+
              '&_token={{csrf_token()}}',
              success:function(result){
                jQuery('#domain').html(result)
              }
             });

             jQuery.ajax({
              url:'{{url("corporateadmin/assignment/gettraining")}}',
              type:'get',
              data:'sid='+cid+'&aid='+school+
              '&_token={{csrf_token()}}',
              success:function(result){
                jQuery('#skillset').html(result)
              }
             });
           });

           
            
           


});

function getcontent(that){
     var clas=document.getElementById('category').value;
     var sec=document.getElementById('domain').value;
     var train=that.value;
	
	 $.ajax({
              url:'{{url("corporateadmin/assignment/data/get")}}',
              type:'GET',
              data:{train:train,sec:sec,clas:clas},
              dataType: "json",
              success:function(data)
              {
                
                $.each(data, function(key,data)
                 {   
                  
                        $('#contable').prop('disabled', false).append('<tr><td>'+data.sname+'</td><td>'+data.type+'</td><td>'+data.trainingname+'</td><td><a href="{{url('/assignmentcontent/question')}}/'+data.questioncontent+'" class="btn btn-sm btn-primary" target="_blank">View</a></td><td><a href="{{url('/assignmentcontent/question')}}/'+data.answercontent+'" class="btn btn-sm btn-primary" target="_blank">View</a></td><td><a href="{{url('/assignmentcontent/question')}}/'+data.correctanswercontent+'" class="btn btn-sm btn-primary" target="_blank">View</a></td></tr>');
                  
                });
              
              }
          });
        
}
</script>



@endsection