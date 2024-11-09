@extends('student/layout')
@section('title','Add Details')
@section('Dashboard_select','active')
@section('container')
<script src="//code.jquery.com/jquery-1.12.4.min.js"></script>
<script src="//rawgithub.com/indrimuska/jquery-editable-select/master/dist/jquery-editable-select.min.js"></script>
<link href="//rawgithub.com/indrimuska/jquery-editable-select/master/dist/jquery-editable-select.min.css" rel="stylesheet">


<div class="content">
<div class="col-12 col-lg-13 m-auto" style="margin-top: 30px !important;">
            <form class="multisteps-form__form" action="{{url('student/adddetails/processing')}}" method="post" enctype="multipart/form-data">
              @csrf 
              <!--single form panel-->
              <div class="multisteps-form__panel shadow p-4 rounded bg-white js-active" data-animation="FadeIn">
                <h3 class="multisteps-form__title">Enter Details</h3>
                <div class="multisteps-form__content">

                  <div class="form-row mt-4">

                    <div class="col-12 col-sm-3 mt-4 mt-sm-0">
                     <label for="GenderId" class="form-control-label">First Name :</label>
                       <input type="text" id="username" name="name" placeholder="First Name" value="{{$name}}" class="multisteps-form__input form-control" required="true">
                    </div>

                    <div class="col-12 col-sm-3 mt-4 mt-sm-0">
                      <label for="GenderId" class="form-control-label">Last Name :</label>
                      <input type="text" id="username" name="lname" placeholder="Last Name" value="{{$lname}}" class="multisteps-form__input form-control" required="true">
                    </div>

                   


                    <?php $date= date('Y-m-d', strtotime('-15 year')); ?>
                    <div class="col-12 col-sm-3 mt-4 mt-sm-0">
                      <label for="GenderId" class="form-control-label"> Dob :</label>
                      <input type="date" class="multisteps-form__input form-control m-input date-picker" placeholder="Date Of Birth" value="{{$dob}}" max={{$date}} required="true" data-val-required="please Select Dob" name="dob" id="DateOfBirthValue">
                    </div>

                    <div class="col-12 col-sm-3 mt-4 mt-sm-0">
                      <label for="GenderId" class="form-control-label"> Gender :</label>
                      <select class="multisteps-form__select form-control" name="gender" id="Gender" required="true">
                         <option value="">Select</option>
                        @foreach($genders as $list)
                         @if($gender==$list->gender)
                          {
                            <option selected value="{{$list->gender}}">{{$list->gender}}</option>
                           }
                             @else
                             {
                               <option  value="{{$list->gender}}">{{$list->gender}}</option>
                             }
                             @endif
                  @endforeach
                      </select>
                    </div>

                  

                  </div>


                  <div class="form-row mt-4">

                        <div class="col-12 col-sm-3 mt-4 mt-sm-0">
                      <label for="GenderId" class="form-control-label">Fathers Name :</label>
                      <input type="text" id="username" name="sfathername" placeholder="Fathers Name" value="{{$sfathername}}" class="multisteps-form__input form-control" required="true">
                    </div>

                    <div class="col-12 col-sm-3 mt-4 mt-sm-0">
                      <label for="GenderId" class="form-control-label">Email Address :</label>
                      <input type="text" class="multisteps-form__input form-control m-input" placeholder="Email Address" required="true"  name="email" value="{{$email}}" id="EmailforId" data-val="true" data-val-email="The EmailAddress field is not a valid e-mail address." data-val-length="The field EmailAddress must be a string with a maximum length of 256." data-val-length-max="256" data-val-required="Please enter email-id" maxlength="256">
                    </div>

                     <div class="col-12 col-sm-3 mt-4 mt-sm-0">
                      <label for="GenderId" class="form-control-label">Mobile Number :</label>
                      <input type="text" class="multisteps-form__input form-control m-input" placeholder="Mobile Number" name="number" id="PhoneId" value="{{$number}}" data-val-regex-pattern="^[6-9][0-9]{9}$" data-val-regex="Please enter a valid Mobile no" required="true" data-val-required="please enter phone number" data-val="true" data-val-length="The field PhoneNumber must be a string with a maximum length of 24." data-val-length-max="24" maxlength="24">
                   </div>
                   <div class="col-12 col-sm-3">
                      <label for="GenderId" class="form-control-label">Registration Number :</label>
                      <input type="text" class="multisteps-form__input form-control m-input" placeholder="Enter" value="{{$sregistrationnumber}}"  id="Address2Id"  name="registrationnumber" data-val-regex-pattern="^.{5}.*$" data-val-regex="Please enter a valid Address" data-val-required="please enter address2" required="true">
                  </div>
                 </div>


                   
                 <div class="form-row mt-4">
                    <div class="col-6 col-sm-3 mt-4 mt-sm-0">
                      <label for="GenderId" class="form-control-label">Class :</label>
                      <select class="multisteps-form__select form-control" name="class" id="mainbranch1" required="true" readonly>
                      @foreach($class as $list)
                      @if($classid==$list->id){
                      <option selected value="{{$list->id}}">{{$list->categories}}</option>
                      }@endif
                      @endforeach
                      </select>
                    </div> 
                      <div class="col-6 col-sm-3 mt-4 mt-sm-0">
                      <label for="GenderId" class="form-control-label">Section :</label>
                      <select class="multisteps-form__select form-control" name="section" id="mainbranch2" required="true" readonly>
                      @foreach($sections as $list)
                      @if($sectionid==$list->id){
                      <option selected value="{{$list->id}}">{{$list->section}}</option>
                      }@endif
                      @endforeach
                      </select>
                    </div>

         <div class="col-6 col-sm-3 mt-4 mt-sm-0">
                      <label for="GenderId" class="form-control-label"> State :</label>
                      <select class="multisteps-form__select form-control" name="state" id="mainbranch" required="true">
                      <option value="">Select</option>
                      @foreach($states as $list)
                      @if($state==$list->id){
                      <option selected value="{{$list->id}}">{{$list->name}}</option>
                      }@else{
                      <option  value="{{$list->id}}">{{$list->name}}</option>
                      }@endif
                      @endforeach
                      </select>
                    </div>
                    <div class="col-6 col-sm-3 mt-4 mt-sm-0">
                      <label for="GenderId" class="form-control-label">Nearest City :</label>
                        <select id="subbranch" name="city" type="text" class="form-control" aria-required="true" aria-invalid="false" required="true" data-val="{{$city}}">
                    <option value="">Select City</option>
                    </select>       
                    </div>
                  </div>

                    <div class="form-row mt-4">
                    <div class="col-12 col-sm-3">
                      <label for="GenderId" class="form-control-label"> Address 1 :</label>
                      <input type="text" class="multisteps-form__input form-control m-input" placeholder="Address 1" value="{{$address1}}" id="Address1Id"  name="address1" data-val-regex-pattern="^.{5}.*$" data-val-regex="Please enter a valid Address" required="true" data-val-required="please enter address1" required="true">
                    </div>
                  
                     <div class="col-12 col-sm-3">
                      <label for="GenderId" class="form-control-label"> Address 2 :</label>
                      <input type="text" class="multisteps-form__input form-control m-input" placeholder="Address 2" value="{{$address2}}"  id="Address2Id"  name="address2" data-val-regex-pattern="^.{5}.*$" data-val-regex="Please enter a valid Address" data-val-required="please enter address2" required="true">
                  </div>

                  <div class="col-12 col-sm-3">
                        <label for="jobrole">Avail Transport Service ?</label>
                        <select class="form-control" name="transportservice" id="category" onchange="check(this)">
                            <option value="">Select</option>
                            @if($stransportservice=="Yes")
                    <option selected value="Yes">Yes</option>
                    <option value="No">No</option>
                    @elseif($stransportservice=="No")
                    <option value="Yes">Yes</option>
                    <option selected value="No">No</option>
                    @else
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                    @endif
                        </select>
                    </div>

                  <div class="col-12 col-sm-3 mt-4 mt-sm-0" id="dist" style="display:none;">
                      <label for="GenderId" class="form-control-label"> Pick / Drop Location :</label>
                      <select class="multisteps-form__select form-control" name="distance"  id="dist1">
                      <option value="">Select</option>
                      @foreach($distances as $list)
                        @if($sdistance==0)
                        @if($sdistance==$list->id)
                          <option selected value="{{$list->id}}">{{$list->location}}</option> 
                        @else   
                          <option  value="{{$list->id}}">{{$list->location}}</option>
                        @endif
                        @else
                        @if($sdistance==$list->id)
                          <option selected value="{{$list->id}}">{{$list->location}}</option> 
                        @endif
                        @endif
                      @endforeach
                      </select>
                    </div>

                </div>
                <div class="form-row mt-4">
                  
                  <div class="col-12 col-sm-3">
                        <label for="jobrole">Avail Hostel Service ?</label>
                        <select class="form-control" name="hostelservice" required="true">
                            <option value="">Select</option>
                            @if($shostelservice=="Yes")
                    <option selected value="Yes">Yes</option>
                    <option value="No">No</option>
                    @elseif($shostelservice=="No")
                    <option value="Yes">Yes</option>
                    <option selected value="No">No</option>
                    @else
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                    @endif
                        </select>
                    </div>
                    <div class="col-12 col-sm-3 mt-4 mt-sm-0">
                      <label for="GenderId" class="form-control-label">Aadhar Number :</label>
                      <input type="text" class="multisteps-form__input form-control m-input" placeholder="Aadhar Number" name="aadharnumber" value="{{$aadharnumber}}"required="true" minlength="12" maxlength="12">
                   </div>
                </div>
                  <div class="form-row mt-4">
                        @php
                        $c=0;
                        @endphp
                         @foreach($optsubs as $list)
                          <div class="col-6 col-sm-3 mt-4 mt-sm-0">
                      <label for="GenderId" class="form-control-label">{{$list->dname}} :</label>
                      <select class="form-control" name="optional[]" id="mainbranch"  required="true">
                      <option value="">Select</option>
                      @foreach($module[$c] as $li)
                      @if(count($optsubs)>=($c+1))
                       @if($optmod[$c]==$li->id)
                        <option value="{{$li->id}}**{{$list->id}}" selected>{{$li->skillset}}</option>
                       @else
                        <option value="{{$li->id}}**{{$list->id}}">{{$li->skillset}}</option>
                        @endif
                      @else
                        <option value="{{$li->id}}**{{$list->id}}">{{$li->skillset}}</option>
                      @endif
                      @endforeach
                      </select>
                    </div>
                      @php
                        $c++;
                      @endphp
                    @endforeach
                    </div>
                        <div class="form-row mt-4">


                         <div class="col-12 col-sm-3 mt-4 mt-sm-0">
        <label for="image" class="control-label">Image</label>
        <input id="image" name="image" type="file" class="form-control">
        @if($id>0)
         <img src="{{asset('studentimages')}}/{{$image}}" width="130px" height="80px" alt="Gallery Image">
         @endif
        </div>
                  </div>

                  <input type="hidden" name="id" value='{{$id}}'>
                  <div class="button-row d-flex mt-4">
                    <input type="submit" class="btn btn-success" value="Save"></input>
                    <a href="{{url('student/dashboard')}}"><button type="button" class="btn btn-danger" style="margin-left:10px !important;">Back</button></a>
                  </div>
                </div>
              </div>
              </form>
            </div> 


