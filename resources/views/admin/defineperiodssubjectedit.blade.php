@extends('admin/layout')
@section('title','Add Subjects')
@section('Dashboard_select','active')
@section('container')
<script src="//code.jquery.com/jquery-1.12.4.min.js"></script>
<script src="//rawgithub.com/indrimuska/jquery-editable-select/master/dist/jquery-editable-select.min.js"></script>
<link href="//rawgithub.com/indrimuska/jquery-editable-select/master/dist/jquery-editable-select.min.css" rel="stylesheet">


<div class="content">
<div class="col-12 col-lg-13 m-auto" style="margin-top: 30px !important;">
            <form class="multisteps-form__form" action="{{url('admin/periods/subject/savesubject')}}" method="post" enctype="multipart/form-data">
              @csrf 
              <!--single form panel-->
              <div class="multisteps-form__panel shadow p-4 rounded bg-white js-active" data-animation="FadeIn">
                <div class="multisteps-form__content">
                
                <div class="form-row">
                    <div class="col-12 col-sm-2 mt-4 mt-sm-0">
                        <label for="role">Type :</label>
                        <select id="group" required="true" type="text" class="form-control" name="sclasstypeid">
                          <option value="">Select</option>
                          @foreach($classtypes as $list)
                          @if($sclasstypeid==$list->id){
                          <option selected value="{{$list->id}}">{{$list->classtype}}</option>
                          }@else{
                          <option  value="{{$list->id}}">{{$list->classtype}}</option>
                          }
                          @endif
                          @endforeach
                       </select>
                    </div>
                    <div class="col-12 col-sm-2 mt-4 mt-sm-0">
                        <label for="role">Class :</label>
                        <select id="mainbranch" required="true" type="text" class="form-control" name="sclassid">
                          <option value="">Select</option>
                          @foreach($class as $list)
                          @if($sclassid==$list->id){
                          <option selected value="{{$list->id}}">{{$list->categories}}</option>
                          }@else{
                          <option  value="{{$list->id}}">{{$list->categories}}</option>
                          }
                          @endif
                          @endforeach
                       </select>
                    </div>
                    <div class="col-12 col-sm-2 mt-4 mt-sm-0">
                        <label for="role">Subject :</label>
                        <select id="subbranch" required="true" type="text" data-val="{{$ssubjectid}}" class="form-control" name="ssubjectid">
                       </select>
                    </div>
                    <div class="col-12 col-sm-3 mt-4 mt-sm-0" id="a">
                        <label for="role">Monday :</label>
                        <select id="group" required="true" type="text" class="form-control" name="smon">
                          <option value="">Select</option>
                          @foreach($subjectavailabilitytypes as $list)
                          @if($smon==$list->id){
                          <option selected value="{{$list->id}}">{{$list->availabilitytype}}</option>
                          }@else{
                          <option  value="{{$list->id}}">{{$list->availabilitytype}}</option>
                          }
                          @endif
                          @endforeach
                       </select>
                    </div>
                    <div class="col-12 col-sm-3 mt-4 mt-sm-0">
                        <label for="role">Tuesday :</label>
                        <select id="group" required="true" type="text" class="form-control" name="stues">
                          <option value="">Select</option>
                          @foreach($subjectavailabilitytypes as $list)
                          @if($stues==$list->id){
                          <option selected value="{{$list->id}}">{{$list->availabilitytype}}</option>
                          }@else{
                          <option  value="{{$list->id}}">{{$list->availabilitytype}}</option>
                          }
                          @endif
                          @endforeach
                       </select>
                    </div>
                </div>


                <div class="form-row mt-4">
                    <div class="col-12 col-sm-3 mt-4 mt-sm-0">
                        <label for="role">Wedesday :</label>
                        <select id="group" required="true" type="text" class="form-control" name="swednes">
                          <option value="">Select</option>
                          @foreach($subjectavailabilitytypes as $list)
                          @if($swednes==$list->id){
                          <option selected value="{{$list->id}}">{{$list->availabilitytype}}</option>
                          }@else{
                          <option  value="{{$list->id}}">{{$list->availabilitytype}}</option>
                          }
                          @endif
                          @endforeach
                       </select>
                    </div>
                    <div class="col-12 col-sm-3 mt-4 mt-sm-0" id="a">
                        <label for="role">Thursday :</label>
                        <select id="group" required="true" type="text" class="form-control" name="sthurs">
                          <option value="">Select</option>
                          @foreach($subjectavailabilitytypes as $list)
                          @if($sthurs==$list->id){
                          <option selected value="{{$list->id}}">{{$list->availabilitytype}}</option>
                          }@else{
                          <option  value="{{$list->id}}">{{$list->availabilitytype}}</option>
                          }
                          @endif
                          @endforeach
                       </select>
                    </div>
                    <div class="col-12 col-sm-3 mt-4 mt-sm-0">
                        <label for="role">Friday :</label>
                        <select id="group" required="true" type="text" class="form-control" name="sfri">
                          <option value="">Select</option>
                          @foreach($subjectavailabilitytypes as $list)
                          @if($sfri==$list->id){
                          <option selected value="{{$list->id}}">{{$list->availabilitytype}}</option>
                          }@else{
                          <option  value="{{$list->id}}">{{$list->availabilitytype}}</option>
                          }
                          @endif
                          @endforeach
                       </select>
                    </div>
                    <div class="col-12 col-sm-3 mt-4 mt-sm-0">
                        <label for="role">Saturday :</label>
                        <select id="group" required="true" type="text" class="form-control" name="ssatur">
                          <option value="">Select</option>
                          @foreach($subjectavailabilitytypes as $list)
                          @if($ssatur==$list->id){
                          <option selected value="{{$list->id}}">{{$list->availabilitytype}}</option>
                          }@else{
                          <option  value="{{$list->id}}">{{$list->availabilitytype}}</option>
                          }
                          @endif
                          @endforeach
                       </select>
                    </div>
                </div>

                <input type="hidden" name="id" value="{{$id}}">

                  
                  <div class="button-row d-flex mt-4">
                    <input type="submit" class="btn-sm btn btn-success" value="Save"></input>
                    <a href="{{url('admin/periods/subject')}}"><button type="button" class="btn-sm btn btn-danger" style="margin-left:10px !important;">Back</button></a>
                  </div>
                </div>
              </div>
              </form>
            </div> 


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script type="text/javascript">
        $(document).ready(function(){
                   var state = $('#mainbranch').val();
                   var subbranch=$('#subbranch').attr('data-val');
           $('#subbranch').html('');
            $.ajax({
              url:'{{url("admin/periods/subject/getsubject/{id}")}}',
              type:'GET',
              data:{myID:state},
              dataType: "json",
              success:function(data)
              {
                
                $.each(data, function(key,jobskills)
                 {   
                   if(subbranch==jobskills.id){
                       $('#subbranch').prop('disabled', false).append('<option value="'+jobskills.id+' " selected>'+jobskills.domain+'</option>');
                   }else{
                        $('#subbranch').prop('disabled', false).append('<option value="'+jobskills.id+'">'+jobskills.domain+'</option>');
                   }
                });
              
              }
          });
          });

         
        $(document).ready(function(){
        $('#mainbranch').change(function(){
           var state = $('#mainbranch').val();
           var subbranch=$('#subbranch').attr('data-val');
           $('#subbranch').html('');
            $.ajax({
              url:'{{url("admin/periods/subject/getsubject/{id}")}}',
              type:'GET',
              data:{myID:state},
              dataType: "json",
              success:function(data)
              {
                $('#subbranch').prop('disabled', false).append('<option value="">Select</option>'); 
                $.each(data, function(key,jobskills)
                 {     
                  $('#subbranch').prop('disabled', false).append('<option value="'+jobskills.id+'">'+jobskills.domain+'</option>');
                });
              }
          }); 
        });
      });
       
    </script>               
 @endsection                 