<script>
  $('#State').editableSelect({
    effects: 'slide'
  });

  $('#Sector').editableSelect({
    effects: 'slide'
  });

  $('#Jobrole').editableSelect({
    effects: 'slide'
  });
</script> 

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
                   var state = $('#mainbranch').val();
                   var attr=$('#subbranch').attr('data-val');
           $('#subbranch').html('');
            $.ajax({
              url:'{{url("student/state/{id}")}}',
              type:'GET',
              data:{myID:state},
              dataType: "json",
              success:function(data)
              {
                
                $.each(data, function(key,subranches)
                 {   
                //  alert(subbranch.id);
                   if(attr==subranches.id){
                       $('#subbranch').prop('disabled', false).css('background','aliceblue').append('<option value="'+subranches.id+' " selected>'+subranches.name+'</option>');
                   }else{
                        $('#subbranch').prop('disabled', false).css('background','aliceblue').append('<option value="'+subranches.id+'">'+subranches.name+'</option>');
                   }
                });
              }
          });
          });

       $(document).ready(function(){
        $('#mainbranch').change(function(){
           var state = $('#mainbranch').val();
           $('#subbranch').html('');
            $.ajax({
              url:'{{url("student/state/{id}")}}',
              type:'GET',
              data:{myID:state},
              dataType: "json",
              success:function(data)
              {
                
                $.each(data, function(key,subranches)
                 {     
                  $('#subbranch').prop('disabled', false).css('background','aliceblue').append('<option value="'+subranches.id+'">'+subranches.name+'</option>');
                });
              }
          });
        });
      });
    </script>

<script type="text/javascript">
  function check(that){
        var val=that.value;
        if(val=="Yes"){
            document.getElementById('dist').style="display:block";
          
        }else{
          document.getElementById('dist').style="display:none";  
          
        }
    }

  $(document).ready(function(){
        var val=$('#category').val();
        if(val=="Yes"){
            document.getElementById('dist').style="display:block";  
        }else{
          document.getElementById('dist').style="display:none";  
        }
  });
</script>               
@endsection                 